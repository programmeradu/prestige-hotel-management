<?php
/* Smarty version 3.1.39, created on 2025-05-11 18:00:16
  from '/www/wwwroot/prestigehotel.org/themes/hotel-reservation-theme/modules/bankwire/views/templates/hook/payment_return.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_6820e5b0818589_66530265',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c10320b84d25a9412d1e4aadbd3da78ef543d0f3' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/themes/hotel-reservation-theme/modules/bankwire/views/templates/hook/payment_return.tpl',
      1 => 1742139974,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6820e5b0818589_66530265 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['status']->value == 'ok') {?>
        <p class="alert alert-success"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Your','mod'=>'bankwire'),$_smarty_tpl ) );?>
 <?php if (count($_smarty_tpl->tpl_vars['cart_room_bookings']->value) > 1) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'bookings have','mod'=>'bankwire'),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'booking has','mod'=>'bankwire'),$_smarty_tpl ) );
}?> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'been created successfully!','mod'=>'bankwire'),$_smarty_tpl ) );?>
</p><br /><br />
		<p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Please send us a Mobile Money payment with:','mod'=>'bankwire'),$_smarty_tpl ) );?>
</p>
		<br />- <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Amount','mod'=>'bankwire'),$_smarty_tpl ) );?>
 <span class="price"><strong><?php echo $_smarty_tpl->tpl_vars['total_to_pay']->value;?>
</strong></span>
		<br /><br />- <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Account Name:','mod'=>'bankwire'),$_smarty_tpl ) );?>
  <strong><?php if ($_smarty_tpl->tpl_vars['bankwireOwner']->value) {
echo $_smarty_tpl->tpl_vars['bankwireOwner']->value;
} else { ?>___________<?php }?></strong>
		<br /><br />- <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Network Provider:','mod'=>'bankwire'),$_smarty_tpl ) );?>
  <strong><?php if ($_smarty_tpl->tpl_vars['bankwireDetails']->value) {
echo $_smarty_tpl->tpl_vars['bankwireDetails']->value;
} else { ?>___________<?php }?></strong>
		<br /><br />- <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Mobile Money Number:','mod'=>'bankwire'),$_smarty_tpl ) );?>
  <strong><?php if ($_smarty_tpl->tpl_vars['bankwireAddress']->value) {
echo $_smarty_tpl->tpl_vars['bankwireAddress']->value;
} else { ?>___________<?php }?></strong>
		<br />
		<?php if (!(isset($_smarty_tpl->tpl_vars['reference']->value))) {?>
			<br /> <p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Do not forget to include your order number #%d in the payment reference.','sprintf'=>$_smarty_tpl->tpl_vars['id_order']->value,'mod'=>'bankwire'),$_smarty_tpl ) );?>
</p>
		<?php } else { ?>
			<br /> <p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Do not forget to include your order reference %s in the payment reference.','sprintf'=>$_smarty_tpl->tpl_vars['reference']->value,'mod'=>'bankwire'),$_smarty_tpl ) );?>
</p>
		<?php }?>
		<br />
	</p>
<?php } else { ?>
	<p class="warning">
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'We noticed a problem with your order. If you think this is an error, feel free to contact our','mod'=>'bankwire'),$_smarty_tpl ) );?>

		<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('contact',true), ENT_QUOTES, 'UTF-8', true);?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'expert customer support team','mod'=>'bankwire'),$_smarty_tpl ) );?>
</a>.
	</p>
<?php }
}
}
