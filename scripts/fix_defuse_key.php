<?php
// Simple maintenance script to fix invalid _NEW_COOKIE_KEY_ format without bootstrapping PrestaShop.
// Usage: php scripts/fix_defuse_key.php

$root = dirname(__DIR__);

// Load only settings to avoid DB/bootstrap overhead
$settingsPath = $root . '/config/settings.inc.php';
if (!file_exists($settingsPath)) {
    fwrite(STDERR, "settings.inc.php not found at {$settingsPath}\n");
    exit(1);
}
require_once $settingsPath;

// Ensure Defuse classes are available
if (!class_exists('Defuse\\Crypto\\Key')) {
    // Base exception must be loaded before specific exceptions
    require_once $root . '/tools/defuse/php-encryption/src/Exception/CryptoException.php';
    require_once $root . '/tools/defuse/php-encryption/src/Exception/BadFormatException.php';
    require_once $root . '/tools/defuse/php-encryption/src/Exception/EnvironmentIsBrokenException.php';
    require_once $root . '/tools/defuse/php-encryption/src/Exception/WrongKeyOrModifiedCiphertextException.php';

    require_once $root . '/tools/defuse/php-encryption/src/Core.php';
    require_once $root . '/tools/defuse/php-encryption/src/Encoding.php';
    require_once $root . '/tools/defuse/php-encryption/src/Key.php';
    require_once $root . '/tools/defuse/php-encryption/src/Crypto.php';
}

use Defuse\Crypto\Key;
use Defuse\Crypto\Encoding;

function is_valid_defuse_ascii($s) {
    try {
        Key::loadFromAsciiSafeString($s);
        return true;
    } catch (\Defuse\Crypto\Exception\BadFormatException $e) {
        return false;
    } catch (\Exception $e) {
        return false;
    }
}

function generate_defuse_ascii_key() {
    try {
        $key = Key::createNewRandomKey();
        return $key->saveToAsciiSafeString();
    } catch (\Defuse\Crypto\Exception\EnvironmentIsBrokenException $e) {
        // Deterministic fallback derived from existing constants
        $seed = '';
        if (defined('_NEW_COOKIE_KEY_')) { $seed .= _NEW_COOKIE_KEY_; }
        if (defined('_COOKIE_KEY_')) { $seed .= _COOKIE_KEY_; }
        if (defined('_COOKIE_IV_')) { $seed .= _COOKIE_IV_; }
        $bytes = hash('sha256', $seed !== '' ? $seed : __FILE__, true);
        return Encoding::saveBytesToChecksummedAsciiSafeString(Key::KEY_CURRENT_VERSION, $bytes);
    }
}

$current = defined('_NEW_COOKIE_KEY_') ? _NEW_COOKIE_KEY_ : '';
if ($current !== '' && is_valid_defuse_ascii($current)) {
    echo "_NEW_COOKIE_KEY_ is already valid. No changes made.\n";
    exit(0);
}

$new = generate_defuse_ascii_key();

$settings = file_get_contents($settingsPath);
if ($settings === false) {
    fwrite(STDERR, "Failed to read settings.inc.php\n");
    exit(1);
}

$pattern = '/define\(\'_NEW_COOKIE_KEY_\',\s*\'[^\']*\'\);/';
$replacement = "define('_NEW_COOKIE_KEY_', '" . addslashes($new) . "');";
$updated = null;
if (preg_match($pattern, $settings)) {
    $updated = preg_replace($pattern, $replacement, $settings, 1);
} else {
    // Append constant definition if missing
    $updated = $settings . "\n" . $replacement . "\n";
}

if (!file_put_contents($settingsPath, $updated)) {
    fwrite(STDERR, "Failed to write updated settings.inc.php\n");
    exit(1);
}

echo "Updated _NEW_COOKIE_KEY_ to a valid Defuse ASCII-safe key.\n";
exit(0);
