<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Filament\Forms\ValidationException;

class EditSiswa extends EditRecord
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function ($record) {
                    if ($record->pkl) {
                        Notification::make()
                            ->title('Gagal menghapus')
                            ->body('Siswa tidak bisa dihapus karena sedang mengikuti PKL.')
                            ->danger()
                            ->send();

                        throw ValidationException::withMessages([
                            'delete' => 'Siswa memiliki PKL, tidak bisa dihapus.',
                        ]);
                    }
                }),
        ];
    }
}
