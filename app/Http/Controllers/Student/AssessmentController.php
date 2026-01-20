<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\{Assessment, AssessmentAttempt, AssessmentResponse};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssessmentController extends Controller
{
    public function index()
    {
        $assessments = Assessment::active()->with('questions')->get();
        
        // Get unique categories/types for filtering
        $categories = Assessment::active()
            ->select('type')
            ->distinct()
            ->pluck('type')
            ->map(function($type) {
                return [
                    'value' => $type,
                    'label' => ucfirst($type)
                ];
            });
        
        $myAttempts = auth()->user()->assessmentAttempts()
            ->with('assessment')
            ->latest()
            ->take(10)
            ->get();

        return view('student.assessments.index', compact('assessments', 'myAttempts', 'categories'));
    }

    public function show(Assessment $assessment)
    {
        $assessment->load('questions');
        
        $latestAttempt = auth()->user()->assessmentAttempts()
            ->where('assessment_id', $assessment->id)
            ->latest()
            ->first();

        return view('student.assessments.show', compact('assessment', 'latestAttempt'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'assessment_id' => 'required|exists:assessments,id',
            'is_anonymous' => 'boolean',
            'answers' => 'required|array',
        ]);

        $assessment = Assessment::findOrFail($request->assessment_id);

        $attempt = DB::transaction(function() use ($request, $assessment) {
            $totalScore = 0;
            $maxPossibleScore = 0;

            $attempt = AssessmentAttempt::create([
                'user_id' => auth()->id(),
                'assessment_id' => $assessment->id,
                'is_anonymous' => $request->is_anonymous ?? false,
                'taken_at' => now(),
                'total_score' => 0, // Will update
                'risk_level' => 'low', // Will update
            ]);

            foreach ($request->answers as $questionId => $optionIndex) {
                $question = $assessment->questions()->find($questionId);
                if (!$question) continue;

                $options = is_array($question->options) ? $question->options : json_decode($question->options, true);
                $score = $options[$optionIndex]['score'] ?? 0;
                $totalScore += $score;
                
                // Calculate max possible score for this question
                $maxScore = max(array_column($options, 'score'));
                $maxPossibleScore += $maxScore;

                AssessmentResponse::create([
                    'attempt_id' => $attempt->id,
                    'question_id' => $questionId,
                    'selected_option_index' => $optionIndex,
                    'score' => $score,
                ]);
            }

            // Convert to percentage (0-100)
            $percentageScore = $maxPossibleScore > 0 ? round(($totalScore / $maxPossibleScore) * 100) : 0;
            
            $riskLevel = $assessment->calculateRiskLevel($percentageScore);
            $interpretation = $assessment->getInterpretation($percentageScore);
            
            $recommendation = $interpretation['interpretation'] ?? $this->getRecommendation($assessment->type, $riskLevel);

            $attempt->update([
                'total_score' => $percentageScore,
                'risk_level' => $riskLevel,
                'recommendation' => $recommendation,
            ]);

            return $attempt;
        });

        return redirect()->route('student.assessments.result', $attempt)
            ->with('success', 'Assessment completed successfully!');
    }

    public function result(AssessmentAttempt $attempt)
    {
        if ($attempt->user_id !== auth()->id()) {
            abort(403);
        }

        $attempt->load('assessment', 'responses.question');

        return view('student.assessments.result', compact('attempt'));
    }

    private function getRecommendation($type, $riskLevel)
    {
        $recommendations = [
            'audit' => [
                'low' => 'Your alcohol consumption is within low-risk levels. Continue making responsible choices.',
                'medium' => 'Your alcohol consumption shows moderate risk. Consider reducing your intake and speaking with a counselor.',
                'high' => 'Your alcohol consumption indicates high risk. We strongly recommend speaking with a counselor immediately.',
            ],
            'dudit' => [
                'low' => 'Your drug use assessment shows low risk. Continue making healthy choices.',
                'medium' => 'Your drug use shows concerning patterns. Please consider speaking with a counselor.',
                'high' => 'Your drug use indicates serious risk. Please seek immediate support from our counseling services.',
            ],
        ];

        return $recommendations[$type][$riskLevel] ?? 'Please consult with a counselor for personalized guidance.';
    }
}