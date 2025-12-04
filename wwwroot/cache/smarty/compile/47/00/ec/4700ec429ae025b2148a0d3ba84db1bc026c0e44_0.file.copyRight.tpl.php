<?php
/* Smarty version 3.1.39, created on 2025-03-13 10:15:20
  from '/home/site/wwwroot/modules/hotelreservationsystem/views/templates/hook/copyRight.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d2b038853453_93007551',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4700ec429ae025b2148a0d3ba84db1bc026c0e44' => 
    array (
      0 => '/home/site/wwwroot/modules/hotelreservationsystem/views/templates/hook/copyRight.tpl',
      1 => 1741860828,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67d2b038853453_93007551 (Smarty_Internal_Template $_smarty_tpl) {
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
