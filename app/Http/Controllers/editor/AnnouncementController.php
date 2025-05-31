<?php

namespace App\Http\Controllers\editor;

use Carbon\Carbon;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnnouncementController extends Controller
{
    public function index()
{
    // Ambil 3 pengumuman terbaru dalam seminggu (opsional, kalau memang perlu)
    // $announcements = Announcement::where('created_at', '>=', Carbon::now()->subWeek())
    //     ->latest()
    //     ->take(3)
    //     ->get();

    // Atau ambil semua pengumuman terbaru
    $announcements = Announcement::orderBy('created_at', 'desc')->get();

    // Ambil pengumuman terbaru untuk preview
    $announcement = $announcements->first();

    return view('pages.editor.announcement.index', compact('announcements', 'announcement'));
}




    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        Announcement::create([
            'content' => $request->content
        ]);

        return redirect()->route('editor.announcement')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

}
