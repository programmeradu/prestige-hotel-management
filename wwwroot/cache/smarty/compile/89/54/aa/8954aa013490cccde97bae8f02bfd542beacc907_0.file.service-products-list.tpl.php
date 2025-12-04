<?php
/* Smarty version 3.1.39, created on 2025-05-04 10:45:23
  from '/www/wwwroot/prestigehotel.org/themes/hotel-reservation-theme/_partials/service-products-list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_68174543519eb9_99803914',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8954aa013490cccde97bae8f02bfd542beacc907' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/themes/hotel-reservation-theme/_partials/service-products-list.tpl',
      1 => 1741272753,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68174543519eb9_99803914 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['service_products']->value, 'service_product');
$_smarty_tpl->tpl_vars['service_product']->index = -1;
$_smarty_tpl->tpl_vars['service_product']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['service_product']->value) {
$_smarty_tpl->tpl_vars['service_product']->do_else = false;
$_smarty_tpl->tpl_vars['service_product']->index++;
$_smarty_tpl->tpl_vars['service_product']->first = !$_smarty_tpl->tpl_vars['service_product']->index;
$__foreach_service_product_14_saved = $_smarty_tpl->tpl_vars['service_product'];
?>
    <?php if (!($_smarty_tpl->tpl_vars['service_product']->first && (isset($_smarty_tpl->tpl_vars['init']->value)) && $_smarty_tpl->tpl_vars['init']->value == true)) {?>
        <hr>
    <?php }?>
    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_205802060868174543516811_07573171', 'service_products_list_row');
?>

<?php
$_smarty_tpl->tpl_vars['service_product'] = $__foreach_service_product_14_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
/* {block 'service_products_list_row'} */
class Block_205802060868174543516811_07573171 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'service_products_list_row' => 
  array (
    0 => 'Block_205802060868174543516811_07573171',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."_partials/service-products-list-row.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('service_product'=>$_smarty_tpl->tpl_vars['service_product']->value,'product'=>$_smarty_tpl->tpl_vars['product']->value), 0, true);
?>
    <?php
}
}
/* {/block 'service_products_list_row'} */
}
