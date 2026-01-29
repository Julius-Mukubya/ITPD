<!-- Assessment Result Modal -->
<div id="assessmentResultModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
        <!-- Modal Header -->
        <div class="sticky top-0 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-6 py-4 flex items-center justify-between rounded-t-2xl">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Assessment Results</h2>
            <button onclick="closeAssessmentResultModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
        </div>

        <!-- Modal Content -->
        <div id="assessmentResultContent" class="p-6">
            <!-- Content will be loaded here via JavaScript -->
        </div>
    </div>
</div>

<script>
function openAssessmentResultModal(resultData) {
    const modal = document.getElementById('assessmentResultModal');
    const content = document.getElementById('assessmentResultContent');
    
    // Build the result content
    content.innerHTML = `
        <!-- Success Message -->
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6 mb-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-2xl">check_circle</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-green-900 dark:text-green-100 mb-2">Assessment Completed!</h3>
                    <p class="text-green-800 dark:text-green-200">Thank you for completing the ${resultData.assessmentName}. Here are your results.</p>
                </div>
            </div>
        </div>

        <!-- Results Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-lg mb-6">
            <!-- Score Header -->
            <div class="bg-gradient-to-r ${resultData.gradientClass} p-6 text-white text-center">
                <h1 class="text-2xl font-bold mb-2">Your ${resultData.resultTitle}</h1>
                <div class="text-4xl font-black mb-2">${resultData.severityLevel}</div>
                <p class="text-white/80">Score: ${resultData.score}/${resultData.maxScore}</p>
            </div>

            <!-- Results Content -->
            <div class="p-6">
                <!-- Score Breakdown -->
                <div class="mb-6">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-3">What This Means</h4>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        ${resultData.interpretation}
                    </p>
                    
                    <!-- Visual Scale -->
                    <div class="relative pt-1 mb-6">
                        <div class="flex mb-2 items-center justify-between">
                            <div class="text-xs font-semibold inline-block text-gray-600 dark:text-gray-400">Minimal</div>
                            <div class="text-xs font-semibold inline-block text-gray-600 dark:text-gray-400">Severe</div>
                        </div>
                        <div class="overflow-hidden h-4 text-xs flex rounded-full bg-gray-200 dark:bg-gray-700 relative">
                            <div class="w-1/4 bg-green-500"></div>
                            <div class="w-1/4 bg-yellow-500"></div>
                            <div class="w-1/4 bg-orange-500"></div>
                            <div class="w-1/4 bg-red-500"></div>
                            <div class="absolute top-0 h-full" style="left: ${(resultData.score / resultData.maxScore) * 100}%;">
                                <div class="absolute -top-8 left-0 transform -translate-x-1/2">
                                    <span class="material-symbols-outlined ${resultData.markerColor} text-3xl">arrow_drop_down</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recommendations -->
                <div class="mb-6">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Recommendations</h4>
                    <div class="space-y-3">
                        ${resultData.recommendations.map(rec => `
                            <div class="flex gap-3 p-4 bg-${rec.color}-50 dark:bg-${rec.color}-900/20 rounded-lg">
                                <span class="material-symbols-outlined text-${rec.color}-600 dark:text-${rec.color}-400">${rec.icon}</span>
                                <div>
                                    <h5 class="font-semibold text-gray-900 dark:text-white mb-1">${rec.title}</h5>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">${rec.description}</p>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>

                ${resultData.showUrgentHelp ? `
                <!-- Urgent Help Notice -->
                <div class="bg-red-50 dark:bg-red-900/20 border-2 border-red-300 dark:border-red-700 rounded-xl p-6 mb-6">
                    <div class="flex gap-4">
                        <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-3xl">emergency</span>
                        <div>
                            <h4 class="text-lg font-bold text-red-900 dark:text-red-100 mb-2">Immediate Support Recommended</h4>
                            <p class="text-red-800 dark:text-red-200 mb-4">Your results suggest you may benefit from professional support. Please consider reaching out to a mental health professional.</p>
                            <div class="space-y-2">
                                <a href="tel:988" class="inline-flex items-center gap-2 bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                                    <span class="material-symbols-outlined">phone</span>
                                    Call Crisis Helpline: 988
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                ` : ''}

                <!-- Resources -->
                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Helpful Resources</h4>
                    <div class="space-y-2">
                        <a href="/content" class="flex items-center gap-2 text-primary hover:underline">
                            <span class="material-symbols-outlined text-lg">library_books</span>
                            <span>Browse Mental Health Resources</span>
                        </a>
                        <a href="/counseling" class="flex items-center gap-2 text-primary hover:underline">
                            <span class="material-symbols-outlined text-lg">support_agent</span>
                            <span>View Counseling Services</span>
                        </a>
                        <a href="/contact" class="flex items-center gap-2 text-primary hover:underline">
                            <span class="material-symbols-outlined text-lg">phone</span>
                            <span>Contact Support</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <button onclick="closeAssessmentResultModal(); window.location.href='/assessments'" class="flex-1 bg-primary text-white text-center py-3 px-6 rounded-lg font-semibold hover:bg-primary/90 transition-colors">
                Take Another Assessment
            </button>
            <button onclick="printResults()" class="flex-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-center py-3 px-6 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                Print Results
            </button>
        </div>

        <!-- Create Account CTA (only show if not authenticated) -->
        ${!resultData.isAuthenticated ? `
        <div class="bg-gradient-to-r from-primary/10 to-emerald-500/10 dark:from-primary/20 dark:to-emerald-500/20 rounded-2xl p-6 text-center mb-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Want to Track Your Progress?</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4 max-w-2xl mx-auto">
                Create a free account to save your assessment results, track your mental health journey, and access personalized resources.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="openSignupModal(); closeAssessmentResultModal();" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-lg font-bold hover:bg-primary/90 transition-colors">
                    <span class="material-symbols-outlined">person_add</span>
                    Create Free Account
                </button>
                <button onclick="openLoginModal(); closeAssessmentResultModal();" class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <span class="material-symbols-outlined">login</span>
                    Sign In
                </button>
            </div>
        </div>
        ` : ''}

        <!-- Disclaimer -->
        <div class="text-center text-sm text-gray-500 dark:text-gray-400">
            <p>This assessment is a screening tool and not a diagnostic instrument. For a professional evaluation, please consult with a licensed mental health professional.</p>
        </div>
    `;
    
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeAssessmentResultModal() {
    const modal = document.getElementById('assessmentResultModal');
    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

function printResults() {
    const content = document.getElementById('assessmentResultContent').innerHTML;
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Assessment Results</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .bg-gradient-to-r { background: linear-gradient(to right, #10b981, #059669); color: white; padding: 20px; text-align: center; }
                .rounded-xl { border-radius: 12px; }
                .p-6 { padding: 24px; }
                .mb-6 { margin-bottom: 24px; }
                .text-center { text-align: center; }
                .font-bold { font-weight: bold; }
                .text-2xl { font-size: 24px; }
                .text-4xl { font-size: 36px; }
                .border { border: 1px solid #e5e7eb; }
                @media print {
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            ${content}
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    const modal = document.getElementById('assessmentResultModal');
    if (e.target === modal) {
        closeAssessmentResultModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeAssessmentResultModal();
    }
});
</script>