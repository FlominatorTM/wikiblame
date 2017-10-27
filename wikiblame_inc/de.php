<?php
/** WikiBlame
 *
 */
/** German (Deutsch)
 * 
 * See the qqq 'language' for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Flominator
 * @author Kghbln
 * @author Metalhead64
 * @author Od1n
 * @author Taresi
 * @author ThePiscin
 * @author Umherirrender
 */

$messages['January'] = 'Januar';
$messages['February'] = 'Februar';
$messages['March'] = 'März';
$messages['April'] = 'April';
$messages['May'] = 'Mai';
$messages['June'] = 'Juni';
$messages['July'] = 'Juli';
$messages['August'] = 'August';
$messages['September'] = 'September';
$messages['October'] = 'Oktober';
$messages['November'] = 'November';
$messages['December'] = 'Dezember';
$messages['ui_lang'] = 'Anzeigesprache';
$messages['lang'] = 'Sprache';
$messages['lang_example'] = 'en, commons, www, …';
$messages['project'] = 'Projekt';
$messages['project_example'] = 'wikipedia, wikisource, wikimedia, wikidata, …';
$messages['article'] = 'Artikel';
$messages['needle'] = 'Suchbegriff';
$messages['skipversions'] = 'Immer x Versionen überspringen';
$messages['ignorefirst'] = 'Die ersten x Versionen überspringen';
$messages['limit'] = 'Versionen durchsuchen';
$messages['start_date'] = 'Startdatum';
$messages['date_format'] = 'DD.MM.YYYY';
$messages['revision_date_format'] = '%d. %B %Y, %H:%M Uhr';
$messages['order'] = 'Reihenfolge';
$messages['newest_first'] = 'neuere zuerst';
$messages['oldest_first'] = 'ältere zuerst (nur bei linearer Suche)';
$messages['binary_search_inverse'] = 'Nach Löschung des Textes suchen (nur bei binärer Suche)';
$messages['search_method'] = 'Suchmethode';
$messages['binary'] = 'binär';
$messages['binary_in_wp'] = 'https://de.wikipedia.org/wiki/Binäre_Suche';
$messages['linear'] = 'linear';
$messages['interpolated'] = 'binär (bei vielen Versionen schneller)';
$messages['ignore_minors'] = 'Kleine Änderungen ignorieren (experimentell)';
$messages['force_wikitags'] = 'Suche nach Wikitext erzwingen';
$messages['start'] = 'Start';
$messages['reset'] = 'zurücksetzen';
$messages['manual'] = 'Handbuch';
$messages['manual_link'] = 'https://de.wikipedia.org/wiki/Benutzer:Flominator/WikiBlame';
$messages['contact'] = 'Kontakt';
$messages['get_less_versions'] = 'Die angegebene Suche könnte zur gleichzeitigen Abfrage von __NUMREVISIONS__ Versionen führen. Zum Schutz der Serverleistung, sind je Abfrage maximal __ALLOWEDREVISIONS__ Versionen zulässig. Bitte daher die Abfrageeinstellungen ändern oder auf die Suchmethode „binär“ umstellen.';
$messages['wrong_skips'] = 'Falsche Einstellung: Sofern die ersten __VERSIONSTOSKIP__ Versionen übersprungen werden sollen, wird keine der gewählten __VERSIONSTOSEARCH__ Versionen durchsucht.';
$messages['search_in_progress_text'] = 'Die Versionsgeschichte des Artikels _ARTICLELINK_ wird nach <b>_NEEDLE_</b> als einfachem Text durchsucht';
$messages['search_in_progress_wikitags'] = 'Die Versionsgeschichte von _ARTICLELINK_ wird nach <b>_NEEDLE_</b> als Wikitext durchsucht';
$messages['no_differences'] = 'Keine Unterschiede in den durchsuchten Versionen gefunden';
$messages['inverse_restart'] = 'Keine Einfügung oder Löschung gefunden. Wurde der Suchbegriff vielleicht später eingefügt?';
$messages['first_version'] = 'Die Änderung muss in der ersten oder letzten Version passiert sein?';
$messages['first_version_present'] = '__NEEDLE__ war bereits in der ältesten durchsuchten Version vom __REVISIONLINK__ enthalten.';
$messages['earlier_versions_available'] = 'Es existieren wahrscheinlich ältere Versionen.';
$messages['execution_time'] = 'Ausführungszeit: _EXECUTIONTIME_ Sekunden';
$messages['versions_found'] = '_NUMBEROFVERSIONS_ Versionen gefunden';
$messages['please_wait'] = 'Bitte warten …';
$messages['binary_test'] = 'Prüfe Änderung vom _FIRSTDATEVERSION_ zwischen _FIRSTNUMBER_ und _SECONDNUMBER_ von _SOURCENUMBER_ aus:';
$messages['dead_end'] = 'Die Suche befindet sich in der Sackgasse (wahrscheinlich aufgrund häufiger Artikelzurücksetzungen)';
$messages['once_more'] = 'Erneuter Versuch:';
$messages['delete_from_here'] = 'Lösche _NUMBEROFVERSIONS_ frühere Versionen, da Löschung später vorgenommen worden sein muss';
$messages['delete_until_here'] = 'Lösche _NUMBEROFVERSIONS_ spätere Versionen, da Einfügung früher vorgenommen worden sein muss';
$messages['binary_enough'] = 'Die Suche wurde etliche Male wiederholt. Da die Artikelhistorie sehr unübersichtlich ist, sollten die Sucheinstellungen verändert werden.';
$messages['insertion_found'] = 'Einfügung zwischen LEFT_VERSION und RIGHT_VERSION gefunden';
$messages['deletion_found'] = 'Löschung zwischen LEFT_VERSION und RIGHT_VERSION gefunden';
$messages['here'] = 'hier';
$messages['help_translating'] = 'Hilf beim Übersetzen auf translatewiki.net';
$messages['start_here'] = 'Ab hier suchen';
$messages['too_much_versions'] = 'Die Abfragebegrenzung von __VERSIONLIMIT__ Versionen wurde erreicht. Eine erneute Suche ist in __WAITMINUTES__ Minuten möglich. Alternativ ist die Suchmethode „binär“ möglich. Entschuldige die Unannehmlichkeiten.';
$messages['not_found_at_all'] = 'Der Suchbegriff wurde nicht gefunden. Überprüfe die Einstellungen und versuche es erneut.';
