<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\TextItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BlogPostsTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'nickname' => 'Admin',
                'firstname' => 'Admin',
                'lastname' => 'User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        $files = \App\Models\File::all();

        $posts = [
            [
                'title' => 'Rückblick auf das Sommerlager',
                'content' => 'Das diesjährige Sommerlager war ein voller Erfolg! Wir haben zwei Wochen lang in den Bergen zelten dürfen. Das Wetter spielte meistens mit, und die Wanderungen waren atemberaubend. Highlights waren der Lagerfeuerabend und das Geländespiel. Wir freuen uns schon aufs nächste Jahr!',
            ],
            [
                'title' => 'Anmeldung für das Pfingstlager',
                'content' => 'Die Anmeldung für das kommende Pfingstlager ist ab sofort eröffnet. Wir werden drei Tage in der Region verbringen. Bitte meldet euch so bald wie möglich an, da die Plätze begrenzt sind. Weitere Infos findet ihr im angehängten Flyer.',
            ],
            [
                'title' => 'Unsere neuen Leiter',
                'content' => 'Wir begrüssen herzlich unsere neuen Leiter im Team! Nach erfolgreichem Abschluss des Basiskurses sind sie nun bereit, eigene Gruppen zu übernehmen. Wir wünschen ihnen viel Spass und Erfolg bei ihren neuen Aufgaben.',
            ],
            [
                'title' => 'Waldweihnacht 2025',
                'content' => 'Bald ist es wieder soweit: Unsere traditionelle Waldweihnacht steht vor der Tür. Wir treffen uns am Waldrand für Fackeln, Lieder und heissen Tee. Bringt bitte warme Kleidung und eine Tasse mit.',
            ],
            [
                'title' => 'Samstagnachmittag Aktivitäten',
                'content' => 'Diesen Samstag findet wieder eine spannende Aktivität statt. Ob Schnitzeljagd, Pioniertechnik oder Kochen über dem Feuer – es ist für jeden etwas dabei. Treffpunkt ist wie immer um 14:00 Uhr beim Pfadiheim.',
            ],
            [
                'title' => 'Fundgegenstände vom Wochenende',
                'content' => 'Am letzten Wochenende sind einige Kleidungsstücke liegen geblieben. Darunter eine blaue Jacke, zwei linke Handschuhe und eine Trinkflasche. Die Sachen können am nächsten Samstag vor der Aktivität abgeholt werden.',
            ],
            [
                'title' => 'Neues Material im Magazin',
                'content' => 'Unser Materialwart hat fleissig eingekauft. Wir haben neue Zelte und Kochgeschirr bekommen. Bitte geht sorgfältig damit um, damit wir lange Freude daran haben.',
            ],
            [
                'title' => 'Jubiläumsfeier',
                'content' => 'Unsere Abteilung feiert ihr 50-jähriges Bestehen! Zu diesem Anlass laden wir alle aktiven und ehemaligen Mitglieder, Eltern und Freunde zu einem grossen Fest ein. Es wird Essen, Spiele und eine Ausstellung geben.',
            ],
            [
                'title' => 'Fotos vom Kantonalen Treffen',
                'content' => 'Die Fotos vom Kantonalen Treffen sind jetzt online. Schaut in unsere Galerie, um die tollen Momente noch einmal zu erleben. Danke an alle, die dabei waren!',
            ],
            [
                'title' => 'Wichtige Infos zum Jahresstart',
                'content' => 'Das neue Pfadi-Jahr steht in den Startlöchern. Hier findet ihr alle wichtigen Termine und Infos für das kommende Jahr. Bitte tragt euch die Daten schon mal dick in die Agenda ein.',
            ],
        ];

        foreach ($posts as $index => $postData) {
            $previewImage = $files->isNotEmpty() ? $files->random() : null;

            $blogPost = BlogPost::create([
                'title' => $postData['title'],
                'slug' => Str::slug($postData['title']) . '-' . uniqid(), 
                'published_at' => Carbon::now()->subDays($index * 3), 
                'active' => true,
                'user_id' => $user->id,
                'author' => $user->nickname ?? $user->firstname,
                'preview_image_id' => $previewImage ? $previewImage->id : null,
            ]);
            TextItem::create([
                'title' => '', 
                'body' => '<p class="main-text">' . $postData['content'] . '</p>',
                'blog_post_id' => $blogPost->id,
                'sort' => 0,
            ]);
        }
    }
}
