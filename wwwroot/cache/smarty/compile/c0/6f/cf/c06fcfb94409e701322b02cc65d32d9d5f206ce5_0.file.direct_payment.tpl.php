<?php
/* Smarty version 3.1.39, created on 2025-05-29 13:26:25
  from '/www/wwwroot/prestigehotel.org/modules/paystack/views/templates/front/direct_payment.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_683860810ac0f3_77524210',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c06fcfb94409e701322b02cc65d32d9d5f206ce5' => 
    array (
      0 => '/www/wwwroot/prestigehotel.org/modules/paystack/views/templates/front/direct_payment.tpl',
      1 => 1742616287,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_683860810ac0f3_77524210 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="payment-container" style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 4px; background: #f9f9f9;">
    <h2 style="color: #333; text-align: center; margin-bottom: 20px;"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Complete Your Payment','mod'=>'paystack'),$_smarty_tpl ) );?>
</h2>
    
    <div class="payment-summary" style="background: white; border: 1px solid #eee; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
        <p style="font-size: 16px; font-weight: bold; color: #333; text-align: center;">
            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Total Amount:','mod'=>'paystack'),$_smarty_tpl ) );?>
 <span style="color: #2fb5d2;"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0], array( array('price'=>$_smarty_tpl->tpl_vars['total']->value),$_smarty_tpl ) );?>
</span>
        </p>
        
        <div style="text-align: center; margin: 15px 0;">
            <img src="<?php echo $_smarty_tpl->tpl_vars['this_path_ssl']->value;?>
card-logos.png" alt="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Payment Methods','mod'=>'paystack'),$_smarty_tpl ) );?>
" style="max-width: 250px;">
        </div>
    </div>
    
    <div id="payment-error" class="alert alert-danger" style="display: none; margin-bottom: 15px;">
        <p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'There was an error processing your payment. Please try again.','mod'=>'paystack'),$_smarty_tpl ) );?>
</p>
    </div>
    
    <div style="text-align: center;">
        <button id="pay-button" class="btn btn-primary" style="padding: 10px 20px; font-size: 16px; background: #2fb5d2; border: none; border-radius: 4px; color: white; cursor: pointer; width: 100%;">
            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Pay Now','mod'=>'paystack'),$_smarty_tpl ) );?>

        </button>
        
        <p style="margin-top: 15px; font-size: 13px; color: #777;">
            <i class="icon-lock"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Secured by Paystack','mod'=>'paystack'),$_smarty_tpl ) );?>

        </p>
        
        <div style="margin-top: 20px;">
            <a href="<?php echo $_smarty_tpl->tpl_vars['cancelUrl']->value;?>
" class="btn btn-default" style="font-size: 13px; color: #555;">
                <i class="icon-chevron-left"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Return to Checkout','mod'=>'paystack'),$_smarty_tpl ) );?>

            </a>
        </div>
    </div>
</div>

<?php echo '<script'; ?>
 src="https://js.paystack.co/v1/inline.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
document.getElementById('pay-button').addEventListener('click', function() {
    // Disable button and show loading state
    this.disabled = true;
    this.innerHTML = '<i class="icon-spinner icon-spin"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Processing...",'mod'=>"paystack"),$_smarty_tpl ) );?>
';
    
    try {
        console.log('Direct payment initiated');
        
        var handler = PaystackPop.setup({
            key: '<?php echo strtr($_smarty_tpl->tpl_vars['publicKey']->value, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
            email: '<?php echo strtr($_smarty_tpl->tpl_vars['email']->value, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
            amount: <?php echo $_smarty_tpl->tpl_vars['amount']->value;?>
,
            currency: '<?php echo strtr($_smarty_tpl->tpl_vars['currency']->value, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
            ref: '<?php echo strtr($_smarty_tpl->tpl_vars['reference']->value, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
            callback: function(response) {
                console.log('Payment completed with reference: ' + response.reference);
                window.location.href = '<?php echo strtr($_smarty_tpl->tpl_vars['callbackUrl']->value, array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
?reference=' + response.reference;
            },
            onClose: function() {
                console.log('Payment window closed');
                var payButton = document.getElementById('pay-button');
                payButton.disabled = false;
                payButton.innerHTML = '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Pay Now",'mod'=>"paystack"),$_smarty_tpl ) );?>
';
            }
        });
        
        handler.openIframe();
    } catch (error) {
        console.error('Payment initialization error:', error);
        document.getElementById('payment-error').style.display = 'block';
        var payButton = document.getElementById('pay-button');
        payButton.disabled = false;
        payButton.innerHTML = '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Try Again",'mod'=>"paystack"),$_smarty_tpl ) );?>
';
    }
});
<?php echo '</script'; ?>
>
<?php }
}
