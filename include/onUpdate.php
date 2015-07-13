<?php
function xoops_module_update_tad_rss(&$module, $old_version)
{
    global $xoopsDB;

    //if(!chk_chk1()) go_update1();
    chk_tad_rss_block();

    mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_rss');
    mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_rss/thumbs');
    return true;
}

//�R�����~���������μ˪O��
function chk_tad_rss_block()
{
    global $xoopsDB;
    //die(var_export($xoopsConfig));
    include XOOPS_ROOT_PATH . '/modules/tad_rss/xoops_version.php';

    //����X�Ӧ����϶��H�ι����˪O
    foreach ($modversion['blocks'] as $i => $block) {
        $show_func                = $block['show_func'];
        $tpl_file_arr[$show_func] = $block['template'];
        $tpl_desc_arr[$show_func] = $block['description'];
    }

    //��X�ثe�Ҧ����˪O��
    $sql = "SELECT bid,name,visible,show_func,template FROM `" . $xoopsDB->prefix("newblocks") . "`
    WHERE `dirname` = 'tad_rss' ORDER BY `func_num`";
    $result = $xoopsDB->query($sql);
    while (list($bid, $name, $visible, $show_func, $template) = $xoopsDB->fetchRow($result)) {
        //���p�{�����϶��M�˪O�藍�W�N�R��
        if ($template != $tpl_file_arr[$show_func]) {
            $sql = "delete from " . $xoopsDB->prefix("newblocks") . " where bid='{$bid}'";
            $xoopsDB->queryF($sql);

            //�s�P�˪O�H�μ˪O�����ɮפ]�n�R��
            $sql = "delete from " . $xoopsDB->prefix("tplfile") . " as a
            left join " . $xoopsDB->prefix("tplsource") . "  as b on a.tpl_id=b.tpl_id
            where a.tpl_refid='$bid' and a.tpl_module='tad_rss' and a.tpl_type='block'";
            $xoopsDB->queryF($sql);
        } else {
            $sql = "update " . $xoopsDB->prefix("tplfile") . "
            set tpl_file='{$template}' , tpl_desc='{$tpl_desc_arr[$show_func]}'
            where tpl_refid='{$bid}'";
            $xoopsDB->queryF($sql);
        }
    }

}

//�إߥؿ�
function mk_dir($dir = "")
{
    //�Y�L�ؿ��W�٨q�Xĵ�i�T��
    if (empty($dir)) {
        return;
    }

    //�Y�ؿ����s�b���ܫإߥؿ�
    if (!is_dir($dir)) {
        umask(000);
        //�Y�إߥ��Ѩq�Xĵ�i�T��
        mkdir($dir, 0777);
    }
}

//�����ؿ�
function full_copy($source = "", $target = "")
{
    if (is_dir($source)) {
        @mkdir($target);
        $d = dir($source);
        while (false !== ($entry = $d->read())) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            $Entry = $source . '/' . $entry;
            if (is_dir($Entry)) {
                full_copy($Entry, $target . '/' . $entry);
                continue;
            }
            copy($Entry, $target . '/' . $entry);
        }
        $d->close();
    } else {
        copy($source, $target);
    }
}

function rename_win($oldfile, $newfile)
{
    if (!rename($oldfile, $newfile)) {
        if (copy($oldfile, $newfile)) {
            unlink($oldfile);
            return true;
        }
        return false;
    }
    return true;
}

function delete_directory($dirname)
{
    if (is_dir($dirname)) {
        $dir_handle = opendir($dirname);
    }

    if (!$dir_handle) {
        return false;
    }

    while ($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname . "/" . $file)) {
                unlink($dirname . "/" . $file);
            } else {
                delete_directory($dirname . '/' . $file);
            }

        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}
