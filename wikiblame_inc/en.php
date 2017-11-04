<?php
/** WikiBlame
 *
 */

/** English
 *
 * See the qqq 'language' for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Flominator
 * @author Siebrand
 */

$text_dir = 'ltr';

//Month names
$messages['January'] = 'January';
$messages['February'] = 'February';
$messages['March'] = 'March';
$messages['April'] = 'April';
$messages['May'] = 'May';
$messages['June'] = 'June';
$messages['July'] = 'July';
$messages['August'] = 'August';
$messages['September'] = 'September';
$messages['October'] = 'October';
$messages['November'] = 'November';
$messages['December'] = 'December';

//Form elements
$messages['ui_lang'] = 'Display language';
$messages['lang'] = 'Language';
$messages['lang_example'] = 'en, commons, www, …';
$messages['project'] = 'Project';
$messages['project_example'] = 'wikipedia, wikisource, wikimedia, wikidata, …';
$messages['article'] = 'Page';
$messages['needle'] = 'Search for';

$messages['skipversions'] = 'Always skip x versions';
$messages['skipversions_p'] = 'Always skip _INPUTFIELD_ versions';
$messages['earliest_to_check'] = 'Oldest version';
$messages['latest_to_check'] = 'Latest version';
$messages['revisions_older_than'] = 'is __INPUTFIELD__ revisions older than the current one ';
$messages['ignorefirst'] = 'Ignore first x versions';
$messages['limit'] = 'Versions to check';
$messages['start_date'] = 'Start date';
$messages['start_date_p'] = 'was not created after __INPUTFIELD__';
$messages['end_date_p'] = 'was not created before __INPUTFIELD__';
$messages['date_format'] = 'MM DD, YYYY';
$messages['revision_date_format'] = "%H:%M, %d %B %Y"; //hour:minute, day monthname year
$messages['order'] = 'Order';
$messages['newest_first'] = 'latest first';
$messages['oldest_first'] = 'oldest first';
$messages['binary_search_inverse'] = 'Look for removal of text';
$messages['search_method'] = 'Search method';
$messages['binary'] = 'binary';
$messages['binary_in_wp'] = 'https://en.wikipedia.org/wiki/Binary_search_algorithm';
$messages['linear'] = 'linear';
$messages['interpolated'] = 'binary (faster with more versions)';
$messages['ignore_minors'] = 'Ignore minor changes (experimental)';
$messages['force_wikitags'] = 'Force searching for wikitext';
$messages['from_url'] = 'from url';
$messages['paste_url'] = 'Please paste url to MediaWiki page';
$messages['no_valid_url'] = 'This is no valid MediaWiki url';
$messages['start'] = 'Start';
$messages['reset'] = 'Reset';
$messages['manual'] = 'Manual';
$messages['manual_link'] = 'https://en.wikipedia.org/wiki/User:Flominator/WikiBlame';
$messages['contact'] = 'Contact';
$messages['contact_link'] = 'https://de.wikipedia.org/wiki/Benutzer Diskussion:Flominator/WikiBlame';
$messages['get_less_versions'] = "Your search might query __NUMREVISIONS__ revisions at one time. In order to protect the server, you are only allowed to query for __ALLOWEDREVISIONS__ per call. Please change the settings or switch the search method to binary!";

//Output elements
$messages['wrong_skips'] = 'Wrong settings: If the first __VERSIONSTOSKIP__ versions are skipped, then none of the __VERSIONSTOSEARCH__ versions to be searched will be processed.';
$messages['search_in_progress_text'] = 'The version history of _ARTICLELINK_ is being searched for <b>_NEEDLE_</b> as plain text';

$messages['search_in_progress_wikitags'] = 'The version history of _ARTICLELINK_ is being searched for <b>_NEEDLE_</b> as wiki text';

$messages['no_differences'] = 'No differences found in searched revisions.';
$messages['inverse_restart'] = 'No insertion or removal found, was the search term inserted later?';
$messages['inverse_stuck'] = 'No insertion or removal found in these _NUMBEROFVERSIONS_ revisions. Was the search term maybe removed earlier?';
$messages['inverse_earliest'] = 'Search in earlier revisions';
$messages['first_version'] = 'Change must have happened in first or latest revision?';
$messages['first_version_present'] = '__NEEDLE__ was already present in the oldest revision searched dating from __REVISIONLINK__.';
$messages['earlier_versions_available'] = 'There are probably older revisions.';
$messages['execution_time'] = 'Execution time: _EXECUTIONTIME_ seconds';
$messages['versions_found'] = '_NUMBEROFVERSIONS_ versions found';
$messages['please_wait'] = 'Please wait …';
$messages['binary_test'] = 'Comparing differences in _FIRSTDATEVERSION_ between _FIRSTNUMBER_ and _SECONDNUMBER_ while coming from _SOURCENUMBER_:';
$messages['dead_end'] = 'Caught some dead end (probably caused by reverts or edit wars)';
$messages['once_more'] = 'Once more, with feeling:';
$messages['delete_from_here'] = 'Deleting _NUMBEROFVERSIONS_ earlier revisions, since removal must have been performed later';
$messages['delete_until_here'] = 'Deleting _NUMBEROFVERSIONS_ later revisions, since insertion must have been performed earlier';
$messages['binary_enough'] = 'Performed enough retries, article history is quite messed up, please try changing some settings.';
$messages['insertion_found'] = 'Insertion found between LEFT_VERSION and RIGHT_VERSION';
$messages['deletion_found'] = 'Deletion found between LEFT_VERSION and RIGHT_VERSION';
$messages['here'] = 'here';
$messages['help_translating'] = 'Help translating at translatewiki.net';
$messages['start_here'] = 'Search from here';
$messages['too_much_versions'] = 'You have reached your query limit of __VERSIONLIMIT__ versions. Please try again in __WAITMINUTES__ minutes or switch to binary search. Sorry for the inconvenience.';
$messages['not_found_at_all'] = 'Your search term was not found at all. Check the settings and try again.';
