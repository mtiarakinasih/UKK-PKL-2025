<?php

namespace App\Filament\Resources\IndustriResource\Pages;

use App\Filament\Resources\IndustriResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use App\Models\Industri;
use Illuminate\Validation\ValidationException;

class CreateIndustri extends CreateRecord
{
    protected static string $resource = IndustriResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $normalizedInput = $this->normalizeNama($data['nama']);
        $existingIndustri = Industri::all();

        foreach ($existingIndustri as $industri) {
            if (isset($data['id']) && $data['id'] == $industri->id) continue;

            $normalizedExisting = $this->normalizeNama($industri->nama);

            similar_text($normalizedInput, $normalizedExisting, $percent);

            if ($percent > 80) {
                Notification::make()
                    ->title('Nama industri terlalu mirip')
                    ->body("Nama \"{$data['nama']}\" terlalu mirip dengan \"{$industri->nama}\" yang sudah ada.")
                    ->danger()
                    ->persistent()
                    ->send();

                throw ValidationException::withMessages([
                    'nama' => "Nama \"{$data['nama']}\" terlalu mirip dengan \"{$industri->nama}\" yang sudah ada.",
                ]);
            }
        }

        return $data;
    }

    private function normalizeNama(string $nama): string
    {
        $nama = strtolower(trim($nama));
        // Hilangkan prefix seperti PT, CV, dan karakter non-alfabet
        $nama = preg_replace('/^(pt|cv|ud|pd)\s+/i', '', $nama); // Awalan
        $nama = preg_replace('/[^a-z0-9]/', '', $nama); // Karakter aneh dihapus
        return $nama;
    }
}
