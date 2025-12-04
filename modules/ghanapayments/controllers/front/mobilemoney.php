<?php
/**
 * Mobile Money Payment Controller
 */

class GhanapaymentsMobilemoneyModuleFrontController extends ModuleFrontController
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
            'momo_number' => Configuration::get('GHANAPAYMENTS_MOMO_NUMBER'),
            'customer_name' => $customer->firstname . ' ' . $customer->lastname,
            'this_path' => $this->module->getPathUri(),
            'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->module->name.'/',
            'reference' => $cart->id . '_' . time(),
        ]);
        
        $this->setTemplate('module:ghanapayments/views/templates/front/mobilemoney.tpl');
    }
    
    public function postProcess()
    {
        if (Tools::isSubmit('submit_mobilemoney')) {
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
            
            $network = Tools::getValue('momo_network');
            $phone = Tools::getValue('momo_phone');
            
            // Create an order in "Awaiting Mobile Money Payment" state
            $this->module->validateOrder(
                (int)$cart->id,
                Configuration::get('GHANAPAYMENTS_OS_MOMO_WAITING'),
                $total,
                $this->module->displayName . ' - Mobile Money (' . $network . ')',
                null,
                null,
                (int)$currency->id,
                false,
                $customer->secure_key
            );
            
            // Save transaction information as order message
            $message = 'Mobile Money Transaction Details:' . "\n";
            $message .= 'Network: ' . $network . "\n";
            $message .= 'Phone: ' . $phone . "\n";
            $message .= 'Amount: ' . Tools::displayPrice($total, $currency) . "\n";
            $message .= 'Transaction ID: Pending' . "\n";
            
            // Add a message to the order
            $msg = new Message();
            $msg->message = $message;
            $msg->id_cart = (int)$cart->id;
            $msg->id_order = (int)$this->module->currentOrder;
            $msg->private = true;
            $msg->add();
            
            // Set transaction timeout
            $timeout_hours = (int)Configuration::get('GHANAPAYMENTS_TRANSACTION_TIMEOUT', 24);
            $timeout_date = date('Y-m-d H:i:s', strtotime('+' . $timeout_hours . ' hours'));
            Configuration::updateValue('GHANAPAYMENTS_ORDER_TIMEOUT_' . (int)$this->module->currentOrder, $timeout_date);
            
            Tools::redirect('index.php?controller=order-confirmation&id_cart='.(int)$cart->id.'&id_module='.(int)$this->module->id.'&id_order='.$this->module->currentOrder.'&key='.$customer->secure_key);
        }
    }
}
