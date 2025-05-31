@extends('layouts.fe') {{-- Menggunakan layout frontend yang sama --}}

@section('title', 'Sejarah Sekolah') {{-- Judul untuk tab browser --}}

@section('content')
    {{-- Konten Utama Sejarah (Gambar Kiri, Teks Kanan) dalam Box --}}
    <div class="container-fluid pt-5 pb-3">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-4"> {{-- Kolom penuh untuk membungkus card utama --}}
                    <div class="card shadow-sm h-100"> {{-- Card utama untuk konten sejarah --}}
                        <div class="card-header bg-primary text-white"> {{-- Warna header sesuai tema --}}
                            <h2 class="h4 mb-0 mt-0">Sejarah Sekolah</h2> {{-- Ubah dari H2 ke H4 untuk konsistensi, dan sesuaikan teks --}}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-4"> {{-- Tambahkan mb-4 untuk margin bawah di mobile/tablet --}}
                                    @if($sejarahContent->gambar)
                                        <img src="{{ asset('storage/' . $sejarahContent->gambar) }}" class="img-fluid rounded shadow-sm" alt="Sejarah Sekolah">
                                    @else
                                        {{-- Placeholder jika tidak ada gambar --}}
                                        <img src="https://placehold.co/400x300/e0e0e0/555555?text=Gambar+Sejarah" class="img-fluid rounded shadow-sm" alt="Placeholder Gambar Sejarah">
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    @if($sejarahContent->isi)
                                        {!! nl2br(e($sejarahContent->isi)) !!}
                                    @else
                                        <p class="text-muted">Konten sejarah belum tersedia.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BAGIAN VIDEO YOUTUBE (KECIL DI KANAN) dalam Box --}}
            <div class="row mt-5 justify-content-end"> {{-- mt-5 untuk jarak dari konten atas, justify-content-end untuk ke kanan --}}
                <div class="col-lg-6 col-md-8 col-sm-10"> {{-- Ukuran kolom video --}}
                    <div class="card shadow-sm h-100"> {{-- Card untuk video --}}
                        <div class="card-header bg-primary text-white"> {{-- Header video --}}
                            <h3 class="h4 mb-0 mt-0">Video Tentang Sekolah</h3> {{-- Ubah dari H3 ke H4 untuk konsistensi --}}
                        </div>
                        <div class="card-body">
                            <div class="embed-responsive embed-responsive-16by9 rounded"> {{-- Hapus shadow dan rounded dari sini, sudah ada di card --}}
                                <iframe
                                    class="embed-responsive-item"
                                    src="https://www.youtube.com/embed/6SSGIHUsNj4?si=xrAFJsIBxngwDjYe" {{-- PASTIKAN INI URL EMBED YOUTUBE ASLI --}}
                                    title="YouTube video player"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin"
                                    allowfullscreen>
                                </iframe>
                            </div>
                            <p class="text-center mt-3 text-muted">Cuplikan tentang sekolah kami.</p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- AKHIR BAGIAN VIDEO YOUTUBE --}}

        </div> {{-- Penutup div.container --}}
    </div> {{-- Penutup div.container-fluid pt-5 pb-3 --}}
@endsection