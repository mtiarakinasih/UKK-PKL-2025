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
        $nip = str_replace(' ', '', $row['nip']);

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

        $kontak = preg_replace('/[^0-9]/', '', $row['kontak']);
        if (str_starts_with($kontak, '0')) {
            $kontak = '+62' . substr($kontak, 1);
        } elseif (!str_starts_with($kontak, '62')) {
            $kontak = '+62' . $kontak;
        } else {
            $kontak = '+' . $kontak;
        }

        $guru = Guru::create([
            'nama'   => $row['nama'],
            'nip'    => $nip,
            'alamat' => $row['alamat'],
            'kontak' => $kontak,
            'email'  => $email,
            'gender' => $gender,
        ]);

        User::create([
            'name' => $guru->nama,
            'email' => $email,
            'password' => Hash::make('gurusija123'),
            'role' => 'guru',
            'related_id' => $guru->id,
        ]);
    }
}
