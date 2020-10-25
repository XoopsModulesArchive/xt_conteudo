<?php
### ======================================================
### XoopsTotal - A Comunidade Diferente
### ======================================================
### Bloco que exibe os conteúdos dentro de uma option list
### ======================================================
### Developer: Fernando Santos, fernando@zend.com.br
### Copyright: XoopsTotal © 2004
### ------------------------------------------------------
### www.underpop.com
### ======================================================
### v.1.0, 06/09/2004
### ======================================================
function xt_conteudo_nav_lista()
{
    global $xoopsDB, $_GET, $xoopsConfig;

    $myts = MyTextSanitizer::getInstance();

    $xt_conteudo_options = '';

    $ide = $_GET['id'] ?? 0;

    if ('0' != $ide) {
        $titulo_result = $xoopsDB->query('SELECT title FROM ' . $xoopsDB->prefix('xt_conteudo') . " WHERE visible='1' and storyid=" . $ide . '');

        while ($row1 = $xoopsDB->fetchArray($titulo_result)) {
            $titulo_dados = htmlspecialchars($row1['title'], ENT_QUOTES | ENT_HTML5);
        }
    } else {
        $titulo_dados = $xoopsConfig['sitename'];
    }

    $result = $xoopsDB->query('SELECT storyid, blockid, title, visible, homepage FROM ' . $xoopsDB->prefix('xt_conteudo') . " WHERE visible='1' ORDER BY blockid");

    while ($row = $xoopsDB->fetchArray($result)) {
        $id = $row['storyid'];

        $title = htmlspecialchars($row['title'], ENT_QUOTES | ENT_HTML5);

        $home = $row['homepage'];

        if ($id == $ide) { //define aqui o inicial no select
            $xt_conteudo_select = 'selected';
        } else {
            $xt_conteudo_select = '';
        }

        $xt_conteudo_options .= '<option value="' . $id . '"' . $xt_conteudo_select . '>' . $title . '</option>';
    }

    if ('' != $xt_conteudo_options) {
        $xt_conteudo = '<form action="' . XOOPS_URL . '/modules/xt_conteudo/index.php? method="post">';

        $xt_conteudo .= '<select name="id" onchange="submit();">';

        $xt_conteudo .= $xt_conteudo_options;

        $xt_conteudo .= '</select></form><BR>';

        $xt_conteudo .= '<center><div class="itemHead">' . $titulo_dados . '</div></center>';
    }

    $block = [];

    // $block['title'] = BLOCO_TITULO;

    $block['content'] = $xt_conteudo ?? '';

    return $block;
}
