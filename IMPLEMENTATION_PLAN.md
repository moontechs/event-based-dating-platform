# Event-Based Dating Platform - Implementation Plan

## Overview
This document outlines the complete implementation plan for the Event-Based Dating Platform based on the PRD requirements. The plan is organized into phases with granular steps for systematic development.

## Technology Stack
- **Backend**: Laravel 12 with PHP 8.3+
- **Frontend**: Preline UI library
- **Admin Panel**: Filament 4
- **Database**: PostgreSQL 15+
- **Queue**: KeyDB (Redis-compatible)
- **Node.js Package Manager**: pnpm
- **File Storage**: Laravel Storage (local/S3)
- **Email**: Laravel Mail with queue support
- **Development Server**: php artisan serve
- **Development Services**: Docker compose for PostgreSQL and KeyDB only

## Phase 1: Foundation & Local Development Setup

### 1.1 Docker Services Setup (Database & Queue Only)
- [ ] Create docker-compose.yml for development services:
  - **postgres**: PostgreSQL 15 database
  - **keydb**: KeyDB for queue and cache
- [ ] Configure volume mappings:
  - PostgreSQL data: `./docker/postgres:/var/lib/postgresql/data`
  - KeyDB data: `./docker/keydb:/data`
- [ ] Create docker configuration files:
  - `docker/postgres/init.sql` (optional init scripts)
- [ ] Add .dockerignore file

### 1.2 Project Setup
- [ ] Initialize Laravel 12 project
- [ ] Configure environment settings (.env) for Docker services:
  - DB_HOST=localhost, DB_PORT=5432
  - REDIS_HOST=localhost, REDIS_PORT=6379
  - QUEUE_CONNECTION=redis
  - CACHE_DRIVER=redis
  - SESSION_DRIVER=redis
- [ ] Set up PostgreSQL database connection
- [ ] Configure KeyDB for queues, cache, and sessions
- [ ] Install and configure Filament 4
- [ ] Install Preline UI components with pnpm
- [ ] Set up basic routing structure
- [ ] Configure email providers (SMTP/SES)
- [ ] Set up file storage configuration
- [ ] Configure queue drivers for KeyDB

### 1.3 Database Schema Design
- [ ] Extend default Laravel users migration with additional columns:
  - full_name (string)
  - whatsapp_number (string)
  - photo_path (string, nullable)
  - relationship_intent (enum: dont_know, monogamous, open_relationship, casual_fling)
  - status (enum: active, inactive, default: active)
  - status_reason (text, nullable)
  - terms_accepted (boolean, default: false)
  - Keep default: id, name, email, email_verified_at, password, remember_token, timestamps
- [ ] Create magic_links migration:
  - id, email, token, expires_at, used_at, created_at
- [ ] Create events migration:
  - id, title, description, extended_description, image_path
  - date_time (timestamp), timezone, category_id, city, country
  - is_published (boolean, default: false), created_at, updated_at
- [ ] Create event_categories migration:
  - id, name, is_active (boolean, default: true), created_at, updated_at
- [ ] Create event_attendances migration:
  - id, user_id (foreign), event_id (foreign), created_at, updated_at
  - Unique constraint on (user_id, event_id)
- [ ] Create connection_requests migration:
  - id, sender_id (foreign to users), receiver_id (foreign to users)
  - status (enum: pending, accepted, cancelled, default: pending)
  - created_at, updated_at
- [ ] Create time_zones migration:
  - id, name, display_name, utc_offset, is_active (boolean, default: true)
- [ ] Create admin_actions migration for logging:
  - id, admin_id (foreign to users), action_type, target_type, target_id
  - details (jsonb), created_at

### 1.4 Database Factories
- [ ] Create UserFactory extending default Laravel UserFactory:
  - Generate realistic fake data for all custom fields
  - Handle photo_path generation (fake image URLs)
  - Random relationship_intent selection
  - Random 40-character passwords for non-admin users
- [ ] Create MagicLinkFactory:
  - Generate secure tokens
  - Set appropriate expiration times
  - Associate with existing or fake emails
- [ ] Create EventFactory:
  - Generate realistic event data
  - Random categories and timezones
  - Future and past dates for testing
  - Fake images and descriptions
- [ ] Create EventCategoryFactory:
  - Generate category names and status
- [ ] Create EventAttendanceFactory:
  - Associate users with events
  - Ensure unique combinations
- [ ] Create ConnectionRequestFactory:
  - Generate various request states
  - Ensure proper sender/receiver relationships
- [ ] Create TimeZoneFactory:
  - Generate timezone data with proper UTC offsets

### 1.5 Database Seeders

#### Production Seeders
- [ ] Create TimeZoneSeeder (for production):
  - Seed comprehensive list of world timezones
  - Format: (UTC±X) Zone Name
  - Include major timezones: UTC, EST, PST, CET, JST, etc.
  - Mark all as active by default
- [ ] Create EventCategorySeeder (for production):
  - Seed predefined categories from PRD:
    - Networking, Social Meetup, Professional
    - Recreation & Hobbies, Cultural & Arts
    - Sports & Fitness, Food & Dining
    - Educational, Entertainment, Other
  - Mark all as active by default

#### Development Seeders
- [ ] Create UserSeeder (local development):
  - Create admin user with known credentials
  - Generate 50-100 test users with various profiles
  - Mix of completed and incomplete profiles
  - Various relationship intents and statuses
- [ ] Create EventSeeder (local development):
  - Generate 20-30 sample events
  - Mix of past, current, and future events
  - Various categories and locations
  - Some published, some draft
- [ ] Create EventAttendanceSeeder (local development):
  - Generate realistic attendance patterns
  - Ensure some users attend multiple events
  - Create shared attendance for connection testing
- [ ] Create ConnectionRequestSeeder (local development):
  - Generate various connection states
  - Include pending, accepted, and cancelled requests
  - Ensure realistic connection patterns

#### Seeder Organization
- [ ] Create DatabaseSeeder with environment-specific logic:
  - Always run production seeders (timezones, categories)
  - Run development seeders only in local/staging environments
- [ ] Create separate seeder commands:
  - `php artisan db:seed --class=ProductionSeeder`
  - `php artisan db:seed --class=DevelopmentSeeder`

### 1.6 Authentication System
- [ ] Create MagicLink model with token generation
- [ ] Implement MagicLinkController for login requests
- [ ] Create email verification job for 6-digit codes (queued to KeyDB)
- [ ] Create email job for magic link sending (queued to KeyDB)
- [ ] Implement LoginController with magic link validation
- [ ] Create middleware for authentication checks
- [ ] Set up email templates for authentication
- [ ] Implement automatic user creation on first login with:
  - Random 40-character password for non-admin users
  - Email as username
  - Default status as 'active'
- [ ] Add rate limiting for login attempts (using KeyDB)

## Phase 2: User Management & Profiles

### 2.1 User Models & Relationships
- [ ] Extend default User model with relationships:
  - hasMany(EventAttendance)
  - hasMany(ConnectionRequest, 'sender_id')
  - hasMany(ConnectionRequest, 'receiver_id')
- [ ] Create UserStatus enum (Active, Inactive)
- [ ] Create RelationshipIntent enum (DontKnow, Monogamous, OpenRelationship, CasualFling)
- [ ] Add user status scopes and accessors
- [ ] Implement profile completion checking
- [ ] Add password generation helper for non-admin users (40 random characters)

### 2.2 User Registration Flow
- [ ] Create ProfileSetupController
- [ ] Build mandatory profile form with fields:
  - Photo upload (10MB limit, image validation)
  - Full name validation (update 'name' field)
  - WhatsApp number validation
  - Relationship intent dropdown
  - Terms acceptance checkbox
- [ ] Implement image upload handling and storage
- [ ] Add image resizing and optimization
- [ ] Create profile completion middleware
- [ ] Add form validation rules and error handling

### 2.3 Profile Management
- [ ] Create ProfileController for viewing/editing
- [ ] Implement profile access level logic:
  - Public view (photo, first name only from 'name', relationship intent)
  - Full view (all details for connected users)
- [ ] Build profile edit forms
- [ ] Add profile photo management (upload/delete)
- [ ] Implement email read-only protection
- [ ] Create profile view permissions system

## Phase 3: Event System

### 3.1 Event Models & Categories
- [ ] Create Event model with relationships:
  - belongsTo(EventCategory)
  - hasMany(EventAttendance)
  - hasManyThrough(User, EventAttendance)
- [ ] Create EventCategory model
- [ ] Create TimeZone model with seed data
- [ ] Implement event status scopes (published/draft)
- [ ] Add event date/time handling with PostgreSQL timestamp types

### 3.2 Event Display System
- [ ] Create EventController for public listing
- [ ] Build event list view with filters:
  - Category dropdown filter
  - Location (city/country) filter
  - Date range picker
  - Combined filtering logic using PostgreSQL features
- [ ] Create event detail page showing:
  - All event information
  - Attendee list with photos/names
  - Mark attendance button
- [ ] Implement timezone display logic
- [ ] Add event search functionality with PostgreSQL full-text search

### 3.3 Event Attendance System
- [ ] Create EventAttendance model
- [ ] Create AttendanceController
- [ ] Implement attendance marking rules:
  - Current and future events: unrestricted
  - Past events: up to 2 days old
  - Admin exception for older events
- [ ] Build attendee list display
- [ ] Add attendance validation middleware
- [ ] Implement attendance toggle functionality

## Phase 4: Connection System

### 4.1 Connection Models & Logic
- [ ] Create ConnectionRequest model with relationships:
  - belongsTo(User, 'sender_id')
  - belongsTo(User, 'receiver_id')
- [ ] Create ConnectionStatus enum (Pending, Accepted, Cancelled)
- [ ] Implement connection eligibility checking:
  - Shared event attendance requirement
  - Active user status requirement
- [ ] Add connection state management methods

### 4.2 Connection Request Flow
- [ ] Create ConnectionController
- [ ] Build "Send Connection Request" functionality
- [ ] Implement request cancellation system
- [ ] Add mutual request handling logic
- [ ] Create connection request validation
- [ ] Build connection status display logic

### 4.3 Connection Dashboard
- [ ] Create ConnectionDashboardController
- [ ] Build connection management interface:
  - Incoming requests section
  - Sent requests section (with cancel option)
  - Established matches section
- [ ] Implement request acceptance/rejection
- [ ] Add connection statistics display
- [ ] Create connection-based profile access control

## Phase 5: Admin Panel (Filament)

### 5.1 Admin Authentication & Setup
- [ ] Configure Filament admin panel
- [ ] Set up admin user seeder (with proper admin flag/role)
- [ ] Create admin authentication guard
- [ ] Configure admin panel branding
- [ ] Set up admin navigation structure

### 5.2 Event Management Interface
- [ ] Create EventResource for Filament:
  - Event creation form with all fields
  - Image upload handling
  - Timezone dropdown
  - Category selection
  - Published/Draft toggle
- [ ] Create EventCategoryResource
- [ ] Create TimeZoneResource
- [ ] Implement event listing with filters
- [ ] Add event attendance viewing
- [ ] Build event edit/delete functionality

### 5.3 User Management Interface
- [ ] Create UserResource for Filament:
  - User listing with search
  - Status management (Active/Inactive)
  - Status reason tracking
  - Profile viewing
- [ ] Implement past event access granting
- [ ] Create user statistics dashboard
- [ ] Add user action history logging
- [ ] Build user profile moderation tools

### 5.4 System Management
- [ ] Create admin dashboard with metrics using PostgreSQL analytics
- [ ] Implement category management interface
- [ ] Build timezone configuration panel
- [ ] Create system settings management

## Phase 6: Notification System

### 6.1 Email Infrastructure
- [ ] Set up Laravel queue configuration with KeyDB
- [ ] Create base notification classes
- [ ] Configure email templates with branding
- [ ] Implement email delivery tracking
- [ ] Add bounce/failure handling

### 6.2 Match Notifications
- [ ] Create MatchNotification class (queued to KeyDB)
- [ ] Implement notification triggering on match
- [ ] Build email template for match notifications
- [ ] Add notification preferences system
- [ ] Create notification history tracking

### 6.3 Email Queue Management
- [ ] Configure reliable queue processing with KeyDB
- [ ] Implement queue monitoring
- [ ] Add failed job retry logic
- [ ] Create email delivery reporting
- [ ] Set up queue worker commands (`php artisan queue:work`)

## Phase 7: Security & Privacy

### 7.1 Security Implementation
- [ ] Implement CSRF protection
- [ ] Add rate limiting to all endpoints (using KeyDB)
- [ ] Configure file upload security
- [ ] Implement image content validation
- [ ] Add XSS protection measures
- [ ] Set up secure session handling with KeyDB
- [ ] Secure random password generation for user creation

### 7.2 Privacy Controls
- [ ] Implement profile visibility restrictions
- [ ] Configure secure file storage

## Phase 8: Frontend Development

### 8.1 Setup & Package Management
- [ ] Initialize package.json with pnpm
- [ ] Install Preline UI components via pnpm
- [ ] Configure build tools (Vite) with pnpm
- [ ] Set up CSS preprocessing
- [ ] Configure asset compilation

### 8.2 Layout & Navigation
- [ ] Create base layout with Preline UI
- [ ] Implement responsive navigation
- [ ] Build authentication layout
- [ ] Create dashboard layout structure
- [ ] Add mobile-responsive design
- [ ] Implement accessibility features

### 8.3 Authentication Views
- [ ] Create login page with email input
- [ ] Build magic link landing page
- [ ] Create profile setup form
- [ ] Implement authentication error handling
- [ ] Add loading states and feedback
- [ ] Build logout functionality

### 8.4 Event Views
- [ ] Create event listing page with filters
- [ ] Build event detail page
- [ ] Implement attendance marking interface
- [ ] Create attendee display components
- [ ] Add event sharing functionality
- [ ] Build responsive event cards

### 8.5 Profile & Connection Views
- [ ] Create profile view/edit pages
- [ ] Build connection dashboard
- [ ] Implement connection request interface
- [ ] Create match celebration interface
- [ ] Add profile photo management
- [ ] Build connection history views

## Phase 9: Testing & Quality Assurance

### 9.1 Backend Testing
- [ ] Write unit tests for all models
- [ ] Create feature tests for authentication
- [ ] Test event system functionality
- [ ] Test connection system logic
- [ ] Create integration tests for email system
- [ ] Add performance testing with PostgreSQL
- [ ] Test random password generation
- [ ] Test database factories and seeders
- [ ] Test queue jobs with KeyDB

### 9.2 Frontend Testing
- [ ] Test responsive design across devices
- [ ] Validate form submissions and error handling
- [ ] Test file upload functionality
- [ ] Verify email template rendering
- [ ] Test JavaScript functionality built with pnpm
- [ ] Validate accessibility compliance

### 9.3 Security Testing
- [ ] Perform security vulnerability scanning
- [ ] Test file upload security
- [ ] Validate authentication security
- [ ] Test rate limiting effectiveness
- [ ] Verify data privacy compliance
- [ ] Test admin panel security
- [ ] Validate password generation security

## Phase 10: Deployment & Monitoring

### 10.1 Production Setup
- [ ] Configure production environment
- [ ] Set up PostgreSQL database with proper indexing
- [ ] Configure KeyDB for production queue processing
- [ ] Configure file storage (S3/CDN)
- [ ] Set up email service provider
- [ ] Configure queue workers with KeyDB
- [ ] Implement backup strategy for PostgreSQL
- [ ] Run production seeders (timezones, categories)

### 10.2 Monitoring & Analytics
- [ ] Set up application monitoring
- [ ] Configure error tracking
- [ ] Implement performance monitoring
- [ ] Create admin analytics dashboard using PostgreSQL analytics
- [ ] Set up email delivery monitoring
- [ ] Add user activity tracking
- [ ] Monitor queue health

### 10.3 Launch Preparation
- [ ] Run production seeders for categories and timezones
- [ ] Set up admin user accounts (with admin privileges)
- [ ] Configure production email templates
- [ ] Test complete user journey
- [ ] Prepare launch documentation
- [ ] Create user onboarding materials

## Docker Configuration (Services Only)

### docker-compose.yml
```yaml
version: '3.8'

services:
  postgres:
    image: postgres:15
    container_name: laravel-postgres
    restart: unless-stopped
    environment:
      POSTGRES_DB: laravel_dating
      POSTGRES_USER: laravel_user
      POSTGRES_PASSWORD: laravel_password
    volumes:
      - ./docker/postgres:/var/lib/postgresql/data
    ports:
      - 5432:5432
    networks:
      - laravel

  keydb:
    image: eqalpha/keydb:latest
    container_name: laravel-keydb
    restart: unless-stopped
    ports:
      - 6379:6379
    volumes:
      - ./docker/keydb:/data
    networks:
      - laravel

networks:
  laravel:
    driver: bridge
```

## Performance Considerations

### PostgreSQL Optimization
- [ ] Add appropriate indexes for queries
- [ ] Implement database query optimization
- [ ] Set up PostgreSQL connection pooling
- [ ] Configure query caching where appropriate
- [ ] Use PostgreSQL-specific features (JSONB, full-text search)

### File Handling
- [ ] Implement image optimization pipelines
- [ ] Set up CDN for static assets
- [ ] Configure lazy loading for images
- [ ] Implement progressive image loading

### Caching Strategy
- [ ] Configure KeyDB for session storage
- [ ] Implement query result caching
- [ ] Set up view caching for static content
- [ ] Configure API response caching

## Development Workflow

### Local Development Commands
- [ ] Create development scripts:
  - `docker-compose up -d` - Start PostgreSQL and KeyDB
  - `php artisan serve` - Start Laravel development server
  - `pnpm run dev` - Start asset compilation
  - `php artisan queue:work` - Start queue worker
  - `php artisan migrate` - Run database migrations
  - `php artisan db:seed` - Run database seeders

### Environment Setup
- [ ] Document local development setup process
- [ ] Create development environment guide
- [ ] Set up IDE configuration
- [ ] Configure debugging setup

---

## Implementation Timeline Estimate

**Phase 1**: 1-2 weeks (Local Setup & Foundation)
**Phase 2**: 2-3 weeks (User Management)
**Phase 3-4**: 3-4 weeks (Events & Connections)
**Phase 5**: 2-3 weeks (Admin Panel)
**Phase 6-7**: 2-3 weeks (Notifications & Security)
**Phase 8**: 4-5 weeks (Frontend Development)
**Phase 9-10**: 2-3 weeks (Testing & Deployment)

**Total Estimated Timeline**: 16-23 weeks

## Key Development Principles

1. **Laravel Conventions First**: Follow Laravel best practices and conventions
2. **Local Development**: Use php artisan serve for development server
3. **Factory-Driven Development**: Use factories for all models for consistent testing
4. **Environment-Specific Seeding**: Separate production and development seed data
5. **Queue Management**: Use KeyDB for reliable queue processing
6. **PostgreSQL Optimization**: Leverage PostgreSQL-specific features for performance
7. **Secure User Creation**: Generate secure random passwords for non-admin users
8. **Package Management**: Use pnpm for all Node.js dependencies
9. **Security by Design**: Implement security measures from the beginning
10. **Mobile-First UI**: Design with mobile responsiveness as priority
11. **Performance Optimization**: Consider performance implications of all features
12. **Scalability Preparation**: Design for future growth and feature expansion

This implementation plan provides a comprehensive roadmap for building the Event-Based Dating Platform with local PHP development server, Docker services for PostgreSQL and KeyDB only, and all the requested technical specifications.
