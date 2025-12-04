<?php
/* Smarty version 3.1.39, created on 2025-07-08 15:13:21
  from '/www/wwwroot/prestigehotel.org/pdf/invoice.extra-demands-tab.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686d35910183d5_47437828',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5830dd1c21e9de841fe8bacd6306932f0ea4a47e' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/pdf/invoice.extra-demands-tab.tpl',
      1 => 1741272747,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686d35910183d5_47437828 (Smarty_Internal_Template $_smarty_tpl) {
?>
<br><br>
<?php if ((isset($_smarty_tpl->tpl_vars['room_extra_demands']->value)) && $_smarty_tpl->tpl_vars['room_extra_demands']->value) {?>
	<table id="demands-table" class="bordered-table" width="100%" cellpadding="4" cellspacing="0">
		<thead>
			<tr>
				<th colspan="4" class="header"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Additional Facilities Details','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
			</tr>
			<tr>
				<th class="header-left small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room Type','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<th class="header-left small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Name','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<th class="header-left small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Tax rate(s)','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<th class="header-left small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total','pdf'=>'true'),$_smarty_tpl ) );?>
 <br /> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'(Tax excl.)','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
			</tr>
		</thead>
				<tbody>
																	<?php $_smarty_tpl->_assignInScope('roomCount', 1);?>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['room_extra_demands']->value, 'roomDemand');
$_smarty_tpl->tpl_vars['roomDemand']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['roomDemand']->value) {
$_smarty_tpl->tpl_vars['roomDemand']->do_else = false;
?>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['roomDemand']->value['extra_demands'], 'demand', false, NULL, 'demandRow', array (
  'first' => true,
  'index' => true,
));
$_smarty_tpl->tpl_vars['demand']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['demand']->value) {
$_smarty_tpl->tpl_vars['demand']->do_else = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_demandRow']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_demandRow']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_demandRow']->value['index'];
?>
									<tr class="header small">
										<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_demandRow']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_demandRow']->value['first'] : null)) {?>
											<td rowspan="<?php echo count($_smarty_tpl->tpl_vars['roomDemand']->value['extra_demands']);?>
">
												<?php echo $_smarty_tpl->tpl_vars['roomDemand']->value['room_type_name'];?>
<br>
												<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0], array( array('date'=>$_smarty_tpl->tpl_vars['roomDemand']->value['date_from']),$_smarty_tpl ) );?>
 <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'to','pdf'=>'true'),$_smarty_tpl ) );?>
 <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0], array( array('date'=>$_smarty_tpl->tpl_vars['roomDemand']->value['date_to']),$_smarty_tpl ) );?>
<br>
												<strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room','pdf'=>'true'),$_smarty_tpl ) );?>
 - <?php echo $_smarty_tpl->tpl_vars['roomCount']->value;?>
</strong>
											</td>
										<?php }?>
										<td>
											<?php echo $_smarty_tpl->tpl_vars['demand']->value['name'];?>

										</td>
										<td class="center">
											<?php echo $_smarty_tpl->tpl_vars['demand']->value['extra_demands_tax_label'];?>

										</td>
										<td>
											<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0], array( array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['demand']->value['total_price_tax_excl']),$_smarty_tpl ) );?>

										</td>
									</tr>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
								<?php $_smarty_tpl->_assignInScope('roomCount', $_smarty_tpl->tpl_vars['roomCount']->value+1);?>
							<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
								</tbody>
	</table>
<?php }?>
<br><br>

<?php if ((isset($_smarty_tpl->tpl_vars['room_additinal_services']->value)) && $_smarty_tpl->tpl_vars['room_additinal_services']->value) {?>
	<table id="demands-table" class="bordered-table" width="100%" cellpadding="4" cellspacing="0">
		<thead>
			<tr>
				<th colspan="5" class="header"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Service Details','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
			</tr>
			<tr>
				<th class="header-left small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room Type','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<th class="header-left small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Name','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<th class="header small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Tax rate(s)','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<th class="header small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Qty','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<th class="header-left small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total','pdf'=>'true'),$_smarty_tpl ) );?>
 <br /> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'(Tax excl.)','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
			</tr>
		</thead>
		<tbody>
																	<?php $_smarty_tpl->_assignInScope('roomCount', 1);?>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['room_additinal_services']->value, 'roomService');
$_smarty_tpl->tpl_vars['roomService']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['roomService']->value) {
$_smarty_tpl->tpl_vars['roomService']->do_else = false;
?>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['roomService']->value['additional_services'], 'service', false, NULL, 'demandRow', array (
  'first' => true,
  'index' => true,
));
$_smarty_tpl->tpl_vars['service']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['service']->value) {
$_smarty_tpl->tpl_vars['service']->do_else = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_demandRow']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_demandRow']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_demandRow']->value['index'];
?>
									<tr class="header small">
										<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_demandRow']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_demandRow']->value['first'] : null)) {?>
											<td rowspan="<?php echo count($_smarty_tpl->tpl_vars['roomService']->value['additional_services']);?>
">
												<?php echo $_smarty_tpl->tpl_vars['roomService']->value['room_type_name'];?>
<br>
												<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0], array( array('date'=>$_smarty_tpl->tpl_vars['roomService']->value['date_from']),$_smarty_tpl ) );?>
 <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'to','pdf'=>'true'),$_smarty_tpl ) );?>
 <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0], array( array('date'=>$_smarty_tpl->tpl_vars['roomService']->value['date_to']),$_smarty_tpl ) );?>
<br>
												<strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room','pdf'=>'true'),$_smarty_tpl ) );?>
 - <?php echo $_smarty_tpl->tpl_vars['roomCount']->value;?>
</strong>
											</td>
										<?php }?>
										<td>
											<?php echo $_smarty_tpl->tpl_vars['service']->value['name'];?>

										</td>
										<td class="center">
											<?php if ((isset($_smarty_tpl->tpl_vars['service']->value['product_tax_label'])) && $_smarty_tpl->tpl_vars['service']->value['product_tax_label']) {
echo $_smarty_tpl->tpl_vars['service']->value['product_tax_label'];
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No tax','pdf'=>'true'),$_smarty_tpl ) );
}?>
										</td>
										<td class="center">
											<?php if ($_smarty_tpl->tpl_vars['service']->value['allow_multiple_quantity']) {?>
												<?php echo $_smarty_tpl->tpl_vars['service']->value['quantity'];?>

											<?php } else { ?>
												<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'--','pdf'=>'true'),$_smarty_tpl ) );?>

											<?php }?>
										</td>
										<td>
											<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0], array( array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['service']->value['total_price_tax_excl']),$_smarty_tpl ) );?>

										</td>
									</tr>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
								<?php $_smarty_tpl->_assignInScope('roomCount', $_smarty_tpl->tpl_vars['roomCount']->value+1);?>
							<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
								</tbody>
	</table>
<?php }
}
}
