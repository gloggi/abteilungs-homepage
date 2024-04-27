<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validierungssprachzeilen
    |--------------------------------------------------------------------------
    |
    | Die folgenden Sprachzeilen enthalten die Standardfehlermeldungen, die von
    | der Validator-Klasse verwendet werden. Einige dieser Regeln haben mehrere Versionen,
    | wie die Grössenregeln. Fühlen Sie sich frei, jede dieser Nachrichten hier anzupassen.
    |
    */

    'accepted' => 'Das :attribute muss akzeptiert werden.',
    'accepted_if' => 'Das :attribute muss akzeptiert werden, wenn :other :value ist.',
    'active_url' => 'Das :attribute muss eine gültige URL sein.',
    'after' => 'Das :attribute muss ein Datum nach dem :date sein.',
    'after_or_equal' => 'Das :attribute muss ein Datum nach dem oder gleich dem :date sein.',
    'alpha' => 'Das :attribute darf nur Buchstaben enthalten.',
    'alpha_dash' => 'Das :attribute darf nur Buchstaben, Zahlen, Bindestriche und Unterstriche enthalten.',
    'alpha_num' => 'Das :attribute darf nur Buchstaben und Zahlen enthalten.',
    'array' => 'Das :attribute muss ein Array sein.',
    'ascii' => 'Das :attribute darf nur einbyte alphanumerische Zeichen und Symbole enthalten.',
    'before' => 'Das :attribute muss ein Datum vor dem :date sein.',
    'before_or_equal' => 'Das :attribute muss ein Datum vor oder gleich dem :date sein.',
    'between' => [
        'array' => 'Das :attribute muss zwischen :min und :max Elemente haben.',
        'file' => 'Das :attribute muss zwischen :min und :max Kilobytes gross sein.',
        'numeric' => 'Das :attribute muss zwischen :min und :max liegen.',
        'string' => 'Das :attribute muss zwischen :min und :max Zeichen lang sein.',
    ],
    'boolean' => 'Das :attribute Feld muss wahr oder falsch sein.',
    'can' => 'Das :attribute Feld enthält einen unzulässigen Wert.',
    'confirmed' => 'Die :attribute Bestätigung stimmt nicht überein.',
    'current_password' => 'Das Passwort ist falsch.',
    'date' => 'Das :attribute muss ein gültiges Datum sein.',
    'date_equals' => 'Das :attribute muss ein Datum gleich :date sein.',
    'date_format' => 'Das :attribute muss dem Format :format entsprechen.',
    'decimal' => 'Das :attribute muss :decimal Dezimalstellen haben.',
    'declined' => 'Das :attribute muss abgelehnt werden.',
    'declined_if' => 'Das :attribute muss abgelehnt werden, wenn :other :value ist.',
    'different' => 'Das :attribute und :other müssen unterschiedlich sein.',
    'digits' => 'Das :attribute muss :digits Ziffern sein.',
    'digits_between' => 'Das :attribute muss zwischen :min und :max Ziffern liegen.',
    'dimensions' => 'Das :attribute hat ungültige Bildabmessungen.',
    'distinct' => 'Das :attribute Feld hat einen doppelten Wert.',
    'doesnt_end_with' => 'Das :attribute darf nicht mit einem der folgenden enden: :values.',
    'doesnt_start_with' => 'Das :attribute darf nicht mit einem der folgenden beginnen: :values.',
    'email' => 'Das :attribute muss eine gültige E-Mail-Adresse sein.',
    'ends_with' => 'Das :attribute muss mit einem der folgenden enden: :values.',
    'enum' => 'Das ausgewählte :attribute ist ungültig.',
    'exists' => 'Das ausgewählte :attribute ist ungültig.',
    'extensions' => 'Das :attribute muss eine der folgenden Erweiterungen haben: :values.',
    'file' => 'Das :attribute muss eine Datei sein.',
    'filled' => 'Das :attribute Feld muss einen Wert haben.',
    'gt' => [
        'array' => 'Das :attribute muss mehr als :value Elemente haben.',
        'file' => 'Das :attribute muss grösser als :value Kilobytes sein.',
        'numeric' => 'Das :attribute muss grösser als :value sein.',
        'string' => 'Das :attribute muss grösser als :value Zeichen sein.',
    ],
    'gte' => [
        'array' => 'Das :attribute muss :value oder mehr Elemente haben.',
        'file' => 'Das :attribute muss grösser oder gleich :value Kilobytes sein.',
        'numeric' => 'Das :attribute muss grösser oder gleich :value sein.',
        'string' => 'Das :attribute muss grösser oder gleich :value Zeichen sein.',
    ],
    'hex_color' => 'Das :attribute muss eine gültige Hexadezimalfarbe sein.',
    'image' => 'Das :attribute muss ein Bild sein.',
    'in' => 'Das ausgewählte :attribute ist ungültig.',
    'in_array' => 'Das :attribute Feld muss in :other vorhanden sein.',
    'integer' => 'Das :attribute muss eine ganze Zahl sein.',
    'ip' => 'Das :attribute muss eine gültige IP-Adresse sein.',
    'ipv4' => 'Das :attribute muss eine gültige IPv4-Adresse sein.',
    'ipv6' => 'Das :attribute muss eine gültige IPv6-Adresse sein.',
    'json' => 'Das :attribute muss eine gültige JSON-Zeichenkette sein.',
    'lowercase' => 'Das :attribute muss in Kleinbuchstaben sein.',
    'lt' => [
        'array' => 'Das :attribute muss weniger als :value Elemente haben.',
        'file' => 'Das :attribute muss weniger als :value Kilobytes sein.',
        'numeric' => 'Das :attribute muss kleiner als :value sein.',
        'string' => 'Das :attribute muss weniger als :value Zeichen sein.',
    ],
    'lte' => [
        'array' => 'Das :attribute darf nicht mehr als :value Elemente haben.',
        'file' => 'Das :attribute muss kleiner oder gleich :value Kilobytes sein.',
        'numeric' => 'Das :attribute muss kleiner oder gleich :value sein.',
        'string' => 'Das :attribute muss kleiner oder gleich :value Zeichen sein.',
    ],
    'mac_address' => 'Das :attribute muss eine gültige MAC-Adresse sein.',
    'max' => [
        'array' => 'Das :attribute darf nicht mehr als :max Elemente haben.',
        'file' => 'Das :attribute darf nicht grösser als :max Kilobytes sein.',
        'numeric' => 'Das :attribute darf nicht grösser als :max sein.',
        'string' => 'Das :attribute darf nicht mehr als :max Zeichen sein.',
    ],
    'max_digits' => 'Das :attribute darf nicht mehr als :max Ziffern haben.',
    'mimes' => 'Das :attribute muss eine Datei des Typs sein: :values.',
    'mimetypes' => 'Das :attribute muss eine Datei des Typs sein: :values.',
    'min' => [
        'array' => 'Das :attribute muss mindestens :min Elemente haben.',
        'file' => 'Das :attribute muss mindestens :min Kilobytes sein.',
        'numeric' => 'Das :attribute muss mindestens :min sein.',
        'string' => 'Das :attribute muss mindestens :min Zeichen sein.',
    ],
    'min_digits' => 'Das :attribute muss mindestens :min Ziffern haben.',
    'missing' => 'Das :attribute Feld muss fehlen.',
    'missing_if' => 'Das :attribute Feld muss fehlen, wenn :other :value ist.',
    'missing_unless' => 'Das :attribute Feld muss fehlen, es sei denn, :other ist :value.',
    'missing_with' => 'Das :attribute Feld muss fehlen, wenn :values vorhanden ist.',
    'missing_with_all' => 'Das :attribute Feld muss fehlen, wenn alle :values vorhanden sind.',
    'multiple_of' => 'Das :attribute muss ein Vielfaches von :value sein.',
    'not_in' => 'Das ausgewählte :attribute ist ungültig.',
    'not_regex' => 'Das Format des :attribute ist ungültig.',
    'numeric' => 'Das :attribute muss eine Zahl sein.',
    'password' => [
        'letters' => 'Das :attribute muss mindestens einen Buchstaben enthalten.',
        'mixed' => 'Das :attribute muss mindestens einen Grossbuchstaben und einen Kleinbuchstaben enthalten.',
        'numbers' => 'Das :attribute muss mindestens eine Zahl enthalten.',
        'symbols' => 'Das :attribute muss mindestens ein Symbol enthalten.',
        'uncompromised' => 'Das angegebene :attribute ist in einem Datenleck erschienen. Bitte wählen Sie ein anderes :attribute.',
    ],
    'present' => 'Das :attribute Feld muss vorhanden sein.',
    'present_if' => 'Das :attribute Feld muss vorhanden sein, wenn :other :value ist.',
    'present_unless' => 'Das :attribute Feld muss vorhanden sein, es sei denn, :other ist in :values.',
    'present_with' => 'Das :attribute Feld muss vorhanden sein, wenn :values vorhanden ist.',
    'present_with_all' => 'Das :attribute Feld muss vorhanden sein, wenn alle :values vorhanden sind.',
    'prohibited' => 'Das :attribute Feld ist verboten.',
    'prohibited_if' => 'Das :attribute Feld ist verboten, wenn :other :value ist.',
    'prohibited_unless' => 'Das :attribute Feld ist verboten, es sei denn, :other ist in :values.',
    'prohibits' => 'Das :attribute Feld verbietet, dass :other vorhanden ist.',
    'regex' => 'Das Format von :attribute ist ungültig.',
    'required' => 'Das :attribute Feld ist erforderlich.',
    'required_array_keys' => 'Das :attribute Feld muss Einträge für: :values enthalten.',
    'required_if' => 'Das :attribute Feld ist erforderlich, wenn :other :value ist.',
    'required_if_accepted' => 'Das :attribute Feld ist erforderlich, wenn :other akzeptiert wird.',
    'required_unless' => 'Das :attribute Feld ist erforderlich, es sei denn, :other ist in :values.',
    'required_with' => 'Das :attribute Feld ist erforderlich, wenn :values vorhanden ist.',
    'required_with_all' => 'Das :attribute Feld ist erforderlich, wenn alle :values vorhanden sind.',
    'required_without' => 'Das :attribute Feld ist erforderlich, wenn :values nicht vorhanden ist.',
    'required_without_all' => 'Das :attribute Feld ist erforderlich, wenn keiner der :values vorhanden ist.',
    'same' => 'Das :attribute und :other müssen übereinstimmen.',
    'size' => [
        'array' => 'Das :attribute muss :size Elemente enthalten.',
        'file' => 'Das :attribute muss :size Kilobytes sein.',
        'numeric' => 'Das :attribute muss :size sein.',
        'string' => 'Das :attribute muss :size Zeichen lang sein.',
    ],
    'starts_with' => 'Das :attribute muss mit einem der folgenden beginnen: :values.',
    'string' => 'Das :attribute muss eine Zeichenkette sein.',
    'timezone' => 'Das :attribute muss eine gültige Zeitzone sein.',
    'unique' => 'Das :attribute wurde bereits vergeben.',
    'uploaded' => 'Das :attribute konnte nicht hochgeladen werden.',
    'uppercase' => 'Das :attribute muss in Grossbuchstaben sein.',
    'url' => 'Das :attribute muss eine gültige URL sein.',
    'ulid' => 'Das :attribute muss eine gültige ULID sein.',
    'uuid' => 'Das :attribute muss eine gültige UUID sein.',

    /*
    |--------------------------------------------------------------------------
    | Benutzerdefinierte Validierungssprachzeilen
    |--------------------------------------------------------------------------
    |
    | Hier können Sie benutzerdefinierte Validierungsnachrichten für Attribute angeben,
    | indem Sie die Konvention "attribute.rule" verwenden, um die Zeilen zu benennen.
    | Dies erleichtert das Spezifizieren einer spezifischen benutzerdefinierten Sprachzeile
    | für eine gegebene Attributregel.
    |
    */

    'custom' => [
        'attribut-name' => [
            'regel-name' => 'benutzerdefinierte-nachricht',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Benutzerdefinierte Validierungsattribute
    |--------------------------------------------------------------------------
    |
    | Die folgenden Sprachzeilen werden verwendet, um unseren Attributplatzhalter
    | durch etwas benutzerfreundlicheres wie "E-Mail-Adresse" anstatt "email" zu ersetzen.
    | Dies hilft uns, unsere Nachricht ausdrucksvoller zu gestalten.
    |
    */

    'attributes' => [
        // StorePageRequest.php
        'title' => 'Titel',
        'route' => 'Permalink-Feld',
        'big_header' => 'Großer Header',
        'files' => 'Dateien',
        'page_items.*.sort' => 'Sortieren',
        'page_items.*.type' => 'Typ',
        'page_items.*.title' => 'Titel',
        'page_items.*.body' => 'Inhalt',
        'page_items.*.show_fleur_de_lis' => 'Pfadililie anzeigen',
        'page_items.*.files' => 'Dateien',
        'page_items.*.form_id' => 'Formular',
        'page_items.*.location_id' => 'Ort',
        'page_items.*.faq_id' => 'FAQ',

        // UpdateContactRequest.php
        'firstname' => 'Vorname',
        'lastname' => 'Nachname',
        'nickname' => 'Pfadiname',
        'role' => 'Rolle',
        'email' => 'E-Mail',
        'sort' => 'Sortieren',
        'file_id' => 'Datei',

        // StoreSectionRequest.php
        'name' => 'Name',
        'color' => 'Farbe',
        'from_age' => 'Von Alter',
        'to_age' => 'Bis Alter',
        'file_id' => 'Datei',
        'description' => 'Beschreibung',
        'files' => 'Dateien',

        // UpdateCampRequest.php
        'name' => 'Name',
        'description' => 'Beschreibung',
        'cost' => 'Kosten',
        'maximum_participants' => 'Maximale Teilnehmerzahl',
        'participant_count' => 'Anzahl Teilnehmer',
        'location' => 'Ort',
        'application_opening_at' => 'Anmeldebeginn',
        'application_closing_at' => 'Anmeldeschluss',
        'application_conditions' => 'Anmeldebedinnungen',
        'canton' => 'Kanton',
        'external_application_link' => 'Externer Anmeldelink',
        'start_at' => 'Start',
        'finish_at' => 'Ende',

        // StoreGroupRequest.php
        'name' => 'Name',
        'color' => 'Farbe',
        'midata_id' => 'Midata',
        'gender' => 'Geschlecht',
        'header_images' => 'Header-Bilder',
        'files' => 'Dateien',
        'description' => 'Beschreibung',
        'section_id' => 'Stufen',
        'file_id' => 'Datei',
        'parent_id' => 'Übergruppen',
        'predecessors' => 'Vorgänger',
        'successors' => 'Nachfolger',
        'enable_group_page' => 'Gruppenseite aktivieren',

        // StoreEventRequest.php
        'title' => 'Titel',
        'description' => 'Beschreibung',
        'take_with_you' => 'Mitnehmen',
        'start_time' => 'Startzeit',
        'end_time' => 'Endzeit',
        'groups' => 'Gruppen',
        'start_location_id' => 'Besammlungort',
        'end_location_id' => 'Schlussort',
        'files' => 'Dateien',
        'user_id' => 'Benutzer',
        'external_application_link' => 'Externer Bewerbungslink',

        // UpdateFormRequest.php
        'name' => 'Name',
        'email' => 'E-Mail',
        'subject' => 'Betreff',
        'fields.*.type' => 'Typ',
        'fields.*.input_type' => 'Eingabetyp',
        'fields.*.required' => 'Erforderlich',
        'fields.*.sort' => 'Sortieren',
        'fields.*.option_fields' => 'Optionsfelder',
        'fields.*.label' => 'Beschriftung',

        // StoreFooterLinkRequest.php
        'title' => 'Titel',
        'url' => 'URL',
        'sort' => 'Sortieren',

        // UpdateLocationRequest.php
        'name' => 'Name',
        'lat' => 'Breitengrad',
        'long' => 'Längengrad',

        // UpdateFaqRequest.php
        'title' => 'Titel',
        'questions.*.question' => 'Frage',
        'questions.*.answer' => 'Antwort',
        'questions.*.id' => 'ID',
        'questions.*.open' => 'Öffnen',
        'questions.*.sort' => 'Sortieren',

        // StoreContactRequest.php
        'firstname' => 'Vorname',
        'lastname' => 'Nachname',
        'nickname' => 'Pfadiname',
        'role' => 'Rolle',
        'email' => 'E-Mail',
        'sort' => 'Sortieren',
        'file_id' => 'Datei',

        // UpdateSectionRequest.php
        'name' => 'Name',
        'color' => 'Farbe',
        'from_age' => 'Von Alter',
        'to_age' => 'Bis Alter',
        'file_id' => 'Datei',
        'description' => 'Beschreibung',
        'files' => 'Dateien',

        // StoreLocationRequest.php
        'name' => 'Name',
        'lat' => 'Breitengrad',
        'long' => 'Längengrad',

        // UpdateEventRequest.php
        'title' => 'Titel',
        'start_time' => 'Startzeit',
        'end_time' => 'Endzeit',
        'groups' => 'Gruppen',
        'start_location_id' => 'Startort',
        'end_location_id' => 'Endort',
        'description' => 'Beschreibung',
        'take_with_you' => 'Mitnehmen',
        'files' => 'Dateien',
        'user_id' => 'Benutzer',
        'external_application_link' => 'Externer Anmeldelink',

        // StoreFaqRequest.php
        'title' => 'Titel',
        'questions.*.question' => 'Frage',
        'questions.*.answer' => 'Antwort',
        'questions.*.id' => 'ID',
        'questions.*.open' => 'Öffnen',
        'questions.*.sort' => 'Sortieren',

        // UpdateGroupRequest.php
        'name' => 'Name',
        'color' => 'Farbe',
        'midata_id' => 'Midata',
        'header_images' => 'Header-Bilder',
        'files' => 'Dateien',
        'description' => 'Beschreibung',
        'gender' => 'Geschlecht',
        'section_id' => 'Stufen',
        'file_id' => 'Datei',
        'parent_id' => 'Eltern',
        'predecessors' => 'Vorgänger',
        'successors' => 'Nachfolger',
        'enable_group_page' => 'Gruppenseite aktivieren',

        // UpdateFooterLinkRequest.php
        'title' => 'Titel',
        'url' => 'URL',
        'sort' => 'Sortieren',

        // StoreFormRequest.php
        'name' => 'Name',
        'email' => 'E-Mail',
        'subject' => 'Betreff',
        'fields.*.type' => 'Typ',
        'fields.*.input_type' => 'Eingabetyp',
        'fields.*.required' => 'Erforderlich',
        'fields.*.sort' => 'Sortieren',
        'fields.*.option_fields' => 'Optionsfelder',
        'fields.*.label' => 'Beschriftung',
    ],

];
