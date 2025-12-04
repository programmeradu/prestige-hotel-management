<?php
/**
* MTN Mobile Money Payment Module for QloApps - Validation Controller
*
* @author    Copilot
* @copyright Copyright (c) 2025
* @license   https://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
*/

class MtnMomoValidationModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        if (!$this->module->active) {
            Tools::redirect('index.php?controller=order&step=1');
        }

        $cart = $this->context->cart;
        
        if ($cart->id_customer == 0 || $cart->id_address_delivery == 0 || $cart->id_address_invoice == 0 || !$this->module->active) {
            Tools::redirect('index.php?controller=order&step=1');
        }

        // Check that this payment option is still available in case the customer changed his address
        $authorized = false;
        foreach (Module::getPaymentModules() as $module) {
            if ($module['name'] == 'mtnmomo') {
                $authorized = true;
                break;
            }
        }

        if (!$authorized) {
            die($this->module->l('This payment method is not available.'));
        }

        $customer = new Customer($cart->id_customer);
        
        if (!Validate::isLoadedObject($customer)) {
            Tools::redirect('index.php?controller=order&step=1');
        }

        // Collect phone number from checkout data
        $phone = $this->getCustomerPhoneNumber($cart);
        
        // If no phone is found, ask for it
        if (!$phone) {
            $this->context->smarty->assign([
                'action' => $this->context->link->getModuleLink('mtnmomo', 'validation', array(), true),
            ]);
            
            $this->setTemplate('module:mtnmomo/views/templates/front/phone_entry.tpl');
            return;
        }
        
        if (Tools::isSubmit('phone_number')) {
            $phone = Tools::getValue('phone_number');
        }
        
        // Format phone number to add country code if needed
        $phone = $this->formatPhoneNumber($phone);

        // Validate phone number format
        if (!$this->isValidGhanaPhoneNumber($phone)) {
            $this->context->smarty->assign([
                'action' => $this->context->link->getModuleLink('mtnmomo', 'validation', array(), true),
                'error' => $this->module->l('Please provide a valid Ghana phone number.'),
            ]);
            
            $this->setTemplate('module:mtnmomo/views/templates/front/phone_entry.tpl');
            return;
        }

        $currency = $this->context->currency;
        $total = (float)$cart->getOrderTotal(true, Cart::BOTH);

        // Create an order with pending payment status
        $this->module->validateOrder(
            (int)$cart->id,
            Configuration::get('MTNMOMO_PENDING_STATUS'),
            $total,
            $this->module->displayName,
            null,
            null,
            (int)$currency->id,
            false,
            $customer->secure_key
        );

        // Create payment request
        try {
            // Get the new order ID
            $order_id = Order::getOrderByCartId((int)$cart->id);
            $order = new Order($order_id);
            
            // Initiate MTN MoMo payment
            $momo_api = new MtnMomoApi();
            $payment_result = $momo_api->requestToPay(
                $total, 
                $phone, 
                $order->reference,
                $order_id
            );
            
            if ($payment_result['success']) {
                // Save the transaction reference ID to the database
                $this->saveTransactionReference($order_id, $payment_result['referenceId']);
                
                // Redirect to the payment waiting page
                Tools::redirect(
                    $this->context->link->getModuleLink(
                        'mtnmomo', 
                        'waiting', 
                        array(
                            'order_id' => $order_id,
                            'ref' => $payment_result['referenceId']
                        ), 
                        true
                    )
                );
            } else {
                // Payment initiation failed
                $this->context->smarty->assign([
                    'error' => $this->module->l('Failed to initiate payment: ') . $payment_result['message'],
                    'return_url' => $this->context->link->getPageLink('order', true)
                ]);
                
                $this->setTemplate('module:mtnmomo/views/templates/front/payment_error.tpl');
            }
        } catch (Exception $e) {
            // Exception handling
            $this->context->smarty->assign([
                'error' => $this->module->l('An error occurred while processing payment: ') . $e->getMessage(),
                'return_url' => $this->context->link->getPageLink('order', true)
            ]);
            
            $this->setTemplate('module:mtnmomo/views/templates/front/payment_error.tpl');
        }
    }

    private function getCustomerPhoneNumber($cart)
    {
        // Try to get phone from address
        $address = new Address($cart->id_address_invoice);
        if (!empty($address->phone_mobile)) {
            return $address->phone_mobile;
        }
        if (!empty($address->phone)) {
            return $address->phone;
        }
        
        return false;
    }
    
    private function formatPhoneNumber($phone)
    {
        // Remove spaces, dashes, etc.
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // If it starts with 0, replace with Ghana code
        if (substr($phone, 0, 1) == '0') {
            $phone = '233' . substr($phone, 1);
        }
        
        // If no country code is present, add Ghana code
        if (strlen($phone) == 9) {
            $phone = '233' . $phone;
        }
        
        return $phone;
    }
    
    private function isValidGhanaPhoneNumber($phone)
    {
        // Check if number matches Ghana format
        // Should be 233 followed by 9 digits
        return preg_match('/^233\d{9}$/', $phone);
    }
    
    private function saveTransactionReference($order_id, $reference_id)
    {
        // Store the reference ID for future status checks
        Db::getInstance()->insert(
            'mtnmomo_transaction',
            array(
                'id_order' => (int)$order_id,
                'reference_id' => pSQL($reference_id),
                'status' => 'PENDING',
                'date_add' => date('Y-m-d H:i:s')
            )
        );
    }
}
