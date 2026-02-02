<!-- Terms of Service Modal -->
<div id="termsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-3xl w-full max-h-[85vh] overflow-hidden">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white dark:bg-gray-800 z-10">
            <div class="flex items-center gap-2">
                <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-3 py-1 rounded-full text-xs font-semibold">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Legal Document
                </div>
            </div>
            <button onclick="closeTermsModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors p-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Content -->
        <div class="overflow-y-auto max-h-[calc(85vh-100px)] p-4">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Terms of Service</h1>
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Please read these terms carefully before using our platform
                </p>
                <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    <span><strong>Effective:</strong> Feb 2, 2026</span>
                    <span class="mx-2">•</span>
                    <span><strong>Updated:</strong> Feb 2, 2026</span>
                </div>
            </div>

            <div class="prose prose-sm max-w-none dark:prose-invert space-y-4">
                <section class="mb-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">1. Acceptance of Terms</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-3 text-sm">
                        By accessing or using the WellPath Mental Health Platform, you agree to be bound by these Terms of Service. If you do not agree to these Terms, please do not use our Platform.
                    </p>
                </section>

                <section class="mb-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">2. Description of Service</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-2 text-sm">
                        WellPath is a digital mental health platform that provides:
                    </p>
                    <ul class="list-disc pl-4 text-gray-700 dark:text-gray-300 mb-3 text-xs space-y-0.5">
                        <li>Mental health assessments and screenings</li>
                        <li>Online counseling and therapy sessions</li>
                        <li>Educational resources and content</li>
                        <li>Community forums and peer support</li>
                        <li>Crisis intervention resources</li>
                        <li>Mental health awareness campaigns</li>
                    </ul>
                </section>

                <section class="mb-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">3. Eligibility and User Accounts</h2>
                    
                    <div class="grid md:grid-cols-2 gap-3">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">Age Requirements</h3>
                            <ul class="list-disc pl-4 text-gray-700 dark:text-gray-300 mb-3 text-xs space-y-0.5">
                                <li>Users must be at least 13 years old</li>
                                <li>Users under 18 require parental consent</li>
                                <li>Users under 16 need direct supervision</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">Account Registration</h3>
                            <ul class="list-disc pl-4 text-gray-700 dark:text-gray-300 mb-3 text-xs space-y-0.5">
                                <li>Provide accurate information</li>
                                <li>Maintain credential confidentiality</li>
                                <li>Report unauthorized use immediately</li>
                                <li>One account per person</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <section class="mb-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">4. User Responsibilities</h2>
                    
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">Acceptable Use</h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-2 text-sm">
                        You agree to use the Platform only for lawful purposes. You will not:
                    </p>
                    <ul class="list-disc pl-4 text-gray-700 dark:text-gray-300 mb-3 text-xs space-y-0.5">
                        <li>Violate any applicable laws or regulations</li>
                        <li>Impersonate any person or entity</li>
                        <li>Harass, threaten, or intimidate other users</li>
                        <li>Share inappropriate or harmful content</li>
                        <li>Attempt unauthorized access to the Platform</li>
                        <li>Interfere with Platform operation or security</li>
                    </ul>

                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3 mb-3">
                        <div class="flex items-start">
                            <svg class="w-4 h-4 text-red-600 dark:text-red-400 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <div>
                                <h4 class="text-red-800 dark:text-red-200 font-semibold mb-1 text-xs">Crisis Information</h4>
                                <ul class="list-disc pl-3 text-red-700 dark:text-red-300 text-xs space-y-0.5">
                                    <li>Platform not for emergency mental health crises</li>
                                    <li>Call 911 for immediate danger</li>
                                    <li>Use crisis resources for urgent non-emergencies</li>
                                    <li>Inform counselor of safety concerns immediately</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="mb-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">5. Mental Health Services</h2>
                    
                    <div class="grid md:grid-cols-2 gap-3">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">Nature of Services</h3>
                            <ul class="list-disc pl-4 text-gray-700 dark:text-gray-300 mb-3 text-xs space-y-0.5">
                                <li>Mental health support and resources</li>
                                <li>Licensed mental health professionals</li>
                                <li>Supplements traditional therapy</li>
                                <li>No medical diagnoses or prescriptions</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">Limitations</h3>
                            <ul class="list-disc pl-4 text-gray-700 dark:text-gray-300 mb-3 text-xs space-y-0.5">
                                <li>Not an emergency service</li>
                                <li>May refer to in-person care</li>
                                <li>Technical issues may occur</li>
                                <li>Individual results may vary</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <section class="mb-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">6. Privacy and Confidentiality</h2>
                    
                    <ul class="list-disc pl-4 text-gray-700 dark:text-gray-300 mb-3 text-xs space-y-0.5">
                        <li>Comply with privacy laws (HIPAA, GDPR, local regulations)</li>
                        <li>Health information is protected and confidential</li>
                        <li>Industry-standard security measures used</li>
                        <li>See our <button onclick="closeTermsModal(); openPrivacyModal();" class="text-primary hover:underline">Privacy Policy</button> for detailed practices</li>
                    </ul>

                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">Counseling Confidentiality</h3>
                    <ul class="list-disc pl-4 text-gray-700 dark:text-gray-300 mb-3 text-xs space-y-0.5">
                        <li>Sessions confidential within legal limits</li>
                        <li>May break confidentiality when required by law</li>
                        <li>Includes situations involving harm to self or others</li>
                        <li>Court orders may require disclosure</li>
                    </ul>
                </section>

                <section class="mb-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">7. Limitation of Liability</h2>
                    
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3 mb-3">
                        <h3 class="text-yellow-800 dark:text-yellow-200 font-semibold mb-1 text-xs">Important Legal Notice</h3>
                        <p class="text-yellow-700 dark:text-yellow-300 text-xs">
                            TO THE MAXIMUM EXTENT PERMITTED BY LAW, WellPath's liability is limited. We are not liable for indirect, incidental, or consequential damages including lost profits, data loss, or business interruption.
                        </p>
                    </div>

                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">Service Availability</h3>
                    <ul class="list-disc pl-4 text-gray-700 dark:text-gray-300 mb-3 text-xs space-y-0.5">
                        <li>Strive for 99.9% uptime but cannot guarantee uninterrupted service</li>
                        <li>Scheduled maintenance may temporarily limit access</li>
                        <li>Not liable for damages from service interruptions</li>
                        <li>Alternative crisis resources always available</li>
                    </ul>
                </section>

                <section class="mb-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">8. Contact Information</h2>
                    
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                        <div class="grid md:grid-cols-2 gap-3 text-xs">
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Legal Questions</h4>
                                <p class="text-gray-700 dark:text-gray-300">
                                    <a href="mailto:legal@wellpath.com" class="text-primary hover:underline">legal@wellpath.com</a><br>
                                    <a href="tel:+15551234567" class="text-primary hover:underline">+1 (555) 123-4567</a>
                                </p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Emergency Resources</h4>
                                <p class="text-gray-700 dark:text-gray-300">
                                    Suicide Prevention: <a href="tel:988" class="text-primary hover:underline">988</a><br>
                                    Crisis Text: <a href="sms:741741" class="text-primary hover:underline">741741</a><br>
                                    Emergency: <a href="tel:911" class="text-primary hover:underline">911</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="border-t border-gray-200 dark:border-gray-700 p-3 bg-gray-50 dark:bg-gray-800">
            <div class="flex justify-between items-center">
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    <span><strong>Updated:</strong> Feb 2, 2026</span>
                    <span class="mx-2">•</span>
                    <span><strong>v1.0</strong></span>
                </div>
                <button onclick="closeTermsModal()" class="px-3 py-1.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors text-xs">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function openTermsModal() {
    document.getElementById('termsModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeTermsModal() {
    document.getElementById('termsModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('termsModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeTermsModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('termsModal').classList.contains('hidden')) {
        closeTermsModal();
    }
});
</script>