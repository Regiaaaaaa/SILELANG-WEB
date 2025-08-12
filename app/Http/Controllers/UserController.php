<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
   public function index()
{
    // Ambil hanya data user yang rolenya 'user'
    $users = User::where('role', 'user')->get();

    return view('users.index', compact('users'));
}

}
