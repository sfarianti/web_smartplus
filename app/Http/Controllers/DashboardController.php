<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\Pengumuman;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now('Asia/Jakarta');
        $todayDate = $now->toDateString();
        $tomorrowDate = $now->copy()->addDay()->toDateString();

        $hariIni = $now->translatedFormat('l'); 
        $hariBesok = $now->copy()->addDay()->translatedFormat('l'); 

        $todayCourses = Jadwal::whereDate('tanggal_mulai', '<=', $todayDate)
            ->whereDate('tanggal_berakhir', '>=', $todayDate)
            ->where(function ($query) use ($hariIni) {
                $query->where('hari', 'LIKE', "%$hariIni%");
            })->count();

        $tomorrowCourses = Jadwal::whereDate('tanggal_mulai', '<=', $tomorrowDate)
            ->whereDate('tanggal_berakhir', '>=', $tomorrowDate)
            ->where(function ($query) use ($hariBesok) {
                $query->where('hari', 'LIKE', "%$hariBesok%");
            })->count();

        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $monthlyCourses = 0;

        $allMonthly = Jadwal::whereDate('tanggal_mulai', '<=', $endOfMonth)
            ->whereDate('tanggal_berakhir', '>=', $startOfMonth)
            ->get();

        foreach ($allMonthly as $jadwal) {
            $days = explode(',', str_replace(' ', '', $jadwal->hari)); 
            $start = Carbon::parse($jadwal->tanggal_mulai);
            $end = Carbon::parse($jadwal->tanggal_berakhir);

            $periodStart = $startOfMonth->copy()->max($start); 
            $periodEnd = $endOfMonth->copy()->min($end); 

            foreach ($days as $day) {
                $englishDay = $this->convertHariToEnglish($day);
                if (!$englishDay) continue;

                $dayCarbon = Carbon::parse($periodStart)->next($englishDay);
                while ($dayCarbon->lte($periodEnd)) {
                    $monthlyCourses++;
                    $dayCarbon->addWeek();
                }
            }
        }

        // HISTORY COURSES
        $historyCourses = Jadwal::whereDate('tanggal_berakhir', '<', $todayDate)->count();
        $pengumuman = Pengumuman::orderBy('tgl_pengumuman', 'desc')->get();

        return view('dashboard', compact(
            'todayCourses',
            'tomorrowCourses',
            'monthlyCourses',
            'historyCourses',
            'pengumuman'
        ));
    }

    private function convertHariToEnglish($hariIndo)
    {
        $map = [
            'Senin' => 'Monday',
            'Selasa' => 'Tuesday',
            'Rabu' => 'Wednesday',
            'Kamis' => 'Thursday',
            'Jumat' => 'Friday',
            'Sabtu' => 'Saturday',
            'Minggu' => 'Sunday',
        ];

        return $map[$hariIndo] ?? null;
    }
}
