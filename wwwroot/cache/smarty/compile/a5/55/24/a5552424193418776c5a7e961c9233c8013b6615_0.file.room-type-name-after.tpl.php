<?php
/* Smarty version 3.1.39, created on 2025-05-04 10:45:23
  from '/www/wwwroot/prestigehotel.org/modules/qlohotelreview/views/templates/hook/room-type-name-after.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_681745434e5024_97368742',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a5552424193418776c5a7e961c9233c8013b6615' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/qlohotelreview/views/templates/hook/room-type-name-after.tpl',
      1 => 1741272721,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_681745434e5024_97368742 (Smarty_Internal_Template $_smarty_tpl) {
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
