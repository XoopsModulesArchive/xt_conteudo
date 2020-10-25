<?php
// ================================================
// SPAW PHP WYSIWYG editor control
// ================================================
// Confirmation dialog
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
$theme = empty($_GET['theme']) ? $spaw_default_theme : $_GET['theme'];
$block = $_GET['block'];
$message = $_GET['message'];
$l = new SPAW_Lang($_GET['lang']);
$l->setBlock($block);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Pragma" content="no-cache">
<title><?php echo $l->m('title')?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $l->getCharset()?>">
<link rel="stylesheet" type="text/css" href="<?php echo $theme_path . 'css/'?>dialog.css">
<script language="javascript" src="utils.js"></script>
<script language="javascript">
<!-- 
function Init() {
cur_color = window.dialogArguments;
resizeDialogToContent();
}
function okClick() {
window.returnValue = true;
window.close();
}
function cancelClick() {
window.returnValue = false;
window.close();
}
//-->
</script>
</head>
<body onLoad="Init()" dir="<?php echo $l->getDir(); ?>">
<p align="center">
<BR>
<?php echo $l->m($message)?>
<BR><BR>
<form name="colorpicker">
<input type="button" value="<?php echo $l->m('ok')?>" onClick="okClick()" class="bt">
<input type="button" value="<?php echo $l->m('cancel')?>" onClick="cancelClick()" class="bt"><BR><BR>
</form>
</p>
</body>
</html>
