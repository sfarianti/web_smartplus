<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    use HasFactory;
    
    protected $table = 'tb_tentor';
    protected $primaryKey = 'id_tentor';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'nama_tentor',
        'password',
        'tgl_lahir',
        'pend_terakhir',
        'email',
        'hak_akses',
        'rekening',
        'awal_gabung',
        'foto_tentor',
        'akademik',
        'non_akademik'
    ];
}
