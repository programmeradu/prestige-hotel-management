<?php
/* Smarty version 3.1.39, created on 2025-05-04 10:45:23
  from '/www/wwwroot/prestigehotel.org/themes/hotel-reservation-theme/_partials/service-products.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_6817454350cba3_40026751',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '79b3a2e3ff7ab865d73d2c4f2877a9e18a18ff0f' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/themes/hotel-reservation-theme/_partials/service-products.tpl',
      1 => 1741272753,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6817454350cba3_40026751 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>

<?php if ((isset($_smarty_tpl->tpl_vars['service_products_exists']->value)) && $_smarty_tpl->tpl_vars['service_products_exists']->value) {?>
    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1906340628681745434ec925_17188154', 'service_products_tabs');
?>

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_853567432681745434f5bb2_09649995', 'service_products_tabs_content');
?>

<?php }
}
/* {block 'service_products_tabs'} */
class Block_1906340628681745434ec925_17188154 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'service_products_tabs' => 
  array (
    0 => 'Block_1906340628681745434ec925_17188154',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <ul class="nav nav-tabs product_description_tabs">
            <?php if (!$_smarty_tpl->tpl_vars['PS_SERVICE_PRODUCT_CATEGORY_FILTER']->value) {?>
                <li class="active"><a href="#all_products" class="idTabHrefShort" data-toggle="tab"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Services'),$_smarty_tpl ) );?>
</a></li>
            <?php } else { ?>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['service_products_by_category']->value, 'category');
$_smarty_tpl->tpl_vars['category']->iteration = 0;
$_smarty_tpl->tpl_vars['category']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->do_else = false;
$_smarty_tpl->tpl_vars['category']->iteration++;
$__foreach_category_12_saved = $_smarty_tpl->tpl_vars['category'];
?>
                    <li <?php if ($_smarty_tpl->tpl_vars['category']->iteration == 1) {?>class="active"<?php }?>><a class="idTabHrefShort" href="#category_<?php echo $_smarty_tpl->tpl_vars['category']->value['id_category'];?>
" data-toggle="tab"><?php echo $_smarty_tpl->tpl_vars['category']->value['name'];?>
</a></li>
                <?php
$_smarty_tpl->tpl_vars['category'] = $__foreach_category_12_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            <?php }?>
        </ul>
    <?php
}
}
/* {/block 'service_products_tabs'} */
/* {block 'service_products_list'} */
class Block_1366678593681745434faee7_41479316 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                                        <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."_partials/service-products-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('service_products'=>$_smarty_tpl->tpl_vars['service_product_category']->value['products'],'group'=>$_smarty_tpl->tpl_vars['service_product_category']->value['id_category'],'init'=>true,'product'=>$_smarty_tpl->tpl_vars['product']->value), 0, true);
?>
                                    <?php
}
}
/* {/block 'service_products_list'} */
/* {block 'service_products_list'} */
class Block_203315119868174543505209_09249661 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                                <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."_partials/service-products-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('service_products'=>$_smarty_tpl->tpl_vars['service_products']->value,'group'=>'all','init'=>true,'product'=>$_smarty_tpl->tpl_vars['product']->value), 0, true);
?>
                            <?php
}
}
/* {/block 'service_products_list'} */
/* {block 'service_products_tabs_content'} */
class Block_853567432681745434f5bb2_09649995 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'service_products_tabs_content' => 
  array (
    0 => 'Block_853567432681745434f5bb2_09649995',
  ),
  'service_products_list' => 
  array (
    0 => 'Block_1366678593681745434faee7_41479316',
    1 => 'Block_203315119868174543505209_09249661',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <div class="card">
            <div class="row">
                <div class="col-sm-12 tab-content">
                    <?php if ($_smarty_tpl->tpl_vars['PS_SERVICE_PRODUCT_CATEGORY_FILTER']->value) {?>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['service_products_by_category']->value, 'service_product_category');
$_smarty_tpl->tpl_vars['service_product_category']->iteration = 0;
$_smarty_tpl->tpl_vars['service_product_category']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['service_product_category']->value) {
$_smarty_tpl->tpl_vars['service_product_category']->do_else = false;
$_smarty_tpl->tpl_vars['service_product_category']->iteration++;
$__foreach_service_product_category_13_saved = $_smarty_tpl->tpl_vars['service_product_category'];
?>
                            <div class="tab-pane <?php if ($_smarty_tpl->tpl_vars['service_product_category']->iteration == 1) {?>active<?php }?>" id="category_<?php echo $_smarty_tpl->tpl_vars['service_product_category']->value['id_category'];?>
">
                                <ul class="product-list">
                                    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1366678593681745434faee7_41479316', 'service_products_list', $this->tplIndex);
?>

                                </ul>
                                <?php if (RoomTypeServiceProduct::WK_NUM_RESULTS < $_smarty_tpl->tpl_vars['service_product_category']->value['num_products']) {?>
                                    <div class="show_more_btn_container">
                                        <button class="btn btn-default get-service-products" data-id_category="<?php echo $_smarty_tpl->tpl_vars['service_product_category']->value['id_category'];?>
" data-page="2" data-num_total="<?php echo $_smarty_tpl->tpl_vars['service_product_category']->value['num_products'];?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Show More'),$_smarty_tpl ) );?>
</button>
                                    </div>
                                <?php }?>
                            </div>
                        <?php
$_smarty_tpl->tpl_vars['service_product_category'] = $__foreach_service_product_category_13_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    <?php } else { ?>
                        <ul class="product-list">
                            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_203315119868174543505209_09249661', 'service_products_list', $this->tplIndex);
?>

                        </ul>
                        <?php if (RoomTypeServiceProduct::WK_NUM_RESULTS < $_smarty_tpl->tpl_vars['num_total_service_products']->value) {?>
                            <div class="show_more_btn_container">
                                <button class="btn btn-default get-service-products" data-page="2" data-num_total="<?php echo $_smarty_tpl->tpl_vars['num_total_service_products']->value;?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Show More'),$_smarty_tpl ) );?>
</button>
                            </div>
                        <?php }?>
                    <?php }?>
                </div>
            </div>
        </div>
    <?php
}
}
/* {/block 'service_products_tabs_content'} */
}
