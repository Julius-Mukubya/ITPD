@extends(auth()->user()->role === 'counselor' ? 'layouts.counselor' : 'layouts.admin')

@section('title', 'Create Campaign')
@section('page-title', 'Create New Campaign')

@section('content')
<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Create Campaign</h2>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Add new awareness campaign to the system</p>
        </div>
        <a href="{{ route('admin.campaigns.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors text-center">
            Back to Campaigns
        </a>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 sm:p-6">



    @if ($errors->any())
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
            <div class="flex items-center gap-2 mb-2">
                <span class="material-symbols-outlined text-red-600 dark:text-red-400">error</span>
                <h3 class="font-semibold text-red-800 dark:text-red-200">Please fix the following errors:</h3>
            </div>
            <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.campaigns.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Campaign Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description *</label>
                <textarea name="description" rows="4" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">{{ old('description') }}</textarea>
                @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Campaign Type *</label>
                <select name="type" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    <option value="">Select Type</option>
                    <option value="awareness">Awareness Campaign</option>
                    <option value="workshop">Workshop</option>
                    <option value="webinar">Webinar</option>
                    <option value="event">Event</option>
                </select>
                @error('type')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Start Date *</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    @error('start_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Start Time</label>
                    <input type="time" name="start_time" value="{{ old('start_time') }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    @error('start_time')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">End Date *</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    @error('end_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">End Time</label>
                    <input type="time" name="end_time" value="{{ old('end_time') }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    @error('end_time')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Location (Optional)</label>
                <input type="text" name="location" value="{{ old('location') }}" placeholder="e.g., Main Hall, Online, Building A Room 101"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('location')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max Participants (Optional)</label>
                <input type="number" name="max_participants" value="{{ old('max_participants') }}" min="1" placeholder="Leave empty for unlimited"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('max_participants')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Detailed Content (Optional)</label>
                <textarea name="content" rows="6" placeholder="Add detailed information about the campaign..." class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">{{ old('content') }}</textarea>
                @error('content')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Contact Information Section -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">contact_support</span>
                    Contact Information
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Add one or more contacts for participants to reach out about this campaign.</p>
                
                <div id="contacts-container">
                    <!-- Initial contact form -->
                    <div class="contact-form border border-gray-200 dark:border-gray-600 rounded-lg p-4 mb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-medium text-gray-900 dark:text-white">Contact #1</h4>
                            <div class="flex items-center gap-2">
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="contacts[0][is_primary]" value="1" checked class="rounded">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Primary Contact</span>
                                </label>
                                <button type="button" class="remove-contact text-red-600 hover:text-red-800 hidden" onclick="removeContact(this)">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contact Name *</label>
                                <input type="text" name="contacts[0][name]" value="{{ old('contacts.0.name', 'Campaign Coordinator') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title/Role</label>
                                <input type="text" name="contacts[0][title]" value="{{ old('contacts.0.title') }}" 
                                    placeholder="e.g., Wellness Coordinator"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                                <input type="email" name="contacts[0][email]" value="{{ old('contacts.0.email', 'wellness@wellpath.edu') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone *</label>
                                <input type="tel" name="contacts[0][phone]" value="{{ old('contacts.0.phone', '+256 123 456 789') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Office Location</label>
                                <input type="text" name="contacts[0][office_location]" value="{{ old('contacts.0.office_location') }}" 
                                    placeholder="e.g., Student Wellness Center, Room 201"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Office Hours</label>
                                <input type="text" name="contacts[0][office_hours]" value="{{ old('contacts.0.office_hours') }}" 
                                    placeholder="e.g., Mon-Fri: 8:00 AM - 5:00 PM"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="button" id="add-contact" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined">add</span>
                    Add Another Contact
                </button>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Campaign Banner</label>
                
                <!-- Image Preview -->
                <div id="banner_preview_container" class="hidden mb-4">
                    <div class="relative w-full h-64 rounded-lg overflow-hidden border-2 border-primary bg-gray-100 dark:bg-gray-900">
                        <img id="banner_preview" src="" alt="Banner Preview" class="w-full h-full object-cover">
                        <button type="button" onclick="clearBannerPreview()" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-2 shadow-lg transition-all">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </button>
                    </div>
                </div>

                <input type="file" name="banner_image" accept="image/*" id="banner_input" onchange="previewBanner(event)"
                    class="block w-full text-sm text-gray-500 dark:text-gray-400
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-lg file:border-0
                    file:text-sm file:font-semibold
                    file:bg-primary file:text-white
                    hover:file:opacity-90 file:cursor-pointer">
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Recommended size: 1200x400px. Max 2MB</p>
                @error('banner')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-4">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="rounded">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Publish immediately</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Feature this campaign</span>
                </label>
            </div>

            <!-- Hidden status field that will be set based on publish checkbox -->
            <input type="hidden" name="status" value="draft">
        </div>

        <div class="flex gap-3 mt-8">
            <button type="submit" class="bg-primary text-white px-6 py-3 rounded-lg hover:opacity-90 font-semibold">Add Campaign</button>
            <a href="{{ route('admin.campaigns.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-3 rounded-lg hover:opacity-90 font-semibold">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
let contactIndex = 1;

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
    const input = document.getElementById('banner_input');
    const preview = document.getElementById('banner_preview');
    const container = document.getElementById('banner_preview_container');
    
    input.value = '';
    preview.src = '';
    container.classList.add('hidden');
}

function addContact() {
    const container = document.getElementById('contacts-container');
    const contactHtml = `
        <div class="contact-form border border-gray-200 dark:border-gray-600 rounded-lg p-4 mb-4">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-medium text-gray-900 dark:text-white">Contact #${contactIndex + 1}</h4>
                <div class="flex items-center gap-2">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="contacts[${contactIndex}][is_primary]" value="1" class="rounded primary-checkbox">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Primary Contact</span>
                    </label>
                    <button type="button" class="remove-contact text-red-600 hover:text-red-800" onclick="removeContact(this)">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contact Name *</label>
                    <input type="text" name="contacts[${contactIndex}][name]" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title/Role</label>
                    <input type="text" name="contacts[${contactIndex}][title]" 
                        placeholder="e.g., Wellness Coordinator"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                    <input type="email" name="contacts[${contactIndex}][email]" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone *</label>
                    <input type="tel" name="contacts[${contactIndex}][phone]" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Office Location</label>
                    <input type="text" name="contacts[${contactIndex}][office_location]" 
                        placeholder="e.g., Student Wellness Center, Room 201"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Office Hours</label>
                    <input type="text" name="contacts[${contactIndex}][office_hours]" 
                        placeholder="e.g., Mon-Fri: 8:00 AM - 5:00 PM"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', contactHtml);
    contactIndex++;
    updateRemoveButtons();
}

function removeContact(button) {
    const contactForm = button.closest('.contact-form');
    contactForm.remove();
    updateRemoveButtons();
    updateContactNumbers();
}

function updateRemoveButtons() {
    const contactForms = document.querySelectorAll('.contact-form');
    const removeButtons = document.querySelectorAll('.remove-contact');
    
    removeButtons.forEach(button => {
        button.classList.toggle('hidden', contactForms.length <= 1);
    });
}

function updateContactNumbers() {
    const contactForms = document.querySelectorAll('.contact-form');
    contactForms.forEach((form, index) => {
        const header = form.querySelector('h4');
        header.textContent = `Contact #${index + 1}`;
    });
}

function handlePrimaryCheckbox(checkbox) {
    if (checkbox.checked) {
        // Uncheck all other primary checkboxes
        document.querySelectorAll('.primary-checkbox').forEach(cb => {
            if (cb !== checkbox) {
                cb.checked = false;
            }
        });
    }
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
    
    // Add contact button
    document.getElementById('add-contact').addEventListener('click', addContact);
    
    // Primary checkbox handling
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('primary-checkbox')) {
            handlePrimaryCheckbox(e.target);
        }
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
