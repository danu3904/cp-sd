<?php

namespace App\Http\Controllers\editor;

use App\Models\Sejarah;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SejarahController extends Controller
{
    public function index()
    {
        $sejarah = Sejarah::first();
            if (!$sejarah) {
        $sejarah = Sejarah::create([
            'isi' => '',
            'gambar' => null,
        ]);
    }
        return view('pages.editor.sejarah.index', compact('sejarah'));
    }

    public function update(Request $request, $id)
    {
        $sejarah = Sejarah::findOrFail($id);
        $sejarah->isi = $request->isi;

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('sejarah', 'public');
            $sejarah->gambar = $gambar;
        }

        $sejarah->save();

        return redirect()->back()->with('success', 'Sejarah berhasil diperbarui.');
    }
}
