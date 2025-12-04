<?php
/* Smarty version 3.1.39, created on 2025-07-08 15:13:20
  from '/www/wwwroot/prestigehotel.org/pdf/invoice.addresses-tab.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686d3590e5dfd3_95697604',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '48d367d30054b311a2305953e0916755b72975da' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/pdf/invoice.addresses-tab.tpl',
      1 => 1741272747,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686d3590e5dfd3_95697604 (Smarty_Internal_Template $_smarty_tpl) {
?><table id="addresses-tab" cellspacing="0" cellpadding="0">
	<tr>
		<!-- <td width="33%"><span class="bold"> </span><br/><br/>
			<?php if ((isset($_smarty_tpl->tpl_vars['order_invoice']->value))) {
echo $_smarty_tpl->tpl_vars['order_invoice']->value->shop_address;
}?>
		</td> -->
		<!-- <td width="33%"><?php if ($_smarty_tpl->tpl_vars['delivery_address']->value) {?><span class="bold"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Delivery Address','pdf'=>'true'),$_smarty_tpl ) );?>
</span><br/><br/>
				<?php echo $_smarty_tpl->tpl_vars['delivery_address']->value;?>

			<?php }?>
		</td> -->
		<td width="33%"></td>
		<td  width="33%"></td>
		<td width="33%">
			<span class="bold"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Customer Detail','pdf'=>'true'),$_smarty_tpl ) );?>
</span><br/><br/>
			<?php if ($_smarty_tpl->tpl_vars['invoice_address']->value) {?>
				<?php echo $_smarty_tpl->tpl_vars['invoice_address']->value;?>

			<?php } else { ?>
				<?php echo $_smarty_tpl->tpl_vars['customer']->value->firstname;?>
 <?php echo $_smarty_tpl->tpl_vars['customer']->value->lastname;?>

				<br>
				<?php echo $_smarty_tpl->tpl_vars['customer']->value->phone;?>

			<?php }?>
		</td>
	</tr>
</table><?php }
}
