<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        RateLimiter::for('login', function (Request $request) {
        $email = (string) $request->email;

        return Limit::perMinute(5)->by($email . $request->ip());
        });

        Fortify::authenticateUsing(function (Request $request) {
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Email tidak ditemukan.',
            ]);
        }

        // Validasi email domain berdasarkan role
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

        // Autentikasi Laravel
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $request->remember)) {
            return Auth::user();
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password salah.',
        ]);
    });
}
}