<?php
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Image library dialog
// ================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// ------------------------------------------------
// www.solmetra.com
// ================================================
// $Revision: 1.1 $, $Date: 2006/06/09 19:05:06 $
// ================================================
// include wysiwyg config
require dirname(__DIR__) . '/config/spaw_control.config.php';
include $spaw_root . 'class/lang.class.php';
require_once XOOPS_ROOT_PATH . '/class/uploader.php';
// Se é visitante logado, pega os grupos e põe na array $grupo
if (!$xoopsUser) {
    $grupo = [XOOPS_GROUP_ANONYMOUS];
} else {
    $grupo = &$xoopsUser->getGroups();
}
$imgcatHandler = xoops_getHandler('imagecategory');
$catlist = &$imgcatHandler->getList($grupo, 'imgcat_read', 1);
$theme = empty($_POST['theme']) ? (empty($_GET['theme']) ? $spaw_default_theme : $_GET['theme']) : $_POST['theme'];
//$theme_path = $spaw_dir.'lib/themes/'.$theme.'/';
$l = new SPAW_Lang(empty($_POST['lang']) ? $_GET['lang'] : $_POST['lang']);
$l->setBlock('image_insert');
?>
<?php
$lib = $_POST['lib'];
if (empty($lib)) {
    $lib = $_GET['lib'];
}
$value_found = false;
// callback function for preventing listing of non-library directory
function is_array_value($value, $key, $_imglib)
{
    global $value_found,$lib;

    // echo $value.'-'.$_imglib.'<BR>';

    if (in_array($_imglib, $value, true)) {
        $value_found = true;

        $lib = $spaw_imglibs[$key]['catID'];

        var_dump($key);
    }
}
//array_walk($spaw_imglibs, 'is_array_value',$imglib);
foreach ($spaw_imglibs as $spawimg) {
    if ($lib == $spawimg['catID']) {
        $imagelib = $spawimg['value'];

        $imagetype = $spawimg['storetype'];

        $value_found = true;

        break;
    }
}
if (!$value_found || empty($lib)) {
    $imglib = $spaw_imglibs[0]['value'];

    $lib = $spaw_imglibs[0]['catID'];

    $imagetype = $spawimg['storetype'];
}
$lib_options = liboptions($spaw_imglibs, '', $lib);
$img = $_POST['imglist'];
$preview = '';
$errors = [];
if ($HTTP_POST_FILES['img_file']['size'] > 0) {
    if ($img = uploadImg('img_file')) {
        if ('file' == $imagetype) {
            $preview = XOOPS_URL . '/' . $imagelib . $img;
        } else {
            $preview = XOOPS_URL . "/image.php?id=$img";
        }
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?php echo $l->m('title')?></title>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $l->getCharset()?>">
<link rel="stylesheet" type="text/css" href="<?php echo $theme_path . 'css/'?>dialog.css">
<script language="javascript" src="utils.js"></script>
<script language="javascript">
<!--
function selectClick()
{
if (document.libbrowser.img_file.value!='')
{
return true;
} 
else if (document.libbrowser.lib.selectedIndex>=0 && document.libbrowser.imglist.selectedIndex>=0)
{
//+document.libbrowser.lib.options[document.libbrowser.lib.selectedIndex].value 
window.returnValue = '<?php if ('file' == $imagetype) {
    echo XOOPS_URL . '/uploads/';
} else {
    echo XOOPS_URL . '/image.php?id=';
}?>'+document.libbrowser.imglist.options[document.libbrowser.imglist.selectedIndex].value;
window.close();
}
else if (document.libbrowser.imagem.value!='')
{
window.returnValue = document.libbrowser.imagem.value;
window.close();
}
else
{
alert('<?php echo $l->m('error') . ': ' . $l->m('error_no_image')?>');
}
}
function Init()
{
resizeDialogToContent();
}
//-->
</script>
</head>
<body onLoad="Init()" dir="<?php echo $l->getDir(); ?>">
<script language="javascript">
<!--
window.name = 'imglibrary';
//-->
</script>
<form name="libbrowser" method="post" action="img_library.php" enctype="multipart/form-data" target="imglibrary" onsubmit="selectClick()">
<input type="hidden" name="theme" value="<?php echo $theme?>">
<input type="hidden" name="lang" value="<?php echo $l->lang?>">
<div style="border: 1 solid Black; padding: 5 5 5 5;">
<table border="0" cellpadding="2" cellspacing="0">
<tr>
<td valign="top" align="left"><b><?php echo $l->m('library')?>:</b></td>
<td valign="top" align="left">&nbsp;</td>
<td valign="top" align="left"><b><?php echo $l->m('preview')?>:</b></td>
</tr>
<tr>
<td valign="top" align="left">
<select name="lib" size="1" class="input" style="width: 150px;" onChange="libbrowser.submit();">
<?php echo $lib_options?>
</select>
</td>
<td valign="top" align="left" rowspan="3">&nbsp;</td>
<td valign="top" align="left" rowspan="3">
<iframe name="imgpreview" src="<?php echo $preview?>" style="width: 300px; height: 100%;" scrolling="Auto" marginheight="0" marginwidth="0" frameborder="0"></iframe>
</td>
</tr>
<tr>
<td valign="top" align="left"><b><?php echo $l->m('images')?>:</b></td>
</tr>
<tr>
<td valign="top" align="left">
<?php
/*
if (!preg_match('/$', $HTTP_SERVER_VARS['DOCUMENT_ROOT']))
$_root = $HTTP_SERVER_VARS['DOCUMENT_ROOT'].'/';
else
$_root = $HTTP_SERVER_VARS['DOCUMENT_ROOT'];
*/
$_root = XOOPS_ROOT_PATH . '/';
$d = @dir($_root . $imglib);
?>
<select name="imglist" size="15" class="input" style="width: 150px;" 
onchange="if (this.selectedIndex &gt;=0) imgpreview.location.href = '<?php if ('file' == $imagetype) {
    echo XOOPS_URL . '/uploads/';
} else {
    echo XOOPS_URL . '/image.php?id=';
}?>' + this.options[this.selectedIndex].value;" ondblclick="selectClick();">
<?php
global $xoopsDB;
if ('file' == $imagetype) {
    $result = $xoopsDB->query('SELECT image_name,image_nicename FROM ' . $xoopsDB->prefix('image') . " WHERE imgcat_id = $lib and image_display='1' ORDER BY image_nicename ASC");

    while ($image = $xoopsDB->fetchArray($result)) {
        ?>
<option value="<?php echo $image['image_name']?>" <?php echo ($image['image_name'] == $img) ? 'selected' : ''?>><?php echo $image['image_nicename']?></option>
<?php
    }
} else {
    $result = $xoopsDB->query('SELECT image_id, image_name,image_nicename FROM ' . $xoopsDB->prefix('image') . " WHERE imgcat_id = $lib and image_display='1' ORDER BY image_nicename ASC");

    while ($image = $xoopsDB->fetchArray($result)) {
        ?>
<option value="<?php echo $image['image_id']?>" <?php echo ($image['image_id'] == $img) ? 'selected' : ''?>><?php echo $image['image_nicename']?></option>
<?php
    }
}
?>
</select>
</td>
</tr>
<tr><td valign="top" align="left" colspan="3"><b>Digite a URL da Imagem:<b> <input type="text" name="imagem" size=30></td></tr>
<tr>
<td valign="top" align="left" colspan="3">
<input type="button" value="<?php echo $l->m('select')?>" class="bt" onclick="selectClick();">&nbsp;<input type="button" value="<?php echo $l->m('cancel')?>" class="bt" onclick="window.close();">
</td>
</tr>
</table>
</div>
<?php
$categoria = $imgcatHandler->get($lib);
$imgcat_id = (int)$_POST['lib'];
$erro = false;
if (!is_object($categoria)) {
    $erro = true;
} else {
    $imgcatpermHandler = xoops_getHandler('groupperm');

    if ($xoopsUser) {
        if (!$imgcatpermHandler->checkRight('imgcat_write', $imgcat_id, $xoopsUser->getGroups())) {
            $erro = true;
        }
    } else {
        $erro = true;
    }
}
if ($spaw_upload_allowed && false === $erro) { ?>
<div style="border: 1 solid Black; padding: 5 5 5 5;">
<table border="0" cellpadding="2" cellspacing="0">
<tr>
<td valign="top" align="left">
<?php
if (!empty($errors)) {
    echo '<span class="error">';

    foreach ($errors as $err) {
        echo $err . '<BR>';
    }

    echo '</span>';
}
?>
<?php
if ($d) {
    ?>
<b><?php echo $l->m('upload')?>:</b> <input type="file" name="img_file" class="input"><BR><b>Nome para a Imagem:</b> <input type="text" name="nicename"><BR>
<input type="submit" name="btnupload" class="bt" value="<?php echo $l->m('upload_button')?>">
<?php
}
?>
</td>
</tr>
</table>
</div>
<?php } ?>
</form>
</body>
</html>
<?php
function liboptions($arr, $prefix = '', $sel = '')
{
    $buf = '';

    foreach ($arr as $lib) {
        $buf .= '<option value="' . $lib['catID'] . '"' . (($lib['catID'] == $sel) ? ' selected' : '') . '>' . $prefix . $lib['text'] . '</option>' . "\n";
    }

    return $buf;
}
function uploadImg($img)
{
    global $HTTP_POST_FILES;

    global $_POST;

    global $HTTP_SERVER_VARS;

    global $spaw_valid_imgs;

    global $imglib;

    global $errors;

    global $l;

    global $spaw_upload_allowed;

    global $lib;

    global $xoopsUser;

    global $nicename;

    $imgcat_id = $lib;

    $nicename = ($_POST['nicename']) ?: mb_substr($HTTP_POST_FILES['img_file']['name'], 0, -4);

    if (!$spaw_upload_allowed) {
        return false;
    }

    $imgcatHandler = xoops_getHandler('imagecategory');

    $imgcat = $imgcatHandler->get((int)$imgcat_id);

    $error = false;

    if (!is_object($imgcat)) {
        $error = true;
    } else {
        $imgcatpermHandler = xoops_getHandler('groupperm');

        if ($xoopsUser) {
            if (!$imgcatpermHandler->checkRight('imgcat_write', $imgcat_id, $xoopsUser->getGroups())) {
                $error = true;
            }
        } else {
            if (!$imgcatpermHandler->checkRight('imgcat_write', $imgcat_id, XOOPS_GROUP_ANONYMOUS)) {
                $error = true;
            }
        }
    }

    if (false !== $error) {
        $errors[] = $l->m('error_uploading');

        return false;
    }

    $uploader = new XoopsMediaUploader(XOOPS_UPLOAD_PATH, ['image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png'], $imgcat->getVar('imgcat_maxsize'), $imgcat->getVar('imgcat_maxwidth'), $imgcat->getVar('imgcat_maxheight'));

    $uploader->setPrefix('img');

    if ($uploader->fetchMedia($img)) {
        if (!$uploader->upload()) {
            $errors[] = $uploader->getErrors();

            return false;
        }  

        $imageHandler = xoops_getHandler('image');

        $image = $imageHandler->create();

        $image->setVar('image_name', $uploader->getSavedFileName());

        $image->setVar('image_nicename', $nicename);

        $image->setVar('image_mimetype', $uploader->getMediaType());

        $image->setVar('image_created', time());

        $image->setVar('image_display', 1);

        $image->setVar('image_weight', 0);

        $image->setVar('imgcat_id', $imgcat_id);

        if ('db' == $imgcat->getVar('imgcat_storetype')) {
            $fp = @fopen($uploader->getSavedDestination(), 'rb');

            $fbinary = @fread($fp, filesize($uploader->getSavedDestination()));

            @fclose($fp);

            $image->setVar('image_body', addslashes($fbinary));

            @unlink($uploader->getSavedDestination());
        }

        if (!$imageHandler->insert($image)) {
            $errors[] = sprintf(_FAILSAVEIMG, $image->getVar('image_nicename'));

            return false;
        }
    } else {
        $errors[] = _FAILFETCHIMG;

        return false;
    }

    if ('file' == $imgcat->getVar('imgcat_storetype')) {
        return $uploader->getSavedFileName();
    }
  

    return $image->getVar('image_id');
}
?>
