<?php
/* Smarty version 3.1.39, created on 2025-05-11 18:00:15
  from '/www/wwwroot/prestigehotel.org/mails/en/booking_extra_demands.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_6820e5afa00b24_62722058',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6efcba2be01e6437d632b13ebf3945b66a16cafb' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/mails/en/booking_extra_demands.tpl',
      1 => 1680076407,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6820e5afa00b24_62722058 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/www/wwwroot/prestigehotel.org/tools/smarty/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
if ((isset($_smarty_tpl->tpl_vars['list']->value))) {?>
	<table class="table table-recap extra-demand-table">
		<thead>
			<tr>
				<th colspan="3"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Extra Demands Details'),$_smarty_tpl ) );?>
</th>
			</tr>
			<tr>
				<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room Type'),$_smarty_tpl ) );?>
</th>
				<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Name'),$_smarty_tpl ) );?>
</th>
				<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total'),$_smarty_tpl ) );?>
 <br /> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'(Tax excl.)'),$_smarty_tpl ) );?>
</th>
			</tr>
		</thead>
		<tbody>
			<?php if ((isset($_smarty_tpl->tpl_vars['list']->value))) {?>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'data_v', false, 'data_k');
$_smarty_tpl->tpl_vars['data_v']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['data_k']->value => $_smarty_tpl->tpl_vars['data_v']->value) {
$_smarty_tpl->tpl_vars['data_v']->do_else = false;
?>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data_v']->value['date_diff'], 'rm_v', false, 'rm_k');
$_smarty_tpl->tpl_vars['rm_v']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['rm_k']->value => $_smarty_tpl->tpl_vars['rm_v']->value) {
$_smarty_tpl->tpl_vars['rm_v']->do_else = false;
?>
						<?php if ((isset($_smarty_tpl->tpl_vars['rm_v']->value['extra_demands'])) && $_smarty_tpl->tpl_vars['rm_v']->value['extra_demands']) {?>
							<?php $_smarty_tpl->_assignInScope('roomCount', 1);?>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rm_v']->value['extra_demands'], 'roomDemand');
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
									<?php if (!(isset($_smarty_tpl->tpl_vars['room_demand_exists']->value))) {?>
										<?php $_smarty_tpl->_assignInScope('room_demand_exists', 1);?>
									<?php }?>
									<tr>
										<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_demandRow']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_demandRow']->value['first'] : null)) {?>
											<td class="text-center" rowspan="<?php echo count($_smarty_tpl->tpl_vars['roomDemand']->value['extra_demands']);?>
">
												<font size="2" face="Open-sans, sans-serif" color="#555454">
													<?php echo $_smarty_tpl->tpl_vars['data_v']->value['name'];?>
<br>
													<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['rm_v']->value['data_form'],"%d-%m-%Y");?>
 <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'to'),$_smarty_tpl ) );?>
 <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['rm_v']->value['data_to'],"%d-%m-%Y");?>
<br>
													<strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room'),$_smarty_tpl ) );?>
 - <?php echo $_smarty_tpl->tpl_vars['roomCount']->value;?>
</strong>
												</font>
											</td>
										<?php }?>
										<td class="text-center">
											<font size="2" face="Open-sans, sans-serif" color="#555454">
												<?php echo $_smarty_tpl->tpl_vars['demand']->value['name'];?>

											</font>
										</td>
										<td class="text-center">
											<font size="2" face="Open-sans, sans-serif" color="#555454">
												<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0], array( array('price'=>$_smarty_tpl->tpl_vars['demand']->value['total_price_tax_excl']),$_smarty_tpl ) );?>

											</font>
										</td>
									</tr>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
								<?php $_smarty_tpl->_assignInScope('roomCount', $_smarty_tpl->tpl_vars['roomCount']->value+1);?>
							<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
						<?php }?>
					<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
				<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			<?php }?>
			<?php if (!(isset($_smarty_tpl->tpl_vars['room_demand_exists']->value))) {?>
				<tr>
					<td colspan="3"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No facilities requested'),$_smarty_tpl ) );?>
</td>
				</tr>
			<?php }?>
		</tbody>
	</table>
	<br><br>
	<table class="table table-recap extra-demand-table">
		<thead>
			<tr>
				<th colspan="4"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Additional services Details'),$_smarty_tpl ) );?>
</th>
			</tr>
			<tr>
				<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room Type'),$_smarty_tpl ) );?>
</th>
				<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Name'),$_smarty_tpl ) );?>
</th>
				<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Qty'),$_smarty_tpl ) );?>
</th>
				<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total'),$_smarty_tpl ) );?>
</th>
			</tr>
		</thead>
		<tbody>
			<?php if ((isset($_smarty_tpl->tpl_vars['list']->value))) {?>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'data_v', false, 'data_k');
$_smarty_tpl->tpl_vars['data_v']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['data_k']->value => $_smarty_tpl->tpl_vars['data_v']->value) {
$_smarty_tpl->tpl_vars['data_v']->do_else = false;
?>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data_v']->value['date_diff'], 'rm_v', false, 'rm_k');
$_smarty_tpl->tpl_vars['rm_v']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['rm_k']->value => $_smarty_tpl->tpl_vars['rm_v']->value) {
$_smarty_tpl->tpl_vars['rm_v']->do_else = false;
?>
						<?php if ((isset($_smarty_tpl->tpl_vars['rm_v']->value['additional_services'])) && $_smarty_tpl->tpl_vars['rm_v']->value['additional_services']) {?>
							<?php $_smarty_tpl->_assignInScope('roomCount', 1);?>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rm_v']->value['additional_services'], 'roomService');
$_smarty_tpl->tpl_vars['roomService']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['roomService']->value) {
$_smarty_tpl->tpl_vars['roomService']->do_else = false;
?>
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['roomService']->value['additional_services'], 'service', false, NULL, 'serviceRow', array (
  'first' => true,
  'index' => true,
));
$_smarty_tpl->tpl_vars['service']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['service']->value) {
$_smarty_tpl->tpl_vars['service']->do_else = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_serviceRow']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_serviceRow']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_serviceRow']->value['index'];
?>
									<?php if (!(isset($_smarty_tpl->tpl_vars['room_additinal_services_exists']->value))) {?>
										<?php $_smarty_tpl->_assignInScope('room_additinal_services_exists', 1);?>
									<?php }?>
									<tr>
										<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_serviceRow']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_serviceRow']->value['first'] : null)) {?>
											<td class="text-center" rowspan="<?php echo count($_smarty_tpl->tpl_vars['roomService']->value['additional_services']);?>
">
												<font size="2" face="Open-sans, sans-serif" color="#555454">
													<?php echo $_smarty_tpl->tpl_vars['data_v']->value['name'];?>
<br>
													<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['rm_v']->value['data_form'],"%d-%m-%Y");?>
 <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'to'),$_smarty_tpl ) );?>
 <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['rm_v']->value['data_to'],"%d-%m-%Y");?>
<br>
													<strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room'),$_smarty_tpl ) );?>
 - <?php echo $_smarty_tpl->tpl_vars['roomCount']->value;?>
</strong>
												</font>
											</td>
										<?php }?>
										<td class="text-center">
											<font size="2" face="Open-sans, sans-serif" color="#555454">
												<?php echo $_smarty_tpl->tpl_vars['service']->value['name'];?>

											</font>
										</td>
										<td class="text-center">
											<font size="2" face="Open-sans, sans-serif" color="#555454">
												<?php if ($_smarty_tpl->tpl_vars['service']->value['allow_multiple_quantity']) {?>
													<?php echo $_smarty_tpl->tpl_vars['service']->value['quantity'];?>

												<?php } else { ?>
													<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'--'),$_smarty_tpl ) );?>

												<?php }?>
											</font>
										</td>
										<td class="text-center">
											<font size="2" face="Open-sans, sans-serif" color="#555454">
												<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0], array( array('price'=>$_smarty_tpl->tpl_vars['service']->value['total_price_tax_excl']),$_smarty_tpl ) );?>

											</font>
										</td>
									</tr>
								<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
								<?php $_smarty_tpl->_assignInScope('roomCount', $_smarty_tpl->tpl_vars['roomCount']->value+1);?>
							<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
						<?php }?>
					<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
				<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			<?php }?>
			<?php if (!(isset($_smarty_tpl->tpl_vars['room_additinal_services_exists']->value))) {?>
				<tr>
					<td colspan="4"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No service requested'),$_smarty_tpl ) );?>
</td>
				</tr>
			<?php }?>
		</tbody>
	</table>
	<style>
		.extra-demand-table {
		 	width:100%;
			border-collapse:collapse;
			padding:5px;
		}
		.extra-demand-table th {
			border:1px solid #D6D4D4;
			background-color: #fbfbfb;
			color: #333;
			font-family: Arial;
			font-size: 13px;
			padding: 7px 5px;
			text-align:left;
		}
		.extra-demand-table td {
			border:1px solid #D6D4D4;
			padding:5px;
		}
	</style>
<?php }
}
}
