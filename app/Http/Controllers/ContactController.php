<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\User;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Display the contact form
     */
    public function index()
    {
        return view('contact.index');
    }

    /**
     * Handle the contact form submission
     */
    public function store(Request $request)
    {
        // Server-side validatie
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:5000',
        ], [
            'name.required' => 'Naam is verplicht',
            'email.required' => 'Email is verplicht',
            'email.email' => 'Email moet een geldig email adres zijn',
            'subject.required' => 'Onderwerp is verplicht',
            'message.required' => 'Bericht is verplicht',
            'message.min' => 'Bericht moet minimaal 10 karakters bevatten',
        ]);

        // XSS Protection via mass assignment (fillable in model)
        $contactMessage = ContactMessage::create($validated);

        // Probeer email te versturen naar alle admins
        try {
            // Haal alle admin email adressen op
            $adminEmails = User::where('is_admin', true)
                ->pluck('email')
                ->toArray();

            // Als er geen admins zijn, gebruik fallback email
            if (empty($adminEmails)) {
                $adminEmails = [config('mail.from.address', 'admin@example.com')];
            }

            // Verstuur email naar alle admins
            foreach ($adminEmails as $adminEmail) {
                Mail::to($adminEmail)->send(new ContactFormMail($contactMessage));
            }

            Log::info('Contact form email sent to admins', [
                'contact_message_id' => $contactMessage->id,
                'admin_count' => count($adminEmails)
            ]);
        } catch (\Exception $e) {
            // Log de error maar toon geen error aan gebruiker
            Log::error('Failed to send contact email: ' . $e->getMessage());
        }

        // Redirect met success bericht
        return redirect()->route('contact.index')
            ->with('success', 'Bedankt voor je bericht! We nemen zo snel mogelijk contact met je op.');
    }
}
