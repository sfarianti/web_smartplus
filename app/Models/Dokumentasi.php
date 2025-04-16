<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    use HasFactory;
    protected $table = 'tb_selesai';
    protected $primaryKey = 'id_selesai';
    protected $fillable = [
        'id_jadwal',
        'id_mulai',
        'penguasaan_siswa',
        'feedback_tentor',
        'foto',
        'video',
        'waktu_akhir'
    ];

    public $timestamps = false;

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    // Relasi dengan Mulai (belongsTo)
    public function mulai()
    {
        return $this->belongsTo(Mulai::class, 'id_mulai', 'id_mulai');
    }
}
