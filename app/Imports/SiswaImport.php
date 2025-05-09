<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $email = $row['nis'] . '@siswasija.com';

        // Cek duplikat berdasarkan NIS atau email
        if (Siswa::where('nis', $row['nis'])->orWhere('email', $email)->exists()) {
            return null;
        }

        // Validasi gender harus 'L' atau 'P'
        $gender = strtoupper(trim($row['gender']));
        if (!in_array($gender, ['L', 'P'])) {
            return null; // Skip jika gender tidak valid
        }

        return new Siswa([
            'nama'      => $row['nama'],
            'nis'       => $row['nis'],
            'alamat'    => $row['alamat'],
            'kontak'    => $row['kontak'],
            'email'     => $email,
            'gender'    => $gender,
        ]);
    }
}
