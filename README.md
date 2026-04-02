HotelsSearch — Full-Stack Tour Booking Platform
A high-performance SPA for searching and booking holiday packages. Built with a focus on Clean Architecture (Service Layer) and seamless developer experience.

🚀 Tech Stack
Backend: PHP 8.3, Laravel 11 (Service Layer, API Resources, Sanctum)

Frontend: Vue 3 (Composition API), Pinia, Vuetify 3, Vite

Database: MySQL 8, Redis (Cache/Session Management)

Infrastructure: Docker (Laravel Sail), Mailpit, phpMyAdmin

Admin Suite: MoonShine (RBAC, Content Management)

🛠 Key Architectural Features
Service Layer Pattern: Business logic (filtering, searching, booking) is decoupled from Controllers into dedicated Service classes for better maintainability and testing.

Advanced Filtering: Complex Eloquent queries for price ranges, hotel ratings, flight durations, and meal plans.

Reactive SPA: Smooth user experience with Vue 3 and centralized state management via Pinia.

Internationalization: Full RU/EN support using vue-i18n.

📦 Quick Start (Docker)
Ensure you have Docker and Docker Compose installed.

Bash
# 1. Setup environment
cp .env.example .env

# 2. Install dependencies & Start containers
composer install
./vendor/bin/sail up -d

# 3. Initialize Database
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed

# 4. Compile Frontend
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
Access Points:
Application: http://localhost:8080

Admin Panel: /moonshine (Credentials: admin@example.com / password)

Mailpit (Emails): http://localhost:8025

📁 Project Structure
app/Services — Core business logic (The "Brain" of the app).

app/Http/Resources — API transformation layer.

resources/js — Modular Vue 3 frontend.

🧪 Testing
Bash
./vendor/bin/sail artisan test


<img width="1884" height="918" alt="image" src="https://github.com/user-attachments/assets/4ca23185-9b49-472a-b635-7d0b04deb4a7" />
<img width="1884" height="918" alt="image" src="https://github.com/user-attachments/assets/d04fc2c7-24b0-4c06-86a1-b1e478699731" />
