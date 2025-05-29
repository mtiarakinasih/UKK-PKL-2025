<?php

namespace App\Filament\Resources\GuruResource\Pages;

use App\Filament\Resources\GuruResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Filament\Forms\ValidationException;
use Filament\Support\Exceptions\Halt;

class EditGuru extends EditRecord
{
    protected static string $resource = GuruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function ($record) {
                    if ($record->pkls()->exists()) {
                        Notification::make()
                            ->title('Gagal menghapus')
                            ->body('Guru sedang membimbing PKL.')
                            ->danger()
                            ->send();

                        throw ValidationException::withMessages([
                            'delete' => 'Guru sedang membimbing PKL, tidak bisa dihapus.',
                        ]);
                    }
                }),
        ];
    }
}