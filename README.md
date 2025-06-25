Organizational Chart Management System

A Laravel-based application for managing organizational hierarchies with positions and reporting structures.


Create, read, update, and delete positions

Define reporting relationships between positions

Form validation for position names and reporting structure


RESTful API endpoints for integration


===============================================
Prerequisites

PHP 8.2 

Composer

MySQL 8.0

Node.js (for frontend assets)

Laravel 10

=========================================
Installation

1. Clone the repository: 

git clone https://github.com/CCC-juls/ASS-PRACTICAL-EXAM
cd ASS-PRACTICAL-EXAM


Install PHP dependencies:
composer install


Install JavaScript dependencies:
npm install


===============================================
Database Setup

1. Run migrations:

php artisan migrate

============================================


Running the Application

1. Start the development server:

php artisan serve

2. Compile frontend assets (in another terminal):
    npm run dev

3. Access the application: 

http://localhost:8000/positions
