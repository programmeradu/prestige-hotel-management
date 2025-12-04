<?php
/**
 * MTN Mobile Money Payment Module
 * SQL installation script
 */

// Check if this script is being run directly
if (!defined('_PS_VERSION_')) {
    // Include necessary PrestaShop files for standalone execution
    require_once(dirname(__FILE__).'/../../../config/config.inc.php');
    require_once(dirname(__FILE__).'/../../../init.php');
}

// Now we should have access to the PrestaShop environment
$sql = array();

// Create transactions table
$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'mtnmomo_transaction` (
    `id_transaction` int(11) NOT NULL AUTO_INCREMENT,
    `id_cart` int(11) NOT NULL,
    `id_order` int(11) DEFAULT NULL,
    `reference` varchar(100) NOT NULL,
    `phone_number` varchar(20) NOT NULL,
    `amount` decimal(20,6) NOT NULL,
    `currency` varchar(3) NOT NULL,
    `status` varchar(20) NOT NULL,
    `transaction_id` varchar(100) DEFAULT NULL,
    `date_add` datetime NOT NULL,
    `date_upd` datetime NOT NULL,
    PRIMARY KEY (`id_transaction`),
    KEY `id_cart` (`id_cart`),
    KEY `id_order` (`id_order`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

// Execute all SQL queries
foreach ($sql as $query) {
    try {
        if (!Db::getInstance()->execute($query)) {
            if (defined('_PS_VERSION_')) {
                // We're inside PrestaShop
                return false;
            } else {
                // Direct execution - show error
                echo "Error executing SQL: " . $query . "\n";
                echo "Database error: " . Db::getInstance()->getMsgError() . "\n";
            }
        }
    } catch (Exception $e) {
        echo "Exception: " . $e->getMessage() . "\n";
    }
}

// If run directly, provide success message
if (!defined('_PS_VERSION_')) {
    echo "SQL installation completed successfully.\n";
}

// Return true for PrestaShop module installation
return true;
