<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\AssessmentAttempt;

class PublicAssessmentController extends Controller
{
    // Legacy hardcoded data - kept for backward compatibility
    private $assessmentData = [
        'stress' => [
            'name' => 'Stress Assessment',
            'questions' => [
                ['text' => 'How often have you felt stressed in the past month?', 'options' => ['0' => 'Never', '1' => 'Rarely', '2' => 'Sometimes', '3' => 'Often', '4' => 'Very Often']],
                ['text' => 'How often have you felt unable to control important things in your life?', 'options' => ['0' => 'Never', '1' => 'Rarely', '2' => 'Sometimes', '3' => 'Often', '4' => 'Very Often']],
                ['text' => 'How often have you felt nervous or stressed?', 'options' => ['0' => 'Never', '1' => 'Rarely', '2' => 'Sometimes', '3' => 'Often', '4' => 'Very Often']],
                ['text' => 'How often have you felt confident about handling personal problems?', 'options' => ['4' => 'Never', '3' => 'Rarely', '2' => 'Sometimes', '1' => 'Often', '0' => 'Very Often']],
                ['text' => 'How often have you felt that things were going your way?', 'options' => ['4' => 'Never', '3' => 'Rarely', '2' => 'Sometimes', '1' => 'Often', '0' => 'Very Often']],
                ['text' => 'How often have you found that you could not cope with all the things you had to do?', 'options' => ['0' => 'Never', '1' => 'Rarely', '2' => 'Sometimes', '3' => 'Often', '4' => 'Very Often']],
                ['text' => 'How often have you been able to control irritations in your life?', 'options' => ['4' => 'Never', '3' => 'Rarely', '2' => 'Sometimes', '1' => 'Often', '0' => 'Very Often']],
                ['text' => 'How often have you felt that you were on top of things?', 'options' => ['4' => 'Never', '3' => 'Rarely', '2' => 'Sometimes', '1' => 'Often', '0' => 'Very Often']],
                ['text' => 'How often have you been angered because of things outside your control?', 'options' => ['0' => 'Never', '1' => 'Rarely', '2' => 'Sometimes', '3' => 'Often', '4' => 'Very Often']],
                ['text' => 'How often have you felt difficulties were piling up so high you could not overcome them?', 'options' => ['0' => 'Never', '1' => 'Rarely', '2' => 'Sometimes', '3' => 'Often', '4' => 'Very Often']],
            ]
        ],
        'anxiety' => [
            'name' => 'Anxiety Screening (GAD-7)',
            'questions' => [
                ['text' => 'Feeling nervous, anxious, or on edge', 'options' => ['0' => 'Not at all', '1' => 'Several days', '2' => 'More than half the days', '3' => 'Nearly every day']],
                ['text' => 'Not being able to stop or control worrying', 'options' => ['0' => 'Not at all', '1' => 'Several days', '2' => 'More than half the days', '3' => 'Nearly every day']],
                ['text' => 'Worrying too much about different things', 'options' => ['0' => 'Not at all', '1' => 'Several days', '2' => 'More than half the days', '3' => 'Nearly every day']],
                ['text' => 'Trouble relaxing', 'options' => ['0' => 'Not at all', '1' => 'Several days', '2' => 'More than half the days', '3' => 'Nearly every day']],
                ['text' => 'Being so restless that it is hard to sit still', 'options' => ['0' => 'Not at all', '1' => 'Several days', '2' => 'More than half the days', '3' => 'Nearly every day']],
                ['text' => 'Becoming easily annoyed or irritable', 'options' => ['0' => 'Not at all', '1' => 'Several days', '2' => 'More than half the days', '3' => 'Nearly every day']],
                ['text' => 'Feeling afraid, as if something awful might happen', 'options' => ['0' => 'Not at all', '1' => 'Several days', '2' => 'More than half the days', '3' => 'Nearly every day']],
            ]
        ],
        'depression' => [
            'name' => 'Depression Screening (PHQ-9)',
            'questions' => [
                ['text' => 'Little interest or pleasure in doing things', 'options' => ['0' => 'Not at all', '1' => 'Several days', '2' => 'More than half the days', '3' => 'Nearly every day']],
                ['text' => 'Feeling down, depressed, or hopeless', 'options' => ['0' => 'Not at all', '1' => 'Several days', '2' => 'More than half the days', '3' => 'Nearly every day']],
                ['text' => 'Trouble falling or staying asleep, or sleeping too much', 'options' => ['0' => 'Not at all', '1' => 'Several days', '2' => 'More than half the days', '3' => 'Nearly every day']],
                ['text' => 'Feeling tired or having little energy', 'options' => ['0' => 'Not at all', '1' => 'Several days', '2' => 'More than half the days', '3' => 'Nearly every day']],
                ['text' => 'Poor appetite or overeating', 'options' => ['0' => 'Not at all', '1' => 'Several days', '2' => 'More than half the days', '3' => 'Nearly every day']],
                ['text' => 'Feeling bad about yourself or that you are a failure', 'options' => ['0' => 'Not at all', '1' => 'Several days', '2' => 'More than half the days', '3' => 'Nearly every day']],
                ['text' => 'Trouble concentrating on things', 'options' => ['0' => 'Not at all', '1' => 'Several days', '2' => 'More than half the days', '3' => 'Nearly every day']],
                ['text' => 'Moving or speaking slowly, or being fidgety or restless', 'options' => ['0' => 'Not at all', '1' => 'Several days', '2' => 'More than half the days', '3' => 'Nearly every day']],
                ['text' => 'Thoughts that you would be better off dead or hurting yourself', 'options' => ['0' => 'Not at all', '1' => 'Several days', '2' => 'More than half the days', '3' => 'Nearly every day']],
            ]
        ],
        'substance' => [
            'name' => 'Substance Use Screening',
            'questions' => [
                ['text' => 'How often do you have a drink containing alcohol?', 'options' => ['0' => 'Never', '1' => 'Monthly or less', '2' => '2-4 times a month', '3' => '2-3 times a week', '4' => '4+ times a week']],
                ['text' => 'How many drinks do you have on a typical day when drinking?', 'options' => ['0' => '1-2', '1' => '3-4', '2' => '5-6', '3' => '7-9', '4' => '10+']],
                ['text' => 'How often do you have six or more drinks on one occasion?', 'options' => ['0' => 'Never', '1' => 'Less than monthly', '2' => 'Monthly', '3' => 'Weekly', '4' => 'Daily or almost daily']],
                ['text' => 'How often during the last year have you found that you were not able to stop drinking once you had started?', 'options' => ['0' => 'Never', '1' => 'Less than monthly', '2' => 'Monthly', '3' => 'Weekly', '4' => 'Daily or almost daily']],
                ['text' => 'How often during the last year have you failed to do what was normally expected of you because of drinking?', 'options' => ['0' => 'Never', '1' => 'Less than monthly', '2' => 'Monthly', '3' => 'Weekly', '4' => 'Daily or almost daily']],
                ['text' => 'How often during the last year have you needed a first drink in the morning to get yourself going?', 'options' => ['0' => 'Never', '1' => 'Less than monthly', '2' => 'Monthly', '3' => 'Weekly', '4' => 'Daily or almost daily']],
                ['text' => 'How often during the last year have you had a feeling of guilt or remorse after drinking?', 'options' => ['0' => 'Never', '1' => 'Less than monthly', '2' => 'Monthly', '3' => 'Weekly', '4' => 'Daily or almost daily']],
                ['text' => 'How often during the last year have you been unable to remember what happened the night before because of drinking?', 'options' => ['0' => 'Never', '1' => 'Less than monthly', '2' => 'Monthly', '3' => 'Weekly', '4' => 'Daily or almost daily']],
                ['text' => 'Have you or someone else been injured because of your drinking?', 'options' => ['0' => 'No', '2' => 'Yes, but not in the last year', '4' => 'Yes, during the last year']],
                ['text' => 'Has a relative, friend, doctor, or other health care worker been concerned about your drinking or suggested you cut down?', 'options' => ['0' => 'No', '2' => 'Yes, but not in the last year', '4' => 'Yes, during the last year']],
            ]
        ],
        'wellbeing' => [
            'name' => 'Well-being Check',
            'questions' => [
                ['text' => 'I have been feeling optimistic about the future', 'options' => ['4' => 'All of the time', '3' => 'Often', '2' => 'Sometimes', '1' => 'Rarely', '0' => 'None of the time']],
                ['text' => 'I have been feeling useful', 'options' => ['4' => 'All of the time', '3' => 'Often', '2' => 'Sometimes', '1' => 'Rarely', '0' => 'None of the time']],
                ['text' => 'I have been feeling relaxed', 'options' => ['4' => 'All of the time', '3' => 'Often', '2' => 'Sometimes', '1' => 'Rarely', '0' => 'None of the time']],
                ['text' => 'I have been dealing with problems well', 'options' => ['4' => 'All of the time', '3' => 'Often', '2' => 'Sometimes', '1' => 'Rarely', '0' => 'None of the time']],
                ['text' => 'I have been thinking clearly', 'options' => ['4' => 'All of the time', '3' => 'Often', '2' => 'Sometimes', '1' => 'Rarely', '0' => 'None of the time']],
                ['text' => 'I have been feeling close to other people', 'options' => ['4' => 'All of the time', '3' => 'Often', '2' => 'Sometimes', '1' => 'Rarely', '0' => 'None of the time']],
                ['text' => 'I have been able to make up my own mind about things', 'options' => ['4' => 'All of the time', '3' => 'Often', '2' => 'Sometimes', '1' => 'Rarely', '0' => 'None of the time']],
                ['text' => 'I have been feeling good about myself', 'options' => ['4' => 'All of the time', '3' => 'Often', '2' => 'Sometimes', '1' => 'Rarely', '0' => 'None of the time']],
                ['text' => 'I have been feeling interested in new things', 'options' => ['4' => 'All of the time', '3' => 'Often', '2' => 'Sometimes', '1' => 'Rarely', '0' => 'None of the time']],
                ['text' => 'I have been feeling cheerful', 'options' => ['4' => 'All of the time', '3' => 'Often', '2' => 'Sometimes', '1' => 'Rarely', '0' => 'None of the time']],
                ['text' => 'I have been feeling confident', 'options' => ['4' => 'All of the time', '3' => 'Often', '2' => 'Sometimes', '1' => 'Rarely', '0' => 'None of the time']],
                ['text' => 'I have been feeling loved', 'options' => ['4' => 'All of the time', '3' => 'Often', '2' => 'Sometimes', '1' => 'Rarely', '0' => 'None of the time']],
            ]
        ],
        'sleep' => [
            'name' => 'Sleep Quality Assessment',
            'questions' => [
                ['text' => 'How would you rate your sleep quality overall?', 'options' => ['0' => 'Very good', '1' => 'Fairly good', '2' => 'Fairly bad', '3' => 'Very bad']],
                ['text' => 'How long does it usually take you to fall asleep?', 'options' => ['0' => 'Less than 15 minutes', '1' => '16-30 minutes', '2' => '31-60 minutes', '3' => 'More than 60 minutes']],
                ['text' => 'How many hours of actual sleep do you get at night?', 'options' => ['0' => '7+ hours', '1' => '6-7 hours', '2' => '5-6 hours', '3' => 'Less than 5 hours']],
                ['text' => 'How often do you wake up in the middle of the night?', 'options' => ['0' => 'Not during the past month', '1' => 'Less than once a week', '2' => 'Once or twice a week', '3' => 'Three or more times a week']],
                ['text' => 'How often do you have trouble staying awake during the day?', 'options' => ['0' => 'Not during the past month', '1' => 'Less than once a week', '2' => 'Once or twice a week', '3' => 'Three or more times a week']],
                ['text' => 'How often do you feel tired or fatigued during the day?', 'options' => ['0' => 'Not during the past month', '1' => 'Less than once a week', '2' => 'Once or twice a week', '3' => 'Three or more times a week']],
                ['text' => 'How often do you have difficulty concentrating due to sleepiness?', 'options' => ['0' => 'Not during the past month', '1' => 'Less than once a week', '2' => 'Once or twice a week', '3' => 'Three or more times a week']],
                ['text' => 'How often do you use medication to help you sleep?', 'options' => ['0' => 'Not during the past month', '1' => 'Less than once a week', '2' => 'Once or twice a week', '3' => 'Three or more times a week']],
            ]
        ],
    ];

    public function index()
    {
        // Get assessments from database
        $assessments = Assessment::active()->with('questions')->get();
        
        return view('public.assessments.index', compact('assessments'));
    }

    public function show($type)
    {
        // Try to get assessment from database first
        $assessment = Assessment::where('type', $type)->with('questions')->first();
        
        if ($assessment && $assessment->questions->count() > 0) {
            return view('public.assessments.show', [
                'assessment' => $assessment,
                'type' => $type,
                'questions' => $assessment->questions
            ]);
        }
        
        // Fallback to hardcoded data for backward compatibility
        if (!isset($this->assessmentData[$type])) {
            abort(404);
        }

        $assessmentData = $this->assessmentData[$type];
        
        return view('public.assessments.show', [
            'type' => $type,
            'questions' => $assessmentData['questions'],
            'assessment' => null
        ]);
    }

    public function result(Request $request, $type)
    {
        // Try to get assessment from database first
        $dbAssessment = Assessment::where('type', $type)->with('questions')->first();
        
        if ($dbAssessment && $dbAssessment->questions->count() > 0) {
            // Database assessment
            $score = 0;
            $questionCount = $dbAssessment->questions->count();
            
            // Calculate score from database questions
            for ($i = 1; $i <= $questionCount; $i++) {
                $score += (int) $request->input("q{$i}", 0);
            }
            
            // Calculate max score based on question options
            $maxScore = 0;
            foreach ($dbAssessment->questions as $question) {
                $options = is_array($question->options) ? $question->options : json_decode($question->options, true);
                if (is_array($options) && !empty($options)) {
                    $scores = array_column($options, 'score');
                    $maxScore += max($scores);
                }
            }
            
            $percentage = $maxScore > 0 ? ($score / $maxScore) * 100 : 0;
            
            // Determine severity level and interpretation from database or fallback
            [$severityLevel, $interpretation, $recommendations, $showUrgentHelp] = $this->interpretScoreFromDatabase($dbAssessment, $percentage, $type, $score, $maxScore);
            
            // Map severity level to risk level
            if (in_array($severityLevel, ['Minimal', 'Mild'])) {
                $riskLevel = 'low';
            } elseif ($severityLevel === 'Moderate') {
                $riskLevel = 'medium';
            } elseif ($severityLevel === 'Severe') {
                $riskLevel = 'high';
            } else {
                $riskLevel = 'low';
            }
            
            // Save assessment attempt if user is logged in
            if (auth()->check()) {
                $attempt = AssessmentAttempt::create([
                    'assessment_id' => $dbAssessment->id,
                    'user_id' => auth()->id(),
                    'total_score' => $score,
                    'risk_level' => $riskLevel,
                    'recommendation' => $interpretation,
                    'is_anonymous' => false,
                    'taken_at' => now(),
                ]);
                
                // Save individual responses
                foreach ($dbAssessment->questions as $index => $question) {
                    $answer = $request->input("q" . ($index + 1));
                    if ($answer !== null) {
                        $attempt->responses()->create([
                            'question_id' => $question->id,
                            'selected_option_index' => (int) $answer,
                            'score' => (int) $answer,
                        ]);
                    }
                }
            }
            
            // Set gradient and marker colors based on severity
            $gradientClass = $this->getGradientClass($type);
            $markerColor = $this->getMarkerColor($percentage);
            
            $resultData = [
                'assessmentName' => $dbAssessment->full_name ?? $dbAssessment->name,
                'resultTitle' => $this->getResultTitle($type),
                'score' => $score,
                'maxScore' => $maxScore,
                'severityLevel' => $severityLevel,
                'interpretation' => $interpretation,
                'recommendations' => $recommendations,
                'showUrgentHelp' => $showUrgentHelp,
                'gradientClass' => $gradientClass,
                'markerColor' => $markerColor,
                'isAuthenticated' => auth()->check(),
            ];
            
            // Return JSON for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => $resultData
                ]);
            }
            
            return view('public.assessments.result', $resultData);
        }
        
        // Fallback to hardcoded assessment
        if (!isset($this->assessmentData[$type])) {
            abort(404);
        }

        $assessment = $this->assessmentData[$type];
        $score = 0;
        $questionCount = count($assessment['questions']);

        // Calculate score
        for ($i = 1; $i <= $questionCount; $i++) {
            $score += (int) $request->input("q{$i}", 0);
        }

        $maxScore = $questionCount * 4;
        $percentage = ($score / $maxScore) * 100;

        // Determine severity level and interpretation
        [$severityLevel, $interpretation, $recommendations, $showUrgentHelp] = $this->interpretScore($type, $score, $maxScore, $percentage);

        // Set gradient and marker colors based on severity
        $gradientClass = $this->getGradientClass($type);
        $markerColor = $this->getMarkerColor($percentage);

        $resultData = [
            'assessmentName' => $assessment['name'],
            'resultTitle' => $this->getResultTitle($type),
            'score' => $score,
            'maxScore' => $maxScore,
            'severityLevel' => $severityLevel,
            'interpretation' => $interpretation,
            'recommendations' => $recommendations,
            'showUrgentHelp' => $showUrgentHelp,
            'gradientClass' => $gradientClass,
            'markerColor' => $markerColor,
            'isAuthenticated' => auth()->check(),
        ];
        
        // Return JSON for AJAX requests
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $resultData
            ]);
        }

        return view('public.assessments.result', $resultData);
    }

    private function interpretScoreFromDatabase($assessment, $percentage, $type, $score, $maxScore)
    {
        $guidelines = is_array($assessment->scoring_guidelines) 
            ? $assessment->scoring_guidelines 
            : json_decode($assessment->scoring_guidelines, true);
        
        // Check if we have custom ranges defined
        if (isset($guidelines['ranges']) && is_array($guidelines['ranges'])) {
            foreach ($guidelines['ranges'] as $range) {
                if ($percentage >= $range['min'] && $percentage <= $range['max']) {
                    $severityLevel = $range['level'];
                    $interpretation = $range['interpretation'];
                    $showUrgentHelp = ($range['level'] === 'Severe');
                    
                    // Get recommendations based on severity
                    $recommendations = $this->getRecommendationsForLevel($range['level']);
                    
                    return [$severityLevel, $interpretation, $recommendations, $showUrgentHelp];
                }
            }
        }
        
        // Fallback to default interpretation
        return $this->interpretScore($type, $score, $maxScore, $percentage);
    }
    
    private function getRecommendationsForLevel($level)
    {
        $recommendationSets = [
            'Minimal' => [
                ['icon' => 'check_circle', 'color' => 'green', 'title' => 'Keep Up Good Habits', 'description' => 'Continue your current self-care practices and healthy routines.'],
                ['icon' => 'groups', 'color' => 'blue', 'title' => 'Stay Connected', 'description' => 'Maintain your social connections and support network.'],
                ['icon' => 'self_improvement', 'color' => 'purple', 'title' => 'Practice Prevention', 'description' => 'Regular mindfulness or relaxation can help maintain your wellbeing.'],
            ],
            'Mild' => [
                ['icon' => 'self_improvement', 'color' => 'blue', 'title' => 'Practice Self-Care', 'description' => 'Incorporate relaxation techniques like deep breathing or meditation into your daily routine.'],
                ['icon' => 'directions_run', 'color' => 'green', 'title' => 'Stay Active', 'description' => 'Regular physical activity can significantly improve your mental health.'],
                ['icon' => 'library_books', 'color' => 'purple', 'title' => 'Learn More', 'description' => 'Explore our educational resources to better understand and manage your symptoms.'],
            ],
            'Moderate' => [
                ['icon' => 'psychology', 'color' => 'purple', 'title' => 'Consider Counseling', 'description' => 'Professional support can help you develop effective coping strategies.'],
                ['icon' => 'self_improvement', 'color' => 'blue', 'title' => 'Practice Stress Management', 'description' => 'Learn and practice stress reduction techniques regularly.'],
                ['icon' => 'groups', 'color' => 'green', 'title' => 'Build Support Network', 'description' => 'Connect with friends, family, or support groups who can help.'],
            ],
            'Severe' => [
                ['icon' => 'emergency', 'color' => 'red', 'title' => 'Seek Professional Help', 'description' => 'Contact a mental health professional or counselor as soon as possible.'],
                ['icon' => 'phone', 'color' => 'orange', 'title' => 'Use Crisis Resources', 'description' => 'If you\'re in crisis, call 988 for immediate support.'],
                ['icon' => 'support_agent', 'color' => 'purple', 'title' => 'Schedule Counseling', 'description' => 'Book an appointment with one of our licensed counselors.'],
            ],
        ];
        
        return $recommendationSets[$level] ?? $recommendationSets['Minimal'];
    }

    private function interpretScore($type, $score, $maxScore, $percentage)
    {
        $showUrgentHelp = false;
        
        if ($percentage < 25) {
            $severityLevel = 'Minimal';
            $interpretation = 'Your results indicate minimal concerns in this area. Continue maintaining healthy habits and reach out if things change.';
            $recommendations = [
                ['icon' => 'check_circle', 'color' => 'green', 'title' => 'Keep Up Good Habits', 'description' => 'Continue your current self-care practices and healthy routines.'],
                ['icon' => 'groups', 'color' => 'blue', 'title' => 'Stay Connected', 'description' => 'Maintain your social connections and support network.'],
                ['icon' => 'self_improvement', 'color' => 'purple', 'title' => 'Practice Prevention', 'description' => 'Regular mindfulness or relaxation can help maintain your wellbeing.'],
            ];
        } elseif ($percentage < 50) {
            $severityLevel = 'Mild';
            $interpretation = 'Your results suggest mild concerns. Consider implementing some self-care strategies and monitoring your symptoms.';
            $recommendations = [
                ['icon' => 'self_improvement', 'color' => 'blue', 'title' => 'Practice Self-Care', 'description' => 'Incorporate relaxation techniques like deep breathing or meditation into your daily routine.'],
                ['icon' => 'directions_run', 'color' => 'green', 'title' => 'Stay Active', 'description' => 'Regular physical activity can significantly improve your mental health.'],
                ['icon' => 'library_books', 'color' => 'purple', 'title' => 'Learn More', 'description' => 'Explore our educational resources to better understand and manage your symptoms.'],
            ];
        } elseif ($percentage < 75) {
            $severityLevel = 'Moderate';
            $interpretation = 'Your results indicate moderate concerns. We recommend speaking with a counselor or mental health professional for support.';
            $recommendations = [
                ['icon' => 'psychology', 'color' => 'purple', 'title' => 'Consider Counseling', 'description' => 'Professional support can help you develop effective coping strategies.'],
                ['icon' => 'self_improvement', 'color' => 'blue', 'title' => 'Practice Stress Management', 'description' => 'Learn and practice stress reduction techniques regularly.'],
                ['icon' => 'groups', 'color' => 'green', 'title' => 'Build Support Network', 'description' => 'Connect with friends, family, or support groups who can help.'],
            ];
        } else {
            $severityLevel = 'Severe';
            $interpretation = 'Your results suggest significant concerns that warrant professional attention. We strongly encourage you to reach out to a mental health professional.';
            $showUrgentHelp = true;
            $recommendations = [
                ['icon' => 'emergency', 'color' => 'red', 'title' => 'Seek Professional Help', 'description' => 'Contact a mental health professional or counselor as soon as possible.'],
                ['icon' => 'phone', 'color' => 'orange', 'title' => 'Use Crisis Resources', 'description' => 'If you\'re in crisis, call 988 for immediate support.'],
                ['icon' => 'support_agent', 'color' => 'purple', 'title' => 'Schedule Counseling', 'description' => 'Book an appointment with one of our licensed counselors.'],
            ];
        }

        return [$severityLevel, $interpretation, $recommendations, $showUrgentHelp];
    }

    private function getGradientClass($type)
    {
        $gradients = [
            // Legacy types
            'stress' => 'from-orange-500 to-red-600',
            'anxiety' => 'from-purple-500 to-indigo-600',
            'depression' => 'from-blue-500 to-cyan-600',
            'substance' => 'from-yellow-500 to-orange-600',
            'wellbeing' => 'from-green-500 to-emerald-600',
            'sleep' => 'from-indigo-500 to-purple-600',
            // Database types
            'audit' => 'from-yellow-500 to-orange-600',
            'dudit' => 'from-orange-500 to-red-600',
            'phq9' => 'from-blue-500 to-cyan-600',
            'gad7' => 'from-purple-500 to-indigo-600',
            'dass21' => 'from-pink-500 to-rose-600',
            'pss' => 'from-orange-500 to-red-600',
            'cage' => 'from-amber-500 to-orange-600',
        ];

        return $gradients[$type] ?? 'from-primary to-emerald-600';
    }

    private function getResultTitle($type)
    {
        $titles = [
            // Legacy types
            'stress' => 'Stress Level',
            'anxiety' => 'Anxiety Level',
            'depression' => 'Depression Level',
            'substance' => 'Substance Use Risk',
            'wellbeing' => 'Well-being Score',
            'sleep' => 'Sleep Quality',
            // Database types
            'audit' => 'Alcohol Use Risk',
            'dudit' => 'Drug Use Risk',
            'phq9' => 'Depression Level',
            'gad7' => 'Anxiety Level',
            'dass21' => 'Mental Health Status',
            'pss' => 'Stress Level',
            'cage' => 'Substance Abuse Risk',
        ];

        return $titles[$type] ?? 'Assessment Result';
    }

    private function getMarkerColor($percentage)
    {
        if ($percentage < 25) return 'text-green-500';
        if ($percentage < 50) return 'text-yellow-500';
        if ($percentage < 75) return 'text-orange-500';
        return 'text-red-500';
    }
}
