<?php
/**
* 2010-2022 Webkul.
*
* NOTICE OF LICENSE
*
* All right is reserved,
* Please go through LICENSE.txt file inside our module
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade this module to newer
* versions in the future. If you wish to customize this module for your
* needs please refer to CustomizationPolicy.txt file inside our module for more information.
*
* @author Webkul IN
* @copyright 2010-2022 Webkul IN
* @license LICENSE.txt
*/

class WkAboutHotelBlockDb
{
    public function createTables()
    {
        if ($sqls = $this->getModuleSqls()) {
            foreach ($sqls as $query) {
                if ($query) {
                    if (!DB::getInstance()->execute(trim($query))) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    public function getModuleSqls()
    {
        $prefix = $this->resolvePrefix();
        return array(
            "CREATE TABLE IF NOT EXISTS `".$prefix."htl_interior_image` (
                `id_interior_image` int(11) NOT NULL AUTO_INCREMENT,
                `name` text NOT NULL,
                `media_type` VARCHAR(10) NOT NULL DEFAULT 'image',
                `video_file` VARCHAR(255) DEFAULT NULL,
                `display_name` text NOT NULL,
                `active` tinyint(1) NOT NULL,
                `position` int(11) NOT NULL,
                `date_add` datetime NOT NULL,
                `date_upd` datetime NOT NULL,
                PRIMARY KEY (`id_interior_image`)
            ) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;",
        );
    }
    
    /**
     * Add video columns to existing table (for upgrades)
     */
    public function addVideoColumns()
    {
        $prefix = $this->resolvePrefix();
        $columns = Db::getInstance()->executeS('SHOW COLUMNS FROM `'.$prefix.'htl_interior_image`');
        $columnNames = array_column($columns, 'Field');
        
        // Add media_type column if not exists
        if (!in_array('media_type', $columnNames)) {
            Db::getInstance()->execute(
                'ALTER TABLE `'.$prefix.'htl_interior_image` 
                 ADD COLUMN `media_type` VARCHAR(10) NOT NULL DEFAULT "image" AFTER `name`'
            );
        }
        
        // Add video_file column if not exists
        if (!in_array('video_file', $columnNames)) {
            Db::getInstance()->execute(
                'ALTER TABLE `'.$prefix.'htl_interior_image` 
                 ADD COLUMN `video_file` VARCHAR(255) DEFAULT NULL AFTER `media_type`'
            );
        }
        
        return true;
    }
    
    /**
     * Resolve prefix, defaulting to qlooo_ if available
     */
    protected function resolvePrefix()
    {
        $prefix = defined('_DB_PREFIX_') ? _DB_PREFIX_ : '';
        if ($prefix !== 'qlooo_') {
            $exists = Db::getInstance()->getValue("SHOW TABLES LIKE 'qlooo_htl_interior_image'");
            if ($exists) {
                return 'qlooo_';
            }
        }
        return $prefix ?: 'qlooo_';
    }

    public function dropTables()
    {
        return DB::getInstance()->execute('
            DROP TABLE IF EXISTS
            `'._DB_PREFIX_.'htl_interior_image`;
        ');
    }
}
