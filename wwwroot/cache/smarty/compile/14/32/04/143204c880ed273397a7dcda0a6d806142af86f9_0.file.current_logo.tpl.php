<?php
/* Smarty version 3.1.39, created on 2025-05-04 03:53:10
  from '/www/wwwroot/prestigehotel.org/modules/epsonreceiptprinter/views/templates/admin/current_logo.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_6816e4a63719e6_67899071',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '143204c880ed273397a7dcda0a6d806142af86f9' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/epsonreceiptprinter/views/templates/admin/current_logo.tpl',
      1 => 1746330526,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6816e4a63719e6_67899071 (Smarty_Internal_Template $_smarty_tpl) {
if ((isset($_smarty_tpl->tpl_vars['receipt_logo_exists']->value)) && $_smarty_tpl->tpl_vars['receipt_logo_exists']->value) {?>
<div class="panel">
    <h3><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Current Custom Logo",'mod'=>"epsonreceiptprinter"),$_smarty_tpl ) );?>
</h3>
    <div class="row">
        <div class="col-lg-12">
            <img src="<?php echo $_smarty_tpl->tpl_vars['receipt_logo_path']->value;?>
" alt="Receipt Logo" class="img-thumbnail" style="max-height: 100px;"><br><br>
            <p class="help-block"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"This custom logo will appear on your receipts.",'mod'=>"epsonreceiptprinter"),$_smarty_tpl ) );?>
</p>
        </div>
    </div>
</div>
<?php }
}
}
