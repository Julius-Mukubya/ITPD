<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Category;
use App\Models\User;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        // Skip if quizzes already exist
        if (Quiz::count() > 0) {
            $this->command->info('Quizzes already exist. Skipping...');
            return;
        }

        $admin = User::where('role', 'admin')->first();
        $creatorId = $admin ? $admin->id : 1;

        // Get categories
        $alcoholCategory = Category::where('slug', 'alcohol-awareness')->first();
        $drugCategory = Category::where('slug', 'drug-prevention')->first();
        $mentalHealthCategory = Category::where('slug', 'mental-health')->first();

        // Quiz 1: Alcohol Awareness
        $alcoholQuiz = Quiz::create([
            'category_id' => $alcoholCategory ? $alcoholCategory->id : 1,
            'created_by' => $creatorId,
            'title' => 'Alcohol Awareness Quiz',
            'description' => 'Test your knowledge about alcohol effects, risks, and safe practices.',
            'duration_minutes' => 10,
            'passing_score' => 70,
            'difficulty' => 'easy',
            'is_active' => true,
            'shuffle_questions' => true,
            'show_correct_answers' => true,
            'max_attempts' => null,
        ]);

        $alcoholQuestions = [
            [
                'question' => 'What is the legal blood alcohol concentration (BAC) limit for driving in most places?',
                'options' => json_encode([
                    ['text' => '0.05%', 'is_correct' => false],
                    ['text' => '0.08%', 'is_correct' => true],
                    ['text' => '0.10%', 'is_correct' => false],
                    ['text' => '0.15%', 'is_correct' => false],
                ]),
                'explanation' => 'The legal BAC limit for driving is 0.08% in most jurisdictions. However, impairment begins at much lower levels.',
                'points' => 10,
                'order' => 1,
            ],
            [
                'question' => 'How long does it typically take for the body to metabolize one standard drink?',
                'options' => json_encode([
                    ['text' => '30 minutes', 'is_correct' => false],
                    ['text' => '1 hour', 'is_correct' => true],
                    ['text' => '2 hours', 'is_correct' => false],
                    ['text' => '4 hours', 'is_correct' => false],
                ]),
                'explanation' => 'The liver metabolizes approximately one standard drink per hour. This rate cannot be sped up by coffee, cold showers, or other methods.',
                'points' => 10,
                'order' => 2,
            ],
            [
                'question' => 'Which of the following is NOT a sign of alcohol poisoning?',
                'options' => json_encode([
                    ['text' => 'Confusion or stupor', 'is_correct' => false],
                    ['text' => 'Slow or irregular breathing', 'is_correct' => false],
                    ['text' => 'Increased energy and alertness', 'is_correct' => true],
                    ['text' => 'Vomiting', 'is_correct' => false],
                ]),
                'explanation' => 'Alcohol is a depressant, so increased energy is not a sign of poisoning. Signs include confusion, slow breathing, vomiting, and unconsciousness.',
                'points' => 10,
                'order' => 3,
            ],
            [
                'question' => 'Binge drinking is defined as consuming how many drinks in about 2 hours?',
                'options' => json_encode([
                    ['text' => '2-3 drinks', 'is_correct' => false],
                    ['text' => '4-5 drinks', 'is_correct' => true],
                    ['text' => '6-7 drinks', 'is_correct' => false],
                    ['text' => '8-9 drinks', 'is_correct' => false],
                ]),
                'explanation' => 'Binge drinking is typically defined as 4+ drinks for women or 5+ drinks for men within about 2 hours.',
                'points' => 10,
                'order' => 4,
            ],
            [
                'question' => 'Which part of the brain is most affected by alcohol, leading to impaired judgment?',
                'options' => json_encode([
                    ['text' => 'Cerebellum', 'is_correct' => false],
                    ['text' => 'Prefrontal cortex', 'is_correct' => true],
                    ['text' => 'Hippocampus', 'is_correct' => false],
                    ['text' => 'Medulla', 'is_correct' => false],
                ]),
                'explanation' => 'The prefrontal cortex, responsible for decision-making and impulse control, is significantly affected by alcohol.',
                'points' => 10,
                'order' => 5,
            ],
        ];

        foreach ($alcoholQuestions as $q) {
            $options = json_decode($q['options'], true);
            unset($q['options']);
            $question = QuizQuestion::create(array_merge($q, ['quiz_id' => $alcoholQuiz->id]));
            
            foreach ($options as $index => $option) {
                \App\Models\QuizOption::create([
                    'question_id' => $question->id,
                    'option_text' => $option['text'],
                    'is_correct' => $option['is_correct'],
                    'order' => $index + 1,
                ]);
            }
        }

        // Quiz 2: Drug Awareness
        $drugQuiz = Quiz::create([
            'category_id' => $drugCategory ? $drugCategory->id : 2,
            'created_by' => $creatorId,
            'title' => 'Drug Awareness and Prevention Quiz',
            'description' => 'Test your understanding of different drug types, their effects, and associated risks.',
            'duration_minutes' => 15,
            'passing_score' => 70,
            'difficulty' => 'medium',
            'is_active' => true,
            'shuffle_questions' => true,
            'show_correct_answers' => true,
            'max_attempts' => null,
        ]);

        $drugQuestions = [
            [
                'question' => 'Which category of drugs includes cocaine and amphetamines?',
                'options' => json_encode([
                    ['text' => 'Depressants', 'is_correct' => false],
                    ['text' => 'Stimulants', 'is_correct' => true],
                    ['text' => 'Hallucinogens', 'is_correct' => false],
                    ['text' => 'Opioids', 'is_correct' => false],
                ]),
                'explanation' => 'Stimulants increase alertness and energy by speeding up the central nervous system.',
                'points' => 10,
                'order' => 1,
            ],
            [
                'question' => 'What is the primary danger of mixing depressants (like alcohol) with benzodiazepines?',
                'options' => json_encode([
                    ['text' => 'Increased energy', 'is_correct' => false],
                    ['text' => 'Respiratory depression', 'is_correct' => true],
                    ['text' => 'Hallucinations', 'is_correct' => false],
                    ['text' => 'Increased appetite', 'is_correct' => false],
                ]),
                'explanation' => 'Combining depressants can dangerously slow breathing and heart rate, potentially leading to overdose and death.',
                'points' => 10,
                'order' => 2,
            ],
            [
                'question' => 'Which statement about prescription drug misuse is TRUE?',
                'options' => json_encode([
                    ['text' => 'It\'s safe because they\'re prescribed by doctors', 'is_correct' => false],
                    ['text' => 'It can lead to addiction and overdose', 'is_correct' => true],
                    ['text' => 'It\'s legal if you have a friend\'s prescription', 'is_correct' => false],
                    ['text' => 'It has no side effects', 'is_correct' => false],
                ]),
                'explanation' => 'Prescription drugs can be dangerous when misused. They should only be taken as prescribed by your own doctor.',
                'points' => 10,
                'order' => 3,
            ],
            [
                'question' => 'What is the main active ingredient in marijuana?',
                'options' => json_encode([
                    ['text' => 'CBD', 'is_correct' => false],
                    ['text' => 'THC', 'is_correct' => true],
                    ['text' => 'Nicotine', 'is_correct' => false],
                    ['text' => 'Caffeine', 'is_correct' => false],
                ]),
                'explanation' => 'THC (tetrahydrocannabinol) is the primary psychoactive compound in marijuana.',
                'points' => 10,
                'order' => 4,
            ],
            [
                'question' => 'Which of the following is a sign of opioid overdose?',
                'options' => json_encode([
                    ['text' => 'Dilated pupils', 'is_correct' => false],
                    ['text' => 'Pinpoint pupils', 'is_correct' => true],
                    ['text' => 'Increased heart rate', 'is_correct' => false],
                    ['text' => 'Hyperactivity', 'is_correct' => false],
                ]),
                'explanation' => 'Opioid overdose signs include pinpoint pupils, slow/stopped breathing, unconsciousness, and blue lips or fingernails.',
                'points' => 10,
                'order' => 5,
            ],
            [
                'question' => 'What percentage of people who start using drugs in adolescence develop addiction?',
                'options' => json_encode([
                    ['text' => 'About 5%', 'is_correct' => false],
                    ['text' => 'About 15-17%', 'is_correct' => true],
                    ['text' => 'About 30%', 'is_correct' => false],
                    ['text' => 'About 50%', 'is_correct' => false],
                ]),
                'explanation' => 'Research shows that about 15-17% of people who start using substances in adolescence develop addiction, compared to 9% overall.',
                'points' => 10,
                'order' => 6,
            ],
        ];

        foreach ($drugQuestions as $q) {
            $options = json_decode($q['options'], true);
            unset($q['options']);
            $question = QuizQuestion::create(array_merge($q, ['quiz_id' => $drugQuiz->id]));
            
            foreach ($options as $index => $option) {
                \App\Models\QuizOption::create([
                    'question_id' => $question->id,
                    'option_text' => $option['text'],
                    'is_correct' => $option['is_correct'],
                    'order' => $index + 1,
                ]);
            }
        }

        // Quiz 3: Mental Health Literacy
        $mentalHealthQuiz = Quiz::create([
            'category_id' => $mentalHealthCategory ? $mentalHealthCategory->id : 3,
            'created_by' => $creatorId,
            'title' => 'Mental Health Literacy Quiz',
            'description' => 'Assess your knowledge about mental health, stress management, and when to seek help.',
            'duration_minutes' => 12,
            'passing_score' => 70,
            'difficulty' => 'easy',
            'is_active' => true,
            'shuffle_questions' => true,
            'show_correct_answers' => true,
            'max_attempts' => null,
        ]);

        $mentalHealthQuestions = [
            [
                'question' => 'Which of the following is a healthy way to cope with stress?',
                'options' => json_encode([
                    ['text' => 'Using alcohol to relax', 'is_correct' => false],
                    ['text' => 'Exercise and physical activity', 'is_correct' => true],
                    ['text' => 'Isolating yourself from others', 'is_correct' => false],
                    ['text' => 'Ignoring the problem', 'is_correct' => false],
                ]),
                'explanation' => 'Exercise is a healthy coping mechanism that releases endorphins and reduces stress naturally.',
                'points' => 10,
                'order' => 1,
            ],
            [
                'question' => 'What is the recommended amount of sleep for college students?',
                'options' => json_encode([
                    ['text' => '4-5 hours', 'is_correct' => false],
                    ['text' => '6-7 hours', 'is_correct' => false],
                    ['text' => '7-9 hours', 'is_correct' => true],
                    ['text' => '10-12 hours', 'is_correct' => false],
                ]),
                'explanation' => 'Most adults, including college students, need 7-9 hours of sleep per night for optimal health and cognitive function.',
                'points' => 10,
                'order' => 2,
            ],
            [
                'question' => 'Which statement about depression is TRUE?',
                'options' => json_encode([
                    ['text' => 'It\'s just feeling sad and will go away on its own', 'is_correct' => false],
                    ['text' => 'It\'s a treatable medical condition', 'is_correct' => true],
                    ['text' => 'It only affects weak people', 'is_correct' => false],
                    ['text' => 'Medication is the only treatment', 'is_correct' => false],
                ]),
                'explanation' => 'Depression is a treatable medical condition that can be managed with therapy, medication, lifestyle changes, or a combination.',
                'points' => 10,
                'order' => 3,
            ],
            [
                'question' => 'What is mindfulness?',
                'options' => json_encode([
                    ['text' => 'Thinking about the future', 'is_correct' => false],
                    ['text' => 'Being present in the moment without judgment', 'is_correct' => true],
                    ['text' => 'Avoiding difficult emotions', 'is_correct' => false],
                    ['text' => 'Multitasking effectively', 'is_correct' => false],
                ]),
                'explanation' => 'Mindfulness is the practice of being fully present and aware in the current moment without judgment.',
                'points' => 10,
                'order' => 4,
            ],
            [
                'question' => 'When should you seek professional help for mental health concerns?',
                'options' => json_encode([
                    ['text' => 'Only when you can\'t function at all', 'is_correct' => false],
                    ['text' => 'When symptoms interfere with daily life', 'is_correct' => true],
                    ['text' => 'Never, you should handle it alone', 'is_correct' => false],
                    ['text' => 'Only if you\'re suicidal', 'is_correct' => false],
                ]),
                'explanation' => 'Seek help when symptoms interfere with daily functioning, relationships, or quality of life. Early intervention leads to better outcomes.',
                'points' => 10,
                'order' => 5,
            ],
        ];

        foreach ($mentalHealthQuestions as $q) {
            $options = json_decode($q['options'], true);
            unset($q['options']);
            $question = QuizQuestion::create(array_merge($q, ['quiz_id' => $mentalHealthQuiz->id]));
            
            foreach ($options as $index => $option) {
                \App\Models\QuizOption::create([
                    'question_id' => $question->id,
                    'option_text' => $option['text'],
                    'is_correct' => $option['is_correct'],
                    'order' => $index + 1,
                ]);
            }
        }

        // Quiz 4: Harm Reduction and Safety
        $safetyQuiz = Quiz::create([
            'category_id' => $alcoholCategory ? $alcoholCategory->id : 1,
            'created_by' => $creatorId,
            'title' => 'Harm Reduction and Safety Quiz',
            'description' => 'Learn about strategies to reduce risks and stay safe in various situations.',
            'duration_minutes' => 10,
            'passing_score' => 70,
            'difficulty' => 'easy',
            'is_active' => true,
            'shuffle_questions' => true,
            'show_correct_answers' => true,
            'max_attempts' => null,
        ]);

        $safetyQuestions = [
            [
                'question' => 'What should you do if you suspect someone has alcohol poisoning?',
                'options' => json_encode([
                    ['text' => 'Let them sleep it off', 'is_correct' => false],
                    ['text' => 'Give them coffee', 'is_correct' => false],
                    ['text' => 'Call emergency services immediately', 'is_correct' => true],
                    ['text' => 'Give them a cold shower', 'is_correct' => false],
                ]),
                'explanation' => 'Alcohol poisoning is a medical emergency. Call 911 immediately and stay with the person until help arrives.',
                'points' => 10,
                'order' => 1,
            ],
            [
                'question' => 'Which is the safest way to reduce risks if you choose to drink?',
                'options' => json_encode([
                    ['text' => 'Drink quickly to get it over with', 'is_correct' => false],
                    ['text' => 'Alternate alcoholic drinks with water', 'is_correct' => true],
                    ['text' => 'Mix different types of alcohol', 'is_correct' => false],
                    ['text' => 'Drink on an empty stomach', 'is_correct' => false],
                ]),
                'explanation' => 'Alternating with water helps you stay hydrated, pace yourself, and reduce overall alcohol consumption.',
                'points' => 10,
                'order' => 2,
            ],
            [
                'question' => 'What is the most important thing to do if a friend is struggling with substance use?',
                'options' => json_encode([
                    ['text' => 'Ignore it to avoid conflict', 'is_correct' => false],
                    ['text' => 'Express concern and encourage professional help', 'is_correct' => true],
                    ['text' => 'Use substances with them to monitor them', 'is_correct' => false],
                    ['text' => 'Tell everyone about their problem', 'is_correct' => false],
                ]),
                'explanation' => 'Express concern non-judgmentally and encourage them to seek professional help. Offer support but maintain boundaries.',
                'points' => 10,
                'order' => 3,
            ],
            [
                'question' => 'Which statement about consent is TRUE?',
                'options' => json_encode([
                    ['text' => 'Someone who is intoxicated can give consent', 'is_correct' => false],
                    ['text' => 'Consent must be clear, voluntary, and ongoing', 'is_correct' => true],
                    ['text' => 'Silence means consent', 'is_correct' => false],
                    ['text' => 'Past consent means future consent', 'is_correct' => false],
                ]),
                'explanation' => 'Consent must be freely given, enthusiastic, and can be withdrawn at any time. Intoxication impairs the ability to consent.',
                'points' => 10,
                'order' => 4,
            ],
            [
                'question' => 'What is the best way to help prevent a friend from driving under the influence?',
                'options' => json_encode([
                    ['text' => 'Let them make their own decision', 'is_correct' => false],
                    ['text' => 'Take their keys and arrange safe transportation', 'is_correct' => true],
                    ['text' => 'Go with them to keep them safe', 'is_correct' => false],
                    ['text' => 'Give them coffee to sober up', 'is_correct' => false],
                ]),
                'explanation' => 'Take their keys, call a ride service, or arrange other safe transportation. Never let an impaired person drive.',
                'points' => 10,
                'order' => 5,
            ],
        ];

        foreach ($safetyQuestions as $q) {
            $options = json_decode($q['options'], true);
            unset($q['options']);
            $question = QuizQuestion::create(array_merge($q, ['quiz_id' => $safetyQuiz->id]));
            
            foreach ($options as $index => $option) {
                \App\Models\QuizOption::create([
                    'question_id' => $question->id,
                    'option_text' => $option['text'],
                    'is_correct' => $option['is_correct'],
                    'order' => $index + 1,
                ]);
            }
        }

        $this->command->info('Created 4 quizzes with educational questions.');
    }
}