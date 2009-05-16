<?php
$text_dir = 'ltr';

//Form elements
$messages['lang']='Langue';  // Language
$messages['project']='Projet';  // Project
$messages['article']='Article';  // Article
$messages['needle']='Recherche';  // Search
$messages['skipversions']='Toujours sauter x versions';  // Always skip x versions
$messages['ignorefirst']='Ignorer les x premières versions';  // Ignore first x versions
$messages['limit']='Versions à vérifier'; // Versions to check
$messages['start_date'] = 'Date de début'; // Start date
$messages['order'] = 'Ordre'; // Order
$messages['newest_first'] = "plus récent d'abord";  // Latest first
$messages['oldest_first'] = "plus ancien d'abord"; // Oldest first
$messages['search_method'] = 'méthode de recherche'; // Search method
$messages['linear'] = 'linéaire'; // Linear
$messages['interpolated']='interpolé (plus rapide avec plus de versions)'; // interpolated (faster with more versions)
$messages['ignore_minors']='ignore minor changes (experimental)';
$messages['start'] ='Début';  // Start
$messages['reset'] ='Reset';
$messages['manual'] ='Manuel'; // Manual
$messages['manual_link'] ='http://de.wikipedia.org/wiki/Benutzer:Flominator/WikiBlame/en';
$messages['contact']='Contact'; // Contact
$messages['contact_link']='http://de.wikipedia.org/wiki/Benutzer Diskussion:Flominator/WikiBlame';

//Output elements
$messages['search_in_progress'] = "l'historique de _ARTICLELINK_ est parcouru à la recherche de  <b>_NEEDLE_</b> ...";
                                // The version history of _ARTICLELINK_ is being searched for <b>_NEEDLE_</b> ...
$messages['execution_time'] = "Temps d'exécution: _EXECUTIONTIME_ secondes";
                                // Exectution Time: _EXECUTIONTIME_ seconds
$messages['versions_found'] = '_NUMBEROFVERSIONS_ versions trouvées';
                                // _NUMBEROFVERSIONS_ versions found
$messages['binary_test'] = 'Comparing differences in _FIRSTDATEVERSION_ between _FIRSTNUMBER_ and _SECONDNUMBER_ while coming from _SOURCENUMBER_: '; 
$messages['insertion_found'] = 'Insertion found between LEFT_VERSION and RIGHT_VERSION';
$messages['deletion_found'] = 'Deletion found between LEFT_VERSION and RIGHT_VERSION';
?>