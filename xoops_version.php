<?php
// ------------------------------------------------------------------------ //
// XOOPS - PHP Content Management System //
// Copyright (c) 2000 xoopscube.org //
// <http://www.xoopscube.org> //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify //
// it under the terms of the GNU General Public License as published by //
// the Free Software Foundation; either version 2 of the License, or //
// (at your option) any later version.  //
//   //
// You may not change or alter any portion of this comment or credits //
// of supporting developers from this source code or any supporting //
// source code which is considered copyrighted (c) material of the //
// original comment or credit authors.  //
//   //
// This program is distributed in the hope that it will be useful, //
// but WITHOUT ANY WARRANTY; without even the implied warranty of //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the //
// GNU General Public License for more details. //
//   //
// You should have received a copy of the GNU General Public License //
// along with this program; if not, write to the Free Software //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA //
// ------------------------------------------------------------------------- //
// Author: Tobias Liegl (AKA CHAPI)  //
// Site: http://www.chapi.de  //
// Project: The XOOPS Project  //
// ------------------------------------------------------------------------- //
$modversion['name'] = _MI2_XTCONTEUDO_NAME;
$modversion['version'] = 1.52;
$modversion['author'] = 'Tobias Liegl (AKA CHAPI)';
$modversion['description'] = _MI2_XTCONTEUDO_DESC;
$modversion['credits'] = 'The XOOPS Project';
$modversion['license'] = 'GPL see LICENSE';
$modversion['help'] = '';
$modversion['official'] = 0;
$modversion['image'] = 'images/logo.gif';
$modversion['dirname'] = _MI2_DIR_NAME;
// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
// Tables created by sql file (without prefix!)
$modversion['tables'][0] = _MI2_DIR_NAME;
// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';
// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'xt_conteudo_search';
// Menu
$modversion['hasMain'] = 1;
global $xoopsDB;
// Submenu Items
$result = $xoopsDB->query('SELECT storyid, title, homepage, submenu FROM ' . $xoopsDB->prefix('xt_conteudo') . " WHERE homepage='0' AND submenu='1'");
$i = 1;
while (list($storyid, $title) = $xoopsDB->fetchRow($result)) {
    $modversion['sub'][$i]['name'] = $title;

    $modversion['sub'][$i]['url'] = 'index.php?id=' . $storyid . '';

    $i++;
}
// Smarty
$modversion['use_smarty'] = 1;
// Templates
$modversion['templates'][1]['file'] = 'xt_index.html';
$modversion['templates'][1]['description'] = _MI2_TEMP_NAME1;
// Blocks
$modversion['blocks'][1]['file'] = 'xt_navigation.php';
$modversion['blocks'][1]['name'] = _MI2_TC2_BNAME1;
$modversion['blocks'][1]['description'] = _MI2_TC2_BNAME1_DESC;
$modversion['blocks'][1]['show_func'] = 'xt_conteudo_block_nav';
$modversion['blocks'][1]['template'] = 'xt_nav_block.html';
$modversion['blocks'][2]['file'] = 'xt_navigation2.php';
$modversion['blocks'][2]['name'] = _MI2_TC2_BNAME2;
$modversion['blocks'][2]['description'] = _MI2_TC2_BNAME2_DESC;
$modversion['blocks'][2]['show_func'] = 'xt_conteudo_nav_lista';
$modversion['blocks'][3]['file'] = 'xtmenu.php';
$modversion['blocks'][3]['name'] = _MI2_TC2_BNAME3;
$modversion['blocks'][3]['description'] = _MI2_TC2_BNAME3_DESC;
$modversion['blocks'][3]['show_func'] = 'xtmenu';
$modversion['blocks'][3]['edit_func'] = 'xtmenu_editar';
$modversion['blocks'][3]['options'] = '1|1';
$modversion['blocks'][4]['file'] = 'xt_navigation3.php';
$modversion['blocks'][4]['name'] = _MI2_TC2_BNAME4;
$modversion['blocks'][4]['description'] = _MI2_TC2_BNAME4_DESC;
$modversion['blocks'][4]['show_func'] = 'xt_mainmenu_dynshow';
// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['itemName'] = 'id';
$modversion['comments']['pageName'] = 'index.php';
$modversion['config'][1]['name'] = 'xt_wysiwyg';
$modversion['config'][1]['title'] = '_MI2_WYSIWYG';
$modversion['config'][1]['description'] = '_MI2_WYSIWYG_DESC';
$modversion['config'][1]['formtype'] = 'yesno';
$modversion['config'][1]['valuetype'] = 'int';
$modversion['config'][1]['default'] = 0;
