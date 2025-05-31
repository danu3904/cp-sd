<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Gallery;
use App\Models\Sejarah;
use App\Models\Activity;
use App\Models\VisiMisi;
use App\Models\HeroImage;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\OrganizationStructure;
use App\Models\OrganizationChartImage;
use App\Models\PrincipalMessageImage; 
use App\Models\PrincipalWelcome;      

class PublicController extends Controller
{
    public function index()
    {
        
        $visiMisi = VisiMisi::first();
        $sejarah = Sejarah::first();
        $galleries = Gallery::latest()->paginate(3);
        $news = News::latest()->take(3)->get();
        $activities = Activity::latest()->take(4)->get();
        $announcements = Announcement::latest()->take(3)->get();
        
        // Mengambil Hero Image (asumsi hanya satu yang aktif atau yang terbaru)
        $heroImage = heroImage::latest()->first(); // Variabel $image sebelumnya diubah menjadi $heroImage agar lebih jelas

        // Mengambil Gambar untuk Kata Sambutan Kepala Sekolah yang aktif
        $principalImage = PrincipalMessageImage::where('is_active', true)->latest()->first();

        // Mengambil Teks Kata Sambutan Kepala Sekolah yang aktif
        $principalWelcome = PrincipalWelcome::where('is_active', true)->latest()->first();

        return view('pages.fe.index', compact(
            'announcements', 
            'heroImage',  
            'news', 
            'sejarah',  
            'visiMisi', 
            'activities', // Data kegiatan
            'principalImage',    // Data gambar kata sambutan
            'principalWelcome',   // Data teks kata sambutan
            'galleries'          // Data galeri
        ));
    }

    // ... (method allNews, showNews, allActivities, showActivities tetap sama) ...
    public function allAnnouncements(Request $request)
    {
        $query = Announcement::query();

        // Optional: kalau mau ada fitur search pengumuman
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where('content', 'like', '%' . $search . '%');
        }

        // Urut berdasarkan tanggal terbaru, paginasi 5 per halaman
        $announcements = $query->orderBy('created_at', 'desc')->paginate(5);

        // Supaya query 'q' tetap ada di link pagination
        $announcements->appends($request->only('q'));

        return view('pages.fe.all_announcements.index', compact('announcements'));
    }


    public function allNews(Request $request)
    {
        $query = News::query();

        // Jika ada parameter pencarian 'q'
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $allNewsItems = $query->orderBy('created_at', 'desc')->paginate(5);

        // Sertakan parameter pencarian agar pagination mempertahankan query
        $allNewsItems->appends($request->only('q'));

        return view('pages.fe.news.all_news', compact('allNewsItems'));
    }

    public function showNews($news_id)
    {
        $newsItem = News::findOrFail($news_id);
        return view('pages.fe.news.show_news', compact('newsItem'));
    }

    public function allActivities(Request $request)
{
    $query = Activity::query(); // Ganti dari News ke Activity

    // Jika ada parameter pencarian 'q'
    if ($request->filled('q')) {
        $search = $request->input('q');
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%"); // jika field ini ada
        });
    }

    // Mengambil hasil dengan pagination
    $allActivityItems = $query->orderBy('created_at', 'desc')->paginate(5);

    // Menyisipkan parameter pencarian ke pagination
    $allActivityItems->appends($request->only('q'));

    // Kirim ke view
    return view('pages.fe.activities.all_activities', compact('allActivityItems'));
}


    public function showActivities($activity_id)
    {
        $activityItem = Activity::findOrFail($activity_id);
        return view('pages.fe.activities.show_activities', compact('activityItem'));
    }

    public function allGallery(Request $request)
    {
        $query = Gallery::query();

        // Cek apakah ada parameter pencarian
        if ($request->has('q')) {
            $search = $request->input('q');
            $query->where('judul', 'like', '%' . $search . '%')
                ->orWhere('kategori', 'like', '%' . $search . '%');
        }

        $galleries = $query->latest()->paginate(12);

        // Pastikan keyword tetap ada di pagination
        return view('pages.fe.gallery.index', compact('galleries'))
            ->with('search', $request->q);
    }



     public function sejarah()
    {
        // Mengambil data Sejarah dari model Sejarah
        $sejarahContent = Sejarah::first(); 
        return view('pages.fe.sejarah.index', compact('sejarahContent'));
    }

    public function visiMisi()
    {
        $visiMisi = VisiMisi::first();
        return view('pages.fe.visimisi.index', compact('visiMisi'));
    }

        // BARU: Metode untuk menampilkan halaman publik Struktur Organisasi
    public function showOrganizationChartImage()
    {
        $chartImage = OrganizationChartImage::first(); // Ambil data gambar bagan organisasi
        
        // Jika tidak ada data, kita bisa membuat objek kosong agar view tidak error
        if (!$chartImage) {
            $chartImage = new OrganizationChartImage();
        }

        return view('pages.fe.struktur_organisasi.index', compact('chartImage'));
    }

}
