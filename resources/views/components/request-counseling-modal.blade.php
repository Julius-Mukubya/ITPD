<!-- Request Counseling Modal -->
<div id="requestCounselingModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4 overflow-y-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-3xl my-8 transform transition-all" onclick="event.stopPropagation()">
        <!-- Modal Header -->
        <div class="sticky top-0 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-t-2xl p-4 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-xl">psychology</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Request Counseling Session</h2>
                        <p class="text-white/80 text-xs">Complete the steps below</p>
                    </div>
                </div>
                <button onclick="closeRequestModal()" class="w-8 h-8 bg-white/20 hover:bg-white/30 rounded-lg flex items-center justify-center transition-all">
                    <span class="material-symbols-outlined text-white text-lg">close</span>
                </button>
            </div>
            
            <!-- Progress Bar -->
            <div class="mt-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1 step-indicator active" data-step="1">
                        <div class="w-7 h-7 rounded-full bg-white text-primary flex items-center justify-center font-bold text-xs step-circle">1</div>
                        <span class="font-semibold text-white text-xs hidden sm:block">Type</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-white/30 mx-1 progress-line"></div>
                    <div class="flex items-center gap-1 step-indicator" data-step="2">
                        <div class="w-7 h-7 rounded-full bg-white/30 text-white/60 flex items-center justify-center font-bold text-xs step-circle">2</div>
                        <span class="font-semibold text-white/60 text-xs hidden sm:block">Counselor</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-white/30 mx-1 progress-line"></div>
                    <div class="flex items-center gap-1 step-indicator" data-step="3">
                        <div class="w-7 h-7 rounded-full bg-white/30 text-white/60 flex items-center justify-center font-bold text-xs step-circle">3</div>
                        <span class="font-semibold text-white/60 text-xs hidden sm:block">Priority</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-white/30 mx-1 progress-line"></div>
                    <div class="flex items-center gap-1 step-indicator" data-step="4">
                        <div class="w-7 h-7 rounded-full bg-white/30 text-white/60 flex items-center justify-center font-bold text-xs step-circle">4</div>
                        <span class="font-semibold text-white/60 text-xs hidden sm:block">Details</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-white/30 mx-1 progress-line"></div>
                    <div class="flex items-center gap-1 step-indicator" data-step="5">
                        <div class="w-7 h-7 rounded-full bg-white/30 text-white/60 flex items-center justify-center font-bold text-xs step-circle">5</div>
                        <span class="font-semibold text-white/60 text-xs hidden sm:block">Review</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Body -->
        <div class="p-4 md:p-6 max-h-[65vh] overflow-y-auto">
            <form action="{{ route('public.counseling.request.store') }}" method="POST" id="modalCounselingForm">
                @csrf

                <!-- Step 1: Session Type -->
                <div class="form-step active" data-step="1">
                    <div class="text-center mb-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Choose Session Type</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-xs">Select the type of counseling session you need</p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-2">
                        <label class="relative flex flex-col p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary hover:shadow-md transition-all group">
                            <input type="radio" name="session_type" value="individual" required class="sr-only peer">
                            <div class="text-center">
                                <div class="w-10 h-10 mx-auto mb-1.5 bg-primary/10 rounded-lg flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all">
                                    <span class="material-symbols-outlined text-xl text-primary group-hover:text-white">person</span>
                                </div>
                                <span class="font-bold text-gray-900 dark:text-white text-xs block mb-0.5">Individual</span>
                                <p class="text-[10px] text-gray-600 dark:text-gray-400">One-on-one</p>
                            </div>
                            <div class="absolute inset-0 border-2 border-primary rounded-lg opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                            <div class="absolute top-1.5 right-1.5 w-4 h-4 bg-primary rounded-full items-center justify-center hidden peer-checked:flex">
                                <span class="material-symbols-outlined text-white text-[10px]">check</span>
                            </div>
                        </label>

                        <label class="relative flex flex-col p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary hover:shadow-md transition-all group">
                            <input type="radio" name="session_type" value="group" required class="sr-only peer">
                            <div class="text-center">
                                <div class="w-10 h-10 mx-auto mb-1.5 bg-primary/10 rounded-lg flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all">
                                    <span class="material-symbols-outlined text-xl text-primary group-hover:text-white">groups</span>
                                </div>
                                <span class="font-bold text-gray-900 dark:text-white text-xs block mb-0.5">Group</span>
                                <p class="text-[10px] text-gray-600 dark:text-gray-400">Group therapy</p>
                            </div>
                            <div class="absolute inset-0 border-2 border-primary rounded-lg opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                            <div class="absolute top-1.5 right-1.5 w-4 h-4 bg-primary rounded-full items-center justify-center hidden peer-checked:flex">
                                <span class="material-symbols-outlined text-white text-[10px]">check</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Step 2: Counselor Selection -->
                <div class="form-step" data-step="2">
                    <div class="text-center mb-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Choose Your Counselor</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-xs">Select a specific counselor or let us assign one</p>
                    </div>
                    
                    <div class="space-y-2 max-h-48 overflow-y-auto">
                        <label class="relative flex items-center p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary hover:shadow-md transition-all group">
                            <input type="radio" name="counselor_id" value="" class="sr-only peer" checked>
                            <div class="flex items-center gap-3 w-full">
                                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all">
                                    <span class="material-symbols-outlined text-lg text-primary group-hover:text-white">shuffle</span>
                                </div>
                                <div class="flex-1">
                                    <span class="font-bold text-gray-900 dark:text-white text-sm block">Any Available Counselor</span>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">We'll assign the best available counselor</p>
                                </div>
                            </div>
                            <div class="absolute inset-0 border-2 border-primary rounded-lg opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                            <div class="absolute top-2 right-2 w-4 h-4 bg-primary rounded-full items-center justify-center hidden peer-checked:flex">
                                <span class="material-symbols-outlined text-white text-[10px]">check</span>
                            </div>
                        </label>

                        @if(isset($counselors))
                            @foreach($counselors as $counselor)
                            <label class="relative flex items-center p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary hover:shadow-md transition-all group">
                                <input type="radio" name="counselor_id" value="{{ $counselor->id }}" class="sr-only peer">
                                <div class="flex items-center gap-3 w-full">
                                    <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg flex items-center justify-center group-hover:bg-emerald-500 group-hover:scale-110 transition-all">
                                        <span class="material-symbols-outlined text-lg text-emerald-500 group-hover:text-white">person</span>
                                    </div>
                                    <div class="flex-1">
                                        <span class="font-bold text-gray-900 dark:text-white text-sm block">{{ $counselor->name }}</span>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $counselor->email }}</p>
                                    </div>
                                </div>
                                <div class="absolute inset-0 border-2 border-primary rounded-lg opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                <div class="absolute top-2 right-2 w-4 h-4 bg-primary rounded-full items-center justify-center hidden peer-checked:flex">
                                    <span class="material-symbols-outlined text-white text-[10px]">check</span>
                                </div>
                            </label>
                            @endforeach
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 text-center mt-2">Counselor selection is optional. Availability may vary.</p>
                </div>

                <!-- Step 3: Priority -->
                <div class="form-step" data-step="3">
                    <div class="text-center mb-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Set Priority Level</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-xs">How urgent is your need?</p>
                    </div>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                        <label class="relative flex flex-col items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer hover:border-green-500 hover:shadow-md transition-all group">
                            <input type="radio" name="priority" value="low" required class="sr-only peer">
                            <div class="w-12 h-12 mb-2 bg-green-50 dark:bg-green-900/20 rounded-xl flex items-center justify-center group-hover:bg-green-500 group-hover:scale-110 transition-all">
                                <span class="material-symbols-outlined text-2xl text-green-500 group-hover:text-white">sentiment_satisfied</span>
                            </div>
                            <span class="font-bold text-gray-900 dark:text-white text-sm">Low</span>
                            <div class="absolute inset-0 border-2 border-green-500 rounded-xl opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                        </label>

                        <label class="relative flex flex-col items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer hover:border-yellow-500 hover:shadow-md transition-all group">
                            <input type="radio" name="priority" value="medium" required class="sr-only peer">
                            <div class="w-12 h-12 mb-2 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl flex items-center justify-center group-hover:bg-yellow-500 group-hover:scale-110 transition-all">
                                <span class="material-symbols-outlined text-2xl text-yellow-500 group-hover:text-white">sentiment_neutral</span>
                            </div>
                            <span class="font-bold text-gray-900 dark:text-white text-sm">Medium</span>
                            <div class="absolute inset-0 border-2 border-yellow-500 rounded-xl opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                        </label>

                        <label class="relative flex flex-col items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer hover:border-orange-500 hover:shadow-md transition-all group">
                            <input type="radio" name="priority" value="high" required class="sr-only peer">
                            <div class="w-12 h-12 mb-2 bg-orange-50 dark:bg-orange-900/20 rounded-xl flex items-center justify-center group-hover:bg-orange-500 group-hover:scale-110 transition-all">
                                <span class="material-symbols-outlined text-2xl text-orange-500 group-hover:text-white">sentiment_worried</span>
                            </div>
                            <span class="font-bold text-gray-900 dark:text-white text-sm">High</span>
                            <div class="absolute inset-0 border-2 border-orange-500 rounded-xl opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                        </label>

                        <label class="relative flex flex-col items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer hover:border-red-500 hover:shadow-md transition-all group">
                            <input type="radio" name="priority" value="urgent" required class="sr-only peer">
                            <div class="w-12 h-12 mb-2 bg-red-50 dark:bg-red-900/20 rounded-xl flex items-center justify-center group-hover:bg-red-500 group-hover:scale-110 transition-all">
                                <span class="material-symbols-outlined text-2xl text-red-500 group-hover:text-white">emergency</span>
                            </div>
                            <span class="font-bold text-gray-900 dark:text-white text-sm">Urgent</span>
                            <div class="absolute inset-0 border-2 border-red-500 rounded-xl opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                        </label>
                    </div>
                </div>

                <!-- Step 4: Details -->
                <div class="form-step" data-step="4">
                    <div class="text-center mb-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Session Details</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-xs">Tell us more about your needs</p>
                    </div>

                    <div class="space-y-3">
                        <!-- Group Participants (only shown for group sessions) -->
                        <div id="groupParticipantsSection" class="hidden">
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                                Group Participants <span class="text-red-500">*</span>
                            </label>
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3 mb-3">
                                <div class="flex gap-2">
                                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-sm flex-shrink-0">info</span>
                                    <p class="text-xs text-blue-800 dark:text-blue-200">Add other participants who will join this group session. They will receive an invitation to join.</p>
                                </div>
                            </div>
                            
                            <div id="participantsList" class="space-y-2 mb-3">
                                <!-- Participants will be added here dynamically -->
                            </div>
                            
                            <div class="flex gap-2">
                                <input type="text" id="participantName" placeholder="Participant name" 
                                    class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white text-sm">
                                <input type="email" id="participantEmail" placeholder="Email address" 
                                    class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white text-sm">
                                <button type="button" onclick="addParticipant()" 
                                    class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-1 text-sm">
                                    <span class="material-symbols-outlined text-sm">add</span>
                                    Add
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Minimum 1 participant required for group sessions. Maximum 8 participants.</p>
                        </div>

                        <!-- Preferred Method -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Preferred Method</label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                <label class="flex items-center p-2 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary transition-all text-sm">
                                    <input type="radio" name="preferred_method" value="jitsi" class="text-primary focus:ring-primary mr-2">
                                    <span class="material-symbols-outlined text-primary text-sm mr-1">videocam</span>
                                    <span class="text-gray-900 dark:text-white">Jitsi</span>
                                </label>
                                <label class="flex items-center p-2 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary transition-all text-sm">
                                    <input type="radio" name="preferred_method" value="zoom" class="text-primary focus:ring-primary mr-2">
                                    <span class="material-symbols-outlined text-primary text-sm mr-1">videocam</span>
                                    <span class="text-gray-900 dark:text-white">Zoom</span>
                                </label>
                                <label class="flex items-center p-2 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary transition-all text-sm">
                                    <input type="radio" name="preferred_method" value="google_meet" class="text-primary focus:ring-primary mr-2">
                                    <span class="material-symbols-outlined text-primary text-sm mr-1">video_call</span>
                                    <span class="text-gray-900 dark:text-white">Meet</span>
                                </label>
                                <label class="flex items-center p-2 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary transition-all text-sm">
                                    <input type="radio" name="preferred_method" value="whatsapp" class="text-primary focus:ring-primary mr-2">
                                    <span class="material-symbols-outlined text-primary text-sm mr-1">chat</span>
                                    <span class="text-gray-900 dark:text-white">WhatsApp</span>
                                </label>
                                <label class="flex items-center p-2 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary transition-all text-sm">
                                    <input type="radio" name="preferred_method" value="phone_call" class="text-primary focus:ring-primary mr-2">
                                    <span class="material-symbols-outlined text-primary text-sm mr-1">call</span>
                                    <span class="text-gray-900 dark:text-white">Phone</span>
                                </label>
                                <label class="flex items-center p-2 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary transition-all text-sm">
                                    <input type="radio" name="preferred_method" value="physical" class="text-primary focus:ring-primary mr-2">
                                    <span class="material-symbols-outlined text-primary text-sm mr-1">location_on</span>
                                    <span class="text-gray-900 dark:text-white">In-Person</span>
                                </label>
                            </div>
                        </div>

                        <!-- Reason -->
                        <div>
                            <label for="modal_reason" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                                Reason for Counseling <span class="text-red-500">*</span>
                            </label>
                            <textarea id="modal_reason" name="reason" rows="4" required minlength="10"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white resize-none text-sm"
                                placeholder="Please describe what you'd like to discuss..."></textarea>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Minimum 10 characters. All information is confidential.</p>
                        </div>

                        <!-- Preferred Date/Time -->
                        <div>
                            <label for="modal_preferred_datetime" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                                Preferred Date & Time (Optional)
                            </label>
                            <input type="datetime-local" id="modal_preferred_datetime" name="preferred_datetime"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white text-sm">
                        </div>

                        <!-- Options -->
                        <div class="space-y-2">
                            <label class="flex items-start p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                                <input type="checkbox" name="anonymous" value="1" class="mt-0.5 text-primary focus:ring-primary rounded">
                                <div class="ml-2">
                                    <span class="font-medium text-gray-900 dark:text-white text-sm">Anonymous Session</span>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Keep your identity confidential</p>
                                </div>
                            </label>
                            <label class="flex items-start p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                                <input type="checkbox" name="follow_up" value="1" class="mt-0.5 text-primary focus:ring-primary rounded">
                                <div class="ml-2">
                                    <span class="font-medium text-gray-900 dark:text-white text-sm">Follow-up Sessions</span>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Schedule regular sessions</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Step 5: Review -->
                <div class="form-step" data-step="5">
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Review Your Request</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Please review before submitting</p>
                    </div>

                    <div class="space-y-3">
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Session Type</p>
                            <p class="font-bold text-gray-900 dark:text-white" id="modal-review-session-type">-</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Preferred Counselor</p>
                            <p class="font-bold text-gray-900 dark:text-white" id="modal-review-counselor">-</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Priority Level</p>
                            <p class="font-bold text-gray-900 dark:text-white" id="modal-review-priority">-</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Preferred Method</p>
                            <p class="font-bold text-gray-900 dark:text-white" id="modal-review-method">-</p>
                        </div>
                        <div id="modal-review-participants-section" class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3 hidden">
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Group Participants</p>
                            <div id="modal-review-participants" class="space-y-1">
                                <!-- Participants will be listed here -->
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Reason</p>
                            <p class="text-sm text-gray-900 dark:text-white" id="modal-review-reason">-</p>
                        </div>
                    </div>

                    <div class="mt-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <div class="flex gap-2">
                            <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-sm flex-shrink-0">lock</span>
                            <p class="text-xs text-blue-800 dark:text-blue-200">All counseling sessions are completely confidential.</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="sticky bottom-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 p-4 rounded-b-2xl flex items-center justify-between">
            <button type="button" id="modalPrevBtn" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-all flex items-center gap-1 text-sm" style="display: none;">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Previous
            </button>
            <button type="button" onclick="closeRequestModal()" class="px-4 py-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 font-medium transition-colors text-sm">
                Cancel
            </button>
            <button type="button" id="modalNextBtn" class="px-6 py-2 bg-gradient-to-r from-primary to-emerald-600 text-white rounded-lg font-bold hover:shadow-lg hover:scale-105 transition-all flex items-center gap-1 text-sm">
                Next
                <span class="material-symbols-outlined text-base">arrow_forward</span>
            </button>
            <button type="button" id="modalSubmitBtn" onclick="document.getElementById('modalCounselingForm').submit()" class="px-6 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-lg font-bold hover:shadow-lg hover:scale-105 transition-all flex items-center gap-1 text-sm" style="display: none;">
                <span class="material-symbols-outlined text-base">send</span>
                Submit
            </button>
        </div>
    </div>
</div>

<script>
// Modal functions
function openRequestModal() {
    document.getElementById('requestCounselingModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    modalCurrentStep = 1;
    showModalStep(1);
}

function closeRequestModal() {
    document.getElementById('requestCounselingModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.getElementById('modalCounselingForm').reset();
    // Clear participants list
    document.getElementById('participantsList').innerHTML = '';
    groupParticipants = [];
}

// Close on backdrop click
document.getElementById('requestCounselingModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeRequestModal();
});

// Group participants functionality
let groupParticipants = [];

function addParticipant() {
    const nameInput = document.getElementById('participantName');
    const emailInput = document.getElementById('participantEmail');
    const name = nameInput.value.trim();
    const email = emailInput.value.trim();
    
    if (!name || !email) {
        showToast('Please enter both name and email', 'warning');
        return;
    }
    
    if (!isValidEmail(email)) {
        showToast('Please enter a valid email address', 'warning');
        return;
    }
    
    if (groupParticipants.length >= 8) {
        showToast('Maximum 8 participants allowed', 'warning');
        return;
    }
    
    // Check for duplicate emails
    if (groupParticipants.some(p => p.email === email)) {
        showToast('This email is already added', 'warning');
        return;
    }
    
    // Add participant
    groupParticipants.push({ name, email });
    
    // Clear inputs
    nameInput.value = '';
    emailInput.value = '';
    
    // Update UI
    updateParticipantsList();
    showToast('Participant added successfully', 'success');
}

function removeParticipant(index) {
    groupParticipants.splice(index, 1);
    updateParticipantsList();
    showToast('Participant removed', 'info');
}

function updateParticipantsList() {
    const container = document.getElementById('participantsList');
    container.innerHTML = '';
    
    groupParticipants.forEach((participant, index) => {
        const participantEl = document.createElement('div');
        participantEl.className = 'flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg';
        participantEl.innerHTML = `
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-sm">person</span>
                </div>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white text-sm">${participant.name}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">${participant.email}</p>
                </div>
            </div>
            <button type="button" onclick="removeParticipant(${index})" 
                class="w-6 h-6 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-full flex items-center justify-center hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors">
                <span class="material-symbols-outlined text-xs">close</span>
            </button>
        `;
        container.appendChild(participantEl);
    });
    
    // Add hidden inputs for form submission
    const form = document.getElementById('modalCounselingForm');
    // Remove existing participant inputs
    form.querySelectorAll('input[name^="participants"]').forEach(input => input.remove());
    
    // Add new participant inputs
    groupParticipants.forEach((participant, index) => {
        const nameInput = document.createElement('input');
        nameInput.type = 'hidden';
        nameInput.name = `participants[${index}][name]`;
        nameInput.value = participant.name;
        form.appendChild(nameInput);
        
        const emailInput = document.createElement('input');
        emailInput.type = 'hidden';
        emailInput.name = `participants[${index}][email]`;
        emailInput.value = participant.email;
        form.appendChild(emailInput);
    });
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Show/hide group participants section based on session type
document.addEventListener('change', function(e) {
    if (e.target.name === 'session_type') {
        const groupSection = document.getElementById('groupParticipantsSection');
        if (e.target.value === 'group') {
            groupSection.classList.remove('hidden');
        } else {
            groupSection.classList.add('hidden');
            // Clear participants when switching away from group
            groupParticipants = [];
            updateParticipantsList();
        }
    }
});

// Allow Enter key to add participants
document.getElementById('participantEmail')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        addParticipant();
    }
});

document.getElementById('participantName')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('participantEmail').focus();
    }
});

// Multi-step logic for modal
let modalCurrentStep = 1;
const modalTotalSteps = 5;

function showModalStep(step) {
    document.querySelectorAll('#requestCounselingModal .form-step').forEach(el => {
        el.classList.remove('active');
        el.style.display = 'none';
    });
    
    const currentStepEl = document.querySelector(`#requestCounselingModal .form-step[data-step="${step}"]`);
    if (currentStepEl) {
        currentStepEl.style.display = 'block';
        setTimeout(() => currentStepEl.classList.add('active'), 10);
    }
    
    // Update progress
    document.querySelectorAll('#requestCounselingModal .step-indicator').forEach((indicator, index) => {
        const stepNum = index + 1;
        const circle = indicator.querySelector('.step-circle');
        const text = indicator.querySelector('span:last-child');
        
        if (stepNum < step) {
            circle.className = 'w-8 h-8 rounded-full bg-white text-primary flex items-center justify-center font-bold text-sm step-circle';
            if (text) text.className = 'font-semibold text-white text-sm hidden sm:block';
        } else if (stepNum === step) {
            circle.className = 'w-8 h-8 rounded-full bg-white text-primary flex items-center justify-center font-bold text-sm step-circle';
            if (text) text.className = 'font-semibold text-white text-sm hidden sm:block';
        } else {
            circle.className = 'w-8 h-8 rounded-full bg-white/30 text-white/60 flex items-center justify-center font-bold text-sm step-circle';
            if (text) text.className = 'font-semibold text-white/60 text-sm hidden sm:block';
        }
    });
    
    document.querySelectorAll('#requestCounselingModal .progress-line').forEach((line, index) => {
        if (index < step - 1) {
            line.className = 'flex-1 h-1 bg-white mx-2 progress-line';
        } else {
            line.className = 'flex-1 h-1 bg-white/30 mx-2 progress-line';
        }
    });
    
    // Update buttons
    const prevBtn = document.getElementById('modalPrevBtn');
    const nextBtn = document.getElementById('modalNextBtn');
    const submitBtn = document.getElementById('modalSubmitBtn');
    
    prevBtn.style.display = step === 1 ? 'none' : 'flex';
    
    if (step === modalTotalSteps) {
        nextBtn.style.display = 'none';
        submitBtn.style.display = 'flex';
        updateModalReview();
    } else {
        nextBtn.style.display = 'flex';
        submitBtn.style.display = 'none';
    }
}

function validateModalStep(step) {
    if (step === 1) {
        const sessionType = document.querySelector('#requestCounselingModal input[name="session_type"]:checked');
        if (!sessionType) {
            showToast('Please select a session type', 'warning');
            return false;
        }
    } else if (step === 2) {
        // Counselor selection is optional, so no validation needed
        return true;
    } else if (step === 3) {
        const priority = document.querySelector('#requestCounselingModal input[name="priority"]:checked');
        if (!priority) {
            showToast('Please select a priority level', 'warning');
            return false;
        }
    } else if (step === 4) {
        const reason = document.getElementById('modal_reason').value;
        if (reason.length < 10) {
            showToast('Please provide more details (minimum 10 characters).', 'warning');
            return false;
        }
        
        // Check group participants if group session is selected
        const sessionType = document.querySelector('#requestCounselingModal input[name="session_type"]:checked');
        if (sessionType && sessionType.value === 'group') {
            if (groupParticipants.length === 0) {
                showToast('Please add at least one participant for group sessions', 'warning');
                return false;
            }
        }
    }
    return true;
}

function updateModalReview() {
    const sessionType = document.querySelector('#requestCounselingModal input[name="session_type"]:checked');
    const sessionTypeText = sessionType ? 
        sessionType.value.charAt(0).toUpperCase() + sessionType.value.slice(1) : '-';
    document.getElementById('modal-review-session-type').textContent = sessionTypeText;
    
    // Counselor
    const counselor = document.querySelector('#requestCounselingModal input[name="counselor_id"]:checked');
    if (counselor && counselor.value) {
        // Find the counselor label text
        const counselorLabel = counselor.closest('label').querySelector('.font-bold');
        document.getElementById('modal-review-counselor').textContent = counselorLabel ? counselorLabel.textContent : 'Specific counselor selected';
    } else {
        document.getElementById('modal-review-counselor').textContent = 'Any available counselor';
    }
    
    const priority = document.querySelector('#requestCounselingModal input[name="priority"]:checked');
    document.getElementById('modal-review-priority').textContent = priority ? 
        priority.value.charAt(0).toUpperCase() + priority.value.slice(1) : '-';
    
    const method = document.querySelector('#requestCounselingModal input[name="preferred_method"]:checked');
    document.getElementById('modal-review-method').textContent = method ? 
        method.value.replace('_', ' ').split(' ').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ') : 'Not specified';
    
    // Group participants
    const participantsSection = document.getElementById('modal-review-participants-section');
    const participantsContainer = document.getElementById('modal-review-participants');
    
    if (sessionType && sessionType.value === 'group' && groupParticipants.length > 0) {
        participantsSection.classList.remove('hidden');
        participantsContainer.innerHTML = '';
        
        groupParticipants.forEach(participant => {
            const participantEl = document.createElement('div');
            participantEl.className = 'flex items-center gap-2 text-sm text-gray-900 dark:text-white';
            participantEl.innerHTML = `
                <span class="material-symbols-outlined text-primary text-xs">person</span>
                <span class="font-medium">${participant.name}</span>
                <span class="text-gray-500 dark:text-gray-400">(${participant.email})</span>
            `;
            participantsContainer.appendChild(participantEl);
        });
    } else {
        participantsSection.classList.add('hidden');
    }
    
    const reason = document.getElementById('modal_reason').value;
    document.getElementById('modal-review-reason').textContent = reason || '-';
}

document.getElementById('modalNextBtn')?.addEventListener('click', function() {
    if (validateModalStep(modalCurrentStep)) {
        if (modalCurrentStep < modalTotalSteps) {
            modalCurrentStep++;
            showModalStep(modalCurrentStep);
        }
    }
});

document.getElementById('modalPrevBtn')?.addEventListener('click', function() {
    if (modalCurrentStep > 1) {
        modalCurrentStep--;
        showModalStep(modalCurrentStep);
    }
});

// CSS for transitions
const modalStyle = document.createElement('style');
modalStyle.textContent = `
    #requestCounselingModal .form-step {
        display: none;
        opacity: 0;
        transform: translateX(20px);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    #requestCounselingModal .form-step.active {
        opacity: 1;
        transform: translateX(0);
    }
`;
document.head.appendChild(modalStyle);
</script>
