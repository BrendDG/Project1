<?php

namespace Database\Seeders;

use App\Models\PrivateMessage;
use App\Models\User;
use Illuminate\Database\Seeder;

class PrivateMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Haal alle gebruikers op
        $users = User::all();

        if ($users->count() < 2) {
            $this->command->info('Niet genoeg gebruikers om berichten te seeden. Minimaal 2 gebruikers nodig.');
            return;
        }

        // Voorbeeldberichten
        $messages = [
            [
                'subject' => 'Welkom bij de Rocket League Community!',
                'message' => "Hallo!\n\nWelkom bij onze Rocket League community. We zijn blij dat je er bij bent.\n\nAls je vragen hebt, aarzel dan niet om een bericht te sturen!\n\nMet vriendelijke groet,\nHet Team",
            ],
            [
                'subject' => 'Tournament aanmelding bevestiging',
                'message' => "Hey!\n\nIk zag dat je je hebt aangemeld voor het aankomende tournament. Succes!\n\nAls je wilt oefenen samen, laat het me weten.\n\nGroeten!",
            ],
            [
                'subject' => 'Training sessie afspraak',
                'message' => "Hallo,\n\nHeb je zin om morgenavond rond 20:00 wat ranked te spelen? Ik wil graag mijn 2v2 rank verbeteren en ik zag dat je ook veel 2v2 speelt.\n\nLaat het me weten!",
            ],
            [
                'subject' => 'Vraag over ranked systeem',
                'message' => "Hey,\n\nIk heb een vraag over het ranked systeem. Hoe vaak wordt de MMR bijgewerkt op het platform?\n\nIk zie dat mijn rank nog niet is geüpdatet terwijl ik gisteren gespeeld heb.\n\nBedankt voor je hulp!",
            ],
            [
                'subject' => 'Bedankt voor de tip!',
                'message' => "Hallo,\n\nIk wilde je even bedanken voor de tip die je me gaf over flip resets. Het heeft echt geholpen!\n\nMijn gameplay is nu veel beter geworden.\n\nMisschien kunnen we snel eens samen spelen?\n\nGroeten!",
            ],
            [
                'subject' => 'Team samenstelling voor tournament',
                'message' => "Hey teammate,\n\nWe moeten nog even overleggen over onze strategie voor het tournament volgende week.\n\nHeb je tijd om morgen te trainen?\n\nLaat me weten wanneer het jou uitkomt!",
            ],
            [
                'subject' => 'Nieuwe game mode idee',
                'message' => "Hallo,\n\nIk had een cool idee voor een custom game mode. Wat dacht je van een Hoops tournament?\n\nIk denk dat veel mensen dat wel leuk zouden vinden.\n\nWat vind jij?\n\nGroet!",
            ],
            [
                'subject' => 'Profiel foto compliment',
                'message' => "Hey!\n\nIk zag je profiel foto en die is echt gaaf! Welke rank ben je nu in 3v3?\n\nMisschien kunnen we samen spelen als je op zoek bent naar een teamgenoot.\n\nGreetz!",
            ],
        ];

        // Maak willekeurige berichten tussen gebruikers
        foreach ($users as $sender) {
            // Selecteer 2-4 willekeurige ontvangers (behalve de verzender zelf)
            $receivers = $users->where('id', '!=', $sender->id)->random(min(4, $users->count() - 1));

            foreach ($receivers as $receiver) {
                // Selecteer een willekeurig bericht
                $messageData = $messages[array_rand($messages)];

                // Maak het bericht
                PrivateMessage::create([
                    'sender_id' => $sender->id,
                    'receiver_id' => $receiver->id,
                    'subject' => $messageData['subject'],
                    'message' => $messageData['message'],
                    'is_read' => rand(0, 1) === 1, // 50% kans op gelezen
                    'read_at' => rand(0, 1) === 1 ? now()->subDays(rand(0, 7)) : null,
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);
            }
        }

        $this->command->info('Private messages succesvol geseeded!');
    }
}
