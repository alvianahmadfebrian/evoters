<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the public voter login form.
     */
    public function showUserLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    /**
     * Show the public voter registration form.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    /**
     * Handle public voter registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.unique' => 'Nama/Username sudah terdaftar. Silakan gunakan nama lain.',
            'email.unique' => 'Email ini sudah terdaftar. Silakan login atau gunakan email lain.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('home'))->with('success', 'Akun berhasil dibuat! Selamat datang di eVoters.');
    }

    /**
     * Show the admin login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('cms.dashboard');
            }
            return redirect()->route('home');
        }
        return view('cms.login');
    }

    /**
     * Handle authentication attempt (Supports both voter & admin).
     */
    public function login(Request $request)
    {
        $loginInput = $request->input('login_identity');
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        
        $request->merge([$fieldType => $loginInput]);
        
        $request->validate([
            'login_identity' => ['required'],
            'password' => ['required'],
        ], [
            'login_identity.required' => 'Email atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = [
            $fieldType => $loginInput,
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // If login was initiated from CMS login page
            if ($request->is('cms-admin/*')) {
                if ($user->isAdmin()) {
                    return redirect()->intended(route('cms.dashboard'));
                } else {
                    Auth::logout();
                    return back()->withErrors([
                        'login_identity' => 'Akses ditolak. Akun ini tidak memiliki hak akses administrator.',
                    ])->onlyInput('login_identity');
                }
            }

            // Normal voter login
            if ($user->isAdmin()) {
                return redirect()->intended(route('cms.dashboard'));
            }

            return redirect()->intended(route('home'))->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return back()->withErrors([
            'login_identity' => 'Email/Username atau password salah.',
        ])->onlyInput('login_identity');
    }

    /**
     * Handle logging out.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah berhasil keluar.');
    }
}
