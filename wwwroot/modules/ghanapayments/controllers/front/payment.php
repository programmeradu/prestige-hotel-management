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

class GhanaPaymentsPaymentModuleFrontController extends ModuleFrontController
{
    public $ssl = true;

    public function initContent()
    {
        parent::initContent();

        // Get payment method
        $method = Tools::getValue('method');
        if (!in_array($method, ['momo'])) {
            Tools::redirect('index.php?controller=order&step=3');
            return;
        }

        $cart = $this->context->cart;
        
        // Check cart and customer validity
        if (!$this->module->checkCurrency($cart) || 
            $cart->id_customer == 0 || 
            $cart->id_address_delivery == 0 || 
            $cart->id_address_invoice == 0 || 
            !$this->module->active) {
            Tools::redirect('index.php?controller=order&step=1');
            return;
        }

        // Customer info
        $customer = new Customer($cart->id_customer);
        if (!Validate::isLoadedObject($customer)) {
            Tools::redirect('index.php?controller=order&step=1');
            return;
        }

        // Process the payment based on method
        if ($method === 'momo') {
            $this->processMomoPayment($cart, $customer);
        }
    }

    /**
     * Process Mobile Money payment
     */
    private function processMomoPayment($cart, $customer) 
    {
        // Prepare order details
        $total = (float)$cart->getOrderTotal(true, Cart::BOTH);
        $currency = $this->context->currency;
        $momo_number = Configuration::get('GHANAPAYMENTS_MOMO_NUMBER');
        $momo_instructions = Configuration::get('GHANAPAYMENTS_MOMO_INSTRUCTIONS');
        
        // Check if this is the confirmation step with transaction ID
        if (Tools::isSubmit('submitMomoConfirmation')) {
            $transaction_id = Tools::getValue('transaction_id');
            $network = Tools::getValue('network');
            $phone = Tools::getValue('phone');
            
            // Basic validation
            if (empty($transaction_id) || strlen($transaction_id) < 5) {
                $this->errors[] = $this->module->l('Please provide a valid transaction ID.');
            }
            
            if (empty($network)) {
                $this->errors[] = $this->module->l('Please select your mobile money network.');
            }
            
            if (empty($phone) || !preg_match('/^0[0-9]{9}$/', $phone)) {
                $this->errors[] = $this->module->l('Please provide a valid phone number.');
            }
            
            // If no validation errors, create order
            if (empty($this->errors)) {
                // Create the payment method field
                $payment_method = Configuration::get('GHANAPAYMENTS_MOMO_TITLE');
                
                // Get order status
                $order_status = Configuration::get('GHANAPAYMENTS_OS_MOMO_WAITING');
                if (!$order_status) {
                    $order_status = Configuration::get('PS_OS_PREPARATION');
                }
                
                try {
                    // Validate the order
                    $this->module->validateOrder(
                        $cart->id,
                        $order_status,
                        $total,
                        $payment_method,
                        null,
                        [],
                        (int)$currency->id,
                        false,
                        $customer->secure_key
                    );
                    
                    // Get the order ID that was just created
                    $order_id = Order::getOrderByCartId((int)$cart->id);
                    
                    // Create a message with transaction details
                    $message = "Mobile Money Transaction Details:\n";
                    $message .= "Network: " . $network . "\n";
                    $message .= "Phone: " . $phone . "\n";
                    $message .= "Transaction ID: " . $transaction_id . "\n";
                    $message .= "Amount: " . Tools::displayPrice($total, $currency) . "\n";
                    $message .= "Date: " . date('Y-m-d H:i:s') . "\n";
                    
                    // Add a message to the order
                    $msg = new Message();
                    $msg->message = $message;
                    $msg->id_order = (int)$order_id;
                    $msg->private = 1; // Private message (visible to admins only)
                    $msg->add();
                    
                    // Log the transaction
                    if (Configuration::get('GHANAPAYMENTS_DEBUG_MODE')) {
                        PrestaShopLogger::addLog(
                            'GhanaPayments: Mobile Money payment - Order #' . $order_id . ' - ' . $transaction_id, 
                            1, 
                            null, 
                            'Order', 
                            $order_id
                        );
                    }
                    
                    // Redirect to order confirmation
                    Tools::redirect('index.php?controller=order-confirmation&id_cart=' . $cart->id . '&id_module=' . $this->module->id . '&id_order=' . $this->module->currentOrder . '&key=' . $customer->secure_key);
                } catch (Exception $e) {
                    // Log error
                    if (Configuration::get('GHANAPAYMENTS_DEBUG_MODE')) {
                        PrestaShopLogger::addLog(
                            'GhanaPayments: Error processing Mobile Money payment - ' . $e->getMessage(), 
                            3, 
                            null, 
                            'Cart', 
                            $cart->id
                        );
                    }
                    
                    $this->errors[] = $this->module->l('An error occurred while processing your payment. Please try again.');
                }
            }
        }
        
        // If we reach here, either show the form initially or re-display with errors
        $this->context->smarty->assign([
            'module_dir' => $this->module->getPathUri(),
            'momo_number' => $momo_number,
            'momo_instructions' => $momo_instructions,
            'total' => Tools::displayPrice($total, $currency),
            'reference' => $this->module->currentOrder,
            'errors' => $this->errors,
            'form_action' => $this->context->link->getModuleLink($this->module->name, 'payment', ['method' => 'momo'], true),
            'networks' => [
                'mtn' => 'MTN Mobile Money',
                'vodafone' => 'Vodafone Cash',
                'airtel' => 'AirtelTigo Money',
            ]
        ]);
        
        $this->setTemplate('module:ghanapayments/views/templates/front/momo.tpl');
    }
}
