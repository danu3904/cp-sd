@extends('layouts.editor')

@section('content')
<div class="container">
    <h1 class="mb-4">
    <i class="fas fa-hands-helping"></i> Edit Visi & Misi
    </h1>

    @if(session('success'))
        <div class="alert alert-success">{!! session('success') !!}</div>
    @endif
    <div class="card shadow-sm p-4 rounded-3 bg-ligh">
        <form action="{{ route('editor.visimisi.update', $data->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Visi</label>
                <textarea name="visi" class="form-control" rows="4">{{ old('visi', $data->visi) }}</textarea>
            </div>
            <div class="form-group mt-3">
                <label>Misi</label>
                <textarea name="misi" class="form-control" rows="6">{{ old('misi', $data->misi) }}</textarea>
            </div>
            <button class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>
</div>
@endsection
