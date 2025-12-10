<?php
/**
 * Cron endpoint for Abandoned Cart Alerts
 * 
 * Add this URL to your cron module:
 * https://prestigehotel.org/modules/abandonedcartalerts/cron.php?token=YOUR_SECURE_TOKEN
 */

// Security token - change this to a random string!
$secureToken = 'prestige_abandoned_alerts_2024';

// Verify token
if (!isset($_GET['token']) || $_GET['token'] !== $secureToken) {
    header('HTTP/1.1 403 Forbidden');
    die('Access denied. Invalid or missing token.');
}

// Load PrestaShop
$configPath = dirname(__FILE__) . '/../../config/config.inc.php';
if (!file_exists($configPath)) {
    die('PrestaShop config not found');
}

require_once($configPath);

// Get module and run
$module = Module::getInstanceByName('abandonedcartalerts');

if (!$module) {
    die('Module not found or not installed');
}

// Check if module is enabled
if (!$module->active) {
    die('Module is disabled');
}

// Execute the alert sending
$result = $module->sendAbandonedCartAlerts();

// Output result
header('Content-Type: application/json');
echo json_encode(array(
    'success' => true,
    'timestamp' => date('Y-m-d H:i:s'),
    'result' => $result
));
