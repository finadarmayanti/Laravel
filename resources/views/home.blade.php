@extends('layouts.mainlayout')

@section('title', 'Posts')

@section('css')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="card create-post-card">
                <div class="card-body">
                    <h2 class="card-title mb-4">Buat Postingan Baru</h2>
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="caption">Caption:</label>
                            <textarea name="caption" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Gambar:</label>
                            <input type="file" name="image" class="form-control-file">
                        </div>
                        <button type="submit" class="btn btn-success">Buat Postingan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            @foreach($posts as $post)
            <div class="card post-card mb-4">
                <div class="card-body">
                    <div class="post-header d-flex align-items-center mb-3">
                        @if($post->user && $post->user->profile && $post->user->profile->image)
                            <img src="{{ asset('storage/' . $post->user->profile->image) }}" alt="Foto Profil" class="rounded-circle mr-3" width="50" height="50">
                        @else
                            <img src="{{ asset('images/siluet.jpeg') }}" alt="Foto Profil Default" class="rounded-circle mr-3" width="50" height="50">
                        @endif
                        <div>
                            <div>
                                <span>{{ optional($post->user)->name }}</span><br>
                            </div>
                            <div>
                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                    <p class="card-text">{{ $post->caption }}</p>
                    <div class="post-image-wrapper">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Foto Postingan" class="img-fluid rounded">
                    </div>
                    <div class="post-actions mt-3">
                        <form action="{{ route('posts.like', $post->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm">
                                <img src="{{ asset('images/love.png') }}" alt="Ikon Suka" class="action-icon">
                                {{ $post->likes->count() }}
                            </button>
                        </form>
                        <form action="{{ route('posts.dislike', $post->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm">
                                <img src="{{ asset('images/dislike.png') }}" alt="Ikon Tidak Suka" class="action-icon">
                                {{ $post->dislikes->count() }}
                            </button>
                        </form>
                        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-primary btn-sm">Perbarui</button>
                        </form>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn  btn-sm ml-2">
                                <img src="{{ asset('images/icon_del.png') }}" alt="Ikon Hapus" class="action-icon">
                            </button>
                        </form>
                    </div>
                    <br>

<!-- Formulir untuk membuat komentar baru -->
<form action="{{ route('posts.comment.store', $post->id) }}" method="POST">
    @csrf
    <div class="form-group">
        <textarea name="content" class="form-control" rows="2" placeholder="Tambahkan komentar"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Kirim Komentar</button>
</form>



<!-- Tampilkan komentar -->
@foreach($post->comments as $comment)
    <div class="mt-3">
        <strong>{{ optional($comment->user)->name }}</strong>
        <p>{{ $comment->content }}</p>

        <!-- Tombol untuk menampilkan form edit -->
        <button class="btn btn-secondary btn-sm ml-2" data-toggle="collapse" data-target="#editCommentForm{{ $comment->id }}">Edit</button>

        <!-- Formulir untuk memperbarui komentar -->
        <div class="collapse mt-2" id="editCommentForm{{ $comment->id }}">
            <form action="{{ route('comment.update', $comment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <textarea name="content" class="form-control" rows="2">{{ $comment->content }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Perbarui</button>
            </form>
        </div>

        <!-- Formulir untuk menghapus komentar -->
        <form action="{{ route('comment.destroy', $comment->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm ml-2">Hapus</button>
        </form>
    </div>
@endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
