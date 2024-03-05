<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('questions')->delete();
        
        \DB::table('questions')->insert(array (
            0 => 
            array (
                'id' => 2,
                'question' => 'Was mache ich in der Pfadi?',
                'answer' => '<p class="main-text">Pfadi ist Abwechslung pur. Hauptsächlich in der Natur geht es darum, gemeinsam mit Freunden Abenteuer zu erleben und Spass zu haben. Dabei lernt mal allerhand!</p><p class="main-text">Unter anderem gehören folgende Aktivitäten zu den Klassikern: Schnitzeljagd, Kochen, Basteln, Geländespiele, Wanderungen, Outdoor-Technik, Erste Hilfe und auch Sport. Dabei stehen gemeinsame Erfahrungen und Erfolge in der Gruppe im Vordergrund.</p>',
                'sort' => 0,
                'open' => 0,
                'faq_id' => 1,
                'created_at' => '2024-03-05 17:12:29',
                'updated_at' => '2024-03-05 17:12:29',
            ),
            1 => 
            array (
                'id' => 3,
                'question' => 'Muss ich jeden Samstag in die Pfadi?',
                'answer' => '<p class="main-text">Nein, aber die Leitenden sind sehr froh, wenn eine Abwesenheit im Voraus gemeldet wird. Und natürlich ist es für das Gruppengefühl toller, wenn du möglichst oft dabei bist.</p>',
                'sort' => 1,
                'open' => 0,
                'faq_id' => 1,
                'created_at' => '2024-03-05 17:12:29',
                'updated_at' => '2024-03-05 17:12:29',
            ),
            2 => 
            array (
                'id' => 4,
                'question' => 'Ich habe eine Frage, die nicht aufgeführt ist!',
            'answer' => '<p class="main-text"><span style="color: rgb(51, 51, 51)">Wenn du eine weitere Frage hast, dann kannst du dich an dein Leitungsteam oder via </span>Kontaktformular<span style="color: rgb(51, 51, 51)"> direkt an die Pfadi Lagom wenden. Wir finden sicher eine Antwort.</span></p>',
                'sort' => 2,
                'open' => 0,
                'faq_id' => 1,
                'created_at' => '2024-03-05 17:12:29',
                'updated_at' => '2024-03-05 17:12:50',
            ),
            3 => 
            array (
                'id' => 8,
                'question' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr?',
                'answer' => '<p class="main-text">Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo</p>',
                'sort' => 0,
                'open' => 0,
                'faq_id' => 2,
                'created_at' => '2024-03-05 19:30:34',
                'updated_at' => '2024-03-05 19:32:02',
            ),
            4 => 
            array (
                'id' => 9,
                'question' => 'Frage 2',
                'answer' => '<p class="main-text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo:</p><ul class="list-disc pl-6"><li><p class="main-text">eleifend </p></li><li><p class="main-text">option </p></li><li><p class="main-text">congue </p></li><li><p class="main-text">nihil</p></li></ul>',
                'sort' => 1,
                'open' => 0,
                'faq_id' => 2,
                'created_at' => '2024-03-05 19:30:34',
                'updated_at' => '2024-03-05 19:30:34',
            ),
        ));
        
        
    }
}