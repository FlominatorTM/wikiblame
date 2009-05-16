<?php
$text_dir = 'ltr';

$messages['translator']='Tgr'; //<gtisza@gmail.com>
$messages['translator_link']='http://hu.wikipedia.org/wiki/Szerkeszt%C5%91:Tgr'; 

//Form elements
$messages['lang']='Nyelv';
$messages['project']='Projekt';
$messages['article']='Szócikk';
$messages['needle']='Keresendő szöveg';
$messages['skipversions']='Csak minden x. változatot vizsgálja';
$messages['ignorefirst']='Első x változat átugrása';
$messages['limit']='Legfeljebb ennyi változatot';
$messages['start_date'] = 'Kezdődátum';
$messages['order'] = 'Rendezés';
$messages['newest_first'] = 'legújabb először';
$messages['oldest_first'] = 'legrégebbi először';
$messages['search_method'] = 'Keresési mód';
$messages['linear'] = 'lineáris';
$messages['interpolated']='interpolált (sok változat esetén gyorsabb)';
$messages['ignore_minors']='apró változtatások figyelmen kívül hagyása (kísérleti)';
$messages['start'] ='Mehet';
$messages['reset'] ='Mai dátumra';
$messages['manual'] ='Használati útmutató';
$messages['manual_link'] ='http://hu.wikipedia.org/wiki/Szerkeszt%C5%91:Tgr/WikiBlame';
$messages['contact']='Kapcsolat';
$messages['contact_link']='http://de.wikipedia.org/wiki/Benutzer Diskussion:Flominator/WikiBlame';

//Output elements
$messages['wrong_skips'] = 'Hibás beállítás: ha az első __VERSIONSTOSKIP__ változatot kell átugornom, akkor a vizsgálandó __VERSIONSTOSEARCH__ változat egyikét sem tudom feldolgozni.';

$messages['search_in_progress'] = 'Keresem a(z) <b>_NEEDLE_</b> szöveget a(z) _ARTICLELINK_ szócikk laptörténetében, kis türelmet...';
$messages['execution_time'] = 'A keresés _EXECUTIONTIME_ másodpercet vett igénybe.';
$messages['versions_found'] = '_NUMBEROFVERSIONS_ változatot találtam';

$messages['binary_test'] = 'A _FIRSTDATEVERSION_-i szerkesztés (_FIRSTNUMBER_. és _SECONDNUMBER_. változat között)  vizsgálata';
$messages['insertion_found'] = 'Beillesztést találtam LEFT_VERSION és RIGHT_VERSION között';
$messages['deletion_found'] = 'Törlést találtam LEFT_VERSION és RIGHT_VERSION között';
?>