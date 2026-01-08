# Privébericht Functionaliteit

Deze implementatie biedt een complete privébericht-functionaliteit voor het Laravel project, volledig volgens de technische requirements.

## Overzicht

Gebruikers kunnen:
- Privéberichten sturen naar andere gebruikers
- Ontvangen berichten bekijken in hun inbox
- Verzonden berichten bekijken
- Berichten lezen en als gelezen markeren
- Berichten verwijderen
- Direct berichten sturen vanaf gebruikersprofielen

## Technische Requirements - Checklist

### ✅ Views
- **Twee layouts gebruikt**: `layouts.app` (hoofdlayout) en component-based views
- **Components**: `message-card.blade.php` component voor herbruikbare berichtweergave
- **Control structures**: @if, @foreach, @auth gebruikt in alle views
- **XSS protection**: {{ }} blade syntax overal gebruikt, e() helper voor extra beveiliging
- **CSRF protection**: @csrf token in alle forms
- **Client-side validation**: JavaScript validatie in create.blade.php

### ✅ Routes
- Alle routes gebruiken controller methods (MessageController)
- Middleware toegepast: `auth` middleware voor alle message routes
- Routes gegroepeerd: `Route::middleware('auth')->prefix('messages')->name('messages.')->group()`

### ✅ Controller
- **MessageController** met resource methods:
  - `index()` - Inbox overzicht
  - `sent()` - Verzonden berichten
  - `create()` - Nieuw bericht formulier
  - `store()` - Bericht opslaan
  - `show()` - Bericht bekijken
  - `destroy()` - Bericht verwijderen
  - `markAsRead()` - Bericht markeren als gelezen
  - `markAllAsRead()` - Alle berichten als gelezen

### ✅ Models
- **PrivateMessage model** met Eloquent relaties:
  - `sender()` - belongsTo relatie naar User (Many-to-One)
  - `receiver()` - belongsTo relatie naar User (Many-to-One)
- **User model** uitgebreid met:
  - `sentMessages()` - hasMany relatie (One-to-Many)
  - `receivedMessages()` - hasMany relatie (One-to-Many)

### ✅ Database
- **Migration**: `2024_12_06_000001_create_private_messages_table.php`
  - Bevat alle nodige velden en foreign keys
  - Indexes voor betere performance
- **Seeder**: `PrivateMessageSeeder.php`
  - Genereert realistische test data
  - Toegevoegd aan DatabaseSeeder

### ✅ Authentication
- Login/logout functionaliteit gebruikt (bestaand)
- Remember me functionaliteit (bestaand)
- Registratie (bestaand)
- Wachtwoord reset (bestaand)
- Middleware beschermt alle message routes

## Database Relaties

### One-to-Many Relaties
1. **User -> SentMessages** (One-to-Many)
   - Een gebruiker kan veel berichten versturen
   - `User::sentMessages()` relatie

2. **User -> ReceivedMessages** (One-to-Many)
   - Een gebruiker kan veel berichten ontvangen
   - `User::receivedMessages()` relatie

### Many-to-One Relaties
1. **PrivateMessage -> Sender** (Many-to-One)
   - Veel berichten behoren tot één verzender
   - `PrivateMessage::sender()` relatie

2. **PrivateMessage -> Receiver** (Many-to-One)
   - Veel berichten behoren tot één ontvanger
   - `PrivateMessage::receiver()` relatie

## Bestandsstructuur

```
app/
├── Http/
│   └── Controllers/
│       └── MessageController.php
└── Models/
    ├── PrivateMessage.php
    └── User.php (updated)

database/
├── migrations/
│   └── 2024_12_06_000001_create_private_messages_table.php
└── seeders/
    ├── PrivateMessageSeeder.php
    └── DatabaseSeeder.php (updated)

resources/views/
├── components/
│   └── message-card.blade.php
├── messages/
│   ├── index.blade.php (inbox)
│   ├── sent.blade.php
│   ├── create.blade.php
│   └── show.blade.php
├── profile/
│   └── show.blade.php (updated)
├── players/
│   └── show.blade.php (updated)
└── layouts/
    └── app.blade.php (updated)

routes/
└── web.php (updated)
```

## Features

### 1. Inbox (Ontvangen Berichten)
- Overzicht van alle ontvangen berichten
- Paginatie (15 berichten per pagina)
- Ongelezen berichten badge
- "Markeer alle als gelezen" functionaliteit
- Sortering op datum (nieuwste eerst)

### 2. Verzonden Berichten
- Overzicht van alle verzonden berichten
- Paginatie
- Bekijk naar wie je berichten hebt gestuurd

### 3. Nieuw Bericht
- Dropdown met alle gebruikers (behalve jezelf)
- Onderwerp (3-255 karakters)
- Bericht (10-5000 karakters)
- Client-side validatie met karakter teller
- Server-side validatie
- Pre-filled ontvanger via query parameter (?to=user_id)

### 4. Bericht Bekijken
- Volledige weergave van bericht
- Automatisch markeren als gelezen (voor ontvanger)
- Link naar profiel van verzender/ontvanger
- "Beantwoorden" knop
- "Verwijderen" knop

### 5. Notificaties
- Ongelezen berichten teller in navigatie
- Rode badge met aantal ongelezen berichten
- Real-time updates bij laden van pagina

### 6. Integratie
- "Stuur bericht" knop op gebruikersprofielen
- "Stuur bericht" knop op spelers pagina's
- Direct naar bericht formulier met vooraf geselecteerde ontvanger

## Security Features

### XSS Protection
- Blade escape syntax {{ }} overal gebruikt
- e() helper voor extra beveiliging in oude syntax
- Geen {!! !!} gebruikt zonder sanitization

### CSRF Protection
- @csrf token in alle formulieren
- Automatische verificatie door Laravel middleware

### Authorization
- Alleen ingelogde gebruikers kunnen berichten gebruiken
- Gebruikers kunnen alleen hun eigen berichten bekijken
- Validatie voorkomt berichten naar jezelf

### Validation
- Server-side validatie met custom Nederlandse foutmeldingen
- Client-side validatie voor betere UX
- Input sanitization via Eloquent mass assignment protection

## Routes Overzicht

```php
GET    /messages              -> messages.index        (Inbox)
GET    /messages/sent         -> messages.sent         (Verzonden)
GET    /messages/create       -> messages.create       (Nieuw bericht)
POST   /messages              -> messages.store        (Bericht opslaan)
GET    /messages/{message}    -> messages.show         (Bericht bekijken)
DELETE /messages/{message}    -> messages.destroy      (Bericht verwijderen)
POST   /messages/{message}/mark-as-read                (Markeer als gelezen)
POST   /messages/mark-all-as-read                      (Markeer alle als gelezen)
```

## Database Schema

### private_messages tabel

| Kolom | Type | Beschrijving |
|-------|------|--------------|
| id | bigint | Primary key |
| sender_id | bigint | Foreign key naar users |
| receiver_id | bigint | Foreign key naar users |
| subject | string(255) | Onderwerp |
| message | text | Bericht inhoud |
| is_read | boolean | Gelezen status |
| read_at | timestamp | Wanneer gelezen |
| created_at | timestamp | Aangemaakt op |
| updated_at | timestamp | Bijgewerkt op |

**Indexes:**
- `(receiver_id, is_read)` - Voor snelle ongelezen berichten queries
- `(sender_id, created_at)` - Voor verzonden berichten queries

## Installation & Setup

1. **Run migrations:**
```bash
php artisan migrate
```

2. **Seed test data:**
```bash
php artisan db:seed --class=PrivateMessageSeeder
```

Of reset de hele database:
```bash
php artisan migrate:fresh --seed
```

## Gebruik

1. Log in als gebruiker
2. Klik op "Berichten" in de navigatie
3. Bekijk je inbox of verzonden berichten
4. Klik op "Nieuw bericht" om een bericht te sturen
5. Of ga naar een gebruikersprofiel en klik "Stuur bericht"

## Testing

Test data wordt automatisch aangemaakt via de seeder:
- Willekeurige berichten tussen gebruikers
- Variatie in gelezen/ongelezen status
- Realistische onderwerpen en berichten
- Berichten van de afgelopen 30 dagen

## Code Quality

- **PSR-12** code style
- **Type hints** in alle methods
- **Docblocks** voor alle public methods
- **Descriptive naming** voor variabelen en methods
- **DRY principle** - geen code duplicatie
- **Single Responsibility** - elke method heeft één doel
