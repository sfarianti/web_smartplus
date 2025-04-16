<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditProfilController extends Controller
{
    // Menampilkan form edit profil
    public function edit()
    {
        $nama = session('nama_tentor');
        $foto = session('foto_tentor');

        // Ambil data tentor dari database berdasarkan session
        $tentor = DB::table('tb_tentor')
                    ->where('nama_tentor', $nama)
                    ->where('foto_tentor', $foto)
                    ->first();

        // Jika tidak ditemukan, redirect ke login atau tampilkan error
        if (!$tentor) {
            return redirect()->route('login')->withErrors([
                'error' => 'Data tentor tidak ditemukan. Silakan login ulang.'
            ]);
        }

        return view('editprofil', compact('tentor'));
    }

    // Proses update data profil
    public function updateProfile(Request $request)
    {
        $request->validate([
            'nama_tentor'     => 'required',
            'password'        => 'nullable', // Password tidak wajib diisi
            'akademik'        => 'required',
            'non_akademik'    => 'required',
            'rekening'        => 'required',
        ]);

        // Simpan data lama dari session
        $namaLama = session('nama_tentor');
        $fotoLama = session('foto_tentor');

        // Siapkan data untuk update
        $data = [
            'nama_tentor'     => $request->nama_tentor,
            'akademik'        => $request->akademik,
            'non_akademik'    => $request->non_akademik,
            'rekening'        => $request->rekening,
        ];

        // Hanya update password jika user mengisi
        if ($request->filled('password')) {
            $data['password'] = md5($request->password); // sesuai sistem login kamu
        }

        // Jika user upload foto baru
        if ($request->hasFile('foto_tentor')) {
            $path = $request->file('foto_tentor')->store('foto_tentor', 'public');
            $data['foto_tentor'] = $path;

            // Session akan diperbarui setelah update DB
        }

        // Update ke database berdasarkan session login lama
        DB::table('tb_tentor')
            ->where('nama_tentor', $namaLama)
            ->where('foto_tentor', $fotoLama)
            ->update($data);

        // Update session setelah update berhasil
        session(['nama_tentor' => $request->nama_tentor]);

        if (isset($data['foto_tentor'])) {
            session(['foto_tentor' => $data['foto_tentor']]);
        }

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}