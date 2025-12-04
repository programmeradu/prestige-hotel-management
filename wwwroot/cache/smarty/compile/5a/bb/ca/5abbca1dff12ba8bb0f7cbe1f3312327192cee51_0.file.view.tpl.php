<?php
/* Smarty version 3.1.39, created on 2025-03-13 10:15:23
  from '/home/site/wwwroot/modules/hotelreservationsystem/views/templates/admin/hotel_rooms_booking/helpers/view/view.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d2b03b9c6039_65619984',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5abbca1dff12ba8bb0f7cbe1f3312327192cee51' => 
    array (
      0 => '/home/site/wwwroot/modules/hotelreservationsystem/views/templates/admin/hotel_rooms_booking/helpers/view/view.tpl',
      1 => 1741860839,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./_partials/search-stats.tpl' => 1,
    'file:./_partials/service-products.tpl' => 1,
    'file:./_partials/booking-rooms.tpl' => 1,
    'file:./_partials/booking-cart.tpl' => 1,
  ),
),false)) {
function content_67d2b03b9c6039_65619984 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/site/wwwroot/tools/smarty/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<div class="row">
	<?php if ((isset($_smarty_tpl->tpl_vars['hotel_list']->value)) && is_array($_smarty_tpl->tpl_vars['hotel_list']->value) && count($_smarty_tpl->tpl_vars['hotel_list']->value)) {?>
		<div class="col-sm-4">
			<div class="panel">
				<div class="panel-heading">
					<i class="icon-info"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Booking Form','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>

				</div>
				<div class="panel-body">
					<form method="post" action="" id="room-search-form">
						<div class="row">
														<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayAdminRoomsBookingSearchFormFieldsBefore'),$_smarty_tpl ) );?>

							<div class="form-group col-sm-12">
								<label for="date_from" class="control-label col-sm-4 required">
									<span title="" data-toggle="tooltip" class="label-tooltip"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Check-In','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span>
								</label>
								<div class="col-sm-8">
									<input type="text" name="from_date" class="form-control" id="from_date" <?php if ((isset($_smarty_tpl->tpl_vars['date_from']->value))) {?>value="<?php echo smarty_modifier_date_format(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['date_from']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'),"%d-%m-%Y");?>
"<?php }?> readonly>
									<input type="hidden" name="date_from" id="date_from" <?php if ((isset($_smarty_tpl->tpl_vars['date_from']->value))) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['date_from']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>
									<input type="hidden" name="search_date_from" id="search_date_from" <?php if ((isset($_smarty_tpl->tpl_vars['date_from']->value))) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['date_from']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>
								</div>
							</div>
							<div class="form-group col-sm-12">
								<label for="to_date" class="control-label col-sm-4 required">
									<span title="" data-toggle="tooltip" class="label-tooltip"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Check-Out','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span>
								</label>
								<div class="col-sm-8">
									<input type="text" name="to_date" class="form-control" id="to_date" <?php if ((isset($_smarty_tpl->tpl_vars['date_to']->value))) {?>value="<?php echo smarty_modifier_date_format(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['date_to']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'),"%d-%m-%Y");?>
"<?php }?> readonly>
									<input type="hidden" name="date_to" id="date_to" <?php if ((isset($_smarty_tpl->tpl_vars['date_to']->value))) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['date_to']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>
									<input type="hidden" name="search_date_to" id="search_date_to" <?php if ((isset($_smarty_tpl->tpl_vars['date_to']->value))) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['date_to']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>
								</div>
							</div>
							<div class="form-group col-sm-12">
								<label for="id_hotel" class="control-label col-sm-4 required">
									<span title="" data-toggle="tooltip" class="label-tooltip"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Hotel Name','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span>
								</label>
								<div class="col-sm-8">
									<select name="id_hotel" class="form-control" id="id_hotel">
										<?php if ((isset($_smarty_tpl->tpl_vars['hotel_list']->value)) && $_smarty_tpl->tpl_vars['hotel_list']->value) {?>
											<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['hotel_list']->value, 'name_val');
$_smarty_tpl->tpl_vars['name_val']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['name_val']->value) {
$_smarty_tpl->tpl_vars['name_val']->do_else = false;
?>
												<option value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['name_val']->value['id'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" <?php if ((isset($_smarty_tpl->tpl_vars['id_hotel']->value)) && ($_smarty_tpl->tpl_vars['name_val']->value['id'] == $_smarty_tpl->tpl_vars['id_hotel']->value)) {?>selected<?php }?>><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['name_val']->value['hotel_name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</option>
											<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
										<?php } else { ?>
											<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No hotels available','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>

										<?php }?>
									</select>
									<input type="hidden" name="search_id_hotel" id="search_id_hotel" <?php if ((isset($_smarty_tpl->tpl_vars['id_hotel']->value))) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['id_hotel']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>
								</div>
							</div>
							<?php if ($_smarty_tpl->tpl_vars['is_occupancy_wise_search']->value) {?>
								<div class="form-group col-sm-12">
									<label for="occupancy" class="control-label col-sm-4 required">
										<span title="" data-toggle="tooltip" class="label-tooltip"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Occupancy','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span>
									</label>
									<div class="col-sm-8">
										<div class="dropdown">
											<button class="booking_guest_occupancy btn btn-default btn-left btn-block input-occupancy" id="search_occupancy" type="button">
												<span class=""><?php if (((isset($_smarty_tpl->tpl_vars['occupancy_adults']->value)) && $_smarty_tpl->tpl_vars['occupancy_adults']->value)) {
echo $_smarty_tpl->tpl_vars['occupancy_adults']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['occupancy_adults']->value > 1) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Adults','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Adult','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );
}?>, <?php if ((isset($_smarty_tpl->tpl_vars['occupancy_children']->value)) && $_smarty_tpl->tpl_vars['occupancy_children']->value) {
echo $_smarty_tpl->tpl_vars['occupancy_children']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['occupancy_children']->value > 1) {?> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Children','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Child','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );
}?>, <?php }
echo count($_smarty_tpl->tpl_vars['occupancy']->value);?>
 <?php if (count($_smarty_tpl->tpl_vars['occupancy']->value) > 1) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Rooms','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );
}
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'1 Adult, 1 Room','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );
}?></span>
											</button>
											<input type="hidden" class="max_avail_type_qty" value="<?php if ((isset($_smarty_tpl->tpl_vars['total_available_rooms']->value))) {?>	<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['total_available_rooms']->value, ENT_QUOTES, 'UTF-8', true);
}?>">
											<div class="dropdown-menu booking_occupancy_wrapper well well-sm">
												<div class="booking_occupancy_inner row">
													<?php if ((isset($_smarty_tpl->tpl_vars['occupancy']->value)) && $_smarty_tpl->tpl_vars['occupancy']->value) {?>
														<?php $_smarty_tpl->_assignInScope('countRoom', 1);?>
														<hr class="occupancy-info-separator col-sm-12">
														<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['occupancy']->value, 'room_occupancy', false, 'key', 'occupancyInfo', array (
  'first' => true,
  'index' => true,
));
$_smarty_tpl->tpl_vars['room_occupancy']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['room_occupancy']->value) {
$_smarty_tpl->tpl_vars['room_occupancy']->do_else = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_occupancyInfo']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_occupancyInfo']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_occupancyInfo']->value['index'];
?>
															<div class="occupancy_info_block" occ_block_index="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
">
																<div class="occupancy_info_head col-sm-12"><label class="room_num_wrapper"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
 - <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['countRoom']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 </label><?php if (!(isset($_smarty_tpl->tpl_vars['__smarty_foreach_occupancyInfo']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_occupancyInfo']->value['first'] : null)) {?><a class="remove-room-link pull-right" href="#"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Remove','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</a><?php }?></div>
																<div class="col-sm-12">
																	<div class="row">
																		<div class="form-group col-xs-6 occupancy_count_block">
																			<label><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Adults','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</label>
																			<input type="number" class="form-control num_occupancy num_adults" name="occupancy[<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
][adults]" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['room_occupancy']->value['adults'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" min="1">
																		</div>
																		<div class="form-group col-xs-6 occupancy_count_block">
																			<label><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Children','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
 <span class="label-desc-txt"></span></label>
																			<input type="number" class="form-control num_occupancy num_children" name="occupancy[<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
][children]" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['room_occupancy']->value['children'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" min="0" <?php if ($_smarty_tpl->tpl_vars['max_child_in_room']->value) {?>max="<?php echo $_smarty_tpl->tpl_vars['max_child_in_room']->value;?>
"<?php }?>>
																			(<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Below','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
  <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['max_child_age']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'years','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
)
																		</div>
																	</div>
																	<div class="row children_age_info_block" <?php if (!$_smarty_tpl->tpl_vars['room_occupancy']->value['children']) {?>style="display:none"<?php }?>>
																		<div class="form-group col-sm-12">
																			<label class=""><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'All Children','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</label>
																			<div class="">
																				<div class="row children_ages">
																					<?php if ((isset($_smarty_tpl->tpl_vars['room_occupancy']->value['child_ages'])) && $_smarty_tpl->tpl_vars['room_occupancy']->value['child_ages']) {?>
																						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['room_occupancy']->value['child_ages'], 'childAge');
$_smarty_tpl->tpl_vars['childAge']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['childAge']->value) {
$_smarty_tpl->tpl_vars['childAge']->do_else = false;
?>
																							<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
																								<select class="guest_child_age room_occupancies" name="occupancy[<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
][child_ages][]">
																									<option value="-1" <?php if ($_smarty_tpl->tpl_vars['childAge']->value == -1) {?>selected<?php }?>><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Select age','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</option>
																									<option value="0" <?php if ($_smarty_tpl->tpl_vars['childAge']->value == 0) {?>selected<?php }?>><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Under 1','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</option>
																									<?php
$_smarty_tpl->tpl_vars['age'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['age']->step = 1;$_smarty_tpl->tpl_vars['age']->total = (int) ceil(($_smarty_tpl->tpl_vars['age']->step > 0 ? ($_smarty_tpl->tpl_vars['max_child_age']->value-1)+1 - (1) : 1-(($_smarty_tpl->tpl_vars['max_child_age']->value-1))+1)/abs($_smarty_tpl->tpl_vars['age']->step));
if ($_smarty_tpl->tpl_vars['age']->total > 0) {
for ($_smarty_tpl->tpl_vars['age']->value = 1, $_smarty_tpl->tpl_vars['age']->iteration = 1;$_smarty_tpl->tpl_vars['age']->iteration <= $_smarty_tpl->tpl_vars['age']->total;$_smarty_tpl->tpl_vars['age']->value += $_smarty_tpl->tpl_vars['age']->step, $_smarty_tpl->tpl_vars['age']->iteration++) {
$_smarty_tpl->tpl_vars['age']->first = $_smarty_tpl->tpl_vars['age']->iteration === 1;$_smarty_tpl->tpl_vars['age']->last = $_smarty_tpl->tpl_vars['age']->iteration === $_smarty_tpl->tpl_vars['age']->total;?>
																										<option value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['age']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['childAge']->value == $_smarty_tpl->tpl_vars['age']->value) {?>selected<?php }?>><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['age']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</option>
																									<?php }
}
?>
																								</select>
																							</div>
																						<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
																					<?php }?>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<hr class="occupancy-info-separator col-sm-12">
															<?php $_smarty_tpl->_assignInScope('countRoom', $_smarty_tpl->tpl_vars['countRoom']->value+1);?>
														<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
													<?php } else { ?>
														<div class="occupancy_info_block col-sm-12" occ_block_index="0">
															<div class="occupancy_info_head col-sm-12"><label class="room_num_wrapper"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room - 1','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</label></div>
															<div class="col-sm-12">
																<div class="row">
																	<div class="form-group col-xs-6 occupancy_count_block">
																		<label><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Adults','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</label>
																		<input type="number" class="form-control num_occupancy num_adults" name="occupancy[0][adults]" value="1" min="1">
																	</div>
																	<div class="form-group col-xs-6 occupancy_count_block">
																		<label><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Children','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
 <span class="label-desc-txt"></span></label>
																		<input type="number" class="form-control num_occupancy num_children" name="occupancy[0][children]" value="0" min="0" <?php if ($_smarty_tpl->tpl_vars['max_child_in_room']->value) {?>max="<?php echo $_smarty_tpl->tpl_vars['max_child_in_room']->value;?>
"<?php }?>>
																		(<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Below','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
  <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['max_child_age']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'years','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
)
																	</div>
																</div>
																<div class="row children_age_info_block" style="display:none">
																	<div class="form-group col-sm-12">
																		<label class=""><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'All Children','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</label>
																		<div class="">
																			<div class="row children_ages">
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<hr class="occupancy-info-separator col-sm-12">
													<?php }?>
												</div>
												<div class="add_occupancy_block col-sm-12">
													<a class="add_new_occupancy_btn" href="#"><i class="icon-plus"></i> <span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add Room','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></a>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php }?>
							<div class="form-group col-sm-12">
								<label for="id_room_type" class="control-label col-sm-4">
									<span title="" data-toggle="tooltip" class="label-tooltip"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room Type','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span>
								</label>
								<div class="col-sm-8">
									<select class="form-control" name="id_room_type" id="id_room_type">
										<?php if ((isset($_smarty_tpl->tpl_vars['id_room_type']->value))) {?>
											<option value='0' <?php if (($_smarty_tpl->tpl_vars['id_room_type']->value == 0)) {?>selected<?php }?>><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'All Types','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</option>
											<?php if (((isset($_smarty_tpl->tpl_vars['all_room_type']->value)) && $_smarty_tpl->tpl_vars['all_room_type']->value)) {?>
												<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['all_room_type']->value, 'val_type');
$_smarty_tpl->tpl_vars['val_type']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['val_type']->value) {
$_smarty_tpl->tpl_vars['val_type']->do_else = false;
?>
													<option value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['val_type']->value['id_product'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" <?php if (($_smarty_tpl->tpl_vars['val_type']->value['id_product'] == $_smarty_tpl->tpl_vars['id_room_type']->value)) {?>selected<?php }?>><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['val_type']->value['room_type'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</option>
												<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
											<?php }?>
										<?php }?>
									</select>
									<input type="hidden" name="search_id_room_type" id="search_id_room_type" value="<?php echo $_smarty_tpl->tpl_vars['id_room_type']->value;?>
">
								</div>
							</div>
							<div class="col-sm-12">
								<button id="search_hotel_list" name="search_hotel_list" type="submit" class="btn btn-primary pull-right">
									<i class="icon-search"></i>&nbsp;&nbsp;<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Search','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>

								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<?php if (!(isset($_smarty_tpl->tpl_vars['booking_product']->value)) || ((isset($_smarty_tpl->tpl_vars['booking_product']->value)) && $_smarty_tpl->tpl_vars['booking_product']->value == 1)) {?>
				<div class="panel">
					<?php $_smarty_tpl->_subTemplateRender("file:./_partials/search-stats.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
				</div>
			<?php }?>
		</div>
		<div class="col-sm-8">
			<div class="panel">
				<div class="panel-heading">
					<i class="icon-info"></i> <?php if (!(isset($_smarty_tpl->tpl_vars['booking_product']->value)) || ((isset($_smarty_tpl->tpl_vars['booking_product']->value)) && $_smarty_tpl->tpl_vars['booking_product']->value == 1)) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Booking Calender','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Service Products','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );
}?>
					<button type="button" class="btn btn-primary <?php if (intval($_smarty_tpl->tpl_vars['total_products_in_cart']->value) == 0) {?>disabled<?php }?>" id="cart_btn" data-toggle="modal" data-target="#cartModal"><i class="icon-shopping-cart"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Cart','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
 <span class="badge" id="cart_record"><?php echo $_smarty_tpl->tpl_vars['total_products_in_cart']->value;?>
</span></button>
				</div>
				<?php if (!(isset($_smarty_tpl->tpl_vars['booking_product']->value)) || ((isset($_smarty_tpl->tpl_vars['booking_product']->value)) && $_smarty_tpl->tpl_vars['booking_product']->value == 1)) {?>
					<div id='fullcalendar'></div>
					<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayAdminRoomsBookingCalendarAfter'),$_smarty_tpl ) );?>

				<?php } else { ?>
					<div class="panel-body">
						<?php $_smarty_tpl->_subTemplateRender("file:./_partials/service-products.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
					</div>
				<?php }?>
			</div>
		</div>
		<?php if (!(isset($_smarty_tpl->tpl_vars['booking_product']->value)) || ((isset($_smarty_tpl->tpl_vars['booking_product']->value)) && $_smarty_tpl->tpl_vars['booking_product']->value == 1)) {?>
			<?php if ((isset($_smarty_tpl->tpl_vars['booking_data']->value)) && $_smarty_tpl->tpl_vars['booking_data']->value) {?>
				<?php $_smarty_tpl->_subTemplateRender("file:./_partials/booking-rooms.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
			<?php }?>
		<?php }?>
	<?php } else { ?>
		<div class="panel">
			<div class="panel-heading">
				<i class="icon-warning"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No Hotels','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>

			</div>

			<div class="alert alert-warning">
				<p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No active hotels available for booking.','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</p>
				<p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'You can manage hotels from ','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
 <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminAddHotel');?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Hotel Reservation System > Manage Hotel','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</a> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'page.','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</p>
			</div>
		</div>
	<?php }?>
</div>

<div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<?php $_smarty_tpl->_subTemplateRender("file:./_partials/booking-cart.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</div>

<div id="date-stats-tooltop" style="display:none">
	<div class="tooltip_cont">
		<div class="tip_header">
			<div class="tip_date"></div>
		</div>
		<div class="tip-body">
			<div class="total_rooms">
				<div class="tip_element_head"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total Rooms','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</div>
				<div class="tip_element_value"></div>
			</div>
			<div class="num_avail">
				<div class="tip_element_head"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total Available','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</div>
				<div class="tip_element_value"></div>
			</div>
			<div class="num_booked">
				<div class="tip_element_head"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Booked Rooms','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</div>
				<div class="tip_element_value"></div>
			</div>
			<div class="num_unavail">
				<div class="tip_element_head"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Unavailable Rooms','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</div>
				<div class="tip_element_value"></div>
			</div>
            <div class="num_part_avai">
				<div class="tip_element_head"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Partially Available Rooms','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</div>
				<div class="tip_element_value"></div>
			</div>
		</div>
	</div>
</div>
<template id="svg-icon">
<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="8" cy="8" r="8"/><path d="M8.06536 3C8.30937 3 8.51561 3.07032 8.6841 3.21097C8.85839 3.34693 8.94553 3.51336 8.94553 3.71027C8.94553 3.90717 8.85839 4.07595 8.6841 4.2166C8.51561 4.35724 8.30937 4.42757 8.06536 4.42757C7.82135 4.42757 7.6122 4.35724 7.43791 4.2166C7.26362 4.07595 7.17647 3.90717 7.17647 3.71027C7.17647 3.51336 7.26071 3.34693 7.42919 3.21097C7.60349 3.07032 7.81554 3 8.06536 3ZM8.78867 6.3685V11.5443C8.78867 11.9475 8.82353 12.2171 8.89325 12.353C8.96877 12.4843 9.07625 12.5827 9.21569 12.6484C9.36093 12.714 9.62237 12.7468 10 12.7468V13H6.122V12.7468C6.51126 12.7468 6.77269 12.7164 6.90632 12.6554C7.03994 12.5945 7.14452 12.4937 7.22004 12.353C7.30138 12.2124 7.34205 11.9428 7.34205 11.5443V9.06188C7.34205 8.36334 7.3159 7.91092 7.26362 7.70464C7.22295 7.55462 7.15904 7.45148 7.0719 7.39522C6.98475 7.33427 6.86565 7.3038 6.7146 7.3038C6.55192 7.3038 6.35439 7.33896 6.122 7.40928L6 7.15612L8.40523 6.3685H8.78867Z" fill="white"/></svg>
<template>
<?php }
}
