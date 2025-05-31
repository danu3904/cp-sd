<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('template_admin/img/favicon.png') }}" type="image/png">
    <!-- Custom fonts for this template-->
    @include('includes.editor.style')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('includes.editor.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('includes.editor.topbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('includes.editor.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" action="{{ route('editor.profile.update') }}">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="profileModalLabel">Edit Profil</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>          
<div class="modal-body">
  <form>
    <div class="form-group">
      <label for="name" class="text-gray-900 font-weight-bold">Nama</label>
      <input type="text" class="form-control form-control-user" name="name" value="{{ auth()->user()->name }}" required>
    </div>

    <div class="form-group">
      <label for="email" class="text-gray-900 font-weight-bold">Email</label>
      <input type="email" class="form-control form-control-user" name="email" value="{{ auth()->user()->email }}" readonly>
    </div>

    <div class="form-group">
      <label for="password" class="text-gray-900 font-weight-bold">Password Baru</label>
      <input type="password" class="form-control form-control-user" name="password" placeholder="password baru" autocomplete="new-password">
      <small class="form-text text-muted">Isi hanya jika ingin mengubah password.</small>
    </div>
  </form>
</div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ingin keluar sekarang?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih 'Keluar' jika Anda ingin mengakhiri sesi saat ini.</div>
                <div class="modal-footer d-flex gap-2">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                
                    <form action="{{ route('editor.logout') }}" method="POST" id="logout-form">
                        @csrf
                        <button type="submit" class="btn btn-primary">Keluar</button>
                    </form>
                </div>                
        </div>
    </div>

@include('includes.editor.script')
@yield('script')
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        html: '{!! session('success') !!}',
        text: '{{ session('success') }}',
        showConfirmButton: true,
                timer: 3000 // Pesan akan hilang setelah 3 detik
    });
</script>
@endif

@if(session('info'))
<script>
    Swal.fire({
        icon: 'info',
        title: 'Info',
        text: '{{ session('info') }}',
    });
</script>
@endif

@stack('scripts')
</body>

</html>