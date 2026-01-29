<!-- Assessment Result Modal -->
<div id="assessmentResultModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
        <!-- Modal Header -->
        <div class="sticky top-0 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-4 py-3 flex items-center justify-between rounded-t-xl">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Assessment Results</h2>
            <button onclick="closeAssessmentResultModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <!-- Modal Content -->
        <div id="assessmentResultContent" class="p-4">
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
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-4">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-xl">check_circle</span>
                <div>
                    <h3 class="font-bold text-green-900 dark:text-green-100">Assessment Completed!</h3>
                    <p class="text-sm text-green-800 dark:text-green-200">Thank you for completing the ${resultData.assessmentName}.</p>
                </div>
            </div>
        </div>

        <!-- Results Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden shadow mb-4">
            <!-- Score Header -->
            <div class="bg-gradient-to-r ${resultData.gradientClass} p-4 text-white text-center">
                <h1 class="text-xl font-bold mb-1">Your ${resultData.resultTitle}</h1>
                <div class="text-3xl font-black mb-1">${resultData.severityLevel}</div>
                <p class="text-white/80 text-sm">Score: ${resultData.score}/${resultData.maxScore}</p>
            </div>

            <!-- Results Content -->
            <div class="p-4">
                <!-- Score Breakdown -->
                <div class="mb-4">
                    <h4 class="font-bold text-gray-900 dark:text-white mb-2">What This Means</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                        ${resultData.interpretation}
                    </p>
                    
                    <!-- Visual Scale -->
                    <div class="relative pt-1 mb-4">
                        <div class="flex mb-1 items-center justify-between">
                            <div class="text-xs text-gray-600 dark:text-gray-400">Minimal</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Severe</div>
                        </div>
                        <div class="overflow-hidden h-3 flex rounded-full bg-gray-200 dark:bg-gray-700 relative">
                            <div class="w-1/4 bg-green-500"></div>
                            <div class="w-1/4 bg-yellow-500"></div>
                            <div class="w-1/4 bg-orange-500"></div>
                            <div class="w-1/4 bg-red-500"></div>
                            <div class="absolute top-0 h-full" style="left: ${(resultData.score / resultData.maxScore) * 100}%;">
                                <div class="absolute -top-6 left-0 transform -translate-x-1/2">
                                    <span class="material-symbols-outlined ${resultData.markerColor} text-2xl">arrow_drop_down</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recommendations -->
                <div class="mb-4">
                    <h4 class="font-bold text-gray-900 dark:text-white mb-2">Recommendations</h4>
                    <div class="space-y-2">
                        ${resultData.recommendations.map(rec => `
                            <div class="flex gap-2 p-3 bg-${rec.color}-50 dark:bg-${rec.color}-900/20 rounded-lg">
                                <span class="material-symbols-outlined text-${rec.color}-600 dark:text-${rec.color}-400 text-lg">${rec.icon}</span>
                                <div>
                                    <h5 class="font-semibold text-gray-900 dark:text-white text-sm">${rec.title}</h5>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">${rec.description}</p>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>

                ${resultData.showUrgentHelp ? `
                <!-- Urgent Help Notice -->
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-300 dark:border-red-700 rounded-lg p-4 mb-4">
                    <div class="flex gap-3">
                        <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-2xl">emergency</span>
                        <div>
                            <h4 class="font-bold text-red-900 dark:text-red-100 mb-1">Immediate Support Recommended</h4>
                            <p class="text-sm text-red-800 dark:text-red-200 mb-3">Your results suggest you may benefit from professional support.</p>
                            <a href="tel:988" class="inline-flex items-center gap-2 bg-red-600 text-white px-3 py-2 rounded-lg text-sm font-semibold hover:bg-red-700 transition-colors">
                                <span class="material-symbols-outlined text-sm">phone</span>
                                Call Crisis Helpline: 988
                            </a>
                        </div>
                    </div>
                </div>
                ` : ''}

                <!-- Resources -->
                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-3">
                    <h4 class="font-bold text-gray-900 dark:text-white mb-2">Helpful Resources</h4>
                    <div class="space-y-1">
                        <a href="/content" class="flex items-center gap-2 text-primary hover:underline text-sm">
                            <span class="material-symbols-outlined text-base">library_books</span>
                            <span>Browse Mental Health Resources</span>
                        </a>
                        <a href="/counseling" class="flex items-center gap-2 text-primary hover:underline text-sm">
                            <span class="material-symbols-outlined text-base">support_agent</span>
                            <span>View Counseling Services</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 mb-4">
            <button onclick="closeAssessmentResultModal(); window.location.href='/assessments'" class="flex-1 bg-primary text-white text-center py-2 px-4 rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm">
                Take Another Assessment
            </button>
            <button onclick="printResults()" class="flex-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-center py-2 px-4 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                Print Results
            </button>
        </div>

        ${!resultData.isAuthenticated ? `
        <!-- Create Account CTA -->
        <div class="bg-gradient-to-r from-primary/10 to-emerald-500/10 dark:from-primary/20 dark:to-emerald-500/20 rounded-lg p-4 text-center mb-4">
            <h3 class="font-bold text-gray-900 dark:text-white mb-2">Want to Track Your Progress?</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                Create a free account to save your assessment results and track your mental health journey.
            </p>
            <div class="flex gap-2 justify-center">
                <button onclick="openSignupModal(); closeAssessmentResultModal();" class="inline-flex items-center gap-1 bg-primary text-white px-4 py-2 rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm">
                    <span class="material-symbols-outlined text-sm">person_add</span>
                    Create Account
                </button>
                <button onclick="openLoginModal(); closeAssessmentResultModal();" class="inline-flex items-center gap-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                    <span class="material-symbols-outlined text-sm">login</span>
                    Sign In
                </button>
            </div>
        </div>
        ` : ''}

        <!-- Disclaimer -->
        <div class="text-center text-xs text-gray-500 dark:text-gray-400">
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