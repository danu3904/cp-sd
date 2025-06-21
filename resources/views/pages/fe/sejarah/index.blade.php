@extends('layouts.fe') 

@section('title', 'Sejarah Sekolah') 

@section('content')
    {{-- Konten Utama Sejarah dalam Box --}}
    <div class="container-fluid pt-5 pb-3">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-4"> 
                    <div class="card shadow-sm h-100"> 
                        <div class="card-header bg-primary text-white"> 
                            <h2 class="h4 mb-0 mt-0">Sejarah Sekolah</h2> 
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-4">
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
            <div class="row mt-5 justify-content-end"> 
                <div class="col-lg-6 col-md-8 col-sm-10"> 
                    <div class="card shadow-sm h-100"> 
                        <div class="card-header bg-primary text-white"> 
                            <h3 class="h4 mb-0 mt-0">Video Tentang Sekolah</h3> 
                        </div>
                        <div class="card-body">
                            <div class="embed-responsive embed-responsive-16by9 rounded"> 
                                <iframe
                                    class="embed-responsive-item"
                                    src="https://www.youtube.com/embed/6SSGIHUsNj4?si=xrAFJsIBxngwDjYe" 
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

        </div> 
    </div> 
@endsection