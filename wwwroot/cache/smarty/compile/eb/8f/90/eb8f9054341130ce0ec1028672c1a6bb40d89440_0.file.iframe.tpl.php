<?php
/* Smarty version 3.1.39, created on 2025-07-09 09:24:21
  from '/www/wwwroot/prestigehotel.org/modules/ybc_widget/views/templates/hook/iframe.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_686e3545995602_75325188',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eb8f9054341130ce0ec1028672c1a6bb40d89440' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/ybc_widget/views/templates/hook/iframe.tpl',
      1 => 1751908664,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_686e3545995602_75325188 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type="text/javascript">
   function phProductFeedResizeIframe(obj) {
       $('iframe').css('height','auto');
       setTimeout(function() {
           $('iframe').css('opacity',1);
           var pHeight = $(obj).parent().height();
           $(obj).css('height','540px');
       }, 300);
    }
<?php echo '</script'; ?>
> 
<div id="ph_preview_template_html">
    <iframe src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['url_iframe']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="background: #ffffff ; border : 1px solid #ccc;width:100%;height:0;opacity:0;border-radius:5px" onload="phProductFeedResizeIframe(this)"></iframe>
</div><?php }
}
