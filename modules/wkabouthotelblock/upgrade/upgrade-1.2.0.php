<?php
/**
 * 2010-2025 Webkul/Prestige Hotel.
 *
 * Upgrade script to add video support to interior media
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_2_0($module)
{
    // Determine prefix, prefer qlooo_ if table exists
    $prefix = defined('_DB_PREFIX_') ? _DB_PREFIX_ : '';
    if ($prefix !== 'qlooo_') {
        $exists = Db::getInstance()->getValue("SHOW TABLES LIKE 'qlooo_htl_interior_image'");
        if ($exists) {
            $prefix = 'qlooo_';
        }
    }
    if (!$prefix) {
        $prefix = 'qlooo_';
    }
    
    // Add media_type column to support videos
    $sql = 'ALTER TABLE `'.$prefix.'htl_interior_image` 
            ADD COLUMN `media_type` VARCHAR(10) NOT NULL DEFAULT "image" AFTER `name`,
            ADD COLUMN `video_file` VARCHAR(255) DEFAULT NULL AFTER `media_type`';
    
    // Try to add columns (may fail if they already exist)
    try {
        Db::getInstance()->execute($sql);
    } catch (Exception $e) {
        // Columns may already exist, try adding them individually
        try {
            Db::getInstance()->execute(
                'ALTER TABLE `'._DB_PREFIX_.'htl_interior_image` 
                 ADD COLUMN `media_type` VARCHAR(10) NOT NULL DEFAULT "image" AFTER `name`'
            );
        } catch (Exception $e) {
            // Column already exists
        }
        
        try {
            Db::getInstance()->execute(
                'ALTER TABLE `'._DB_PREFIX_.'htl_interior_image` 
                 ADD COLUMN `video_file` VARCHAR(255) DEFAULT NULL AFTER `media_type`'
            );
        } catch (Exception $e) {
            // Column already exists
        }
    }
    
    return true;
}
