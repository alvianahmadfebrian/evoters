<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CmsArticleController extends Controller
{
    /**
     * Display a listing of the articles.
     */
    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && in_array($request->input('status'), ['published', 'draft'])) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $articles = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Article::select('category')->distinct()->pluck('category');

        return view('cms.articles.index', compact('articles', 'categories'));
    }

    /**
     * Show the form for creating a new article.
     */
    public function create()
    {
        return view('cms.articles.create');
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'author_name' => 'nullable|string|max:100',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'status' => 'required|in:published,draft',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $data = $request->except('image');
        $data['category'] = $request->input('category') ?: 'Berita';
        $data['author_name'] = $request->input('author_name') ?: (auth()->user()->name ?? 'Admin eVoters');
        
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        // Generate unique slug
        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        $data['slug'] = $slug;

        // Auto excerpt if empty
        if (empty($data['excerpt'])) {
            $data['excerpt'] = Str::limit(strip_tags($request->content), 180);
        }

        // Process image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            
            if (!file_exists(public_path('uploads/articles'))) {
                mkdir(public_path('uploads/articles'), 0755, true);
            }
            
            $file->move(public_path('uploads/articles'), $filename);
            $data['image'] = 'uploads/articles/' . $filename;
        }

        Article::create($data);

        return redirect()->route('cms.articles.index')->with('success', 'Berita berhasil dipublikasikan!');
    }

    /**
     * Show the form for editing the specified article.
     */
    public function edit(Article $article)
    {
        return view('cms.articles.edit', compact('article'));
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'author_name' => 'nullable|string|max:100',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'status' => 'required|in:published,draft',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $data = $request->except('image');
        $data['category'] = $request->input('category') ?: 'Berita';
        $data['author_name'] = $request->input('author_name') ?: ($article->author_name ?: 'Admin eVoters');

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = $article->published_at ?: now();
        }

        // Update slug if title changed
        if ($request->title !== $article->title) {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $count = 1;
            while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            $data['slug'] = $slug;
        }

        // Auto excerpt if empty
        if (empty($data['excerpt'])) {
            $data['excerpt'] = Str::limit(strip_tags($request->content), 180);
        }

        // Process image upload
        if ($request->hasFile('image')) {
            // Remove old image if exists
            if ($article->image && file_exists(public_path($article->image))) {
                @unlink(public_path($article->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            
            if (!file_exists(public_path('uploads/articles'))) {
                mkdir(public_path('uploads/articles'), 0755, true);
            }
            
            $file->move(public_path('uploads/articles'), $filename);
            $data['image'] = 'uploads/articles/' . $filename;
        }

        $article->update($data);

        return redirect()->route('cms.articles.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(Article $article)
    {
        if ($article->image && file_exists(public_path($article->image))) {
            @unlink(public_path($article->image));
        }

        $article->delete();

        return redirect()->route('cms.articles.index')->with('success', 'Berita berhasil dihapus!');
    }
}
