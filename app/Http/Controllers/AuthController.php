<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('cms.dashboard');
        }
        return view('cms.login');
    }

    /**
     * Handle authentication attempt.
     */
    public function login(Request $request)
    {
        $loginInput = $request->input('login_identity');
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        
        $request->merge([$fieldType => $loginInput]);
        
        $request->validate([
            'login_identity' => ['required'],
            'password' => ['required'],
        ]);

        $credentials = [
            $fieldType => $loginInput,
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('cms.dashboard'));
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

        return redirect()->route('home');
    }
}
