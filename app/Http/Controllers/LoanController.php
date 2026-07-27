<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Loan;
use App\Models\User;
use App\Models\Equipment;
use App\Models\Notification;
use App\Models\SignaturePad;
use App\Traits\ActivityLogger;

class LoanController extends Controller
{
    use ActivityLogger;

    /**
     * Show the form for creating a new loan
     */
    public function create()
    {
        // Use 'Available' with capital A to match your database
        $equipment = Equipment::where('status', 'Available')->get();
        
        \Log::info('Available Equipment for Loan:', [
            'count' => $equipment->count(),
            'equipment' => $equipment->pluck('name', 'id')->toArray()
        ]);
        
        return view('loan.create', compact('equipment'));
    }

    /**
     * Display a listing of loans
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search');

        $availableEquipment = Equipment::where('status', 'available')->count();

        $unread = Auth::user()->notifications()->where('is_read', false)->count();
        $query = Loan::with('user', 'equipment');

        if ($user->role === 'admin') {
            if ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }
        } else {
            $query->where('user_id', $user->id);
        }

        $loans = $query->orderBy('created_at', 'desc')->get();

        return view('loan.index', compact('loans', 'unread'));
    }

    /**
     * Store a newly created loan
     */
    public function store(Request $request)
    {
    // dd([
    //     'all_data' => $request->all(),
    //     'only_files' => $request->allFiles(),
    //     'has_sign_borrower' => $request->has('sign_borrower'),
    //     'has_sign_superior' => $request->has('sign_superior'),
    //     'has_sign_ict' => $request->has('sign_ict'),
    // ]);
        // Log incoming request
        \Log::info('=== LOAN CREATION START ===');
        \Log::info('Request Data:', $request->except(['sign_borrower', 'sign_superior', 'sign_ict'])); // Don't log huge base64 strings

        // Debug equipment status before validation
        if ($request->equipment_id) {
            $equipment = Equipment::find($request->equipment_id);
            \Log::info('Equipment Status Before Validation:', [
                'id' => $equipment->id ?? 'not found',
                'status' => $equipment->status ?? 'N/A',
                'name' => $equipment->name ?? 'N/A',
                'user_id' => $equipment->user_id ?? 'N/A'
            ]);
        }

        

        $validated = $request->validate([
            'name'          => 'nullable|string',
            'phone'         => 'nullable|string',
            'department'    => 'nullable|string',
            'email'         => 'nullable|email',
            'purpose'       => 'nullable|string',
            'other_purpose' => 'nullable|string',

            'item_type'     => 'nullable|array',
            'item'          => 'nullable|string',
            'other_equipment' => 'nullable|string',
            'asset_no'      => 'nullable|string',
            'quantity'      => 'nullable|integer|min:1',
            'serial_no'     => 'nullable|string',

            'current_location' => 'nullable|string',
            'asset_serial_number'=> 'nullable|string',
            'model' => 'nullable|string',
            'additional_description'=> 'nullable|string',

            'date_borrow'   => 'nullable|date',
            'date_return'   => 'nullable|date',

            /* ===== NEW FIELDS ===== */
            'condition'     => 'nullable|string|max:255',
            'est_ret_date'  => 'nullable|date',

            'name_borrower' => 'nullable|string|max:255',
            'date_borrower' => 'nullable|date',

            'name_superior' => 'nullable|string|max:255',
            'date_superior' => 'nullable|date',

            'name_ict'      => 'nullable|string|max:255',
            'date_ict'      => 'nullable|date',

            /* ===== SIGNATURES (BASE64 STRINGS) ===== */
            'sign_borrower'  => 'nullable|string',
            'stamp_borrower' => 'nullable|string',
            'sign_superior'  => 'nullable|string',
            'sign_ict'       => 'nullable|string',

            'equipment_id' => [
    'required',
    'exists:equipment,id',
    function ($attribute, $value, $fail) {
        $equipment = Equipment::find($value);
        
        if (!$equipment) {
            $fail('Equipment not found.');
            return;
        }
        
        // Check status
        if (strtolower(trim($equipment->status)) !== 'available') {
            $fail('This equipment is not available for loan. Current status: ' . $equipment->status);
            return;
        }
        
        // Check if there's an UNRETURNED active loan
        $activeLoan = Loan::where('equipment_id', $value)
            ->whereIn('status', ['Pending', 'Approved'])
            ->where(function($query) {
                // Loan is active if:
                // - No return date set yet, OR
                // - Return date is in the future
                $query->whereNull('date_return')
                      ->orWhere('date_return', '>', now());
            })
            ->first();
            
        if ($activeLoan) {
            $fail('This equipment is currently on loan (ID: ' . $activeLoan->id . ')');
        }
    }
],
        ]);

        \Log::info('Validation passed');

        /* ================= AUTO FIELDS ================= */
        $validated['staff_id'] = auth()->user()->staff_id;
        $validated['user_id']  = auth()->id();

        /* ================= ITEM TYPE (CHECKBOX) ================= */
        $validated['item_type'] = is_array($request->item_type)
            ? implode(', ', $request->item_type)
            : $request->item_type;

        /* ================= DEFAULT STATUS ================= */
        $validated['status'] = 'Pending';

        /* ================= HANDLE BASE64 SIGNATURES ================= */
        $signatureFields = ['sign_borrower', 'stamp_borrower', 'sign_superior', 'sign_ict'];
        
        foreach ($signatureFields as $field) {
            if (!empty($request->$field) && str_starts_with($request->$field, 'data:image')) {
                // It's a base64 image
                $validated[$field] = $this->saveBase64Image($request->$field, "signatures/{$field}");
                \Log::info("{$field} saved as file:", [$validated[$field]]);
            }
        }

        \Log::info('Data before transaction (signatures processed)');

        /* ================= CREATE WITH TRANSACTION ================= */
        try {
            $loan = DB::transaction(function () use ($validated) {
                \Log::info('Inside transaction - creating loan');
                
                // Create the loan
                $loan = Loan::create($validated);
                \Log::info('Loan created successfully:', ['id' => $loan->id]);
                
                // Update equipment status to 'Not Available' and assign to user
                $equipmentUpdated = Equipment::where('id', $validated['equipment_id'])
                    ->update([
                        'status' => 'Not Available',
                        'user_id' => $validated['user_id']
                    ]);
                    
                \Log::info('Equipment status updated:', [
                    'equipment_id' => $validated['equipment_id'], 
                    'rows_affected' => $equipmentUpdated
                ]);
                    
                return $loan;
            });

            \Log::info('Transaction completed successfully');

            // Check equipment status after update
            $equipment = Equipment::find($validated['equipment_id']);
            \Log::info('Equipment Status After Update:', [
                'id' => $equipment->id, 
                'status' => $equipment->status,
                'user_id' => $equipment->user_id
            ]);

        } catch (\Exception $e) {
            \Log::error('Transaction failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create loan: ' . $e->getMessage());
        }

        /* ================= NOTIFICATIONS ================= */
        \Log::info('Creating notifications for admins');
        $admins = User::where('role', 'admin')->get();
        \Log::info('Found admins:', ['count' => $admins->count()]);
        
        // Bulk insert notifications for better performance
        $notifications = $admins->map(function ($admin) use ($validated, $loan) {
            return [
                'user_id' => $admin->id,
                'title' => 'New Loan Submitted',
                'message' => 'A new loan has been submitted by ' . auth()->user()->name . ' for equipment: ' . ($validated['item'] ?? 'N/A'),
                'url' => route('loans.index'),
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();
        
        if (!empty($notifications)) {
            Notification::insert($notifications);
            \Log::info('Notifications created');
        }

        /* ================= ACTIVITY LOG ================= */
        $this->logActivity(
            'create',
            "User created loan ID {$loan->id}",
            $loan
        );

        \Log::info('=== LOAN CREATION END ===');

        return redirect()
            ->route('loan.index')
            ->with('success', 'Loan record saved successfully!');
    }

    /**
     * Helper function to save base64 image
     */
    private function saveBase64Image($base64String, $path)
    {
        // Extract the base64 encoded binary data from the string
        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
            $base64String = substr($base64String, strpos($base64String, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            // Decode the base64 string
            $imageData = base64_decode($base64String);

            if ($imageData === false) {
                throw new \Exception('Base64 decode failed');
            }

            // Generate unique filename
            $filename = $path . '_' . Str::uuid() . '.' . $type;

            // Save to storage
            Storage::disk('public')->put($filename, $imageData);

            return $filename;
        }

        throw new \Exception('Invalid base64 image format');
    }

    /**
     * Display the specified loan
     */
    public function show($id)
    {
        $loan = Loan::with('equipment', 'user')->findOrFail($id);
        $user = auth()->user();

        
        $this->logActivity(
            'view',
            "User viewed loan ID {$loan->id}",
            $loan
        );

        return view('loan.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified loan
     */
    public function edit($id)
    {
        $loan = Loan::findOrFail($id);
        $equipment = Equipment::all();
        $user = auth()->user();

        // Check permission
        if ($user->role !== 'admin' && $loan->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        return view('loan.edit', compact('loan', 'equipment'));
    }

    /**
     * Update the specified loan
     */
    public function update(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);
        
        \Log::info('=== LOAN UPDATE START ===', ['loan_id' => $id]);

        $validated = $request->validate([
            'name'          => 'nullable|string',
            'phone'         => 'nullable|string',
            'department'    => 'nullable|string',
            'email'         => 'nullable|email',
            'purpose'       => 'nullable|string',
            'other_purpose' => 'nullable|string',

            'item_type'     => 'nullable|array',
            'item'          => 'nullable|string',
            'other_equipment' => 'nullable|string',
            'asset_no'      => 'nullable|string',
            'quantity'      => 'nullable|integer|min:1',
            'serial_no'     => 'nullable|string',

            'current_location' => 'nullable|string',
            'asset_serial_number'=> 'nullable|string',
            'model' => 'nullable|string',
            'additional_description'=> 'nullable|string',

            'date_borrow'   => 'nullable|date',
            'date_return'   => 'nullable|date',
            'est_ret_date'  => 'nullable|date',
            
            'condition'     => 'nullable|string|max:255',
            'name_borrower' => 'nullable|string|max:255',
            'date_borrower' => 'nullable|date',

            'name_superior' => 'nullable|string|max:255',
            'date_superior' => 'nullable|date',

            'name_ict'      => 'nullable|string|max:255',
            'date_ict'      => 'nullable|date',

            'sign_borrower'   => 'nullable|string',
            'stamp_borrower'  => 'nullable|string',
            'sign_superior'   => 'nullable|string',
            'sign_ict'        => 'nullable|string',
            
            'equipment_id' => [
                'nullable',
                'exists:equipment,id',
                function ($attribute, $value, $fail) use ($loan) {
                    // Skip validation if equipment hasn't changed
                    if ($value == $loan->equipment_id) {
                        return;
                    }
                    
                    $equipment = Equipment::find($value);
                    
                    if (!$equipment) {
                        $fail('Equipment not found.');
                        return;
                    }
                    
                    if (strtolower(trim($equipment->status)) !== 'available') {
                        $fail('This equipment is not available for loan. Current status: ' . $equipment->status);
                        return;
                    }
                    
                    // Check if there's already an active loan for this equipment
                    $activeLoan = Loan::where('equipment_id', $value)
                        ->where('id', '!=', $loan->id) // Exclude current loan
                        ->whereIn('status', ['Pending', 'Approved'])
                        ->exists();
                        
                    if ($activeLoan) {
                        $fail('This equipment already has an active loan.');
                    }
                }
            ],
        ]);

        /* ================= ITEM TYPE (CHECKBOX) ================= */
        if ($request->has('item_type')) {
            $validated['item_type'] = is_array($request->item_type)
                ? implode(', ', $request->item_type)
                : $request->item_type;
        }

        /* ================= HANDLE BASE64 SIGNATURES ================= */
        $signatureFields = ['sign_borrower', 'stamp_borrower', 'sign_superior', 'sign_ict'];
        
        foreach ($signatureFields as $field) {
            if (!empty($request->$field) && str_starts_with($request->$field, 'data:image')) {
                // It's a new base64 image, save it
                $validated[$field] = $this->saveBase64Image($request->$field, "signatures/{$field}");
                \Log::info("{$field} updated:", [$validated[$field]]);
            }
        }

        /* ================= UPDATE WITH TRANSACTION ================= */
        try {
            DB::transaction(function () use ($loan, $validated, $request) {
                \Log::info('Inside update transaction');
                
                // If equipment changed, update status
                if (isset($validated['equipment_id']) && $validated['equipment_id'] != $loan->equipment_id) {
                    \Log::info('Equipment changed', [
                        'old_equipment_id' => $loan->equipment_id,
                        'new_equipment_id' => $validated['equipment_id']
                    ]);
                    
                    // Set old equipment back to available and remove user assignment
                    Equipment::where('id', $loan->equipment_id)
                        ->update([
                            'status' => 'Available',
                            'user_id' => null
                        ]);
                    \Log::info('Old equipment set to available');
                    
                    // Set new equipment to Not Available and assign to user
                    Equipment::where('id', $validated['equipment_id'])
                        ->update([
                            'status' => 'Not Available',
                            'user_id' => $loan->user_id
                        ]);
                    \Log::info('New equipment set to Not Available');
                }
                
                // Update the loan
                $loan->update($validated);
                \Log::info('Loan updated successfully');
            });

        } catch (\Exception $e) {
            \Log::error('Update transaction failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update loan: ' . $e->getMessage());
        }

        /* ================= ACTIVITY LOG ================= */
        $this->logActivity(
            'update',
            "User updated loan ID {$loan->id}",
            $loan
        );

        \Log::info('=== LOAN UPDATE END ===');

        return redirect()
            ->route('loan.index')
            ->with('success', 'Loan updated successfully!');
    }

    /**
     * Remove the specified loan
     */
    public function destroy($id)
    {
        $loan = Loan::findOrFail($id);
        $user = auth()->user();

        // Check permission
        if ($user->role !== 'admin' && $loan->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        \Log::info('=== LOAN DELETE START ===', ['loan_id' => $id]);

        try {
            DB::transaction(function () use ($loan) {
                // Set equipment back to available and remove user assignment when loan is deleted
                if ($loan->equipment_id) {
                    Equipment::where('id', $loan->equipment_id)
                        ->update([
                            'status' => 'Available',
                            'user_id' => null
                        ]);
                    \Log::info('Equipment set back to available', ['equipment_id' => $loan->equipment_id]);
                }
                
                // Delete the loan
                $loan->delete();
                \Log::info('Loan deleted');
            });

        } catch (\Exception $e) {
            \Log::error('Delete transaction failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->back()
                ->with('error', 'Failed to delete loan: ' . $e->getMessage());
        }

        $this->logActivity(
            'delete',
            "User deleted loan ID {$loan->id}",
            $loan
        );

        \Log::info('=== LOAN DELETE END ===');

        return redirect()
            ->route('loan.index')
            ->with('success', 'Loan deleted successfully.');
    }


    public function updateReturnDate(Request $request, $id)
{
    $loan = Loan::findOrFail($id);

    $request->validate([
        'date_return' => 'required|date|after_or_equal:date_borrow',
    ]);

    $loan->date_return = $request->date_return;

    // Update equipment status
    if ($loan->equipment_id) {
        $equipment = $loan->equipment;
        if ($loan->date_return) {
            // Equipment returned
            $equipment->markAsAvailable();
        } else {
            // Still on loan
            $equipment->markAsNotAvailable($loan->user_id);
        }
    }

    $loan->save();

    return redirect()->back()->with('success', 'Return date updated and equipment status synced!');
}

    /**
     * Return equipment (mark loan as completed)
     */
    public function returnEquipment(Request $request, $id)
{
    $loan = Loan::findOrFail($id);
    $user = auth()->user();

    // Check permission
    if ($user->role !== 'admin' && $loan->user_id !== $user->id) {
        abort(403, 'Unauthorized');
    }

    // Validate the return date if provided
    $validated = $request->validate([
        'date_return' => 'nullable|date'
    ]);

    \Log::info('=== EQUIPMENT RETURN START ===', ['loan_id' => $id]);

    try {
        DB::transaction(function () use ($loan, $validated) {
            // Update loan status
            $loan->update([
                'status' => 'Returned',
                'date_return' => $validated['date_return'] ?? now() // Use provided date or now
            ]);
            
            // Set equipment back to available and remove user assignment
            if ($loan->equipment_id) {
                Equipment::where('id', $loan->equipment_id)
                    ->update([
                        'status' => 'Available',
                        'user_id' => null
                    ]);
                \Log::info('Equipment returned and set to available', ['equipment_id' => $loan->equipment_id]);
            }
        });

    } catch (\Exception $e) {
        \Log::error('Return transaction failed:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()
            ->back()
            ->with('error', 'Failed to return equipment: ' . $e->getMessage());
    }

    $this->logActivity(
        'return',
        "User returned equipment for loan ID {$loan->id}",
        $loan
    );

    \Log::info('=== EQUIPMENT RETURN END ===');

    return redirect()
        ->route('loan.index')
        ->with('success', 'Equipment returned successfully!');
}

    public function updateStatus(Request $request, $id)
{
    $loan = Loan::findOrFail($id);

    $request->validate([
        'status' => 'required|in:Pending,Approved,Rejected',
    ]);

    $loan->status = $request->status;
    $loan->save();

    // Optional: update equipment status if Approved
    if ($loan->equipment_id) {
        $equipment = $loan->equipment;
        if ($loan->status === 'Approved' && !$loan->date_return) {
            $equipment->markAsNotAvailable($loan->user_id);
        } elseif ($loan->status !== 'Approved') {
            $equipment->markAsAvailable();
        }
    }

    return redirect()->back()->with('success', 'Loan status updated!');
}
}