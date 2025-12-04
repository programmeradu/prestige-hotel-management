<?php
/* Smarty version 3.1.39, created on 2025-03-12 10:26:32
  from '/home/site/wwwroot/admin033aqbbsn/themes/default/template/controllers/modules_catalog/content.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d1615805c977_17868854',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cc6cd787c7fd1760231350eb908b23b1df133ccf' => 
    array (
      0 => '/home/site/wwwroot/admin033aqbbsn/themes/default/template/controllers/modules_catalog/content.tpl',
      1 => 1741272490,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:recomended-banner.tpl' => 1,
    'file:controllers/modules_catalog/page.tpl' => 1,
  ),
),false)) {
function content_67d1615805c977_17868854 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="ajax_confirmation" class="alert alert-success hide"></div>
<div id="ajaxBox" style="display:none"></div>

<?php $_smarty_tpl->_subTemplateRender('file:recomended-banner.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="row">
	<div class="col-lg-12">
		<?php $_smarty_tpl->_subTemplateRender('file:controllers/modules_catalog/page.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
	</div>
</div><?php }
}
