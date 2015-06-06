<?php

setlocale(LC_TIME, 'de_DE');	
//form
$messages['ui_lang'] = 'Anzeigesprache';
$messages['headline'] = 'Nächste Fotografen';
$messages['lang'] = 'Sprache';
$messages['lang_example'] = 'de, commons, …';
$messages['project'] = 'Projekt';
$messages['project_example'] = 'wikipedia, wikisource, wikimedia, …';
$messages['article_to'] = 'Artikel';
$messages['article_to_descr'] = 'Wikipedia-Artikel mit Koordinaten, an denen das Bild aufgenommen werden soll (z.B.  Stadt, Sehenswürdigkeit, Platz etc.)';
$messages['find_next'] = 'Nächste Fotografen finden';
$messages['manual'] = 'Anleitung';
$messages['issues'] = 'Probleme und Feedback';
$messages['manual_link'] = 'https://de.wikipedia.org/wiki/Wikipedia%3ABilderangebote';
$messages['issue_link'] = 'https://github.com/FlominatorTM/wikipedia_nearest_photographers/issues';


//template
$messages['template_offer'] = 'Bilderangebot';
$messages['template_user'] = 'Benutzer';
$messages['template_location'] = 'Standort';
$messages['template_range'] = 'Aktionsradius';

//result
$messages['distance_to'] = 'Fotografen nach Entfernung zu Koordinaten aus [[_ARTICLE_TO_]] ';
$messages['no_coordinates'] = 'Der Artikel _LOCATION_ ist ungültig oder hat keine Koordinaten';
$messages['proj_not_supported'] = 'Das Projekt _PROJECT_ wird derzeit nicht unterstützt. Bitte nehme Kontakt mit :de:user:Flominator auf.';
$messages['new_request'] = 'Neue Suche durchführen';
$messages['between_dates'] = 'nur zwischen _FIRST_DATE_ und _SECOND_DATE_';
$messages['until_date']= 'nur noch bis _DATE_';
$messages['until_date_over']= 'war bis _DATE_ dort :(';
$messages['you_on_list']= 'Du willst auch auf dieser Liste zu finden sein? Füge deinen Eintrag mit {{_TEMPLATE_NAME_}} auf der Seite _OFFER_PAGE_ ein.';