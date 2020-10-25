XT-Conteúdo is based on TinyContent, but with major changes:

Spaw Related
img_library.php – Added the field "Type Image URL" to allow image insertion via URL.
img_library.php – Added upload system directly to xoops image library, respecting all configurations made when creating the library.
img_library.php – Fixed image preview when library is set to store pictures on the DB.
img_library.php – Added the field "image name", used when uploading images. If left empty, the system will use the file’s name (without the extension .
- Added the "justified" button, to justify the text.
- Image buttons for “bold” “underlined” and “italic” where translated to Portuguese [N] [S] and [I].
To start using the SPAW editor, go to "Preferences" and check the option "Use WYSIWYG Editor?"
Table Related
- Added the field "parent_id", that made it possible to create a MENU AND SUBMENU system, transforming the module from simple wonder, to a page creation system with infinite categories and sub-categories.
Blocks Related
- Added the Block MENU AND SUBMENU , a JavaScript that displays a beautiful menu (with submenus) for all the content.
- Added the block DROPDOWN MENU, that shows all content created within a dropdown menu.
Module Related
Throughout the administration (add content / edit / delete / add link to file, etc) the "Show in:" option was created in order to allow for content to be displayed inside other content, creating the sub-menus on MENU AND SUBMENU.
Additional Resources
Nothing that Tiny-Content originally had was DELETED. XT-Conteúdo differs from TinyContent because of the new features that were added to it.
The Menu appearance can be easily edited by changing the modules\xt_conteudo\blocks\xtmenu.php (that is commented to make changes easier).
If you wish to create a LINKLESS MENU (to serve as a base for all that will be put inside) simply create a new content, leaving the text field EMPTY.
For Instance:
If you want this Menu structure:
Products -> Product 1
------------> Product 2
------------> Product 3
You would first have to create a new content named PRODUCTS (if the text field as ANY content, it will become a link, so don’t put nothing in it). Secondly, you would create a new content named " Product 1" and on the field "Show in:" you would set "Products".
This way, when the visitor does a mouse over on the "Products", the menu will expand and show " Product 1", " Product 2" and so on.
Know Issues
Many will ask : "Does it work on FireFox??"
The answer is YES. But your theme.html MUST NOT start with the line:
Citando:
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
it must ONLY HAVE:
Citando:
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
(have no clue why this happens, since W3C says that the difference between HTML 4.1 and XHTML 1 is XML support)
I solved this problem by opening the file header.php and around line 78 (before the comment // show banner?) placing the following code:
Citando:
$agent = $_SERVER['HTTP_USER_AGENT'];
if (eregi("MSIE[^;]*",$agent)) {
$xoopsTpl->assign('xoops_agent', 'IE');
}else{
$xoopsTpl->assign('xoops_agent', 'NIE');
}
Doing so, i was able to use the smarty tag <{$xoops_agent}> in my theme, that contains the "IE" value if visitor uses IE or the "NIE" if he uses another browser.
Then, in my theme.html, i erased all above the <html> tag and placed the following code:
Citando:
<{if $xoops_agent == "IE"}>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<{$xoops_langcode}>" lang="<{$xoops_langcode}>">
<{else}>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="<{$xoops_langcode}>">
<{/if}>
Et Voila!!! Problem solved, menu now works on firefox.