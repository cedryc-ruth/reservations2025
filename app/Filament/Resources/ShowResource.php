<?php

namespace App\Filament\Resources;

use App\Models\Show;
use App\Models\Location;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Resources\Resource;
use App\Filament\Resources\ShowResource\Pages;

class ShowResource extends Resource
{
    protected static ?string $model = Show::class;
    protected static ?string $navigationIcon = 'heroicon-o-film';
    protected static ?string $navigationGroup = 'Gestion du contenu';
    protected static ?string $navigationLabel = 'Spectacles';
    protected static ?int $navigationSort = 3;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(60),

            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->required()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('poster_url')
                ->label('Affiche (URL)')
                ->url()
                ->nullable(),

            Forms\Components\TextInput::make('duration')
                ->label('Durée (min)')
                ->numeric()
                ->required(),

            Forms\Components\DatePicker::make('created_in')
                ->label('Année de création')
                ->required(),

            Forms\Components\Select::make('location_id')
                ->relationship('location', 'designation')
                ->label('Lieu')
                ->required(),

            Forms\Components\Toggle::make('bookable')
                ->label('Réservable')
                ->default(true),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('duration')->label('Durée'),
            Tables\Columns\TextColumn::make('location.designation')->label('Lieu'),
            Tables\Columns\IconColumn::make('bookable')->boolean()->label('Réservable'),
            Tables\Columns\TextColumn::make('created_in')->label('Créé en'),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShows::route('/'),
            'create' => Pages\CreateShow::route('/create'),
            'edit' => Pages\EditShow::route('/{record}/edit'),
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