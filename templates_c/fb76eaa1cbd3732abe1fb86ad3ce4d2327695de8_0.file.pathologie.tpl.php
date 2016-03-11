<?php
/* Smarty version 3.1.29, created on 2016-03-10 20:50:54
  from "D:\wamp\www\tpPhp\tp_tli_4irc\templates\pathologie.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_56e1de2e664e24_05140243',
  'file_dependency' => 
  array (
    'fb76eaa1cbd3732abe1fb86ad3ce4d2327695de8' => 
    array (
      0 => 'D:\\wamp\\www\\tpPhp\\tp_tli_4irc\\templates\\pathologie.tpl',
      1 => 1457643051,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_56e1de2e664e24_05140243 ($_smarty_tpl) {
?>
<div id="main">
    <h3>Liste des pathologies</h3>
    <table>
        <thead>
            <tr>
                <th>Méridien</th>
                <th>Pathologies</th>
            </tr>
        </thead>   
        <tfoot>  
            <?php
$_from = $_smarty_tpl->tpl_vars['argument']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_meridien_0_saved_item = isset($_smarty_tpl->tpl_vars['meridien']) ? $_smarty_tpl->tpl_vars['meridien'] : false;
$_smarty_tpl->tpl_vars['meridien'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['meridien']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['meridien']->value) {
$_smarty_tpl->tpl_vars['meridien']->_loop = true;
$__foreach_meridien_0_saved_local_item = $_smarty_tpl->tpl_vars['meridien'];
?>
            <tr>
                <td>
                    <?php echo $_smarty_tpl->tpl_vars['meridien']->value['nom'];?>

                </td>
                <td>
                    <?php
$_from = $_smarty_tpl->tpl_vars['meridien']->value['desc'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_loop_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_foreach_loop']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_loop'] : false;
$__foreach_loop_1_saved_item = isset($_smarty_tpl->tpl_vars['pathologie']) ? $_smarty_tpl->tpl_vars['pathologie'] : false;
$_smarty_tpl->tpl_vars['pathologie'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['__smarty_foreach_loop'] = new Smarty_Variable(array());
$__foreach_loop_1_first = true;
$_smarty_tpl->tpl_vars['pathologie']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['pathologie']->value) {
$_smarty_tpl->tpl_vars['pathologie']->_loop = true;
$_smarty_tpl->tpl_vars['__smarty_foreach_loop']->value['first'] = $__foreach_loop_1_first;
$__foreach_loop_1_first = false;
$__foreach_loop_1_saved_local_item = $_smarty_tpl->tpl_vars['pathologie'];
?>
                        <?php if (!(isset($_smarty_tpl->tpl_vars['__smarty_foreach_loop']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_loop']->value['first'] : null)) {?><span class="separateur">, </span><?php }?> 
                            <?php echo $_smarty_tpl->tpl_vars['pathologie']->value;?>

                    <?php
$_smarty_tpl->tpl_vars['pathologie'] = $__foreach_loop_1_saved_local_item;
}
if ($__foreach_loop_1_saved) {
$_smarty_tpl->tpl_vars['__smarty_foreach_loop'] = $__foreach_loop_1_saved;
}
if ($__foreach_loop_1_saved_item) {
$_smarty_tpl->tpl_vars['pathologie'] = $__foreach_loop_1_saved_item;
}
?>
                </td>
            </tr>
            <?php
$_smarty_tpl->tpl_vars['meridien'] = $__foreach_meridien_0_saved_local_item;
}
if ($__foreach_meridien_0_saved_item) {
$_smarty_tpl->tpl_vars['meridien'] = $__foreach_meridien_0_saved_item;
}
?>
        </tfoot>
    </table>
</div><?php }
}
