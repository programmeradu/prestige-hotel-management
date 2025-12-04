<?php
/* Smarty version 3.1.39, created on 2025-05-04 10:45:23
  from '/www/wwwroot/prestigehotel.org/modules/qlohotelreview/views/templates/hook/product-tab-content.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_68174543127f44_31918089',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '63b0c82869cf342bbb055d94dcd0b5dc13a0ded5' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/qlohotelreview/views/templates/hook/product-tab-content.tpl',
      1 => 1741272721,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./_partials/review-summary.tpl' => 1,
    'file:./_partials/media-list.tpl' => 1,
    'file:./_partials/list-actions.tpl' => 1,
    'file:./_partials/review-list.tpl' => 1,
  ),
),false)) {
function content_68174543127f44_31918089 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_42636372468174543113392_13165707', 'hotel_reviews');
?>

<?php }
/* {block 'review_summary'} */
class Block_13802476406817454311af59_56562600 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                <?php $_smarty_tpl->_subTemplateRender('file:./_partials/review-summary.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
            <?php
}
}
/* {/block 'review_summary'} */
/* {block 'media_list'} */
class Block_7861812396817454311fbd7_70879730 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                <?php $_smarty_tpl->_subTemplateRender('file:./_partials/media-list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
            <?php
}
}
/* {/block 'media_list'} */
/* {block 'list_actions'} */
class Block_15663607168174543121e23_34473095 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                <?php $_smarty_tpl->_subTemplateRender('file:./_partials/list-actions.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
            <?php
}
}
/* {/block 'list_actions'} */
/* {block 'review_list'} */
class Block_57511977968174543123d04_02257996 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                <?php $_smarty_tpl->_subTemplateRender('file:./_partials/review-list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
            <?php
}
}
/* {/block 'review_list'} */
/* {block 'hotel_reviews'} */
class Block_42636372468174543113392_13165707 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'hotel_reviews' => 
  array (
    0 => 'Block_42636372468174543113392_13165707',
  ),
  'review_summary' => 
  array (
    0 => 'Block_13802476406817454311af59_56562600',
  ),
  'media_list' => 
  array (
    0 => 'Block_7861812396817454311fbd7_70879730',
  ),
  'list_actions' => 
  array (
    0 => 'Block_15663607168174543121e23_34473095',
  ),
  'review_list' => 
  array (
    0 => 'Block_57511977968174543123d04_02257996',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div id="hotel-reviews" class="tab-pane card <?php if ((isset($_smarty_tpl->tpl_vars['language_is_rtl']->value)) && $_smarty_tpl->tpl_vars['language_is_rtl']->value) {?> rtl <?php }?>">
        <?php if (is_array($_smarty_tpl->tpl_vars['reviews']->value) && count($_smarty_tpl->tpl_vars['reviews']->value)) {?>
            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_13802476406817454311af59_56562600', 'review_summary', $this->tplIndex);
?>

            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7861812396817454311fbd7_70879730', 'media_list', $this->tplIndex);
?>

            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15663607168174543121e23_34473095', 'list_actions', $this->tplIndex);
?>

            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_57511977968174543123d04_02257996', 'review_list', $this->tplIndex);
?>

        <?php } else { ?>
            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No reviews.','mod'=>'qlohotelreview'),$_smarty_tpl ) );?>

        <?php }?>
    </div>
<?php
}
}
/* {/block 'hotel_reviews'} */
}
