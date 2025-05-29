<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CustomLoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    public function authenticate(): void
    {
        $credentials = $this->only('email', 'password');

        $user = \App\Models\User::where('email', $this->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Email tidak ditemukan.',
            ]);
        }

        if ($user->role === 'guru' && !str_ends_with($user->email, '@gurusija.com')) {
            throw ValidationException::withMessages([
                'email' => 'Guru hanya boleh pakai email @gurusija.com',
            ]);
        }

        if ($user->role === 'siswa' && !str_ends_with($user->email, '@siswasija.com')) {
            throw ValidationException::withMessages([
                'email' => 'Siswa hanya boleh pakai email @siswasija.com',
            ]);
        }

        if (!Auth::attempt($credentials, $this->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        session()->regenerate();
    }
}
