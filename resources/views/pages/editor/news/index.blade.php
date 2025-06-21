@extends('layouts.editor')

@section('title', 'Kelola Berita')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">
    <i class="fas fa-newspaper mr-2"></i> Kelola Berita Sekolah
    </h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="fas fa-exclamation-triangle"></i> Validasi Gagal:</strong>
        <ul class="mb-0 pl-3">
            @foreach ($errors->getMessages() as $field => $messages)
                @foreach ($messages as $message)
                    <li><strong>{{ ucfirst(str_replace('_', ' ', $field)) }}:</strong> {{ $message }}</li>
                @endforeach
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif


    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <div>Daftar Berita</div>
                    <form action="{{ route('editor.news.index') }}" method="GET" style="width: 300px;">
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" id="searchNewsInput" class="form-control" placeholder="Cari berita..." value="{{ request('search') }}">
                            @if(request('search'))
                                <div class="input-group-append">
                                    <a href="{{ route('editor.news.index') }}"
                                       class="btn btn-sm btn-light"
                                       title="Hapus pencarian">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            @endif
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-sm btn-light">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Gambar</th>
                                    <th>Deskripsi Singkat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($news as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($news->currentPage() - 1) * $news->perPage() }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="Gambar Berita" width="60" class="img-thumbnail">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit(strip_tags($item->description ?? ''), 50) }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-sm btn-warning text-white btn-edit-news"
                                                    data-id="{{ $item->id }}"
                                                    data-title="{{ $item->title }}"
                                                    data-description="{{ e($item->description ?? '') }}"
                                                    data-content="{{ e($item->content ?? '') }}"
                                                    data-image="{{ $item->image ? asset('storage/' . $item->image) : '' }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-news"
                                                    data-id="{{ $item->id }}"
                                                    data-title="{{ $item->title }}"
                                                    data-action="{{ route('editor.news.delete', $item->id) }}"
                                                    data-toggle="modal" data-target="#deleteNewsModal">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada berita.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($news->hasPages())
                <div class="card-footer">
                    {{ $news->withQueryString()->links('pagination::bootstrap-4') }}
                </div>
                @endif
            </div>
        </div>

        <div class="col-md-5 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white" id="form-title-news">Tambah Berita</div>
                <div class="card-body">
                    {{-- Form action akan diubah oleh JavaScript untuk mode edit --}}
                    <form id="news-form" action="{{ route('editor.news.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                        <input type="hidden" name="news_id" id="news_id_field">
                        {{-- Input _method akan ditambahkan oleh JavaScript untuk update --}}
                        
                        <div class="form-group">
                            <label for="news_title_field">Judul Berita <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="news_title_field" class="form-control @error('title') is-invalid @enderror" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="news_description_field">Deskripsi Singkat <span class="text-danger">*</span></label>
                            <textarea name="description" id="news_description_field" rows="4" class="form-control @error('description') is-invalid @enderror" required></textarea>
                            <small class="form-text text-muted">Ringkasan berita untuk tampilan daftar.</small>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="news_image_field">Gambar Berita</label>
                            <div class="custom-file">
                                <input type="file" 
                                    name="image" 
                                    id="news_image_field" 
                                    class="custom-file-input @error('image') is-invalid @enderror" 
                                    accept="image/*">
                                <label class="custom-file-label" for="news_image_field" id="news_image_label">Pilih gambar...</label>
                                <small class="form-text text-muted pl-2">
                                    Format: JPEG, JPG, PNG. Maksimal 2MB.
                                </small>
                            </div>

                            @error('image')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror

                            <div class="mt-2" id="news-image-preview-container" style="display:none;">
                                <img id="news-image-preview" src="" alt="Preview Gambar Berita" class="img-fluid rounded border" style="max-height: 150px;">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="news_content_field">Isi Berita / Konten Lengkap <span class="text-danger">*</span></label>
                            <textarea name="content" id="news_content_field" rows="10" class="form-control @error('content') is-invalid @enderror" required></textarea>
                            <small class="form-text text-muted">Detail lengkap berita.</small>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary" id="btn-submit-news"><i class="fas fa-save"></i> Simpan</button>
                            <button type="button" class="btn btn-secondary" id="btn-cancel-news" style="display:none;">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteNewsModal" tabindex="-1" role="dialog" aria-labelledby="deleteNewsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form method="POST" id="deleteNewsForm"> {{-- Action akan diisi oleh JavaScript --}}
        @csrf
        @method('DELETE') {{-- Method spoofing untuk delete --}}
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteNewsModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus berita <strong id="deleteNewsTitle"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
const defaultNewsFormAction = "{{ route('editor.news.store') }}";
const baseNewsUpdateUrl = "{{ url('editor/news') }}"; // URL dasar untuk update, tanpa ID

document.addEventListener('DOMContentLoaded', function () {

    const newsForm = document.getElementById('news-form');
    const formTitleNews = document.getElementById('form-title-news');
    const newsIdInput = document.getElementById('news_id_field');
    const newsTitleInput = document.getElementById('news_title_field');
    const newsDescriptionInput = document.getElementById('news_description_field');
    const newsContentInput = document.getElementById('news_content_field');
    const newsImageInput = document.getElementById('news_image_field');
    const newsImageLabel = document.getElementById('news_image_label');
    const newsImagePreviewContainer = document.getElementById('news-image-preview-container');
    const newsImagePreview = document.getElementById('news-image-preview');
    const btnSubmitNews = document.getElementById('btn-submit-news');
    const btnCancelNews = document.getElementById('btn-cancel-news');

    // Pengecekan elemen penting
    let allElementsFound = true;
    const elementsToCheck = {
        newsForm, formTitleNews, newsIdInput, newsTitleInput, newsDescriptionInput,
        newsContentInput, newsImageInput, newsImageLabel, newsImagePreviewContainer,
        newsImagePreview, btnSubmitNews, btnCancelNews
    };

    for (const key in elementsToCheck) {
        if (!elementsToCheck[key]) {
            console.error(`DEBUG BERITA: Elemen '${key}' (ID: ${elementsToCheck[key] ? elementsToCheck[key].id : 'ID_HTML_ASLI'}) tidak ditemukan!`);
            allElementsFound = false;
        }
    }
    if (allElementsFound) {
        console.log();
    } else {
        console.error();
    }

    // Handle tombol Edit Berita
    const editButtonsNews = document.querySelectorAll('.btn-edit-news');
    console.log(` ${editButtonsNews.length} tombol .btn-edit-news`);
    editButtonsNews.forEach(btn => {
        btn.addEventListener('click', function() {
            console.log(this.dataset.id);
            try {
                const id = this.dataset.id;
                const title = this.dataset.title;
                const description = this.dataset.description;
                const content = this.dataset.content;
                const imageUrl = this.dataset.image;

                if(formTitleNews) formTitleNews.innerText = 'Edit Berita';
                if(newsIdInput) newsIdInput.value = id; // Meskipun tidak digunakan di form action, bisa berguna
                if(newsTitleInput) newsTitleInput.value = title || '';
                if(newsDescriptionInput) newsDescriptionInput.value = description || '';
                if(newsContentInput) newsContentInput.value = content || '';

                if(newsForm) newsForm.action = `${baseNewsUpdateUrl}/${id}/update`; // Set action URL

                // Hapus _method lama jika ada, lalu tambahkan yang baru untuk PUT
                let methodInput = newsForm ? newsForm.querySelector('input[name="_method"]') : null;
                if (methodInput) methodInput.remove();
                
                if(newsForm){ // Pastikan newsForm ada sebelum appendChild
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT'; // Mengirim sebagai PUT
                    newsForm.appendChild(methodInput);
                    console.log();
                }


                if (imageUrl && imageUrl !== "{{ asset('storage/') }}" && imageUrl.trim() !== '') {
                    if(newsImagePreview) newsImagePreview.src = imageUrl;
                    if(newsImagePreviewContainer) newsImagePreviewContainer.style.display = 'block';
                    if(newsImageLabel) newsImageLabel.innerText = imageUrl.split('/').pop() || 'Pilih gambar...';
                } else {
                    if(newsImagePreview) newsImagePreview.src = '';
                    if(newsImagePreviewContainer) newsImagePreviewContainer.style.display = 'none';
                    if(newsImageLabel) newsImageLabel.innerText = 'Pilih gambar...';
                }
                if(newsImageInput) newsImageInput.value = '';

                if(btnSubmitNews) btnSubmitNews.innerHTML = '<i class="fas fa-sync-alt"></i> Update';
                if(btnCancelNews) btnCancelNews.style.display = 'inline-block';

                if(newsForm) newsForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
                console.log('DEBUG: Form Edit Berita dibuka');
            } catch (e) {
                console.error(e);
            }
        });
    });
    if(editButtonsNews.length > 0) console.log();
    else console.warn();


    // Handle tombol Cancel Berita
    if(btnCancelNews) {
        btnCancelNews.addEventListener('click', () => {
            console.log('DEBUG BERITA LOG: Tombol Cancel Berita diklik.');
            try {
                if(formTitleNews) formTitleNews.innerText = 'Tambah Berita';
                if(newsIdInput) newsIdInput.value = '';
                if(newsForm) {
                    newsForm.reset(); // Membersihkan semua input
                    newsForm.action = defaultNewsFormAction; // Kembalikan action ke store
                    const methodInput = newsForm.querySelector('input[name="_method"]');
                    if (methodInput) methodInput.remove(); // Hapus _method jika ada
                }
                if(newsImagePreview) newsImagePreview.src = '';
                if(newsImagePreviewContainer) newsImagePreviewContainer.style.display = 'none';
                if(newsImageLabel) newsImageLabel.innerText = 'Pilih gambar...';
                if(btnSubmitNews) btnSubmitNews.innerHTML = '<i class="fas fa-save"></i> Simpan';
                btnCancelNews.style.display = 'none';
            } catch (e) {
                console.error(e);
            }
        });
    } else {
        console.warn();
    }

    // Handle tombol Hapus Berita
    const deleteButtonsNews = document.querySelectorAll('.btn-delete-news');
    console.log(`DEBUG BERITA ATTACH: Ditemukan ${deleteButtonsNews.length} tombol .btn-delete-news`);
    deleteButtonsNews.forEach(button => {
        button.addEventListener('click', function () {
            console.log('DEBUG BERITA LOG: Tombol Hapus Berita diklik.');
            try {
                const title = this.dataset.title;
                const action = this.dataset.action;
                const deleteForm = document.getElementById('deleteNewsForm');
                const deleteTitle = document.getElementById('deleteNewsTitle');

                if(deleteForm) deleteForm.action = action;
                if(deleteTitle) deleteTitle.innerText = title;
            } catch (e) {
                console.error(e);
            }
        });
    });
    if(deleteButtonsNews.length > 0) console.log();
    else console.warn();


    // Preview gambar dan update label untuk Berita
    console.log();
    if(newsImageInput) {
        newsImageInput.addEventListener('change', function(event) {
            console.log();
            try {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if(newsImagePreview) newsImagePreview.src = e.target.result;
                        if(newsImagePreviewContainer) newsImagePreviewContainer.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                    if(newsImageLabel) newsImageLabel.innerText = file.name;
                } else {
                    if(newsImagePreview) newsImagePreview.src = '';
                    if(newsImagePreviewContainer) newsImagePreviewContainer.style.display = 'none';
                    if(newsImageLabel) newsImageLabel.innerText = 'Pilih gambar...';
                }
            } catch (e) {
                console.error(e);
            }
        });
        console.log();
    } else {
        console.warn();
    }
});
</script>
@endpush
