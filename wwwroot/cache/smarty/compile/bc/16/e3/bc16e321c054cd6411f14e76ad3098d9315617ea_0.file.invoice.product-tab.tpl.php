<?php
/* Smarty version 3.1.39, created on 2025-07-08 15:13:20
  from '/www/wwwroot/prestigehotel.org/pdf/invoice.product-tab.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686d3590ed0825_52929377',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bc16e321c054cd6411f14e76ad3098d9315617ea' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/pdf/invoice.product-tab.tpl',
      1 => 1741272747,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686d3590ed0825_52929377 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/www/wwwroot/prestigehotel.org/tools/smarty/plugins/function.cycle.php','function'=>'smarty_function_cycle',),));
?>

<?php if ((isset($_smarty_tpl->tpl_vars['cart_htl_data']->value)) && $_smarty_tpl->tpl_vars['cart_htl_data']->value) {?>
	<table class="product" class="bordered-table" width="100%" cellpadding="4" cellspacing="0">
		<thead>
			<tr>
				<th colspan="<?php if ($_smarty_tpl->tpl_vars['display_product_images']->value) {?>9<?php } else { ?>8<?php }?>" class="header"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Rooms Details','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
			</tr>
			<tr>
				<?php if ($_smarty_tpl->tpl_vars['display_product_images']->value) {?>
					<th class="product header small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room Image','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<?php }?>
				<th class="product header small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room Description','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<th class="product header small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Hotel','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<th class="product header small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Tax Rate(s)','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				
				<th class="product header small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Unit Price','pdf'=>'true'),$_smarty_tpl ) );?>
 <br /> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'(Tax excl.)','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<th class="product header small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Rooms','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<th class="product header small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Check-in Date','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<th class="product header small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Check-out Date','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<th class="product header small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total','pdf'=>'true'),$_smarty_tpl ) );?>
 <br /> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'(Tax excl.)','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
			</tr>
		</thead>
		<tbody>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cart_htl_data']->value, 'data_v', false, 'data_k');
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
						<?php echo smarty_function_cycle(array('values'=>array("color_line_even","color_line_odd"),'assign'=>'bgcolor_class'),$_smarty_tpl);?>

						<tr class="product <?php echo $_smarty_tpl->tpl_vars['bgcolor_class']->value;?>
">
							<?php if ($_smarty_tpl->tpl_vars['display_product_images']->value) {?>
								<td class="cart_product">
									<img src="<?php echo $_smarty_tpl->tpl_vars['data_v']->value['cover_img'];?>
" class="thumbnail" />
								</td>
							<?php }?>
							<td class="product center">
								<p class="product-name">
									<?php echo $_smarty_tpl->tpl_vars['data_v']->value['name'];?>

								</p>
							</td>
							<td class="product center">
								<p>
									<?php echo $_smarty_tpl->tpl_vars['data_v']->value['hotel_name'];?>

								</p>
							</td>
							<td class="product center">
								<?php echo $_smarty_tpl->tpl_vars['data_v']->value['order_detail_tax_label'];?>

							</td>
							<td class="product center">
								<p class="text-center">
									<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0], array( array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['rm_v']->value['avg_paid_unit_price_tax_excl']),$_smarty_tpl ) );?>

								</p>
							</td>
							<td class="product center">
								<p class="text-left">
									<?php if ($_smarty_tpl->tpl_vars['rm_v']->value['adults'] <= 9) {?>0<?php echo $_smarty_tpl->tpl_vars['rm_v']->value['adults'];
} else {
echo $_smarty_tpl->tpl_vars['rm_v']->value['adults'];
}?> <?php if ($_smarty_tpl->tpl_vars['rm_v']->value['adults'] > 1) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Adults'),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Adult'),$_smarty_tpl ) );
}
if ($_smarty_tpl->tpl_vars['rm_v']->value['children']) {?>, <?php if ($_smarty_tpl->tpl_vars['rm_v']->value['children'] <= 9) {?>0<?php echo $_smarty_tpl->tpl_vars['rm_v']->value['children'];
} else { ?> <?php echo $_smarty_tpl->tpl_vars['rm_v']->value['children'];
}?> <?php if ($_smarty_tpl->tpl_vars['rm_v']->value['children'] > 1) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Children'),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Child'),$_smarty_tpl ) );
}
}?><br><?php if ($_smarty_tpl->tpl_vars['rm_v']->value['num_rm'] <= 9) {?>0<?php }
echo $_smarty_tpl->tpl_vars['rm_v']->value['num_rm'];?>
 <?php if ($_smarty_tpl->tpl_vars['rm_v']->value['num_rm'] > 1) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Rooms'),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room'),$_smarty_tpl ) );
}?>
								</p>
							</td>
							<td class="product center">
								<p>
									<?php echo $_smarty_tpl->tpl_vars['rm_v']->value['data_form'];?>

								</p>
							</td>
							<td class="product center">
								<p>
									<?php echo $_smarty_tpl->tpl_vars['rm_v']->value['data_to'];?>

								</p>
							</td>
							<td class="product center">
								<p>
									<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0], array( array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['rm_v']->value['amount']),$_smarty_tpl ) );?>

								</p>
							</td>
						</tr>
					<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
				<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
											</tbody>
	</table>
<?php }
}
}
