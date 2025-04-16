<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course; 
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    // public function index()
    // {
    //     // $courses = Course::all();
    //     // $totalCourse = Course::count(); 
    //     // return view('kursus.view_course', compact('courses', 'totalCourse'));
    // $search = $request->get('search');  // Ambil parameter pencarian dari request
    // $courses = Course::where('nama_kursus', 'like', '%' . $search . '%')->get();  // Filter kursus berdasarkan nama
    
    // $totalCourse = $courses->count(); 
    // return view('kursus.view_course', compact('courses', 'totalCourse'));
    // }

    public function index(Request $request)
{
    $search = $request->get('search');  // Ambil parameter pencarian dari request
    $courses = Course::where('nama_kursus', 'like', '%' . $search . '%')->get();  // Filter kursus berdasarkan nama
    
    $totalCourse = $courses->count(); 
    return view('kursus.view_course', compact('courses', 'totalCourse'));
}


    
    public static function countCourses()
    {
        return Course::count();
    }

    public function create()
    {
        return view('kursus.create_course');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kursus' => 'required|max:100',
            'harga_kursus' => 'required|max:100',
            'foto_kursus' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'required',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_kursus')) {
            $fotoPath = $request->file('foto_kursus')->store('kursus', 'public');
        }

        Course::create([
            'nama_kursus' => $request->nama_kursus,
            'harga_kursus' => $request->harga_kursus,
            'foto_kursus' => $fotoPath,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('course.view')->with('success', 'Kursus berhasil ditambahkan!');
    }

    public function edit($id_kursus)
    {
        $course = Course::findOrFail($id_kursus);
        return view('kursus.update_course', compact('course'));
    }

    public function update(Request $request, $id_kursus)
    {
        $request->validate([
            'nama_kursus' => 'required|max:100',
            'harga_kursus' => 'required|max:100',
            'foto_kursus' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'required',
        ]);

        $course = Course::findOrFail($id_kursus);

        if ($request->hasFile('foto_kursus')) {
            if ($course->foto_kursus) {
                Storage::delete('public/' . $course->foto_kursus);
            }
            $course->foto_kursus = $request->file('foto_kursus')->store('kursus', 'public');
        }

        $course->update([
            'nama_kursus' => $request->nama_kursus,
            'harga_kursus' => $request->harga_kursus,
            'deskripsi' => $request->deskripsi,
            'foto_kursus' => $course->foto_kursus, 
        ]);

        return redirect()->route('course.view')->with('success', 'Kursus berhasil diperbarui!');
    }

    public function destroy($id_kursus)
{
    $course = Course::find($id_kursus);
    if (!$course) {
        return redirect()->route('course.view')->with('error', 'Kursus tidak ditemukan.');
    }
    if ($course->foto_kursus) {
        Storage::delete('public/' . $course->foto_kursus);
    }
    $course->delete();
    return redirect()->route('course.view')->with('success', 'Kursus berhasil dihapus!');
}
}
