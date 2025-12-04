<?php
/* Smarty version 3.1.39, created on 2025-07-09 08:49:58
  from '/www/wwwroot/prestigehotel.org/modules/dashguestcycle/views/templates/hook/dashboard-zone-two.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686e2d36410f20_92945049',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bcab868e67aeb79f2860608e210bc6a8f11fe3ea' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/dashguestcycle/views/templates/hook/dashboard-zone-two.tpl',
      1 => 1741272617,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686e2d36410f20_92945049 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="col-sm-12">
    <section id="dashguestcycle" class="panel widget allow_push">
        <header class="panel-heading">
            <i class="icon-bar-chart"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Operations Today','mod'=>'dashguestcycle'),$_smarty_tpl ) );?>

            <span class="panel-heading-action">
                <a class="list-toolbar-btn" href="#" onclick="refreshDashboard('dashguestcycle'); return false;"
                    title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Refresh','mod'=>'dashguestcycle'),$_smarty_tpl ) );?>
">
                    <i class="process-icon-refresh"></i>
                </a>
            </span>
        </header>

        <section>
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#dgc_current_arrivals" data-toggle="tab">
                        <span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Arrivals','mod'=>'dashguestcycle'),$_smarty_tpl ) );?>
</span>
                        <span class="label label-info" id="dgc_count_upcoming_arrivals">0</span>
                    </a>
                </li>
                <li>
                    <a href="#dgc_current_departures" data-toggle="tab">
                        <span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Departures','mod'=>'dashguestcycle'),$_smarty_tpl ) );?>
</span>
                        <span class="label label-info" id="dgc_count_upcoming_departures">0</span>
                    </a>
                </li>
                <li>
                    <a href="#dgc_current_in_house" data-toggle="tab">
                        <span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'In-house','mod'=>'dashguestcycle'),$_smarty_tpl ) );?>
</span>
                        <span class="label label-info" id="dgc_count_current_in_house">0</span>
                    </a>
                </li>
                <li>
                    <a href="#dgc_current_new_bookings" data-toggle="tab">
                        <span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'New Bookings','mod'=>'dashguestcycle'),$_smarty_tpl ) );?>
</span>
                        <span class="label label-info" id="dgc_count_new_bookings">0</span>
                    </a>
                </li>
                <li>
                    <a href="#dgc_current_cancellations" data-toggle="tab">
                        <span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Cancellations','mod'=>'dashguestcycle'),$_smarty_tpl ) );?>
</span>
                        <span class="label label-info" id="dgc_count_cancellations">0</span>
                    </a>
                </li>
                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayDashGuestCycleTab'),$_smarty_tpl ) );?>

            </ul>

            <div class="tab-content panel panel-sm">
                <div class="tab-pane active" id="dgc_current_arrivals">
                    <table class="table table-striped" id="dgc_table_current_arrivals">
                        <thead></thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="tab-pane" id="dgc_current_departures">
                    <table class="table table-striped" id="dgc_table_current_departures">
                        <thead></thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="tab-pane" id="dgc_current_in_house">
                    <table class="table table-striped" id="dgc_table_current_in_house">
                        <thead></thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="tab-pane" id="dgc_current_new_bookings">
                    <table class="table table-striped" id="dgc_table_new_bookings">
                        <thead></thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="tab-pane" id="dgc_current_cancellations">
                    <table class="table table-striped" id="dgc_table_cancellations">
                        <thead></thead>
                        <tbody></tbody>
                    </table>
                </div>
                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayDashGuestCycleTabContent'),$_smarty_tpl ) );?>

            </div>
        </section>
    </section>
</div>
<div class="clearfix"></div>
<?php }
}
