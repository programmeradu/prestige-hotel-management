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

// This script helps with installation and transplanting of the module
// It can be run from the command line using: php install.php

// Load PrestaShop configuration
include_once(dirname(__FILE__).'/../../config/config.inc.php');
include_once(dirname(__FILE__).'/../../init.php');

// Check if the module is already installed
$module = Module::getInstanceByName('ghanapayments');
if (!$module) {
    die('Module not found. Make sure the module is in the correct directory and named "ghanapayments".');
}

echo "Starting GhanaPayments module installation process...\n";

// If module is not installed, install it
if (!$module->isInstalled('ghanapayments')) {
    try {
        echo "Installing module...\n";
        
        // Make sure to enable overrides for QloApps
        Configuration::updateValue('PS_DISABLE_OVERRIDES', 0);
        
        // Clear the cache to make sure QloApps recognizes the module
        if (method_exists('Tools', 'clearCache')) {
            Tools::clearCache();
        }
        
        if ($module->install()) {
            echo "Module installed successfully!\n";
            
            // Double-check that the module is registered in the modules table
            $check_installed = Db::getInstance()->getValue("SELECT `id_module` FROM `"._DB_PREFIX_."module` WHERE `name` = 'ghanapayments'");
            if (!$check_installed) {
                echo "Warning: Module not found in database, manually inserting...\n";
                Db::getInstance()->insert('module', [
                    'name' => 'ghanapayments',
                    'active' => 1,
                    'version' => $module->version
                ]);
            }
        } else {
            echo "Failed to install module. Checking for specific issues...\n";
            
            // Check SQL directory exists
            if (!is_dir(dirname(__FILE__).'/sql')) {
                echo "Error: SQL directory missing - creating it now.\n";
                mkdir(dirname(__FILE__).'/sql', 0755, true);
            }
            
            // Check permissions
            $dirs_to_check = [
                dirname(__FILE__).'/sql',
                dirname(__FILE__).'/views',
                dirname(__FILE__).'/views/img',
                dirname(__FILE__).'/views/css',
                dirname(__FILE__).'/views/js',
            ];
            
            foreach ($dirs_to_check as $dir) {
                if (!is_writable($dir)) {
                    echo "Error: Directory $dir is not writable. Please check permissions.\n";
                }
            }
            
            die("Installation failed. Please check the issues above and try again.\n");
        }
    } catch (Exception $e) {
        die("Exception during installation: ".$e->getMessage()."\n");
    }
} else {
    echo "Module is already installed.\n";
}

// Force transplant to hooks
echo "Transplanting module to hooks...\n";

// Get module ID
$id_module = (int)$module->id;

// Define hooks to transplant to
$hooks = [
    'paymentOptions',
    'paymentReturn',
    'header',
    'displayPayment',
    'displayPaymentReturn',
    'displayOrderConfirmation',
    'displayAdminOrder',
    'actionOrderStatusUpdate'
];

// Transplant module to each hook
$success_count = 0;
foreach ($hooks as $hook_name) {
    // Get hook ID
    $id_hook = (int)Hook::getIdByName($hook_name);
    if (!$id_hook) {
        echo "Hook $hook_name not found, skipping...\n";
        continue;
    }
    
    // Check if module is already transplanted to this hook
    $sql = 'SELECT COUNT(*) FROM `'._DB_PREFIX_.'hook_module` 
            WHERE `id_module` = '.(int)$id_module.' 
            AND `id_hook` = '.(int)$id_hook;
    $is_transplanted = (bool)Db::getInstance()->getValue($sql);
    
    // If not transplanted, add it
    if (!$is_transplanted) {
        $sql = 'SELECT MAX(`position`) AS position FROM `'._DB_PREFIX_.'hook_module` 
                WHERE `id_hook` = '.(int)$id_hook;
        $position = (int)Db::getInstance()->getValue($sql) + 1;
        
        Db::getInstance()->insert('hook_module', [
            'id_module' => (int)$id_module,
            'id_hook' => (int)$id_hook,
            'position' => (int)$position,
        ]);
        
        // Also add to hook_module_exceptions if needed for specific pages
        if (in_array($hook_name, ['displayPayment', 'paymentOptions'])) {
            // Add to payment page
            $id_shop = (int)Context::getContext()->shop->id;
            $pages = ['order', 'order-opc'];
            
            foreach ($pages as $page) {
                $id_page = (int)Db::getInstance()->getValue(
                    'SELECT `id_meta` FROM `'._DB_PREFIX_.'meta` WHERE `page` = "'.pSQL($page).'"'
                );
                
                if ($id_page) {
                    Db::getInstance()->insert('hook_module_exceptions', [
                        'id_module' => (int)$id_module,
                        'id_hook' => (int)$id_hook,
                        'id_shop' => (int)$id_shop,
                        'file_name' => pSQL($page),
                    ]);
                }
            }
        }
        
        echo "Module transplanted to hook $hook_name successfully.\n";
        $success_count++;
    } else {
        echo "Module already transplanted to hook $hook_name.\n";
    }
}

// Create order states if they don't exist
echo "Checking order states...\n";

// Create Cash Payment Waiting state
if (!Configuration::get('GHANAPAYMENTS_OS_CASH_WAITING')) {
    $order_state = new OrderState();
    $order_state->name = [];
    foreach (Language::getLanguages() as $language) {
        $order_state->name[$language['id_lang']] = 'Awaiting Cash Payment';
    }
    $order_state->send_email = false;
    $order_state->color = '#FFEAA7';
    $order_state->hidden = false;
    $order_state->delivery = false;
    $order_state->logable = false;
    $order_state->invoice = false;
    $order_state->module_name = 'ghanapayments';
    if ($order_state->add()) {
        Configuration::updateValue('GHANAPAYMENTS_OS_CASH_WAITING', (int)$order_state->id);
        echo "Created 'Awaiting Cash Payment' order state.\n";
    }
} else {
    echo "'Awaiting Cash Payment' order state already exists.\n";
}

// Create Mobile Money Waiting state
if (!Configuration::get('GHANAPAYMENTS_OS_MOMO_WAITING')) {
    $order_state = new OrderState();
    $order_state->name = [];
    foreach (Language::getLanguages() as $language) {
        $order_state->name[$language['id_lang']] = 'Awaiting Mobile Money Verification';
    }
    $order_state->send_email = false;
    $order_state->color = '#F1C40F';
    $order_state->hidden = false;
    $order_state->delivery = false;
    $order_state->logable = false;
    $order_state->invoice = false;
    $order_state->module_name = 'ghanapayments';
    if ($order_state->add()) {
        Configuration::updateValue('GHANAPAYMENTS_OS_MOMO_WAITING', (int)$order_state->id);
        echo "Created 'Awaiting Mobile Money Verification' order state.\n";
    }
} else {
    echo "'Awaiting Mobile Money Verification' order state already exists.\n";
}

// Create Paystack Payment Waiting state
if (!Configuration::get('GHANAPAYMENTS_OS_PAYSTACK_WAITING')) {
    $order_state = new OrderState();
    $order_state->name = [];
    foreach (Language::getLanguages() as $language) {
        $order_state->name[$language['id_lang']] = 'Awaiting Paystack Payment';
    }
    $order_state->send_email = false;
    $order_state->color = '#3498DB';
    $order_state->hidden = false;
    $order_state->delivery = false;
    $order_state->logable = false;
    $order_state->invoice = false;
    $order_state->module_name = 'ghanapayments';
    if ($order_state->add()) {
        Configuration::updateValue('GHANAPAYMENTS_OS_PAYSTACK_WAITING', (int)$order_state->id);
        echo "Created 'Awaiting Paystack Payment' order state.\n";
    }
} else {
    echo "'Awaiting Paystack Payment' order state already exists.\n";
}

echo "\nInstallation and transplantation process completed!\n";
echo "Transplanted to $success_count hooks successfully.\n";
echo "You can now configure the module in the PrestaShop back office.\n";
