<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\DB; 
use App\Http\Controllers\AdminController;

// Protect Login
Route::get('/login', function () { return view('login'); })->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');

// Protect OTP Routes
Route::get('/verify-otp', function () { return view('auth.verify-otp'); })->name('otp.view');
Route::post('/verify-otp', [LoginController::class, 'verifyOtp'])
    ->name('otp.verify')
    ->middleware('throttle:3,1');

Route::post('/resend-otp', [LoginController::class, 'resendOtp'])
    ->name('otp.resend')
    ->middleware('throttle:2,1');

Route::middleware(['auth'])->group(function () {
    // Admin Dashboard - Updated to fetch logs
   Route::get('/admin/dashboard', function () {
    $accounts = \App\Models\User::all();
    
    // Fetch logs and 'eager load' the user to get decrypted names
    $logs = \App\Models\AuditLog::with('user')->latest()->take(5)->get();

    return view('admin.manage_accounts', compact('accounts', 'logs'));
})->name('admin.dashboard');

    // CRUD Routes
    Route::post('/admin/store', [LoginController::class, 'store'])->name('admin.store');
    Route::delete('/admin/delete/{id}', [LoginController::class, 'destroy'])->name('admin.delete');
    
// Edit and Update Routes
Route::get('/admin/edit/{id}', [LoginController::class, 'edit'])->name('admin.edit');
Route::put('/admin/update/{id}', [LoginController::class, 'update'])->name('admin.update');

    
    // Registrar Dashboard
    Route::get('/registrar/dashboard', function () {
        return view('registrar.registrar_dashboard');
    })->name('registrar_dashboard');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/accounts/{id}/toggle-lock', [LoginController::class, 'toggleLock'])->name('accounts.toggleLock');
});

Route::prefix('admin')->group(function () {
    
Route::get('/admin/students', [AdminController::class, 'students'])->name('admin.students');
Route::get('/admin/events/create', [AdminController::class, 'createEvent'])->name('admin.events.create');
Route::post('/admin/events/store', [AdminController::class, 'storeEvent'])->name('admin.events.store');
Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
Route::post('/admin/settings/update', [AdminController::class, 'updateSettings'])->name('admin.settings.update');

});