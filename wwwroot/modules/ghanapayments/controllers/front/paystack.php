<?php
/**
 * 2023-2025 StaNetwork
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 *
 * @author    StaNetwork <contact@stanetwork.com>
 * @copyright 2023-2025 StaNetwork
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class GhanapaymentsPaystackModuleFrontController extends ModuleFrontController
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
        
        $currency = new Currency($cart->id_currency);
        $public_key = $this->module->getPaystackPublicKey();
        $amount = $cart->getOrderTotal(true, Cart::BOTH) * 100; // Convert to kobo/pesewas for Paystack
        $email = $customer->email;
        $reference = 'PS_' . $cart->id . '_' . time();
        
        $this->context->smarty->assign([
            'nbProducts' => $cart->nbProducts(),
            'cust_currency' => $cart->id_currency,
            'currencies' => $this->module->getCurrency((int)$cart->id_currency),
            'total' => $cart->getOrderTotal(true, Cart::BOTH),
            'amount_kobo' => $amount,
            'email' => $email,
            'reference' => $reference,
            'public_key' => $public_key,
            'callback_url' => $this->context->link->getModuleLink('ghanapayments', 'validation', ['source' => 'paystack'], true),
            'currency_code' => $currency->iso_code,
        ]);
        
        $this->setTemplate('module:ghanapayments/views/templates/front/paystack.tpl');
    }
    
    public function postProcess()
    {
        if (Tools::getValue('reference')) {
            $reference = Tools::getValue('reference');
            $response = $this->module->callPaystackApi('transaction/verify/' . $reference, [], 'GET');
            
            if ($response && isset($response['status']) && $response['status'] && isset($response['data']['status']) && $response['data']['status'] === 'success') {
                $cart = $this->context->cart;
                $customer = new Customer($cart->id_customer);
                $currency = $this->context->currency;
                $total = (float)$cart->getOrderTotal(true, Cart::BOTH);
                
                // Create the order
                $this->module->validateOrder(
                    (int)$cart->id,
                    Configuration::get('PS_OS_PAYMENT'),
                    $total,
                    $this->module->displayName . ' - Card (Paystack)',
                    null,
                    null,
                    (int)$currency->id,
                    false,
                    $customer->secure_key
                );
                
                // Save transaction information as order message
                $message = 'Paystack Transaction Details:' . "\n";
                $message .= 'Reference: ' . $reference . "\n";
                $message .= 'Amount: ' . Tools::displayPrice($total, $currency) . "\n";
                $message .= 'Email: ' . $response['data']['customer']['email'] . "\n";
                $message .= 'Card: ' . $response['data']['authorization']['card_type'] . ' **** ' . $response['data']['authorization']['last4'] . "\n";
                
                // Add a message to the order
                $msg = new Message();
                $msg->message = $message;
                $msg->id_cart = (int)$cart->id;
                $msg->id_order = (int)$this->module->currentOrder;
                $msg->private = true;
                $msg->add();
                
                Tools::redirect('index.php?controller=order-confirmation&id_cart='.(int)$cart->id.'&id_module='.(int)$this->module->id.'&id_order='.$this->module->currentOrder.'&key='.$customer->secure_key);
            } else {
                $this->errors[] = $this->module->l('Payment failed. Please try again or contact shop owner.');
            }
        }
    }
}
