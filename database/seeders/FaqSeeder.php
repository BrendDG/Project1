<?php

namespace Database\Seeders;

use App\Models\FaqCategory;
use App\Models\FaqItem;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Categorie 1: Algemeen
        $algemeen = FaqCategory::create([
            'name' => 'Algemeen',
            'order' => 1,
        ]);

        FaqItem::create([
            'faq_category_id' => $algemeen->id,
            'question' => 'Wat is Rocket League?',
            'answer' => 'Rocket League is een vehicular soccer video game ontwikkeld door Psyonix. Het combineert racen met voetbal, waarbij spelers rocket-powered cars besturen om een bal in het doel van de tegenstander te scoren.',
            'order' => 1,
        ]);

        FaqItem::create([
            'faq_category_id' => $algemeen->id,
            'question' => 'Is Rocket League gratis te spelen?',
            'answer' => 'Ja! Sinds september 2020 is Rocket League gratis te spelen (free-to-play) op alle platforms: PC (Epic Games Store), PlayStation, Xbox, en Nintendo Switch.',
            'order' => 2,
        ]);

        FaqItem::create([
            'faq_category_id' => $algemeen->id,
            'question' => 'Ondersteunt Rocket League cross-platform play?',
            'answer' => 'Ja, Rocket League ondersteunt volledige cross-platform play tussen alle platforms. Je kunt spelen met vrienden ongeacht welk platform zij gebruiken.',
            'order' => 3,
        ]);

        // Categorie 2: Gameplay
        $gameplay = FaqCategory::create([
            'name' => 'Gameplay',
            'order' => 2,
        ]);

        FaqItem::create([
            'faq_category_id' => $gameplay->id,
            'question' => 'Hoe werkt het ranked systeem?',
            'answer' => 'Het ranked systeem in Rocket League bestaat uit verschillende ranks: Bronze, Silver, Gold, Platinum, Diamond, Champion, Grand Champion, en Supersonic Legend. Elk rank heeft drie divisies (I, II, III). Je MMR (Match Making Rating) bepaalt je rank.',
            'order' => 1,
        ]);

        FaqItem::create([
            'faq_category_id' => $gameplay->id,
            'question' => 'Wat zijn aerial shots?',
            'answer' => 'Aerial shots zijn schoten waarbij je met je auto de lucht in vliegt om de bal te raken. Dit is een essentiële vaardigheid om te leren voor competitief spelen.',
            'order' => 2,
        ]);

        FaqItem::create([
            'faq_category_id' => $gameplay->id,
            'question' => 'Hoe leer ik nieuwe mechanics?',
            'answer' => 'De beste manier om nieuwe mechanics te leren is door custom training packs te gebruiken. Je kunt deze vinden in het Training menu. Ook zijn er veel YouTube tutorials beschikbaar.',
            'order' => 3,
        ]);

        // Categorie 3: Technisch
        $technisch = FaqCategory::create([
            'name' => 'Technisch',
            'order' => 3,
        ]);

        FaqItem::create([
            'faq_category_id' => $technisch->id,
            'question' => 'Welke camera instellingen gebruiken pro spelers?',
            'answer' => 'De meeste pro spelers gebruiken een FOV tussen 105-110, Camera Distance tussen 260-280, Camera Height tussen 90-110, en Camera Angle tussen -3 tot -5. Experimenteer om te vinden wat voor jou werkt!',
            'order' => 1,
        ]);

        FaqItem::create([
            'faq_category_id' => $technisch->id,
            'question' => 'Wat zijn de beste controller instellingen?',
            'answer' => 'Veel spelers remappen hun controls voor betere toegang tot boost en powerslide. Populaire setups zijn: Boost op R1/RB, Powerslide en Air Roll op L1/LB. Dit maakt het makkelijker om meerdere acties tegelijk uit te voeren.',
            'order' => 2,
        ]);

        FaqItem::create([
            'faq_category_id' => $technisch->id,
            'question' => 'Hoe kan ik mijn FPS verbeteren?',
            'answer' => 'Om je FPS te verbeteren: verlaag graphics settings, schakel V-Sync uit, sluit background programmas, update je graphics drivers, en overweeg om render quality te verlagen in de video settings.',
            'order' => 3,
        ]);

        // Categorie 4: Items & Trading
        $items = FaqCategory::create([
            'name' => 'Items & Trading',
            'order' => 4,
        ]);

        FaqItem::create([
            'faq_category_id' => $items->id,
            'question' => 'Hoe krijg ik nieuwe items?',
            'answer' => 'Je kunt items krijgen door: de Rocket Pass te kopen, items in de Item Shop te kopen met credits, Tournament Rewards te verdienen, of blueprints te openen.',
            'order' => 1,
        ]);

        FaqItem::create([
            'faq_category_id' => $items->id,
            'question' => 'Is trading nog mogelijk?',
            'answer' => 'Ja, trading is nog steeds mogelijk maar met beperkingen. Je kunt alleen traden met items die je uit drops hebt gekregen of via trading hebt verkregen. Items gekocht uit de Item Shop kunnen niet getraded worden.',
            'order' => 2,
        ]);

        FaqItem::create([
            'faq_category_id' => $items->id,
            'question' => 'Wat is de Rocket Pass?',
            'answer' => 'De Rocket Pass is een seizoensgebonden systeem waarbij je items kunt unlocken door te spelen. Er is een gratis versie en een premium versie. Met de premium versie unlock je exclusieve items en painted variants.',
            'order' => 3,
        ]);
    }
}
