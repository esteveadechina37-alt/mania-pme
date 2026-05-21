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
    });

// Routes Employé & Stagiaire
Route::middleware(['auth', 'role:employe,stagiaire'])
    ->prefix('employee')
    ->name('employee.')
    ->group(function () {
        Route::get('/dashboard', [EmployeeDashboard::class, 'index'])->name('dashboard');
    });

// Routes pour la gestion des départements (Admin uniquement)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('employees', \App\Http\Controllers\Admin\EmployeeController::class);
    Route::resource('departments', \App\Http\Controllers\Admin\DepartmentController::class);
    Route::resource('leave-types', \App\Http\Controllers\Admin\LeaveTypeController::class);
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

