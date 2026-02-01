# Entity Relationship Diagram - WellPath Mental Health Platform

## Overview
This document describes the Entity Relationship Diagram (ERD) for the WellPath Mental Health Platform database design, showing entities, attributes, relationships, and constraints.

## Entities and Attributes

### 1. Users
**Description**: Core entity representing all system users (students, counselors, administrators)

#### Attributes:
- **id** (Primary Key, Auto-increment)
- **name** (VARCHAR(255), NOT NULL) - Full name
- **email** (VARCHAR(255), UNIQUE, NOT NULL) - Email address
- **email_verified_at** (TIMESTAMP, NULLABLE) - Email verification timestamp
- **password** (VARCHAR(255), NOT NULL) - Encrypted password
- **role** (ENUM: 'user', 'counselor', 'admin', DEFAULT 'user') - User role
- **registration_number** (VARCHAR(50), UNIQUE, NULLABLE) - Student/staff ID
- **phone** (VARCHAR(20), NULLABLE) - Phone number
- **whatsapp_number** (VARCHAR(20), NULLABLE) - WhatsApp contact
- **counselor_email** (VARCHAR(255), NULLABLE) - Professional email for counselors
- **office_address** (TEXT, NULLABLE) - Office location for counselors
- **office_phone** (VARCHAR(20), NULLABLE) - Office phone for counselors
- **availability_hours** (JSON, NULLABLE) - Counselor availability schedule
- **custom_contact_info** (JSON, NULLABLE) - Additional contact methods
- **default_meeting_links** (JSON, NULLABLE) - Preferred meeting platforms
- **avatar** (VARCHAR(255), NULLABLE) - Profile picture path
- **is_active** (BOOLEAN, DEFAULT TRUE) - Account status
- **last_login_at** (TIMESTAMP, NULLABLE) - Last login timestamp
- **remember_token** (VARCHAR(100), NULLABLE) - Remember me token
- **current_team_id** (BIGINT, NULLABLE) - Team association
- **profile_photo_path** (VARCHAR(2048), NULLABLE) - Profile photo path
- **created_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
- **updated_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP ON UPDATE)

### 2. Categories
**Description**: Content categorization for educational materials

#### Attributes:
- **id** (Primary Key, Auto-increment)
- **name** (VARCHAR(255), NOT NULL) - Category name
- **description** (TEXT, NULLABLE) - Category description
- **image** (VARCHAR(255), NULLABLE) - Category image path
- **is_active** (BOOLEAN, DEFAULT TRUE) - Category status
- **created_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
- **updated_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP ON UPDATE)

### 3. Educational_Content
**Description**: Mental health educational resources and materials

#### Attributes:
- **id** (Primary Key, Auto-increment)
- **title** (VARCHAR(255), NOT NULL) - Content title
- **content** (LONGTEXT, NOT NULL) - Main content body
- **excerpt** (TEXT, NULLABLE) - Content summary
- **category_id** (Foreign Key → Categories.id) - Content category
- **created_by** (Foreign Key → Users.id) - Content author
- **is_published** (BOOLEAN, DEFAULT FALSE) - Publication status
- **is_featured** (BOOLEAN, DEFAULT FALSE) - Featured content flag
- **views** (INTEGER, DEFAULT 0) - View count
- **meta_description** (TEXT, NULLABLE) - SEO description
- **tags** (JSON, NULLABLE) - Content tags
- **reading_time** (INTEGER, NULLABLE) - Estimated reading time
- **difficulty_level** (ENUM: 'beginner', 'intermediate', 'advanced', NULLABLE)
- **target_audience** (JSON, NULLABLE) - Intended audience
- **published_at** (TIMESTAMP, NULLABLE) - Publication timestamp
- **created_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
- **updated_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP ON UPDATE)

### 4. Assessments
**Description**: Mental health assessment templates and configurations

#### Attributes:
- **id** (Primary Key, Auto-increment)
- **title** (VARCHAR(255), NOT NULL) - Assessment name
- **description** (TEXT, NULLABLE) - Assessment description
- **type** (ENUM: 'depression', 'anxiety', 'stress', 'substance_abuse', 'general') - Assessment type
- **questions** (JSON, NOT NULL) - Assessment questions and options
- **scoring_criteria** (JSON, NOT NULL) - Scoring methodology
- **risk_thresholds** (JSON, NOT NULL) - Risk level boundaries
- **instructions** (TEXT, NULLABLE) - User instructions
- **estimated_duration** (INTEGER, NULLABLE) - Expected completion time
- **is_active** (BOOLEAN, DEFAULT TRUE) - Assessment availability
- **requires_followup** (BOOLEAN, DEFAULT FALSE) - Follow-up requirement
- **created_by** (Foreign Key → Users.id) - Assessment creator
- **created_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
- **updated_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP ON UPDATE)

### 5. Assessment_Attempts
**Description**: User assessment completion records

#### Attributes:
- **id** (Primary Key, Auto-increment)
- **user_id** (Foreign Key → Users.id) - User taking assessment
- **assessment_id** (Foreign Key → Assessments.id) - Assessment taken
- **responses** (JSON, NOT NULL) - User responses to questions
- **score** (INTEGER, NOT NULL) - Calculated score
- **risk_level** (ENUM: 'low', 'medium', 'high', 'critical') - Risk assessment
- **recommendations** (JSON, NULLABLE) - Generated recommendations
- **completion_time** (INTEGER, NULLABLE) - Time taken to complete
- **is_completed** (BOOLEAN, DEFAULT FALSE) - Completion status
- **counselor_notified** (BOOLEAN, DEFAULT FALSE) - Counselor notification status
- **follow_up_required** (BOOLEAN, DEFAULT FALSE) - Follow-up flag
- **notes** (TEXT, NULLABLE) - Additional notes
- **created_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
- **updated_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP ON UPDATE)

### 6. Counseling_Sessions
**Description**: Counseling session records and management

#### Attributes:
- **id** (Primary Key, Auto-increment)
- **student_id** (Foreign Key → Users.id) - Primary student/client
- **counselor_id** (Foreign Key → Users.id, NULLABLE) - Assigned counselor
- **preferred_counselor_id** (Foreign Key → Users.id, NULLABLE) - Requested counselor
- **session_type** (ENUM: 'individual', 'group') - Session format
- **status** (ENUM: 'pending', 'active', 'completed', 'cancelled') - Session status
- **priority** (ENUM: 'low', 'medium', 'high', 'urgent') - Session priority
- **preferred_method** (ENUM: 'google_meet', 'zoom', 'phone_call') - Communication method
- **meeting_link** (VARCHAR(500), NULLABLE) - Session meeting link
- **scheduled_at** (TIMESTAMP, NULLABLE) - Scheduled session time
- **started_at** (TIMESTAMP, NULLABLE) - Actual start time
- **ended_at** (TIMESTAMP, NULLABLE) - Actual end time
- **completed_at** (TIMESTAMP, NULLABLE) - Completion timestamp
- **duration** (INTEGER, NULLABLE) - Session duration in minutes
- **reason** (TEXT, NULLABLE) - Reason for counseling request
- **notes** (TEXT, NULLABLE) - Session notes
- **rating** (INTEGER, NULLABLE) - Session rating (1-5)
- **feedback** (TEXT, NULLABLE) - Session feedback
- **follow_up_required** (BOOLEAN, DEFAULT FALSE) - Follow-up needed
- **follow_up_date** (DATE, NULLABLE) - Scheduled follow-up date
- **follow_up_notes** (TEXT, NULLABLE) - Follow-up instructions
- **created_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
- **updated_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP ON UPDATE)

### 7. Session_Participants
**Description**: Group session participant management

#### Attributes:
- **id** (Primary Key, Auto-increment)
- **counseling_session_id** (Foreign Key → Counseling_Sessions.id) - Session reference
- **email** (VARCHAR(255), NOT NULL) - Participant email
- **name** (VARCHAR(255), NULLABLE) - Participant name
- **status** (ENUM: 'invited', 'joined', 'declined', 'left') - Participation status
- **invited_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP) - Invitation timestamp
- **joined_at** (TIMESTAMP, NULLABLE) - Join timestamp
- **left_at** (TIMESTAMP, NULLABLE) - Leave timestamp
- **notes** (TEXT, NULLABLE) - Participant notes
- **created_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
- **updated_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP ON UPDATE)

### 8. Session_Notes
**Description**: Detailed counselor notes for sessions

#### Attributes:
- **id** (Primary Key, Auto-increment)
- **counseling_session_id** (Foreign Key → Counseling_Sessions.id) - Session reference
- **counselor_id** (Foreign Key → Users.id) - Note author
- **notes** (LONGTEXT, NOT NULL) - Detailed session notes
- **observations** (TEXT, NULLABLE) - Counselor observations
- **recommendations** (TEXT, NULLABLE) - Treatment recommendations
- **follow_up_required** (BOOLEAN, DEFAULT FALSE) - Follow-up needed
- **follow_up_date** (DATE, NULLABLE) - Recommended follow-up date
- **risk_assessment** (ENUM: 'low', 'medium', 'high', 'critical', NULLABLE) - Risk level
- **intervention_type** (VARCHAR(100), NULLABLE) - Type of intervention
- **progress_rating** (INTEGER, NULLABLE) - Progress rating (1-10)
- **is_confidential** (BOOLEAN, DEFAULT TRUE) - Confidentiality flag
- **created_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
- **updated_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP ON UPDATE)

### 9. Campaigns
**Description**: Mental health awareness campaigns

#### Attributes:
- **id** (Primary Key, Auto-increment)
- **title** (VARCHAR(255), NOT NULL) - Campaign title
- **description** (TEXT, NULLABLE) - Campaign description
- **content** (LONGTEXT, NULLABLE) - Campaign content
- **target_audience** (JSON, NULLABLE) - Target demographics
- **start_date** (DATE, NULLABLE) - Campaign start date
- **end_date** (DATE, NULLABLE) - Campaign end date
- **is_active** (BOOLEAN, DEFAULT TRUE) - Campaign status
- **is_featured** (BOOLEAN, DEFAULT FALSE) - Featured campaign
- **image** (VARCHAR(255), NULLABLE) - Campaign image
- **contact_email** (VARCHAR(255), NULLABLE) - Contact email
- **contact_phone** (VARCHAR(20), NULLABLE) - Contact phone
- **contact_whatsapp** (VARCHAR(20), NULLABLE) - WhatsApp contact
- **contact_address** (TEXT, NULLABLE) - Physical address
- **created_by** (Foreign Key → Users.id) - Campaign creator
- **created_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
- **updated_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP ON UPDATE)

### 10. Campaign_Participants
**Description**: Campaign participation tracking

#### Attributes:
- **id** (Primary Key, Auto-increment)
- **campaign_id** (Foreign Key → Campaigns.id) - Campaign reference
- **user_id** (Foreign Key → Users.id, NULLABLE) - Registered user
- **guest_name** (VARCHAR(255), NULLABLE) - Guest participant name
- **guest_email** (VARCHAR(255), NULLABLE) - Guest participant email
- **guest_phone** (VARCHAR(20), NULLABLE) - Guest participant phone
- **participation_type** (ENUM: 'registered', 'guest') - Participant type
- **status** (ENUM: 'registered', 'attended', 'cancelled') - Participation status
- **registration_date** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
- **notes** (TEXT, NULLABLE) - Participation notes
- **created_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
- **updated_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP ON UPDATE)

### 11. Campaign_Contacts
**Description**: Campaign contact information management

#### Attributes:
- **id** (Primary Key, Auto-increment)
- **campaign_id** (Foreign Key → Campaigns.id) - Campaign reference
- **contact_type** (ENUM: 'email', 'phone', 'whatsapp', 'address') - Contact method
- **contact_value** (VARCHAR(255), NOT NULL) - Contact information
- **is_primary** (BOOLEAN, DEFAULT FALSE) - Primary contact flag
- **is_active** (BOOLEAN, DEFAULT TRUE) - Contact status
- **created_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
- **updated_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP ON UPDATE)

### 12. Forum_Categories
**Description**: Discussion forum category organization

#### Attributes:
- **id** (Primary Key, Auto-increment)
- **name** (VARCHAR(255), NOT NULL) - Category name
- **description** (TEXT, NULLABLE) - Category description
- **color** (VARCHAR(7), DEFAULT '#3B82F6') - Category color code
- **icon** (VARCHAR(50), DEFAULT 'chat') - Category icon
- **is_active** (BOOLEAN, DEFAULT TRUE) - Category status
- **sort_order** (INTEGER, DEFAULT 0) - Display order
- **created_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
- **updated_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP ON UPDATE)

### 13. Forum_Posts
**Description**: Community forum discussion posts

#### Attributes:
- **id** (Primary Key, Auto-increment)
- **user_id** (Foreign Key → Users.id) - Post author
- **category_id** (Foreign Key → Forum_Categories.id) - Post category
- **title** (VARCHAR(255), NOT NULL) - Post title
- **content** (LONGTEXT, NOT NULL) - Post content
- **is_anonymous** (BOOLEAN, DEFAULT FALSE) - Anonymous posting
- **is_pinned** (BOOLEAN, DEFAULT FALSE) - Pinned post flag
- **is_locked** (BOOLEAN, DEFAULT FALSE) - Locked post flag
- **views** (INTEGER, DEFAULT 0) - View count
- **upvotes** (INTEGER, DEFAULT 0) - Upvote count
- **created_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
- **updated_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP ON UPDATE)

### 14. Forum_Comments
**Description**: Replies to forum posts

#### Attributes:
- **id** (Primary Key, Auto-increment)
- **post_id** (Foreign Key → Forum_Posts.id) - Parent post
- **user_id** (Foreign Key → Users.id) - Comment author
- **content** (TEXT, NOT NULL) - Comment content
- **is_anonymous** (BOOLEAN, DEFAULT FALSE) - Anonymous comment
- **upvotes** (INTEGER, DEFAULT 0) - Upvote count
- **created_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
- **updated_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP ON UPDATE)

### 15. Content_Reviews
**Description**: User reviews and ratings for educational content

#### Attributes:
- **id** (Primary Key, Auto-increment)
- **content_id** (Foreign Key → Educational_Content.id) - Reviewed content
- **user_id** (Foreign Key → Users.id) - Reviewer
- **rating** (INTEGER, NOT NULL) - Rating (1-5)
- **review** (TEXT, NULLABLE) - Review text
- **is_helpful** (BOOLEAN, NULLABLE) - Helpfulness indicator
- **is_approved** (BOOLEAN, DEFAULT TRUE) - Review approval status
- **created_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
- **updated_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP ON UPDATE)

### 16. Notifications
**Description**: System notifications and alerts

#### Attributes:
- **id** (Primary Key, Auto-increment)
- **user_id** (Foreign Key → Users.id) - Notification recipient
- **type** (VARCHAR(100), NOT NULL) - Notification type
- **title** (VARCHAR(255), NOT NULL) - Notification title
- **message** (TEXT, NOT NULL) - Notification message
- **data** (JSON, NULLABLE) - Additional notification data
- **is_read** (BOOLEAN, DEFAULT FALSE) - Read status
- **priority** (ENUM: 'low', 'medium', 'high', 'urgent', DEFAULT 'medium') - Priority level
- **expires_at** (TIMESTAMP, NULLABLE) - Expiration timestamp
- **action_url** (VARCHAR(500), NULLABLE) - Action link
- **created_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
- **updated_at** (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP ON UPDATE)

## Relationships

### One-to-Many Relationships

#### Users → Educational_Content
- **Relationship**: One user can create many educational content items
- **Foreign Key**: Educational_Content.created_by → Users.id
- **Cardinality**: 1:N

#### Users → Assessment_Attempts
- **Relationship**: One user can have many assessment attempts
- **Foreign Key**: Assessment_Attempts.user_id → Users.id
- **Cardinality**: 1:N

#### Users → Counseling_Sessions (as Student)
- **Relationship**: One user can have many counseling sessions as a student
- **Foreign Key**: Counseling_Sessions.student_id → Users.id
- **Cardinality**: 1:N

#### Users → Counseling_Sessions (as Counselor)
- **Relationship**: One counselor can conduct many counseling sessions
- **Foreign Key**: Counseling_Sessions.counselor_id → Users.id
- **Cardinality**: 1:N

#### Categories → Educational_Content
- **Relationship**: One category can contain many educational content items
- **Foreign Key**: Educational_Content.category_id → Categories.id
- **Cardinality**: 1:N

#### Assessments → Assessment_Attempts
- **Relationship**: One assessment can have many attempts
- **Foreign Key**: Assessment_Attempts.assessment_id → Assessments.id
- **Cardinality**: 1:N

#### Counseling_Sessions → Session_Participants
- **Relationship**: One session can have many participants
- **Foreign Key**: Session_Participants.counseling_session_id → Counseling_Sessions.id
- **Cardinality**: 1:N

#### Counseling_Sessions → Session_Notes
- **Relationship**: One session can have many notes
- **Foreign Key**: Session_Notes.counseling_session_id → Counseling_Sessions.id
- **Cardinality**: 1:N

#### Campaigns → Campaign_Participants
- **Relationship**: One campaign can have many participants
- **Foreign Key**: Campaign_Participants.campaign_id → Campaigns.id
- **Cardinality**: 1:N

#### Forum_Categories → Forum_Posts
- **Relationship**: One category can contain many posts
- **Foreign Key**: Forum_Posts.category_id → Forum_Categories.id
- **Cardinality**: 1:N

#### Forum_Posts → Forum_Comments
- **Relationship**: One post can have many comments
- **Foreign Key**: Forum_Comments.post_id → Forum_Posts.id
- **Cardinality**: 1:N

### Many-to-Many Relationships

#### Users ↔ Campaigns (through Campaign_Participants)
- **Relationship**: Users can participate in multiple campaigns, campaigns can have multiple users
- **Junction Table**: Campaign_Participants
- **Cardinality**: M:N

## Constraints and Business Rules

### Primary Key Constraints
- All entities have auto-incrementing primary keys
- Primary keys are unique and not null

### Foreign Key Constraints
- All foreign keys reference valid primary keys
- Cascade delete rules applied where appropriate
- Referential integrity maintained

### Unique Constraints
- Users.email must be unique
- Users.registration_number must be unique (when not null)
- Category names must be unique

### Check Constraints
- Assessment scores must be non-negative
- Session ratings must be between 1 and 5
- Content ratings must be between 1 and 5
- Risk levels must be valid enum values

### Business Rules
1. **User Role Validation**: Only users with 'counselor' role can be assigned as counselors
2. **Assessment Completion**: Assessment attempts must have valid responses and calculated scores
3. **Session Scheduling**: Sessions cannot be scheduled in the past
4. **Content Publishing**: Only published content is visible to regular users
5. **Crisis Handling**: High-risk assessments automatically trigger notifications
6. **Session Capacity**: Group sessions have participant limits
7. **Data Retention**: Session notes are retained for compliance periods
8. **Privacy Protection**: Personal health information is encrypted and access-controlled

## Indexes

### Primary Indexes
- All primary keys have clustered indexes

### Secondary Indexes
- Users.email (unique index)
- Users.role (non-unique index)
- Assessment_Attempts.user_id (non-unique index)
- Counseling_Sessions.student_id (non-unique index)
- Counseling_Sessions.counselor_id (non-unique index)
- Educational_Content.category_id (non-unique index)
- Forum_Posts.category_id (non-unique index)
- Notifications.user_id (non-unique index)

### Composite Indexes
- (Assessment_Attempts.user_id, Assessment_Attempts.created_at)
- (Counseling_Sessions.counselor_id, Counseling_Sessions.scheduled_at)
- (Educational_Content.is_published, Educational_Content.created_at)
- (Notifications.user_id, Notifications.is_read)