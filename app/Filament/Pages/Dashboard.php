<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    public static function getSlug(): string
    {
        return '/';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
