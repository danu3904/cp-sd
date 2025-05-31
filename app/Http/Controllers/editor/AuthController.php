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
    public function index()
    {
        return view('pages.auth.login');
    }
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('editor.home'));
        } else {
            return back()->with('LoginError', 'Login Gagal');
        }

    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function updateProfile(Request $request): RedirectResponse
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'password' => 'nullable|min:6',
    ]);

    $dataChanged = false;

    if ($request->name !== $user->name) {
        $user->name = $request->name;
        $dataChanged = true;
    }

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
        $dataChanged = true;
    }

    if ($dataChanged) {
        $user->save();
        return back()->with('success', 'Profile berhasil diperbarui.');
    }

    return back()->with('info', 'Tidak ada perubahan pada data.');
}   

}
