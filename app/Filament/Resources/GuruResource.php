<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuruResource\Pages;
use App\Models\Guru;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GuruImport;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;

class GuruResource extends Resource
{
    protected static ?string $navigationLabel = 'Daftar Guru';
    protected static ?string $title = 'Kelola Data Guru';
    protected static ?string $model = Guru::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama')
                ->label('Nama Lengkap')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('nip')
                ->required()
                ->maxLength(18)
                ->rules(fn ($record) => [
                    'digits_between:1,18',
                    Rule::unique('gurus', 'nip')->ignore($record?->id),
                ])
                ->label('NIP'),

            Forms\Components\Select::make('gender')
                ->label('Jenis Kelamin')
                ->options([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ])
                ->required(),

            Forms\Components\TextInput::make('alamat')
                ->required()
                ->label('Alamat'),

            Forms\Components\TextInput::make('kontak')
                ->required()
                ->label('Kontak Telepon')
                ->tel(),

            Forms\Components\TextInput::make('email')
                ->required()
                ->label('Email')
                ->helperText('Gunakan format: <nama>@gurusija.com')
                ->rules(fn ($record) => [
                    'regex:/^[a-zA-Z0-9._%+-]+@gurusija\.com$/',
                    Rule::unique('gurus', 'email')->ignore($record?->id),
                ])
                ->validationMessages([
                    'regex' => 'Email harus menggunakan domain @gurusija.com dan format <nama>@gurusija.com.',
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('nip')->sortable(),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('email')->searchable(),
            ])
            ->headerActions([
                Action::make('Import CSV')
                    ->form([
                        FileUpload::make('file')
                            ->label('Pilih CSV')
                            ->acceptedFileTypes(['text/csv', 'text/plain', 'application/vnd.ms-excel'])
                            ->disk('public')
                            ->directory('uploads')
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $filePath = storage_path('app/public/' . $data['file']);
                        Excel::import(new GuruImport, $filePath);

                        Storage::disk('public')->delete($data['file']);

                        Notification::make()
                            ->title('Data guru berhasil diimpor!')
                            ->success()
                            ->send();
                    })
                    ->label('Import CSV'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getLabel(): string
    {
        return 'Data Guru';
    }

    public static function getPluralLabel(): string
    {
        return 'Data Guru';
    }
    public static function getNavigationGroup(): ?string
    {
        return 'Sumber Daya Manusia'; 
    }


    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGurus::route('/'),
            'create' => Pages\CreateGuru::route('/create'),
            'edit' => Pages\EditGuru::route('/{record}/edit'),
        ];
    }
}
