<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostsControllers extends Controller
{
    public function index()
    {
        $posts = Posts::with('user', 'likes', 'dislikes', 'comments')->get();
        return view('home', ['posts' => $posts]);
    }    

        public function show($id)
    {
        $post = Posts::findOrFail($id);
        return view('home', ['post' => $post]);
    }

    public function like($id)
    {
        $post = Posts::find($id);
        if (!$post) {
            return redirect()->route('home')->with('error', 'Posting tidak ditemukan.');
        }

        $user = Auth::user();

        if ($post->dislikes()->where('user_id', $user->id)->exists()) {
            $post->dislikes()->where('user_id', $user->id)->delete();
        }

        $post->likes()->updateOrCreate(['user_id' => $user->id]);

        return redirect()->route('home')->with('success', 'Posting disukai.');
    }

    public function dislike($id)
    {
        $post = Posts::find($id);
        if (!$post) {
            return redirect()->route('home')->with('error', 'Posting tidak ditemukan.');
        }

        $user = Auth::user();

        if ($post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->where('user_id', $user->id)->delete();
        }

        $post->dislikes()->updateOrCreate(['user_id' => $user->id]);

        return redirect()->route('home')->with('success', 'Posting tidak disukai.');
    }

    public function comment(Request $request, $id)
    {
        $request->validate(['content' => 'required|string']);
        $post = Posts::find($id);
        if (!$post) {
            return redirect()->route('home')->with('error', 'Posting tidak ditemukan.');
        }
        $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);
        return redirect()->route('home')->with('success', 'Komentar berhasil ditambahkan.');
    }    

    public function update(Request $request, string $id)
    {
        try {
            $post = Posts::find($id);
            if (!$post) {
                return redirect()->route('home')->with('error', 'Posting tidak ditemukan.');
            }

            if ($post->user_id != Auth::id()) {
                return redirect()->route('home')->with('error', 'Tindakan tidak diizinkan. Anda bukan pemilik postingan ini.');
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
            return redirect()->route('home')->with('success', 'Posting berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Terjadi kesalahan!');
        }
    }

    public function destroy(string $id)
    {
        try {
            $post = Posts::find($id);
            if (!$post) {
                return redirect()->route('home')->with('error', 'Posting tidak ditemukan.');
            }

            if ($post->user_id != Auth::id()) {
                return redirect()->route('home')->with('error', 'Tindakan tidak diizinkan. Anda bukan pemilik postingan ini.');
            }

            $storage = Storage::disk('public');
            if ($storage->exists($post->image)) {
                $storage->delete($post->image);
            }
            $post->delete();
            return redirect()->route('home')->with('success', 'Posting berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Terjadi kesalahan!');
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'caption' => 'required|string|max:255',
                'image' => 'required|image|max:2048',
            ]);

            $imagePath = $request->file('image')->store('public');
            $imageName = basename($imagePath);

            $post = new Posts();
            $post->caption = $validatedData['caption'];
            $post->image = $imageName;
            $post->user_id = Auth::id();
            $post->save();

            return redirect()->route('home')->with('success', 'Posting berhasil dibuat.');
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Terjadi kesalahan!');
        }
    }
}
