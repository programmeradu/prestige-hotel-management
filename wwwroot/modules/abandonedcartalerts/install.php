<?php
/**
 * Install script for the Abandoned Cart Alerts module
 * 
 * Access this via: https://yoursite.com/modules/abandonedcartalerts/install.php
 * DELETE THIS FILE after installation!
 */

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h2>Module Install Script</h2>";
echo "<pre>";

// Load PrestaShop
$configPath = dirname(__FILE__) . '/../../config/config.inc.php';
if (!file_exists($configPath)) {
    die("Could not find PrestaShop config");
}

require_once($configPath);

echo "PrestaShop loaded: " . _PS_VERSION_ . "\n\n";

// Get module instance
$moduleName = 'abandonedcartalerts';
echo "Installing module: $moduleName\n";

try {
    // Check if already installed
    $installed = Db::getInstance()->getValue(
        "SELECT id_module FROM " . _DB_PREFIX_ . "module WHERE name = '" . pSQL($moduleName) . "'"
    );
    
    if ($installed) {
        echo "❌ Module is already installed (id: $installed)\n";
        echo "\nTo reinstall, first uninstall it manually or run:\n";
        echo "DELETE FROM " . _DB_PREFIX_ . "module WHERE name = '$moduleName';\n";
    } else {
        // Load and install the module
        $module = Module::getInstanceByName($moduleName);
        
        if ($module) {
            echo "Module loaded successfully\n";
            echo "Attempting to install...\n\n";
            
            $result = $module->install();
            
            if ($result) {
                echo "✅ SUCCESS! Module installed!\n\n";
                echo "The module is now registered and should appear in:\n";
                echo "Back Office → Modules and Services → Installed Modules\n";
                echo "Or search for 'Abandoned'\n";
            } else {
                echo "❌ Installation failed.\n";
                
                // Check for errors
                if (isset($module->_errors) && is_array($module->_errors)) {
                    echo "Errors:\n";
                    foreach ($module->_errors as $error) {
                        echo "  - $error\n";
                    }
                }
            }
        } else {
            echo "❌ Could not load module instance\n";
        }
    }
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n</pre>";
echo "<hr>";
echo "<p><strong style='color:red;'>DELETE this install.php file immediately after use!</strong></p>";
