    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\PublicController;
    use App\Http\Controllers\editor\AuthController;
    use App\Http\Controllers\editor\HomeController;
    use App\Http\Controllers\editor\NewsController;
    use App\Http\Controllers\editor\ContactController;
    use App\Http\Controllers\editor\GalleryController;
    use App\Http\Controllers\editor\SejarahController;
    use App\Http\Controllers\editor\ActivityController;
    use App\Http\Controllers\editor\VisiMisiController;
    use App\Http\Controllers\editor\HeroImageController;
    use App\Http\Controllers\editor\AnnouncementController;
    use App\Http\Controllers\editor\PrincipalImageController;
    use App\Http\Controllers\editor\OrganizationChartImageController; 

    // ======== ROUTE UNTUK PUBLIK ========
    Route::controller(PublicController::class)->group(function () {
        Route::get('/', 'index'); // Halaman utama
        Route::get('/berita', 'allNews')->name('news.all');
        Route::get('/berita/{news_id}', 'showNews')->name('news.show');
        Route::get('/kegiatan', 'allActivities')->name('activities.all');
        Route::get('/kegiatan/{activity_id}', 'showActivities')->name('activity.show');
        Route::get('/sejarah', 'sejarah')->name('sejarah');
        Route::get('/visi-misi','visiMisi')->name('visimisi');
        Route::get('/struktur-organisasi', 'showOrganizationChartImage')->name('struktur_organisasi');
        Route::get('/galeri', 'allGallery')->name('galeri');
        Route::get('/pengumuman', 'allAnnouncements')->name('announcements.all');
    });

    // ======== ROUTE LOGIN (HANYA UNTUK TAMU) ========
    Route::controller(AuthController::class)->middleware('guest')->group(function () {
        Route::get('/login', 'index')->name('login');
        Route::post('/login', 'authenticate')->name('login.auth');
    });

    // ======== ROUTE UNTUK EDITOR (AUTH WAJIB) ========
    // PASTIKAN BLOK INI TIDAK ADA KESALAHAN PADA KURUNG KURAWALNYA { }
    Route::prefix('editor')->middleware('auth')->name('editor.')->group(function () {

        // Dashboard dan profil
        Route::controller(HomeController::class)->group(function () {
            Route::get('/', 'index')->name('home');
        });

        Route::controller(AuthController::class)->group(function () {
            Route::post('/logout', 'logout')->name('logout');
            Route::post('/profile/update', 'updateProfile')->name('profile.update');
        });

        // Pengumuman
        Route::controller(AnnouncementController::class)->group(function () {
            Route::get('/announcement', 'index')->name('announcement');
            Route::post('/announcement/store', 'store')->name('announcement.store');
            Route::post('/announcement', 'update')->name('announcement.update');
        });

        // Hero Image
        Route::controller(HeroImageController::class)->group(function () {
            Route::get('/hero-image', 'index')->name('hero-image');
            Route::post('/hero-image/store', 'uploadHeroImage')->name('hero-image.store');
        });

        // Kontak
        Route::controller(ContactController::class)->group(function () {
            Route::get('/contact', 'index')->name('contact');
            Route::get('/contact/data', 'getData')->name('contact.data');
            Route::delete('/contact/delete', 'deleteData')->name('contact.delete');
        });

        // Berita
        Route::controller(NewsController::class)->prefix('news')->name('news.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}/update', 'update')->name('update');
            Route::delete('/{id}/delete', 'destroy')->name('delete');
        });

        // Kegiatan
        Route::controller(ActivityController::class)->prefix('activities')->name('activities.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}/update', 'update')->name('update');
            Route::delete('/{id}/delete', 'destroy')->name('delete');
        });

        // Galeri
        Route::controller(GalleryController::class)->prefix('gallery')->name('gallery.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}/update', 'update')->name('update');
            Route::delete('/{id}/delete', 'destroy')->name('destroy');
        });

        // Kata Sambutan Kepala Sekolah
        Route::controller(PrincipalImageController::class)->prefix('principal-section')->name('principal-section.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/image/store', 'storePrincipalImage')->name('image.store');
            Route::post('/welcome/store', 'storePrincipalWelcome')->name('welcome.store');
        });

        // Sejarah
        Route::controller(SejarahController::class)->prefix('sejarah')->name('sejarah.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::put('/{id}/update', 'update')->name('update');
        });

        // Visi Misi
        Route::controller(VisiMisiController::class)->prefix('visimisi')->name('visimisi.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::put('/{id}/update', 'update')->name('update');
        });
        
        // BARU: Route untuk Manajemen Gambar Struktur Organisasi (satu entri)
        // PASTIKAN BLOK INI ADA DI DALAM GROUP EDITOR {}
        Route::controller(OrganizationChartImageController::class)->prefix('organization_chart_image')->name('organization_chart_image.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'update')->name('update');
        });

    }); 