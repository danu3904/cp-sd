<?php

namespace App\Http\Controllers\Editor;

use App\Models\PrincipalMessageImage; // Untuk gambar kata sambutan
use App\Models\PrincipalWelcome;      // 1. Model baru untuk teks kata sambutan
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Untuk logging jika terjadi error

class PrincipalImageController extends Controller
{
    /**
     * Menampilkan form untuk upload Gambar Kata Sambutan dan input teks Kata Sambutan.
     */
    public function index()
    {
        // Ambil gambar kata sambutan yang aktif
        $principalImage = PrincipalMessageImage::where('is_active', true)->latest()->first();
        // Ambil teks kata sambutan yang aktif
        $principalWelcome = PrincipalWelcome::where('is_active', true)->latest()->first();

        // Asumsi view admin adalah 'pages.editor.principal_section.index'
        // Kamu perlu membuat atau menyesuaikan view ini
        return view('pages.editor.principal_section.index', compact('principalImage', 'principalWelcome'));
    }

    /**
     * Menyimpan atau memperbarui Gambar Kata Sambutan Kepala Sekolah.
     */
    public function storePrincipalImage(Request $request)
    {
        $request->validate([
            'principal_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'alt_text' => 'nullable|string|max:255',
        ], [
            'principal_image.required' => 'Anda belum memilih gambar untuk kata sambutan.',
            'principal_image.image' => 'File harus berupa gambar.',
            'principal_image.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'principal_image.max' => 'Ukuran gambar maksimal 2MB.',
            'alt_text.string' => 'Teks alternatif harus berupa teks.',
            'alt_text.max' => 'Teks alternatif maksimal 255 karakter.',
        ]);

        try {
            /** @var \Illuminate\Http\UploadedFile $file */
            $file = $request->file('principal_image');

            // 1. Nonaktifkan semua gambar kata sambutan yang lama
            PrincipalMessageImage::where('is_active', true)->update(['is_active' => false]);
            
            // (Opsional) Hapus file gambar lama dari storage jika hanya ingin menyimpan yang aktif
            // $oldImages = PrincipalMessageImage::where('is_active', false)->get();
            // foreach ($oldImages as $oldImage) {
            //     if ($oldImage->image_path && Storage::disk('public')->exists($oldImage->image_path)) {
            //         Storage::disk('public')->delete($oldImage->image_path);
            //         // Pertimbangkan untuk menghapus recordnya juga jika tidak ingin menyimpan histori path
            //         // $oldImage->delete(); 
            //     }
            // }

            // 2. Upload dan simpan gambar baru
            $path = $file->store('principal_images', 'public'); // Simpan di folder principal_images
            
            PrincipalMessageImage::create([
                'image_path' => $path,
                'alt_text' => $request->input('alt_text'),
                'is_active' => true,
            ]);

            // Asumsi nama route untuk halaman pengelolaan ini adalah 'editor.principal-section.index'
            return redirect()->route('editor.principal-section.index')
                             ->with('success_principal_image', 'Gambar kata sambutan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error uploading principal image: ' . $e->getMessage());
            return redirect()->route('editor.principal-section.index')
                             ->with('error_principal_image', 'Terjadi kesalahan saat memperbarui gambar kata sambutan.');
        }
    }

    /**
     * Menyimpan atau memperbarui Teks Kata Sambutan Kepala Sekolah.
     */
    public function storePrincipalWelcome(Request $request)
    {
        // 1. Validasi semua input yang diharapkan dari form
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255', // Jadikan nullable jika boleh kosong, atau 'required'
            'headmaster_name' => 'nullable|string|max:255', // Jadikan nullable jika boleh kosong, atau 'required'
            'welcome_message' => 'required|string|min:20', // 'welcome_message' adalah name dari textarea
        ], [
            'title.string' => 'Judul sambutan harus berupa teks.',
            'title.max' => 'Judul sambutan maksimal 255 karakter.',
            'headmaster_name.string' => 'Nama kepala sekolah harus berupa teks.',
            'headmaster_name.max' => 'Nama kepala sekolah maksimal 255 karakter.',
            'welcome_message.required' => 'Teks kata sambutan tidak boleh kosong.',
            'welcome_message.string' => 'Teks kata sambutan harus berupa teks.',
            'welcome_message.min' => 'Teks kata sambutan minimal 20 karakter.',
        ]);

        try {
            // Nonaktifkan semua teks kata sambutan yang lama
            PrincipalWelcome::where('is_active', true)->update(['is_active' => false]);

            // Menggunakan updateOrCreate untuk menyederhanakan logika
            // Ini akan mencari record pertama, jika tidak ada akan membuat baru.
            // Jika kamu ingin logika yang lebih spesifik (misalnya update berdasarkan ID tertentu), sesuaikan kriteria pencarian.
            PrincipalWelcome::updateOrCreate(
                ['id' => $request->input('principal_welcome_id', PrincipalWelcome::first()->id ?? null)], // Mengupdate record yang ada, atau membuat baru jika tabel kosong
                [
                    'title' => $validatedData['title'] ?? 'Kata Sambutan Kepala Sekolah', // Default jika tidak diisi
                    'headmaster_name' => $validatedData['headmaster_name'] ?? null,
                    'content' => $validatedData['welcome_message'],
                    'is_active' => true,
                ]
            );
            
            return redirect()->route('editor.principal-section.index')
                             ->with('success_principal_welcome', 'Teks kata sambutan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error storing principal welcome: ' . $e->getMessage());
            // Tambahkan $e->getTraceAsString() untuk detail error jika perlu
            // Log::error($e->getTraceAsString());
            return redirect()->route('editor.principal-section.index')
                             ->with('error_principal_welcome', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
