<?php
    if (!defined('_PS_VERSION_')) {
        exit;
    }

    class EpsonReceiptPrinter extends Module
    {
        public function __construct()
        {
            $this->name = 'epsonreceiptprinter';
            $this->tab = 'administration'; // Or 'billing_invoicing', etc.
            $this->version = '1.0.1'; // Incremented version
            $this->author = 'Your Name'; // Replace with your name
            $this->need_instance = 0;
            $this->ps_versions_compliancy = array('min' => '1.6', 'max' => '1.6.99'); // Adjust for QloApps if needed
            $this->bootstrap = true;

            parent::__construct();

            $this->displayName = $this->l('Guest Folio Printer (Epson)'); // Updated Display Name
            $this->description = $this->l('Adds a button to print a formatted guest folio for Epson printers via browser.'); // Updated Description

            $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
            
            // Define configuration variables
            $this->config_name = 'EPSON_RECEIPT_';
        }

        public function install()
        {
            // Default configuration values
            Configuration::updateValue($this->config_name.'PAPER_WIDTH', '80'); // 80mm default width
            Configuration::updateValue($this->config_name.'SHOW_LOGO', '1'); // Show logo by default
            Configuration::updateValue($this->config_name.'SHOW_BARCODE', '1'); // Show barcode by default
            Configuration::updateValue($this->config_name.'FOOTER_TEXT', 'Thank you for staying with us!'); // Default footer text
            Configuration::updateValue($this->config_name.'CUSTOM_LOGO', ''); // Custom logo filename
            
            // Create the uploads directory for custom logos
            if (!file_exists(dirname(__FILE__).'/views/img/')) {
                mkdir(dirname(__FILE__).'/views/img/', 0755, true);
            }
            
            // REMOVED: SQL installation code
            
            if (!parent::install() ||
                !$this->registerHook('displayAdminOrderLeft') || // Hook for PS 1.6 left column
                !$this->registerHook('displayAdminOrder') ||     // Hook for the order page buttons (top right section)
                !$this->registerHook('displayBackOfficeHeader') || // Hook for adding CSS/JS to admin
                !$this->installTab()) {
                return false;
            }
            return true;
        }

        public function uninstall()
        {
            // Remove all config values
            Configuration::deleteByName($this->config_name.'PAPER_WIDTH');
            Configuration::deleteByName($this->config_name.'SHOW_LOGO');
            Configuration::deleteByName($this->config_name.'SHOW_BARCODE');
            Configuration::deleteByName($this->config_name.'FOOTER_TEXT');
            Configuration::deleteByName($this->config_name.'CUSTOM_LOGO');
            
            // Remove uploaded custom logo if it exists
            $custom_logo = Configuration::get($this->config_name.'CUSTOM_LOGO');
            if (!empty($custom_logo)) {
                $logo_path = dirname(__FILE__).'/views/img/'.$custom_logo;
                if (file_exists($logo_path)) {
                    unlink($logo_path);
                }
            }
            
            // Unregister all hooks
            $this->unregisterHook('displayAdminOrderLeft');
            $this->unregisterHook('displayAdminOrder');
            $this->unregisterHook('displayBackOfficeHeader');
            
            if (!$this->uninstallTab() || !parent::uninstall()) {
                return false;
            }
            return true;
        }

        // Install Controller Tab
        public function installTab()
        {
            $tab = new Tab();
            $tab->active = 1;
            $tab->class_name = 'AdminEpsonReceipt'; // Controller Class Name
            $tab->name = array();
            foreach (Language::getLanguages(true) as $lang) {
                $tab->name[$lang['id_lang']] = 'Guest Folio Print'; // Updated Tab Name
            }
            $tab->id_parent = -1; // Hide from menu
            $tab->module = $this->name;
            return $tab->add();
        }

        // Uninstall Controller Tab
        public function uninstallTab()
        {
            $id_tab = (int)Tab::getIdFromClassName('AdminEpsonReceipt');
            if ($id_tab) {
                $tab = new Tab($id_tab);
                return $tab->delete();
            }
            return true;
        }


        /**
         * Hook to display content in the admin order view (left column in PS 1.6)
         */
        public function hookDisplayAdminOrderLeft($params)
        {
            if (empty($params['id_order'])) {
                return;
            }

            $order = new Order((int)$params['id_order']);
            if (!Validate::isLoadedObject($order)) {
                 return;
            }

            // Generate URL to your module's controller action
            // Note: Using getAdminLink requires the controller to be registered as a Tab
            $controller_link = $this->context->link->getAdminLink('AdminEpsonReceipt', true); // Controller Name, true for token

            $this->context->smarty->assign(array(
                'print_receipt_url' => $controller_link.'&id_order='.(int)$order->id.'&action=printReceipt', // Add params
            ));

            // Use a template file for the button
            return $this->display(__FILE__, 'views/templates/hook/displayAdminOrderLeft.tpl');
        }

        /**
         * Hook to display content in the admin order page (where "View Hotel" button is)
         */
        public function hookDisplayAdminOrder($params)
        {
            // Temporary Debug Output
            error_log("DEBUG: hookDisplayAdminOrder called for order ID: " . (isset($params['id_order']) ? $params['id_order'] : 'N/A'));
            
            if (empty($params['id_order'])) {
                error_log("DEBUG: hookDisplayAdminOrder - No id_order found in params.");
                return;
            }

            $order = new Order((int)$params['id_order']);
            if (!Validate::isLoadedObject($order)) {
                 error_log("DEBUG: hookDisplayAdminOrder - Could not load order object.");
                 return;
            }

            // Generate URL to your module's controller action
            $controller_link = $this->context->link->getAdminLink('AdminEpsonReceipt', true);

            $this->context->smarty->assign(array(
                'print_receipt_url' => $controller_link.'&id_order='.(int)$order->id.'&action=printReceipt',
            ));

            // Use a template file for the button
            try {
                $output = $this->display(__FILE__, 'views/templates/hook/displayAdminOrder.tpl');
                error_log("DEBUG: hookDisplayAdminOrder - Template displayed successfully.");
                return $output;
            } catch (Exception $e) {
                error_log("DEBUG: hookDisplayAdminOrder - Error displaying template: " . $e->getMessage());
                return ''; // Return empty string on error
            }
        }
        
        /**
         * Hook for adding CSS/JS to admin
         */
        public function hookDisplayBackOfficeHeader()
        {
            // Add CSS for styling the button
            $this->context->controller->addCSS($this->_path.'views/css/admin.css', 'all');
        }
        
        // Admin Configuration Page
        public function getContent()
        {
            $output = '';
            
            // Process form submission
            if (Tools::isSubmit('submit'.$this->name)) {
                // Validate and update configuration values
                $paper_width = (string)Tools::getValue($this->config_name.'PAPER_WIDTH');
                if (!Validate::isGenericName($paper_width) || !in_array($paper_width, array('58', '80'))) {
                    $output .= $this->displayError($this->l('Invalid paper width.'));
                } else {
                    Configuration::updateValue($this->config_name.'PAPER_WIDTH', $paper_width);
                }
                
                $show_logo = (int)Tools::getValue($this->config_name.'SHOW_LOGO');
                Configuration::updateValue($this->config_name.'SHOW_LOGO', $show_logo);
                
                $show_barcode = (int)Tools::getValue($this->config_name.'SHOW_BARCODE');
                Configuration::updateValue($this->config_name.'SHOW_BARCODE', $show_barcode);
                
                $footer_text = (string)Tools::getValue($this->config_name.'FOOTER_TEXT');
                if (!Validate::isGenericName($footer_text)) {
                    $output .= $this->displayError($this->l('Invalid footer text.'));
                } else {
                    Configuration::updateValue($this->config_name.'FOOTER_TEXT', $footer_text);
                }
                
                // Handle logo upload
                if (isset($_FILES[$this->config_name.'CUSTOM_LOGO']) && !empty($_FILES[$this->config_name.'CUSTOM_LOGO']['tmp_name'])) {
                    $ext = pathinfo($_FILES[$this->config_name.'CUSTOM_LOGO']['name'], PATHINFO_EXTENSION);
                    
                    // Validate image
                    if (!in_array(strtolower($ext), array('jpg', 'jpeg', 'png', 'gif')) || 
                        !getimagesize($_FILES[$this->config_name.'CUSTOM_LOGO']['tmp_name'])) {
                        $output .= $this->displayError($this->l('Invalid image format. Please use JPG, PNG, or GIF.'));
                    } else {
                        // Generate unique filename
                        $logo_name = 'receipt_logo_'.time().'.'.$ext;
                        $upload_path = dirname(__FILE__).'/views/img/'.$logo_name;
                        
                        // Delete old logo if it exists
                        $old_logo = Configuration::get($this->config_name.'CUSTOM_LOGO');
                        if (!empty($old_logo)) {
                            $old_logo_path = dirname(__FILE__).'/views/img/'.$old_logo;
                            if (file_exists($old_logo_path)) {
                                unlink($old_logo_path);
                            }
                        }
                        
                        // Upload new logo
                        if (move_uploaded_file($_FILES[$this->config_name.'CUSTOM_LOGO']['tmp_name'], $upload_path)) {
                            Configuration::updateValue($this->config_name.'CUSTOM_LOGO', $logo_name);
                        } else {
                            $output .= $this->displayError($this->l('Error uploading logo. Please check directory permissions.'));
                        }
                    }
                }
                
                if (empty($this->context->controller->errors)) {
                    $output .= $this->displayConfirmation($this->l('Settings updated.'));
                }
            }
            
            // Display current logo if it exists
            $current_logo = Configuration::get($this->config_name.'CUSTOM_LOGO');
            if (!empty($current_logo) && file_exists(dirname(__FILE__).'/views/img/'.$current_logo)) {
                $this->context->smarty->assign(array(
                    'receipt_logo_path' => $this->_path.'views/img/'.$current_logo,
                    'receipt_logo_exists' => true
                ));
                $output .= $this->display(__FILE__, 'views/templates/admin/current_logo.tpl');
            }
            
            // Display the config form
            return $output.$this->displayForm();
        }
        
        // Display Configuration Form
        public function displayForm()
        {
            // Get default language
            $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
            
            // Form fields
            $fields_form = array();
            $fields_form[0]['form'] = array(
                'legend' => array(
                    'title' => $this->l('Receipt Printer Settings'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->l('Paper Width'),
                        'name' => $this->config_name.'PAPER_WIDTH',
                        'options' => array(
                            'query' => array(
                                array('id' => '58', 'name' => $this->l('58mm')),
                                array('id' => '80', 'name' => $this->l('80mm'))
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Show Logo'),
                        'name' => $this->config_name.'SHOW_LOGO',
                        'is_bool' => true,
                        'values' => array(
                            array('id' => 'logo_on', 'value' => 1, 'label' => $this->l('Yes')),
                            array('id' => 'logo_off', 'value' => 0, 'label' => $this->l('No'))
                        ),
                        'desc' => $this->l('Display a logo at the top of the receipt')
                    ),
                    array(
                        'type' => 'file',
                        'label' => $this->l('Custom Receipt Logo'),
                        'name' => $this->config_name.'CUSTOM_LOGO',
                        'display_image' => true,
                        'desc' => $this->l('Upload a custom logo for your receipts. If none uploaded, the shop logo will be used.')
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Show Barcode'),
                        'name' => $this->config_name.'SHOW_BARCODE',
                        'is_bool' => true,
                        'values' => array(
                            array('id' => 'barcode_on', 'value' => 1, 'label' => $this->l('Yes')),
                            array('id' => 'barcode_off', 'value' => 0, 'label' => $this->l('No'))
                        ),
                        'desc' => $this->l('Display a barcode of the booking reference at the bottom of the receipt')
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Footer Text'),
                        'name' => $this->config_name.'FOOTER_TEXT',
                        'size' => 50,
                        'required' => false,
                        'desc' => $this->l('Custom text to display at the bottom of the receipt')
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right'
                )
            );
            
            $helper = new HelperForm();
            
            // Module, token and currentIndex
            $helper->module = $this;
            $helper->name_controller = $this->name;
            $helper->token = Tools::getAdminTokenLite('AdminModules');
            $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
            
            // Language
            $helper->default_form_language = $default_lang;
            $helper->allow_employee_form_lang = $default_lang;
            
            // Title and toolbar
            $helper->title = $this->displayName;
            $helper->show_toolbar = true;
            $helper->toolbar_scroll = true;
            $helper->submit_action = 'submit'.$this->name;
            $helper->toolbar_btn = array(
                'save' => array(
                    'desc' => $this->l('Save'),
                    'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
                )
            );
            
            // Load current values
            $helper->fields_value[$this->config_name.'PAPER_WIDTH'] = Configuration::get($this->config_name.'PAPER_WIDTH');
            $helper->fields_value[$this->config_name.'SHOW_LOGO'] = Configuration::get($this->config_name.'SHOW_LOGO');
            $helper->fields_value[$this->config_name.'SHOW_BARCODE'] = Configuration::get($this->config_name.'SHOW_BARCODE');
            $helper->fields_value[$this->config_name.'FOOTER_TEXT'] = Configuration::get($this->config_name.'FOOTER_TEXT');
            // Note: File inputs don't use fields_value directly for the current value.
            // The preview is handled separately in getContent().
            
            return $helper->generateForm($fields_form);
        }
    }
