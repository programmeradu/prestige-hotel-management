<?php
/*
* Paystack Module - Debug Controller
*/

class PaystackDebugModuleFrontController extends ModuleFrontController
{
    public $ssl = true;
    public $display_column_left = false;
    
    public function initContent()
    {
        parent::initContent();
        
        if (!Tools::getIsset('debug_token') || Tools::getValue('debug_token') !== Configuration::get('PS_SHOP_DOMAIN')) {
            die('Access denied');
        }
        
        // Get Paystack configuration
        $config = Configuration::getMultiple(array(
            'PAYSTACK_MODE', 
            'PAYSTACK_TEST_PUBLICKEY', 
            'PAYSTACK_TEST_SECRETKEY',
            'PAYSTACK_LIVE_PUBLICKEY',
            'PAYSTACK_LIVE_SECRETKEY'
        ));
        
        $testMode = $config['PAYSTACK_MODE'] == 1;
        $publicKey = $testMode ? $config['PAYSTACK_TEST_PUBLICKEY'] : $config['PAYSTACK_LIVE_PUBLICKEY'];
        $secretKey = $testMode ? $config['PAYSTACK_TEST_SECRETKEY'] : $config['PAYSTACK_LIVE_SECRETKEY'];
        
        $context = Context::getContext();
        $currency = new Currency($context->currency->id);
        
        $this->context->smarty->assign(array(
            'testMode' => $testMode,
            'hasPublicKey' => !empty($publicKey),
            'hasSecretKey' => !empty($secretKey),
            'publicKey' => $publicKey,
            'email' => 'test@example.com',
            'currency' => $currency->iso_code
        ));
        
        $this->setTemplate('debug.tpl');
    }
}
