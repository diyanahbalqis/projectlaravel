<?php

namespace App\Http\Controllers;
   
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\User;
use App\Models\Equipment;
use App\Models\ActivityLog;
use App\Traits\ActivityLogger;

use PDF;
    
class PDFController extends Controller
{

    use ActivityLogger;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        // pastikan hanya admin boleh tengok page ni
        if ($user->role !== 'admin') {
        abort(403, 'Unauthorized Access');
        }
    }


    public function showReport()
{

    $users = User::all();
    $loans = Loan::all();

    $user = auth()->user();

    // pastikan hanya admin boleh tengok page ni
    if ($user->role !== 'admin') {
        abort(403, 'Unauthorized Access');
    }
    
    return view('loan.reportloan', [
        'title' => 'Loan Report',
        'date'  => date('m/d/Y'),
        'loan'  => $loans
    ]);
}

    public function generatePDF()
{
    $users = User::all();
    

    $loans = Loan::all();
    $data = [
        'title' => 'Loan Report',
        'date'  => now()->format('d/m/Y'),
        'loan'  => $loans,
        'users' => $users
    ];

     

    $pdf = PDF::loadView('pdf.loanreport', $data);
    return $pdf->stream('loan-report.pdf');
}

public function userReport()
{
    $users = User::get();

     $user = auth()->user();

    // pastikan hanya admin boleh tengok page ni
    if ($user->role !== 'admin') {
        abort(403, 'Unauthorized Access');
    }

    
    return view('user.reportuser', [
        'title' => 'User Report',
        'date'  => date('m/d/Y'),
        'user'  => $users
    ]);
}

    public function generatePDFuser()
{
        $users = User::get();
    
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y'),
            'users' => $users
        ];

    $pdf = PDF::loadView('pdf.userreport', $data);
    return $pdf->stream('user-report.pdf', 'user');
}

public function userLogs(Request $request)
{
    
    $search = $request->input('search');

    $logs = ActivityLog::with('users')->latest();

    if (!empty($search)) {
        $logs->whereHas('users', function($q) use ($search){
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('id', 'like', "%{$search}%");
        });
    }

    // Filter by date range
    if ($request->date_from) {
        $query->whereDate('created_at', '>=', $request->date_from);
    }

    if ($request->date_to) {
        $query->whereDate('created_at', '<=', $request->date_to);
    }

    $logs = $logs->get();

    return view('activity.userlogs', compact('logs', 'search'));
}

public function generatePDFactivity(Request $request)
{
    
    $search = $request->input('search');

    $logs = ActivityLog::with('users')->latest();

    if (!empty($search)) {
        $logs->whereHas('users', function($q) use ($search){
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('id', 'like', "%{$search}%");
        });
    }

    // Filter by date range
    if ($request->date_from) {
        $query->whereDate('created_at', '>=', $request->date_from);
    }

    if ($request->date_to) {
        $query->whereDate('created_at', '<=', $request->date_to);
    }

    $logs = $logs->get();

    $pdf = PDF::loadView('pdf.actlog', [
        'logs' => $logs,
        'search' => $search,
        'date' => date('m/d/Y'),
        'title' => 'Activity Logs Report'
    ]);

    return $pdf->stream('activity-log.pdf');
}



public function formPDF($id)
{ 
    $user = auth()->user();


    // Load the loan data including borrower info
    $loans = Loan::findOrFail($id);

    return view('loan.show', [
        'title' => 'PDF for Form',
        'date'  => date('m/d/Y'),
        'loans'  => $loans
    ]);
}


public function generateForm($id)
{
    $user = auth()->user();
    

    $loans = Loan::findOrFail($id);
    
    $data = [
        'title' => 'Loan',
        'date'  => now()->format('d/m/Y'),
        'loans' => $loans
    ];

    $pdf = PDF::loadView('pdf.loanshow', [
        'title' => 'Loan',
        'date'  => now()->format('d/m/Y'),
        'loans'  => $loans
    ]);
    return $pdf->stream('loanshow.pdf');
}

public function equipReport()
{

    $users = User::all();
    $equipment = Equipment::all();

    $user = auth()->user();

    // pastikan hanya admin boleh tengok page ni
    if ($user->role !== 'admin') {
        abort(403, 'Unauthorized Access');
    }
    
    return view('equipment.reportequipment', [
        'title' => 'Equipment Report',
        'date'  => date('m/d/Y'),
        'equipment'  => $equipment
    ]);
}

    public function generatePDFequip()
{
    $users = User::all();
    
    $loans = Loan::all();
    $data = [
        'title' => 'Equipment Report',
        'date'  => now()->format('d/m/Y'),
        'equipment'  => $equipment,
        'users' => $users
    ];

    $pdf = PDF::loadView('pdf.equip', $data);
    return $pdf->stream('equipment-report.pdf');
}
}
