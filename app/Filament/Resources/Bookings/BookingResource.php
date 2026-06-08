<?php

namespace App\Filament\Resources\Bookings;

use App\Filament\Resources\Bookings\Pages;
use App\Models\Booking;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $label = 'Réservation';
    protected static ?string $pluralLabel = 'Réservations';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\Select::make('user_id')
                ->label('Utilisateur')
                ->relationship('user', 'name')
                ->required(),

            Forms\Components\Select::make('property_id')
                ->label('Propriété')
                ->relationship('property', 'name')
                ->required(),

            Forms\Components\DatePicker::make('start_date')
                ->label('Date de début')
                ->required(),

            Forms\Components\DatePicker::make('end_date')
                ->label('Date de fin')
                ->required(),

            Forms\Components\Select::make('status')
                ->label('Statut')
                ->options([
                    'pending'   => 'En attente',
                    'confirmed' => 'Confirmé',
                    'cancelled' => 'Annulé',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Utilisateur')
                    ->searchable(),

                Tables\Columns\TextColumn::make('property.name')
                    ->label('Propriété')
                    ->searchable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Début')
                    ->date('d/m/Y'),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('Fin')
                    ->date('d/m/Y'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Statut')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'confirmed',
                        'danger'  => 'cancelled',
                    ])
                    ->formatStateUsing(fn ($state) => match($state) {
                        'pending'   => 'En attente',
                        'confirmed' => 'Confirmé',
                        'cancelled' => 'Annulé',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'pending'   => 'En attente',
                        'confirmed' => 'Confirmé',
                        'cancelled' => 'Annulé',
                    ]),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit'   => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}