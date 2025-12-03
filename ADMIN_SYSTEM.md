# Admin Systeem - Documentatie

## Overzicht

Het admin systeem is volledig geïmplementeerd en biedt de volgende functionaliteiten:

### Functionaliteiten

1. **Login Systeem**
   - Bezoekers kunnen inloggen via `/login`
   - Alle bezoekers kunnen een nieuwe account aanmaken via `/register`
   - Wachtwoord reset functionaliteit is beschikbaar

2. **User Accounts**
   - Een user account is of een gewone gebruiker, of een admin
   - Admin status wordt bepaald door het `is_admin` veld in de database

3. **Admin Rechten**
   - Enkel admins kunnen andere gebruikers verheffen tot admin
   - Enkel admins kunnen admin rechten van gebruikers afnemen
   - Enkel admins kunnen een nieuwe gebruiker manueel aanmaken
   - Admins kunnen niet zichzelf degraderen als ze de enige admin zijn
   - De laatste admin kan niet verwijderd worden

## Installatie

### 1. Database Migratie

Voer de migrations uit om het `is_admin` veld toe te voegen:

```bash
php artisan migrate
```

### 2. Database Seeding

Voer de seeders uit om een admin gebruiker aan te maken:

```bash
php artisan db:seed
```

Of specifiek alleen de UserSeeder:

```bash
php artisan db:seed --class=UserSeeder
```

### 3. Admin Credentials

Na het seeden is de volgende admin account beschikbaar:

- **Email:** admin@rocketleague.com
- **Wachtwoord:** admin123
- **Rol:** Admin

## Admin Panel Routes

Alle admin routes zijn beschermd met de `admin` middleware en zijn alleen toegankelijk voor gebruikers met admin rechten:

- `/admin/dashboard` - Admin dashboard met statistieken
- `/admin/users` - Overzicht van alle gebruikers
- `/admin/users/create` - Nieuwe gebruiker aanmaken
- `/admin/users/{user}/edit` - Gebruiker bewerken
- `/admin/users/{user}/toggle-admin` - Admin status wijzigen
- `/admin/users/{user}` (DELETE) - Gebruiker verwijderen

## Toegang tot Admin Panel

### Als Bezoeker
1. Navigeer naar `/login`
2. Log in met een admin account
3. In de navigatie verschijnt een gouden "Admin Panel" link
4. Klik hierop om naar het admin dashboard te gaan

### Als Ingelogde Gebruiker
- Als je een admin bent, zie je de "Admin Panel" link in de navigatie (goud gekleurd)
- Klik erop om naar `/admin/dashboard` te gaan

## Technische Implementatie

### Middleware

**File:** `app/Http/Middleware/AdminMiddleware.php`

- Controleert of de gebruiker ingelogd is
- Controleert of de gebruiker admin rechten heeft
- Weigert toegang als de gebruiker geen admin is (403 Forbidden)

### Controller

**File:** `app/Http/Controllers/Admin/AdminController.php`

Bevat alle admin functionaliteit:
- `dashboard()` - Toon dashboard met statistieken
- `users()` - Toon alle gebruikers met zoek- en filterfunctionaliteit
- `createUser()` - Toon formulier voor nieuwe gebruiker
- `storeUser()` - Sla nieuwe gebruiker op
- `editUser()` - Toon formulier voor gebruiker bewerken
- `updateUser()` - Update gebruiker gegevens
- `destroyUser()` - Verwijder gebruiker
- `toggleAdmin()` - Wijzig admin status van gebruiker

### Views

**Admin Layout:** `resources/views/layouts/admin.blade.php`
- Sidebar navigatie
- Admin header met user info
- Flash messages (success/error)
- Responsive design

**Admin Views:**
- `resources/views/admin/dashboard.blade.php` - Dashboard
- `resources/views/admin/users/index.blade.php` - Gebruikers overzicht
- `resources/views/admin/users/create.blade.php` - Nieuwe gebruiker
- `resources/views/admin/users/edit.blade.php` - Gebruiker bewerken

### Database

**Migration:** `database/migrations/2024_11_24_000001_add_is_admin_to_users_table.php`

Voegt het `is_admin` veld toe aan de users tabel:
- Type: boolean
- Default: false
- Positie: na email veld

**Seeder:** `database/seeders/UserSeeder.php`

Bevat een admin gebruiker voor testing.

## Beveiliging

### CSRF Protection
Alle formulieren zijn beschermd met CSRF tokens via `@csrf` directive.

### XSS Protection
Alle output wordt automatisch ge-escaped door Blade's `{{ }}` syntax.

### Client-side Validatie
Alle formulieren hebben JavaScript validatie:
- Email format validatie
- Wachtwoord lengte (minimaal 8 karakters)
- Wachtwoord bevestiging matching
- Verplichte velden

### Server-side Validatie
Alle input wordt gevalideerd in de controller met Laravel's validatie:
- Required fields
- Email format
- Unique constraints (email, username)
- Password confirmation
- Password strength (Laravel Password rules)

### Middleware Protection
- `auth` middleware - Gebruiker moet ingelogd zijn
- `admin` middleware - Gebruiker moet admin zijn
- Routes zijn gegroepeerd met beide middleware

## Features

### Dashboard
- Totaal aantal gebruikers
- Aantal admins
- Aantal normale gebruikers
- Recent geregistreerde gebruikers (laatste 5)
- Snelle acties (nieuwe gebruiker, alle gebruikers)

### Gebruikers Beheer
- Overzicht van alle gebruikers in tabel format
- Zoeken op naam, email of username
- Filteren op rol (alle/admins/gebruikers)
- Paginatie (15 per pagina)
- Acties per gebruiker:
  - 👁️ Profiel bekijken
  - ✏️ Bewerken
  - ⬆️/⬇️ Admin status wijzigen
  - 🗑️ Verwijderen

### Gebruiker Aanmaken
- Naam (verplicht)
- Username (optioneel)
- Email (verplicht, uniek)
- Wachtwoord (verplicht, minimaal 8 karakters)
- Wachtwoord bevestiging (verplicht)
- Admin rechten checkbox
- Client-side en server-side validatie
- Real-time wachtwoord match indicator

### Gebruiker Bewerken
- Alle velden kunnen aangepast worden
- Wachtwoord is optioneel (laat leeg om te behouden)
- Admin rechten kunnen gewijzigd worden
- Bescherming tegen zelf-degradatie (als enige admin)
- Kan niet jezelf verwijderen
- Gebruiker informatie sectie (ID, registratie datum, laatste update)
- Link naar publiek profiel

### Veiligheidsmaatregelen
1. **Laatste Admin Bescherming**
   - Je kunt jezelf niet degraderen als je de enige admin bent
   - De laatste admin kan niet verwijderd worden

2. **Zelf-verwijdering Preventie**
   - Je kunt jezelf niet verwijderen als admin

3. **Confirmatie Dialogen**
   - Bij het wijzigen van admin status
   - Bij het verwijderen van een gebruiker
   - Bij het degraderen van jezelf

## Relaties Vereisten

Het systeem voldoet aan de volgende requirements:

### ✅ Standaard Functionaliteiten
- ✅ Log in/out
- ✅ 'Remember me'
- ✅ Registreer
- ✅ Wachtwoord reset

### ✅ Views
- ✅ Twee layouts gebruikt (app.blade.php en admin.blade.php)
- ✅ Component gebruikt (alert component)
- ✅ Control structures (if/else, foreach, loops)
- ✅ XSS protection (via {{ }} syntax)
- ✅ CSRF protection (@csrf directive)
- ✅ Client-side validation (JavaScript)

### ✅ Routes
- ✅ Alle routes gebruiken controller methods
- ✅ Routes zijn gegroepeerd (admin routes group)
- ✅ Middleware gebruikt (auth, admin)

### ✅ Controller
- ✅ AdminController voor logica opsplitsing
- ✅ Resource controller pattern voor CRUD operaties

### ✅ Models
- ✅ User model met Eloquent
- ✅ is_admin boolean veld
- ✅ isAdmin() helper method

### ✅ Database
- ✅ Migrations werken met `php artisan migrate:fresh --seed`
- ✅ Seeders bevatten basisdata (admin user)
- ✅ .env file wordt gebruikt voor database connectie

## Testing

### Test Admin Account
```
Email: admin@rocketleague.com
Wachtwoord: admin123
```

### Test Normale Gebruikers
```
Email: john@example.com
Wachtwoord: password

Email: jane@example.com
Wachtwoord: password

Email: bob@example.com
Wachtwoord: password
```

## Troubleshooting

### Probleem: Kan niet inloggen als admin
**Oplossing:** Zorg dat de database is ge-seed:
```bash
php artisan db:seed --class=UserSeeder
```

### Probleem: 403 Forbidden bij admin routes
**Oplossing:** Zorg dat je ingelogd bent als een gebruiker met `is_admin = 1` in de database.

### Probleem: Middleware not found
**Oplossing:** Zorg dat de middleware is geregistreerd in `bootstrap/app.php`.

### Probleem: CSRF token mismatch
**Oplossing:** Clear de cache:
```bash
php artisan cache:clear
php artisan config:clear
```

## Uitbreidingsmogelijkheden

Het systeem kan eenvoudig uitgebreid worden met:
- Bulk acties (meerdere gebruikers tegelijk bewerken/verwijderen)
- Export functionaliteit (CSV, Excel)
- Gebruikersrollen (niet alleen admin/gebruiker, maar ook moderator, etc.)
- Activiteiten log (wie heeft wat gewijzigd)
- Email notificaties bij account wijzigingen
- Two-factor authentication
- API endpoints voor admin functionaliteit
- Geavanceerde filters en sortering
