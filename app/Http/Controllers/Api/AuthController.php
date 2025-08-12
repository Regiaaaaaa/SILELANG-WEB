<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{


    public function userRegister(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
        'no_telepon' => 'required|string|max:20',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validasi gagal',
            'errors'  => $validator->errors(),
        ], 422);
    }

    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role'     => 'user',
        'no_telepon' => $request->no_telepon,
    ]);

    $token = $user->createToken('user-token')->plainTextToken;

    return response()->json([
        'message' => 'Registrasi berhasil',
        'token'   => $token,
        'user'    => $user,
    ]);
}

public function userLogin(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email'    => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validasi gagal',
            'errors'  => $validator->errors(),
        ], 422);
    }

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Email atau password salah'], 401);
    }

    if ($user->role !== 'user') {
        return response()->json(['message' => 'Akses hanya untuk user biasa'], 403);
    }

    $token = $user->createToken('user-token')->plainTextToken;

    return response()->json([
        'message' => 'Login user berhasil',
        'token'   => $token,
        'user'    => $user,
    ]);
}

    public function adminLogin(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email'    => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validasi gagal',
            'errors'  => $validator->errors(),
        ], 422);
    }

    $admin = User::where('email', $request->email)->first();

    if (! $admin || ! Hash::check($request->password, $admin->password)) {
        return response()->json(['message' => 'Email atau password salah'], 401);
    }

    if ($admin->role !== 'admin') {
        return response()->json(['message' => 'Akses ditolak. Hanya untuk admin.'], 403);
    }

    $token = $admin->createToken('admin-token')->plainTextToken;

    return response()->json([
        'message' => 'Login admin berhasil',
        'token'   => $token,
        'admin'   => $admin,
    ]);
}
}
