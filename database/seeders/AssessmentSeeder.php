<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assessment;
use App\Models\AssessmentQuestion;

class AssessmentSeeder extends Seeder
{
    public function run(): void
    {
        // Skip if assessments already exist (except when forcing)
        // Comment out the return to force re-seeding
        // if (Assessment::count() > 0) {
        //     return;
        // }

        // AUDIT Assessment
        if (!Assessment::where('type', 'audit')->exists()) {
            $audit = new Assessment();
            $audit->name = 'AUDIT';
            $audit->full_name = 'Alcohol Use Disorders Identification Test';
            $audit->description = 'A 10-question screening tool to assess alcohol consumption patterns.';
            $audit->type = 'audit';
            $audit->scoring_guidelines = json_encode([
                'ranges' => [
                    ['min' => 0, 'max' => 25, 'level' => 'Minimal', 'interpretation' => 'Your drinking patterns indicate low risk. Continue to drink responsibly.'],
                    ['min' => 26, 'max' => 50, 'level' => 'Mild', 'interpretation' => 'Your drinking patterns suggest some risk. Consider reducing your alcohol consumption.'],
                    ['min' => 51, 'max' => 75, 'level' => 'Moderate', 'interpretation' => 'Your drinking patterns indicate moderate risk. We recommend speaking with a counselor about your alcohol use.'],
                    ['min' => 76, 'max' => 100, 'level' => 'Severe', 'interpretation' => 'Your drinking patterns suggest high risk. Professional help is strongly recommended.'],
                ]
            ]);
            $audit->is_active = true;
            $audit->save();
        } else {
            $audit = Assessment::where('type', 'audit')->first();
        }

        $auditQuestions = [
            ['question' => 'How often do you have a drink containing alcohol?', 'options' => [
                ['text' => 'Never', 'score' => 0], ['text' => 'Monthly or less', 'score' => 1], ['text' => '2-4 times a month', 'score' => 2], ['text' => '2-3 times a week', 'score' => 3], ['text' => '4 or more times a week', 'score' => 4]
            ]],
            ['question' => 'How many standard drinks do you have on a typical day when drinking?', 'options' => [
                ['text' => '1 or 2', 'score' => 0], ['text' => '3 or 4', 'score' => 1], ['text' => '5 or 6', 'score' => 2], ['text' => '7 to 9', 'score' => 3], ['text' => '10 or more', 'score' => 4]
            ]],
            ['question' => 'How often do you have six or more drinks on one occasion?', 'options' => [
                ['text' => 'Never', 'score' => 0], ['text' => 'Less than monthly', 'score' => 1], ['text' => 'Monthly', 'score' => 2], ['text' => 'Weekly', 'score' => 3], ['text' => 'Daily or almost daily', 'score' => 4]
            ]],
            ['question' => 'How often during the last year have you found that you were not able to stop drinking once you had started?', 'options' => [
                ['text' => 'Never', 'score' => 0], ['text' => 'Less than monthly', 'score' => 1], ['text' => 'Monthly', 'score' => 2], ['text' => 'Weekly', 'score' => 3], ['text' => 'Daily or almost daily', 'score' => 4]
            ]],
            ['question' => 'How often during the last year have you failed to do what was normally expected of you because of drinking?', 'options' => [
                ['text' => 'Never', 'score' => 0], ['text' => 'Less than monthly', 'score' => 1], ['text' => 'Monthly', 'score' => 2], ['text' => 'Weekly', 'score' => 3], ['text' => 'Daily or almost daily', 'score' => 4]
            ]],
            ['question' => 'How often during the last year have you needed a first drink in the morning to get yourself going after a heavy drinking session?', 'options' => [
                ['text' => 'Never', 'score' => 0], ['text' => 'Less than monthly', 'score' => 1], ['text' => 'Monthly', 'score' => 2], ['text' => 'Weekly', 'score' => 3], ['text' => 'Daily or almost daily', 'score' => 4]
            ]],
            ['question' => 'How often during the last year have you had a feeling of guilt or remorse after drinking?', 'options' => [
                ['text' => 'Never', 'score' => 0], ['text' => 'Less than monthly', 'score' => 1], ['text' => 'Monthly', 'score' => 2], ['text' => 'Weekly', 'score' => 3], ['text' => 'Daily or almost daily', 'score' => 4]
            ]],
            ['question' => 'How often during the last year have you been unable to remember what happened the night before because of your drinking?', 'options' => [
                ['text' => 'Never', 'score' => 0], ['text' => 'Less than monthly', 'score' => 1], ['text' => 'Monthly', 'score' => 2], ['text' => 'Weekly', 'score' => 3], ['text' => 'Daily or almost daily', 'score' => 4]
            ]],
            ['question' => 'Have you or someone else been injured because of your drinking?', 'options' => [
                ['text' => 'No', 'score' => 0], ['text' => 'Yes, but not in the last year', 'score' => 2], ['text' => 'Yes, during the last year', 'score' => 4]
            ]],
            ['question' => 'Has a relative, friend, doctor, or other health care worker been concerned about your drinking or suggested you cut down?', 'options' => [
                ['text' => 'No', 'score' => 0], ['text' => 'Yes, but not in the last year', 'score' => 2], ['text' => 'Yes, during the last year', 'score' => 4]
            ]],
        ];

        if ($audit->questions()->count() == 0) {
            foreach ($auditQuestions as $index => $q) {
                $question = new AssessmentQuestion();
                $question->assessment_id = $audit->id;
                $question->question = $q['question'];
                $question->options = json_encode($q['options']);
                $question->order = $index + 1;
                $question->save();
            }
        }

        // DUDIT Assessment
        if (!Assessment::where('type', 'dudit')->exists()) {
            $dudit = new Assessment();
            $dudit->name = 'DUDIT';
            $dudit->full_name = 'Drug Use Disorders Identification Test';
            $dudit->description = 'An 11-item screening tool to identify drug-related problems.';
            $dudit->type = 'dudit';
            $dudit->scoring_guidelines = json_encode([
                'ranges' => [
                    ['min' => 0, 'max' => 25, 'level' => 'Minimal', 'interpretation' => 'Your drug use patterns indicate low risk.'],
                    ['min' => 26, 'max' => 50, 'level' => 'Mild', 'interpretation' => 'Your drug use patterns suggest some concerns. Consider reducing your substance use.'],
                    ['min' => 51, 'max' => 75, 'level' => 'Moderate', 'interpretation' => 'Your drug use patterns indicate moderate risk. Professional guidance is recommended.'],
                    ['min' => 76, 'max' => 100, 'level' => 'Severe', 'interpretation' => 'Your drug use patterns suggest significant concerns. Immediate professional help is strongly recommended.'],
                ]
            ]);
            $dudit->is_active = true;
            $dudit->save();
        } else {
            $dudit = Assessment::where('type', 'dudit')->first();
        }

        $duditQuestions = [
            ['question' => 'How often do you use drugs other than alcohol?', 'options' => [
                ['text' => 'Never', 'score' => 0], ['text' => 'Once a month or less', 'score' => 1], ['text' => '2-4 times a month', 'score' => 2], ['text' => '2-3 times a week', 'score' => 3], ['text' => '4 times a week or more', 'score' => 4]
            ]],
            ['question' => 'Do you use more than one type of drug on the same occasion?', 'options' => [
                ['text' => 'Never', 'score' => 0], ['text' => 'Once a month or less', 'score' => 1], ['text' => '2-4 times a month', 'score' => 2], ['text' => '2-3 times a week', 'score' => 3], ['text' => '4 times a week or more', 'score' => 4]
            ]],
            ['question' => 'How many times do you take drugs on a typical day when you use drugs?', 'options' => [
                ['text' => '0', 'score' => 0], ['text' => '1-2', 'score' => 1], ['text' => '3-4', 'score' => 2], ['text' => '5-6', 'score' => 3], ['text' => '7 or more', 'score' => 4]
            ]],
            ['question' => 'How often are you influenced heavily by drugs?', 'options' => [
                ['text' => 'Never', 'score' => 0], ['text' => 'Once a month or less', 'score' => 1], ['text' => '2-4 times a month', 'score' => 2], ['text' => '2-3 times a week', 'score' => 3], ['text' => '4 times a week or more', 'score' => 4]
            ]],
            ['question' => 'Over the past year, have you felt that your longing for drugs was so strong that you could not resist it?', 'options' => [
                ['text' => 'Never', 'score' => 0], ['text' => 'Once a month or less', 'score' => 1], ['text' => '2-4 times a month', 'score' => 2], ['text' => '2-3 times a week', 'score' => 3], ['text' => '4 times a week or more', 'score' => 4]
            ]],
            ['question' => 'Has it happened, over the past year, that you have not been able to stop taking drugs once you started?', 'options' => [
                ['text' => 'Never', 'score' => 0], ['text' => 'Once a month or less', 'score' => 1], ['text' => '2-4 times a month', 'score' => 2], ['text' => '2-3 times a week', 'score' => 3], ['text' => '4 times a week or more', 'score' => 4]
            ]],
            ['question' => 'How often over the past year have you taken drugs and then neglected to do something you should have done?', 'options' => [
                ['text' => 'Never', 'score' => 0], ['text' => 'Once a month or less', 'score' => 1], ['text' => '2-4 times a month', 'score' => 2], ['text' => '2-3 times a week', 'score' => 3], ['text' => '4 times a week or more', 'score' => 4]
            ]],
            ['question' => 'How often over the past year have you needed to take a drug the morning after heavy drug use the day before?', 'options' => [
                ['text' => 'Never', 'score' => 0], ['text' => 'Once a month or less', 'score' => 1], ['text' => '2-4 times a month', 'score' => 2], ['text' => '2-3 times a week', 'score' => 3], ['text' => '4 times a week or more', 'score' => 4]
            ]],
            ['question' => 'How often over the past year have you had guilt feelings or a bad conscience because you used drugs?', 'options' => [
                ['text' => 'Never', 'score' => 0], ['text' => 'Once a month or less', 'score' => 1], ['text' => '2-4 times a month', 'score' => 2], ['text' => '2-3 times a week', 'score' => 3], ['text' => '4 times a week or more', 'score' => 4]
            ]],
            ['question' => 'Have you or anyone else been hurt (mentally or physically) because you used drugs?', 'options' => [
                ['text' => 'No', 'score' => 0], ['text' => 'Yes, but not over the past year', 'score' => 2], ['text' => 'Yes, over the past year', 'score' => 4]
            ]],
            ['question' => 'Has a relative or a friend, a doctor or a nurse, or anyone else, been worried about your drug use or said to you that you should stop using drugs?', 'options' => [
                ['text' => 'No', 'score' => 0], ['text' => 'Yes, but not over the past year', 'score' => 2], ['text' => 'Yes, over the past year', 'score' => 4]
            ]],
        ];

        if ($dudit->questions()->count() == 0) {
            foreach ($duditQuestions as $index => $q) {
                $question = new AssessmentQuestion();
                $question->assessment_id = $dudit->id;
                $question->question = $q['question'];
                $question->options = json_encode($q['options']);
                $question->order = $index + 1;
                $question->save();
            }
        }

        // PHQ-9 Assessment (Depression)
        if (!Assessment::where('type', 'phq9')->exists()) {
            $phq9 = new Assessment();
            $phq9->name = 'PHQ-9';
            $phq9->full_name = 'Patient Health Questionnaire-9';
            $phq9->description = 'A 9-item screening tool for depression severity.';
            $phq9->type = 'phq9';
            $phq9->scoring_guidelines = json_encode([
                'ranges' => [
                    ['min' => 0, 'max' => 25, 'level' => 'Minimal', 'interpretation' => 'Your responses indicate minimal depression symptoms. Continue your healthy habits.'],
                    ['min' => 26, 'max' => 50, 'level' => 'Mild', 'interpretation' => 'Your responses suggest mild depression symptoms. Consider self-care strategies and monitoring your mood.'],
                    ['min' => 51, 'max' => 75, 'level' => 'Moderate', 'interpretation' => 'Your responses indicate moderate depression symptoms. Speaking with a mental health professional is recommended.'],
                    ['min' => 76, 'max' => 100, 'level' => 'Severe', 'interpretation' => 'Your responses suggest significant depression symptoms. Professional help is strongly recommended.'],
                ]
            ]);
            $phq9->is_active = true;
            $phq9->save();
        } else {
            $phq9 = Assessment::where('type', 'phq9')->first();
        }

        $phq9Questions = [
            ['question' => 'Little interest or pleasure in doing things', 'options' => [
                ['text' => 'Not at all', 'score' => 0], ['text' => 'Several days', 'score' => 1], ['text' => 'More than half the days', 'score' => 2], ['text' => 'Nearly every day', 'score' => 3]
            ]],
            ['question' => 'Feeling down, depressed, or hopeless', 'options' => [
                ['text' => 'Not at all', 'score' => 0], ['text' => 'Several days', 'score' => 1], ['text' => 'More than half the days', 'score' => 2], ['text' => 'Nearly every day', 'score' => 3]
            ]],
            ['question' => 'Trouble falling or staying asleep, or sleeping too much', 'options' => [
                ['text' => 'Not at all', 'score' => 0], ['text' => 'Several days', 'score' => 1], ['text' => 'More than half the days', 'score' => 2], ['text' => 'Nearly every day', 'score' => 3]
            ]],
            ['question' => 'Feeling tired or having little energy', 'options' => [
                ['text' => 'Not at all', 'score' => 0], ['text' => 'Several days', 'score' => 1], ['text' => 'More than half the days', 'score' => 2], ['text' => 'Nearly every day', 'score' => 3]
            ]],
            ['question' => 'Poor appetite or overeating', 'options' => [
                ['text' => 'Not at all', 'score' => 0], ['text' => 'Several days', 'score' => 1], ['text' => 'More than half the days', 'score' => 2], ['text' => 'Nearly every day', 'score' => 3]
            ]],
            ['question' => 'Feeling bad about yourself - or that you are a failure or have let yourself or your family down', 'options' => [
                ['text' => 'Not at all', 'score' => 0], ['text' => 'Several days', 'score' => 1], ['text' => 'More than half the days', 'score' => 2], ['text' => 'Nearly every day', 'score' => 3]
            ]],
            ['question' => 'Trouble concentrating on things, such as reading the newspaper or watching television', 'options' => [
                ['text' => 'Not at all', 'score' => 0], ['text' => 'Several days', 'score' => 1], ['text' => 'More than half the days', 'score' => 2], ['text' => 'Nearly every day', 'score' => 3]
            ]],
            ['question' => 'Moving or speaking so slowly that other people could have noticed. Or the opposite - being so fidgety or restless that you have been moving around a lot more than usual', 'options' => [
                ['text' => 'Not at all', 'score' => 0], ['text' => 'Several days', 'score' => 1], ['text' => 'More than half the days', 'score' => 2], ['text' => 'Nearly every day', 'score' => 3]
            ]],
            ['question' => 'Thoughts that you would be better off dead, or of hurting yourself in some way', 'options' => [
                ['text' => 'Not at all', 'score' => 0], ['text' => 'Several days', 'score' => 1], ['text' => 'More than half the days', 'score' => 2], ['text' => 'Nearly every day', 'score' => 3]
            ]],
        ];

        if ($phq9->questions()->count() == 0) {
            foreach ($phq9Questions as $index => $q) {
                $question = new AssessmentQuestion();
                $question->assessment_id = $phq9->id;
                $question->question = $q['question'];
                $question->options = json_encode($q['options']);
                $question->order = $index + 1;
                $question->save();
            }
        }

        // GAD-7 Assessment (Anxiety)
        if (!Assessment::where('type', 'gad7')->exists()) {
            $gad7 = new Assessment();
            $gad7->name = 'GAD-7';
            $gad7->full_name = 'Generalized Anxiety Disorder-7';
            $gad7->description = 'A 7-item screening tool for generalized anxiety disorder.';
            $gad7->type = 'gad7';
            $gad7->scoring_guidelines = json_encode([
                'ranges' => [
                    ['min' => 0, 'max' => 25, 'level' => 'Minimal', 'interpretation' => 'Your responses indicate minimal anxiety symptoms.'],
                    ['min' => 26, 'max' => 50, 'level' => 'Mild', 'interpretation' => 'Your responses suggest mild anxiety symptoms. Consider stress management techniques.'],
                    ['min' => 51, 'max' => 75, 'level' => 'Moderate', 'interpretation' => 'Your responses indicate moderate anxiety symptoms. Professional support may be helpful.'],
                    ['min' => 76, 'max' => 100, 'level' => 'Severe', 'interpretation' => 'Your responses suggest significant anxiety symptoms. Professional help is strongly recommended.'],
                ]
            ]);
            $gad7->is_active = true;
            $gad7->save();
        } else {
            $gad7 = Assessment::where('type', 'gad7')->first();
        }

        $gad7Questions = [
            ['question' => 'Feeling nervous, anxious, or on edge', 'options' => [
                ['text' => 'Not at all', 'score' => 0], ['text' => 'Several days', 'score' => 1], ['text' => 'More than half the days', 'score' => 2], ['text' => 'Nearly every day', 'score' => 3]
            ]],
            ['question' => 'Not being able to stop or control worrying', 'options' => [
                ['text' => 'Not at all', 'score' => 0], ['text' => 'Several days', 'score' => 1], ['text' => 'More than half the days', 'score' => 2], ['text' => 'Nearly every day', 'score' => 3]
            ]],
            ['question' => 'Worrying too much about different things', 'options' => [
                ['text' => 'Not at all', 'score' => 0], ['text' => 'Several days', 'score' => 1], ['text' => 'More than half the days', 'score' => 2], ['text' => 'Nearly every day', 'score' => 3]
            ]],
            ['question' => 'Trouble relaxing', 'options' => [
                ['text' => 'Not at all', 'score' => 0], ['text' => 'Several days', 'score' => 1], ['text' => 'More than half the days', 'score' => 2], ['text' => 'Nearly every day', 'score' => 3]
            ]],
            ['question' => 'Being so restless that it is hard to sit still', 'options' => [
                ['text' => 'Not at all', 'score' => 0], ['text' => 'Several days', 'score' => 1], ['text' => 'More than half the days', 'score' => 2], ['text' => 'Nearly every day', 'score' => 3]
            ]],
            ['question' => 'Becoming easily annoyed or irritable', 'options' => [
                ['text' => 'Not at all', 'score' => 0], ['text' => 'Several days', 'score' => 1], ['text' => 'More than half the days', 'score' => 2], ['text' => 'Nearly every day', 'score' => 3]
            ]],
            ['question' => 'Feeling afraid, as if something awful might happen', 'options' => [
                ['text' => 'Not at all', 'score' => 0], ['text' => 'Several days', 'score' => 1], ['text' => 'More than half the days', 'score' => 2], ['text' => 'Nearly every day', 'score' => 3]
            ]],
        ];

        if ($gad7->questions()->count() == 0) {
            foreach ($gad7Questions as $index => $q) {
                $question = new AssessmentQuestion();
                $question->assessment_id = $gad7->id;
                $question->question = $q['question'];
                $question->options = json_encode($q['options']);
                $question->order = $index + 1;
                $question->save();
            }
        }

        // CAGE Assessment (Substance Abuse)
        if (!Assessment::where('type', 'cage')->exists()) {
            $cage = new Assessment();
            $cage->name = 'CAGE';
            $cage->full_name = 'CAGE Substance Abuse Screening';
            $cage->description = 'A 4-item screening tool for substance abuse problems.';
            $cage->type = 'cage';
            $cage->scoring_guidelines = json_encode([
                'ranges' => [
                    ['min' => 0, 'max' => 25, 'level' => 'Minimal', 'interpretation' => 'Your responses indicate low risk for substance abuse problems.'],
                    ['min' => 26, 'max' => 50, 'level' => 'Mild', 'interpretation' => 'Your responses suggest some concerns about substance use.'],
                    ['min' => 51, 'max' => 75, 'level' => 'Moderate', 'interpretation' => 'Your responses indicate moderate risk. Consider speaking with a counselor.'],
                    ['min' => 76, 'max' => 100, 'level' => 'Severe', 'interpretation' => 'Your responses suggest significant substance abuse concerns. Professional help is recommended.'],
                ]
            ]);
            $cage->is_active = true;
            $cage->save();
        } else {
            $cage = Assessment::where('type', 'cage')->first();
        }

        $cageQuestions = [
            ['question' => 'Have you ever felt you should Cut down on your drinking or drug use?', 'options' => [
                ['text' => 'No', 'score' => 0], ['text' => 'Yes', 'score' => 1]
            ]],
            ['question' => 'Have people Annoyed you by criticizing your drinking or drug use?', 'options' => [
                ['text' => 'No', 'score' => 0], ['text' => 'Yes', 'score' => 1]
            ]],
            ['question' => 'Have you ever felt bad or Guilty about your drinking or drug use?', 'options' => [
                ['text' => 'No', 'score' => 0], ['text' => 'Yes', 'score' => 1]
            ]],
            ['question' => 'Have you ever had a drink or used drugs first thing in the morning (Eye-opener)?', 'options' => [
                ['text' => 'No', 'score' => 0], ['text' => 'Yes', 'score' => 1]
            ]],
        ];

        if ($cage->questions()->count() == 0) {
            foreach ($cageQuestions as $index => $q) {
                $question = new AssessmentQuestion();
                $question->assessment_id = $cage->id;
                $question->question = $q['question'];
                $question->options = json_encode($q['options']);
                $question->order = $index + 1;
                $question->save();
            }
        }
    }
}