<?php
/** WikiBlame
 *
 */
/** Polish (polski)
 * 
 * See the qqq 'language' for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author BeginaFelicysym
 * @author Chrumps
 * @author CiaPan
 * @author Flominator
 * @author Leinad
 * @author Matma Rex
 * @author Od1n
 * @author Sp5uhe
 * @author WTM
 * @author WarX
 * @author Woytecr
 */

$messages['January'] = 'stycznia';
$messages['February'] = 'lutego';
$messages['March'] = 'marca';
$messages['April'] = 'kwietnia';
$messages['May'] = 'maja';
$messages['June'] = 'czerwca';
$messages['July'] = 'lipca';
$messages['August'] = 'sierpnia';
$messages['September'] = 'września';
$messages['October'] = 'października';
$messages['November'] = 'listopada';
$messages['December'] = 'grudnia';
$messages['ui_lang'] = 'Język prezentacji';
$messages['lang'] = 'Język';
$messages['project'] = 'Projekt';
$messages['article'] = 'Strona';
$messages['needle'] = 'Tekst do wyszukania';
$messages['skipversions'] = 'Zawsze pomijaj x wersji';
$messages['ignorefirst'] = 'Ignoruj pierwsze x wersji';
$messages['limit'] = 'Wersje do sprawdzenia';
$messages['start_date'] = 'Data początkowa';
$messages['date_format'] = 'DD MM YYYY';
$messages['revision_date_format'] = '%H:%M, %d %B %Y';
$messages['order'] = 'Kolejność';
$messages['newest_first'] = 'najnowsze na początku';
$messages['oldest_first'] = 'najstarsze na początku';
$messages['binary_search_inverse'] = 'Szukaj usunięcia tekstu (tylko wyszukiwanie binarne)';
$messages['search_method'] = 'Metoda wyszukiwania';
$messages['binary'] = 'binarna';
$messages['binary_in_wp'] = 'https://pl.wikipedia.org/wiki/Wyszukiwanie_binarne';
$messages['linear'] = 'liniowa';
$messages['interpolated'] = 'binarna (szybsza dla większej liczby wersji)';
$messages['ignore_minors'] = 'ignoruj drobne zmiany (eksperymentalne)';
$messages['force_wikitags'] = 'Wymuś wyszukiwanie w wikitekście';
$messages['from_url'] = 'pobierz z URL';
$messages['paste_url'] = 'Wklej URL strony MediaWiki';
$messages['no_valid_url'] = 'To nie jest poprawny URL MediaWiki';
$messages['start'] = 'Start';
$messages['reset'] = 'Reset';
$messages['manual'] = 'Instrukcja';
$messages['contact'] = 'Kontakt';
$messages['get_less_versions'] = 'Wyszukiwanie może zapytać o __NUMREVISIONS__ wersji na raz. Aby chronić serwer, dozwolone jest pytanie o __ALLOWEDREVISIONS__ wersji w jednym wywołaniu. Zmień ustawienia lub przełącz metodę wyszukiwania na binarną!';
$messages['wrong_skips'] = 'Niewłaściwe ustawienia – jeśli pierwsze wersje __VERSIONSTOSKIP__ są pomijane, to żadne z wersji __VERSIONSTOSEARCH__, które mają zostać przeszukane nie będą przetworzone.';
$messages['search_in_progress_text'] = 'Trwa przeszukiwanie historii zmian _ARTICLELINK_ w celu odnalezienia zwykłego tekstu <b>_NEEDLE_</b>';
$messages['search_in_progress_wikitags'] = 'Trwa przeszukiwanie historii zmian _ARTICLELINK_ w celu odnalezienia tekstu w formacie wiki <b>_NEEDLE_</b>';
$messages['no_differences'] = 'Nie znaleziono różnic w przeszukiwanych wersjach.';
$messages['inverse_restart'] = 'Nie znaleziono wstawienia lub usunięcia, czy szukana fraza nie została dodana później?';
$messages['inverse_stuck'] = 'Nie znaleziono miejsca dodania lub usunięcia w tych _NUMBEROFVERSIONS_ wersjach. Być może poszukiwany tekst został usunięty wcześniej?';
$messages['inverse_earliest'] = 'Wyszukiwanie we wcześniejszych wersjach';
$messages['first_version'] = 'Zmiana musiała wystąpić w pierwszej lub w ostatniej wersji?';
$messages['first_version_present'] = '__NEEDLE__ było już obecne w najstarszej z przeszukanych wersji z __REVISIONLINK__.';
$messages['latest_version_present'] = '__NEEDLE__ było już obecne w najmłodszej z przeszukanych wersji z __REVISIONLINK__.';
$messages['earlier_versions_available'] = 'Prawdopodobnie są starsze wersje.';
$messages['execution_time'] = 'Czas wykonania: _EXECUTIONTIME_ sekund';
$messages['versions_found'] = '_NUMBEROFVERSIONS_ wersji znaleziono';
$messages['please_wait'] = 'Proszę czekać…';
$messages['binary_test'] = 'Porównuję różnice z _FIRSTDATEVERSION_ pomiędzy wersjami _FIRSTNUMBER_ i _SECONDNUMBER_ spośród _SOURCENUMBER_:';
$messages['dead_end'] = 'Ślepy zaułek (prawdopodobnie spowodowany przywracaniem lub wojną edycyjną)';
$messages['once_more'] = 'Raz jeszcze, z wyczuciem:';
$messages['delete_from_here'] = 'Pomijam _NUMBEROFVERSIONS_ wcześniejszych wersji, ponieważ usunięcie musiało nastąpić później';
$messages['delete_until_here'] = 'Pomijam _NUMBEROFVERSIONS_ późniejszych wersji, gdyż wstawienie tekstu musiało nastąpić wcześniej';
$messages['binary_enough'] = 'Wykonano zbyt wiele prób, historia artykułu jest bardzo zagmatwana, proszę spróbować zmienić niektóre ustawienia.';
$messages['insertion_found'] = 'Wstawienie odnalezione pomiędzy LEFT_VERSION i RIGHT_VERSION';
$messages['deletion_found'] = 'Usunięcie odnalezione pomiędzy LEFT_VERSION i RIGHT_VERSION';
$messages['here'] = 'tutaj';
$messages['help_translating'] = 'Pomóż w tłumaczeniu na translatewiki.net';
$messages['start_here'] = 'Szukaj od tego miejsca';
$messages['too_much_versions'] = 'Osiągnąłeś limit zapytań, który wynosi __VERSIONLIMIT__ wersji. Spróbuj ponownie za __WAITMINUTES__ minut lub przełącz na wyszukiwanie binarne. Przepraszamy za utrudnienia.';
$messages['not_found_at_all'] = 'Nie odnaleziono zupełnie wyszukiwanego wyrażenia. Sprawdź ustawienia i spróbuj ponownie.';
