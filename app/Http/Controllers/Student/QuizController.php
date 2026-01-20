<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\{Quiz, QuizAttempt, QuizAnswer};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::active()
            ->with('category')
            ->withCount('questions')
            ->get();

        $myAttempts = auth()->user()->quizAttempts()
            ->with('quiz')
            ->latest()
            ->take(5)
            ->get();

        return view('student.quizzes.index', compact('quizzes', 'myAttempts'));
    }

    public function show(Quiz $quiz)
    {
        $quiz->load(['questions.options', 'category']);
        
        $previousAttempts = auth()->user()->quizAttempts()
            ->where('quiz_id', $quiz->id)
            ->latest()
            ->take(3)
            ->get();

        $canAttempt = $quiz->canUserAttempt(auth()->id());

        return view('student.quizzes.show', compact('quiz', 'previousAttempts', 'canAttempt'));
    }

    public function start(Quiz $quiz)
    {
        if (!$quiz->canUserAttempt(auth()->id())) {
            return redirect()->route('student.quizzes.show', $quiz)
                ->with('error', 'You have reached the maximum number of attempts for this quiz.');
        }

        $attempt = QuizAttempt::create([
            'user_id' => auth()->id(),
            'quiz_id' => $quiz->id,
            'started_at' => now(),
            'total_questions' => $quiz->questions->count(),
        ]);

        return redirect()->route('student.quizzes.take', $attempt);
    }

    public function take(QuizAttempt $attempt)
    {
        if ($attempt->user_id !== auth()->id()) {
            abort(403);
        }

        if ($attempt->completed_at) {
            return redirect()->route('student.quizzes.result', $attempt);
        }

        $attempt->load(['quiz.questions.options']);

        return view('student.quizzes.take', compact('attempt'));
    }

    public function submit(Request $request, QuizAttempt $attempt)
    {
        if ($attempt->user_id !== auth()->id() || $attempt->completed_at) {
            abort(403);
        }

        DB::transaction(function() use ($request, $attempt) {
            $correctAnswers = 0;
            $totalPoints = 0;
            $earnedPoints = 0;

            foreach ($attempt->quiz->questions as $question) {
                $answerId = $request->input("question_{$question->id}");
                $isCorrect = false;

                if ($question->type === 'multiple_choice') {
                    $option = $question->options()->find($answerId);
                    if ($option && $option->is_correct) {
                        $isCorrect = true;
                        $correctAnswers++;
                        $earnedPoints += $question->points;
                    }

                    QuizAnswer::create([
                        'attempt_id' => $attempt->id,
                        'question_id' => $question->id,
                        'option_id' => $answerId,
                        'is_correct' => $isCorrect,
                        'points_earned' => $isCorrect ? $question->points : 0,
                    ]);
                }

                $totalPoints += $question->points;
            }

            $score = $totalPoints > 0 ? ($earnedPoints / $totalPoints) * 100 : 0;
            $passed = $score >= $attempt->quiz->passing_score;

            $timeTaken = now()->diffInSeconds($attempt->started_at);

            $attempt->update([
                'score' => round($score, 2),
                'correct_answers' => $correctAnswers,
                'total_points' => $totalPoints,
                'earned_points' => $earnedPoints,
                'passed' => $passed,
                'completed_at' => now(),
                'time_taken' => $timeTaken,
            ]);
        });

        return redirect()->route('student.quizzes.result', $attempt)
            ->with('success', 'Quiz submitted successfully!');
    }

    public function result(QuizAttempt $attempt)
    {
        if ($attempt->user_id !== auth()->id()) {
            abort(403);
        }

        $attempt->load(['quiz', 'answers.question.options', 'answers.option']);

        return view('student.quizzes.result', compact('attempt'));
    }
}