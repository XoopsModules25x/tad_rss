<?php

use XoopsModules\Tadtools\Utility;
if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}


function xoops_module_install_tad_rss(&$module)
{
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/magpierss_cache');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/simplepie_cache');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_rss');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_rss/thumbs');

    return true;
}
