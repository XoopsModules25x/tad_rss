<?php

use XoopsModules\Tadtools\Utility;
use XoopsModules\Tad_rss\Update;
if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}
if (!class_exists('XoopsModules\Tad_rss\Update')) {
    include dirname(__DIR__) . '/preloads/autoloader.php';
}

function xoops_module_update_tad_rss(&$module, $old_version)
{
    global $xoopsDB;

    Update::chk_tad_rss_block();

    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_rss');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_rss/thumbs');

    return true;
}
