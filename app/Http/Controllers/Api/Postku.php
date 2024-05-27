<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Posts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class Postku extends Controller
{
    public function index()
    {
        $posts = Posts::with('user', 'likes', 'dislikes', 'comments')->get();
        return response()->json(['posts' => $posts]);
    }

    public function like($id)
    {
        $post = Posts::find($id);
        if (!$post) {
            return response()->json(['error' => 'Posting tidak ditemukan.'], 404);
        }
        $post->likes()->create(['user_id' => Auth::id()]);
        return response()->json(['message' => 'Posting disukai.']);
    }

    public function dislike($id)
    {
        $post = Posts::find($id);
        if (!$post) {
            return response()->json(['error' => 'Posting tidak ditemukan.'], 404);
        }
        $post->dislikes()->create(['user_id' => Auth::id()]);
        return response()->json(['message' => 'Posting tidak disukai.']);
    }

    public function comment(Request $request, $id)
    {
        $request->validate(['content' => 'required|string']);
        $post = Posts::find($id);
        if (!$post) {
            return response()->json(['error' => 'Posting tidak ditemukan.'], 404);
        }
        $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);
        return response()->json(['message' => 'Komentar berhasil ditambahkan.']);
    }

    public function update(Request $request, string $id)
    {
        try {
            $post = Posts::find($id);
            if (!$post) {
                return response()->json(['error' => 'Posting tidak ditemukan.'], 404);
            }

            if ($post->user_id != Auth::id()) {
                return response()->json(['error' => 'Tindakan tidak diizinkan. Anda bukan pemilik postingan ini.'], 403);
            }

            $post->caption = $request->caption ?? $post->caption;

            if ($request->hasFile('image')) {
                $storage = Storage::disk('public');
                if ($storage->exists($post->image)) {
                    $storage->delete($post->image);
                }
                $imageName = time() . '_' . Str::random(10) . '.' . $request->image->getClientOriginalExtension();
                $post->image = $imageName;
                $request->image->storeAs('public', $imageName);
            }

            $post->save();
            return response()->json(['message' => 'Posting berhasil diperbarui.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan!'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $post = Posts::find($id);
            if (!$post) {
                return response()->json(['error' => 'Posting tidak ditemukan.'], 404);
            }

            if ($post->user_id != Auth::id()) {
                return response()->json(['error' => 'Tindakan tidak diizinkan. Anda bukan pemilik postingan ini.'], 403);
            }

            $storage = Storage::disk('public');
            if ($storage->exists($post->image)) {
                $storage->delete($post->image);
            }
            $post->delete();
            return response()->json(['message' => 'Posting berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan!'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Lakukan validasi data yang diterima dari request
            $validatedData = $request->validate([
                'caption' => 'required|string',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Jadikan bidang 'image' opsional
            ]);
    
            // Jika bidang 'image' kosong, atur nilainya menjadi null
            $imageName = null;
            if ($request->hasFile('image')) {
                // Simpan gambar ke dalam penyimpanan
                $imageName = time() . '_' . Str::random(10) . '.' . $request->image->getClientOriginalExtension();
                $request->image->storeAs('public', $imageName);
            }
    
            // Simpan data postingan ke dalam database
            $post = new Posts();
            $post->caption = $validatedData['caption'];
            $post->image = $imageName;
            $post->user_id = Auth::id();
            $post->save();
    
            return response()->json(['message' => 'Posting berhasil dibuat.'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat membuat posting.'], 500);
        }
    }
}
