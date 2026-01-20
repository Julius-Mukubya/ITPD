<?php

namespace App\Http\Controllers;

use App\Models\{EducationalContent, Category, ContentView};
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $query = EducationalContent::published()->with(['category', 'author']);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $contents = $query->latest('published_at')->paginate(12);
        $categories = Category::active()->get();

        return view('public.content.index', compact('contents', 'categories'));
    }

    public function show(EducationalContent $content)
    {
        // Check if published or user is admin
        if (!$content->is_published && !(auth()->user() && auth()->user()->isAdmin())) {
            abort(404);
        }

        // Track view
        ContentView::create([
            'content_id' => $content->id,
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'viewed_at' => now(),
        ]);

        $content->incrementViews();
        $content->load('category', 'author');

        // Get related content
        $relatedContents = EducationalContent::published()
            ->where('category_id', $content->category_id)
            ->where('id', '!=', $content->id)
            ->latest()
            ->take(4)
            ->get();

        // Return view with cache-busting headers
        return response()
            ->view('public.content.show', compact('content', 'relatedContents'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function searchSuggestions(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = EducationalContent::published()
            ->where(function($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%');
            })
            ->with('category')
            ->select('id', 'title', 'description', 'type', 'category_id', 'reading_time')
            ->orderByRaw("CASE WHEN title LIKE ? THEN 1 ELSE 2 END", [$query . '%'])
            ->orderBy('views', 'desc')
            ->take(8)
            ->get()
            ->map(function($content) {
                return [
                    'id' => $content->id,
                    'title' => $content->title,
                    'description' => \Str::limit($content->description, 80),
                    'type' => $content->type,
                    'category' => $content->category->name,
                    'url' => route('content.show', $content->id),
                    'reading_time' => $content->reading_time
                ];
            });

        return response()->json($suggestions);
    }
}