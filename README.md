# HotelsSearch — Full-Stack Tour Booking Platform

A comprehensive Single Page Application for discovering and booking holiday packages. Built with focus on Clean Architecture, dedicated service layers, and scalability.

## 🛠 Tech Stack
- **Backend:** PHP 8.3+, Laravel 12 (Sail), Sanctum, API Resources
- **Frontend:** Vue 3 (Composition API), Pinia, Vuetify 3, Vite
- **Admin Panel:** MoonShine (RBAC, Content Management)
- **Database & Cache:** MySQL 8, Redis
- **Infra:** Docker (Laravel Sail), Mailpit, phpMyAdmin

## 🏗 Architecture Highlights
- **Service Layer Pattern:** All business logic (pricing logic, tour selection) resides in `app/Services`, keeping Controllers thin and maintainable.
- **Advanced Filtering:** Complex filtering system for price ranges, hotel ratings, flight durations, and amenities.
- **Reactive State:** Vue 3 + Pinia ensures synchronized data across the entire SPA.
- **i18n:** Multi-language support (RU/EN) via `vue-i18n`.

## 📦 Quick Start (Local Setup)

1. **Environment:**
   bash
   cp .env.example .env
Build & Install:

Bash
make up
make install-node-packages
make refresh
Launch:

Bash
make start
🔗 Local Access Points
App: http://localhost:8080

Admin: /moonshine (admin@example.com / password)

Mailpit: http://localhost:8025

Database: phpMyAdmin at :8090 (Host: mysql, User: root)
## Demo Flow
Browse `/hotels`, `/tour-selection`, `/news`, and `/reviews` for an end-to-end experience.

## Screenshots
<img width="1884" height="918" alt="Hotels list" src="https://github.com/user-attachments/assets/4ca23185-9b49-472a-b635-7d0b04deb4a7" />
<img width="1884" height="918" alt="Tour details" src="https://github.com/user-attachments/assets/d04fc2c7-24b0-4c06-86a1-b1e478699731" />
