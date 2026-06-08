<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

use App\Models\Booking;
use App\Models\Property;

Route::get('/', function () {
    $properties = Property::whereDoesntHave('bookings', function ($query) {
        $query->where('status', 'confirmed')
              ->where('start_date', '<=', today())
              ->where('end_date', '>=', today());
    })->get();

    return view('welcome', compact('properties'));
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    $availableProperties = Property::whereDoesntHave('bookings', function ($query) {
        $query->where('status', 'confirmed')
              ->where('start_date', '<=', today())
              ->where('end_date', '>=', today());
    })->count();

    $totalBookings = Booking::where('user_id', $user->id)->count();

    $nextBooking = Booking::where('user_id', $user->id)
        ->where('status', 'confirmed')
        ->where('start_date', '>=', today())
        ->with('property')
        ->orderBy('start_date')
        ->first();

    $recentBookings = Booking::where('user_id', $user->id)
        ->with('property')
        ->latest()
        ->take(3)
        ->get();

    return view('dashboard', compact(
        'availableProperties',
        'totalBookings',
        'nextBooking',
        'recentBookings'
    ));
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
