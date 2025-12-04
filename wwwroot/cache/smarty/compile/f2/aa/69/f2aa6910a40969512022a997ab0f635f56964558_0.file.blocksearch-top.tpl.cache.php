<?php
/* Smarty version 3.1.39, created on 2025-07-07 18:18:53
  from '/www/wwwroot/prestigehotel.org/modules/ybc_blocksearch/views/templates/hook/blocksearch-top.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686c0f8d9670a7_26226580',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f2aa6910a40969512022a997ab0f635f56964558' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/ybc_blocksearch/views/templates/hook/blocksearch-top.tpl',
      1 => 1751908664,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686c0f8d9670a7_26226580 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '284715323686c0f8d954af2_56326025';
?>
<!-- Block search module TOP -->
<div id="search_block_top" class="col-sm-6 clearfix <?php if ($_smarty_tpl->tpl_vars['searched_categories']->value) {?>has-categories-dropdown<?php } else { ?>no-categories-dropdown<?php }?>">
	<form id="searchbox" method="get" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('search',null,null,null,false,null,true), ENT_QUOTES, 'UTF-8', true);?>
" >
		<input type="hidden" name="controller" value="search" />
		<input type="hidden" name="orderby" value="position" />
		<input type="hidden" name="orderway" value="desc" />
        <?php if ($_smarty_tpl->tpl_vars['searched_categories']->value) {
echo $_smarty_tpl->tpl_vars['searched_categories']->value;
}?>
		<input class="search_query form-control" type="text" id="search_query_top" name="search_query" placeholder="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Enter product name ...','mod'=>'ybc_blocksearch'),$_smarty_tpl ) );?>
" value="<?php echo stripslashes(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['search_query']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'));?>
" />
		<button type="submit" name="submit_search" class="btn btn-default button-search">
			<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Search','mod'=>'ybc_blocksearch'),$_smarty_tpl ) );?>
</span>
		</button>
	</form>
</div>
<!-- /Block search module TOP --><?php }
}
