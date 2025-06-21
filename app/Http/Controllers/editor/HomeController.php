<?php

namespace App\Http\Controllers\editor;

use App\Models\News;
use App\Models\Gallery;
use App\Models\Activity;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrganizationChartImage;

class HomeController extends Controller
{
    public function index()
    {
        $jumlahBerita = News::count();
        $jumlahKegiatan = Activity::count();
        $jumlahGaleri = Gallery::count();
        $jumlahPengumuman = Announcement::count();
        $jumlahStruktur = OrganizationChartImage::count();
        $beritaTerbaru = News::latest()->take(3)->get();
        $pengumumanAktif = Announcement::latest()->take(3)->get();

        return view('pages.editor.dashboard.index', compact(
            'jumlahBerita',
            'jumlahKegiatan',
            'jumlahGaleri',
            'jumlahPengumuman',
            'jumlahStruktur',
            'beritaTerbaru',
            'pengumumanAktif'
        ));
    }
}

