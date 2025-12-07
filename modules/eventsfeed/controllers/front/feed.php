<?php
/**
 * 2024-2025 Prestige Hotel.
 *
 * @author    Prestige Hotel <info@prestigehotel.com>
 * @copyright 2024-2025 Prestige Hotel
 * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class EventsfeedFeedModuleFrontController extends ModuleFrontController
{
    /** @var bool */
    public $ssl = true;

    /** @var bool */
    public $display_header = false;

    /** @var bool */
    public $display_footer = false;

    /**
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        parent::initContent();

        // Set JSON headers
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: public, max-age=300');
        header('Access-Control-Allow-Origin: *');

        // Get parameters
        $limit = (int)Tools::getValue('limit', 4);
        $refresh = (int)Tools::getValue('refresh', 0);

        // Load service
        require_once _PS_MODULE_DIR_.'eventsfeed/classes/EventFeedService.php';

        $service = new EventFeedService();

        // Force refresh if requested
        if ($refresh) {
            $events = $service->refreshCache();
        } else {
            $events = $service->getEvents($limit);
        }

        // Build response
        $response = array(
            'success' => true,
            'cached' => $service->wasFromCache(),
            'source' => $service->getLastSource(),
            'fetched_at' => date('c'),
            'count' => count($events),
            'events' => $events,
        );

        // Output JSON
        die(Tools::jsonEncode($response));
    }
}

 * 2024-2025 Prestige Hotel.
 *
 * @author    Prestige Hotel <info@prestigehotel.com>
 * @copyright 2024-2025 Prestige Hotel
 * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class EventsfeedFeedModuleFrontController extends ModuleFrontController
{
    /** @var bool */
    public $ssl = true;

    /** @var bool */
    public $display_header = false;

    /** @var bool */
    public $display_footer = false;

    /**
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        parent::initContent();

        // Set JSON headers
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: public, max-age=300');
        header('Access-Control-Allow-Origin: *');

        // Get parameters
        $limit = (int)Tools::getValue('limit', 4);
        $refresh = (int)Tools::getValue('refresh', 0);

        // Load service
        require_once _PS_MODULE_DIR_.'eventsfeed/classes/EventFeedService.php';

        $service = new EventFeedService();

        // Force refresh if requested
        if ($refresh) {
            $events = $service->refreshCache();
        } else {
            $events = $service->getEvents($limit);
        }

        // Build response
        $response = array(
            'success' => true,
            'cached' => $service->wasFromCache(),
            'source' => $service->getLastSource(),
            'fetched_at' => date('c'),
            'count' => count($events),
            'events' => $events,
        );

        // Output JSON
        die(Tools::jsonEncode($response));
    }
}

 * 2024-2025 Prestige Hotel.
 *
 * @author    Prestige Hotel <info@prestigehotel.com>
 * @copyright 2024-2025 Prestige Hotel
 * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class EventsfeedFeedModuleFrontController extends ModuleFrontController
{
    /** @var bool */
    public $ssl = true;

    /** @var bool */
    public $display_header = false;

    /** @var bool */
    public $display_footer = false;

    /**
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        parent::initContent();

        // Set JSON headers
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: public, max-age=300');
        header('Access-Control-Allow-Origin: *');

        // Get parameters
        $limit = (int)Tools::getValue('limit', 4);
        $refresh = (int)Tools::getValue('refresh', 0);

        // Load service
        require_once _PS_MODULE_DIR_.'eventsfeed/classes/EventFeedService.php';

        $service = new EventFeedService();

        // Force refresh if requested
        if ($refresh) {
            $events = $service->refreshCache();
        } else {
            $events = $service->getEvents($limit);
        }

        // Build response
        $response = array(
            'success' => true,
            'cached' => $service->wasFromCache(),
            'source' => $service->getLastSource(),
            'fetched_at' => date('c'),
            'count' => count($events),
            'events' => $events,
        );

        // Output JSON
        die(Tools::jsonEncode($response));
    }
}
