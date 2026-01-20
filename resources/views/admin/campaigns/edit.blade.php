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
                    <option value="awareness" {{ old('type', $campaign->type) === 'awareness' ? 'selected' : '' }}>Awareness</option>
                    <option value="education" {{ old('type', $campaign->type) === 'education' ? 'selected' : '' }}>Education</option>
                    <option value="prevention" {{ old('type', $campaign->type) === 'prevention' ? 'selected' : '' }}>Prevention</option>
                    <option value="support" {{ old('type', $campaign->type) === 'support' ? 'selected' : '' }}>Support</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Status *
                </label>
                <select id="status" 
                        name="status"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white"
                        required>
                    <option value="draft" {{ old('status', $campaign->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="active" {{ old('status', $campaign->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="completed" {{ old('status', $campaign->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Featured Campaign -->
            <div class="md:col-span-2 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   name="is_featured" 
                                   value="1" 
                                   {{ old('is_featured', $campaign->is_featured) ? 'checked' : '' }}
                                   class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary focus:ring-2">
                            <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Featured Campaign</span>
                        </label>
                        <div class="ml-2">
                            <span class="text-xs text-gray-500 dark:text-gray-400 cursor-help" title="Featured campaigns appear prominently on the homepage and in featured sections">ⓘ</span>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $campaign->is_featured ? 'Currently featured' : 'Not featured' }}
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Featured campaigns are highlighted on the homepage and get priority placement in campaign listings.</p>
                @error('is_featured')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Banner Image -->
            <div class="md:col-span-2">
                <label for="banner_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Banner Image
                </label>
                @if($campaign->banner_image)
                    <div class="mb-3">
                        <img src="{{ $campaign->banner_url }}" alt="Current banner" class="w-32 h-20 object-cover rounded-lg">
                        <p class="text-sm text-gray-500 mt-1">Current banner image</p>
                    </div>
                @endif
                <input type="file" 
                       id="banner_image" 
                       name="banner_image" 
                       accept="image/*"
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                <p class="text-sm text-gray-500 mt-1">Upload a new image to replace the current banner</p>
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
    
    // Validate on form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!validateDateTime()) {
            e.preventDefault();
        }
    });
});
</script>
@endpush