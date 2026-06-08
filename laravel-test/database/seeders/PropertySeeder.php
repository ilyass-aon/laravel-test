<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = [
    [
        'name'            => 'Villa Provençale',
        'description'     => 'Magnifique villa avec piscine au cœur du Luberon.',
        'price_per_night' => 890.00,
        'location'        => 'Gordes, Provence',
        'max_guests'      => 8,
    ],
    [
        'name'            => 'Château de la Loire',
        'description'     => 'Château du XVIIIe siècle entouré de vignes.',
        'price_per_night' => 1200.00,
        'location'        => 'Amboise, Vallée de la Loire',
        'max_guests'      => 12,
    ],
    [
        'name'            => 'Appartement Saint-Germain',
        'description'     => 'Appartement cosy au cœur du quartier latin.',
        'price_per_night' => 180.00,
        'location'        => 'Paris 6e',
        'max_guests'      => 2,
    ],
    [
        'name'            => 'Maison Basque',
        'description'     => 'Maison typique à 10 min des plages de Biarritz.',
        'price_per_night' => 350.00,
        'location'        => 'Bidart, Pays Basque',
        'max_guests'      => 5,
    ],
    [
        'name'            => 'Chalet Mont-Blanc',
        'description'     => 'Chalet avec vue imprenable sur le massif.',
        'price_per_night' => 420.00,
        'location'        => 'Chamonix, Alpes',
        'max_guests'      => 6,
    ],
];

        foreach ($properties as $property) {
            Property::create($property);
        }
    }
}
