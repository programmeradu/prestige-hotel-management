<?php
/**
* MTN Mobile Money Payment Module for QloApps
*
* @author    Copilot
* @copyright Copyright (c) 2025
* @license   https://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class MtnMomo extends PaymentModule
{
    protected $errors = array();
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'mtnmomo';
        $this->tab = 'payments_gateways';
        $this->version = '1.0.0';
        $this->author = 'QloApps';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->bootstrap = true;
        $this->controllers = array('validation');

        parent::__construct();

        $this->displayName = $this->l('MTN Mobile Money');
        $this->description = $this->l('Accept payments via MTN Mobile Money (Ghana)');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall this module?');
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('displayPaymentReturn') &&
            $this->registerHook('paymentOptions') &&
            $this->registerHook('actionFrontControllerSetMedia') &&
            $this->createOrderState() &&
            $this->installConfiguration();
    }

    public function uninstall()
    {
        return $this->uninstallConfiguration() && parent::uninstall();
    }

    protected function installConfiguration()
    {
        Configuration::updateValue('MTNMOMO_LIVE_MODE', false);
        Configuration::updateValue('MTNMOMO_PRIMARY_KEY', '');
        Configuration::updateValue('MTNMOMO_SECONDARY_KEY', '');
        Configuration::updateValue('MTNMOMO_API_USER', '');
        Configuration::updateValue('MTNMOMO_API_KEY', '');
        Configuration::updateValue('MTNMOMO_CALLBACK_URL', '');
        Configuration::updateValue('MTNMOMO_PENDING_STATUS', (int)Configuration::get('PS_OS_PENDING'));
        
        return true;
    }

    protected function uninstallConfiguration()
    {
        Configuration::deleteByName('MTNMOMO_LIVE_MODE');
        Configuration::deleteByName('MTNMOMO_PRIMARY_KEY');
        Configuration::deleteByName('MTNMOMO_SECONDARY_KEY');
        Configuration::deleteByName('MTNMOMO_API_USER');
        Configuration::deleteByName('MTNMOMO_API_KEY');
        Configuration::deleteByName('MTNMOMO_CALLBACK_URL');
        Configuration::deleteByName('MTNMOMO_PENDING_STATUS');
        
        return true;
    }

    protected function createOrderState()
    {
        if (!Configuration::get('MTNMOMO_PENDING_STATUS')) {
            $order_state = new OrderState();
            $order_state->name = array();
            foreach (Language::getLanguages() as $language) {
                $order_state->name[$language['id_lang']] = 'Awaiting MTN MoMo payment';
            }
            $order_state->send_email = false;
            $order_state->color = '#4169E1';
            $order_state->hidden = false;
            $order_state->delivery = false;
            $order_state->logable = false;
            $order_state->invoice = false;
            $order_state->paid = false;
            if ($order_state->add()) {
                Configuration::updateValue('MTNMOMO_PENDING_STATUS', (int)$order_state->id);
            }
        }
        return true;
    }

    public function getContent()
    {
        if (Tools::isSubmit('submit'.$this->name)) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);
        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $output.$this->renderForm();
    }

    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submit'.$this->name;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Live mode'),
                        'name' => 'MTNMOMO_LIVE_MODE',
                        'is_bool' => true,
                        'desc' => $this->l('Use this module in live mode'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-key"></i>',
                        'desc' => $this->l('Enter your MTN MoMo Primary Key'),
                        'name' => 'MTNMOMO_PRIMARY_KEY',
                        'label' => $this->l('Primary Key'),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-key"></i>',
                        'desc' => $this->l('Enter your MTN MoMo Secondary Key'),
                        'name' => 'MTNMOMO_SECONDARY_KEY',
                        'label' => $this->l('Secondary Key'),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-user"></i>',
                        'desc' => $this->l('Enter your MTN MoMo API User'),
                        'name' => 'MTNMOMO_API_USER',
                        'label' => $this->l('API User'),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-key"></i>',
                        'desc' => $this->l('Enter your MTN MoMo API Key'),
                        'name' => 'MTNMOMO_API_KEY',
                        'label' => $this->l('API Key'),
                    ),
                    array(
                        'col' => 6,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-link"></i>',
                        'desc' => $this->l('Callback URL for payment notifications'),
                        'name' => 'MTNMOMO_CALLBACK_URL',
                        'label' => $this->l('Callback URL'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    protected function getConfigFormValues()
    {
        return array(
            'MTNMOMO_LIVE_MODE' => Configuration::get('MTNMOMO_LIVE_MODE'),
            'MTNMOMO_PRIMARY_KEY' => Configuration::get('MTNMOMO_PRIMARY_KEY', '941916200e9c49c4bcb234fdc120a63f'),
            'MTNMOMO_SECONDARY_KEY' => Configuration::get('MTNMOMO_SECONDARY_KEY', '597fdac539ee42f2bd3e8e81021c9895'),
            'MTNMOMO_API_USER' => Configuration::get('MTNMOMO_API_USER'),
            'MTNMOMO_API_KEY' => Configuration::get('MTNMOMO_API_KEY'),
            'MTNMOMO_CALLBACK_URL' => Configuration::get('MTNMOMO_CALLBACK_URL', $this->context->link->getModuleLink($this->name, 'callback', array(), true)),
        );
    }

    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
        
        $this->_clearCache('*');
    }

    public function hookPaymentOptions($params)
    {
        if (!$this->active) {
            return;
        }

        $payment_option = new PrestaShop\PrestaShop\Core\Payment\PaymentOption();
        $payment_option->setCallToActionText($this->l('Pay with MTN Mobile Money'))
            ->setAction($this->context->link->getModuleLink($this->name, 'validation', array(), true))
            ->setLogo(Media::getMediaPath(_PS_MODULE_DIR_.$this->name.'/views/img/mtnmomo.png'));

        return [$payment_option];
    }

    public function hookActionFrontControllerSetMedia($params)
    {
        if ($this->context->controller->php_self == 'order') {
            $this->context->controller->registerStylesheet(
                'mtnmomo-style',
                'modules/'.$this->name.'/views/css/front.css',
                [
                    'media' => 'all',
                    'priority' => 200,
                ]
            );

            $this->context->controller->registerJavascript(
                'mtnmomo-javascript',
                'modules/'.$this->name.'/views/js/front.js',
                [
                    'position' => 'bottom',
                    'priority' => 200,
                ]
            );
        }
    }

    public function hookDisplayPaymentReturn($params)
    {
        if ($this->active == false) {
            return;
        }

        $order = $params['order'];
        
        if ($order->module != $this->name) {
            return;
        }

        $this->smarty->assign([
            'order' => $order,
            'shop_name' => $this->context->shop->name,
        ]);

        return $this->display(__FILE__, 'views/templates/hook/payment_return.tpl');
    }
}
