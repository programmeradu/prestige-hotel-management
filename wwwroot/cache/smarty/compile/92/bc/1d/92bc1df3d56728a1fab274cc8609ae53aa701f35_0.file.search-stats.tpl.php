<?php
/* Smarty version 3.1.39, created on 2025-07-08 14:46:28
  from '/www/wwwroot/prestigehotel.org/modules/hotelreservationsystem/views/templates/admin/hotel_rooms_booking/helpers/view/_partials/search-stats.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686d2f44720eb9_33516015',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '92bc1df3d56728a1fab274cc8609ae53aa701f35' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/hotelreservationsystem/views/templates/admin/hotel_rooms_booking/helpers/view/_partials/search-stats.tpl',
      1 => 1741272628,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686d2f44720eb9_33516015 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="htl_room_data_cont">
    <div class="status-info-tooltip" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Due to the dynamic nature of room availability, a single room can fall under multiple categories in the stats panel. For example, if a room is booked from 1st to 3th and then marked as unavailable for maintenance on 4th to 5th, it would be counted in both the "Booked Rooms" and "Unavailable Rooms" categories for those respective dates if search is done from 1st to 6th. This allows admin to understand the room\'s status across different periods accurately.','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
">
        <i class="icon-info-circle"></i>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-12 htl_room_cat_data">
                    <p class="room_cat_header"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total Rooms','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</p>
                    <p class="room_cat_data"><?php if ((isset($_smarty_tpl->tpl_vars['booking_data']->value)) && $_smarty_tpl->tpl_vars['booking_data']->value) {
echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['booking_data']->value['stats']['total_rooms'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');
} else { ?>00<?php }?></p>
                </div>
            </div>
            <hr class="hr_style" />
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-12 htl_room_cat_data">
                    <p class="room_cat_header"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Available Rooms','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</p>
                    <p class="room_cat_data" id="num_avail"><?php if ((isset($_smarty_tpl->tpl_vars['booking_data']->value)) && $_smarty_tpl->tpl_vars['booking_data']->value) {
echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['booking_data']->value['stats']['num_avail'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');
} else { ?>00<?php }?></p>
                </div>
            </div>
            <hr class="hr_style" />
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-12 htl_room_cat_data">
                    <p class="room_cat_header"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Partially Available','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</p>
                    <p class="room_cat_data" id="num_part"><?php if ((isset($_smarty_tpl->tpl_vars['booking_data']->value)) && $_smarty_tpl->tpl_vars['booking_data']->value) {
echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['booking_data']->value['stats']['num_part_avai'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');
} else { ?>00<?php }?></p>
                </div>
            </div>
            <hr class="hr_style" />
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-12 htl_room_cat_data">
                    <p class="room_cat_header"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Booked Rooms','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</p>
                    <p class="room_cat_data"><?php if ((isset($_smarty_tpl->tpl_vars['booking_data']->value)) && $_smarty_tpl->tpl_vars['booking_data']->value) {
echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['booking_data']->value['stats']['num_booked'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');
} else { ?>00<?php }?></p>
                </div>
            </div>
            <hr class="hr_style" />
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-12 htl_room_cat_data">
                    <p class="room_cat_header"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Unavailable Rooms','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</p>
                    <p class="room_cat_data"><?php if ((isset($_smarty_tpl->tpl_vars['booking_data']->value)) && $_smarty_tpl->tpl_vars['booking_data']->value) {
echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['booking_data']->value['stats']['num_unavail'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');
} else { ?>00<?php }?></p>
                </div>
            </div>
            <hr class="hr_style" />
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-12 htl_room_cat_data">
                    <p class="room_cat_header"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'In-Cart Rooms','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</p>
                    <p class="room_cat_data" id="cart_stats"><?php if ((isset($_smarty_tpl->tpl_vars['booking_data']->value)) && $_smarty_tpl->tpl_vars['booking_data']->value) {
echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['booking_data']->value['stats']['num_cart'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');
} else { ?>00<?php }?></p>
                </div>
            </div>
            <hr class="hr_style" />
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 indi_cont clearfix">
            <span class="color_indicate bg-green"></span>
            <span class="indi_label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Available Rooms','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span>
        </div>
        <div class="col-sm-6 indi_cont clearfix">
            <span class="color_indicate bg-yellow"></span>
            <span class="indi_label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Partially Available','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span>
        </div>
        <div class="col-sm-6 indi_cont clearfix">
            <span class="color_indicate bg-red"></span>
            <span class="indi_label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Unavailable Rooms','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span>
        </div>
        <div class="col-sm-6 indi_cont clearfix">
            <span class="color_indicate bg-blue"></span>
            <span class="indi_label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Booked Rooms','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</span>
        </div>
    </div>
</div><?php }
}
