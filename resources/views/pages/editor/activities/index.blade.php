@extends('layouts.editor')

@section('title', 'Kelola Kegiatan')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">
    <i class="fas fa-tasks mr-2"></i> Kelola Kegiatan Sekolah
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
            <ul class="mb-0 pl-3">
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
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <div>Daftar Kegiatan</div>
                    <form action="{{ route('editor.activities.index') }}" method="GET" style="width: 300px;">
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" id="searchActivityInput" class="form-control" placeholder="Cari kegiatan..." value="{{ request('search') }}">
                            @if(request('search'))
                                <div class="input-group-append">
                                    <a href="{{ route('editor.activities.index') }}"
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
                                @forelse($activities as $activity)
                                <tr>
                                    <td>{{ $loop->iteration + ($activities->currentPage() - 1) * $activities->perPage() }}</td>
                                    <td>{{ $activity->title }}</td>
                                    <td>
                                        @if($activity->image)
                                            <img src="{{ asset('storage/' . $activity->image) }}" alt="Gambar Kegiatan" width="60" class="img-thumbnail">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit(strip_tags($activity->description ?? ''), 18) }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-sm btn-warning text-white btn-edit-activity"
                                                    data-id="{{ $activity->id }}"
                                                    data-title="{{ $activity->title }}"
                                                    data-description="{{ e($activity->description ?? '') }}"
                                                    data-content="{{ e($activity->content ?? '') }}"
                                                    data-image="{{ $activity->image ? asset('storage/' . $activity->image) : '' }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-activity"
                                                    data-id="{{ $activity->id }}"
                                                    data-title="{{ $activity->title }}"
                                                    data-action="{{ route('editor.activities.delete', $activity->id) }}"
                                                    data-toggle="modal" data-target="#deleteActivityModal">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada kegiatan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($activities->hasPages())
                <div class="card-footer">
                    {{ $activities->withQueryString()->links('pagination::bootstrap-4') }}
                </div>
                @endif
            </div>
        </div>

        <div class="col-md-5 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white" id="form-title-activity">Tambah Kegiatan</div>
                <div class="card-body">
                    <form id="activity-form" action="{{ route('editor.activities.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="activity_id" id="activity_id_field">
                        {{-- _method untuk update akan ditambahkan oleh JavaScript --}}
                        
                        <div class="form-group">
                            <label for="activity_title_field">Judul Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="activity_title_field" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="activity_description_field">Deskripsi Singkat <span class="text-danger">*</span></label>
                            <textarea name="description" id="activity_description_field" rows="4" class="form-control" required></textarea>
                            <small class="form-text text-muted">Deskripsi singkat untuk kegiatan (maks. 150-200 karakter disarankan).</small>
                        </div>

                        <div class="form-group">
                            <label for="activity_image_field">Gambar Kegiatan</label>
                            <div class="custom-file">
                                <input type="file" name="image" id="activity_image_field" class="custom-file-input" accept="image/*">
                                <label class="custom-file-label" for="activity_image_field" id="activity_image_label">Pilih gambar...</label>
                            </div>
                            <div class="mt-2" id="activity-image-preview-container" style="display:none;">
                                <img id="activity-image-preview" src="" alt="Preview Gambar Kegiatan" class="img-fluid rounded border" style="max-height: 150px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="activity_content_field">Konten Lengkap (Opsional)</label>
                            <textarea name="content" id="activity_content_field" rows="10" class="form-control"></textarea>
                            <small class="form-text text-muted">Detail lengkap kegiatan jika diperlukan.</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary" id="btn-submit-activity"><i class="fas fa-save"></i> Simpan</button>
                            <button type="button" class="btn btn-secondary" id="btn-cancel-activity" style="display:none;">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteActivityModal" tabindex="-1" role="dialog" aria-labelledby="deleteActivityModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form method="POST" id="deleteActivityForm"> {{-- Action akan diisi oleh JavaScript --}}
        @csrf
        @method('DELETE') {{-- Method spoofing untuk delete --}}
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteActivityModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus kegiatan <strong id="deleteActivityTitle"></strong>?</p>
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
// Vanilla JS untuk Kelola Kegiatan
// Pastikan Bootstrap 4 JS (bundle atau terpisah dengan Popper.js) sudah dimuat untuk fungsionalitas modal.

const defaultActivityFormAction = "{{ route('editor.activities.store') }}";
const baseActivityUpdateUrl = "{{ url('editor/activities') }}";

document.addEventListener('DOMContentLoaded', function () {
    const activityForm = document.getElementById('activity-form');
    const formTitleActivity = document.getElementById('form-title-activity');
    const activityIdInput = document.getElementById('activity_id_field');
    const activityTitleInput = document.getElementById('activity_title_field');
    const activityDescriptionInput = document.getElementById('activity_description_field');
    const activityContentInput = document.getElementById('activity_content_field');
    const activityImageInput = document.getElementById('activity_image_field');
    const activityImageLabel = document.getElementById('activity_image_label');
    const activityImagePreviewContainer = document.getElementById('activity-image-preview-container');
    const activityImagePreview = document.getElementById('activity-image-preview');
    const btnSubmitActivity = document.getElementById('btn-submit-activity');
    const btnCancelActivity = document.getElementById('btn-cancel-activity');

    // Handle tombol Edit Kegiatan
    const editButtonsActivity = document.querySelectorAll('.btn-edit-activity');
    editButtonsActivity.forEach(btn => {
        btn.addEventListener('click', function() {
            try {
                const id = this.dataset.id;
                const title = this.dataset.title;
                const description = this.dataset.description;
                const content = this.dataset.content;
                const imageUrl = this.dataset.image;

                if(formTitleActivity) formTitleActivity.innerText = 'Edit Kegiatan';
                if(activityIdInput) activityIdInput.value = id;
                if(activityTitleInput) activityTitleInput.value = title || '';
                if(activityDescriptionInput) activityDescriptionInput.value = description || '';
                if(activityContentInput) activityContentInput.value = content || '';

                if(activityForm) activityForm.action = `${baseActivityUpdateUrl}/${id}/update`;

                let methodInput = activityForm ? activityForm.querySelector('input[name="_method"]') : null;
                if (methodInput) methodInput.remove();
                
                if(activityForm){
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    activityForm.appendChild(methodInput);
                }

                if (imageUrl && imageUrl !== "{{ asset('storage/') }}" && imageUrl.trim() !== '') {
                    if(activityImagePreview) activityImagePreview.src = imageUrl;
                    if(activityImagePreviewContainer) activityImagePreviewContainer.style.display = 'block';
                    if(activityImageLabel) activityImageLabel.innerText = imageUrl.split('/').pop() || 'Pilih gambar...';
                } else {
                    if(activityImagePreview) activityImagePreview.src = '';
                    if(activityImagePreviewContainer) activityImagePreviewContainer.style.display = 'none';
                    if(activityImageLabel) activityImageLabel.innerText = 'Pilih gambar...';
                }
                if(activityImageInput) activityImageInput.value = '';

                if(btnSubmitActivity) btnSubmitActivity.innerHTML = '<i class="fas fa-sync-alt"></i> Update';
                if(btnCancelActivity) btnCancelActivity.style.display = 'inline-block';

                if(activityForm) activityForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } catch (e) {
                // Anda bisa menambahkan penanganan error yang lebih spesifik di sini jika diperlukan
            }
        });
    });

    // Handle tombol Cancel Kegiatan
    if(btnCancelActivity) {
        btnCancelActivity.addEventListener('click', () => {
            try {
                if(formTitleActivity) formTitleActivity.innerText = 'Tambah Kegiatan';
                if(activityIdInput) activityIdInput.value = '';
                if(activityForm) {
                    activityForm.reset(); 
                    activityForm.action = defaultActivityFormAction; 
                    const methodInput = activityForm.querySelector('input[name="_method"]');
                    if (methodInput) methodInput.remove(); 
                }
                if(activityImagePreview) activityImagePreview.src = '';
                if(activityImagePreviewContainer) activityImagePreviewContainer.style.display = 'none';
                if(activityImageLabel) activityImageLabel.innerText = 'Pilih gambar...';
                if(btnSubmitActivity) btnSubmitActivity.innerHTML = '<i class="fas fa-save"></i> Simpan';
                btnCancelActivity.style.display = 'none';
            } catch (e) {
                // Penanganan error
            }
        });
    }

    // Handle tombol Hapus Kegiatan
    document.querySelectorAll('.btn-delete-activity').forEach(button => {
        button.addEventListener('click', function () {
            try {
                const title = this.dataset.title;
                const action = this.dataset.action;
                const deleteForm = document.getElementById('deleteActivityForm');
                const deleteTitle = document.getElementById('deleteActivityTitle');

                if(deleteForm) deleteForm.action = action;
                if(deleteTitle) deleteTitle.innerText = title;
            } catch (e) {
                // Penanganan error
            }
        });
    });

    // Preview gambar dan update label untuk Kegiatan
    if(activityImageInput) {
        activityImageInput.addEventListener('change', function(event) {
            try {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if(activityImagePreview) activityImagePreview.src = e.target.result;
                        if(activityImagePreviewContainer) activityImagePreviewContainer.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                    if(activityImageLabel) activityImageLabel.innerText = file.name;
                } else {
                    if(activityImagePreview) activityImagePreview.src = '';
                    if(activityImagePreviewContainer) activityImagePreviewContainer.style.display = 'none';
                    if(activityImageLabel) activityImageLabel.innerText = 'Pilih gambar...';
                }
            } catch (e) {
                // Penanganan error
            }
        });
    }
});
</script>
@endpush
