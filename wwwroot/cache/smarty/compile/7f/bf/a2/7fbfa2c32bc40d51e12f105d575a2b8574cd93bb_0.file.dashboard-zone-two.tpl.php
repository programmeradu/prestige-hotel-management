<?php
/* Smarty version 3.1.39, created on 2025-03-11 17:01:44
  from '/home/site/wwwroot/modules/dashinsights/views/templates/hook/dashboard-zone-two.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d06c789299c0_71920073',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7fbfa2c32bc40d51e12f105d575a2b8574cd93bb' => 
    array (
      0 => '/home/site/wwwroot/modules/dashinsights/views/templates/hook/dashboard-zone-two.tpl',
      1 => 1741272616,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67d06c789299c0_71920073 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="col-sm-12">
    <section id="dashinsights" class="panel widget allow_push">
        <header class="panel-heading">
            <i class="icon-area-chart"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Insights','mod'=>'dashinsights'),$_smarty_tpl ) );?>

            <span><small class="text-muted" id="dashinsights_heading_zone_two"></small></span>
            <span class="panel-heading-action">
                <a class="list-toolbar-btn" href="#" onclick="refreshDashboard('dashinsights'); return false;" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Refresh','mod'=>'dashinsights'),$_smarty_tpl ) );?>
">
                    <i class="process-icon-refresh"></i>
                </a>
            </span>
        </header>

        <section>
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <p class="chart-label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Room Nights','mod'=>'dashinsights'),$_smarty_tpl ) );?>
</p>
                    <div class="chart with-transitions insight-chart-wrap" id="dashinsights_room_nights">
                        <svg></svg>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <p class="chart-label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Days of the Week','mod'=>'dashinsights'),$_smarty_tpl ) );?>
</p>
                    <div class="chart with-transitions insight-chart-wrap" id="dashinsights_days_of_the_week">
                        <svg></svg>
                    </div>
                </div>
            </div>
        </section>
    </section>
</div>
<div class="clearfix"></div>
<?php }
}
