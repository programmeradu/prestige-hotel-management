<?php
/* Smarty version 3.1.39, created on 2025-03-11 20:25:33
  from '/home/site/wwwroot/modules/qlohotelreview/views/templates/hook/product-tab-content.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d09c3d1d3db2_87214182',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '675e5b6e0b3024f85def5713df6a2b5501e1f353' => 
    array (
      0 => '/home/site/wwwroot/modules/qlohotelreview/views/templates/hook/product-tab-content.tpl',
      1 => 1741272720,
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
function content_67d09c3d1d3db2_87214182 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_52653528167d09c3d1879f7_08505450', 'hotel_reviews');
?>

<?php }
/* {block 'review_summary'} */
class Block_22819161267d09c3d1b24c8_66041191 extends Smarty_Internal_Block
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
class Block_90818457667d09c3d1cd9a6_24140518 extends Smarty_Internal_Block
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
class Block_155368129967d09c3d1ceb51_48969338 extends Smarty_Internal_Block
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
class Block_57958114367d09c3d1cf689_48765633 extends Smarty_Internal_Block
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
class Block_52653528167d09c3d1879f7_08505450 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'hotel_reviews' => 
  array (
    0 => 'Block_52653528167d09c3d1879f7_08505450',
  ),
  'review_summary' => 
  array (
    0 => 'Block_22819161267d09c3d1b24c8_66041191',
  ),
  'media_list' => 
  array (
    0 => 'Block_90818457667d09c3d1cd9a6_24140518',
  ),
  'list_actions' => 
  array (
    0 => 'Block_155368129967d09c3d1ceb51_48969338',
  ),
  'review_list' => 
  array (
    0 => 'Block_57958114367d09c3d1cf689_48765633',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div id="hotel-reviews" class="tab-pane card <?php if ((isset($_smarty_tpl->tpl_vars['language_is_rtl']->value)) && $_smarty_tpl->tpl_vars['language_is_rtl']->value) {?> rtl <?php }?>">
        <?php if (is_array($_smarty_tpl->tpl_vars['reviews']->value) && count($_smarty_tpl->tpl_vars['reviews']->value)) {?>
            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_22819161267d09c3d1b24c8_66041191', 'review_summary', $this->tplIndex);
?>

            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_90818457667d09c3d1cd9a6_24140518', 'media_list', $this->tplIndex);
?>

            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_155368129967d09c3d1ceb51_48969338', 'list_actions', $this->tplIndex);
?>

            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_57958114367d09c3d1cf689_48765633', 'review_list', $this->tplIndex);
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
