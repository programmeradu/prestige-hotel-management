<?php
/* Smarty version 3.1.39, created on 2025-07-07 15:15:08
  from '/www/wwwroot/prestigehotel.org/modules/hotelreservationsystem/views/templates/hook/display-nav.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686be47c6f01f0_44788309',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '550397cf5c6c3d9f5d5729b7d1282b4aecdf13a8' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/hotelreservationsystem/views/templates/hook/display-nav.tpl',
      1 => 1741272629,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686be47c6f01f0_44788309 (Smarty_Internal_Template $_smarty_tpl) {
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
