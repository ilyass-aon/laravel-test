<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
use App\Models\Property;

class BookingManager extends Component
{
    // Champs du formulaire
    public $property_id;
    public $start_date;
    public $end_date;
    public $nbr_guests = 1;
    public $successMessage = '';
    public $errorMessage = '';

    // Nouveaux champs pour notre logique
    public $viewMode = 'both'; // 'list', 'form', 'both'
    public $property_preselected = false;

    // Validation des données
    protected $rules = [
        'property_id' => 'required|exists:properties,id',
        'start_date'  => 'required|date|after_or_equal:today',
        'end_date'    => 'required|date|after:start_date',
        'nbr_guests'  => 'required|integer|min:1',
    ];

    protected $messages = [
        'property_id.required' => 'Veuillez sélectionner une propriété.',
        'start_date.required'  => 'La date de début est obligatoire.',
        'start_date.after_or_equal' => 'La date de début doit être aujourd\'hui ou dans le futur.',
        'end_date.required'    => 'La date de fin est obligatoire.',
        'end_date.after'       => 'La date de fin doit être après la date de début.',
        'nbr_guests.required'  => 'Veuillez indiquer le nombre de personnes.',
        'nbr_guests.min'       => 'Il faut au moins 1 personne.',
    ];

    public function mount($viewMode = 'both', $property_id = null)
    {
        $this->viewMode = $viewMode;
        
        $param_property_id = request()->query('property_id') ?? $property_id;
        
        if ($param_property_id) {
            $this->property_id = $param_property_id;
            $this->property_preselected = true;
        }
    }

    public function reserve()
    {
        $this->validate();

        // Vérifier la capacité
        $property = Property::find($this->property_id);
        if ($this->nbr_guests > $property->max_guests) {
            $this->errorMessage = 'La capacité maximale de cette propriété est de ' . $property->max_guests . ' personnes.';
            return;
        }

        // Vérifier la disponibilité
        $overlap = Booking::where('property_id', $this->property_id)
            ->where('status', 'confirmed')
            ->where(function ($query) {
                $query->whereBetween('start_date', [$this->start_date, $this->end_date])
                      ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                      ->orWhere(function ($q) {
                          $q->where('start_date', '<=', $this->start_date)
                            ->where('end_date', '>=', $this->end_date);
                      });
            })->exists();

        if ($overlap) {
            $this->errorMessage = 'Ces dates sont déjà réservées pour cette propriété.';
            return;
        }

        Booking::create([
            'user_id'     => auth()->id(),
            'property_id' => $this->property_id,
            'start_date'  => $this->start_date,
            'end_date'    => $this->end_date,
            'nbr_guests'  => $this->nbr_guests,
            'status'      => 'pending',
        ]);

        session()->flash('success', 'Réservation effectuée avec succès !');
        return redirect()->route('bookings.index');
    }

    public function render()
    {
        return view('livewire.booking-manager', [
            'properties' => Property::all(),
            'bookings'   => Booking::where('user_id', auth()->id())
                                   ->with('property')
                                   ->latest()
                                   ->get(),
        ]);
    }
}
