<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EducationalContent;
use App\Models\Category;
use App\Models\User;

class EducationalContentSeeder extends Seeder
{
    public function run(): void
    {
        // Educational content seeder has been cleared
        // No sample content will be created
        $this->command->info('Educational content seeder cleared - no sample content created.');
    }

    // Content generation methods
    private function getAlcoholEffectsContent(): string
    {
        return '<h2>Understanding Alcohol: Effects on Your Body and Mind</h2>

<p>Alcohol is one of the most commonly used substances among college students. Understanding its effects is crucial for making informed decisions about your health and academic success.</p>

<h3>How Alcohol Affects Your Brain</h3>
<p>When you drink alcohol, it quickly enters your bloodstream and reaches your brain within minutes:</p>
<ul>
<li><strong>Impaired judgment</strong> - Makes risky decisions seem reasonable</li>
<li><strong>Reduced coordination</strong> - Affects balance and motor skills</li>
<li><strong>Memory problems</strong> - Difficulty forming new memories (blackouts)</li>
<li><strong>Slowed reaction time</strong> - Dangerous for driving</li>
<li><strong>Mood changes</strong> - Can increase aggression or depression</li>
</ul>

<h3>Physical Health Impact</h3>
<p><strong>Immediate effects:</strong></p>
<ul>
<li>Dehydration and hangovers</li>
<li>Nausea and vomiting</li>
<li>Increased heart rate</li>
<li>Risk of alcohol poisoning</li>
</ul>

<p><strong>Long-term consequences:</strong></p>
<ul>
<li>Liver damage (fatty liver, cirrhosis)</li>
<li>Heart problems</li>
<li>Increased cancer risk</li>
<li>Weakened immune system</li>
</ul>

<h3>Academic Performance Impact</h3>
<p>Research shows that alcohol use significantly affects academic success:</p>
<ul>
<li>Lower GPA among heavy drinkers</li>
<li>Missed classes due to hangovers</li>
<li>Poor study habits and concentration</li>
<li>Disrupted sleep affecting memory</li>
</ul>

<h3>Making Informed Decisions</h3>
<p><strong>Standard drink sizes:</strong></p>
<ul>
<li>12 oz beer (5% alcohol)</li>
<li>5 oz wine (12% alcohol)</li>
<li>1.5 oz spirits (40% alcohol)</li>
</ul>

<p><strong>Safer drinking guidelines if you choose to drink:</strong></p>
<ul>
<li>Eat before and while drinking</li>
<li>Alternate with water</li>
<li>Know your limits</li>
<li>Never drink and drive</li>
<li>Have a trusted friend present</li>
</ul>

<h3>When to Seek Help</h3>
<p>Consider talking to a counselor if you experience:</p>
<ul>
<li>Drinking more than intended</li>
<li>Unable to cut down</li>
<li>Spending lots of time drinking or recovering</li>
<li>Neglecting responsibilities</li>
<li>Continuing despite problems</li>
</ul>

<p><em>If you\'re struggling with alcohol use, reach out to our counseling services. We\'re here to support you without judgment.</em></p>';
    }

    private function getBingeDrinkingContent(): string
    {
        return '<h2>Binge Drinking: Risks and Consequences</h2>

<p>Binge drinking is defined as consuming 4+ drinks for women or 5+ drinks for men within about 2 hours. It\'s a dangerous pattern that\'s common on college campuses.</p>

<h3>Why Binge Drinking is Dangerous</h3>
<ul>
<li><strong>Alcohol poisoning</strong> - Can be fatal</li>
<li><strong>Accidents and injuries</strong> - Falls, burns, drowning</li>
<li><strong>Risky behaviors</strong> - Unprotected sex, violence</li>
<li><strong>Blackouts</strong> - Memory loss of events</li>
<li><strong>Academic problems</strong> - Missed classes, poor performance</li>
</ul>

<h3>Signs of Alcohol Poisoning</h3>
<p>Call emergency services immediately if someone shows:</p>
<ul>
<li>Confusion or stupor</li>
<li>Vomiting</li>
<li>Seizures</li>
<li>Slow breathing (less than 8 breaths per minute)</li>
<li>Irregular breathing</li>
<li>Blue-tinged or pale skin</li>
<li>Low body temperature</li>
<li>Unconsciousness</li>
</ul>

<h3>Social Pressures</h3>
<p>Many students binge drink due to:</p>
<ul>
<li>Peer pressure to "keep up"</li>
<li>Drinking games</li>
<li>Social anxiety</li>
<li>Celebration culture</li>
<li>Stress relief</li>
</ul>

<h3>Alternatives to Binge Drinking</h3>
<ul>
<li>Set a drink limit before going out</li>
<li>Alternate alcoholic drinks with water</li>
<li>Eat before and during drinking</li>
<li>Choose activities that don\'t center on alcohol</li>
<li>Be the designated driver</li>
<li>Practice saying no</li>
</ul>

<p><em>Remember: You don\'t have to drink to have fun or fit in. True friends will respect your choices.</em></p>';
    }

    private function getAlcoholAcademicContent(): string
    {
        return '<h2>Alcohol and Academic Performance</h2>

<p>The relationship between alcohol use and academic success is clear: heavy drinking negatively impacts your grades and learning ability.</p>

<h3>How Alcohol Affects Learning</h3>
<ul>
<li><strong>Memory formation</strong> - Alcohol disrupts the process of creating long-term memories</li>
<li><strong>Concentration</strong> - Hangovers impair focus and attention</li>
<li><strong>Sleep quality</strong> - Disrupted sleep affects memory consolidation</li>
<li><strong>Motivation</strong> - Reduced drive to study and attend class</li>
</ul>

<h3>Academic Consequences</h3>
<p>Students who binge drink are more likely to:</p>
<ul>
<li>Miss classes (25% report missing class due to drinking)</li>
<li>Fall behind on assignments</li>
<li>Perform poorly on exams</li>
<li>Receive lower grades</li>
<li>Drop out of college</li>
</ul>

<h3>The GPA Connection</h3>
<p>Research shows:</p>
<ul>
<li>Students with A averages: 3.6 drinks per week</li>
<li>Students with B averages: 4.9 drinks per week</li>
<li>Students with C averages: 6.6 drinks per week</li>
<li>Students with D/F averages: 9.8 drinks per week</li>
</ul>

<h3>Breaking the Cycle</h3>
<p>If alcohol is affecting your academics:</p>
<ul>
<li>Track your drinking and its impact</li>
<li>Set specific academic goals</li>
<li>Find study groups that don\'t drink</li>
<li>Use campus tutoring services</li>
<li>Talk to academic advisors</li>
<li>Seek counseling support</li>
</ul>

<h3>Success Strategies</h3>
<ul>
<li>Schedule study time when you\'re most alert</li>
<li>Avoid drinking before important academic events</li>
<li>Find alcohol-free ways to socialize</li>
<li>Prioritize sleep over late-night drinking</li>
<li>Connect academic success to your future goals</li>
</ul>

<p><em>Your education is an investment in your future. Don\'t let alcohol diminish your potential.</em></p>';
    }

    private function getCommonDrugsContent(): string
    {
        return '<h2>Common Drugs on Campus: What You Need to Know</h2>

<p>Understanding different types of drugs and their effects helps you make informed decisions and recognize when someone needs help.</p>

<h3>Stimulants</h3>
<p><strong>Examples:</strong> Cocaine, methamphetamine, Adderall (when misused)</p>
<p><strong>Effects:</strong> Increased energy, alertness, confidence</p>
<p><strong>Risks:</strong></p>
<ul>
<li>Heart problems and stroke</li>
<li>Anxiety and paranoia</li>
<li>Sleep deprivation</li>
<li>High addiction potential</li>
<li>Academic performance actually decreases with regular use</li>
</ul>

<h3>Depressants</h3>
<p><strong>Examples:</strong> Benzodiazepines (Xanax, Valium), opioids</p>
<p><strong>Effects:</strong> Relaxation, reduced anxiety, pain relief</p>
<p><strong>Risks:</strong></p>
<ul>
<li>Respiratory depression</li>
<li>High overdose risk (especially with alcohol)</li>
<li>Physical dependence</li>
<li>Dangerous withdrawal</li>
</ul>

<h3>Cannabis</h3>
<p><strong>Effects:</strong> Relaxation, altered perception, increased appetite</p>
<p><strong>Risks:</strong></p>
<ul>
<li>Impaired memory and learning</li>
<li>Reduced motivation</li>
<li>Respiratory issues (when smoked)</li>
<li>Legal consequences in many areas</li>
<li>Potential for dependence</li>
</ul>

<h3>Hallucinogens</h3>
<p><strong>Examples:</strong> LSD, psilocybin mushrooms, MDMA</p>
<p><strong>Effects:</strong> Altered perception, hallucinations, euphoria</p>
<p><strong>Risks:</strong></p>
<ul>
<li>Unpredictable psychological effects</li>
<li>"Bad trips" can be traumatic</li>
<li>Risk of accidents</li>
<li>Potential to trigger mental health issues</li>
</ul>

<h3>Prescription Drug Misuse</h3>
<p>Commonly misused medications:</p>
<ul>
<li><strong>ADHD medications</strong> - Used for studying</li>
<li><strong>Anti-anxiety medications</strong> - Used for stress</li>
<li><strong>Pain medications</strong> - Used recreationally</li>
</ul>

<p><strong>Dangers:</strong></p>
<ul>
<li>Not prescribed for your specific condition</li>
<li>Unknown drug interactions</li>
<li>Risk of overdose</li>
<li>Legal consequences</li>
<li>Addiction potential</li>
</ul>

<h3>Warning Signs of Drug Use</h3>
<ul>
<li>Changes in academic performance</li>
<li>Altered sleep patterns</li>
<li>Mood swings</li>
<li>Changes in friend groups</li>
<li>Financial problems</li>
<li>Secretive behavior</li>
</ul>

<h3>Getting Help</h3>
<p>If you or someone you know is struggling:</p>
<ul>
<li>Campus counseling services</li>
<li>Student health center</li>
<li>Substance abuse counselors</li>
<li>Support groups</li>
<li>Crisis hotlines</li>
</ul>

<p><em>Remember: Experimenting with drugs might seem harmless, but the consequences can be life-altering.</em></p>';
    }

    private function getPrescriptionDrugContent(): string
    {
        return '<h2>Prescription Drug Misuse: A Hidden Danger</h2>

<p>Prescription drug misuse is using medication without a prescription, in a way other than prescribed, or for the experience or feeling it causes.</p>

<h3>Commonly Misused Medications</h3>

<p><strong>1. ADHD Medications (Adderall, Ritalin)</strong></p>
<ul>
<li>Often used by students to study or stay awake</li>
<li>Can cause anxiety, paranoia, and heart problems</li>
<li>Doesn\'t actually improve academic performance</li>
<li>High potential for dependence</li>
</ul>

<p><strong>2. Anti-Anxiety Medications (Xanax, Ativan)</strong></p>
<ul>
<li>Used to manage stress or enhance alcohol effects</li>
<li>Extremely dangerous when mixed with alcohol</li>
<li>Can cause memory problems and dependence</li>
<li>Withdrawal can be life-threatening</li>
</ul>

<p><strong>3. Pain Medications (OxyContin, Vicodin)</strong></p>
<ul>
<li>Used recreationally for euphoric effects</li>
<li>High risk of overdose and death</li>
<li>Extremely addictive</li>
<li>Gateway to heroin use</li>
</ul>

<h3>Why Prescription Drug Misuse is Dangerous</h3>
<ul>
<li><strong>Not prescribed for you</strong> - Dosage may be wrong for your body</li>
<li><strong>Unknown interactions</strong> - Can interact with other medications or conditions</li>
<li><strong>Addiction risk</strong> - Many prescription drugs are highly addictive</li>
<li><strong>Legal consequences</strong> - Possession without prescription is illegal</li>
<li><strong>Health risks</strong> - Can cause serious medical complications</li>
</ul>

<h3>The "Study Drug" Myth</h3>
<p>Many students believe ADHD medications help them study better, but research shows:</p>
<ul>
<li>No improvement in actual test scores</li>
<li>False sense of productivity</li>
<li>Disrupted sleep affects long-term learning</li>
<li>Side effects impair overall performance</li>
<li>Risk of dependence and addiction</li>
</ul>

<h3>Better Alternatives for Academic Success</h3>
<ul>
<li>Proper sleep (7-9 hours)</li>
<li>Regular exercise</li>
<li>Healthy diet</li>
<li>Time management skills</li>
<li>Study groups</li>
<li>Tutoring services</li>
<li>Academic counseling</li>
</ul>

<h3>Signs of Prescription Drug Misuse</h3>
<ul>
<li>Taking medication not prescribed to you</li>
<li>Taking more than prescribed</li>
<li>Using medication to get high</li>
<li>Doctor shopping for multiple prescriptions</li>
<li>Crushing or snorting pills</li>
<li>Mixing with alcohol or other drugs</li>
</ul>

<h3>Getting Help</h3>
<p>If you\'re misusing prescription drugs:</p>
<ul>
<li>Talk to a healthcare provider honestly</li>
<li>Contact campus counseling services</li>
<li>Join a support group</li>
<li>Consider treatment options</li>
<li>Don\'t quit suddenly (especially benzodiazepines)</li>
</ul>

<p><em>Just because a drug is prescribed doesn\'t mean it\'s safe for everyone. Misuse can have serious consequences.</em></p>';
    }

    private function getCannabisContent(): string
    {
        return '<h2>Cannabis: Facts vs. Myths</h2>

<p>With changing laws and attitudes toward marijuana, it\'s important to understand the facts about cannabis use and its effects on students.</p>

<h3>Common Myths Debunked</h3>

<p><strong>Myth: Marijuana is completely harmless</strong></p>
<p><strong>Fact:</strong> While less harmful than some substances, cannabis can still cause problems, especially for young adults whose brains are still developing.</p>

<p><strong>Myth: You can\'t become addicted to marijuana</strong></p>
<p><strong>Fact:</strong> About 9% of users become dependent, rising to 17% for those who start in adolescence.</p>

<p><strong>Myth: Marijuana improves academic performance</strong></p>
<p><strong>Fact:</strong> Regular use is associated with lower grades, reduced motivation, and impaired memory.</p>

<p><strong>Myth: It\'s legal everywhere now</strong></p>
<p><strong>Fact:</strong> Laws vary by location, and it remains illegal federally and in many states.</p>

<h3>Effects of Cannabis Use</h3>

<p><strong>Short-term effects:</strong></p>
<ul>
<li>Altered perception and mood</li>
<li>Impaired memory and concentration</li>
<li>Reduced coordination</li>
<li>Increased heart rate</li>
<li>Anxiety or paranoia (in some users)</li>
</ul>

<p><strong>Long-term effects:</strong></p>
<ul>
<li>Impaired brain development (especially under age 25)</li>
<li>Reduced cognitive function</li>
<li>Respiratory problems (when smoked)</li>
<li>Potential for dependence</li>
<li>Increased risk of mental health issues</li>
</ul>

<h3>Impact on Students</h3>

<p><strong>Academic consequences:</strong></p>
<ul>
<li>Difficulty concentrating in class</li>
<li>Impaired memory affecting learning</li>
<li>Reduced motivation ("amotivational syndrome")</li>
<li>Lower grades and test scores</li>
<li>Increased risk of dropping out</li>
</ul>

<p><strong>Social and legal consequences:</strong></p>
<ul>
<li>Campus disciplinary action</li>
<li>Loss of financial aid</li>
<li>Criminal charges in some areas</li>
<li>Impaired driving charges</li>
<li>Impact on future employment</li>
</ul>

<h3>Cannabis and Mental Health</h3>
<ul>
<li>Can trigger or worsen anxiety and depression</li>
<li>Linked to increased risk of psychosis in vulnerable individuals</li>
<li>May interfere with mental health treatment</li>
<li>Can mask underlying mental health issues</li>
</ul>

<h3>Making Informed Decisions</h3>

<p>If you choose to use cannabis:</p>
<ul>
<li>Understand your local laws</li>
<li>Never drive while impaired</li>
<li>Avoid use before important academic tasks</li>
<li>Be aware of potency (THC content)</li>
<li>Don\'t mix with alcohol or other drugs</li>
<li>Consider your personal and family mental health history</li>
</ul>

<h3>Alternatives for Stress Relief</h3>
<ul>
<li>Exercise and physical activity</li>
<li>Meditation and mindfulness</li>
<li>Social activities</li>
<li>Creative hobbies</li>
<li>Counseling and therapy</li>
<li>Relaxation techniques</li>
</ul>

<h3>When to Seek Help</h3>
<p>Consider talking to a counselor if:</p>
<ul>
<li>You use cannabis daily or almost daily</li>
<li>It\'s affecting your academics or relationships</li>
<li>You\'ve tried to cut back but can\'t</li>
<li>You experience anxiety or paranoia when using</li>
<li>You\'re using to cope with problems</li>
</ul>

<p><em>Whether legal or not, cannabis use carries risks. Make informed decisions based on facts, not myths.</em></p>';
    }

    private function getStressManagementContent(): string
    {
        return '<h2>Managing Stress Without Substances</h2>

<p>College brings unique stressors, but there are healthy ways to cope that don\'t involve alcohol or drugs.</p>

<h3>Understanding College Stress</h3>

<p><strong>Common stressors:</strong></p>
<ul>
<li>Academic pressure and deadlines</li>
<li>Financial concerns</li>
<li>Social challenges</li>
<li>Independence and responsibility</li>
<li>Future uncertainty</li>
<li>Time management</li>
</ul>

<h3>Why Substances Don\'t Help</h3>
<ul>
<li><strong>Temporary relief</strong> - Stress returns worse than before</li>
<li><strong>New problems</strong> - Creates additional stress</li>
<li><strong>Impaired coping</strong> - Prevents learning healthy strategies</li>
<li><strong>Tolerance</strong> - Need more for same effect</li>
<li><strong>Dependence</strong> - Creates cycle of stress and use</li>
</ul>

<h3>Healthy Stress Management Techniques</h3>

<p><strong>Immediate relief:</strong></p>
<ul>
<li><strong>Deep breathing</strong> - 4-7-8 technique (inhale 4, hold 7, exhale 8)</li>
<li><strong>Progressive muscle relaxation</strong> - Tense and release muscle groups</li>
<li><strong>Grounding</strong> - 5-4-3-2-1 sensory method</li>
<li><strong>Quick walk</strong> - Even 5 minutes helps</li>
<li><strong>Cold water</strong> - Splash on face or drink slowly</li>
</ul>

<p><strong>Physical strategies:</strong></p>
<ul>
<li>Regular exercise (30 minutes daily)</li>
<li>Yoga or stretching</li>
<li>Adequate sleep (7-9 hours)</li>
<li>Healthy nutrition</li>
<li>Limit caffeine</li>
</ul>

<p><strong>Mental strategies:</strong></p>
<ul>
<li>Mindfulness meditation</li>
<li>Journaling</li>
<li>Positive self-talk</li>
<li>Cognitive reframing</li>
<li>Time management</li>
</ul>

<p><strong>Social strategies:</strong></p>
<ul>
<li>Talk to friends or family</li>
<li>Join support groups</li>
<li>Seek counseling</li>
<li>Participate in activities you enjoy</li>
<li>Volunteer or help others</li>
</ul>

<h3>Building Resilience</h3>
<ul>
<li>Develop a growth mindset</li>
<li>Practice self-compassion</li>
<li>Set realistic goals</li>
<li>Maintain perspective</li>
<li>Learn from challenges</li>
<li>Build strong support network</li>
</ul>

<h3>Time Management for Stress Reduction</h3>
<ul>
<li>Use a planner or calendar</li>
<li>Break large tasks into smaller steps</li>
<li>Prioritize important tasks</li>
<li>Avoid procrastination</li>
<li>Schedule breaks and self-care</li>
<li>Learn to say no</li>
</ul>

<h3>When to Seek Professional Help</h3>
<p>Contact a counselor if you experience:</p>
<ul>
<li>Overwhelming anxiety or worry</li>
<li>Persistent sadness or hopelessness</li>
<li>Difficulty functioning in daily life</li>
<li>Thoughts of self-harm</li>
<li>Panic attacks</li>
<li>Inability to cope with stress</li>
</ul>

<h3>Campus Resources</h3>
<ul>
<li>Counseling center</li>
<li>Student health services</li>
<li>Academic support services</li>
<li>Peer support programs</li>
<li>Wellness programs</li>
<li>Crisis hotlines</li>
</ul>

<p><em>Learning healthy coping strategies now will benefit you throughout your life. You don\'t need substances to manage stress.</em></p>';
    }

    private function getDepressionAnxietyContent(): string
    {
        return '<h2>Recognizing Depression and Anxiety</h2>
<p>Mental health issues are common among college students. Recognizing symptoms early can lead to better outcomes.</p>
<h3>Depression Symptoms</h3>
<ul>
<li>Persistent sadness or empty mood</li>
<li>Loss of interest in activities</li>
<li>Changes in appetite or weight</li>
<li>Sleep problems (too much or too little)</li>
<li>Fatigue and low energy</li>
<li>Difficulty concentrating</li>
<li>Feelings of worthlessness or guilt</li>
<li>Thoughts of death or suicide</li>
</ul>
<h3>Anxiety Symptoms</h3>
<ul>
<li>Excessive worry</li>
<li>Restlessness or feeling on edge</li>
<li>Difficulty concentrating</li>
<li>Irritability</li>
<li>Muscle tension</li>
<li>Sleep disturbances</li>
<li>Panic attacks</li>
</ul>
<h3>Connection to Substance Use</h3>
<p>Many students use alcohol or drugs to self-medicate mental health symptoms, but this:</p>
<ul>
<li>Worsens symptoms over time</li>
<li>Interferes with treatment</li>
<li>Increases risk of addiction</li>
<li>Creates additional problems</li>
</ul>
<h3>Getting Help</h3>
<ul>
<li>Talk to a counselor or therapist</li>
<li>Consider medication if recommended</li>
<li>Practice self-care</li>
<li>Build support network</li>
<li>Join support groups</li>
</ul>
<p><em>Mental health conditions are treatable. Seeking help is a sign of strength.</em></p>';
    }

    private function getMindfulnessContent(): string
    {
        return '<h2>Mindfulness and Meditation for Students</h2>
<p>Mindfulness is the practice of being present in the moment without judgment. It\'s a powerful tool for managing stress and improving focus.</p>
<h3>Benefits of Mindfulness</h3>
<ul>
<li>Reduced stress and anxiety</li>
<li>Improved focus and concentration</li>
<li>Better emotional regulation</li>
<li>Enhanced self-awareness</li>
<li>Improved sleep quality</li>
<li>Better academic performance</li>
</ul>
<h3>Simple Mindfulness Practices</h3>
<p><strong>1. Mindful Breathing (5 minutes)</strong></p>
<ul>
<li>Sit comfortably</li>
<li>Focus on your breath</li>
<li>Notice when mind wanders</li>
<li>Gently return focus to breath</li>
</ul>
<p><strong>2. Body Scan (10 minutes)</strong></p>
<ul>
<li>Lie down comfortably</li>
<li>Focus attention on each body part</li>
<li>Notice sensations without judgment</li>
<li>Release tension as you go</li>
</ul>
<p><strong>3. Mindful Walking</strong></p>
<ul>
<li>Walk slowly and deliberately</li>
<li>Notice each step</li>
<li>Pay attention to surroundings</li>
<li>Stay present in the moment</li>
</ul>
<h3>Incorporating Mindfulness into Daily Life</h3>
<ul>
<li>Mindful eating (savor each bite)</li>
<li>Mindful listening (full attention to others)</li>
<li>Mindful studying (single-task focus)</li>
<li>Mindful breaks between classes</li>
</ul>
<h3>Apps and Resources</h3>
<ul>
<li>Headspace</li>
<li>Calm</li>
<li>Insight Timer</li>
<li>UCLA Mindful App</li>
<li>Campus meditation groups</li>
</ul>
<p><em>Start with just 5 minutes a day. Consistency matters more than duration.</em></p>';
    }

    private function getSleepHygieneContent(): string
    {
        return '<h2>Sleep Hygiene: The Foundation of Wellness</h2>
<p>Quality sleep is essential for academic success, mental health, and overall wellbeing.</p>
<h3>Why Sleep Matters</h3>
<ul>
<li>Memory consolidation and learning</li>
<li>Emotional regulation</li>
<li>Physical health and immunity</li>
<li>Decision-making ability</li>
<li>Stress management</li>
</ul>
<h3>Sleep Hygiene Tips</h3>
<p><strong>Consistent schedule:</strong></p>
<ul>
<li>Go to bed and wake up at same time daily</li>
<li>Even on weekends</li>
<li>Aim for 7-9 hours</li>
</ul>
<p><strong>Bedroom environment:</strong></p>
<ul>
<li>Dark, quiet, and cool</li>
<li>Comfortable mattress and pillows</li>
<li>Remove electronic devices</li>
<li>Use for sleep only (not studying)</li>
</ul>
<p><strong>Pre-sleep routine:</strong></p>
<ul>
<li>Wind down 30-60 minutes before bed</li>
<li>Avoid screens (blue light)</li>
<li>Read or listen to calm music</li>
<li>Practice relaxation techniques</li>
</ul>
<p><strong>Daytime habits:</strong></p>
<ul>
<li>Exercise regularly (but not before bed)</li>
<li>Limit caffeine after 2pm</li>
<li>Avoid alcohol (disrupts sleep quality)</li>
<li>Get natural sunlight exposure</li>
</ul>
<h3>Common Sleep Disruptors</h3>
<ul>
<li>Alcohol and drugs</li>
<li>Caffeine and energy drinks</li>
<li>Late-night studying</li>
<li>Irregular schedule</li>
<li>Stress and anxiety</li>
<li>Screen time before bed</li>
</ul>
<p><em>Prioritizing sleep is one of the best things you can do for your academic success and mental health.</em></p>';
    }

    private function getNutritionContent(): string
    {
        return '<h2>Nutrition for Brain Health</h2>
<p>What you eat directly affects your brain function, mood, and academic performance.</p>
<h3>Brain-Boosting Foods</h3>
<ul>
<li><strong>Omega-3 fatty acids</strong> - Fish, walnuts, flaxseeds</li>
<li><strong>Antioxidants</strong> - Berries, dark chocolate, green tea</li>
<li><strong>Whole grains</strong> - Oats, brown rice, quinoa</li>
<li><strong>Lean proteins</strong> - Chicken, fish, beans, eggs</li>
<li><strong>Leafy greens</strong> - Spinach, kale, broccoli</li>
<li><strong>Nuts and seeds</strong> - Almonds, pumpkin seeds</li>
</ul>
<h3>Foods to Limit</h3>
<ul>
<li>Processed foods and fast food</li>
<li>Sugary snacks and drinks</li>
<li>Excessive caffeine</li>
<li>Trans fats</li>
<li>Alcohol</li>
</ul>
<h3>Eating for Academic Success</h3>
<p><strong>Breakfast:</strong> Never skip it - fuels your brain for morning classes</p>
<p><strong>Regular meals:</strong> Eat every 3-4 hours to maintain energy</p>
<p><strong>Hydration:</strong> Drink 8 glasses of water daily</p>
<p><strong>Study snacks:</strong> Nuts, fruit, yogurt, whole grain crackers</p>
<h3>Meal Planning on a Budget</h3>
<ul>
<li>Buy in bulk</li>
<li>Cook in batches</li>
<li>Use campus meal plans wisely</li>
<li>Shop seasonal produce</li>
<li>Limit eating out</li>
</ul>
<p><em>Good nutrition supports your brain, mood, and academic performance. Invest in your health.</em></p>';
    }

    private function getExerciseContent(): string
    {
        return '<h2>Exercise and Mental Health</h2>
<p>Physical activity is one of the most effective ways to improve mental health and reduce stress.</p>
<h3>Mental Health Benefits</h3>
<ul>
<li>Reduces anxiety and depression</li>
<li>Improves mood and self-esteem</li>
<li>Enhances cognitive function</li>
<li>Better sleep quality</li>
<li>Stress relief</li>
<li>Increased energy</li>
</ul>
<h3>How Much Exercise?</h3>
<ul>
<li>Aim for 150 minutes moderate activity per week</li>
<li>Or 75 minutes vigorous activity</li>
<li>Even 10-minute sessions help</li>
<li>Any movement is better than none</li>
</ul>
<h3>Types of Exercise</h3>
<p><strong>Aerobic:</strong> Running, cycling, swimming, dancing</p>
<p><strong>Strength:</strong> Weight lifting, bodyweight exercises</p>
<p><strong>Flexibility:</strong> Yoga, stretching, Pilates</p>
<p><strong>Mind-body:</strong> Tai chi, yoga, qigong</p>
<h3>Getting Started</h3>
<ul>
<li>Start small and build gradually</li>
<li>Choose activities you enjoy</li>
<li>Exercise with friends</li>
<li>Use campus recreation facilities</li>
<li>Join intramural sports or clubs</li>
<li>Walk or bike to class</li>
</ul>
<h3>Exercise vs. Substances</h3>
<p>Exercise provides natural mood boost without the risks of substances:</p>
<ul>
<li>Releases endorphins (natural high)</li>
<li>No negative side effects</li>
<li>Improves rather than impairs function</li>
<li>Builds long-term health</li>
<li>Enhances rather than disrupts sleep</li>
</ul>
<p><em>Movement is medicine for the mind. Make it part of your daily routine.</em></p>';
    }

    private function getAssertivenessContent(): string
    {
        return '<h2>Saying No: Assertiveness Skills for Students</h2>
<p>Learning to say no confidently is essential for resisting peer pressure and making your own choices.</p>
<h3>What is Assertiveness?</h3>
<p>Assertiveness is expressing your thoughts, feelings, and needs respectfully while respecting others.</p>
<h3>Assertive vs. Passive vs. Aggressive</h3>
<p><strong>Passive:</strong> "I guess I\'ll have a drink..." (giving in)</p>
<p><strong>Aggressive:</strong> "No way! That\'s stupid!" (attacking)</p>
<p><strong>Assertive:</strong> "No thanks, I\'m good." (confident and respectful)</p>
<h3>Ways to Say No</h3>
<ul>
<li>"No thanks, I\'m not drinking tonight."</li>
<li>"I\'m good, but thanks for offering."</li>
<li>"I have an early class tomorrow."</li>
<li>"I\'m the designated driver."</li>
<li>"I don\'t feel like it."</li>
<li>"That\'s not my thing."</li>
</ul>
<h3>Assertiveness Techniques</h3>
<p><strong>Broken record:</strong> Calmly repeat your refusal</p>
<p><strong>Fogging:</strong> Agree with part but maintain your position</p>
<p><strong>Compromise:</strong> Suggest alternative activity</p>
<p><strong>Change subject:</strong> Redirect conversation</p>
<h3>Handling Pressure</h3>
<p>If someone persists:</p>
<ul>
<li>Stay calm and confident</li>
<li>Don\'t feel need to explain</li>
<li>Use humor if appropriate</li>
<li>Leave the situation if needed</li>
<li>Surround yourself with supportive friends</li>
</ul>
<h3>Building Confidence</h3>
<ul>
<li>Practice saying no in low-stakes situations</li>
<li>Know your values and boundaries</li>
<li>Remember your goals</li>
<li>Find supportive friends</li>
<li>Remind yourself it\'s your choice</li>
</ul>
<p><em>True friends respect your decisions. You don\'t owe anyone an explanation for taking care of yourself.</em></p>';
    }

    private function getHealthyFriendshipsContent(): string
    {
        return '<h2>Building Healthy Friendships</h2>
<p>Quality friendships are essential for wellbeing and don\'t require alcohol or drugs to maintain.</p>
<h3>Characteristics of Healthy Friendships</h3>
<ul>
<li>Mutual respect and trust</li>
<li>Support during difficult times</li>
<li>Honest communication</li>
<li>Shared interests and values</li>
<li>Respect for boundaries</li>
<li>Positive influence</li>
</ul>
<h3>Red Flags in Friendships</h3>
<ul>
<li>Pressure to use substances</li>
<li>Disrespect for your choices</li>
<li>One-sided relationships</li>
<li>Negative influence on academics</li>
<li>Lack of support</li>
<li>Manipulation or control</li>
</ul>
<h3>Making New Friends</h3>
<ul>
<li>Join clubs and organizations</li>
<li>Attend campus events</li>
<li>Study groups</li>
<li>Volunteer activities</li>
<li>Intramural sports</li>
<li>Residence hall activities</li>
</ul>
<h3>Substance-Free Socializing</h3>
<ul>
<li>Coffee or meal dates</li>
<li>Movie or game nights</li>
<li>Outdoor activities</li>
<li>Sports and recreation</li>
<li>Cultural events</li>
<li>Study sessions</li>
<li>Volunteer together</li>
</ul>
<h3>Maintaining Friendships</h3>
<ul>
<li>Regular communication</li>
<li>Make time for each other</li>
<li>Be reliable and trustworthy</li>
<li>Show appreciation</li>
<li>Support their goals</li>
<li>Resolve conflicts respectfully</li>
</ul>
<p><em>Quality friendships enrich your life. Choose friends who support your wellbeing and goals.</em></p>';
    }

    private function getAddictionRecoveryContent(): string
    {
        return '<h2>Understanding Addiction and Recovery</h2>
<p>Addiction is a chronic medical condition that affects the brain. Recovery is possible with proper support and treatment.</p>
<h3>What is Addiction?</h3>
<p>Addiction is characterized by:</p>
<ul>
<li>Compulsive substance use</li>
<li>Loss of control</li>
<li>Continued use despite consequences</li>
<li>Physical and psychological dependence</li>
</ul>
<h3>The Recovery Process</h3>
<p><strong>1. Acknowledgment:</strong> Recognizing the problem</p>
<p><strong>2. Detoxification:</strong> Safely stopping substance use</p>
<p><strong>3. Treatment:</strong> Therapy and support</p>
<p><strong>4. Maintenance:</strong> Ongoing recovery work</p>
<p><strong>5. Growth:</strong> Building new life in recovery</p>
<h3>Treatment Options</h3>
<ul>
<li>Individual therapy</li>
<li>Group therapy</li>
<li>Family therapy</li>
<li>Medication-assisted treatment</li>
<li>Residential treatment</li>
<li>Outpatient programs</li>
<li>Support groups (AA, NA, SMART Recovery)</li>
</ul>
<h3>Recovery Tools</h3>
<ul>
<li>Develop coping skills</li>
<li>Build support network</li>
<li>Identify and avoid triggers</li>
<li>Practice self-care</li>
<li>Set goals and work toward them</li>
<li>Celebrate milestones</li>
</ul>
<h3>Relapse Prevention</h3>
<ul>
<li>Recognize warning signs</li>
<li>Have a relapse prevention plan</li>
<li>Stay connected to support</li>
<li>Manage stress healthily</li>
<li>Avoid high-risk situations</li>
<li>Continue therapy and meetings</li>
</ul>
<p><em>Recovery is a journey, not a destination. With support and commitment, lasting recovery is possible.</em></p>';
    }

    private function getSupportingFriendsContent(): string
    {
        return '<h2>Supporting a Friend in Recovery</h2>
<p>If someone you care about is struggling with substance use, your support can make a difference.</p>
<h3>How to Help</h3>
<ul>
<li>Express concern without judgment</li>
<li>Listen without trying to fix</li>
<li>Encourage professional help</li>
<li>Offer to help find resources</li>
<li>Be patient and supportive</li>
<li>Set healthy boundaries</li>
</ul>
<h3>What to Say</h3>
<ul>
<li>"I\'m worried about you."</li>
<li>"I\'m here for you."</li>
<li>"How can I support you?"</li>
<li>"Have you thought about talking to someone?"</li>
<li>"I care about you and want to help."</li>
</ul>
<h3>What Not to Say</h3>
<ul>
<li>"Just stop using."</li>
<li>"You\'re being selfish."</li>
<li>"I told you so."</li>
<li>"You\'re weak."</li>
<li>"It\'s not that bad."</li>
</ul>
<h3>Avoiding Enabling</h3>
<p>Don\'t:</p>
<ul>
<li>Make excuses for them</li>
<li>Give them money</li>
<li>Cover up consequences</li>
<li>Use substances with them</li>
<li>Ignore the problem</li>
</ul>
<h3>Taking Care of Yourself</h3>
<ul>
<li>Set boundaries</li>
<li>Seek your own support</li>
<li>Don\'t take responsibility for their recovery</li>
<li>Practice self-care</li>
<li>Know when to involve professionals</li>
</ul>
<h3>When to Get Help</h3>
<p>Contact authorities or emergency services if:</p>
<ul>
<li>Immediate danger to self or others</li>
<li>Overdose or medical emergency</li>
<li>Suicidal thoughts or plans</li>
<li>Violent behavior</li>
</ul>
<p><em>You can\'t force someone to get help, but you can offer support and resources. Take care of yourself too.</em></p>';
    }

    private function getCampusResourcesContent(): string
    {
        return '<h2>Campus Resources and Where to Get Help</h2>
<p>Your campus offers many resources to support your wellbeing. Don\'t hesitate to use them.</p>
<h3>Counseling Services</h3>
<ul>
<li>Individual therapy</li>
<li>Group counseling</li>
<li>Crisis intervention</li>
<li>Substance abuse counseling</li>
<li>Workshops and programs</li>
</ul>
<h3>Student Health Center</h3>
<ul>
<li>Medical care</li>
<li>Mental health services</li>
<li>Health education</li>
<li>Referrals to specialists</li>
</ul>
<h3>Academic Support</h3>
<ul>
<li>Tutoring services</li>
<li>Writing center</li>
<li>Academic advising</li>
<li>Study skills workshops</li>
<li>Disability services</li>
</ul>
<h3>Peer Support</h3>
<ul>
<li>Support groups</li>
<li>Peer mentoring</li>
<li>Recovery programs</li>
<li>Student organizations</li>
</ul>
<h3>Crisis Resources</h3>
<ul>
<li>Campus security</li>
<li>Crisis hotlines</li>
<li>Emergency services</li>
<li>24/7 support lines</li>
</ul>
<h3>Off-Campus Resources</h3>
<ul>
<li>Community mental health centers</li>
<li>Substance abuse treatment facilities</li>
<li>Support groups (AA, NA, SMART Recovery)</li>
<li>Crisis centers</li>
<li>Hospitals</li>
</ul>
<h3>How to Access Help</h3>
<ul>
<li>Walk-in during office hours</li>
<li>Call to schedule appointment</li>
<li>Use online portals</li>
<li>Ask RA or advisor for referral</li>
<li>Call crisis line anytime</li>
</ul>
<h3>Confidentiality</h3>
<p>Most campus services are confidential. Your privacy is protected except in cases of:</p>
<ul>
<li>Danger to self or others</li>
<li>Child abuse</li>
<li>Court orders</li>
</ul>
<p><em>Seeking help is a sign of strength. These resources exist to support your success and wellbeing.</em></p>';
    }
}
