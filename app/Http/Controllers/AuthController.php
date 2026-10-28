<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.users.index');
            }
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle login authentication by Email or NIP.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginInput = trim($credentials['login']);
        $password = $credentials['password'];
        $remember = $request->boolean('remember');

        // Check if login is email or NIP
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'nip';

        if (Auth::attempt([$fieldType => $loginInput, 'password' => $password], $remember)) {
            $request->session()->regenerate();
            session(['active_user_id' => Auth::id()]);

            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.users.index'))
                    ->with('success', "Selamat datang kembali, Administrator {$user->name}!");
            }

            return redirect()->intended(route('dashboard'))
                ->with('success', "Selamat datang, {$user->name}! Selamat bertugas.");
        }

        return back()->withErrors([
            'login' => 'NIP / Email atau kata sandi yang Anda masukkan salah.',
        ])->withInput($request->only('login'));
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}
