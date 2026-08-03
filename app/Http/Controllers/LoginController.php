<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('layouts.guest');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nip' => 'required|numeric',
            'password' => 'required|string',
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nip.numeric' => 'NIP harus berupa angka.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('rules.index'));
        }

        return back()->withErrors([
            'nip' => 'NIP atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
