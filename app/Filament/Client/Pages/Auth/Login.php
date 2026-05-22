<?php

namespace App\Filament\Client\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getEmailFormComponent(),
                        $this->getVerificationCodeFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getVerificationCodeFormComponent(): Component
    {
        return TextInput::make('verification_code')
            ->label('Kode Verifikasi')
            ->required()
            ->maxLength(20)
            ->autocomplete('off');
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email' => $data['email'],
            'password' => $data['password'],
            'verification_code' => $data['verification_code'],
        ];
    }
}
