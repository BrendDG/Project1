<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
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

        // Probeer email te versturen naar admin
        try {
            // Check of MAIL_FROM_ADDRESS is ingesteld in .env
            $adminEmail = config('mail.from.address', 'admin@example.com');

            Mail::raw(
                "Nieuw contactbericht ontvangen:\n\n" .
                "Naam: {$validated['name']}\n" .
                "Email: {$validated['email']}\n" .
                "Onderwerp: {$validated['subject']}\n\n" .
                "Bericht:\n{$validated['message']}\n\n" .
                "---\n" .
                "Dit bericht werd verstuurd via het contactformulier op " . config('app.url'),
                function ($message) use ($validated, $adminEmail) {
                    $message->to($adminEmail)
                        ->subject('Nieuw contactbericht: ' . $validated['subject'])
                        ->from($validated['email'], $validated['name']);
                }
            );
        } catch (\Exception $e) {
            // Log de error maar toon geen error aan gebruiker
            Log::error('Failed to send contact email: ' . $e->getMessage());
        }

        // Redirect met success bericht
        return redirect()->route('contact.index')
            ->with('success', 'Bedankt voor je bericht! We nemen zo snel mogelijk contact met je op.');
    }
}
