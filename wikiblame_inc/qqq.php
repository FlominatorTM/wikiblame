<?php
/** Message documentation (Message documentation)
 * 
 * See the qqq 'language' for message documentation incl. usage of parameters
 * To improve a translation please visit https://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Abijeet Patro
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Liuxinyu970226
 * @author Lloffiwr
 * @author Lou Crazy
 * @author McDutchie
 * @author Purodha
 * @author Shirayuki
 * @author Siebrand
 * @author Verdy p
 * @author Waldyrious
 * @author 아라
 */

$text_dir = '{{optional}}Directionality of the language. Should only be changed if the language translated is written right to left. Possible values:
* \'ltr\' for left to right (default)
* rtl for right to left';
$messages['January'] = 'In dropdown list of months. See [http://wikipedia.ramselehof.de/wikiblame.php here].
{{Identical|January}}';
$messages['February'] = 'In dropdown list of months. See [http://wikipedia.ramselehof.de/wikiblame.php here].
{{Identical|February}}';
$messages['March'] = 'In dropdown list of months. See [http://wikipedia.ramselehof.de/wikiblame.php here].
{{Identical|March}}';
$messages['April'] = 'In dropdown list of months. See [http://wikipedia.ramselehof.de/wikiblame.php here].
{{Identical|April}}';
$messages['May'] = 'In dropdown list of months. See [http://wikipedia.ramselehof.de/wikiblame.php here].
{{Identical|May}}';
$messages['June'] = 'In dropdown list of months. See [http://wikipedia.ramselehof.de/wikiblame.php here].
{{Identical|June}}';
$messages['July'] = 'In dropdown list of months. See [http://wikipedia.ramselehof.de/wikiblame.php here].
{{Identical|July}}';
$messages['August'] = 'In dropdown list of months. See [http://wikipedia.ramselehof.de/wikiblame.php here].
{{Identical|August}}';
$messages['September'] = 'In dropdown list of months. See [http://wikipedia.ramselehof.de/wikiblame.php here].
{{Identical|September}}';
$messages['October'] = 'In dropdown list of months. See [http://wikipedia.ramselehof.de/wikiblame.php here].
{{Identical|October}}';
$messages['November'] = 'In dropdown list of months. See [http://wikipedia.ramselehof.de/wikiblame.php here].
{{Identical|November}}';
$messages['December'] = 'In dropdown list of months. See [http://wikipedia.ramselehof.de/wikiblame.php here].
{{Identical|December}}';
$messages['ui_lang'] = 'Appears above dropdown list of languages. See [http://wikipedia.ramselehof.de/wikiblame.php here]. \'Display\' is a noun.
{{Identical|Display language}}';
$messages['lang'] = 'Text before input box. See [http://wikipedia.ramselehof.de/wikiblame.php here].

{{Identical|Language}}';
$messages['lang_example'] = '{{Optional}}';
$messages['project'] = 'Text before input box. See [http://wikipedia.ramselehof.de/wikiblame.php here].

{{Identical|Project}}';
$messages['project_example'] = '{{Optional}}

The items listed in this message aren\'t the project names, but rather the domain part of their URLs, so they shouldn\'t be translated. Only translate the punctuation or other similar details.';
$messages['article'] = 'Text before input box. See [http://wikipedia.ramselehof.de/wikiblame.php here].

{{Identical|Page}}';
$messages['needle'] = 'This message is used by wikiblame (http://wikipedia.ramselehof.de/wikiblame.php). It is the caption for the text to be searched for.
{{Identical|Search}}';
$messages['skipversions'] = 'Label for a field in which the number of versions to skip while blaming can be entered. See [http://wikipedia.ramselehof.de/wikiblame.php here].';
$messages['ignorefirst'] = 'Label for a field in which the number of early versions to skip while blaming can be entered. See [http://wikipedia.ramselehof.de/wikiblame.php here].';
$messages['limit'] = 'Label before field (field is a number). See [http://wikipedia.ramselehof.de/wikiblame.php here].';
$messages['start_date'] = 'Label of date input boxes. See [http://wikipedia.ramselehof.de/wikiblame.php here].

{{Identical|Start date}}';
$messages['date_format'] = 'Format string to describe how dates have to be displayed. Must contain these symbols: "MM" (month) "DD" (day) and "YYYY" (year). Example in en would be MM DD, YYYY. Do not localise the symbols as this message will not appear in the interface (although as of 25.1.11 it does appear, during the implementation of the formats and localisation for major languages - see [https://sourceforge.net/p/wikiblame/bug-reports/54/ sourceforge]. Please note that the input box for the month shows the month names, which are translated in other Wikiblame messages in this group. See [http://wikipedia.ramselehof.de/wikiblame.php Wikiblame interface].
{{DataFormatSpecifiers/en}}';
$messages['revision_date_format'] = 'This is used for formatting the date/time data of the revisions.

* %H:%M is the 2 digit representation of the time in 24 Hour format
* %d is the 2-digit day of the month
* %m is the 2-digit representation of the month
* %B is replaced by the localized month name
* %Y is the 4-digit representation for the year';
$messages['order'] = 'Label for search option radio buttons, \'latest first\' and \'oldest first\'. See [http://wikipedia.ramselehof.de/wikiblame.php here].
{{Identical|Order}}';
$messages['newest_first'] = 'Radio button option for search \'order\'. See [http://wikipedia.ramselehof.de/wikiblame.php here].';
$messages['oldest_first'] = 'Radio button option for search \'order\'. See [http://wikipedia.ramselehof.de/wikiblame.php here].';
$messages['search_method'] = 'Label for search options \'linear\' and \'binary\'. See [http://wikipedia.ramselehof.de/wikiblame.php here].';
$messages['binary'] = 'Radio button option for \'search method\'. See [http://wikipedia.ramselehof.de/wikiblame.php here].
<br />
There is a [[w:en:Binary_search_algorithm|Wikipedia article explaining how it works]].
{{Identical|Binary}}';
$messages['binary_in_wp'] = '{{Optional}}
Link to your local wikipedia article about Binary search algorithm (see [[w:d:Q243754|Wikidata]] if you can\'t find it easy).';
$messages['linear'] = 'Radio button option for \'search method\'. See [http://wikipedia.ramselehof.de/wikiblame.php here].';
$messages['interpolated'] = 'Interpolated is a binary search. It is faster than linear search when a lot of versions have to be checked. Radio button option for search \'order\' (not yet used?). See [http://wikipedia.ramselehof.de/wikiblame.php here].';
$messages['ignore_minors'] = 'Checkbox option. See [http://wikipedia.ramselehof.de/wikiblame.php here].';
$messages['force_wikitags'] = 'Checkbox option. See [http://wikipedia.ramselehof.de/wikiblame.php here].';
$messages['start'] = 'Text of the button to start the search. Translate as a verb. See [http://wikipedia.ramselehof.de/wikiblame.php here].
{{Identical|Start}}';
$messages['reset'] = 'Button text next to date input boxes. Resets to today\'s date. See [http://wikipedia.ramselehof.de/wikiblame.php here].

{{Identical|Reset}}';
$messages['manual'] = 'Label for link to a user manual. See [http://wikipedia.ramselehof.de/wikiblame.php here].
{{Identical|Manual}}';
$messages['manual_link'] = '{{optional}} Contains the link to the Wikiblame manual. Should only contain a link if the manual has been localised.

The German version of the page was published in the German Wikipedia by the creator and maintainer of the tool in a subpage of his user page at https://de.wikipedia.org/wiki/Benutzer:Flominator/WikiBlame, in addition to the English version on a subpage of his user page on English Wikipedia. Other users have translated that page, but it may be translated on any suitable wiki, not just Wikipedia, such as MetaWiki, and not necessarily in a user page (for example the Portuguese version is in a subpage of a project page on Portuguese Wikipedia for Wikimedia tools). These pages should be linked in Wikidata (see [[wikipedia:d:Q15042058]]).';
$messages['contact'] = 'Link label to contact pages for Wikiblame. See [http://wikipedia.ramselehof.de/wikiblame.php here].
{{Identical|Contact}}';
$messages['contact_link'] = '{{optional}}Contains the link to a location for local language support. Should only contain a link if local language support for the tool is available.';
$messages['source_code'] = 'Label for the link to the source code repository on GitHub.';
$messages['wrong_skips'] = 'Do not translate <code>__VERSIONSTOSKIP__</code>, and <code>__VERSIONSTOSEARCH__</code>

Hint: you could quote the text of the labels for the fields <code>__VERSIONSTOSKIP__</code> ({{msg-wikiblame|Messages\x5b\'ignorefirst\'\x5d}}) and <code>__VERSIONSTOSEARCH__</code> ({{msg-wikiblame|Messages\x5b\'limit\'\x5d}}). See [http://wikipedia.ramselehof.de/wikiblame.php here]';
$messages['search_in_progress_text'] = 'Do not translate <code>_ARTICLELINK_</code> nor <code>_NEEDLE_</code>';
$messages['search_in_progress_wikitags'] = 'Do not translate <code>_ARTICLELINK_</code> nor <code><b>_NEEDLE_</b></code>';
$messages['first_version_present'] = 'Do not translate __NEEDLE__ and __REVISIONLINK__ .

NEEDLE is the search string and REVISIONLINK is a link whose text is a date.';
$messages['execution_time'] = 'Do not translate <code>_EXECUTIONTIME_</code>. This message is part of the results page, giving the time taken to produce the results.';
$messages['versions_found'] = 'Do not translate <code>_NUMBEROFVERSIONS_</code>';
$messages['please_wait'] = '{{Identical|Please wait}}';
$messages['binary_test'] = 'Do not translate <code>_FIRSTDATEVERSION_</code>, <code>_FIRSTNUMBER_</code>, <code>_SECONDNUMBER_</code>, and <code>_SOURCENUMBER_</code>';
$messages['insertion_found'] = 'Do not translate <code>LEFT_VERSION</code>, and <code>RIGHT_VERSION</code>.';
$messages['deletion_found'] = 'Do not translate <code>LEFT_VERSION</code>, and <code>RIGHT_VERSION</code>.';
$messages['here'] = '{{Identical|Here}}';
$messages['help_translating'] = 'Link to Wikiblame project page at translatewiki.net. See [http://wikipedia.ramselehof.de/wikiblame.php here].';
$messages['start_here'] = 'Text on link to a new search starting with the date of the revision next to the link';
