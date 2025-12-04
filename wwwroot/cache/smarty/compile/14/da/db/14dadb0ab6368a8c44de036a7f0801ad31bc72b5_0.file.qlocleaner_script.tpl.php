<?php
/* Smarty version 3.1.39, created on 2025-03-12 10:26:52
  from '/home/site/wwwroot/modules/qlocleaner/views/templates/admin/qlocleaner_script.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d1616c5f0a92_40546802',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '14dadb0ab6368a8c44de036a7f0801ad31bc72b5' => 
    array (
      0 => '/home/site/wwwroot/modules/qlocleaner/views/templates/admin/qlocleaner_script.tpl',
      1 => 1741272718,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67d1616c5f0a92_40546802 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type="text/javascript">
	$(document).ready(function(){
		$("#submitTruncateCatalog").click(function(){
			if ($(\'#checkTruncateCatalog_on\').attr(\'checked\') != "checked")
			{
				alert(<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Please read the disclaimer and click "Yes" above','mod'=>'qlocleaner'),$_smarty_tpl ) );?>
);
				return false;
			}
			if (confirm(<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Are you sure that you want to delete all catalog data?','mod'=>'qlocleaner'),$_smarty_tpl ) );?>
)
				return true;
			return false;
		});
		$("#submitTruncateSales").click(function(){
			if ($(\'#checkTruncateSales_on\').attr(\'checked\') != "checked")
			{
				alert(<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Please read the disclaimer and click "Yes" above','mod'=>'qlocleaner'),$_smarty_tpl ) );?>
);
				return false;
			}
			if (confirm(<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Are you sure that you want to delete all booking data?','mod'=>'qlocleaner'),$_smarty_tpl ) );?>
)
				return true;
			return false;
		});
	});
<?php echo '</script'; ?>
><?php }
}
