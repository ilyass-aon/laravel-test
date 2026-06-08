<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ $property->name }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-8">

                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-1">
                            {{ $property->name }}
                        </h1>
                        <p class="text-gray-500"> {{ $property->location }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-primary">
                            {{ number_format($property->price_per_night, 0) }} €
                        </p>
                        <p class="text-sm text-gray-400">par nuit</p>
                    </div>
                </div>

                <p class="text-gray-600 leading-relaxed mb-6">
                    {{ $property->description }}
                </p>

                <div class="p-4 bg-gray-50 rounded-lg mb-8">
                    <p class="text-sm text-gray-500">Capacité maximale</p>
                    <p class="font-semibold text-gray-800">{{ $property->max_guests }} personnes</p>
                </div>

                <div class="mt-8 border-t border-gray-100 pt-8 flex justify-between items-center">
                    <a href="{{ route('properties.index') }}"
                       class="text-sm text-gray-500 hover:text-primary transition">
                        ← Retour aux propriétés
                    </a>
                    
                    <a href="{{ route('bookings.create', ['property_id' => $property->id]) }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Réserver cette propriété
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>