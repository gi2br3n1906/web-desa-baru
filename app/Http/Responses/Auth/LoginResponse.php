<?php

namespace App\Http\Responses\Auth;

use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        return Filament::auth()->user()?->role === 'umkm'
            ? redirect()->route('accounting')
            : redirect()->intended(Filament::getUrl());
    }
}
