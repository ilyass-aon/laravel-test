<div>
    @if($viewMode === 'both' || $viewMode === 'form')
    {{-- Formulaire de réservation --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Nouvelle réservation</h3>

        {{-- Message succès --}}
        @if($successMessage)
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                {{ $successMessage }}
            </div>
        @endif

        {{-- Message erreur --}}
        @if($errorMessage)
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                {{ $errorMessage }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            {{-- Sélection propriété --}}
            @if(!$property_preselected)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Propriété</label>
                <select wire:model="property_id"
                        class="w-full rounded-lg border-gray-300 text-sm focus:ring-primary focus:border-primary">
                    <option value="">-- Choisir --</option>
                    @foreach($properties as $property)
                        <option value="{{ $property->id }}">
                            {{ $property->name }} — {{ number_format($property->price_per_night, 0) }} €/nuit
                        </option>
                    @endforeach
                </select>
                @error('property_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            @endif

            {{-- Date début --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                <input type="date" wire:model="start_date"
                       class="w-full rounded-lg border-gray-300 text-sm focus:ring-primary focus:border-primary" />
                @error('start_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Date fin --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                <input type="date" wire:model="end_date"
                       class="w-full rounded-lg border-gray-300 text-sm focus:ring-primary focus:border-primary" />
                @error('end_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nombre de personnes --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Personnes</label>
                <input type="number" wire:model="nbr_guests" min="1"
                       class="w-full rounded-lg border-gray-300 text-sm focus:ring-primary focus:border-primary" />
                @error('nbr_guests')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('bookings.index') }}"
               class="text-sm text-gray-500 hover:text-blue-600 transition">
                ← Retour aux réservations
            </a>
            <button wire:click="reserve"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-800 transition">
                Confirmer la réservation
            </button>
        </div>
    </div>
    @endif

    @if($viewMode === 'both' || $viewMode === 'list')
    {{-- Liste des réservations de l'utilisateur --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Mes réservations</h3>

        @if($bookings->isEmpty())
            <p class="text-gray-400 text-sm">Vous n'avez pas encore de réservation.</p>
        @else
            <table class="w-full text-sm text-left">
                <thead class="text-gray-500 border-b border-gray-100">
                    <tr>
                        <th class="pb-3">Propriété</th>
                        <th class="pb-3">Du</th>
                        <th class="pb-3">Au</th>
                        <th class="pb-3">Personnes</th>
                        <th class="pb-3">Total</th>
                        <th class="pb-3">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($bookings as $booking)
                        <tr class="py-3">
                            <td class="py-3 font-medium text-gray-800">{{ $booking->property->name }}</td>
                            <td class="py-3 text-gray-600">{{ $booking->start_date->format('d/m/Y') }}</td>
                            <td class="py-3 text-gray-600">{{ $booking->end_date->format('d/m/Y') }}</td>
                            <td class="py-3 text-gray-600">{{ $booking->nbr_guests }}</td>
                            <td class="py-3 font-semibold text-blue-600">{{ number_format($booking->total_price, 0) }} €</td>
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
    @endif
</div>
