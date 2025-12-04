<?php
// This is a temporary script to register the Paystack module in the database

// Set the correct table prefix for QloApps
define('_DB_PREFIX_', 'qlooo_');

// Load PrestaShop configuration
define('_PS_ADMIN_DIR_', 1);
include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');

// Check if module exists in file system
$module_dir = _PS_MODULE_DIR_.'paystack';
if (!file_exists($module_dir)) {
    die('Module directory not found: '.$module_dir);
}

// Check if module is already registered in database
$sql = 'SELECT * FROM '._DB_PREFIX_.'module WHERE name = "paystack"';
$result = Db::getInstance()->executeS($sql);

if (empty($result)) {
    // Module not in database, register it
    $module = Module::getInstanceByName('paystack');
    if ($module) {
        echo "Module instance created successfully.<br>";
        
        // Register in database
        $sql = 'INSERT INTO '._DB_PREFIX_.'module (name, active, version) VALUES ("paystack", 0, "'.$module->version.'")';
        if (Db::getInstance()->execute($sql)) {
            echo "Module registered in database successfully.<br>";
            
            // Get the module ID
            $id_module = Db::getInstance()->Insert_ID();
            echo "Module ID: ".$id_module."<br>";
            
            // Add to hook modules_list
            $sql = 'INSERT INTO '._DB_PREFIX_.'hook_module (id_module, id_hook, position) 
                   VALUES ('.$id_module.', (SELECT id_hook FROM '._DB_PREFIX_.'hook WHERE name = "displayPaymentReturn"), 1)';
            if (Db::getInstance()->execute($sql)) {
                echo "Module hooked to displayPaymentReturn.<br>";
            }
            
            $sql = 'INSERT INTO '._DB_PREFIX_.'hook_module (id_module, id_hook, position) 
                   VALUES ('.$id_module.', (SELECT id_hook FROM '._DB_PREFIX_.'hook WHERE name = "paymentOptions"), 1)';
            if (Db::getInstance()->execute($sql)) {
                echo "Module hooked to paymentOptions.<br>";
            }
            
            echo "Now you should be able to see and install the module from the module manager.<br>";
        } else {
            echo "Failed to register module in database.<br>";
        }
    } else {
        echo "Failed to create module instance.<br>";
    }
} else {
    echo "Module is already registered in database with ID: ".$result[0]['id_module']."<br>";
    echo "Check if it's active: ".($result[0]['active'] ? 'Yes' : 'No')."<br>";
}

// Clean up database if module is registered but not active
if (!empty($result) && !$result[0]['active']) {
    echo "Module is registered but not active. You should be able to see it in the module manager.<br>";
    echo "If not, try clearing the cache:<br>";
    echo "1. Go to Advanced Parameters > Performance<br>";
    echo "2. Click 'Clear Cache'<br>";
}

echo "<br>Done. You can delete this script now.";
