<!-- Assessment Result Modal -->
<div id="assessmentResultModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-2">
    <div class="bg-white dark:bg-gray-800 rounded-lg max-w-lg w-full shadow-2xl">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-3 py-2 border-b border-gray-200 dark:border-gray-700">
            <h2 class="font-semibold text-gray-900 dark:text-white text-sm">Assessment Result</h2>
            <button onclick="closeAssessmentResultModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>

        <!-- Modal Content -->
        <div id="assessmentResultContent" class="p-3">
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
        <!-- Score Header -->
        <div class="bg-gradient-to-r ${resultData.gradientClass} p-3 text-white text-center rounded mb-3">
            <div class="text-lg font-bold">${resultData.severityLevel}</div>
            <div class="text-xs opacity-80">Score: ${resultData.score}/${resultData.maxScore} • ${resultData.resultTitle}</div>
        </div>

        <!-- Interpretation -->
        <div class="mb-3">
            <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">${resultData.interpretation}</p>
            
            <!-- Visual Scale -->
            <div class="relative">
                <div class="h-2 flex rounded-full bg-gray-200 dark:bg-gray-700 relative">
                    <div class="w-1/4 bg-green-500"></div>
                    <div class="w-1/4 bg-yellow-500"></div>
                    <div class="w-1/4 bg-orange-500"></div>
                    <div class="w-1/4 bg-red-500"></div>
                    <div class="absolute top-0 h-full" style="left: ${(resultData.score / resultData.maxScore) * 100}%;">
                        <div class="absolute -top-3 left-0 transform -translate-x-1/2">
                            <span class="material-symbols-outlined ${resultData.markerColor} text-sm">arrow_drop_down</span>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span>Low</span><span>High</span>
                </div>
            </div>
        </div>

        <!-- Top Recommendation -->
        <div class="mb-3">
            <div class="flex gap-2 p-2 bg-${resultData.recommendations[0].color}-50 dark:bg-${resultData.recommendations[0].color}-900/20 rounded">
                <span class="material-symbols-outlined text-${resultData.recommendations[0].color}-600 dark:text-${resultData.recommendations[0].color}-400 text-sm">${resultData.recommendations[0].icon}</span>
                <div>
                    <h5 class="font-medium text-gray-900 dark:text-white text-xs">${resultData.recommendations[0].title}</h5>
                    <p class="text-xs text-gray-600 dark:text-gray-400">${resultData.recommendations[0].description}</p>
                </div>
            </div>
        </div>

        ${resultData.showUrgentHelp ? `
        <!-- Crisis Support -->
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-300 dark:border-red-700 rounded p-2 mb-3">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-sm">emergency</span>
                <div class="flex-1">
                    <h4 class="font-medium text-red-900 dark:text-red-100 text-xs">Crisis Support Available</h4>
                    <a href="tel:988" class="text-red-600 dark:text-red-400 text-xs underline">Call 988</a>
                </div>
            </div>
        </div>
        ` : ''}

        <!-- Action Buttons -->
        <div class="flex gap-2 mb-2">
            <button onclick="closeAssessmentResultModal(); window.location.href='/assessments'" class="flex-1 bg-primary text-white text-center py-2 px-2 rounded font-medium hover:bg-primary/90 transition-colors text-xs">
                Take Another
            </button>
            <button onclick="printResults()" class="flex-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-center py-2 px-2 rounded font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-xs">
                Print
            </button>
        </div>

        ${!resultData.isAuthenticated ? `
        <!-- Quick CTA -->
        <div class="bg-primary/10 dark:bg-primary/20 rounded p-2 text-center">
            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Save your results</p>
            <div class="flex gap-1">
                <button onclick="openSignupModal(); closeAssessmentResultModal();" class="flex-1 bg-primary text-white px-2 py-1 rounded text-xs font-medium">Sign Up</button>
                <button onclick="openLoginModal(); closeAssessmentResultModal();" class="flex-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white px-2 py-1 rounded text-xs font-medium">Sign In</button>
            </div>
        </div>
        ` : ''}

        ${resultData.isLastResult ? `
        <div class="text-center text-xs text-gray-500 dark:text-gray-400 mt-2">
            Result from ${resultData.takenAtFormatted || 'previous session'}
        </div>
        ` : ''}
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