<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Filament\Resources\ReservationResource\RelationManagers;
use App\Models\Reservation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Réservations';
    protected static ?string $navigationLabel = 'Réservations';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->relationship('user', 'email')
                ->label('Utilisateur')
                ->required(),

            Forms\Components\DateTimePicker::make('booking_date')
                ->label('Date de réservation')
                ->required(),

            Forms\Components\TextInput::make('status')
                ->label('Statut')
                ->required()
                ->maxLength(60),
            
            Forms\Components\Select::make('type_id')
                ->relationship('type', 'type') // Clé étrangère 'type_id', affichage du champ 'type'
                ->label('Type de spectacle')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('user.name')->label('Utilisateur'),
            Tables\Columns\TextColumn::make('user.id')->label('Matricule'),
            Tables\Columns\TextColumn::make('booking_date')->label('Date')->dateTime('d/m/Y H:i'),
            Tables\Columns\TextColumn::make('status')->label('Statut'),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }

    public static function getPanel(): string
    {
        return 'admin';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function canViewAny(): bool
    {
        return true;
    }
}
