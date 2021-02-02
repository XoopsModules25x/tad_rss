<?php
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
$xoopsOption['template_main']  = 'tad_rss_adm_main.tpl';
require_once __DIR__ . '/header.php';
require_once dirname(__DIR__) . '/function.php';

/*-----------function區--------------*/
//tad_rss編輯表單
function tad_rss_form($rss_sn = '')
{
    global $xoopsDB, $xoopsUser, $xoopsTpl;

    //抓取預設值
    if (!empty($rss_sn)) {
        $DBV = get_tad_rss($rss_sn);
    } else {
        $DBV = [];
    }

    //預設值設定

    //設定「rss_sn」欄位預設值
    $rss_sn = (!isset($DBV['rss_sn'])) ? '' : $DBV['rss_sn'];

    //設定「title」欄位預設值
    $title = (!isset($DBV['title'])) ? '' : $DBV['title'];

    //設定「url」欄位預設值
    $rss_url = (!isset($DBV['url'])) ? '' : $DBV['url'];

    //設定「enable」欄位預設值
    $enable = (!isset($DBV['enable'])) ? '1' : $DBV['enable'];

    $op = (empty($rss_sn)) ? 'insert_tad_rss' : 'update_tad_rss';

    $xoopsTpl->assign('rss_sn', $rss_sn);
    $xoopsTpl->assign('title', $title);
    $xoopsTpl->assign('enable', $enable);
    $xoopsTpl->assign('rss_url', $rss_url);
    $xoopsTpl->assign('next_op', $op);
}

//新增資料到tad_rss中
function insert_tad_rss()
{
    global $xoopsDB, $xoopsUser;

    require_once dirname(__DIR__) . '/class/simplepie/SimplePie.php';
    $feed = new SimplePie();
    $feed->set_feed_url($_POST['url']);
    $feed->set_cache_location(XOOPS_ROOT_PATH . '/uploads/simplepie_cache');
    $feed->init();
    $feed->handle_content_type();
    $feed->set_output_encoding(_CHARSET);
    $title = $feed->get_title();

    $sql = 'insert into ' . $xoopsDB->prefix('tad_rss') . "
	(`title` , `url` , `enable`)
	values('{$title}' , '{$_POST['url']}' , '1')";
    $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    //取得最後新增資料的流水編號
    $rss_sn = $xoopsDB->getInsertId();

    return $rss_sn;
}

//列出所有tad_rss資料
function list_tad_rss($rss_sn = 1)
{
    global $xoopsDB, $xoopsModule, $xoopsTpl;

    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('tad_rss') . '';

    //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
    $PageBar = Utility::getPageBar($sql, 20, 10);
    $bar = $PageBar['bar'];
    $sql = $PageBar['sql'];

    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $all_data = [];
    $i = 0;
    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        //以下會產生這些變數： $rss_sn , $title , $url , $enable
        foreach ($all as $k => $v) {
            $$k = $v;
        }

        $all_data[$i]['title'] = $title;
        $all_data[$i]['url'] = $url;
        $all_data[$i]['enable'] = $enable;
        $all_data[$i]['rss_sn'] = $rss_sn;
        $new_enable = 1 == $enable ? 0 : 1;
        $all_data[$i]['new_enable'] = $new_enable;
        $i++;
    }

    $xoopsTpl->assign('all_data', $all_data);
    $xoopsTpl->assign('bar', $bar);
}

//以流水號取得某筆tad_rss資料
function get_tad_rss($rss_sn = '')
{
    global $xoopsDB;
    if (empty($rss_sn)) {
        return;
    }

    $sql = 'select * from ' . $xoopsDB->prefix('tad_rss') . " where rss_sn='$rss_sn'";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $data = $xoopsDB->fetchArray($result);

    return $data;
}

//更新tad_rss某一筆資料
function update_tad_rss($rss_sn = '')
{
    global $xoopsDB, $xoopsUser;

    $sql = 'update ' . $xoopsDB->prefix('tad_rss') . " set
	 `title` = '{$_POST['title']}' ,
	 `url` = '{$_POST['url']}' ,
	 `enable` = '{$_POST['enable']}'
	where rss_sn='$rss_sn'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    return $rss_sn;
}

//更新狀態
function change_enable($rss_sn, $enable = '1')
{
    global $xoopsDB, $xoopsUser;

    $sql = 'update ' . $xoopsDB->prefix('tad_rss') . " set `enable` = '{$enable}' where rss_sn='$rss_sn'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
}

//刪除tad_rss某筆資料資料
function delete_tad_rss($rss_sn = '')
{
    global $xoopsDB;
    $sql = 'delete from ' . $xoopsDB->prefix('tad_rss') . " where rss_sn='$rss_sn'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
}

/*-----------執行動作判斷區----------*/
require_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$rss_sn = system_CleanVars($_REQUEST, 'rss_sn', 0, 'int');
$enable = system_CleanVars($_REQUEST, 'enable', 1, 'int');

switch ($op) {
    /*---判斷動作請貼在下方---*/

    //更新資料
    case 'update_tad_rss':
        update_tad_rss($rss_sn);
        header("location: {$_SERVER['PHP_SELF']}");
        break;
    //新增資料
    case 'insert_tad_rss':
        insert_tad_rss();
        header("location: {$_SERVER['PHP_SELF']}");
        break;
    //刪除資料
    case 'delete_tad_rss':
        delete_tad_rss($rss_sn);
        header("location: {$_SERVER['PHP_SELF']}");
        break;
    case 'change_enable':
        change_enable($rss_sn, $enable);
        header("location: {$_SERVER['PHP_SELF']}");
        break;
    //預設動作
    default:
        tad_rss_form($rss_sn);
        list_tad_rss($rss_sn);
        break;
        /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
require_once __DIR__ . '/footer.php';
