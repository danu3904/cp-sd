@extends('layouts.fe')

@section('title', 'Galeri Foto Sekolah')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="card shadow-sm border-0 rounded">
            <div class="card-header bg-primary text-white rounded-top d-flex justify-content-between align-items-center flex-wrap">
                <h4 class="fw-bold fs-3 mb-0"> Galeri Foto Sekolah</h4>
                {{-- Form Search --}}
                 <form action="{{ route('galeri') }}" method="GET" class="d-flex align-items-center" style="gap: 0.5rem;">
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ request('q') }}" 
                        class="form-control form-control-sm" 
                        placeholder="Cari foto atau kegiatan..."
                        aria-label="Cari foto atau kegiatan"
                    >

                    @if(request()->filled('q'))
                        <a href="{{ route('galeri') }}" class="btn btn-outline-secondary btn-sm" title="Hapus pencarian">&times;</a>
                    @endif

                    <button class="btn btn-primary btn-sm" type="submit">Cari</button>
                </form>
                </div>

            </div>

            <div class="row g-3 px-3 py-4">
                @forelse($galleries as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card h-100 border-0 shadow-sm gallery-card">
                        <a href="{{ asset('storage/' . $item->foto) }}" data-lightbox="gallery" data-title="{{ $item->judul }}">
                            <img src="{{ asset('storage/' . $item->foto) }}" class="card-img-top rounded-top"
                                 alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
                        </a>
                            <div class="card-body p-3 text-center">
                                <p class="card-title font-weight-semibold mb-1 text-truncate" title="{{ $item->judul }}">
                                    {{ $item->judul }}
                                </p>
                                @if($item->kategori)
                                    <p class="text-muted small mb-0 text-truncate" title="{{ $item->kategori }}">
                                        <i class="fas fa-tag mr-1"></i> {{ $item->kategori }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted fst-italic">Belum ada foto yang ditambahkan.</p>
                    </div>
                @endforelse
            </div>

            @if($galleries->hasPages())
                <div class="pb-4 d-flex justify-content-center">
                    {{ $galleries->appends(['q' => request('q')])->links() }}
                </div>
            @endif
        </div>
    </div>
</section>

{{-- CSS Custom --}}
<style>
    .gallery-card {
        transition: all 0.3s ease-in-out;
    }

    .gallery-card:hover {
        transform: scale(1.02);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .card-title {
        font-size: 0.95rem;
        font-weight: 600;
    }

    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

        /* Style form search */
    .form input.form-control {
        max-width: 250px;
    }
    
    .form button.btn {
        min-width: 38px;
    }
</style>
@endsection
