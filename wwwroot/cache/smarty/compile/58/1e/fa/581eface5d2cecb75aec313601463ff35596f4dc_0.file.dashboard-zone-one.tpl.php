<?php
/* Smarty version 3.1.39, created on 2025-03-11 17:01:43
  from '/home/site/wwwroot/modules/dashinsights/views/templates/hook/dashboard-zone-one.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d06c77d7b0b5_57270198',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '581eface5d2cecb75aec313601463ff35596f4dc' => 
    array (
      0 => '/home/site/wwwroot/modules/dashinsights/views/templates/hook/dashboard-zone-one.tpl',
      1 => 1741272616,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67d06c77d7b0b5_57270198 (Smarty_Internal_Template $_smarty_tpl) {
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
