<?php

namespace App\Filament\Resources\IndustriResource\Pages;

use App\Filament\Resources\IndustriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use App\Models\Industri;
use Illuminate\Validation\ValidationException;

class EditIndustri extends EditRecord
{
    protected static string $resource = IndustriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function ($record) {
                    if ($record->pkls()->exists()) {
                        Notification::make()
                            ->title('Gagal menghapus')
                            ->body('Industri ini masih digunakan sebagai tempat PKL.')
                            ->danger()
                            ->send();

                        throw ValidationException::withMessages([
                            'delete' => 'Industri masih digunakan sebagai tempat PKL, tidak bisa dihapus.',
                        ]);
                    }
                }),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $normalize = function ($text) {
            $text = strtolower($text);
            $text = preg_replace('/[^a-z0-9]/', '', $text);
            $text = preg_replace('/\b(pt|cv|group|inc|ltd)\b/', '', $text);
            return trim($text);
        };

        $normalizedInput = $normalize($data['nama']);
        $existingIndustri = Industri::all();

        foreach ($existingIndustri as $industri) {
            // Jika ID sama, lanjutkan, jika tidak dibandingkan
            if ($data['id'] == $industri->id) continue;

            $normalizedExisting = $normalize($industri->nama);

            // Periksa kesamaan dengan threshold similarity
            similar_text($normalizedInput, $normalizedExisting, $percent);

            // Jika kesamaan lebih dari 80%, lemparkan exception untuk mencegah submit
            if ($percent > 80) {
                // Buat notifikasi yang mirip
                Notification::make()
                    ->title('Nama industri terlalu mirip')
                    ->body("Nama \"{$data['nama']}\" terlalu mirip dengan \"{$industri->nama}\" yang sudah ada.")
                    ->danger()
                    ->persistent()
                    ->send();

                // Lempar exception untuk menghentikan form submit
                throw ValidationException::withMessages([
                    'nama' => "Nama \"{$data['nama']}\" terlalu mirip dengan \"{$industri->nama}\" yang sudah ada.",
                ]);
            }
        }

        return $data;
    }
}
