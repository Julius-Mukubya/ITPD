# Content System Structure

## Overview

The content system is a comprehensive educational content management platform that allows administrators and counselors to create, manage, and publish educational resources. The system includes content creation, categorization, user reviews, content flagging, and moderation capabilities.

---

## Core Components

### 1. Educational Content

The main content entity that represents educational resources in the system.

#### Database Table: `educational_contents`

**Fields:**
- `id` - Primary key
- `category_id` - Foreign key to categories table
- `created_by` - Foreign key to users table (author)
- `title` - Content title (string)
- `description` - Brief description (text, nullable)
- `content` - Main content body (longText)
- `type` - Content type enum: `article`, `video`, `infographic`, `document`
- `featured_image` - Path to featured image (string, nullable)
- `video_url` - URL for video content (string, nullable)
- `file_path` - Path to downloadable file (string, nullable)
- `views` - View count (integer, default: 0)
- `reading_time` - Estimated reading time in minutes (integer, nullable)
- `is_published` - Publication status (boolean, default: false)
- `is_featured` - Featured content flag (boolean, default: false)
- `published_at` - Publication timestamp (timestamp, nullable)
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp
- `deleted_at` - Soft delete timestamp (nullable)

**Indexes:**
- `is_published, published_at` - For efficient published content queries
- `type, is_published` - For filtering by content type

**Relationships:**
- `category()` - BelongsTo Category
- `author()` - BelongsTo User (via created_by)
- `contentViews()` - HasMany ContentView
- `bookmarks()` - MorphMany Bookmark
- `reviews()` - HasMany ContentReview
- `approvedReviews()` - HasMany ContentReview (filtered by is_approved)

**Scopes:**
- `published()` - Returns only published content
- `featured()` - Returns only featured content
- `ofType($type)` - Filters by content type

**Key Methods:**
- `incrementViews()` - Increments view count
- `isBookmarkedBy($userId)` - Check if user bookmarked content
- `hasReviewBy($userId)` - Check if user has reviewed content
- `getReviewBy($userId)` - Get user's review
- `clearReviewCache()` - Clear cached review attributes

**Computed Attributes:**
- `average_rating` - Average rating from approved reviews
- `formatted_average_rating` - Formatted average rating (1 decimal)
- `total_reviews` - Count of approved reviews
- `rating_distribution` - Array of rating counts and percentages (1-5 stars)
- `helpful_percentage` - Percentage of users who found content helpful
- `featured_image_url` - Full URL to featured image
- `file_url` - Full URL to downloadable file

---

### 2. Content Reviews

User-generated reviews and ratings for educational content.

#### Database Table: `content_reviews`

**Fields:**
- `id` - Primary key
- `user_id` - Foreign key to users table
- `educational_content_id` - Foreign key to educational_contents table
- `rating` - Star rating (integer, 1-5)
- `review` - Written review text (text, nullable)
- `is_helpful` - Whether user found content helpful (boolean, nullable)
- `feedback_data` - Additional structured feedback (JSON, nullable)
- `is_approved` - Admin approval status (boolean, default: true)
- `approved_at` - Approval timestamp (timestamp, nullable)
- `approved_by` - Foreign key to users table (admin who approved)
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

**Constraints:**
- Unique constraint on `user_id, educational_content_id` - One review per user per content

**Indexes:**
- `educational_content_id, is_approved` - For fetching approved reviews
- `rating, is_approved` - For rating-based queries
- `created_at` - For chronological sorting

**Relationships:**
- `user()` - BelongsTo User (reviewer)
- `content()` - BelongsTo EducationalContent
- `approvedBy()` - BelongsTo User (admin)

**Scopes:**
- `approved()` - Returns only approved reviews
- `pending()` - Returns pending reviews
- `withRating($rating)` - Filters by specific rating

**Computed Attributes:**
- `formatted_rating` - Formatted rating (1 decimal)
- `star_display` - Visual star representation (★★★☆☆)
- `has_review_text` - Boolean indicating if review has text
- `truncated_review` - Review text truncated to 150 characters
- `time_ago` - Human-readable time since review

---

### 3. Content Flags

System for reporting inappropriate or problematic content (forum posts, comments, etc.).

#### Database Table: `content_flags`

**Fields:**
- `id` - Primary key
- `user_id` - Foreign key to users table (reporter)
- `flaggable_type` - Polymorphic type (e.g., App\Models\ForumPost)
- `flaggable_id` - Polymorphic ID
- `reason` - Flag reason enum:
  - `inappropriate_content`
  - `harassment`
  - `spam`
  - `misinformation`
  - `hate_speech`
  - `violence`
  - `self_harm`
  - `other`
- `description` - Additional details (text, nullable)
- `status` - Flag status enum: `pending`, `reviewed`, `dismissed`, `action_taken`
- `reviewed_by` - Foreign key to users table (admin reviewer)
- `admin_notes` - Admin notes about the flag (text, nullable)
- `reviewed_at` - Review timestamp (timestamp, nullable)
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

**Constraints:**
- Unique constraint on `user_id, flaggable_type, flaggable_id` - One flag per user per content

**Indexes:**
- `flaggable_type, flaggable_id` - For polymorphic queries
- `status, created_at` - For filtering by status

**Relationships:**
- `flaggable()` - MorphTo (polymorphic - can be ForumPost, ForumComment, etc.)
- `user()` - BelongsTo User (reporter)
- `reviewer()` - BelongsTo User (admin)

**Scopes:**
- `pending()` - Returns pending flags
- `reviewed()` - Returns reviewed flags

**Computed Attributes:**
- `reason_label` - Human-readable reason
- `status_color` - Badge color for status (yellow, blue, gray, green)
- `status_label` - Human-readable status

---

### 4. Content Views

Tracks user views of educational content for analytics.

#### Database Table: `content_views`

**Fields:**
- `id` - Primary key
- `content_id` - Foreign key to educational_contents table
- `user_id` - Foreign key to users table (nullable for guests)
- `ip_address` - IP address of viewer (string, nullable)
- `created_at` - View timestamp
- `updated_at` - Last update timestamp

**Relationships:**
- `content()` - BelongsTo EducationalContent
- `user()` - BelongsTo User (nullable)

---

## Content Types

The system supports four types of educational content:

### 1. Article
- Text-based content with rich formatting
- Primary field: `content` (longText)
- Optional: `featured_image`, `reading_time`

### 2. Video
- Video-based educational content
- Primary field: `video_url`
- Optional: `content` (description/transcript), `featured_image` (thumbnail)

### 3. Infographic
- Visual educational content
- Primary field: `featured_image`
- Optional: `content` (description), `file_path` (downloadable version)

### 4. Document
- Downloadable educational documents (PDF, DOCX, etc.)
- Primary field: `file_path`
- Optional: `content` (description), `featured_image` (preview)

---

## Content Workflow

### Creation & Publishing

1. **Draft Creation**
   - Admin/Counselor creates content
   - `is_published` = false
   - Content not visible to public

2. **Content Review**
   - Internal review process
   - Editing and refinement

3. **Publishing**
   - Set `is_published` = true
   - Set `published_at` timestamp
   - Content becomes visible to users

4. **Featuring** (Optional)
   - Set `is_featured` = true
   - Content appears in featured sections

### User Interaction

1. **Viewing**
   - User views content
   - `views` counter incremented
   - ContentView record created

2. **Bookmarking**
   - User can bookmark content
   - Polymorphic Bookmark relationship

3. **Reviewing**
   - User submits rating (1-5 stars)
   - Optional written review
   - Optional helpful/not helpful feedback
   - One review per user per content

### Moderation

1. **Content Flagging**
   - Users can flag inappropriate content
   - Select reason and provide description
   - Flag status: pending

2. **Admin Review**
   - Admin reviews flagged content
   - Can take actions:
     - Delete content
     - Hide content
     - Warn user
     - Ban user
     - Unhide content
     - Unban user
   - Update flag status: reviewed, dismissed, or action_taken

3. **Action Changes**
   - Admins can modify previous decisions
   - Change status or take different actions
   - All changes tracked with admin notes

---

## Access Control

### Roles & Permissions

**Admin:**
- Full CRUD on all content
- Publish/unpublish content
- Feature/unfeature content
- Review and moderate flags
- Approve/reject reviews

**Counselor:**
- Create and edit own content
- Cannot publish without admin approval (configurable)
- View content analytics

**User/Student:**
- View published content
- Bookmark content
- Submit reviews
- Flag inappropriate content
- View own bookmarks and reviews

**Guest:**
- View published content only
- No interaction capabilities

---

## API Endpoints

### Public Routes
- `GET /content` - List published content
- `GET /content/{id}` - View single content
- `GET /content/{id}/reviews` - Get content reviews

### Authenticated Routes
- `POST /content/{id}/reviews` - Submit review
- `PUT /reviews/{id}` - Update own review
- `DELETE /reviews/{id}` - Delete own review
- `POST /content/{id}/quick-feedback` - Submit quick feedback
- `POST /content/{id}/bookmark` - Toggle bookmark
- `POST /content-flags` - Flag content
- `DELETE /content-flags` - Remove own flag

### Admin Routes
- `GET /admin/contents` - List all content
- `POST /admin/contents` - Create content
- `PUT /admin/contents/{id}` - Update content
- `DELETE /admin/contents/{id}` - Delete content
- `GET /admin/content-flags` - List flags
- `GET /admin/content-flags/{id}` - View flag details
- `PUT /admin/content-flags/{id}` - Review flag
- `POST /admin/content-flags/bulk-update` - Bulk flag actions

---

## Data Integrity

### Constraints
- One review per user per content
- One flag per user per content item
- Soft deletes on educational_contents
- Cascade deletes on related records

### Validation Rules
- Rating: 1-5 integer
- Content type: Must be valid enum value
- Review text: Optional but recommended
- Flag reason: Must be valid enum value

---

## Performance Considerations

### Caching Strategy
- Review statistics cached on EducationalContent model
- `clearReviewCache()` method to refresh cached data
- Direct database queries for real-time accuracy

### Indexes
- Composite indexes on frequently queried fields
- Polymorphic indexes for content flags
- Timestamp indexes for chronological queries

### Optimization
- Eager loading relationships to prevent N+1 queries
- Pagination on content lists
- Lazy loading for large content bodies

---

## Future Enhancements

### Planned Features
- Content versioning
- Collaborative editing
- Content recommendations based on user behavior
- Advanced analytics dashboard
- Content scheduling
- Multi-language support
- Content tags and advanced search
- Content series/collections

### Moderation Improvements
- Automated content filtering
- Machine learning for flag prioritization
- User reputation system
- Community moderation features

---

## Related Documentation

- [Database Structure](./database-structure.md)
- [User Roles & Permissions](./requirements.md)
- [API Documentation](./api-documentation.md)
- [Content Creation Guide](../CONTENT_CREATION_GUIDE.md)

---

**Last Updated:** February 9, 2026  
**Version:** 1.0
