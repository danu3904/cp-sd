@extends('layouts.fe') {{-- Menggunakan layout frontend yang sama --}}

@section('title', $activityItem->title) {{-- Judul halaman diambil dari judul kegiatan --}}

@section('content')

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto"> {{-- Kolom konten utama --}}
                <article>
                    <h1 class="mb-3 text-primary">{{ $activityItem->title }}</h1>
                    <p class="text-muted mb-4">
                        <i class="far fa-calendar-alt mr-1"></i> Dipublikasikan pada: {{ \Carbon\Carbon::parse($activityItem->created_at)->translatedFormat('d F Y, H:i') }}
                    </p>

                    @if($activityItem->image)
                        <img src="{{ asset('storage/' . $activityItem->image) }}" alt="{{ $activityItem->title }}" class="img-fluid rounded mb-4 w-100" style="max-height: 450px; object-fit: cover;">
                    @endif

                    {{-- Menampilkan deskripsi singkat jika ada dan berbeda dari konten utama --}}
                    @if($activityItem->description)
                        <p class="lead" style="font-size: 1.1rem; margin-bottom: 1.5rem;"><em>{{ $activityItem->description }}</em></p>
                    @endif

                    {{-- Menampilkan konten utama kegiatan --}}
                    <div class="activity-content" style="line-height: 1.8;">
                        {{-- Jika kolom 'content' ada dan berisi detail lengkap --}}
                        @if($activityItem->content)
                            {!! nl2br(e($activityItem->content)) !!}
                        @elseif(!$activityItem->description) {{-- Jika tidak ada content dan tidak ada description --}}
                            <p><em>Tidak ada detail lebih lanjut untuk kegiatan ini.</em></p>
                        @endif
                    </div>
                </article>

                <hr class="my-5">

                <div class="text-center">
                    <a href="{{ route('activities.all') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar Kegiatan
                    </a>
                </div>
            </div>
            {{-- Kamu bisa menambahkan sidebar di sini jika mau (col-lg-4) untuk kegiatan terkait atau kategori --}}
        </div>
    </div>
    @endsection

@push('styles')
<style>
    .activity-content img { /* Jika ada gambar di dalam konten kegiatan */
        max-width: 100%;
        height: auto;
        border-radius: 0.25rem; /* rounded */
        margin-top: 1rem;
        margin-bottom: 1rem;
    }
</style>
@endpush
