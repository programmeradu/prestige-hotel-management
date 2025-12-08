<?php
/**
 * Setup API Tokens for Events Feed
 * Run this file once to configure API tokens via PrestaShop Configuration (Option A)
 * 
 * Usage: Access via browser: yoursite.com/themes/hotel-reservation-theme/ajax/setup-api-tokens.php
 * Or run via command line: php setup-api-tokens.php
 * 
 * 2024-2025 Prestige Hotel.
 */

require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');

// Security check - only allow if accessed directly with a secret key
$secret = Tools::getValue('key', '');
$expectedSecret = 'prestige_setup_2025'; // Change this for security

if ($secret !== $expectedSecret) {
    die('Access denied. Use: ?key=prestige_setup_2025');
}

// API Tokens - Option A: Configure via PrestaShop Configuration
// Eventbrite: Application Key provided, but you need Personal OAuth Token for API access
// Generate Personal OAuth Token from: https://www.eventbrite.com/platform/api-keys/
$eventbriteToken = 'PO5FJEM5NG3PTXBCJQ'; // Application Key (won't work - need Personal OAuth Token)
$predicthqToken = 'XuZ1aN9EPua5odyYqMo1XcwPyHEVwrHM-BAhRYSX'; // PredictHQ API Token

$results = array();

// Set Eventbrite Token (Option A)
if ($eventbriteToken) {
    $result = Configuration::updateValue('EVENTSFEED_EVENTBRITE_TOKEN', $eventbriteToken);
    $results['eventbrite'] = $result ? 'SUCCESS' : 'FAILED';
    $results['eventbrite_note'] = 'NOTE: Eventbrite API requires a Personal OAuth Token, not Application Key. Generate from: https://www.eventbrite.com/platform/api-keys/';
} else {
    $results['eventbrite'] = 'SKIPPED';
}

// Set PredictHQ Token (Option A)
if ($predicthqToken) {
    $result = Configuration::updateValue('EVENTSFEED_PREDICTHQ_TOKEN', $predicthqToken);
    $results['predicthq'] = $result ? 'SUCCESS' : 'FAILED';
} else {
    $results['predicthq'] = 'SKIPPED';
}

// Output results
header('Content-Type: application/json; charset=utf-8');
echo json_encode(array(
    'success' => true,
    'message' => 'API tokens configured via PrestaShop Configuration (Option A)',
    'results' => $results,
    'next_steps' => array(
        'eventbrite' => 'Generate Personal OAuth Token from Eventbrite and update Configuration::updateValue("EVENTSFEED_EVENTBRITE_TOKEN", "YOUR_PERSONAL_TOKEN")',
        'predicthq' => 'Token configured successfully',
    ),
    'verify' => array(
        'eventbrite_token' => Configuration::get('EVENTSFEED_EVENTBRITE_TOKEN') ? 'SET' : 'NOT SET',
        'predicthq_token' => Configuration::get('EVENTSFEED_PREDICTHQ_TOKEN') ? 'SET' : 'NOT SET',
    )
), JSON_PRETTY_PRINT);
