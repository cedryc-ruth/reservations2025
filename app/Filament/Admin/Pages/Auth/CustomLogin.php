<?php

namespace App\Filament\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Auth;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;

class CustomLogin extends BaseLogin
{
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