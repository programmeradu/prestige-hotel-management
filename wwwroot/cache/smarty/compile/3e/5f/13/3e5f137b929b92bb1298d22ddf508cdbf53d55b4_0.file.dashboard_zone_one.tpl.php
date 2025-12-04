<?php
/* Smarty version 3.1.39, created on 2025-07-09 08:49:58
  from '/www/wwwroot/prestigehotel.org/modules/dashoccupancy/views/templates/hook/dashboard_zone_one.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686e2d36321ad9_00522346',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3e5f137b929b92bb1298d22ddf508cdbf53d55b4' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/dashoccupancy/views/templates/hook/dashboard_zone_one.tpl',
      1 => 1741272618,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686e2d36321ad9_00522346 (Smarty_Internal_Template $_smarty_tpl) {
?>
<section id="dashoccupancy" class="panel widget allow_push">
	<header class="panel-heading">
		<i class="icon-bar-chart"></i>
		<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Occupancy','mod'=>'dashoccupancy'),$_smarty_tpl ) );?>
&nbsp;<small class='text-muted' id='dashoccupancy_date_range'></small></span>
        &nbsp;<i class="icon-info-circle label-tooltip" data-toggle="tooltip" data-original-title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Occupancy information will be displayed by considering the selected date range as Check-in and Check-out dates.','mod'=>'dashoccupancy'),$_smarty_tpl ) );?>
"></i>
		<span class="panel-heading-action">
			<a class="list-toolbar-btn" href="javascript:void(0);" title="Refresh" onclick="refreshDashboard('dashoccupancy'); return false;">
				<i class="process-icon-refresh"></i>
			</a>
		</span>
	</header>
	<div class="row text-center avil-chart-head">
		<div class="col-md-4 col-xs-4">
			<div class="row">
				<div class="col-md-11 label-tooltip col-lg-11 avail-pie-label-container" style="background: #A569DF;"  data-toggle="tooltip" data-original-title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'The total number of rooms booked for date range out of total number of rooms.','mod'=>'dashoccupancy'),$_smarty_tpl ) );?>
">
					<div class="">
						<p class="avail-pie-text">
							<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Occupied','mod'=>'dashoccupancy'),$_smarty_tpl ) );?>

						</p>
						<div class="avail-pie-value-container">
							<p class="avail-pie-value">
								<span id="do_count_occupied"></span>/<span id="do_count_total"></span>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-xs-4">
			<div class="row">
				<div class="col-md-11 col-lg-11 avail-pie-label-container label-tooltip" style="background: #56CE56;" data-toggle="tooltip" data-original-title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'The total number of rooms available for booking for date range.','mod'=>'dashoccupancy'),$_smarty_tpl ) );?>
">
					<div class="">
						<p class="avail-pie-text">
							<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Available','mod'=>'dashoccupancy'),$_smarty_tpl ) );?>

						</p>
						<div class="avail-pie-value-container">
							<p class="avail-pie-value" id="pie_avail_text">
								<span id="do_count_available"></span>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-xs-4">
			<div class="row">
				<div class="col-md-11 col-lg-11 avail-pie-label-container label-tooltip" style="background: #FF655C;" data-toggle="tooltip" data-original-title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'The total number of rooms unavailable for booking for date range.','mod'=>'dashoccupancy'),$_smarty_tpl ) );?>
">
					<div class="">
						<p class="avail-pie-text">
							<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Unavailable','mod'=>'dashoccupancy'),$_smarty_tpl ) );?>

						</p>
						<div class="avail-pie-value-container">
							<p class="avail-pie-value" id="pie_inactive_text">
								<span id="do_count_unavailable"></span>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="avil-chart-svg" id="availablePieChart">
		<svg></svg>
	</div>
</section>
<?php }
}
