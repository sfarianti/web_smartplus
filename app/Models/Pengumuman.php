<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahkan import ini
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory; // Gunakan HasFactory jika diperlukan
    protected $table = 'tb_pengumuman';
    protected $primaryKey = 'id_pengumuman';
    public $timestamps = false; // Jika tabel tidak memiliki kolom created_at & updated_at

    protected $fillable = [
        'judul_pengumuman',
        'tgl_pengumuman',
        'detail_pengumuman',
    ];
}