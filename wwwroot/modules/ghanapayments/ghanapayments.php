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

class GhanaPayments extends PaymentModule
{
    public $trust_key = 'StaNetworkGhanaPayments';
    private $html = '';
    private $postErrors = [];

    public function __construct()
    {
        $this->name = 'ghanapayments';
        $this->tab = 'payments_gateways';
        $this->version = '1.0.0';
        $this->author = 'StaNetwork';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7.0.0',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;
        $this->currencies = true;
        $this->currencies_mode = 'checkbox';

        parent::__construct();

        $this->displayName = $this->l('Ghana Payments');
        $this->description = $this->l('Accept Pay at Check-in and Ghana Mobile Money payments for hotel bookings');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall this module?');
    }

    public function install()
    {
        if (!parent::install()
            || !$this->registerHook('paymentOptions')
            || !$this->registerHook('paymentReturn')
            || !$this->registerHook('displayAdminOrderLeft')
            || !$this->registerHook('displayAdminOrderMainBottom')
            || !$this->registerHook('actionOrderStatusUpdate')
            || !$this->registerHook('actionEmailAddAfterContent')
            || !$this->installOrderState()
            || !$this->installEmailTemplates()
        ) {
            return false;
        }

        // Default configuration values
        Configuration::updateValue('GHANAPAYMENTS_CASH_ENABLED', 1);
        Configuration::updateValue('GHANAPAYMENTS_CASH_TITLE', 'Pay at Check-in');
        Configuration::updateValue('GHANAPAYMENTS_CASH_DESCRIPTION', 'Pay with cash or card when you arrive at the hotel');
        
        Configuration::updateValue('GHANAPAYMENTS_MOMO_ENABLED', 1);
        Configuration::updateValue('GHANAPAYMENTS_MOMO_TITLE', 'Ghana Mobile Money');
        Configuration::updateValue('GHANAPAYMENTS_MOMO_DESCRIPTION', 'Pay with MTN, Vodafone, or AirtelTigo Mobile Money');
        Configuration::updateValue('GHANAPAYMENTS_MOMO_INSTRUCTIONS', 'Please send payment to our mobile money number and provide your transaction ID to confirm your booking.');
        Configuration::updateValue('GHANAPAYMENTS_MOMO_NUMBER', '0201234567');
        Configuration::updateValue('GHANAPAYMENTS_MOMO_TIMEOUT', 24); // Payment timeout in hours
        
        return true;
    }

    /**
     * Install email templates
     */
    private function installEmailTemplates()
    {
        $languages = Language::getLanguages();
        
        // Payment Instructions Email
        foreach ($languages as $language) {
            Mail::createTemplate('payment_instructions', $language['id_lang'], 
                $this->l('Mobile Money Payment Instructions'), 
                '{firstname} {lastname},

Thank you for your order {order_reference}.

To complete your payment, please follow these steps:
1. Send {total_paid} {currency} to our Mobile Money number: {momo_number}
2. Use your order reference {order_reference} as payment description
3. After payment, submit your transaction ID on the order confirmation page

Your order will be confirmed once we verify your payment.

Best regards,
{shop_name}',
                'payment_instructions.html');
        }
        
        // Payment Reminder Email
        foreach ($languages as $language) {
            Mail::createTemplate('payment_reminder', $language['id_lang'], 
                $this->l('Payment Reminder - Your order will be canceled soon'), 
                '{firstname} {lastname},

This is a reminder about your order {order_reference}.

We haven\'t received your Mobile Money payment yet. Your order will be automatically canceled in {hours_left} hours if payment is not received.

To complete your payment, please send {total_paid} {currency} to: {momo_number}

Best regards,
{shop_name}',
                'payment_reminder.html');
        }
        
        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall()
            || !Configuration::deleteByName('GHANAPAYMENTS_CASH_ENABLED')
            || !Configuration::deleteByName('GHANAPAYMENTS_CASH_TITLE')
            || !Configuration::deleteByName('GHANAPAYMENTS_CASH_DESCRIPTION')
            || !Configuration::deleteByName('GHANAPAYMENTS_MOMO_ENABLED')
            || !Configuration::deleteByName('GHANAPAYMENTS_MOMO_TITLE')
            || !Configuration::deleteByName('GHANAPAYMENTS_MOMO_DESCRIPTION')
            || !Configuration::deleteByName('GHANAPAYMENTS_MOMO_INSTRUCTIONS')
            || !Configuration::deleteByName('GHANAPAYMENTS_MOMO_NUMBER')
            || !Configuration::deleteByName('GHANAPAYMENTS_MOMO_TIMEOUT')
        ) {
            return false;
        }
        
        return true;
    }

    /**
     * Hook: Add additional content to order emails
     */
    public function hookActionEmailAddAfterContent($params)
    {
        if (!isset($params['template']) || !isset($params['template_vars'])) {
            return '';
        }

        $template = $params['template'];
        $templateVars = $params['template_vars'];

        // Add Mobile Money payment instructions to order confirmation email
        if ($template == 'order_conf' && isset($templateVars['payment']) 
            && strpos($templateVars['payment'], $this->displayName) !== false) {
            
            return $this->context->smarty->fetch('module:ghanapayments/views/templates/hook/email_instructions.tpl');
        }

        return '';
    }

    /**
     * Create custom order states for the module
     */
    public function installOrderState()
    {
        // Pay at Check-in - Awaiting payment
        if (!Configuration::get('GHANAPAYMENTS_OS_CASH_WAITING')) {
            $orderState = new OrderState();
            $orderState->name = [];
            
            foreach (Language::getLanguages() as $language) {
                $orderState->name[$language['id_lang']] = 'Awaiting Payment at Check-in';
            }
            
            $orderState->send_email = false;
            $orderState->color = '#FFEAA7';
            $orderState->hidden = false;
            $orderState->delivery = false;
            $orderState->logable = false;
            $orderState->invoice = false;
            $orderState->module_name = $this->name;
            
            if ($orderState->add()) {
                Configuration::updateValue('GHANAPAYMENTS_OS_CASH_WAITING', (int)$orderState->id);
            }
        }
        
        // Mobile Money - Awaiting payment
        if (!Configuration::get('GHANAPAYMENTS_OS_MOMO_WAITING')) {
            $orderState = new OrderState();
            $orderState->name = [];
            
            foreach (Language::getLanguages() as $language) {
                $orderState->name[$language['id_lang']] = 'Awaiting Mobile Money Payment';
            }
            
            $orderState->send_email = true;
            $orderState->template = 'payment';
            $orderState->color = '#34495E';
            $orderState->hidden = false;
            $orderState->delivery = false;
            $orderState->logable = false;
            $orderState->invoice = false;
            $orderState->module_name = $this->name;
            
            if ($orderState->add()) {
                Configuration::updateValue('GHANAPAYMENTS_OS_MOMO_WAITING', (int)$orderState->id);
            }
        }
        
        return true;
    }

    /**
     * Module configuration page
     */
    public function getContent()
    {
        $this->html = '';

        if (Tools::isSubmit('submitGhanaPaymentsModule')) {
            $this->postValidation();
            
            if (!count($this->postErrors)) {
                $this->postProcess();
            } else {
                foreach ($this->postErrors as $err) {
                    $this->html .= $this->displayError($err);
                }
            }
        }
        
        $this->html .= $this->renderForm();
        
        return $this->html;
    }

    /**
     * Validate configuration form values
     */
    protected function postValidation()
    {
        if (Tools::isSubmit('submitGhanaPaymentsModule')) {
            // Validate Mobile Money number
            if (Tools::getValue('GHANAPAYMENTS_MOMO_ENABLED')) {
                $momoNumber = Tools::getValue('GHANAPAYMENTS_MOMO_NUMBER');
                if (empty($momoNumber)) {
                    $this->postErrors[] = $this->l('Mobile Money number is required.');
                } elseif (!preg_match('/^0[0-9]{9}$/', $momoNumber)) {
                    $this->postErrors[] = $this->l('Mobile Money number must be a valid 10-digit Ghana phone number starting with 0.');
                }
            }
        }
    }

    /**
     * Save form data
     */
    protected function postProcess()
    {
        Configuration::updateValue('GHANAPAYMENTS_CASH_ENABLED', (int)Tools::getValue('GHANAPAYMENTS_CASH_ENABLED'));
        Configuration::updateValue('GHANAPAYMENTS_CASH_TITLE', Tools::getValue('GHANAPAYMENTS_CASH_TITLE'));
        Configuration::updateValue('GHANAPAYMENTS_CASH_DESCRIPTION', Tools::getValue('GHANAPAYMENTS_CASH_DESCRIPTION'));
        
        Configuration::updateValue('GHANAPAYMENTS_MOMO_ENABLED', (int)Tools::getValue('GHANAPAYMENTS_MOMO_ENABLED'));
        Configuration::updateValue('GHANAPAYMENTS_MOMO_TITLE', Tools::getValue('GHANAPAYMENTS_MOMO_TITLE'));
        Configuration::updateValue('GHANAPAYMENTS_MOMO_DESCRIPTION', Tools::getValue('GHANAPAYMENTS_MOMO_DESCRIPTION'));
        Configuration::updateValue('GHANAPAYMENTS_MOMO_INSTRUCTIONS', Tools::getValue('GHANAPAYMENTS_MOMO_INSTRUCTIONS'));
        Configuration::updateValue('GHANAPAYMENTS_MOMO_NUMBER', Tools::getValue('GHANAPAYMENTS_MOMO_NUMBER'));
        
        $this->html .= $this->displayConfirmation($this->l('Settings updated'));
    }

    /**
     * Build the configuration form
     */
    protected function renderForm()
    {
        $helper = new HelperForm();
        
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitGhanaPaymentsModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        
        $helper->tpl_vars = [
            'fields_value' => $this->getConfigFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        ];
        
        return $helper->generateForm([$this->getConfigForm()]);
    }

    /**
     * Configuration form structure
     */
    protected function getConfigForm()
    {
        return [
            'form' => [
                'legend' => [
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ],
                'tabs' => [
                    'cash' => $this->l('Pay at Check-in'),
                    'momo' => $this->l('Mobile Money'),
                ],
                'input' => [
                    // Pay at Check-in Settings
                    [
                        'type' => 'switch',
                        'label' => $this->l('Enable Pay at Check-in'),
                        'name' => 'GHANAPAYMENTS_CASH_ENABLED',
                        'is_bool' => true,
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ],
                            [
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            ]
                        ],
                        'tab' => 'cash',
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Title'),
                        'name' => 'GHANAPAYMENTS_CASH_TITLE',
                        'desc' => $this->l('This title will be displayed on the checkout page.'),
                        'tab' => 'cash',
                    ],
                    [
                        'type' => 'textarea',
                        'label' => $this->l('Description'),
                        'name' => 'GHANAPAYMENTS_CASH_DESCRIPTION',
                        'desc' => $this->l('This description will be displayed on the checkout page.'),
                        'tab' => 'cash',
                    ],
                    
                    // Mobile Money Settings
                    [
                        'type' => 'switch',
                        'label' => $this->l('Enable Mobile Money Payment'),
                        'name' => 'GHANAPAYMENTS_MOMO_ENABLED',
                        'is_bool' => true,
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ],
                            [
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            ]
                        ],
                        'tab' => 'momo',
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Title'),
                        'name' => 'GHANAPAYMENTS_MOMO_TITLE',
                        'desc' => $this->l('This title will be displayed on the checkout page.'),
                        'tab' => 'momo',
                    ],
                    [
                        'type' => 'textarea',
                        'label' => $this->l('Description'),
                        'name' => 'GHANAPAYMENTS_MOMO_DESCRIPTION',
                        'desc' => $this->l('This description will be displayed on the checkout page.'),
                        'tab' => 'momo',
                    ],
                    [
                        'type' => 'textarea',
                        'label' => $this->l('Payment Instructions'),
                        'name' => 'GHANAPAYMENTS_MOMO_INSTRUCTIONS',
                        'desc' => $this->l('Instructions for customers on how to complete the mobile money payment.'),
                        'tab' => 'momo',
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Mobile Money Number'),
                        'name' => 'GHANAPAYMENTS_MOMO_NUMBER',
                        'desc' => $this->l('The mobile money number where customers should send payments.'),
                        'tab' => 'momo',
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Payment Timeout (hours)'),
                        'name' => 'GHANAPAYMENTS_MOMO_TIMEOUT',
                        'desc' => $this->l('Number of hours to wait for Mobile Money payment before canceling the order.'),
                        'tab' => 'momo',
                        'class' => 'fixed-width-sm',
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                ],
            ],
        ];
    }

    /**
     * Set default values for the configuration form
     */
    protected function getConfigFormValues()
    {
        return [
            'GHANAPAYMENTS_CASH_ENABLED' => Configuration::get('GHANAPAYMENTS_CASH_ENABLED'),
            'GHANAPAYMENTS_CASH_TITLE' => Configuration::get('GHANAPAYMENTS_CASH_TITLE'),
            'GHANAPAYMENTS_CASH_DESCRIPTION' => Configuration::get('GHANAPAYMENTS_CASH_DESCRIPTION'),
            
            'GHANAPAYMENTS_MOMO_ENABLED' => Configuration::get('GHANAPAYMENTS_MOMO_ENABLED'),
            'GHANAPAYMENTS_MOMO_TITLE' => Configuration::get('GHANAPAYMENTS_MOMO_TITLE'),
            'GHANAPAYMENTS_MOMO_DESCRIPTION' => Configuration::get('GHANAPAYMENTS_MOMO_DESCRIPTION'),
            'GHANAPAYMENTS_MOMO_INSTRUCTIONS' => Configuration::get('GHANAPAYMENTS_MOMO_INSTRUCTIONS'),
            'GHANAPAYMENTS_MOMO_NUMBER' => Configuration::get('GHANAPAYMENTS_MOMO_NUMBER'),
            'GHANAPAYMENTS_MOMO_TIMEOUT' => Configuration::get('GHANAPAYMENTS_MOMO_TIMEOUT'),
        ];
    }

    /**
     * Hook: Display payment options on the checkout page
     */
    public function hookPaymentOptions($params)
    {
        if (!$this->active || !$this->checkCurrency($params['cart'])) {
            return [];
        }

        $paymentOptions = [];
        
        // Pay at Check-in Option
        if (Configuration::get('GHANAPAYMENTS_CASH_ENABLED')) {
            $newOption = new PaymentOption();
            $newOption->setCallToActionText(Configuration::get('GHANAPAYMENTS_CASH_TITLE'))
                     ->setAction($this->context->link->getModuleLink($this->name, 'validation', ['method' => 'cash'], true))
                     ->setAdditionalInformation(Configuration::get('GHANAPAYMENTS_CASH_DESCRIPTION'));
            
            $paymentOptions[] = $newOption;
        }
        
        // Mobile Money Payment Option
        if (Configuration::get('GHANAPAYMENTS_MOMO_ENABLED')) {
            $this->context->smarty->assign([
                'momo_instructions' => Configuration::get('GHANAPAYMENTS_MOMO_INSTRUCTIONS'),
                'momo_number' => Configuration::get('GHANAPAYMENTS_MOMO_NUMBER'),
                'action_url' => $this->context->link->getModuleLink($this->name, 'validation', ['method' => 'momo'], true)
            ]);
            
            $newOption = new PaymentOption();
            $newOption->setCallToActionText(Configuration::get('GHANAPAYMENTS_MOMO_TITLE'))
                     ->setAction($this->context->link->getModuleLink($this->name, 'validation', ['method' => 'momo'], true))
                     ->setAdditionalInformation(Configuration::get('GHANAPAYMENTS_MOMO_DESCRIPTION'))
                     ->setForm($this->context->smarty->fetch('module:ghanapayments/views/templates/front/payment_momo_form.tpl'));
            
            $paymentOptions[] = $newOption;
        }
        
        return $paymentOptions;
    }

    /**
     * Hook: Process payment
     */
    public function hookPayment($params)
    {
        if (!$this->active) {
            return;
        }

        $this->smarty->assign([
            'this_path' => $this->_path,
            'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->name.'/',
            'payment_options' => [
                'cash' => [
                    'enabled' => (bool)Configuration::get('GHANAPAYMENTS_CASH_ENABLED'),
                    'title' => Configuration::get('GHANAPAYMENTS_CASH_TITLE'),
                    'description' => Configuration::get('GHANAPAYMENTS_CASH_DESCRIPTION'),
                ],
                'momo' => [
                    'enabled' => (bool)Configuration::get('GHANAPAYMENTS_MOMO_ENABLED'),
                    'title' => Configuration::get('GHANAPAYMENTS_MOMO_TITLE'),
                    'description' => Configuration::get('GHANAPAYMENTS_MOMO_DESCRIPTION'),
                    'instructions' => Configuration::get('GHANAPAYMENTS_MOMO_INSTRUCTIONS'),
                    'number' => Configuration::get('GHANAPAYMENTS_MOMO_NUMBER'),
                ],
            ],
        ]);

        return $this->display(__FILE__, 'views/templates/hook/payment.tpl');
    }

    /**
     * Check if the module currency is available for the current cart
     */
    private function checkCurrency($cart)
    {
        $currency_order = new Currency($cart->id_currency);
        $currencies_module = $this->getCurrency($cart->id_currency);

        if (is_array($currencies_module)) {
            foreach ($currencies_module as $currency_module) {
                if ($currency_order->id == $currency_module['id_currency']) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Hook: Display content on the order confirmation page
     */
    public function hookPaymentReturn($params)
    {
        if (!$this->active) {
            return;
        }

        $order = $params['order'];
        
        if ($order->module !== $this->name) {
            return;
        }
        
        $this->context->smarty->assign([
            'shop_name' => $this->context->shop->name,
            'reference' => $order->reference,
            'contact_url' => $this->context->link->getPageLink('contact', true),
            'status' => $order->getCurrentState(),
            'total' => Tools::displayPrice($order->total_paid, null, false),
        ]);
        
        // Get payment method from order payment
        $payment = $order->getOrderPaymentCollection()->getFirst();
        $paymentMethod = $payment ? $payment->payment_method : '';
        
        if (strpos($paymentMethod, 'Pay at Check-in') !== false) {
            return $this->context->smarty->fetch('module:ghanapayments/views/templates/hook/payment_return_cash.tpl');
        } elseif (strpos($paymentMethod, 'Mobile Money') !== false) {
            $this->context->smarty->assign([
                'momo_number' => Configuration::get('GHANAPAYMENTS_MOMO_NUMBER'),
            ]);
            return $this->context->smarty->fetch('module:ghanapayments/views/templates/hook/payment_return_momo.tpl');
        }
        
        return '';
    }

    /**
     * Hook: Display Mobile Money transaction information in the admin order view
     */
    public function hookDisplayAdminOrderLeft($params)
    {
        $orderId = $params['id_order'];
        $order = new Order($orderId);
        
        if ($order->module !== $this->name) {
            return;
        }
        
        // Get payment method from order payment
        $payment = $order->getOrderPaymentCollection()->getFirst();
        $paymentMethod = $payment ? $payment->payment_method : '';
        
        if (strpos($paymentMethod, 'Mobile Money') === false) {
            return;
        }
        
        // Get transaction details from order message
        $messages = Message::getMessagesByOrderId($orderId, false);
        $transactionInfo = [];
        
        foreach ($messages as $message) {
            if (strpos($message['message'], 'Mobile Money Transaction') !== false) {
                // Parse transaction info from message
                preg_match('/Network: (.*?)\n/', $message['message'], $networkMatch);
                preg_match('/Phone: (.*?)\n/', $message['message'], $phoneMatch);
                preg_match('/Transaction ID: (.*?)\n/', $message['message'], $transactionMatch);
                
                if (!empty($networkMatch) && !empty($phoneMatch) && !empty($transactionMatch)) {
                    $transactionInfo = [
                        'network' => $networkMatch[1],
                        'phone' => $phoneMatch[1],
                        'transaction_id' => $transactionMatch[1],
                    ];
                    break;
                }
            }
        }
        
        $this->context->smarty->assign([
            'transaction_info' => $transactionInfo,
        ]);
        
        return $this->context->smarty->fetch('module:ghanapayments/views/templates/hook/admin_order_left.tpl');
    }

    /**
     * Hook: Handle order status updates
     */
    public function hookActionOrderStatusUpdate($params)
    {
        $order = new Order($params['id_order']);
        $newStatus = $params['newOrderStatus'];
        
        // Handle Mobile Money payment status
        if ($order->module == $this->name) {
            // When order is created with Mobile Money payment
            if ($newStatus->id == Configuration::get('GHANAPAYMENTS_OS_MOMO_WAITING')) {
                // Schedule payment timeout check
                $timeoutHours = (int)Configuration::get('GHANAPAYMENTS_MOMO_TIMEOUT');
                $timeoutDate = date('Y-m-d H:i:s', strtotime("+{$timeoutHours} hours"));
                
                Configuration::updateValue('GHANAPAYMENTS_ORDER_TIMEOUT_' . $order->id, $timeoutDate);
                
                // Send payment instructions email
                $customer = new Customer($order->id_customer);
                $templateVars = [
                    '{order_reference}' => $order->reference,
                    '{firstname}' => $customer->firstname,
                    '{lastname}' => $customer->lastname,
                    '{total_paid}' => Tools::displayPrice($order->total_paid, new Currency($order->id_currency)),
                    '{currency}' => (new Currency($order->id_currency))->iso_code,
                    '{momo_number}' => Configuration::get('GHANAPAYMENTS_MOMO_NUMBER'),
                    '{shop_name}' => Configuration::get('PS_SHOP_NAME')
                ];
                
                Mail::Send(
                    (int)$order->id_lang,
                    'payment_instructions',
                    $this->l('Mobile Money Payment Instructions'),
                    $templateVars,
                    $customer->email,
                    $customer->firstname . ' ' . $customer->lastname,
                    null,
                    null,
                    null,
                    null,
                    _PS_MODULE_DIR_ . $this->name . '/mails/',
                    false,
                    (int)$order->id_shop
                );
            }
            
            // When payment is confirmed
            if ($newStatus->id == Configuration::get('PS_OS_PAYMENT')) {
                // Remove timeout check
                Configuration::deleteByName('GHANAPAYMENTS_ORDER_TIMEOUT_' . $order->id);
            }
        }
    }

    /**
     * Check for payment timeouts
     */
    public function checkPaymentTimeouts()
    {
        $sql = 'SELECT `name`, `value` FROM ' . _DB_PREFIX_ . 'configuration 
                WHERE `name` LIKE "GHANAPAYMENTS_ORDER_TIMEOUT_%"';
        
        $timeouts = Db::getInstance()->executeS($sql);
        $currentTime = date('Y-m-d H:i:s');
        
        foreach ($timeouts as $timeout) {
            $orderId = str_replace('GHANAPAYMENTS_ORDER_TIMEOUT_', '', $timeout['name']);
            $timeoutDate = $timeout['value'];
            
            if ($currentTime > $timeoutDate) {
                $order = new Order((int)$orderId);
                
                if (Validate::isLoadedObject($order) 
                    && $order->current_state == Configuration::get('GHANAPAYMENTS_OS_MOMO_WAITING')) {
                    
                    // Send reminder email before cancellation
                    $customer = new Customer($order->id_customer);
                    $hoursLeft = 2; // Give 2 more hours before cancellation
                    
                    $templateVars = [
                        '{order_reference}' => $order->reference,
                        '{firstname}' => $customer->firstname,
                        '{lastname}' => $customer->lastname,
                        '{total_paid}' => Tools::displayPrice($order->total_paid, new Currency($order->id_currency)),
                        '{currency}' => (new Currency($order->id_currency))->iso_code,
                        '{momo_number}' => Configuration::get('GHANAPAYMENTS_MOMO_NUMBER'),
                        '{hours_left}' => $hoursLeft,
                        '{shop_name}' => Configuration::get('PS_SHOP_NAME')
                    ];
                    
                    Mail::Send(
                        (int)$order->id_lang,
                        'payment_reminder',
                        $this->l('Payment Reminder - Your order will be canceled soon'),
                        $templateVars,
                        $customer->email,
                        $customer->firstname . ' ' . $customer->lastname,
                        null,
                        null,
                        null,
                        null,
                        _PS_MODULE_DIR_ . $this->name . '/mails/',
                        false,
                        (int)$order->id_shop
                    );
                    
                    // Update timeout to give additional time
                    $newTimeout = date('Y-m-d H:i:s', strtotime("+{$hoursLeft} hours"));
                    Configuration::updateValue($timeout['name'], $newTimeout);
                    
                    // If already reminded, cancel the order
                    if (strpos($timeoutDate, '+2 hours') !== false) {
                        $order->setCurrentState(Configuration::get('PS_OS_CANCELED'));
                        Configuration::deleteByName($timeout['name']);
                    }
                }
            }
        }
    }
}
