<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{EducationalContent, Category};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index()
    {
        $contents = EducationalContent::with(['category', 'author'])
            ->withCount('bookmarks')
            ->latest()
            ->paginate(15);
        
        $categories = Category::active()->get();

        return view('admin.contents.index', compact('contents', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.contents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'type' => 'required|in:article,video,infographic,document',
            'featured_image' => 'nullable|image|max:2048',
            'video_url' => 'nullable|url',
            'file_path' => 'nullable|file|max:10240',
            'reading_time' => 'nullable|integer|min:1',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['created_by'] = auth()->id();

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('content-images', 'public');
        }

        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')
                ->store('content-files', 'public');
        }

        if ($request->is_published) {
            $validated['published_at'] = now();
        }

        EducationalContent::create($validated);

        return redirect()->route('admin.contents.index')
            ->with('success', 'Content created successfully!');
    }

    public function show(EducationalContent $content)
    {
        return view('admin.contents.show', compact('content'));
    }

    public function edit(EducationalContent $content)
    {
        $categories = Category::active()->get();
        return view('admin.contents.edit', compact('content', 'categories'));
    }

    public function update(Request $request, EducationalContent $content)
    {
        // Debug: Check what content is being received
        \Log::info('Content received:', ['content' => substr($request->content, 0, 500)]);
        
        if (strlen($request->content) < 50) {
            return back()->withErrors(['content' => 'Content seems too short. Please make sure your changes are saved in the editor.'])->withInput();
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'type' => 'required|in:article,video,infographic,document',
            'featured_image' => 'nullable|image|max:2048',
            'video_url' => 'nullable|url',
            'file_path' => 'nullable|file|max:10240',
            'reading_time' => 'nullable|integer|min:1',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        // Handle checkboxes that might not be present in request
        $validated['is_published'] = $request->has('is_published') ? 1 : 0;
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;

        if ($request->hasFile('featured_image')) {
            if ($content->featured_image) {
                Storage::disk('public')->delete($content->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')
                ->store('content-images', 'public');
        }

        if ($request->hasFile('file_path')) {
            if ($content->file_path) {
                Storage::disk('public')->delete($content->file_path);
            }
            $validated['file_path'] = $request->file('file_path')
                ->store('content-files', 'public');
        }

        if ($validated['is_published'] && !$content->is_published) {
            $validated['published_at'] = now();
        } elseif (!$validated['is_published']) {
            $validated['published_at'] = null;
        }

        \Log::info('Content before update:', ['content' => substr($validated['content'], 0, 500)]);
        $content->update($validated);
        \Log::info('Content after update:', ['content' => substr($content->fresh()->content, 0, 500)]);

        return redirect()->route('admin.contents.index')
            ->with('success', 'Content updated successfully!');
    }

    public function destroy(EducationalContent $content)
    {
        if ($content->featured_image) {
            Storage::disk('public')->delete($content->featured_image);
        }
        if ($content->file_path) {
            Storage::disk('public')->delete($content->file_path);
        }

        $content->delete();

        return redirect()->route('admin.contents.index')
            ->with('success', 'Content deleted successfully!');
    }
}