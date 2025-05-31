@extends('layouts.editor')

@section('title', 'Kelola Bagian Kata Sambutan')

@section('content')
<div class="container py-4">
        <h2 class="mb-4">
            <i class="fas fa-user-tie mr-2"></i> Kelola Kata Sambutan Kepala Sekolah
        </h2>

    {{-- Pesan Sukses untuk Gambar --}}
    @if(session('success_principal_image'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success_principal_image') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('error_principal_image'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error_principal_image') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Pesan Sukses untuk Teks Kata Sambutan --}}
    @if(session('success_principal_welcome'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success_principal_welcome') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
     @if(session('error_principal_welcome'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error_principal_welcome') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Terjadi kesalahan validasi:
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    Gambar Kepala Sekolah
                </div>
                <div class="card-body">
                    @if($principalImage && $principalImage->image_path)
                        <div class="mb-3 text-center">
                            <p>Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $principalImage->image_path) }}" alt="{{ $principalImage->alt_text ?? 'Gambar Kepala Sekolah' }}" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    @else
                        <p class="text-muted text-center">Belum ada gambar kepala sekolah yang diunggah.</p>
                    @endif

                    <form action="{{ route('editor.principal-section.image.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="principal_image">Upload Gambar Baru (akan menggantikan yang lama)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('principal_image') is-invalid @enderror" id="principal_image" name="principal_image" required>
                                <label class="custom-file-label" for="principal_image" id="principal_image_label">Pilih gambar...</label>
                                @error('principal_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alt_text">Teks Alternatif Gambar</label>
                            <input type="text" class="form-control @error('alt_text') is-invalid @enderror" id="alt_text" name="alt_text" value="{{ old('alt_text', $principalImage->alt_text ?? '') }}" placeholder="Mis: Foto Kepala Sekolah Bapak/Ibu ...">
                            @error('alt_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Upload Gambar</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    Teks Kata Sambutan
                </div>
                <div class="card-body">
                    <form action="{{ route('editor.principal-section.welcome.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="welcome_title">Judul Sambutan</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="welcome_title" name="title" value="{{ old('title', $principalWelcome->title ?? 'Kata Sambutan Kepala Sekolah') }}" required>
                             @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                         <div class="form-group">
                            <label for="headmaster_name">Nama Kepala Sekolah</label>
                            <input type="text" class="form-control @error('headmaster_name') is-invalid @enderror" id="headmaster_name" name="headmaster_name" value="{{ old('headmaster_name', $principalWelcome->headmaster_name ?? '') }}" placeholder="Nama Lengkap Kepala Sekolah">
                             @error('headmaster_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="welcome_message">Isi Kata Sambutan</label>
                            <textarea class="form-control @error('welcome_message') is-invalid @enderror" id="welcome_message" name="welcome_message" rows="10" required>{{ old('welcome_message', $principalWelcome->content ?? '') }}</textarea>
                            @error('welcome_message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-info"><i class="fas fa-save"></i> Simpan Kata Sambutan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Skrip untuk menampilkan nama file pada custom file input Bootstrap 4
    document.addEventListener('DOMContentLoaded', function() {
        const principalImageInput = document.getElementById('principal_image');
        const principalImageLabel = document.getElementById('principal_image_label');

        if (principalImageInput && principalImageLabel) {
            principalImageInput.addEventListener('change', function(e) {
                let fileName = '';
                if (this.files && this.files.length > 0) {
                    fileName = this.files[0].name;
                } else {
                    fileName = 'Pilih gambar...';
                }
                principalImageLabel.textContent = fileName;
            });
        }
    });
</script>
@endpush
