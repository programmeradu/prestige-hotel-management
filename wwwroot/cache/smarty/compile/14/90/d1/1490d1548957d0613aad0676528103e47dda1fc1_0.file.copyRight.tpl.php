<?php
/* Smarty version 3.1.39, created on 2025-07-07 15:15:08
  from '/www/wwwroot/prestigehotel.org/modules/hotelreservationsystem/views/templates/hook/copyRight.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686be47c78f172_07494628',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1490d1548957d0613aad0676528103e47dda1fc1' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/hotelreservationsystem/views/templates/hook/copyRight.tpl',
      1 => 1741272629,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686be47c78f172_07494628 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="copyRightWrapper">
	<p class="copyRight">
		&copy;<?php if ((isset($_smarty_tpl->tpl_vars['WK_HTL_ESTABLISHMENT_YEAR']->value)) && $_smarty_tpl->tpl_vars['WK_HTL_ESTABLISHMENT_YEAR']->value) {?> <?php echo $_smarty_tpl->tpl_vars['WK_HTL_ESTABLISHMENT_YEAR']->value;?>
-<?php echo date('Y');?>
&nbsp;<?php }?><a href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
">&nbsp;<?php echo $_smarty_tpl->tpl_vars['WK_HTL_CHAIN_NAME']->value;?>
</a>.&nbsp;<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' All rights reserved.','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>

	</p>
</div><?php }
}
