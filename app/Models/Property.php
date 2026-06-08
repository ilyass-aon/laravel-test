<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Property extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'description',
        'price_per_night',
        'location',
        'max_guests',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getIsAvailableAttribute()
    {
        return !$this->bookings()
            ->where('status', 'confirmed')
            ->where('start_date', '<=', today())
            ->where('end_date', '>=', today())
            ->exists();
    }
}
