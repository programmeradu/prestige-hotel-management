<?php
/**
* 2007-2025 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2025 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

$sql = array();

// Create tables for any transaction logs we might need
$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ghanapayments_transactions` (
    `id_transaction` int(11) NOT NULL AUTO_INCREMENT,
    `id_order` int(11) NOT NULL,
    `transaction_id` varchar(255) NOT NULL,
    `payment_method` varchar(64) NOT NULL,
    `amount` decimal(20,6) NOT NULL,
    `status` varchar(64) NOT NULL,
    `date_add` datetime NOT NULL,
    `date_upd` datetime NOT NULL,
    PRIMARY KEY  (`id_transaction`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

// There are no tables to create, but we'll initialize some configuration values
$config_values = array(
    'GHANAPAYMENTS_LIVE_MODE' => '0',
    'GHANAPAYMENTS_DEBUG_MODE' => '0',
    'GHANAPAYMENTS_MOMO_ENABLED' => '1',
    'GHANAPAYMENTS_MOMO_TITLE' => 'Pay with Mobile Money',
    'GHANAPAYMENTS_MOMO_DESCRIPTION' => 'Pay using MTN, Vodafone, or AirtelTigo Mobile Money',
    'GHANAPAYMENTS_MOMO_NUMBER' => '0XXXXXXXXX',
    'GHANAPAYMENTS_MOMO_INSTRUCTIONS' => 'Send the payment to our Mobile Money number, then enter your transaction ID to confirm payment.',
    'GHANAPAYMENTS_CASH_ENABLED' => '1',
    'GHANAPAYMENTS_CASH_TITLE' => 'Pay at Check-in',
    'GHANAPAYMENTS_CASH_DESCRIPTION' => 'Pay in cash when you arrive at our location',
    'GHANAPAYMENTS_PAYSTACK_ENABLED' => '1',
    'GHANAPAYMENTS_PAYSTACK_TITLE' => 'Pay with Card (via Paystack)',
    'GHANAPAYMENTS_PAYSTACK_DESCRIPTION' => 'Pay securely with credit/debit card via Paystack',
    'GHANAPAYMENTS_PAYSTACK_TEST_MODE' => '1',
);

foreach ($config_values as $key => $value) {
    if (!Configuration::hasKey($key)) {
        Configuration::updateValue($key, $value);
    }
}

// Execute all SQL queries
foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
