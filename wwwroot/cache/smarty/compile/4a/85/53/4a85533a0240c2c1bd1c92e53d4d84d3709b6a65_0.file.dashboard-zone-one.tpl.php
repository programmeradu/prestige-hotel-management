<?php
/* Smarty version 3.1.39, created on 2025-07-09 08:49:58
  from '/www/wwwroot/prestigehotel.org/modules/dashinsights/views/templates/hook/dashboard-zone-one.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686e2d3633f1d1_27523483',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4a85533a0240c2c1bd1c92e53d4d84d3709b6a65' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/dashinsights/views/templates/hook/dashboard-zone-one.tpl',
      1 => 1741272617,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686e2d3633f1d1_27523483 (Smarty_Internal_Template $_smarty_tpl) {
?>
<section id="dashinsights" class="widget allow_push">
    <div class="panel">
        <div class="panel-heading">
            <i class="icon-area-chart"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Insights",'mod'=>'dashinsights'),$_smarty_tpl ) );?>

            <span><small class="text-muted" id="dashinsights_heading_zone_one"></small></span>
            <span class="panel-heading-action">
                <a class="list-toolbar-btn" href="#" onclick="refreshDashboard('dashinsights'); return false;" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Refresh",'mod'=>'dashinsights'),$_smarty_tpl ) );?>
">
                    <i class="process-icon-refresh"></i>
                </a>
            </span>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <p class="chart-label"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Length of Stay (%)','mod'=>'dashinsights'),$_smarty_tpl ) );?>
</p>
                <div class="chart with-transitions insight-chart-wrap" id="dashinsights_length_of_stay">
                    <svg></svg>
                </div>
            </div>
        </div>
    </div>
</section>
<?php }
}
