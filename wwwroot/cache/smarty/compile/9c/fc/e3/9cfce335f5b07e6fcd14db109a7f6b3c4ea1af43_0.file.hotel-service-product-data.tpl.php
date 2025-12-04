<?php
/* Smarty version 3.1.39, created on 2025-05-11 18:00:15
  from '/www/wwwroot/prestigehotel.org/mails/en/hotel-service-product-data.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_6820e5afa35bb9_72575193',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9cfce335f5b07e6fcd14db109a7f6b3c4ea1af43' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/mails/en/hotel-service-product-data.tpl',
      1 => 1680076407,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6820e5afa35bb9_72575193 (Smarty_Internal_Template $_smarty_tpl) {
if ((isset($_smarty_tpl->tpl_vars['list']->value)) && $_smarty_tpl->tpl_vars['list']->value) {?>
    <tr>
        <td style="padding:7px 0">
            <font size="2" face="Open-sans, sans-serif" color="#555454">
                <table class="table table-recap" bgcolor="#ffffff" style="width:100%;border-collapse:collapse"><!-- Title -->
                    <tr>
                        <th bgcolor="#f8f8f8" style="border:1px solid #D6D4D4;background-color: #fbfbfb;color: #333;font-family: Arial;font-size: 13px;padding: 10px;">Image</th>
                        <th bgcolor="#f8f8f8" style="border:1px solid #D6D4D4;background-color: #fbfbfb;color: #333;font-family: Arial;font-size: 13px;padding: 10px;">Name</th>
                        <th bgcolor="#f8f8f8" style="border:1px solid #D6D4D4;background-color: #fbfbfb;color: #333;font-family: Arial;font-size: 13px;padding: 10px;">Unit Price</th>
                        <th bgcolor="#f8f8f8" style="border:1px solid #D6D4D4;background-color: #fbfbfb;color: #333;font-family: Arial;font-size: 13px;padding: 10px;" width="17%">Qty</th>
                        <th bgcolor="#f8f8f8" style="border:1px solid #D6D4D4;background-color: #fbfbfb;color: #333;font-family: Arial;font-size: 13px;padding: 10px;" width="17%">Total</th>
                    </tr>
                    <tbody>
                        <tr>
                            <td colspan="5" style="border:1px solid #D6D4D4;text-align:center;color:#777;padding:7px 0">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'product', false, 'key');
$_smarty_tpl->tpl_vars['product']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->do_else = false;
?>
                                    <tr>
                                        <td style="border:1px solid #D6D4D4;">
                                            <table class="table">
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td class="text-center">
                                                        <font size="2" face="Open-sans, sans-serif" color="#555454">
                                                            <img src="<?php echo $_smarty_tpl->tpl_vars['product']->value['cover_img'];?>
" class="img-responsive" />
                                                        </font>
                                                    </td>
                                                    <td width="10">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td style="border:1px solid #D6D4D4;">
                                            <table class="table">
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td  class="text-center">
                                                        <font size="2" face="Open-sans, sans-serif" color="#555454">
                                                            <?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>

                                                        </font>
                                                    </td>
                                                    <td width="10">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td style="border:1px solid #D6D4D4;">
                                            <table class="table">
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td align="right"  class="text-center">
                                                        <font size="2" face="Open-sans, sans-serif" color="#555454">
                                                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0], array( array('price'=>$_smarty_tpl->tpl_vars['product']->value['unit_price']),$_smarty_tpl ) );?>

                                                        </font>
                                                    </td>
                                                    <td width="10">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td style="border:1px solid #D6D4D4;">
                                            <table class="table">
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td align="right"  class="text-center">
                                                        <font size="2" face="Open-sans, sans-serif" color="#555454">
                                                            <?php echo $_smarty_tpl->tpl_vars['product']->value['quantity'];?>

                                                        </font>
                                                    </td>
                                                    <td width="10">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td style="border:1px solid #D6D4D4;">
                                            <table class="table">
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td align="right"  class="text-center">
                                                        <font size="2" face="Open-sans, sans-serif" color="#555454">
                                                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0], array( array('price'=>$_smarty_tpl->tpl_vars['product']->value['price']),$_smarty_tpl ) );?>

                                                        </font>
                                                    </td>
                                                    <td width="10">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </font>
        </td>
    </tr>
<style>
    .pull-right {
        float: right;
    }
</style>
<?php }
}
}
