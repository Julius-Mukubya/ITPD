# Level 1 Data Flow Diagram - WellPath Mental Health Platform

## Overview
The Level 1 DFD breaks down the WellPath system into six major subsystems, showing the detailed data flows between processes, external entities, and data stores.

## Major Processes

### 1. User Management System
**Process ID**: P1
**Description**: Handles user registration, authentication, profile management, and role assignment

#### Inputs:
- Registration data (from Students/Counselors)
- Login credentials (from all users)
- Profile updates (from all users)

#### Outputs:
- Authentication tokens
- User profiles
- Role assignments
- Account confirmations

#### Data Stores:
- D1: User Profiles
- D2: Authentication Data

### 2. Assessment System
**Process ID**: P2
**Description**: Manages mental health assessments, scoring, and risk evaluation

#### Inputs:
- Assessment responses (from Students)
- Assessment configurations (from Administrators)
- Scoring criteria (from Administrators)

#### Outputs:
- Assessment results
- Risk level classifications
- Recommendations
- Crisis alerts (if high risk)

#### Data Stores:
- D3: Assessments
- D4: Assessment Attempts
- D5: Assessment Results

### 3. Counseling Management System
**Process ID**: P3
**Description**: Handles counseling session requests, scheduling, and session management

#### Inputs:
- Session requests (from Students)
- Counselor availability (from Counselors)
- Session preferences (from Students)
- Session notes (from Counselors)

#### Outputs:
- Session confirmations
- Schedule updates
- Session reminders
- Progress reports

#### Data Stores:
- D6: Counseling Sessions
- D7: Session Participants
- D8: Session Notes

### 4. Content Management System
**Process ID**: P4
**Description**: Manages educational content, campaigns, and resource delivery

#### Inputs:
- Content uploads (from Administrators)
- Content requests (from Students)
- Campaign data (from Administrators)
- Content feedback (from Students)

#### Outputs:
- Educational content
- Campaign materials
- Content recommendations
- Usage analytics

#### Data Stores:
- D9: Educational Content
- D10: Categories
- D11: Campaigns
- D12: Content Reviews

### 5. Communication System
**Process ID**: P5
**Description**: Handles notifications, messaging, and forum interactions

#### Inputs:
- Notification triggers (from all processes)
- Forum posts (from Students/Counselors)
- Message content (from all users)
- Communication preferences (from all users)

#### Outputs:
- Email notifications
- SMS alerts
- In-app notifications
- Forum discussions
- System messages

#### Data Stores:
- D13: Notifications
- D14: Forum Posts
- D15: Forum Comments
- D16: Messages

### 6. Reporting & Analytics System
**Process ID**: P6
**Description**: Generates reports, analytics, and system insights

#### Inputs:
- Usage data (from all processes)
- Report requests (from Administrators/Counselors)
- Analytics parameters (from Administrators)
- Performance metrics (from system)

#### Outputs:
- System reports
- User analytics
- Performance dashboards
- Compliance reports
- Usage statistics

#### Data Stores:
- D17: System Logs
- D18: Analytics Data
- D19: Reports

## Data Stores

### Primary Data Stores
- **D1: User Profiles** - User account information, roles, preferences
- **D2: Authentication Data** - Login credentials, tokens, sessions
- **D3: Assessments** - Assessment templates, questions, scoring
- **D4: Assessment Attempts** - User responses, scores, timestamps
- **D5: Assessment Results** - Processed results, risk levels, recommendations
- **D6: Counseling Sessions** - Session details, schedules, status
- **D7: Session Participants** - Participant information, attendance
- **D8: Session Notes** - Counselor notes, progress tracking
- **D9: Educational Content** - Articles, resources, materials
- **D10: Categories** - Content categorization, organization
- **D11: Campaigns** - Awareness campaigns, targeted content
- **D12: Content Reviews** - User feedback, ratings, comments
- **D13: Notifications** - System notifications, alerts, messages
- **D14: Forum Posts** - Discussion topics, community posts
- **D15: Forum Comments** - Responses, discussions, interactions
- **D16: Messages** - Direct messages, communications
- **D17: System Logs** - Audit trails, system events, errors
- **D18: Analytics Data** - Usage metrics, performance data
- **D19: Reports** - Generated reports, scheduled outputs

## Inter-Process Data Flows

### P1 → P2: User Authentication
- Authenticated user data for assessment access
- User role information for assessment permissions

### P2 → P3: Assessment Results
- Risk level data for counseling prioritization
- Assessment outcomes for session planning

### P2 → P5: Crisis Alerts
- High-risk assessment results triggering immediate notifications
- Emergency contact information

### P3 → P5: Session Notifications
- Session confirmations and reminders
- Schedule changes and updates

### P4 → P5: Content Notifications
- New content alerts
- Campaign announcements

### All Processes → P6: Analytics Data
- Usage statistics
- Performance metrics
- User interaction data

### P6 → P1: User Reports
- User activity summaries
- Account status reports

## External Entity Interactions

### Students/Users
- **To P1**: Registration, login, profile updates
- **To P2**: Assessment responses, retake requests
- **To P3**: Session requests, preferences, feedback
- **To P4**: Content requests, reviews, feedback
- **From P5**: Notifications, alerts, messages

### Counselors
- **To P1**: Profile updates, availability
- **To P3**: Session notes, schedules, reports
- **From P3**: Session assignments, client information
- **From P5**: Session notifications, system alerts

### Administrators
- **To P1**: User management, role assignments
- **To P2**: Assessment configurations, scoring updates
- **To P4**: Content uploads, campaign management
- **From P6**: System reports, analytics, performance data

### Emergency Services
- **From P2**: Crisis alerts, high-risk notifications
- **From P5**: Emergency contact requests

## Data Flow Validation Rules

### Authentication Flows
- All user interactions require valid authentication
- Role-based access control enforced at process level
- Session timeouts and security validations

### Assessment Flows
- Only authenticated students can take assessments
- Assessment results trigger appropriate follow-up actions
- Crisis-level results immediately notify relevant parties

### Session Management Flows
- Session requests validated against counselor availability
- Participant limits enforced for group sessions
- Session notes restricted to assigned counselors

### Content Flows
- Content access based on user role and permissions
- Content reviews and feedback tracked for quality assurance
- Campaign targeting based on user profiles and assessment results

## Error Handling
- Invalid data flows rejected with appropriate error messages
- System failures logged and administrators notified
- Backup processes for critical functions like crisis alerts
- Data integrity checks at all process boundaries