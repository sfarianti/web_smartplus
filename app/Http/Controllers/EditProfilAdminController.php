<?PHP
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditProfilAdminController extends Controller
{
    // Menampilkan form edit profil admin
    public function edit()
    {
        $username = session('username');  // Mengambil username dari session

        // Ambil data user berdasarkan username yang ada di session
        $user = DB::table('tb_user')
                    ->where('username', $username)
                    ->first();

        // Jika tidak ditemukan, redirect ke login atau tampilkan error
        if (!$user) {
            return redirect()->route('login')->withErrors([
                'error' => 'Data user tidak ditemukan. Silakan login ulang.'
            ]);
        }

        // Mengirim data user ke view
        return view('editprofiladmin', compact('user'));
    }

    // Proses update data profil admin
    public function updateProfile(Request $request)
    {
        $request->validate([
            'username'         => 'required',
            'password'         => 'nullable', // Password tidak wajib diisi
        ]);

        // Simpan data lama dari session
        $usernameLama = session('username');

        // Siapkan data untuk update
        $data = [
            'username'         => $request->username,
        ];

        // Hanya update password jika user mengisi
        if ($request->filled('password')) {
            $data['password'] = md5($request->password); // Sesuaikan dengan sistem login MD5
        }

        // Update ke database berdasarkan session login lama
        DB::table('tb_user')
            ->where('username', $usernameLama)
            ->update($data);

        // Update session setelah update berhasil
        session(['username' => $request->username]);

        return redirect()->route('profileadmin.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}