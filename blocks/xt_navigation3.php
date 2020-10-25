<?php
// $Id: xt_navigation3.php,v 1.1 2006/06/08 07:28:04 mikhail Exp $
// ------------------------------------------------------------------------- //
// E-Xoops: Content Management for the Masses //
// < http://www.e-xoops.com > //
// ------------------------------------------------------------------------- //
// Original Author: Kazumi Ono
// Author Website : http://www.mywebaddons.com/ , http://www.myweb.ne.jp
// Licence Type : GPL
// ------------------------------------------------------------------------- //
//---------------------------------------------------------------------------------------//
/**
 * Description
 *
 * @return array description
 */
function xt_mainmenu_dynshow()
{
    global $xoopsDB, $xoopsUser, $xoopsModule;

    $groups = [];

    $block = [];

    $sublinks = [];

    $subcont = [];

    $groups = $xoopsUser ? $xoopsUser->groups() : XOOPS_GROUP_ANONYMOUS;

    $block['content'] = "
<script type='text/javascript'>
function toggle_dynmenu(id) {
if (xoopsGetElementById(id + '_sub')) {
var dom = xoopsGetElementById(id + '_sub').style.display;
if (dom == 'none') {
xoopsGetElementById(id + '_sub').style.display = 'inline';
xoopsGetElementById(id + '_sign').src = '" . XOOPS_URL . "/modules/xt_conteudo/images/menu/minus.gif';
xoopsGetElementById(id + '_folder').src = '" . XOOPS_URL . "/modules/xt_conteudo/images/menu/tree_open.gif';
} else if (dom == 'inline') {
xoopsGetElementById(id + '_sub').style.display = 'none';
xoopsGetElementById(id + '_sign').src = '" . XOOPS_URL . "/modules/xt_conteudo/images/menu/plus.gif';
xoopsGetElementById(id + '_folder').src = '" . XOOPS_URL . "/modules/xt_conteudo/images/menu/tree_close.gif';
}
}
}
</script>";

    $block['content'] .= "<img src='" . XOOPS_URL . "/modules/xt_conteudo/images/menu/d_tree_home.gif' alt=''> <a href='" . XOOPS_URL . "/'>" . _TC2_HOMEPAGE . '</a>';

    $moduleHandler = xoops_getHandler('module');

    $criteria = new CriteriaCompo(new Criteria('hasmain', 1));

    $criteria->add(new Criteria('isactive', 1));

    $criteria->add(new Criteria('weight', 0, '>'));

    $modules = $moduleHandler->getObjects($criteria, true);

    $modulepermHandler = xoops_getHandler('groupperm');

    $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;

    $read_allowed = $modulepermHandler->getItemIds('module_read', $groups);

    foreach (array_keys($modules) as $i) {
        if (in_array($i, $read_allowed, true)) {
            if ($sublinks = $modules[$i]->subLink()) {
                $subcont[] = $modules[$i]->getVar('dirname');

                $block['content'] .= "<br><a href='javascript:toggle_dynmenu(\"" . $modules[$i]->getVar('dirname') . "\");'><img id='" . $modules[$i]->getVar('dirname') . "_sign' name='" . $modules[$i]->getVar('dirname') . "_sign' src='" . XOOPS_URL . "/modules/xt_conteudo/images/menu/minus.gif' height='9' width='9' align='absmiddle' border='0'></a> ";

                $block['content'] .= "<img id='" . $modules[$i]->getVar('dirname') . "_folder' name='" . $modules[$i]->getVar('dirname') . "_folder' src='" . XOOPS_URL . "/modules/xt_conteudo/images/menu/tree_open.gif' alt=''> " . $modules[$i]->mainLink();

                $block['content'] .= "<span id='" . $modules[$i]->getVar('dirname') . "_sub' name='" . $modules[$i]->getVar('dirname') . "_sub' style='display:inline;'>";

                foreach ($sublinks as $sublink) {
                    $block['content'] .= "<br> <img src='" . XOOPS_URL . "/modules/xt_conteudo/images/menu/d_tree_content.gif' alt=''><a href=\"" . XOOPS_URL . '/modules/' . $modules[$i]->getVar('dirname') . '/' . $sublink['url'] . '">' . $sublink['name'] . '</a>';
                }

                $block['content'] .= '</span>';
            } else {
                $block['content'] .= "<br><img src='" . XOOPS_URL . "/modules/xt_conteudo/images/menu/d_tree_close.gif' alt=''> " . $modules[$i]->mainLink() . "\n";
            }
        }
    }

    if (!empty($subcont)) {
        $block['content'] .= "<script type='text/javascript'>\n";

        foreach ($subcont as $value) {
            if (!$xoopsModule || ($xoopsModule->dirname() != $value)) {
                $block['content'] .= "toggle_dynmenu('$value');\n";
            }
        }

        $block['content'] .= '</script>';
    }

    return $block;
}
//---------------------------------------------------------------------------------------//
