<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Tentor;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use App\Models\Mulai;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal::with(['kursus', 'tentor']); 

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('kursus', function ($query) use ($search) {
                    $query->where('nama_kursus', 'like', "%{$search}%");
                })
                ->orWhere('nama_siswa', 'like', "%{$search}%")
                ->orWhere('nama_ortu', 'like', "%{$search}%");
            });
        }

        $jadwal = $query->paginate(10);  
        return view('jadwal.index', compact('jadwal'));
    }

    public function todayCourse(Request $request): View
    {
        $tentors = Tentor::all();
        $query = Jadwal::with('tentor', 'kursus')
            ->whereDate('tanggal_mulai', Carbon::today());

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('nama_ortu', 'like', "%{$search}%");
            });
        }

        if ($request->filled('id_tentor')) {
            $query->where('id_tentor', $request->input('id_tentor'));
        }

        $jadwals = $query->get();

        return view('jadwals.today', compact('jadwals', 'tentors'));
    }

    public function start(Jadwal $jadwal, Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'waktu_mulai' => 'required|date',
        ]);

        $mulai = new Mulai([
            'id_jadwal' => $jadwal->id_jadwal,
            'waktu_mulai' => Carbon::parse($request->waktu_mulai)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
            'lokasi_latitude' => $request->latitude,
            'lokasi_longitude' => $request->longitude,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        $mulai->save();

        return redirect()->route('today.course');
    }

    public function complete(Jadwal $jadwal): RedirectResponse
{
    $jadwal->load('kursus', 'tentor', 'mulai');

    if ($jadwal->mulai && !$jadwal->mulai->waktu_akhir) {
        $jadwal->mulai->update([
            'waktu_akhir' => now(),
        ]);
    }

    return redirect()->route('dokumentasi.create', [
        'jadwal' => $jadwal->id_jadwal, 
    ]);
}

public function mySchedule(Request $request)
{
    $id_tentor = session('id_tentor');

    if (!$id_tentor) {
        return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
    }

    $query = Jadwal::where('id_tentor', $id_tentor)->with('kursus', 'tentor');

    if ($request->filled('search')) {
        $search = $request->input('search');

        $query->where(function ($q) use ($search) {
            $q->where('nama_siswa', 'like', '%' . $search . '%')
              ->orWhere('nama_ortu', 'like', '%' . $search . '%');
        });
    }

    $jadwals = $query->get();

    return view('jadwals.myschedule', compact('jadwals', 'id_tentor'));
}

public function history(Request $request)
{
    $id_tentor = session('id_tentor');

    if (!$id_tentor) {
        return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
    }

    $query = Jadwal::with('mulai')
        ->where('id_tentor', $id_tentor)
        ->whereNotNull('waktu_akhir');

    // Filter berdasarkan nama siswa saja
    if ($request->filled('search')) {
        $search = $request->input('search');

        $query->where('nama_siswa', 'like', '%' . $search . '%');
    }

    $histories = $query->orderByDesc('tanggal_mulai')->get();

    return view('jadwals.history', compact('histories'));
}


    public function create()
    {
        $courses = Course::all();
        $tentors = Tentor::all();
        return view('jadwal.create', compact('courses', 'tentors'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'id_kursus' => 'required|exists:tb_kursus,id_kursus',
        'id_tentor' => 'required|exists:tb_tentor,id_tentor',
        'durasi' => 'required|integer',
        'nama_siswa' => 'required|string|max:255',
        'nama_ortu' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'telp_ortu' => 'required|string|max:20',
        'hari' => 'required|string|max:50',
        'tanggal_mulai' => 'required|date',
        'tanggal_berakhir' => 'required|date',
        'waktu_mulai' => 'nullable|date_format:H:i',
        'waktu_akhir' => 'nullable|date_format:H:i',
    ]);

    $waktuMulai = $validated['waktu_mulai']
        ? Carbon::parse($validated['tanggal_mulai'] . ' ' . $validated['waktu_mulai'])->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s')
        : null;

    $waktuAkhir = $validated['waktu_akhir']
        ? Carbon::parse($validated['tanggal_mulai'] . ' ' . $validated['waktu_akhir'])->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s')
        : null;

    Jadwal::create([
        'id_kursus' => $validated['id_kursus'],
        'id_tentor' => $validated['id_tentor'],
        'durasi' => $validated['durasi'],
        'nama_siswa' => $validated['nama_siswa'],
        'nama_ortu' => $validated['nama_ortu'],
        'alamat' => $validated['alamat'],
        'telp_ortu' => $validated['telp_ortu'],
        'hari' => $validated['hari'],
        'tanggal_mulai' => $validated['tanggal_mulai'],
        'tanggal_berakhir' => $validated['tanggal_berakhir'],
        'waktu_mulai' => $waktuMulai,
        'waktu_akhir' => $waktuAkhir,
    ]);

    return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan!');
}


public function edit($id)
{
    $jadwal = Jadwal::findOrFail($id);
    $courses = Course::all(); 
    $tentors = Tentor::all(); 
    return view('jadwal.edit', compact('jadwal', 'courses', 'tentors'));
}



public function update(Request $request, $id_jadwal)
{
    $request->validate([
        'id_kursus' => 'required',
        'id_tentor' => 'required',
        'durasi' => 'required|integer',
        'nama_siswa' => 'required|string',
        'nama_ortu' => 'required|string',
        'alamat' => 'required|string',
        'telp_ortu' => 'required|string',
        'hari' => 'required|string',
        'tanggal_mulai' => 'required|date',
        'tanggal_berakhir' => 'required|date',
        'waktu_mulai' => 'required|date_format:H:i',
        'waktu_akhir' => 'required|date_format:H:i',
    ]);

    $jadwal = Jadwal::findOrFail($id_jadwal);
    $jadwal->update([
        'id_kursus' => $request->id_kursus,
        'id_tentor' => $request->id_tentor,
        'durasi' => $request->durasi,
        'nama_siswa' => $request->nama_siswa,
        'nama_ortu' => $request->nama_ortu,
        'alamat' => $request->alamat,
        'telp_ortu' => $request->telp_ortu,
        'hari' => $request->hari,
        'tanggal_mulai' => $request->tanggal_mulai,
        'tanggal_berakhir' => $request->tanggal_berakhir,
        'waktu_mulai' => $request->waktu_mulai,
        'waktu_akhir' => $request->waktu_akhir,
    ]);

    return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diupdate');
}

public function destroy($id)
{
    $jadwal = Jadwal::findOrFail($id);
    $jadwal->delete();
    return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
}

}
