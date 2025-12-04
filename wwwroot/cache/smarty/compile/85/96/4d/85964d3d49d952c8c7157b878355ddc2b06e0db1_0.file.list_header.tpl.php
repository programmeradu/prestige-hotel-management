<?php
/* Smarty version 3.1.39, created on 2025-03-12 12:43:19
  from '/home/site/wwwroot/admin033aqbbsn/themes/default/template/controllers/cart_rules/helpers/list/list_header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d181670cc849_90134491',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '85964d3d49d952c8c7157b878355ddc2b06e0db1' => 
    array (
      0 => '/home/site/wwwroot/admin033aqbbsn/themes/default/template/controllers/cart_rules/helpers/list/list_header.tpl',
      1 => 1741272484,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67d181670cc849_90134491 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_175440204767d1816704c749_51892581', 'override_header');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "helpers/list/list_header.tpl");
}
/* {block 'override_header'} */
class Block_175440204767d1816704c749_51892581 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'override_header' => 
  array (
    0 => 'Block_175440204767d1816704c749_51892581',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php if ($_smarty_tpl->tpl_vars['submit_form_ajax']->value) {?>
	<?php echo '<script'; ?>
 type="text/javascript">
		$('#voucher', window.parent.document).val('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['new_cart_rule']->value->code, ENT_QUOTES, 'UTF-8', true);?>
');
		parent.add_cart_rule(<?php echo intval($_smarty_tpl->tpl_vars['new_cart_rule']->value->id);?>
);
		parent.$.fancybox.close();
	<?php echo '</script'; ?>
>
<?php }
}
}
/* {/block 'override_header'} */
}
