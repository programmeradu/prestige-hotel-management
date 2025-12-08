<?php
/**
 * 2024-2025 Prestige Hotel.
 *
 * @author    Prestige Hotel <info@prestigehotel.com>
 * @copyright 2024-2025 Prestige Hotel
 * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

try {
    require_once(dirname(__FILE__).'/../../config/config.inc.php');
    require_once(dirname(__FILE__).'/../../init.php');

    // Set JSON headers
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: public, max-age=300');
    header('Access-Control-Allow-Origin: *');

    // Load helper class - use relative path from AJAX directory
    $helperPath = dirname(__FILE__).'/../classes/EventFeedHelper.php';
    
    if (!file_exists($helperPath)) {
        // Fallback to absolute path
        $helperPath = _PS_ROOT_DIR_.'/themes/hotel-reservation-theme/classes/EventFeedHelper.php';
    }
    
    if (!file_exists($helperPath)) {
        throw new Exception('EventFeedHelper class not found at: '.$helperPath);
    }
    
    require_once $helperPath;

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

} catch (Throwable $e) {
    // Log error with full details
    $errorMsg = $e->getMessage();
    $errorFile = $e->getFile();
    $errorLine = $e->getLine();
    $errorTrace = $e->getTraceAsString();
    
    error_log('Events Feed Error: '.$errorMsg);
    error_log('File: '.$errorFile.' Line: '.$errorLine);
    error_log('Stack trace: '.$errorTrace);
    
    // Return error response
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200); // Return 200 with error in JSON to avoid CORS issues
    
    die(json_encode(array(
        'success' => false,
        'error' => 'Failed to load events',
        'message' => $errorMsg,
        'file' => basename($errorFile),
        'line' => $errorLine,
        'events' => array()
    )));
}
