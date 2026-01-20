@extends(auth()->user()->role === 'counselor' ? 'layouts.counselor' : 'layouts.admin')

@section('title', 'Create Content')
@section('page-title', 'Create New Content')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Create Content</h2>
            <p class="text-gray-600 dark:text-gray-400">Add new educational content to the system</p>
        </div>
        <a href="{{ route('admin.contents.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
            Back to Content
        </a>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">

    <form action="{{ route('admin.contents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category *</label>
                <select name="category_id" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type *</label>
                <select name="type" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    <option value="article" {{ old('type') == 'article' ? 'selected' : '' }}>Article</option>
                    <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video</option>
                    <option value="infographic" {{ old('type') == 'infographic' ? 'selected' : '' }}>Infographic</option>
                    <option value="document" {{ old('type') == 'document' ? 'selected' : '' }}>Document</option>
                </select>
                @error('type')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <span id="description-label">Description</span>
                </label>
                <textarea name="description" rows="3" id="description-field" placeholder="Brief summary of the content" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">{{ old('description') }}</textarea>
                @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <span id="content-label">Content</span> *
                </label>
                <div id="content-editor" class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">{{ old('content') }}</div>
                <textarea name="content" class="hidden">{{ old('content') }}</textarea>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" id="content-hint">Use the toolbar above to format your content with headings, bold, italic, lists, etc.</p>
                @error('content')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Featured Image</label>
                <div class="space-y-3">
                    <input type="file" name="featured_image" accept="image/*" id="featured_image" onchange="previewImage(event)"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    <div id="image_preview" class="hidden">
                        <div class="relative inline-block">
                            <img id="preview_img" src="" alt="Preview" class="max-w-full h-48 rounded-lg border-2 border-gray-300 dark:border-gray-600">
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
                <input type="number" name="reading_time" value="{{ old('reading_time') }}" min="1" placeholder="5" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('reading_time')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Video URL</label>
                <div class="space-y-3">
                    <input type="url" name="video_url" id="video_url" value="{{ old('video_url') }}" 
                        placeholder="https://youtube.com/watch?v=... or https://youtu.be/..." 
                        onchange="previewVideo()"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    <div id="video_preview" class="hidden">
                        <div class="relative">
                            <div class="aspect-video bg-gray-100 dark:bg-gray-900 rounded-lg overflow-hidden">
                                <iframe id="preview_video" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full"></iframe>
                            </div>
                            <button type="button" onclick="clearVideo()" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                <span class="material-symbols-outlined text-sm">close</span>
                            </button>
                        </div>
                    </div>
                </div>
                @error('video_url')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Attachment</label>
                <input type="file" name="file_path" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('file_path')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2 flex gap-4">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="rounded">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Publish immediately</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Feature this content</span>
                </label>
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <button type="submit" id="submit-btn" class="bg-primary text-white px-6 py-2 rounded-lg hover:opacity-90">Create Content</button>
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

console.log('Quill editor initialized:', quill);

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
    console.log('Form submission started...');
    
    // Sync content FIRST, before any validation
    var content = document.querySelector('textarea[name="content"]');
    var quillContent = quill.root.innerHTML;
    
    console.log('Quill content:', quillContent);
    
    if (content) {
        content.value = quillContent;
        console.log('Content synced to textarea');
    } else {
        console.error('Content textarea not found!');
    }
    
    // Check if content is empty (only contains empty tags)
    var textContent = quill.getText().trim();
    if (!textContent || textContent.length === 0) {
        e.preventDefault();
        showToast('Please enter some content before submitting.', 'error');
        return false;
    }
    
    // Check required fields
    const title = document.querySelector('input[name="title"]').value.trim();
    const category = document.querySelector('select[name="category_id"]').value;
    
    if (!title) {
        e.preventDefault();
        showToast('Please enter a title.', 'error');
        return false;
    }
    
    if (!category) {
        e.preventDefault();
        showToast('Please select a category.', 'error');
        return false;
    }
    
    console.log('Form validation passed, submitting...');
    showToast('Creating content...', 'info');
});

// Also sync content when the Quill editor content changes
quill.on('text-change', function() {
    var content = document.querySelector('textarea[name="content"]');
    if (content) {
        content.value = quill.root.innerHTML;
    }
});

// Debug button click
document.getElementById('submit-btn').addEventListener('click', function(e) {
    console.log('Submit button clicked!');
});

// Also add debugging to DOMContentLoaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, checking form...');
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submit-btn');
    
    console.log('Form found:', form);
    console.log('Submit button found:', submitBtn);
    console.log('Form action:', form ? form.action : 'No form');
    console.log('Form method:', form ? form.method : 'No form');
});

// Dynamic Label Updates Based on Content Type
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.querySelector('select[name="type"]');
    
    if (typeSelect) {
        typeSelect.addEventListener('change', updateLabels);
        // Set initial labels based on default selection
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

// Video Preview
function previewVideo() {
    const url = document.getElementById('video_url').value;
    if (url) {
        let embedUrl = '';
        
        // YouTube URL patterns
        const youtubeRegex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
        const match = url.match(youtubeRegex);
        
        if (match && match[1]) {
            embedUrl = `https://www.youtube.com/embed/${match[1]}`;
        }
        // Vimeo URL pattern
        else if (url.includes('vimeo.com/')) {
            const vimeoId = url.split('vimeo.com/')[1].split(/[?&]/)[0];
            embedUrl = `https://player.vimeo.com/video/${vimeoId}`;
        }
        // Direct embed URL
        else if (url.includes('embed')) {
            embedUrl = url;
        }
        
        if (embedUrl) {
            document.getElementById('preview_video').src = embedUrl;
            document.getElementById('video_preview').classList.remove('hidden');
        } else {
            showToast('Please enter a valid YouTube or Vimeo URL', 'error');
        }
    }
}

function clearVideo() {
    document.getElementById('video_url').value = '';
    document.getElementById('video_preview').classList.add('hidden');
    document.getElementById('preview_video').src = '';
}
</script>
@endpush
