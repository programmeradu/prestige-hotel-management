<?php
/**
 * Service class for fetching and caching event data from external APIs.
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
        $this->cacheDir = _PS_CACHE_DIR_ . 'eventsfeed/';
        $this->cacheFile = $this->cacheDir . 'events.json';
        $this->imageDir = _PS_IMG_DIR_ . 'events/';

        if (!is_dir($this->cacheDir)) {
            @mkdir($this->cacheDir, 0775, true);
        }
        if (!is_dir($this->imageDir)) {
            @mkdir($this->imageDir, 0775, true);
        }
    }

    public function getEvents($limit = 4)
    {
        $limit = max(1, min(8, (int)$limit));

        $cached = $this->readCache();
        if ($cached !== null) {
            $this->fromCache = true;
            return array_slice($cached, 0, $limit);
        }

        $events = $this->fetchEventbrite();
        if (empty($events)) {
            $events = $this->fetchPredictHQ();
        }

        if (!empty($events)) {
            $this->writeCache($events);
        }

        return array_slice($events, 0, $limit);
    }

    public function wasFromCache()
    {
        return $this->fromCache;
    }

    public function getLastSource()
    {
        return $this->lastSource;
    }

    protected function readCache()
    {
        if (!file_exists($this->cacheFile)) {
            return null;
        }
        if ((time() - filemtime($this->cacheFile)) > self::CACHE_TTL) {
            return null;
        }

        $data = json_decode(@file_get_contents($this->cacheFile), true);
        if (!$data || !isset($data['events'])) {
            return null;
        }

        $this->lastSource = isset($data['source']) ? $data['source'] : 'cache';
        return $data['events'];
    }

    protected function writeCache(array $events)
    {
        $payload = array(
            'cached_at' => date('c'),
            'source' => $this->lastSource,
            'events' => $events,
        );
        @file_put_contents($this->cacheFile, json_encode($payload, JSON_PRETTY_PRINT));
    }

    protected function fetchEventbrite()
    {
        $token = getenv('EVENTBRITE_PRIVATE_TOKEN');
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

        $url = 'https://www.eventbriteapi.com/v3/events/search/?' . http_build_query($params);
        $response = $this->httpGet($url, array('Authorization: Bearer ' . $token));

        if (!$response || !isset($response['events'])) {
            return array();
        }

        $this->lastSource = 'eventbrite';
        $normalized = array();

        foreach ($response['events'] as $ev) {
            $normalized[] = array(
                'id' => (string)$ev['id'],
                'title' => isset($ev['name']['text']) ? $ev['name']['text'] : '',
                'description' => $this->truncate(isset($ev['description']['text']) ? $ev['description']['text'] : '', 200),
                'start' => isset($ev['start']['local']) ? $ev['start']['local'] : '',
                'end' => isset($ev['end']['local']) ? $ev['end']['local'] : '',
                'url' => isset($ev['url']) ? $ev['url'] : '',
                'image' => isset($ev['logo']['url']) ? $ev['logo']['url'] : null,
                'needs_ai_image' => empty($ev['logo']['url']),
                'venue' => array(
                    'name' => isset($ev['venue']['name']) ? $ev['venue']['name'] : '',
                    'address' => isset($ev['venue']['address']['localized_address_display']) ? $ev['venue']['address']['localized_address_display'] : '',
                ),
                'category' => 'event',
                'source' => 'eventbrite',
            );
        }

        return $normalized;
    }

    protected function fetchPredictHQ()
    {
        $token = getenv('PREDICTHQ_ACCESS_TOKEN');
        if (!$token) {
            return array();
        }

        $params = array(
            'category' => 'conferences,expos,concerts,festivals,performing-arts,community,sports',
            'within' => '50km@5.10535,-1.24660',
            'start.gte' => gmdate('Y-m-d'),
            'end.lte' => gmdate('Y-m-d', strtotime('+45 days')),
            'sort' => 'start',
            'limit' => 15,
        );

        $url = 'https://api.predicthq.com/v1/events/?' . http_build_query($params);
        $response = $this->httpGet($url, array('Authorization: Bearer ' . $token));

        if (!$response || !isset($response['results'])) {
            return array();
        }

        $this->lastSource = 'predicthq';
        $normalized = array();

        foreach ($response['results'] as $ev) {
            $normalized[] = array(
                'id' => (string)$ev['id'],
                'title' => isset($ev['title']) ? $ev['title'] : 'Upcoming Event',
                'description' => $this->truncate(isset($ev['description']) ? $ev['description'] : '', 200),
                'start' => isset($ev['start']) ? $ev['start'] : '',
                'end' => isset($ev['end']) ? $ev['end'] : '',
                'url' => 'https://predicthq.com/events/' . $ev['id'],
                'image' => null,
                'needs_ai_image' => true,
                'venue' => array(
                    'name' => isset($ev['entities'][0]['name']) ? $ev['entities'][0]['name'] : '',
                    'address' => isset($ev['geo']['address']['formatted_address']) ? $ev['geo']['address']['formatted_address'] : 'Cape Coast, Ghana',
                ),
                'category' => isset($ev['category']) ? $ev['category'] : 'event',
                'source' => 'predicthq',
            );
        }

        return $normalized;
    }

    protected function httpGet($url, array $headers = array())
    {
        $opts = array(
            'http' => array(
                'method' => 'GET',
                'header' => implode("\r\n", array_merge($headers, array('Accept: application/json'))),
                'timeout' => 10,
                'ignore_errors' => true,
            ),
        );

        $body = @file_get_contents($url, false, stream_context_create($opts));
        if ($body === false) {
            return null;
        }

        return json_decode($body, true);
    }

    protected function truncate($text, $length)
    {
        $text = trim(strip_tags($text));
        if (strlen($text) > $length) {
            $text = substr($text, 0, $length - 3) . '...';
        }
        return $text;
    }
}

