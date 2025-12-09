<?php
/**
* 2010-2020 Webkul.
*
* NOTICE OF LICENSE
*
* All right is reserved,
* Please go through this link for complete license : https://store.webkul.com/license.html
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade this module to newer
* versions in the future. If you wish to customize this module for your
* needs please refer to https://store.webkul.com/customisation-guidelines/ for more information.
*
*  @author    Webkul IN <support@webkul.com>
*  @copyright 2010-2020 Webkul IN
*  @license   https://store.webkul.com/license.html
*/

class WkHotelInteriorImage extends ObjectModel
{
    public $name;
    public $media_type = 'image'; // 'image' or 'video'
    public $video_file;
    public $display_name;
    public $active;
    public $position;
    public $date_add;
    public $date_upd;

    public static $definition = array(
        'table' => 'htl_interior_image',
        'primary' => 'id_interior_image',
        'fields' => array(
            'name' => array('type' => self::TYPE_STRING),
            'media_type' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
            'video_file' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
            'display_name' => array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName'),
            'active' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'position' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        ),
    );

    public function __construct($id = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id, $id_lang, $id_shop);

        $this->image_dir = _PS_MODULE_DIR_.'wkabouthotelblock/views/img/hotel_interior/';
        $this->video_dir = _PS_MODULE_DIR_.'wkabouthotelblock/views/video/hotel_interior/';
        $this->image_name = $this->name;
    }
    
    /**
     * Resolve DB prefix, with fallback to qlooo_ if needed
     */
    public static function getDbPrefix()
    {
        $prefix = defined('_DB_PREFIX_') ? _DB_PREFIX_ : '';
        // If prefix is ps_ but qlooo_ table exists, prefer qlooo_
        if ($prefix !== 'qlooo_') {
            $exists = Db::getInstance()->getValue("SHOW TABLES LIKE 'qlooo_htl_interior_image'");
            if ($exists) {
                return 'qlooo_';
            }
        }
        return $prefix ?: 'qlooo_';
    }
    
    /**
     * Get fully prefixed table name
     */
    public static function getPrefixedTable()
    {
        return self::getDbPrefix().'htl_interior_image';
    }
    
    /**
     * Get video directory path
     */
    public static function getVideoDir()
    {
        return _PS_MODULE_DIR_.'wkabouthotelblock/views/video/hotel_interior/';
    }
    
    /**
     * Check if this media is a video
     */
    public function isVideo()
    {
        return $this->media_type === 'video';
    }
    
    /**
     * Delete video file
     */
    public function deleteVideo()
    {
        if ($this->video_file) {
            $videoPath = self::getVideoDir() . $this->video_file;
            if (file_exists($videoPath)) {
                @unlink($videoPath);
            }
        }
        return true;
    }

    /**
     * NOTE : If you want to get all images then pass false in argument variable
     */
    public function getHotelInteriorImg($active = 2)
    {
        $table = self::getPrefixedTable();
        $sql = 'SELECT `id_interior_image`, `name`, `media_type`, `video_file`, `display_name`, `position`
                FROM `'.$table.'` WHERE 1';

        if ($active != 2) {
            $sql .= ' AND `active` = '.(int) $active;
        }
        $sql .= ' ORDER BY position';

        $result = Db::getInstance()->executeS($sql);
        if ($result) {
            return $result;
        }
        return false;
    }
    
    /**
     * Get only images (no videos)
     */
    public function getHotelInteriorImages($active = 1)
    {
        $table = self::getPrefixedTable();
        $sql = 'SELECT `id_interior_image`, `name`, `display_name`, `position`
                FROM `'.$table.'` 
                WHERE (`media_type` = "image" OR `media_type` IS NULL OR `media_type` = "")';

        if ($active != 2) {
            $sql .= ' AND `active` = '.(int) $active;
        }
        $sql .= ' ORDER BY position';

        return Db::getInstance()->executeS($sql);
    }
    
    /**
     * Get only videos
     */
    public function getHotelInteriorVideos($active = 1)
    {
        $table = self::getPrefixedTable();
        $sql = 'SELECT `id_interior_image`, `name`, `media_type`, `video_file`, `display_name`, `position`
                FROM `'.$table.'` 
                WHERE `media_type` = "video"';

        if ($active != 2) {
            $sql .= ' AND `active` = '.(int) $active;
        }
        $sql .= ' ORDER BY position';

        return Db::getInstance()->executeS($sql);
    }

    /**
     * Deletes current interior image/video from the database
     * @return bool `true` if delete was successful
     */
    public function delete()
    {
        // Delete video if this is a video entry
        if ($this->media_type === 'video') {
            $this->deleteVideo();
        }
        
        if (!parent::delete()
            || !$this->deleteImage(true)
            || !$this->cleanPositions()
        ) {
            return false;
        }
        return true;
    }

    public function getHigherPosition()
    {
        $table = self::getPrefixedTable();
        $position = DB::getInstance()->getValue(
            'SELECT MAX(`position`) FROM `'.$table.'`'
        );
        $result = (is_numeric($position)) ? $position : -1;
        return $result + 1;
    }

    public function updatePosition($way, $position)
    {
        $table = self::getPrefixedTable();
        if (!$result = Db::getInstance()->executeS(
            'SELECT hib.`id_interior_image`, hib.`position` FROM `'.$table.'` hib
            WHERE hib.`id_interior_image` = '.(int) $this->id.' ORDER BY `position` ASC'
        )
        ) {
            return false;
        }

        $movedBlock = false;
        foreach ($result as $block) {
            if ((int)$block['id_interior_image'] == (int)$this->id) {
                $movedBlock = $block;
            }
        }

        if ($movedBlock === false) {
            return false;
        }
        return (Db::getInstance()->execute(
            'UPDATE `'.$table.'` SET `position`= `position` '.($way ? '- 1' : '+ 1').
            ' WHERE `position`'.($way ? '> '.
            (int)$movedBlock['position'].' AND `position` <= '.(int)$position : '< '
            .(int)$movedBlock['position'].' AND `position` >= '.(int)$position)
        ) && Db::getInstance()->execute(
            'UPDATE `'.$table.'`
            SET `position` = '.(int)$position.'
            WHERE `id_interior_image`='.(int)$movedBlock['id_interior_image']
        ));
    }

    /**
     * Reorder blocks position
     * Call it after deleting a blocks.
     * @return bool $return
     */
    public function cleanPositions()
    {
        Db::getInstance()->execute('SET @i = -1', false);
        $table = self::getPrefixedTable();
        $sql = 'UPDATE `'.$table.'` SET `position` = @i:=@i+1 ORDER BY `position` ASC';
        return (bool) Db::getInstance()->execute($sql);
    }

    public function insertModuleDemoData()
    {
        $languages = Language::getLanguages(false);
        $HOTEL_INTERIOR_HEADING = array();
        $HOTEL_INTERIOR_DESCRIPTION = array();
        $htlInteriorHeadingLang = array(
            'en' => 'Explore the Interiors!',
            'nl' => 'Verken de interieurs!',
            'fr' => 'Explorez les intérieurs!',
            'de' => 'Entdecken Sie die Innenräume!',
            'ru' => 'Исследуйте интерьеры!',
            'es' => '¡Explora los interiores!',
        );
        $htlInteriorDescLang = array(
            'en' => 'Step into the sophisticated elegance of our hotel, where every detail is designed with your comfort in mind.',
            'nl' => 'Stap in de verfijnde elegantie van ons hotel, waar elk detail is ontworpen met uw comfort in gedachten.',
            'fr' => 'Entrez dans l\'élégance sophistiquée de notre hôtel, où chaque détail est conçu pour votre confort.',
            'de' => 'Treten Sie ein in die raffinierte Eleganz unseres Hotels, wo jedes Detail mit Ihrem Komfort im Hinterkopf gestaltet ist.',
            'ru' => 'Погрузитесь в утонченную элегантность нашего отеля, где каждая деталь создана с заботой о вашем комфорте.',
            'es' => 'Sumérgete en la elegancia sofisticada de nuestro hotel, donde cada detalle está diseñado pensando en tu comodidad.',
        );
        foreach ($languages as $lang) {
            if (isset($htlInteriorHeadingLang[$lang['iso_code']])) {
                $HOTEL_INTERIOR_HEADING[$lang['id_lang']] = $htlInteriorHeadingLang[$lang['iso_code']];
                $HOTEL_INTERIOR_DESCRIPTION[$lang['id_lang']] = $htlInteriorDescLang[$lang['iso_code']];
            } else {
                $HOTEL_INTERIOR_HEADING[$lang['id_lang']] = $htlInteriorHeadingLang['en'];
                $HOTEL_INTERIOR_DESCRIPTION[$lang['id_lang']] = $htlInteriorDescLang['en'];
            }
        }
        // update global configuration values in multilang
        Configuration::updateValue('HOTEL_INTERIOR_HEADING', $HOTEL_INTERIOR_HEADING);
        Configuration::updateValue('HOTEL_INTERIOR_DESCRIPTION', $HOTEL_INTERIOR_DESCRIPTION);

        // Database Entry
        for ($i = 1; $i <= 12; $i++) {
            $imgName = $i;
            $srcPath = _PS_MODULE_DIR_.'wkabouthotelblock/views/img/dummy_img/'.$imgName.'.jpg';
            if (file_exists($srcPath)) {
                if (ImageManager::isRealImage($srcPath)
                    && ImageManager::isCorrectImageFileExt($srcPath)
                ) {
                    if (ImageManager::resize(
                        $srcPath,
                        _PS_MODULE_DIR_.'wkabouthotelblock/views/img/hotel_interior/'.$imgName.'.jpg'
                    )) {
                        $objHtlInteriorImg = new WkHotelInteriorImage();
                        $objHtlInteriorImg->name = $imgName;
                        $objHtlInteriorImg->display_name = 'Dummy Image '.$i;
                        $objHtlInteriorImg->position = $this->getHigherPosition();
                        $objHtlInteriorImg->active = 1;
                        $objHtlInteriorImg->save();
                    }
                }
            }
        }

        return true;
    }
}
