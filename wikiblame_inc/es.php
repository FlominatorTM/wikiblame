<?php
/** WikiBlame
 *
 */
/** Spanish (español)
 * 
 * See the qqq 'language' for message documentation incl. usage of parameters
 * To improve a translation please visit https://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Armando-Martin
 * @author Athena in Wonderland
 * @author Crazymadlover
 * @author DJ Nietzsche
 * @author Fitoschido
 * @author KATRINE1992
 * @author Macofe
 * @author McDutchie
 * @author Od1n
 * @author Pertile
 * @author Peter17
 * @author VegaDark
 * @author XalD
 * @author XalD <hiperion93 AT gmail.com>
 */

$messages['January'] = 'Enero';
$messages['February'] = 'Febrero';
$messages['March'] = 'Marzo';
$messages['April'] = 'Abril';
$messages['May'] = 'Mayo';
$messages['June'] = 'Junio';
$messages['July'] = 'Julio';
$messages['August'] = 'Agosto';
$messages['September'] = 'Setiembre';
$messages['October'] = 'Octubre';
$messages['November'] = 'Noviembre';
$messages['December'] = 'Diciembre';
$messages['ui_lang'] = 'Idioma de visualización';
$messages['lang'] = 'Idioma';
$messages['project'] = 'Proyecto';
$messages['article'] = 'Artículo';
$messages['needle'] = 'Búsqueda';
$messages['skipversions'] = 'Saltar siempre x versiones';
$messages['ignorefirst'] = 'Ignorar las primeras x versiones';
$messages['limit'] = 'Versiones para revisar';
$messages['start_date'] = 'Fecha de inicio';
$messages['date_format'] = 'MM DD, AAAA';
$messages['revision_date_format'] = '%H:%M, %d %B %Y';
$messages['order'] = 'Orden';
$messages['newest_first'] = 'la última primero';
$messages['oldest_first'] = 'la más antigua primero';
$messages['binary_search_inverse'] = 'Buscar la eliminación de texto (solo binario)';
$messages['search_method'] = 'Método de búsqueda';
$messages['binary'] = 'binario';
$messages['linear'] = 'lineal';
$messages['interpolated'] = 'binario (más rápido con más versiones)';
$messages['ignore_minors'] = 'Ignorar ediciones menores (experimental)';
$messages['force_wikitags'] = 'Forzar la búsqueda de wikitexto';
$messages['from_url'] = 'a partir de un URL';
$messages['paste_url'] = 'Pega el URL de una página de MediaWiki';
$messages['no_valid_url'] = 'Este no es un URL de MediaWiki válido';
$messages['start'] = 'Iniciar';
$messages['reset'] = 'Restablecer';
$messages['manual'] = 'Manual';
$messages['manual_link'] = 'https://es.wikipedia.org/wiki/Usuario:XalD/WikiBlame';
$messages['contact'] = 'Contacto';
$messages['get_less_versions'] = 'Tu búsqueda podría consultar __NUMREVISIONS__ revisiones a la vez. Con el fin de proteger el servidor, solamente estás permitido consultar por __ALLOWEDREVISIONS__ por llamada. Por favor cambia la configuración o el método de búsqueda a binario.';
$messages['wrong_skips'] = 'Configuraciones erróneas: Si las primeras __VERSIONSTOSKIP__ versiones se omiten, entonces ninguna de las __VERSIONSTOSEARCH__ versiones que buscar se procesarán.';
$messages['search_in_progress_text'] = 'Se está buscando <b>_NEEDLE_</b> como texto sencillo en el historial de versiones de _ARTICLELINK_';
$messages['search_in_progress_wikitags'] = 'Se está buscando <b>_NEEDLE_</b> como texto wiki en el historial de versiones de _ARTICLELINK_';
$messages['no_differences'] = 'No se encontraron diferencias en las revisiones buscadas.';
$messages['inverse_restart'] = 'No se encontró ninguna inserción o extracción. ¿Se insertó el término de búsqueda después?';
$messages['inverse_stuck'] = 'No se encontró ninguna inserción ni eliminación en estas _NUMBEROFVERSIONS_ revisiones. Es posible que el término de búsqueda se haya quitado con anterioridad.';
$messages['inverse_earliest'] = 'Buscar en las revisiones anteriores';
$messages['first_version'] = '¿El cambio debió haber ocurrido en la primera o en la última revisión?';
$messages['first_version_present'] = '__NEEDLE__ ya estaba presente en la revisión más antigua buscada el __REVISIONLINK__.';
$messages['earlier_versions_available'] = 'Probablemente existan revisiones anteriores.';
$messages['execution_time'] = 'Tiempo de ejecución: _EXECUTIONTIME_ segundos';
$messages['versions_found'] = '_NUMBEROFVERSIONS_ versiones encontradas';
$messages['please_wait'] = 'Espera un momento…';
$messages['binary_test'] = 'Comparando diferencias en _FIRSTDATEVERSION_ entre _FIRSTNUMBER_ y _SECONDNUMBER_ cuando vengan de _SOURCENUMBER_:';
$messages['dead_end'] = 'Atrapados algunos sin salida (probablemente causados por reversiones o guerras de edición)';
$messages['once_more'] = 'Una vez más, con sentimiento:';
$messages['delete_from_here'] = 'Eliminar_NUMBEROFVERSIONS_earlier revisions, como ellas se han performado mas temprano';
$messages['delete_until_here'] = 'Eliminando _NUMBEROFVERSIONS_ later revisions, como la insercion debe qua haber sido performado mas temprano';
$messages['binary_enough'] = 'Se realizaron suficientes reintentos. El historial del artículo está en mal estado. Trata de cambiar algunas configuraciones.';
$messages['insertion_found'] = 'Inserción encontrada entre LEFT_VERSION y RIGHT_VERSION';
$messages['deletion_found'] = 'Borrado encontrado entre LEFT_VERSION y RIGHT_VERSION';
$messages['here'] = 'aquí';
$messages['help_translating'] = 'Ayuda traduciendo en translatewiki.net';
$messages['start_here'] = 'Búsqueda desde aquí';
$messages['too_much_versions'] = 'Has llegado a tu límite de consultas de __VERSIONLIMIT__ versiones. Por favor intenta nuevamente en __WAITMINUTES__ minutos o cambia a la búsqueda binaria.
Disculpa el inconveniente.';
$messages['not_found_at_all'] = 'No se ha encontrado tu término de búsqueda. Comprueba la configuración y vuelve a intentarlo.';
