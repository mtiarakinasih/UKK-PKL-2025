<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PklResource\Pages;
use App\Filament\Resources\PklResource\RelationManagers;
use App\Models\Pkl;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;


class PklResource extends Resource
{
    protected static ?string $navigationLabel = 'Daftar Terlapor PKL';
    protected static ?string $model = Pkl::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Select::make('siswa_id')
                ->label('Nama Siswa')
                ->searchable()
                ->preload()
                ->options(function ($record) {
                    $query = \App\Models\Siswa::query();

                    // Saat create: hanya tampilkan siswa yang belum punya PKL
                    // Saat edit: tetap tampilkan siswa yang sedang dipilih
                    if ($record) {
                        $query->where(function ($q) use ($record) {
                            $q->doesntHave('pkl')
                            ->orWhere('id', $record->siswa_id);
                        });
                    } else {
                        $query->doesntHave('pkl');
                    }

                    return $query->pluck('nama', 'id');
                })
                ->required()
                ->disabledOn('edit'),

            Select::make('industri_id')
                ->label('Industri')
                ->relationship('industri', 'nama')
                ->searchable()
                ->preload()
                ->required(),

            DatePicker::make('mulai')
                ->label('Mulai PKL')
                ->required(),

            DatePicker::make('selesai')
                ->label('Selesai PKL')
                ->required(),

                Select::make('guru_id')
                ->label('Guru Pembimbing')
                ->relationship('guru', 'nama')
                ->searchable()
                ->preload()
        ]);

    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('siswa.nama')
                ->label('Nama Siswa')
                ->searchable()
                ->sortable(),

            TextColumn::make('siswa.nis')
                ->label('NIS')
                ->searchable()
                ->sortable(),

            TextColumn::make('industri.nama')
                ->label('Industri')
                ->searchable()
                ->sortable(),

            TextColumn::make('guru.nama')
                ->label('Guru Pembimbing')
                ->sortable()
                ->placeholder('Belum ditentukan'),

            TextColumn::make('mulai')
                ->label('Mulai PKL')
                ->date()
                ->sortable(),

            TextColumn::make('selesai')
                ->label('Selesai PKL')
                ->date()
                ->sortable(),
        ])
        ->filters([
            // Tambahkan filter jika dibutuhkan nanti
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
        return 'Data PKL';
    }
    public static function getPluralLabel(): string
    {
        return 'Data PKL';
    }
    public static function getNavigationGroup(): ?string
    {
        return 'Program PKL'; 
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPkls::route('/'),
            'create' => Pages\CreatePkl::route('/create'),
            'edit' => Pages\EditPkl::route('/{record}/edit'),
        ];
    }
}
