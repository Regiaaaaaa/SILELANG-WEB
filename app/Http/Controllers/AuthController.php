<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Email atau password salah');
        }

        if ($user->role !== 'admin') {
            return back()->with('error', 'Akses hanya untuk admin');
        }

        // Hapus token lama
        $user->tokens()->delete();

        // Generate token baru
        $token = $user->createToken('admin-token', ['*'], now()->addDays(30))->plainTextToken;

        // Login ke session
        Auth::login($user);

        // Kirim token via flash session ke view
        return redirect()->route('admin.login')->with([
            'token' => $token,
            'success' => 'Berhasil masuk! Mengalihkan...'
        ]);
    }

    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        Auth::logout();
        session()->forget('api_token');

        return redirect()->route('admin.login')->with('success', 'Logout berhasil');
    }
}
