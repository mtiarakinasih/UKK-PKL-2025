<?php
namespace App\Imports;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class GuruImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        $row = $row->toArray();

        $email = trim($row['email']);
        $nip = $row['nip'];

        if (!preg_match('/^[a-zA-Z0-9._%+-]+@gurusija\.com$/', $email)) {
            return;
        }

        if (Guru::where('nip', $nip)->orWhere('email', $email)->exists()) {
            return;
        }

        $gender = strtoupper(trim($row['gender']));
        if (!in_array($gender, ['L', 'P'])) {
            return;
        }

        $guru = Guru::create([
            'nama'   => $row['nama'],
            'nip'    => $nip,
            'alamat' => $row['alamat'],
            'kontak' => $row['kontak'],
            'email'  => $email,
            'gender' => $gender,
        ]);

        $username = $this->extractUsernameFromName($row['nama']);

        User::create([
            'name' => $guru->nama,
            'email' => $username . '@gurusija.com',
            'password' => Hash::make('gurusija123'),
            'role' => 'guru',
            'related_id' => $guru->id,
        ]);

    }

    private function extractUsernameFromName(string $nama): string
    {
        $namaTanpaGelar = explode(',', $nama)[0];
        $parts = preg_split('/\s+/', trim($namaTanpaGelar));

        $filtered = array_filter($parts, function ($part) {
            return !preg_match('/^[A-Z][a-z]?\.$|^[A-Z]{1,4}$/', $part);
        });

        $filtered = array_values($filtered);
        return strtolower($filtered[count($filtered) - 1] ?? 'guru');
    }
}
