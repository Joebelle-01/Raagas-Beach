<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredCottages = \App\Models\Cottage::with('images')->latest()->take(3)->get();
    return view('welcome', compact('featuredCottages'));
})->name('home');

Route::get('/cottages', [\App\Http\Controllers\BookingController::class, 'index'])->name('cottages.index');
Route::get('/cottages/{cottage:slug}', [\App\Http\Controllers\BookingController::class, 'show'])->name('cottages.show');
Route::post('/bookings', [\App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
Route::post('/bookings/{reference}/payment', [\App\Http\Controllers\BookingController::class, 'payment'])
    ->middleware('auth')
    ->name('bookings.payment');

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isAdmin()) {
        return redirect()->intended(route('admin.dashboard', absolute: false));
    }

    if ($user->isStaff()) {
        return redirect()->intended(route('staff.dashboard', absolute: false));
    }

    $bookings = \App\Models\Booking::where('user_id', $user->id)
        ->with(['cottage', 'payments'])
        ->latest()
        ->get();

    return view('dashboard', compact('bookings'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::redirect('/admin', '/admin/dashboard');

// Admin Routes (Admin Only)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/logs', [\App\Http\Controllers\Admin\AdminController::class, 'logs'])->name('logs');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports');
});

// Shared Management Routes (Admin & Staff)
Route::middleware(['auth', 'role:admin,staff'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');
    Route::resource('cottages', \App\Http\Controllers\Admin\CottageController::class);
    
    // Cottage Image Archiving / Restoring
    Route::delete('/cottages/images/{image}/archive', [\App\Http\Controllers\Admin\CottageController::class, 'archiveImage'])->name('cottages.images.archive');
    Route::post('/cottages/images/{image_id}/restore', [\App\Http\Controllers\Admin\CottageController::class, 'restoreImage'])->name('cottages.images.restore');
    Route::delete('/cottages/images/{image_id}/purge', [\App\Http\Controllers\Admin\CottageController::class, 'purgeImage'])->name('cottages.images.purge');

    // Cottage Archiving / Restoring
    Route::post('/cottages/{cottage_id}/restore', [\App\Http\Controllers\Admin\CottageController::class, 'restore'])->name('cottages.restore');
    Route::delete('/cottages/{cottage_id}/purge', [\App\Http\Controllers\Admin\CottageController::class, 'forceDelete'])->name('cottages.purge');

    // Booking Management
    Route::get('/bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [\App\Http\Controllers\Admin\BookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/status', [\App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('bookings.update-status');
    Route::patch('/payments/{payment}/verify', [\App\Http\Controllers\Admin\BookingController::class, 'verifyPayment'])->name('payments.verify');
    Route::delete('/bookings/{booking}', [\App\Http\Controllers\Admin\BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::post('/bookings/{booking_id}/restore', [\App\Http\Controllers\Admin\BookingController::class, 'restore'])->name('bookings.restore');
    Route::delete('/bookings/{booking_id}/purge', [\App\Http\Controllers\Admin\BookingController::class, 'forceDelete'])->name('bookings.purge');
});

// Staff Dashboard
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Staff\StaffController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
