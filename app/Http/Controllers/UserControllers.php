<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserControllers extends Controller
{
    public function index()
    {
        $usersList = User::all();// Mengambil semua data pengguna dari database
        return view('users', ['usersList' => $usersList]);// Mengembalikan tampilan 'users.blade.php' dan mengirimkan data pengguna ke tampilan
    }

    public function showPost()
    {
        $user = auth()->user(); // Mengambil data pengguna yang sedang terautentikasi
        return view('post', ['user' => $user]);
    }
}
