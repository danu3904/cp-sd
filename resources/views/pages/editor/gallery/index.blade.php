@extends('layouts.editor')

@section('title')
    @if ($mode === 'index')
        Kelola Galeri
    @elseif ($mode === 'create')
        Tambah Foto Galeri
    @elseif ($mode === 'edit')
        Edit Foto Galeri
    @endif
@endsection

@section('content')
<div class="container py-4">

    {{-- Mode Index --}}
    @if ($mode === 'index')
        <h2 class="mb-4 text-primary font-weight-bold">
            <i class="fas fa-camera-retro mr-2"></i> Kelola Galeri Sekolah
        </h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('editor.gallery.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle mr-1"></i> Tambah Foto Baru
            </a>
        </div>

        <div class="row">
            @forelse ($galleries as $gallery)
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card shadow-sm h-100" style="border-radius: .5rem; overflow: hidden;">
                        <img src="{{ asset('storage/' . $gallery->foto) }}" class="card-img-top" alt="{{ $gallery->judul }}" style="height: 180px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate" title="{{ $gallery->judul }}">{{ $gallery->judul }}</h5>
                            <p class="card-text text-muted small text-truncate">
                                <i class="fas fa-tag mr-1"></i> Kategori: {{ $gallery->kategori ?? '-' }}
                            </p>
                            <div class="mt-auto d-flex justify-content-between">
                                <a href="{{ route('editor.gallery.edit', $gallery->id) }}" class="btn btn-sm btn-warning" title="Edit Foto">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Tombol buka modal hapus -->
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapusModal{{ $gallery->id }}" title="Hapus Foto">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                                <!-- Modal Hapus -->
                                <div class="modal fade" id="hapusModal{{ $gallery->id }}" tabindex="-1" role="dialog" aria-labelledby="hapusLabel{{ $gallery->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="hapusLabel{{ $gallery->id }}"><i class="fas fa-exclamation-triangle mr-2"></i> Konfirmasi Hapus</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Yakin ingin menghapus <strong>{{ $gallery->judul }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('editor.gallery.destroy', $gallery->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Modal -->
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted font-italic">Belum ada foto di galeri.</p>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $galleries->links() }}
        </div>

    {{-- Mode Create --}}
    @elseif ($mode === 'create')
        <h1 class="mb-4 text-primary font-weight-bold">Tambah Foto Galeri</h1>
        <div class="card shadow-sm p-4 rounded-3 bg-light">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle mr-1"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('editor.gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="judul">Judul Foto <span class="text-danger">*</span></label>
                    <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul') }}" required maxlength="100" placeholder="Masukkan judul foto">
                </div>

                <div class="form-group">
                    <label for="kategori">Kategori Foto</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" value="{{ old('kategori') }}" maxlength="50" placeholder="Misal: Kegiatan, Prestasi, dll">
                </div>

                <div class="form-group">
                    <label for="image">Pilih Gambar (jpg, jpeg, png, webp) <span class="text-danger">*</span></label>
                    <input type="file" name="image" id="image" class="form-control-file" accept=".jpg,.jpeg,.png,.webp" required>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save mr-1"></i> Simpan
                </button>
                <a href="{{ route('editor.gallery.index') }}" class="btn btn-secondary ml-2">Batal</a>
            </form>
        </div>

    {{-- Mode Edit --}}
    @elseif ($mode === 'edit')
        <h1 class="mb-4 text-primary font-weight-bold">Edit Foto Galeri</h1>
        <div class="card shadow-sm p-4 rounded-3 bg-light">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle mr-1"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('editor.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="judul">Judul Foto <span class="text-danger">*</span></label>
                    <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul', $gallery->judul) }}" required maxlength="100" placeholder="Masukkan judul foto">
                </div>

                <div class="form-group">
                    <label for="kategori">Kategori Foto</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" value="{{ old('kategori', $gallery->kategori) }}" maxlength="50" placeholder="Misal: Kegiatan, Prestasi, dll">
                </div>

                <div class="form-group">
                    <label>Gambar Saat Ini</label><br>
                    <img src="{{ asset('storage/' . $gallery->foto) }}" alt="{{ $gallery->judul }}" class="img-thumbnail mb-3" style="max-width: 200px;">
                </div>

                <div class="form-group">
                    <label for="image">Ganti Gambar (opsional)</label>
                    <input type="file" name="image" id="image" class="form-control-file" accept=".jpg,.jpeg,.png,.webp">
                    <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
                </div>

                <div class="d-flex align-items-center mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Perbarui
                    </button>
                    <a href="{{ route('editor.gallery.index') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-times-circle mr-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    @endif
</div>

<style>
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        transition: box-shadow 0.3s ease-in-out;
    }
</style>
@endsection
