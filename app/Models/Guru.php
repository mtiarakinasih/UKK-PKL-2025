<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guru extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',   // Nama guru
        'nip',    // Nomor Induk Pegawai
        'gender', // Jenis kelamin
        'alamat', // Alamat
        'kontak', // Kontak
        'email',  // Email
        'password',//Password
    ];

    public static function rules($id = null)
    {
        return [
            'nip' => [
                'required',
                'digits_between:1,18',
                Rule::unique('guru')->ignore($id), // Menambahkan pengecualian untuk NIP saat edit
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('guru')->ignore($id), // Menambahkan pengecualian untuk email saat edit
            ],
            // Tambahkan aturan validasi lainnya sesuai kebutuhan
        ];
    }

    public function pkls()
    {
        return $this->hasMany(Pkl::class); // 1 guru membimbing banyak PKL
    }


    

}
