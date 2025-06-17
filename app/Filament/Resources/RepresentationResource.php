<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RepresentationResource\Pages;
use App\Filament\Resources\RepresentationResource\RelationManagers;
use App\Models\Representation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RepresentationResource extends Resource
{
    protected static ?string $model = Representation::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Gestion du contenu';
    protected static ?string $navigationLabel = 'Représentations';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('show_id')
                ->relationship('show', 'title')
                ->required(),

            Forms\Components\Select::make('location_id')
                ->relationship('location', 'designation')
                ->required(),

            Forms\Components\DateTimePicker::make('schedule')
                ->label('Date et heure')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('show.title')->label('Spectacle'),
            Tables\Columns\TextColumn::make('location.designation')->label('Lieu'),
            Tables\Columns\TextColumn::make('schedule')->dateTime('d/m/Y H:i')->label('Horaire'),
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
            'index' => Pages\ListRepresentations::route('/'),
            'create' => Pages\CreateRepresentation::route('/create'),
            'edit' => Pages\EditRepresentation::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function getPanel(): string
    {
        return 'admin';
    }

    public static function canViewAny(): bool
    {
        return true;
    }
}
