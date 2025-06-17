<?php

namespace App\Filament\Admin\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Auth;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;

class Login extends BaseLogin
{
    /**
     * Détermine le slug (URL) de la page de login : /admin/login
     */
    public static function getSlug(): string
    {
        return 'login';
    }

    /**
     * Formulaire personnalisé de connexion.
     */
    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('email')
                ->label('Adresse email')
                ->email()
                ->required(),

            TextInput::make('password')
                ->label('Mot de passe')
                ->password()
                ->required(),
        ]);
    }

    /**
     * Authentifie l'utilisateur avec les identifiants fournis.
     */
    public function authenticate(): LoginResponse
    {
        $credentials = $this->form->getState();

        if (! Auth::attempt($credentials)) {
            $this->addError('email', 'Identifiants invalides.');
            throw new \Exception('Identifiants invalides.');
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }
}