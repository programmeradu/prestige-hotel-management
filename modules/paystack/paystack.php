<?php
/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Paystack extends PaymentModule
{
    private $_html = '';
    private $_postErrors = array();
    
    const PAYMENT_TYPE_ONLINE = 1;

    public function __construct()
    {
        $this->name = 'paystack';
        $this->tab = 'payments_gateways';
        $this->version = '1.0.0';
        $this->author = 'Paystack';
        $this->need_instance = 1;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Paystack');
        $this->description = $this->l('Accept payments via Paystack');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!count(Currency::checkPaymentCurrencies($this->id))) {
            $this->warning = $this->l('No currency has been set for this module.');
        }
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('paymentOptions') &&
            $this->registerHook('paymentReturn') &&
            $this->registerHook('displayOrderConfirmation') &&
            $this->registerHook('displayPayment') &&
            Configuration::updateValue('PAYSTACK_MODE', 0) &&
            Configuration::updateValue('PAYSTACK_TEST_PUBLICKEY', '') &&
            Configuration::updateValue('PAYSTACK_TEST_SECRETKEY', '') &&
            Configuration::updateValue('PAYSTACK_LIVE_PUBLICKEY', '') &&
            Configuration::updateValue('PAYSTACK_LIVE_SECRETKEY', '');
    }

    public function uninstall()
    {
        return parent::uninstall() &&
            Configuration::deleteByName('PAYSTACK_MODE') &&
            Configuration::deleteByName('PAYSTACK_TEST_PUBLICKEY') &&
            Configuration::deleteByName('PAYSTACK_TEST_SECRETKEY') &&
            Configuration::deleteByName('PAYSTACK_LIVE_PUBLICKEY') &&
            Configuration::deleteByName('PAYSTACK_LIVE_SECRETKEY');
    }

    public function getContent()
    {
        if (Tools::isSubmit('btnSubmit')) {
            $this->_postValidation();
            if (!count($this->_postErrors)) {
                $this->_postProcess();
            } else {
                foreach ($this->_postErrors as $err) {
                    $this->_html .= $this->displayError($err);
                }
            }
        }

        $this->_html .= $this->renderForm();
        return $this->_html;
    }

    private function _postValidation()
    {
        if (Tools::isSubmit('btnSubmit')) {
            if (!Tools::getValue('PAYSTACK_TEST_PUBLICKEY') && !Tools::getValue('PAYSTACK_LIVE_PUBLICKEY')) {
                $this->_postErrors[] = $this->l('Public key is required.');
            }
            if (!Tools::getValue('PAYSTACK_TEST_SECRETKEY') && !Tools::getValue('PAYSTACK_LIVE_SECRETKEY')) {
                $this->_postErrors[] = $this->l('Secret key is required.');
            }
        }
    }

    private function _postProcess()
    {
        Configuration::updateValue('PAYSTACK_MODE', Tools::getValue('PAYSTACK_MODE'));
        Configuration::updateValue('PAYSTACK_TEST_PUBLICKEY', Tools::getValue('PAYSTACK_TEST_PUBLICKEY'));
        Configuration::updateValue('PAYSTACK_TEST_SECRETKEY', Tools::getValue('PAYSTACK_TEST_SECRETKEY'));
        Configuration::updateValue('PAYSTACK_LIVE_PUBLICKEY', Tools::getValue('PAYSTACK_LIVE_PUBLICKEY'));
        Configuration::updateValue('PAYSTACK_LIVE_SECRETKEY', Tools::getValue('PAYSTACK_LIVE_SECRETKEY'));

        $this->_html .= $this->displayConfirmation($this->l('Settings updated'));
    }

    public function getCardPaymentOption()
    {
        if (version_compare(_PS_VERSION_, '1.7.0.0', '>=')) {
            $newOption = new PrestaShop\PrestaShop\Core\Payment\PaymentOption();
            $newOption->setModuleName($this->name)
                    ->setCallToActionText($this->l('Pay with Card or Mobile Money'))
                    ->setAction($this->context->link->getModuleLink($this->name, 'validation', array(), true))
                    ->setAdditionalInformation($this->context->smarty->fetch('module:paystack/views/templates/hook/payment_intro.tpl'));

            return $newOption;
        }
        
        return null;
    }

    public function hookPaymentOptions($params)
    {
        if (!$this->active) {
            return;
        }

        if (!$this->checkCurrency($params['cart'])) {
            return;
        }

        if (version_compare(_PS_VERSION_, '1.7.0.0', '>=')) {
            $payment_options = [
                $this->getCardPaymentOption()
            ];
            
            return $payment_options;
        }
        
        return null;
    }

    public function checkCurrency($cart)
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

    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Paystack Configuration'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Test Mode'),
                        'name' => 'PAYSTACK_MODE',
                        'is_bool' => true,
                        'desc' => $this->l('Use test keys for testing, live keys for production'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Test')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Live')
                            )
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Test Public Key'),
                        'name' => 'PAYSTACK_TEST_PUBLICKEY',
                        'required' => true
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Test Secret Key'),
                        'name' => 'PAYSTACK_TEST_SECRETKEY',
                        'required' => true
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Live Public Key'),
                        'name' => 'PAYSTACK_LIVE_PUBLICKEY',
                        'required' => true
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Live Secret Key'),
                        'name' => 'PAYSTACK_LIVE_SECRETKEY',
                        'required' => true
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->id = (int)Tools::getValue('id_carrier');
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'btnSubmit';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($fields_form));
    }

    public function getConfigFieldsValues()
    {
        return array(
            'PAYSTACK_MODE' => Tools::getValue('PAYSTACK_MODE', Configuration::get('PAYSTACK_MODE')),
            'PAYSTACK_TEST_PUBLICKEY' => Tools::getValue('PAYSTACK_TEST_PUBLICKEY', Configuration::get('PAYSTACK_TEST_PUBLICKEY')),
            'PAYSTACK_TEST_SECRETKEY' => Tools::getValue('PAYSTACK_TEST_SECRETKEY', Configuration::get('PAYSTACK_TEST_SECRETKEY')),
            'PAYSTACK_LIVE_PUBLICKEY' => Tools::getValue('PAYSTACK_LIVE_PUBLICKEY', Configuration::get('PAYSTACK_LIVE_PUBLICKEY')),
            'PAYSTACK_LIVE_SECRETKEY' => Tools::getValue('PAYSTACK_LIVE_SECRETKEY', Configuration::get('PAYSTACK_LIVE_SECRETKEY'))
        );
    }

    public function hookDisplayOrderConfirmation($params)
    {
        if (!isset($params['objOrder']) || ($params['objOrder']->module != $this->name)) {
            return false;
        }

        if (isset($params['objOrder']) && Validate::isLoadedObject($params['objOrder']) && isset($params['objOrder']->valid) && 
            isset($params['objOrder']->reference)) {
            
            $this->smarty->assign(array(
                'shop_name' => $this->context->shop->name,
                'reference' => $params['objOrder']->reference,
                'contact_url' => $this->context->link->getPageLink('contact', true),
                'total' => Tools::displayPrice(
                    $params['objOrder']->getOrdersTotalPaid(),
                    new Currency($params['objOrder']->id_currency),
                    false
                ),
                'status' => 'ok'
            ));

            return $this->display(__FILE__, 'views/templates/hook/order_confirmation.tpl');
        }

        return false;
    }

    public function hookPaymentReturn($params)
    {
        // Disable this method to avoid duplicate messages
        return false;
    }

    public function hookDisplayPayment($params)
    {
        if (!$this->active) {
            return;
        }

        if (!$this->checkCurrency($params['cart'])) {
            return;
        }

        $this->smarty->assign([
            'this_path' => $this->_path,
            'this_path_bw' => $this->_path,
            'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->name.'/'
        ]);

        return $this->display(__FILE__, 'views/templates/hook/payment.tpl');
    }

    public function validateOrder(
        $id_cart,
        $id_order_state,
        $amount_paid,
        $payment_method = 'Unknown',
        $message = null,
        $extra_vars = array(),
        $currency_special = null,
        $dont_touch_amount = false,
        $secure_key = false,
        Shop $shop = null,
        $send_mails = true
    ) {
        PrestaShopLogger::addLog('Paystack validateOrder called: Cart #' . $id_cart . ', Amount: ' . $amount_paid, 1);
        PrestaShopLogger::addLog('Paystack validateOrder called: Cart #' . $id_cart . ', Order State: ' . $id_order_state, 1);

        if (!isset($extra_vars['transaction_id'])) {
            $reference = Tools::getValue('reference');
            if (!empty($reference)) {
                $extra_vars['transaction_id'] = $reference;
            } else {
                $extra_vars['transaction_id'] = 'PS_' . $id_cart . '_' . time();
            }
        }

        try {
            $result = parent::validateOrder(
                $id_cart,
                $id_order_state,
                $amount_paid,
                $payment_method,
                $message,
                $extra_vars,
                $currency_special,
                $dont_touch_amount,
                $secure_key,
                $shop,
                $send_mails
            );

            PrestaShopLogger::addLog('Paystack validateOrder success: Order #' . $this->currentOrder, 1);

            return $result;
        } catch (Exception $e) {
            PrestaShopLogger::addLog('Paystack validateOrder error: ' . $e->getMessage(), 3);
            throw $e;
        }
    }
}
