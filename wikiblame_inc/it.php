<?php
/** Italian (italiano)
 *
 * See the qqq 'language' for message documentation incl. usage of parameters
 * To improve a translation please visit https://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Ajeje Brazorf
 * @author Beta16
 * @author Civvì
 * @author Codicorumus
 * @author Darth Kule
 * @author Flominator
 * @author Fringio
 * @author Gianfranco
 * @author Lou Crazy
 * @author Macofe
 * @author Mannivu
 * @author Melos <nnico AT jumpy.it>
 * @author Od1n
 * @author Ontsed
 * @author Rippitippi
 * @author Selven
 * @author Toa
 */

$messages['January'] = 'Gennaio';
$messages['February'] = 'Febbraio';
$messages['March'] = 'Marzo';
$messages['April'] = 'Aprile';
$messages['May'] = 'Maggio';
$messages['June'] = 'Giugno';
$messages['July'] = 'Luglio';
$messages['August'] = 'Agosto';
$messages['September'] = 'Settembre';
$messages['October'] = 'Ottobre';
$messages['November'] = 'Novembre';
$messages['December'] = 'Dicembre';
$messages['ui_lang'] = 'Lingua di visualizzazione';
$messages['lang'] = 'Lingua';
$messages['project'] = 'Progetto';
$messages['tld'] = 'Dominio';
$messages['tld_example'] = 'org, com, net, ...';
$messages['article'] = 'Pagina';
$messages['needle'] = 'Cerca';
$messages['skipversions'] = 'Escludi sempre x versioni';
$messages['ignorefirst'] = 'Ignora le prime x versioni';
$messages['limit'] = 'Versioni da controllare';
$messages['start_date'] = 'Data inizio';
$messages['date_format'] = 'DD MM YYYY';
$messages['revision_date_format'] = '%d %B %Y, %H:%M';
$messages['order'] = 'Ordinamento';
$messages['newest_first'] = 'prima le più recenti';
$messages['oldest_first'] = 'prima le meno recenti';
$messages['binary_search_inverse'] = 'Cerca la rimozione del testo (solo binario)';
$messages['search_method'] = 'Metodo di ricerca';
$messages['binary'] = 'binario';
$messages['binary_in_wp'] = 'https://it.wikipedia.org/wiki/Ricerca_dicotomica';
$messages['linear'] = 'lineare';
$messages['interpolated'] = 'binario (più veloce con molte versioni da controllare)';
$messages['ignore_minors'] = 'ignora le modifiche minori (sperimentale)';
$messages['force_wikitags'] = 'forza la ricerca di wikitext';
$messages['from_url'] = 'dall’URL';
$messages['paste_url'] = 'Incollare l’URL della pagina MediaWiki';
$messages['no_valid_url'] = 'Non è un URL MediaWiki valido';
$messages['start'] = 'Inizia';
$messages['reset'] = 'Reimposta';
$messages['manual'] = 'Manuale';
$messages['manual_link'] = 'https://it.wikipedia.org/wiki/Utente:Darth_Kule/WikiBlame';
$messages['contact'] = 'Contatto';
$messages['source_code'] = 'Codice sorgente su GitHub';
$messages['get_less_versions'] = 'La ricerca potrebbe controllare __NUMREVISIONS__ revisioni alla volta. Al fine di proteggere il server, però, si possono controllare soltanto __ALLOWEDREVISIONS__ revisioni per volta. Per favore modifica le impostazioni, oppure passa al metodo di ricerca binario!';
$messages['wrong_skips'] = 'Impostazioni sbagliate: se le prime __VERSIONSTOSKIP__
versioni vengono saltate, allora nessuna delle __VERSIONSTOSEARCH__ versioni
da ricercare sarà processata.';
$messages['search_in_progress_text'] = 'La cronologia di _ARTICLELINK_ viene ora analizzata alla ricerca di <b>_NEEDLE_</b> come testo semplice';
$messages['search_in_progress_wikitags'] = 'La cronologia di _ARTICLELINK_ viene ora analizzata alla ricerca di <b>_NEEDLE_</b> come testo wiki';
$messages['no_differences'] = 'Nessuna differenza nelle revisioni trovate.';
$messages['inverse_restart'] = 'Nessun inserimento o rimozione trovati, il termine di ricerca è stato inserito in un secondo momento?';
$messages['inverse_stuck'] = 'Non sono stati trovati inserimenti o rimozioni in queste _NUMBEROFVERSIONS_ revisioni. Forse il termine di ricerca è stato rimosso precedentemente?';
$messages['inverse_earliest'] = 'Ricerca in versioni precedenti';
$messages['first_version'] = 'La modifica è avvenuta nella prima o nell\'ultima revisione?';
$messages['first_version_present'] = '__NEEDLE__ era già presente nella versione più vecchia cercata del __REVISIONLINK__.';
$messages['latest_version_present'] = '__NEEDLE__ era già presente nella versione più recente ricercata del __REVISIONLINK__.';
$messages['earlier_versions_available'] = 'Probabilmente ci sono versioni più vecchie.';
$messages['execution_time'] = 'Tempo di esecuzione: _EXECUTIONTIME_ secondi';
$messages['versions_found'] = '_NUMBEROFVERSIONS_ revisioni trovate';
$messages['please_wait'] = 'Attendere prego …';
$messages['binary_test'] = 'Confronto delle differenze nella revisione del _FIRSTDATEVERSION_ fra la revisione _FIRSTNUMBER_ e la _SECONDNUMBER_ mentre proviene dalla revisione _SOURCENUMBER_:';
$messages['dead_end'] = 'Trovato un punto morto (probabilmente causato da rollback o edit war)';
$messages['once_more'] = 'Ancora una volta, con sentimento:';
$messages['delete_from_here'] = 'Cancellando _NUMBEROFVERSIONS_ versioni precedenti, poiché la rimozione deve essere stata eseguita in seguito';
$messages['delete_until_here'] = 'Cancellando _NUMBEROFVERSIONS_ versioni successive, poiché l\'inserimento deve essere stata eseguita in precedenza';
$messages['binary_enough'] = 'Eseguiti sufficienti tentativi, la cronologia della voce è purtroppo abbastanza in disordine, prova a cambiare qualche impostazione.';
$messages['insertion_found'] = 'Inserimento della parola trovato fra la revisione del LEFT_VERSION e quella del RIGHT_VERSION';
$messages['deletion_found'] = 'Cancellazione trovata fra LEFT_VERSION e RIGHT_VERSION';
$messages['here'] = 'qui';
$messages['help_translating'] = 'Aiuta a tradurre su translatewiki.net';
$messages['start_here'] = 'Cerca da qui';
$messages['too_much_versions'] = 'Hai raggiunto il limite massimo  di __VERSIONLIMIT__ richieste. Si prega di riprovare passati __WAITMINUTES__ o passare alla ricerca binaria. Ci scusiamo per l\'inconveniente.';
$messages['not_found_at_all'] = 'Il termine di ricerca non è stato proprio trovato. Controlla le impostazioni e riprova.';
