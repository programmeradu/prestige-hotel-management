<?php
/* Smarty version 3.1.39, created on 2025-05-07 15:40:50
  from '/www/wwwroot/prestigehotel.org/admin033aqbbsn/themes/default/template/controllers/orders/modals/_edit_room_tab_content.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_681b7f025d9fd9_82476086',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd511fd86424f751de820128dd54505e125f47df5' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/admin033aqbbsn/themes/default/template/controllers/orders/modals/_edit_room_tab_content.tpl',
      1 => 1741272494,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_681b7f025d9fd9_82476086 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div id="edit_room_tab" class="tab-pane active">
    <input type="hidden" name="id_order" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order'];?>
" />
    <input type="hidden" name="id_room" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['id_room'];?>
" />
    <input type="hidden" name="id_product" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['id_product'];?>
" />
    <input type="hidden" name="id_hotel" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['id_hotel'];?>
" />
    <input type="hidden" name="date_from" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['date_from'];?>
" />
    <input type="hidden" name="date_to" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['date_to'];?>
" />
    <input type="hidden" name="id_order_detail" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['id_order_detail'];?>
" />
    <input type="hidden" name="product_price_tax_excl" value="<?php echo Tools::ps_round($_smarty_tpl->tpl_vars['data']->value['original_unit_price_tax_excl'],2);?>
" />
    <input type="hidden" name="product_price_tax_incl" value="<?php echo Tools::ps_round($_smarty_tpl->tpl_vars['data']->value['original_unit_price_tax_incl'],2);?>
" />

    <div class="edit_room_fields">
        <div class="row form-group">
            <div class="col-sm-6 room_check_in_div">
                <label class="control-label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Check-In'),$_smarty_tpl ) );?>
</label>
                <div class="input-group">
                    <input type="hidden" class="edit_product_date_from_actual" name="edit_product[date_from]"/>
                    <?php if ((isset($_smarty_tpl->tpl_vars['refundReqBookings']->value)) && $_smarty_tpl->tpl_vars['refundReqBookings']->value && in_array($_smarty_tpl->tpl_vars['data']->value['id'],$_smarty_tpl->tpl_vars['refundReqBookings']->value) && $_smarty_tpl->tpl_vars['data']->value['is_refunded']) {?>
                        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0], array( array('date'=>$_smarty_tpl->tpl_vars['data']->value['date_from']),$_smarty_tpl ) );?>

                    <?php } else { ?>
                        <input type="text" class="form-control edit_product_date_from" readonly/>
                        <div class="input-group-addon"><i class="icon-calendar"></i></div>
                    <?php }?>
                </div>
            </div>
            <div class="col-sm-6 room_check_out_div">
                <label class="control-label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Check-Out'),$_smarty_tpl ) );?>
</label>
                <div class="input-group">
                    <input type="hidden" class="edit_product_date_to_actual" name="edit_product[date_to]"/>
                    <?php if ((isset($_smarty_tpl->tpl_vars['refundReqBookings']->value)) && $_smarty_tpl->tpl_vars['refundReqBookings']->value && in_array($_smarty_tpl->tpl_vars['data']->value['id'],$_smarty_tpl->tpl_vars['refundReqBookings']->value) && $_smarty_tpl->tpl_vars['data']->value['is_refunded']) {?>
                        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0], array( array('date'=>$_smarty_tpl->tpl_vars['data']->value['date_to']),$_smarty_tpl ) );?>

                    <?php } else { ?>
                        <input type="text" class="form-control edit_product_date_to" readonly/>
                        <div class="input-group-addon"><i class="icon-calendar"></i></div>
                    <?php }?>
                </div>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-sm-6">
                <label class="control-label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Price (tax excl.)'),$_smarty_tpl ) );?>
</label>
                <div class="input-group">
                    <?php if ($_smarty_tpl->tpl_vars['currency']->value->format%2) {?><div class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['currency']->value->sign;?>
</div><?php }?>
                    <input class="form-control room_unit_price" type="text" name="room_unit_price" value=""/>
                    <?php if (!($_smarty_tpl->tpl_vars['currency']->value->format%2)) {?><div class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['currency']->value->sign;?>
</div><?php }?>
                </div>
            </div>
            <div class="col-sm-6">
                <label class="control-label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Occupancy'),$_smarty_tpl ) );?>
</label>
                <div class="booking_occupancy_edit">
                    <div class="dropdown">
                        <button class="form-control booking_guest_occupancy btn btn-default btn-left btn-block input-occupancy" type="button">
                            <span>
                                <?php if ($_smarty_tpl->tpl_vars['data']->value['adults']) {
echo $_smarty_tpl->tpl_vars['data']->value['adults'];
}?> <?php if ($_smarty_tpl->tpl_vars['data']->value['adults'] > 1) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Adults'),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Adult'),$_smarty_tpl ) );
}
ob_start();
echo $_smarty_tpl->tpl_vars['data']->value['children'];
$_prefixVariable1 = ob_get_clean();
if ($_prefixVariable1) {?>, <?php echo $_smarty_tpl->tpl_vars['data']->value['children'];?>
 <?php if ($_smarty_tpl->tpl_vars['data']->value['children'] > 1) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Children'),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Child'),$_smarty_tpl ) );
}
}?>
                            </span>
                        </button>
                        <div class="dropdown-menu booking_occupancy_wrapper fixed-width-xxl well well-sm">
                            <div class="booking_occupancy_inner">
                            <input type="hidden" class="max_adults" value="<?php if ((isset($_smarty_tpl->tpl_vars['data']->value['room_type_info']))) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['room_type_info']['max_adults'], ENT_QUOTES, 'UTF-8', true);
}?>">
                            <input type="hidden" class="max_children" value="<?php if ((isset($_smarty_tpl->tpl_vars['data']->value['room_type_info']))) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['room_type_info']['max_children'], ENT_QUOTES, 'UTF-8', true);
}?>">
                            <input type="hidden" class="max_guests" value="<?php if ((isset($_smarty_tpl->tpl_vars['data']->value['room_type_info']))) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['room_type_info']['max_guests'], ENT_QUOTES, 'UTF-8', true);
}?>">
                                <div class="occupancy_info_block" occ_block_index="0">
                                    <div class="occupancy_info_head col-sm-12"><span class="room_num_wrapper"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room - 1'),$_smarty_tpl ) );?>
</span></div>
                                    <div class="row">
                                        <div class="col-xs-6 occupancy_count_block">
                                            <div class="col-sm-12">
                                                <label><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Adults'),$_smarty_tpl ) );?>
</label>
                                                <input type="number" class="form-control num_occupancy num_adults" name="occupancy[0][adults]" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['adults'];?>
" min="1"  max="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['room_type_info']['max_adults'], ENT_QUOTES, 'UTF-8', true);?>
">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 occupancy_count_block">
                                            <div class="col-sm-12">
                                                <label><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Child'),$_smarty_tpl ) );?>
 <span class="label-desc-txt"></span></label>
                                                <input type="number" class="form-control num_occupancy num_children" name="occupancy[0][children]" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['children'];?>
" min="0" max="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['room_type_info']['max_children'], ENT_QUOTES, 'UTF-8', true);?>
">
                                                (<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Below'),$_smarty_tpl ) );?>
  <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['max_child_age']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'years'),$_smarty_tpl ) );?>
)
                                            </div>
                                        </div>
                                    </div>

                                    <p style="display:none;"><span class="text-danger occupancy-input-errors"></span></p>
                                    <div class="row children_age_info_block" <?php if (!(isset($_smarty_tpl->tpl_vars['data']->value['child_ages'])) || !$_smarty_tpl->tpl_vars['data']->value['child_ages']) {?>style="display:none"<?php }?>>
                                        <div class="col-sm-12">
                                            <label class="col-sm-12"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'All Children'),$_smarty_tpl ) );?>
</label>
                                            <div class="col-sm-12">
                                                <div class="row children_ages">
                                                    <?php if ((isset($_smarty_tpl->tpl_vars['data']->value['child_ages'])) && $_smarty_tpl->tpl_vars['data']->value['child_ages']) {?>
                                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value['child_ages'], 'childAge');
$_smarty_tpl->tpl_vars['childAge']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['childAge']->value) {
$_smarty_tpl->tpl_vars['childAge']->do_else = false;
?>
                                                            <p class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                <select class="guest_child_age room_occupancies" name="occupancy[0][child_ages][]">
                                                                    <option value="-1" <?php if ($_smarty_tpl->tpl_vars['childAge']->value == -1) {?>selected<?php }?>><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Select age'),$_smarty_tpl ) );?>
</option>
                                                                    <option value="0" <?php if ($_smarty_tpl->tpl_vars['childAge']->value == 0) {?>selected<?php }?>><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Under 1'),$_smarty_tpl ) );?>
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
                                                            </p>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" id="submitRoomChange" class="btn btn-primary"><i class="icon icon-bed"></i> &nbsp;<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Update Rooms"),$_smarty_tpl ) );?>
</button>
    </div>
</div><?php }
}
