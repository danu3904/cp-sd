@extends('layouts.fe') {{-- Menggunakan layout frontend yang sama --}}

@section('title', 'Semua Kegiatan Sekolah') {{-- Judul untuk tab browser --}}

@section('content')
    {{-- Konten Utama Kegiatan dalam Box --}}
    <div class="container-fluid pt-5 pb-3">
        <div class="container">
            {{-- Card Utama yang membungkus semua kegiatan --}}
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex flex-wrap justify-content-between align-items-center">
                    <h4 class="mb-0 mt-0">Daftar Kegiatan Sekolah</h4>

                    {{-- Form Search --}}
                    <form action="{{ route('activities.all') }}" method="GET" class="d-flex align-items-center" style="gap: 0.5rem;">
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ request('q') }}" 
                        class="form-control form-control-sm" 
                        placeholder="Cari pengumuman..."
                        aria-label="Cari pengumuman"
                    >

                    @if(request()->filled('q'))
                        <a href="{{ route('activities.all') }}" class="btn btn-outline-secondary btn-sm" title="Hapus pencarian">&times;</a>
                    @endif

                    <button class="btn btn-primary btn-sm" type="submit">Cari</button>
                </form>
                </div>

                <div class="card-body">
                    @if(isset($allActivityItems) && $allActivityItems->count() > 0)
                        <div class="row">
                            @foreach($allActivityItems as $activityItem)
                                <div class="col-lg-4 col-md-6 mb-4">
                                    {{-- Card untuk setiap item kegiatan --}}
                                    <a href="{{ route('activity.show', ['activity_id' => $activityItem->id]) }}" class="text-decoration-none text-dark d-block h-100 activity-item-clickable">
                                        <div class="card h-100 shadow-sm border-0 rounded overflow-hidden">
                                            @if($activityItem->image)
                                                <img class="card-img-top activity-card-img" src="{{ asset('storage/' . $activityItem->image) }}" alt="{{ $activityItem->title }}">
                                            @else
                                                {{-- Placeholder jika tidak ada gambar --}}
                                                <div class="d-flex align-items-center justify-content-center bg-light activity-card-img-placeholder">
                                                    <i class="fas fa-calendar-check fa-3x text-muted"></i>
                                                </div>
                                            @endif
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title">{{ $activityItem->title }}</h5>
                                                <p class="card-text text-muted" style="font-size: 0.9em;">
                                                    <small>{{ \Carbon\Carbon::parse($activityItem->created_at)->translatedFormat('d M Y') }}</small>
                                                </p>
                                                <p class="card-text mb-4">
                                                    {!! \Illuminate\Support\Str::limit(strip_tags($activityItem->content ?? $activityItem->description ?? ''), 100) !!}
                                                </p>
                                                {{-- Tombol Baca Selengkapnya --}}
                                                <div class="mt-auto align-self-start">
                                                    <span class="btn btn-outline-primary btn-sm">Baca Selengkapnya</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{-- Menyisipkan query pencarian pada pagination --}}
                            {{ $allActivityItems->appends(['q' => request('q')])->links() }}
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            <p class="mb-0">Belum ada kegiatan yang dipublikasikan.</p>
                        </div>
                    @endif
                </div> {{-- End card-body --}}
            </div> {{-- End card --}}
        </div> {{-- End container --}}
    </div> {{-- End container-fluid --}}

    <div class="mt-5 text-center">
        <a href="{{ url('/') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Halaman Utama
        </a>
    </div>
@endsection

@push('styles')
<style>
    /* Styling untuk gambar kegiatan */
    .activity-card-img {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }

    /* Placeholder jika tidak ada gambar kegiatan */
    .activity-card-img-placeholder {
        height: 200px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }

    .card-title {
        min-height: 3em;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .card-text {
        min-height: 6em;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
    }

    .activity-item-clickable {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .activity-item-clickable:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    /* Style pagination */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }

    .page-item .page-link {
        color: #17a2b8;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        margin: 0 5px;
        transition: all 0.3s ease;
    }

    .page-item .page-link:hover {
        color: #ffffff;
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .page-item.active .page-link {
        color: #ffffff;
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }

    /* Style form search */
    .form input.form-control {
        max-width: 250px;
    }

    .form button.btn {
        min-width: 35px;
    }
</style>
@endpush
