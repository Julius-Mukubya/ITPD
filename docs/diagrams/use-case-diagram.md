# Use Case Diagram - WellPath Mental Health Platform

## Overview
This document describes the use case diagram for the WellPath Mental Health Platform, detailing the interactions between different actors and the system's functionality.

## Actors

### Primary Actors

#### 1. Student/User
**Description**: Primary beneficiary of the platform seeking mental health support and resources
**Role**: End user accessing mental health services and educational content

#### 2. Counselor
**Description**: Mental health professional providing counseling services through the platform
**Role**: Service provider managing client sessions and progress

#### 3. Administrator
**Description**: System administrator managing the platform and its users
**Role**: System manager with full access to platform configuration and management

### Secondary Actors

#### 4. Emergency Services
**Description**: External crisis intervention services
**Role**: Receives crisis alerts and provides emergency support

#### 5. Email System
**Description**: External email service for notifications
**Role**: Delivers email notifications and alerts

#### 6. SMS Gateway
**Description**: External SMS service for urgent alerts
**Role**: Sends SMS notifications for critical situations

## Use Cases by Actor

### Student/User Use Cases

#### Authentication & Profile Management
- **UC001: Register Account**
  - Description: Create new user account with personal information
  - Preconditions: User has valid email address
  - Postconditions: Account created, verification email sent

- **UC002: Login to System**
  - Description: Authenticate and access personal dashboard
  - Preconditions: Valid account exists
  - Postconditions: User authenticated, session established

- **UC003: Update Profile**
  - Description: Modify personal information and preferences
  - Preconditions: User logged in
  - Postconditions: Profile information updated

- **UC004: Change Password**
  - Description: Update account password for security
  - Preconditions: User authenticated
  - Postconditions: Password updated, confirmation sent

#### Assessment & Evaluation
- **UC005: Take Mental Health Assessment**
  - Description: Complete standardized mental health questionnaire
  - Preconditions: User logged in
  - Postconditions: Assessment completed, results generated

- **UC006: View Assessment Results**
  - Description: Review assessment outcomes and recommendations
  - Preconditions: Assessment completed
  - Postconditions: Results displayed, recommendations provided

- **UC007: Retake Assessment**
  - Description: Complete assessment again after time period
  - Preconditions: Previous assessment exists, time limit passed
  - Postconditions: New assessment completed, results updated

#### Counseling Services
- **UC008: Request Individual Counseling**
  - Description: Submit request for one-on-one counseling session
  - Preconditions: User logged in, assessment completed
  - Postconditions: Request submitted, counselor assignment initiated

- **UC009: Join Group Session**
  - Description: Participate in group counseling session
  - Preconditions: Invited to group session
  - Postconditions: Participation recorded, session attended

- **UC010: View Session History**
  - Description: Review past counseling sessions and notes
  - Preconditions: User has attended sessions
  - Postconditions: Session history displayed

- **UC011: Cancel Session**
  - Description: Cancel scheduled counseling session
  - Preconditions: Session scheduled, within cancellation window
  - Postconditions: Session cancelled, notifications sent

#### Educational Content
- **UC012: Browse Educational Content**
  - Description: Explore mental health resources and articles
  - Preconditions: User logged in
  - Postconditions: Content displayed, viewing tracked

- **UC013: Search Content**
  - Description: Find specific educational materials
  - Preconditions: User logged in
  - Postconditions: Search results displayed

- **UC014: Rate Content**
  - Description: Provide feedback on educational materials
  - Preconditions: Content viewed
  - Postconditions: Rating submitted, feedback recorded

#### Community Interaction
- **UC015: Participate in Forum**
  - Description: Engage in community discussions
  - Preconditions: User logged in
  - Postconditions: Forum participation recorded

- **UC016: Create Forum Post**
  - Description: Start new discussion topic
  - Preconditions: User logged in, forum access granted
  - Postconditions: Post created, notifications sent

### Counselor Use Cases

#### Profile & Availability Management
- **UC017: Manage Professional Profile**
  - Description: Update counselor credentials and specializations
  - Preconditions: Counselor account verified
  - Postconditions: Profile updated, visible to system

- **UC018: Set Availability Schedule**
  - Description: Define available times for counseling sessions
  - Preconditions: Counselor logged in
  - Postconditions: Schedule updated, available for booking

- **UC019: Update Contact Information**
  - Description: Modify professional contact details
  - Preconditions: Counselor authenticated
  - Postconditions: Contact information updated

#### Session Management
- **UC020: View Assigned Sessions**
  - Description: Review scheduled counseling sessions
  - Preconditions: Counselor logged in
  - Postconditions: Session list displayed

- **UC021: Conduct Individual Session**
  - Description: Facilitate one-on-one counseling session
  - Preconditions: Session scheduled, client present
  - Postconditions: Session conducted, notes recorded

- **UC022: Facilitate Group Session**
  - Description: Lead group counseling session
  - Preconditions: Group session scheduled, participants invited
  - Postconditions: Group session completed, participation tracked

- **UC023: Create Session Notes**
  - Description: Document session observations and recommendations
  - Preconditions: Session completed
  - Postconditions: Notes saved, client progress updated

- **UC024: Schedule Follow-up Session**
  - Description: Arrange subsequent counseling session
  - Preconditions: Initial session completed
  - Postconditions: Follow-up scheduled, client notified

#### Client Management
- **UC025: View Client Assessment History**
  - Description: Review client's mental health assessment results
  - Preconditions: Client assigned to counselor
  - Postconditions: Assessment history displayed

- **UC026: Generate Progress Report**
  - Description: Create comprehensive client progress summary
  - Preconditions: Multiple sessions completed
  - Postconditions: Report generated, available for review

- **UC027: Refer to Specialist**
  - Description: Recommend specialized mental health services
  - Preconditions: Client assessment indicates need
  - Postconditions: Referral created, client notified

#### Crisis Management
- **UC028: Handle Crisis Alert**
  - Description: Respond to high-risk assessment results
  - Preconditions: Crisis alert received
  - Postconditions: Crisis response initiated, appropriate actions taken

### Administrator Use Cases

#### User Management
- **UC029: Manage User Accounts**
  - Description: Create, modify, or deactivate user accounts
  - Preconditions: Administrator logged in
  - Postconditions: User account status updated

- **UC030: Assign User Roles**
  - Description: Set user permissions and access levels
  - Preconditions: User account exists
  - Postconditions: Role assigned, permissions updated

- **UC031: Verify Counselor Credentials**
  - Description: Validate counselor professional qualifications
  - Preconditions: Counselor registration submitted
  - Postconditions: Credentials verified, account approved

#### Content Management
- **UC032: Upload Educational Content**
  - Description: Add new mental health resources to platform
  - Preconditions: Administrator logged in, content prepared
  - Postconditions: Content uploaded, available to users

- **UC033: Manage Content Categories**
  - Description: Organize educational materials by topic
  - Preconditions: Administrator access
  - Postconditions: Categories updated, content organized

- **UC034: Create Awareness Campaign**
  - Description: Develop targeted mental health campaigns
  - Preconditions: Campaign content prepared
  - Postconditions: Campaign created, targeting configured

#### System Configuration
- **UC035: Configure Assessment Parameters**
  - Description: Set scoring criteria and risk thresholds
  - Preconditions: Administrator access, clinical guidelines
  - Postconditions: Assessment parameters updated

- **UC036: Manage System Settings**
  - Description: Configure platform operational parameters
  - Preconditions: Administrator privileges
  - Postconditions: System settings updated

- **UC037: Generate System Reports**
  - Description: Create platform usage and performance reports
  - Preconditions: Administrator access, data available
  - Postconditions: Reports generated, insights provided

#### Monitoring & Maintenance
- **UC038: Monitor System Performance**
  - Description: Track platform performance and user activity
  - Preconditions: Administrator access, monitoring tools
  - Postconditions: Performance data reviewed, issues identified

- **UC039: Manage Crisis Protocols**
  - Description: Configure emergency response procedures
  - Preconditions: Administrator access, crisis guidelines
  - Postconditions: Crisis protocols updated

## Use Case Relationships

### Include Relationships
- UC001 (Register Account) includes UC002 (Login to System)
- UC008 (Request Individual Counseling) includes UC005 (Take Mental Health Assessment)
- UC021 (Conduct Individual Session) includes UC023 (Create Session Notes)

### Extend Relationships
- UC005 (Take Mental Health Assessment) extends to UC028 (Handle Crisis Alert) if high risk
- UC012 (Browse Educational Content) extends to UC014 (Rate Content)
- UC016 (Create Forum Post) extends to UC015 (Participate in Forum)

### Generalization Relationships
- UC021 (Conduct Individual Session) and UC022 (Facilitate Group Session) generalize to "Conduct Counseling Session"
- UC008 (Request Individual Counseling) and UC009 (Join Group Session) generalize to "Access Counseling Services"

## System Boundaries
The WellPath system boundary includes:
- Web-based user interfaces
- Assessment processing engine
- Session management system
- Content delivery system
- Notification services
- Reporting and analytics

## Non-Functional Requirements
- **Security**: All use cases require appropriate authentication and authorization
- **Performance**: System must respond within 3 seconds for standard operations
- **Availability**: Platform must be available 99.9% of the time
- **Scalability**: System must support concurrent users and growing data volumes
- **Compliance**: All use cases must comply with healthcare privacy regulations