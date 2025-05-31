<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::query();
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
        }
        $activities = $query->latest()->paginate(6);
        return view('pages.editor.activities.index', compact('activities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            // 'icon_class' => 'nullable|string|max:100', // HAPUS/KOMENTARI VALIDASI INI
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Hapus 'icon_class' dari data yang diambil
        $data = $request->only(['title', 'description', 'content']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('activity_images', 'public');
        }

        Activity::create($data);

        return redirect()->route('editor.activities.index')
                         ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $activity = Activity::findOrFail($id);
        return response()->json($activity); // Tetap kirim semua data, JS akan abaikan icon_class
    }

    public function update(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            // 'icon_class' => 'nullable|string|max:100', // HAPUS/KOMENTARI VALIDASI INI
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $activity->title = $validatedData['title'];
        $activity->description = $validatedData['description'] ?? null;
        // $activity->icon_class = $validatedData['icon_class'] ?? null; // HAPUS/KOMENTARI BARIS INI
        $activity->content = $validatedData['content'] ?? null;

        if ($request->hasFile('image')) {
            if ($activity->image && Storage::disk('public')->exists($activity->image)) {
                Storage::disk('public')->delete($activity->image);
            }
            $activity->image = $request->file('image')->store('activity_images', 'public');
        }

        $activity->save();

        return redirect()->route('editor.activities.index')
                         ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        if ($activity->image && Storage::disk('public')->exists($activity->image)) {
            Storage::disk('public')->delete($activity->image);
        }
        $activity->delete();
        return redirect()->route('editor.activities.index')
                         ->with('success', 'Kegiatan berhasil dihapus.');
    }
}
