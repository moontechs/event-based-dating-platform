# Event-Based Dating Platform - Product Requirements Document

## 1. Product Overview

### 1.1 Product Vision
A web-based platform that connects people through shared event experiences, allowing users to meet and form connections based on mutual event attendance.

### 1.2 Target Audience
- Primary: Adults seeking romantic connections through shared interests and events
- Secondary: Social networkers looking to expand their social circle

### 1.3 Core Value Proposition
- Connect with people who share similar interests through real events
- Remove the awkwardness of cold messaging by requiring mutual event attendance
- Build authentic connections based on shared experiences

## 2. Technical Requirements

### 2.1 Technology Stack
- **Backend**: PHP with Laravel 12
- **Frontend**: Preline UI library
- **Admin Panel**: Filament 4
- **Platform**: Web-only (mobile app consideration for future phases)

### 2.2 Performance Requirements
- Page load time: < 3 seconds
- Image upload: Support up to 10MB files
- Concurrent users: To be determined based on launch scale

## 3. User Authentication & Registration

### 3.1 Login System
- **Magic Link Authentication**: Email-only login system
- **Verification Methods**: 
  - Email with 6-digit code
  - Email with clickable magic link
  - Both methods provide equivalent access
- **Registration**: First-time login automatically creates account
- **Email Verification**: Implicit through successful login

### 3.2 User States
- **Unregistered**: Has not logged in
- **Registered**: Has logged in but not completed profile
- **Active**: Completed profile, full platform access
- **Inactive**: Admin-restricted access (profile-only access)

## 4. User Profile Management

### 4.1 Short Profile Form (Mandatory)
**Required fields for first login:**
- Email (pre-filled from login)
- Photo (max 10MB, images only)
- Full Name
- WhatsApp Number (display only)
- Relationship Intent (dropdown):
  - Don't know
  - Monogamous relationships
  - Open relationship
  - Casual fling
- Terms of Service acceptance (checkbox)

### 4.2 Profile Access Levels
**Public Profile (non-connected users):**
- Photo
- First name only
- Relationship intent

**Full Profile (connected users):**
- All information from short profile form
- Future: Additional profile fields

### 4.3 Profile Management
- Users can edit all profile information post-registration except email
- Email field is read-only after registration (tied to authentication)
- Profile page accessible from main navigation
- Future expansion: Extended profile fields

## 5. Event System

### 5.1 Event Display
**Main Page Event List:**
- Event image
- Date and time
- Title
- Short description
- Event category
- Location (city, country)
- Time zone display

**Event Detail Page:**
- All information from list view
- Extended description
- "Mark Attendance" button
- List of attendees (photo + first name)
- Category and location details
- Full time zone information

### 5.2 Event Categories & Filtering
**Predefined Event Categories:**
- Networking
- Social Meetup
- Professional
- Recreation & Hobbies
- Cultural & Arts
- Sports & Fitness
- Food & Dining
- Educational
- Entertainment
- Other

**Category Management:**
- Predefined categories available by default
- Admin can add new categories
- Admin can edit/disable existing categories
- Categories displayed in dropdown on event creation

**Filtering Options:**
- Category selection
- Location (city/country)
- Date range picker
- Combined filtering support

### 5.3 Event Attendance
**Attendance Rules:**
- Users can mark attendance for any event
- Past events: Only up to 2 days old
- Exception: Admin can grant access to older events
- No verification system initially
- No capacity limits

**Attendee Visibility:**
- All users who marked attendance are visible
- Display: Photo + first name
- Each attendee links to their profile

## 6. Connection System

### 6.1 Connection Prerequisites
- Both users must have marked attendance for the same event
- Both users must have active status

### 6.2 Connection Flow
**Connection Request:**
- Available only on profiles of users from shared events
- "Send Connection Request" button on user profiles
- **Request Management:**
  - Users can cancel sent requests before acceptance
  - Cancel button available in "Sent Requests" section
  - Cancelled requests remove the connection possibility until re-sent
- Multiple scenarios supported:
  - One-way: User A sends → User B accepts
  - Mutual: Both users send requests to each other
  - Cancellation: User can withdraw pending requests

**Connection States:**
- Pending: Request sent, awaiting response
- Matched: Mutual connection established
- No connection: No requests sent

### 6.3 Connection Management Dashboard
**User's connection overview page includes:**
- **Incoming Requests**: Connection requests received
- **Sent Requests**: Connection requests sent (pending)
- **Matches**: Established mutual connections

### 6.4 Match Benefits
- Access to full profile of matched user
- Email notification when match occurs
- Future: Additional premium features

## 7. User Status Management

### 7.1 User Status Types
- **Active**: Full platform access
- **Inactive**: Restricted access (profile page only)

### 7.2 Admin Controls
- Admin can change user status
- Reason field required for status changes
- Inactive users cannot:
  - Browse events
  - Send connection requests
  - Mark event attendance

## 8. Admin Panel Features

### 8.1 Event Management
**Event Creation Form:**
- Event image upload
- Title
- Date and time selection
- Time zone selection (dropdown with predefined list)
- Short description
- Extended description
- Category selection
- Location (city, country)
- Published/Draft toggle

**Time Zone Management:**
- Predefined time zone list in admin panel
- Time zones displayed as: (UTC±X) Zone Name format
- Examples: (UTC-5) Eastern Standard Time, (UTC+1) Central European Time
- Admin can modify available time zone list

**Event Administration:**
- Event listing with filters
- Edit existing events
- Delete events
- View attendance lists

### 8.2 User Management
- User listing and search
- Status management (Active/Inactive)
- Reason tracking for status changes
- Grant access to past events (beyond 2-day limit)

### 8.3 System Management
- Create/edit/delete event categories
- Category assignment to events
- Time zone list management
- Photo content moderation (when reported)

## 9. Notification System

### 9.1 Email Notifications
**Match Notifications:**
- Triggered when mutual connection is established
- Sent to both users
- Include basic information about the match

**Future Considerations:**
- Connection request notifications
- Event reminders
- Platform updates

## 10. Security & Privacy

### 10.1 Data Protection
- Secure handling of personal information
- Image storage and processing
- Email security for authentication

### 10.2 Privacy Controls
- Limited profile visibility for non-connected users
- Event-based connection requirements
- Admin oversight capabilities
- **Photo Moderation**: Report-based system for inappropriate content

## 11. Future Enhancements

### 11.1 Phase 2 Features
- Event attendance verification (QR codes, check-ins)
- Connection limits and rate limiting
- Advanced user moderation tools
- Analytics dashboard for admins
- Event approval workflow

### 11.2 Phase 3 Features
- Premium user tiers
- Mobile application
- In-app messaging system
- Enhanced geolocation features
- Advanced matching algorithms

### 11.3 Monetization Options
- Premium profile features
- Event promotion options
- Subscription tiers
- Enhanced connection features

## 12. Success Metrics

### 12.1 User Engagement
- User registration completion rate
- Event attendance marking frequency
- Connection request success rate
- User retention metrics

### 12.2 Platform Health
- Event creation frequency
- User activity levels
- Match conversion rates
- Platform usage patterns

## 13. Technical Implementation Notes

### 13.1 Database Considerations
- User profile data structure
- Event and attendance relationship modeling
- Connection request state management
- Admin action logging

### 13.2 File Management
- Image upload and storage system
- File size validation (10MB limit)
- Image optimization and resizing
- Content delivery optimization

### 13.3 Email System
- Magic link generation and validation
- Notification email templates
- Email delivery reliability
- Bounce and error handling

---

**Document Version**: 1.0  
**Last Updated**: July 27, 2025  
**Status**: Ready for Development Planning