@extends(auth()->user()->role === 'counselor' ? 'layouts.counselor' : 'layouts.admin')

@section('title', 'Edit Campaign')
@section('page-title', 'Edit Campaign')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Campaign</h2>
            <p class="text-gray-600 dark:text-gray-400">Update campaign details and settings</p>
        </div>
        <a href="{{ route('admin.campaigns.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
            Back to Campaigns
        </a>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
    <form method="POST" action="{{ route('admin.campaigns.update', $campaign) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Title -->
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Campaign Title *
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $campaign->title) }}"
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white"
                       required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Description *
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white"
                          required>{{ old('description', $campaign->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Start Date -->
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Start Date *
                </label>
                <input type="date" 
                       id="start_date" 
                       name="start_date" 
                       value="{{ old('start_date', $campaign->start_date->format('Y-m-d')) }}"
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white"
                       required>
                @error('start_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Start Time -->
            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Start Time
                </label>
                <input type="time" 
                       id="start_time" 
                       name="start_time" 
                       value="{{ old('start_time', $campaign->start_time ? \Carbon\Carbon::parse($campaign->start_time)->format('H:i') : '') }}"
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                @error('start_time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- End Date -->
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    End Date *
                </label>
                <input type="date" 
                       id="end_date" 
                       name="end_date" 
                       value="{{ old('end_date', $campaign->end_date->format('Y-m-d')) }}"
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white"
                       required>
                @error('end_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- End Time -->
            <div>
                <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    End Time
                </label>
                <input type="time" 
                       id="end_time" 
                       name="end_time" 
                       value="{{ old('end_time', $campaign->end_time ? \Carbon\Carbon::parse($campaign->end_time)->format('H:i') : '') }}"
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                @error('end_time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Campaign Type
                </label>
                <select id="type" 
                        name="type"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                    <option value="">Select Type</option>
                    <option value="awareness" {{ old('type', $campaign->type) === 'awareness' ? 'selected' : '' }}>Awareness Campaign</option>
                    <option value="workshop" {{ old('type', $campaign->type) === 'workshop' ? 'selected' : '' }}>Workshop</option>
                    <option value="webinar" {{ old('type', $campaign->type) === 'webinar' ? 'selected' : '' }}>Webinar</option>
                    <option value="event" {{ old('type', $campaign->type) === 'event' ? 'selected' : '' }}>Event</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Publishing Options -->
            <div class="md:col-span-2 flex gap-4">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $campaign->status === 'active') ? 'checked' : '' }} class="rounded">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Publish immediately</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $campaign->is_featured) ? 'checked' : '' }} class="rounded">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Feature this campaign</span>
                </label>
            </div>

            <!-- Hidden status field that will be set based on publish checkbox -->
            <input type="hidden" name="status" value="{{ $campaign->status }}">

            <!-- Location -->
            <div class="md:col-span-2">
                <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Location (Optional)
                </label>
                <input type="text" 
                       id="location" 
                       name="location" 
                       value="{{ old('location', $campaign->location) }}"
                       placeholder="e.g., Main Hall, Online, Building A Room 101"
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                @error('location')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Max Participants -->
            <div>
                <label for="max_participants" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Max Participants (Optional)
                </label>
                <input type="number" 
                       id="max_participants" 
                       name="max_participants" 
                       value="{{ old('max_participants', $campaign->max_participants) }}"
                       min="1"
                       placeholder="Leave empty for unlimited"
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                @error('max_participants')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Detailed Content -->
            <div class="md:col-span-2">
                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Detailed Content (Optional)
                </label>
                <textarea id="content" 
                          name="content" 
                          rows="6"
                          placeholder="Add detailed information about the campaign..."
                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">{{ old('content', $campaign->content) }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contact Information Section -->
            <div class="md:col-span-2 border-t border-gray-200 dark:border-gray-700 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">contact_support</span>
                    Contact Information
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Provide contact details for participants to reach out about this campaign.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contact Email *</label>
                        <input type="email" name="contact_email" value="{{ old('contact_email', $campaign->contact_email ?? 'wellness@wellpath.edu') }}" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                        @error('contact_email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contact Phone *</label>
                        <input type="tel" name="contact_phone" value="{{ old('contact_phone', $campaign->contact_phone ?? '+256 123 456 789') }}" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                        @error('contact_phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Office Location (Optional)</label>
                        <input type="text" name="contact_office" value="{{ old('contact_office', $campaign->contact_office) }}" 
                            placeholder="e.g., Student Wellness Center, Room 201"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                        @error('contact_office')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Office Hours (Optional)</label>
                        <input type="text" name="contact_hours" value="{{ old('contact_hours', $campaign->contact_hours) }}" 
                            placeholder="e.g., Mon-Fri: 8:00 AM - 5:00 PM"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                        @error('contact_hours')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>


            <!-- Banner Image -->
            <div class="md:col-span-2">
                <label for="banner_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Banner Image
                </label>
                
                <!-- Current Image -->
                @if($campaign->banner_image)
                    <div class="mb-4">
                        <div class="relative w-full h-64 rounded-lg overflow-hidden border-2 border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-900">
                            <img id="current_banner" src="{{ $campaign->banner_url }}" alt="Current banner" class="w-full h-full object-cover">
                            <div class="absolute top-2 left-2 bg-black/50 text-white px-2 py-1 rounded text-xs">Current Image</div>
                        </div>
                    </div>
                @endif

                <!-- Image Preview for New Upload -->
                <div id="banner_preview_container" class="hidden mb-4">
                    <div class="relative w-full h-64 rounded-lg overflow-hidden border-2 border-primary bg-gray-100 dark:bg-gray-900">
                        <img id="banner_preview" src="" alt="Banner Preview" class="w-full h-full object-cover">
                        <div class="absolute top-2 left-2 bg-primary text-white px-2 py-1 rounded text-xs">New Image Preview</div>
                        <button type="button" onclick="clearBannerPreview()" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-2 shadow-lg transition-all">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </button>
                    </div>
                </div>

                <input type="file" 
                       id="banner_image" 
                       name="banner_image" 
                       accept="image/*"
                       onchange="previewBanner(event)"
                       class="block w-full text-sm text-gray-500 dark:text-gray-400
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-lg file:border-0
                       file:text-sm file:font-semibold
                       file:bg-primary file:text-white
                       hover:file:opacity-90 file:cursor-pointer">
                <p class="text-sm text-gray-500 mt-1">Upload a new image to replace the current banner. Recommended size: 1200x400px. Max 2MB</p>
                @error('banner_image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end space-x-4 mt-8">
            <a href="{{ route('admin.campaigns.index') }}" class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">
                Update Campaign
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewBanner(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('banner_preview');
            const container = document.getElementById('banner_preview_container');
            
            preview.src = e.target.result;
            container.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

function clearBannerPreview() {
    const input = document.getElementById('banner_image');
    const preview = document.getElementById('banner_preview');
    const container = document.getElementById('banner_preview_container');
    
    input.value = '';
    preview.src = '';
    container.classList.add('hidden');
}

function validateDateTime() {
    const startDate = document.querySelector('input[name="start_date"]').value;
    const startTime = document.querySelector('input[name="start_time"]').value || '00:00';
    const endDate = document.querySelector('input[name="end_date"]').value;
    const endTime = document.querySelector('input[name="end_time"]').value || '23:59';
    
    if (startDate && endDate) {
        const startDateTime = new Date(startDate + 'T' + startTime);
        const endDateTime = new Date(endDate + 'T' + endTime);
        
        const endDateInput = document.querySelector('input[name="end_date"]');
        const existingError = endDateInput.parentNode.querySelector('.datetime-error');
        
        if (endDateTime <= startDateTime) {
            if (!existingError) {
                const errorMsg = document.createElement('p');
                errorMsg.className = 'text-red-500 text-sm mt-1 datetime-error';
                errorMsg.textContent = 'The end date and time must be after the start date and time.';
                endDateInput.parentNode.appendChild(errorMsg);
            }
            endDateInput.classList.add('border-red-500');
            return false;
        } else {
            if (existingError) {
                existingError.remove();
            }
            endDateInput.classList.remove('border-red-500');
            return true;
        }
    }
    return true;
}

// Add event listeners for real-time validation
document.addEventListener('DOMContentLoaded', function() {
    const dateTimeInputs = document.querySelectorAll('input[name="start_date"], input[name="start_time"], input[name="end_date"], input[name="end_time"]');
    dateTimeInputs.forEach(input => {
        input.addEventListener('change', validateDateTime);
        input.addEventListener('blur', validateDateTime);
    });
    
    // Handle form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        // Set status based on publish checkbox
        const isPublished = document.querySelector('input[name="is_published"]').checked;
        const statusField = document.querySelector('input[name="status"]');
        
        if (isPublished) {
            statusField.value = 'active';
        } else {
            statusField.value = 'draft';
        }
        
        // Validate date/time before submitting
        if (!validateDateTime()) {
            e.preventDefault();
        }
    });
});
</script>
@endpush