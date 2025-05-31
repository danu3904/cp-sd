@extends('layouts.editor')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">
        <i class="fas fa-address-book me-2"></i> Edit Sejarah Sekolah
    </h1>

    <form action="{{ route('editor.sejarah.update', $sejarah->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">

                {{-- Textarea Isi Sejarah --}}
                <div class="mb-4">
                    <label for="isi" class="form-label fw-semibold">Isi Sejarah Sekolah</label>
                    <textarea name="isi" id="isi" class="form-control" rows="7" placeholder="Tuliskan sejarah sekolah...">{{ old('isi', $sejarah->isi) }}</textarea>
                </div>

                {{-- Upload Gambar --}}
                <div class="mb-4">
                    <label for="gambar" class="form-label fw-semibold">Upload Gambar (opsional)</label>
                    @if($sejarah->gambar)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $sejarah->gambar) }}" width="200" class="img-thumbnail">
                        </div>
                    @endif
                    <input type="file" name="gambar" id="gambar" class="form-control">
                    <small class="text-muted">Format gambar disarankan: JPG, PNG. Maks. 2MB.</small>
                </div>

                {{-- Tombol Simpan --}}
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
