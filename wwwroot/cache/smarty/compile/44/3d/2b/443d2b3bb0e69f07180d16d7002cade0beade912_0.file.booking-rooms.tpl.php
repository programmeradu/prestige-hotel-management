<?php
/* Smarty version 3.1.39, created on 2025-03-13 10:15:23
  from '/home/site/wwwroot/modules/hotelreservationsystem/views/templates/admin/hotel_rooms_booking/helpers/view/_partials/booking-rooms.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d2b03bbe0696_95662456',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '443d2b3bb0e69f07180d16d7002cade0beade912' => 
    array (
      0 => '/home/site/wwwroot/modules/hotelreservationsystem/views/templates/admin/hotel_rooms_booking/helpers/view/_partials/booking-rooms.tpl',
      1 => 1741860840,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67d2b03bbe0696_95662456 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/home/site/wwwroot/tools/smarty/plugins/modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<div class="col-sm-12" id="htl_rooms_list">
    <div class="panel">
        <ul class="nav nav-tabs">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['booking_data']->value['rm_data'], 'book_v', false, 'book_k');
$_smarty_tpl->tpl_vars['book_v']->index = -1;
$_smarty_tpl->tpl_vars['book_v']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['book_k']->value => $_smarty_tpl->tpl_vars['book_v']->value) {
$_smarty_tpl->tpl_vars['book_v']->do_else = false;
$_smarty_tpl->tpl_vars['book_v']->index++;
$_smarty_tpl->tpl_vars['book_v']->first = !$_smarty_tpl->tpl_vars['book_v']->index;
$__foreach_book_v_4_saved = $_smarty_tpl->tpl_vars['book_v'];
?>
                <li <?php if ($_smarty_tpl->tpl_vars['book_v']->first) {?>class="active"<?php }?> ><a href="#room_type_<?php echo $_smarty_tpl->tpl_vars['book_k']->value;?>
" data-toggle="tab"><?php echo $_smarty_tpl->tpl_vars['book_v']->value['name'];?>
</a></li>
            <?php
$_smarty_tpl->tpl_vars['book_v'] = $__foreach_book_v_4_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </ul>
        <div class="tab-content panel">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['booking_data']->value['rm_data'], 'book_v', false, 'book_k');
$_smarty_tpl->tpl_vars['book_v']->index = -1;
$_smarty_tpl->tpl_vars['book_v']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['book_k']->value => $_smarty_tpl->tpl_vars['book_v']->value) {
$_smarty_tpl->tpl_vars['book_v']->do_else = false;
$_smarty_tpl->tpl_vars['book_v']->index++;
$_smarty_tpl->tpl_vars['book_v']->first = !$_smarty_tpl->tpl_vars['book_v']->index;
$__foreach_book_v_5_saved = $_smarty_tpl->tpl_vars['book_v'];
?>
                <div id="room_type_<?php echo $_smarty_tpl->tpl_vars['book_k']->value;?>
" class="tab-pane <?php if ($_smarty_tpl->tpl_vars['book_v']->first) {?>active<?php }?>">
                                        <div>
                        <div class="form-group">
                            <b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room Occupancy','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
:</b>&nbsp;&nbsp;&nbsp;
                            <span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Maximum adults','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
 : <?php echo $_smarty_tpl->tpl_vars['book_v']->value['room_type_info']['max_adults'];?>
</span>&nbsp;&nbsp;&nbsp;<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Maximum children','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
 : <?php echo $_smarty_tpl->tpl_vars['book_v']->value['room_type_info']['max_children'];?>
</span>&nbsp;&nbsp;&nbsp;<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Maximum guests','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
 : <?php echo $_smarty_tpl->tpl_vars['book_v']->value['room_type_info']['max_guests'];?>
</span>
                        </div>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#avail_room_data_<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['book_k']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-toggle="tab"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Available Rooms','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</a></li>
                        <li><a href="#part_room_data_<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['book_k']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-toggle="tab"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Partially Available','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</a></li>
                        <li><a href="#book_room_data_<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['book_k']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-toggle="tab"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Booked Rooms','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</a></li>
                        <li><a href="#unavail_room_data_<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['book_k']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-toggle="tab"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Unavailable Rooms','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</a></li>
                    </ul>
                    <div class="tab-content panel">
                        <div id="avail_room_data_<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['book_k']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" class="tab-pane active">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room No.','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                            <th><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Duration','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                            <th><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Message','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                            <th><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Allotment Type','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                            <?php if ($_smarty_tpl->tpl_vars['occupancy_required_for_booking']->value) {?>
                                                <th class="fixed-width-xxl"><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Guests','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                            <?php }?>
                                            <th><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Action','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['book_v']->value['data']['available'], 'avai_v', false, 'avai_k');
$_smarty_tpl->tpl_vars['avai_v']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['avai_k']->value => $_smarty_tpl->tpl_vars['avai_v']->value) {
$_smarty_tpl->tpl_vars['avai_v']->do_else = false;
?>
                                            <tr>
                                                <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['avai_v']->value['room_num'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayRoomNumAfter','data'=>$_smarty_tpl->tpl_vars['avai_v']->value,'type'=>'available'),$_smarty_tpl ) );?>
</td>
                                                <?php $_smarty_tpl->_assignInScope('is_full_date', ($_smarty_tpl->tpl_vars['show_full_date']->value && (smarty_modifier_date_format($_smarty_tpl->tpl_vars['date_from']->value,'%D') == smarty_modifier_date_format($_smarty_tpl->tpl_vars['date_to']->value,'%D'))));?>
                                                <td><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0], array( array('date'=>$_smarty_tpl->tpl_vars['date_from']->value,'full'=>$_smarty_tpl->tpl_vars['is_full_date']->value),$_smarty_tpl ) );?>
 - <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0], array( array('date'=>$_smarty_tpl->tpl_vars['date_to']->value,'full'=>$_smarty_tpl->tpl_vars['is_full_date']->value),$_smarty_tpl ) );?>
</td>
                                                <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['avai_v']->value['room_comment'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                                                <td>
                                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['allotment_types']->value, 'allotment_type');
$_smarty_tpl->tpl_vars['allotment_type']->index = -1;
$_smarty_tpl->tpl_vars['allotment_type']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['allotment_type']->value) {
$_smarty_tpl->tpl_vars['allotment_type']->do_else = false;
$_smarty_tpl->tpl_vars['allotment_type']->index++;
$_smarty_tpl->tpl_vars['allotment_type']->first = !$_smarty_tpl->tpl_vars['allotment_type']->index;
$__foreach_allotment_type_7_saved = $_smarty_tpl->tpl_vars['allotment_type'];
?>
                                                        <label class="control-label">
                                                            <input type="radio" value="<?php echo intval($_smarty_tpl->tpl_vars['allotment_type']->value['id_allotment']);?>
" name="bk_type_<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['avai_v']->value['id_room'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-id-room="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['avai_v']->value['id_room'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" class="avai_bk_type" <?php if ($_smarty_tpl->tpl_vars['allotment_type']->first) {?>checked="checked"<?php }?>>
                                                            <span><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['allotment_type']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
                                                        </label>
                                                    <?php
$_smarty_tpl->tpl_vars['allotment_type'] = $__foreach_allotment_type_7_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                                    <input type="text" id="comment_<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['avai_v']->value['id_room'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" name="comment_<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['avai_v']->value['id_room'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" class="form-control booking_type_comment" placeholder="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Allotment message','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
">
                                                </td>
                                                <?php if ($_smarty_tpl->tpl_vars['occupancy_required_for_booking']->value) {?>
                                                    <td class="booking_occupancy">
                                                        <div class="dropdown">
                                                            <button class="btn btn-default btn-left btn-block booking_guest_occupancy input-occupancy" type="button">
                                                                <span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Select occupancy','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span>
                                                            </button>
                                                            <div class="dropdown-menu booking_occupancy_wrapper well well-sm">
                                                                <input type="hidden" class="max_adults" value="<?php if ((isset($_smarty_tpl->tpl_vars['book_v']->value))) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['book_v']->value['max_adults'], ENT_QUOTES, 'UTF-8', true);
}?>">
                                                                <input type="hidden" class="max_children" value="<?php if ((isset($_smarty_tpl->tpl_vars['book_v']->value))) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['book_v']->value['max_children'], ENT_QUOTES, 'UTF-8', true);
}?>">
                                                                <input type="hidden" class="max_guests" value="<?php if ((isset($_smarty_tpl->tpl_vars['book_v']->value))) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['book_v']->value['max_guests'], ENT_QUOTES, 'UTF-8', true);
}?>">
                                                                <div class="booking_occupancy_inner row">
                                                                    <div class="occupancy_info_block col-sm-12" occ_block_index="0">
                                                                        <div class="occupancy_info_head col-sm-12"><label class="room_num_wrapper"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room - 1','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</label></div>
                                                                        <div class="col-sm-12">
                                                                            <div class="row">
                                                                                <div class="form-group col-xs-6 occupancy_count_block">
                                                                                    <label><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Adults','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</label>
                                                                                    <input type="number" class="form-control num_occupancy num_adults" name="occupancy[0][adults]" value="1" min="1"  data-max="<?php if ((isset($_smarty_tpl->tpl_vars['book_v']->value))) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['book_v']->value['max_adults'], ENT_QUOTES, 'UTF-8', true);
}?>">
                                                                                </div>
                                                                                <div class="form-group col-xs-6 occupancy_count_block">
                                                                                    <label><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Children','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
 <span class="label-desc-txt"></span></label>
                                                                                    <input type="number" class="form-control num_occupancy num_children" name="occupancy[0][children]" value="0" min="0" data-max="<?php if ((isset($_smarty_tpl->tpl_vars['book_v']->value))) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['book_v']->value['max_children'], ENT_QUOTES, 'UTF-8', true);
} else {
echo $_smarty_tpl->tpl_vars['max_child_in_room']->value;
}?>">
                                                                                    (<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Below','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
  <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['max_child_age']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'years','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
)
                                                                                </div>
                                                                            </div>
                                                                            <p style="display:none;"><span class="text-danger occupancy-input-errors"></span></p>
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
                                                                </div>
                                                                                                                            </div>
                                                        </div>
                                                    </td>
                                                <?php }?>
                                                <td>
                                                    <button type="button" data-id-cart="" data-id-cart-book-data="" data-id-product="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['avai_v']->value['id_product'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-id-room="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['avai_v']->value['id_room'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-id-hotel="<?php echo $_smarty_tpl->tpl_vars['avai_v']->value['id_hotel'];?>
" data-date-from="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['date_from']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-date-to ="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['date_to']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" class="btn btn-primary avai_add_cart"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add To Cart','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</button>
                                                </td>
                                            </tr>
                                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="part_room_data_<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['book_k']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" class="tab-pane">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Duration','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                            <th><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room No.','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                            <th><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Allotment Type','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                            <?php if ($_smarty_tpl->tpl_vars['occupancy_required_for_booking']->value) {?>
                                                <th class="fixed-width-xxl"><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Guests','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                            <?php }?>
                                            <th><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Action','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['book_v']->value['data']['partially_available'], 'part_v', false, 'part_k');
$_smarty_tpl->tpl_vars['part_v']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['part_k']->value => $_smarty_tpl->tpl_vars['part_v']->value) {
$_smarty_tpl->tpl_vars['part_v']->do_else = false;
?>
                                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['part_v']->value['rooms'], 'sub_part_v', false, 'sub_part_k');
$_smarty_tpl->tpl_vars['sub_part_v']->index = -1;
$_smarty_tpl->tpl_vars['sub_part_v']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['sub_part_k']->value => $_smarty_tpl->tpl_vars['sub_part_v']->value) {
$_smarty_tpl->tpl_vars['sub_part_v']->do_else = false;
$_smarty_tpl->tpl_vars['sub_part_v']->index++;
$_smarty_tpl->tpl_vars['sub_part_v']->first = !$_smarty_tpl->tpl_vars['sub_part_v']->index;
$__foreach_sub_part_v_9_saved = $_smarty_tpl->tpl_vars['sub_part_v'];
?>
                                                <tr>
                                                    <?php if ($_smarty_tpl->tpl_vars['sub_part_v']->first) {?>
                                                        <?php $_smarty_tpl->_assignInScope('is_full_date', ($_smarty_tpl->tpl_vars['show_full_date']->value && (smarty_modifier_date_format($_smarty_tpl->tpl_vars['part_v']->value['date_from'],'%D') == smarty_modifier_date_format($_smarty_tpl->tpl_vars['part_v']->value['date_to'],'%D'))));?>
                                                        <td rowspan="<?php echo count($_smarty_tpl->tpl_vars['part_v']->value['rooms']);?>
">
                                                            <p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0], array( array('date'=>$_smarty_tpl->tpl_vars['part_v']->value['date_from'],'full'=>$_smarty_tpl->tpl_vars['is_full_date']->value),$_smarty_tpl ) );?>
 - <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0], array( array('date'=>$_smarty_tpl->tpl_vars['part_v']->value['date_to'],'full'=>$_smarty_tpl->tpl_vars['is_full_date']->value),$_smarty_tpl ) );?>
</p>
                                                        </td>
                                                    <?php }?>
                                                    <td ><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['sub_part_v']->value['room_num'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayRoomNumAfter','data'=>$_smarty_tpl->tpl_vars['sub_part_v']->value,'type'=>'partially_available'),$_smarty_tpl ) );?>
</td>
                                                    <td>
                                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['allotment_types']->value, 'allotment_type');
$_smarty_tpl->tpl_vars['allotment_type']->index = -1;
$_smarty_tpl->tpl_vars['allotment_type']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['allotment_type']->value) {
$_smarty_tpl->tpl_vars['allotment_type']->do_else = false;
$_smarty_tpl->tpl_vars['allotment_type']->index++;
$_smarty_tpl->tpl_vars['allotment_type']->first = !$_smarty_tpl->tpl_vars['allotment_type']->index;
$__foreach_allotment_type_10_saved = $_smarty_tpl->tpl_vars['allotment_type'];
?>
                                                            <label class="control-label">
                                                                <input type="radio" value="<?php echo intval($_smarty_tpl->tpl_vars['allotment_type']->value['id_allotment']);?>
" class="par_bk_type" name="bk_type_<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['part_k']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
_<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['sub_part_k']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-id-room="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['sub_part_v']->value['id_room'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-sub-key="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['sub_part_k']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['allotment_type']->first) {?>checked="checked"<?php }?>>
                                                                <span><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['allotment_type']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
                                                            </label>
                                                        <?php
$_smarty_tpl->tpl_vars['allotment_type'] = $__foreach_allotment_type_10_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                                        <input type="text" id="comment_<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['sub_part_v']->value['id_room'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
_<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['sub_part_k']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" name="comment_<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['sub_part_v']->value['id_room'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
_<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['sub_part_k']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" class="form-control booking_type_comment" placeholder="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Allotment message','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
">
                                                    </td>
                                                    <?php if ($_smarty_tpl->tpl_vars['occupancy_required_for_booking']->value) {?>
                                                        <td class="booking_occupancy">
                                                            <div class="dropdown">
                                                                <button class="btn btn-default btn-left btn-block booking_guest_occupancy input-occupancy" type="button">
                                                                    <span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Select occupancy','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span>
                                                                </button>
                                                                <div class="dropdown-menu booking_occupancy_wrapper well well-sm">
                                                                    <input type="hidden" class="max_adults" value="<?php if ((isset($_smarty_tpl->tpl_vars['book_v']->value))) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['book_v']->value['max_adults'], ENT_QUOTES, 'UTF-8', true);
}?>">
                                                                    <input type="hidden" class="max_children" value="<?php if ((isset($_smarty_tpl->tpl_vars['book_v']->value))) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['book_v']->value['max_children'], ENT_QUOTES, 'UTF-8', true);
}?>">
                                                                    <input type="hidden" class="max_guests" value="<?php if ((isset($_smarty_tpl->tpl_vars['book_v']->value))) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['book_v']->value['max_guests'], ENT_QUOTES, 'UTF-8', true);
}?>">
                                                                    <div class="booking_occupancy_inner row">
                                                                        <div class="occupancy_info_block col-sm-12" occ_block_index="0">
                                                                            <div class="occupancy_info_head col-sm-12"><label class="room_num_wrapper"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room - 1','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</label></div>
                                                                            <div class="col-sm-12">
                                                                                <div class="row">
                                                                                    <div class="form-group col-xs-6 occupancy_count_block">
                                                                                        <label><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Adults','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</label>
                                                                                        <input type="number" class="form-control num_occupancy num_adults" name="occupancy[0][adults]" value="1" min="1"  data-max="<?php if ((isset($_smarty_tpl->tpl_vars['book_v']->value))) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['book_v']->value['max_adults'], ENT_QUOTES, 'UTF-8', true);
}?>">
                                                                                    </div>
                                                                                    <div class="form-group col-xs-6 occupancy_count_block">
                                                                                        <label><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Children','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
 <span class="label-desc-txt"></span></label>
                                                                                        <input type="number" class="form-control num_occupancy num_children" name="occupancy[0][children]" value="0" min="0" data-max="<?php if ((isset($_smarty_tpl->tpl_vars['book_v']->value))) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['book_v']->value['max_children'], ENT_QUOTES, 'UTF-8', true);
} else {
echo $_smarty_tpl->tpl_vars['max_child_in_room']->value;
}?>">
                                                                                        (<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Below'),$_smarty_tpl ) );?>
  <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['max_child_age']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'years','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
)
                                                                                    </div>
                                                                                </div>
                                                                                <p style="display:none;"><span class="text-danger occupancy-input-errors"></span></p>
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
                                                                    </div>
                                                                                                                                    </div>
                                                            </div>
                                                        </td>
                                                    <?php }?>
                                                    <td>
                                                        <button type="button" data-id-cart="" data-id-cart-book-data="" data-id-product="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['sub_part_v']->value['id_product'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-id-room="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['sub_part_v']->value['id_room'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-id-hotel="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['sub_part_v']->value['id_hotel'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-date-from="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['part_v']->value['date_from'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-date-to ="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['part_v']->value['date_to'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-sub-key="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['sub_part_k']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" class="btn btn-primary par_add_cart"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add To Cart','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</button>
                                                    </td>
                                                </tr>
                                            <?php
$_smarty_tpl->tpl_vars['sub_part_v'] = $__foreach_sub_part_v_9_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="book_room_data_<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['book_k']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" class="tab-pane">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room No.','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                            <th><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Duration','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                            <th><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Order','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                            <th><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Message','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                            <th><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Allotment Type','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                            <th><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Reallocate','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['book_v']->value['data']['booked'], 'booked_v', false, 'booked_k');
$_smarty_tpl->tpl_vars['booked_v']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['booked_k']->value => $_smarty_tpl->tpl_vars['booked_v']->value) {
$_smarty_tpl->tpl_vars['booked_v']->do_else = false;
?>
                                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['booked_v']->value['detail'], 'rm_dtl_v', false, 'rm_dtl_k');
$_smarty_tpl->tpl_vars['rm_dtl_v']->index = -1;
$_smarty_tpl->tpl_vars['rm_dtl_v']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['rm_dtl_k']->value => $_smarty_tpl->tpl_vars['rm_dtl_v']->value) {
$_smarty_tpl->tpl_vars['rm_dtl_v']->do_else = false;
$_smarty_tpl->tpl_vars['rm_dtl_v']->index++;
$_smarty_tpl->tpl_vars['rm_dtl_v']->first = !$_smarty_tpl->tpl_vars['rm_dtl_v']->index;
$__foreach_rm_dtl_v_12_saved = $_smarty_tpl->tpl_vars['rm_dtl_v'];
?>
                                                <tr>
                                                    <?php $_smarty_tpl->_assignInScope('is_full_date', ($_smarty_tpl->tpl_vars['show_full_date']->value && (smarty_modifier_date_format($_smarty_tpl->tpl_vars['rm_dtl_v']->value['date_from'],'%D') == smarty_modifier_date_format($_smarty_tpl->tpl_vars['rm_dtl_v']->value['date_to'],'%D'))));?>
                                                    <?php if ($_smarty_tpl->tpl_vars['rm_dtl_v']->first) {?>
                                                        <td rowspan="<?php echo count($_smarty_tpl->tpl_vars['booked_v']->value['detail']);?>
"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['booked_v']->value['room_num'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayRoomNumAfter','data'=>$_smarty_tpl->tpl_vars['booked_v']->value,'key'=>$_smarty_tpl->tpl_vars['rm_dtl_k']->value,'type'=>'booked'),$_smarty_tpl ) );?>
</td>
                                                    <?php }?>
                                                    <td><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0], array( array('date'=>$_smarty_tpl->tpl_vars['rm_dtl_v']->value['date_from'],'full'=>$_smarty_tpl->tpl_vars['is_full_date']->value),$_smarty_tpl ) );?>
 - <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0], array( array('date'=>$_smarty_tpl->tpl_vars['rm_dtl_v']->value['date_to'],'full'=>$_smarty_tpl->tpl_vars['is_full_date']->value),$_smarty_tpl ) );?>
</td>
                                                    <td><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminOrders');?>
&id_order=<?php echo intval($_smarty_tpl->tpl_vars['rm_dtl_v']->value['id_order']);?>
&vieworder" target="_blank">#<?php echo $_smarty_tpl->tpl_vars['rm_dtl_v']->value['id_order'];?>
</a></td>
                                                    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['rm_dtl_v']->value['comment'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                                                    <td>
                                                        <?php if ($_smarty_tpl->tpl_vars['rm_dtl_v']->value['booking_type'] == HotelBookingDetail::ALLOTMENT_AUTO) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Auto Allotment','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );
} elseif ($_smarty_tpl->tpl_vars['rm_dtl_v']->value['booking_type'] == HotelBookingDetail::ALLOTMENT_MANUAL) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Manual Allotment','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );
}?>
                                                    </td>
                                                    <td>
                                                        <?php if ($_smarty_tpl->tpl_vars['rm_dtl_v']->value['booking_type'] == HotelBookingDetail::ALLOTMENT_AUTO) {?>
                                                            <button type="button" class="btn btn-primary room_reallocate_swap" id="reallocate_room_<?php echo $_smarty_tpl->tpl_vars['rm_dtl_v']->value['id_htl_booking'];?>
" data-room_type_name="<?php echo $_smarty_tpl->tpl_vars['rm_dtl_v']->value['room_type_name'];?>
" data-id_htl_booking="<?php echo $_smarty_tpl->tpl_vars['rm_dtl_v']->value['id_htl_booking'];?>
" data-id_order="<?php echo $_smarty_tpl->tpl_vars['rm_dtl_v']->value['id_order'];?>
" data-room_num="<?php echo $_smarty_tpl->tpl_vars['booked_v']->value['room_num'];?>
" data-currency_sign="<?php echo $_smarty_tpl->tpl_vars['rm_dtl_v']->value['currency_sign'];?>
" data-id_room_type="<?php echo $_smarty_tpl->tpl_vars['booked_v']->value['id_product'];?>
" data-cust_name="<?php echo $_smarty_tpl->tpl_vars['rm_dtl_v']->value['alloted_cust_name'];?>
" data-cust_email="<?php echo $_smarty_tpl->tpl_vars['rm_dtl_v']->value['alloted_cust_email'];?>
" data-avail_rm_swap='<?php echo json_encode($_smarty_tpl->tpl_vars['rm_dtl_v']->value['avail_rooms_to_swap']);?>
' data-avail_realloc_room_types='<?php echo json_encode($_smarty_tpl->tpl_vars['rm_dtl_v']->value['avail_room_types_to_realloc']);?>
' data-allotment_type_label="<?php if ($_smarty_tpl->tpl_vars['rm_dtl_v']->value['booking_type'] == $_smarty_tpl->tpl_vars['ALLOTMENT_MANUAL']->value) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Manual'),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Auto'),$_smarty_tpl ) );
}?>" data-comment="<?php echo $_smarty_tpl->tpl_vars['rm_dtl_v']->value['comment'];?>
">
                                                                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Reallocate Room','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>

                                                            </button>
                                                        <?php } else { ?>
                                                            --
                                                        <?php }?>
                                                    </td>
                                                </tr>
                                            <?php
$_smarty_tpl->tpl_vars['rm_dtl_v'] = $__foreach_rm_dtl_v_12_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="unavail_room_data_<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['book_k']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" class="tab-pane">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room No.','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                            <th><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Status','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                            <th><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Duration','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                            <th><span class="title_box"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Message','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['book_v']->value['data']['unavailable'], 'unavai_v', false, 'unavai_k');
$_smarty_tpl->tpl_vars['unavai_v']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['unavai_k']->value => $_smarty_tpl->tpl_vars['unavai_v']->value) {
$_smarty_tpl->tpl_vars['unavai_v']->do_else = false;
?>
                                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['unavai_v']->value['detail'], 'unavail_dtl_v', false, 'rm_dtl_k');
$_smarty_tpl->tpl_vars['unavail_dtl_v']->index = -1;
$_smarty_tpl->tpl_vars['unavail_dtl_v']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['rm_dtl_k']->value => $_smarty_tpl->tpl_vars['unavail_dtl_v']->value) {
$_smarty_tpl->tpl_vars['unavail_dtl_v']->do_else = false;
$_smarty_tpl->tpl_vars['unavail_dtl_v']->index++;
$_smarty_tpl->tpl_vars['unavail_dtl_v']->first = !$_smarty_tpl->tpl_vars['unavail_dtl_v']->index;
$__foreach_unavail_dtl_v_14_saved = $_smarty_tpl->tpl_vars['unavail_dtl_v'];
?>
                                                <tr>
                                                    <?php if ($_smarty_tpl->tpl_vars['unavail_dtl_v']->first) {?>
                                                        <td rowspan="<?php echo count($_smarty_tpl->tpl_vars['unavai_v']->value['detail']);?>
"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['unavai_v']->value['room_num'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                                                    <?php }?>
                                                    <td><?php echo mb_convert_encoding(htmlspecialchars(HotelRoomInformation::getRoomStatusTitle($_smarty_tpl->tpl_vars['unavail_dtl_v']->value['id_status']), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                                                    <td>
                                                        <?php if ($_smarty_tpl->tpl_vars['unavail_dtl_v']->value['date_from'] && $_smarty_tpl->tpl_vars['unavail_dtl_v']->value['date_to']) {?>
                                                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0], array( array('date'=>$_smarty_tpl->tpl_vars['unavail_dtl_v']->value['date_from']),$_smarty_tpl ) );?>
 - <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0], array( array('date'=>$_smarty_tpl->tpl_vars['unavail_dtl_v']->value['date_to']),$_smarty_tpl ) );?>

                                                        <?php } else { ?>
                                                            --
                                                        <?php }?>
                                                    </td>
                                                    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['unavail_dtl_v']->value['room_comment'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                                                </tr>
                                            <?php
$_smarty_tpl->tpl_vars['unavail_dtl_v'] = $__foreach_unavail_dtl_v_14_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
$_smarty_tpl->tpl_vars['book_v'] = $__foreach_book_v_5_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </div>
    </div>
</div>
<?php }
}
