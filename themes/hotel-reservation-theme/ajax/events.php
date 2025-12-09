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

// Demo events fallback function with placeholder images
function getDemoEventsFallback() {
    return array(
        array(
            'id' => 'demo_1',
            'title' => 'Cape Coast Cultural Festival',
            'description' => 'Experience the rich heritage of Cape Coast with traditional music, dance, and local cuisine. A celebration of Ghanaian culture.',
            'start' => date('Y-m-d', strtotime('+7 days')).'T10:00:00',
            'end' => date('Y-m-d', strtotime('+7 days')).'T18:00:00',
            'url' => 'https://www.google.com/search?q=Cape+Coast+Cultural+Festival+Ghana',
            'image' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800&h=450&fit=crop',
            'venue' => array('name' => 'Cape Coast Castle', 'address' => 'Cape Coast, Ghana'),
            'category' => 'festivals',
            'source' => 'cape-coast',
        ),
        array(
            'id' => 'demo_2',
            'title' => 'Prestige Wine & Dine Experience',
            'description' => 'An exclusive evening of fine dining with curated wines from around the world. Limited seats available.',
            'start' => date('Y-m-d', strtotime('+10 days')).'T19:00:00',
            'end' => date('Y-m-d', strtotime('+10 days')).'T23:00:00',
            'url' => '/contact-us',
            'image' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800&h=450&fit=crop',
            'venue' => array('name' => 'Prestige Hotel Restaurant', 'address' => 'Cape Coast, Ghana'),
            'category' => 'dining',
            'source' => 'hotel',
        ),
        array(
            'id' => 'demo_3',
            'title' => 'Historical Cape Coast Tour',
            'description' => 'Guided tour of Cape Coast Castle and Elmina. Explore the rich history of Ghana\'s coastal heritage.',
            'start' => date('Y-m-d', strtotime('+5 days')).'T09:00:00',
            'end' => date('Y-m-d', strtotime('+5 days')).'T15:00:00',
            'url' => '/contact-us',
            'image' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=800&h=450&fit=crop',
            'venue' => array('name' => 'Cape Coast Castle', 'address' => 'Cape Coast, Ghana'),
            'category' => 'tours',
            'source' => 'hotel',
        ),
        array(
            'id' => 'demo_4',
            'title' => 'Sunset Jazz Evening',
            'description' => 'Enjoy smooth jazz performances as the sun sets over the Atlantic. Live music and cocktails at the terrace.',
            'start' => date('Y-m-d', strtotime('+28 days')).'T17:00:00',
            'end' => date('Y-m-d', strtotime('+28 days')).'T21:00:00',
            'url' => '/contact-us',
            'image' => 'https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=800&h=450&fit=crop',
            'venue' => array('name' => 'Prestige Hotel Terrace', 'address' => 'Cape Coast, Ghana'),
            'category' => 'concert',
            'source' => 'hotel',
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
    $regenImages = isset($_GET['regen_images']) ? (int)$_GET['regen_images'] : 0;

    // Initialize helper and get events
    $helper = new EventFeedHelper();

    if ($refresh || $regenImages) {
        // Clear cache to force fresh data
        $events = $helper->refreshCache();
    } else {
        $events = $helper->getEvents($limit);
    }

    // Add debug info about AI generation
    $debugInfo = array();
    foreach ($events as $event) {
        $debugInfo[] = array(
            'id' => $event['id'],
            'has_image' => !empty($event['image']),
            'is_ai_image' => !empty($event['needs_ai_image']),
            'is_placeholder' => !empty($event['placeholder_image']),
        );
    }

    // Success response
    die(json_encode(array(
        'success' => true,
        'cached' => $helper->wasFromCache(),
        'source' => $helper->getLastSource(),
        'fetched_at' => date('c'),
        'count' => count($events),
        'events' => $events,
        'debug' => $debugInfo,
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
