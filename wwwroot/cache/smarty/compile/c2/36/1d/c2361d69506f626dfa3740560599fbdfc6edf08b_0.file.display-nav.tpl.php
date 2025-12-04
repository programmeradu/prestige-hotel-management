<?php
/* Smarty version 3.1.39, created on 2025-03-13 10:15:20
  from '/home/site/wwwroot/modules/hotelreservationsystem/views/templates/hook/display-nav.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_67d2b0386c0f27_49427369',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c2361d69506f626dfa3740560599fbdfc6edf08b' => 
    array (
      0 => '/home/site/wwwroot/modules/hotelreservationsystem/views/templates/hook/display-nav.tpl',
      1 => 1741860828,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67d2b0386c0f27_49427369 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['email']->value != '') {?>
    <div class="contact-item">
        <i class="icon-envelope-o"></i>
        <a href="mailto:<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['email']->value;?>
</a>
    </div>
<?php }
if ($_smarty_tpl->tpl_vars['phone']->value != '') {?>
    <div class="contact-item">
        <i class="icon-phone"></i>
        <a href="tel:<?php echo $_smarty_tpl->tpl_vars['phone']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['phone']->value;?>
</a>
    </div>
<?php }
}
}
