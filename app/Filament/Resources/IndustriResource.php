<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IndustriResource\Pages;
use App\Models\Industri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Grid;
use Filament\Notifications\Notification;

class IndustriResource extends Resource
{
    protected static ?string $navigationLabel = 'Daftar Industri';
    protected static ?string $model = Industri::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('nama')
                        ->label('Nama Industri')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                            // Fungsi normalisasi
                            $normalize = function ($text) {
                                // Ubah ke huruf kecil
                                $text = strtolower($text);
                                // Hapus simbol, spasi, dan angka
                                $text = preg_replace('/[^a-z0-9]/', '', $text);
                                // Hilangkan awalan seperti PT, CV, Group, dll.
                                $text = preg_replace('/\b(pt|cv|group|cv|inc|ltd)\b/', '', $text);
                                return trim($text);
                            };

                            $normalizedInput = $normalize($state);
                            $existingIndustri = Industri::all();

                            foreach ($existingIndustri as $industri) {
                                if ($get('id') == $industri->id) continue;

                                $normalizedExisting = $normalize($industri->nama);

                                // Cek kesamaan string menggunakan similar_text
                                similar_text($normalizedInput, $normalizedExisting, $percent);

                                // Jika kesamaan lebih dari 80%, beri peringatan
                                if ($percent > 80) {
                                    Notification::make()
                                        ->title('Nama industri terlalu mirip')
                                        ->body("Nama \"$state\" mirip dengan \"$industri->nama\" yang sudah ada.")
                                        ->danger()
                                        ->persistent()
                                        ->send();
                                    break;
                                }
                            }
                        }),

                    TextInput::make('bidang_usaha')
                        ->label('Bidang Usaha')
                        ->required(),

                    Textarea::make('alamat')
                        ->label('Alamat')
                        ->required()
                        ->columnSpan(2),

                    TextInput::make('kontak')
                        ->label('Kontak')
                        ->required()
                        ->tel(),

                    TextInput::make('email')
                        ->label('Email')
                        ->required()
                        ->email()
                        ->unique(ignoreRecord: true),

                    TextInput::make('website')
                        ->label('Website')
                        ->url()
                        ->nullable(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('bidang_usaha')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('alamat'),
                Tables\Columns\TextColumn::make('website'),
            ])
            ->filters([])
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
        return 'Data Industri';
    }

    public static function getPluralLabel(): string
    {
        return 'Data Industri';
    }
    public static function getNavigationGroup(): ?string
    {
        return 'Mitra PKL'; 
    }


    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIndustris::route('/'),
            'create' => Pages\CreateIndustri::route('/create'),
            'edit' => Pages\EditIndustri::route('/{record}/edit'),
        ];
    }
}
