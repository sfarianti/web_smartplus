<?php

namespace App\Http\Controllers;

use App\Exports\ActivitiesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Activity;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $jumlahPertemuanFilter = $request->input('jumlah_pertemuan');
        $selectedCourse = $request->input('course');

        $query = DB::table('tb_selesai')
            ->join('tb_jadwal', 'tb_selesai.id_jadwal', '=', 'tb_jadwal.id_jadwal')
            ->join('tb_kursus', 'tb_jadwal.id_kursus', '=', 'tb_kursus.id_kursus')
            ->join('tb_tentor', 'tb_jadwal.id_tentor', '=', 'tb_tentor.id_tentor')
            ->select(
                'tb_selesai.id_selesai',
                'tb_selesai.penguasaan_siswa',
                'tb_selesai.feedback_tentor',
                'tb_selesai.waktu_akhir',
                'tb_kursus.nama_kursus',
                'tb_kursus.harga_kursus',
                'tb_tentor.nama_tentor',
                'tb_jadwal.nama_siswa',
                'tb_jadwal.nama_ortu',
                'tb_jadwal.hari',
                'tb_jadwal.tanggal_mulai',
                'tb_jadwal.tanggal_berakhir'
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tb_jadwal.nama_siswa', 'like', "%{$search}%")
                  ->orWhere('tb_jadwal.nama_ortu', 'like', "%{$search}%");
            });
        }

        if ($selectedCourse) {
            $query->where('tb_kursus.nama_kursus', $selectedCourse);
        }

        $allResults = $query->get();

        // Mapping data dengan jumlah_pertemuan manual
        $mappedResults = $allResults->map(function ($item) {
            $item->jumlah_pertemuan = $this->hitungJumlahPertemuan($item->hari, $item->tanggal_mulai, $item->tanggal_berakhir);
            return $item;
        });

        if ($jumlahPertemuanFilter !== null) {
            $mappedResults = $mappedResults->filter(function ($item) use ($jumlahPertemuanFilter) {
                return $item->jumlah_pertemuan == $jumlahPertemuanFilter;
            });
        }

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pagedResults = new LengthAwarePaginator(
            $mappedResults->slice(($currentPage - 1) * $perPage, $perPage)->values(),
            $mappedResults->count(),
            $perPage,
            $currentPage
        );

        $courses = $mappedResults->pluck('nama_kursus')->unique()->values();

        return view('reports.index', [
            'activities' => $pagedResults,
            'totalActivities' => $mappedResults->count(),
            'courses' => $courses
        ]);
    }

    private function hitungJumlahPertemuan($hari, $tanggalMulai, $tanggalBerakhir)
    {
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

        if (is_null($targetDay) || !$tanggalMulai || !$tanggalBerakhir) {
            return 0;
        }

        $start = new \DateTime($tanggalMulai);
        $end = new \DateTime($tanggalBerakhir);
        $end->modify('+1 day');

        $jumlah = 0;
        foreach (new \DatePeriod($start, new \DateInterval('P1D'), $end) as $date) {
            if ((int)$date->format('w') === $targetDay) {
                $jumlah++;
            }
        }

        return $jumlah;
    }

    public function autocomplete(Request $request)
    {
        $search = $request->get('search');

        $results = DB::table('tb_jadwal')
            ->select('nama_siswa', 'nama_ortu')
            ->where('nama_siswa', 'like', "%{$search}%")
            ->orWhere('nama_ortu', 'like', "%{$search}%")
            ->limit(10)
            ->get();

        $merged = collect($results)
            ->flatMap(function ($item) {
                return [$item->nama_siswa, $item->nama_ortu];
            })
            ->unique()
            ->values();

        return response()->json($merged);
    }

    public function exportActivities()
{
    return Excel::download(new ActivitiesExport, 'activities.xlsx');
}

    private function getFilteredActivities($request)
    {
        // Placeholder jika kamu nanti pakai model Activity
        $query = Activity::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('student_name', 'like', '%' . $request->search . '%')
                  ->orWhere('parent_name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('course')) {
            $query->where('course', $request->course);
        }

        return $query->paginate(10);
    }
}
