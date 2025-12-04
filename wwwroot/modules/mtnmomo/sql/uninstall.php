<?php
/**
* MTN Mobile Money Payment Module for QloApps - SQL Uninstall
*
* @author    Copilot
* @copyright Copyright (c) 2025
* @license   https://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
*/

$sql = array();
$sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'mtnmomo_transaction`';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
