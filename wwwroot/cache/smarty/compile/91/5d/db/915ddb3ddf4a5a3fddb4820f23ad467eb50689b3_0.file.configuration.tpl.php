<?php
/* Smarty version 3.1.39, created on 2025-07-08 16:51:50
  from '/www/wwwroot/prestigehotel.org/admin033aqbbsn/themes/default/template/controllers/products/configuration.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686d4ca66941c9_22447605',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '915ddb3ddf4a5a3fddb4820f23ad467eb50689b3' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/admin033aqbbsn/themes/default/template/controllers/products/configuration.tpl',
      1 => 1741272495,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686d4ca66941c9_22447605 (Smarty_Internal_Template $_smarty_tpl) {
if ((isset($_smarty_tpl->tpl_vars['product']->value->id))) {?>
	<div id="product-configuration" class="panel product-tab">
		<input type="hidden" name="submitted_tabs[]" value="Configuration" />
		<h3 class="tab"> <i class="icon-AdminAdmin"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Rooms'),$_smarty_tpl ) );?>
</h3>

		<input type="hidden" id="checkConfSubmit" value="0" name="checkConfSubmit">

		<div class="from-group table-responsive-row clearfix">
			<table class="table hotel-room">
				<thead>
					<tr class="nodrag nodrop">
						<th class="col-sm-2 center">
							<label class="control-label required">
								<span class="label-tooltip" data-toggle="tooltip" data-original-title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Enter room number. For eg. A-101, A-102 etc. Invalid characters <>;=#{}'),$_smarty_tpl ) );?>
">
									<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room No.'),$_smarty_tpl ) );?>

								</span>
							</label>
						</th>
						<th class="col-sm-2 center">
							<label class="control-label">
								<span class="label-tooltip" data-toggle="tooltip" data-original-title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Enter floor of the room. For eg. First, Second etc. Invalid characters <>;=#{}'),$_smarty_tpl ) );?>
">
									<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Floor'),$_smarty_tpl ) );?>

								</span>
							</label>
						</th>
						<th class="col-sm-2 center">
							<label class="control-label">
								<span class="label-tooltip" data-toggle="tooltip" data-original-title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Select status of the room.'),$_smarty_tpl ) );?>
">
									<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Status'),$_smarty_tpl ) );?>

								</span>
							</label>
						</th>
						<th class="col-sm-3 center">
							<label class="control-label">
								<span class="label-tooltip" data-toggle="tooltip" data-original-title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Enter extra information about this room. Leave empty if not required.'),$_smarty_tpl ) );?>
">
									<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Extra Information'),$_smarty_tpl ) );?>

								</span>
							</label>
						</th>
						<th class="col-sm-2 center">
							<label class="control-label">
								<span class="label-tooltip" data-toggle="tooltip" data-original-title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Set date ranges when room is set to Temporarily Inactive.'),$_smarty_tpl ) );?>
">
									<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Disable Dates'),$_smarty_tpl ) );?>

								</span>
							</label>
						</th>
                        <th class="col-sm-1 center">
                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'--'),$_smarty_tpl ) );?>

                        </th>
					</tr>
				</thead>
				<tbody>
					<?php if ((isset($_POST['rooms_info'])) && is_array($_POST['rooms_info']) && count($_POST['rooms_info'])) {?>
						<?php $_smarty_tpl->_assignInScope('rooms_info', $_POST['rooms_info']);?>
					<?php } elseif ((isset($_smarty_tpl->tpl_vars['htl_room_info']->value)) && is_array($_smarty_tpl->tpl_vars['htl_room_info']->value) && count($_smarty_tpl->tpl_vars['htl_room_info']->value)) {?>
						<?php $_smarty_tpl->_assignInScope('rooms_info', $_smarty_tpl->tpl_vars['htl_room_info']->value);?>
					<?php }?>
					<?php if ((isset($_smarty_tpl->tpl_vars['rooms_info']->value)) && is_array($_smarty_tpl->tpl_vars['rooms_info']->value) && count($_smarty_tpl->tpl_vars['rooms_info']->value)) {?>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rooms_info']->value, 'room_info', false, 'key');
$_smarty_tpl->tpl_vars['room_info']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['room_info']->value) {
$_smarty_tpl->tpl_vars['room_info']->do_else = false;
?>
							<?php $_smarty_tpl->_assignInScope('var_name_room_info', "rooms_info[".((string)$_smarty_tpl->tpl_vars['key']->value)."]");?>
							<tr class="room_data_values" data-row-index="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
								<td class="col-sm-1 center">
									<input class="form-control" type="text" value="<?php echo $_smarty_tpl->tpl_vars['room_info']->value['room_num'];?>
" name="<?php echo ($_smarty_tpl->tpl_vars['var_name_room_info']->value).('[room_num]');?>
">
								</td>
								<td class="col-sm-2 center">
									<input class="form-control" type="text" value="<?php echo $_smarty_tpl->tpl_vars['room_info']->value['floor'];?>
" name="<?php echo ($_smarty_tpl->tpl_vars['var_name_room_info']->value).('[floor]');?>
">
								</td>
								<td class="col-sm-2 center">
									<select class="form-control room_status" name="<?php echo ($_smarty_tpl->tpl_vars['var_name_room_info']->value).('[id_status]');?>
">
										<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rm_status']->value, 'room_stauts');
$_smarty_tpl->tpl_vars['room_stauts']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['room_stauts']->value) {
$_smarty_tpl->tpl_vars['room_stauts']->do_else = false;
?>
											<option value="<?php echo $_smarty_tpl->tpl_vars['room_stauts']->value['id'];?>
" <?php ob_start();
echo $_smarty_tpl->tpl_vars['room_stauts']->value['id'];
$_prefixVariable1 = ob_get_clean();
if ($_smarty_tpl->tpl_vars['room_info']->value['id_status'] == $_prefixVariable1) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['room_stauts']->value['status'];?>
</option>
										<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
									</select>
								</td>
								<td class="col-sm-3 center">
									<input type="text" class="form-control room_comment" value="<?php if ((isset($_smarty_tpl->tpl_vars['room_info']->value['comment']))) {
echo $_smarty_tpl->tpl_vars['room_info']->value['comment'];
}?>" name="<?php echo ($_smarty_tpl->tpl_vars['var_name_room_info']->value).('[comment]');?>
">
								</td>
								<td class="col-sm-2 center">
									<a class="btn btn-default deactiveDatesModal <?php if ($_smarty_tpl->tpl_vars['room_info']->value['id_status'] != $_smarty_tpl->tpl_vars['rm_status']->value['STATUS_TEMPORARY_INACTIVE']['id']) {?>disabled<?php }?>" data-toggle="modal" data-target="#deactiveDatesModal" data-id-room="<?php if ((isset($_smarty_tpl->tpl_vars['room_info']->value['id']))) {
echo $_smarty_tpl->tpl_vars['room_info']->value['id'];
}?>"><?php if ($_smarty_tpl->tpl_vars['room_info']->value['id_status'] != $_smarty_tpl->tpl_vars['rm_status']->value['STATUS_TEMPORARY_INACTIVE']['id']) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add Dates'),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'View Dates'),$_smarty_tpl ) );
}?>
									</a>
									<input type="hidden" class="form-control disable_dates_json" name="<?php echo ($_smarty_tpl->tpl_vars['var_name_room_info']->value).('[disable_dates_json]');?>
" <?php if ($_smarty_tpl->tpl_vars['room_info']->value['id_status'] == $_smarty_tpl->tpl_vars['rm_status']->value['STATUS_TEMPORARY_INACTIVE']['id']) {?>value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['room_info']->value['disable_dates_json'], ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>>
								</td>
								<td class="col-sm-1 center">
									<?php if ((isset($_smarty_tpl->tpl_vars['room_info']->value['id']))) {?>
                                        <input type="hidden" class="booked-dates" name="<?php echo ($_smarty_tpl->tpl_vars['var_name_room_info']->value).('[booked_dates]');?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['room_info']->value['booked_dates'], ENT_QUOTES, 'UTF-8', true);?>
">
                                        <a href="#" class="view_htl_room btn btn-default" data-toggle="modal" data-target="#room-dates-modal" data-id-room="<?php echo $_smarty_tpl->tpl_vars['room_info']->value['id'];?>
"><i class="icon-info"></i></a>
										<a href="#" class="rm_htl_room btn btn-default" data-id-htl-info="<?php echo $_smarty_tpl->tpl_vars['room_info']->value['id'];?>
"><i class="icon-trash"></i></a>
										<input type="hidden" name="<?php echo ($_smarty_tpl->tpl_vars['var_name_room_info']->value).('[id]');?>
" value="<?php echo $_smarty_tpl->tpl_vars['room_info']->value['id'];?>
">
									<?php } else { ?>
										<a href="#" class="remove-rooms-button btn btn-default"><i class="icon-trash"></i></a>
									<?php }?>
								</td>
							</tr>
						<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					<?php } else { ?>
						<?php
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['k']->step = 1;$_smarty_tpl->tpl_vars['k']->total = (int) ceil(($_smarty_tpl->tpl_vars['k']->step > 0 ? 1+1 - (0) : 0-(1)+1)/abs($_smarty_tpl->tpl_vars['k']->step));
if ($_smarty_tpl->tpl_vars['k']->total > 0) {
for ($_smarty_tpl->tpl_vars['k']->value = 0, $_smarty_tpl->tpl_vars['k']->iteration = 1;$_smarty_tpl->tpl_vars['k']->iteration <= $_smarty_tpl->tpl_vars['k']->total;$_smarty_tpl->tpl_vars['k']->value += $_smarty_tpl->tpl_vars['k']->step, $_smarty_tpl->tpl_vars['k']->iteration++) {
$_smarty_tpl->tpl_vars['k']->first = $_smarty_tpl->tpl_vars['k']->iteration === 1;$_smarty_tpl->tpl_vars['k']->last = $_smarty_tpl->tpl_vars['k']->iteration === $_smarty_tpl->tpl_vars['k']->total;?>
							<?php $_smarty_tpl->_assignInScope('var_name_room_info', "rooms_info[".((string)$_smarty_tpl->tpl_vars['k']->value)."]");?>
							<tr class="room_data_values" data-row-index="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
">
								<td class="col-sm-1 center">
									<input class="form-control" type="text" name="<?php echo ($_smarty_tpl->tpl_vars['var_name_room_info']->value).('[room_num]');?>
">
								</td>
								<td class="col-sm-2 center">
									<input class="form-control" type="text" name="<?php echo ($_smarty_tpl->tpl_vars['var_name_room_info']->value).('[floor]');?>
">
								</td>
								<td class="col-sm-2 center">
									<select class="form-control room_status" name="<?php echo ($_smarty_tpl->tpl_vars['var_name_room_info']->value).('[id_status]');?>
">
										<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rm_status']->value, 'room_stauts');
$_smarty_tpl->tpl_vars['room_stauts']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['room_stauts']->value) {
$_smarty_tpl->tpl_vars['room_stauts']->do_else = false;
?>
											<option value="<?php echo $_smarty_tpl->tpl_vars['room_stauts']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['room_stauts']->value['status'];?>
</option>
										<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
									</select>
								</td>
                                <td class="center col-sm-3">
									<input type="text" class="form-control room_comment" name="<?php echo ($_smarty_tpl->tpl_vars['var_name_room_info']->value).('[comment]');?>
">
                                </td>
								<td class="center col-sm-2">
									<a class="btn btn-default deactiveDatesModal disabled" data-toggle="modal" data-target="#deactiveDatesModal">
										<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add Dates'),$_smarty_tpl ) );?>

									</a>
									<input type="hidden" class="form-control disable_dates_json" name="<?php echo ($_smarty_tpl->tpl_vars['var_name_room_info']->value).('[disable_dates_json]');?>
" value="">
								</td>
								<td class="center col-sm-1">
								    <?php if ($_smarty_tpl->tpl_vars['k']->value == 1) {?>
										<a href="#" class="remove-rooms-button btn btn-default"><i class="icon-trash"></i></a>
                                    <?php } else { ?>
                                        <a href="#" class="remove-rooms-button btn btn-default disabled"><i class="icon-trash"></i></a>
								    <?php }?>
                                </td>
							</tr>
						<?php }
}
?>
					<?php }?>
				</tbody>
			</table>
			<div class="form-group">
				<div class="col-sm-12">
					<button id="add-more-rooms-button" class="btn btn-default" type="button" data-size="s" data-style="expand-right">
						<i class="icon icon-plus"></i>
						<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add More Rooms'),$_smarty_tpl ) );?>

					</button>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminProducts'), ENT_QUOTES, 'UTF-8', true);
if ((isset($_REQUEST['page'])) && $_REQUEST['page'] > 1) {?>&amp;submitFilterproduct=<?php echo intval($_REQUEST['page']);
}?>" class="btn btn-default">
				<i class="process-icon-cancel"></i>
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Cancel'),$_smarty_tpl ) );?>

			</a>
			<button type="submit" name="submitAddproduct" class="btn btn-default pull-right checkConfigurationClick" disabled="disabled">
				<i class="process-icon-loading"></i>
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Save'),$_smarty_tpl ) );?>

			</button>
			<button type="submit" name="submitAddproductAndStay" class="btn btn-default pull-right checkConfigurationClick"  disabled="disabled">
				<i class="process-icon-loading"></i>
					<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Save and stay'),$_smarty_tpl ) );?>

			</button>
		</div>
	</div>
<?php }?>

<div id="modal_loader" class="loading_overlay" style="display: none;">
    <img src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getMediaLink(((defined('_PS_ADMIN_IMG_') ? constant('_PS_ADMIN_IMG_') : null)));?>
ajax-loader.gif" class="loading-img"/>
</div>

<div class="modal fade" id="deactiveDatesModal" tabindex="-1" role="dialog" aria-labelledby="deactiveDatesLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
                <div class="modal-title">
                    <div class="row">
                        <div class="disable_dates_title"><i class="icon-calendar"></i>&nbsp; <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Disable Dates'),$_smarty_tpl ) );?>
 <span class="disable_dates_room_num"></span></div>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success add_disable_dates"><i class="icon-plus-circle"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add Dates'),$_smarty_tpl ) );?>
</button>
                            <button type="submit" class="btn btn-danger remove_disable_dates"><i class="icon-trash"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Remove Dates'),$_smarty_tpl ) );?>
</button>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
			</div>
			<div class="modal-body">
                <div class="text-left messages-wrap" style="display: none;"></div>
                <div class="text-left room_not_found" style="display: none;">
                    <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <ul class="list-unstyled">
                            <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Please save this room first to add dates.'),$_smarty_tpl ) );?>
</li>
                        </ul>
                    </div>
                </div>
                <div id="disable_dates_form" class="panel" hidden>
                    <input type="hidden" class="id_disable_date">
                    <input type="hidden" class="id_calendar_event">
                    <div class="panel-heading col-xs-12">
                        <div class="disable_dates_form_title disable_dates_form_title_add"><i class="icon-plus-circle"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add Dates'),$_smarty_tpl ) );?>
</div>
                        <div class="disable_dates_form_title disable_dates_form_title_update"><i class="icon-pencil"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Update Dates'),$_smarty_tpl ) );?>
</div>
                        <div class="disable_dates_form_title disable_dates_form_title_delete"><i class="icon-trash"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Remove Dates'),$_smarty_tpl ) );?>
</div>
                    </div>
                    <div class="panel-content">
                        <div class="row form-group">
                            <div class="col-sm-6 date_from_container">
                                <label class="control-label" for="disable_date_from">
                                    <span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Date From'),$_smarty_tpl ) );?>
</span>
                                </label>
                                <div>
                                    <div class="input-group">
                                        <input type="text" class="form-control disable_date_from" name="disable_date_from" value="" readonly>
                                        <div class="input-group-addon"><i class="icon-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 date_to_container">
                                <label class="control-label" for="disable_date_to">
                                    <span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Date To'),$_smarty_tpl ) );?>
</span>
                                </label>
                                <div>
                                    <div class="input-group">
                                        <input type="textarea" class="form-control disable_date_to" name="disable_date_to" value="" readonly>
                                        <div class="input-group-addon"><i class="icon-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12">
                                <label class="control-label" for="room_disable_reason">
                                    <span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Reason'),$_smarty_tpl ) );?>
</span>
                                </label>
                                <div class="input-group col-xs-12">
                                    <textarea class="form-control room_disable_reason" name="room_disable_reason" value=""></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <button type="button" class="btn btn-default pull-left close_disable_dates_form"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Close'),$_smarty_tpl ) );?>
</button>
                            </div>
                            <div class="col-xs-6">
                                <button type="button" class="btn btn-primary pull-right submit_add_disable_date"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Submit'),$_smarty_tpl ) );?>
</button>
                                <button type="button" class="btn btn-primary pull-right submit_remove_disable_date"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Remove'),$_smarty_tpl ) );?>
</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="disable_dates_full_calendar"></div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="room-dates-modal" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close margin-right-10" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="icon-calendar"></i>&nbsp; <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Upcoming bookings'),$_smarty_tpl ) );?>
</h4>
            </div>
            <div class="room-booked-dates-table modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Order'),$_smarty_tpl ) );?>
</span></th>
                                <th><span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Date From'),$_smarty_tpl ) );?>
</span></th>
                                <th><span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Date To'),$_smarty_tpl ) );?>
</span></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Done'),$_smarty_tpl ) );?>
</button>
            </div>
        </div>
    </div>
</div>

<div class="hidden">
    <div id="tooltip_info_block">
        <div class="tooltip_container tooltip_info_block">
            <div class="tooltip_title"></div>
            <div class="tooltip_content">
                <div class="row col-xs-6">
                    <div class="tooltip_label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Duration'),$_smarty_tpl ) );?>
 </div>
                    <div>
                        <span class="tooltip_date_from"></span> - <span class="tooltip_date_to"></span>
                    </div>
                </div>
                <div class="row col-xs-6">
                    <div class="tooltip_label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Disabled on'),$_smarty_tpl ) );?>
 </div>
                    <div<span class="tooltip_date_add"></span>
                </div>
                <div class="row col-xs-12 id_event"><div class="tooltip_label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Event Id'),$_smarty_tpl ) );?>
 </div><span class="tooltip_id_event"></span></div>
                <div><div class="tooltip_label tooltip_reason_container col-xs-12"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Reason'),$_smarty_tpl ) );?>
</div><span class="tooltip_reason col-xs-12"></span></div>
            </div>
        </div>
    </div>
    <div id="tooltip_action_block">
        <div class="tooltip_container tooltip_action_block">
            <div class="tooltip_title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Select Action'),$_smarty_tpl ) );?>

                <button type="button" class="close margin-right-10" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="tooltip_content">
                <ul class="disable_dates_actions">
                    <li class="enable_selected_dates btn btn-default">
                        <span class="enable_selected_dates">
                            <i class="icon-check"></i>
                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Make Room Available'),$_smarty_tpl ) );?>

                        </span>
                    </li>
                    <li class="disabled_selected_dates btn btn-default">
                        <span class="disabled_selected_dates">
                            <i class="icon-ban"></i>
                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Disable Room'),$_smarty_tpl ) );?>

                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
	.hotel-room {
		border: 1px solid #f2f2f2;
		margin-top: 10px;
	}
</style>

<?php echo '<script'; ?>
>
    var prod_link = "<?php echo $_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminProducts');?>
";
    var rm_status = <?php echo json_encode($_smarty_tpl->tpl_vars['rm_status']->value);?>
;
    var confirmText = "<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Are you sure?','js'=>1),$_smarty_tpl ) );?>
";
    var removeDisableDateText = "<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Are you sure you want to remove the selected date range?','js'=>1),$_smarty_tpl ) );?>
";
    var currentRoomRow = 0;
    $(document).ready(function() {
        var tooltipCounter = 0;
        var disableDatesCounter = {};
        // Setting the Date object without current time.
        const dateToday = new Date("<?php echo date('Y-m-d');?>
");
        
        $('#room-dates-modal').on('show.bs.modal', function(e) {
            const triggerRoom = $(e.relatedTarget);
            $('#room-dates-modal tbody').html('');
            var bookedDates = JSON.parse($(triggerRoom).closest('tr').find('.booked-dates').val());
            if (bookedDates.length) {
                if (bookedDates.length) {
                    $('#room-dates-modal .room-booked-dates-table').show();
                    $(bookedDates).each(function() {
                        $('#room-dates-modal .room-booked-dates-table tbody').append(`<tr>
                            <td><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminOrders'), ENT_QUOTES, 'UTF-8', true);?>
&vieworder&id_order=${this.id_order}" target="_blank">#${this.id_order}</a></td>
                            <td>${this.date_from_formatted}</td>
                            <td>${this.date_to_formatted}</td>
                        </tr>`);
                    });
                }
            } else {
                $('#room-dates-modal .room-booked-dates-table tbody').append(`<tr>
                    <td colspan="3" class="center"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No Booking for this room'),$_smarty_tpl ) );?>
</td>
                </tr>`);
            }
        });
        

        // Add new room detail
        $('#add-more-rooms-button').on('click',function() {
            var lengthRooms = parseInt($('.room_data_values').length);

            var prefix = 'rooms_info['+lengthRooms+']';
            html = '<tr class="room_data_values" data-row-index="'+lengthRooms+'">';
                html += '<td class="col-sm-1 center">';
                    html += '<input class="form-control" type="text" name="'+prefix+'[room_num]">';
                html += '</td>';
                html += '<td class="col-sm-2 center">';
                    html += '<input class="form-control" type="text" name="'+prefix+'[floor]">';
                html += '</td>';
                html += '<td class="col-sm-2 center">';
                    html += '<select class="form-control room_status" name="'+prefix+'[id_status]">';
                        $.each(rm_status, function(key, value) {
                            html += '<option value="'+value.id+'">'+value.status+'</option>';
                        });
                    html += '</select>';
                html += '</td>';
                html += '<td class="col-sm-3 center">';
                    html += '<input class="form-control" type="text" name="'+prefix+'[floor]">';
                html += '</td>';
                html += '<td class="center col-sm-2">';
                    html += '<a class="btn btn-default deactiveDatesModal disabled" data-toggle="modal" data-target="#deactiveDatesModal">';
                        html += "<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add Dates'),$_smarty_tpl ) );?>
";
                    html += '</a>';
                    html += '<input type="hidden" class="form-control disable_dates_json" name="'+prefix+'[disable_dates_json]">';
                html += '</td>';
                html += '<td class="center col-sm-1">';
                    html += '<a href="#" class="remove-rooms-button btn btn-default"><i class="icon-trash"></i></a>';
                html += '</td>';
            html += '</tr>';

            $('table.hotel-room tbody').append(html);
        });

        // delete room
        $('.rm_htl_room').on('click',function(e) {
            e.preventDefault();
            var $current = $(this);
            var id_htl_info = $(this).attr('data-id-htl-info');
            $.ajax({
                url: prod_link,
                type: 'POST',
                dataType: 'JSON',
                data: {
                    ajax:true,
                    action:'deleteHotelRoom',
                    id: id_htl_info,
                },
                success: function (response) {
                    if (response.success) {
                        showSuccessMessage("<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Removed successfully'),$_smarty_tpl ) );?>
");
                        $current.closest(".room_data_values").remove();
                    } else {
                        if (response.errors)
                        showErrorMessage(response.errors);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showErrorMessage("<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Some error occurred'),$_smarty_tpl ) );?>
");
                }
            });
        });

        $(".checkConfigurationClick").on("click", function() {
            $("#checkConfSubmit").val(1);
            return true;
        });

        // remove room row
        $(document).on('click', '.remove-rooms-button', function(e) {
            e.preventDefault();
            $(this).closest('.room_data_values').remove();
            $('#product-configuration table.hotel-room tr.room_data_values').each(function(iOuter, tr) {
                $(tr).attr('data-row-index', iOuter);
                $(tr).find('input, select').each(function (iInner, inputField) {
                    let fieldName = $(inputField).attr('name');
                    fieldName = fieldName.replace(/[0-9]+/, iOuter)
                    $(inputField).attr('name', fieldName);
                });
            });
        });

        // on changing the room status as disabled for some date range
        $(document).on('change', '.room_status', function(){
            var status_val = $(this).val();
            if (status_val == rm_status.STATUS_TEMPORARY_INACTIVE.id) {
                $(this).closest('.room_data_values').find('.deactiveDatesModal').removeClass('disabled');
            } else {
                $(this).closest('.room_data_values').find('.deactiveDatesModal').addClass('disabled');
            }
        });

        // Initializing datepicker for date from for the disable dates calendar
        $('#disable_dates_form .date_from_container').datepicker({
            showOtherMonths: true,
            dateFormat: 'yy-mm-dd',
            minDate: 0,
            onSelect: function(selectedDate) {
                let objDateToMin = $.datepicker.parseDate('yy-mm-dd', selectedDate);
                $(this).find('.disable_date_from').val(selectedDate);
                objDateToMin.setDate(objDateToMin.getDate());

                $(this).closest('#disable_dates_form').find('.date_to_container').datepicker('option', 'minDate', objDateToMin);
                var dateTo = $(this).closest('#disable_dates_form').find('.disable_date_to').val();
                $(this).find('.ui-datepicker').hide();
                if (!dateTo || (dateTo && selectedDate > dateTo)) {
                    $('#disable_dates_form .disable_date_to').val($.datepicker.formatDate('yy-mm-dd', objDateToMin));
                    $('#disable_dates_form .date_to_container').datepicker("setDate", $.datepicker.formatDate('yy-mm-dd', objDateToMin));
                    $('#disable_dates_form .date_to_container').find('.ui-datepicker').show();
                }
            }
        });

        // Initializing datepicker for date to for the disable dates calendar
        $('#disable_dates_form .date_to_container').datepicker({
            showOtherMonths: true,
            dateFormat: 'yy-mm-dd',
            minDate: 0,
            beforeShow: function (input, instance) {
                let dateFrom = $(this).closest('#disable_dates_form').find('.disable_date_from').val();

                let objDateToMin = null;
                if (typeof dateFrom != 'undefined' && dateFrom != '') {
                    objDateToMin = $.datepicker.parseDate('yy-mm-dd', dateFrom);
                } else {
                    objDateToMin = new Date();
                }

                objDateToMin.setDate(objDateToMin.getDate() + 1);
                $(this).datepicker('option', 'minDate', objDateToMin);
                $(this).datepicker("setDate", objDateToMin);
            },
            onSelect: function(selectedDate) {
                $(this).find('.disable_date_to').val(selectedDate);
                $(this).find('.ui-datepicker').hide();
            }
        });

        // Since the datepickers are mounted on to the container instead of the input fields, we are handeling the date picker hide and show events.
        $(document).on('focus', '#disable_dates_form .disable_date_from, #disable_dates_form .disable_date_to', function() {
            if ($(this).hasClass('disable_date_from')) {
                $('#disable_dates_form .date_to_container').find('.ui-datepicker').hide();
                $('#disable_dates_form .date_from_container').find('.ui-datepicker').show();
            } else if ($(this).hasClass('disable_date_to')) {
                $('#disable_dates_form .date_to_container').find('.ui-datepicker').show();
                $('#disable_dates_form .date_from_container').find('.ui-datepicker').hide();
            }
        });

        // Handeling the date picker hide and show events for the click events.
        $('#disable_dates_form').on('focus click', function(e) {
            if (!$(e.target).closest('.date_from_container, .date_to_container').length
                && ($(e.target).hasClass('disable_date_from') || $(e.target).hasClass('disable_date_to'))
            ) {
                $('#disable_dates_form .ui-datepicker').hide();
            } else {
                if ($(e.target).hasClass('disable_date_from')) {
                    $('#disable_dates_form .date_to_container').find('.ui-datepicker').hide();
                    $('#disable_dates_form .date_from_container').find('.ui-datepicker').show();
                } else if ($(e.target).hasClass('disable_date_to')) {
                    $('#disable_dates_form .date_to_container').find('.ui-datepicker').show();
                    $('#disable_dates_form .date_from_container').find('.ui-datepicker').hide();
                } else if (!$(e.target).parents('.ui-datepicker').length
                    && (!$(e.target).hasClass('ui-corner-all') && !$(e.target).hasClass('ui-icon'))
                ) {
                    $('#disable_dates_form .ui-datepicker').hide();
                }
            }
        });

        // Removing single disable date range and its event from calendar.
        $(document).on('click', '#disable_dates_full_calendar .delete_disable_dates', function() {
            if (confirm(confirmText)) {
                var calendarEventId = parseInt($(this).parent().find('.fc-event-title').attr('data-id_calendar_event'));
                var calendarEvent = DisableDatesCalendar.getEventById(calendarEventId);
                if (DisableDatesObj.deleteDisableDate(calendarEvent.extendedProps.id_disable_date)) {
                    $('#disable_dates_full_calendar .id_calendar_event_'+calendarEventId).find('.fc-event-main-frame').tooltip('destroy');
                    calendarEvent.remove();
                    var formEventId = parseInt($('#disable_dates_form .id_calendar_event').val());
                    if (!isNaN(formEventId) && formEventId == eventId) {
                        DisableDatesForm.resetForm();
                        DisableDatesForm.hideForm();
                    }
                }
            }
        });

        // Setting data for single disable date range into form for updation.
        $(document).on('click', '#disable_dates_full_calendar .edit_disable_dates', function() {
            var element = $(this).parent().find('.fc-event-title');
            var calendarEvent = DisableDatesCalendar.getEventById($(element).attr('data-id_calendar_event'));
            var formData = {
                disable_date_from : calendarEvent.extendedProps.date_from_formatted,
                disable_date_to : calendarEvent.extendedProps.date_to_formatted,
                id_disable_date : calendarEvent.extendedProps.id_disable_date,
                room_disable_reason : calendarEvent.extendedProps.reason,
                id_calendar_event: $(element).attr('data-id_calendar_event') // this will be used to identify this event on the calendar
            };
            if ($('#disable_dates_form').attr('data-form_action') == 'update'
                && $('#disable_dates_form .id_calendar_event').val() != formData.id_calendar_event
            ) {
                $('#disable_dates_form').attr('data-form_action',' ')
            }

            DisableDatesForm.displayUpdateDatesForm();
            DisableDatesForm.setFormData(formData);
        });

        // Removing multiple disable dates that intersects with the selected date range.
        $(document).on('click', '#disable_dates_form .submit_remove_disable_date', function(e) {
            e.preventDefault();
            if (confirm(removeDisableDateText)) {
                let idRoom = parseInt($('#deactiveDatesModal').attr('data-id-room'));
                if(isNaN(idRoom)) {
                    idRoom = 0;
                }

                const formElem = $('#disable_dates_form');
                var dateFrom =  $(formElem).find('.disable_date_from').val();
                var dateTo = new Date($(formElem).find('.disable_date_to').val());
                dateTo.setDate(dateTo.getDate() + 1);
                dateTo = $.datepicker.formatDate('yy-mm-dd', dateTo);
                var data = {
                    ajax: true,
                    action: 'removeDisableDatesInDateRange',
                    id_room: idRoom,
                    date_from: dateFrom,
                    date_to: dateTo
                }
                $.ajax({
                    url: prod_link,
                    type: 'POST',
                    data: data,
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.status) {
                            DisableDatesObj.reset(false);
                            if (response.disable_dates.length) {
                                DisableDatesObj.initEvents(response.disable_dates);
                            }
                        }
                        DisableDatesForm.showMessages(response.msg);
                    }
                });
            }
        });

        // opening form for adding new disable date.
        $(document).on('click', '#deactiveDatesModal .add_disable_dates, #deactiveDatesModal .disabled_selected_dates', function(e){
            e.preventDefault();
            DisableDatesForm.displayAddDatesForm();
        });

        // closing the actions tooltip for the calendar drag drop event.
        $(document).on('click', '#disable_dates_full_calendar .tooltip_action_block .close', function(){
            $(this).closest('.tooltip_action_block').remove();
        });

        // opening form for removing disable date.
        $(document).on('click', '#deactiveDatesModal .remove_disable_dates, #deactiveDatesModal .enable_selected_dates', function(e){
            e.preventDefault();
            DisableDatesForm.displayRemoveDatesForm();
        });

        // to save the dates on submit button click event
        $(document).on('click', '#disable_dates_form .submit_add_disable_date', function(e){
            e.preventDefault();
            if (confirm(confirmText)) {
                DisableDatesObj.submitDisableDates();
            }
        });

        // Closing the form on click event.
        $(document).on('click', '#disable_dates_form .close_disable_dates_form', function(){
            DisableDatesForm.resetForm();
            DisableDatesForm.hideForm();
        });

        // Hide tooltips on click.
        $(document).on('click', function(e) {
            var hideAll = true;
            if ($(e.target).closest('.tooltip_info_block').length) {
                hideAll = false;
            }

            $('#disable_dates_full_calendar .tooltip_info_block').each(function(){
                var tooltipId = $(this).attr('data-tooltip-id');
                if (!$('#tooltip-id-'+tooltipId).length) {
                    $('#disable_dates_full_calendar .tooltip_info_block').remove();
                } else if (hideAll) {
                    $('#tooltip-id-'+tooltipId).tooltip('hide');
                }
            });
        });

        // Called after the modal is shown, since the modal is hidden at first, the size of the fullcalendar is render incorrectly.
        $('#deactiveDatesModal').on('shown.bs.modal', function(e) {
            DisableDatesCalendar.updateSize();
            $('#modal_loader').hide();
            $('#deactiveDatesModal').css('visibility', 'visible');
        });

        // Reseting and populating the modal.
        $('#deactiveDatesModal').on('show.bs.modal', function(e) {
            $('#deactiveDatesModal').css('visibility', 'hidden');
            $('#modal_loader').show();
            DisableDatesObj.reset();
            DisableDatesObj.init($(e.relatedTarget));
        });

        // Disable dates data filling in the tr so that we cal validate it while saving this room type.
        $('#deactiveDatesModal').on('hide.bs.modal', function(e) {
            const disableDates = DisableDatesObj.getAllDisableDates();
            const roomRowIndex = parseInt($('#deactiveDatesModal').attr('data-room-row-index'));
            const roomRow = $('#product-configuration .hotel-room tr.room_data_values[data-row-index='+roomRowIndex+']');
            $(roomRow).find('.disable_dates_json').val(JSON.stringify(disableDates));
            DisableDatesObj.reset();
            DisableDatesObj.allowCalendarActions();
        });

        // Init full calander object.
        const DisableDatesCalendar = new FullCalendar.Calendar($('#disable_dates_full_calendar').get(0), {
            initialView: 'dayGridMonth',
            initialDate: '<?php echo date('Y-m-d',time());?>
',
            dayMaxEventRows: true,
            selectable: true,
            direction:<?php if ((isset($_smarty_tpl->tpl_vars['language_is_rtl']->value)) && $_smarty_tpl->tpl_vars['language_is_rtl']->value) {?>'rtl'<?php } else { ?>'ltr'<?php }?>,
            locale:<?php if ((isset($_smarty_tpl->tpl_vars['locale']->value)) && $_smarty_tpl->tpl_vars['locale']->value) {?>'<?php echo $_smarty_tpl->tpl_vars['locale']->value;?>
'<?php } else { ?>'en'<?php }?>,
            unselectAuto: true,
            contentHeight: 'auto',
            views: {
                dayGridMonth: {
                    dayMaxEventRows: 10
                }
            },
            // This function is used to check the clicked date on calendar can be selected.
            selectAllow: function(info) {
                $('#disable_dates_full_calendar .tooltip_container').remove();
                let idRoom = parseInt($('#deactiveDatesModal').attr('data-id-room'));
                // disabling select action incase room is not saved.
                if (isNaN(idRoom)) {
                    return false;
                }

                var date_start = new Date(info.startStr);
                if (date_start < dateToday) {
                    return false;
                }

                return true;
            },
            // This event is called every time an event has mounted successfully.
            // This event is called not called incase there is any changes in the event source.
            eventDidMount: function(info) {
                DisableDatesObj.handleEventDateBackgroundHighlight(info.event, true);
                DisableDatesObj.initEventTooltip(info.event, info.el);
                var isDeletable = info.event.extendedProps.is_deletable;
                var isEditable = info.event.extendedProps.is_editable;
                if (isDeletable) {
                    $(info.el).find('.fc-event-title-container').append('<i class="icon-trash pull-right delete_disable_dates"></i>');
                }

                if (isDeletable) {
                    $(info.el).find('.fc-event-title-container').append('<i class="icon-pencil pull-right edit_disable_dates"></i>');
                }

                if (info.isStart) {
                    $(info.el).find('.fc-event-title').addClass('event_title_container');
                }
            },
            // This event is called when a calendar event is removed from the full calendar.
            eventWillUnmount: function(info) {
                DisableDatesObj.handleEventDateBackgroundHighlight(info.event, false);
            },
            // This event is caled when admin select and dates on full calendar using mouse.
            select: function(info) {
                var selectedElement = $('#disable_dates_full_calendar .fc-daygrid-bg-harness').last();
                DisableDatesForm.resetForm();
                DisableDatesForm.hideForm();
                $('#disable_dates_form').attr('data-form_action', 'tooltip_actions');
                var formData = {
                    disable_date_from : info.startStr,
                    disable_date_to : info.endStr,
                };
                DisableDatesForm.setFormData(formData);
                var html = $('#tooltip_action_block').html();
                var options = {
                    title: ' ',
                    html: true,
                    template: html,
                    trigger: 'click',
                    container: $('#disable_dates_full_calendar').closest('div'),
                    delay: {
                        show: 600,
                        hide: 500
                    },
                    placement: <?php if ((isset($_smarty_tpl->tpl_vars['language_is_rtl']->value)) && $_smarty_tpl->tpl_vars['language_is_rtl']->value) {?>'left'<?php } else { ?>'right'<?php }?>,
                }
                $(selectedElement).tooltip(options);
                $('#disable_dates_full_calendar .tooltip_action_block .enable_selected_dates').hide();
                setTimeout(() => {
                    $(selectedElement).tooltip('show');
                    if (!DisableDatesObj.checkDisabled(formData)) {
                        $('#disable_dates_full_calendar .tooltip_action_block .enable_selected_dates').hide();
                    }
                }, 200);
            },
            unselect: function(){
                // since unselectAuto: true will remove the element on which we are adding the tooltip, so the tooltip is destroyed on any action.
                // which will not allow the events binded to the tooltip_action_block class
                setTimeout(() => {
                    $('#disable_dates_full_calendar .tooltip_action_block').remove();
                }, 1);
            },
            eventMouseEnter: function (info) {
                var idCalendarEvent = $(info.el).find('.fc-event-title').attr('data-id_calendar_event');
                $('.id_calendar_event_' + idCalendarEvent).addClass('calendar_hover_highlight');
                $(info.el).addClass('calendar_hover_highlight');
                $(info.el).addClass('id_calendar_event_' + idCalendarEvent);
            },
            eventMouseLeave: function(info) {
                var idCalendarEvent = $(info.el).find('.fc-event-title').attr('data-id_calendar_event');
                $('.id_calendar_event_' + idCalendarEvent).removeClass('calendar_hover_highlight');
                $(info.el).removeClass('calendar_hover_highlight');
            }
        });

        DisableDatesCalendar.render();

        //Object to handle all disable date form related operations.
        const DisableDatesForm = {
            // used for resetting the disable date form form.
            resetForm: function () {
                $('#disable_dates_form .ui-datepicker').hide();
                $('#disable_dates_form .disable_date_from').val('');
                $('#disable_dates_form .disable_date_to').val('');
                $('#disable_dates_form .id_disable_date').val('');
                $('#disable_dates_form .room_disable_reason').val('');
                $('#disable_dates_form .id_calendar_event').val('');
                $('#disable_dates_form .room_disable_reason').closest('.form-group').show();
                $('#disable_dates_form .date_from_container').datepicker("option", "minDate", "<?php echo date('Y-m-d');?>
");
                $('#disable_dates_form .date_to_container').datepicker("setDate", null);
                $('#disable_dates_form .date_from_container').datepicker("setDate", null);
                $('#disable_dates_form .date_from_container').find('.ui-datepicker').hide();
                $('#disable_dates_form .date_to_container').find('.ui-datepicker').hide();
            },
            // used for opulating the disable dates form with the data.
            setFormData: function(formData) {
                var disableDateTo = new Date(formData.disable_date_to);
                // setting the date_to to -1 since the full calendar does not includes the date to
                disableDateTo.setDate(disableDateTo.getDate() - 1);
                disableDateTo = $.datepicker.formatDate('yy-mm-dd', disableDateTo);
                //setting the min dates dfor the date picker
                $('#disable_dates_form .disable_date_from').val(formData.disable_date_from);
                $('#disable_dates_form .date_from_container').datepicker("setDate", formData.disable_date_from);

                $('#disable_dates_form .disable_date_to').val(disableDateTo);
                $('#disable_dates_form .date_to_container').datepicker("option", "minDate", formData.disable_date_from);
                $('#disable_dates_form .date_to_container').datepicker("setDate", disableDateTo);
                if (typeof(formData.id_disable_date) !== undefined)
                    $('#disable_dates_form .id_disable_date').val(formData.id_disable_date);

                if (typeof(formData.room_disable_reason) !== undefined)
                    $('#disable_dates_form .room_disable_reason').val(formData.room_disable_reason);

                if (typeof(formData.id_calendar_event) !== undefined)
                    $('#disable_dates_form .id_calendar_event').val(formData.id_calendar_event);
            },
            // used for hiding the disable date form form.
            hideForm: function(){
                $('#disable_dates_form').hide(200);
                $('#disable_dates_form .disable_dates_form_title').hide(200);
                $('#disable_dates_form .submit_add_disable_date').hide(200);
                $('#disable_dates_form .submit_remove_disable_date').hide(200);
            },
            // used for display the disable dates form with add action.
            displayAddDatesForm: function () {
                DisableDatesForm.hideMessages();
                DisableDatesCalendar.unselect();
                if ($('#disable_dates_form').attr('data-form_action') == 'tooltip_actions') {
                    $('#disable_dates_form').attr('data-form_action', 'add');
                }

                if ($('#disable_dates_form').attr('data-form_action') != 'add') {
                    $('#disable_dates_form').attr('data-form_action', 'add');
                    DisableDatesForm.resetForm();
                    DisableDatesForm.hideForm();
                }

                DisableDatesForm.displayForm();
                $('#disable_dates_form .disable_dates_form_title_add').show(200);
                $('#disable_dates_form .submit_add_disable_date').show(200);
            },
            // used for display the disable dates form with remove action.
            displayRemoveDatesForm: function () {
                DisableDatesForm.hideMessages();
                DisableDatesCalendar.unselect();
                if ($('#disable_dates_form').attr('data-form_action') == 'tooltip_actions') {
                    $('#disable_dates_form').attr('data-form_action', 'remove');
                }

                if ($('#disable_dates_form').attr('data-form_action') != 'remove') {
                    $('#disable_dates_form').attr('data-form_action', 'remove');
                    DisableDatesForm.resetForm();
                    DisableDatesForm.hideForm();
                }

                DisableDatesForm.displayForm();
                $('#disable_dates_form .disable_dates_form_title_delete').show(200);
                $('#disable_dates_form .submit_remove_disable_date').show(200);
                $('#disable_dates_form .room_disable_reason').closest('.form-group').hide();
                $('#disable_dates_form .date_from_container').datepicker("option", "minDate", null);
            },
            // used for display the disable dates form with update action.
            displayUpdateDatesForm: function () {
                DisableDatesForm.hideMessages();
                DisableDatesCalendar.unselect();
                if ($('#disable_dates_form').attr('data-form_action') != 'update') {
                    $('#disable_dates_form').attr('data-form_action', 'update');
                    DisableDatesForm.resetForm();
                    DisableDatesForm.hideForm();
                }

                DisableDatesForm.displayForm();
                $('#disable_dates_form .disable_dates_form_title_update').show(200);
                $('#disable_dates_form .submit_add_disable_date').show(200);
            },
            // used for display the disable dates, also the screen is scrolled to top to show the form on the screen.
            displayForm: function() {
                if ($('#deactiveDatesModal').scrollTop() > 0) {
                    $('#deactiveDatesModal').animate({ scrollTop: 0 });
                }

                $('#disable_dates_form').show(200);
                setTimeout(() => {
                    $('#disable_dates_full_calendar .tooltip_info_block').remove();
                }, 610);
            },
            // used to display messages related to the disable date form
            showMessages: function(messages) {
                $('#deactiveDatesModal .messages-wrap').html(messages);
                $('#deactiveDatesModal .messages-wrap').show();
                $('#deactiveDatesModal').animate({ scrollTop: 0 });
            },
            // used to hide messages related to the disable date form
            hideMessages: function() {
                $('#deactiveDatesModal .messages-wrap').hide();
                $('#deactiveDatesModal .messages-wrap').html('');
            }
        }

        //Object to handle all calander and disable dates related operations.
        const DisableDatesObj = {
            // called to initilize and set actions for the modal.
            init: function(triggerRoomRow) {
                var idRoom = parseInt($(triggerRoomRow).attr('data-id-room'));
                var roomRowIndex = parseInt($(triggerRoomRow).closest('tr').attr('data-row-index'));
                var roomNum = $(triggerRoomRow).closest('tr').find('[name="rooms_info['+roomRowIndex+'][room_num]"]').val();
                $('#deactiveDatesModal').attr('data-room-row-index', roomRowIndex);
                $('#deactiveDatesModal').attr('data-id-room', idRoom);
                if ($.trim(roomNum) != '') {
                    roomNum = '( '+'<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room No'),$_smarty_tpl ) );?>
'+' '+roomNum+')';
                }

                $('#deactiveDatesModal .disable_dates_room_num').html(roomNum);
                if (isNaN(idRoom)) {
                    DisableDatesObj.restrictCalendarActions();
                    return;
                } else {
                    DisableDatesObj.getPopulateRoomDisableDates(idRoom);
                }
            },
            // called to add events in the calendar.
            initEvents: function(datesInfo) {
                if (datesInfo.length) {
                    var events = [];
                    $.each(datesInfo, function(index, dateInfo) {
                        var eventId = DisableDatesObj.getUniqueEventId();
                        events.push({
                            'id': DisableDatesObj.getUniqueEventId(),
                            'title': dateInfo['reason'],
                            'start': dateInfo['date_from'],
                            'end': dateInfo['date_to'],
                            'reason': dateInfo['reason'],
                            'date_add' : dateInfo['date_add'],
                            'id_disable_date' : parseInt(dateInfo['id']),
                            'is_editable' : parseInt(dateInfo['is_editable']),
                            'is_deletable' : parseInt(dateInfo['is_deletable']),
                            'event_title' : dateInfo['event_title'],
                            'date_to_formatted': dateInfo['date_to'],
                            'date_from_formatted': dateInfo['date_from'],
                            'id_event' : dateInfo['id_event'],
                            'event_url' : dateInfo['event_url']
                        });
                    });
                    DisableDatesCalendar.addEventSource(events);
                }
            },
            // called to initlized the tooltips for the events in the calendar.
            initEventTooltip: function(event, element) {
                // will be used to get this particular event
                $(element).find('.fc-event-title').attr('data-id_calendar_event', event.id);
                var dateFrom = event.extendedProps.date_from_formatted;
                var eventDateTo = new Date(event.extendedProps.date_to_formatted);
                // setting the date_to to -1 days since the full calendar does not includes the end date
                eventDateTo.setDate(eventDateTo.getDate() - 1);
                var dateTo = $.datepicker.formatDate('yy-mm-dd', eventDateTo);
                var reason = event.extendedProps.reason;
                var eventTitle = event.extendedProps.event_title;
                var idEvent = event.extendedProps.id_event;
                var eventUrl = event.extendedProps.event_url;
                var dateAdd = event.extendedProps.date_add;
                $('#tooltip_info_block .tooltip_date_from').text(dateFrom);
                $('#tooltip_info_block .tooltip_date_to').text(dateTo);
                $('#tooltip_info_block .tooltip_date_add').text(dateAdd);
                $('#tooltip_info_block .tooltip_reason').parent().hide();
                if (reason != '') {
                    $('#tooltip_info_block .tooltip_reason').text(reason).parent().show();
                }

                if (eventTitle != '' && eventTitle != null) {
                    eventTitle = '<span class="tooltip_event_title">'+eventTitle+'</span>';
                    $('#tooltip_info_block .tooltip_title').html(eventTitle).show();
                } else {
                    $('#tooltip_info_block .tooltip_title').html('').hide();
                }

                if (idEvent && idEvent !== null) {
                    var eventHtml = '';
                    if (eventUrl != '' && eventUrl != null) {
                        eventHtml = '<a target="_blank" href="'+eventUrl+'">'+ '#'+idEvent + '</a>';
                    } else {
                        eventHtml = '<span>'+ '#'+idEvent + '</span>';
                    }

                    $('#tooltip_info_block .tooltip_id_event').html(eventHtml).parent().show();
                } else {
                    $('#tooltip_info_block .tooltip_id_event').html('').parent().hide();
                }

                $('#tooltip_info_block .tooltip_container').attr('data-tooltip-id', event.id + '-'+ tooltipCounter);
                var html = $('#tooltip_info_block').html();
                var options = {
                    title: ' ',
                    html: true,
                    template: html,
                    trigger: 'click',
                    container: $('#disable_dates_full_calendar').closest('div'),
                    delay: {
                        show: 600,
                        hide: 500
                    },
                    placement: 'auto'
                }

                // linking the tooltip with the calander event, so we can perform actions on them.

                $(element).addClass('id_calendar_event_' + event.id);
                $(element).find('.fc-event-main-frame').tooltip(options);

                // since an event can be for more than one time, we have to display the tooltip for more than one time, so we are adding counter for unique id for them
                $(element).find('.fc-event-main-frame').attr('id', 'tooltip-id-' + event.id + '-' + tooltipCounter);
                tooltipCounter++;
            },
            // called to restrict and hide all actions on the modal
            restrictCalendarActions: function() {
                $('#deactiveDatesModal .add_disable_dates').hide();
                $('#deactiveDatesModal .remove_disable_dates').hide();
                $('#deactiveDatesModal .room_not_found').show();
            },
            // called to enable the restricted actions on the modal
            allowCalendarActions: function() {
                $('#deactiveDatesModal .add_disable_dates').show();
                $('#deactiveDatesModal .remove_disable_dates').show();
                $('#deactiveDatesModal .room_not_found').hide();
            },
            // called to get the disable dates for a perticular room.
            getPopulateRoomDisableDates: function(idRoom) {
                $.ajax({
                    url: prod_link,
                    type: 'POST',
                    data: {
                        ajax: true,
                        action: 'getDisableDates',
                        id_room: idRoom,
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.status) {
                            if (response.disable_dates.length) {
                                DisableDatesObj.initEvents(response.disable_dates);
                            }
                        }

                        DisableDatesForm.hideMessages();
                    }
                });
            },
            // This is called to reset the disable dates calendar and the form.
            reset: function(showCurrentDay = true) {
                var source = DisableDatesCalendar.getEventSources();
                if (source.length) {
                    $.each(source, function(i, event) {
                        event.remove();
                    });
                }

                tooltipCounter = 0;

                $('#deactiveDatesModal .disable_dates_room_num').html('');
                $('#disable_dates_full_calendar .tooltip_container').remove();
                DisableDatesForm.hideMessages();
                DisableDatesForm.resetForm();
                DisableDatesForm.hideForm();
                if (showCurrentDay) {
                    // this is used to show the current day on the calendar
                    DisableDatesCalendar.today();
                }
            },
            // This is called to submit the dates selected in the disable date form.
            submitDisableDates: function() {
                let idRoom = parseInt($('#deactiveDatesModal').attr('data-id-room'));
                if(isNaN(idRoom)) {
                    idRoom = 0;
                }
                var formElem = $('#disable_dates_form');
                var dateFrom =  $(formElem).find('.disable_date_from').val();
                var dateTo = $(formElem).find('.disable_date_to').val();
                var eventId = parseInt($(formElem).find('.id_calendar_event').val());
                var reason = $(formElem).find('.room_disable_reason').val();
                var idProduct = $('[name="id_product"]').val();
                var idDisableDate = parseInt($(formElem).find('.id_disable_date').val());
                if (isNaN(idDisableDate)) {
                    idDisableDate = 0;
                }

                dateTo = new Date(dateTo);
                // setting the date_to +1 since the full calendar does not includes the date to
                dateTo.setDate(dateTo.getDate() + 1);
                dateTo = $.datepicker.formatDate('yy-mm-dd', dateTo);
                $.ajax({
                    url: prod_link,
                    type: 'POST',
                    data: {
                        ajax: true,
                        action: 'submitDisableDates',
                        id_disable_date : idDisableDate,
                        id_product: idProduct,
                        id_room: idRoom,
                        date_from: dateFrom,
                        date_to: dateTo,
                        reason: reason
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        reason = $.trim(reason);
                        if (response.status) {
                            var validatedEvent = {
                                'id' : DisableDatesObj.getUniqueEventId(),
                                'title': reason,
                                'start': dateFrom,
                                'end': dateTo,
                                'date_from_formatted': dateFrom,
                                'date_to_formatted': dateTo,
                                'reason': reason,
                                'id': DisableDatesObj.getUniqueEventId(),
                                'is_deletable' : 1,
                                'is_editable' : 1,
                                'id_disable_date': response.id_disable_date,
                                'event_title' : response.event_title,
                                'id_event' : '',
                                'event_url' : '',
                                'date_add' : "<?php echo date('Y-m-d H:i:s');?>
"
                            }

                            if (!isNaN(eventId)) {
                                var olderEvent = DisableDatesCalendar.getEventById(eventId);
                                if (olderEvent) {
                                    validatedEvent.is_deletable = olderEvent.extendedProps.is_deletable;
                                    validatedEvent.is_editable = olderEvent.extendedProps.is_editable;
                                    validatedEvent.event_title = olderEvent.extendedProps.event_title;
                                    validatedEvent.id_event = olderEvent.extendedProps.id_event;
                                    validatedEvent.event_url = olderEvent.extendedProps.event_url;
                                    olderEvent.remove();
                                }
                            }

                            var event = [];
                            event.push(validatedEvent);
                            DisableDatesCalendar.addEventSource(event);
                            DisableDatesForm.resetForm();
                            DisableDatesForm.hideForm();
                        }
                        DisableDatesForm.showMessages(response.msg);
                    }
                });
            },
            // This is called to delete the disable date object using the idDisableDate.
            deleteDisableDate: function(idDisableDate) {
                $.ajax({
                    url: prod_link,
                    type: 'POST',
                    data: {
                        ajax: true,
                        action: 'deleteDisableDate',
                        id_disable_date : idDisableDate,
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        DisableDatesForm.showMessages(response.msg);

                        return response.status;
                    }
                });
            },
            // This is called to get the all disable dates from the calander.
            getAllDisableDates: function() {
                var disableDates = [];
                var events = DisableDatesCalendar.getEvents();
                if (events.length) {
                    $.each(events, function(i, event) {
                        var data = {
                            date_from: event.extendedProps.date_from_formatted,
                            date_to: event.extendedProps.date_to_formatted,
                            reason: event.extendedProps.reason,
                            date_add : event.extendedProps.date_add,
                            id : event.extendedProps.id_disable_date,
                            is_editable : event.extendedProps.is_editable,
                            event_title : event.extendedProps.event_title,
                            is_deletable : event.extendedProps.is_deletable,
                            id_event : event.extendedProps.id_event,
                            event_url : event.extendedProps.event_url
                        }

                        disableDates.push(data);
                    });
                }

                return disableDates;
            },
            // This is used to generate and get a unique id for all the events, which are added to the tooltips to link them together.
            getUniqueEventId: function() {
                var id = Math.floor(Math.random() * 100000);
                var event = DisableDatesCalendar.getEventById(id);
                if (event) {
                    return DisableDatesObj.getUniqueEventId()
                }
                return id;
            },
            // This is used to set/highlight the background for all the days that are added in the calander as event.
            handleEventDateBackgroundHighlight: function(event, add) {
                if (event.start && event.end) {
                    let dateFrom = new Date(event.start);
                    let endDate = new Date(event.end);
                    dateFrom.setDate(dateFrom.getDate() + 1)
                    let startDate = dateFrom;
                    // Loop through all the days the event spans
                    for (let date = startDate; date <= endDate; date.setDate(date.getDate() + 1)) {
                        // This return the date in format of Y-m-d, and we are counting the date for overlapping events.
                        let dateString = date.toISOString().split('T')[0];
                        if (add) {
                            if (!disableDatesCounter[dateString]) {
                                disableDatesCounter[dateString] = 0;
                            }

                            disableDatesCounter[dateString]++;
                        } else {
                            disableDatesCounter[dateString]--;
                            if (disableDatesCounter[dateString] <= 0) {
                                delete disableDatesCounter[dateString];
                            }
                        }
                    }
                } else if (event.start) {
                    let dateFrom = new Date(event.start);
                    dateFrom.setDate(dateFrom.getDate() + 1);
                    let dateString = dateFrom.toISOString().split('T')[0];
                    if (add) {
                        if (!disableDatesCounter[dateString]) {
                            disableDatesCounter[dateString] = 0;
                        }

                        disableDatesCounter[dateString]++;
                    } else {
                        disableDatesCounter[dateString]--;
                        if (disableDatesCounter[dateString] <= 0) {
                            delete disableDatesCounter[dateString];
                        }
                    }
                }

                const today = new Date().toISOString().split('T')[0];
                $('#disable_dates_full_calendar .fc-daygrid-day').each(function() {
                    let dateString = $(this).data('date');
                    if (dateString !== today) {
                        if (disableDatesCounter[dateString]) {
                            $(this).addClass('highlight-event-day');
                        } else {
                            $(this).removeClass('highlight-event-day');
                        }
                    }
                });
            },
            checkDisabled: function(dates) {
                let dateFrom = new Date(dates.disable_date_from);
                let endDate = new Date(dates.disable_date_to);
                dateFrom.setDate(dateFrom.getDate())
                let startDate = dateFrom;
                for (let date = startDate; date < endDate; date.setDate(date.getDate() + 1)) {
                    let dateString = date.toISOString().split('T')[0];
                    if (disableDatesCounter[dateString]) {
                        return true;
                    }
                }

                return false;
            }
        }
    });

<?php echo '</script'; ?>
><?php }
}
