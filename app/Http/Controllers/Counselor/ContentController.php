<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\{EducationalContent, Category};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    /**
     * Display a listing of counselor's own content.
     */
    public function index()
    {
        $contents = EducationalContent::where('created_by', auth()->id())
            ->with(['category', 'author'])
            ->latest()
            ->paginate(10);

        return view('counselor.contents.index', compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('counselor.contents.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();
        $data['description'] = $request->excerpt; // Map excerpt to description
        $data['is_published'] = $request->has('is_published');
        $data['is_featured'] = $request->has('is_featured');

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('content-images', 'public');
        }

        EducationalContent::create($data);

        return redirect()->route('counselor.contents.index')
            ->with('success', 'Content created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EducationalContent $content)
    {
        // Ensure counselor can only view their own content
        if ($content->created_by !== auth()->id()) {
            abort(403, 'You can only view your own content.');
        }

        return view('counselor.contents.show', compact('content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EducationalContent $content)
    {
        // Ensure counselor can only edit their own content
        if ($content->created_by !== auth()->id()) {
            abort(403, 'You can only edit your own content.');
        }

        $categories = Category::all();
        return view('counselor.contents.edit', compact('content', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EducationalContent $content)
    {
        // Ensure counselor can only update their own content
        if ($content->created_by !== auth()->id()) {
            abort(403, 'You can only update your own content.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $data = $request->all();
        $data['description'] = $request->excerpt; // Map excerpt to description
        $data['is_published'] = $request->has('is_published');
        $data['is_featured'] = $request->has('is_featured');

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('content-images', 'public');
        }

        $content->update($data);

        return redirect()->route('counselor.contents.index')
            ->with('success', 'Content updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EducationalContent $content)
    {
        // Ensure counselor can only delete their own content
        if ($content->created_by !== auth()->id()) {
            abort(403, 'You can only delete your own content.');
        }

        $content->delete();

        return redirect()->route('counselor.contents.index')
            ->with('success', 'Content deleted successfully!');
    }
}
