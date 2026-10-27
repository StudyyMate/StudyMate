<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLoginForm(Request $request)
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        RegisterController::clearRegistrationSession($request);

        return view('login');
    }

    /**
     * Proses autentikasi user.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Data tidak boleh kosong.',
            'password.required' => 'Data tidak boleh kosong.',
        ]);

        $email = trim((string) $request->input('email'));
        $password = (string) $request->input('password');

        // Cek apakah akun terdaftar
        $user = User::where('email', $email)->first();
        if (!$user) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Akun belum terdaftar.',
                ]);
        }

        // Cek kecocokan password
        $remember = $request->boolean('remember');
        if (!Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'password' => 'Password salah.',
                ]);
        }

        $request->session()->regenerate();

        return redirect()->intended('/dashboard')->with('success', 'Selamat datang kembali!');
    }

    /**
     * Logout user dan bersihkan session.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('info', 'Anda berhasil keluar.');
    }
}
