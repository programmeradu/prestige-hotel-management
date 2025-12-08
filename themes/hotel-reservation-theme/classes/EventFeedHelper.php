<?php
/**
 * 2024-2025 Prestige Hotel.
 * 
 * EventFeedHelper - Core theme class for fetching and displaying events
 * This is NOT a module - it's a core part of the theme.
 *
 * @author    Prestige Hotel <info@prestigehotel.com>
 * @copyright 2024-2025 Prestige Hotel
 * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

// This class is loaded via AJAX endpoint which initializes PrestaShop first
// No module dependency required

class EventFeedHelper
{
    const CACHE_TTL = 3600; // 1 hour
    const GEMINI_API_KEY = 'AIzaSyBe_6gJkOE0767f4S_JzPNgEHPWQsS_22E';
    const GEMINI_API_BASE = 'https://generativelanguage.googleapis.com/v1beta';
    const IMAGEN_MODEL = 'imagen-4.0-generate-001';
    const GEMINI_MODEL = 'gemini-2.5-flash';
    
    // Default API tokens (can be overridden via Configuration or environment variables)
    // Option B: Set tokens here as constants
    // NOTE: Eventbrite requires a Personal OAuth Token (not Application Key)
    // Generate Personal OAuth Token from: https://www.eventbrite.com/platform/api-keys/
    // Application Key: PO5FJEM5NG3PTXBCJQ
    // OAuth Client Secret: UYDZHPBKTRYGCDEV6CB6I5GSJL22LPVHZ2KPJ44XYMHJ6VZBMA
    // Option B: Eventbrite API Credentials
    // API Key: A2TOTKGGKRJVK2S5HG
    // Client Secret: KXLTG27TXWRUNL5IRRGDXLBQYVXME3DXEG2J46LGWS6K544L66
    // Private Token: V6B37YHBPIGYMMY5VP4V (used for API authentication)
    // Public Token: YPCBFL4WBY26RFH4LBGV
    const DEFAULT_EVENTBRITE_TOKEN = 'V6B37YHBPIGYMMY5VP4V';
    const DEFAULT_PREDICTHQ_TOKEN = 'XuZ1aN9EPua5odyYqMo1XcwPyHEVwrHM-BAhRYSX';

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

        // Generate AI images for events without images
        $events = $this->generateMissingImages($events);

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
     * Note: The /v3/events/search/ endpoint was deprecated in Sep 2023
     * Now using /v3/destination/search/ for public event discovery
     */
    protected function fetchEventbrite()
    {
        // Try PrestaShop Configuration first
        $token = Configuration::get('EVENTSFEED_EVENTBRITE_TOKEN');
        
        // Try environment variable
        if (!$token) {
            $token = getenv('EVENTBRITE_PRIVATE_TOKEN');
        }
        
        // Use default token if configured
        if (!$token && self::DEFAULT_EVENTBRITE_TOKEN) {
            $token = self::DEFAULT_EVENTBRITE_TOKEN;
        }

        if (!$token) {
            error_log('Eventbrite: No API token configured');
            return array();
        }

        // Try the destination search endpoint (newer API)
        $params = array(
            'place' => 'Cape Coast, Ghana',
            'dates' => 'current_future',
            'page_size' => 10,
        );

        $url = 'https://www.eventbriteapi.com/v3/destination/search/?'.http_build_query($params);
        $headers = array('Authorization: Bearer '.$token);

        error_log('Eventbrite: Trying destination search API');
        $response = $this->httpGetWithDebug($url, $headers);
        
        // Check for events in destination search response
        if ($response && isset($response['events']) && !empty($response['events']['results'])) {
            error_log('Eventbrite: Found events via destination search');
            $this->lastSource = 'eventbrite';
            $normalized = array();
            
            foreach ($response['events']['results'] as $ev) {
                $normalized[] = array(
                    'id' => 'eb_'.(string)$ev['id'],
                    'title' => isset($ev['name']) ? $ev['name'] : 'Event',
                    'description' => isset($ev['summary']) ? $ev['summary'] : 'Eventbrite event in Cape Coast',
                    'start' => isset($ev['start_date']) ? $ev['start_date'].'T'.($ev['start_time'] ?? '00:00:00').'Z' : gmdate('c'),
                    'end' => isset($ev['end_date']) ? $ev['end_date'].'T'.($ev['end_time'] ?? '23:59:59').'Z' : null,
                    'url' => isset($ev['url']) ? $ev['url'] : null,
                    'image' => isset($ev['image']['url']) ? $ev['image']['url'] : null,
                    'venue' => array(
                        'name' => isset($ev['primary_venue']['name']) ? $ev['primary_venue']['name'] : '',
                        'address' => isset($ev['primary_venue']['address']['localized_address_display']) 
                            ? $ev['primary_venue']['address']['localized_address_display'] 
                            : 'Cape Coast, Ghana',
                    ),
                    'category' => $this->mapEventbriteCategory(isset($ev['tags']) ? $ev['tags'] : array()),
                    'source' => 'eventbrite',
                );
            }
            
            return $normalized;
        }

        // Fallback: Try the legacy events search endpoint
        error_log('Eventbrite: Trying legacy search API');
        $legacyParams = array(
            'location.address' => 'Cape Coast, Ghana',
            'location.within' => '100km',
            'start_date.range_start' => gmdate('Y-m-d\TH:i:s\Z'),
            'start_date.range_end' => gmdate('Y-m-d\TH:i:s\Z', strtotime('+60 days')),
            'expand' => 'venue,logo',
            'sort_by' => 'date',
        );

        $legacyUrl = 'https://www.eventbriteapi.com/v3/events/search/?'.http_build_query($legacyParams);
        $response = $this->httpGetWithDebug($legacyUrl, $headers);
        
        if (!$response) {
            error_log('Eventbrite: No response from API');
            return array();
        }
        
        if (isset($response['error'])) {
            error_log('Eventbrite API Error: ' . json_encode($response['error']));
            return array();
        }
        
        if (!isset($response['events']) || empty($response['events'])) {
            error_log('Eventbrite: No events found in response');
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
        // Try PrestaShop Configuration first
        $token = Configuration::get('EVENTSFEED_PREDICTHQ_TOKEN');
        
        // Try environment variable
        if (!$token) {
            $token = getenv('PREDICTHQ_ACCESS_TOKEN');
        }
        
        // Use default PredictHQ token if configured
        if (!$token && self::DEFAULT_PREDICTHQ_TOKEN) {
            $token = self::DEFAULT_PREDICTHQ_TOKEN;
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
     * HTTP GET with debug logging
     */
    protected function httpGetWithDebug($url, array $headers = array())
    {
        $allHeaders = array_merge($headers, array('Accept: application/json'));

        $opts = array(
            'http' => array(
                'method' => 'GET',
                'header' => implode("\r\n", $allHeaders),
                'timeout' => 15,
                'ignore_errors' => true,
            ),
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
            ),
        );

        $context = stream_context_create($opts);
        $body = @file_get_contents($url, false, $context);

        // Get response headers for debugging
        if (isset($http_response_header)) {
            $statusLine = $http_response_header[0] ?? 'Unknown';
            error_log('API Response Status: ' . $statusLine);
        }

        if ($body === false) {
            error_log('API Request failed: No response body');
            return null;
        }

        $decoded = json_decode($body, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('API Response not valid JSON: ' . substr($body, 0, 200));
            return null;
        }

        return $decoded;
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
     * Map Eventbrite tags to our category system
     */
    protected function mapEventbriteCategory($tags)
    {
        if (empty($tags) || !is_array($tags)) {
            return 'event';
        }

        $tagString = strtolower(implode(' ', array_map(function($t) {
            return isset($t['display_name']) ? $t['display_name'] : (is_string($t) ? $t : '');
        }, $tags)));

        if (strpos($tagString, 'music') !== false || strpos($tagString, 'concert') !== false) {
            return 'concert';
        }
        if (strpos($tagString, 'festival') !== false || strpos($tagString, 'cultural') !== false) {
            return 'festival';
        }
        if (strpos($tagString, 'conference') !== false || strpos($tagString, 'business') !== false) {
            return 'conferences';
        }
        if (strpos($tagString, 'community') !== false || strpos($tagString, 'charity') !== false) {
            return 'community';
        }
        if (strpos($tagString, 'market') !== false || strpos($tagString, 'food') !== false) {
            return 'market';
        }
        if (strpos($tagString, 'sport') !== false || strpos($tagString, 'fitness') !== false) {
            return 'sports';
        }

        return 'event';
    }

    /**
     * Generate AI images for events that don't have images
     * Falls back to themed placeholder images if AI generation fails
     *
     * @param array $events
     * @return array
     */
    protected function generateMissingImages(array $events)
    {
        // Themed placeholder images by category
        $placeholders = array(
            'festival' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800&h=450&fit=crop',
            'festivals' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800&h=450&fit=crop',
            'concert' => 'https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=800&h=450&fit=crop',
            'concerts' => 'https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=800&h=450&fit=crop',
            'performing-arts' => 'https://images.unsplash.com/photo-1507676184212-d03ab07a01bf?w=800&h=450&fit=crop',
            'community' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=800&h=450&fit=crop',
            'market' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800&h=450&fit=crop',
            'conferences' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&h=450&fit=crop',
            'expos' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&h=450&fit=crop',
            'sports' => 'https://images.unsplash.com/photo-1461896836934-1e0cd4e86e4e?w=800&h=450&fit=crop',
            'default' => 'https://images.unsplash.com/photo-1523580494863-6f3031224c94?w=800&h=450&fit=crop',
        );

        // Process each event using index-based loop to avoid reference issues
        for ($i = 0; $i < count($events); $i++) {
            // Skip if event already has an image
            if (!empty($events[$i]['image'])) {
                continue;
            }

            $eventId = $events[$i]['id'] ?? 'unknown';
            $category = strtolower($events[$i]['category'] ?? 'default');
            
            // First, set placeholder as default (guaranteed to work)
            $events[$i]['image'] = isset($placeholders[$category]) ? $placeholders[$category] : $placeholders['default'];
            $events[$i]['placeholder_image'] = true;

            // Now try AI generation (if it works, it overrides placeholder)
            try {
                // Check if we have a cached AI image
                $cachedImage = $this->getCachedImage($eventId);
                if ($cachedImage) {
                    $events[$i]['image'] = $cachedImage;
                    $events[$i]['needs_ai_image'] = true;
                    $events[$i]['placeholder_image'] = false;
                    continue;
                }

                // Try to generate AI image (skip if taking too long)
                $aiImage = $this->generateAIImage($events[$i]);
                if ($aiImage) {
                    $events[$i]['image'] = $aiImage;
                    $events[$i]['needs_ai_image'] = true;
                    $events[$i]['placeholder_image'] = false;
                }
            } catch (Exception $e) {
                // Log error - placeholder already set
                error_log('AI image generation failed for event ' . $eventId . ': ' . $e->getMessage());
            }
        }

        return $events;
    }

    /**
     * Generate AI image using Gemini Imagen 4.0
     *
     * @param array $event
     * @return string|null Image URL or null on failure
     */
    protected function generateAIImage(array $event)
    {
        // Enhance prompt with Gemini 2.5 Flash
        $enhancedPrompt = $this->enhancePromptWithGemini($event);
        if (!$enhancedPrompt) {
            // Fallback to basic prompt if Gemini fails
            $enhancedPrompt = $this->createBasicPrompt($event);
        }

        // Generate image with Imagen 4.0
        $imageData = $this->generateImageWithImagen($enhancedPrompt);
        if (!$imageData) {
            return null;
        }

        // Save image and return URL
        return $this->saveGeneratedImage($event['id'], $imageData);
    }

    /**
     * Enhance prompt using Gemini 2.5 Flash
     *
     * @param array $event
     * @return string|null Enhanced prompt or null on failure
     */
    protected function enhancePromptWithGemini(array $event)
    {
        $prompt = "Create a detailed, photorealistic image generation prompt (max 400 tokens) for an event in Cape Coast, Ghana. ";
        $prompt .= "Event Title: {$event['title']}. ";
        $prompt .= "Description: {$event['description']}. ";
        $prompt .= "Category: {$event['category']}. ";
        $prompt .= "Venue: " . (isset($event['venue']['name']) ? $event['venue']['name'] : 'Cape Coast') . ". ";
        $prompt .= "The prompt should be descriptive, professional, and suitable for a luxury hotel's event showcase. ";
        $prompt .= "Include style modifiers like 'professional photography', 'high quality', and appropriate lighting. ";
        $prompt .= "Focus on the event's atmosphere and setting. Return ONLY the image generation prompt, nothing else.";

        $url = self::GEMINI_API_BASE . '/models/' . self::GEMINI_MODEL . ':generateContent?key=' . self::GEMINI_API_KEY;

        $payload = array(
            'contents' => array(
                array(
                    'parts' => array(
                        array('text' => $prompt)
                    )
                )
            ),
            'generationConfig' => array(
                'temperature' => 0.7,
                'topK' => 40,
                'topP' => 0.95,
                'maxOutputTokens' => 500,
            )
        );

        $response = $this->httpPost($url, $payload);
        if (!$response || !isset($response['candidates'][0]['content']['parts'][0]['text'])) {
            return null;
        }

        $enhancedPrompt = trim($response['candidates'][0]['content']['parts'][0]['text']);
        // Remove any markdown formatting or quotes
        $enhancedPrompt = preg_replace('/^["\']|["\']$/', '', $enhancedPrompt);
        $enhancedPrompt = preg_replace('/^```[\w]*\n?|\n?```$/', '', $enhancedPrompt);
        
        return trim($enhancedPrompt);
    }

    /**
     * Create a basic prompt if Gemini enhancement fails
     *
     * @param array $event
     * @return string
     */
    protected function createBasicPrompt(array $event)
    {
        $venue = isset($event['venue']['name']) ? $event['venue']['name'] : 'Cape Coast';
        $category = $event['category'] ?? 'event';
        
        $prompt = "Professional high-quality photograph of ";
        $prompt .= strtolower($event['title']) . " event in {$venue}, Cape Coast, Ghana. ";
        $prompt .= "Luxury hotel event showcase style, ";
        
        // Add category-specific details
        switch ($category) {
            case 'festival':
                $prompt .= "vibrant cultural celebration with traditional elements, golden hour lighting";
                break;
            case 'concert':
                $prompt .= "live music performance, atmospheric stage lighting, elegant venue";
                break;
            case 'community':
                $prompt .= "community gathering, warm and welcoming atmosphere, natural lighting";
                break;
            case 'market':
                $prompt .= "artisan market with handcrafted items, bright natural lighting, bustling atmosphere";
                break;
            default:
                $prompt .= "elegant event setting, professional photography, premium quality";
        }
        
        $prompt .= ", 4K HDR, taken by a professional photographer";
        
        return $prompt;
    }

    /**
     * Generate image using Imagen 4.0
     * Uses the REST API format per Google documentation
     *
     * @param string $prompt
     * @return string|null Base64 image data or null on failure
     */
    protected function generateImageWithImagen($prompt)
    {
        // Imagen 4.0 REST API endpoint (from official docs)
        $url = self::GEMINI_API_BASE . '/models/' . self::IMAGEN_MODEL . ':predict';

        $payload = array(
            'instances' => array(
                array(
                    'prompt' => $prompt
                )
            ),
            'parameters' => array(
                'sampleCount' => 1,
                'aspectRatio' => '16:9'
            )
        );

        // Use dedicated method with proper API key header
        $response = $this->httpPostWithApiKey($url, $payload, self::GEMINI_API_KEY);
        
        // Log for debugging
        if (!$response) {
            error_log('Imagen API: No response received');
            return null;
        }

        // Check for API errors
        if (isset($response['error'])) {
            error_log('Imagen API Error: ' . json_encode($response['error']));
            return null;
        }

        // Try predictions format (REST API standard response)
        if (isset($response['predictions'][0]['bytesBase64Encoded'])) {
            error_log('Imagen API: Successfully generated image');
            return $response['predictions'][0]['bytesBase64Encoded'];
        }
        
        // Try alternative response formats
        if (isset($response['predictions'][0]['image'])) {
            return $response['predictions'][0]['image'];
        }
        
        // Try generatedImages format (SDK response format)
        if (isset($response['generatedImages'][0]['image']['imageBytes'])) {
            return $response['generatedImages'][0]['image']['imageBytes'];
        }

        error_log('Imagen API: Unexpected response format: ' . json_encode(array_keys($response)));
        return null;
    }

    /**
     * Make HTTP POST request with API key in header (for Google Gemini/Imagen APIs)
     *
     * @param string $url
     * @param array $payload
     * @param string $apiKey
     * @return array|null
     */
    protected function httpPostWithApiKey($url, array $payload, $apiKey)
    {
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n" .
                           "x-goog-api-key: {$apiKey}\r\n",
                'content' => json_encode($payload),
                'timeout' => 60, // Longer timeout for image generation
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
            error_log('Imagen API: Request failed - no response body');
            return null;
        }

        $decoded = json_decode($body, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('Imagen API: Invalid JSON response: ' . substr($body, 0, 500));
            return null;
        }

        return $decoded;
    }

    /**
     * Save generated image to disk
     *
     * @param string $eventId
     * @param string $base64Data
     * @return string|null Image URL or null on failure
     */
    protected function saveGeneratedImage($eventId, $base64Data)
    {
        error_log('Saving AI image for event: ' . $eventId);
        
        // Ensure image directory exists
        if (!is_dir($this->imageDir)) {
            if (!@mkdir($this->imageDir, 0775, true)) {
                error_log('Failed to create image directory: ' . $this->imageDir);
                return null;
            }
        }
        
        // Check if directory is writable
        if (!is_writable($this->imageDir)) {
            error_log('Image directory not writable: ' . $this->imageDir);
            return null;
        }

        // Decode base64 data
        $imageData = base64_decode($base64Data);
        if (!$imageData) {
            error_log('Failed to decode base64 image data');
            return null;
        }

        // Detect image type from data
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($imageData);
        
        // Determine file extension
        $extension = 'jpg';
        if ($mimeType === 'image/png') {
            $extension = 'png';
        } elseif ($mimeType === 'image/webp') {
            $extension = 'webp';
        }

        $filename = 'event_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $eventId) . '_' . time() . '.' . $extension;
        $filepath = $this->imageDir . $filename;

        $bytesWritten = @file_put_contents($filepath, $imageData);
        if ($bytesWritten === false) {
            error_log('Failed to save image to: ' . $filepath);
            return null;
        }

        error_log('Successfully saved AI image: ' . $filename . ' (' . $bytesWritten . ' bytes)');
        
        // Return public URL
        return _PS_IMG_ . 'events/' . $filename;
    }

    /**
     * Get cached AI image if exists
     *
     * @param string $eventId
     * @return string|null Image URL or null
     */
    protected function getCachedImage($eventId)
    {
        $pattern = $this->imageDir . 'event_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $eventId) . '_*.jpg';
        $files = glob($pattern);
        
        if (empty($files)) {
            return null;
        }

        // Get most recent file
        usort($files, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });

        $filename = basename($files[0]);
        return _PS_IMG_ . 'events/' . $filename;
    }

    /**
     * Make HTTP POST request
     *
     * @param string $url
     * @param array $payload
     * @return array|null
     */
    protected function httpPost($url, array $payload)
    {
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n",
                'content' => json_encode($payload),
                'timeout' => 30,
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
