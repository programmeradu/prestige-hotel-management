<?php
/* Smarty version 3.1.39, created on 2025-03-13 10:41:02
  from '/home/site/wwwroot/admin033aqbbsn/themes/default/template/layout.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d2b63eac3ef7_14150335',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3ee94894cde5f141ccdb9445a07b65397b5261cc' => 
    array (
      0 => '/home/site/wwwroot/admin033aqbbsn/themes/default/template/layout.tpl',
      1 => 1741862347,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./alerts.tpl' => 1,
  ),
),false)) {
function content_67d2b63eac3ef7_14150335 (Smarty_Internal_Template $_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['header']->value;?>

<?php $_smarty_tpl->_subTemplateRender('file:./alerts.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo $_smarty_tpl->tpl_vars['page']->value;?>

<?php echo $_smarty_tpl->tpl_vars['footer']->value;?>

<?php }
}
