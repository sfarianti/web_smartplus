<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Jadwal extends Model
{
    use HasFactory;
    
    protected $table = 'tb_jadwal';
    protected $primaryKey = 'id_jadwal';
    public $timestamps = false;
    
    protected $fillable = [
        'id_tentor',
        'id_kursus',
        'durasi',
        'nama_siswa',
        'nama_ortu',
        'alamat',
        'telp_ortu',
        'hari',
        'tanggal_mulai',
        'tanggal_berakhir',
        'waktu_mulai',
        'waktu_akhir',
    ];
    
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
        'waktu_mulai' => 'datetime',
        'waktu_akhir' => 'datetime',
    ];    
    
    public function tentor(): BelongsTo
    {
        return $this->belongsTo(Tentor::class, 'id_tentor', 'id_tentor');
    }
    
    public function kursus(): BelongsTo
    {
        return $this->belongsTo(Kursus::class, 'id_kursus', 'id_kursus');
    }
    
    // Scope to get today's schedules
   public function scopeToday($query)
{
    $dayName = now()->locale('id')->isoFormat('dddd'); // Contoh hasil: 'Minggu'

    return $query->whereDate('tanggal_mulai', '<=', now()->toDateString())
                ->whereDate('tanggal_berakhir', '>=', now()->toDateString())
                ->where(function($q) use ($dayName) {
                    $q->where('hari', 'like', "%$dayName%")
                      ->orWhereNull('hari');
                });
}

    public function mulai(): HasOne
    {
        return $this->hasOne(Mulai::class, 'id_jadwal', 'id_jadwal');
    }

    public function complete(Request $request)
{
    $id_jadwal = $request->input('id_jadwal');
    $id_mulai = $request->input('id_mulai');

    // Lakukan logic penyelesaian jadwal di sini
    // Redirect ke halaman dokumentasi atau simpan data

    return redirect()->route('dokumentasi.create', [
        'id_jadwal' => $id_jadwal,
        'id_mulai' => $id_mulai,
    ]);
}


    // Check if course is in progress
    public function isInProgress()
    {
        return $this->waktu_mulai !== null && $this->waktu_akhir === null;
    }
    
    // Check if course is completed
    public function isCompleted()
    {
        return $this->waktu_akhir !== null;
    }
    public function getJumlahPertemuanAttribute()
{
    $hari = $this->hari;
    $startDate = $this->tanggal_mulai;
    $endDate = $this->tanggal_berakhir;

    $dayMap = [
        'Minggu' => 0,
        'Senin' => 1,
        'Selasa' => 2,
        'Rabu' => 3,
        'Kamis' => 4,
        'Jumat' => 5,
        'Sabtu' => 6,
    ];

    $targetDay = $dayMap[$hari] ?? null;

    if (is_null($targetDay)) {
        return 0;
    }

    $start = new \DateTime($startDate);
    $end = new \DateTime($endDate);
    $end->modify('+1 day'); // agar tanggal akhir ikut dihitung

    $jumlah = 0;
    foreach (new \DatePeriod($start, new \DateInterval('P1D'), $end) as $date) {
        if ((int)$date->format('w') === $targetDay) {
            $jumlah++;
        }
    }

    return $jumlah;
}
public function selesai()
{
    return $this->hasMany(Selesai::class, 'id_jadwal');
}

public function getJumlahHadirAttribute()
{
    return $this->selesai()->count();
}

}