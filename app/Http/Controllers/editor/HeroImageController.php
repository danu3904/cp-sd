<?php

namespace App\Http\Controllers\editor;

use App\Models\HeroImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class HeroImageController extends Controller
{
    public function index()
    {
        $image = HeroImage::latest()->first();
        return view('pages.editor.heroimage.index', compact('image'));
    }

    public function uploadHeroImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        /** @var \Illuminate\Http\UploadedFile $file */
        $file = $request->file('image');

        // Hapus gambar lama (jika ada)
        $old = HeroImage::latest()->first();
        if ($old && Storage::disk('public')->exists($old->image_path)) {
            Storage::disk('public')->delete($old->image_path);
        }

        // Upload dan simpan gambar baru
        $path = $file->store('hero_images', 'public');
        HeroImage::create(['image_path' => $path]);

        return redirect()->route('editor.hero-image')->with('success', 'Gambar header berhasil diperbarui.');
    }
}
