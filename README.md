# Rocket League Community Platform

Een volledige Laravel-gebaseerde community website voor Rocket League spelers met gebruikersbeheer, privéberichten, admin functionaliteit en meer.

## Inhoudsopgave

- [Over het Project](#over-het-project)
- [Features](#features)
- [Technologieën](#technologieën)
- [Installatie](#installatie)
- [Configuratie](#configuratie)
- [Database Setup](#database-setup)
- [Test Accounts](#test-accounts)
- [Documentatie](#documentatie)
- [Project Structuur](#project-structuur)
- [Development](#development)

## Over het Project

Deze applicatie is een community platform voor Rocket League spelers waar gebruikers:
- Profielen kunnen aanmaken en beheren
- Privéberichten kunnen versturen naar andere spelers
- Nieuws en toernooien kunnen volgen
- Contact kunnen opnemen via een contactformulier
- FAQ's kunnen raadplegen

Het platform bevat ook een volledig admin systeem voor gebruikersbeheer.

## Features

### Gebruikersfunctionaliteit
- **Authenticatie**
  - Registratie met email verificatie
  - Login met "Remember me" functionaliteit
  - Wachtwoord reset via email
  - Veilige uitlog functionaliteit

- **Profielbeheer**
  - Publieke profielpagina's
  - Profielfoto upload (max 2MB)
  - Username en verjaardag
  - "Over mij" sectie (max 1000 karakters)
  - Bewerkbare profielen (alleen voor eigenaar)

- **Privéberichten Systeem**
  - Privéberichten versturen naar andere gebruikers
  - Inbox met ongelezen berichten badge
  - Verzonden berichten overzicht
  - Berichten markeren als gelezen
  - Direct berichten sturen vanaf profielpagina's
  - Paginatie en sortering

- **Community Features**
  - Nieuws overzicht
  - Toernooien informatie
  - Commentaar functionaliteit
  - FAQ systeem
  - Contact formulier

### Admin Functionaliteit
- **Admin Dashboard**
  - Statistieken (totaal gebruikers, admins)
  - Recent geregistreerde gebruikers
  - Snelle acties

- **Gebruikersbeheer**
  - Overzicht van alle gebruikers
  - Zoeken en filteren
  - Gebruikers aanmaken/bewerken/verwijderen
  - Admin rechten toekennen/intrekken
  - Bescherming tegen zelf-degradatie

### Beveiliging
- CSRF bescherming op alle formulieren
- XSS bescherming via Blade templating
- Server-side en client-side validatie
- Authorization middleware voor protected routes
- Veilige wachtwoord hashing (bcrypt)
- Admin middleware voor restricted functionaliteit

## Technologieën

- **Backend:** Laravel 12 (PHP 8.2+)
- **Database:** MySQL/MariaDB
- **Frontend:** Blade templating, Vanilla JavaScript
- **CSS:** TailwindCSS
- **Build Tool:** Vite
- **Package Manager:** Composer, NPM

## Installatie

### Vereisten

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/MariaDB
- Git

### Stappen

1. **Clone de repository**
```bash
git clone https://github.com/your-username/project1.git
cd project1
```

2. **Installeer PHP dependencies**
```bash
composer install
```

3. **Installeer Node dependencies**
```bash
npm install
```

4. **Environment configuratie**
```bash
cp .env.example .env
```

5. **Genereer application key**
```bash
php artisan key:generate
```

6. **Configureer database in `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. **Run migrations en seeders**
```bash
php artisan migrate:fresh --seed
```

8. **Link storage voor file uploads**
```bash
php artisan storage:link
```

9. **Build frontend assets**
```bash
npm run build
```

10. **Start development server**
```bash
php artisan serve
```

Bezoek http://localhost:8000 in je browser.

## Configuratie

### Mail Setup (Optioneel)

Voor wachtwoord reset functionaliteit, configureer mail in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@rocketleague.local"
MAIL_FROM_NAME="${APP_NAME}"
```

Voor development kan je [Mailhog](https://github.com/mailhog/MailHog) of [Mailtrap](https://mailtrap.io) gebruiken.

Zie [EMAIL_SETUP.md](EMAIL_SETUP.md) voor gedetailleerde instructies.

## Database Setup

### Migrations

Het project bevat migrations voor:
- Users tabel met profile velden
- Private messages tabel
- Nieuws tabel
- Comments tabel
- Tournaments tabel
- FAQ categories en items
- Contact messages

### Seeders

Na `php artisan db:seed` worden de volgende data aangemaakt:
- Admin gebruiker
- Test gebruikers
- Voorbeeld nieuws items
- FAQ items
- Private messages (voor testing)

## Test Accounts

### Admin Account
```
Username: admin
Email: admin@ehb.be
Wachtwoord: Password!321
```

### Normale Gebruikers
Normale gebruikers kunnen zelf geregistreerd worden via de registratie pagina.

## Documentatie

Het project bevat uitgebreide documentatie in de volgende bestanden:

- **[SETUP.md](SETUP.md)** - Setup instructies en technische details
- **[ADMIN_SYSTEM.md](ADMIN_SYSTEM.md)** - Admin systeem documentatie
- **[PRIVEBERICHT_FUNCTIONALITEIT.md](PRIVEBERICHT_FUNCTIONALITEIT.md)** - Privébericht systeem documentatie
- **[EMAIL_SETUP.md](EMAIL_SETUP.md)** - Email configuratie handleiding

## Project Structuur

```
project1/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   └── AdminController.php
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   ├── RegisterController.php
│   │   │   │   └── ForgotPasswordController.php
│   │   │   ├── MessageController.php
│   │   │   ├── ProfileController.php
│   │   │   └── ...
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── PrivateMessage.php
│       ├── Nieuws.php
│       ├── Comment.php
│       ├── Tournament.php
│       └── ...
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php
│       │   ├── auth.blade.php
│       │   └── admin.blade.php
│       ├── components/
│       │   ├── alert.blade.php
│       │   └── message-card.blade.php
│       ├── admin/
│       ├── auth/
│       ├── messages/
│       ├── profile/
│       └── ...
├── routes/
│   └── web.php
├── public/
└── storage/
```

## Development

### Composer Scripts

Het project bevat handige Composer scripts:

```bash
# Complete setup (install, migrate, seed, build)
composer setup

# Start development servers (PHP, queue, logs, Vite)
composer dev

# Run tests
composer test
```

### Development Server

```bash
# Laravel development server
php artisan serve

# Vite development server (in een aparte terminal)
npm run dev
```

### Database Management

```bash
# Run migrations
php artisan migrate

# Reset database en seed opnieuw
php artisan migrate:fresh --seed

# Run specifieke seeder
php artisan db:seed --class=UserSeeder
```

### Cache Management

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Optimize for production
php artisan optimize
```

## Routes Overzicht

### Publieke Routes
- `/` - Home pagina
- `/nieuws` - Nieuws overzicht
- `/toernooien` - Toernooien
- `/faq` - FAQ
- `/contact` - Contact formulier
- `/profile/{user}` - Publieke profielpagina

### Authenticatie Routes
- `/login` - Login
- `/register` - Registratie
- `/forgot-password` - Wachtwoord vergeten
- `/reset-password/{token}` - Wachtwoord reset

### Protected Routes (ingelogd)
- `/profile/{user}/edit` - Profiel bewerken
- `/messages` - Inbox
- `/messages/sent` - Verzonden berichten
- `/messages/create` - Nieuw bericht
- `/messages/{message}` - Bericht bekijken

### Admin Routes (alleen admins)
- `/admin/dashboard` - Admin dashboard
- `/admin/users` - Gebruikersbeheer
- `/admin/users/create` - Nieuwe gebruiker
- `/admin/users/{user}/edit` - Gebruiker bewerken

## Beveiliging

### Belangrijke Security Features

- **CSRF Protection:** Alle POST/PUT/DELETE requests zijn beschermd
- **XSS Protection:** Automatische output escaping via Blade
- **SQL Injection Protection:** Eloquent ORM met prepared statements
- **Password Hashing:** Bcrypt hashing voor wachtwoorden
- **Authorization:** Middleware voor route bescherming
- **Validation:** Server-side en client-side validatie
- **File Upload Validation:** Type en grootte checks voor uploads

### Best Practices

- Gebruik altijd `{{ }}` syntax in Blade templates
- Gebruik `@csrf` in alle formulieren
- Valideer alle user input server-side
- Gebruik middleware voor authorization checks
- Gebruik Eloquent ORM in plaats van raw queries

## Bronvermeldingen

Dit project maakt gebruik van de volgende frameworks en libraries:
- [Laravel Framework](https://laravel.com) - PHP web application framework
- [TailwindCSS](https://tailwindcss.com) - CSS framework
- [Vite](https://vitejs.dev) - Frontend build tool

Alle code is zelf geschreven volgens de Laravel best practices en documentatie.

## Licentie

Dit project is ontwikkeld voor educatieve doeleinden.

## Contact

Voor vragen of problemen, gebruik het contact formulier op de website of open een issue op GitHub.

---

**Gemaakt met Laravel 12** | [Documentatie](https://laravel.com/docs) | [GitHub](https://github.com/your-username/project1)
