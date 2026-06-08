<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Property;

class PropertyController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $properties = Property::all();
        } else {
            $properties = Property::whereDoesntHave('bookings', function ($query) {
                $query->where('status', 'confirmed')
                      ->where('start_date', '<=', today())
                      ->where('end_date', '>=', today());
            })->get();
    }
    return view('properties.index', compact('properties'));
    }

    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }
}
