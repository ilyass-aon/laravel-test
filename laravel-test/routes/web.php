<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
    Route::get('/bookings/create', fn () => view('bookings.create'))->name('bookings.create');
    Route::get('/bookings', function () {
        $bookings = \App\Models\Booking::where('user_id', auth()->id())->with('property')->latest()->get();
        return view('bookings.index', compact('bookings'));
    })->name('bookings.index');
});

require __DIR__.'/auth.php';
