<?php
// This script fixes the Paystack module hooks for QloApps compatibility

// Set the correct table prefix for QloApps
define('_DB_PREFIX_', 'qlooo_');

// Load PrestaShop configuration
define('_PS_ADMIN_DIR_', 1);
include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');

// Get the module ID
$sql = 'SELECT id_module FROM '._DB_PREFIX_.'module WHERE name = "paystack"';
$result = Db::getInstance()->getRow($sql);

if (empty($result)) {
    die('Paystack module not found in database. Please install it first.');
}

$id_module = $result['id_module'];
echo "Paystack module ID: ".$id_module."<br>";

// Check if module is active
$sql = 'SELECT active FROM '._DB_PREFIX_.'module WHERE id_module = '.$id_module;
$active = Db::getInstance()->getValue($sql);

if (!$active) {
    // Activate the module
    $sql = 'UPDATE '._DB_PREFIX_.'module SET active = 1 WHERE id_module = '.$id_module;
    if (Db::getInstance()->execute($sql)) {
        echo "Module activated successfully.<br>";
    } else {
        echo "Failed to activate module.<br>";
    }
}

// List of hooks needed for payment modules in QloApps
$hooks = array(
    'paymentOptions',
    'displayPaymentReturn',
    'displayPayment',  // For QloApps compatibility
    'payment',         // For QloApps compatibility
    'displayPaymentTop',
    'displayOrderConfirmation',
    'actionPaymentConfirmation'
);

// Register hooks
foreach ($hooks as $hook_name) {
    // Check if hook exists
    $sql = 'SELECT id_hook FROM '._DB_PREFIX_.'hook WHERE name = "'.$hook_name.'"';
    $hook_id = Db::getInstance()->getValue($sql);
    
    if (!$hook_id) {
        echo "Hook '".$hook_name."' does not exist in database. Creating it...<br>";
        
        // Create the hook
        $sql = 'INSERT INTO '._DB_PREFIX_.'hook (name, title, description, position) 
                VALUES ("'.$hook_name.'", "'.$hook_name.'", "Hook for '.$hook_name.'", 1)';
        if (Db::getInstance()->execute($sql)) {
            $hook_id = Db::getInstance()->Insert_ID();
            echo "Hook '".$hook_name."' created with ID: ".$hook_id."<br>";
        } else {
            echo "Failed to create hook '".$hook_name."'.<br>";
            continue;
        }
    }
    
    // Check if module is already hooked
    $sql = 'SELECT id_hook_module FROM '._DB_PREFIX_.'hook_module 
            WHERE id_module = '.$id_module.' AND id_hook = '.$hook_id;
    $is_hooked = Db::getInstance()->getValue($sql);
    
    if (!$is_hooked) {
        // Get max position
        $sql = 'SELECT MAX(position) FROM '._DB_PREFIX_.'hook_module WHERE id_hook = '.$hook_id;
        $position = Db::getInstance()->getValue($sql);
        $position = $position ? $position + 1 : 1;
        
        // Hook the module
        $sql = 'INSERT INTO '._DB_PREFIX_.'hook_module (id_module, id_hook, position) 
                VALUES ('.$id_module.', '.$hook_id.', '.$position.')';
        if (Db::getInstance()->execute($sql)) {
            echo "Module hooked to '".$hook_name."' successfully.<br>";
        } else {
            echo "Failed to hook module to '".$hook_name."'.<br>";
        }
    } else {
        echo "Module is already hooked to '".$hook_name."'.<br>";
    }
}

// Check if we need to register for specific shop
$sql = 'SELECT id_shop FROM '._DB_PREFIX_.'shop';
$shops = Db::getInstance()->executeS($sql);

if (count($shops) > 1) {
    echo "<br>Multiple shops detected. Ensuring module is enabled for all shops...<br>";
    
    foreach ($shops as $shop) {
        $id_shop = $shop['id_shop'];
        
        // Check if module is enabled for this shop
        $sql = 'SELECT id_module FROM '._DB_PREFIX_.'module_shop 
                WHERE id_module = '.$id_module.' AND id_shop = '.$id_shop;
        $is_enabled = Db::getInstance()->getValue($sql);
        
        if (!$is_enabled) {
            // Enable module for this shop
            $sql = 'INSERT INTO '._DB_PREFIX_.'module_shop (id_module, id_shop) 
                    VALUES ('.$id_module.', '.$id_shop.')';
            if (Db::getInstance()->execute($sql)) {
                echo "Module enabled for shop ID: ".$id_shop."<br>";
            } else {
                echo "Failed to enable module for shop ID: ".$id_shop."<br>";
            }
        } else {
            echo "Module is already enabled for shop ID: ".$id_shop."<br>";
        }
    }
}

echo "<br>Hook registration complete. Please clear your cache:<br>";
echo "1. Go to Advanced Parameters > Performance<br>";
echo "2. Click 'Clear Cache'<br>";
echo "<br>After clearing the cache, the Paystack payment method should appear on your checkout page.<br>";
echo "<br>You can delete this script now.";
