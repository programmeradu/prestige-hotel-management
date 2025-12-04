<?php
/* Smarty version 3.1.39, created on 2025-05-11 17:59:38
  from '/www/wwwroot/prestigehotel.org/themes/hotel-reservation-theme/modules/bankwire/views/templates/hook/payment.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_6820e58a654ae1_37374537',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5d644d0208b29d0318cb1380eff52090477ba0b4' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/themes/hotel-reservation-theme/modules/bankwire/views/templates/hook/payment.tpl',
      1 => 1742139974,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6820e58a654ae1_37374537 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="row">
	<div class="col-xs-12">
		<p class="payment_module">
			<a class="bankwire" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getModuleLink('bankwire','payment'), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Pay by Mobile Money','mod'=>'bankwire'),$_smarty_tpl ) );?>
">
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Pay by Ghana Mobile Money','mod'=>'bankwire'),$_smarty_tpl ) );?>
 <span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'(MTN, Vodafone, AirtelTigo)','mod'=>'bankwire'),$_smarty_tpl ) );?>
</span>
			</a>
		</p>
	</div>
</div>
<?php }
}
