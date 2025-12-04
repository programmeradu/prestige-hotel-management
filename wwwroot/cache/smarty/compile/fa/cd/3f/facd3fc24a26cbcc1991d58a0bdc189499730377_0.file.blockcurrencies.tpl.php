<?php
/* Smarty version 3.1.39, created on 2025-07-07 15:15:08
  from '/www/wwwroot/prestigehotel.org/modules/blockcurrencies/views/templates/hook/blockcurrencies.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686be47c71e448_63593165',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'facd3fc24a26cbcc1991d58a0bdc189499730377' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/blockcurrencies/views/templates/hook/blockcurrencies.tpl',
      1 => 1741272607,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686be47c71e448_63593165 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_232068066686be47c6fff00_17809606', 'block_currencies');
}
/* {block 'block_currencies'} */
class Block_232068066686be47c6fff00_17809606 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'block_currencies' => 
  array (
    0 => 'Block_232068066686be47c6fff00_17809606',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php if (count($_smarty_tpl->tpl_vars['currencies']->value) > 1) {?>
        <div id="currencies-block-top" class="currencies-block-wrap nav-main-item-right hidden-xs pull-right">
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['currencies']->value, 'f_currency', false, 'k');
$_smarty_tpl->tpl_vars['f_currency']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['f_currency']->value) {
$_smarty_tpl->tpl_vars['f_currency']->do_else = false;
?>
                        <?php if ($_smarty_tpl->tpl_vars['cookie']->value->id_currency == $_smarty_tpl->tpl_vars['f_currency']->value['id_currency']) {
echo $_smarty_tpl->tpl_vars['f_currency']->value['iso_code'];
}?>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    <span class="caret"></span>
                </button>

                <ul class="dropdown-menu">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['currencies']->value, 'f_currency', false, 'k');
$_smarty_tpl->tpl_vars['f_currency']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['f_currency']->value) {
$_smarty_tpl->tpl_vars['f_currency']->do_else = false;
?>
                        <?php if (strpos($_smarty_tpl->tpl_vars['f_currency']->value['name'],('(').($_smarty_tpl->tpl_vars['f_currency']->value['iso_code']).(')')) === false) {?>
                            <?php ob_start();
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'%s (%s)','sprintf'=>array($_smarty_tpl->tpl_vars['f_currency']->value['name'],$_smarty_tpl->tpl_vars['f_currency']->value['iso_code'])),$_smarty_tpl ) );
$_prefixVariable9 = ob_get_clean();
$_smarty_tpl->_assignInScope('currency_name', $_prefixVariable9);?>
                        <?php } else { ?>
                            <?php $_smarty_tpl->_assignInScope('currency_name', $_smarty_tpl->tpl_vars['f_currency']->value['name']);?>
                        <?php }?>
                        <li <?php if ($_smarty_tpl->tpl_vars['cookie']->value->id_currency == $_smarty_tpl->tpl_vars['f_currency']->value['id_currency']) {?>class="disabled"<?php }?>>
                            <a href="javascript:setCurrency(<?php echo $_smarty_tpl->tpl_vars['f_currency']->value['id_currency'];?>
);" title="<?php echo $_smarty_tpl->tpl_vars['currency_name']->value;?>
">
                                <?php echo $_smarty_tpl->tpl_vars['currency_name']->value;?>

                            </a>
                        </li>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </ul>
            </div>
        </div>
    <?php }
}
}
/* {/block 'block_currencies'} */
}
