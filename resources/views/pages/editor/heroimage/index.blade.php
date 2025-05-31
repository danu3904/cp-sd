@extends('layouts.editor')

@section('title', 'Hero Image')

@section('content')
<div class="container-fluid">
        <h2 class="mb-4">
            <i class="fas fa-image mr-2"></i> Kelola Gambar Header Sekolah
        </h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">

            <form action="{{ route('editor.hero-image.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Gambar yang saat ini digunakan --}}
                <div class="form-group mb-4">
                    <label for="image" class="font-weight-bold">Gambar Header Saat Ini:</label><br>

                    @if($image)
                        <img id="preview" 
                             src="{{ asset('storage/' . $image->image_path) }}" 
                             alt="Hero Image" 
                             class="img-fluid rounded mb-3 shadow-sm" 
                             style="max-width: 400px; border: 2px solid #ddd;">
                    @else
                        <p class="text-muted">Belum ada gambar diunggah.</p>
                        <img id="preview" 
                             src="#" 
                             alt="Preview" 
                             class="img-fluid rounded mb-3 shadow-sm" 
                             style="display:none; max-width: 400px; border: 2px solid #ddd;">
                    @endif
                </div>

                {{-- Input upload file baru --}}
                <div class="form-group mb-3">
                    <label for="image" class="font-weight-bold">Unggah Gambar Baru:</label>
                    <input type="file" name="image" id="image" class="form-control-file" accept="image/*" onchange="previewHeroImage(event)" required>
                    <small class="form-text text-muted mt-2">
                        Format gambar: JPG, JPEG, PNG. Maksimal ukuran file: 2MB.<br>
                        Disarankan resolusi gambar: 3000x3000px agar tampilan optimal.
                    </small>
                </div>

                <button type="submit" class="btn btn-primary btn-block mt-4">Simpan Gambar</button>
            </form>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewHeroImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';

            preview.onload = () => {
                URL.revokeObjectURL(preview.src); // Hapus URL sementara
            }
        }
    }
</script>
@endpush
