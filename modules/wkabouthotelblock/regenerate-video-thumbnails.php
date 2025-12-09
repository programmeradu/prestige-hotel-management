<?php
/**
 * Video Thumbnail Generator Script
 * 
 * Run this script to generate thumbnails for all existing videos
 * that don't have thumbnails yet.
 * 
 * Usage:
 *   From command line: php regenerate-video-thumbnails.php
 *   From browser: Access via admin URL (requires login)
 * 
 * Requirements:
 *   - FFmpeg installed on server (check with: ffmpeg -version)
 * 
 * @author Prestige Hotel
 * @version 1.0
 */

// PrestaShop config
$currentDir = dirname(__FILE__);

// Try to find config.inc.php
$configPaths = array(
    $currentDir . '/../../../../config/config.inc.php',
    $currentDir . '/../../../config/config.inc.php', 
    $currentDir . '/../../config/config.inc.php',
    '/var/www/html/config/config.inc.php',
);

$configFound = false;
foreach ($configPaths as $path) {
    if (file_exists($path)) {
        require_once($path);
        $configFound = true;
        break;
    }
}

if (!$configFound) {
    die("Error: Could not find PrestaShop config.inc.php\n");
}

// Check if running from CLI or web
$isCli = php_sapi_name() === 'cli';

function output($message, $isCli) {
    if ($isCli) {
        echo $message . "\n";
    } else {
        echo $message . "<br>";
        @ob_flush();
        @flush();
    }
}

function outputHeader($isCli) {
    if (!$isCli) {
        echo "<!DOCTYPE html><html><head><title>Video Thumbnail Generator</title>";
        echo "<style>body{font-family:monospace;padding:20px;background:#1a1a2e;color:#fff;}";
        echo ".success{color:#4ade80;}.error{color:#f87171;}.info{color:#60a5fa;}</style></head><body>";
        echo "<h1>🎬 Video Thumbnail Generator</h1><hr>";
    }
}

function outputFooter($isCli) {
    if (!$isCli) {
        echo "</body></html>";
    }
}

// Security check for web access
if (!$isCli) {
    // Check if admin is logged in
    $cookie = new Cookie('psAdmin');
    if (!$cookie->id_employee) {
        die("Access denied. Please log in to Back Office first.");
    }
    outputHeader($isCli);
}

output("=== Video Thumbnail Generator ===", $isCli);
output("", $isCli);

// Check FFmpeg availability
$ffmpegPath = '';
$ffmpegCommands = array('ffmpeg', '/usr/bin/ffmpeg', '/usr/local/bin/ffmpeg', 'C:\\ffmpeg\\bin\\ffmpeg.exe');

foreach ($ffmpegCommands as $cmd) {
    $output = array();
    $returnCode = 0;
    @exec($cmd . ' -version 2>&1', $output, $returnCode);
    if ($returnCode === 0 && !empty($output)) {
        $ffmpegPath = $cmd;
        break;
    }
}

if (empty($ffmpegPath)) {
    output("<span class='error'>❌ FFmpeg not found on this server.</span>", $isCli);
    output("", $isCli);
    output("To install FFmpeg:", $isCli);
    output("  Ubuntu/Debian: sudo apt-get install ffmpeg", $isCli);
    output("  CentOS/RHEL: sudo yum install ffmpeg", $isCli);
    output("  Windows: Download from https://ffmpeg.org/download.html", $isCli);
    output("", $isCli);
    output("Alternative: Re-upload videos in Back Office to auto-generate thumbnails.", $isCli);
    outputFooter($isCli);
    exit(1);
}

output("<span class='success'>✅ FFmpeg found: $ffmpegPath</span>", $isCli);
output("", $isCli);

// Get module paths
$moduleName = 'wkabouthotelblock';
$modulePath = _PS_MODULE_DIR_ . $moduleName . '/';
$videoDir = $modulePath . 'views/video/hotel_interior/';
$imageDir = $modulePath . 'views/img/hotel_interior/';

output("<span class='info'>📁 Video directory: $videoDir</span>", $isCli);
output("<span class='info'>📁 Image directory: $imageDir</span>", $isCli);
output("", $isCli);

// Check directories exist
if (!is_dir($videoDir)) {
    output("<span class='error'>❌ Video directory does not exist</span>", $isCli);
    outputFooter($isCli);
    exit(1);
}

if (!is_dir($imageDir)) {
    mkdir($imageDir, 0755, true);
    output("<span class='success'>📁 Created image directory</span>", $isCli);
}

// Get all videos from database
$prefix = _DB_PREFIX_;

// Check for qlooo_ prefix
$tableCheck = Db::getInstance()->getValue("SHOW TABLES LIKE 'qlooo_htl_interior_image'");
if ($tableCheck) {
    $prefix = 'qlooo_';
}

$sql = "SELECT id_interior_image, name, video_file, display_name 
        FROM {$prefix}htl_interior_image 
        WHERE media_type = 'video' AND video_file IS NOT NULL AND video_file != ''";

$videos = Db::getInstance()->executeS($sql);

if (empty($videos)) {
    output("<span class='info'>ℹ️ No videos found in database.</span>", $isCli);
    outputFooter($isCli);
    exit(0);
}

output("<span class='info'>📹 Found " . count($videos) . " video(s) to process</span>", $isCli);
output("", $isCli);

$successCount = 0;
$errorCount = 0;
$skippedCount = 0;

foreach ($videos as $video) {
    $idInterior = $video['id_interior_image'];
    $videoFile = $video['video_file'];
    $currentName = $video['name'];
    $displayName = $video['display_name'];
    
    output("Processing: $videoFile (ID: $idInterior)", $isCli);
    
    // Check if video file exists
    $videoPath = $videoDir . $videoFile;
    if (!file_exists($videoPath)) {
        output("  <span class='error'>❌ Video file not found: $videoPath</span>", $isCli);
        $errorCount++;
        continue;
    }
    
    // Check if thumbnail already exists
    if (!empty($currentName)) {
        $thumbPath = $imageDir . $currentName . '.jpg';
        if (file_exists($thumbPath)) {
            output("  <span class='info'>⏭️ Thumbnail already exists, skipping</span>", $isCli);
            $skippedCount++;
            continue;
        }
    }
    
    // Generate thumbnail filename
    $thumbName = 'autothumb_' . uniqid();
    $thumbPath = $imageDir . $thumbName . '.jpg';
    
    // Use FFmpeg to extract frame at 1 second (or 0.5 if video is short)
    // -ss 1: seek to 1 second
    // -vframes 1: extract 1 frame
    // -vf scale=720:360: resize to 720x360
    $command = sprintf(
        '%s -ss 1 -i %s -vframes 1 -vf "scale=720:360:force_original_aspect_ratio=decrease,pad=720:360:(ow-iw)/2:(oh-ih)/2:color=0x1a1a2e" -y %s 2>&1',
        escapeshellcmd($ffmpegPath),
        escapeshellarg($videoPath),
        escapeshellarg($thumbPath)
    );
    
    $output = array();
    $returnCode = 0;
    exec($command, $output, $returnCode);
    
    if ($returnCode !== 0 || !file_exists($thumbPath)) {
        // Try at 0.5 seconds (for very short videos)
        $command = sprintf(
            '%s -ss 0.5 -i %s -vframes 1 -vf "scale=720:360:force_original_aspect_ratio=decrease,pad=720:360:(ow-iw)/2:(oh-ih)/2:color=0x1a1a2e" -y %s 2>&1',
            escapeshellcmd($ffmpegPath),
            escapeshellarg($videoPath),
            escapeshellarg($thumbPath)
        );
        exec($command, $output, $returnCode);
    }
    
    if ($returnCode === 0 && file_exists($thumbPath)) {
        // Update database with new thumbnail name
        $updateSql = "UPDATE {$prefix}htl_interior_image 
                      SET name = '" . pSQL($thumbName) . "' 
                      WHERE id_interior_image = " . (int)$idInterior;
        
        if (Db::getInstance()->execute($updateSql)) {
            output("  <span class='success'>✅ Thumbnail generated: $thumbName.jpg</span>", $isCli);
            $successCount++;
        } else {
            output("  <span class='error'>❌ Failed to update database</span>", $isCli);
            @unlink($thumbPath);
            $errorCount++;
        }
    } else {
        output("  <span class='error'>❌ FFmpeg failed to generate thumbnail</span>", $isCli);
        if (!empty($output)) {
            output("  Error: " . implode(' ', array_slice($output, -2)), $isCli);
        }
        $errorCount++;
    }
}

output("", $isCli);
output("=== Summary ===", $isCli);
output("<span class='success'>✅ Success: $successCount</span>", $isCli);
output("<span class='info'>⏭️ Skipped: $skippedCount</span>", $isCli);
output("<span class='error'>❌ Errors: $errorCount</span>", $isCli);
output("", $isCli);

if ($successCount > 0) {
    output("<span class='success'>🎉 Done! Clear PrestaShop cache and refresh homepage to see thumbnails.</span>", $isCli);
}

outputFooter($isCli);
