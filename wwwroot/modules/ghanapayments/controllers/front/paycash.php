<?php
/**
 * Pay at Check-in Controller
 */

class GhanapaymentsPaycashModuleFrontController extends ModuleFrontController
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
        
        $this->context->smarty->assign([
            'nbProducts' => $cart->nbProducts(),
            'cust_currency' => $cart->id_currency,
            'currencies' => $this->module->getCurrency((int)$cart->id_currency),
            'total' => $cart->getOrderTotal(true, Cart::BOTH),
            'isoCode' => $this->context->language->iso_code,
            'customer_name' => $customer->firstname . ' ' . $customer->lastname,
            'this_path' => $this->module->getPathUri(),
        ]);
        
        $this->setTemplate('module:ghanapayments/views/templates/front/paycash.tpl');
    }
    
    public function postProcess()
    {
        if (Tools::isSubmit('confirm_paycash')) {
            $cart = $this->context->cart;
            
            if ($cart->id_customer == 0 || $cart->id_address_delivery == 0 || $cart->id_address_invoice == 0 || !$this->module->active) {
                Tools::redirect('index.php?controller=order&step=1');
            }
            
            // Check if this payment module is authorized
            $authorized = false;
            foreach (Module::getPaymentModules() as $module) {
                if ($module['name'] == 'ghanapayments') {
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
            
            $currency = $this->context->currency;
            $total = (float)$cart->getOrderTotal(true, Cart::BOTH);
            
            $arrival_date = Tools::getValue('arrival_date');
            $additional_notes = Tools::getValue('additional_notes');
            
            // Create an order in "Awaiting Check-in Payment" state
            $this->module->validateOrder(
                (int)$cart->id,
                Configuration::get('GHANAPAYMENTS_OS_CASH_WAITING'),
                $total,
                $this->module->displayName . ' - Pay at Check-in',
                null,
                null,
                (int)$currency->id,
                false,
                $customer->secure_key
            );
            
            // Save additional information as order message
            $message = 'Pay at Check-in Details:' . "\n";
            $message .= 'Expected Arrival Date: ' . $arrival_date . "\n";
            $message .= 'Customer Notes: ' . $additional_notes . "\n";
            $message .= 'Amount to Pay on Arrival: ' . Tools::displayPrice($total, $currency) . "\n";
            
            // Add a message to the order
            $msg = new Message();
            $msg->message = $message;
            $msg->id_cart = (int)$cart->id;
            $msg->id_order = (int)$this->module->currentOrder;
            $msg->private = true;
            $msg->add();
            
            Tools::redirect('index.php?controller=order-confirmation&id_cart='.(int)$cart->id.'&id_module='.(int)$this->module->id.'&id_order='.$this->module->currentOrder.'&key='.$customer->secure_key);
        }
    }
}
