<?php
/* Smarty version 3.1.39, created on 2025-07-08 15:12:36
  from '/www/wwwroot/prestigehotel.org/admin033aqbbsn/themes/default/template/controllers/orders/_select_payment.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686d3564d5a0b7_96182088',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '19dfb74a5fe5accf130ca959823113c6072d065f' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/admin033aqbbsn/themes/default/template/controllers/orders/_select_payment.tpl',
      1 => 1741272493,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686d3564d5a0b7_96182088 (Smarty_Internal_Template $_smarty_tpl) {
?>
<datalist id="payment_module_name_list">
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['payment_modules']->value, 'payment_module');
$_smarty_tpl->tpl_vars['payment_module']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['payment_module']->value) {
$_smarty_tpl->tpl_vars['payment_module']->do_else = false;
?>
        <option value="<?php echo $_smarty_tpl->tpl_vars['payment_module']->value->displayName;?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['payment_module']->value->name;?>
" data-payment-type="<?php echo $_smarty_tpl->tpl_vars['payment_module']->value->payment_type;?>
">
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</datalist>
<?php }
}
