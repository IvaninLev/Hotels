HotelsSearch — Full-Stack Tour Booking Platform
A high-performance Single Page Application (SPA) for discovering and booking holiday packages. Engineered with Clean Architecture principles, a dedicated Service Layer, and a streamlined Developer Experience (DX).

# Tech Stack
Backend: PHP 8.4 (Sail runtime), Laravel 12, API Resources, Sanctum (Auth)

Frontend: Vue 3 (Composition API), Pinia (State Management), Vuetify 3, Vite

Database: MySQL 8, Redis (Caching & Sessions)

Infrastructure: Docker (Laravel Sail), Mailpit (SMTP Testing), phpMyAdmin

Admin Panel: MoonShine (RBAC, Content Management)

# Key Architectural Features
Service Layer Pattern: Business logic for search, filtering, and booking is decoupled from controllers and encapsulated in app/Services (e.g., TourService).

Advanced Filtering: Complex Eloquent queries handling price ranges, hotel ratings, flight durations, nutrition types, and amenities.

Reactive SPA: Seamless UX powered by Vue 3 + Pinia for centralized state synchronization.

Internationalization (i18n): Full RU/EN localization support via vue-i18n.

Separation of Concerns: Clean API/Frontend split, making the codebase scalable and maintainable.

# Quick Start (Docker / Laravel Sail)
Prerequisites: Docker & Docker Compose.

Bash
# Setup
cp .env.example .env

composer install
./vendor/bin/sail up -d

./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed

./vendor/bin/sail npm install
./vendor/bin/sail npm run dev -- --host
Local Access Points:
App: http://localhost:8080

Admin: http://localhost:8080/moonshine (User: admin@example.com / Pass: password)

Mailpit: http://localhost:8025

phpMyAdmin: http://localhost:8090 (Host: mysql, User: root, Pass: password)

# Project Structure
app/Services — The core business logic (The "Brain" of the app).

app/Http/Resources — API transformation layer for consistent JSON responses.

resources/js — Modular Frontend architecture with Vue 3.

 # Quality Assurance
Bash./vendor/bin/sail artisan test
# Notes for Recruiters
Demo Flow: Please check /hotels, /tour-selection, /news, and /reviews for a complete end-to-end experience.

<img width="1884" height="918" alt="image" src="https://github.com/user-attachments/assets/4ca23185-9b49-472a-b635-7d0b04deb4a7" />
<img width="1884" height="918" alt="image" src="https://github.com/user-attachments/assets/d04fc2c7-24b0-4c06-86a1-b1e478699731" />
