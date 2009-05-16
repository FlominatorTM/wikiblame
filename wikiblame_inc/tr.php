<?
$text_dir = 'ltr';

//Form elements
$messages['lang']='Dil';  // Language
$messages['project']='Proje';  // Project
$messages['article']='Madde';  // Article
$messages['needle']='Arama';  // Search
$messages['skipversions']='Her zaman x sürümünü atla';  // Always skip x versions
$messages['ignorefirst']='Her zaman ilk x sürümü atla';  // Ignore first x versions
$messages['limit']='İncelenecek sürümler'; // Versions to check
$messages['start_date'] = 'Başlangıç tarihi'; // Start date
$messages['order'] = 'Sıra'; // Order
$messages['newest_first'] = "Sondan birinci";  // Latest first
$messages['oldest_first'] = "Baştan birinci"; // Oldest first
$messages['search_method'] = 'Arama tipi'; // Search method
$messages['linear'] = 'lineer'; // Linear
$messages['interpolated']='interpol (fazla sürüm sayısı varsa daha hızı arar)'; // interpolated (faster with more versions)
$messages['ignore_minors']='ignore minor changes (experimental)';
$messages['start'] ='Başla';  // Start
$messages['reset'] ='Reset';
$messages['manual'] ='Manuel'; // Manual
//$messages['manual_link'] ='http://de.wikipedia.org/wiki/Benutzer:Flominator/WikiBlame';
$messages['contact']='Bağlantı'; // Contact
//$messages['contact_link']='httpde.wikipedia.org/wiki/Kullanıcı mesaj:Flominator/WikiBlame';

//Output elements
$messages['search_in_progress'] = "_ARTICLELINK_ maddesinin sürüm geçmişinde <b>_NEEDLE_</b> aranıyor..."; // The version history of _ARTICLELINK_ is being searched for <b>_NEEDLE_</b> ...
$messages['execution_time'] = "Çalıştoğı süre: _EXECUTIONTIME_ saniye";  // Exectution Time: _EXECUTIONTIME_ seconds
$messages['versions_found'] = '_NUMBEROFVERSIONS_ sürüm bulundu';  // _NUMBEROFVERSIONS_ versions found
$messages['binary_test'] = 'Comparing differences in _FIRSTDATEVERSION_ between _FIRSTNUMBER_ and _SECONDNUMBER_ while coming from _SOURCENUMBER_: '; 
								
$messages['insertion_found'] = 'Insertion found between LEFT_VERSION and RIGHT_VERSION';
$messages['deletion_found'] = 'Deletion found between LEFT_VERSION and RIGHT_VERSION';
?>