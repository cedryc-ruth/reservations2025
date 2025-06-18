<?php

namespace App\Filament\Resources;

use App\Models\Show;
use App\Models\Location;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Resources\Resource;
use App\Filament\Resources\ShowResource\Pages;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;

class ShowResource extends Resource
{
    protected static ?string $model = Show::class;
    protected static ?string $navigationIcon = 'heroicon-o-film';
    protected static ?string $navigationGroup = 'Gestion du contenu';
    protected static ?string $navigationLabel = 'Spectacles';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->label('Titre')
                ->required(),

            Forms\Components\TextInput::make('slug')
                ->label('Slug')
                ->required(),

            Forms\Components\Textarea::make('description')
                ->label('Description')
                ->required(),

            Forms\Components\FileUpload::make('poster_url')
                ->label('Affiche')
                ->directory('images') // va enregistrer dans public/images/
                ->disk('public_root') // cf. config/filesystems.php ci-dessous
                ->visibility('public')
                ->required(),

            Forms\Components\TextInput::make('duration')
                ->label('Durée (minutes)')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('created_in')
                ->label('Année de création')
                ->numeric()
                ->minValue(1900)
                ->maxValue(date('Y'))
                ->required(),

            Forms\Components\Select::make('location_id')
                ->label('Lieu')
                ->relationship('location', 'designation')
                ->required(),

            Forms\Components\Select::make('bookable')
                ->label('Réservable ?')
                ->options([
                    0 => 'Non',
                    1 => 'Oui',
                ])
                ->required(),
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
        ])
        ->headerActions([
            Action::make('export')
                ->label('Exporter CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('warning')
                ->url(route('export.shows'))
                ->openUrlInNewTab(),
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