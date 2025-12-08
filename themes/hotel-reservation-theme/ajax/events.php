<?php
/**
 * 2024-2025 Prestige Hotel.
 * 
 * Events Feed AJAX Endpoint - Core theme feature (NOT a module)
 * Returns upcoming events from Eventbrite, PredictHQ, or demo data
 *
 * @author    Prestige Hotel <info@prestigehotel.com>
 * @copyright 2024-2025 Prestige Hotel
 * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

// Set headers first
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: public, max-age=300');
header('Access-Control-Allow-Origin: *');

// Demo events fallback function
function getDemoEventsFallback() {
    return array(
        array(
            'id' => 'demo_1',
            'title' => 'Cape Coast Cultural Festival',
            'description' => 'Experience the rich heritage of Cape Coast with traditional music, dance, and local cuisine.',
            'start' => date('Y-m-d', strtotime('+7 days')).'T10:00:00',
            'end' => date('Y-m-d', strtotime('+7 days')).'T18:00:00',
            'url' => '#',
            'image' => null,
            'venue' => array('name' => 'Cape Coast Castle', 'address' => 'Cape Coast, Ghana'),
            'category' => 'festival',
            'source' => 'demo',
        ),
        array(
            'id' => 'demo_2',
            'title' => 'Beach Cleanup & Conservation',
            'description' => 'Join the community effort to keep our beautiful beaches pristine.',
            'start' => date('Y-m-d', strtotime('+14 days')).'T08:00:00',
            'end' => date('Y-m-d', strtotime('+14 days')).'T12:00:00',
            'url' => '#',
            'image' => null,
            'venue' => array('name' => 'Elmina Beach', 'address' => 'Elmina, Ghana'),
            'category' => 'community',
            'source' => 'demo',
        ),
        array(
            'id' => 'demo_3',
            'title' => 'Artisan Market Weekend',
            'description' => 'Discover handcrafted treasures from local artisans. Jewelry, textiles, woodwork and more.',
            'start' => date('Y-m-d', strtotime('+21 days')).'T09:00:00',
            'end' => date('Y-m-d', strtotime('+22 days')).'T17:00:00',
            'url' => '#',
            'image' => null,
            'venue' => array('name' => 'Cape Coast Market', 'address' => 'Cape Coast, Ghana'),
            'category' => 'market',
            'source' => 'demo',
        ),
        array(
            'id' => 'demo_4',
            'title' => 'Sunset Jazz Evening',
            'description' => 'Enjoy smooth jazz performances as the sun sets over the Atlantic.',
            'start' => date('Y-m-d', strtotime('+28 days')).'T17:00:00',
            'end' => date('Y-m-d', strtotime('+28 days')).'T21:00:00',
            'url' => '#',
            'image' => null,
            'venue' => array('name' => 'Prestige Hotel Terrace', 'address' => 'Cape Coast, Ghana'),
            'category' => 'concert',
            'source' => 'demo',
        ),
    );
}

// Try to initialize PrestaShop and load events
try {
    // Enable error logging
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);

    // Path: themes/hotel-reservation-theme/ajax/ → need 3 levels up to root
    $configPath = dirname(__FILE__).'/../../../config/config.inc.php';
    $initPath = dirname(__FILE__).'/../../../init.php';
    
    if (!file_exists($configPath)) {
        throw new Exception('Config file not found: '.$configPath);
    }
    
    require_once($configPath);
    require_once($initPath);

    // Load helper class
    $helperPath = dirname(__FILE__).'/../classes/EventFeedHelper.php';
    
    if (!file_exists($helperPath)) {
        // Try absolute path
        $helperPath = _PS_ROOT_DIR_.'/themes/hotel-reservation-theme/classes/EventFeedHelper.php';
    }
    
    if (!file_exists($helperPath)) {
        throw new Exception('EventFeedHelper class not found');
    }
    
    require_once $helperPath;

    // Get parameters
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 4;
    $refresh = isset($_GET['refresh']) ? (int)$_GET['refresh'] : 0;

    // Initialize helper and get events
    $helper = new EventFeedHelper();

    if ($refresh) {
        $events = $helper->refreshCache();
    } else {
        $events = $helper->getEvents($limit);
    }

    // Success response
    die(json_encode(array(
        'success' => true,
        'cached' => $helper->wasFromCache(),
        'source' => $helper->getLastSource(),
        'fetched_at' => date('c'),
        'count' => count($events),
        'events' => $events,
    )));

} catch (Throwable $e) {
    // Log the error
    error_log('Events Feed Error: '.$e->getMessage().' in '.$e->getFile().':'.$e->getLine());
    
    // Return demo events as fallback (so the section always works)
    $demoEvents = getDemoEventsFallback();
    
    die(json_encode(array(
        'success' => true,
        'cached' => false,
        'source' => 'demo',
        'fetched_at' => date('c'),
        'count' => count($demoEvents),
        'events' => $demoEvents,
    )));
}
