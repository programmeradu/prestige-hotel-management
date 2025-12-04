<?php
/* Smarty version 3.1.39, created on 2025-07-08 15:11:27
  from '/www/wwwroot/prestigehotel.org/modules/epsonreceiptprinter/views/templates/hook/displayAdminOrderLeft.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686d351fad6d08_99414207',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ad78b1f80b352999e978d0791d621636c0fb22c6' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/epsonreceiptprinter/views/templates/hook/displayAdminOrderLeft.tpl',
      1 => 1746331860,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686d351fad6d08_99414207 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="panel">
    <div class="panel-heading">
        <i class="icon-print"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Print Folio','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>

    </div>
    <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['print_receipt_url']->value, ENT_QUOTES, 'UTF-8', true);?>
" target="_blank" class="btn btn-default btn-block">
        <i class="icon-print"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Print Guest Folio','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>

    </a>
    <p class="help-block"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Opens the folio in a new tab for printing.','mod'=>'epsonreceiptprinter'),$_smarty_tpl ) );?>
</p>
</div>
<?php }
}
