<?php
/* Smarty version 3.1.39, created on 2025-07-08 14:46:36
  from '/www/wwwroot/prestigehotel.org/admin033aqbbsn/themes/default/template/controllers/orders/helpers/list/list_header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686d2f4c8aafd8_89155024',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '761b308c72b428c0ff7e87c524f8ee64aa3965b4' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/admin033aqbbsn/themes/default/template/controllers/orders/helpers/list/list_header.tpl',
      1 => 1741272494,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686d2f4c8aafd8_89155024 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>



<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1739505015686d2f4c86f1a9_20728828', 'leadin');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1034645683686d2f4c8a61e8_49943124', "override_form_extra");
?>



<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "helpers/list/list_header.tpl");
}
/* {block 'leadin'} */
class Block_1739505015686d2f4c86f1a9_20728828 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'leadin' => 
  array (
    0 => 'Block_1739505015686d2f4c86f1a9_20728828',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php if ((isset($_smarty_tpl->tpl_vars['updateOrderStatus_mode']->value)) && $_smarty_tpl->tpl_vars['updateOrderStatus_mode']->value) {?>
	<div class="panel">
		<div class="panel-heading">
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Choose an order status'),$_smarty_tpl ) );?>

		</div>
		<form action="<?php echo $_smarty_tpl->tpl_vars['REQUEST_URI']->value;?>
" method="post">
			<div class="radio">
				<label for="id_order_state">
					<select id="id_order_state" name="id_order_state">
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['order_statuses']->value, 'order_status_name', false, 'id_order_state');
$_smarty_tpl->tpl_vars['order_status_name']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id_order_state']->value => $_smarty_tpl->tpl_vars['order_status_name']->value) {
$_smarty_tpl->tpl_vars['order_status_name']->do_else = false;
?>
						<option value="<?php echo intval($_smarty_tpl->tpl_vars['id_order_state']->value);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order_status_name']->value, ENT_QUOTES, 'UTF-8', true);?>
</option>
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					</select>
				</label>
			</div>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['POST']->value, 'value', false, 'key');
$_smarty_tpl->tpl_vars['value']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->do_else = false;
?>
	<?php if (is_array($_smarty_tpl->tpl_vars['value']->value)) {?>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['value']->value, 'val');
$_smarty_tpl->tpl_vars['val']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->do_else = false;
?>
			<input type="hidden" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true);?>
[]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['val']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	<?php } elseif (strtolower($_smarty_tpl->tpl_vars['key']->value) != 'id_order_state') {?>
			<input type="hidden" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true);?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8', true);?>
" />

	<?php }
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			<div class="panel-footer">
				<button type="submit" name="cancel" class="btn btn-default">
					<i class="icon-remove"></i>
					<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Cancel'),$_smarty_tpl ) );?>

				</button>
				<button type="submit" class="btn btn-default" name="submitUpdateOrderStatus">
					<i class="icon-check"></i>
					<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Update Order Status'),$_smarty_tpl ) );?>

				</button>
			</div>
		</form>
	</div>
<?php }
}
}
/* {/block 'leadin'} */
/* {block "override_form_extra"} */
class Block_1034645683686d2f4c8a61e8_49943124 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'override_form_extra' => 
  array (
    0 => 'Block_1034645683686d2f4c8a61e8_49943124',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<?php echo '<script'; ?>
>
			$(document).ready(function(){
				function updateRoomTypeFilter() {
					let filterInputHotelName = $('#filter_input_hotel_name');
					let filterInputRoomTypeName = $('#filter_input_room_type_name');

					let idHotel = parseInt($(filterInputHotelName).val() || '0');

					$.ajax({
						url: currentIndex + '&token=' + token,
						data: {
							ajax: true,
							action: 'GetHotelRoomTypes',
							id_hotel: idHotel,
						},
						type: 'POST',
						dataType: 'JSON',
						success: function(response) {
							if (response.status) {
								if (response.has_room_types) {
									$(filterInputRoomTypeName).html(response.html_room_types);
								} else {
									$(filterInputRoomTypeName).find('option').not(':first').remove();
								}

								// destroy current chosen and re-initialize
								$(filterInputRoomTypeName).chosen('destroy');
								$(filterInputRoomTypeName).chosen({
									disable_search_threshold: 5,
									search_contains: true,
								});
							}
						},
					});
				}

				function updateHotelRoomsFilter(useRoomType = true) {
					let filterInputHotelName = $('#filter_input_hotel_name');
					let filterInputRoomTypeName = $('#filter_input_room_type_name');
					let filterInputRoomNumber = $('#filter_input_id_room_information');

					let idHotel = parseInt($(filterInputHotelName).val() || '0');
					let idProduct = parseInt($(filterInputRoomTypeName).val() || '0');

					$.ajax({
						url: currentIndex + '&token=' + token,
						data: {
							ajax: true,
							action: 'GetHotelRooms',
							id_hotel: idHotel,
							id_product: useRoomType ? idProduct : 0,
						},
						type: 'POST',
						dataType: 'JSON',
						success: function(response) {
							if (response.status) {
								if (response.has_hotel_rooms) {
									$(filterInputRoomNumber).html(response.html_hotel_rooms);
								} else {
									$(filterInputRoomNumber).find('option').not(':first').remove();
								}

								// destroy current chosen and re-initialize
								$(filterInputRoomNumber).chosen('destroy');
								$(filterInputRoomNumber).chosen({
									disable_search_threshold: 5,
									search_contains: true,
								});
							}
						},
					});
				}

				// manage Hotel and Room type filter inputs
				$(document).on('change', '#filter_input_hotel_name', function () {
					updateRoomTypeFilter();
					updateHotelRoomsFilter(false);
				});

				$(document).on('change', '#filter_input_room_type_name', function () {
					updateHotelRoomsFilter();
				});
			});
		<?php echo '</script'; ?>
>
<?php
}
}
/* {/block "override_form_extra"} */
}
