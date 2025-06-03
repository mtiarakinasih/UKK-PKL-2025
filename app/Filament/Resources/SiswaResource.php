<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;
use Illuminate\Validation\Rule;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Support\Exceptions\Halt; 

class SiswaResource extends Resource
{
    protected static ?string $navigationLabel = 'Daftar Siswa';
    protected static ?string $pluralLabel = 'Kelola Data Siswa';
    protected static ?string $model = Siswa::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static function afterCreate($record): void
    {
        User::create([
            'name' => $record->nama,
            'email' => $record->nis . '@siswasija.com',
            'password' => Hash::make('siswasija123'),
            'role' => 'siswa',
            'related_id' => $record->id,
        ]);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama')
                ->label('Nama Lengkap')
                ->required()
                ->maxLength(255),

            TextInput::make('nis')
                ->required()
                ->maxLength(5)
                ->rule('digits_between:1,5')
                ->label('NIS')
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    $exists = Siswa::where('nis', $state)->exists();
                    if ($exists) {
                        $set('nis', null);
                        \Filament\Notifications\Notification::make()
                            ->title('NIS sudah terdaftar')
                            ->danger()
                            ->send();
                    }
                }),

            Select::make('gender')
                ->label('Jenis Kelamin')
                ->options([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ])
                ->required(),

            TextInput::make('alamat')
                ->required()
                ->label('Alamat'),

            TextInput::make('kontak')
                ->label('Kontak Telepon')
                ->required()
                ->tel()
                ->prefix('+62')
                ->afterStateUpdated(function ($state, callable $set) {
                    // Pastikan yang tersimpan di database pakai +62 di depan
                    if (str_starts_with($state, '0')) {
                        $set('kontak', '+62' . substr($state, 1));
                    } elseif (!str_starts_with($state, '+62')) {
                        // Kalau user input tanpa 0 atau +62, tambahkan +62 otomatis
                        $set('kontak', '+62' . $state);
                    }
                }),


            // TextInput::make('email')
            //     ->label('Email')
            //     ->helperText('Gunakan format: <nis>@siswasija.com')
            //     ->disabled()
            //     ->reactive()
            //     ->default(fn ($get) => $get('nis') ? $get('nis') . '@siswasija.com' : null)
            //     ->rules([
            //         'regex:/^[0-9]+@siswasija\.com$/',
            //         fn ($get, $record) => Rule::unique('siswas', 'email')->ignore($record?->id),
            //     ])
            //     ->validationMessages([
            //         'regex' => 'Email harus menggunakan domain @siswasija.com dan format <nis>@siswasija.com.',
            //         'unique' => 'Email ini sudah digunakan.',
            //     ]),

            FileUpload::make('foto')
                ->label('Foto Siswa')
                ->nullable()
                ->image()
                ->acceptedFileTypes(['image/*'])
                ->directory('siswa-fotos')
                ->disk('public')
                ->visibility('public'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('nis')->sortable()->searchable()
                    ->label('NIS'),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Jenis Kelamin')
                    ->formatStateUsing(fn ($state) => $state === 'L' ? 'Laki-laki' : 'Perempuan'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('kontak')
                    ->label('Kontak Telepon'),
                Tables\Columns\TextColumn::make('status_pkl'),
                ImageColumn::make('foto')->circular(),
                BadgeColumn::make('status_pkl')
                    ->label('Status')
                    ->formatStateUsing(fn (bool $state) => $state ? 'Terlapor' : 'Belum Terlapor')
                    ->colors([
                        'success' => fn ($state) => $state === true,
                        'danger' => fn ($state) => $state === false,
                    ])
                    ->sortable(),
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
                        Excel::import(new SiswaImport, $filePath);
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($data['file']);
                        \Filament\Notifications\Notification::make()
                            ->title('Data siswa berhasil diimpor!')
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
                   Tables\Actions\DeleteBulkAction::make()
                    ->action(function ($records, $data) {
                        $undeletedNames = [];

                        foreach ($records as $record) {
                            if ($record->pkl) {
                                $undeletedNames[] = $record->nama;
                                continue;
                            }

                            // Hapus user terkait dulu
                            $user = User::where('related_id', $record->id)
                                        ->where('role', 'siswa')
                                        ->first();

                            if ($user) {
                                $user->delete();
                            }

                            $record->delete();
                        }

                        if (count($undeletedNames)) {
                            \Filament\Notifications\Notification::make()
                                ->title('Sebagian siswa tidak bisa dihapus')
                                ->body('Siswa berikut tidak dihapus karena sedang mengikuti PKL: ' . implode(', ', $undeletedNames))
                                ->danger()
                                ->send();
                        } else {
                            \Filament\Notifications\Notification::make()
                                ->title('Berhasil menghapus semua siswa yang dipilih')
                                ->success()
                                ->send();
                        }
                    }),
                ]),
            ]);
    }

    public static function getLabel(): string
    {
        return 'Data Siswa';
    }

    public static function getPluralLabel(): string
    {
        return 'Data Siswa';
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
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
