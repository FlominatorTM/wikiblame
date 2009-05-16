<?php
$text_dir = 'ltr';

$messages['translator']='Mosca'; //
$messages['translator_link']='http://pt.wikipedia.org/wiki/Usu%C3%A1rio:Mosca'; 

//Form elements
$messages['lang']='Língua do projeto';
$messages['project']='Projeto';
$messages['article']='Página';
$messages['needle']='Procurar por';
$messages['skipversions']='Ignorar intervalos de x edições';
$messages['ignorefirst']='Ignorar as primeiras x edições';
$messages['limit']='Número de edições a verificar';
$messages['start_date'] = 'Começar pela data';
$messages['order'] = 'Ordem';
$messages['newest_first'] = 'recentes primeiro';
$messages['oldest_first'] = 'antigas primeiro';
$messages['search_method'] = 'Método de procura';
$messages['linear'] = 'linear';
$messages['interpolated']='interpolada (mais rápido para verificar muitas edições)';
$messages['ignore_minors']='ignorar edições menores (experimental)';
$messages['start'] ='Iniciar procura';
$messages['reset'] ='Data de hoje';
$messages['manual'] ='Instruções';
$messages['manual_link'] ='http://pt.wikipedia.org/wiki/Wikipedia:Ferramentas/WikiBlame';
$messages['contact']='Contacto';
$messages['contact_link']='http://de.wikipedia.org/wiki/Benutzer Diskussion:Flominator/WikiBlame';

//Output elements
$messages['wrong_skips'] = 'Configurações erradas: se as primeiras __VERSIONSTOSKIP__ edições são ignoradas, então nenhuma das __VERSIONSTOSEARCH__ edições a verificar serão processadas.';

$messages['search_in_progress'] = 'A pesquisar no histórico de edições do artigo _ARTICLELINK_ por <b>_NEEDLE_</b> ...';
$messages['execution_time'] = 'Tempo de execução: _EXECUTIONTIME_ segundos';
$messages['versions_found'] = '_NUMBEROFVERSIONS_ edições encontradas';

$messages['binary_test'] = 'A comparar diferenças em _FIRSTDATEVERSION_ entre _FIRSTNUMBER_ e _SECONDNUMBER_ a partir da _SOURCENUMBER_: ';
$messages['insertion_found'] = 'O texto foi adicionado entre a edição LEFT_VERSION e a edição RIGHT_VERSION';
$messages['deletion_found'] = 'O texto foi retirado entre a edição LEFT_VERSION e a edição RIGHT_VERSION';
?>
