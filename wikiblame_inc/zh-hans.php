<?php
/** Simplified Chinese (中文（简体）)
 * 
 * See the qqq 'language' for message documentation incl. usage of parameters
 * To improve a translation please visit https://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Bencmq
 * @author Dimension
 * @author Hydra
 * @author Liuxinyu970226
 * @author Od1n
 * @author PhiLiP
 * @author Shizhao
 * @author VulpesVulpes825
 * @author Yfdyh000
 * @author 阿pp
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
$messages['ui_lang'] = '显示语言';
$messages['lang'] = '语言';
$messages['project'] = '项目';
$messages['article'] = '页面';
$messages['needle'] = '搜索';
$messages['skipversions'] = '总是跳过x个版本';
$messages['ignorefirst'] = '忽略开始的x个版本';
$messages['limit'] = '要检查的版本数量';
$messages['start_date'] = '开始日期';
$messages['date_format'] = 'YYYY MM DD';
$messages['revision_date_format'] = '%Y年%B%d日 %H:%M';
$messages['order'] = '排序';
$messages['newest_first'] = '从最近开始';
$messages['oldest_first'] = '从最早开始';
$messages['binary_search_inverse'] = '搜索移除相关文本的编辑（仅限二分法搜索）';
$messages['search_method'] = '搜索方式';
$messages['binary'] = '二分法';
$messages['binary_in_wp'] = 'https://zh.wikipedia.org/wiki/二分搜索算法';
$messages['linear'] = '线性';
$messages['interpolated'] = '二分法（在版本更多时更快）';
$messages['ignore_minors'] = '忽略小修改（实验功能）';
$messages['force_wikitags'] = '强制搜索wiki文本';
$messages['from_url'] = '来自url';
$messages['paste_url'] = '请粘贴utl到MediaWiki页面';
$messages['no_valid_url'] = '这不是有效的MediaWiki url';
$messages['start'] = '开始';
$messages['reset'] = '重置';
$messages['manual'] = '手册';
$messages['manual_link'] = 'https://zh.wikipedia.org/wiki/User:Gqqnb/WikiBlame文档';
$messages['contact'] = '联系';
$messages['get_less_versions'] = '您的搜索可能一次查询 __NUMREVISIONS__ 个修订版本。为了保护服务器，您的每次调用只被允许查询 __ALLOWEDREVISIONS__ 个修订。请更改设置或切换查询模式到二分法搜索！';
$messages['wrong_skips'] = '错误的设置：如果跳过__VERSIONSTOSKIP__个版本，那么要搜索的__VERSIONSTOSEARCH__个版本将不会被处理。';
$messages['search_in_progress_text'] = '_ARTICLELINK_的版本记录正在以<b>_NEEDLE_</b>作为纯文本进行搜索';
$messages['search_in_progress_wikitags'] = '_ARTICLELINK_的版本记录正在以<b>_NEEDLE_</b>作为wiki文本进行搜索';
$messages['no_differences'] = '搜索修订中没有发现差异。';
$messages['inverse_restart'] = '找不到插入或移除的内容，搜索关键词是否已在之后插入？';
$messages['inverse_stuck'] = '在这些_NUMBEROFVERSIONS_个修订版本中找不到插入或移除物。搜索词或许早就被移除？';
$messages['inverse_earliest'] = '在早期修订版本中搜索';
$messages['first_version'] = '更改是在第一个或最新的版本中发生的吧？';
$messages['first_version_present'] = '__NEEDLE__已存在于最旧修订版本，搜索可追溯到__REVISIONLINK__。';
$messages['latest_version_present'] = '__NEEDLE__已存在于最新修订版本，搜索可追溯到__REVISIONLINK__。';
$messages['earlier_versions_available'] = '可能存在更旧的修订版本。';
$messages['execution_time'] = '执行时间：_EXECUTIONTIME_秒';
$messages['versions_found'] = '发现 _NUMBEROFVERSIONS_ 个版本';
$messages['please_wait'] = '请稍等 …';
$messages['binary_test'] = '由 _SOURCENUMBER_ 开始，正在比较在 _FIRSTNUMBER_ 和 _SECONDNUMBER_ 之间的差异 _FIRSTDATEVERSION_ ：';
$messages['dead_end'] = '发现一些循环（可能由回退或编辑战引起）';
$messages['once_more'] = '再来一次：';
$messages['delete_from_here'] = '正在删除_NUMBEROFVERSIONS_个早期修订版本，因为移除必须在此之后进行';
$messages['delete_until_here'] = '正在删除_NUMBEROFVERSIONS_个早期修订版本，因为插入必须在此之前进行';
$messages['binary_enough'] = '重试次数够多了，条目历史太乱了，请试着更改某些设置。';
$messages['insertion_found'] = '目标在 LEFT_VERSION 和 RIGHT_VERSION 之间被加入';
$messages['deletion_found'] = '目标在 LEFT_VERSION 和 RIGHT_VERSION 之间被删除';
$messages['here'] = '这里';
$messages['help_translating'] = '在Translatewiki.net帮助翻译';
$messages['start_here'] = '从这里开始搜索';
$messages['too_much_versions'] = '您已到达您的 __VERSIONLIMIT__ 个版本的查询限制。请在 __WAITMINUTES__ 分钟后再试，或切换到二分法搜索。不便之处，敬请原谅。';
$messages['not_found_at_all'] = '完全找不到您的搜寻词。请检查设置后重试。';
