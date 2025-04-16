<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Pengumuman;
use App\Models\Register;



class DashboardAdminController extends Controller
{
    public function index()
    {
        // $totalStudents = User::where('role', 'student')->count();
        $totalTeachers = Register::count();
        $totalCourses = Course::count();
        $pengumuman = Pengumuman::all();

        return view('dashboardAdmin', compact('totalCourses', 'totalTeachers','pengumuman'));
    }
}
