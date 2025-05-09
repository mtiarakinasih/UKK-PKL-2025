<?php

namespace App\Imports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $email = trim($row['email']);
        $nip = $row['nip'];

        // Validasi email domain harus @gurusija.com
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@gurusija\.com$/', $email)) {
            return null;
        }

        // Cek jika NIP atau email sudah ada
        if (Guru::where('nip', $nip)->orWhere('email', $email)->exists()) {
            return null;
        }

        // Validasi gender jika diperlukan
        $gender = strtoupper(trim($row['gender']));
        if (!in_array($gender, ['L', 'P'])) {
            return null;
        }

        return new Guru([
            'nama'   => $row['nama'],
            'nip'    => $nip,
            'alamat' => $row['alamat'],
            'kontak' => $row['kontak'],
            'email'  => $email,
            'gender' => $gender,
        ]);
    }
}
