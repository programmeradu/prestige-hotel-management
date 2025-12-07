<?php
/**
 * Events feed JSON endpoint.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class EventsfeedFeedModuleFrontController extends ModuleFrontController
{
    public $ssl = true;
    public $display_header = false;
    public $display_footer = false;

    public function initContent()
    {
        parent::initContent();

        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: public, max-age=300');

        require_once _PS_MODULE_DIR_ . 'eventsfeed/classes/EventFeedService.php';

        $limit = (int) Tools::getValue('limit', 4);
        $service = new EventFeedService();
        $events = $service->getEvents($limit);

        $response = array(
            'success' => true,
            'cached' => $service->wasFromCache(),
            'source' => $service->getLastSource(),
            'fetched_at' => date('c'),
            'count' => count($events),
            'events' => $events,
        );

        die(json_encode($response));
    }
}

