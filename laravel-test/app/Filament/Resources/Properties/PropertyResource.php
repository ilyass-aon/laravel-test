<?php

namespace App\Filament\Resources\Properties;

use App\Filament\Resources\Properties\Pages;
use App\Models\Property;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';
    protected static ?string $label = 'Propriété';
    protected static ?string $pluralLabel = 'Propriétés';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\TextInput::make('name')
                ->label('Nom')
                ->required(),

            Forms\Components\TextInput::make('location')
                ->label('Localisation')
                ->required(),

            Forms\Components\Textarea::make('description')
                ->label('Description')
                ->required()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('price_per_night')
                ->label('Prix par nuit (€)')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('max_guests')
                ->label('Capacité max')
                ->numeric()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),

                Tables\Columns\TextColumn::make('location')
                    ->label('Localisation')
                    ->searchable(),

                Tables\Columns\TextColumn::make('price_per_night')
                    ->label('Prix/nuit')
                    ->money('EUR'),

                Tables\Columns\TextColumn::make('max_guests')
                    ->label('Capacité'),

                // Colonne calculée : disponible ou réservé
                Tables\Columns\BadgeColumn::make('disponibilité')
                    ->getStateUsing(fn (Property $record) =>
                        $record->is_available ? 'Disponible' : 'Réservé'
                    )
                    ->colors([
                        'success' => 'Disponible',
                        'danger'  => 'Réservé',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('disponibilité')
                    ->options([
                        'available' => 'Disponible',
                        'reserved'  => 'Réservé',
                    ])
                    ->query(function ($query, array $data) {
                        if ($data['value'] === 'available') {
                            $query->whereDoesntHave('bookings', fn ($q) =>
                                $q->where('status', 'confirmed')
                                  ->where('start_date', '<=', today())
                                  ->where('end_date', '>=', today())
                            );
                        } elseif ($data['value'] === 'reserved') {
                            $query->whereHas('bookings', fn ($q) =>
                                $q->where('status', 'confirmed')
                                  ->where('start_date', '<=', today())
                                  ->where('end_date', '>=', today())
                            );
                        }
                    }),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit'   => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}