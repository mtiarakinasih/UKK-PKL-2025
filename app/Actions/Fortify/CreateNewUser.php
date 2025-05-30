<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nis' => ['required', 'string', 'max:255', 'unique:siswas'],
            'gender' => ['required', 'string', 'in:L,P'],
            'alamat' => ['required', 'string'],
            'kontak' => ['required', 'string', 'max:20'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted'] : '',
        ])->validate();

        $siswa = Siswa::create([
            'nama' => $input['name'],
            'nis' => $input['nis'],
            'email' => $input['email'],
            'gender' => $input['gender'],
            'alamat' => $input['alamat'], 
            'kontak' => $input['kontak'],
        ]);

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => 'siswa',
            'related_id' => $siswa->id,
        ]);
    }
}