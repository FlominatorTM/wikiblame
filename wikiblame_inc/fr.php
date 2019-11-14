<?php
/** WikiBlame
 *
 */
/** French (français)
 * 
 * See the qqq 'language' for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Coyau
 * @author Cquoi
 * @author Crochet.david
 * @author Gomoko
 * @author IAlex
 * @author Jean-Frédéric
 * @author McDutchie
 * @author Od1n
 * @author Peter17
 * @author The RedBurn
 * @author Tititou36
 * @author Urhixidur
 * @author Verdy p
 * @author Wladek92
 * @author Wyz
 */

$messages['January'] = 'janvier';
$messages['February'] = 'février';
$messages['March'] = 'mars';
$messages['April'] = 'avril';
$messages['May'] = 'mai';
$messages['June'] = 'juin';
$messages['July'] = 'juillet';
$messages['August'] = 'août';
$messages['September'] = 'septembre';
$messages['October'] = 'octobre';
$messages['November'] = 'novembre';
$messages['December'] = 'décembre';
$messages['ui_lang'] = 'Langue d’affichage';
$messages['lang'] = 'Langue';
$messages['project'] = 'Projet';
$messages['article'] = 'Page';
$messages['needle'] = 'Rechercher :';
$messages['skipversions'] = 'Toujours sauter \'\'n\'\' versions';
$messages['ignorefirst'] = 'Ignorer les \'\'n\'\' premières versions';
$messages['limit'] = 'Versions à vérifier';
$messages['start_date'] = 'Date de début';
$messages['date_format'] = 'DD MM YYYY';
$messages['revision_date_format'] = '%H:%M, %d %B %Y';
$messages['order'] = 'Ordre';
$messages['newest_first'] = 'plus récent d’abord';
$messages['oldest_first'] = 'plus ancien d’abord';
$messages['binary_search_inverse'] = 'Rechercher la suppression de texte (dichotomique uniquement)';
$messages['search_method'] = 'Méthode de recherche';
$messages['binary'] = 'dichotomique';
$messages['binary_in_wp'] = 'https://fr.wikipedia.org/wiki/Recherche_dichotomique';
$messages['linear'] = 'linéaire';
$messages['interpolated'] = 'binaire (plus rapide avec plus de versions)';
$messages['ignore_minors'] = 'Ignorer les modifications mineures (expérimental)';
$messages['force_wikitags'] = 'Forcer la recherche de code wiki';
$messages['from_url'] = 'depuis l’URL';
$messages['paste_url'] = 'Veuillez coller l’URL de la page MediaWiki';
$messages['no_valid_url'] = 'Ceci n’est pas une URL MediaWiki valide';
$messages['start'] = 'Démarrer';
$messages['reset'] = 'Réinitialiser';
$messages['manual'] = 'Manuel';
$messages['contact'] = 'Contact';
$messages['get_less_versions'] = 'Votre recherche peut requérir __NUMREVISIONS__ versions à la fois. Afin de protéger le serveur, vous n’êtes autorisé à requérir que __ALLOWEDREVISIONS__ par appel. Veuillez modifier les paramètres ou changer la méthode de recherche vers dichotomique !';
$messages['wrong_skips'] = 'Paramètres incorrects : si les premières __VERSIONSTOSKIP__ versions sont sautées, alors aucune des __VERSIONSTOSEARCH__ versions à chercher ne seront traitées.';
$messages['search_in_progress_text'] = '<b>_NEEDLE_</b> est recherché comme texte brut dans l’historique des versions de _ARTICLELINK_';
$messages['search_in_progress_wikitags'] = '<b>_NEEDLE_</b> est recherché en tant que texte wiki dans l’historique des versions de _ARTICLELINK_';
$messages['no_differences'] = 'Aucune différence dans les versions recherchées.';
$messages['inverse_restart'] = 'Aucune insertion ou suppression trouvée, le terme recherché a-t-il été inséré plus tard ?';
$messages['inverse_stuck'] = 'Aucune insertion ni suppression trouvée parmi ces _NUMBEROFVERSIONS_ versions. Peut-être que le terme recherché avait été supprimé antérieurement ?';
$messages['inverse_earliest'] = 'Rechercher dans les versions plus anciennes';
$messages['first_version'] = 'Les changements doivent s’être produits dans la première ou la dernière version ?';
$messages['first_version_present'] = '__NEEDLE__ était déjà présent dans la plus ancienne version trouvée datant du __REVISIONLINK__.';
$messages['latest_version_present'] = '__NEEDLE__ était déjà présent dans la révision la plus récente recherchée datant du __REVISIONLINK__.';
$messages['earlier_versions_available'] = 'Il existe probablement des versions plus anciennes.';
$messages['execution_time'] = 'Durée d’exécution : _EXECUTIONTIME_ secondes';
$messages['versions_found'] = '_NUMBEROFVERSIONS_ versions trouvées';
$messages['please_wait'] = 'Veuillez patienter...';
$messages['binary_test'] = 'Comparaison des différences du _FIRSTDATEVERSION_ entre _FIRSTNUMBER_ et _SECONDNUMBER_ en venant de _SOURCENUMBER_ :';
$messages['dead_end'] = 'Tombé dans une impasse (probablement causée par des révocations ou des guerres d’éditions)';
$messages['once_more'] = 'Encore une fois, avec conviction :';
$messages['delete_from_here'] = 'Effacement de _NUMBEROFVERSIONS_ versions antérieures, car la suppression a dû être effectuée plus tard';
$messages['delete_until_here'] = 'Effacement de _NUMBEROFVERSIONS_ versions postérieures, car l’insertion a dû être effectuée plus tôt';
$messages['binary_enough'] = 'Vous avez suffisamment réessayé et l’historique de l’article est mal en point. Veuillez essayer de changer certains paramètres.';
$messages['insertion_found'] = 'Insertion détectée entre le LEFT_VERSION et le RIGHT_VERSION';
$messages['deletion_found'] = 'Suppression détectée entre le LEFT_VERSION et le RIGHT_VERSION';
$messages['here'] = 'comparaison des versions';
$messages['help_translating'] = 'Aidez à traduire sur translatewiki.net';
$messages['start_here'] = 'Rechercher à partir d’ici';
$messages['too_much_versions'] = 'Vous avez atteint votre limite de requête de __VERSIONLIMIT__ versions. Essayez de nouveau dans __WAITMINUTES__ minutes ou basculez vers la recherche binaire. Désolé pour les inconvénients.';
$messages['not_found_at_all'] = 'Le contenu recherché n’a pas été trouvé. Vérifiez les paramètres et réessayez.';
