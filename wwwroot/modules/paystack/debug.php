<?php
/*
* Debug file for Paystack Module
*/

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load PrestaShop configuration
require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');

// Basic module integrity check
echo "<h1>Paystack Module Debug</h1>";

// Test transaction options
echo "<div style='margin: 20px 0; padding: 15px; background: #f8f8f8; border: 1px solid #ddd; border-radius: 4px;'>";
echo "<h2>Test Transaction</h2>";
echo "<p>Use these credentials for testing:</p>";
echo "<ul>";
echo "<li><strong>Card Number:</strong> 4084 0840 8408 4081</li>";
echo "<li><strong>Expiry Date:</strong> Any future date (e.g., 01/30)</li>";
echo "<li><strong>CVV:</strong> 408</li>";
echo "<li><strong>PIN:</strong> 0000</li>";
echo "<li><strong>OTP:</strong> 123456</li>";
echo "</ul>";

echo "<p><a href='controllers/front/payment.php' class='button' style='display: inline-block; padding: 10px 15px; background: #4CAF50; color: white; text-decoration: none; border-radius: 4px;'>Test Payment Process</a></p>";
echo "</div>";

// Check recent logs
echo "<h2>Recent Logs</h2>";
echo "<div style='max-height: 300px; overflow-y: auto; background: #f5f5f5; padding: 10px; border: 1px solid #ddd; margin-bottom: 20px;'>";
echo "<pre>";

// Try to access PrestaShop logs
try {
    $db = Db::getInstance();
    $logs = $db->executeS('SELECT id_log, severity_id, message, object_type, object_id, date_add 
                          FROM '._DB_PREFIX_.'log 
                          WHERE message LIKE "%paystack%" 
                          ORDER BY date_add DESC LIMIT 30');
    
    if ($logs && count($logs) > 0) {
        foreach ($logs as $log) {
            $severity = '';
            switch ($log['severity_id']) {
                case 1: $severity = 'INFO'; break;
                case 2: $severity = 'WARNING'; break;
                case 3: $severity = 'ERROR'; break;
                case 4: $severity = 'CRITICAL'; break;
                default: $severity = 'UNKNOWN';
            }
            
            echo "[{$log['date_add']}] {$severity}: {$log['message']}";
            if (!empty($log['object_type']) && !empty($log['object_id'])) {
                echo " ({$log['object_type']} #{$log['object_id']})";
            }
            echo "\n";
        }
    } else {
        echo "No Paystack-related logs found.";
    }
} catch (Exception $e) {
    echo "Error retrieving logs: " . $e->getMessage();
}

echo "</pre>";
echo "</div>";

// Check PHP and server environment
echo "<h2>Server Environment</h2>";
echo "<ul>";
echo "<li>PHP Version: " . phpversion() . "</li>";
echo "<li>PrestaShop Version: " . _PS_VERSION_ . "</li>";
echo "<li>Server: " . $_SERVER['SERVER_SOFTWARE'] . "</li>";
echo "<li>Loaded Extensions: ";
$extensions = get_loaded_extensions();
echo implode(', ', array_slice($extensions, 0, 10)) . "... and " . (count($extensions) - 10) . " more.</li>";
echo "</ul>";

// Check if module exists and is installed
echo "<h2>Module Status</h2>";
if (Module::isInstalled('paystack')) {
    echo "<p style='color:green'>✓ Module is installed</p>";
} else {
    echo "<p style='color:red'>✗ Module is NOT installed</p>";
}

// Check configuration
echo "<h2>Configuration</h2>";
$keys = array(
    'PAYSTACK_MODE',
    'PAYSTACK_TEST_PUBLICKEY',
    'PAYSTACK_TEST_SECRETKEY',
    'PAYSTACK_LIVE_PUBLICKEY',
    'PAYSTACK_LIVE_SECRETKEY'
);

echo "<ul>";
foreach ($keys as $key) {
    $value = Configuration::get($key);
    $status = !empty($value) ? "✓" : "✗";
    $color = !empty($value) ? "green" : "red";
    echo "<li style='color:$color'>$status $key: " . (!empty($value) ? "Set" : "Not set") . "</li>";
}
echo "</ul>";

// Check file structure
echo "<h2>File Structure</h2>";
$requiredFiles = array(
    '/paystack.php',
    '/index.php',
    '/config.xml',
    '/controllers/front/payment.php',
    '/controllers/front/validation.php',
    '/controllers/front/paystacksuccess.php',
    '/views/templates/front/payment_execution.tpl',
    '/payment_execution.tpl',
    '/card-logos.png'
);

echo "<ul>";
foreach ($requiredFiles as $file) {
    $filePath = dirname(__FILE__) . $file;
    $status = file_exists($filePath) ? "✓" : "✗";
    $color = file_exists($filePath) ? "green" : "red";
    echo "<li style='color:$color'>$status $file: " . (file_exists($filePath) ? "Exists" : "Missing") . "</li>";
    
    // If it's a PHP file and it exists, check for syntax errors
    if (file_exists($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) == 'php') {
        $output = array();
        $return_var = 0;
        exec("php -l " . escapeshellarg($filePath), $output, $return_var);
        if ($return_var !== 0) {
            echo "<li style='color:red; margin-left: 20px;'>✗ Syntax error in file! " . implode(", ", $output) . "</li>";
        }
    }
}
echo "</ul>";

// Try to create a simple test file to check write permissions
$testFile = dirname(__FILE__) . '/test_write_permission.txt';
$writeTest = @file_put_contents($testFile, 'Test write permission');
if ($writeTest === false) {
    echo "<p style='color:red'>✗ The module directory is not writable. Please check folder permissions.</p>";
} else {
    echo "<p style='color:green'>✓ Module directory is writable.</p>";
    @unlink($testFile); // Remove the test file
}

echo "<h2>Apache Error Log (Last 10 Entries)</h2>";
$errorLogPath = "C:/xampp/apache/logs/error.log";
if (file_exists($errorLogPath)) {
    $errorLog = file($errorLogPath);
    $lastEntries = array_slice($errorLog, -10);
    echo "<pre>";
    foreach ($lastEntries as $entry) {
        echo htmlspecialchars($entry);
    }
    echo "</pre>";
} else {
    echo "<p>Error log not found at $errorLogPath</p>";
}

echo "<p>If you see any red items above, please ensure all the required files are present and properly configured.</p>";
?>
