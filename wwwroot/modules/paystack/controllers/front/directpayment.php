<?php
/*
* Paystack Direct Payment Controller
* Provides a simplified payment experience
*/

class PaystackDirectpaymentModuleFrontController extends ModuleFrontController
{
    public $ssl = true;
    public $display_column_left = false;

    public function initContent()
    {
        parent::initContent();

        $cart = $this->context->cart;
        if (!$this->module->checkCurrency($cart)) {
            Tools::redirect('index.php?controller=order');
        }

        $customer = new Customer($cart->id_customer);
        if (!Validate::isLoadedObject($customer)) {
            Tools::redirect('index.php?controller=order&step=1');
        }

        // Get Paystack configuration
        $config = Configuration::getMultiple(array('PAYSTACK_MODE', 'PAYSTACK_TEST_PUBLICKEY', 'PAYSTACK_LIVE_PUBLICKEY'));
        $publicKey = $config['PAYSTACK_MODE'] == 1 ? $config['PAYSTACK_TEST_PUBLICKEY'] : $config['PAYSTACK_LIVE_PUBLICKEY'];

        // Generate reference
        $reference = 'PS_DIRECT_' . $cart->id . '_' . time();

        $currency = new Currency($cart->id_currency);
        $total = $cart->getOrderTotal(true, Cart::BOTH);
        $amount = $total * 100; // Convert to kobo/cents

        $callbackUrl = $this->context->link->getModuleLink('paystack', 'paystacksuccess', array(), true);

        // Prepare data for the template
        $this->context->smarty->assign(array(
            'publicKey' => $publicKey,
            'email' => $customer->email,
            'amount' => $amount,
            'currency' => $currency->iso_code,
            'reference' => $reference,
            'callbackUrl' => $callbackUrl,
            'cancelUrl' => $this->context->link->getPageLink('order', true, null, "step=3"),
            'this_path' => $this->module->getPathUri(),
            'this_path_ssl' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->module->name . '/',
            'total' => $total
        ));

        $this->setTemplate('direct_payment.tpl');
    }
}
