<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function create()
    {
        if (Auth::check()) {
            return $this->redirectAuthenticatedUser();
        }

        return view('auth.login');
    }

    /**
     * Memproses login
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Cek role user
            $user = Auth::user();

            return redirect()->intended($this->dashboardRoute($user))
                ->with('success', 'Selamat datang kembali, ' . $user->nama_lengkap . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Logout user
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Anda berhasil logout. Sampai jumpa!');
    }

    protected function redirectAuthenticatedUser()
    {
        return redirect()->intended($this->dashboardRoute(Auth::user()));
    }

    protected function dashboardRoute($user)
    {
        if ($user->role == 'admin') {
            return route('admin.dashboard');
        }

        return route('user.dashboard');
    }
}