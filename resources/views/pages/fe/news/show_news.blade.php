@extends('layouts.fe') {{-- Menggunakan layout frontend yang sama --}}

@section('title', $newsItem->title) {{-- Judul halaman diambil dari judul berita --}}

@section('content')

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto"> {{-- Kolom konten utama --}}
                <article>
                    <h1 class="mb-3 text-primary">{{ $newsItem->title }}</h1>
                    <p class="text-muted mb-4">
                        <i class="far fa-calendar-alt mr-1"></i> Dipublikasikan pada: {{ \Carbon\Carbon::parse($newsItem->created_at)->translatedFormat('d F Y, H:i') }}
                    </p>

                    @if($newsItem->image)
                        <img src="{{ asset('storage/' . $newsItem->image) }}" alt="{{ $newsItem->title }}" class="img-fluid rounded mb-4 w-100" style="max-height: 450px; object-fit: cover;">
                    @endif

                    <div class="news-content" style="line-height: 1.8;">
                        {!! nl2br(e($newsItem->content)) !!} {{-- Menampilkan konten berita, nl2br untuk baris baru, e() untuk escaping --}}
                    </div>
                </article>

                <hr class="my-5">

                <div class="text-center">
                    <a href="{{ route('news.all') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar Berita
                    </a>
                </div>
            </div>
            {{-- Kamu bisa menambahkan sidebar di sini jika mau (col-lg-4) untuk berita terkait atau kategori --}}
        </div>
    </div>
    @endsection

@push('styles')
<style>
    .news-content img { /* Jika ada gambar di dalam konten berita */
        max-width: 100%;
        height: auto;
        border-radius: 0.25rem; /* rounded */
        margin-top: 1rem;
        margin-bottom: 1rem;
    }
</style>
@endpush