<?php
/** Traditional Chinese (中文（繁體）)
 * 
 * See the qqq 'language' for message documentation incl. usage of parameters
 * To improve a translation please visit https://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author 578985s
 * @author A2093064
 * @author Bowleerin
 * @author Cookai1205
 * @author Diskdance
 * @author Frankou
 * @author Kly
 * @author LNDDYL
 * @author Lauhenry
 * @author Liuxinyu970226
 * @author Maskers
 * @author Od1n
 * @author Reke
 * @author Shangkuanlc
 * @author Tranve
 * @author Winston Sung
 * @author Wrightbus
 * @author Xiplus
 * @author 捍粵者
 */

$messages['January'] = '1月';
$messages['February'] = '2月';
$messages['March'] = '3月';
$messages['April'] = '4月';
$messages['May'] = '5月';
$messages['June'] = '6月';
$messages['July'] = '7月';
$messages['August'] = '8月';
$messages['September'] = '9月';
$messages['October'] = '10月';
$messages['November'] = '11月';
$messages['December'] = '12月';
$messages['ui_lang'] = '顯示語言';
$messages['lang'] = '語言';
$messages['project'] = '專案';
$messages['tld'] = '網域';
$messages['tld_example'] = 'org, com, net, …';
$messages['article'] = '頁面';
$messages['needle'] = '搜尋';
$messages['skipversions'] = '永遠跳過的版本數量';
$messages['ignorefirst'] = '略過開始的版本數量';
$messages['limit'] = '要檢查的版本數量';
$messages['start_date'] = '開始日期';
$messages['date_format'] = 'YYYY MM DD';
$messages['revision_date_format'] = '%Y年%B%d日 %H:%M';
$messages['order'] = '排列次序';
$messages['newest_first'] = '從最近開始';
$messages['oldest_first'] = '從最早開始';
$messages['binary_search_inverse'] = '尋找去除相關文字的編輯（僅適用於二分法）';
$messages['search_method'] = '搜尋方式';
$messages['binary'] = '二分法';
$messages['binary_in_wp'] = 'https://zh.wikipedia.org/wiki/二分搜尋演算法';
$messages['linear'] = '線性';
$messages['interpolated'] = '二分法（在版本較多時更快）';
$messages['ignore_minors'] = '略過小修改（實驗性功能）';
$messages['force_wikitags'] = '強制搜尋 wikitext';
$messages['from_url'] = '來自 URL';
$messages['paste_url'] = '請貼上至 MediaWiki 頁面的 URL';
$messages['no_valid_url'] = '這不是有效的 MediaWiki URL';
$messages['start'] = '開始';
$messages['reset'] = '重設';
$messages['manual'] = '手冊';
$messages['contact'] = '聯絡';
$messages['source_code'] = '在 GitHub 上的原始碼';
$messages['get_less_versions'] = '您的搜尋可能會在一次內回報 __NUMREVISIONS__ 個修訂版本，為了保護伺服器，您每次能取得的搜尋回報為 __ALLOWEDREVISIONS__ 個以內，請變更設定或把搜尋模式轉為二分法模式！';
$messages['wrong_skips'] = '設定錯誤：如果跳過首 __VERSIONSTOSKIP__ 個版本，要搜尋的 __VERSIONSTOSEARCH__ 個版本將不會被處理。';
$messages['search_in_progress_text'] = '_ARTICLELINK_的版本紀錄正以純文字<b>_NEEDLE_</b>搜尋';
$messages['search_in_progress_wikitags'] = '_ARTICLELINK_ 的版本記錄正在以wikitext <b>_NEEDLE_</b> 進行搜尋';
$messages['no_differences'] = '在尋找到的修訂版本中並未發現任何差異。';
$messages['inverse_restart'] = '查無插入或去除內容，搜尋項目是否是在之後插入？';
$messages['inverse_stuck'] = '在這些_NUMBEROFVERSIONS_修訂版本查無插入或去除內容。也許是稍早前搜尋項目就被移除？';
$messages['inverse_earliest'] = '在較舊的修訂版本搜尋';
$messages['first_version'] = '必須在第一個或最新修訂版本中出現更改嗎？';
$messages['first_version_present'] = '__NEEDLE__ 已經存在於追溯到 __REVISIONLINK__ 後最早的修訂版本。';
$messages['latest_version_present'] = '__NEEDLE__ 已經存在於追溯到 __REVISIONLINK__ 後最新的修訂版本。';
$messages['earlier_versions_available'] = '可能有較舊的修訂版本。';
$messages['execution_time'] = '執行時間：_EXECUTIONTIME_ 秒';
$messages['versions_found'] = '找到 _NUMBEROFVERSIONS_ 個版本';
$messages['please_wait'] = '請稍候…';
$messages['binary_test'] = '在 _SOURCENUMBER_ 個版本中，正在比較在第 _FIRSTNUMBER_ 個和第 _SECONDNUMBER_ 個版本之間 _FIRSTDATEVERSION_ 的差異：';
$messages['dead_end'] = '找到一些死胡同（可能由回退或編輯戰所造成）';
$messages['once_more'] = '再一次，有感而發：';
$messages['delete_from_here'] = '去除必須在之後，正在刪除之前_NUMBEROFVERSIONS_版修訂版';
$messages['delete_until_here'] = '插入必須在之前，正在刪除之後_NUMBEROFVERSIONS_版修訂版';
$messages['binary_enough'] = '重試次數已經達到一定程度，條目歷史已經相當混亂，請嘗試變更一些設定。';
$messages['insertion_found'] = '在 LEFT_VERSION 與 RIGHT_VERSION 之間發現文字插入記錄';
$messages['deletion_found'] = '在 LEFT_VERSION 與 RIGHT_VERSION 之間發現文字刪除記錄';
$messages['here'] = '這裡';
$messages['help_translating'] = '在 translatewiki.net 協助翻譯';
$messages['start_here'] = '由這裡開始搜尋';
$messages['too_much_versions'] = '您已經達到 __VERSIONLIMIT__ 個版本的搜尋限制，請在 __WAITMINUTES__ 分鐘後再試或以二分法方式搜尋。不便之處，敬請原諒。';
$messages['not_found_at_all'] = '您的搜尋字詞未能找到，確定搜尋設定正確嗎？';
