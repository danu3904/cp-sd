@extends('layouts.fe') {{-- Menggunakan layout frontend yang sama --}}

@section('title', 'Visi & Misi Sekolah') {{-- Judul untuk tab browser --}}

@section('content')

    {{-- Konten Utama Visi & Misi dalam Box --}}
    <div class="container-fluid pt-5 pb-3">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0 mt-0">Visi & Misi Sekolah</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    {{-- GAMBAR DARI LOKAL --}}
                                    {{-- PASTIKAN PATH INI SESUAI DENGAN LOKASI GAMBAR ANDA DI FOLDER PUBLIC --}}
                                    <img src="{{ asset('template_fe/img/visi-misi.png') }}"
                                         onerror="this.onerror=null;this.src='https://placehold.co/400x300/e0e0e0/555555?text=Gambar+Visi+Misi';"
                                         class="img-fluid rounded shadow-sm visi-misi-img"
                                         alt="Gambar Visi Misi Sekolah">
                                </div>
                                <div class="col-md-8">
                                    <h4 class="mb-3">Visi</h4>
                                    @if(isset($visiMisi->visi)) 
                                        <p class="visi-content-text">{!! nl2br(e($visiMisi->visi)) !!}</p>
                                    @else
                                        <p class="text-muted">Konten Visi belum tersedia.</p>
                                    @endif

                                    <h4 class="mt-4 mb-3">Misi</h4>
                                    @if(isset($visiMisi->misi))
                                        <ol class="misi-list">
                                            @php
                                                $misiItems = explode("\n", $visiMisi->misi);
                                            @endphp
                                            @foreach($misiItems as $item)
                                                @php
                                                    $cleanedItem = trim(preg_replace('/^\d+\.\s*/', '', $item));
                                                @endphp
                                                @if(!empty($cleanedItem))
                                                    <li>{!! $cleanedItem !!}</li>
                                                @endif
                                            @endforeach
                                        </ol>
                                    @else
                                        <p class="text-muted">Konten Misi belum tersedia.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('style')
    <style>
        .visi-content-text {
            font-size: 1.1rem; /* Ukuran font untuk konten visi */
        }
        .misi-list {
            list-style-type: decimal; /* Menggunakan angka untuk daftar misi */
            padding-left: 20px; /* Jarak kiri untuk daftar */
        }
        /* Style untuk teks Visi agar sejajar dengan isi poin Misi */
        .visi-content-text {
            padding-left: 20px; /* Sesuaikan nilai ini secara visual hingga sesuai keinginan Anda */
        }

        /* Style untuk daftar Misi (dari sebelumnya) */
        .misi-list {
            padding-left: 35px; /* Indentasi dasar untuk nomor poin Misi */
            margin-bottom: 0;
        }

        .misi-list li {
            list-style-position: outside;
            margin-bottom: 10px;
            padding-left: 0;
        }
        
        /* Style untuk gambar Visi & Misi */
        .visi-misi-img {
            max-width: 100%;
            width: 300px;
            height: 280px;
            display: block;
            margin: 10 auto;
            object-fit: cover;
        }

        /* Penyesuaian untuk layar yang lebih kecil */
        @media (max-width: 767.98px) { /* Untuk layar di bawah breakpoint 'md' (tablet ke bawah) */
            .visi-misi-img {
                height: 150px; /* Mengurangi tinggi gambar di layar kecil (dari 250px) */
            }
        }
    </style>
@endsection