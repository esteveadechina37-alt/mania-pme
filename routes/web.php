<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboard;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboard;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\AttendanceController;

// Page d'accueil
// Route::get('/', function () { return view('welcome');});
Route::get('/', function () { return view('welcome'); });
Route::get('/fonctionnalites', function () { return view('pages.fonctionnalites'); });
Route::get('/tarifs', function () { return view('pages.tarifs'); });
Route::get('/a-propos', function () { return view('pages.a-propos'); });
Route::get('/contact', function () { return view('pages.contact'); });

Route::get('/payslips/verify/{hash}', [App\Http\Controllers\PayslipVerificationController::class, 'show'])
    ->name('payslips.verify');

Route::get('/documents/verify/{hash}', [App\Http\Controllers\DocumentVerificationController::class, 'show'])
    ->name('documents.verify');

// Routes Auth (Breeze)
require __DIR__.'/auth.php';

// Routes Admin (administrateur d'entreprise)
Route::middleware(['auth', 'role:admin,super-admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    });

// Routes Manager
Route::middleware(['auth', 'role:manager'])
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {
        Route::get('/dashboard', [ManagerDashboard::class, 'index'])->name('dashboard');
        Route::get('/team', [App\Http\Controllers\Manager\TeamController::class, 'index'])->name('team'); 
    });

// Routes Employé & Stagiaire
Route::middleware(['auth', 'role:employe,stagiaire'])
    ->prefix('employee')
    ->name('employee.')
    ->group(function () {
        Route::get('/dashboard', [EmployeeDashboard::class, 'index'])->name('dashboard');
        Route::get('/profile', [\App\Http\Controllers\Employee\ProfileController::class, 'index'])->name('profile');
        // Route::post('/profile/avatar', [\App\Http\Controllers\Employee\ProfileController::class, 'updateAvatar'])->name('profile.avatar');
        Route::get('/internship', [\App\Http\Controllers\Employee\InternshipController::class, 'index'])->name('internship');
    });

// Routes pour la gestion des départements (Admin uniquement)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('employees', \App\Http\Controllers\Admin\EmployeeController::class);
    Route::resource('departments', \App\Http\Controllers\Admin\DepartmentController::class);
    Route::resource('leave-types', \App\Http\Controllers\Admin\LeaveTypeController::class);
    Route::resource('payslips', \App\Http\Controllers\Admin\PayslipController::class)->except(['edit', 'update', 'show']);
    Route::get('/payslips/{payslip}/download', [\App\Http\Controllers\Admin\PayslipController::class, 'download'])->name('payslips.download');
});

// Évaluations (Admin & Manager)
Route::middleware(['auth', 'role:admin,manager'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('evaluations', \App\Http\Controllers\Admin\EvaluationController::class)->except(['edit', 'update']);
});

// Pour managers et admins : validation
Route::middleware(['auth', 'role:manager,admin'])->group(function () {
    Route::get('/leave-requests/pending', [LeaveRequestController::class, 'pending'])->name('leave-requests.pending');
    Route::post('/leave-requests/{leaveRequest}/decide', [LeaveRequestController::class, 'decide'])->name('leave-requests.decide');
});

// Pour employés/stagiaires UNIQUEMENT (index, create, store)
Route::middleware(['auth', 'role:employe,stagiaire'])->group(function () {
    Route::get('/leave-requests', [LeaveRequestController::class, 'index'])->name('leave-requests.index');
    Route::get('/leave-requests/create', [LeaveRequestController::class, 'create'])->name('leave-requests.create');
    Route::post('/leave-requests', [LeaveRequestController::class, 'store'])->name('leave-requests.store');
    Route::get('/my-payslips', [App\Http\Controllers\Employee\PayslipController::class, 'index'])->name('employee.payslips.index');
    Route::get('/my-payslips/{payslip}/download', [App\Http\Controllers\Employee\PayslipController::class, 'download'])->name('employee.payslips.download');
});

// Pour le détail d'une demande : employés, stagiaires ET managers (validation)
Route::middleware(['auth', 'role:employe,stagiaire,manager'])->group(function () {
    Route::get('/leave-requests/{leaveRequest}', [LeaveRequestController::class, 'show'])->name('leave-requests.show');
});

// Pointage (employé/stagiaire)
Route::middleware(['auth', 'role:employe,stagiaire'])->group(function () {
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::post('/attendances/check-in', [AttendanceController::class, 'checkIn'])->name('attendances.checkin');
    Route::post('/attendances/check-out', [AttendanceController::class, 'checkOut'])->name('attendances.checkout');
    Route::get('/attendances/history', [AttendanceController::class, 'history'])->name('attendances.history');
    Route::get('/attendances/weekly', [AttendanceController::class, 'weekly'])->name('attendances.weekly');
    Route::get('/attendances/export-pdf', [AttendanceController::class, 'exportPdf'])->name('attendances.export-pdf');
});

// Consultation des présences (manager/admin)
Route::middleware(['auth', 'role:manager,admin'])->group(function () {
    Route::get('/attendances/list', [AttendanceController::class, 'list'])->name('attendances.list');
    Route::get('/attendances/export-list-pdf', [AttendanceController::class, 'exportListPdf'])->name('attendances.export-list-pdf');
});


// Documents RH (Admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('documents', \App\Http\Controllers\Admin\DocumentController::class)->except(['edit', 'update']);
    Route::get('/documents/attestation/create', [\App\Http\Controllers\Admin\DocumentController::class, 'createAttestation'])->name('documents.attestation.create');
    Route::post('/documents/attestation', [\App\Http\Controllers\Admin\DocumentController::class, 'storeAttestation'])->name('documents.attestation.store');
    Route::get('/documents/{document}/download', [\App\Http\Controllers\Admin\DocumentController::class, 'download'])->name('documents.download');
});

// Documents pour l'employé/stagiaire
Route::middleware(['auth', 'role:employe,stagiaire'])->group(function () {
    Route::get('/my-documents', [\App\Http\Controllers\Employee\DocumentController::class, 'index'])->name('employee.documents.index');
    Route::get('/my-documents/{document}/download', [\App\Http\Controllers\Employee\DocumentController::class, 'download'])->name('employee.documents.download');
});

// Évaluations (employé/stagiaire)
Route::middleware(['auth', 'role:employe,stagiaire'])->group(function () {
    Route::get('/my-evaluations', [\App\Http\Controllers\Employee\EvaluationController::class, 'index'])->name('employee.evaluations.index');
    Route::get('/my-evaluations/{evaluation}', [\App\Http\Controllers\Employee\EvaluationController::class, 'show'])->name('employee.evaluations.show');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/settings', [\App\Http\Controllers\Admin\CompanySettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [\App\Http\Controllers\Admin\CompanySettingsController::class, 'update'])->name('settings.update');
});


// Notifications (tous les utilisateurs authentifiés)
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/account/settings', [\App\Http\Controllers\UserSettingsController::class, 'edit'])->name('user.settings.edit');
    Route::put('/account/settings', [\App\Http\Controllers\UserSettingsController::class, 'update'])->name('user.settings.update');
});



// // Pour managers et admins : validation
// Route::middleware(['auth', 'role:manager,admin'])->group(function () {
//     Route::get('/leave-requests/pending', [LeaveRequestController::class, 'pending'])->name('leave-requests.pending');
//     Route::post('/leave-requests/{leaveRequest}/decide', [LeaveRequestController::class, 'decide'])->name('leave-requests.decide');
// });

// // Pour employés/stagiaires
// // Pour employés/stagiaires (et aussi le manager pour voir le détail)
// Route::middleware(['auth', 'role:employe,stagiaire,manager'])->group(function () {
//     Route::get('/leave-requests', [LeaveRequestController::class, 'index'])->name('leave-requests.index');
//     Route::get('/leave-requests/create', [LeaveRequestController::class, 'create'])->name('leave-requests.create');
//     Route::post('/leave-requests', [LeaveRequestController::class, 'store'])->name('leave-requests.store');
//     Route::get('/leave-requests/{leaveRequest}', [LeaveRequestController::class, 'show'])->name('leave-requests.show');
// });
// // Route::middleware(['auth', 'role:employe,stagiaire'])->group(function () {
// //     Route::get('/leave-requests', [LeaveRequestController::class, 'index'])->name('leave-requests.index');
// //     Route::get('/leave-requests/create', [LeaveRequestController::class, 'create'])->name('leave-requests.create');
// //     Route::post('/leave-requests', [LeaveRequestController::class, 'store'])->name('leave-requests.store');
// //     Route::get('/leave-requests/{leaveRequest}', [LeaveRequestController::class, 'show'])->name('leave-requests.show');
// // });

