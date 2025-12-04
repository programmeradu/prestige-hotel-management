<?php
/* Smarty version 3.1.39, created on 2025-05-11 18:00:16
  from '/www/wwwroot/prestigehotel.org/themes/hotel-reservation-theme/order-confirmation.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_6820e5b0a62b79_28939172',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4de063bc1d1b554e7eb1955db3cf1020cc46eabc' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/themes/hotel-reservation-theme/order-confirmation.tpl',
      1 => 1741272751,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6820e5b0a62b79_28939172 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_5560039706820e5b08a6d95_10179975', 'order_confirmation');
?>

<?php }
/* {block 'order_confirmation_heading'} */
class Block_10819169266820e5b08ac500_71486600 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<h1 class="page-heading"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Order confirmation'),$_smarty_tpl ) );?>
</h1>
	<?php
}
}
/* {/block 'order_confirmation_heading'} */
/* {block 'order_steps'} */
class Block_997059286820e5b08b26e1_32187163 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./order-steps.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
	<?php
}
}
/* {/block 'order_steps'} */
/* {block 'errors'} */
class Block_7656458076820e5b08bd395_58568311 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
	<?php
}
}
/* {/block 'errors'} */
/* {block 'displayOrderConfirmation'} */
class Block_963936156820e5b08c1400_54894470 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<?php echo $_smarty_tpl->tpl_vars['HOOK_ORDER_CONFIRMATION']->value;?>

	<?php
}
}
/* {/block 'displayOrderConfirmation'} */
/* {block 'displayPaymentReturn'} */
class Block_11849365456820e5b08c3e03_71818048 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

			<?php echo $_smarty_tpl->tpl_vars['HOOK_PAYMENT_RETURN']->value;?>

		<?php
}
}
/* {/block 'displayPaymentReturn'} */
/* {block 'order_detail_heading'} */
class Block_4519859366820e5b08f12a9_03362634 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

					<p><strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Order Details -'),$_smarty_tpl ) );?>
</strong></p>
				<?php
}
}
/* {/block 'order_detail_heading'} */
/* {block 'order_detail_room_type_image'} */
class Block_16881205266820e5b090ae63_14878462 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

													<td class="cart_product">
														<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getProductLink($_smarty_tpl->tpl_vars['data_v']->value['id_product']);?>
">
															<img src="<?php echo $_smarty_tpl->tpl_vars['data_v']->value['cover_img'];?>
" class="img-responsive"/>
														</a>
													</td>
												<?php
}
}
/* {/block 'order_detail_room_type_image'} */
/* {block 'order_detail_room_type_name'} */
class Block_14807851846820e5b0911f65_78654613 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

													<td class="cart_description">
														<p class="product-name">
															<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getProductLink($_smarty_tpl->tpl_vars['data_v']->value['id_product']);?>
">
																<?php echo $_smarty_tpl->tpl_vars['data_v']->value['name'];?>

															</a>
														</p>
													</td>
												<?php
}
}
/* {/block 'order_detail_room_type_name'} */
/* {block 'displayOrderConfirmationHotelNameAfter'} */
class Block_11390955006820e5b091bf44_54767840 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

															<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>"displayOrderConfirmationHotelNameAfter",'id_product'=>$_smarty_tpl->tpl_vars['data_v']->value['id_product']),$_smarty_tpl ) );?>

														<?php
}
}
/* {/block 'displayOrderConfirmationHotelNameAfter'} */
/* {block 'order_detail_room_type_hotel_name'} */
class Block_12398694986820e5b0919241_57072879 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

													<td>
														<?php echo $_smarty_tpl->tpl_vars['data_v']->value['hotel_name'];?>

														<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11390955006820e5b091bf44_54767840', 'displayOrderConfirmationHotelNameAfter', $this->tplIndex);
?>

													</td>
												<?php
}
}
/* {/block 'order_detail_room_type_hotel_name'} */
/* {block 'order_detail_room_type_guest'} */
class Block_6996671376820e5b0921de8_48597751 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

													<td class="text-center">
														<p>
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
												<?php
}
}
/* {/block 'order_detail_room_type_guest'} */
/* {block 'order_detail_room_type_check_in'} */
class Block_14503113136820e5b09509a0_40898272 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

													<td class="text-center">
														<p>
															<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0], array( array('date'=>$_smarty_tpl->tpl_vars['rm_v']->value['data_form'],'full'=>$_smarty_tpl->tpl_vars['is_full_date']->value),$_smarty_tpl ) );?>

														</p>
													</td>
												<?php
}
}
/* {/block 'order_detail_room_type_check_in'} */
/* {block 'order_detail_room_type_check_out'} */
class Block_7654885136820e5b0955712_52303298 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

													<td class="text-center">
														<p>
															<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0], array( array('date'=>$_smarty_tpl->tpl_vars['rm_v']->value['data_to'],'full'=>$_smarty_tpl->tpl_vars['is_full_date']->value),$_smarty_tpl ) );?>

														</p>
													</td>
												<?php
}
}
/* {/block 'order_detail_room_type_check_out'} */
/* {block 'order_detail_room_type_extra_demands'} */
class Block_865619616820e5b0959c12_86334942 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

													<td>
														<p class="text-center">
															<?php if (((isset($_smarty_tpl->tpl_vars['rm_v']->value['extra_demands'])) && $_smarty_tpl->tpl_vars['rm_v']->value['extra_demands']) || (isset($_smarty_tpl->tpl_vars['rm_v']->value['additional_services'])) && $_smarty_tpl->tpl_vars['rm_v']->value['additional_services']) {?>
																	<a data-date_from="<?php echo $_smarty_tpl->tpl_vars['rm_v']->value['data_form'];?>
" data-date_to="<?php echo $_smarty_tpl->tpl_vars['rm_v']->value['data_to'];?>
" data-id_product="<?php echo $_smarty_tpl->tpl_vars['data_v']->value['id_product'];?>
" data-id_order="<?php echo $_smarty_tpl->tpl_vars['data_v']->value['id_order'];?>
" data-action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('order-detail');?>
" class="open_rooms_extra_services_panel" href="#rooms_type_extra_services_form">
															<?php }?>
															<?php if ($_smarty_tpl->tpl_vars['group_use_tax']->value) {?>
																<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>($_smarty_tpl->tpl_vars['rm_v']->value['extra_demands_price_ti']+$_smarty_tpl->tpl_vars['rm_v']->value['additional_services_price_ti']),'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value),$_smarty_tpl ) );?>

															<?php } else { ?>
																<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>($_smarty_tpl->tpl_vars['rm_v']->value['extra_demands_price_te']+$_smarty_tpl->tpl_vars['rm_v']->value['additional_services_price_te']),'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value),$_smarty_tpl ) );?>

															<?php }?>
															<?php if (((isset($_smarty_tpl->tpl_vars['rm_v']->value['extra_demands'])) && $_smarty_tpl->tpl_vars['rm_v']->value['extra_demands']) || (isset($_smarty_tpl->tpl_vars['rm_v']->value['additional_services'])) && $_smarty_tpl->tpl_vars['rm_v']->value['additional_services']) {?>
																</a>
															<?php }?>
														</p>
													</td>
												<?php
}
}
/* {/block 'order_detail_room_type_extra_demands'} */
/* {block 'order_confirmation_cart_total'} */
class Block_1663181806820e5b0981344_91457798 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

													<td class="cart_total text-left">
														<p class="text-left">
															<?php if ($_smarty_tpl->tpl_vars['group_use_tax']->value) {?>
																<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>($_smarty_tpl->tpl_vars['rm_v']->value['amount_tax_incl']+$_smarty_tpl->tpl_vars['rm_v']->value['extra_demands_price_ti']+$_smarty_tpl->tpl_vars['rm_v']->value['additional_services_price_ti']+$_smarty_tpl->tpl_vars['rm_v']->value['additional_services_price_auto_add_ti']),'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value),$_smarty_tpl ) );?>

															<?php } else { ?>
																<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>($_smarty_tpl->tpl_vars['rm_v']->value['amount_tax_excl']+$_smarty_tpl->tpl_vars['rm_v']->value['extra_demands_price_te']+$_smarty_tpl->tpl_vars['rm_v']->value['additional_services_price_te']+$_smarty_tpl->tpl_vars['rm_v']->value['additional_services_price_auto_add_te']),'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value),$_smarty_tpl ) );?>

															<?php }?>
															<?php if (((isset($_smarty_tpl->tpl_vars['rm_v']->value['extra_demands'])) && $_smarty_tpl->tpl_vars['rm_v']->value['extra_demands']) || (isset($_smarty_tpl->tpl_vars['rm_v']->value['additional_services'])) && $_smarty_tpl->tpl_vars['rm_v']->value['additional_services']) {?>
																<span class="order-price-info">
																	<img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
icon/icon-info.svg" />
																</span>
																<div class="price-info-container" style="display:none">
																	<div class="price-info-tooltip-cont">
																		<div class="list-row">
																			<div>
																				<p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room cost'),$_smarty_tpl ) );?>
 : </p>
																			</div>
																			<div class="text-right">
																				<p>
																					<?php if ($_smarty_tpl->tpl_vars['group_use_tax']->value) {?>
																						<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>($_smarty_tpl->tpl_vars['rm_v']->value['amount_tax_incl']+$_smarty_tpl->tpl_vars['rm_v']->value['additional_services_price_auto_add_ti']),'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value),$_smarty_tpl ) );?>

																					<?php } else { ?>
																						<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>($_smarty_tpl->tpl_vars['rm_v']->value['amount_tax_excl']+$_smarty_tpl->tpl_vars['rm_v']->value['additional_services_price_auto_add_te']),'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value),$_smarty_tpl ) );?>

																					<?php }?>
																				</p>
																			</div>
																		</div>
																		<div class="list-row">
																			<div>
																				<p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Service cost'),$_smarty_tpl ) );?>
 : </p>
																			</div>
																			<div class="text-right">
																				<p>
																					<?php if ($_smarty_tpl->tpl_vars['group_use_tax']->value) {?>
																						<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>($_smarty_tpl->tpl_vars['rm_v']->value['extra_demands_price_ti']+$_smarty_tpl->tpl_vars['rm_v']->value['additional_services_price_ti']),'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value),$_smarty_tpl ) );?>

																					<?php } else { ?>
																						<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>($_smarty_tpl->tpl_vars['rm_v']->value['extra_demands_price_te']+$_smarty_tpl->tpl_vars['rm_v']->value['additional_services_price_te']),'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value),$_smarty_tpl ) );?>

																					<?php }?>
																				</p>
																			</div>
																		</div>
																	</div>
																</div>
															<?php }?>
														</p>
													</td>
												<?php
}
}
/* {/block 'order_confirmation_cart_total'} */
/* {block 'order_detail_total_information'} */
class Block_14232614536820e5b09ddbb5_40157342 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

									<?php if ((isset($_smarty_tpl->tpl_vars['cart_htl_data']->value))) {?>
										<?php if ($_smarty_tpl->tpl_vars['priceDisplay']->value && $_smarty_tpl->tpl_vars['use_tax']->value) {?>
											<tr class="item">
												<td colspan="3"></td>
												<td colspan="3">
													<strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total Rooms Cost (tax excl.)'),$_smarty_tpl ) );?>
</strong>
												</td>
												<td colspan="2">
													<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>($_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_rooms_te']+$_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_services_te']+$_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_auto_add_services_te']+$_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_demands_price_te']),'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value),$_smarty_tpl ) );?>
</span>
												</td>
											</tr>
										<?php } else { ?>
											<tr class="item">
												<td colspan="3"></td>
												<td colspan="3">
													<strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total Rooms Cost'),$_smarty_tpl ) );?>
 <?php if ($_smarty_tpl->tpl_vars['use_tax']->value) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'(tax incl.)'),$_smarty_tpl ) );
}?> </strong>
												</td>
												<td colspan="2">
													<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>($_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_rooms_ti']+$_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_services_ti']+$_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_auto_add_services_ti']+$_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_demands_price_ti']),'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value),$_smarty_tpl ) );?>
</span>
												</td>
											</tr>
										<?php }?>
									<?php }?>
																											<?php if ($_smarty_tpl->tpl_vars['order']->value->total_wrapping > 0) {?>
										<tr class="item">
											<td colspan="3"></td>
											<td colspan="3">
												<strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total gift wrapping cost'),$_smarty_tpl ) );?>
</strong>
											</td>
											<td colspan="2">
												<span class="price-wrapping"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>($_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_wrapping']*-1),'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value),$_smarty_tpl ) );?>
</span>
											</td>
										</tr>
									<?php }?>
									<?php if ($_smarty_tpl->tpl_vars['priceDisplay']->value && $_smarty_tpl->tpl_vars['use_tax']->value && $_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_convenience_fee_te']) {?>
										<tr class="item">
											<td colspan="3"></td>
											<td colspan="3">
												<strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total Convenience Fees (tax excl.)'),$_smarty_tpl ) );?>
</strong>
											</td>
											<td colspan="2">
												<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>($_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_convenience_fee_te']),'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value),$_smarty_tpl ) );?>
</span>
											</td>
										</tr>
									<?php } elseif ($_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_convenience_fee_ti']) {?>
										<tr class="item">
											<td colspan="3"></td>
											<td colspan="3">
												<strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total Convenience Fees'),$_smarty_tpl ) );?>
 <?php if ($_smarty_tpl->tpl_vars['use_tax']->value) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'(tax incl.)'),$_smarty_tpl ) );
}?> </strong>
											</td>
											<td colspan="2">
												<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>($_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_convenience_fee_ti']),'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value),$_smarty_tpl ) );?>
</span>
											</td>
										</tr>
									<?php }?>
									<tr class="item">
										<td colspan="3"></td>
										<td colspan="3">
											<strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total Tax'),$_smarty_tpl ) );?>
</strong>
										</td>
										<td colspan="2">
											<span class="price-discount"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>$_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_tax_without_discount'],'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value,'convert'=>1),$_smarty_tpl ) );?>
</span>
										</td>
									</tr>
									<?php if ($_smarty_tpl->tpl_vars['order']->value->total_discounts > 0) {?>
										<tr class="item">
											<td colspan="3"></td>
											<td colspan="3">
												<strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total Vouchers'),$_smarty_tpl ) );?>
</strong>
											</td>
											<td colspan="2">
												<?php if ($_smarty_tpl->tpl_vars['priceDisplay']->value && $_smarty_tpl->tpl_vars['use_tax']->value) {?>
													<span class="price-discount"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>($_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_discounts_te']*-1),'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value,'convert'=>1),$_smarty_tpl ) );?>
</span>
												<?php } else { ?>
													<span class="price-discount"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>($_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_discounts']*-1),'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value,'convert'=>1),$_smarty_tpl ) );?>
</span>
												<?php }?>
											</td>
										</tr>
									<?php }?>
									<tr class="totalprice item">
										<td colspan="3"></td>
										<td colspan="3">
											<strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Final Booking Total'),$_smarty_tpl ) );?>
</strong>
										</td>
										<td colspan="2">
											<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>$_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_paid'],'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value),$_smarty_tpl ) );?>
</span>
										</td>
									</tr>
									<?php if ($_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_paid'] > $_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_paid_real']) {?>
										<tr class="item">
											<td colspan="3"></td>
											<td colspan="3">
												<strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Due Amount'),$_smarty_tpl ) );?>
</strong>
											</td>
											<td colspan="2">
												<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>($_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_paid']-$_smarty_tpl->tpl_vars['orderTotalInfo']->value['total_paid_real']),'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value),$_smarty_tpl ) );?>
</span>
											</td>
										</tr>
									<?php }?>
								<?php
}
}
/* {/block 'order_detail_total_information'} */
/* {block 'order_details'} */
class Block_8576373786820e5b08f44b2_22759735 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/www/wwwroot/prestigehotel.org/tools/smarty/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>

					<div id="order-detail-content" class="">
						<table class="table table-bordered">
							<?php if ((isset($_smarty_tpl->tpl_vars['cart_htl_data']->value))) {?>
								<thead>
									<tr>
										<th class="cart_product"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room Image'),$_smarty_tpl ) );?>
</th>
										<th class="cart_description"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room Description'),$_smarty_tpl ) );?>
</th>
										<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Hotel Name'),$_smarty_tpl ) );?>
</th>
										<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Rooms'),$_smarty_tpl ) );?>
</th>
										<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Check-in Date'),$_smarty_tpl ) );?>
</th>
										<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Check-out Date'),$_smarty_tpl ) );?>
</th>
										<th><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Extra Services'),$_smarty_tpl ) );?>
</th>
										<th class="cart_total"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total'),$_smarty_tpl ) );?>
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
											<tr class="table_body">
												<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_16881205266820e5b090ae63_14878462', 'order_detail_room_type_image', $this->tplIndex);
?>

												<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14807851846820e5b0911f65_78654613', 'order_detail_room_type_name', $this->tplIndex);
?>

												<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_12398694986820e5b0919241_57072879', 'order_detail_room_type_hotel_name', $this->tplIndex);
?>

												<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_6996671376820e5b0921de8_48597751', 'order_detail_room_type_guest', $this->tplIndex);
?>

												<?php $_smarty_tpl->_assignInScope('is_full_date', ($_smarty_tpl->tpl_vars['show_full_date']->value && (smarty_modifier_date_format($_smarty_tpl->tpl_vars['rm_v']->value['data_form'],'%D') == smarty_modifier_date_format($_smarty_tpl->tpl_vars['rm_v']->value['data_to'],'%D'))));?>
												<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14503113136820e5b09509a0_40898272', 'order_detail_room_type_check_in', $this->tplIndex);
?>

												<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7654885136820e5b0955712_52303298', 'order_detail_room_type_check_out', $this->tplIndex);
?>

												<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_865619616820e5b0959c12_86334942', 'order_detail_room_type_extra_demands', $this->tplIndex);
?>

												<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1663181806820e5b0981344_91457798', 'order_confirmation_cart_total', $this->tplIndex);
?>

												<?php if ((isset($_smarty_tpl->tpl_vars['orders_has_invoice']->value)) && $_smarty_tpl->tpl_vars['orders_has_invoice']->value && $_smarty_tpl->tpl_vars['order']->value->payment != 'Free order') {?>
												<?php }?>
																							</tr>
										<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
									<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
								</tbody>
							<?php }?>
							<?php if ((isset($_smarty_tpl->tpl_vars['cart_service_products']->value))) {?>
								<thead>
									<tr>
										<th colspan="1"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Image'),$_smarty_tpl ) );?>
</th>
										<th colspan="2"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Name'),$_smarty_tpl ) );?>
</th>
										<th colspan="2"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Unit Price'),$_smarty_tpl ) );?>
</th>
										<th colspan="1"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Quantity'),$_smarty_tpl ) );?>
</th>
										<th colspan="2" class="cart_total"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total'),$_smarty_tpl ) );?>
</th>
									</tr>
								</thead>
								<tbody>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cart_service_products']->value, 'data_v', false, 'data_k');
$_smarty_tpl->tpl_vars['data_v']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['data_k']->value => $_smarty_tpl->tpl_vars['data_v']->value) {
$_smarty_tpl->tpl_vars['data_v']->do_else = false;
?>
										<tr class="table_body">
											<td class="cart_product">
												<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getProductLink($_smarty_tpl->tpl_vars['data_v']->value['id_product']);?>
">
													<img src="<?php echo $_smarty_tpl->tpl_vars['data_v']->value['cover_img'];?>
" class="img-responsive"/>
												</a>
											</td>
											<td class="cart_product" colspan="2">
												<p class="product-name">
													<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getProductLink($_smarty_tpl->tpl_vars['data_v']->value['id_product']);?>
">
														<?php echo $_smarty_tpl->tpl_vars['data_v']->value['product_name'];?>

													</a>
												</p>
											</td>
											<td class="cart_unit" colspan="2">
												<p class="text-center">
													<?php if ($_smarty_tpl->tpl_vars['group_use_tax']->value) {?>
														<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>$_smarty_tpl->tpl_vars['data_v']->value['unit_price_tax_incl'],'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value),$_smarty_tpl ) );?>

																											<?php } else { ?>
																												<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>$_smarty_tpl->tpl_vars['data_v']->value['unit_price_tax_excl'],'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value),$_smarty_tpl ) );?>

													<?php }?>
												</p>
											</td>
											<td>
												<p class="text-center">
													<?php echo $_smarty_tpl->tpl_vars['data_v']->value['product_quantity'];?>

												</p>
											</td>
											<td>
												<p class="text-left" colspan="2">
													<?php if ($_smarty_tpl->tpl_vars['group_use_tax']->value) {?>
														<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>$_smarty_tpl->tpl_vars['data_v']->value['total_price_tax_incl'],'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value),$_smarty_tpl ) );?>

													<?php } else { ?>
														<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPriceWithCurrency'][0], array( array('price'=>$_smarty_tpl->tpl_vars['data_v']->value['total_price_tax_excl'],'currency'=>$_smarty_tpl->tpl_vars['objOrderCurrency']->value),$_smarty_tpl ) );?>

													<?php }?>
												</p>
											</td>
										</tr>
									<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
								</tbody>
							<?php }?>
							<tfoot>
								<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14232614536820e5b09ddbb5_40157342', 'order_detail_total_information', $this->tplIndex);
?>

							</tfoot>
						</table>
					</div>
				<?php
}
}
/* {/block 'order_details'} */
/* {block 'order_confirmation_room_extra_services'} */
class Block_14017253366820e5b0a421b3_47451973 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<div style="display:none;" id="rooms_extra_services">
					</div>
	<?php
}
}
/* {/block 'order_confirmation_room_extra_services'} */
/* {block 'order_confirmation_js_vars'} */
class Block_23360846820e5b0a443f9_70007904 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0], array( array('historyUrl'=>preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['link']->value->getPageLink("orderdetail",true))),$_smarty_tpl ) );
$_block_plugin1 = isset($_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]) ? $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0] : null;
if (!is_callable(array($_block_plugin1, 'addJsDefL'))) {
throw new SmartyException('block tag \'addJsDefL\' not callable or registered');
}
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('addJsDefL', array('name'=>'req_sent_msg'));
$_block_repeat=true;
echo $_block_plugin1->addJsDefL(array('name'=>'req_sent_msg'), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Request Sent..','js'=>1),$_smarty_tpl ) );
$_block_repeat=false;
echo $_block_plugin1->addJsDefL(array('name'=>'req_sent_msg'), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);
$_block_plugin2 = isset($_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]) ? $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0] : null;
if (!is_callable(array($_block_plugin2, 'addJsDefL'))) {
throw new SmartyException('block tag \'addJsDefL\' not callable or registered');
}
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('addJsDefL', array('name'=>'wait_stage_msg'));
$_block_repeat=true;
echo $_block_plugin2->addJsDefL(array('name'=>'wait_stage_msg'), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Waiting','js'=>1),$_smarty_tpl ) );
$_block_repeat=false;
echo $_block_plugin2->addJsDefL(array('name'=>'wait_stage_msg'), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);
$_block_plugin3 = isset($_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]) ? $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0] : null;
if (!is_callable(array($_block_plugin3, 'addJsDefL'))) {
throw new SmartyException('block tag \'addJsDefL\' not callable or registered');
}
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('addJsDefL', array('name'=>'pending_state_msg'));
$_block_repeat=true;
echo $_block_plugin3->addJsDefL(array('name'=>'pending_state_msg'), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Pending...','js'=>1),$_smarty_tpl ) );
$_block_repeat=false;
echo $_block_plugin3->addJsDefL(array('name'=>'pending_state_msg'), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);
$_block_plugin4 = isset($_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]) ? $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0] : null;
if (!is_callable(array($_block_plugin4, 'addJsDefL'))) {
throw new SmartyException('block tag \'addJsDefL\' not callable or registered');
}
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('addJsDefL', array('name'=>'mail_sending_err'));
$_block_repeat=true;
echo $_block_plugin4->addJsDefL(array('name'=>'mail_sending_err'), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Some error occurred while sending mail to the customer','js'=>1),$_smarty_tpl ) );
$_block_repeat=false;
echo $_block_plugin4->addJsDefL(array('name'=>'mail_sending_err'), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);
$_block_plugin5 = isset($_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]) ? $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0] : null;
if (!is_callable(array($_block_plugin5, 'addJsDefL'))) {
throw new SmartyException('block tag \'addJsDefL\' not callable or registered');
}
$_smarty_tpl->smarty->_cache['_tag_stack'][] = array('addJsDefL', array('name'=>'refund_request_sending_error'));
$_block_repeat=true;
echo $_block_plugin5->addJsDefL(array('name'=>'refund_request_sending_error'), null, $_smarty_tpl, $_block_repeat);
while ($_block_repeat) {
ob_start();
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Some error occurred while processing request for order cancellation.','js'=>1),$_smarty_tpl ) );
$_block_repeat=false;
echo $_block_plugin5->addJsDefL(array('name'=>'refund_request_sending_error'), ob_get_clean(), $_smarty_tpl, $_block_repeat);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>
	<?php
}
}
/* {/block 'order_confirmation_js_vars'} */
/* {block 'order_confirmation'} */
class Block_5560039706820e5b08a6d95_10179975 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'order_confirmation' => 
  array (
    0 => 'Block_5560039706820e5b08a6d95_10179975',
  ),
  'order_confirmation_heading' => 
  array (
    0 => 'Block_10819169266820e5b08ac500_71486600',
  ),
  'order_steps' => 
  array (
    0 => 'Block_997059286820e5b08b26e1_32187163',
  ),
  'errors' => 
  array (
    0 => 'Block_7656458076820e5b08bd395_58568311',
  ),
  'displayOrderConfirmation' => 
  array (
    0 => 'Block_963936156820e5b08c1400_54894470',
  ),
  'displayPaymentReturn' => 
  array (
    0 => 'Block_11849365456820e5b08c3e03_71818048',
  ),
  'order_detail_heading' => 
  array (
    0 => 'Block_4519859366820e5b08f12a9_03362634',
  ),
  'order_details' => 
  array (
    0 => 'Block_8576373786820e5b08f44b2_22759735',
  ),
  'order_detail_room_type_image' => 
  array (
    0 => 'Block_16881205266820e5b090ae63_14878462',
  ),
  'order_detail_room_type_name' => 
  array (
    0 => 'Block_14807851846820e5b0911f65_78654613',
  ),
  'order_detail_room_type_hotel_name' => 
  array (
    0 => 'Block_12398694986820e5b0919241_57072879',
  ),
  'displayOrderConfirmationHotelNameAfter' => 
  array (
    0 => 'Block_11390955006820e5b091bf44_54767840',
  ),
  'order_detail_room_type_guest' => 
  array (
    0 => 'Block_6996671376820e5b0921de8_48597751',
  ),
  'order_detail_room_type_check_in' => 
  array (
    0 => 'Block_14503113136820e5b09509a0_40898272',
  ),
  'order_detail_room_type_check_out' => 
  array (
    0 => 'Block_7654885136820e5b0955712_52303298',
  ),
  'order_detail_room_type_extra_demands' => 
  array (
    0 => 'Block_865619616820e5b0959c12_86334942',
  ),
  'order_confirmation_cart_total' => 
  array (
    0 => 'Block_1663181806820e5b0981344_91457798',
  ),
  'order_detail_total_information' => 
  array (
    0 => 'Block_14232614536820e5b09ddbb5_40157342',
  ),
  'order_confirmation_room_extra_services' => 
  array (
    0 => 'Block_14017253366820e5b0a421b3_47451973',
  ),
  'order_confirmation_js_vars' => 
  array (
    0 => 'Block_23360846820e5b0a443f9_70007904',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'path', null, null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Order confirmation'),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_10819169266820e5b08ac500_71486600', 'order_confirmation_heading', $this->tplIndex);
?>


	<?php $_smarty_tpl->_assignInScope('current_step', 'payment');?>
	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_997059286820e5b08b26e1_32187163', 'order_steps', $this->tplIndex);
?>


	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7656458076820e5b08bd395_58568311', 'errors', $this->tplIndex);
?>


	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_963936156820e5b08c1400_54894470', 'displayOrderConfirmation', $this->tplIndex);
?>

	<div class="box">
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11849365456820e5b08c3e03_71818048', 'displayPaymentReturn', $this->tplIndex);
?>

		<?php if ((isset($_smarty_tpl->tpl_vars['order']->value->id)) && $_smarty_tpl->tpl_vars['order']->value->id) {?>
			<?php if ($_smarty_tpl->tpl_vars['is_guest']->value) {?>
				<p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Your Order Reference is:'),$_smarty_tpl ) );?>
 <span class="bold"><?php echo $_smarty_tpl->tpl_vars['order']->value->reference;?>
</span></p>
				<p class="cart_navigation exclusive">
				<a class="button-exclusive btn btn-default" href="<?php ob_start();
echo urlencode($_smarty_tpl->tpl_vars['reference_order']->value);
$_prefixVariable1=ob_get_clean();
ob_start();
echo urlencode($_smarty_tpl->tpl_vars['email']->value);
$_prefixVariable2=ob_get_clean();
echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('guest-tracking',true,NULL,"id_order=".$_prefixVariable1."&email=".$_prefixVariable2), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Follow my order'),$_smarty_tpl ) );?>
"><i class="icon-chevron-left"></i><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Follow my order'),$_smarty_tpl ) );?>
</a>
				</p>
			<?php } else { ?>
				<?php if ((isset($_smarty_tpl->tpl_vars['is_free_order']->value)) && $_smarty_tpl->tpl_vars['is_free_order']->value) {?>
					<p class="alert alert-success"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Your'),$_smarty_tpl ) );?>
 <?php if ($_smarty_tpl->tpl_vars['total_rooms_booked']->value > 1) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'bookings have'),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'booking has'),$_smarty_tpl ) );
}?> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'been created successfully!'),$_smarty_tpl ) );?>
</p><br />
				<?php }?>
				<p><strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Order Status :'),$_smarty_tpl ) );?>
</strong> <span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Confirmed'),$_smarty_tpl ) );?>
</span></p>
				<p><strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Order Reference :'),$_smarty_tpl ) );?>
</strong> <span class="bold"><?php echo $_smarty_tpl->tpl_vars['order']->value->reference;?>
</span></p>
				<?php if ($_smarty_tpl->tpl_vars['any_back_order']->value) {?>
					<?php if ($_smarty_tpl->tpl_vars['shw_bo_msg']->value) {?>
						<br>
						<p class="back_o_msg"><strong><sup>*</sup><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Some of your rooms are on back order. Please read the following message for rooms with status on backorder'),$_smarty_tpl ) );?>
</strong></p>
						<p>
							-&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['back_ord_msg']->value;?>

						</p>
					<?php }?>
				<?php }?>
				<hr>
				<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4519859366820e5b08f12a9_03362634', 'order_detail_heading', $this->tplIndex);
?>

				<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8576373786820e5b08f44b2_22759735', 'order_details', $this->tplIndex);
?>

				<p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'An email has been sent with this information.'),$_smarty_tpl ) );?>

					<br /><strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Your booking has been received successfully and we are looking forward to welcoming you.'),$_smarty_tpl ) );?>
</strong>
					<br /><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'If you have questions, comments or concerns, please contact our'),$_smarty_tpl ) );?>
 <a class="cust_serv_lnk" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('contact',true), ENT_QUOTES, 'UTF-8', true);?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'expert customer support team.'),$_smarty_tpl ) );?>
</a>
				</p>
				<p class="cart_navigation exclusive">
					<a class="btn" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('history',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Go to your order history page'),$_smarty_tpl ) );?>
"><i class="icon-chevron-left"></i><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'View your order history'),$_smarty_tpl ) );?>
</a>
				</p>
			<?php }?>
		<?php }?>
	</div>

		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14017253366820e5b0a421b3_47451973', 'order_confirmation_room_extra_services', $this->tplIndex);
?>

	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_23360846820e5b0a443f9_70007904', 'order_confirmation_js_vars', $this->tplIndex);
?>

<?php
}
}
/* {/block 'order_confirmation'} */
}
