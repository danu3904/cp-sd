<?php

namespace App\Http\Controllers\editor;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    // Tampilkan semua galeri
    public function index()
    {
        $galleries = Gallery::latest()->paginate(12);
        return view('pages.editor.gallery.index', compact('galleries'))->with('mode', 'index');
    }

    // Form tambah galeri
    public function create()
    {
        return view('pages.editor.gallery.index')->with('mode', 'create');
    }

    // Simpan galeri baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:100',
            'kategori' => 'nullable|string|max:50',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'foto' => $imagePath,
        ]);

        return redirect()->route('editor.gallery.index')->with('success', 'Foto berhasil ditambahkan.');
    }

    // Form edit galeri
    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        $galleries = Gallery::latest()->paginate(12);
        return view('pages.editor.gallery.index', compact('gallery', 'galleries'))->with('mode', 'edit');
    }

    // Update galeri
    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:100',
            'kategori' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($gallery->foto && Storage::disk('public')->exists($gallery->foto)) {
                Storage::disk('public')->delete($gallery->foto);
            }

            $imagePath = $request->file('image')->store('gallery', 'public');
            $gallery->foto = $imagePath;
        }

        $gallery->judul = $request->judul;
        $gallery->kategori = $request->kategori;
        $gallery->save();

        return redirect()->route('editor.gallery.index')->with('success', 'Foto berhasil diperbarui.');
    }

    // Hapus galeri
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        if ($gallery->foto && Storage::disk('public')->exists($gallery->foto)) {
            Storage::disk('public')->delete($gallery->foto);
        }

        $gallery->delete();

        return redirect()->route('editor.gallery.index')->with('success', 'Foto berhasil dihapus.');
    }
}
