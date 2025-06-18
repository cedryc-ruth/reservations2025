<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class HomeWidget extends Widget
{

    protected static string $view = 'filament.widgets.home-widget';

    protected int | string | array $columnSpan = 1;

    public static function canView(): bool
    {
        return Auth::user()?->is_admin ?? false;
    }
}
