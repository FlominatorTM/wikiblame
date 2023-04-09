<?php
/** Japanese (日本語)
 *
 * See the qqq 'language' for message documentation incl. usage of parameters
 * To improve a translation please visit https://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Aotake
 * @author Flominator
 * @author Fryed-peach
 * @author Gulpin
 * @author Od1n
 * @author Omotecho
 * @author Otokoume
 * @author Shirayuki
 * @author Whym
 * @author Yamagata Yusuke
 * @author にょきにょき
 * @author もなー(偽物)
 * @author カッパ鳥
 */

$text_dir = '左書き';
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
$messages['ui_lang'] = '表示言語';
$messages['lang'] = '言語';
$messages['lang_example'] = 'ja, commons, www, …';
$messages['project'] = 'プロジェクト';
$messages['project_example'] = 'wikipedia, wikisource, wikimedia, wikidata, …';
$messages['tld'] = 'ドメイン';
$messages['tld_example'] = 'org, com, net, …';
$messages['article'] = 'ページ';
$messages['needle'] = '検索語';
$messages['skipversions'] = '常にX版をスキップ';
$messages['ignorefirst'] = '先頭のX版を無視';
$messages['limit'] = '検査する版数';
$messages['start_date'] = '開始日';
$messages['date_format'] = 'YYYY年MM月DD日';
$messages['revision_date_format'] = '%Y年%B%d日 %H:%M';
$messages['order'] = '順序';
$messages['newest_first'] = '新しい順';
$messages['oldest_first'] = '古い順';
$messages['binary_search_inverse'] = 'テキストの除去を探す (二分探索)';
$messages['search_method'] = '探索方法';
$messages['binary'] = '二分探索';
$messages['binary_in_wp'] = 'https://ja.wikipedia.org/wiki/二分探索';
$messages['linear'] = '線型';
$messages['interpolated'] = '二分探索 (版が多い場合はより速い)';
$messages['ignore_minors'] = '細部の編集を無視 (実験的)';
$messages['force_wikitags'] = 'ウィキテキストとして検索を強制';
$messages['from_url'] = 'URLから';
$messages['paste_url'] = 'MediaWiki ページのURLをコピーして貼り付けてください';
$messages['no_valid_url'] = '無効な MediaWiki URL です。';
$messages['start'] = '開始';
$messages['reset'] = 'リセット';
$messages['manual'] = 'マニュアル';
$messages['manual_link'] = 'https://ja.wikipedia.org/wiki/Wikipedia:ツール/WikiBlame';
$messages['contact'] = '連絡先';
$messages['contact_link'] = 'https://ja.wikipedia.org/wiki/Wikipedia:ツール/WikiBlame';
$messages['source_code'] = 'GitHub のソースコード';
$messages['get_less_versions'] = 'あなたの検索クエリは__NUMREVISIONS__件の版を一度に検査する可能性があります。サーバーを保護するため、一度の呼び出しで検査できる版数は__ALLOWEDREVISIONS__件以下に制限されています。設定を変更するか、検索方法を二分探索にしてください!';
$messages['wrong_skips'] = '設定の不備: 初めの__VERSIONSTOSKIP__版をとばしてしまうと、検査すべき__VERSIONSTOSEARCH__版のどれも処理されません。';
$messages['search_in_progress_text'] = '_ARTICLELINK_の版履歴は、<b>_NEEDLE_</b>をプレーンテキストとして検索中です';
$messages['search_in_progress_wikitags'] = '_ARTICLELINK_の版履歴は、<b>_NEEDLE_</b>をウィキテキストして検索中です';
$messages['no_differences'] = '検索された範囲の版で差分は見つかりませんでした。';
$messages['inverse_restart'] = '挿入や削除は見つかりませんでした。検索語があとで挿入されましたか？';
$messages['inverse_stuck'] = ' _NUMBEROFVERSIONS_ 件の履歴中に挿入や削除は見つかりませんでした。検索語は以前に削除されましたか？';
$messages['inverse_earliest'] = '古い版で検索';
$messages['first_version'] = '変更は最初か最新の版で起きていませんか?';
$messages['first_version_present'] = '__NEEDLE__は検索の結果、__REVISIONLINK__までに作成された初版に既に存在しています。';
$messages['latest_version_present'] = '__NEEDLE__は検索の結果、__REVISIONLINK__までに作成された初版に既に存在しています。';
$messages['earlier_versions_available'] = '以前の版が存在するかもしれません。';
$messages['execution_time'] = '実行時間: _EXECUTIONTIME_秒';
$messages['versions_found'] = '_NUMBEROFVERSIONS_件の版が見つかりました';
$messages['please_wait'] = 'お待ちください…';
$messages['binary_test'] = '_SOURCENUMBER_番の次に、_FIRSTDATEVERSION_における_FIRSTNUMBER_番と_SECONDNUMBER_番の差分を比較しています:';
$messages['dead_end'] = '行き止まりに入ってしまいました (理由はおそらくリバートか編集合戦です)';
$messages['once_more'] = 'もう一度、心を込めて:';
$messages['delete_from_here'] = '削除はそれ以降に実行された可能性があるため、_NUMBEROFVERSIONS_ 件の以前の履歴を削除しています';
$messages['delete_until_here'] = '削除はそれ以前に実行された可能性があるため、_NUMBEROFVERSIONS_ 件の以降の履歴を削除しています';
$messages['binary_enough'] = '何度か再試行しましたが、記事の履歴が非常に込み入っているため、設定を変えて試行してください。';
$messages['insertion_found'] = 'LEFT_VERSION と RIGHT_VERSION の間で挿入が見つかりました';
$messages['deletion_found'] = 'LEFT_VERSION と RIGHT_VERSION の間で挿入が見つかりました';
$messages['here'] = 'こちら';
$messages['help_translating'] = 'translatewiki.net で翻訳作業を手伝う';
$messages['start_here'] = 'ここから検索';
$messages['too_much_versions'] = '検索の上限である__VERSIONLIMIT__版に達しました。__WAITMINUTES__分待ってから再試行するか、二分探索に切り替えてください。ご迷惑をおかけしてしまい申し訳ありません。';
$messages['not_found_at_all'] = '検索語はまったく見つかりませんでした。設定を確認してから、もう一度試してください。';
