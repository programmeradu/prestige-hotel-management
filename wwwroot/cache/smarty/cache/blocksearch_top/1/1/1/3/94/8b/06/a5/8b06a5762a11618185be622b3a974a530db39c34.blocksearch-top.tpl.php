<?php
/* Smarty version 3.1.39, created on 2025-07-09 09:22:05
  from '/www/wwwroot/prestigehotel.org/modules/ybc_blocksearch/views/templates/hook/blocksearch-top.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686e34bd184851_59807061',
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
  'cache_lifetime' => 31536000,
),true)) {
function content_686e34bd184851_59807061 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- Block search module TOP -->
<div id="search_block_top" class="col-sm-6 clearfix has-categories-dropdown">
	<form id="searchbox" method="get" action="///search" >
		<input type="hidden" name="controller" value="search" />
		<input type="hidden" name="orderby" value="position" />
		<input type="hidden" name="orderway" value="desc" />
        <select class="searched_category" name="searched_category"><option value="0">CATEGORIES</option><option  class="search_depth_level_1" value="3">Locations</option><option  class="search_depth_level_2" value="5">- Ghana</option><option  class="search_depth_level_3" value="12">-- Cape Coast</option><option  class="search_depth_level_4" value="13">--- Cape Coast</option><option  class="search_depth_level_5" value="7">---- Prestige Hotel</option><option  class="search_depth_level_1" value="4">Services</option><option  class="search_depth_level_2" value="8">- Restaurant</option><option  class="search_depth_level_2" value="9">- Transfers</option><option  class="search_depth_level_2" value="10">- Activities</option><option  class="search_depth_level_2" value="11">- Operational charges</option></select><span class="select-arrow"></span>		<input class="search_query form-control" type="text" id="search_query_top" name="search_query" placeholder="Enter product name ..." value="" />
		<button type="submit" name="submit_search" class="btn btn-default button-search">
			<span>Search</span>
		</button>
	</form>
</div>
<!-- /Block search module TOP --><?php }
}
