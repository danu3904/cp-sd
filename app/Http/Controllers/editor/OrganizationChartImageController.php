<?php

namespace App\Http\Controllers\editor;

use App\Http\Controllers\Controller;
use App\Models\OrganizationChartImage; // Import model yang baru dibuat
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Untuk menghapus/menyimpan gambar

class OrganizationChartImageController extends Controller
{
    public function index()
    {
        // Ambil data gambar struktur organisasi yang pertama (atau satu-satunya entri)
        $chartImage = OrganizationChartImage::first();
        
        // Jika belum ada data, buat entri baru agar form tidak error dan bisa diisi saat pertama kali
        if (!$chartImage) {
            $chartImage = new OrganizationChartImage();
        }

        return view('pages.editor.organization_chart_image.index', compact('chartImage'));
    }

    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Maks 2MB, tambahkan webp
        ]);

        $messages = [
            'title.required' => 'Judul bagan organisasi tidak boleh kosong.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'description.max' => 'Deskripsi terlalu panjang, maksimal 2000 karakter.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diizinkan hanya: JPG, PNG, atau WEBP.',
            'image.max' => 'Ukuran gambar tidak boleh melebihi 2MB.',
        ];

        // Lakukan validasi dengan pesan kustom
        $validatedData = $request->validate($request, $messages);

        // Ambil data gambar struktur organisasi yang pertama (atau satu-satunya entri)
        $chartImage = OrganizationChartImage::first();

        // Jika belum ada, buat baru
        if (!$chartImage) {
            $chartImage = new OrganizationChartImage();
        }

        // Tangani upload gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($chartImage->image_path && Storage::disk('public')->exists($chartImage->image_path)) {
                Storage::disk('public')->delete($chartImage->image_path);
            }

            // Simpan gambar baru ke folder 'organization_chart_images' di public storage
            $imagePath = $request->file('image')->store('organization_chart_images', 'public');
            $chartImage->image_path = $imagePath;
        }

        // Update kolom lain
        $chartImage->title = $request->title;
        $chartImage->description = $request->description;
        $chartImage->save();

        return redirect()->back()->with('success', 'Gambar Struktur Organisasi berhasil diperbarui!');
    }
}