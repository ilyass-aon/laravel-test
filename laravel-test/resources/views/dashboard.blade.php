<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Bonjour, {{ auth()->user()->name }} 
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Cartes stats --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Propriétés disponibles --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                    <p class="text-sm text-gray-500 mb-1">Propriétés disponibles</p>
                    <p class="text-3xl font-bold text-primary">{{ $availableProperties }}</p>
                    <a href="{{ route('properties.index') }}"
                       class="text-xs text-secondary hover:underline mt-2 inline-block">
                        Voir les propriétés →
                    </a>
                </div>

                {{-- Mes réservations --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                    <p class="text-sm text-gray-500 mb-1">Mes réservations</p>
                    <p class="text-3xl font-bold text-primary">{{ $totalBookings }}</p>
                    <a href="{{ route('bookings.index') }}"
                       class="text-xs text-secondary hover:underline mt-2 inline-block">
                        Voir mes réservations →
                    </a>
                </div>

                {{-- Prochaine réservation --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                    <p class="text-sm text-gray-500 mb-1">Prochaine réservation</p>
                    @if($nextBooking)
                        <p class="text-lg font-bold text-gray-800">{{ $nextBooking->property->name }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $nextBooking->start_date->format('d/m/Y') }}
                            →
                            {{ $nextBooking->end_date->format('d/m/Y') }}
                        </p>
                    @else
                        <p class="text-gray-400 text-sm mt-2">Aucune réservation à venir</p>
                    @endif
                </div>

            </div>

            {{-- Raccourci nouvelle réservation --}}
            <div class="bg-primary rounded-xl p-6 flex items-center justify-between">
                <div>
                    <p class="text-white font-semibold text-lg">Vous souhaitez réserver un bien ?</p>
                    <p class="text-blue-200 text-sm mt-1">Consultez nos propriétés disponibles et faites votre réservation.</p>
                </div>
                <a href="{{ route('bookings.index') }}"
                   class="bg-white text-primary font-semibold text-sm px-6 py-3 rounded-lg hover:bg-blue-50 transition whitespace-nowrap">
                    Nouvelle réservation
                </a>
            </div>

            {{-- Dernières réservations --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Mes dernières réservations</h3>

                @if($recentBookings->isEmpty())
                    <p class="text-gray-400 text-sm">Vous n'avez pas encore de réservation.</p>
                @else
                    <table class="w-full text-sm text-left">
                        <thead class="text-gray-500 border-b border-gray-100">
                            <tr>
                                <th class="pb-3">Propriété</th>
                                <th class="pb-3">Du</th>
                                <th class="pb-3">Au</th>
                                <th class="pb-3">Total</th>
                                <th class="pb-3">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($recentBookings as $booking)
                                <tr>
                                    <td class="py-3 font-medium text-gray-800">{{ $booking->property->name }}</td>
                                    <td class="py-3 text-gray-600">{{ $booking->start_date->format('d/m/Y') }}</td>
                                    <td class="py-3 text-gray-600">{{ $booking->end_date->format('d/m/Y') }}</td>
                                    <td class="py-3 font-semibold text-primary">{{ number_format($booking->total_price, 0) }} MAD</td>
                                    <td class="py-3">
                                        @if($booking->status === 'confirmed')
                                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Confirmé</span>
                                        @elseif($booking->status === 'pending')
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs">En attente</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs">Annulé</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
