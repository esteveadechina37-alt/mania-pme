<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboard;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboard;

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

// employees
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('employees', \App\Http\Controllers\Admin\EmployeeController::class);
});