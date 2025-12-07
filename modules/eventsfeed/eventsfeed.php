<?php
/**
 * 2024-2025 Prestige Hotel.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 *
 * @author    Prestige Hotel <info@prestigehotel.com>
 * @copyright 2024-2025 Prestige Hotel
 * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once dirname(__FILE__).'/classes/EventFeedService.php';

class Eventsfeed extends Module
{
    public function __construct()
    {
        $this->name = 'eventsfeed';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Prestige Hotel';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Events Feed');
        $this->description = $this->l('Display real Cape Coast events from Eventbrite & PredictHQ on your homepage.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Module installation
     */
    public function install()
    {
        // Create cache directory
        $cacheDir = _PS_CACHE_DIR_.'eventsfeed/';
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0775, true);
        }

        // Create images directory
        $imgDir = _PS_IMG_DIR_.'events/';
        if (!is_dir($imgDir)) {
            @mkdir($imgDir, 0775, true);
        }

        return parent::install()
            && $this->registerHook('displayHome')
            && $this->registerHook('displayHeader');
    }

    /**
     * Module uninstallation
     */
    public function uninstall()
    {
        return parent::uninstall();
    }

    /**
     * Hook displayHeader - Add CSS/JS assets
     */
    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path.'views/css/eventsfeed.css');
        $this->context->controller->addJS($this->_path.'views/js/eventsfeed.js');

        // Add feed URL for JavaScript
        Media::addJsDef(array(
            'eventsfeed_ajax_url' => $this->context->link->getModuleLink($this->name, 'feed'),
        ));
    }

    /**
     * Hook displayHome - Display events on homepage
     */
    public function hookDisplayHome()
    {
        $service = new EventFeedService();
        $events = $service->getEvents(4);

        $this->context->smarty->assign(array(
            'events' => $events,
            'events_feed_url' => $this->context->link->getModuleLink($this->name, 'feed'),
            'module_dir' => $this->_path,
        ));

        return $this->display(__FILE__, 'views/templates/hook/eventsfeed.tpl');
    }

    /**
     * Get feed URL for external use
     */
    public function getFeedUrl()
    {
        return $this->context->link->getModuleLink($this->name, 'feed');
    }
}

 * 2024-2025 Prestige Hotel.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 *
 * @author    Prestige Hotel <info@prestigehotel.com>
 * @copyright 2024-2025 Prestige Hotel
 * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once dirname(__FILE__).'/classes/EventFeedService.php';

class Eventsfeed extends Module
{
    public function __construct()
    {
        $this->name = 'eventsfeed';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Prestige Hotel';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Events Feed');
        $this->description = $this->l('Display real Cape Coast events from Eventbrite & PredictHQ on your homepage.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Module installation
     */
    public function install()
    {
        // Create cache directory
        $cacheDir = _PS_CACHE_DIR_.'eventsfeed/';
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0775, true);
        }

        // Create images directory
        $imgDir = _PS_IMG_DIR_.'events/';
        if (!is_dir($imgDir)) {
            @mkdir($imgDir, 0775, true);
        }

        return parent::install()
            && $this->registerHook('displayHome')
            && $this->registerHook('displayHeader');
    }

    /**
     * Module uninstallation
     */
    public function uninstall()
    {
        return parent::uninstall();
    }

    /**
     * Hook displayHeader - Add CSS/JS assets
     */
    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path.'views/css/eventsfeed.css');
        $this->context->controller->addJS($this->_path.'views/js/eventsfeed.js');

        // Add feed URL for JavaScript
        Media::addJsDef(array(
            'eventsfeed_ajax_url' => $this->context->link->getModuleLink($this->name, 'feed'),
        ));
    }

    /**
     * Hook displayHome - Display events on homepage
     */
    public function hookDisplayHome()
    {
        $service = new EventFeedService();
        $events = $service->getEvents(4);

        $this->context->smarty->assign(array(
            'events' => $events,
            'events_feed_url' => $this->context->link->getModuleLink($this->name, 'feed'),
            'module_dir' => $this->_path,
        ));

        return $this->display(__FILE__, 'views/templates/hook/eventsfeed.tpl');
    }

    /**
     * Get feed URL for external use
     */
    public function getFeedUrl()
    {
        return $this->context->link->getModuleLink($this->name, 'feed');
    }
}
