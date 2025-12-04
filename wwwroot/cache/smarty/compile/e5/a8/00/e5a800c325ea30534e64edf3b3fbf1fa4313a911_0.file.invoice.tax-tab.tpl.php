<?php
/* Smarty version 3.1.39, created on 2025-07-08 15:13:21
  from '/www/wwwroot/prestigehotel.org/pdf/invoice.tax-tab.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686d359109fa99_95972388',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e5a800c325ea30534e64edf3b3fbf1fa4313a911' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/pdf/invoice.tax-tab.tpl',
      1 => 1741272747,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686d359109fa99_95972388 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!--  TAX DETAILS -->

<?php if (((isset($_smarty_tpl->tpl_vars['tax_breakdowns']->value)) && $_smarty_tpl->tpl_vars['tax_breakdowns']->value)) {?>
	<?php $_smarty_tpl->_assignInScope('th_rows', 3);?>
	<?php if ((isset($_smarty_tpl->tpl_vars['showTaxName']->value)) && $_smarty_tpl->tpl_vars['showTaxName']->value) {?>
		<?php $_smarty_tpl->_assignInScope('th_rows', $_smarty_tpl->tpl_vars['th_rows']->value+1);?>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['display_tax_bases_in_breakdowns']->value) {?>
		<?php $_smarty_tpl->_assignInScope('th_rows', $_smarty_tpl->tpl_vars['th_rows']->value+1);?>
	<?php }?>
	<table class="bordered-table" id="tax-tab" width="100%">
		<thead>
			<tr>
				<th colspan="<?php echo $_smarty_tpl->tpl_vars['th_rows']->value;?>
" class="header"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Tax Details','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
			</tr>
			<tr>
				<th class="header-left small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Taxable category','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<?php if ((isset($_smarty_tpl->tpl_vars['showTaxName']->value)) && $_smarty_tpl->tpl_vars['showTaxName']->value) {?>
					<th class="header-left small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Tax Name','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<?php }?>
				<th class="header-left small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Tax Rate','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<?php if ($_smarty_tpl->tpl_vars['display_tax_bases_in_breakdowns']->value) {?>
					<th class="header-left small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Base price','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<?php }?>
				<th class="header-left small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total Tax','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
			</tr>
		</thead>
		<tbody>

		<?php $_smarty_tpl->_assignInScope('has_line', false);?>

		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tax_breakdowns']->value, 'bd', false, 'label');
$_smarty_tpl->tpl_vars['bd']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['label']->value => $_smarty_tpl->tpl_vars['bd']->value) {
$_smarty_tpl->tpl_vars['bd']->do_else = false;
?>
			<?php $_smarty_tpl->_assignInScope('label_printed', false);?>

			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['bd']->value, 'line');
$_smarty_tpl->tpl_vars['line']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->do_else = false;
?>
				<?php if ($_smarty_tpl->tpl_vars['line']->value['rate'] == 0) {?>
					<?php continue 1;?>
				<?php }?>
				<?php $_smarty_tpl->_assignInScope('has_line', true);?>
				<tr class="<?php if (!$_smarty_tpl->tpl_vars['label_printed']->value) {?>tr-border-top<?php }?>">
					<?php if (!$_smarty_tpl->tpl_vars['label_printed']->value) {?>
						<td class="white" rowspan="<?php echo count($_smarty_tpl->tpl_vars['bd']->value);?>
">
							<?php if ($_smarty_tpl->tpl_vars['label']->value == 'additional_services_tax') {?>
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Services','pdf'=>'true'),$_smarty_tpl ) );?>

							<?php } elseif ($_smarty_tpl->tpl_vars['label']->value == 'room_tax') {?>
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Rooms','pdf'=>'true'),$_smarty_tpl ) );?>

							<?php } elseif ($_smarty_tpl->tpl_vars['label']->value == 'extra_demands_tax') {?>
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Facilities','pdf'=>'true'),$_smarty_tpl ) );?>

							<?php } elseif ($_smarty_tpl->tpl_vars['label']->value == 'convenience_fee_tax') {?>
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Convenience Fees','pdf'=>'true'),$_smarty_tpl ) );?>

							<?php } elseif ($_smarty_tpl->tpl_vars['label']->value == 'service_products_tax') {?>
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Service Products','pdf'=>'true'),$_smarty_tpl ) );?>

							<?php } elseif ($_smarty_tpl->tpl_vars['label']->value == 'shipping_tax') {?>
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Shipping','pdf'=>'true'),$_smarty_tpl ) );?>

							<?php } elseif ($_smarty_tpl->tpl_vars['label']->value == 'ecotax_tax') {?>
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Ecotax','pdf'=>'true'),$_smarty_tpl ) );?>

							<?php } elseif ($_smarty_tpl->tpl_vars['label']->value == 'wrapping_tax') {?>
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Wrapping','pdf'=>'true'),$_smarty_tpl ) );?>

							<?php }?>
							<?php $_smarty_tpl->_assignInScope('label_printed', true);?>
						</td>
					<?php }?>
					<?php if ((isset($_smarty_tpl->tpl_vars['showTaxName']->value)) && $_smarty_tpl->tpl_vars['showTaxName']->value) {?>
						<td class="white">
							<?php if ((isset($_smarty_tpl->tpl_vars['line']->value['name'])) && $_smarty_tpl->tpl_vars['line']->value['name']) {?>
								<?php echo $_smarty_tpl->tpl_vars['line']->value['name'];?>

							<?php } else { ?>
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'tax','pdf'=>'true'),$_smarty_tpl ) );?>

							<?php }?>
						</td>
					<?php }?>
					<td class="white">
						<?php echo $_smarty_tpl->tpl_vars['line']->value['rate'];?>
 %
					</td>

					<?php if ($_smarty_tpl->tpl_vars['display_tax_bases_in_breakdowns']->value) {?>
						<td class="white">
							<?php if ((isset($_smarty_tpl->tpl_vars['is_order_slip']->value)) && $_smarty_tpl->tpl_vars['is_order_slip']->value) {?>- <?php }?>
							<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0], array( array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['line']->value['total_tax_excl']),$_smarty_tpl ) );?>

						</td>
					<?php }?>

					<td class="white">
						<?php if ((isset($_smarty_tpl->tpl_vars['is_order_slip']->value)) && $_smarty_tpl->tpl_vars['is_order_slip']->value) {?>- <?php }?>
						<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0], array( array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['line']->value['total_amount']),$_smarty_tpl ) );?>

					</td>
				</tr>
			<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
		<?php if (!$_smarty_tpl->tpl_vars['has_line']->value) {?>
			<tr>
				<td class="white" colspan="<?php if ($_smarty_tpl->tpl_vars['display_tax_bases_in_breakdowns']->value) {?>4<?php } else { ?>3<?php }?>">
					<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No taxes','pdf'=>'true'),$_smarty_tpl ) );?>

				</td>
			</tr>
		<?php }?>

		</tbody>
	</table>
<?php }?>
<!--  / TAX DETAILS --><?php }
}
