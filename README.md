# CraftConnect (Lag Artisans)

CraftConnect is a service marketplace platform designed to connect customers with skilled artisans and service providers across Lagos.  
The platform enables users to discover, hire, and manage artisan services through a scalable Laravel-powered backend and an interactive web interface.

> Live Production Name: **Lag Artisans**

---

## 🚀 Features

### User & Artisan Management
- Customer and artisan registration
- Secure authentication and authorization
- Profile management for service providers
- Multi-role access control

### Service Marketplace
- Browse artisan categories and services
- Search and filter artisans
- Service request management
- Dynamic artisan listings

### Booking & Engagement
- Hire artisans directly from the platform
- Customer-artisan communication flow
- Job tracking and management
- Ratings and reviews system

### Promotions & Visibility
- Featured artisan promotions
- Homepage advertisement modules
- Dynamic service highlighting

### Admin Dashboard
- User management
- Artisan verification workflows
- Reports and dispute management
- Platform analytics and controls

### KYC & Verification
- Integrated identity verification workflows
- Secure onboarding process for artisans

---

## 🛠️ Tech Stack

### Backend
- Laravel
- PHP
- REST APIs

### Frontend
- Blade
- JavaScript
- CSS
- HTML

### Database
- MySQL

### Integrations & Tools
- Smile ID
- Paystack
- Postman
- Git & GitHub

---

## 📸 Screenshots

### Homepage
<img width="660" height="340" alt="Screenshot 2026-05-17 100349" src="https://github.com/user-attachments/assets/c04f784a-94e7-4555-8758-6e14f5c24ef8" />


### Artisan Listings
<img width="660" height="340" alt="Screenshot 2026-05-17 100519" src="https://github.com/user-attachments/assets/db10bd5d-9470-4cdb-bc2f-02e638a85d59" />

### Artisan profile
<img width="660" height="340" alt="Screenshot 2026-05-17 100559" src="https://github.com/user-attachments/assets/61d1c855-4768-4fbf-b825-5a1a060d2184" />


---

## ⚙️ Installation

Clone the repository:

```bash
git clone https://github.com/Soburr/craftconnect.git
```

Navigate into the project directory:
```bash   
cd your-repo-name
```
Install backend dependencies:
```bash
composer install
```

Install frontend dependencies:
```bash
npm install
```

Create environment file:
```bash
cp .env.example .env
```

Generate application key:
```bash
php artisan key:generate
```

Run migrations:
```bash
php artisan migrate
```

Start development server:
```bash
php artisan serve
```

Run frontend build:
```bash
npm run dev
