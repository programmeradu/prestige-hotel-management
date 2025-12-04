<?php
/* Smarty version 3.1.39, created on 2025-05-08 14:06:46
  from '/www/wwwroot/prestigehotel.org/modules/wkroomsearchblock/views/templates/hook/categoryPageSearch.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_681cba763727a6_62328020',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a0b7dc211bf9e0ea87309baf22828f8251542e09' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/wkroomsearchblock/views/templates/hook/categoryPageSearch.tpl',
      1 => 1741272742,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./searchForm.tpl' => 1,
  ),
),false)) {
function content_681cba763727a6_62328020 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_390192236681cba763620b4_24015304', 'category_page_search_panel');
?>

<?php }
/* {block 'search_form'} */
class Block_1560129289681cba7636b0b8_81988314 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		    <?php $_smarty_tpl->_subTemplateRender("file:./searchForm.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
        <?php
}
}
/* {/block 'search_form'} */
/* {block 'category_page_search_panel'} */
class Block_390192236681cba763620b4_24015304 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'category_page_search_panel' => 
  array (
    0 => 'Block_390192236681cba763620b4_24015304',
  ),
  'search_form' => 
  array (
    0 => 'Block_1560129289681cba7636b0b8_81988314',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php if ((isset($_smarty_tpl->tpl_vars['hotels_info']->value)) && count($_smarty_tpl->tpl_vars['hotels_info']->value)) {?>
        <div class="header-rmsearch-wrapper">
        <div class="filter_header clearfix">
        <p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Search Rooms','mod'=>'wkroomsearchblock'),$_smarty_tpl ) );?>
</p>
        <hr class="header-bottom-hr">
        </div>
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1560129289681cba7636b0b8_81988314', 'search_form', $this->tplIndex);
?>

        </div>
    <?php }
}
}
/* {/block 'category_page_search_panel'} */
}
