<?php
/* Smarty version 3.1.39, created on 2025-03-11 16:54:50
  from '/home/site/wwwroot/modules/wkfooteraboutblock/views/templates/hook/wkFooterAboutBlock.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d06ada1f92d3_82344554',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c8df1737808ba0cf6ec6a6e13feca442448914bc' => 
    array (
      0 => '/home/site/wwwroot/modules/wkfooteraboutblock/views/templates/hook/wkFooterAboutBlock.tpl',
      1 => 1741272732,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67d06ada1f92d3_82344554 (Smarty_Internal_Template $_smarty_tpl) {
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
