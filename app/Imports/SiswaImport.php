<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class SiswaImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        $row = $row->toArray();

        $email = $row['nis'] . '@siswasija.com';

        if (Siswa::where('nis', $row['nis'])->orWhere('email', $email)->exists()) {
            return; // skip duplikat
        }

        $gender = strtoupper(trim($row['gender']));
        if (!in_array($gender, ['L', 'P'])) {
            return; // skip gender invalid
        }

        $siswa = Siswa::create([
            'nama'      => $row['nama'],
            'nis'       => $row['nis'],
            'alamat'    => $row['alamat'],
            'kontak'    => $row['kontak'],
            'email'     => $email,
            'gender'    => $gender,
        ]);

        User::create([
            'name' => $siswa->nama,
            'email' => $siswa->nis . '@siswasija.com',
            'password' => Hash::make('siswasija123'),
            'role' => 'siswa',
            'related_id' => $siswa->id,
        ]);
    }
}
