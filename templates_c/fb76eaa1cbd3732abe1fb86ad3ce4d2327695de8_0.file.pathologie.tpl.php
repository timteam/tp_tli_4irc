<?php
/* Smarty version 3.1.29, created on 2016-03-10 15:54:28
  from "D:\wamp\www\tpPhp\tp_tli_4irc\templates\pathologie.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_56e198b4d5bb37_99689125',
  'file_dependency' => 
  array (
    'fb76eaa1cbd3732abe1fb86ad3ce4d2327695de8' => 
    array (
      0 => 'D:\\wamp\\www\\tpPhp\\tp_tli_4irc\\templates\\pathologie.tpl',
      1 => 1457621622,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_56e198b4d5bb37_99689125 ($_smarty_tpl) {
?>
<div id="main">
    <h1>Liste des pathologies</h1>
    <table>
        <thead>
            <td>Pathologie</td>
        </thead>   
        <tfoot>  
            <?php
$_from = $_smarty_tpl->tpl_vars['argument']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_pathologie_0_saved_item = isset($_smarty_tpl->tpl_vars['pathologie']) ? $_smarty_tpl->tpl_vars['pathologie'] : false;
$_smarty_tpl->tpl_vars['pathologie'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['pathologie']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['pathologie']->value) {
$_smarty_tpl->tpl_vars['pathologie']->_loop = true;
$__foreach_pathologie_0_saved_local_item = $_smarty_tpl->tpl_vars['pathologie'];
?>
            <tr>
                <td>
                    <?php echo $_smarty_tpl->tpl_vars['pathologie']->value['desc'];?>

                </td>
            </tr>
            <?php
$_smarty_tpl->tpl_vars['pathologie'] = $__foreach_pathologie_0_saved_local_item;
}
if ($__foreach_pathologie_0_saved_item) {
$_smarty_tpl->tpl_vars['pathologie'] = $__foreach_pathologie_0_saved_item;
}
?>
        </tfoot>
    </table>
</div><?php }
}
