<?php
/* Smarty version 3.1.39, created on 2025-07-08 14:52:14
  from '/www/wwwroot/prestigehotel.org/admin033aqbbsn/themes/default/template/controllers/order_preferences/helpers/options/options.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686d309e533775_70484345',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0742ecb9c869907c4ebcd04d26644b285b8e0eac' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/admin033aqbbsn/themes/default/template/controllers/order_preferences/helpers/options/options.tpl',
      1 => 1741272493,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686d309e533775_70484345 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_865809311686d309e530c97_86561228', "after");
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "helpers/options/options.tpl");
}
/* {block "after"} */
class Block_865809311686d309e530c97_86561228 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'after' => 
  array (
    0 => 'Block_865809311686d309e530c97_86561228',
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
