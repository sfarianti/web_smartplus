<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function form()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $hashedPassword = md5($request->password);

        $user = DB::table('tb_user')
            ->where('username', $request->username)
            ->where('password', $hashedPassword)
            ->first();

        $tentor = DB::table('tb_tentor')
            ->where('nama_tentor', $request->username)
            ->where('password', $hashedPassword)
            ->first();

        if ($user) {
            session([
                'username' => $user->username,
                'role' => 'user'
            ]);
            return redirect()->route('dashboardAdmin')->with('success', 'Login berhasil!');
        }

        if ($tentor) {
            session([
                'id_tentor' => $tentor->id_tentor,
                'nama_tentor' => $tentor->nama_tentor,
                'foto_tentor' => $tentor->foto_tentor,
                'role' => 'tentor'
            ]);
            return redirect()->route('dashboard')->with('success', 'Login berhasil!');
        }

        return redirect()->back()->withErrors([
            'password' => 'Password atau username tidak sesuai dengan data manapun.'
        ]);
    }

    public function getUserByPassword(Request $request)
    {
        $hashedPassword = md5($request->password);

        $user = DB::table('tb_user')
            ->where('password', $hashedPassword)
            ->first();

        if ($user) {
            return response()->json([
                'username' => $user->username,
                'foto_tentor' => null
            ]);
        }

        $tentor = DB::table('tb_tentor')
            ->where('password', $hashedPassword)
            ->first();

        if ($tentor) {
            return response()->json([
                'username' => $tentor->nama_tentor,
                'foto_tentor' => $tentor->foto_tentor
            ]);
        }

        return response()->json([]);
    }
}