@extends('layouts.fe')

@section('content')
<div class="container-fluid px-0 px-md-5 py-5 mb-5">
    <div class="container-fluid p-0">
        <div class="row no-gutters" style="min-height: 400px;">
            <div class="container my-5">
                <div class="row g-4">
                    {{-- Kolom Informasi Sekolah --}}
                    {{-- Kolom Pengumuman --}}
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">📢 Pengumuman</h5>
                        </div>
                        <div class="card-body bg-light">
                            @forelse ($announcements->sortByDesc('created_at') as $index => $announcement)
                                @php
                                    $limit = 100;
                                    $content = $announcement->content;
                                    $shortContent = strlen($content) > $limit ? substr($content, 0, $limit) . '...' : $content;
                                    $dateFormatted = \Carbon\Carbon::parse($announcement->created_at)->translatedFormat('d M Y');
                                @endphp

                                <div class="mb-3">
                                    <div class="d-flex align-items-start">
                                        {{-- Bullet --}}
                                        <div class="text-primary" style="font-size: 1.2rem; margin-right: 8px;">•</div>

                                        {{-- Tanggal dan isi --}}
                                        <div>
                                            <div style="font-weight: bold;">{{ $dateFormatted }}</div>
                                            <div style="padding-left: 2px;">
                                                <p id="content-preview-{{ $index }}" class="mb-1">
                                                    {!! nl2br(e($shortContent)) !!}
                                                </p>

                                                @if(strlen($content) > $limit)
                                                    <div class="d-flex justify-content-end">
                                                        <button type="button" class="btn btn-link p-0" data-toggle="modal" data-target="#modalAnnouncement{{ $index }}">
                                                            Lebih Banyak
                                                        </button>
                                                    </div>

                                                    {{-- Modal Detail Pengumuman --}}
                                                    <div class="modal fade" id="modalAnnouncement{{ $index }}" tabindex="-1" aria-labelledby="modalLabel{{ $index }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                                            <div class="modal-content shadow-lg rounded">
                                                                <div class="modal-header bg-primary text-white border-0">
                                                                    <h5 class="modal-title" id="modalLabel{{ $index }}">
                                                                        📢 Pengumuman - {{ $dateFormatted }}
                                                                    </h5>
                                                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="font-size: 1.8rem;">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body" style="white-space: pre-line; font-size: 1.1rem; line-height: 1.6; color: #333;">
                                                                    {!! e($content) !!}
                                                                </div>
                                                                <div class="modal-footer border-0">
                                                                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Tutup</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">Tidak ada pengumuman terbaru.</p>
                            @endforelse
                            {{-- Tombol ke halaman semua pengumuman --}}
                                <div class="card-footer bg-light border-0 text-center">
                                    <a href="{{ route('announcements.all') }}" class="btn btn-primary btn-sm">
                                        Lihat Semua Pengumuman
                                    </a>
                                </div>
                        </div>
                    </div>
                </div>
                    {{-- end kolom pengumuman --}}

                    {{-- Kolom Informasi Sekolah --}}


                    {{-- Kolom Gambar Header --}}
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            @if (isset($heroImage) && $heroImage->image_path)
                            <div class="position-relative w-100 h-100 rounded overflow-hidden">
                                <img src="{{ asset('storage/' . $heroImage->image_path) }}" 
                                    alt="Gambar Header Sekolah"
                                    class="position-absolute w-100 h-100"
                                    style="top: 0; left: 0; object-fit: cover;">
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 bg-secondary text-white rounded">
                                <p class="text-center m-0 p-4">Belum ada gambar header diunggah.</p>
                            </div>
                        @endif

                        </div>
                    </div>

                </div> {{-- end row --}}
            </div> {{-- end container --}}
        </div> {{-- end row --}}
    </div> {{-- end container-fluid --}}
</div>

{{-- BERITA DAN KEGIATAN SECTION --}}
<div class="container-fluid pt-5">
    <div class="container pb-3">
        <div class="row">

            {{-- BAGIAN BERITA --}}
            <div class="col-lg-6 mb-4 d-flex flex-column">
                <div class="card shadow-sm h-100"> {{-- Box utama untuk bagian berita --}}
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Berita Terbaru</h3>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="news-scrollable-area flex-grow-1">
                            <div class="row">
                                @forelse($news as $newsItem)
                                    <div class="col-12 mb-3">
                                        <a href="{{ route('news.show', ['news_id' => $newsItem->id]) }}" class="text-decoration-none text-dark d-block h-100 news-item-clickable">
                                            <div class="card h-50 shadow-sm border"> {{-- Box untuk setiap item berita --}}
                                                @if($newsItem->image)
                                                    <img src="{{ asset('storage/' . $newsItem->image) }}" alt="{{ $newsItem->title }}" class="card-img-top" style="max-height: 150px; object-fit: cover;">
                                                @endif
                                                <div class="card-body d-flex flex-column">
                                                    <h5 class="card-title text-primary">{{ $newsItem->title }}</h5>
                                                    <p class="card-text mb-0 flex-grow-1">
                                                        {!! \Illuminate\Support\Str::limit(strip_tags($newsItem->content ?? $newsItem->description ?? ''), 100) !!}
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="bg-light shadow-sm rounded p-4 mb-3 text-center">
                                            <p class="mb-0 text-muted">Belum ada berita terbaru.</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        @if($news->count())
                            <div class="mt-auto pt-3 text-right">
                                <a href="{{ route('news.all') }}" class="btn btn-primary btn-sm">
                                    Semua Berita <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- BAGIAN KEGIATAN --}}
            <div class="col-lg-6 mb-4 d-flex flex-column">
                <div class="card shadow-sm h-100"> {{-- Box utama untuk bagian kegiatan --}}
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Kegiatan Sekolah</h3>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="activity-scrollable-area flex-grow-1">
                            <div class="row">
                                @forelse($activities as $activity)
                                    <div class="col-md-6 mb-4 d-flex">
                                        <a href="{{ route('activity.show', ['activity_id' => $activity->id]) }}" class="text-decoration-none text-dark d-block w-100 h-100 activity-item-clickable">
                                            <div class="card h-200 shadow-sm border"> {{-- Box untuk setiap item kegiatan --}}
                                                @if($activity->image)
                                                    <img src="{{ asset('storage/' . $activity->image) }}" class="card-img-top" alt="{{ $activity->title }}" style="height: 150px; object-fit: cover;">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center bg-light card-img-top" style="height: 150px;">
                                                        <i class="fas fa-calendar-check fa-3x text-muted"></i>
                                                    </div>
                                                @endif
                                                <div class="card-body d-flex flex-column">
                                                    <h5 class="card-title text-primary">{{ $activity->title }}</h5>
                                                    @if($activity->description)
                                                        <p class="card-text mb-0 flex-grow-1">
                                                            {{ \Illuminate\Support\Str::limit(strip_tags($activity->description), 100) }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="bg-light shadow-sm rounded p-4 mb-3 text-center">
                                            <p class="mb-0 text-muted">Belum ada kegiatan yang ditampilkan.</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        @if($activities->count())
                            <div class="mt-auto pt-3 text-right">
                                <a href="{{ route('activities.all') }}" class="btn btn-primary btn-sm">
                                    Semua Kegiatan <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- KATA SAMBUTAN --}}
<div class="container-fluid py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0">
                @if(isset($principalImage) && $principalImage->image_path)
                    <img class="img-fluid rounded" src="{{ asset('storage/' . $principalImage->image_path) }}" alt="{{ $principalImage->alt_text ?? 'Foto Kepala Sekolah' }}">
                @else
                    <img class="img-fluid rounded" src="{{ asset('template_fe/img/about-1.jpg') }}" alt="Kepala Sekolah Placeholder">
                @endif
            </div>

            <div class="col-lg-7">
                <div class="card-header bg-primary text-white">
                    <h2 class="text-black mb-1 mt-1">{{ $principalWelcome->title ?? 'Kata Sambutan Kepala Sekolah' }}</h2>
                </div>
                <div class="bg-light shadow rounded p-5 h-100">                   
                    {{-- Cek apakah ada konten kata sambutan --}}
                    @if(isset($principalWelcome) && $principalWelcome->content)
                        <div class="overflow-auto" style="max-height: 280px; text-align: justify; line-height: 1.6;">
                            {!! nl2br(e($principalWelcome->content)) !!}
                        </div>

                        <p class="font-italic text-right mt-4 mb-0">
                            Kepala Sekolah, SDN 05 Taman<br><br>
                            <strong>{{ $principalWelcome->headmaster_name ?? 'Nama Kepala Sekolah' }}</strong>
                        </p>
                    @else
                        <p style="text-align: justify;">
                            Assalamu’alaikum Warahmatullahi Wabarakatuh.<br>
                            Puji syukur kami panjatkan ke hadirat Allah SWT... [konten default]
                        </p>
                        <p class="font-italic text-right mt-4 mb-0">Kepala Sekolah,<br><strong>Nama Kepala Sekolah</strong></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid pt-5 pb-3">
    <div class="container">
        <div class="text-center pb-2">
            <p class="section-title px-5"><span class="px-2">Galeri Sekolah</span></p>
            <h1 class="mb-4">Foto Kegiatan & Prestasi</h1>
        </div>

        @if(isset($galleries) && $galleries->count() > 0)
            <div class="owl-carousel testimonial-carousel">
                @foreach($galleries as $galleryItem)
                    <div class="testimonial-item px-3">
                        <div class="position-relative overflow-hidden gallery-img-container" style="border-radius: 15px;">
                             <a href="{{ asset('storage/' . $galleryItem->foto) }}" data-lightbox="gallery" data-title="{{ $galleryItem->judul }}">
                            <img class="gallery-img"
                                 src="{{ $galleryItem->foto ? asset('storage/' . $galleryItem->foto) : asset('template_fe/img/placeholder-image.jpg') }}"
                                 alt="{{ $galleryItem->judul ?? 'Galeri Sekolah' }}">
                            </a>
                            {{-- Judul galeri --}}
                            @if($galleryItem->judul)
                                <div class="p-2 bg-light text-center gallery-caption" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                                    <small>{{ \Illuminate\Support\Str::limit($galleryItem->judul, 30, '...') }}</small> 
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-muted">Belum ada foto di galeri.</p>
        @endif
    </div>
</div>

@endsection

@push('styles')
<style>
    .news-scrollable-area, .activity-scrollable-area {
        max-height: 480px;
        overflow-y: auto;
        padding-right: 15px;
    }

    .news-item-clickable:hover, .activity-item-clickable:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .news-item-clickable, .activity-item-clickable {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .card-body.bg-light p {
        text-align: justify;
        line-height: 1.5;
    }

    .btn-link {
        font-size: 0.9rem;
    }

    @media (max-width: 576px) {
    .gallery-img {
        height: 180px;
        }
    }

    .gallery-img {
        width: 100%;
        height: 250px; /* bisa disesuaikan */
        object-fit: cover;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

</style>
@endpush
@push('scripts')
<script>
    $(document).ready(function(){
        $(".gallery-carousel").owlCarousel({ // Jika kamu menggunakan kelas .gallery-carousel
            autoplay: true,
            smartSpeed: 1000,
            margin: 25,
            loop: true,
            center: true,
            dots: false,
            nav: true,
            navText : [
                '<i class="bi-chevron-left"></i>',
                '<i class="bi-chevron-right"></i>'
            ],
            responsive: {
                0:{
                    items:1
                },
                768:{
                    items:2
                },
                992:{
                    items:3
                }
            }
        });
    });
</script>
@endpush