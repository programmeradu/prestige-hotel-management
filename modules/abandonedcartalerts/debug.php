<?php
/**
 * Debug script to test module loading
 * 
 * Access this via: https://yoursite.com/modules/abandonedcartalerts/debug.php
 * DELETE THIS FILE after debugging!
 */

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>Module Debug Script</h2>";
echo "<pre>";

// Step 1: Check PHP version
echo "1. PHP Version: " . PHP_VERSION . "\n";

// Step 2: Try to find config
$configPaths = array(
    dirname(__FILE__) . '/../../config/config.inc.php',
    dirname(__FILE__) . '/../../../config/config.inc.php',
);

$configFound = false;
foreach ($configPaths as $path) {
    echo "   Checking: $path ... ";
    if (file_exists($path)) {
        echo "FOUND\n";
        $configFound = $path;
        break;
    } else {
        echo "not found\n";
    }
}

if (!$configFound) {
    echo "\n❌ ERROR: Could not find PrestaShop config.inc.php\n";
    exit;
}

// Step 3: Load PrestaShop
echo "\n2. Loading PrestaShop config...\n";
try {
    require_once($configFound);
    echo "   ✅ PrestaShop config loaded successfully\n";
    echo "   PS Version: " . _PS_VERSION_ . "\n";
    echo "   DB Prefix: " . _DB_PREFIX_ . "\n";
} catch (Exception $e) {
    echo "   ❌ ERROR loading config: " . $e->getMessage() . "\n";
    exit;
}

// Step 4: Check module file
echo "\n3. Checking module file...\n";
$moduleFile = dirname(__FILE__) . '/abandonedcartalerts.php';
echo "   Path: $moduleFile\n";
if (file_exists($moduleFile)) {
    echo "   ✅ Module file exists\n";
    echo "   Size: " . filesize($moduleFile) . " bytes\n";
} else {
    echo "   ❌ Module file NOT found\n";
    exit;
}

// Step 5: Check syntax by including file
echo "\n4. Testing PHP syntax...\n";
try {
    // Capture any output/errors
    ob_start();
    $result = include_once($moduleFile);
    $output = ob_get_clean();
    
    if ($output) {
        echo "   Output during include: $output\n";
    }
    
    echo "   ✅ File included without fatal errors\n";
} catch (Exception $e) {
    echo "   ❌ ERROR: " . $e->getMessage() . "\n";
}

// Step 6: Check class exists
echo "\n5. Checking class...\n";
$className = 'Abandonedcartalerts';
if (class_exists($className)) {
    echo "   ✅ Class '$className' exists\n";
} else {
    echo "   ❌ Class '$className' NOT found\n";
    
    // Check other possible names
    $altNames = array('AbandonedCartAlerts', 'abandonedcartalerts', 'ABANDONEDCARTALERTS');
    foreach ($altNames as $alt) {
        if (class_exists($alt)) {
            echo "   Found alternative class: $alt\n";
        }
    }
}

// Step 7: Try to instantiate
echo "\n6. Trying to instantiate module...\n";
try {
    if (class_exists($className)) {
        $module = new $className();
        echo "   ✅ Module instantiated successfully\n";
        echo "   Name: " . $module->name . "\n";
        echo "   Display Name: " . $module->displayName . "\n";
        echo "   Version: " . $module->version . "\n";
        echo "   Tab: " . $module->tab . "\n";
    }
} catch (Exception $e) {
    echo "   ❌ ERROR instantiating: " . $e->getMessage() . "\n";
}

// Step 8: Check if module is in database
echo "\n7. Checking database registration...\n";
try {
    $dbResult = Db::getInstance()->getValue(
        "SELECT id_module FROM " . _DB_PREFIX_ . "module WHERE name = 'abandonedcartalerts'"
    );
    if ($dbResult) {
        echo "   Module is registered in database (id: $dbResult)\n";
    } else {
        echo "   Module is NOT registered in database\n";
    }
} catch (Exception $e) {
    echo "   ❌ DB ERROR: " . $e->getMessage() . "\n";
}

// Step 9: List all registered modules in same category
echo "\n8. Modules in 'administration' category:\n";
try {
    $modules = Db::getInstance()->executeS(
        "SELECT m.name, m.active FROM " . _DB_PREFIX_ . "module m WHERE m.name LIKE '%dash%' OR m.name LIKE '%admin%' LIMIT 10"
    );
    foreach ($modules as $mod) {
        echo "   - " . $mod['name'] . " (active: " . $mod['active'] . ")\n";
    }
} catch (Exception $e) {
    echo "   ❌ ERROR: " . $e->getMessage() . "\n";
}

// Step 10: Try PrestaShop's module loader
echo "\n9. Trying PrestaShop's Module::getInstanceByName...\n";
try {
    $instance = Module::getInstanceByName('abandonedcartalerts');
    if ($instance) {
        echo "   ✅ PrestaShop can load the module!\n";
        echo "   Class: " . get_class($instance) . "\n";
    } else {
        echo "   ❌ PrestaShop returned NULL for this module\n";
    }
} catch (Exception $e) {
    echo "   ❌ ERROR: " . $e->getMessage() . "\n";
}

echo "\n</pre>";
echo "<hr>";
echo "<p><strong>DELETE this debug.php file after troubleshooting!</strong></p>";
