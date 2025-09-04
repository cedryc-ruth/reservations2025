<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Utilisateurs';
    protected static ?string $navigationLabel = 'Membres';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('firstname')
                ->label('Prénom')
                ->required(),
            Forms\Components\TextInput::make('lastname')
                ->label('Nom')
                ->required(),
            Forms\Components\TextInput::make('email')->email()->required(),
            Forms\Components\Toggle::make('is_admin')->label('Administrateur'),
            Forms\Components\TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn ($state) => $state ? Hash::make($state) : null)
                ->label('Mot de passe')
                ->required(fn (string $context): bool => $context === 'create')
                ->dehydrated(fn ($state) => filled($state))
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('firstname')
                    ->label('Prénom')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('lastname')
                    ->label('Nom')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_admin')
                    ->boolean()
                    ->label('Admin'),
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
                ->url(route('export.users'))
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
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