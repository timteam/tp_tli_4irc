<?php
/* Smarty version 3.1.29, created on 2016-03-11 09:02:42
  from "D:\wamp\www\tpPhp\tp_tli_4irc\templates\site.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_56e289b21b9946_10642019',
  'file_dependency' => 
  array (
    '9833bb8f56c6794caa9d1a67bbd093cdf038f75b' => 
    array (
      0 => 'D:\\wamp\\www\\tpPhp\\tp_tli_4irc\\templates\\site.tpl',
      1 => 1457686957,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_56e289b21b9946_10642019 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Acupunctura - Medecine chinoise millénaire</title>
    <meta content="Acupunctura - Medecine chinoise millénaire" name="description">
    <link type="text/css" rel="stylesheet" href="media/css/site.css">
    <?php echo '<script'; ?>
 type="text/javascript" charset="UTF-8" src="media/js/site.js"><?php echo '</script'; ?>
>
  </head>
  <body>
        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, ((string)$_smarty_tpl->tpl_vars['module']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('argument'=>$_smarty_tpl->tpl_vars['argument']->value), 0, true);
?>

        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

  </body>
</html><?php }
}
