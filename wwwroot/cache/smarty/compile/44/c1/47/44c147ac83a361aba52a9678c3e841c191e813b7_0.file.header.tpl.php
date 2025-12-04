<?php
/* Smarty version 3.1.39, created on 2025-07-07 18:18:53
  from '/www/wwwroot/prestigehotel.org/modules/ybc_nivoslider/views/templates/hook/header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686c0f8d70c888_38350063',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '44c147ac83a361aba52a9678c3e841c191e813b7' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/ybc_nivoslider/views/templates/hook/header.tpl',
      1 => 1751908664,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686c0f8d70c888_38350063 (Smarty_Internal_Template $_smarty_tpl) {
if ((isset($_smarty_tpl->tpl_vars['ybcnivo']->value))) {
echo '<script'; ?>
 type="text/javascript">
     var YBCNIVO_WIDTH='<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_WIDTH'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
';
     var YBCNIVO_HEIGHT='<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_HEIGHT'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
';
     var YBCNIVO_SPEED=<?php echo intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_SPEED']);?>
;
     var YBCNIVO_PAUSE=<?php echo intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_PAUSE']);?>
;
     var YBCNIVO_LOOP=<?php echo intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_LOOP']);?>
;
     var YBCNIVO_START_SLIDE=<?php echo intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_START_SLIDE']);?>
;
     var YBCNIVO_PAUSE_ON_HOVER=<?php echo intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_PAUSE_ON_HOVER']);?>
;
     var YBCNIVO_SHOW_CONTROL=<?php echo intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_SHOW_CONTROL']);?>
;
     var YBCNIVO_SHOW_PREV_NEXT=<?php echo intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_SHOW_PREV_NEXT']);?>
;
     var YBCNIVO_CAPTION_SPEED=<?php echo intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_CAPTION_SPEED']);?>
;
     var YBCNIVO_FRAME_WIDTH='<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_FRAME_WIDTH'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
';
<?php echo '</script'; ?>
>
<?php }
}
}
