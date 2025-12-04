<?php
/* Smarty version 3.1.39, created on 2025-03-11 17:12:19
  from '/home/site/wwwroot/modules/wkroomsearchblock/views/templates/hook/landingPageSearch.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d06ef34127c0_39216814',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c4e5555f783caaa606466e449817ef12316971f5' => 
    array (
      0 => '/home/site/wwwroot/modules/wkroomsearchblock/views/templates/hook/landingPageSearch.tpl',
      1 => 1741272742,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./searchForm.tpl' => 1,
  ),
),false)) {
function content_67d06ef34127c0_39216814 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_118263440367d06ef33fd2c3_13666694', 'landing_page_search_panel');
?>

<?php }
/* {block 'search_form'} */
class Block_20647366767d06ef33ff448_04264757 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                                <?php $_smarty_tpl->_subTemplateRender("file:./searchForm.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                            <?php
}
}
/* {/block 'search_form'} */
/* {block 'landing_page_search_panel'} */
class Block_118263440367d06ef33fd2c3_13666694 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'landing_page_search_panel' => 
  array (
    0 => 'Block_118263440367d06ef33fd2c3_13666694',
  ),
  'search_form' => 
  array (
    0 => 'Block_20647366767d06ef33ff448_04264757',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php if ((isset($_smarty_tpl->tpl_vars['is_index_page']->value)) && $_smarty_tpl->tpl_vars['is_index_page']->value) {?>
        <div class="header-rmsearch-container header-rmsearch-hide-xs hidden-xs">
            <?php if ((isset($_smarty_tpl->tpl_vars['hotels_info']->value)) && count($_smarty_tpl->tpl_vars['hotels_info']->value)) {?>
                <div class="header-rmsearch-wrapper" id="xs_room_search_form">
                    <div class="header-rmsearch-primary">
                        <div class="fancy_search_header_xs">
                            <p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Search Rooms','mod'=>'wkroomsearchblock'),$_smarty_tpl ) );?>
</p>
                            <hr>
                        </div>
                        <div class="container">
                            <div class="header-rmsearch-inner-wrapper">
                            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_20647366767d06ef33ff448_04264757', 'search_form', $this->tplIndex);
?>

                            </div>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>
    <?php }
}
}
/* {/block 'landing_page_search_panel'} */
}
