<?php

global $xoopsConfig;

$modversion = [];

//---模組基本資訊---//
$modversion['name'] = _MI_TADRSS_NAME;
$modversion['version'] = 2.35;
$modversion['description'] = _MI_TADRSS_DESC;
$modversion['author'] = _MI_TADRSS_AUTHOR;
$modversion['credits'] = _MI_TADRSS_CREDITS;
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image'] = "images/logo_{$xoopsConfig['language']}.png";
$modversion['dirname'] = basename(__DIR__);

//---模組狀態資訊---//
$modversion['release_date'] = '2020-03-15';
$modversion['module_website_url'] = 'https://tad0616.net/';
$modversion['module_website_name'] = _MI_TAD_WEB;
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'https://tad0616.net/';
$modversion['author_website_name'] = _MI_TAD_WEB;
$modversion['min_php'] = 5.3;
$modversion['min_xoops'] = '2.5';

//---paypal資訊---//
$modversion['paypal'] = [];
$modversion['paypal']['business'] = 'tad0616@gmail.com';
$modversion['paypal']['item_name'] = 'Donation : ' . _MI_TAD_WEB;
$modversion['paypal']['amount'] = 0;
$modversion['paypal']['currency_code'] = 'USD';

//---資料表架構---//
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][1] = 'tad_rss';

//---啟動後台管理界面選單---//
$modversion['system_menu'] = 1;

//---管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

//---使用者主選單設定---//
$modversion['hasMain'] = 1;

$modversion['onInstall'] = 'include/onInstall.php';
$modversion['onUpdate'] = 'include/onUpdate.php';

//---樣板設定---//
$modversion['templates'] = [];
$i = 1;
$modversion['templates'][$i]['file'] = 'tad_rss_index.tpl';
$modversion['templates'][$i]['description'] = 'tad_rss_index.tpl';

$i++;
$modversion['templates'][$i]['file'] = 'tad_rss_adm_main.tpl';
$modversion['templates'][$i]['description'] = 'tad_rss_adm_main.tpl';

//---區塊設定---//
$modversion['blocks'][1]['file'] = 'tad_rss_show.php';
$modversion['blocks'][1]['name'] = _MI_TADRSS_BNAME1;
$modversion['blocks'][1]['description'] = _MI_TADRSS_BDESC1;
$modversion['blocks'][1]['show_func'] = 'tad_rss_show';
$modversion['blocks'][1]['template'] = 'tad_rss_show.tpl';
$modversion['blocks'][1]['edit_func'] = 'tad_rss_show_edit';
$modversion['blocks'][1]['options'] = '|10';

//---偏好設定---//
$modversion['config'][1]['name'] = 'show_num';
$modversion['config'][1]['title'] = '_MI_TADRSS_SHOW_NUM';
$modversion['config'][1]['description'] = '_MI_TADRSS_SHOW_NUM_DESC';
$modversion['config'][1]['formtype'] = 'textbox';
$modversion['config'][1]['valuetype'] = 'int';
$modversion['config'][1]['default'] = '10';

$modversion['config'][2]['name'] = 'use_pda';
$modversion['config'][2]['title'] = '_MI_USE_PDA_TITLE';
$modversion['config'][2]['description'] = '_MI_USE_PDA_TITLE_DESC';
$modversion['config'][2]['formtype'] = 'yesno';
$modversion['config'][2]['valuetype'] = 'int';
$modversion['config'][2]['default'] = '1';
