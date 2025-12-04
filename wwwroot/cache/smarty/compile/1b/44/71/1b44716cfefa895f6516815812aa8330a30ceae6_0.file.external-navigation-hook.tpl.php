<?php
/* Smarty version 3.1.39, created on 2025-03-13 10:15:19
  from '/home/site/wwwroot/modules/hotelreservationsystem/views/templates/hook/external-navigation-hook.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d2b037edb709_57852421',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1b44716cfefa895f6516815812aa8330a30ceae6' => 
    array (
      0 => '/home/site/wwwroot/modules/hotelreservationsystem/views/templates/hook/external-navigation-hook.tpl',
      1 => 1741860829,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67d2b037edb709_57852421 (Smarty_Internal_Template $_smarty_tpl) {
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
