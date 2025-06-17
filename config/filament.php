<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Filament Panel Providers
    |--------------------------------------------------------------------------
    |
    | Here you may register your Filament panel provider classes. These are
    | automatically discovered by default, but you may modify this if
    | needed.
    |
    */

    'panel-providers' => [
        \App\Providers\Filament\AdminPanelProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Filament Path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where Filament will be accessible from. You can
    | change it to anything you like.
    |
    */

    'path' => 'filament',

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | These are the middleware that will be applied to all Filament routes.
    |
    */

    'middleware' => [
        'web',
    ],

    /*
    |--------------------------------------------------------------------------
    | Dark mode
    |--------------------------------------------------------------------------
    |
    | By enabling this setting, your Filament admin panel will be themed
    | in dark mode by default.
    |
    */

    'dark_mode' => false,

];
