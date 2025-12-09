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

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once dirname(__FILE__).'/define.php';

class WkAboutHotelBlock extends Module
{
    public function __construct()
    {
        $this->name = 'wkabouthotelblock';
        $this->tab = 'front_office_features';
        $this->version = '1.1.9';
        $this->author = 'Webkul';
        $this->need_instance = 0;

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('About Hotel Block');
        $this->description = $this->l('Now show Block about your hotel using this module.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    public function hookDisplayHome()
    {
        $this->context->controller->addCSS(_PS_JS_DIR_.'owl-carousel/assets/owl.carousel.min.css');
        $this->context->controller->addCSS(_PS_JS_DIR_.'owl-carousel/assets/owl.theme.default.min.css');
        $this->context->controller->addJS(_PS_JS_DIR_.'owl-carousel/owl.carousel.min.js');
        $this->context->controller->addCSS($this->_path.'/views/css/WkAboutHotelBlockFront.css');
        $this->context->controller->addJS($this->_path.'/views/js/WkAboutHotelBlockFront.js');

        $HOTEL_INTERIOR_HEADING = Configuration::get('HOTEL_INTERIOR_HEADING', $this->context->language->id);
        $HOTEL_INTERIOR_DESCRIPTION = Configuration::get('HOTEL_INTERIOR_DESCRIPTION', $this->context->language->id);

        $objHtlInteriorImg = new WkHotelInteriorImage();
        $InteriorImg = $objHtlInteriorImg->getHotelInteriorImg(1);

        // Video configuration
        $videoEnabled = (bool)Configuration::get('HOTEL_INTERIOR_VIDEO_ENABLED');
        $videoUrl = Configuration::get('HOTEL_INTERIOR_VIDEO_URL');
        $videoTitle = Configuration::get('HOTEL_INTERIOR_VIDEO_TITLE', $this->context->language->id);
        $videoThumbnail = Configuration::get('HOTEL_INTERIOR_VIDEO_THUMBNAIL');
        
        // Parse video URL to get embed URL and thumbnail
        $videoEmbed = null;
        $videoType = null;
        if ($videoEnabled && $videoUrl) {
            $parsedVideo = $this->parseVideoUrl($videoUrl);
            $videoEmbed = $parsedVideo['embed'];
            $videoType = $parsedVideo['type'];
            // Use auto thumbnail if custom not provided
            if (!$videoThumbnail && $parsedVideo['thumbnail']) {
                $videoThumbnail = $parsedVideo['thumbnail'];
            }
        }

        $this->context->smarty->assign(
            array(
                'HOTEL_INTERIOR_HEADING' => $HOTEL_INTERIOR_HEADING,
                'HOTEL_INTERIOR_DESCRIPTION' => $HOTEL_INTERIOR_DESCRIPTION,
                'InteriorImg' => $InteriorImg,
                // Video data
                'video_enabled' => $videoEnabled,
                'video_embed' => $videoEmbed,
                'video_type' => $videoType,
                'video_title' => $videoTitle,
                'video_thumbnail' => $videoThumbnail,
                'video_url' => $videoUrl,
            )
        );

        return $this->display(__FILE__, 'hotelInteriorBlock.tpl');
    }
    
    /**
     * Parse YouTube or Vimeo URL to get embed URL and thumbnail
     */
    protected function parseVideoUrl($url)
    {
        $result = array('embed' => null, 'thumbnail' => null, 'type' => null);
        
        // YouTube patterns
        $youtubePatterns = array(
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/',
            '/youtu\.be\/([a-zA-Z0-9_-]+)/',
            '/youtube\.com\/v\/([a-zA-Z0-9_-]+)/',
        );
        
        foreach ($youtubePatterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                $videoId = $matches[1];
                $result['embed'] = 'https://www.youtube.com/embed/'.$videoId.'?autoplay=1&rel=0';
                $result['thumbnail'] = 'https://img.youtube.com/vi/'.$videoId.'/maxresdefault.jpg';
                $result['type'] = 'youtube';
                return $result;
            }
        }
        
        // Vimeo patterns
        if (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
            $videoId = $matches[1];
            $result['embed'] = 'https://player.vimeo.com/video/'.$videoId.'?autoplay=1';
            $result['type'] = 'vimeo';
            // Vimeo thumbnail requires API call, use placeholder
            $result['thumbnail'] = null;
            return $result;
        }
        
        // Direct video URL (mp4, webm, etc.)
        if (preg_match('/\.(mp4|webm|ogg)$/i', $url)) {
            $result['embed'] = $url;
            $result['type'] = 'direct';
            return $result;
        }
        
        return $result;
    }

    /**
     * If admin add any language then an entry will add in defined $lang_tables array's lang table same as prestashop
     * @param array $params
     */
    public function hookActionObjectLanguageAddAfter($params)
    {
        if ($newIdLang = $params['object']->id) {
            $configKeys = array(
                'HOTEL_INTERIOR_HEADING',
                'HOTEL_INTERIOR_DESCRIPTION',
            );
            HotelHelper::updateConfigurationLangKeys($newIdLang, $configKeys);
        }
    }

    public function install()
    {
        $objAboutHotelBlockDb = new WkAboutHotelBlockDb();
        if (!parent::install()
            || !$objAboutHotelBlockDb->createTables()
            || !$this->registerModuleHooks()
            || !$this->callInstallTab()
        ) {
            return false;
        }

        // if module should create demo data during installation
        if (isset($this->populateData) && $this->populateData) {
            $objHtlInteriorImg = new WkHotelInteriorImage();
            if (!$objHtlInteriorImg->insertModuleDemoData()) {
                return false;
            }
        } else {
            Tools::deleteDirectory($this->local_path.'views/img/dummy_img');
        }

        return true;
    }

    public function getContent()
    {
        Tools::redirectAdmin($this->context->link->getAdminLink('AdminAboutHotelBlockSetting'));
    }

    public function registerModuleHooks()
    {
        return $this->registerHook(
            array(
                'displayHome',
                'displayFooterExploreSectionHook',
                'actionObjectLanguageAddAfter'
            )
        );
    }

    public function callInstallTab()
    {
        //Controllers which are to be used in this modules but we have not to create tab for those controllers...
        $this->installTab('AdminAboutHotelBlockSetting', 'Hotel Description Configuration');
        return true;
    }

    public function installTab($class_name, $tab_name, $tab_parent_name = false)
    {
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = $class_name;
        $tab->name = array();

        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = $tab_name;
        }

        if ($tab_parent_name) {
            $tab->id_parent = (int)Tab::getIdFromClassName($tab_parent_name);
        } else {
            $tab->id_parent = -1;
        }

        $tab->module = $this->name;
        $res = $tab->add();
        //Set position of the Hotel reservation System Tab to the position wherewe want...
        return $res;
    }

    public function uninstall()
    {
        $objAboutHotelBlockDb = new WkAboutHotelBlockDb();
        if (!parent::uninstall()
            || !$this->deleteHotelInterierImg()
            || !$objAboutHotelBlockDb->dropTables()
            || !$this->deleteConfigKeys()
            || !$this->uninstallTab()
        ) {
            return false;
        }
        return true;
    }

    public function uninstallTab()
    {
        $moduleTabs = Tab::getCollectionFromModule($this->name);
        if (!empty($moduleTabs)) {
            foreach ($moduleTabs as $moduleTab) {
                $moduleTab->delete();
            }
        }

        return true;
    }

    public function deleteHotelInterierImg()
    {
        $objHtlInteriorImg = new WkHotelInteriorImage();
        $InteriorImgs = $objHtlInteriorImg->getHotelInteriorImg();
        foreach($InteriorImgs as $key => $interiorImg) {
            $objHtlInteriorImg = new WkHotelInteriorImage($interiorImg['id_interior_image']);
            if (Validate::isLoadedObject($objHtlInteriorImg)) {
                $objHtlInteriorImg->deleteImage(true);
            }
        }
        return true;
    }

    public function deleteConfigKeys()
    {
        $var = array('HOTEL_INTERIOR_HEADING', 'HOTEL_INTERIOR_DESCRIPTION');
        foreach ($var as $key) {
            if (!Configuration::deleteByName($key)) {
                return false;
            }
        }
        return true;
    }
}
