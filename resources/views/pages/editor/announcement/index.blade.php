@extends('layouts.editor')
@section('title')
    Editor - Pengumuman
@endsection
@section('content')
<div class="container">
    <h2 class="mb-4">
        <i class="fas fa-bullhorn mr-2"></i> Pengumuman Sekolah
    </h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('editor.announcement.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="content">Isi Pengumuman</label>
            <textarea name="content" id="content" rows="5" class="form-control">{{ old('content', $announcement->content ?? '') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>

    {{-- Preview Pengumuman --}}
    @if(isset($announcement) && $announcement->content)
        <div class="card mt-5">
            <div class="card-header bg-info text-white">
                Preview Pengumuman Terakhir
            </div>
            <div class="card-body">
                {!! nl2br(e($announcement->content)) !!}
            </div>
            <div class="card-footer text-muted">
                <small>Terakhir diupdate: {{ \Carbon\Carbon::parse($announcement->updated_at)->translatedFormat('d M Y H:i') }}</small>
            </div>
        </div>
    @else
        <p class="mt-4 text-muted">Belum ada pengumuman yang tersimpan.</p>
    @endif
</div>
@endsection
