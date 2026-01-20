@extends(auth()->user()->role === 'counselor' ? 'layouts.counselor' : 'layouts.admin')

@section('title', 'Edit Content')
@section('page-title', 'Edit Content')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Content</h2>
            <p class="text-gray-600 dark:text-gray-400">Update educational content information</p>
        </div>
        <a href="{{ route('admin.contents.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
            Back to Content
        </a>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
            <strong>Please fix the following errors:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.contents.update', $content) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title *</label>
                <input type="text" name="title" value="{{ old('title', $content->title) }}" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category *</label>
                <select name="category_id" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $content->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type *</label>
                <select name="type" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    <option value="article" {{ old('type', $content->type) == 'article' ? 'selected' : '' }}>Article</option>
                    <option value="video" {{ old('type', $content->type) == 'video' ? 'selected' : '' }}>Video</option>
                    <option value="infographic" {{ old('type', $content->type) == 'infographic' ? 'selected' : '' }}>Infographic</option>
                    <option value="document" {{ old('type', $content->type) == 'document' ? 'selected' : '' }}>Document</option>
                </select>
                @error('type')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <span id="description-label">Description</span>
                </label>
                <textarea name="description" rows="3" id="description-field" placeholder="Brief summary of the content" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">{{ old('description', $content->description) }}</textarea>
                @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <span id="content-label">Content</span> *
                </label>
                <div id="content-editor" class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg"></div>
                <textarea name="content" class="hidden" required>{{ old('content', $content->content) }}</textarea>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" id="content-hint">Use the toolbar above to format your content with headings, bold, italic, lists, etc.</p>
                @error('content')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Featured Image</label>
                <div class="space-y-3">
                    @if($content->featured_image)
                    <div class="relative inline-block" id="current_image">
                        <img src="{{ asset('storage/' . $content->featured_image) }}" alt="Current" class="max-w-full h-48 rounded-lg border-2 border-gray-300 dark:border-gray-600">
                        <div class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">Current Image</div>
                    </div>
                    @endif
                    <input type="file" name="featured_image" accept="image/*" id="featured_image" onchange="previewImage(event)"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    <div id="image_preview" class="hidden">
                        <div class="relative inline-block">
                            <img id="preview_img" src="" alt="Preview" class="max-w-full h-48 rounded-lg border-2 border-green-500">
                            <div class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded">New Image</div>
                            <button type="button" onclick="clearImage()" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                <span class="material-symbols-outlined text-sm">close</span>
                            </button>
                        </div>
                    </div>
                </div>
                @error('featured_image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <span id="time-label">Reading Time</span> (minutes)
                </label>
                <input type="number" name="reading_time" value="{{ old('reading_time', $content->reading_time) }}" min="1" placeholder="5" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('reading_time')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2 flex gap-4">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $content->is_published) ? 'checked' : '' }} class="rounded">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Published</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $content->is_featured) ? 'checked' : '' }} class="rounded">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Featured</span>
                </label>
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:opacity-90">Update Content</button>
            <a href="{{ route('admin.contents.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg hover:opacity-90">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('styles')
<!-- Quill Rich Text Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .ql-container {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        height: 400px;
    }
    .ql-editor {
        font-size: 16px;
        max-height: 400px;
        overflow-y: auto;
    }
    
    /* Match frontend paragraph spacing in editor */
    .ql-editor p {
        margin-top: 1em;
        margin-bottom: 1em;
    }
    
    .ql-editor p:first-child {
        margin-top: 0;
    }
    
    .ql-editor p:last-child {
        margin-bottom: 0;
    }
    
    .ql-editor br {
        display: block;
        margin: 0.5em 0;
        content: "";
    }
    
    .ql-editor p:empty {
        margin: 0.5em 0;
        min-height: 1em;
    }
    #content-editor {
        height: 450px;
    }
    
    /* Better tooltip styling for native title attribute */
    .ql-toolbar button,
    .ql-toolbar .ql-picker-label {
        cursor: pointer;
    }
</style>
@endpush

@push('scripts')
<!-- Quill Rich Text Editor JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
// Get existing content
var existingContent = document.querySelector('textarea[name="content"]').value;
console.log('Content from textarea:', existingContent.substring(0, 100) + '...');

// Initialize Quill Editor
var quill = new Quill('#content-editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'indent': '-1'}, { 'indent': '+1' }],
            [{ 'align': [] }],
            [{ 'color': [] }, { 'background': [] }],
            ['link', 'image'],
            ['blockquote', 'code-block'],
            ['clean']
        ]
    },
    placeholder: 'Write your content here...'
});

// Load existing content into editor
if (existingContent) {
    quill.root.innerHTML = existingContent;
    console.log('Loaded existing content into Quill:', existingContent.substring(0, 100) + '...');
} else {
    console.log('No existing content found');
}

// Add tooltips to toolbar buttons after Quill is fully initialized
function addToolbarTooltips() {
    const toolbar = document.querySelector('.ql-toolbar');
    if (!toolbar) {
        console.log('Toolbar not found, retrying...');
        setTimeout(addToolbarTooltips, 200);
        return;
    }
    
    console.log('Adding tooltips to Quill toolbar...');
    
    // Format buttons
    const boldBtn = toolbar.querySelector('.ql-bold');
    if (boldBtn) {
        boldBtn.setAttribute('title', 'Bold (Ctrl+B)');
        boldBtn.setAttribute('aria-label', 'Bold');
    }
    
    const italicBtn = toolbar.querySelector('.ql-italic');
    if (italicBtn) {
        italicBtn.setAttribute('title', 'Italic (Ctrl+I)');
        italicBtn.setAttribute('aria-label', 'Italic');
    }
    
    const underlineBtn = toolbar.querySelector('.ql-underline');
    if (underlineBtn) {
        underlineBtn.setAttribute('title', 'Underline (Ctrl+U)');
        underlineBtn.setAttribute('aria-label', 'Underline');
    }
    
    const strikeBtn = toolbar.querySelector('.ql-strike');
    if (strikeBtn) {
        strikeBtn.setAttribute('title', 'Strikethrough');
        strikeBtn.setAttribute('aria-label', 'Strikethrough');
    }
    
    // List buttons
    const orderedList = toolbar.querySelector('.ql-list[value="ordered"]');
    if (orderedList) {
        orderedList.setAttribute('title', 'Numbered List');
        orderedList.setAttribute('aria-label', 'Numbered List');
    }
    
    const bulletList = toolbar.querySelector('.ql-list[value="bullet"]');
    if (bulletList) {
        bulletList.setAttribute('title', 'Bullet List');
        bulletList.setAttribute('aria-label', 'Bullet List');
    }
    
    // Indent buttons
    const decreaseIndent = toolbar.querySelector('.ql-indent[value="-1"]');
    if (decreaseIndent) {
        decreaseIndent.setAttribute('title', 'Decrease Indent');
        decreaseIndent.setAttribute('aria-label', 'Decrease Indent');
    }
    
    const increaseIndent = toolbar.querySelector('.ql-indent[value="+1"]');
    if (increaseIndent) {
        increaseIndent.setAttribute('title', 'Increase Indent');
        increaseIndent.setAttribute('aria-label', 'Increase Indent');
    }
    
    // Align buttons
    const alignBtns = toolbar.querySelectorAll('.ql-align');
    alignBtns.forEach(btn => {
        const value = btn.getAttribute('value');
        if (value === 'center') {
            btn.setAttribute('title', 'Align Center');
            btn.setAttribute('aria-label', 'Align Center');
        } else if (value === 'right') {
            btn.setAttribute('title', 'Align Right');
            btn.setAttribute('aria-label', 'Align Right');
        } else if (value === 'justify') {
            btn.setAttribute('title', 'Justify');
            btn.setAttribute('aria-label', 'Justify');
        } else {
            btn.setAttribute('title', 'Align Left');
            btn.setAttribute('aria-label', 'Align Left');
        }
    });
    
    // Other buttons
    const linkBtn = toolbar.querySelector('.ql-link');
    if (linkBtn) {
        linkBtn.setAttribute('title', 'Insert Link');
        linkBtn.setAttribute('aria-label', 'Insert Link');
    }
    
    const imageBtn = toolbar.querySelector('.ql-image');
    if (imageBtn) {
        imageBtn.setAttribute('title', 'Insert Image');
        imageBtn.setAttribute('aria-label', 'Insert Image');
    }
    
    const blockquoteBtn = toolbar.querySelector('.ql-blockquote');
    if (blockquoteBtn) {
        blockquoteBtn.setAttribute('title', 'Blockquote');
        blockquoteBtn.setAttribute('aria-label', 'Blockquote');
    }
    
    const codeBlockBtn = toolbar.querySelector('.ql-code-block');
    if (codeBlockBtn) {
        codeBlockBtn.setAttribute('title', 'Code Block');
        codeBlockBtn.setAttribute('aria-label', 'Code Block');
    }
    
    const cleanBtn = toolbar.querySelector('.ql-clean');
    if (cleanBtn) {
        cleanBtn.setAttribute('title', 'Remove Formatting');
        cleanBtn.setAttribute('aria-label', 'Remove Formatting');
    }
    
    // Picker labels (dropdowns)
    const headerPicker = toolbar.querySelector('.ql-header .ql-picker-label');
    if (headerPicker) {
        headerPicker.setAttribute('title', 'Heading Style');
        headerPicker.setAttribute('aria-label', 'Heading Style');
    }
    
    const colorPicker = toolbar.querySelector('.ql-color .ql-picker-label');
    if (colorPicker) {
        colorPicker.setAttribute('title', 'Text Color');
        colorPicker.setAttribute('aria-label', 'Text Color');
    }
    
    const backgroundPicker = toolbar.querySelector('.ql-background .ql-picker-label');
    if (backgroundPicker) {
        backgroundPicker.setAttribute('title', 'Background Color');
        backgroundPicker.setAttribute('aria-label', 'Background Color');
    }
    
    console.log('Tooltips added successfully!');
}

// Start adding tooltips
addToolbarTooltips();

// Sync Quill content with hidden textarea on form submit
document.querySelector('form').addEventListener('submit', function(e) {
    var content = document.querySelector('textarea[name="content"]');
    var quillHTML = quill.root.innerHTML;
    content.value = quillHTML;
    
    // Debug: Log the content being submitted
    console.log('Submitting content:', quillHTML.substring(0, 200) + '...');
    console.log('Textarea value set to:', content.value.substring(0, 200) + '...');
    
    // Double check that the content is not empty
    if (!quillHTML || quillHTML.trim() === '<p><br></p>' || quillHTML.trim() === '') {
        alert('Content cannot be empty!');
        e.preventDefault();
        return false;
    }
});

// Also sync on any content change to ensure it's always up to date
quill.on('text-change', function() {
    var content = document.querySelector('textarea[name="content"]');
    content.value = quill.root.innerHTML;
    console.log('Content changed, synced to textarea');
});

// Dynamic Label Updates Based on Content Type
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.querySelector('select[name="type"]');
    
    if (typeSelect) {
        typeSelect.addEventListener('change', updateLabels);
        // Set initial labels based on current content type
        updateLabels();
    }
    
    function updateLabels() {
        const type = typeSelect.value;
        const descriptionLabel = document.getElementById('description-label');
        const descriptionField = document.getElementById('description-field');
        const contentLabel = document.getElementById('content-label');
        const contentHint = document.getElementById('content-hint');
        const timeLabel = document.getElementById('time-label');
        
        switch(type) {
            case 'video':
                if (descriptionLabel) descriptionLabel.textContent = 'Video Summary';
                if (descriptionField) descriptionField.placeholder = 'Brief summary of what viewers will learn';
                if (contentLabel) contentLabel.textContent = 'Video Description';
                if (contentHint) contentHint.textContent = 'Describe what the video covers and what viewers will learn';
                if (timeLabel) timeLabel.textContent = 'Watch Time';
                break;
                
            case 'infographic':
                if (descriptionLabel) descriptionLabel.textContent = 'Infographic Summary';
                if (descriptionField) descriptionField.placeholder = 'Brief overview of the infographic content';
                if (contentLabel) contentLabel.textContent = 'Infographic Details';
                if (contentHint) contentHint.textContent = 'Provide context and explanation for the visual content';
                if (timeLabel) timeLabel.textContent = 'View Time';
                break;
                
            case 'document':
                if (descriptionLabel) descriptionLabel.textContent = 'Document Summary';
                if (descriptionField) descriptionField.placeholder = 'Brief overview of the document';
                if (contentLabel) contentLabel.textContent = 'Document Overview';
                if (contentHint) contentHint.textContent = 'Provide an overview of what the document contains';
                if (timeLabel) timeLabel.textContent = 'Reading Time';
                break;
                
            default: // article
                if (descriptionLabel) descriptionLabel.textContent = 'Description';
                if (descriptionField) descriptionField.placeholder = 'Brief summary of the content';
                if (contentLabel) contentLabel.textContent = 'Content';
                if (contentHint) contentHint.textContent = 'Use the toolbar above to format your content with headings, bold, italic, lists, etc.';
                if (timeLabel) timeLabel.textContent = 'Reading Time';
                break;
        }
    }
});

// Image Preview
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview_img').src = e.target.result;
            document.getElementById('image_preview').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

function clearImage() {
    document.getElementById('featured_image').value = '';
    document.getElementById('image_preview').classList.add('hidden');
    document.getElementById('preview_img').src = '';
}
</script>
@endpush
