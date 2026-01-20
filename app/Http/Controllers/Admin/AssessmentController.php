<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Assessment, AssessmentAttempt};
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function index()
    {
        $assessments = Assessment::withCount('attempts')
            ->latest()
            ->paginate(15);

        return view('admin.assessments.index', compact('assessments'));
    }

    public function show(Assessment $assessment)
    {
        $assessment->load(['attempts.user']);
        
        $stats = [
            'total_attempts' => $assessment->attempts()->count(),
            'this_week' => $assessment->attempts()->where('created_at', '>=', now()->subWeek())->count(),
            'this_month' => $assessment->attempts()->whereMonth('created_at', now()->month)->count(),
            'unique_users' => $assessment->attempts()->distinct('user_id')->count(),
        ];

        $recentAttempts = $assessment->attempts()
            ->with('user')
            ->latest()
            ->take(20)
            ->get();

        return view('admin.assessments.show', compact('assessment', 'stats', 'recentAttempts'));
    }

    public function create()
    {
        return view('admin.assessments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|in:audit,dudit,phq9,gad7,dass21,pss,cage',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.options' => 'required|string',
        ]);

        // Generate name from type
        $name = strtoupper($validated['type']);
        
        // Build scoring guidelines with interpretations
        $scoringGuidelines = [
            'ranges' => [
                ['min' => 0, 'max' => 25, 'level' => 'Minimal', 'interpretation' => $request->input('interpretation_minimal', 'Your results indicate minimal concerns in this area.')],
                ['min' => 26, 'max' => 50, 'level' => 'Mild', 'interpretation' => $request->input('interpretation_mild', 'Your results suggest mild concerns.')],
                ['min' => 51, 'max' => 75, 'level' => 'Moderate', 'interpretation' => $request->input('interpretation_moderate', 'Your results indicate moderate concerns.')],
                ['min' => 76, 'max' => 100, 'level' => 'Severe', 'interpretation' => $request->input('interpretation_severe', 'Your results suggest significant concerns.')],
            ]
        ];
        
        $assessment = Assessment::create([
            'name' => $name,
            'full_name' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'scoring_guidelines' => json_encode($scoringGuidelines),
            'is_active' => true,
        ]);

        // Create questions
        foreach ($validated['questions'] as $index => $questionData) {
            $assessment->questions()->create([
                'question' => $questionData['text'],
                'options' => $questionData['options'] ?? null,
                'order' => $index + 1,
            ]);
        }

        return redirect()->route('admin.assessments.index')
            ->with('success', 'Assessment created successfully!');
    }

    public function edit(Assessment $assessment)
    {
        $assessment->load('questions');
        return view('admin.assessments.edit', compact('assessment'));
    }

    public function update(Request $request, Assessment $assessment)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|in:audit,dudit,phq9,gad7,dass21,pss,cage',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.options' => 'required|string',
        ]);

        // Generate name from type
        $name = strtoupper($validated['type']);
        
        // Build scoring guidelines with interpretations
        $scoringGuidelines = [
            'ranges' => [
                ['min' => 0, 'max' => 25, 'level' => 'Minimal', 'interpretation' => $request->input('interpretation_minimal', 'Your results indicate minimal concerns in this area.')],
                ['min' => 26, 'max' => 50, 'level' => 'Mild', 'interpretation' => $request->input('interpretation_mild', 'Your results suggest mild concerns.')],
                ['min' => 51, 'max' => 75, 'level' => 'Moderate', 'interpretation' => $request->input('interpretation_moderate', 'Your results indicate moderate concerns.')],
                ['min' => 76, 'max' => 100, 'level' => 'Severe', 'interpretation' => $request->input('interpretation_severe', 'Your results suggest significant concerns.')],
            ]
        ];
        
        $assessment->update([
            'name' => $name,
            'full_name' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'scoring_guidelines' => json_encode($scoringGuidelines),
        ]);

        // Delete old questions and create new ones
        $assessment->questions()->delete();
        
        foreach ($validated['questions'] as $index => $questionData) {
            $assessment->questions()->create([
                'question' => $questionData['text'],
                'options' => $questionData['options'] ?? null,
                'order' => $index + 1,
            ]);
        }

        return redirect()->route('admin.assessments.index')
            ->with('success', 'Assessment updated successfully!');
    }

    public function destroy(Assessment $assessment)
    {
        // Check if assessment has attempts
        if ($assessment->attempts()->count() > 0) {
            return redirect()->route('admin.assessments.index')
                ->with('error', 'Cannot delete assessment with existing attempts.');
        }

        $assessment->questions()->delete();
        $assessment->delete();

        return redirect()->route('admin.assessments.index')
            ->with('success', 'Assessment deleted successfully!');
    }
}
