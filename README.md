# exam-1210-app

**Title of Exam:** Simple Task Management  
**Author:** Jaihgi (Jojo) De Jesus  
**Role:** Senior PHP Developer  
**Live URL:** https://jdjportfolio.com/exam-1210-app  

---

## Overview

A Laravel application for managing user-specific tasks. Features include:

- User **authentication** (register, login, logout)  
- **CRUD** operations for tasks scoped to each user  
- **Search**, **filter**, **sort**, **pagination**, and **soft-delete**  
- Cleanup of "trashed" tasks after 30 days using Laravel Scheduler  

Built for evaluation as part of a Senior PHP Developer assessment.

---

## Technology Stack

- **Backend:** Laravel 12
- **Database:** MySQL
- **Frontend:** Blade Templates with Vanilla CSS
- **Development Environment:** Laravel Sail (Docker)
- **Authentication:** Laravel Breeze/Built-in Auth

---

## Features

### User Management
- User registration and login
- Password reset functionality
- User-specific task isolation

### Task Management
- **Create** new tasks with title, description, and status
- **Read** tasks with search and filtering
- **Update** existing tasks
- **Delete** tasks (soft delete to trash)
- **Search** tasks by title
- **Filter** by status (Todo, In Progress, Done)
- **Sort** by title or date created
- **Paginate** results (10-100 items per page)

### Data Management
- Soft delete functionality
- Automatic cleanup of trashed tasks after 30 days
- Task scheduling with Laravel Cron

---

## Development Setup

This project uses **Laravel Sail** (Docker-based) to simplify local development.

### Prerequisites

- **Docker Desktop** (macOS, Windows with WSL2, Linux)
- **Composer** (for initial setup)
- **Git** (for version control)

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/jojo-webdeveloper/exam-1210-app.git
   cd exam-1210-app
   ```

2. **Install Composer dependencies**
   ```bash
   composer install
   ```

3. **Copy environment configuration**
   ```bash
   cp .env.example .env
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Start Laravel Sail**
   ```bash
   ./vendor/bin/sail up -d
   ```

6. **Run database migrations**
   ```bash
   ./vendor/bin/sail artisan migrate
   ```
   *This will set up the two main tables: `users` and `user_tasks`*

7. **Access the application**
   - Open your browser and navigate to: `http://localhost:9001`
   - Register a new account and login to start managing tasks

### Setup up command Commands

```bash
# Start the application
./vendor/bin/sail up -d

# Stop the application  
./vendor/bin/sail down

# Run migrations to setup the database as well the two tables `users` and `user_tasks`
./vendor/bin/sail artisan migrate

```

---

## Database Schema

### Users Table
```sql
- id (Primary Key)
- name (String)
- email (String, Unique)
- password (Hashed)
- email_verified_at (Timestamp)
- created_at, updated_at (Timestamps)
```

### User Tasks Table
```sql
- id (Primary Key)
- parent_id (Foreign Key → id)
- title (String)
- content (Text, Nullable)
- task_status (Enum: todo, inprogress, done)
- publish_status (Enum: draft, published, trashed)
- created_by (Foreign Key → users.id)
- date_created (Timestamp)
- date_updated (Timestamp)
- date_published(Timestamp, Nullable - for publish_status as draft)
- attachment (String, Nullable)
```

---

## Task Scheduler Setup

To enable automatic cleanup of trashed tasks, add this to your cron table:

```bash
# Edit crontab
crontab -e

# Add this line
* * * * * cd /path/to/your/app && ./vendor/bin/php artisan schedule:run >> /dev/null 2>&1
```

---

## Usage Guide

### Getting Started
1. **Register** a new account at `/register`
2. **Login** with your credentials at `/login`
3. **Create** your first task using the "New Task" button
4. **Manage** your tasks using the intuitive interface

### Task Management
- **Search:** Type in the search box to find tasks by title
- **Filter:** Use the status dropdown to filter by task status
- **Sort:** Click on "Title" or "Date Created" column headers to sort
- **Pagination:** Adjust "Per Page" to control how many tasks are displayed
- **Actions:** Use View, Edit, or Trash buttons for each task

### Task Status Options
- **Todo:** Tasks that haven't been started
- **In Progress:** Tasks currently being worked on  
- **Done:** Completed tasks

---

## Project Structure

```
exam-1210-app/
├── app
│   ├── Http
│   │   └── Controllers
│   │       ├── AuthController.php
│   │       ├── RegisterController.php
│   │       └── UserTaskController.php
│   ├── Models
│   │   ├── User.php
│   │   └── UserTask.php
│   ├── Observers
│   │   └── UserTaskObserver.php
│   └── Providers
│       └── AppServiceProvider.php
├── config
├── database
│   ├── database.sqlite
│   ├── factories
│   │   └── UserFactory.php
│   ├── migrations
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   └── 2025_06_11_184538_create_user_task_table.php
│   └── seeders
│       └── DatabaseSeeder.php
├── docker-compose.yml
├── phpstan.neon
├── public
│   ├── css
│   ├── images
│   ├── index.php
├── README.md
├── resources
│   ├── js
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── views
│       ├── layouts
│       │   └── app.blade.php
│       ├── login.blade.php
│       ├── register.blade.php
│       └── user_tasks
│           ├── create.blade.php
│           ├── edit.blade.php
│           ├── index.blade.php
│           └── show.blade.php
├── routes
│   ├── console.php
│   └── web.php
├── storage
└── vite.config.js

```
