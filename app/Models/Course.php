<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    
    protected $table = 'tb_kursus';
    protected $primaryKey = 'id_kursus';

    public $timestamps = false;

    protected $fillable = [
        'nama_kursus',
        'harga_kursus',
        'foto_kursus',
        'deskripsi',
    ];
}
