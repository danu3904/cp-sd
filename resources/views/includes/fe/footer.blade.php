<div class="container-fluid bg-secondary text-white mt-5 py-5 px-sm-3 px-md-5">
    <div class="row pt-5">
        {{-- <div class="col-lg-3 col-md-6 mb-7">
            <a href="{{ url('/') }}" class="navbar-brand font-weight-bold text-primary m-0 mb-4 p-0" style="font-size: 23px; line-height: 40px;">
                <img src="{{asset('template_admin/img/tutwuri.jpg')}}" alt="Logo Sekolah" style="width: 40px; height: 40px; object-fit: contain;">
                <span class="text-white">SD Negeri 05 Taman</span>
            </a>
            <p>Labore dolor amet ipsum ea, erat sit ipsum duo eos. Volup amet ea dolor et magna dolor, elitr rebum duo est sed diam elitr. Stet elitr stet diam duo eos rebum ipsum diam ipsum elitr.</p>
            <div class="d-flex justify-content-start mt-4">
                <a class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
                    style="width: 38px; height: 38px;" href="https://youtube.com/@sdn05taman99?si=Tb9pYzkilYSHkOZi"><i class="fab fa-youtube"></i></a>
                <a class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
                    style="width: 38px; height: 38px;" href="#"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
                    style="width: 38px; height: 38px;" href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div> --}}
        
        <div class="col-lg-3 col-md-6 mb-5">
            <h3 class="text-primary mb-4">Tautan Cepat</h3>
            <div class="d-flex flex-column justify-content-start">
                <a class="text-white mb-2" href="/"><i class="fa fa-angle-right mr-2"></i>Beranda</a>
                <a class="text-white mb-2" href="{{ route('news.all') }}" class="dropdown-item"><i class="fa fa-angle-right mr-2"></i>Berita</a>
                <a class="text-white mb-2" href="{{ route('activities.all') }}" class="dropdown-item"><i class="fa fa-angle-right mr-2"></i>Kegiatan</a>
                <a class="text-white mb-2" href="{{ route('sejarah') }}"><i class="fa fa-angle-right mr-2"></i>Sejarah</a>
                <a class="text-white mb-2" href="{{ route('visimisi') }}"><i class="fa fa-angle-right mr-2"></i>Visi & Misi</a>
                <a class="text-white" href="#"><i class="fa fa-angle-right mr-2"></i>Galeri</a>
            </div>
        </div>
        <div class="col-lg-5 col-md-6 mb-5">
            <h3 class="text-primary mb-4">Kontak Sekolah</h3>
            <div class="d-flex">
                <h4 class="fa fa-map-marker-alt text-primary"></h4>
                <div class="pl-3">
                    <h5 class="text-white">Alamat</h5>
                    <p>JL. Bandelan Taman, Rt 4/Rw 6, Taman, Taman, Taman 1, Taman, Kec. Pemalang, Kabupaten Pemalang, Jawa Tengah 52361</p>
                </div>
            </div>
            <div class="d-flex">
                <h4 class="fa fa-envelope text-primary"></h4>
                <div class="pl-3">
                    <h5 class="text-white">Email</h5>
                    <p> sdn05taman@yahoo.com</p>
                </div>
            </div>
            <div class="d-flex">
                <h4 class="fa fa-phone-alt text-primary"></h4>
                <div class="pl-3">
                    <h5 class="text-white">Ponsel</h5>
                    <p>081914600614</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-5">
            <h3 class="text-primary mb-4">Lokasi Kami</h3>
            <div class="embed-responsive embed-responsive-16by9">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.9026641033033!2d109.40456027410634!3d-6.902242867546085!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fdb1c86503abd%3A0x1ff99157256229c1!2sSD%20Negeri%2005%20Taman!5e0!3m2!1sen!2sid!4v1748452278708!5m2!1sen!2sid" 
                        width="400" 
                        height="300" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <div class="d-flex justify-content-start mt-4">
                <a class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
                     style="width: 38px; height: 38px;" href="https://youtube.com/@sdn05taman99?si=Tb9pYzkilYSHkOZi"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
    <div class="container-fluid pt-5" style="border-top: 1px solid rgba(23, 162, 184, .2);">
        <p class="m-0 text-center text-white">
            <span>Copyright © SD Negeri 05 Taman {{date('Y')}}</span>
        </p>
    </div>
</div>