@extends('layouts.fe')

@section('title', 'Semua Pengumuman')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📢 Semua Pengumuman</h2>

        <form action="{{ route('announcements.all') }}" method="GET" class="d-flex align-items-center" style="gap: 0.5rem;">
            <input 
                type="text" 
                name="q" 
                value="{{ request('q') }}" 
                class="form-control form-control-sm" 
                placeholder="Cari pengumuman..."
                aria-label="Cari pengumuman"
            >

            @if(request()->filled('q'))
                <a href="{{ route('announcements.all') }}" class="btn btn-outline-secondary btn-sm" title="Hapus pencarian">&times;</a>
            @endif

            <button class="btn btn-primary btn-sm" type="submit">Cari</button>
        </form>
    </div>

    @forelse ($announcements as $announcement)
        @php
            $limit = 200; // batas ringkasan
            $content = $announcement->content;
            $shortContent = strlen($content) > $limit ? substr($content, 0, $limit) . '...' : $content;
            $dateFormatted = \Carbon\Carbon::parse($announcement->created_at)->translatedFormat('d M Y');
        @endphp

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">{{ $dateFormatted }}</h5>
            </div>
            <div class="card-body">
                <p class="card-text">{!! nl2br(e($shortContent)) !!}</p>

                @if(strlen($content) > $limit)
                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAnnouncement{{ $announcement->id }}">
                        Baca Selengkapnya
                    </a>

                    <!-- Modal -->
                    <div class="modal fade" id="modalAnnouncement{{ $announcement->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title">Pengumuman - {{ $dateFormatted }}</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="font-size: 1.5rem;">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="white-space: pre-line;">
                                    {!! e($content) !!}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <p class="text-muted">Tidak ada pengumuman tersedia.</p>
    @endforelse

    <div class="d-flex justify-content-center">
        {{ $announcements->appends(request()->only('q'))->links() }}
    </div>
</div>
@endsection
