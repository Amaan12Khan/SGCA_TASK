# TaskSync - Workflow & Approval System

## Tech Stack
- PHP 8.3
- Laravel 11
- SQLite (Database)
- Blade Templates (Frontend)

## Setup Steps
1. Install Laragon from laragon.net
2. Clone/copy project to C:\laragon\www\tasksync
3. Open Laragon terminal and run:
   - cd C:\laragon\www\tasksync
   - composer install
   - copy .env.example .env
   - php artisan key:generate
   - php artisan migrate
4. Visit http://tasksync.test

## Features
- Full Task CRUD
- Status Flow: Pending → In Progress → Submitted → Approved/Rejected
- Rejected tasks return to In Progress automatically
- Approved tasks are locked (read-only)
- Overdue tasks highlighted in red with Overdue badge
- Dashboard analytics (Total, Pending, Awaiting, Overdue)
- Input validation (no empty title, no past deadlines)

## Assumptions
- Single admin role manages all approvals
- SQLite used for simplicity and portability
- No authentication required per assignment scope