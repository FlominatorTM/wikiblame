<?php
/** Brazilian Portuguese (português do Brasil)
 * 
 * See the qqq 'language' for message documentation incl. usage of parameters
 * To improve a translation please visit https://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author !Silent
 * @author Amgauna
 * @author ArgonSim
 * @author Athena in Wonderland
 * @author Capmo
 * @author Dianakc
 * @author Duke of Wikipädia
 * @author Eduardo Addad de Oliveira
 * @author Eduardoaddad
 * @author Giro720
 * @author Luckas
 * @author Luckas Blade
 * @author MisterSanderson
 * @author MuratTheTurkish
 * @author Pedroca cerebral
 * @author Raylton P. Sousa
 * @author Re demz
 * @author TheEduGobi
 * @author TheGabrielZaum
 * @author Tuliouel
 */

$text_dir = 'ltr';
$messages['January'] = 'janeiro';
$messages['February'] = 'fevereiro';
$messages['March'] = 'março';
$messages['April'] = 'abril';
$messages['May'] = 'maio';
$messages['June'] = 'junho';
$messages['July'] = 'julho';
$messages['August'] = 'agosto';
$messages['September'] = 'setembro';
$messages['October'] = 'outubro';
$messages['November'] = 'novembro';
$messages['December'] = 'dezembro';
$messages['ui_lang'] = 'Idioma de exibição';
$messages['lang'] = 'Idioma';
$messages['lang_example'] = 'pt, commons, www, …';
$messages['project'] = 'Projeto';
$messages['project_example'] = 'wikipédia, wikisource, wikimedia, wikidata, …';
$messages['tld'] = 'Domínio';
$messages['tld_example'] = 'org, com, net, …';
$messages['article'] = 'Página';
$messages['needle'] = 'Procurar por';
$messages['skipversions'] = 'Sempre saltar x versões';
$messages['ignorefirst'] = 'Ignorar as primeiras x edições';
$messages['limit'] = 'Versões a checar';
$messages['start_date'] = 'Data de início';
$messages['date_format'] = 'DD/MM/YYYY';
$messages['revision_date_format'] = '%H:%M, %d %B %Y';
$messages['order'] = 'Ordem';
$messages['newest_first'] = 'mais recentes primeiro';
$messages['oldest_first'] = 'mais antigos primeiro';
$messages['binary_search_inverse'] = 'Procurar remoção de texto (somente binário)';
$messages['search_method'] = 'Método de pesquisa';
$messages['binary'] = 'binária';
$messages['binary_in_wp'] = 'https://pt.wikipedia.org/wiki/Pesquisa_binária';
$messages['linear'] = 'linear';
$messages['interpolated'] = 'binária (mais rápida para pesquisar muitas edições)';
$messages['ignore_minors'] = 'ignorar edições menores (experimental)';
$messages['force_wikitags'] = 'forçar a procura de texto wiki';
$messages['from_url'] = 'a partir do url';
$messages['paste_url'] = 'Por favor, insira o url de uma página MediaWiki';
$messages['no_valid_url'] = 'Este url do MediaWiki não é válido';
$messages['start'] = 'Iniciar procura';
$messages['reset'] = 'Redefinir';
$messages['manual'] = 'Manual';
$messages['manual_link'] = 'https://pt.wikipedia.org/wiki/Wikip%C3%A9dia:Ferramentas/WikiBlame';
$messages['contact'] = 'Contato';
$messages['contact_link'] = 'https://de.wikipedia.org/wiki/Benutzer Diskussion:Flominator/WikiBlame';
$messages['source_code'] = 'Código-fonte no GitHub';
$messages['get_less_versions'] = 'A sua pesquisa pode consultar __NUMREVISIONS__ edições ao mesmo tempo. Para proteger o servidor, só pode consultar __ALLOWEDREVISIONS__ por chamada. Por favor, altere a configuração ou mude o método de pesquisa para binária.';
$messages['wrong_skips'] = 'Configurações erradas: Se as primeiras __VERSIONSTOSKIP__ edições são ignoradas, então nenhuma das __VERSIONSTOSEARCH__ edições a verificar serão processadas.';
$messages['search_in_progress_text'] = '<b>_NEEDLE_</b> está a ser procurado como texto não formatado no histórico de edições de _ARTICLELINK_';
$messages['search_in_progress_wikitags'] = '<b>_NEEDLE_</b> está a ser procurado como código wiki no histórico de edições de _ARTICLELINK_';
$messages['no_differences'] = 'Não foram encontradas diferenças nas versões pesquisadas.';
$messages['inverse_restart'] = 'Nenhuma inserção ou remoção encontrada, o termo de pesquisa foi inserido depois?';
$messages['inverse_stuck'] = 'Não foram encontradas introduções ou eliminações nestas _NUMBEROFVERSIONS_ revisões. O termo procurado foi eliminado anteriormente?';
$messages['inverse_earliest'] = 'Pesquisar nas revisões anteriores';
$messages['first_version'] = 'A mudança deve ter acontecido na primeira ou última versão?';
$messages['first_version_present'] = '__NEEDLE__ já estava presente na versão mais antiga buscada, datada de __REVISIONLINK__.';
$messages['latest_version_present'] = '__NEEDLE__ já estava presente na revisão mais recente pesquisada, cuja data é __REVISIONLINK__.';
$messages['earlier_versions_available'] = 'Provavelmente existem revisões mais antigas.';
$messages['execution_time'] = 'Tempo de execução: _EXECUTIONTIME_ segundos';
$messages['versions_found'] = '_NUMBEROFVERSIONS_ edições encontradas';
$messages['please_wait'] = 'Aguarde, por favor …';
$messages['binary_test'] = 'Comparando diferenças em _FIRSTDATEVERSION_ entre _FIRSTNUMBER_ e _SECONDNUMBER_ a partir da _SOURCENUMBER_:';
$messages['dead_end'] = 'Encontrado um beco sem saída (provavelmente causado por reversões ou guerras de edição)';
$messages['once_more'] = 'Mais uma vez, com sentimento:';
$messages['delete_from_here'] = 'Eliminando _NUMBEROFVERSIONS_ revisões anteriores, já que a remoção deve ter sido realizada posteriormente';
$messages['delete_until_here'] = 'Eliminando _NUMBEROFVERSIONS_ revisões posteriores, visto que a inserção deve ter sido realizada anteriormente';
$messages['binary_enough'] = 'Foram realizadas várias tentativas, mas o histórico do artigo está bastante confuso. Por favor altere algumas configurações.';
$messages['insertion_found'] = 'O texto foi adicionado entre a edição LEFT_VERSION e a edição RIGHT_VERSION';
$messages['deletion_found'] = 'O texto foi retirado entre a edição LEFT_VERSION e a edição RIGHT_VERSION';
$messages['here'] = 'aqui';
$messages['help_translating'] = 'Ajude a traduzir no translatewiki.net';
$messages['start_here'] = 'Procurar a partir daqui';
$messages['too_much_versions'] = 'Você atingiu o seu limite de consultas, de __VERSIONLIMIT__ versões. Tente novamente dentro de __WAITMINUTES__ minutos ou mude para pesquisa binária. Desculpe pelo transtorno.';
$messages['not_found_at_all'] = 'Seu termo não foi encontrado. Verifique as configurações e tente outra vez.';
