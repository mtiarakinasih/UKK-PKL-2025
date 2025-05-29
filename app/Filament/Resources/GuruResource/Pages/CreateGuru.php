<?php
namespace App\Filament\Resources\GuruResource\Pages;

use App\Filament\Resources\GuruResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateGuru extends CreateRecord
{
    protected static string $resource = GuruResource::class;

    protected function afterCreate(): void
    {
        $guru = $this->record;

            \App\Models\User::create([
            'name' => $guru->nama,
            'email' => $guru->email,
            'password' => \Illuminate\Support\Facades\Hash::make('gurusija123'),
            'role' => 'guru',
            'related_id' => $guru->id,
        ]);
    }

}
