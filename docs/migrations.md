# 📘 Database Migrations Overview

This document outlines all database migrations used in the project.  
Each section corresponds to a migration file found in `/database/migrations/`.

---

## 🧑‍💻 2024_01_01_000001_add_additional_fields_to_users_table

**Adds fields to the `users` table.**

| Column | Type | Description |
|--------|------|--------------|
| `registration_number` | string, unique, nullable | Unique registration ID for students |
| `phone` | string, nullable | User phone number |
| `avatar` | string, nullable | Profile image path |
| `role` | enum(`student`, `counselor`, `admin`) | User role |
| `is_active` | boolean, default `true` | Active status |
| `last_login_at` | timestamp, nullable | Last login timestamp |

---

## 🏷️ 2024_01_01_000002_create_categories_table

**Creates the `categories` table.**

| Column | Type | Description |
|--------|------|-------------|
| `name` | string | Category name |
| `slug` | string, unique | URL-friendly name |
| `description` | text, nullable | Description |
| `icon` | string, nullable | Optional icon |
| `color` | string, default `#3B82F6` | Category color |
| `order` | integer, default `0` | Sort order |
| `is_active` | boolean, default `true` | Active status |

---

## 📚 2024_01_01_000003_create_educational_contents_table

**Stores educational materials (articles, videos, etc).**

- Relations:
  - `category_id` → `categories.id`
  - `created_by` → `users.id`

| Column | Type | Description |
|--------|------|-------------|
| `title` | string | Content title |
| `description` | text, nullable | Short description |
| `content` | longText | Main content body |
| `type` | enum(`article`, `video`, `infographic`, `document`) | Content format |
| `featured_image` | string, nullable | Cover image |
| `video_url` | string, nullable | Video link |
| `file_path` | string, nullable | Attachment |
| `views` | integer | View count |
| `reading_time` | integer, nullable | Estimated reading time (min) |
| `is_published` | boolean | Visibility flag |
| `published_at` | timestamp | Publish date |

---

## 👁️ 2024_01_01_000004_create_content_views_table

Tracks each user’s view of educational content.

| Column | Type | Description |
|--------|------|-------------|
| `content_id` | FK → educational_contents |
| `user_id` | FK → users, nullable |
| `ip_address` | string, nullable |
| `user_agent` | string, nullable |
| `viewed_at` | timestamp |

---

## 🧠 2024_01_01_000005_create_assessments_table

Defines available assessment tools (AUDIT, DUDIT, etc).

| Column | Type | Description |
|--------|------|-------------|
| `name` | string | Short code |
| `full_name` | string | Full name |
| `type` | enum(`audit`, `dudit`) | Type identifier |
| `scoring_guidelines` | JSON | Scoring thresholds |
| `is_active` | boolean | Enable/disable test |

---

## ❓ 2024_01_01_000006_create_assessment_questions_table

Holds all assessment questions.

| Column | Type | Description |
|--------|------|-------------|
| `assessment_id` | FK → assessments |
| `question` | text | The question text |
| `options` | JSON | Answers with scores |
| `order` | integer | Display order |

---

## 📝 2024_01_01_000007_create_assessment_attempts_table

Records a user’s completed assessment attempt.

| Column | Type | Description |
|--------|------|-------------|
| `user_id` | FK → users |
| `assessment_id` | FK → assessments |
| `total_score` | integer | Total points |
| `risk_level` | enum(`low`, `medium`, `high`) | Risk classification |
| `recommendation` | text, nullable | Feedback |
| `is_anonymous` | boolean | Whether identity hidden |
| `taken_at` | timestamp | Attempt date |

---

## 🧩 2024_01_01_000008_create_assessment_responses_table

Stores question-by-question responses for each assessment.

| Column | Type | Description |
|--------|------|-------------|
| `attempt_id` | FK → assessment_attempts |
| `question_id` | FK → assessment_questions |
| `selected_option_index` | int | Chosen option |
| `score` | int | Earned score |

---

## 🎯 2024_01_01_000009_create_quizzes_table

Defines quizzes tied to categories.

| Column | Type | Description |
|--------|------|-------------|
| `category_id` | FK → categories |
| `created_by` | FK → users |
| `title` | string | Quiz title |
| `duration_minutes` | int | Time limit |
| `passing_score` | int | Required score |
| `difficulty` | enum(`easy`, `medium`, `hard`) | Difficulty level |

---

## 🧾 2024_01_01_000010_create_quiz_questions_table

Quiz question definitions.

| Column | Type | Description |
|--------|------|-------------|
| `quiz_id` | FK → quizzes |
| `question` | text | Question text |
| `type` | enum(`multiple_choice`, `true_false`, `text`) | Question type |
| `explanation` | text, nullable | Answer rationale |
| `points` | int | Points per question |

---

## 🧠 2024_01_01_000011_create_quiz_options_table

Possible answers for quiz questions.

| Column | Type | Description |
|--------|------|-------------|
| `question_id` | FK → quiz_questions |
| `option_text` | string | Answer text |
| `is_correct` | boolean | Correctness flag |

---

## 🏁 2024_01_01_000012_create_quiz_attempts_table

Tracks user attempts and results.

| Column | Type | Description |
|--------|------|-------------|
| `user_id` | FK → users |
| `quiz_id` | FK → quizzes |
| `score` | decimal | Percentage |
| `passed` | boolean | Passed status |
| `started_at` | timestamp | Start time |
| `completed_at` | timestamp | End time |

---

## ✅ 2024_01_01_000013_create_quiz_answers_table

Stores user answers per attempt.

| Column | Type | Description |
|--------|------|-------------|
| `attempt_id` | FK → quiz_attempts |
| `question_id` | FK → quiz_questions |
| `option_id` | FK → quiz_options, nullable |
| `is_correct` | boolean | Answer correctness |

---

## 🗣️ 2024_01_01_000014_create_counseling_sessions_table

Manages counseling session records.

| Column | Type | Description |
|--------|------|-------------|
| `student_id` | FK → users |
| `counselor_id` | FK → users, nullable |
| `subject` | string | Session topic |
| `status` | enum | Session progress |
| `priority` | enum | Urgency level |
| `rating` | int | Feedback rating |

---

## 💬 2024_01_01_000015_create_counseling_messages_table

Chat messages within counseling sessions.

| Column | Type | Description |
|--------|------|-------------|
| `session_id` | FK → counseling_sessions |
| `sender_id` | FK → users |
| `message` | text | Message content |
| `attachment_path` | string, nullable | Optional file |

---

## 💭 2024_01_01_000016_create_forum_categories_table

Discussion forum categories.

| Column | Type | Description |
|--------|------|-------------|
| `name` | string | Category name |
| `slug` | string | URL identifier |
| `color` | string | Label color |

---

## 🧵 2024_01_01_000017_create_forum_posts_table

Forum discussion posts.

| Column | Type | Description |
|--------|------|-------------|
| `category_id` | FK → forum_categories |
| `user_id` | FK → users |
| `title` | string | Post title |
| `is_pinned` | boolean | Pin to top |

---

## 💭 2024_01_01_000018_create_forum_comments_table

Nested comments for posts.

| Column | Type | Description |
|--------|------|-------------|
| `post_id` | FK → forum_posts |
| `parent_id` | FK → forum_comments, nullable |
| `comment` | text | Comment body |

---

## 👍 2024_01_01_000019_create_forum_upvotes_table

Tracks post/comment upvotes.

| Column | Type | Description |
|--------|------|-------------|
| `user_id` | FK → users |
| `votable_type` | string | Target model |
| `votable_id` | int | Target ID |

---

## 🚨 2024_01_01_000020_create_incidents_table

Incident reporting table.

| Column | Type | Description |
|--------|------|-------------|
| `reported_by` | FK → users, nullable |
| `incident_type` | string | Type of case |
| `severity` | enum(`low`, `medium`, `high`, `critical`) | Risk level |
| `status` | enum | Resolution stage |

---

## 💌 2024_01_01_000021_create_feedback_table

User feedback and complaints.

| Column | Type | Description |
|--------|------|-------------|
| `user_id` | FK → users |
| `type` | enum | Feedback category |
| `subject` | string | Topic |
| `rating` | int | Optional rating |

---

## 📢 2024_01_01_000022_create_campaigns_table

Awareness campaigns and events.

| Column | Type | Description |
|--------|------|-------------|
| `created_by` | FK → users |
| `title` | string | Campaign name |
| `type` | enum | Category of campaign |
| `status` | enum | Lifecycle state |

---

## 🙋 2024_01_01_000023_create_campaign_participants_table

Links users to campaigns they join.

| Column | Type | Description |
|--------|------|-------------|
| `campaign_id` | FK → campaigns |
| `user_id` | FK → users |
| `status` | enum | Participation status |

---

## 🔔 2024_01_01_000024_create_notifications_table

System notifications for users.

| Column | Type | Description |
|--------|------|-------------|
| `user_id` | FK → users |
| `type` | string | Notification category |
| `is_read` | boolean | Read flag |

---

## 🧾 2024_01_01_000025_create_activity_logs_table

Tracks user activity across modules.

| Column | Type | Description |
|--------|------|-------------|
| `user_id` | FK → users |
| `action` | string | Performed action |
| `model_type` | string | Related model |
| `properties` | JSON | Extra metadata |

---

## 🔖 2024_01_01_000026_create_bookmarks_table

Allows users to save content.

| Column | Type | Description |
|--------|------|-------------|
| `user_id` | FK → users |
| `bookmarkable_type` | string | Related model type |
| `bookmarkable_id` | int | Model ID |

---

## ☎️ 2024_01_01_000027_create_emergency_contacts_table

Stores important helplines and contacts.

| Column | Type | Description |
|--------|------|-------------|
| `name` | string | Contact name |
| `organization` | string | Affiliation |
| `phone` | string | Phone number |
| `type` | enum | Contact type (`hotline`, `hospital`, etc.) |
| `is_24_7` | boolean | Availability |

---

# ✅ End of Migrations
