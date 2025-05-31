@extends('layouts.fe')

@section('title', $chartImage->title ?? 'Struktur Organisasi')

@section('content')
<div class="container-fluid pt-5 pb-3">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        <h2 class="h4 mb-0">Struktur Organisasi</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- Kolom kiri: papan nama --}}
                            <div class="col-md-4 mb-4">
                                <img src="{{ asset('template_fe/img/struktur_organisasi.png') }} "  
                                     class="img-fluid rounded shadow-sm struktur-organisasi-img
                                     alt="Papan Nama Sekolah">
                            </div>

                            {{-- Kolom kanan: gambar struktur --}}
                            <div class="col-md-8">
                                @if($chartImage && $chartImage->image_path)
                                    <img src="{{ asset('storage/' . $chartImage->image_path) }}" 
                                         class="img-fluid rounded shadow-sm struktur-img mb-3" 
                                         alt="{{ $chartImage->title ?? 'Struktur Organisasi' }}">
                                @else
                                    <img src="https://placehold.co/800x500/e0e0e0/555555?text=Struktur+Belum+Tersedia" 
                                         class="img-fluid rounded shadow-sm mb-3" 
                                         alt="Placeholder Struktur Organisasi">
                                    <p class="text-muted">Gambar struktur organisasi belum diunggah.</p>
                                @endif

                                {{-- Keterangan jika ada --}}
                                @if($chartImage && $chartImage->description)
                                    <p class="text-muted mt-3">{{ $chartImage->description }}</p>
                                @endif
                                {{-- Penjelasan --}}
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <p class="lead text-dark">
                                            Struktur organisasi <strong>SD Negeri 05 Taman</strong> dirancang untuk mendukung efektivitas kegiatan belajar mengajar dan pengelolaan sekolah.
                                        </p>
                                        <p class="text-muted">
                                            Setiap jabatan memiliki peran yang penting dalam menunjang visi, misi, serta keberhasilan program pendidikan di sekolah.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> {{-- End card-body --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .struktur-img {
        max-width: 100%;
        height: auto;
        max-height: 500px;
        object-fit: contain;
    }

    .card-header h2, .card-header h4 {
        margin: 0;
    }

    .struktur-organisasi-img {
        max-width: 100%;
        width: 300px;
        height: 280px;
        display: block;
        margin: 10px auto;
        padding-left: 10px
        object-fit: cover;
        }
</style>
@endpush
