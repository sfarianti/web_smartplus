<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kursus extends Model
{
    use HasFactory;
    
    protected $table = 'tb_kursus';
    protected $primaryKey = 'id_kursus';
    public $timestamps = false;
    
    protected $fillable = [
        'nama_kursus',
    ];
    
    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'id_kursus', 'id_kursus');
    }
}