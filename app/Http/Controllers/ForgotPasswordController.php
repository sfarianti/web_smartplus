<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // Tampilkan form lupa password
    public function showForm()
    {
        return view('forgot-password');
    }

    // Kirim email berisi link reset password
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Cek apakah email ada di tb_tentor
        $tentor = DB::table('tb_tentor')->where('email', $request->email)->first();
        if (!$tentor) {
            return back()->withErrors(['email' => 'Email tidak terdaftar sebagai tentor.']);
        }

        // Buat token dan simpan ke password_resets
        $token = Str::random(60);
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        // Kirim email reset password
        Mail::send('reset-link', ['token' => $token, 'email' => $request->email], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password Tentor');
        });

        return back()->with('status', 'Link reset password sudah dikirim ke email Anda.');
    }

    // Tampilkan form reset password dari email
    public function showResetForm($token)
    {
        // Ambil email berdasarkan token yang diberikan
        $email = DB::table('password_resets')->where('token', $token)->first()->email;

        return view('reset-password', ['token' => $token, 'email' => $email]);
    }

    // Proses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        // Cek token di tabel password_resets
        $check = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$check) {
            return back()->withErrors(['email' => 'Token tidak valid atau email tidak cocok.']);
        }

        // Update password tentor (pakai MD5)
        DB::table('tb_tentor')
            ->where('email', $request->email)
            ->update(['password' => md5($request->password)]);

        // Hapus token
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('/login')->with('success', 'Password berhasil direset!');
    }
}