<?php

require_once XOOPS_ROOT_PATH . '/modules/tad_rss/function_block.php';

//區塊主函式 (友站消息(tad_rss_show))
function tad_rss_show($options = ['', 3, 170])
{
    global $xoopsDB, $xoTheme;
    $xoTheme->addStylesheet('modules/tadtools/css/vertical_menu.css');

    $in = (empty($options[0])) ? '' : "and rss_sn in({$options[0]})";

    $moduleHandler = xoops_getHandler('module');
    $xoopsModule = $moduleHandler->getByDirname('tad_rss');
    $configHandler = xoops_getHandler('config');
    $xoopsModuleConfig = $configHandler->getConfigsByCat(0, $xoopsModule->getVar('mid'));

    $sql = 'select * from ' . $xoopsDB->prefix('tad_rss') . " where enable='1' $in";

    $result = $xoopsDB->query($sql);

    $block = [];

    $n = 0;
    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        //以下會產生這些變數： $rss_sn , $title , $url , $enable
        foreach ($all as $k => $v) {
            $$k = $v;
        }

        $rss = get_rss_by_simplepie_block($url, $options[1]);

        $block['rss_data'][$n]['link'] = $url;
        $block['rss_data'][$n]['title'] = $title;
        $block['rss_data'][$n]['content'] = $rss;
        $n++;
    }

    return $block;
}

function tad_rss_show_edit($options)
{
    global $xoopsDB;

    if (!empty($options[0])) {
        $sc = explode(',', $options[0]);
    }

    $js = '<script>
    function bbv(col){
      $i=0;
      var arr = new Array();';

    $chkbox = '';

    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('tad_rss') . " WHERE enable='1'";

    $result = $xoopsDB->query($sql);
    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        //以下會產生這些變數： $rss_sn , $title , $url , $enable
        foreach ($all as $k => $v) {
            $$k = $v;
        }

        $js .= "if(document.getElementById('c{$rss_sn}').checked){
            arr[\$i] = document.getElementById('c{$rss_sn}').value;
                \$i++;
            }";

        $chked = (in_array($rss_sn, $sc)) ? 'checked' : '';
        $chkbox .= "<input type='checkbox' id='c{$rss_sn}' value='{$rss_sn}'  onChange=bbv() $chked>$title";
    }
    $js .= "document.getElementById('bb').value=arr.join(',');
    }
    </script>";

    $form = "$js
    <ol class='my-form'>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADRSS_TAD_RSS_SHOW_EDIT_BITEM0 . "</lable>
            <div class='my-content'>
                {$chkbox}
	            <input type='hidden' name='options[0]' id='bb' value='{$options[0]}'>
            </div>
        </li>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADRSS_TAD_RSS_SHOW_EDIT_BITEM1 . "</lable>
            <div class='my-content'>
	            <input type='text' name='options[1]' class='my-input' value='{$options[1]}'>
            </div>
        </li>
    </ol>";

    return $form;
}

//以 simplepie 來取得RSS
function get_rss_by_simplepie_block($url = '', $maxitems = 5)
{
    require_once XOOPS_ROOT_PATH . '/modules/tad_rss/class/simplepie/SimplePie.php';
    $feed =new SimplePie();
    $feed->set_output_encoding(_CHARSET);
    $feed->set_feed_url($url);
    $feed->set_cache_location(XOOPS_ROOT_PATH . '/uploads/simplepie_cache');
    $feed->init();
    $feed->handle_content_type();

    $n = 0;
    foreach ($feed->get_items(0, $maxitems) as $item) {
        $href = $item->get_permalink();
        $title = $item->get_title();
        $date = $item->get_date('m/d');
        $description = $item->get_description();

        $arr[$n]['date'] = $date;
        $arr[$n]['link'] = $href;
        $arr[$n]['title'] = $title;
        $arr[$n]['description'] = $description;
        $n++;
    }

    return $arr;
}
