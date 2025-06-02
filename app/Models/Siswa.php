<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nis',
        'gender',
        'alamat',
        'kontak',
        'email',
        'password',
        'foto',
        'user_id'
    ];

    public static function rules($id = null)
    {
        return [
            'nis' => [
                'required',
                'digits_between:1,18',
                Rule::unique('siswas')->ignore($id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('siswas')->ignore($id),
            ],
        ];
    }

    protected static function booted()
    {
        static::creating(function ($siswa) {
            if (empty($siswa->email) && !empty($siswa->nis)) {
                $siswa->email = $siswa->nis . '@siswasija.com';
            }
        });

        static::updating(function ($siswa) {
            if (!empty($siswa->nis)) {
                $siswa->email = $siswa->nis . '@siswasija.com';
            }
        });
    }

    public function pkl()
    {
        return $this->hasOne(PKL::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}