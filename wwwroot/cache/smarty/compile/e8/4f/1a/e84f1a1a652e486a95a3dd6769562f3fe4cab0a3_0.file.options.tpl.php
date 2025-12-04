<?php
/* Smarty version 3.1.39, created on 2025-03-12 17:33:47
  from '/home/site/wwwroot/modules/hotelreservationsystem/views/templates/admin/hotel_feature_prices_settings/helpers/options/options.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d1c57b91cbb1_80354645',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e84f1a1a652e486a95a3dd6769562f3fe4cab0a3' => 
    array (
      0 => '/home/site/wwwroot/modules/hotelreservationsystem/views/templates/admin/hotel_feature_prices_settings/helpers/options/options.tpl',
      1 => 1741272626,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67d1c57b91cbb1_80354645 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="panel">
	<h3><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Priority management','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</h3>
	<div class="alert alert-info">
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Sometimes one customer can fit into multiple advanced price rules. In this case priorities allow you to define which rule applies to the room type.','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>

	</div>
	<form id="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['table']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
_form" class="defaultForm form-horizontal" action="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['current']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&<?php if (!empty($_smarty_tpl->tpl_vars['submit_action']->value)) {
echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['submit_action']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');
}?>&token=<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" method="post" enctype="multipart/form-data" <?php if ((isset($_smarty_tpl->tpl_vars['style']->value))) {?>style="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['style']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>
		<div class="form-group">
			<label class="control-label col-lg-3" for="featurePricePriority"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Advanced Price Calculation Priorities','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
 :: </label>
			<div class="input-group col-lg-9">
				<select name="featurePricePriority[]" class="featurePricePriority">
					<option class="specific_date" value="specific_date" <?php if ((isset($_smarty_tpl->tpl_vars['featurePricePriority']->value)) && $_smarty_tpl->tpl_vars['featurePricePriority']->value[0] == 'specific_date') {?>selected="selected"<?php }?>><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Specific Date",'mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</option>
					<option class="special_day" value="special_day" <?php if ((isset($_smarty_tpl->tpl_vars['featurePricePriority']->value)) && $_smarty_tpl->tpl_vars['featurePricePriority']->value[0] == 'special_day') {?>selected="selected"<?php }?>><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Special Days",'mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</option>
					<option class="date_range" value="date_range" <?php if ((isset($_smarty_tpl->tpl_vars['featurePricePriority']->value)) && $_smarty_tpl->tpl_vars['featurePricePriority']->value[0] == 'date_range') {?>selected="selected"<?php }?>><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Date Ranges",'mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</option>
				</select>
				<span class="input-group-addon"><i class="icon-chevron-right"></i></span>
				<select name="featurePricePriority[]" class="featurePricePriority">
					<option class="specific_date" value="specific_date" <?php if ((isset($_smarty_tpl->tpl_vars['featurePricePriority']->value)) && $_smarty_tpl->tpl_vars['featurePricePriority']->value[1] == 'specific_date') {?>selected="selected"<?php }?>><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Specific Date",'mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</option>
					<option class="special_day" value="special_day" <?php if ((isset($_smarty_tpl->tpl_vars['featurePricePriority']->value)) && $_smarty_tpl->tpl_vars['featurePricePriority']->value[1] == 'special_day') {?>selected="selected"<?php }?>><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Special Days",'mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</option>
					<option class="date_range" value="date_range" <?php if ((isset($_smarty_tpl->tpl_vars['featurePricePriority']->value)) && $_smarty_tpl->tpl_vars['featurePricePriority']->value[1] == 'date_range') {?>selected="selected"<?php }?>><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Date Ranges",'mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</option>
				</select>
				<span class="input-group-addon"><i class="icon-chevron-right"></i></span>
				<select name="featurePricePriority[]" class="featurePricePriority">
					<option class="specific_date" value="specific_date" <?php if ((isset($_smarty_tpl->tpl_vars['featurePricePriority']->value)) && $_smarty_tpl->tpl_vars['featurePricePriority']->value[2] == 'specific_date') {?>selected="selected"<?php }?>><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Specific Date",'mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</option>
					<option class="special_day" value="special_day" <?php if ((isset($_smarty_tpl->tpl_vars['featurePricePriority']->value)) && $_smarty_tpl->tpl_vars['featurePricePriority']->value[2] == 'special_day') {?>selected="selected"<?php }?>><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Special Days",'mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</option>
					<option class="date_range" value="date_range" <?php if ((isset($_smarty_tpl->tpl_vars['featurePricePriority']->value)) && $_smarty_tpl->tpl_vars['featurePricePriority']->value[2] == 'date_range') {?>selected="selected"<?php }?>><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Date Ranges",'mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</option>
				</select>
			</div>
		</div>
		<div class="panel-footer">
			<button type="submit" name="submitAddFeaturePricePriority" class="btn btn-default pull-right">
				<i class="process-icon-save"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Save','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>

			</button>
		</div>
	</form>
</div>
<?php }
}
