<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    public function show()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_tentor'       => 'required|string|max:100',
            'password'          => 'required|min:4',
            'tanggal_lahir'     => 'required|date',
            'pendidikan_terakhir' => 'required|string',
            'email'             => 'required|email',
            'rekening'          => 'required|string',
            'awal_gabung'       => 'required|date',
            'foto_tentor'       => 'required|image|max:2048',
            'akademik'          => 'required|string',
            'non_akademik'      => 'required|string',
        ]);

        // Upload foto ke folder storage/app/public/foto_tentor
        $fotoPath = $request->file('foto_tentor')->store('foto_tentor', 'public');

        // Hash password dengan MD5
        $hashedPassword = md5($request->password);

        // Simpan data ke database
        DB::table('tb_tentor')->insert([
            'nama_tentor'   => $request->nama_tentor,
            'password'      => $hashedPassword, // Menggunakan MD5 untuk password
            'tgl_lahir'     => $request->tanggal_lahir,
            'pend_terakhir' => $request->pendidikan_terakhir,
            'email'         => $request->email,
            'rekening'      => $request->rekening,
            'hak_akses'     => $request->role,
            'awal_gabung'   => $request->awal_gabung,
            'foto_tentor'   => $fotoPath,
            'akademik'      => $request->akademik,
            'non_akademik'  => $request->non_akademik,
        ]);

        // Redirect dengan notifikasi sukses
        return redirect('/register?success=true');
    }
}