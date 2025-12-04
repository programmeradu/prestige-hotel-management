<?php
/* Smarty version 3.1.39, created on 2025-07-08 15:13:21
  from '/www/wwwroot/prestigehotel.org/pdf/invoice.total-tab.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686d3591104a12_60498526',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9fc05b8b1b9e63cebc52a9526810441822cb2135' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/pdf/invoice.total-tab.tpl',
      1 => 1741272747,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686d3591104a12_60498526 (Smarty_Internal_Template $_smarty_tpl) {
?><table id="total-tab" width="100%">

	<tr>
		<td class="grey" width="70%">
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total Rooms Cost (tax excl.)','pdf'=>'true'),$_smarty_tpl ) );?>

		</td>
		<td class="white" width="30%">
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0], array( array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['footer']->value['room_price_tax_excl']),$_smarty_tpl ) );?>

		</td>
	</tr>
	<?php if ((isset($_smarty_tpl->tpl_vars['footer']->value['additional_service_price_tax_excl'])) && $_smarty_tpl->tpl_vars['footer']->value['additional_service_price_tax_excl']) {?>
		<tr>
			<td class="grey" width="70%">
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Extra Services Cost (tax excl.)','pdf'=>'true'),$_smarty_tpl ) );?>

			</td>
			<td class="white" width="30%">
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0], array( array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>($_smarty_tpl->tpl_vars['footer']->value['additional_service_price_tax_excl'])),$_smarty_tpl ) );?>

			</td>
		</tr>
	<?php }?>
	<?php if ((isset($_smarty_tpl->tpl_vars['footer']->value['total_convenience_fee_te'])) && $_smarty_tpl->tpl_vars['footer']->value['total_convenience_fee_te']) {?>
		<tr>
			<td class="grey" width="70%">
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Convenience Fee (tax excl.)','pdf'=>'true'),$_smarty_tpl ) );?>

			</td>
			<td class="white" width="30%">
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0], array( array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['footer']->value['total_convenience_fee_te']),$_smarty_tpl ) );?>

			</td>
		</tr>
	<?php }?>
	
	
	
	<tr class="bold">
		<td class="grey">
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total (Tax excl.)','pdf'=>'true'),$_smarty_tpl ) );?>

		</td>
		<td class="white">
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0], array( array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['footer']->value['total_without_discount_te']),$_smarty_tpl ) );?>

		</td>
	</tr>
	<?php if ($_smarty_tpl->tpl_vars['footer']->value['total_tax_without_discount'] > 0) {?>
	<tr class="bold">
		<td class="grey">
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total Tax','pdf'=>'true'),$_smarty_tpl ) );?>

		</td>
		<td class="white">
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0], array( array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['footer']->value['total_tax_without_discount']),$_smarty_tpl ) );?>

		</td>
	</tr>
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['footer']->value['product_discounts_tax_incl'] > 0) {?>
		<tr class="bold">
			<td class="grey" width="70%">
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total Discounts','pdf'=>'true'),$_smarty_tpl ) );?>

			</td>
			<td class="white" width="30%">
				- <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0], array( array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['footer']->value['product_discounts_tax_incl']),$_smarty_tpl ) );?>

			</td>
		</tr>
	<?php }?>
	<tr class="bold big">
		<td class="grey">
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Final Booking Amount','pdf'=>'true'),$_smarty_tpl ) );?>

		</td>
		<td class="white">
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0], array( array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['footer']->value['total_paid_tax_incl']),$_smarty_tpl ) );?>

		</td>
	</tr>

	<?php if ($_smarty_tpl->tpl_vars['order']->value->total_paid-$_smarty_tpl->tpl_vars['order']->value->total_paid_real > 0) {?>
		<tr class="bold big">
			<td class="grey">
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Due Amount','pdf'=>'true'),$_smarty_tpl ) );?>

			</td>
			<td class="white">
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0], array( array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>($_smarty_tpl->tpl_vars['footer']->value['total_paid_tax_incl']-$_smarty_tpl->tpl_vars['footer']->value['total_paid_real'])),$_smarty_tpl ) );?>

			</td>
		</tr>
	<?php }?>
</table>
<?php }
}
