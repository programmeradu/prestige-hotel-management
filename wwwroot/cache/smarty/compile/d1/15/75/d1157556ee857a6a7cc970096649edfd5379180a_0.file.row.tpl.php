<?php
/* Smarty version 3.1.39, created on 2025-03-13 10:41:24
  from '/home/site/wwwroot/admin033aqbbsn/themes/default/template/helpers/kpi/row.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d2b654461565_06080284',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd1157556ee857a6a7cc970096649edfd5379180a' => 
    array (
      0 => '/home/site/wwwroot/admin033aqbbsn/themes/default/template/helpers/kpi/row.tpl',
      1 => 1741862385,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67d2b654461565_06080284 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="panel kpi-container<?php if ((isset($_smarty_tpl->tpl_vars['no_wrapping']->value)) && $_smarty_tpl->tpl_vars['no_wrapping']->value) {?> no-wrapping<?php }?>">
	<div class="kpis-wrap">
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['kpis']->value, 'kpi');
$_smarty_tpl->tpl_vars['kpi']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['kpi']->value) {
$_smarty_tpl->tpl_vars['kpi']->do_else = false;
?>
			<div class="kpi-wrap"<?php if ((isset($_smarty_tpl->tpl_vars['kpi']->value->visible)) && !$_smarty_tpl->tpl_vars['kpi']->value->visible) {?>style="display: none;"<?php }?>>
				<?php echo $_smarty_tpl->tpl_vars['kpi']->value->generate();?>

			</div>
		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	</div>

	<div class="actions-wrap">
		<?php if ($_smarty_tpl->tpl_vars['refresh']->value) {?>
			<button class="btn btn-default" type="button" onclick="refresh_kpis();" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Refresh'),$_smarty_tpl ) );?>
">
				<i class="icon-refresh"></i>
			</button>
		<?php }?>

		<div class="dropdown">
			<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Select KPIs'),$_smarty_tpl ) );?>
">
				<i class="icon-ellipsis-vertical"></i>
			</button>

			<ul class="dropdown-menu">
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['kpis']->value, 'kpi');
$_smarty_tpl->tpl_vars['kpi']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['kpi']->value) {
$_smarty_tpl->tpl_vars['kpi']->do_else = false;
?>
					<li>
						<label>
							<input type="checkbox" class="kpi-display-toggle" data-kpi-id="<?php echo $_smarty_tpl->tpl_vars['kpi']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['kpi']->value->visible) {?>checked <?php if ($_smarty_tpl->tpl_vars['count_visible']->value == 1) {?>disabled<?php }
}?>>
							<?php echo $_smarty_tpl->tpl_vars['kpi']->value->title;?>

						</label>
					</li>
				<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			</ul>
		</div>

		<button class="btn btn-default" type="button" onclick="toggleKpiView();" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Toggle View'),$_smarty_tpl ) );?>
">
			<i class="icon-retweet"></i>
		</button>
	</div>
</div>
<?php }
}
