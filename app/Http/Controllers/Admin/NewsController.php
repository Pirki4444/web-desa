<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('author')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $news = $query->paginate(15)->withQueryString();
        $categories = ['Pemerintahan', 'Pembangunan', 'Sosial', 'Pengumuman'];

        return view('admin.news.index', compact('news', 'categories'));
    }

    public function create()
    {
        $categories = ['Pemerintahan', 'Pembangunan', 'Sosial', 'Pengumuman'];
        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'category' => 'required|in:Pemerintahan,Pembangunan,Sosial,Pengumuman',
            'status'   => 'required|in:draft,published',
            'excerpt'  => 'nullable|string|max:500',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'title.required'    => 'Judul berita wajib diisi.',
            'content.required'  => 'Konten berita wajib diisi.',
            'category.required' => 'Kategori wajib dipilih.',
            'image.image'       => 'File harus berupa gambar.',
            'image.max'         => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = $request->only(['title', 'content', 'category', 'status', 'excerpt']);
        $data['user_id'] = Auth::id();
        $data['slug'] = $this->generateUniqueSlug($request->title);

        if ($request->status === 'published') {
            $data['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        News::create($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $news)
    {
        $categories = ['Pemerintahan', 'Pembangunan', 'Sosial', 'Pengumuman'];
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'category' => 'required|in:Pemerintahan,Pembangunan,Sosial,Pengumuman',
            'status'   => 'required|in:draft,published',
            'excerpt'  => 'nullable|string|max:500',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['title', 'content', 'category', 'status', 'excerpt']);

        if ($news->title !== $request->title) {
            $data['slug'] = $this->generateUniqueSlug($request->title, $news->id);
        }

        if ($request->status === 'published' && !$news->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }
        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    private function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 1;

        while (News::where('slug', $slug)->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))->exists()) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }
}
