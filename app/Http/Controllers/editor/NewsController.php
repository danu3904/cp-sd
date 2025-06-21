<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = News::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%") // Tambahkan pencarian berdasarkan deskripsi
                  ->orWhere('content', 'like', "%{$search}%");
        }

        // Menggunakan latest() untuk urutan terbaru dan paginate() untuk pagination
        $news = $query->latest()->paginate(6); // Sesuaikan jumlah item per halaman jika perlu

        // Pastikan view ini ada: resources/views/pages/editor/news/index.blade.php
        return view('pages.editor.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     * Biasanya tidak diperlukan jika form tambah ada di halaman index.
     * Jika ada halaman create terpisah, buat method create() di sini.
     */
    // public function create()
    // {
    //     return view('pages.editor.news.create');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500', // Validasi untuk deskripsi singkat
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'image.image' => 'File harus berupa gambar (jpeg, png, dll).',
        ]);

        $dataToStore = [
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'content' => $validatedData['content'],
        ];

        if ($request->hasFile('image')) {
            $dataToStore['image'] = $request->file('image')->store('news_images', 'public');
        }

        News::create($dataToStore);

        // PERBAIKAN: Menggunakan nama route yang benar
        return redirect()->route('editor.news.index')
                         ->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * Biasanya tidak diperlukan untuk CRUD admin sederhana, kecuali ada halaman detail di admin.
     */
    // public function show(News $news) // Menggunakan Route Model Binding
    // {
    //     return view('pages.editor.news.show', compact('news'));
    // }

    /**
     * Show the form for editing the specified resource.
     * Jika form edit di-handle oleh JavaScript dan mengambil data via JSON (seperti di kodemu).
     */
    public function edit($id) // Atau News $news jika menggunakan Route Model Binding
    {
        $newsItem = News::findOrFail($id);
        // Jika form edit adalah halaman Blade terpisah:
        // return view('pages.editor.news.edit', compact('newsItem'));

        // Jika menggunakan JavaScript untuk mengisi form berdasarkan JSON:
        return response()->json($newsItem);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) // Atau News $news
    {
        $newsItem = News::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500', // Validasi untuk deskripsi singkat
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 'image' bukan 'new_image'
        ]);

        $newsItem->title = $validatedData['title'];
        $newsItem->description = $validatedData['description'];
        $newsItem->content = $validatedData['content'];

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($newsItem->image && Storage::disk('public')->exists($newsItem->image)) {
                Storage::disk('public')->delete($newsItem->image);
            }
            // Upload gambar baru
            $newsItem->image = $request->file('image')->store('news_images', 'public');
        }

        $newsItem->save();

        // PERBAIKAN: Menggunakan nama route yang benar
        return redirect()->route('editor.news.index')
                         ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) // Atau News $news
    {
        $newsItem = News::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($newsItem->image && Storage::disk('public')->exists($newsItem->image)) {
            Storage::disk('public')->delete($newsItem->image);
        }

        $newsItem->delete();

        // PERBAIKAN: Menggunakan nama route yang benar
        return redirect()->route('editor.news.index')
                         ->with('success', 'Berita berhasil dihapus.');
    }
}
