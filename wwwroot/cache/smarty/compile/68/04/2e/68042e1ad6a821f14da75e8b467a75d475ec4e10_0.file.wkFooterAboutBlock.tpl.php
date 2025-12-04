<?php
/* Smarty version 3.1.39, created on 2025-07-07 15:15:08
  from '/www/wwwroot/prestigehotel.org/modules/wkfooteraboutblock/views/templates/hook/wkFooterAboutBlock.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686be47c46f418_65434578',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '68042e1ad6a821f14da75e8b467a75d475ec4e10' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/wkfooteraboutblock/views/templates/hook/wkFooterAboutBlock.tpl',
      1 => 1741272732,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686be47c46f418_65434578 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="row">
	<section class="col-xs-12 col-sm-12">
		<div class="row margin-lr-0 footer-section-heading">
			<p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'About','mod'=>'wkfooteraboutblock'),$_smarty_tpl ) );?>
</p>
			<hr/>
		</div>
		<div class="row margin-lr-0 footer-about-hotel">
			<p><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'truncate' ][ 0 ], array( $_smarty_tpl->tpl_vars['WK_HTL_SHORT_DESC']->value,220,'',true )), ENT_QUOTES, 'UTF-8', true);?>
</p>
		</div>
	</section>
</div><?php }
}
