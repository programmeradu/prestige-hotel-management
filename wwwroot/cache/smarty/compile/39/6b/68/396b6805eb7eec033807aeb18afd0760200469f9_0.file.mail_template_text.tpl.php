<?php
/* Smarty version 3.1.39, created on 2025-05-11 18:00:15
  from '/www/wwwroot/prestigehotel.org/modules/bankwire/views/templates/mail/mail_template_text.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_6820e5af7fbbf0_19068047',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '396b6805eb7eec033807aeb18afd0760200469f9' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/bankwire/views/templates/mail/mail_template_text.tpl',
      1 => 1742139884,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6820e5af7fbbf0_19068047 (Smarty_Internal_Template $_smarty_tpl) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Here are the Mobile Money details for your payment:','mod'=>'bankwire'),$_smarty_tpl ) );?>


<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Amount:','mod'=>'bankwire'),$_smarty_tpl ) );?>
 {total_paid}
<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Account Name:','mod'=>'bankwire'),$_smarty_tpl ) );?>
 <?php echo $_smarty_tpl->tpl_vars['bankwire_owner']->value;?>

<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Network Provider:','mod'=>'bankwire'),$_smarty_tpl ) );?>
 <?php echo $_smarty_tpl->tpl_vars['bankwire_details']->value;?>

<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Mobile Money Number:','mod'=>'bankwire'),$_smarty_tpl ) );?>
 <?php echo $_smarty_tpl->tpl_vars['bankwire_address']->value;?>

<?php }
}
