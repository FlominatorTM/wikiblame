<?php
/** WikiBlame
 *
 */
/** Hungarian (magyar)
 * 
 * See the qqq 'language' for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Bináris
 * @author Dj
 * @author Glanthor Reviol
 * @author Od1n
 * @author Tacsipacsi
 * @author Tgr
 * @author Tgr <gtisza AT gmail.com>
 */

$messages['January'] = 'január';
$messages['February'] = 'február';
$messages['March'] = 'március';
$messages['April'] = 'április';
$messages['May'] = 'május';
$messages['June'] = 'június';
$messages['July'] = 'július';
$messages['August'] = 'augusztus';
$messages['September'] = 'szeptember';
$messages['October'] = 'október';
$messages['November'] = 'november';
$messages['December'] = 'december';
$messages['ui_lang'] = 'Megjelenítési nyelv';
$messages['lang'] = 'Nyelv';
$messages['project'] = 'Projekt';
$messages['article'] = 'Szócikk';
$messages['needle'] = 'Keresendő szöveg';
$messages['skipversions'] = 'Csak minden x. változatot vizsgálja';
$messages['ignorefirst'] = 'Első x változat átugrása';
$messages['limit'] = 'Legfeljebb ennyi változatot';
$messages['start_date'] = 'Kezdődátum';
$messages['date_format'] = 'YYYY. MM DD.';
$messages['revision_date_format'] = '%Y. %B %e., %H:%M';
$messages['order'] = 'Rendezés';
$messages['newest_first'] = 'legújabb először';
$messages['oldest_first'] = 'legrégebbi először';
$messages['binary_search_inverse'] = 'Szöveg eltávolításának a keresése (csak bináris)';
$messages['search_method'] = 'Keresési mód';
$messages['binary'] = 'bináris';
$messages['linear'] = 'lineáris';
$messages['interpolated'] = 'bináris (sok változat esetén gyorsabb)';
$messages['ignore_minors'] = 'apró változtatások figyelmen kívül hagyása (kísérleti)';
$messages['force_wikitags'] = 'keresés mint wikiszöveg';
$messages['from_url'] = 'URL-ből';
$messages['paste_url'] = 'Illessz be egy MediaWiki-oldalra mutató URL-t';
$messages['no_valid_url'] = 'Ez nem egy érvényes MediaWiki-URL';
$messages['start'] = 'Mehet';
$messages['reset'] = 'Mai dátumra';
$messages['manual'] = 'Használati útmutató';
$messages['manual_link'] = 'https://hu.wikipedia.org/wiki/Wikipédia:WikiBlame';
$messages['contact'] = 'Kapcsolat';
$messages['get_less_versions'] = 'A keresésed egyszerre __NUMREVISIONS__ változatot próbált lekérdezni. A szerver védelme érdekében legfeljebb __ALLOWEDREVISIONS__ változatot kérdezhetsz le hívásonként. Kérlek változtasd meg a beállításokat, vagy válts bináris keresésre!';
$messages['wrong_skips'] = 'Hibás beállítás: ha az első __VERSIONSTOSKIP__ változatot kell átugornom, akkor a vizsgálandó __VERSIONSTOSEARCH__ változat egyikét sem tudom feldolgozni.';
$messages['search_in_progress_text'] = 'Keresés a(z) _ARTICLELINK_ laptörténetében a(z) <b>_NEEDLE_</b> keresőkifejezésre (mint sima szöveg)';
$messages['search_in_progress_wikitags'] = 'Keresés a(z) _ARTICLELINK_ laptörténetében a(z) <b>_NEEDLE_</b> keresőkifejezésre (mint wikiszöveg)';
$messages['no_differences'] = 'Nincs eltérés a keresett változatokban.';
$messages['inverse_restart'] = 'Nem található beillesztés vagy eltávolítás, talán a keresőkifejezés később került a cikkbe?';
$messages['inverse_stuck'] = 'Nem található beillesztés vagy eltávolítás ebben a(z) _NUMBEROFVERSIONS_ lapváltozatban. Talán a szöveg már korábban el lett távolítva?';
$messages['inverse_earliest'] = 'Régebbi változatok keresése';
$messages['first_version'] = 'A változásnak az első vagy a legutóbbi változatban kell előfordulnia?';
$messages['first_version_present'] = '__NEEDLE__ már az legrégebbi keresett változatban megtalálható, amely ekkor készült: __REVISIONLINK__.';
$messages['latest_version_present'] = '__NEEDLE__ már az legújabb keresett változatban megtalálható, amely ekkor készült: __REVISIONLINK__.';
$messages['earlier_versions_available'] = 'Vélhetően vannak régebbi változatok.';
$messages['execution_time'] = 'A keresés _EXECUTIONTIME_ másodpercet vett igénybe.';
$messages['versions_found'] = '_NUMBEROFVERSIONS_ változatot találtam';
$messages['please_wait'] = 'Kérlek várj…';
$messages['binary_test'] = 'A _FIRSTDATEVERSION_-i szerkesztés (_FIRSTNUMBER_. és _SECONDNUMBER_. változat között)  vizsgálata';
$messages['dead_end'] = 'Zsákutcába került (vélhetően visszaállítás vagy szerkesztői háború miatt)';
$messages['once_more'] = 'Még egyszer, ezzel az érzéssel:';
$messages['delete_from_here'] = '_NUMBEROFVERSIONS_ korábbi lapváltozat törlése, mert az eltávolításnak később kellett történnie';
$messages['delete_until_here'] = '_NUMBEROFVERSIONS_ későbbi lapváltozat törlése, mert az eltávolításnak korábban kellett történnie';
$messages['binary_enough'] = 'Elég próbálkozást végrehajtva, a cikk története meglehetősen zavaros, próbáld más beállításokkal.';
$messages['insertion_found'] = 'Beillesztést találtam LEFT_VERSION és RIGHT_VERSION között';
$messages['deletion_found'] = 'Törlést találtam LEFT_VERSION és RIGHT_VERSION között';
$messages['here'] = 'itt';
$messages['help_translating'] = 'Segíts a fordításban a translatewiki.net oldalon';
$messages['start_here'] = 'Keresés innen';
$messages['too_much_versions'] = 'Elérted a __VERSIONLIMIT__ típusú lekérdezések maximális számát. Próbáld újra __WAITMINUTES__ perc múlva, vagy kapcsolj át bináris keresésre. Elnézést a kényelmetlenségért.';
$messages['not_found_at_all'] = 'A keresett kifejezés egyáltalán nem található. Ellenőrizd a beállításokat, és próbáld meg újra!';
