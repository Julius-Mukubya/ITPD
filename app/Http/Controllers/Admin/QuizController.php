<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Quiz, QuizQuestion, QuizOption, Category};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with(['category', 'creator'])
            ->withCount(['questions', 'attempts'])
            ->latest()
            ->paginate(15);

        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.quizzes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'difficulty' => 'required|in:easy,medium,hard',
            'is_active' => 'boolean',
            'shuffle_questions' => 'boolean',
            'show_correct_answers' => 'boolean',
            'max_attempts' => 'nullable|integer|min:1',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.explanation' => 'nullable|string',
            'questions.*.points' => 'required|integer|min:1',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.options.*.text' => 'required|string',
            'questions.*.options.*.is_correct' => 'required|boolean',
        ]);

        DB::transaction(function() use ($validated) {
            $quiz = Quiz::create([
                'category_id' => $validated['category_id'],
                'created_by' => auth()->id(),
                'title' => $validated['title'],
                'description' => $validated['description'],
                'duration_minutes' => $validated['duration_minutes'],
                'passing_score' => $validated['passing_score'],
                'difficulty' => $validated['difficulty'],
                'is_active' => $validated['is_active'] ?? true,
                'shuffle_questions' => $validated['shuffle_questions'] ?? false,
                'show_correct_answers' => $validated['show_correct_answers'] ?? true,
                'max_attempts' => $validated['max_attempts'],
            ]);

            foreach ($validated['questions'] as $index => $questionData) {
                $question = QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => $questionData['question'],
                    'type' => 'multiple_choice',
                    'explanation' => $questionData['explanation'],
                    'points' => $questionData['points'],
                    'order' => $index + 1,
                ]);

                foreach ($questionData['options'] as $optIndex => $optionData) {
                    QuizOption::create([
                        'question_id' => $question->id,
                        'option_text' => $optionData['text'],
                        'is_correct' => $optionData['is_correct'],
                        'order' => $optIndex + 1,
                    ]);
                }
            }
        });

        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz created successfully!');
    }

    public function edit(Quiz $quiz)
    {
        $quiz->load(['questions.options', 'category']);
        $categories = Category::active()->get();
        return view('admin.quizzes.edit', compact('quiz', 'categories'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'difficulty' => 'required|in:easy,medium,hard',
            'is_active' => 'boolean',
            'shuffle_questions' => 'boolean',
            'show_correct_answers' => 'boolean',
            'max_attempts' => 'nullable|integer|min:1',
        ]);

        $quiz->update($validated);

        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz updated successfully!');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz deleted successfully!');
    }
}