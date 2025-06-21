<?php

namespace App\Http\Controllers\editor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Models\User; 

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login untuk editor.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('pages.auth.login');
    }

    /**
     * Melakukan proses autentikasi (login) pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request): RedirectResponse
    {
        // Validasi input email dan password dari form login.
        // Pesan validasi kustom disertakan untuk umpan balik yang lebih baik.
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // Coba mencari pengguna berdasarkan email terlebih dahulu.
        $user = User::where('email', $request->email)->first();

        // Jika email tidak terdaftar di database
        if (!$user) {
            return back()->with('LoginError', 'Email yang Anda masukkan tidak terdaftar.')->withInput($request->only('email'));
        }

        // Jika email ditemukan, coba autentikasi dengan kredensial lengkap.
        // Jika Auth::attempt gagal pada tahap ini, berarti kata sandi yang salah.
        if (!Auth::attempt($credentials)) {
            return back()->with('LoginError', 'Kata sandi yang Anda masukkan salah.')->withInput($request->only('email'));
        }

        // Jika autentikasi berhasil
        $request->session()->regenerate(); // Regenerasi ID sesi untuk keamanan

        // Redirect pengguna ke URL yang mereka coba akses sebelumnya, atau ke dashboard editor sebagai default
        return redirect()->intended(route('editor.home'));
    }

    /**
     * Melakukan proses logout pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout(); // Logout pengguna dari sesi

        $request->session()->invalidate(); // Membatalkan sesi saat ini

        $request->session()->regenerateToken(); // Meregenerasi token CSRF untuk sesi baru

        // Redirect pengguna ke halaman login
        return redirect()->route('login');
    }

    /**
     * Memperbarui profil pengguna (nama dan/atau kata sandi).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        // Mendapatkan instance pengguna yang sedang login
        $user = Auth::user();

        // Validasi input untuk update profil
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:6',
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'password.min' => 'Kata sandi minimal harus 6 karakter.',
        ]);

        $dataChanged = false; // Flag untuk menandai apakah ada perubahan data

        // Memeriksa apakah ada perubahan pada nama
        if ($request->name !== $user->name) {
            $user->name = $request->name;
            $dataChanged = true;
        }

        // Memeriksa apakah ada kata sandi baru yang diisi dan tidak kosong
        if ($request->filled('password')) {
            // Hash password baru sebelum disimpan
            $user->password = Hash::make($request->password);
            $dataChanged = true;
        }

        // Jika ada perubahan pada nama atau password, simpan ke database
        if ($dataChanged) {
            $user->save();
            // Berikan pesan sukses jika ada perubahan
            return back()->with('success', 'Profil berhasil diperbarui.');
        }

        // Jika tidak ada perubahan yang terdeteksi
        return back()->with('info', 'Tidak ada perubahan pada data profil.');
    }
}