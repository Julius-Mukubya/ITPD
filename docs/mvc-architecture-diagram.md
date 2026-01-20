# MVC Architecture Diagram - Student Drug and Alcohol Awareness Platform

## System Overview
A Laravel-based platform for student mental health support, counseling services, educational content, and community engagement.

---

## MVC Architecture Layers

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                              USER INTERFACE LAYER                            │
│                                   (VIEWS)                                    │
└─────────────────────────────────────────────────────────────────────────────┘
                                      │
                                      ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│                            ROUTING & MIDDLEWARE                              │
│                              (routes/web.php)                                │
└─────────────────────────────────────────────────────────────────────────────┘
                                      │
                                      ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│                            CONTROLLER LAYER                                  │
│                          (Business Logic Handler)                            │
└─────────────────────────────────────────────────────────────────────────────┘
                                      │
                                      ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│                              MODEL LAYER                                     │
│                        (Data & Business Logic)                               │
└─────────────────────────────────────────────────────────────────────────────┘
                                      │
                                      ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│                              DATABASE LAYER                                  │
│                          (MySQL/PostgreSQL)                                  │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## Detailed Component Breakdown

### 1. MODEL LAYER (app/Models/)

#### Core User Management
```
User (Authenticatable)
├── Attributes: name, email, password, role, registration_number, phone, avatar
├── Roles: admin, counselor, student
└── Relationships:
    ├── hasMany: contents, quizzes, quizAttempts, assessmentAttempts
    ├── hasMany: counselingSessions, forumPosts, forumComments
    ├── hasMany: incidents, feedback, campaigns, notifications
    └── hasMany: bookmarks, contentViews, upvotes

Role
└── Manages user permissions and access control
```

#### Educational Content Module
```
Category
├── Attributes: name, slug, description, icon
└── hasMany: EducationalContent, Quiz

EducationalContent
├── Attributes: title, slug, content, type, category_id, created_by
├── Attributes: is_published, is_featured, views, reading_time
├── belongsTo: Category, User (author)
└── hasMany: ContentView, Bookmark

ContentView
├── Attributes: user_id, content_id, duration
└── Tracks user engagement with content

Bookmark
├── Attributes: user_id, content_id
└── User saved content for later
```

#### Quiz & Assessment Module
```
Quiz
├── Attributes: title, description, category_id, difficulty, time_limit
├── Attributes: passing_score, is_active, created_by
├── belongsTo: Category, User (creator)
└── hasMany: QuizQuestion, QuizAttempt

QuizQuestion
├── Attributes: quiz_id, question_text, question_type, points
├── belongsTo: Quiz
└── hasMany: QuizOption

QuizOption
├── Attributes: question_id, option_text, is_correct
└── belongsTo: QuizQuestion

QuizAttempt
├── Attributes: user_id, quiz_id, score, passed, time_spent
├── Attributes: started_at, completed_at, status
├── belongsTo: User, Quiz
└── hasMany: QuizAnswer

QuizAnswer
├── Attributes: attempt_id, question_id, selected_option_id, is_correct
└── belongsTo: QuizAttempt, QuizQuestion, QuizOption

AssessmentAttempt
├── Attributes: user_id, assessment_type, score, results (JSON)
└── Mental health self-assessment tracking

AssessmentResponse
├── Attributes: attempt_id, question, answer, score
└── Individual assessment question responses
```

#### Counseling Module
```
CounselingSession
├── Attributes: student_id, counselor_id, session_type, priority
├── Attributes: status (pending/active/completed/cancelled)
├── Attributes: scheduled_at, completed_at, rating, notes
├── belongsTo: User (student), User (counselor)
└── hasMany: CounselingMessage

CounselingMessage
├── Attributes: session_id, sender_id, message, is_read
├── belongsTo: CounselingSession, User (sender)
└── Real-time messaging between student and counselor
```

#### Forum & Community Module
```
ForumCategory
├── Attributes: name, slug, description, icon, is_active
└── hasMany: ForumPost

ForumPost
├── Attributes: user_id, category_id, title, content
├── Attributes: is_pinned, is_locked, views
├── belongsTo: User, ForumCategory
├── hasMany: ForumComment, ForumUpvote
└── Community discussion threads

ForumComment
├── Attributes: post_id, user_id, content, parent_id
├── belongsTo: ForumPost, User
└── Supports nested comments (replies)

ForumUpvote
├── Attributes: user_id, post_id, comment_id
└── User engagement tracking
```

#### Incident & Safety Module
```
Incident
├── Attributes: reported_by, assigned_to, incident_type, severity
├── Attributes: description, status, priority, resolution_notes
├── belongsTo: User (reporter), User (assigned counselor/admin)
└── Tracks bullying, safety concerns, emergencies

EmergencyContact
├── Attributes: user_id, name, relationship, phone, email
└── Emergency contact information for students
```

#### Campaign & Engagement Module
```
Campaign
├── Attributes: title, description, type, start_date, end_date
├── Attributes: target_audience, created_by, is_active
├── belongsTo: User (creator)
└── hasMany: CampaignParticipant

CampaignParticipant
├── Attributes: campaign_id, user_id, participated_at
└── Tracks user participation in awareness campaigns
```

#### System & Notifications Module
```
Notification
├── Attributes: user_id, type, title, message, data (JSON)
├── Attributes: is_read, read_at
└── belongsTo: User

ActivityLog
├── Attributes: user_id, action, model_type, model_id, details
└── System audit trail

Feedback
├── Attributes: user_id, type, subject, message, status
└── User feedback and suggestions
```

---

### 2. CONTROLLER LAYER (app/Http/Controllers/)

#### Authentication & Profile
```
ProfileController
├── show() - Display user profile
├── edit() - Edit profile form
├── update() - Update profile data
└── updateAvatar() - Upload profile picture
```

#### Dashboard Controllers
```
DashboardController
├── index() - Route to role-specific dashboard
├── getStudentData() - Student metrics & progress
├── getCounselorData() - Counselor session stats
└── getAdminData() - System-wide analytics

Methods provide:
- User statistics & engagement metrics
- Performance trends & charts data
- Recent activity & notifications
- Role-specific KPIs
```

#### Admin Controllers (app/Http/Controllers/Admin/)
```
Admin\UserController
├── index() - List all users
├── create() - New user form
├── store() - Create user
├── edit() - Edit user form
├── update() - Update user
├── destroy() - Delete user
└── toggleStatus() - Activate/deactivate user

Admin\ContentController
├── index() - List educational content
├── create() - New content form
├── store() - Create content
├── edit() - Edit content
├── update() - Update content
├── destroy() - Delete content
└── togglePublish() - Publish/unpublish content

Admin\QuizController
├── index() - List quizzes
├── create() - New quiz form
├── store() - Create quiz with questions
├── edit() - Edit quiz
├── update() - Update quiz
├── destroy() - Delete quiz
└── manageQuestions() - CRUD for quiz questions

Admin\IncidentController
├── index() - List incidents
├── show() - View incident details
├── assign() - Assign to counselor
├── updateStatus() - Update incident status
└── resolve() - Mark as resolved

Admin\CampaignController
├── index() - List campaigns
├── create() - New campaign form
├── store() - Create campaign
├── edit() - Edit campaign
├── update() - Update campaign
└── destroy() - Delete campaign

Admin\ReportController
├── index() - Reports dashboard
├── userReport() - User analytics
├── contentReport() - Content performance
├── quizReport() - Quiz statistics
├── counselingReport() - Counseling metrics
└── exportReport() - Export to PDF/Excel
```

#### Student Controllers (app/Http/Controllers/Student/)
```
Student\QuizController
├── index() - Available quizzes
├── show() - Quiz details
├── start() - Start quiz attempt
├── submit() - Submit quiz answers
├── results() - View quiz results
└── history() - Quiz attempt history

Student\AssessmentController
├── index() - Available assessments
├── show() - Assessment form
├── submit() - Submit assessment
└── results() - View assessment results

Student\CounselingController
├── index() - My counseling sessions
├── create() - Request new session
├── store() - Create session request
├── show() - View session details
├── sendMessage() - Send message to counselor
└── rate() - Rate completed session

Student\ForumController
├── index() - Forum categories
├── category() - Posts in category
├── show() - View post & comments
├── create() - New post form
├── store() - Create post
├── comment() - Add comment
├── upvote() - Upvote post/comment
└── search() - Search forum
```

#### Counselor Controllers (app/Http/Controllers/Counselor/)
```
Counselor\SessionController
├── index() - My sessions
├── pending() - Pending requests
├── accept() - Accept session request
├── show() - Session details
├── sendMessage() - Send message to student
├── addNotes() - Add session notes
├── complete() - Mark session complete
└── cancel() - Cancel session
```

#### Shared Controllers
```
NotificationController
├── index() - List notifications
├── markAsRead() - Mark notification read
├── markAllAsRead() - Mark all read
└── destroy() - Delete notification

CampaignController
├── index() - View campaigns
├── show() - Campaign details
└── participate() - Join campaign
```

---

### 3. VIEW LAYER (resources/views/)

#### Layout Templates
```
layouts/
├── app.blade.php - Main application layout
├── admin.blade.php - Admin dashboard layout
├── counselor.blade.php - Counselor dashboard layout
├── student.blade.php - Student dashboard layout
└── guest.blade.php - Public/authentication layout
```

#### Dashboard Views
```
dashboard.blade.php - Generic dashboard
admin/
├── dashboard.blade.php - Admin overview
├── users/
│   ├── index.blade.php - User list
│   ├── create.blade.php - Create user
│   └── edit.blade.php - Edit user
├── content/
│   ├── index.blade.php - Content list
│   ├── create.blade.php - Create content
│   └── edit.blade.php - Edit content
├── quizzes/
│   ├── index.blade.php - Quiz list
│   ├── create.blade.php - Create quiz
│   └── questions.blade.php - Manage questions
├── incidents/
│   ├── index.blade.php - Incident list
│   └── show.blade.php - Incident details
├── campaigns/
│   ├── index.blade.php - Campaign list
│   └── create.blade.php - Create campaign
└── reports/
    └── index.blade.php - Analytics dashboard

counselor/
├── dashboard.blade.php - Counselor overview
├── sessions/
│   ├── index.blade.php - My sessions
│   ├── pending.blade.php - Pending requests
│   └── show.blade.php - Session details
└── messages/
    └── index.blade.php - Message inbox

student/
├── dashboard.blade.php - Student overview
├── content/
│   ├── index.blade.php - Browse content
│   └── show.blade.php - View content
├── quizzes/
│   ├── index.blade.php - Available quizzes
│   ├── show.blade.php - Quiz details
│   ├── take.blade.php - Take quiz
│   └── results.blade.php - Quiz results
├── assessments/
│   ├── index.blade.php - Assessments
│   └── take.blade.php - Take assessment
├── counseling/
│   ├── index.blade.php - My sessions
│   ├── request.blade.php - Request session
│   └── show.blade.php - Session chat
└── forum/
    ├── index.blade.php - Forum categories
    ├── category.blade.php - Category posts
    ├── show.blade.php - View post
    └── create.blade.php - Create post
```

#### Shared Views
```
content/
├── index.blade.php - Browse content
└── show.blade.php - View content

profile/
├── show.blade.php - View profile
└── edit.blade.php - Edit profile

notifications/
└── index.blade.php - Notification list

campaigns/
├── index.blade.php - Campaign list
└── show.blade.php - Campaign details

home.blade.php - Landing page
```

---

## Data Flow Diagram

```
┌──────────┐
│  Browser │
└────┬─────┘
     │ HTTP Request
     ▼
┌─────────────────┐
│  Routes Layer   │ ← Middleware (Auth, Role Check)
└────┬────────────┘
     │
     ▼
┌─────────────────┐
│   Controller    │ ← Validates Request
└────┬────────────┘
     │
     ├─────────────────────┐
     │                     │
     ▼                     ▼
┌─────────┐         ┌──────────┐
│  Model  │ ←──────→│ Database │
└────┬────┘         └──────────┘
     │
     │ Returns Data
     ▼
┌─────────────────┐
│   Controller    │ ← Processes Data
└────┬────────────┘
     │
     ▼
┌─────────────────┐
│   View (Blade)  │ ← Renders HTML
└────┬────────────┘
     │
     ▼
┌──────────┐
│  Browser │ ← HTTP Response
└──────────┘
```

---

## Key Relationships & Interactions

### Student Workflow
```
Student Login
    ↓
Dashboard (metrics, progress, notifications)
    ↓
├─→ Browse Educational Content → View Content → Bookmark
├─→ Take Quizzes → Submit Answers → View Results
├─→ Take Assessments → Get Recommendations
├─→ Request Counseling → Chat with Counselor → Rate Session
└─→ Forum Participation → Create Posts → Comment → Upvote
```

### Counselor Workflow
```
Counselor Login
    ↓
Dashboard (sessions, pending requests, stats)
    ↓
├─→ View Pending Requests → Accept Session
├─→ Active Sessions → Chat with Student → Add Notes
├─→ Complete Session → Student Rates
└─→ View Incidents → Provide Support
```

### Admin Workflow
```
Admin Login
    ↓
Dashboard (system analytics, user stats)
    ↓
├─→ Manage Users → Create/Edit/Deactivate
├─→ Manage Content → Create/Publish/Feature
├─→ Manage Quizzes → Create/Edit Questions
├─→ Manage Incidents → Assign/Resolve
├─→ Manage Campaigns → Create/Monitor
└─→ View Reports → Export Analytics
```

---

## Technology Stack

### Backend (MVC Core)
- **Framework**: Laravel 8.x
- **Authentication**: Laravel Jetstream + Fortify
- **API**: Laravel Sanctum
- **Real-time**: Livewire 2.x
- **PDF Generation**: DomPDF
- **Image Processing**: Intervention Image

### Frontend (View Layer)
- **Template Engine**: Blade
- **CSS Framework**: Tailwind CSS
- **JavaScript**: Alpine.js (via Livewire)
- **Build Tool**: Vite / Webpack Mix

### Database (Model Layer)
- **ORM**: Eloquent
- **Migrations**: Laravel Migrations
- **Seeders**: Database Seeders & Factories
- **Supported DBs**: MySQL, PostgreSQL

---

## Security & Middleware

```
Request Flow with Middleware:

HTTP Request
    ↓
├─→ CSRF Protection
├─→ Authentication (auth)
├─→ Role Authorization (role:admin|counselor|student)
├─→ Email Verification (verified)
├─→ Throttle (rate limiting)
└─→ Controller Action
```

---

## Database Schema Overview

### Core Tables (20+)
1. users - User accounts
2. categories - Content/quiz categories
3. educational_contents - Learning materials
4. content_views - Content engagement
5. bookmarks - Saved content
6. quizzes - Quiz definitions
7. quiz_questions - Quiz questions
8. quiz_options - Answer options
9. quiz_attempts - User quiz attempts
10. quiz_answers - Individual answers
11. assessment_attempts - Mental health assessments
12. assessment_responses - Assessment answers
13. counseling_sessions - Counseling appointments
14. counseling_messages - Session messages
15. forum_categories - Forum sections
16. forum_posts - Discussion threads
17. forum_comments - Post comments
18. forum_upvotes - User votes
19. incidents - Safety incidents
20. emergency_contacts - Emergency info
21. campaigns - Awareness campaigns
22. campaign_participants - Campaign engagement
23. notifications - User notifications
24. activity_logs - System audit trail
25. feedback - User feedback

---

## Actual Route Structure (routes/web.php)

### Public Routes
```
GET    /                                    → home
GET    /content                             → content.index
GET    /content/{content}                   → content.show
GET    /campaigns                           → campaigns.index
GET    /campaigns/{campaign}                → campaigns.show
```

### Authenticated Routes (Middleware: auth, sanctum, verified)
```
GET    /dashboard                           → dashboard (role-based redirect)
GET    /profile/edit                        → profile.edit
PATCH  /profile                             → profile.update
PATCH  /profile/password                    → profile.password.update
DELETE /profile                             → profile.destroy

GET    /notifications                       → notifications.index
PATCH  /notifications/{id}/read             → notifications.read
PATCH  /notifications/read-all              → notifications.read-all

POST   /campaigns/{campaign}/register       → campaigns.register
DELETE /campaigns/{campaign}/unregister     → campaigns.unregister
```

### Student Routes (Middleware: role:student)
```
Prefix: /student

GET    /student/dashboard                   → student.dashboard

# Quizzes
GET    /student/quizzes                     → student.quizzes.index
GET    /student/quizzes/{quiz}              → student.quizzes.show
POST   /student/quizzes/{quiz}/start        → student.quizzes.start
GET    /student/quizzes/attempt/{attempt}   → student.quizzes.take
POST   /student/quizzes/attempt/{attempt}/submit → student.quizzes.submit
GET    /student/quizzes/attempt/{attempt}/result → student.quizzes.result

# Assessments
GET    /student/assessments                 → student.assessments.index
GET    /student/assessments/{assessment}    → student.assessments.show
POST   /student/assessments                 → student.assessments.store
GET    /student/assessments/attempt/{attempt}/result → student.assessments.result

# Counseling
GET    /student/counseling                  → student.counseling.index
GET    /student/counseling/create           → student.counseling.create
POST   /student/counseling                  → student.counseling.store
GET    /student/counseling/{counseling}     → student.counseling.show
POST   /student/counseling/{counseling}/message → student.counseling.message

# Forum
GET    /student/forum                       → student.forum.index
GET    /student/forum/create                → student.forum.create
POST   /student/forum                       → student.forum.store
GET    /student/forum/{forum}               → student.forum.show
POST   /student/forum/{forum}/comment       → student.forum.comment
POST   /student/forum/{forum}/upvote        → student.forum.upvote
```

### Counselor Routes (Middleware: role:counselor)
```
Prefix: /counselor

GET    /counselor/dashboard                 → counselor.dashboard

# Sessions
GET    /counselor/sessions                  → counselor.sessions.index
GET    /counselor/sessions/{session}        → counselor.sessions.show
POST   /counselor/sessions/{session}/accept → counselor.sessions.accept
POST   /counselor/sessions/{session}/complete → counselor.sessions.complete
POST   /counselor/sessions/{session}/message → counselor.sessions.message
```

### Admin Routes (Middleware: role:admin)
```
Prefix: /admin

GET    /admin/dashboard                     → admin.dashboard

# Content Management (Resource Routes)
GET    /admin/contents                      → admin.contents.index
GET    /admin/contents/create               → admin.contents.create
POST   /admin/contents                      → admin.contents.store
GET    /admin/contents/{content}            → admin.contents.show
GET    /admin/contents/{content}/edit       → admin.contents.edit
PUT    /admin/contents/{content}            → admin.contents.update
DELETE /admin/contents/{content}            → admin.contents.destroy

# User Management (Resource Routes)
GET    /admin/users                         → admin.users.index
GET    /admin/users/create                  → admin.users.create
POST   /admin/users                         → admin.users.store
GET    /admin/users/{user}                  → admin.users.show
GET    /admin/users/{user}/edit             → admin.users.edit
PUT    /admin/users/{user}                  → admin.users.update
DELETE /admin/users/{user}                  → admin.users.destroy

# Quiz Management (Resource Routes)
GET    /admin/quizzes                       → admin.quizzes.index
GET    /admin/quizzes/create                → admin.quizzes.create
POST   /admin/quizzes                       → admin.quizzes.store
GET    /admin/quizzes/{quiz}                → admin.quizzes.show
GET    /admin/quizzes/{quiz}/edit           → admin.quizzes.edit
PUT    /admin/quizzes/{quiz}                → admin.quizzes.update
DELETE /admin/quizzes/{quiz}                → admin.quizzes.destroy

# Campaign Management (Resource Routes)
GET    /admin/campaigns                     → admin.campaigns.index
GET    /admin/campaigns/create              → admin.campaigns.create
POST   /admin/campaigns                     → admin.campaigns.store
GET    /admin/campaigns/{campaign}          → admin.campaigns.show
GET    /admin/campaigns/{campaign}/edit     → admin.campaigns.edit
PUT    /admin/campaigns/{campaign}          → admin.campaigns.update
DELETE /admin/campaigns/{campaign}          → admin.campaigns.destroy

# Incident Management (Resource Routes - except create/store)
GET    /admin/incidents                     → admin.incidents.index
GET    /admin/incidents/{incident}          → admin.incidents.show
GET    /admin/incidents/{incident}/edit     → admin.incidents.edit
PUT    /admin/incidents/{incident}          → admin.incidents.update
DELETE /admin/incidents/{incident}          → admin.incidents.destroy

# Reports
GET    /admin/reports                       → admin.reports.index
GET    /admin/reports/export                → admin.reports.export
```

---

## Design Patterns Used

1. **MVC Pattern** - Separation of concerns
2. **Repository Pattern** - Data access abstraction (via Eloquent)
3. **Factory Pattern** - Object creation (Model Factories)
4. **Observer Pattern** - Event listeners
5. **Facade Pattern** - Simplified interfaces
6. **Dependency Injection** - Service container
7. **Middleware Pattern** - Request filtering
8. **Service Layer** - Business logic separation

---

## Performance Optimization

- **Eager Loading** - Prevent N+1 queries
- **Query Caching** - Cache frequent queries
- **Asset Compilation** - Vite/Webpack optimization
- **Database Indexing** - Foreign keys, search fields
- **Pagination** - Large dataset handling
- **Queue Jobs** - Async processing (emails, notifications)

---

## Future Enhancements

- Real-time chat (WebSockets/Pusher)
- Mobile app (API-first approach)
- AI-powered content recommendations
- Video counseling integration
- Advanced analytics dashboard
- Multi-language support
- Progressive Web App (PWA)

---

**Generated**: November 11, 2025
**System**: Student Mental Health & Counseling Platform
**Framework**: Laravel 8.x MVC Architecture
