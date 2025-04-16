<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumentasi;
use Illuminate\Support\Facades\Storage;
use App\Models\Jadwal;
use App\Models\Tentor;
use Carbon\Carbon;

class DokumentasiController extends Controller
{
    /**
     * Tampilkan form untuk membuat dokumentasi baru.
     */
    public function create($jadwalId)
    {
        $jadwal = Jadwal::with('kursus', 'tentor', 'mulai')->findOrFail($jadwalId);
        $jadwals = Jadwal::where('id_tentor', $jadwal->id_tentor)->get();
        $tentors = Tentor::all();
        return view('laporan.dokumentasi', compact('jadwal', 'jadwals', 'tentors'));
    }

    
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'id_jadwal' => 'nullable|exists:tb_jadwal,id_jadwal',
            'id_mulai' => 'nullable|exists:tb_mulai,id_mulai',
            'penguasaan_siswa' => 'required|string|max:100',
            'feedback_tentor' => 'required|string|max:100',
            'foto' => 'nullable|array',
            'foto.*' => 'image|mimes:jpg,jpeg,png|max:10240',
            'video' => 'nullable|mimes:mp4,wmv,mov,mkv,avi|max:204800',
        ]);

        // Menyimpan foto jika ada
        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $foto) {
                $fotoPaths[] = $foto->store('public/foto');
            }
        }

        // Menyimpan video jika ada
        $videoPath = $request->hasFile('video') ? $request->file('video')->store('public/video') : null;

        // Simpan data ke database
        Dokumentasi::create([
            'id_jadwal' => $request->id_jadwal,
            'id_mulai' => $request->id_mulai,
            // 'id_jadwal' => $request->id_jadwal ?? null,  // Menggunakan null jika tidak ada
            // 'id_mulai' => $request->id_mulai ?? null, 
            'penguasaan_siswa' => $request->penguasaan_siswa,
            'feedback_tentor' => $request->feedback_tentor,
            'foto' => json_encode($fotoPaths),  
            'video' => $videoPath,
            'waktu_akhir' => Carbon::now('Asia/Jakarta'),
        ]);

        return redirect()->route('today.course')->with('success', 'Dokumentasi berhasil disimpan!');
    }
}
