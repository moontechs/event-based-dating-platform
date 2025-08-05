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
- **Email-only Authentication**: Simple login system using email address only
- **Unified Authentication Method**: 
  - Single email containing both 6-digit verification code and clickable login button
  - User can either enter the 6-digit code or click the login button
  - Same token used for both methods (the 6-digit code serves as the clickable login token)
  - Code expires in 15 minutes for security
- **Registration**: First-time login automatically creates account
- **Email Verification**: Implicit through successful login
- **User Experience**: 
  - User enters email and receives one email with both options
  - After requesting login, user is automatically redirected to code entry form
  - Code input has autofocus and auto-submits when 6 digits are entered
  - All interactive elements have proper cursor styling

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
- **User Slugs**: URLs using user slugs instead of IDs
  - Profile URLs: `/users/abcdef` instead of `/users/123`
  - Automatic slug generation using randomized strings
  - Privacy-enhanced URLs that don't expose internal user IDs
- Future expansion: Extended profile fields

## 5. Event System

### 5.1 Event Display
**Main Page Event List:**
- Event image (with fallback placeholder)
- Date and time with timezone information
- Title
- Description (single unified field)
- Event category badge
- Location (city, country)
- Attendee count
- Time zone display with formatted offset
- **Search and Filtering**:
  - Advanced search with keyword highlighting
  - Category, city, and country dropdown filters (populated from existing events)
  - Date range filtering
  - Combined search with pagination

**Event Detail Page:**
- All information from list view
- Full description (single unified field)
- "Mark Attendance" button with AJAX functionality
- List of attendees with profile photos and relationship intent
- Attendance statistics and event status
- Real-time attendance updates
- Responsive design with sidebar layout

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
- Category selection (dropdown)
- Location filters:
  - City selection (dropdown populated from existing events)
  - Country selection (dropdown populated from existing events)
- Date range picker (start and end dates)
- Text search across titles, descriptions, and locations
- Combined filtering support with real-time updates
- Clear filters functionality
- **Advanced Search Page**:
  - Dedicated search interface with expanded filtering
  - Search result highlighting
  - Quick search suggestions
  - Category-based browsing

### 5.3 Event Attendance
**Attendance System Implementation:**
- **AJAX-powered attendance toggling** with real-time updates
- **Middleware-based access control** (EnsureCanMarkAttendance)
- **Loading states and user feedback** during attendance changes
- **Automatic page refresh** after successful attendance updates

**Attendance Rules:**
- Users can mark attendance for any published event
- Past events: Only up to 2 days old
- Exception: Admin can grant access to older events
- **Authentication required** - guest users see login prompt
- No verification system initially
- No capacity limits
- **Event status validation** - unpublished events blocked

**Attendee Visibility:**
- All users who marked attendance are visible in sidebar
- Display: Profile photo + first name + relationship intent
- **Current user indicator** ("You" badge for logged-in user)
- Each attendee links to their profile using slug-based URLs (`/users/user-slug`)
- **Scrollable attendee list** with maximum height constraint
- **Empty state messaging** when no attendees present

## 6. Connection System

### 6.1 Connection Prerequisites
- Both users must have marked attendance for the same event
- Both users must have active status

### 6.2 Connection Flow
**Connection Request Interface:**
- Available on event attendee lists and user profiles from shared events
- **Livewire-powered Connection Actions** with real-time updates
- **Session Flash Messages** for user feedback after connection actions
- **Dynamic Button States** reflect current connection status (Connect, Cancel, Accept, Connected)
- **Real-time updates** without page refresh using Livewire reactivity

**Request Management:**
- Users can cancel sent requests before acceptance
- Cancel button available on profiles and connection dashboard
- Cancelled requests remove the connection possibility until re-sent
- **Mutual Request Handling:** Automatic match when both users send requests to each other

**Multiple Scenarios Supported:**
- One-way: User A sends → User B accepts
- Mutual: Both users send requests to each other (auto-accepted)
- Cancellation: User can withdraw pending requests
- Rejection: Users can reject incoming requests

**Connection States:**
- Pending: Request sent, awaiting response
- Matched: Mutual connection established
- Cancelled: Request was cancelled or rejected
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
- Event image upload (optional)
- Title (required)
- Date and time selection
- **Time zone selection** (required foreign key relationship)
- Description (single unified field)
- Category selection (required)
- Location: city and country (required)
- Published/Draft toggle

**Time Zone Management:**
- **Foreign key relationship** to dedicated time_zones table
- **Required timezone selection** - no events without timezone
- Predefined time zone list in admin panel
- Time zones displayed as: (UTC±X) Zone Name format
- Examples: (UTC-5) Eastern Standard Time, (UTC+1) Central European Time
- **Database constraint enforcement** for data integrity
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
**Authentication Emails:**
- Unified login emails containing both verification code and clickable login button
- User-friendly language avoiding technical terms like "magic link"
- Professional email template with clear call-to-action
- 15-minute expiration for security

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
- **Privacy-Enhanced URLs**: User slugs prevent exposure of internal user IDs

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
- User profile data structure with slug field for SEO-friendly URLs
- **Event and attendance relationship modeling** with full implementation
- Connection request state management
- Admin action logging
- **User Slug System**:
  - Unique slug field generated from randomized strings
  - Route model binding for seamless URL resolution
- **Event System Database Structure**:
  - Events table with timezone_id foreign key constraint
  - Time_zones table with proper timezone data
  - Event_attendances table for tracking attendance
  - Database constraints ensuring data integrity

### 13.2 File Management
- Image upload and storage system
- File size validation (10MB limit)
- Image optimization and resizing
- Content delivery optimization

### 13.3 Email System
- 6-digit verification code generation and validation (same code used as clickable login token)
- Professional email templates with user-friendly language
- Email delivery reliability using Laravel's queue system
- Bounce and error handling
- Rate limiting for authentication attempts

## 14. Implementation Status

### 14.1 Completed Features ✅

#### ✅ Core Authentication & Profile System
- **Email-based Authentication System**:
  - Magic link generation and verification (6-digit code)
  - Unified login with both code entry and clickable button
  - Profile setup flow for new users
  - User status management (Active/Inactive)
  - Profile photo upload and management
  - User slug system for privacy-enhanced URLs

#### ✅ Event Management System
- **Event Display System**:
  - Event listing page with comprehensive filtering
  - Advanced search functionality with keyword highlighting
  - Location dropdown filters populated from existing events
  - Responsive grid layout with event cards
  - Timezone display with proper formatting
  - Pagination and results summary

- **Event Attendance System**:
  - AJAX-powered attendance toggling
  - Middleware-based access control
  - Real-time attendee list updates
  - Attendance statistics and event status
  - Guest user handling with login prompts
  - Mobile-responsive sidebar design
  - Event detail pages with attendee lists

#### ✅ Connection System (Major New Feature)
- **Connection Request Management**:
  - Send/cancel/accept/reject connection requests
  - Mutual request handling (auto-match when both users send requests)
  - Connection eligibility validation (must share event attendance)
  - Real-time status updates and user feedback

- **Connection Dashboard**:
  - Incoming requests page with accept/reject actions
  - Sent requests page with cancel functionality  
  - Matches page showing established connections
  - Navigation between connection states

- **Connection UI Components**:
  - Dynamic connection buttons with state-aware styling
  - Session flash messages for user feedback
  - Responsive card layouts for connection management
  - Empty state handling for all connection types

#### ✅ Database Architecture
- **Core Tables Implemented**:
  - Users table with slug field and status management
  - Events table with timezone foreign key relationships
  - Event attendances tracking system
  - Connection requests with status management
  - Time zones table with proper timezone data
  - Magic links for authentication

- **Data Integrity Features**:
  - Foreign key constraints and relationships
  - Enum-based status management (ConnectionStatus)
  - Proper indexing for performance
  - Migration system for schema management

#### ✅ User Interface & Experience
- **Preline UI Integration**:
  - Consistent design system throughout application
  - Responsive design patterns for mobile and desktop
  - Loading states and user feedback mechanisms
  - Empty state handling with helpful messaging
  - Search result highlighting and visual feedback

- **Navigation & Routing**:
  - User slug-based URLs for privacy
  - Route model binding for seamless navigation
  - Middleware-based access control
  - Proper authentication flow and redirects

### 14.2 Technical Achievements

#### 🔧 Performance Optimizations
- **Frontend Performance**:
  - Lazy loading for images and components
  - AJAX functionality for seamless user experience
  - Optimized filtering and search operations
  - Real-time updates without full page refreshes

- **Database Performance**:
  - Efficient database queries with eager loading
  - Proper indexing on foreign keys and slug fields
  - Query optimization for connection status lookups
  - Optimized pagination for large datasets

#### 🛡️ Security Implementations
- **Authentication Security**:
  - Magic link token expiration (15 minutes)
  - Secure token generation and validation
  - CSRF protection for all form submissions
  - Rate limiting for authentication attempts

- **Access Control**:
  - Middleware-based access control system
  - Role-based routing (Active vs Inactive users)
  - Connection eligibility validation
  - Event attendance restrictions

- **Data Protection**:
  - Input validation and sanitization
  - Secure file upload handling (10MB limit, image validation)
  - User privacy through slug-based URLs
  - Protection against unauthorized profile access

#### 💡 Code Quality & Architecture
- **Laravel Best Practices**:
  - Service layer architecture (EventService, ProfileService)
  - Proper separation of concerns across controllers
  - Observer pattern for user lifecycle events
  - Enum-based status management for type safety

- **Clean Code Principles**:
  - Single responsibility principle in controllers
  - Reusable Blade components for UI consistency
  - Proper error handling and user feedback
  - Comprehensive migration system for database versioning

- **Testing & Reliability**:
  - Factory classes for all major models
  - Database transaction handling for critical operations
  - Comprehensive error logging and debugging
  - Graceful error handling with user-friendly messages

### 14.3 Recent Development Progress (Latest Updates)

#### 🎨 UI/UX Improvements
- **Connection Pages Restyling**: Complete visual overhaul of connection management interface
- **Event Pages Enhancement**: Improved styling for event listing and detail pages
- **Responsive Design**: Enhanced mobile and desktop user experience
- **Storage Management**: Improved gitignore configuration for better version control

#### 🔗 Connection System Maturation  
- **Full Connection Workflow**: Complete implementation from request to match
- **User Interface Polish**: Professional styling with Preline UI components
- **State Management**: Robust handling of all connection states and transitions
- **User Experience**: Seamless navigation between connection management pages

#### 📊 Current Platform Capabilities
The platform now supports the complete user journey:
1. **Registration**: Email-based authentication with profile setup
2. **Event Discovery**: Browse, search, and filter events with advanced options
3. **Event Participation**: Mark attendance and view attendee lists
4. **Social Connection**: Send, receive, and manage connection requests
5. **Match Management**: View and interact with established connections

### 14.4 Next Implementation Phase

#### 🚀 Immediate Priorities
- **Admin Panel Enhancement**: Complete Filament 4 admin interface for event and user management
- **Email Notification System**: Match notifications and connection request alerts
- **User Status Management**: Enhanced admin controls for user moderation
- **Performance Testing**: Load testing and optimization for production deployment

#### 📈 Future Development Roadmap
- **Event Verification System**: QR codes and check-in validation
- **Enhanced Matching**: Algorithm improvements and connection suggestions
- **Mobile App Development**: Native mobile application for iOS and Android
- **Premium Features**: Subscription tiers and advanced user capabilities

---

**Document Version**: 3.0  
**Last Updated**: August 3, 2025  
**Status**: Core Platform MVP Complete - Connection System Implemented
