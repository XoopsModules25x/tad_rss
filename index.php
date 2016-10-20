<?php
/*-----------�ޤJ�ɮװ�--------------*/
include "header.php";
$xoopsOption['template_main'] = set_bootstrap("tad_rss_index.html");
include_once XOOPS_ROOT_PATH . "/header.php";
/*-----------function��--------------*/

//�C�X�Ҧ�tad_rss���
function list_tad_rss($maxitems = 5)
{
    global $xoopsDB, $xoopsModule, $xoopsModuleConfig, $xoopsTpl;

    $sql = "select * from " . $xoopsDB->prefix("tad_rss") . " where enable='1'";

    $result = $xoopsDB->query($sql) or web_error($sql);

    $data = "";
    $i    = 0;
    while ($all = $xoopsDB->fetchArray($result)) {
        //�H�U�|���ͳo���ܼơG $rss_sn , $title , $url , $enable
        foreach ($all as $k => $v) {
            $$k = $v;
        }

        $rss = get_rss_by_simplepie($rss_sn, $url, $maxitems);

        $data[$i]['title']   = $title;
        $data[$i]['rss_sn']  = $rss_sn;
        $data[$i]['url']     = $url;
        $data[$i]['link']    = $rss['web']['link'];
        $data[$i]['content'] = $rss['content'];

        //die($rss['content']);
        $i++;
    }
    $xoopsTpl->assign('data', $data);
}

//�H simplepie �Ө��oRSS
function get_rss_by_simplepie($rss_sn = "", $url = "", $maxitems = 5)
{

    require_once XOOPS_ROOT_PATH . '/modules/tad_rss/class/simplepie/SimplePie.php';
    $feed = new SimplePie();
    $feed->set_output_encoding(_CHARSET);
    $feed->set_feed_url($url);
    $feed->set_cache_location(XOOPS_ROOT_PATH . "/uploads/simplepie_cache");
    $feed->init();
    $feed->handle_content_type();

    $arr['web']['title']       = $feed->get_title();
    $arr['web']['link']        = $feed->get_permalink();
    $arr['web']['description'] = $feed->get_description();

    $content = "";
    $i       = 0;
    foreach ($feed->get_items(0, $maxitems) as $item) {
        $href        = $item->get_permalink();
        $title       = $item->get_title();
        $date        = $item->get_date("Y-m-d");
        $description = $item->get_description();

        $content[$i]['date']        = $date;
        $content[$i]['href']        = $href;
        $content[$i]['title']       = $title;
        $content[$i]['description'] = nl2br(strip_tags($description));
        $i++;
    }

    $arr['webinfo'] = "<a href='{$arr['web']['link']}' target='_blank'>{$arr['web']['title']}</a>";
    $arr['content'] = $content;
    return $arr;
}

/*-----------����ʧ@�P�_��----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');

$xoopsTpl->assign("toolbar", toolbar_bootstrap($interface_menu));
$xoopsTpl->assign("isAdmin", $isAdmin);
$xoopsTpl->assign("jquery", get_jquery(true));

switch ($op) {

    default:
        list_tad_rss($xoopsModuleConfig['show_num']);
        break;
}

/*-----------�q�X���G��--------------*/
include_once XOOPS_ROOT_PATH . '/footer.php';
