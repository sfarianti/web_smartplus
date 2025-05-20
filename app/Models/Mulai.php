<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mulai extends Model
{
    use HasFactory;

    protected $table = 'tb_mulai';
    protected $primaryKey = 'id_mulai';
    public $timestamps = true;

    // Relasi ke Jadwal
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    // Relasi ke Jadwal
    public function dokumentasi()
    {
        return $this->belongsTo(Jadwal::class, 'id_selesai', 'id_selesai');
    }

    protected $fillable = [
        'id_jadwal',
        'waktu_mulai',
        'lokasi_latitude',
        'lokasi_longitude',
        'ip_address',
        'user_agent',
        
    ];
}
