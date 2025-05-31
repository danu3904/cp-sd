<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('editor.home') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('template_admin/img/tutwuri.jpg') }}" alt="Logo Sekolah" style="width: 40px; height: 40px; object-fit: contain;">
        </div>
        <div class="sidebar-brand-text mx-3">SDN 05 Taman</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ Request::is('editor') || Request::is('editor/home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('editor.home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <li class="nav-item {{ 
        Request::is('editor/news*') || 
        Request::is('editor/activities*') || 
        Request::is('editor/hero-image') ||
        Request::is('editor/principal-section*') ||
        Request::is('editor/announcement') ||
        Request::is('editor/gallery*')
        ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseContent" aria-expanded="true" aria-controls="collapseContent">
            <i class="fas fa-folder-open"></i>
            <span>Konten Sekolah</span>
        </a>
        <div id="collapseContent" class="collapse {{ 
            Request::is('editor/news*') || 
            Request::is('editor/activities*') || 
            Request::is('editor/hero-image') || 
            Request::is('editor/principal-section*') || 
            Request::is('editor/announcement') ||
            Request::is('editor/gallery*')
            ? 'show' : '' }}" aria-labelledby="headingContent" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('editor/news*') ? 'active' : '' }}" href="{{ route('editor.news.index') }}">
                    <i class="fas fa-newspaper mr-2"></i> Berita
                </a>
                <a class="collapse-item {{ Request::is('editor/activities*') ? 'active' : '' }}" href="{{ route('editor.activities.index') }}">
                    <i class="fas fa-tasks mr-2"></i> Kegiatan
                </a>
                <a class="collapse-item {{ Request::is('editor/hero-image') ? 'active' : '' }}" href="{{ route('editor.hero-image') }}">
                    <i class="fas fa-image mr-2"></i> Hero Image
                </a>
                <a class="collapse-item {{ Request::is('editor/principal-section*') ? 'active' : '' }}" href="{{ route('editor.principal-section.index') }}">
                    <i class="fas fa-user-tie mr-2"></i> Kata Sambutan
                </a>
                <a class="collapse-item {{ Request::is('editor/announcement') ? 'active' : '' }}" href="{{ route('editor.announcement') }}">
                    <i class="fas fa-bullhorn mr-2"></i> Pengumuman
                </a>
                <a class="collapse-item {{ Request::is('editor/gallery*') ? 'active' : '' }}" href="{{ route('editor.gallery.index') }}">
                    <i class="fas fa-camera-retro mr-2"></i> Galeri
                </a>
            </div>
        </div>
    </li>
    
        <hr class="sidebar-divider d-none d-md-block">
    
        <li class="nav-item 
        {{ Request::is('editor/sejarah') || Request::is('editor/visimisi') || Request::is('editor/organization_chart_image') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProfil" aria-expanded="true" aria-controls="collapseProfil">
            <i class="fas fa-user-graduate"></i>
            <span>Profil Sekolah</span>
        </a>
        <div id="collapseProfil" class="collapse 
            {{ Request::is('editor/sejarah') || Request::is('editor/visimisi') || Request::is('editor/organization_chart_image') ? 'show' : '' }}" 
            aria-labelledby="headingProfil" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('editor/sejarah') ? 'active' : '' }}" href="{{ route('editor.sejarah.index') }}">
                    <i class="fas fa-book-open mr-2"></i> Sejarah Sekolah
                </a>
                <a class="collapse-item {{ Request::is('editor/visimisi') ? 'active' : '' }}" href="{{ route('editor.visimisi.index') }}">
                    <i class="fas fa-lightbulb mr-2"></i> Visi & Misi
                </a>
                <a class="collapse-item {{ Request::is('editor/organization_chart_image') ? 'active' : '' }}" href="{{ route('editor.organization_chart_image.index') }}">
                    <i class="fas fa-sitemap mr-2"></i> Struktur Organisasi
                </a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider d-none d-md-block">


    <hr class="sidebar-divider d-none d-md-block">

    <li class="nav-item {{ Request::is('editor/contact') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('editor.contact') }}">
            <i class="fas fa-address-book"></i>
            <span>Contact</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
