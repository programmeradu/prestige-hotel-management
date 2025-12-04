<?php
/**
 * 2023-2025 StaNetwork
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 *
 * @author    StaNetwork <contact@stanetwork.com>
 * @copyright 2023-2025 StaNetwork
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

// This script regenerates placeholder images

// Check if the script is being run from console or browser
if (PHP_SAPI !== 'cli') {
    // If it's run from a browser, set proper header
    header('Content-Type: text/html; charset=utf-8');
}

echo "Generating placeholder payment logos...\n";

// Define the directory
$img_dir = dirname(__FILE__) . '/views/img';

// Ensure the directory exists
if (!is_dir($img_dir)) {
    mkdir($img_dir, 0755, true);
    echo "Created directory: {$img_dir}\n";
}

// Function to create placeholder images
function createPlaceholderImage($filepath, $text) {
    $image = @imagecreatetruecolor(100, 40);
    if (!$image) {
        echo "Error: GD library not available\n";
        return false;
    }
    
    // Create a more visually appealing placeholder
    $bg_color = imagecolorallocate($image, 240, 240, 240);     // Light gray background
    $border_color = imagecolorallocate($image, 200, 200, 200); // Darker gray border
    $text_color = imagecolorallocate($image, 50, 50, 50);      // Dark gray text
    
    // Fill background
    imagefill($image, 0, 0, $bg_color);
    
    // Add border
    imagerectangle($image, 0, 0, 99, 39, $border_color);
    
    // Center and add text
    $font_size = 3;
    $text_width = imagefontwidth($font_size) * strlen($text);
    $text_height = imagefontheight($font_size);
    $x = (100 - $text_width) / 2;
    $y = (40 - $text_height) / 2;
    
    imagestring($image, $font_size, $x, $y, $text, $text_color);
    
    // Save the image
    imagepng($image, $filepath);
    imagedestroy($image);
    
    echo "Generated placeholder for: " . basename($filepath) . "\n";
    return true;
}

// Create placeholder images
$placeholders = [
    'cash.png' => 'CASH',
    'momo.png' => 'MOBILE MONEY',
    'paystack.png' => 'PAYSTACK',
    'visa.png' => 'VISA',
    'mastercard.png' => 'MASTERCARD'
];

foreach ($placeholders as $filename => $text) {
    $filepath = $img_dir . '/' . $filename;
    // Force regenerate by removing existing files
    if (file_exists($filepath)) {
        unlink($filepath);
        echo "Removed existing file: {$filename}\n";
    }
    createPlaceholderImage($filepath, $text);
}

echo "\nAll placeholder images have been generated successfully!\n";
echo "Path: {$img_dir}/\n";
