<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailables\Attachment;
use App\Traits\ActivityLogger;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\SignaturePadController;
use App\Mail\WelcomeMail;


Route::get('/', function () {
    return view('welcome');
});


Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->name('login');

    Route::get('/equip_avail', function () {
    return view('equip_avail');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Route to check user role and redirect
    Route::get('/userinfo/userdashboard/check', function () {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('loan.index');
    })->name('user.check');

    // Admin dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    // User dashboard
    Route::get('/userinfo/userdashboard', [UserController::class, 'dashboard'])
        ->name('userinfo.userdashboard');
});



Route::get('/file', function () {
    return "Upload File";
})->name('file.index');

Route::get('/images', function () {
    return "Image";
})->name('images.index');



Route::middleware(['auth'])->group(function () {

    Route::get('/userinfo', [UserController::class, 'index'])->name('userinfo.index');
    Route::get('/userinfo/create', [UserController::class, 'create'])->name('userinfo.create');
    Route::post('/userinfo/store', [UserController::class, 'store'])->name('userinfo.store');
    Route::get('/userinfo/{id}/edit', [UserController::class, 'edit'])->name('userinfo.edit');
    Route::put('/userinfo/{id}/update', [UserController::class, 'update'])->name('userinfo.update');
    Route::get('/userinfo/datatable', [UserController::class, 'datatable'])->name('userinfo.datatable');
    Route::get('/userinfo/userprofile/{id}', [UserController::class, 'userprofile'])->name('userinfo.userprofile');
    Route::put('/userinfo/{id}/update-Approval', [UserController::class, 'updateApproval'])->name('userinfo.updateApproval');
    Route::get('/userinfo/form/{id}', [UserController::class, 'form'])->name('userinfo.form');
    Route::delete('/userinfo/{id}', [UserController::class, 'destroy'])->name('userinfo.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('admin/index', [AdminController::class, 'index'])->name('admin.index');
});

Route::resource('loans', LoanController::class)->middleware('auth');
// Loan routes
Route::middleware(['auth'])->group(function () {
Route::get('/loan', [LoanController::class, 'index'])->name('loan.index');
Route::get('/loan/create', [LoanController::class, 'create'])->name('loan.create');
Route::post('/loan/store', [LoanController::class, 'store'])->name('loan.store');
Route::get('/loan/{id}/show', [LoanController::class, 'show'])->name('loan.show');
Route::put('/loan/{id}/update', [LoanController::class, 'update'])->name('loan.update');
Route::get('/loan/{id}/edit', [LoanController::class, 'edit'])->name('loan.edit');
Route::delete('/loan/{id}', [LoanController::class, 'destroy'])->name('loan.destroy');
Route::post('/loan/{id}/return', [LoanController::class, 'returnEquipment'])
    ->name('loan.return');
Route::put('/loan/{loan}/update-return', [LoanController::class, 'updateReturnDate'])->name('loan.updateReturnDate');
Route::put('/loan/{loan}/update-status', [LoanController::class, 'updateStatus'])->name('loan.updateStatus');


});

// Optional (later)
// Route::put('/loan/{id}/update-status', [LoanController::class, 'updateStatus'])->name('loan.updateStatus');
Route::put('/loan/{id}/update-dates', [LoanController::class, 'updateDates'])->name('loan.updateDates');

//report pdf,download
Route::get('/loan/reportloan', [PDFController::class, 'showReport'])->name('loan.reportloan');
Route::get('/loan/print-pdf', [PDFController::class, 'generatePDF'])->name('loan.printpdf');
Route::get('/user/reportuser', [PDFController::class, 'userReport'])->name('user.reportuser');
Route::get('/user/print-pdf', [PDFController::class, 'generatePDFuser'])->name('user.printpdf');
Route::get('/activity/userlogs', [PDFController::class, 'userLogs'])->name('activity.userlogs');
Route::get('/activity/print-pdf', [PDFController::class, 'generatePDFactivity'])->name('activity.printpdf');
Route::get('/loan/{id}/show', [PDFController::class, 'formPDF'])->name('loan.show');
Route::get('/loan/{id}/print-pdf', [PDFController::class, 'generateForm'])->name('loanshow.printpdf');
Route::get('/equipment/reportloan', [PDFController::class, 'equipReport'])->name('equipment.reportequipment');
Route::get('/equipment/print-pdf', [PDFController::class, 'generatePDFequip'])->name('equipment.printpdf');

//setting
Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/role', [SettingController::class, 'roleIndex'])->name('settings.role');

    // untuk User update password
    Route::post('/settings/update-password', [SettingController::class, 'updatePassword'])->name('settings.updatePassword');

    // untuk Admin-only routes
    Route::middleware('admin')->group(function () {
        Route::post('/settings/admin/update-password/{id}', [SettingController::class, 'adminUpdatePassword'])->name('settings.adminUpdatePassword');
        Route::post('/settings/update-role/{id}', [SettingController::class, 'updateRole'])->name('settings.updateRole');
    });
});

//equipment page
Route::middleware(['auth'])->group(function () {
Route::get('/equipment/index', [EquipmentController::Class, 'index'])->name('equipment.index');
Route::get('/equipment/create', [EquipmentController::class, 'create'])->name('equipment.create');
Route::post('/equipment/store', [EquipmentController::Class, 'store'])->name('equipment.store');
Route::put('/equipment/{id}/update', [EquipmentController::Class, 'update'])->name('equipment.update');
Route::get('/equipment/{id}/edit', [EquipmentController::Class, 'edit'])->name('equipment.edit');
Route::delete('/equipment/{id}/destroy', [EquipmentController::Class, 'destroy'])->name('equipment.destroy');
Route::get('/equipment/form', [EquipmentController::Class, 'formpdf'])->name('equipment.form');
Route::get('/equipment/list', [EquipmentController::Class, 'getEquipmentList']);

});

//notification punya web
Route::middleware(['auth'])->group(function () {

    // User notifications
    Route::get('/notifications/index', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/notifications/fetch', [NotificationController::class, 'fetchNotifications'])->name('notifications.fetch');
    

    // Admin only
    Route::middleware('admin')->group(function () {
        Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
        Route::post('/notifications/store', [NotificationController::class, 'store'])->name('notifications.store');
    });

});

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// signaturepad
Route::get('/signature/index', [SignaturePadController::class, 'index'])->name('signature.index');
Route::post('/signature/signaturePad', [SignaturePadController::class, 'upload'])->name('signature.upload');



Route::get('/send-welcome-mail', [MailsController::class, 'WelcomeMail']);


require __DIR__.'/auth.php';


//FIle Controller
// Route::get('/file/index', [FileController::class, 'index'])->name('file.index');
// Route::post('/file/upload', [FileController::class, 'store'])->name('file.store');
// Route::delete('/files/{id}', [FileController::class, 'destroy'])->name('file.destroy');


//image controller
// Route::middleware(['auth'])->group(function () {
//     Route::get('/images', [ImageController::class, 'index'])->name('images.index');
//     Route::post('/images', [ImageController::class, 'upload'])->name('images.upload');
//     Route::delete('/images/{id}', [ImageController::class, 'destroy'])->name('images.destroy');
// });


// activity log
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/activity/{id}/userlogs', [ActivityLogController::class, 'userLogs'])->name('activity.userlogs');
//     Route::get('/activityindex', [ActivityLogController::class, 'index'])->name('activity.index');
// });