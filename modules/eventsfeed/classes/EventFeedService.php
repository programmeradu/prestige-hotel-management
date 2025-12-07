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

class EventFeedService
{
    const CACHE_TTL = 3600; // 1 hour

    protected $cacheDir;
    protected $cacheFile;
    protected $imageDir;
    protected $lastSource = 'none';
    protected $fromCache = false;

    public function __construct()
    {
        $this->cacheDir = _PS_CACHE_DIR_.'eventsfeed/';
        $this->cacheFile = $this->cacheDir.'events.json';
        $this->imageDir = _PS_IMG_DIR_.'events/';

        // Ensure directories exist
        if (!is_dir($this->cacheDir)) {
            @mkdir($this->cacheDir, 0775, true);
        }
        if (!is_dir($this->imageDir)) {
            @mkdir($this->imageDir, 0775, true);
        }
    }

    /**
     * Get events with caching
     *
     * @param int $limit Number of events to return
     * @return array
     */
    public function getEvents($limit = 4)
    {
        $limit = max(1, min(8, (int)$limit));

        // Try cache first
        $cached = $this->readCache();
        if ($cached !== null) {
            $this->fromCache = true;
            return array_slice($cached, 0, $limit);
        }

        // Fetch from APIs
        $events = $this->fetchEventbrite();
        if (empty($events)) {
            $events = $this->fetchPredictHQ();
        }

        // If still empty, return demo data
        if (empty($events)) {
            $events = $this->getDemoEvents();
            $this->lastSource = 'demo';
        }

        // Cache results
        if (!empty($events)) {
            $this->writeCache($events);
        }

        return array_slice($events, 0, $limit);
    }

    /**
     * Check if data was served from cache
     */
    public function wasFromCache()
    {
        return $this->fromCache;
    }

    /**
     * Get the source of the last fetch
     */
    public function getLastSource()
    {
        return $this->lastSource;
    }

    /**
     * Read cached events
     */
    protected function readCache()
    {
        if (!file_exists($this->cacheFile)) {
            return null;
        }

        $mtime = filemtime($this->cacheFile);
        if ((time() - $mtime) > self::CACHE_TTL) {
            return null;
        }

        $content = @file_get_contents($this->cacheFile);
        if (!$content) {
            return null;
        }

        $data = json_decode($content, true);
        if (!$data || !isset($data['events'])) {
            return null;
        }

        $this->lastSource = isset($data['source']) ? $data['source'] : 'cache';
        return $data['events'];
    }

    /**
     * Write events to cache
     */
    protected function writeCache(array $events)
    {
        $payload = array(
            'cached_at' => date('c'),
            'source' => $this->lastSource,
            'events' => $events,
        );

        @file_put_contents($this->cacheFile, json_encode($payload, JSON_PRETTY_PRINT));
    }

    /**
     * Fetch events from Eventbrite API
     */
    protected function fetchEventbrite()
    {
        $token = Configuration::get('EVENTSFEED_EVENTBRITE_TOKEN');
        if (!$token) {
            $token = getenv('EVENTBRITE_PRIVATE_TOKEN');
        }

        if (!$token) {
            return array();
        }

        $params = array(
            'location.address' => 'Cape Coast, Ghana',
            'location.within' => '50km',
            'start_date.range_start' => gmdate('Y-m-d\TH:i:s\Z'),
            'start_date.range_end' => gmdate('Y-m-d\TH:i:s\Z', strtotime('+30 days')),
            'expand' => 'venue,logo',
            'sort_by' => 'date',
        );

        $url = 'https://www.eventbriteapi.com/v3/events/search/?'.http_build_query($params);
        $headers = array('Authorization: Bearer '.$token);

        $response = $this->httpGet($url, $headers);
        if (!$response || !isset($response['events'])) {
            return array();
        }

        $this->lastSource = 'eventbrite';
        $normalized = array();

        foreach ($response['events'] as $ev) {
            $normalized[] = array(
                'id' => 'eb_'.(string)$ev['id'],
                'title' => isset($ev['name']['text']) ? $ev['name']['text'] : 'Event',
                'description' => $this->truncate(
                    isset($ev['description']['text']) ? $ev['description']['text'] : '',
                    200
                ),
                'start' => isset($ev['start']['local']) ? $ev['start']['local'] : '',
                'end' => isset($ev['end']['local']) ? $ev['end']['local'] : '',
                'url' => isset($ev['url']) ? $ev['url'] : '#',
                'image' => isset($ev['logo']['url']) ? $ev['logo']['url'] : null,
                'venue' => array(
                    'name' => isset($ev['venue']['name']) ? $ev['venue']['name'] : '',
                    'address' => isset($ev['venue']['address']['localized_address_display'])
                        ? $ev['venue']['address']['localized_address_display']
                        : 'Cape Coast, Ghana',
                ),
                'category' => 'event',
                'source' => 'eventbrite',
            );
        }

        return $normalized;
    }

    /**
     * Fetch events from PredictHQ API
     */
    protected function fetchPredictHQ()
    {
        $token = Configuration::get('EVENTSFEED_PREDICTHQ_TOKEN');
        if (!$token) {
            $token = getenv('PREDICTHQ_ACCESS_TOKEN');
        }

        if (!$token) {
            return array();
        }

        $params = array(
            'category' => 'conferences,expos,concerts,festivals,performing-arts,community,sports',
            'within' => '50km@5.10535,-1.24660', // Cape Coast coordinates
            'start.gte' => gmdate('Y-m-d'),
            'end.lte' => gmdate('Y-m-d', strtotime('+45 days')),
            'sort' => 'start',
            'limit' => 15,
        );

        $url = 'https://api.predicthq.com/v1/events/?'.http_build_query($params);
        $headers = array('Authorization: Bearer '.$token);

        $response = $this->httpGet($url, $headers);
        if (!$response || !isset($response['results'])) {
            return array();
        }

        $this->lastSource = 'predicthq';
        $normalized = array();

        foreach ($response['results'] as $ev) {
            $normalized[] = array(
                'id' => 'phq_'.(string)$ev['id'],
                'title' => isset($ev['title']) ? $ev['title'] : 'Upcoming Event',
                'description' => $this->truncate(
                    isset($ev['description']) ? $ev['description'] : '',
                    200
                ),
                'start' => isset($ev['start']) ? $ev['start'] : '',
                'end' => isset($ev['end']) ? $ev['end'] : '',
                'url' => 'https://predicthq.com/events/'.$ev['id'],
                'image' => null,
                'venue' => array(
                    'name' => isset($ev['entities'][0]['name']) ? $ev['entities'][0]['name'] : '',
                    'address' => isset($ev['geo']['address']['formatted_address'])
                        ? $ev['geo']['address']['formatted_address']
                        : 'Cape Coast, Ghana',
                ),
                'category' => isset($ev['category']) ? $ev['category'] : 'event',
                'source' => 'predicthq',
            );
        }

        return $normalized;
    }

    /**
     * Get demo events when APIs are unavailable
     */
    protected function getDemoEvents()
    {
        return array(
            array(
                'id' => 'demo_1',
                'title' => 'Cape Coast Cultural Festival',
                'description' => 'Experience the rich heritage of Cape Coast with traditional music, dance, and local cuisine. A celebration of Ghanaian culture.',
                'start' => date('Y-m-d', strtotime('+7 days')).'T10:00:00',
                'end' => date('Y-m-d', strtotime('+7 days')).'T18:00:00',
                'url' => '#',
                'image' => null,
                'venue' => array(
                    'name' => 'Cape Coast Castle',
                    'address' => 'Cape Coast, Ghana',
                ),
                'category' => 'festival',
                'source' => 'demo',
            ),
            array(
                'id' => 'demo_2',
                'title' => 'Beach Cleanup & Conservation',
                'description' => 'Join the community effort to keep our beautiful beaches pristine. All volunteers welcome.',
                'start' => date('Y-m-d', strtotime('+14 days')).'T08:00:00',
                'end' => date('Y-m-d', strtotime('+14 days')).'T12:00:00',
                'url' => '#',
                'image' => null,
                'venue' => array(
                    'name' => 'Elmina Beach',
                    'address' => 'Elmina, Ghana',
                ),
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
                'venue' => array(
                    'name' => 'Cape Coast Market',
                    'address' => 'Cape Coast, Ghana',
                ),
                'category' => 'market',
                'source' => 'demo',
            ),
            array(
                'id' => 'demo_4',
                'title' => 'Sunset Jazz Evening',
                'description' => 'Enjoy smooth jazz performances as the sun sets over the Atlantic. Live music and cocktails.',
                'start' => date('Y-m-d', strtotime('+28 days')).'T17:00:00',
                'end' => date('Y-m-d', strtotime('+28 days')).'T21:00:00',
                'url' => '#',
                'image' => null,
                'venue' => array(
                    'name' => 'Prestige Hotel Terrace',
                    'address' => 'Cape Coast, Ghana',
                ),
                'category' => 'concert',
                'source' => 'demo',
            ),
        );
    }

    /**
     * Make HTTP GET request
     */
    protected function httpGet($url, array $headers = array())
    {
        $allHeaders = array_merge($headers, array('Accept: application/json'));

        $opts = array(
            'http' => array(
                'method' => 'GET',
                'header' => implode("\r\n", $allHeaders),
                'timeout' => 10,
                'ignore_errors' => true,
            ),
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
            ),
        );

        $context = stream_context_create($opts);
        $body = @file_get_contents($url, false, $context);

        if ($body === false) {
            return null;
        }

        return json_decode($body, true);
    }

    /**
     * Truncate text to specified length
     */
    protected function truncate($text, $length)
    {
        $text = trim(strip_tags($text));
        if (Tools::strlen($text) > $length) {
            $text = Tools::substr($text, 0, $length - 3).'...';
        }
        return $text;
    }

    /**
     * Force refresh cache
     */
    public function refreshCache()
    {
        if (file_exists($this->cacheFile)) {
            @unlink($this->cacheFile);
        }
        $this->fromCache = false;
        return $this->getEvents(8);
    }
}
