<?php

namespace App\Http\Controllers\editor;

use App\Models\VisiMisi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VisiMisiController extends Controller
{
    public function index()
    {
        $data = VisiMisi::first();
        return view('pages.editor.visimisi.index', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
        ]);

        $data = VisiMisi::findOrFail($id);
        $data->update([
            'visi' => $request->visi,
            'misi' => $request->misi,
        ]);

        return redirect()->back()->with('success', 'Visi & Misi berhasil diperbarui.');
    }
}
