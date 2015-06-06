<?php

setlocale(LC_TIME, 'en_US');

//form
$messages['ui_lang'] = 'Display language';
$messages['headline'] = 'Nearest photographers';
$messages['lang'] = 'Language';
$messages['lang_example'] = 'en, commons, …';
$messages['project'] = 'Project';
$messages['project_example'] = 'wikipedia, wikisource, wikimedia, …';
$messages['article_to'] = 'Article';
$messages['article_to_descr'] = 'Wikipedia article with coordinates where picture should be taken at (e.g. some city, sight, place etc.)';
$messages['find_next'] = 'Find closest photographers';
$messages['manual'] = 'Manual';
$messages['issues'] = 'issues + feedback ';
$messages['manual_link'] = 'https://en.wikipedia.org/wiki/Wikipedia%3AWikipedians%2FPhotographers';
$messages['issue_link'] = 'https://github.com/FlominatorTM/wikipedia_nearest_photographers/issues';


//template
$messages['template_offer'] = 'Bilderangebot';
$messages['template_user'] = 'Benutzer';
$messages['template_location'] = 'Standort';
$messages['template_range'] = 'Aktionsradius';

//result
$messages['distance_to'] = 'Photographers distance to coordinates from [[_ARTICLE_TO_]] ';
$messages['no_coordinates'] = 'location _LOCATION_ is invalid/does not have coordinates';
$messages['proj_not_supported'] = 'project _PROJECT_ is currently not supported, please contact :de:user:Flominator for details';
$messages['new_request'] = 'Perform new search';
$messages['between_dates'] = 'only between _FIRST_DATE_ and _SECOND_DATE_';
$messages['until_date']= 'only until _DATE_';
$messages['until_date_over']= 'was there until _DATE_ :(';
$messages['you_on_list']= 'You want to be on this list? Please insert your copy of {{_TEMPLATE_NAME_}} into _OFFER_PAGE_';