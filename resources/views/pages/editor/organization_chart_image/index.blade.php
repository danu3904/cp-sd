@extends('layouts.editor') 

@section('title', 'Kelola Gambar Struktur Organisasi')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="fas fa-sitemap mr-2"></i> Kelola Struktur Organisasi</h2>

    {{-- Pesan Sukses/Error --}}
    @if(session('success'))
        <div class="alert alert-success">{!! session('success') !!}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{!! session('error') !!}</div>
    @endif

    {{-- Pesan Validasi Error --}}
    @if ($errors->any())
            <ul class="mb-0">
                @if ($errors->any())
                    <div class="alert alert-danger shadow-sm rounded-3">
                        <h5 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Terjadi Kesalahan Validasi</h5>
                        <p>Harap periksa kembali isian Anda pada kolom yang ditandai merah di bawah.</p>
                    </div>
                @endif
            </ul>
    @endif

    <div class="card shadow-sm p-4 rounded-3 bg-light">
        <form action="{{ route('editor.organization_chart_image.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="title" class="form-label fw-bold">Judul Bagan Organisasi</label>
                <input type="text" name="title" class="form-control" placeholder="Contoh: Struktur Organisasi SD Negeri 05 Taman" value="{{ old('title', $chartImage->title) }}">
                <small class="form-text text-muted">Judul ini akan tampil di halaman publik.</small>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label fw-bold">Deskripsi Singkat Bagan</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat tentang bagan ini.">{{ old('description', $chartImage->description) }}</textarea>
                <small class="form-text text-muted">Deskripsi ini juga akan tampil di halaman publik.</small>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label fw-bold">Unggah Gambar Bagan Organisasi</label>
                <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif,image/svg,image/webp" onchange="previewImage(event)">
                <small class="form-text text-muted">Hanya file gambar (JPG, PNG, GIF, SVG, WEBP). Maksimal 2MB. Gambar ini akan menggantikan gambar yang sudah ada.</small>
                                @error('image')
                    <div class="invalid-feedback d-block"> {{-- 'd-block' diperlukan karena input file tidak bisa menampilkan feedback secara default --}}
                        {{ $message }}
                    </div>
                @enderror
                <div class="mt-2">
                    @if($chartImage->image_path)
                        <p class="mb-1">Gambar saat ini:</p>
                        <img id="currentImage" src="{{ asset('storage/' . $chartImage->image_path) }}" alt="Gambar Bagan Organisasi Saat Ini" style="max-width: 300px; height: auto;" class="rounded shadow-sm border">
                    @else
                        <p class="text-muted">Belum ada gambar yang diunggah.</p>
                    @endif
                    <img id="imagePreview" src="#" alt="Preview Gambar Baru" style="display:none; max-width: 300px; height: auto;" class="rounded shadow-sm mt-2">
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Perbarui Struktur Organisasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.style.display = 'block';
            const currentImage = document.getElementById('currentImage');
            if (currentImage) { // Sembunyikan gambar saat ini jika ada
                currentImage.style.display = 'none';
            }
        };
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        } else {
            document.getElementById('imagePreview').style.display = 'none';
            const currentImage = document.getElementById('currentImage');
            if (currentImage) { // Tampilkan lagi gambar saat ini jika tidak ada preview
                currentImage.style.display = 'block';
            }
        }
    }
</script>
@endpush