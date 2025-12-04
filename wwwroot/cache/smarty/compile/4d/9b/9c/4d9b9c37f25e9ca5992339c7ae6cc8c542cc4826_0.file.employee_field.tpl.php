<?php
/* Smarty version 3.1.39, created on 2025-03-12 17:55:19
  from '/home/site/wwwroot/admin033aqbbsn/themes/default/template/controllers/logs/employee_field.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d1ca870b2f65_57849792',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4d9b9c37f25e9ca5992339c7ae6cc8c542cc4826' => 
    array (
      0 => '/home/site/wwwroot/admin033aqbbsn/themes/default/template/controllers/logs/employee_field.tpl',
      1 => 1741272490,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67d1ca870b2f65_57849792 (Smarty_Internal_Template $_smarty_tpl) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['employee_name']->value, ENT_QUOTES, 'UTF-8', true);?>

<br />
(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['employee_email']->value, ENT_QUOTES, 'UTF-8', true);?>
)
<?php }
}
