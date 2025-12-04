<?php
/* Smarty version 3.1.39, created on 2025-03-13 10:15:23
  from '/home/site/wwwroot/modules/hotelreservationsystem/views/templates/admin/hotel_rooms_booking/helpers/view/_partials/booking-cart.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d2b03bca9555_09145240',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '62edf788a5059bfa13d7593e568bef25eaf55e9a' => 
    array (
      0 => '/home/site/wwwroot/modules/hotelreservationsystem/views/templates/admin/hotel_rooms_booking/helpers/view/_partials/booking-cart.tpl',
      1 => 1741860840,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67d2b03bca9555_09145240 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/site/wwwroot/tools/smarty/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close margin-right-10" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel"><i class="icon-shopping-cart"></i>&nbsp; <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Cart Options','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</h4>
			</div>
			<div class="modal-body">
				<div class="row margin-lr-0">
					<div class="cart_table_container">
                        <?php if ((isset($_smarty_tpl->tpl_vars['cart_bdata']->value))) {?>
							<table class="table table-responsive addtocart-table">
								<thead class="cart-table-thead">
									<tr>
										<th class="text-center"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room No.','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</th>
										<th class="text-center"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room Type','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</th>
										<th class="text-center"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Duration','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</th>
										<th class="text-center"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Amount (Tax excl.)','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</th>
										<th></th>
									</tr>
								</thead>
								<tbody class="cart_tbody">
								<?php if ((isset($_smarty_tpl->tpl_vars['cart_bdata']->value))) {?>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cart_bdata']->value, 'cart_data');
$_smarty_tpl->tpl_vars['cart_data']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['cart_data']->value) {
$_smarty_tpl->tpl_vars['cart_data']->do_else = false;
?>
										<tr>
											<td class="text-center"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cart_data']->value['room_num'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
											<td class="text-center"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cart_data']->value['room_type'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
											<?php $_smarty_tpl->_assignInScope('is_full_date', ($_smarty_tpl->tpl_vars['show_full_date']->value && (smarty_modifier_date_format($_smarty_tpl->tpl_vars['cart_data']->value['date_from'],'%D') == smarty_modifier_date_format($_smarty_tpl->tpl_vars['cart_data']->value['date_to'],'%D'))));?>
											<td class="text-center"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0], array( array('date'=>$_smarty_tpl->tpl_vars['cart_data']->value['date_from'],'full'=>$_smarty_tpl->tpl_vars['is_full_date']->value),$_smarty_tpl ) );?>
 - <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0], array( array('date'=>$_smarty_tpl->tpl_vars['cart_data']->value['date_to'],'full'=>$_smarty_tpl->tpl_vars['is_full_date']->value),$_smarty_tpl ) );?>
</td>
											<td class="text-center"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0], array( array('price'=>($_smarty_tpl->tpl_vars['cart_data']->value['amt_with_qty']+$_smarty_tpl->tpl_vars['cart_data']->value['additional_services_auto_add_with_room_price']+$_smarty_tpl->tpl_vars['cart_data']->value['additional_service_price']+$_smarty_tpl->tpl_vars['cart_data']->value['demand_price'])),$_smarty_tpl ) );?>
</td>
											<td class="text-center"><button class="btn btn-default ajax_cart_delete_data" data-id-product="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cart_data']->value['id_product'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-id-hotel="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cart_data']->value['id_hotel'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-id-cart="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cart_data']->value['id_cart'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-id-cart-book-data="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cart_data']->value['id'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-date-from="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cart_data']->value['date_from'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-date-to="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cart_data']->value['date_to'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"><i class='icon-trash'></i></button></td>
										</tr>
									<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
								<?php }?>
								</tbody>
							</table>
						<?php }?>
						<?php if ((isset($_smarty_tpl->tpl_vars['cart_normal_data']->value))) {?>
                            <table class="table table-responsive addtocart-table">
                                <thead class="cart-table-thead">
                                    <tr>
                                        <th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Id','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</th>
                                        <th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Name','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</th>
                                        <th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Hotel','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</th>
                                        <th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Quantity','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</th>
                                        <th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Amount (Tax excl.)','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</th>
                                        <th></th>
                                    </tr>
                                    <tbody class="cart_tbody">
                                        <?php if ((isset($_smarty_tpl->tpl_vars['cart_normal_data']->value))) {?>
                                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cart_normal_data']->value, 'cart_data');
$_smarty_tpl->tpl_vars['cart_data']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['cart_data']->value) {
$_smarty_tpl->tpl_vars['cart_data']->do_else = false;
?>
                                                <tr>
                                                    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cart_data']->value['id_product'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                                                    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cart_data']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                                                    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cart_data']->value['hotel_name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                                                    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cart_data']->value['quantity'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                                                    <td><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0], array( array('price'=>$_smarty_tpl->tpl_vars['cart_data']->value['total_price_tax_excl']),$_smarty_tpl ) );?>
</td>
                                                    <td><button class="btn btn-default service_product_delete" data-id-hotel="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cart_data']->value['id_hotel'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-id-product="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cart_data']->value['id_product'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-id-cart="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['id_cart']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"><i class='icon-trash'></i></button></td>
                                                </tr>
                                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                        <?php }?>
                                    </tbody>

                                </thead>
                            </table>
                        <?php }?>

					</div>
					<div class="row cart_amt_div">
						<table class="table table-responsive">
							<tr>
								<td><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Rooms Amount (Tax excl.):','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</td>
								<td class="text-right" id="cart_rooms_amount">
									<?php if ((isset($_smarty_tpl->tpl_vars['cart_rooms_amount']->value))) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0], array( array('price'=>$_smarty_tpl->tpl_vars['cart_rooms_amount']->value),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0], array( array('price'=>0),$_smarty_tpl ) );
}?>
								</td>
							</tr>
							<tr>
								<td><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Convenience Fee (Tax excl.):','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</td>
								<td class="text-right" id="cart_convenience_fee">
									<?php if ((isset($_smarty_tpl->tpl_vars['cart_amount_convenience_fee']->value))) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0], array( array('price'=>$_smarty_tpl->tpl_vars['cart_amount_convenience_fee']->value),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0], array( array('price'=>0),$_smarty_tpl ) );
}?>
								</td>
							</tr>
							<tr>
								<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total Amount (Tax excl.):','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</th>
								<th class="text-right" id="cart_total_amt">
									<?php if ((isset($_smarty_tpl->tpl_vars['cart_tamount']->value))) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0], array( array('price'=>$_smarty_tpl->tpl_vars['cart_tamount']->value),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0], array( array('price'=>0),$_smarty_tpl ) );
}?>
								</th>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminOrders');?>
&amp;addorder&amp;cart_id=<?php echo intval(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['id_cart']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'));?>
" class="btn btn-primary cart_booking_btn" <?php if (!$_smarty_tpl->tpl_vars['total_products_in_cart']->value) {?>disabled="disabled"<?php }?>>
					<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Book Now','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>

				</a>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Close','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</button>
			</div>
		</div>
	</div><?php }
}
