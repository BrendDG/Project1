# Rocket League Tracker - Setup Instructies

## Overzicht
Deze applicatie is een Rocket League community website met volledige user authentication en profielpagina functionaliteit.

## Nieuwe Functionaliteit

### Profielpagina
- Elke gebruiker heeft een publieke profielpagina
- Toegankelijk voor iedereen (ook niet-ingelogde gebruikers)
- Ingelogde gebruikers kunnen hun eigen profiel bewerken
- Profielvelden:
  - Username (optioneel)
  - Verjaardag (optioneel)
  - Profielfoto (upload naar webserver)
  - "Over mij" tekst (max 1000 karakters)

### Authentication
- **Login** - Met "remember me" functionaliteit
- **Registratie** - Voor nieuwe gebruikers
- **Wachtwoord vergeten** - Reset via e-mail
- **Logout** - Veilig uitloggen

## Installatie & Setup

### 1. Database migreren
```bash
php artisan migrate:fresh --seed
```

Dit zal:
- Alle tabellen aanmaken
- Test gebruikers aanmaken
- Nieuws items toevoegen
- FAQ items toevoegen

### 2. Storage linken
```bash
php artisan storage:link
```

Dit creëert een symbolic link voor profielfoto uploads.

### 3. Test gebruikers
Na het seeden zijn deze test accounts beschikbaar:

- **Email:** john@example.com - **Password:** password (Volledig profiel)
- **Email:** jane@example.com - **Password:** password (Basis profiel)
- **Email:** bob@example.com - **Password:** password (Minimaal profiel)
- **Email:** test@example.com - **Password:** password (Test account)

## Technische Implementatie

### Layouts
1. **app.blade.php** - Hoofdlayout voor publieke pagina's
2. **auth.blade.php** - Layout voor authentication pagina's

### Controllers
- **ProfileController** - CRUD operaties voor profielen
  - `show()` - Publieke profielweergave
  - `edit()` - Bewerkformulier (alleen voor eigenaar)
  - `update()` - Profiel updaten (alleen voor eigenaar)
- **Auth Controllers**
  - `LoginController` - Login & logout
  - `RegisterController` - Registratie
  - `ForgotPasswordController` - Wachtwoord reset

### Routes
```php
// Publiek toegankelijk
GET  /profile/{user}              - Profielpagina bekijken

// Alleen voor ingelogde gebruikers
GET  /profile/{user}/edit         - Profiel bewerken
PUT  /profile/{user}              - Profiel updaten
POST /logout                      - Uitloggen

// Alleen voor gasten (niet-ingelogde gebruikers)
GET  /login                       - Login pagina
POST /login                       - Login verwerken
GET  /register                    - Registratie pagina
POST /register                    - Registratie verwerken
GET  /forgot-password             - Wachtwoord vergeten
POST /forgot-password             - Reset link versturen
GET  /reset-password/{token}      - Wachtwoord reset formulier
POST /reset-password              - Wachtwoord resetten
```

### Models & Database
- **User model** - Uitgebreid met:
  - `username` (nullable)
  - `birthday` (nullable, date)
  - `profile_photo` (nullable, string)
  - `about_me` (nullable, text)
  - Accessor: `display_name` - Geeft username of name terug
  - Accessor: `profile_photo_url` - Geeft foto URL of default avatar

### Security & Validatie

#### CSRF Protection
Alle formulieren gebruiken `@csrf` token.

#### XSS Protection
- Blade engine escaped automatisch alle output met `{{ }}`
- User input wordt nooit direct gerenderd

#### Authorization
- Gebruikers kunnen alleen hun eigen profiel bewerken
- Check in controller: `auth()->id() !== $user->id` → 403 error

#### Validatie (Server-side)
```php
- name: required, max:255
- username: nullable, max:255, unique
- email: required, email, max:255, unique
- birthday: nullable, date, before:today
- about_me: nullable, max:1000
- profile_photo: nullable, image, mimes:jpeg,png,jpg,gif, max:2048 (KB)
- password: required, min:8, confirmed
```

#### Client-side Validatie
JavaScript validatie op alle formulieren:
- Email format check
- Wachtwoord lengte (min 8 karakters)
- Wachtwoord confirmatie match
- Verjaardag in verleden
- Bestandstype en grootte voor foto upload
- Character counter voor "over mij" tekst

### Components
**alert.blade.php** - Herbruikbaar component voor success/error/warning/info messages

Gebruik:
```blade
<x-alert type="success" message="Profiel opgeslagen!" />
<x-alert type="error">Er ging iets mis</x-alert>
```

## Bestandsstructuur

```
app/
├── Http/
│   └── Controllers/
│       ├── ProfileController.php
│       └── Auth/
│           ├── LoginController.php
│           ├── RegisterController.php
│           └── ForgotPasswordController.php
├── Models/
│   └── User.php

database/
├── migrations/
│   └── 2024_01_01_000008_add_profile_fields_to_users_table.php
└── seeders/
    ├── UserSeeder.php
    └── DatabaseSeeder.php

resources/
└── views/
    ├── layouts/
    │   ├── app.blade.php
    │   └── auth.blade.php
    ├── components/
    │   └── alert.blade.php
    ├── auth/
    │   ├── login.blade.php
    │   ├── register.blade.php
    │   ├── forgot-password.blade.php
    │   └── reset-password.blade.php
    └── profile/
        ├── show.blade.php
        └── edit.blade.php

routes/
└── web.php
```

## Features Checklist

✅ Twee layouts (app.blade.php en auth.blade.php)
✅ Component voor alerts
✅ XSS protection (Blade escaping)
✅ CSRF protection (alle formulieren)
✅ Client-side validatie (JavaScript)
✅ Server-side validatie (Laravel validation)
✅ Routes met controller methods
✅ Routes met middleware (auth, guest)
✅ Routes gegroepeerd
✅ Resource controllers (ProfileController CRUD)
✅ Eloquent models met relaties (User model)
✅ Migrations
✅ Seeders met test data
✅ Authentication (login, logout, register, remember me, password reset)
✅ Publieke profielpagina
✅ Profielbewerkingen (alleen voor eigenaar)
✅ Profielfoto upload
✅ Authorization checks

## Ontwikkeling

### Server starten
```bash
php artisan serve
```

### Test de functionaliteit
1. Ga naar http://localhost:8000
2. Klik op "Registreer" om een nieuw account aan te maken
3. Log in met je account
4. Klik op "Mijn Profiel" in de navigatie
5. Klik op "Profiel bewerken" om je gegevens aan te passen
6. Upload een profielfoto, vul je verjaardag en "over mij" in
7. Bekijk je publieke profiel (ook zichtbaar voor niet-ingelogde gebruikers)

### E-mail configuratie (optioneel)
Voor wachtwoord reset functionaliteit moet je e-mail configureren in `.env`:
```
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@rocketleague.local"
MAIL_FROM_NAME="${APP_NAME}"
```

Voor development kan je Mailhog gebruiken om e-mails te testen.

## Notities
- Profielfoto's worden opgeslagen in `storage/app/public/profile-photos/`
- Default avatar path: `public/default-avatar.png` (plaats hier een standaard avatar afbeelding)
- Maximum upload grootte: 2MB
- Ondersteunde afbeeldingsformaten: JPG, PNG, GIF
