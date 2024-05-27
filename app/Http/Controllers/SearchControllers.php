<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SearchControllers extends Controller
{
    public function searchUsers(Request $request)
    {
        $query = $request->get('query');
        $users = User::where('name', 'like', "%$query%")->get();

        return view('search', compact('users', 'query'));
    }
}
