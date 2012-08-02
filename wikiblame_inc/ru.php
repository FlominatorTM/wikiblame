<?php
/** WikiBlame
 *
 */
/** Russian (русский)
 * 
 * See the qqq 'language' for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Ferrer
 * @author Flominator
 * @author Ignatus
 * @author Lockal
 * @author Александр Сигачёв
 */

$messages['January'] = 'января';
$messages['February'] = 'февраля';
$messages['March'] = 'марта';
$messages['April'] = 'апреля';
$messages['May'] = 'мая';
$messages['June'] = 'июня';
$messages['July'] = 'июля';
$messages['August'] = 'августа';
$messages['September'] = 'сентября';
$messages['October'] = 'октября';
$messages['November'] = 'ноября';
$messages['December'] = 'декабря';
$messages['ui_lang'] = 'Язык отображения';
$messages['lang'] = 'Язык';
$messages['project'] = 'Проект';
$messages['project_example'] = 'Википедия, Викитека, Викимедиа…';
$messages['article'] = 'Страница';
$messages['needle'] = 'Строка для поиска';
$messages['skipversions'] = 'Всегда пропускать X версий';
$messages['ignorefirst'] = 'Не учитывать первые X версий';
$messages['limit'] = 'Количество версий для проверки';
$messages['start_date'] = 'Дата начала';
$messages['date_format'] = 'DD.MM.YYYY';
$messages['order'] = 'Порядок';
$messages['newest_first'] = 'вначале новейшие';
$messages['oldest_first'] = 'вначале старейшие';
$messages['binary_search_inverse'] = 'Поиск удаления текста (только двоичный)';
$messages['search_method'] = 'Способ поиска';
$messages['binary'] = 'двоичный';
$messages['binary_in_wp'] = 'http://ru.wikipedia.org/wiki/%D0%94%D0%B2%D0%BE%D0%B8%D1%87%D0%BD%D1%8B%D0%B9_%D0%BF%D0%BE%D0%B8%D1%81%D0%BA';
$messages['linear'] = 'линейный';
$messages['interpolated'] = 'двоичный (быстрее, если много версий)';
$messages['ignore_minors'] = 'не учитывать малые изменения (экспериментально)';
$messages['force_wikitags'] = 'произвести поиск викитекста';
$messages['start'] = 'Запустить';
$messages['reset'] = 'Сбросить';
$messages['manual'] = 'Руководство';
$messages['contact'] = 'Контактная информация';
$messages['get_less_versions'] = 'Ваш запрос может выдать __NUMREVISIONS__ версий за раз. В целях защиты сервера, за один вызов допускается запрашивать не более __ALLOWEDREVISIONS__ версий. Пожалуйста, измените настройки или переключитесь в двоичный режим поиска!';
$messages['wrong_skips'] = 'Ошибочные настройки. Если первые __VERSIONSTOSKIP__ версий будут пропущены, то ни одна из __VERSIONSTOSEARCH__ версий для поиска не будет обработана.';
$messages['search_in_progress_text'] = '<b>_NEEDLE_</b> ищется в истории версий _ARTICLELINK_ как обычный текст';
$messages['search_in_progress_wikitags'] = '<b>_NEEDLE_</b> ищется в истории версий _ARTICLELINK_ как викитекст';
$messages['no_differences'] = 'В найденных версиях нет различий.';
$messages['first_version'] = 'Изменение должно было произойти в первой или последней версии?';
$messages['first_version_present'] = '__NEEDLE__ уже присутствовала в первой ревизии, найденной начиная с __REVISIONLINK__.';
$messages['earlier_versions_available'] = 'Вероятно, есть в более ранних версиях.';
$messages['execution_time'] = 'Время выполнения: _EXECUTIONTIME_ секунд';
$messages['versions_found'] = 'Найдено _NUMBEROFVERSIONS_ версий страницы';
$messages['please_wait'] = 'Пожалуйста, подождите…';
$messages['binary_test'] = 'Сравнение различий _FIRSTDATEVERSION_ между _FIRSTNUMBER_ и _SECONDNUMBER_ при переходе с _SOURCENUMBER_:';
$messages['dead_end'] = 'Тупик (вероятно, вызван откатом или войной правок)';
$messages['once_more'] = 'Ещё раз, с чувством:';
$messages['binary_enough'] = 'Выполнено достаточно попыток, история статьи совершенно запуталась, пожалуйста, попробуйте изменить какие-нибудь параметры.';
$messages['insertion_found'] = 'Добавление обнаружено между LEFT_VERSION и RIGHT_VERSION';
$messages['deletion_found'] = 'Исключение обнаружено между LEFT_VERSION и RIGHT_VERSION';
$messages['help_translating'] = 'Помочь в переводе на translatewiki.net';
$messages['start_here'] = 'Начинать поиск отсюда';
$messages['too_much_versions'] = 'Достигнут предел запроса по количеству версий: __VERSIONLIMIT__. Пожалуйста, попробуйте ещё раз через __WAITMINUTES__ минут или переключитесь в двоичный режим. Извините за доставленные неудобства.';
$messages['not_found_at_all'] = 'По данному запросу ничего не найдено. Вы уверены, что, у вы задали правильные настройки?';
