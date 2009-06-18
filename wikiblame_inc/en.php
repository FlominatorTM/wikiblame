<?php
$text_dir = 'ltr';

//Form elements
$messages['lang']='Language';
$messages['project']='Project';
$messages['article']='Article';
$messages['needle']='Search for';
$messages['skipversions']='Always skip x versions';
$messages['ignorefirst']='Ignore first x versions';
$messages['limit']='Versions to check';
$messages['start_date'] = 'Starting date';
$messages['order'] = 'Order';
$messages['newest_first'] = 'latest first';
$messages['oldest_first'] = 'oldest first';
$messages['search_method'] = 'Search method';
$messages['linear'] = 'linear';
$messages['interpolated']='interpolated (faster with more versions)';
$messages['ignore_minors']='ignore minor changes (experimental)';
$messages['start'] ='Start';
$messages['reset'] ='Reset';
$messages['manual'] ='Manual';
$messages['manual_link'] ='http://en.wikipedia.org/wiki/User:Flominator/WikiBlame';
$messages['contact']='Contact';
$messages['contact_link']='http://de.wikipedia.org/wiki/Benutzer Diskussion:Flominator/WikiBlame';

//Output elements
$messages['wrong_skips'] = 'Wrong settings: If the first __VERSIONSTOSKIP__ versions are skipped, then none of the __VERSIONSTOSEARCH__ versions to be searched will be processed.';

$messages['search_in_progress'] = 'The version history of _ARTICLELINK_ is being searched for <b>_NEEDLE_</b> ...';
$messages['execution_time'] = 'Execution Time: _EXECUTIONTIME_ seconds';
$messages['versions_found'] = '_NUMBEROFVERSIONS_ versions found';

$messages['binary_test'] = 'Comparing differences in _FIRSTDATEVERSION_ between _FIRSTNUMBER_ and _SECONDNUMBER_ while coming from _SOURCENUMBER_: ';
$messages['insertion_found'] = 'Insertion found between LEFT_VERSION and RIGHT_VERSION';
$messages['deletion_found'] = 'Deletion found between LEFT_VERSION and RIGHT_VERSION';
