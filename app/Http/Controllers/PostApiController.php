<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;

class PostApiController extends Controller
{
    public function create(Request $request)
    {
        // Lakukan validasi data
        $request->validate([
            'caption' => 'required',
            'image' => 'required',
        ]);

        // Buat posting baru
        $post = new Posts();
        $post->caption = $request->caption;
        $post->image = $request->image;
        $post->save();

        return response()->json(['message' => 'Posting berhasil dibuat'], 201);
    }
}
