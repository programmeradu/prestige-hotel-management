<?php
/**
 * 2024-2025 Prestige Hotel.
 *
 * @author    Prestige Hotel <info@prestigehotel.com>
 * @copyright 2024-2025 Prestige Hotel
 * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');

// Set JSON headers
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: public, max-age=300');
header('Access-Control-Allow-Origin: *');

// Load helper class
require_once _PS_THEME_DIR_.'classes/EventFeedHelper.php';

// Get parameters
$limit = (int)Tools::getValue('limit', 4);
$refresh = (int)Tools::getValue('refresh', 0);

// Initialize helper
$helper = new EventFeedHelper();

// Force refresh if requested
if ($refresh) {
    $events = $helper->refreshCache();
} else {
    $events = $helper->getEvents($limit);
}

// Build response
$response = array(
    'success' => true,
    'cached' => $helper->wasFromCache(),
    'source' => $helper->getLastSource(),
    'fetched_at' => date('c'),
    'count' => count($events),
    'events' => $events,
);

// Output JSON
die(Tools::jsonEncode($response));
