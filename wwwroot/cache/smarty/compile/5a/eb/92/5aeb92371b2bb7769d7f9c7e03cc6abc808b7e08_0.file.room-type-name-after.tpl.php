<?php
/* Smarty version 3.1.39, created on 2025-03-11 20:25:34
  from '/home/site/wwwroot/modules/qlohotelreview/views/templates/hook/room-type-name-after.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d09c3e175c47_14831451',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5aeb92371b2bb7769d7f9c7e03cc6abc808b7e08' => 
    array (
      0 => '/home/site/wwwroot/modules/qlohotelreview/views/templates/hook/room-type-name-after.tpl',
      1 => 1741272720,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67d09c3e175c47_14831451 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div>
    <span class="raty readonly" data-score="<?php echo $_smarty_tpl->tpl_vars['avg_rating']->value;?>
"></span>
    <span class="num_reviews"><?php echo $_smarty_tpl->tpl_vars['num_reviews']->value;?>
 <?php if (intval($_smarty_tpl->tpl_vars['num_reviews']->value) > 1) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Review(s)','mod'=>'qlohotelreview'),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Review','mod'=>'qlohotelreview'),$_smarty_tpl ) );
}?></span>
</div>
<?php }
}
