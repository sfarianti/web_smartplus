<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tentor extends Model
{
    use HasFactory;
    
    protected $table = 'tb_tentor';
    protected $primaryKey = 'id_tentor';
    public $timestamps = false;
    
    protected $fillable = [
        'nama_tentor',
        // Add other fields from your tentor table
    ];
    
    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'id_tentor', 'id_tentor');
    }
}