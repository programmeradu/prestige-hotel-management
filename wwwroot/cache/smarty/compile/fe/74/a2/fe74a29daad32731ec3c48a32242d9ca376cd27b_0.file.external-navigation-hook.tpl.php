<?php
/* Smarty version 3.1.39, created on 2025-07-07 15:15:08
  from '/www/wwwroot/prestigehotel.org/modules/hotelreservationsystem/views/templates/hook/external-navigation-hook.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686be47c034755_32093179',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fe74a29daad32731ec3c48a32242d9ca376cd27b' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/hotelreservationsystem/views/templates/hook/external-navigation-hook.tpl',
      1 => 1741272629,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686be47c034755_32093179 (Smarty_Internal_Template $_smarty_tpl) {
if (($_smarty_tpl->tpl_vars['email']->value != '') || ($_smarty_tpl->tpl_vars['phone']->value != '')) {?>
    <ul class="nav nav-pills nav-stacked visible-xs wk-nav-style">
        <?php if ($_smarty_tpl->tpl_vars['email']->value != '') {?>
            <li>
                <a href="mailto:<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
">
                    <i class="icon-envelope-o"></i>
                    <?php echo $_smarty_tpl->tpl_vars['email']->value;?>

                </a>
            </li>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['phone']->value != '') {?>
            <li>
                <a href="tel:<?php echo $_smarty_tpl->tpl_vars['phone']->value;?>
">
                    <i class="icon-phone"></i>
                    <?php echo $_smarty_tpl->tpl_vars['phone']->value;?>

                </a>
            </li>
        <?php }?>
    </ul>
<?php }
}
}
