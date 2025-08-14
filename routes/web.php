<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', [App\Http\Controllers\LmsController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [App\Http\Controllers\LmsController::class, 'index'])->name('dashboard');
    
    // Course management
    Route::resource('courses', App\Http\Controllers\CourseController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
