@extends('layouts.counselor')

@section('title', 'Contact Setup - Counselor')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-2xl sm:text-3xl font-bold tracking-tight">Contact Setup</p>
        <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">Manage your contact information for student communication</p>
    </div>
</div>

<!-- Basic Contact Information -->
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm mb-6">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
            <span class="material-symbols-outlined text-blue-600">contact_phone</span>
            Basic Contact Information
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Primary contact details for student communication
        </p>
    </div>
    
    <div class="p-6 space-y-4">
        <!-- Phone Number -->
        <div class="flex items-center gap-4">
            <div class="flex-1">
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Phone Number
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 material-symbols-outlined text-gray-400">phone</span>
                    <input type="tel" id="phone" 
                           value="{{ $user->phone }}"
                           placeholder="+256 700 000 000"
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                </div>
            </div>
            <div class="flex flex-col gap-2 pt-7">
                <button onclick="saveField('phone')" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 text-sm font-medium flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Save
                </button>
            </div>
        </div>

        <!-- WhatsApp Number -->
        <div class="flex items-center gap-4">
            <div class="flex-1">
                <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    WhatsApp Number
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 material-symbols-outlined text-gray-400">chat</span>
                    <input type="tel" id="whatsapp_number" 
                           value="{{ $user->whatsapp_number }}"
                           placeholder="+256 700 000 000"
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                </div>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Can be the same as phone number if you use WhatsApp on your main number
                </p>
            </div>
            <div class="flex flex-col gap-2 pt-7">
                <button onclick="saveField('whatsapp_number')" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 text-sm font-medium flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Save
                </button>
            </div>
        </div>

        <!-- Email -->
        <div class="flex items-center gap-4">
            <div class="flex-1">
                <label for="counselor_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Contact Email
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 material-symbols-outlined text-gray-400">email</span>
                    <input type="email" id="counselor_email" 
                           value="{{ $user->counselor_email ?: $user->email }}"
                           placeholder="your.email@example.com"
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                </div>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Email address students can use to contact you directly
                </p>
            </div>
            <div class="flex flex-col gap-2 pt-7">
                <button onclick="saveField('counselor_email')" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 text-sm font-medium flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Office Information -->
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm mb-6">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
            <span class="material-symbols-outlined text-green-600">location_on</span>
            Office Information
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Physical office details for in-person consultations
        </p>
    </div>
    
    <div class="p-6 space-y-4">
        <!-- Office Phone -->
        <div class="flex items-center gap-4">
            <div class="flex-1">
                <label for="office_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Office Phone
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 material-symbols-outlined text-gray-400">business</span>
                    <input type="tel" id="office_phone" 
                           value="{{ $user->office_phone }}"
                           placeholder="+256 414 000 000"
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                </div>
            </div>
            <div class="flex flex-col gap-2 pt-7">
                <button onclick="saveField('office_phone')" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 text-sm font-medium flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Save
                </button>
            </div>
        </div>

        <!-- Office Address -->
        <div class="flex items-start gap-4">
            <div class="flex-1">
                <label for="office_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Office Address
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-3 material-symbols-outlined text-gray-400">place</span>
                    <textarea id="office_address" rows="3"
                              placeholder="Building name, floor, room number, street address, city..."
                              class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white resize-none">{{ $user->office_address }}</textarea>
                </div>
            </div>
            <div class="flex flex-col gap-2 pt-7">
                <button onclick="saveField('office_address')" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 text-sm font-medium flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Custom Contact Information -->
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm mb-6">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-purple-600">add_circle</span>
                    Custom Contact Information
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Add additional contact methods like Telegram, LinkedIn, etc.
                </p>
            </div>
            <button onclick="showAddCustomModal()" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 text-sm font-medium flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">add</span>
                Add Custom
            </button>
        </div>
    </div>
    
    <div class="p-6">
        <div id="custom-contacts-list" class="space-y-4">
            @if($user->custom_contact_info)
                @foreach($user->custom_contact_info as $key => $contact)
                <div class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg" data-key="{{ $key }}">
                    <div class="flex items-center gap-3 flex-1">
                        <span class="material-symbols-outlined text-purple-600">{{ $contact['icon'] ?? 'contact_page' }}</span>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $contact['label'] }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $contact['value'] }}</p>
                        </div>
                    </div>
                    <button onclick="deleteCustomContact('{{ $key }}')" class="text-red-600 hover:text-red-700 p-1">
                        <span class="material-symbols-outlined text-sm">delete</span>
                    </button>
                </div>
                @endforeach
            @else
                <div id="no-custom-contacts" class="text-center py-8">
                    <span class="material-symbols-outlined text-4xl text-gray-300 dark:text-gray-600 mb-2">contact_page</span>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">No custom contact information added yet</p>
                    <button onclick="showAddCustomModal()" class="text-purple-600 hover:underline text-sm mt-1">
                        Add your first custom contact
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Default Meeting Links -->
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm mb-6">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-600">videocam</span>
                    Default Meeting Links
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Set up your default meeting links that will be pre-populated in sessions
                </p>
            </div>
            <button onclick="showAddMeetingModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">add</span>
                Add Meeting Link
            </button>
        </div>
    </div>
    
    <div class="p-6">
        <div id="meeting-links-list" class="space-y-4">
            @if($user->default_meeting_links)
                @foreach($user->default_meeting_links as $key => $meeting)
                <div class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg" data-key="{{ $key }}">
                    <div class="flex items-center gap-3 flex-1">
                        <span class="material-symbols-outlined text-blue-600">
                            @if($meeting['type'] === 'zoom') videocam
                            @elseif($meeting['type'] === 'google_meet') video_call
                            @elseif($meeting['type'] === 'whatsapp') chat
                            @elseif($meeting['type'] === 'phone_call') call
                            @elseif($meeting['type'] === 'physical') location_on
                            @else videocam
                            @endif
                        </span>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ ucfirst(str_replace('_', ' ', $meeting['type'])) }}
                                @if($meeting['label']) - {{ $meeting['label'] }} @endif
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 break-all">{{ $meeting['link'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="copyMeetingLink('{{ $meeting['link'] }}')" class="text-blue-600 hover:text-blue-700 p-1" title="Copy Link">
                            <span class="material-symbols-outlined text-sm">content_copy</span>
                        </button>
                        <button onclick="deleteMeetingLink('{{ $key }}')" class="text-red-600 hover:text-red-700 p-1" title="Delete">
                            <span class="material-symbols-outlined text-sm">delete</span>
                        </button>
                    </div>
                </div>
                @endforeach
            @else
                <div id="no-meeting-links" class="text-center py-8">
                    <span class="material-symbols-outlined text-4xl text-gray-300 dark:text-gray-600 mb-2">videocam</span>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">No default meeting links added yet</p>
                    <button onclick="showAddMeetingModal()" class="text-blue-600 hover:underline text-sm mt-1">
                        Add your first meeting link
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Availability Hours (Keep the existing bulk save for this complex section) -->
<form action="{{ route('counselor.contact-setup.update') }}" method="POST">
    @csrf
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-orange-600">schedule</span>
                Availability Hours
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Let students know when you're typically available for contact
            </p>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @php
                    $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                    $dayLabels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                    $availabilityHours = $user->availability_hours ?: [];
                @endphp
                
                @foreach($days as $index => $day)
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-3">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ $dayLabels[$index] }}
                        </label>
                        <input type="checkbox" name="availability_hours[{{ $day }}][enabled]" value="1"
                               {{ isset($availabilityHours[$day]['enabled']) ? 'checked' : '' }}
                               class="text-primary border-gray-300 rounded focus:ring-primary"
                               onchange="toggleDayInputs('{{ $day }}')">
                    </div>
                    
                    <div id="{{ $day }}-inputs" class="space-y-2 {{ isset($availabilityHours[$day]['enabled']) ? '' : 'opacity-50 pointer-events-none' }}">
                        <div>
                            <label class="text-xs text-gray-500 dark:text-gray-400">From</label>
                            <input type="time" name="availability_hours[{{ $day }}][from]" 
                                   value="{{ $availabilityHours[$day]['from'] ?? '09:00' }}"
                                   class="w-full text-sm px-2 py-1 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-primary dark:bg-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 dark:text-gray-400">To</label>
                            <input type="time" name="availability_hours[{{ $day }}][to]" 
                                   value="{{ $availabilityHours[$day]['to'] ?? '17:00' }}"
                                   class="w-full text-sm px-2 py-1 border border-gray-300 dark:border-gray-600 rounded focus:ring-1 focus:ring-primary dark:bg-gray-600 dark:text-white">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <p class="text-sm text-blue-800 dark:text-blue-200 flex items-start gap-2">
                    <span class="material-symbols-outlined text-sm mt-0.5">info</span>
                    <span>These hours will be displayed to students as your general availability. Actual session scheduling may vary based on your calendar and student needs.</span>
                </p>
            </div>

            <!-- Save Button for Availability Hours -->
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-700 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    Save Availability Hours
                </button>
            </div>
        </div>
    </div>
</form>

<!-- Add Custom Contact Modal -->
<div id="addCustomModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 max-w-md w-full">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Add Custom Contact</h3>
        
        <form id="addCustomForm" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contact Type</label>
                <input type="text" id="custom_label" placeholder="e.g., Telegram, LinkedIn, Skype" required
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contact Value</label>
                <input type="text" id="custom_value" placeholder="e.g., @username, profile URL, phone number" required
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Icon (Optional)</label>
                <select id="custom_icon" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    <option value="contact_page">Default</option>
                    <option value="telegram">Telegram</option>
                    <option value="work">LinkedIn</option>
                    <option value="videocam">Skype</option>
                    <option value="alternate_email">Other Email</option>
                    <option value="language">Website</option>
                    <option value="chat">Chat</option>
                </select>
            </div>
            
            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 font-medium">
                    Add Contact
                </button>
                <button type="button" onclick="hideAddCustomModal()" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add Meeting Link Modal -->
<div id="addMeetingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 max-w-md w-full">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Add Meeting Link</h3>
        
        <form id="addMeetingForm" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Meeting Type</label>
                <select id="meeting_type" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    <option value="">Select meeting type</option>
                    <option value="zoom">Zoom</option>
                    <option value="google_meet">Google Meet</option>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="phone_call">Phone Call</option>
                    <option value="physical">Physical (In-Person)</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Label (Optional)</label>
                <input type="text" id="meeting_label" placeholder="e.g., Main Room, Personal Meeting"
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Meeting Link/Details</label>
                <input type="text" id="meeting_link" placeholder="e.g., https://zoom.us/j/123456, +256700000000" required
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Enter meeting URL, phone number, or address depending on the type
                </p>
            </div>
            
            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-medium">
                    Add Meeting Link
                </button>
                <button type="button" onclick="hideAddMeetingModal()" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Save individual field
function saveField(fieldName) {
    const input = document.getElementById(fieldName);
    const value = input.value.trim();
    
    const button = event.target.closest('button');
    const originalHTML = button.innerHTML;
    button.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">refresh</span> Saving...';
    button.disabled = true;
    
    fetch('{{ route("counselor.contact-setup.update-field") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            field: fieldName,
            value: value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to save. Please try again.', 'error');
    })
    .finally(() => {
        button.innerHTML = originalHTML;
        button.disabled = false;
    });
}

// Custom contact functions
function showAddCustomModal() {
    document.getElementById('addCustomModal').classList.remove('hidden');
}

function hideAddCustomModal() {
    document.getElementById('addCustomModal').classList.add('hidden');
    document.getElementById('addCustomForm').reset();
}

// Meeting link functions
function showAddMeetingModal() {
    document.getElementById('addMeetingModal').classList.remove('hidden');
}

function hideAddMeetingModal() {
    document.getElementById('addMeetingModal').classList.add('hidden');
    document.getElementById('addMeetingForm').reset();
}

// Add custom contact
document.getElementById('addCustomForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const label = document.getElementById('custom_label').value.trim();
    const value = document.getElementById('custom_value').value.trim();
    const icon = document.getElementById('custom_icon').value;
    
    fetch('{{ route("counselor.contact-setup.add-custom") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            label: label,
            value: value,
            icon: icon
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            addCustomContactToList(data.key, data.contact);
            hideAddCustomModal();
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to add custom contact. Please try again.', 'error');
    });
});

// Add meeting link
document.getElementById('addMeetingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const type = document.getElementById('meeting_type').value;
    const label = document.getElementById('meeting_label').value.trim();
    const link = document.getElementById('meeting_link').value.trim();
    
    fetch('{{ route("counselor.contact-setup.add-meeting") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            type: type,
            label: label,
            link: link
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            addMeetingLinkToList(data.key, data.meeting);
            hideAddMeetingModal();
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to add meeting link. Please try again.', 'error');
    });
});

// Add meeting link to the list
function addMeetingLinkToList(key, meeting) {
    const list = document.getElementById('meeting-links-list');
    const noLinksDiv = document.getElementById('no-meeting-links');
    
    if (noLinksDiv) {
        noLinksDiv.remove();
    }
    
    const iconMap = {
        'zoom': 'videocam',
        'google_meet': 'video_call',
        'whatsapp': 'chat',
        'phone_call': 'call',
        'physical': 'location_on'
    };
    
    const linkDiv = document.createElement('div');
    linkDiv.className = 'flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg';
    linkDiv.setAttribute('data-key', key);
    linkDiv.innerHTML = `
        <div class="flex items-center gap-3 flex-1">
            <span class="material-symbols-outlined text-blue-600">${iconMap[meeting.type] || 'videocam'}</span>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-900 dark:text-white">
                    ${meeting.type.charAt(0).toUpperCase() + meeting.type.slice(1).replace('_', ' ')}
                    ${meeting.label ? ' - ' + meeting.label : ''}
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400 break-all">${meeting.link}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="copyMeetingLink('${meeting.link}')" class="text-blue-600 hover:text-blue-700 p-1" title="Copy Link">
                <span class="material-symbols-outlined text-sm">content_copy</span>
            </button>
            <button onclick="deleteMeetingLink('${key}')" class="text-red-600 hover:text-red-700 p-1" title="Delete">
                <span class="material-symbols-outlined text-sm">delete</span>
            </button>
        </div>
    `;
    
    list.appendChild(linkDiv);
}

// Copy meeting link
function copyMeetingLink(link) {
    navigator.clipboard.writeText(link).then(() => {
        showToast('Meeting link copied to clipboard!', 'success');
    }).catch(() => {
        // Fallback for older browsers
        const tempInput = document.createElement('input');
        tempInput.value = link;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        showToast('Meeting link copied to clipboard!', 'success');
    });
}

// Delete meeting link
function deleteMeetingLink(key) {
    if (!confirm('Are you sure you want to delete this meeting link?')) {
        return;
    }
    
    fetch(`{{ route("counselor.contact-setup.delete-meeting", "") }}/${key}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            const linkDiv = document.querySelector(`[data-key="${key}"]`);
            if (linkDiv) {
                linkDiv.remove();
            }
            
            // Show "no links" message if list is empty
            const list = document.getElementById('meeting-links-list');
            if (list.children.length === 0) {
                list.innerHTML = `
                    <div id="no-meeting-links" class="text-center py-8">
                        <span class="material-symbols-outlined text-4xl text-gray-300 dark:text-gray-600 mb-2">videocam</span>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">No default meeting links added yet</p>
                        <button onclick="showAddMeetingModal()" class="text-blue-600 hover:underline text-sm mt-1">
                            Add your first meeting link
                        </button>
                    </div>
                `;
            }
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to delete meeting link. Please try again.', 'error');
    });
}
function addCustomContactToList(key, contact) {
    const list = document.getElementById('custom-contacts-list');
    const noContactsDiv = document.getElementById('no-custom-contacts');
    
    if (noContactsDiv) {
        noContactsDiv.remove();
    }
    
    const contactDiv = document.createElement('div');
    contactDiv.className = 'flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg';
    contactDiv.setAttribute('data-key', key);
    contactDiv.innerHTML = `
        <div class="flex items-center gap-3 flex-1">
            <span class="material-symbols-outlined text-purple-600">${contact.icon}</span>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-900 dark:text-white">${contact.label}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">${contact.value}</p>
            </div>
        </div>
        <button onclick="deleteCustomContact('${key}')" class="text-red-600 hover:text-red-700 p-1">
            <span class="material-symbols-outlined text-sm">delete</span>
        </button>
    `;
    
    list.appendChild(contactDiv);
}

// Delete custom contact
function deleteCustomContact(key) {
    if (!confirm('Are you sure you want to delete this custom contact?')) {
        return;
    }
    
    fetch(`{{ route("counselor.contact-setup.delete-custom", "") }}/${key}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            const contactDiv = document.querySelector(`[data-key="${key}"]`);
            if (contactDiv) {
                contactDiv.remove();
            }
            
            // Show "no contacts" message if list is empty
            const list = document.getElementById('custom-contacts-list');
            if (list.children.length === 0) {
                list.innerHTML = `
                    <div id="no-custom-contacts" class="text-center py-8">
                        <span class="material-symbols-outlined text-4xl text-gray-300 dark:text-gray-600 mb-2">contact_page</span>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">No custom contact information added yet</p>
                        <button onclick="showAddCustomModal()" class="text-purple-600 hover:underline text-sm mt-1">
                            Add your first custom contact
                        </button>
                    </div>
                `;
            }
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to delete custom contact. Please try again.', 'error');
    });
}

// Toggle day inputs for availability
function toggleDayInputs(day) {
    const checkbox = document.querySelector(`input[name="availability_hours[${day}][enabled]"]`);
    const inputs = document.getElementById(`${day}-inputs`);
    
    if (checkbox.checked) {
        inputs.classList.remove('opacity-50', 'pointer-events-none');
    } else {
        inputs.classList.add('opacity-50', 'pointer-events-none');
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    days.forEach(day => {
        toggleDayInputs(day);
    });
});

// Toast notification function
function showToast(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 translate-x-full ${
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'error' ? 'bg-red-500 text-white' : 
        'bg-blue-500 text-white'
    }`;
    
    notification.innerHTML = `
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">
                ${type === 'success' ? 'check_circle' : type === 'error' ? 'error' : 'info'}
            </span>
            <span class="text-sm font-medium">${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove after 4 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 4000);
}
</script>
@endsection