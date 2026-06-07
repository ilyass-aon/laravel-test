<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Nos propriétés disponibles
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($properties as $property)
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">
                            {{ $property->name }}
                        </h3>
                        <p class="text-sm text-gray-500 mb-3">
                             {{ $property->location }}
                        </p>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ $property->description }}
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-primary font-bold text-lg">
                                {{ number_format($property->price_per_night, 0) }} €
                                <span class="text-sm font-normal text-gray-400">/nuit</span>
                            </span>
                            <a href="{{ route('properties.show', $property) }}"
                               class="bg-primary text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-800 transition">
                                Voir détail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>