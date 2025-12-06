<?php

namespace App\Http\Controllers;

use App\Models\PrivateMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of received messages (inbox)
     */
    public function index()
    {
        $messages = Auth::user()
            ->receivedMessages()
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $unreadCount = Auth::user()->unread_messages_count;

        return view('messages.index', compact('messages', 'unreadCount'));
    }

    /**
     * Display sent messages
     */
    public function sent()
    {
        $messages = Auth::user()
            ->sentMessages()
            ->with('receiver')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('messages.sent', compact('messages'));
    }

    /**
     * Show the form for creating a new message
     */
    public function create(Request $request)
    {
        $recipientId = $request->query('to');
        $recipient = null;

        if ($recipientId) {
            $recipient = User::findOrFail($recipientId);
        }

        // Haal alle gebruikers op behalve de ingelogde gebruiker voor de dropdown
        $users = User::where('id', '!=', Auth::id())
            ->orderBy('name')
            ->get();

        return view('messages.create', compact('users', 'recipient'));
    }

    /**
     * Store a newly created message in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id|different:' . Auth::id(),
            'subject' => 'required|string|max:255|min:3',
            'message' => 'required|string|min:10|max:5000',
        ], [
            'receiver_id.required' => 'Selecteer een ontvanger.',
            'receiver_id.exists' => 'De geselecteerde ontvanger bestaat niet.',
            'receiver_id.different' => 'Je kunt geen bericht naar jezelf sturen.',
            'subject.required' => 'Onderwerp is verplicht.',
            'subject.min' => 'Onderwerp moet minimaal 3 karakters bevatten.',
            'subject.max' => 'Onderwerp mag maximaal 255 karakters bevatten.',
            'message.required' => 'Bericht is verplicht.',
            'message.min' => 'Bericht moet minimaal 10 karakters bevatten.',
            'message.max' => 'Bericht mag maximaal 5000 karakters bevatten.',
        ]);

        PrivateMessage::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $validated['receiver_id'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);

        return redirect()
            ->route('messages.index')
            ->with('success', 'Bericht succesvol verzonden!');
    }

    /**
     * Display the specified message
     */
    public function show(PrivateMessage $message)
    {
        // Controleer of de gebruiker gemachtigd is om dit bericht te bekijken
        if ($message->receiver_id !== Auth::id() && $message->sender_id !== Auth::id()) {
            abort(403, 'Je hebt geen toegang tot dit bericht.');
        }

        // Markeer als gelezen als de ontvanger het bericht opent
        if ($message->receiver_id === Auth::id()) {
            $message->markAsRead();
        }

        return view('messages.show', compact('message'));
    }

    /**
     * Remove the specified message from storage
     */
    public function destroy(PrivateMessage $message)
    {
        // Alleen ontvanger of verzender kan het bericht verwijderen
        if ($message->receiver_id !== Auth::id() && $message->sender_id !== Auth::id()) {
            abort(403, 'Je hebt geen toegang tot dit bericht.');
        }

        $message->delete();

        return redirect()
            ->route('messages.index')
            ->with('success', 'Bericht succesvol verwijderd.');
    }

    /**
     * Mark a message as read
     */
    public function markAsRead(PrivateMessage $message)
    {
        // Alleen ontvanger kan bericht markeren als gelezen
        if ($message->receiver_id !== Auth::id()) {
            abort(403, 'Je hebt geen toegang tot dit bericht.');
        }

        $message->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all messages as read
     */
    public function markAllAsRead()
    {
        Auth::user()
            ->receivedMessages()
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return redirect()
            ->route('messages.index')
            ->with('success', 'Alle berichten gemarkeerd als gelezen.');
    }
}
