# Email Setup - Contact Formulier

## Overzicht

Het contactformulier stuurt automatisch een email naar **alle admin gebruikers** wanneer iemand een bericht verstuurt via het formulier.

## Functionaliteit

### Wat gebeurt er?

1. Bezoeker vult contactformulier in op `/contact`
2. Formulier wordt gevalideerd (client-side + server-side)
3. Bericht wordt opgeslagen in de database (`contact_messages` tabel)
4. Email wordt verstuurd naar alle gebruikers met `is_admin = true`
5. Bezoeker ziet een success melding

### Email Inhoud

De email bevat:
- **Naam** van de afzender
- **Email adres** van de afzender (met reply-to functionaliteit)
- **Onderwerp**
- **Bericht**
- **Ontvangen datum/tijd**
- **Reply knop** - admins kunnen direct reageren

### Email Design

De email heeft een professioneel design met:
- Rocket League branding kleuren
- Responsive layout
- Duidelijke structuur
- Direct reply functionaliteit
- Mobiel vriendelijk

## Email Configuratie

### Vereiste .env Instellingen

Om emails te kunnen versturen moet je email instellingen configureren in je `.env` bestand:

#### Optie 1: Mailtrap (Aanbevolen voor Development)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@rocketleague.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Mailtrap Account:**
1. Ga naar https://mailtrap.io
2. Maak een gratis account aan
3. Kopieer de SMTP credentials
4. Plak deze in je `.env`

#### Optie 2: Gmail (Voor Production)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_gmail@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_gmail@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Gmail Setup:**
1. Ga naar Google Account Settings
2. Schakel 2-factor authenticatie in
3. Genereer een "App Password"
4. Gebruik dit wachtwoord in `MAIL_PASSWORD`

#### Optie 3: Andere SMTP Services

Laravel ondersteunt alle SMTP services:
- **SendGrid**
- **Mailgun**
- **Amazon SES**
- **Postmark**
- En meer...

### Email Testen zonder Echte Verzending

Voor development kun je emails "faken":

```env
MAIL_MAILER=log
```

Dit schrijft emails naar `storage/logs/laravel.log` in plaats van ze te versturen.

## Bestanden

### Mailable Class
**Bestand:** `app/Mail/ContactFormMail.php`

Deze class definieert:
- Subject lijn
- Reply-to adres (automatisch ingesteld op afzender)
- Email view
- Data die naar de view wordt gestuurd

### Email View
**Bestand:** `resources/views/emails/contact-form.blade.php`

De HTML template voor de email met:
- Professionele styling
- Rocket League branding
- Responsive design
- Alle formulier gegevens

### Controller
**Bestand:** `app/Http/Controllers/ContactController.php`

De `store()` method:
1. Valideert het formulier
2. Slaat het bericht op in de database
3. Haalt alle admin email adressen op
4. Verstuurt email naar elke admin
5. Logt success/errors
6. Redirect met success melding

## Admin Email Adressen

### Wie krijgt de emails?

**Alle gebruikers met `is_admin = true` ontvangen de email.**

Je kunt controleren wie admin is via:
```sql
SELECT name, email, is_admin FROM users WHERE is_admin = 1;
```

### Admin Email Wijzigen

Admins kunnen hun eigen email adres wijzigen via:
- Admin Panel → Gebruikers → [Hun Account] → Bewerken
- Of via de database

### Geen Admins?

Als er geen admin gebruikers zijn, wordt de email gestuurd naar het fallback adres:
```env
MAIL_FROM_ADDRESS=admin@example.com
```

## Testing

### Test de Email Functionaliteit

1. **Configureer email** in `.env` (gebruik Mailtrap voor development)

2. **Test het formulier:**
   - Ga naar `/contact`
   - Vul het formulier in
   - Verstuur het bericht

3. **Check de email:**
   - Mailtrap: Bekijk inbox op mailtrap.io
   - Log mode: Check `storage/logs/laravel.log`
   - Gmail: Check inbox

4. **Test Reply:**
   - Open de email
   - Klik op "Reageer op dit bericht"
   - Verify dat het reply-to adres correct is

### Debugging

**Email niet ontvangen?**

1. Check `.env` configuratie
2. Check logs: `storage/logs/laravel.log`
3. Verify admin accounts:
   ```php
   php artisan tinker
   User::where('is_admin', true)->get(['name', 'email'])
   ```
4. Test email connectie:
   ```php
   php artisan tinker
   Mail::raw('Test email', function($message) {
       $message->to('test@example.com')->subject('Test');
   });
   ```

**Error in logs?**

- `Connection refused`: Check MAIL_HOST en MAIL_PORT
- `Authentication failed`: Check MAIL_USERNAME en MAIL_PASSWORD
- `530 Must issue STARTTLS`: Check MAIL_ENCRYPTION (moet 'tls' zijn)

## Features

### ✅ Beveiligingsfuncties

- **XSS Protection**: Alle input wordt ge-escaped in Blade templates
- **CSRF Protection**: `@csrf` token op formulier
- **Input Validatie**: Server-side validatie van alle velden
- **Error Handling**: Errors worden gelogd maar niet getoond aan gebruikers

### ✅ User Experience

- **Success Feedback**: Duidelijke bevestiging na verzenden
- **Error Messages**: Duidelijke foutmeldingen bij validatie
- **Client-side Validatie**: Snelle feedback voor gebruiker
- **Responsive Design**: Werkt op alle devices

### ✅ Admin Experience

- **Professional Email**: Mooie HTML email template
- **Reply Functionaliteit**: Direct reply mogelijk via email client
- **Alle Admins**: Alle admins ontvangen het bericht
- **Timestamp**: Duidelijk wanneer het bericht is verzonden

## Productie Checklist

Voor productie gebruik:

- [ ] Configureer productie email service (Gmail, SendGrid, etc.)
- [ ] Test email verzending op productie server
- [ ] Verify dat alle admins de juiste email adressen hebben
- [ ] Check dat `MAIL_FROM_ADDRESS` een geldig domein email is
- [ ] Test reply functionaliteit
- [ ] Monitor logs voor email errors
- [ ] Overweeg rate limiting op contactformulier
- [ ] Overweeg queue systeem voor email verzending (optioneel)

## Queue Systeem (Optioneel)

Voor betere performance kun je emails in de background versturen:

1. **Installeer Queue:**
   ```bash
   php artisan queue:table
   php artisan migrate
   ```

2. **Update Controller:**
   ```php
   Mail::to($adminEmail)->queue(new ContactFormMail($contactMessage));
   ```

3. **Run Queue Worker:**
   ```bash
   php artisan queue:work
   ```

Dit zorgt ervoor dat de gebruiker geen wachttijd heeft tijdens email verzending.

## Support

Bij problemen:
1. Check `storage/logs/laravel.log`
2. Verify email configuratie
3. Test met Mailtrap eerst
4. Check firewall/network settings

## Changelog

### Versie 1.0
- Initiele implementatie
- Email naar alle admins
- HTML email template
- Reply-to functionaliteit
- Error handling en logging
