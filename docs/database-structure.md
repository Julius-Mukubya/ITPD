# WellPath Database Structure - Tables and Relationships

## Overview
This document provides a comprehensive overview of the WellPath Mental Health Platform database structure, including all tables, their columns, and relationships.

## Core Tables

### 1. users
**Purpose**: Central user management for all system users (students, counselors, administrators)

**Key Columns**:
- `id` (Primary Key)
- `name` - Full name
- `email` - Unique email address
- `password` - Encrypted password
- `role` - ENUM('user', 'counselor', 'admin')
- `registration_number` - Student/staff ID
- `phone`, `whatsapp_number` - Contact information
- `counselor_email`, `office_address`, `office_phone` - Counselor-specific fields
- `availability_hours` - JSON field for counselor availability
- `custom_contact_info` - JSON field for additional contact methods
- `default_meeting_links` - JSON field for preferred meeting platforms
- `avatar` - Profile picture path
- `is_active` - Account status
- `last_login_at` - Last login timestamp

**Relationships**:
- One-to-Many: educational_contents (as creator)
- One-to-Many: counseling_sessions (as student)
- One-to-Many: counseling_sessions (as counselor)
- One-to-Many: assessment_attempts
- One-to-Many: campaigns (as creator)
- One-to-Many: forum_posts
- One-to-Many: notifications

---

### 2. counseling_sessions
**Purpose**: Manages counseling sessions between students and counselors

**Key Columns**:
- `id` (Primary Key)
- `student_id` (Foreign Key → users.id)
- `counselor_id` (Foreign Key → users.id)
- `preferred_counselor_id` (Foreign Key → users.id)
- `parent_session_id` (Foreign Key → counseling_sessions.id) - For follow-up sessions
- `subject` - Session topic
- `description` - Detailed description
- `status` - ENUM('pending', 'active', 'completed', 'cancelled')
- `priority` - ENUM('low', 'medium', 'high', 'urgent')
- `session_type` - ENUM('individual', 'group')
- `preferred_method` - ENUM('google_meet', 'zoom', 'phone_call')
- `meeting_link` - Session meeting URL
- `is_anonymous` - Anonymous session flag
- `scheduled_at`, `started_at`, `completed_at` - Timing fields
- `rating` - Session rating (1-5)
- `feedback` - Session feedback

**Relationships**:
- Many-to-One: users (student)
- Many-to-One: users (counselor)
- Many-to-One: users (preferred_counselor)
- One-to-Many: session_participants (for group sessions)
- One-to-Many: session_notes
- One-to-Many: counseling_messages
- One-to-Many: counseling_sessions (follow-up sessions)

---

### 3. session_participants
**Purpose**: Manages participants in group counseling sessions

**Key Columns**:
- `id` (Primary Key)
- `counseling_session_id` (Foreign Key → counseling_sessions.id)
- `name` - Participant name
- `email` - Participant email
- `status` - ENUM('invited', 'joined', 'declined', 'left')
- `invitation_token` - Unique invitation token
- `invited_at`, `joined_at`, `left_at` - Timing fields

**Relationships**:
- Many-to-One: counseling_sessions

---

### 4. session_notes
**Purpose**: Counselor notes for counseling sessions

**Key Columns**:
- `id` (Primary Key)
- `session_id` (Foreign Key → counseling_sessions.id)
- `counselor_id` (Foreign Key → users.id)
- `title` - Note title
- `content` - Note content
- `type` - Note type/category
- `is_private` - Privacy flag

**Relationships**:
- Many-to-One: counseling_sessions
- Many-to-One: users (counselor)

---

### 5. assessments
**Purpose**: Mental health assessment templates

**Key Columns**:
- `id` (Primary Key)
- `name` - Short name (e.g., "AUDIT")
- `full_name` - Full assessment name
- `description` - Assessment description
- `type` - ENUM('audit', 'dudit', 'phq9', 'gad7', 'dass21', 'pss', 'cage')
- `scoring_guidelines` - JSON field with scoring criteria
- `is_active` - Assessment availability

**Relationships**:
- One-to-Many: assessment_questions
- One-to-Many: assessment_attempts

---

### 6. assessment_questions
**Purpose**: Questions for each assessment

**Key Columns**:
- `id` (Primary Key)
- `assessment_id` (Foreign Key → assessments.id)
- `question_text` - Question content
- `question_type` - Question format
- `options` - JSON field with answer options
- `order` - Question order
- `is_required` - Required flag

**Relationships**:
- Many-to-One: assessments
- One-to-Many: assessment_responses

---

### 7. assessment_attempts
**Purpose**: User attempts at taking assessments

**Key Columns**:
- `id` (Primary Key)
- `user_id` (Foreign Key → users.id)
- `assessment_id` (Foreign Key → assessments.id)
- `total_score` - Calculated total score
- `risk_level` - ENUM('low', 'medium', 'high', 'critical')
- `interpretation` - Risk interpretation text
- `completed_at` - Completion timestamp
- `is_completed` - Completion status

**Relationships**:
- Many-to-One: users
- Many-to-One: assessments
- One-to-Many: assessment_responses

---

### 8. assessment_responses
**Purpose**: Individual question responses in assessment attempts

**Key Columns**:
- `id` (Primary Key)
- `attempt_id` (Foreign Key → assessment_attempts.id)
- `question_id` (Foreign Key → assessment_questions.id)
- `response_value` - User's answer
- `score` - Points for this response

**Relationships**:
- Many-to-One: assessment_attempts
- Many-to-One: assessment_questions

---

### 9. categories
**Purpose**: Content categorization system

**Key Columns**:
- `id` (Primary Key)
- `name` - Category name
- `description` - Category description
- `image` - Category image path
- `is_active` - Category status

**Relationships**:
- One-to-Many: educational_contents

---

### 10. educational_contents
**Purpose**: Educational resources and articles

**Key Columns**:
- `id` (Primary Key)
- `category_id` (Foreign Key → categories.id)
- `created_by` (Foreign Key → users.id)
- `title` - Content title
- `description` - Content summary
- `content` - Main content body
- `type` - Content type (article, video, etc.)
- `featured_image` - Image path
- `video_url` - Video URL
- `file_path` - File attachment path
- `views` - View count
- `reading_time` - Estimated reading time
- `is_published` - Publication status
- `is_featured` - Featured content flag
- `published_at` - Publication timestamp

**Relationships**:
- Many-to-One: categories
- Many-to-One: users (creator)
- One-to-Many: content_reviews
- One-to-Many: content_views
- One-to-Many: bookmarks

---

### 11. content_reviews
**Purpose**: User reviews and ratings for educational content

**Key Columns**:
- `id` (Primary Key)
- `user_id` (Foreign Key → users.id)
- `educational_content_id` (Foreign Key → educational_contents.id)
- `rating` - Rating (1-5 stars)
- `review` - Review text
- `is_helpful` - Helpfulness flag
- `feedback_data` - JSON field for additional feedback
- `is_approved` - Approval status
- `approved_at` - Approval timestamp
- `approved_by` (Foreign Key → users.id)

**Relationships**:
- Many-to-One: users (reviewer)
- Many-to-One: educational_contents
- Many-to-One: users (approver)

---

### 12. campaigns
**Purpose**: Mental health awareness campaigns and events

**Key Columns**:
- `id` (Primary Key)
- `created_by` (Foreign Key → users.id)
- `title` - Campaign title
- `description` - Campaign description
- `content` - Campaign content
- `banner_image` - Banner image path
- `type` - Campaign type
- `start_date`, `start_time` - Start date/time
- `end_date`, `end_time` - End date/time
- `location` - Campaign location
- `max_participants` - Participant limit
- `contact_email`, `contact_phone` - Contact information
- `status` - ENUM('draft', 'active', 'completed', 'cancelled')
- `is_featured` - Featured campaign flag

**Relationships**:
- Many-to-One: users (creator)
- One-to-Many: campaign_participants
- One-to-Many: campaign_contacts

---

### 13. campaign_participants
**Purpose**: Campaign participation tracking

**Key Columns**:
- `id` (Primary Key)
- `campaign_id` (Foreign Key → campaigns.id)
- `user_id` (Foreign Key → users.id) - For registered users
- `guest_name`, `guest_email`, `guest_phone` - For guest registrations
- `is_guest_registration` - Guest registration flag
- `status` - ENUM('registered', 'attended', 'cancelled')
- `registration_date` - Registration timestamp

**Relationships**:
- Many-to-One: campaigns
- Many-to-One: users (optional, for registered users)

---

### 14. campaign_contacts
**Purpose**: Campaign contact information management

**Key Columns**:
- `id` (Primary Key)
- `campaign_id` (Foreign Key → campaigns.id)
- `name` - Contact person name
- `title` - Contact person title
- `email` - Contact email
- `phone` - Contact phone
- `office_location` - Office location
- `office_hours` - Office hours
- `is_primary` - Primary contact flag
- `sort_order` - Display order

**Relationships**:
- Many-to-One: campaigns

---

### 15. forum_categories
**Purpose**: Discussion forum category organization

**Key Columns**:
- `id` (Primary Key)
- `name` - Category name
- `description` - Category description
- `color` - Category color code
- `icon` - Category icon
- `is_active` - Category status
- `sort_order` - Display order

**Relationships**:
- One-to-Many: forum_posts

---

### 16. forum_posts
**Purpose**: Community forum discussion posts

**Key Columns**:
- `id` (Primary Key)
- `user_id` (Foreign Key → users.id)
- `category_id` (Foreign Key → forum_categories.id)
- `title` - Post title
- `content` - Post content
- `is_anonymous` - Anonymous posting flag
- `is_pinned` - Pinned post flag
- `is_locked` - Locked post flag
- `views` - View count
- `upvotes` - Upvote count

**Relationships**:
- Many-to-One: users
- Many-to-One: forum_categories
- One-to-Many: forum_comments
- One-to-Many: forum_upvotes

---

### 17. forum_comments
**Purpose**: Replies to forum posts

**Key Columns**:
- `id` (Primary Key)
- `post_id` (Foreign Key → forum_posts.id)
- `user_id` (Foreign Key → users.id)
- `content` - Comment content
- `is_anonymous` - Anonymous comment flag
- `upvotes` - Upvote count

**Relationships**:
- Many-to-One: forum_posts
- Many-to-One: users
- One-to-Many: forum_upvotes

---

### 18. notifications
**Purpose**: System notifications and alerts

**Key Columns**:
- `id` (Primary Key)
- `user_id` (Foreign Key → users.id)
- `type` - Notification type
- `title` - Notification title
- `message` - Notification message
- `data` - JSON field for additional data
- `is_read` - Read status
- `priority` - ENUM('low', 'medium', 'high', 'urgent')
- `expires_at` - Expiration timestamp
- `action_url` - Action link

**Relationships**:
- Many-to-One: users

---

## Supporting Tables

### 19. quizzes
**Purpose**: Educational quizzes and knowledge tests

**Key Columns**:
- `id` (Primary Key)
- `created_by` (Foreign Key → users.id)
- `title` - Quiz title
- `description` - Quiz description
- `is_active` - Quiz availability
- `time_limit` - Time limit in minutes
- `passing_score` - Minimum passing score

**Relationships**:
- Many-to-One: users (creator)
- One-to-Many: quiz_questions
- One-to-Many: quiz_attempts

---

### 20. counseling_messages
**Purpose**: Messages within counseling sessions

**Key Columns**:
- `id` (Primary Key)
- `session_id` (Foreign Key → counseling_sessions.id)
- `sender_id` (Foreign Key → users.id)
- `message` - Message content
- `attachment_path` - File attachment path
- `is_read` - Read status
- `read_at` - Read timestamp

**Relationships**:
- Many-to-One: counseling_sessions
- Many-to-One: users (sender)

---

### 21. bookmarks
**Purpose**: User bookmarks for content

**Key Columns**:
- `id` (Primary Key)
- `user_id` (Foreign Key → users.id)
- `bookmarkable_type` - Polymorphic type
- `bookmarkable_id` - Polymorphic ID

**Relationships**:
- Many-to-One: users
- Polymorphic: bookmarkable (educational_contents, etc.)

---

### 22. content_views
**Purpose**: Content view tracking

**Key Columns**:
- `id` (Primary Key)
- `user_id` (Foreign Key → users.id)
- `content_id` (Foreign Key → educational_contents.id)
- `viewed_at` - View timestamp
- `duration` - View duration

**Relationships**:
- Many-to-One: users
- Many-to-One: educational_contents

---

### 23. emergency_contacts
**Purpose**: Emergency contact information

**Key Columns**:
- `id` (Primary Key)
- `name` - Contact name
- `phone` - Contact phone
- `email` - Contact email
- `organization` - Organization name
- `type` - Contact type
- `is_active` - Contact status

---

### 24. activity_logs
**Purpose**: System activity logging

**Key Columns**:
- `id` (Primary Key)
- `user_id` (Foreign Key → users.id)
- `action` - Action performed
- `description` - Action description
- `ip_address` - User IP address
- `user_agent` - User agent string

**Relationships**:
- Many-to-One: users

---

## Key Relationships Summary

### User-Centric Relationships
- **Users** are central to the system with relationships to:
  - Counseling sessions (as both student and counselor)
  - Assessment attempts
  - Educational content creation
  - Forum participation
  - Campaign creation and participation
  - Notifications and activity logs

### Content Management
- **Categories** organize educational content
- **Educational Content** can have multiple reviews and views
- **Content Reviews** provide user feedback and ratings

### Counseling System
- **Counseling Sessions** connect students with counselors
- **Session Participants** enable group sessions
- **Session Notes** provide counselor documentation
- **Counseling Messages** enable session communication

### Assessment System
- **Assessments** contain multiple questions
- **Assessment Attempts** track user completions
- **Assessment Responses** store individual answers

### Community Features
- **Forum Categories** organize discussions
- **Forum Posts** and **Forum Comments** enable community interaction
- **Forum Upvotes** provide engagement metrics

### Campaign Management
- **Campaigns** can have multiple participants and contacts
- **Campaign Participants** track registrations (both users and guests)
- **Campaign Contacts** provide contact information

## Database Constraints and Indexes

### Foreign Key Constraints
- All foreign keys maintain referential integrity
- Cascade deletes where appropriate (e.g., user deletion cascades to their content)
- Set null for optional relationships (e.g., counselor assignment)

### Unique Constraints
- User emails must be unique
- Assessment types must be unique
- Registration numbers must be unique (when provided)

### Indexes
- Primary keys (clustered indexes)
- Foreign keys (non-clustered indexes)
- Frequently queried fields (status, dates, etc.)
- Composite indexes for common query patterns

This database structure supports a comprehensive mental health platform with user management, counseling services, educational content, community features, and administrative capabilities.