<?php
/* Smarty version 3.1.39, created on 2025-07-07 13:21:35
  from '/www/wwwroot/prestigehotel.org/admin033aqbbsn/themes/default/template/layout.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686bc9df6a5b33_92554610',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fa397a0badacaa4e97cd1513eea8baf22ea29cf1' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/admin033aqbbsn/themes/default/template/layout.tpl',
      1 => 1741272483,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./alerts.tpl' => 1,
  ),
),false)) {
function content_686bc9df6a5b33_92554610 (Smarty_Internal_Template $_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['header']->value;?>

<?php $_smarty_tpl->_subTemplateRender('file:./alerts.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo $_smarty_tpl->tpl_vars['page']->value;?>

<?php echo $_smarty_tpl->tpl_vars['footer']->value;?>

<?php }
}
