<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Equipment; 
use APP\Models\Loan;
use App\Models\User;
use App\Traits\ActivityLogger;


class EquipmentController extends Controller
{

use ActivityLogger;

    public function index()
    {
        $equipment = Equipment::all();
        return view('equipment.index', compact('equipment'));
    }


    public function create()
    {
        $equipment = Equipment::all();
        return view('equipment.create', compact('equipment'));
    }

    public function store(Request $request)
    {

    // dd($request->all());


        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'item_type' => 'nullable|string|max:255',
            'asset_no' => 'nullable|string|max:255',
            'serial_no' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'current_location' => 'nullable|string|max:255',
            'status' => 'required|string|in:Available,Not Available',
            'description' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);
    

    // Assign user_id & default status
    if ($validated['status'] === 'Available') {
            $validated['user_id'] = null;
        }

        try {
            $equipment = Equipment::create($validated);

            $this->logActivity(
                'create',
                "Created equipment: {$equipment->name}",
                $equipment
            );

            return redirect()
                ->route('equipment.index')
                ->with('success', 'Equipment created successfully!');

        } catch (\Exception $e) {
            \Log::error('Equipment creation failed:', ['error' => $e->getMessage()]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create equipment: ' . $e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'item_type' => 'nullable|string|max:255',
            'asset_no' => 'nullable|string|max:255',
            'serial_no' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'current_location' => 'nullable|string|max:255',
            'status' => 'required|string|in:Available,Not Available',
            'description' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        // If status is Available, user_id should be null
        if ($validated['status'] === 'Available') {
            $validated['user_id'] = null;
        }

        try {
            $equipment->update($validated);

            $this->logActivity(
                'update',
                "Updated equipment: {$equipment->name}",
                $equipment
            );

            return redirect()
                ->route('equipment.index')
                ->with('success', 'Equipment updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Equipment update failed:', ['error' => $e->getMessage()]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update equipment: ' . $e->getMessage());
        }
    }

    public function edit($id) 
    {
    $equipment = Equipment::findOrFail($id);

    return view('equipment.edit', compact('equipment'));
    }

    public function destroy($id)
{
        $equipment = Equipment::findOrFail($id);
        
        // Optional: Check if equipment is currently on loan
       
        
        $equipment->delete();
        
        return redirect()->route('equipment.index')->with('success', 'Equipment deleted successfully');
    
        return redirect()->back()->with('error', 'Failed to delete equipment: ' . $e->getMessage());
    
}

    public function formpdf()
    {
        return view ('equipment.form');
    }

    public function getEquipmentList()
{
    $equipment = Equipment::all(); // or whatever your model is
    return response()->json($equipment);
}

}
