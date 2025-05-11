<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PKL extends Model
{
    protected $table = 'pkls';

    protected $fillable = ['siswa_id', 'guru_id', 'industri_id', 'mulai', 'selesai'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function industri()
    {
        return $this->belongsTo(Industri::class);
    }

    protected static function booted()
    {
        static::creating(function ($pkl) {
            if (self::where('siswa_id', $pkl->siswa_id)->exists()) {
                throw new \Exception('Siswa ini sudah memiliki data PKL.');
            }
        });
    }

}
