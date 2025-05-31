<div class="container-fluid bg-light position-relative shadow">
    <nav class="navbar navbar-expand-md bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
        <a href="{{ url('/') }}" class="navbar-brand font-weight-bold text-secondary" style="font-size: 30px;">
            <img src="{{asset('template_admin/img/tutwuri.jpg')}}" alt="Logo Sekolah" style="width: 40px; height: 40px; object-fit: contain;">
            <span class="text-primary">SD Negeri 05 Taman</span>
        </a>

        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
            <div class="navbar-nav font-weight-bold mx-auto py-0">
                <a href="{{ url('/') }}" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">Beranda</a>

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ (Request::routeIs('news.all') || Request::routeIs('activity.show') || Request::routeIs('activities.all') || Request::routeIs('news.show')) ? 'active' : '' }}" data-toggle="dropdown">
                        Informasi
                    </a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="{{ route('news.all') }}" class="dropdown-item {{ Request::routeIs('news.all') || Request::routeIs('news.show') ? 'active' : '' }}">Berita</a>
                        <a href="{{ route('activities.all') }}" class="dropdown-item {{ Request::routeIs('activities.all') || Request::routeIs('activity.show') ? 'active' : '' }}">Kegiatan</a>
                    </div>
                </div>

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ Request::is('profile/*') ? 'active' : '' }}" data-toggle="dropdown">Profile</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="{{ route('sejarah') }}" class="dropdown-item">Sejarah Sekolah</a>
                        <a href="{{ route('visimisi') }}" class="dropdown-item">Visi & Misi</a>
                        <a href="{{ route('struktur_organisasi') }}" class="dropdown-item">Struktur Organisasi</a>
                    </div>
                </div>

                <a href="{{route ('galeri')}}" class="nav-item nav-link {{ Request::is('galeri') ? 'active' : '' }}">Galeri</a>
                <a href="{{route ('announcements.all')}}" class="nav-item nav-link {{ Request::is('pengumuman') ? 'active' : '' }}">Pengumuman</a>
            </div>
            <a href="https://wa.me/6281914600614?text=Halo%20admin%20SD%20Negeri%2005%20Taman%2C%20saya%20ingin%20bertanya%20tentang..." class="btn btn-primary px-4">
                <i class="fab fa-whatsapp mr-2"></i> Chat
            </a>
        </div>
    </nav>
</div>