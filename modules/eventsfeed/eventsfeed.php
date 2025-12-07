<?php
/**
 * Prestige Events Feed Module
 * Fetches real events from Eventbrite + PredictHQ for Cape Coast, Ghana
 *
 * @author Prestige Hotel
 * @version 1.0.0
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

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

        $this->displayName = $this->l('Events Feed (Prestige)');
        $this->description = $this->l('Displays real Cape Coast events from Eventbrite & PredictHQ with caching.');
    }

    public function install()
    {
        return parent::install()
            && $this->registerHook('displayHeader');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function hookDisplayHeader()
    {
        return '';
    }

    public function getFeedUrl()
    {
        return $this->context->link->getModuleLink($this->name, 'feed');
    }
}

