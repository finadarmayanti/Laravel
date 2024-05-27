<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileControllers extends Controller
{
    public function show()
    {
        $user = Auth::user();
        if (!$user->profile) {
            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->bio = 'not bio yet';
            $profile->save();
        }

        return view('profile', [
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            $profile = new Profile();
            $profile->user_id = $user->id;
        }

        $profile->bio = $request->bio ?? 'not bio yet';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/profiles', $filename);
            $profile->image = 'profiles/' . $filename;
        }

        $profile->save();

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Mengecek apakah profil sudah ada, jika belum, maka dibuat
        if (!$user->profile) {
            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->bio = $request->input('bio') ?? 'not bio yet';
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/profiles', $filename);
                $profile->image = 'profiles/' . $filename;
            }
            $profile->save();
        } else {
            // Jika sudah ada, lakukan update
            $profile = $user->profile;
            $profile->bio = $request->input('bio') ?? 'not bio yet';

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/profiles', $filename);
                $profile->image = 'profiles/' . $filename;
            }

            $profile->save();
        }

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function profile($userId)
    {
        $user = User::findOrFail($userId);
        
        return view('profile', ['user' => $user]);
    }
}

