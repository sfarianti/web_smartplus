<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selesai extends Model
{
    use HasFactory;

    protected $table = 'tb_selesai';
    protected $primaryKey = 'id_selesai';
    public $timestamps = true;

    // Relasi ke Jadwal
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    protected $fillable = [
        'id_jadwal',
        'waktu_selesai',
        'keterangan',
    ];
}
