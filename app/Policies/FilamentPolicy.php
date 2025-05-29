<?php

namespace App\Policies;

use App\Models\User;

class FilamentPolicy
{
    public function view(User $user): bool
    {
        // Cek user role harus 'admin'
        return $user->role === 'admin';
    }
}
