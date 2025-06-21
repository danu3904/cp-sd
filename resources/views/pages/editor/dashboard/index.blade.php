@extends('layouts.editor')

@section('title')
    Editor - Dashboard
@endsection
@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Informasi Statistik -->
    <div class="row">

        <!-- Total Berita -->
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="{{ route('editor.news.index') }}" class="card-link"> 
            <div class="card border-left-primary shadow h-100 py-2 ">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Berita</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahBerita }}</div>
                        </div>
                        <div class="col-auto card-hover">
                            <i class="fas fa-newspaper fa-2x text-blue-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                <a href="{{ route('editor.activities.index') }}" class="card-link"> 
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Kegiatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahKegiatan }}</div>
                        </div>
                        <div class="col-auto card-hover">
                            <i class="fas fa-calendar-alt fa-2x text-blue-300"></i>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        </div>

        <!-- Total Galeri -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <a href="{{ route('editor.gallery.index') }}" class="card-link"> 
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Galeri Foto</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahGaleri }}</div>
                            </div>
                            <div class="col-auto card-hover">
                                <i class="fas fa-image fa-2x text-blue-300"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Pengumuman -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <a href="{{ route('editor.announcement') }}" class="card-link">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Pengumuman</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahPengumuman }}</div>
                            </div>
                            <div class="col-auto card-hover">
                                <i class="fas fa-bullhorn fa-2x text-blue-300"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Aktivitas Terbaru -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary">
                    <h6 class="m-0 font-weight-bold text-white">Berita Terbaru</h6>
                </div>
                <div class="card-body">
                    @forelse($beritaTerbaru as $berita)
                        <div class="mb-2">
                            <strong>{{ $berita->title }}</strong><br>
                            <small class="text-muted">{{ $berita->created_at->format('d M Y') }}</small>
                        </div>
                        <hr>
                    @empty
                        <p class="text-muted">Belum ada berita terbaru.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-warning">
                    <h6 class="m-0 font-weight-bold text-white">Pengumuman Aktif</h6>
                </div>
                <div class="card-body">
                    @forelse($pengumumanAktif as $pengumuman)
                        <div class="mb-2">
                            <strong>{{ Str::limit($pengumuman->content, 100, '...') }}</strong><br>
                            <small class="text-muted">{{ $pengumuman->created_at->format('d M Y') }}</small>
                        </div>
                        <hr>
                    @empty
                        <p class="text-muted">Tidak ada pengumuman aktif.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@push('styles')
    <style>
.card-link {
        text-decoration: none;
        color: inherit; /* Mewarisi warna dari parent, bukan warna link default */
    }

    .card-link:hover {
        text-decoration: none;
        color: inherit;
    }

    /* (Opsional) Efek hover agar lebih interaktif */
    .card-hover {
        transition: all 0.2s ease-in-out;
    }

    .card-link:hover .card-hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    </style>
        
@endpush