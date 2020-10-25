<?php
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Configuration file
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// ------------------------------------------------
// www.solmetra.com
// ================================================
// v.1.0, 2003-03-27
// ================================================
require dirname(__DIR__, 4) . '/../mainfile.php';
// directory where spaw files are located
$spaw_dir = 'spaw/';
// base url for images
$spaw_base_url = XOOPS_URL . '/';
$theme_path = XOOPS_URL . '/modules/xt_conteudo/admin/spaw/lib/themes/default/';
$spaw_root = XOOPS_ROOT_PATH . '/modules/xt_conteudo/admin/spaw/';
$spaw_default_toolbars = 'full';
$spaw_default_theme = 'default';
$spaw_default_lang = 'pt_br';
$spaw_default_css_stylesheet = $spaw_dir . 'wysiwyg.css';
// add javascript inline or via separate file
$spaw_inline_js = true;
// use active toolbar (reflecting current style) or static
$spaw_active_toolbar = false;
// default dropdown content
$spaw_dropdown_data['style']['default'] = 'Normal';
$spaw_dropdown_data['font']['Arial'] = 'Arial';
$spaw_dropdown_data['font']['Courier'] = 'Courier';
$spaw_dropdown_data['font']['Tahoma'] = 'Tahoma';
$spaw_dropdown_data['font']['Times New Roman'] = 'Times';
$spaw_dropdown_data['font']['Verdana'] = 'Verdana';
$spaw_dropdown_data['fontsize']['1'] = '1';
$spaw_dropdown_data['fontsize']['2'] = '2';
$spaw_dropdown_data['fontsize']['3'] = '3';
$spaw_dropdown_data['fontsize']['4'] = '4';
$spaw_dropdown_data['fontsize']['5'] = '5';
$spaw_dropdown_data['fontsize']['6'] = '6';
$spaw_dropdown_data['paragraph']['Normal'] = 'Normal';
$spaw_dropdown_data['paragraph']['Heading 1'] = 'Cabeçalho 1';
$spaw_dropdown_data['paragraph']['Heading 2'] = 'Cabeçalho 2';
$spaw_dropdown_data['paragraph']['Heading 3'] = 'Cabeçalho 3';
$spaw_dropdown_data['paragraph']['Heading 4'] = 'Cabeçalho 4';
$spaw_dropdown_data['paragraph']['Heading 5'] = 'Cabeçalho 5';
$spaw_dropdown_data['paragraph']['Heading 6'] = 'Cabeçalho 6';
// image library related config
// allowed extentions for uploaded image files
$spaw_valid_imgs = ['gif', 'jpg', 'jpeg', 'png'];
// allow upload in image library
$spaw_upload_allowed = true;
// image libraries
global $xoopsDB;
//Se o user é administrador, exibe TODAS as categorias
if ($xoopsUser && $xoopsUser->isAdmin()) {
    $result = $xoopsDB->query('SELECT imgcat_name, imgcat_id, imgcat_storetype FROM ' . $xoopsDB->prefix('imagecategory') . ' ORDER BY imgcat_name ASC');

// Se não, exibe só as categorias marcadas como visível
} else {
    $result = $xoopsDB->query('SELECT imgcat_name, imgcat_id, imgcat_storetype FROM ' . $xoopsDB->prefix('imagecategory') . " WHERE imgcat_display='1' ORDER BY imgcat_name ASC");
}
// Pega os grupos no qual o visitante está, se é visitante, pega o anonymous
if (!$xoopsUser) {
    $grupo = [XOOPS_GROUP_ANONYMOUS];
} else {
    $grupo = &$xoopsUser->getGroups();
}
$imgcatHandler = xoops_getHandler('imagecategory');
$catlist = &$imgcatHandler->getList($grupo, 'imgcat_read', 1);
$i = 0;
while ($imgcat = $xoopsDB->fetchArray($result)) {
    if (array_key_exists($imgcat['imgcat_id'], $catlist)) {
        $spaw_imglibs[$i]['value'] = 'uploads/';

        $spaw_imglibs[$i]['text'] = $imgcat['imgcat_name'];

        $spaw_imglibs[$i]['catID'] = $imgcat['imgcat_id'];

        $spaw_imglibs[$i]['storetype'] = $imgcat['imgcat_storetype'];

        $spaw_imglibs[$i]['autoID'] = $i;

        $i++;
    }
}
/*
$spaw_imglibs = array(
array(
'value' => 'uploads/',
'text' => 'Uploads',
)
);
*/
