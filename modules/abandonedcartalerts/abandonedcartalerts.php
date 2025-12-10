<?php
/**
 * Abandoned Cart Email Alerts Module
 * 
 * Sends email alerts to reception when carts are abandoned
 * Compatible with cronjobs module
 * 
 * @author Prestige Hotel
 * @version 1.0.0
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class Abandonedcartalerts extends Module
{
    public function __construct()
    {
        $this->name = 'abandonedcartalerts';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Prestige Hotel';
        $this->need_instance = 0;
        $this->bootstrap = true;
        $this->ps_versions_compliancy = array(
            'min' => '1.6.0.0',
            'max' => _PS_VERSION_
        );
        
        parent::__construct();
        
        $this->displayName = $this->l('Abandoned Cart Email Alerts');
        $this->description = $this->l('Sends email alerts to reception when booking carts are abandoned.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall this module?');
    }
    
    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }
        
        return parent::install()
            && $this->registerHook('actionCronJob')
            && Configuration::updateValue('ABANDONEDCARTALERTS_EMAIL', Configuration::get('PS_SHOP_EMAIL'))
            && Configuration::updateValue('ABANDONEDCARTALERTS_MIN_MINUTES', 30)
            && Configuration::updateValue('ABANDONEDCARTALERTS_MAX_HOURS', 4)
            && Configuration::updateValue('ABANDONEDCARTALERTS_ENABLED', 1)
            && Configuration::updateValue('ABANDONEDCARTALERTS_LAST_CHECK', date('Y-m-d H:i:s'));
    }
    
    public function uninstall()
    {
        return parent::uninstall()
            && Configuration::deleteByName('ABANDONEDCARTALERTS_EMAIL')
            && Configuration::deleteByName('ABANDONEDCARTALERTS_MIN_MINUTES')
            && Configuration::deleteByName('ABANDONEDCARTALERTS_MAX_HOURS')
            && Configuration::deleteByName('ABANDONEDCARTALERTS_ENABLED')
            && Configuration::deleteByName('ABANDONEDCARTALERTS_LAST_CHECK');
    }
    
    /**
     * Required by cronjobs module - returns cron task configuration
     */
    public function getCronFrequency()
    {
        return array(
            'hour' => -1,      // Every hour
            'day' => -1,       // Every day
            'month' => -1,     // Every month
            'day_of_week' => -1 // Every day of week
        );
    }
    
    /**
     * Hook called by cronjobs module
     */
    public function hookActionCronJob($params)
    {
        return $this->sendAbandonedCartAlerts();
    }
    
    /**
     * Module configuration page
     */
    public function getContent()
    {
        $output = '';
        
        // Process form submission
        if (Tools::isSubmit('submitAbandonedCartAlertsSettings')) {
            $email = Tools::getValue('ABANDONEDCARTALERTS_EMAIL');
            $minMinutes = (int)Tools::getValue('ABANDONEDCARTALERTS_MIN_MINUTES');
            $maxHours = (int)Tools::getValue('ABANDONEDCARTALERTS_MAX_HOURS');
            $enabled = (int)Tools::getValue('ABANDONEDCARTALERTS_ENABLED');
            
            // Validate
            $emails = explode(',', $email);
            $valid = true;
            foreach ($emails as $e) {
                if (!Validate::isEmail(trim($e))) {
                    $valid = false;
                    $output .= $this->displayError($this->l('Invalid email address: ') . $e);
                }
            }
            
            if ($minMinutes < 0 || $minMinutes > 1440) {
                $valid = false;
                $output .= $this->displayError($this->l('Minimum minutes must be between 0 and 1440 (24 hours).'));
            }
            
            if ($maxHours < 1 || $maxHours > 168) {
                $valid = false;
                $output .= $this->displayError($this->l('Maximum hours must be between 1 and 168 (7 days).'));
            }
            
            if ($valid) {
                Configuration::updateValue('ABANDONEDCARTALERTS_EMAIL', pSQL($email));
                Configuration::updateValue('ABANDONEDCARTALERTS_MIN_MINUTES', $minMinutes);
                Configuration::updateValue('ABANDONEDCARTALERTS_MAX_HOURS', $maxHours);
                Configuration::updateValue('ABANDONEDCARTALERTS_ENABLED', $enabled);
                $output .= $this->displayConfirmation($this->l('Settings updated successfully.'));
            }
        }
        
        // Manual send button
        if (Tools::isSubmit('sendAbandonedCartAlertNow')) {
            $result = $this->sendAbandonedCartAlerts();
            if ($result['sent']) {
                $output .= $this->displayConfirmation(sprintf(
                    $this->l('Alert sent! Found %d abandoned cart(s).'),
                    $result['count']
                ));
            } else {
                $output .= $this->displayWarning($this->l('No abandoned carts found in the specified time range.'));
            }
        }
        
        return $output . $this->renderForm();
    }
    
    /**
     * Render configuration form using HelperForm
     */
    protected function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Abandoned Cart Alert Settings'),
                    'icon' => 'icon-envelope'
                ),
                'description' => $this->l('This module sends email alerts when customers abandon their booking carts. Configure the settings below and add this module as a cron task to automate alerts.'),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Email Alerts'),
                        'name' => 'ABANDONEDCARTALERTS_ENABLED',
                        'is_bool' => true,
                        'values' => array(
                            array('id' => 'enabled_on', 'value' => 1, 'label' => $this->l('Yes')),
                            array('id' => 'enabled_off', 'value' => 0, 'label' => $this->l('No'))
                        ),
                        'desc' => $this->l('Enable or disable abandoned cart email alerts.')
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Reception Email(s)'),
                        'name' => 'ABANDONEDCARTALERTS_EMAIL',
                        'required' => true,
                        'desc' => $this->l('Email address(es) to receive alerts. Separate multiple emails with commas.'),
                        'class' => 'fixed-width-xxl'
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Minimum Minutes'),
                        'name' => 'ABANDONEDCARTALERTS_MIN_MINUTES',
                        'suffix' => $this->l('minutes'),
                        'class' => 'fixed-width-sm',
                        'desc' => $this->l('Consider cart abandoned after this many MINUTES of inactivity. Default: 30 minutes for quick follow-up.')
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Maximum Hours'),
                        'name' => 'ABANDONEDCARTALERTS_MAX_HOURS',
                        'suffix' => $this->l('hours'),
                        'class' => 'fixed-width-sm',
                        'desc' => $this->l('Stop considering cart abandoned after this many hours. Default: 4 hours.')
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save Settings'),
                    'class' => 'btn btn-default pull-right'
                ),
                'buttons' => array(
                    array(
                        'href' => AdminController::$currentIndex . '&configure=' . $this->name 
                            . '&sendAbandonedCartAlertNow&token=' . Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Send Alert Now'),
                        'icon' => 'process-icon-envelope',
                        'class' => 'pull-left'
                    )
                )
            )
        );
        
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitAbandonedCartAlertsSettings';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) 
            . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        
        $helper->tpl_vars = array(
            'fields_value' => array(
                'ABANDONEDCARTALERTS_ENABLED' => Configuration::get('ABANDONEDCARTALERTS_ENABLED'),
                'ABANDONEDCARTALERTS_EMAIL' => Configuration::get('ABANDONEDCARTALERTS_EMAIL'),
                'ABANDONEDCARTALERTS_MIN_MINUTES' => Configuration::get('ABANDONEDCARTALERTS_MIN_MINUTES'),
                'ABANDONEDCARTALERTS_MAX_HOURS' => Configuration::get('ABANDONEDCARTALERTS_MAX_HOURS'),
            ),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );
        
        // Add info about cron setup
        $cronInfo = '<div class="alert alert-info">'
            . '<h4><i class="icon-cogs"></i> ' . $this->l('Cron Setup') . '</h4>'
            . '<p>' . $this->l('To automate alerts, add this module as a cron task:') . '</p>'
            . '<ol>'
            . '<li>' . $this->l('Go to Modules > Crontab for Prestashop') . '</li>'
            . '<li>' . $this->l('Click on "Jobs" tab') . '</li>'
            . '<li>' . $this->l('Add this module to the cron job list') . '</li>'
            . '</ol>'
            . '<p><strong>' . $this->l('Last check:') . '</strong> ' . Configuration::get('ABANDONEDCARTALERTS_LAST_CHECK') . '</p>'
            . '</div>';
        
        return $cronInfo . $helper->generateForm(array($fields_form));
    }
    
    /**
     * Get abandoned carts with customer details
     * Database uses qlooo_ prefix
     */
    public function getAbandonedCarts()
    {
        $minMinutes = (int)Configuration::get('ABANDONEDCARTALERTS_MIN_MINUTES');
        $maxHours = (int)Configuration::get('ABANDONEDCARTALERTS_MAX_HOURS');
        
        // IMPORTANT: Database uses qlooo_ prefix, NOT ps_
        $prefix = 'qlooo_';
        
        // Simple query - just get customer info from customer table
        $sql = 'SELECT 
                c.id_cart,
                c.id_customer,
                c.id_guest,
                c.date_add,
                c.date_upd,
                cu.firstname,
                cu.lastname,
                cu.email,
                cu.phone_mobile as phone
            FROM `' . bqSQL($prefix) . 'cart` c
            LEFT JOIN `' . bqSQL($prefix) . 'customer` cu ON c.id_customer = cu.id_customer
            LEFT JOIN `' . bqSQL($prefix) . 'guest` g ON c.id_guest = g.id_guest
            WHERE c.date_upd BETWEEN 
                DATE_SUB(NOW(), INTERVAL ' . (int)$maxHours . ' HOUR) 
                AND DATE_SUB(NOW(), INTERVAL ' . (int)$minMinutes . ' MINUTE)
            AND NOT EXISTS (
                SELECT 1 FROM `' . bqSQL($prefix) . 'orders` o WHERE o.id_cart = c.id_cart
            )
            AND EXISTS (
                SELECT 1 FROM `' . bqSQL($prefix) . 'htl_cart_booking_data` hcbd WHERE hcbd.id_cart = c.id_cart
            )
            ORDER BY c.date_upd DESC';
        
        $carts = Db::getInstance()->executeS($sql);
        
        if (!$carts) {
            return array();
        }
        
        // Get booking details for each cart
        foreach ($carts as &$cart) {
            $cart['booking_details'] = $this->getCartBookingDetails((int)$cart['id_cart'], $prefix);
            $cart['total'] = $this->getCartTotal((int)$cart['id_cart']);
        }
        
        return $carts;
    }
    
    /**
     * Get booking details for a cart
     */
    protected function getCartBookingDetails($idCart, $prefix)
    {
        $sql = 'SELECT 
                hcbd.id_room,
                hcbd.date_from,
                hcbd.date_to,
                ri.room_num,
                pl.name as room_type
            FROM `' . bqSQL($prefix) . 'htl_cart_booking_data` hcbd
            LEFT JOIN `' . bqSQL($prefix) . 'htl_room_information` ri ON hcbd.id_room = ri.id
            LEFT JOIN `' . bqSQL($prefix) . 'product_lang` pl ON hcbd.id_product = pl.id_product 
                AND pl.id_lang = ' . (int)Configuration::get('PS_LANG_DEFAULT') . '
            WHERE hcbd.id_cart = ' . (int)$idCart;
        
        return Db::getInstance()->executeS($sql);
    }
    
    /**
     * Get cart total - simplified to avoid pricing calculation errors
     * Note: Hotel booking prices are calculated dynamically and can fail for old carts
     */
    protected function getCartTotal($idCart)
    {
        // Simply return placeholder - the booking details are more important
        // Trying to calculate price triggers complex pricing chain that fails
        return 'See Details';
    }
    
    /**
     * Send abandoned cart alerts
     */
    public function sendAbandonedCartAlerts()
    {
        if (!Configuration::get('ABANDONEDCARTALERTS_ENABLED')) {
            return array('sent' => false, 'count' => 0, 'message' => 'Alerts disabled');
        }
        
        $abandonedCarts = $this->getAbandonedCarts();
        
        if (empty($abandonedCarts)) {
            return array('sent' => false, 'count' => 0, 'message' => 'No abandoned carts');
        }
        
        $emails = explode(',', Configuration::get('ABANDONEDCARTALERTS_EMAIL'));
        $emails = array_map('trim', $emails);
        
        // Build email content
        $emailContent = $this->buildEmailContent($abandonedCarts);
        
        // Send email to each recipient
        $sent = false;
        foreach ($emails as $email) {
            if (Validate::isEmail($email)) {
                $result = Mail::Send(
                    (int)Configuration::get('PS_LANG_DEFAULT'),
                    'abandoned_cart_alert',
                    $this->l('🚨 Abandoned Booking Carts Alert - Action Required'),
                    array(
                        '{alert_content}' => $emailContent,
                        '{shop_name}' => Configuration::get('PS_SHOP_NAME'),
                        '{shop_url}' => Tools::getShopDomainSsl(true),
                        '{date}' => date('F j, Y g:i A'),
                        '{cart_count}' => count($abandonedCarts),
                    ),
                    $email,
                    null,
                    Configuration::get('PS_SHOP_EMAIL'),
                    Configuration::get('PS_SHOP_NAME'),
                    null,
                    null,
                    dirname(__FILE__) . '/mails/'
                );
                if ($result) {
                    $sent = true;
                }
            }
        }
        
        // Update last check time
        Configuration::updateValue('ABANDONEDCARTALERTS_LAST_CHECK', date('Y-m-d H:i:s'));
        
        return array('sent' => $sent, 'count' => count($abandonedCarts));
    }
    
    /**
     * Build email content HTML - simple and readable
     */
    protected function buildEmailContent($carts)
    {
        $html = '<table style="width:100%;border-collapse:collapse;font-family:Arial,sans-serif;">';
        
        foreach ($carts as $cart) {
            $customerName = trim($cart['firstname'] . ' ' . $cart['lastname']);
            
            // Card container
            $html .= '<tr><td style="padding:10px 0;">';
            $html .= '<table style="width:100%;border:1px solid #ddd;border-radius:8px;border-collapse:collapse;">';
            
            // Header
            $html .= '<tr style="background:#1C2331;">';
            $html .= '<td style="padding:12px 15px;color:#fff;font-weight:bold;">Cart #' . (int)$cart['id_cart'] . '</td>';
            $html .= '</tr>';
            
            // Customer Details
            $html .= '<tr><td style="padding:15px;background:#fff;">';
            
            // Name
            if (!empty($customerName)) {
                $html .= '<p style="margin:0 0 8px 0;font-size:16px;font-weight:bold;color:#333;">' . htmlspecialchars($customerName) . '</p>';
            } else {
                $html .= '<p style="margin:0 0 8px 0;font-size:16px;color:#666;">' . $this->l('Guest Visitor') . '</p>';
            }
            
            // Phone - prominent
            if (!empty($cart['phone'])) {
                $html .= '<p style="margin:0 0 5px 0;font-size:15px;"><strong>' . $this->l('Phone:') . '</strong> ' . htmlspecialchars($cart['phone']) . '</p>';
            }
            
            // Email
            if (!empty($cart['email'])) {
                $html .= '<p style="margin:0 0 5px 0;font-size:14px;"><strong>' . $this->l('Email:') . '</strong> ' . htmlspecialchars($cart['email']) . '</p>';
            }
            
            // No contact warning
            if (empty($cart['phone']) && empty($cart['email'])) {
                $html .= '<p style="margin:0 0 5px 0;color:#856404;font-style:italic;">' . $this->l('No contact info - guest visitor') . '</p>';
            }
            
            // Last Activity
            $html .= '<p style="margin:8px 0 0 0;font-size:13px;color:#666;">' . $this->l('Last Activity:') . ' ' . date('M j, Y g:i A', strtotime($cart['date_upd'])) . '</p>';
            
            $html .= '</td></tr>';
            
            // Booking details
            if (!empty($cart['booking_details'])) {
                $html .= '<tr><td style="padding:12px 15px;background:#f9f9f9;border-top:1px solid #eee;">';
                $html .= '<strong style="color:#333;">' . $this->l('Rooms:') . '</strong><br>';
                foreach ($cart['booking_details'] as $booking) {
                    $html .= '• ' . htmlspecialchars($booking['room_type']) . ' (' . date('M j', strtotime($booking['date_from'])) . ' - ' . date('M j', strtotime($booking['date_to'])) . ')<br>';
                }
                $html .= '</td></tr>';
            }
            
            $html .= '</table></td></tr>';
        }
        
        $html .= '</table>';
        
        return $html;
    }
}
