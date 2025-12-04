<?php
/* Smarty version 3.1.39, created on 2025-03-13 10:42:28
  from '/home/site/wwwroot/admin033aqbbsn/themes/default/template/controllers/outstanding/_print_pdf_icon.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d2b694378ac4_06744156',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a188005b90dd6718a7f9b2cc8455c1c7b27d8afc' => 
    array (
      0 => '/home/site/wwwroot/admin033aqbbsn/themes/default/template/controllers/outstanding/_print_pdf_icon.tpl',
      1 => 1741862376,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67d2b694378ac4_06744156 (Smarty_Internal_Template $_smarty_tpl) {
if (Configuration::get('PS_INVOICE')) {?>
	<span style="width:20px; margin-right:5px;">
		<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminPdf'), ENT_QUOTES, 'UTF-8', true);?>
&amp;submitAction=generateInvoicePDF&amp;id_order_invoice=<?php echo $_smarty_tpl->tpl_vars['id_invoice']->value;?>
"><img src="../img/admin/tab-invoice.gif" alt="invoice" /></a>
	</span>
<?php }
}
}
