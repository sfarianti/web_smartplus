<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::all(); 
        return view('dashboardAdmin', compact('pengumuman'));
    }

    public function create()
    {
        return view('pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_pengumuman' => 'required',
            'tgl_pengumuman' => 'required|date',
            'detail_pengumuman' => 'required',
        ]);

        Pengumuman::create($request->all());
        return redirect()->route('dashboardAdmin')->with('success', 'Pengumuman berhasil ditambahkan');
    }

    public function edit($id)
    {
    $pengumuman = Pengumuman::findOrFail($id);
    return view('pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, $id)
    {
    $request->validate([
        'judul_pengumuman' => 'required|string|max:255',
        'detail_pengumuman' => 'required',
        'tgl_pengumuman' => 'required|date',
    ]);

    $pengumuman = Pengumuman::findOrFail($id);
    $pengumuman->update($request->all());

    return redirect()->route('dashboardAdmin')->with('success', 'Pengumuman berhasil diperbarui!');
    }

    public function destroy($id)
    {
    $pengumuman = Pengumuman::findOrFail($id);
    $pengumuman->delete();

    return redirect()->route('dashboardAdmin')->with('success', 'Pengumuman berhasil dihapus');
    }

}