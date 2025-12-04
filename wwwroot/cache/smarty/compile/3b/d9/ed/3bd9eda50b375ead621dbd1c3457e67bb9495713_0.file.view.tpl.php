<?php
/* Smarty version 3.1.39, created on 2025-03-12 17:33:42
  from '/home/site/wwwroot/modules/hotelreservationsystem/views/templates/admin/hotel_configuration_setting/helpers/view/view.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d1c5763de529_32961136',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3bd9eda50b375ead621dbd1c3457e67bb9495713' => 
    array (
      0 => '/home/site/wwwroot/modules/hotelreservationsystem/views/templates/admin/hotel_configuration_setting/helpers/view/view.tpl',
      1 => 1741272626,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67d1c5763de529_32961136 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="panel htl_conf_panel">
	<h3 class="tab"> <i class="icon-cogs"></i>&nbsp;&nbsp; <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Hotel Configuration','mod'=>'hotelreservationsystem'),$_smarty_tpl ) );?>
</h3>
	<div class="panel-body">
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['settings_links']->value, 'settings_link');
$_smarty_tpl->tpl_vars['settings_link']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['settings_link']->value) {
$_smarty_tpl->tpl_vars['settings_link']->do_else = false;
?>
			<div class="btn-group setting-link-div col-sm-3 col-xs-12">
				<a type="button" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings_link']->value['generated_link'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['settings_link']->value['new_window']) {?>target="_blank"<?php }?> class="setting-link btn btn-default col-sm-10 col-xs-10">
					<span class="col-sm-2 col-xs-2"><i class="<?php echo $_smarty_tpl->tpl_vars['settings_link']->value['icon'];?>
"></i></span>
					<span class="setting-title col-sm-10 col-xs-10"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings_link']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</span>
				</a>
				<a tabindex="0" class="btn btn-default col-sm-2 col-xs-2" role="button" data-toggle="popover" data-trigger="focus" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings_link']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" data-content="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings_link']->value['hint'], ENT_QUOTES, 'UTF-8', true);?>
" data-placement="bottom">
					<i class="icon-question-circle"></i>
				</a>
			</div>
		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayAddModuleSettingLink'),$_smarty_tpl ) );?>

	</div>
</div>
<?php }
}
