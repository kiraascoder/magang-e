<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleLoginController extends Controller
{
    public function show()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $identifier = trim($data['identifier']);

        // Cari user berdasarkan email / nbm / nim (prioritas email dulu)
        $user = User::query()
            ->where('email', $identifier)
            ->orWhere('nbm', $identifier)
            ->orWhere('nim', $identifier)
            ->first();

        if (!$user) {
            return back()->withErrors(['identifier' => 'Akun tidak ditemukan.'])->withInput();
        }

        // Login pakai email/nbm/nim yang cocok (kolom yang match)
        $field = null;
        if ($user->email === $identifier) $field = 'email';
        elseif ($user->nbm === $identifier) $field = 'nbm';
        elseif ($user->nim === $identifier) $field = 'nim';

        if (!$field) {
            return back()->withErrors(['identifier' => 'Akun tidak valid.'])->withInput();
        }

        if (!Auth::attempt([$field => $identifier, 'password' => $data['password']], $request->boolean('remember'))) {
            return back()->withErrors(['password' => 'Password salah.'])->withInput();
        }

        $request->session()->regenerate();

        return $this->redirectByRole(Auth::user()->role);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function redirectByRole(string $role)
    {
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'dosen' => redirect()->route('dosen.dashboard'),
            default => redirect()->route('mahasiswa.dashboard'),
        };
    }
}
