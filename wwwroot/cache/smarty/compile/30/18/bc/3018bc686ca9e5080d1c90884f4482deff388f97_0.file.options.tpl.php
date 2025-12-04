<?php
/* Smarty version 3.1.39, created on 2025-03-13 11:07:27
  from '/home/site/wwwroot/admin033aqbbsn/themes/default/template/controllers/order_preferences/helpers/options/options.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d2bc6f20a684_97587051',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3018bc686ca9e5080d1c90884f4482deff388f97' => 
    array (
      0 => '/home/site/wwwroot/admin033aqbbsn/themes/default/template/controllers/order_preferences/helpers/options/options.tpl',
      1 => 1741862420,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67d2bc6f20a684_97587051 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_214676309867d2bc6f2099c1_77427053', "after");
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "helpers/options/options.tpl");
}
/* {block "after"} */
class Block_214676309867d2bc6f2099c1_77427053 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'after' => 
  array (
    0 => 'Block_214676309867d2bc6f2099c1_77427053',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php echo '<script'; ?>
 type="text/javascript">
    changeCMSActivationAuthorization();
    changeOverbookingOrderAction();
<?php echo '</script'; ?>
>
<?php
}
}
/* {/block "after"} */
}
