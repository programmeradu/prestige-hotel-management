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

class GhanaPaymentsValidationModuleFrontController extends ModuleFrontController
{
    /**
     * @see FrontController::postProcess()
     */
    public function postProcess()
    {
        if (!($this->module instanceof GhanaPayments)) {
            Tools::redirect('index.php?controller=order&step=1');
            return;
        }

        $cart = $this->context->cart;
        
        if ($cart->id_customer == 0 || $cart->id_address_delivery == 0 || $cart->id_address_invoice == 0 || !$this->module->active) {
            Tools::redirect('index.php?controller=order&step=1');
            return;
        }

        // Check that this payment option is still available
        $authorized = false;
        foreach (Module::getPaymentModules() as $module) {
            if ($module['name'] == 'ghanapayments') {
                $authorized = true;
                break;
            }
        }
        
        if (!$authorized) {
            $this->errors[] = $this->module->l('This payment method is not available.');
            $this->redirectWithNotifications('index.php?controller=order&step=1');
            return;
        }
        
        $customer = new Customer($cart->id_customer);
        
        if (!Validate::isLoadedObject($customer)) {
            Tools::redirect('index.php?controller=order&step=1');
            return;
        }
        
        $method = Tools::getValue('method');
        $currency = $this->context->currency;
        $total = (float)$cart->getOrderTotal(true, Cart::BOTH);
        
        if ($method == 'cash') {
            $this->processPayAtCheckIn($cart, $currency, $total, $customer);
        } elseif ($method == 'momo') {
            $this->processMomoPayment($cart, $currency, $total, $customer);
        } else {
            Tools::redirect('index.php?controller=order&step=1');
        }
    }
    
    /**
     * Process Pay at Check-in payment
     */
    protected function processPayAtCheckIn($cart, $currency, $total, $customer)
    {
        $this->module->validateOrder(
            $cart->id,
            Configuration::get('GHANAPAYMENTS_OS_CASH_WAITING'),
            $total,
            Configuration::get('GHANAPAYMENTS_CASH_TITLE'),
            null,
            [],
            (int)$currency->id,
            false,
            $customer->secure_key
        );
        
        Tools::redirect('index.php?controller=order-confirmation&id_cart='.$cart->id.'&id_module='.$this->module->id.'&id_order='.$this->module->currentOrder.'&key='.$customer->secure_key);
    }
    
    /**
     * Process Mobile Money payment
     */
    protected function processMomoPayment($cart, $currency, $total, $customer)
    {
        // Get Mobile Money details from form
        $network = Tools::getValue('momo_network');
        $phone = Tools::getValue('momo_phone');
        $transactionId = Tools::getValue('momo_transaction_id');
        
        // Validate Mobile Money details
        if (empty($network) || empty($phone) || empty($transactionId)) {
            $this->errors[] = $this->module->l('Please provide all Mobile Money payment details.');
            $this->redirectWithNotifications('index.php?controller=order&step=3');
            return;
        }
        
        // Create order
        $this->module->validateOrder(
            $cart->id,
            Configuration::get('GHANAPAYMENTS_OS_MOMO_WAITING'),
            $total,
            Configuration::get('GHANAPAYMENTS_MOMO_TITLE'),
            null,
            [
                'transaction_id' => $transactionId,
            ],
            (int)$currency->id,
            false,
            $customer->secure_key
        );
        
        // Save Mobile Money transaction details as order message
        $message = 'Mobile Money Transaction Details:' . "\n";
        $message .= 'Network: ' . $network . "\n";
        $message .= 'Phone: ' . $phone . "\n";
        $message .= 'Transaction ID: ' . $transactionId . "\n";
        
        $msg = new Message();
        $msg->message = $message;
        $msg->id_order = $this->module->currentOrder;
        $msg->private = 1;
        $msg->add();
        
        Tools::redirect('index.php?controller=order-confirmation&id_cart='.$cart->id.'&id_module='.$this->module->id.'&id_order='.$this->module->currentOrder.'&key='.$customer->secure_key);
    }
}

