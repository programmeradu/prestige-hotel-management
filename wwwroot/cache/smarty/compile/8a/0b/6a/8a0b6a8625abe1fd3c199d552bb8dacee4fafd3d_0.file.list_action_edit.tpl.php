<?php
/* Smarty version 3.1.39, created on 2025-07-08 16:49:55
  from '/www/wwwroot/prestigehotel.org/admin033aqbbsn/themes/default/template/controllers/tax_rules/helpers/list/list_action_edit.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686d4c33e14e38_41288495',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8a0b6a8625abe1fd3c199d552bb8dacee4fafd3d' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/admin033aqbbsn/themes/default/template/controllers/tax_rules/helpers/list/list_action_edit.tpl',
      1 => 1741272501,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686d4c33e14e38_41288495 (Smarty_Internal_Template $_smarty_tpl) {
?><a onclick="loadTaxRule('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
'); return false;" href="#" class="btn btn-default">
	<i class="icon-pencil"></i>
	<?php echo $_smarty_tpl->tpl_vars['action']->value;?>

</a><?php }
}
