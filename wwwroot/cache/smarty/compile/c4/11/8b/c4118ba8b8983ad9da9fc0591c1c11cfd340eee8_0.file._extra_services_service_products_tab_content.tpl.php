<?php
/* Smarty version 3.1.39, created on 2025-05-07 15:40:50
  from '/www/wwwroot/prestigehotel.org/admin033aqbbsn/themes/default/template/controllers/orders/modals/_extra_services_service_products_tab_content.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_681b7f026d8575_71233914',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c4118ba8b8983ad9da9fc0591c1c11cfd340eee8' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/admin033aqbbsn/themes/default/template/controllers/orders/modals/_extra_services_service_products_tab_content.tpl',
      1 => 1741272494,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_681b7f026d8575_71233914 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div id="room_type_service_product_desc" class="tab-pane <?php if ((isset($_smarty_tpl->tpl_vars['show_active']->value)) && $_smarty_tpl->tpl_vars['show_active']->value) {?>active<?php }?> extra-services-container">
	<?php if ((isset($_smarty_tpl->tpl_vars['orderEdit']->value)) && $_smarty_tpl->tpl_vars['orderEdit']->value) {?>

		<p class="col-sm-12 facility_nav_btn">
			<button id="btn_new_room_service" class="btn btn-success"><i class="icon-plus"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add new service'),$_smarty_tpl ) );?>
</button>
			<button id="back_to_service_btn" class="btn btn-default"><i class="icon-arrow-left"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Back'),$_smarty_tpl ) );?>
</button>
		</p>

				<div class="col-sm-12 room_ordered_services table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Name'),$_smarty_tpl ) );?>
</th>
						<th class="fixed-width-sm"></th>
						<th class="fixed-width-sm text-center"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Quantity'),$_smarty_tpl ) );?>
</th>
						<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Unit Price (tax excl.)'),$_smarty_tpl ) );?>
</th>
						<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total Price (tax excl.)'),$_smarty_tpl ) );?>
</th>
						<th class="text-right"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Action'),$_smarty_tpl ) );?>
</th>
					</tr>
				</thead>
				<tbody>
					<?php if ((isset($_smarty_tpl->tpl_vars['additionalServices']->value)) && $_smarty_tpl->tpl_vars['additionalServices']->value) {?>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['additionalServices']->value['additional_services'], 'service');
$_smarty_tpl->tpl_vars['service']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['service']->value) {
$_smarty_tpl->tpl_vars['service']->do_else = false;
?>
							<tr class="room_demand_block" data-id_room_type_service_product_order_detail="<?php echo $_smarty_tpl->tpl_vars['service']->value['id_room_type_service_product_order_detail'];?>
">
								<td>
									<div><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['service']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</div>
								</td>
								<td>
									<?php if ($_smarty_tpl->tpl_vars['service']->value['product_auto_add'] && $_smarty_tpl->tpl_vars['service']->value['product_price_addition_type'] == Product::PRICE_ADDITION_TYPE_WITH_ROOM) {?>
										<span class="badge badge-info label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Auto added'),$_smarty_tpl ) );?>
</span><br>
									<?php }?>
									<?php if ($_smarty_tpl->tpl_vars['service']->value['product_auto_add'] && $_smarty_tpl->tpl_vars['service']->value['product_price_addition_type'] == Product::PRICE_ADDITION_TYPE_INDEPENDENT) {?>
										<span class="badge badge-info label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Convenience fee'),$_smarty_tpl ) );?>
</span>
									<?php }?>
								</td>
								<td class="text-center">
									<?php if ($_smarty_tpl->tpl_vars['service']->value['allow_multiple_quantity']) {?>
										<div class="qty_container">
											<input type="number" class="form-control qty" min="1" data-id_product="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['service']->value['id_product'], ENT_QUOTES, 'UTF-8', true);?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['service']->value['quantity'], ENT_QUOTES, 'UTF-8', true);?>
">
											<?php if ($_smarty_tpl->tpl_vars['service']->value['max_quantity']) {?>
												<p style="display:<?php if ($_smarty_tpl->tpl_vars['service']->value['quantity'] > $_smarty_tpl->tpl_vars['service']->value['max_quantity']) {?>block<?php } else { ?>none<?php }?>; margin-top: 4px;">
													<span class="label label-warning"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Maximum allowed quantity: %s','sprintf'=>$_smarty_tpl->tpl_vars['service']->value['max_quantity']),$_smarty_tpl ) );?>
</span>
												</p>
											<?php }?>
										</div>
									<?php } else { ?>
										--
									<?php }?>
								</td>
								<td>
									<div class="input-group">
										<span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['currencySign']->value;?>
</span>
										<input type="text" class="form-control unit_price" value="<?php echo Tools::ps_round($_smarty_tpl->tpl_vars['service']->value['unit_price_tax_excl'],2);?>
" data-id-product="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
">
										<?php if (Product::PRICE_CALCULATION_METHOD_PER_DAY == $_smarty_tpl->tpl_vars['service']->value['product_price_calculation_method']) {?>
											<span class="input-group-addon"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'/ night'),$_smarty_tpl ) );?>
</span>
										<?php }?>
									</div>
																	</td>
								<td><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0], array( array('price'=>htmlspecialchars($_smarty_tpl->tpl_vars['service']->value['total_price_tax_excl'], ENT_QUOTES, 'UTF-8', true),'currency'=>$_smarty_tpl->tpl_vars['orderCurrency']->value),$_smarty_tpl ) );?>
</td>
								<td class="text-right"><a class="btn btn-danger pull-right del_room_additional_service" data-id_room_type_service_product_order_detail="<?php echo $_smarty_tpl->tpl_vars['service']->value['id_room_type_service_product_order_detail'];?>
" href="#"><i class="icon-trash"></i></a></td>
							</tr>
						<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					<?php } else { ?>
						<tr>
							<td colspan="3">
								<i class="icon-warning"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No services added yet.'),$_smarty_tpl ) );?>

							</td>
						</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
		<form id="add_room_services_form" class="col-sm-12 room_services_container">
			<div class="room_demand_detail">
				<?php if ((isset($_smarty_tpl->tpl_vars['roomTypeServiceProducts']->value)) && $_smarty_tpl->tpl_vars['roomTypeServiceProducts']->value) {?>
					<table class="table">
						<thead>
							<tr>
								<th></th>
								<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Name'),$_smarty_tpl ) );?>
</th>
								<th class="fixed-width-sm"> </th>
								<th class="fixed-width-sm text-center"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Quantity'),$_smarty_tpl ) );?>
</th>
								<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Unit Price (tax excl.)'),$_smarty_tpl ) );?>
</th>
							</tr>
						</thead>
						<tbody>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['roomTypeServiceProducts']->value, 'product');
$_smarty_tpl->tpl_vars['product']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->do_else = false;
?>
								<tr class="room_demand_block">
									<td>
										<input data-id_booking_detail="<?php echo $_smarty_tpl->tpl_vars['id_booking_detail']->value;?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_product'], ENT_QUOTES, 'UTF-8', true);?>
" name="selected_service[]" type="checkbox" class="id_room_type_service"/>
									</td>
									<td>
										<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>

									</td>
									<td class="text-center">
										<?php if ($_smarty_tpl->tpl_vars['product']->value['auto_add_to_cart'] && $_smarty_tpl->tpl_vars['product']->value['price_addition_type'] == Product::PRICE_ADDITION_TYPE_WITH_ROOM) {?>
											<span class="badge badge-info label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Auto added'),$_smarty_tpl ) );?>
</span><br>
										<?php }?>
										<?php if ($_smarty_tpl->tpl_vars['product']->value['auto_add_to_cart'] && $_smarty_tpl->tpl_vars['product']->value['price_addition_type'] == Product::PRICE_ADDITION_TYPE_INDEPENDENT) {?>
											<span class="badge badge-info label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Convenience fee'),$_smarty_tpl ) );?>
</span>
										<?php }?>
									</td>
									<td class="text-center">
										<?php if ($_smarty_tpl->tpl_vars['product']->value['allow_multiple_quantity']) {?>
											<div class="qty_container">
												<input type="number" class="form-control qty" min="1" id="qty_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_product'], ENT_QUOTES, 'UTF-8', true);?>
" name="service_qty[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_product'], ENT_QUOTES, 'UTF-8', true);?>
]" data-id-product="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_product'], ENT_QUOTES, 'UTF-8', true);?>
" value="1">
											</div>
										<?php } else { ?>
											<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'--'),$_smarty_tpl ) );?>

										<?php }?>
									</td>
									<td class="text-right">
										<div class="input-group">
											<span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['currencySign']->value;?>
</span>
											<input type="text" class="form-control unit_price" name="service_price[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_product'], ENT_QUOTES, 'UTF-8', true);?>
]" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['price_tax_exc'];?>
" data-id-product="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
">
											<?php if (Product::PRICE_CALCULATION_METHOD_PER_DAY == $_smarty_tpl->tpl_vars['product']->value['price_calculation_method']) {?>
												<span class="input-group-addon"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'/ night'),$_smarty_tpl ) );?>
</span>
											<?php }?>
										</div>
									</td>
								</tr>
							<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
						</tbody>
					</table>

                    <div class="modal-footer">
                        <button type="submit" id="save_service_service" class="btn btn-primary"><i class="icon icon-save"></i> &nbsp;<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Update Services"),$_smarty_tpl ) );?>
</button>
                    </div>
				<?php } else { ?>
					<i class="icon-warning"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No services available to add to this room.'),$_smarty_tpl ) );?>

				<?php }?>
			</div>
			<input type="hidden" name="id_booking_detail" value="<?php echo $_smarty_tpl->tpl_vars['id_booking_detail']->value;?>
">
		</form>

	<?php } elseif ((isset($_smarty_tpl->tpl_vars['additionalServices']->value)) && $_smarty_tpl->tpl_vars['additionalServices']->value) {?>
		<table class="table room_demand_detail">
			<thead>
				<tr>
					<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'ID'),$_smarty_tpl ) );?>
</th>
					<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Name'),$_smarty_tpl ) );?>
</th>
					<th></th>
					<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Unit Price'),$_smarty_tpl ) );?>
</th>
					<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total Price'),$_smarty_tpl ) );?>
</th>
				</tr>
			</thead>
			</tbody>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['additionalServices']->value['additional_services'], 'service');
$_smarty_tpl->tpl_vars['service']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['service']->value) {
$_smarty_tpl->tpl_vars['service']->do_else = false;
?>
					<tr class="room_demand_block">
						<td>
							<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['service']->value['id_product'], ENT_QUOTES, 'UTF-8', true);?>
 <a target="blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminNormalProducts'), ENT_QUOTES, 'UTF-8', true);?>
&amp;id_product=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['service']->value['id_product'], ENT_QUOTES, 'UTF-8', true);?>
&amp;updateproduct"><i class="icon-external-link-sign"></i></a>
						</td>
						<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['service']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</td>
						<td>
							<?php if ($_smarty_tpl->tpl_vars['service']->value['product_auto_add'] && $_smarty_tpl->tpl_vars['service']->value['product_price_addition_type'] == Product::PRICE_ADDITION_TYPE_INDEPENDENT) {?>
								<span class="badge badge-info label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Convenience fee'),$_smarty_tpl ) );?>
</span>
							<?php }?>
							<?php if ($_smarty_tpl->tpl_vars['service']->value['product_auto_add'] && $_smarty_tpl->tpl_vars['service']->value['product_price_addition_type'] == Product::PRICE_ADDITION_TYPE_WITH_ROOM) {?>
								<span class="badge badge-info label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Auto added'),$_smarty_tpl ) );?>
</span>
							<?php }?>
						</td>
						<td>
							<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0], array( array('price'=>$_smarty_tpl->tpl_vars['service']->value['unit_price_tax_excl'],'currency'=>$_smarty_tpl->tpl_vars['orderCurrency']->value),$_smarty_tpl ) );?>

							<?php if ($_smarty_tpl->tpl_vars['service']->value['product_price_calculation_method'] == Product::PRICE_CALCULATION_METHOD_PER_DAY) {?>
								<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'/ night'),$_smarty_tpl ) );?>

							<?php }?>
						</td>
						<td>
							<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0], array( array('price'=>$_smarty_tpl->tpl_vars['service']->value['total_price_tax_excl'],'currency'=>$_smarty_tpl->tpl_vars['orderCurrency']->value),$_smarty_tpl ) );?>

						</td>
					</tr>
				<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			</tbody>
		</table>
	<?php } else { ?>
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No services selected!'),$_smarty_tpl ) );?>

	<?php }?>
</div>
<?php }
}
