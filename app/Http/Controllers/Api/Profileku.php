<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Profileku extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return response()->json([
            'name' => $user->name,
            'image' => $user->profile->image,
            'bio' => $user->profile->bio,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        $profile->bio = $request->bio;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/profiles', $filename);
            $profile->image = 'profiles/' . $filename;
        }

        $profile->save();

        return response()->json(['message' => 'Profile updated successfully']);
    }


    public function ganti_profile(Request $request)
    {
        $user = Auth::user();

        if (!$user->profile) {
            $user->profile->create([
                'bio' => $request->input('bio'),
            ]);
        } else {
            // Jika sudah ada, lakukan update
            $profile = $user->profile;
            $profile->bio = $request->input('bio');

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/profiles', $filename);
                $profile->image = 'profiles/' . $filename;
            }

            $profile->save();
        }


        return response()->json(['message' => 'Profile updated successfully']);

    }


}
