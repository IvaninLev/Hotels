# HotelsSearch — Full-Stack Tour Booking Platform

Single Page Application for discovering and booking holiday packages. Built with Clean Architecture, a dedicated service layer, and an optimized DX.

## Tech Stack
- Backend: PHP 8.4, Laravel 12 (Sail), Sanctum, API Resources
- Frontend: Vue 3 (Composition API), Pinia, Vuetify 3, Vite
- Data: MySQL 8, Redis
- Infra: Docker / Laravel Sail, Mailpit, phpMyAdmin
- Admin: MoonShine (RBAC, content management)

## Architecture Highlights
- Service Layer Pattern: business logic in `app/Services` (e.g., `TourService`) decoupled from controllers.
- Advanced Filtering: price ranges, hotel ratings, flight durations, nutrition types, amenities.
- Reactive SPA: Vue 3 + Pinia for synchronized state.
- Internationalization: RU/EN via `vue-i18n`.
- Clean API/Frontend split for scalability and maintainability.

## Quick Start (Docker / Laravel Sail)
make install-node-packages
make start

Local access:
- App: http://localhost:8080
- Admin: http://localhost:8080/moonshine (User: admin@example.com / Pass: password)
- Mailpit: http://localhost:8025
- phpMyAdmin: http://localhost:8090 (Host: mysql, User: root, Pass: password)

## Quality Assurance
```bash
./vendor/bin/sail artisan test
```

## Demo Flow
Browse `/hotels`, `/tour-selection`, `/news`, and `/reviews` for an end-to-end experience.

## Screenshots
<img width="1884" height="918" alt="Hotels list" src="https://github.com/user-attachments/assets/4ca23185-9b49-472a-b635-7d0b04deb4a7" />
<img width="1884" height="918" alt="Tour details" src="https://github.com/user-attachments/assets/d04fc2c7-24b0-4c06-86a1-b1e478699731" />
