<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Filament\Resources\ReviewResource\RelationManagers;
use App\Models\Review;
use App\Models\User;
use App\Models\Show;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'Utilisateurs';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->label('Utilisateur')
                ->relationship('user', 'firstname')
                ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->firstname} {$record->lastname} ({$record->email})")
                ->required(),

            Forms\Components\Select::make('show_id')
                ->label('Spectacle')
                ->relationship('show', 'title')
                ->required(),

            Forms\Components\Textarea::make('review')
                ->label('Commentaire')
                ->required()
                ->maxLength(1000),

            Forms\Components\Select::make('stars')
                ->label('Note')
                ->required()
                ->options([
                    1 => '⭐',
                    2 => '⭐⭐',
                    3 => '⭐⭐⭐',
                    4 => '⭐⭐⭐⭐',
                    5 => '⭐⭐⭐⭐⭐',
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.firstname')
                    ->label('Prénom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.lastname')
                    ->label('Nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('show.title')->label('Spectacle'),
                Tables\Columns\TextColumn::make('stars')->label('Note'),
                Tables\Columns\TextColumn::make('review')->limit(50)->label('Commentaire'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Date de publication'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->label('Date de modification'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
            Action::make('export')
                ->label('Exporter CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('warning')
                ->url(route('export.reviews'))
                ->openUrlInNewTab(),
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
