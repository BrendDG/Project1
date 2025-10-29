<?php

namespace Database\Seeders;

use App\Models\Nieuws;
use Illuminate\Database\Seeder;

class NieuwsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nieuwsItems = [
            [
                'title' => 'Nieuwe Season 15 Update Gelanceerd',
                'content' => 'Psyonix heeft vandaag Season 15 gelanceerd met een compleet nieuwe Rocket Pass, nieuwe items en spannende gameplay veranderingen. De nieuwe season brengt een futuristisch thema met zich mee en introduceert nieuwe goal explosions en decals.

Belangrijkste nieuwe features:
- Nieuwe arena: Neon Fields (Champions Field remix)
- 70+ nieuwe items in de Rocket Pass
- Nieuwe tournament rewards
- Balans aanpassingen voor competitief spelen
- Bug fixes en performance verbeteringen

De season duurt tot juni en spelers kunnen nu al beginnen met het unlocks van exclusieve rewards door het spelen van online matches.',
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'RLCS 2025 Spring Split Aangekondigd',
                'content' => 'De Rocket League Championship Series (RLCS) heeft officieel de Spring Split 2025 aangekondigd. Het toernooi begint volgende maand en teams uit de hele wereld strijden om een totale prize pool van $2 miljoen.

Dit seizoen zullen 16 teams uit Noord-Amerika, Europa, en andere regio\'s deelnemen aan intense regionale competitions voordat ze zich kwalificeren voor de World Championship.

Belangrijke data:
- Regionale Qualifiers: 15-20 maart
- Group Stage: 1-7 april
- Playoffs: 15-20 april
- World Championship: 1-5 mei

Mis deze spannende competitie niet en volg je favoriete teams!',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Tips: Hoe Verbeter Je Je Aerial Game',
                'content' => 'Een van de belangrijkste vaardigheden in Rocket League is het beheersen van aerial plays. In deze guide delen we praktische tips om je aerial game naar het volgende niveau te tillen.

Stap 1: Training Packs
Begin met de standaard aerial training packs in het spel. Deze helpen je om het gevoel voor boost management en car control in de lucht te ontwikkelen.

Stap 2: Camera Settings
Zorg dat je camera instellingen geoptimaliseerd zijn. De meeste pro spelers gebruiken een FOV tussen 105-110 en een distance van 260-280.

Stap 3: Boost Management
Leer wanneer je wel en niet moet boosten tijdens een aerial. Te veel boosten kan ervoor zorgen dat je voorbij de bal schiet.

Stap 4: Custom Training
Maak gebruik van community-created training packs specifiek voor aerials. Zoek naar packs gemaakt door bekende trainers zoals Poquito of Kevpert.

Met consistente oefening zul je merken dat aerial hits veel natuurlijker aanvoelen!',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Community Spotlight: Best Car Designs van Februari',
                'content' => 'Elke maand showcasen we de beste car designs die de community heeft gemaakt. Deze maand hebben we ongelofelijk creatieve designs gezien!

De winnaar van deze maand is "NeonDreams" met zijn futuristische Octane design dat gebruik maakt van de Interstellar decal gecombineerd met Cristianos wielen.

Runner-ups:
- CyberPunk Fennec door SpeedDemon_420
- Clean White Dominus door MinimalDesign
- Galaxy Breakout door AstroPlayer

Wil jij featured worden in de volgende spotlight? Deel je design op onze Discord server met de hashtag #CarDesign en maak kans om uitgekozen te worden!',
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Patch Notes v2.45: Bug Fixes en Improvements',
                'content' => 'Psyonix heeft een nieuwe patch uitgebracht die verschillende bugs repareert en de algemene gameplay experience verbetert.

Bug Fixes:
- Fixed: Cars konden soms door de vloer vallen in Forbidden Temple
- Fixed: Audio bugs bij bepaalde goal explosions
- Fixed: Party invites werkten niet altijd correct
- Fixed: Replay systeem crashte soms bij lange replays

Improvements:
- Verbeterde server stabiliteit
- Snellere matchmaking in ranked playlists
- UI verbeteringen in het inventory systeem
- Optimalisaties voor betere performance op oudere hardware

Performance Updates:
- Reduced memory usage bij het laden van maps
- Verbeterde frame rates in splitscreen mode

Download de update nu en geniet van een soepelere gameplay ervaring!',
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Nieuwe Items in Item Shop Deze Week',
                'content' => 'De Item Shop is bijgewerkt met nieuwe painted variants en populaire items die lang niet meer beschikbaar waren!

Featured Items deze week:
- Titanium White Octane (ZEER ZELDZAAM!)
- Black Dieci wielen
- Heatwave Black Market Decal
- Dueling Dragons Goal Explosion

Deze items zijn slechts 7 dagen beschikbaar, dus mis deze kans niet als je ze al lang wilde hebben. Painted Octanes verschijnen zelden in de shop!

Verder zijn er ook nieuwe bundles beschikbaar:
- Esports Bundle: Team decals van G2, NRG en Vitality
- Neon Nights Bundle: Complete set met car, wheels en boost
- Championship Bundle: RLCS themed items

Check de shop in-game voor alle beschikbare items en prijzen!',
                'published_at' => now()->subDays(12),
            ],
        ];

        foreach ($nieuwsItems as $item) {
            Nieuws::create($item);
        }
    }
}
