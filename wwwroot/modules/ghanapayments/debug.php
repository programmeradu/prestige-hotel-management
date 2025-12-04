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

// Debug only - remove or protect with password in production
// Access via: /modules/ghanapayments/debug.php

if (!defined('_PS_VERSION_')) {
    include_once('../../config/config.inc.php');
    include_once('../../init.php');
}

// Only allow if in dev mode or explicitly enabled
if (defined('_PS_MODE_DEV_') && !_PS_MODE_DEV_) {
    die('Debug mode only available when _PS_MODE_DEV_ is enabled');
}

echo '<h1>GhanaPayments Debug Info</h1>';
echo '<h2>Module Status</h2>';
$module = Module::getInstanceByName('ghanapayments');
echo 'Module exists: ' . ($module ? 'Yes' : 'No') . '<br>';
echo 'Module active: ' . ($module && $module->active ? 'Yes' : 'No') . '<br>';
echo 'Module version: ' . ($module ? $module->version : 'N/A') . '<br>';

echo '<h2>Configuration</h2>';
echo 'GHANAPAYMENTS_CASH_ENABLED: ' . Configuration::get('GHANAPAYMENTS_CASH_ENABLED') . '<br>';
echo 'GHANAPAYMENTS_MOMO_ENABLED: ' . Configuration::get('GHANAPAYMENTS_MOMO_ENABLED') . '<br>';
echo 'GHANAPAYMENTS_PAYSTACK_ENABLED: ' . Configuration::get('GHANAPAYMENTS_PAYSTACK_ENABLED') . '<br>';
echo 'GHANAPAYMENTS_PAYSTACK_TEST_MODE: ' . Configuration::get('GHANAPAYMENTS_PAYSTACK_TEST_MODE') . '<br>';
echo 'Paystack Public Key available: ' . (Configuration::get('GHANAPAYMENTS_PAYSTACK_TEST_PUBLIC_KEY') ? 'Yes' : 'No') . '<br>';

echo '<h2>Hook Registration</h2>';
echo '<table border="1">';
echo '<tr><th>Hook Name</th><th>Registered</th></tr>';
$hooks = [
    'payment', 
    'paymentOptions', 
    'paymentReturn', 
    'displayPaymentEU',
    'header', 
    'displayPayment', 
    'displayOrderConfirmation', 
    'displayAdminOrder'
];

foreach ($hooks as $hook_name) {
    $is_registered = Hook::isModuleRegisteredOnHook($module, $hook_name, Context::getContext()->shop->id);
    echo '<tr><td>' . $hook_name . '</td><td>' . ($is_registered ? 'Yes' : 'No') . '</td></tr>';
}
echo '</table>';

echo '<h2>File Checks</h2>';
echo '<table border="1">';
echo '<tr><th>File Path</th><th>Exists</th></tr>';
$files = [
    '/controllers/front/validation.php',
    '/controllers/front/payment.php',
    '/controllers/front/paystack.php',
    '/views/templates/front/momo.tpl',
    '/views/templates/front/paystack.tpl',
    '/views/templates/hook/payment.tpl',
    '/views/templates/hook/payment_return_cash.tpl',
    '/views/templates/hook/payment_return_momo.tpl',
    '/views/templates/hook/payment_return_paystack.tpl',
    '/views/templates/hook/admin_order_left.tpl',
    '/views/css/front.css',
    '/views/img/cash.png',
    '/views/img/momo.png',
    '/views/img/paystack.png'
];

foreach ($files as $file) {
    $path = _PS_MODULE_DIR_ . 'ghanapayments' . $file;
    echo '<tr><td>' . $path . '</td><td>' . (file_exists($path) ? 'Yes' : 'No') . '</td></tr>';
}
echo '</table>';

echo '<h2>Test Links</h2>';
echo '<a href="' . Context::getContext()->link->getModuleLink('ghanapayments', 'validation', ['method' => 'cash']) . '" target="_blank">Cash Payment Test Link</a><br>';
echo '<a href="' . Context::getContext()->link->getModuleLink('ghanapayments', 'payment', ['method' => 'momo']) . '" target="_blank">Mobile Money Test Link</a><br>';
echo '<a href="' . Context::getContext()->link->getModuleLink('ghanapayments', 'paystack') . '" target="_blank">Paystack Test Link</a><br>';
?>
