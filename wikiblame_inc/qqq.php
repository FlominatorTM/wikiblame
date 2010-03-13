<?php
/** Wikiblame
 *
 */

/** Message documentation (Message documentation)
 *
 * See the qqq 'language' for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Fryed-peach
 * @author Lou Crazy
 * @author McDutchie
 * @author Purodha
 * @author Siebrand
 */

$text_dir = '{{optional}}Directionality of the language. Should only be changed if the language translated is written right to left. Possible values:
* \'ltr\' for left to right (default)
* rtl for right to left';
$messages['lang'] = '{{Identical|Language}}';
$messages['article'] = '{{Identical|Page}}';
$messages['needle'] = 'This message is used by wikiblame (http://wikipedia.ramselehof.de/wikiblame.php). It is the caption for the text to be searched for.';
$messages['skipversions'] = 'Label for a field in which the number of versions to skip while blaming can be entered.';
$messages['ignorefirst'] = 'Label for a field in which the number of early versions to skip while blaming can be entered.';
$messages['start_date'] = '{{Identical|Start date}}';
$messages['binary_in_wp'] = 'Link to your local wikipedia article about Binary_search_algorithm';
$messages['interpolated'] = 'Interpolated is a binary search. It is faster than linear search when a lot of versions have to be checked.';
$messages['start'] = 'Text of the button to start the search. Translate as a verb.';
$messages['reset'] = '{{Identical|Reset}}';
$messages['manual'] = 'Label for link to a user manual.';
$messages['manual_link'] = '{{optional}} Contains the link to the Wikiblame manual. Should only contain a link if the manual has been localised.';
$messages['contact_link'] = '{{optional}}Contains the link to a location for local language support. Should only contain a link if local language support for the tool is available.';
$messages['wrong_skips'] = 'Do not translate <code>__VERSIONSTOSKIP__</code>, and <code>__VERSIONSTOSEARCH__</code>';
$messages['execution_time'] = 'Do not translate <code>_EXECUTIONTIME_</code>.';
$messages['versions_found'] = 'Do not translate <code>_NUMBEROFVERSIONS_</code>';
$messages['binary_test'] = 'Do not translate <code>_FIRSTDATEVERSION_</code>, <code>_FIRSTNUMBER_</code>, <code>_SECONDNUMBER_</code>, and <code>_SOURCENUMBER_</code>';
$messages['insertion_found'] = 'Do not translate <code>LEFT_VERSION</code>, and <code>RIGHT_VERSION</code>.';
$messages['deletion_found'] = 'Do not translate <code>LEFT_VERSION</code>, and <code>RIGHT_VERSION</code>.';
