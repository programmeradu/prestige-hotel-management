<?php
/* Smarty version 3.1.39, created on 2025-07-08 15:13:20
  from '/www/wwwroot/prestigehotel.org/pdf/invoice.service-product-tab.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686d3590f07798_17007915',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0fcf68ac2d8d37781b18ae288643ff515c0bb142' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/pdf/invoice.service-product-tab.tpl',
      1 => 1741272747,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686d3590f07798_17007915 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/www/wwwroot/prestigehotel.org/tools/smarty/plugins/function.cycle.php','function'=>'smarty_function_cycle',),));
?>

<?php if ((isset($_smarty_tpl->tpl_vars['service_product_data']->value)) && $_smarty_tpl->tpl_vars['service_product_data']->value) {?>
	<table class="product" class="bordered-table" width="100%" cellpadding="4" cellspacing="0">
		<thead>
			<tr>
				<th colspan="<?php if ($_smarty_tpl->tpl_vars['display_product_images']->value) {?>6<?php } else { ?>5<?php }?>" class="header"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Service Products Details','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
			</tr>
			<tr>
				<?php if ($_smarty_tpl->tpl_vars['display_product_images']->value) {?>
					<th class="product header small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Image','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<?php }?>
				<th class="product header small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Name','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<th class="product header small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Tax Rate(s)','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<th class="product header small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Unit Price','pdf'=>'true'),$_smarty_tpl ) );?>
 <br /> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'(Tax excl.)','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<th class="product header small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Qty','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
				<th class="product header small"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total','pdf'=>'true'),$_smarty_tpl ) );?>
 <br /> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'(Tax excl.)','pdf'=>'true'),$_smarty_tpl ) );?>
</th>
			</tr>
		</thead>
		<tbody>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['service_product_data']->value, 'product');
$_smarty_tpl->tpl_vars['product']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->do_else = false;
?>
				<?php echo smarty_function_cycle(array('values'=>array("color_line_even","color_line_odd"),'assign'=>'bgcolor_class'),$_smarty_tpl);?>

				<tr class="product <?php echo $_smarty_tpl->tpl_vars['bgcolor_class']->value;?>
">
					<?php if ($_smarty_tpl->tpl_vars['display_product_images']->value) {?>
						<td class="product center">
							<?php if ((isset($_smarty_tpl->tpl_vars['product']->value['image'])) && $_smarty_tpl->tpl_vars['product']->value['image']->id) {?>
								<?php echo $_smarty_tpl->tpl_vars['product']->value['image_tag'];?>

							<?php }?>
						</td>
					<?php }?>
					<td class="product center">
						<?php echo $_smarty_tpl->tpl_vars['product']->value['product_name'];?>

					</td>
					<td class="product center">
						<?php echo $_smarty_tpl->tpl_vars['product']->value['order_detail_tax_label'];?>

					</td>
					<td class="product right">
						<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0], array( array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['product']->value['unit_price_tax_excl_including_ecotax']),$_smarty_tpl ) );?>

					</td>
					<td class="product center">
						<?php echo $_smarty_tpl->tpl_vars['product']->value['product_quantity'];?>

					</td>
					<td  class="product right">
						<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0], array( array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['product']->value['total_price_tax_excl_including_ecotax']),$_smarty_tpl ) );?>

					</td>
				</tr>
		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
		</tbody>
	</table>
<?php }?>

<?php }
}
