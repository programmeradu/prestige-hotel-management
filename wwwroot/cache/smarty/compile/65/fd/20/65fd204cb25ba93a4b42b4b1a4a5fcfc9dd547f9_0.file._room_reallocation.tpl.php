<?php
/* Smarty version 3.1.39, created on 2025-05-07 15:36:40
  from '/www/wwwroot/prestigehotel.org/admin033aqbbsn/themes/default/template/controllers/orders/modals/_room_reallocation.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_681b7e08542715_80266828',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '65fd204cb25ba93a4b42b4b1a4a5fcfc9dd547f9' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/admin033aqbbsn/themes/default/template/controllers/orders/modals/_room_reallocation.tpl',
      1 => 1741272494,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_681b7e08542715_80266828 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="modal-body">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a  href="#reallocate_room_tab" aria-controls="reallocate" role="tab" data-toggle="tab"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room Reallocation'),$_smarty_tpl ) );?>
</a>
        </li>
        <li role="presentation">
            <a  href="#swap_room_tab" aria-controls="swap" role="tab" data-toggle="tab"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Swap Room'),$_smarty_tpl ) );?>
</a>
        </li>
    </ul>
    <div class="tab-content active">
        <div role="tabpanel" class="tab-pane active" id="reallocate_room_tab">
            <div class="row">
                <dl class="list-detail col-sm-6">
                    <label class="label-title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Current Room Number'),$_smarty_tpl ) );?>
</label>
                    <dd><i class="icon-bed"></i> &nbsp;<span class="modal_curr_room_num"></span></dd>
                </dl>
                <dl class="list-detail col-sm-6">
                    <label class="label-title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Allotment type'),$_smarty_tpl ) );?>
</label>
                    <dd><span class="modal_curr_allotent_type"></span></dd>
                </dl>
            </div>
            <div class="row">
                <dl class="list-detail col-sm-6">
                    <label class="label-title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Currently Alloted Customer'),$_smarty_tpl ) );?>
</label>
                    <dd><i class="icon-user"></i> &nbsp;<span class="cust_name"></span></dd>
                    <dd><i class="icon-envelope"></i> &nbsp;<span class="cust_email"></span></dd>
                </dl>
                <dl class="list-detail col-sm-6 allotment_comment_block">
                    <label class="label-title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Allotment Comment'),$_smarty_tpl ) );?>
</label>
                    <dd><span class="modal_curr_allotment_comment"></span></dd>
                </dl>
            </div>

            <hr>
            <form class="form-hozizontal" method="post" action="<?php echo $_smarty_tpl->tpl_vars['reallocate_form_action']->value;?>
">
                <div class="form-group">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="realloc_avail_room_type" class="control-label model-label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room Type To Reallocate:'),$_smarty_tpl ) );?>
</label>
                            <input type="hidden" class="form-control modal_id_htl_booking" name="id_htl_booking">
                            <div class="realloc_avail_room_type_container">
                                <select class="form-control" name="realloc_avail_room_type" id="realloc_avail_room_type">
                                    <option value="0" selected="selected"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Select Room Type'),$_smarty_tpl ) );?>
</option>
                                </select>
                            </div>
                            <p class="error_text" id="realloc_sel_rm_type_err_p"></p>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="realloc_avail_rooms" class="control-label model-label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room To Reallocate:'),$_smarty_tpl ) );?>
</label>
                            <div class="realloc_avail_rooms_container">
                                <select class="form-control" name="realloc_avail_rooms" id="realloc_avail_rooms">
                                    <option value="0" selected="selected"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Select Rooms'),$_smarty_tpl ) );?>
</option>
                                </select>
                            </div>
                            <p class="error_text" id="realloc_sel_rm_err_p"></p>
                        </div>
                    </div>
                    <div class="row" id="reallocation_price_diff_block" style="display:none;">
                        <div class="form-group col-sm-6">
                            <label for="reallocation_price_diff" class="control-label model-label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Price Difference'),$_smarty_tpl ) );?>
 *</label>
                            <div class="input-group">
                                <span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['currency']->value->prefix;
echo $_smarty_tpl->tpl_vars['currency']->value->suffix;?>
</span>
                                <input class="alert-warning" type="text" name="reallocation_price_diff" id="reallocation_price_diff" value="0" />
                                <span class="input-group-addon"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Tax excl.'),$_smarty_tpl ) );?>
</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="alert alert-warning col-sm-12 realloc_roomtype_change_message" style="display:none">
                            <p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"If room type is changed while room reallocation then all additional facilities and services will be assigned to the selected room of new room type."),$_smarty_tpl ) );?>
</p>
                            <p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"If you want to change additional facilities or services, you can update by editing the room after reallocation."),$_smarty_tpl ) );?>
</p>
                        </div>
                    </div>
                    <p class="error_text" id="realloc_sel_rm_err_p"></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-close" data-dismiss="modal"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Close"),$_smarty_tpl ) );?>
</button>
                    <button type="submit" id="realloc_allocated_rooms" name="realloc_allocated_rooms" class="btn btn-primary" value="Reallocate"><i class="icon icon-refresh"></i> &nbsp;<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Reallocate"),$_smarty_tpl ) );?>
</button>
                </div>
            </form>
        </div>
        <div role="tabpanel" class="tab-pane" id="swap_room_tab">
            <div class="row">
                <dl class="list-detail col-sm-6">
                    <label class="label-title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Current Room Number'),$_smarty_tpl ) );?>
</label>
                    <dd><i class="icon-bed"></i> &nbsp;<span class="modal_curr_room_num"></span></dd>
                </dl>
                <dl class="list-detail col-sm-6">
                    <label class="label-title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Allotment type'),$_smarty_tpl ) );?>
</label>
                    <dd><span class="modal_curr_allotent_type"></span></dd>
                </dl>
            </div>
            <div class="row">
                <dl class="list-detail col-sm-6">
                    <label class="label-title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Currently Alloted Customer'),$_smarty_tpl ) );?>
</label>
                    <dd><i class="icon-user"></i> &nbsp;<span class="cust_name"></span></dd>
                    <dd><i class="icon-envelope"></i> &nbsp;<span class="cust_email"></span></dd>
                </dl>
                <dl class="list-detail col-sm-6 allotment_comment_block">
                    <label class="label-title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Allotment Comment'),$_smarty_tpl ) );?>
</label>
                    <dd><span class="modal_curr_allotment_comment"></span></dd>
                </dl>
            </div>
            <hr>
            <form method="post" action="<?php echo $_smarty_tpl->tpl_vars['reallocate_form_action']->value;?>
">
                <div class="form-group">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="swap_avail_rooms" class="control-label model-label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Available rooms to swap'),$_smarty_tpl ) );?>
</label>
                            <input type="hidden" class="form-control modal_id_htl_booking" name="id_htl_booking">
                            <div class="swap_avail_rooms_container"></div>

                            <p class="error_text" id="swap_sel_rm_err_p"></p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-close" data-dismiss="modal"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Close"),$_smarty_tpl ) );?>
</button>
                    <button type="submit" id="swap_allocated_rooms" name="swap_allocated_rooms" class="btn btn-primary" value="Swap"><i class="icon icon-refresh"></i> &nbsp;<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Swap"),$_smarty_tpl ) );?>
</button>
                </div>
            </form>
        </div>
    </div>

        <?php if ((isset($_smarty_tpl->tpl_vars['loaderImg']->value)) && $_smarty_tpl->tpl_vars['loaderImg']->value) {?>
        <div class="loading_overlay">
            <img src='<?php echo $_smarty_tpl->tpl_vars['loaderImg']->value;?>
' class="loading-img"/>
        </div>
    <?php }?>
</div>
<?php }
}
