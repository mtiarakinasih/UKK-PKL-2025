<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateSiswa extends CreateRecord
{
    protected static string $resource = SiswaResource::class;
    protected function afterCreate(): void
    {
        $siswa = $this->record;

        \App\Models\User::create([
            'name' => $siswa->nama,
            'email' => $siswa->nis . '@siswasija.com',
            'password' => \Illuminate\Support\Facades\Hash::make('siswasija123'),
            'role' => 'siswa',
            'related_id' => $siswa->id,
        ]);
    }
}
