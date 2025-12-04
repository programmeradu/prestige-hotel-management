<?php
/* Smarty version 3.1.39, created on 2025-05-11 17:59:38
  from '/www/wwwroot/prestigehotel.org/modules/paystack/views/templates/hook/payment.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_6820e58a67b9c9_87535540',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bb39583b2ac7f04fabd39883fe65f428c96512a8' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/paystack/views/templates/hook/payment.tpl',
      1 => 1742616287,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6820e58a67b9c9_87535540 (Smarty_Internal_Template $_smarty_tpl) {
?>
<p class="payment_module">
	<a class="paystack automated-payment" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getModuleLink('paystack','directpayment'), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Pay instantly with Paystack','mod'=>'paystack'),$_smarty_tpl ) );?>
">
		<img src="<?php echo $_smarty_tpl->tpl_vars['this_path_bw']->value;?>
logo.png" alt="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Pay with Paystack','mod'=>'paystack'),$_smarty_tpl ) );?>
" style="max-width: 52px; vertical-align: middle; margin-right: 10px;"/>
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Instant Online Payment','mod'=>'paystack'),$_smarty_tpl ) );?>
&nbsp;<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'(Card, Mobile Money, Bank Transfer)','mod'=>'paystack'),$_smarty_tpl ) );?>
</span>
		<small class="automated-tag"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Instant - Automated','mod'=>'paystack'),$_smarty_tpl ) );?>
</small>
	</a>
</p>

<style type="text/css">
/* Styling for Paystack payment option */
.payment_module a.automated-payment {
    display: flex;
    align-items: center;
    position: relative;
    padding: 15px 10px;
    min-height: 20px;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}

.payment_module a.automated-payment:hover {
    background-color: #d0e9c6;
}

.payment_module a.automated-payment img {
    max-width: 50px;
    height: auto;
    display: inline-block;
}

.payment_module a.automated-payment span {
    font-size: 12px;
    color: #777;
}

.automated-tag {
    position: absolute;
    right: 15px;
    background: #5cb85c;
    color: white;
    padding: 3px 8px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: bold;
}

/* For responsive behavior */
@media (max-width: 768px) {
    .payment_module a.automated-payment {
        padding: 10px;
    }
    .payment_module a.automated-payment img {
        max-width: 40px;
    }
    .automated-tag {
        position: static;
        display: block;
        margin-top: 8px;
        width: fit-content;
    }
}
</style>
<?php }
}
