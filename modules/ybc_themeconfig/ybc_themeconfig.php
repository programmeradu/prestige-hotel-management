<?php

/**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Theme: Your Best First
 * Last updated: NOT YET
 */


if (!defined('_PS_VERSION_'))

    exit;

/**
 * Includes
 */
class Ybc_themeconfig extends Module

{

    private $baseAdminPath;

    private $errorMessage = false;

    public $skins;

    public $layouts;

    public $fontSizes;

    public $fonts;

    public $bgs;

    public $modules;

    public function __construct()

    {

        $this->name = 'ybc_themeconfig';

        $this->tab = 'front_office_features';

        $this->version = '1.0.1';

        $this->author = 'YBC-Themes';

        $this->need_instance = 0;

        $this->secure_key = Tools::encrypt($this->name);

        $this->bootstrap = true;


        parent::__construct();


        $this->displayName = $this->l('YBC theme configuration');

        $this->description = $this->l('Configure your theme');

        $this->ps_versions_compliancy = array('min' => '1.6.0.0', 'max' => _PS_VERSION_);

        if ($this->context->controller->controller_type == 'admin')

            $this->baseAdminPath = $this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;


        //Initiate vairables

        $this->layouts = array(

            array(

                'id_option' => 'DEFAULT',

                'name' => $this->l('Full width')

            ),

            array(

                'id_option' => 'BOXED',

                'name' => $this->l('Boxed')

            )

        );

        $this->skins = array(

            array(

                'id_option' => 'DEFAULT',

                'name' => $this->l('Default (Light blue)')

            ),

            array(

                'id_option' => 'PINK',

                'name' => $this->l('Pink')

            ),

            array(

                'id_option' => 'BLUE',

                'name' => $this->l('Blue')

            ),

            array(

                'id_option' => 'RED',

                'name' => $this->l('Red')

            ),

            array(

                'id_option' => 'GREEN',

                'name' => $this->l('Green')

            ),

            array(

                'id_option' => 'ORANGE',

                'name' => $this->l('Orange')

            )

        );

        $this->fontSizes = array(

            array(

                'id_option' => 'DEFAULT',

                'name' => $this->l('Default')

            ),

            array(

                'id_option' => 'SMALL',

                'name' => $this->l('Small')

            ),

            array(

                'id_option' => 'MEDIUM',

                'name' => $this->l('Medium')

            ),

            array(

                'id_option' => 'LARGE',

                'name' => $this->l('Large')

            )

        );

        $this->fonts = array(

            array(

                'id_option' => 'DEFAULT',

                'name' => $this->l('Default (Open Sans)')

            ),

            array(

                'id_option' => 'arial',

                'name' => $this->l('Arial')

            ),

            array(

                'id_option' => 'verdana',

                'name' => $this->l('Verdana')

            ),

            array(

                'id_option' => 'tahoma',

                'name' => $this->l('Tahoma')

            ),

            array(

                'id_option' => 'times',

                'name' => $this->l('Times')

            ),

            array(

                'id_option' => 'courier',

                'name' => $this->l('Courier New')

            ),

            array(

                'id_option' => 'impact',

                'name' => $this->l('Impact')

            )

        );

        $this->bgs = array('default', 'bg1', 'bg2', 'bg3', 'bg4', 'bg5', 'bg6', 'bg7', 'bg8', 'bg9', 'bg10', 'bg11');

        $this->modules = array(

            array(

                'id' => 'ybc_megamenu',

                'name' => $this->l('Megamenu')

            ),

            array(

                'id' => 'ybc_nivoslider',

                'name' => $this->l('Home slider')

            ),

            array(

                'id' => 'ybc_featuredcat',

                'name' => $this->l('Featured categories')

            ),

            array(

                'id' => 'ybc_widget',

                'name' => $this->l('HTML Widgets')

            ),

            array(

                'id' => 'ybc_blog',

                'name' => $this->l('Blog')

            ),

            array(

                'id' => 'ybc_advancedcat',

                'name' => $this->l('Top categories block')

            ),

            array(

                'id' => 'ybc_socialsharing',

                'name' => $this->l('Social sharing')

            ),

            array(

                'id' => 'ybc_htmlproduct',

                'name' => $this->l('Product html block')

            ),

            array(

                'id' => 'ybc_manufacturer',

                'name' => $this->l('Manufacturers / brands')

            ),

            array(

                'id' => 'ybc_blocksearch',

                'name' => $this->l('Top search block')

            )

        );

    }

    /**
     * @see Module::install()
     */

    public function install()

    {

        $this->_installDb();

        return parent::install()

            && $this->registerHook('displayHeader')

            && $this->registerHook('displayFooter')

            && $this->registerHook('ybcCopyright')

            && $this->registerHook('ybcBlockSocial')

            && $this->registerHook('displayBackOfficeFooter')

            && $this->registerHook('displayYbcProductReview')

            && $this->registerHook('displayBackOfficeHeader');

    }


    /**
     * @see Module::uninstall()
     */

    public function uninstall()

    {

        $this->_uninstallDb();

        return parent::uninstall();

    }

    private function _installDb()

    {

        $languages = Language::getLanguages(false);

        Db::getInstance()->execute("UPDATE " . _DB_PREFIX_ . "themeconfigurator SET active = 0");

        Configuration::updateValue('YBC_TC_SKIN', 'DEFAULT');

        Configuration::updateValue('YBC_TC_FONTSIZE', 'DEFAULT');

        Configuration::updateValue('YBC_TC_GENERAL_FONT', 'DEFAULT');

        Configuration::updateValue('YBC_TC_HEADING_FONT', 'DEFAULT');

        Configuration::updateValue('YBC_TC_CUSTOM_FONT', 'DEFAULT');

        Configuration::updateValue('YBC_TC_BG_IMG', 'default');

        Configuration::updateValue('YBC_TC_MOBLE_ENABLED', 1);

        Configuration::updateValue('YBC_TC_LAYOUT', 'DEFAULT');

        Configuration::updateValue('YBC_TC_SHOW_SETTING', 1);

        $YBC_TC_COPYRIGHT_TEXTS = array();

        foreach ($languages as $l) {

            $YBC_TC_COPYRIGHT_TEXTS[$l['id_lang']] = $this->l('Copyright 2015 Your company. Powered by ') . '<a class="_blank" href="#">Prestashop</a>';

        }

        Configuration::updateValue('YBC_TC_COPYRIGHT_TEXT', $YBC_TC_COPYRIGHT_TEXTS, true);

        $tab = new Tab();

        $tab->class_name = 'AdminYbcThemeConfig';

        $tab->module = 'ybc_themeconfig';

        $tab->id_parent = 0;

        foreach ($languages as $lang) {

            $tab->name[$lang['id_lang']] = $this->l('Quick access');

        }

        $tab->save();

        $blogTabId = Tab::getIdFromClassName('AdminYbcThemeConfig');

        if ($blogTabId) {

            $subTabs = array(

                array(

                    'class_name' => 'AdminYbcTC',

                    'tab_name' => $this->l('Theme configuration')

                )

            );

            foreach ($subTabs as $tabArg) {

                $tab = new Tab();

                $tab->class_name = $tabArg['class_name'];

                $tab->module = 'ybc_themeconfig';

                $tab->id_parent = $blogTabId;

                foreach ($languages as $lang) {

                    $tab->name[$lang['id_lang']] = $tabArg['tab_name'];

                }

                $tab->save();

            }

        }

    }

    private function _uninstallDb()

    {

        Configuration::deleteByName('YBC_TC_SKIN');

        Configuration::deleteByName('YBC_TC_FONTSIZE');

        Configuration::deleteByName('YBC_TC_GENERAL_FONT');

        Configuration::deleteByName('YBC_TC_HEADING_FONT');

        Configuration::deleteByName('YBC_TC_CUSTOM_FONT');

        Configuration::deleteByName('YBC_TC_BG_IMG');

        Configuration::deleteByName('YBC_TC_MOBLE_ENABLED');

        Configuration::deleteByName('YBC_TC_LAYOUT', 'DEFAULT');

        Configuration::deleteByName('YBC_TC_SHOW_SETTING');

        Configuration::deleteByName('YBC_TC_COPYRIGHT_TEXT');

        $tabs = array('AdminYbcThemeConfig', 'AdminYbcTC');

        if ($tabs)

            foreach ($tabs as $classname) {

                if ($tabId = Tab::getIdFromClassName($classname)) {

                    $tab = new Tab($tabId);

                    if ($tab)

                        $tab->delete();

                }

            }

    }

    private function _postConfig()

    {

        $languages = Language::getLanguages(false);

        $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');

        $errors = array();

        if (Tools::isSubmit('tcreset') && Tools::getValue('tcreset')) {

            $this->_uninstallDb();

            $this->_installDb();

            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true) . '&conf=4&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name);

        }

        if (Tools::isSubmit('saveTC')) {

            $YBC_TC_LAYOUT = trim(Tools::getValue('YBC_TC_LAYOUT', 'DEFAULT'));

            $YBC_TC_SHOW_SETTING = trim(Tools::getValue('YBC_TC_SHOW_SETTING')) ? 1 : 0;

            $YBC_TC_SKIN = trim(Tools::getValue('YBC_TC_SKIN', 'DEFAULT'));

            $YBC_TC_FONTSIZE = trim(Tools::getValue('YBC_TC_FONTSIZE', 'DEFAULT'));

            $YBC_TC_GENERAL_FONT = trim(Tools::getValue('YBC_TC_GENERAL_FONT', 'DEFAULT'));

            $YBC_TC_HEADING_FONT = trim(Tools::getValue('YBC_TC_HEADING_FONT', 'DEFAULT'));

            $YBC_TC_CUSTOM_FONT = trim(Tools::getValue('YBC_TC_CUSTOM_FONT', 'DEFAULT'));

            $YBC_TC_BG_IMG = trim(Tools::getValue('YBC_TC_BG_IMG', 'default'));

            $YBC_TC_MOBLE_ENABLED = Tools::getValue('YBC_TC_MOBLE_ENABLED') ? 1 : 0;


            $YBC_TC_COPYRIGHT_TEXTS = array();

            foreach ($languages as $l) {

                $YBC_TC_COPYRIGHT_TEXTS[$l['id_lang']] = trim(Tools::getValue('YBC_TC_COPYRIGHT_TEXT_' . $l['id_lang'])) != '' ? trim(Tools::getValue('YBC_TC_COPYRIGHT_TEXT_' . $l['id_lang'])) : trim(Tools::getValue('YBC_TC_COPYRIGHT_TEXT_' . $id_lang_default));

            }


            if (!$this->validateOption($this->layouts, $YBC_TC_LAYOUT))

                $errors[] = $this->l('Layout is not valid');

            if (!$this->validateOption($this->skins, $YBC_TC_SKIN))

                $errors[] = $this->l('Skin is not valid');

            if (!$this->validateOption($this->fontSizes, $YBC_TC_FONTSIZE))

                $errors[] = $this->l('Font size is not valid');

            if (!$this->validateOption($this->fonts, $YBC_TC_GENERAL_FONT))

                $errors[] = $this->l('General font is not valid');

            if (!$this->validateOption($this->fonts, $YBC_TC_HEADING_FONT))

                $errors[] = $this->l('Heading font is not valid');

            if (!$this->validateOption($this->fonts, $YBC_TC_CUSTOM_FONT))

                $errors[] = $this->l('Custom font is not valid');

            if (!in_array($YBC_TC_BG_IMG, $this->bgs))

                $errors[] = $this->l('Background image is not valid');


            if (trim(Tools::getValue('YBC_TC_COPYRIGHT_TEXT_' . $id_lang_default)) == '')

                $errors[] = $this->l('Copyright text is required');


            if (!$errors) {

                Configuration::updateValue('YBC_TC_SKIN', $YBC_TC_SKIN);

                Configuration::updateValue('YBC_TC_LAYOUT', $YBC_TC_LAYOUT);

                Configuration::updateValue('YBC_TC_FONTSIZE', $YBC_TC_FONTSIZE);

                Configuration::updateValue('YBC_TC_GENERAL_FONT', $YBC_TC_GENERAL_FONT);

                Configuration::updateValue('YBC_TC_HEADING_FONT', $YBC_TC_HEADING_FONT);

                Configuration::updateValue('YBC_TC_CUSTOM_FONT', $YBC_TC_CUSTOM_FONT);

                Configuration::updateValue('YBC_TC_BG_IMG', $YBC_TC_BG_IMG);

                Configuration::updateValue('YBC_TC_MOBLE_ENABLED', $YBC_TC_MOBLE_ENABLED);

                Configuration::updateValue('YBC_TC_SHOW_SETTING', $YBC_TC_SHOW_SETTING);

                Configuration::updateValue('YBC_TC_COPYRIGHT_TEXT', $YBC_TC_COPYRIGHT_TEXTS, true);

            }

            if (count($errors)) {

                $this->errorMessage = $this->displayError(implode('<br />', $errors));

            } else

                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true) . '&conf=4&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name);

        }

    }

    public function validateOption($arg, $valule)

    {

        if ($arg && is_array($arg)) {

            foreach ($arg as $item) {

                if ($item['id_option'] == $valule)

                    return true;

            }

        }

        return false;

    }

    public function getContent()

    {

        $this->_postConfig();

        if ($this->errorMessage)

            $this->_html .= $this->errorMessage;

        $this->renderConfigForm();

        return $this->_html . $this->displayIframe();

    }

    public function displayIframe()
    {
        switch ($this->context->language->iso_code) {
            case 'en':
                $url = 'https://cdn.prestahero.com/prestahero-product-feed?utm_source=feed_' . $this->name . '&utm_medium=iframe';
                break;
            case 'it':
                $url = 'https://cdn.prestahero.com/it/prestahero-product-feed?utm_source=feed_' . $this->name . '&utm_medium=iframe';
                break;
            case 'fr':
                $url = 'https://cdn.prestahero.com/fr/prestahero-product-feed?utm_source=feed_' . $this->name . '&utm_medium=iframe';
                break;
            case 'es':
                $url = 'https://cdn.prestahero.com/es/prestahero-product-feed?utm_source=feed_' . $this->name . '&utm_medium=iframe';
                break;
            default:
                $url = 'https://cdn.prestahero.com/prestahero-product-feed?utm_source=feed_' . $this->name . '&utm_medium=iframe';
        }
        $this->smarty->assign(
            array(
                'url_iframe' => $url
            )
        );
        return $this->display(__FILE__, 'iframe.tpl');
    }

    public function renderConfigForm()

    {

        $fields_form = array(

            'form' => array(

                'legend' => array(

                    'title' => $this->l('YBC theme configuration'),

                    'icon' => 'icon-AdminAdmin'

                ),

                'input' => array(

                    array(

                        'type' => 'select',

                        'label' => $this->l('Layout'),

                        'name' => 'YBC_TC_LAYOUT',

                        'options' => array(

                            'query' => $this->layouts,

                            'id' => 'id_option',

                            'name' => 'name'

                        )

                    ),

                    array(

                        'type' => 'select',

                        'label' => $this->l('Skin'),

                        'name' => 'YBC_TC_SKIN',

                        'options' => array(

                            'query' => $this->skins,

                            'id' => 'id_option',

                            'name' => 'name'

                        )

                    ),

                    array(

                        'type' => 'select',

                        'label' => $this->l('Font size'),

                        'name' => 'YBC_TC_FONTSIZE',

                        'options' => array(

                            'query' => $this->fontSizes,

                            'id' => 'id_option',

                            'name' => 'name'

                        )

                    ),

                    array(

                        'type' => 'select',

                        'label' => $this->l('General font'),

                        'name' => 'YBC_TC_GENERAL_FONT',

                        'options' => array(

                            'query' => $this->fonts,

                            'id' => 'id_option',

                            'name' => 'name'

                        )

                    ),

                    array(

                        'type' => 'select',

                        'label' => $this->l('Heading font'),

                        'name' => 'YBC_TC_HEADING_FONT',

                        'options' => array(

                            'query' => $this->fonts,

                            'id' => 'id_option',

                            'name' => 'name'

                        )

                    ),

                    array(

                        'type' => 'select',

                        'label' => $this->l('Custom font'),

                        'name' => 'YBC_TC_CUSTOM_FONT',

                        'options' => array(

                            'query' => $this->fonts,

                            'id' => 'id_option',

                            'name' => 'name'

                        )

                    ),

                    array(

                        'type' => 'backgroundimg',

                        'label' => $this->l('Background image'),

                        'name' => 'YBC_TC_BG_IMG',

                        'bgs' => $this->bgs

                    ),

                    array(

                        'type' => 'textarea',

                        'label' => $this->l('Copyright text'),

                        'name' => 'YBC_TC_COPYRIGHT_TEXT',

                        'required' => true,

                        'lang' => true

                    ),


                    array(

                        'type' => 'switch',

                        'label' => $this->l('Show front setting panel'),

                        'name' => 'YBC_TC_SHOW_SETTING',

                        'is_bool' => true,

                        'values' => array(

                            array(

                                'id' => 'active_on',

                                'value' => 1,

                                'label' => $this->l('Yes')

                            ),

                            array(

                                'id' => 'active_off',

                                'value' => 0,

                                'label' => $this->l('No')

                            )

                        )

                    )

                ),

                'submit' => array(

                    'title' => $this->l('Save'),

                )

            ),

        );


        $helper = new HelperForm();

        $helper->show_toolbar = false;

        $helper->table = $this->table;

        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

        $helper->default_form_language = $lang->id;

        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;

        $this->fields_form = array();

        $helper->module = $this;

        $helper->identifier = $this->identifier;

        $helper->submit_action = 'saveTC';

        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;

        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

        $helper->override_folder = '/';

        $languages = Language::getLanguages(false);

        /**
         * Get field values
         */


        $fields = array();

        if (Tools::isSubmit('saveTC')) {

            $fields['YBC_TC_SKIN'] = Tools::getValue('YBC_TC_SKIN', 'DEFAULT');

            $fields['YBC_TC_LAYOUT'] = Tools::getValue('YBC_TC_LAYOUT', 'DEFAULT');

            $fields['YBC_TC_FONTSIZE'] = Tools::getValue('YBC_TC_FONTSIZE', 'DEFAULT');

            $fields['YBC_TC_GENERAL_FONT'] = Tools::getValue('YBC_TC_GENERAL_FONT', 'DEFAULT');

            $fields['YBC_TC_HEADING_FONT'] = Tools::getValue('YBC_TC_HEADING_FONT', 'DEFAULT');

            $fields['YBC_TC_CUSTOM_FONT'] = Tools::getValue('YBC_TC_CUSTOM_FONT', 'DEFAULT');

            $fields['YBC_TC_BG_IMG'] = Tools::getValue('YBC_TC_BG_IMG', 'default');

            $fields['YBC_TC_MOBLE_ENABLED'] = Tools::getValue('YBC_TC_MOBLE_ENABLED', 1);

            $fields['YBC_TC_SHOW_SETTING'] = Tools::getValue('YBC_TC_SHOW_SETTING', 1);

            foreach ($languages as $l) {

                $fields['YBC_TC_COPYRIGHT_TEXT'][$l['id_lang']] = Tools::getValue('YBC_TC_COPYRIGHT_TEXT_' . $l['id_lang'], Tools::getValue('YBC_TC_COPYRIGHT_TEXT_' . Configuration::get('PS_LANG_DEFAULT')));

            }

        } else {

            $fields['YBC_TC_SKIN'] = Configuration::get('YBC_TC_SKIN') ? Configuration::get('YBC_TC_SKIN') : 'DEFAULT';

            $fields['YBC_TC_LAYOUT'] = Configuration::get('YBC_TC_LAYOUT') ? Configuration::get('YBC_TC_LAYOUT') : 'DEFAULT';

            $fields['YBC_TC_FONTSIZE'] = Configuration::get('YBC_TC_FONTSIZE') ? Configuration::get('YBC_TC_FONTSIZE') : 'DEFAULT';

            $fields['YBC_TC_GENERAL_FONT'] = Configuration::get('YBC_TC_GENERAL_FONT') ? Configuration::get('YBC_TC_GENERAL_FONT') : 'DEFAULT';

            $fields['YBC_TC_HEADING_FONT'] = Configuration::get('YBC_TC_HEADING_FONT') ? Configuration::get('YBC_TC_HEADING_FONT') : 'DEFAULT';

            $fields['YBC_TC_CUSTOM_FONT'] = Configuration::get('YBC_TC_CUSTOM_FONT') ? Configuration::get('YBC_TC_CUSTOM_FONT') : 'DEFAULT';

            $fields['YBC_TC_BG_IMG'] = Configuration::get('YBC_TC_BG_IMG') ? Configuration::get('YBC_TC_BG_IMG') : 'default';

            $fields['YBC_TC_MOBLE_ENABLED'] = Configuration::get('YBC_TC_MOBLE_ENABLED') ? 1 : 0;

            $fields['YBC_TC_SHOW_SETTING'] = Configuration::get('YBC_TC_SHOW_SETTING') ? 1 : 0;

            foreach ($languages as $l) {

                $fields['YBC_TC_COPYRIGHT_TEXT'][$l['id_lang']] = Configuration::get('YBC_TC_COPYRIGHT_TEXT', $l['id_lang']);

            }

        }


        $helper->tpl_vars = array(

            'base_url' => $this->context->shop->getBaseURL(),

            'language' => array(

                'id_lang' => $language->id,

                'iso_code' => $language->iso_code

            ),

            'fields_value' => $fields,

            'languages' => $this->context->controller->getLanguages(),

            'id_language' => $this->context->language->id,

            'reset_url' => $this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name . '&tcreset=yes'

        );


        $this->_html .= $helper->generateForm(array($fields_form));

    }

    private function _getThemeConfig()

    {

        $fields = array();

        $fields['YBC_TC_LAYOUT'] = Configuration::get('YBC_TC_LAYOUT') ? Configuration::get('YBC_TC_LAYOUT') : 'DEFAULT';

        $fields['YBC_TC_SKIN'] = Configuration::get('YBC_TC_SKIN') ? Configuration::get('YBC_TC_SKIN') : 'DEFAULT';

        $fields['YBC_TC_FONTSIZE'] = Configuration::get('YBC_TC_FONTSIZE') ? Configuration::get('YBC_TC_FONTSIZE') : 'DEFAULT';

        $fields['YBC_TC_GENERAL_FONT'] = Configuration::get('YBC_TC_GENERAL_FONT') ? Configuration::get('YBC_TC_GENERAL_FONT') : 'DEFAULT';

        $fields['YBC_TC_HEADING_FONT'] = Configuration::get('YBC_TC_HEADING_FONT') ? Configuration::get('YBC_TC_HEADING_FONT') : 'DEFAULT';

        $fields['YBC_TC_CUSTOM_FONT'] = Configuration::get('YBC_TC_CUSTOM_FONT') ? Configuration::get('YBC_TC_CUSTOM_FONT') : 'DEFAULT';

        $fields['YBC_TC_BG_IMG'] = Configuration::get('YBC_TC_BG_IMG') ? Configuration::get('YBC_TC_BG_IMG') : 'default';

        $fields['YBC_TC_MOBLE_ENABLED'] = Configuration::get('YBC_TC_MOBLE_ENABLED') ? 1 : 0;

        $fields['YBC_TC_SHOW_SETTING'] = Configuration::get('YBC_TC_SHOW_SETTING') ? 1 : 0;

        return $fields;

    }

    public function getThemeConfigDemo()

    {

        if (Configuration::get('YBC_TC_SHOW_SETTING')) {

            if (!$this->context->cookie->themeconfig) {

                $this->context->cookie->themeconfig = @serialize($this->_getThemeConfig());

                $this->context->cookie->write();

            }

        }

        $themeConfig = @unserialize($this->context->cookie->themeconfig);

        if ($themeConfig)

            return $themeConfig;

        return $this->_getThemeConfig();

    }

    public function updateThemeConfigDemo($key, $val)

    {

        $config = false;

        if (!$this->context->cookie->themeconfig) {

            $this->context->cookie->themeconfig = @serialize($this->_getThemeConfig());

        }

        if ($this->context->cookie->themeconfig) {

            $config = @unserialize($this->context->cookie->themeconfig);

        }

        if ($config && is_array($config) && isset($config[$key])) {

            $config[$key] = $val;

            $this->context->cookie->themeconfig = @serialize($config);

            $this->context->cookie->write();

        }

        return;

    }

    public function getThemeConfig($key)

    {

        if ($this->context->cookie->themeconfig) {

            $config = @unserialize($this->context->cookie->themeconfig);

        }

        if ($config && is_array($config) && isset($config[$key])) {

            return $config[$key];

        }

        return false;

    }

    public function resetConfigDemo()

    {

        $this->context->cookie->themeconfig = false;

        $this->context->cookie->write();

    }

    /**
     * Hooks
     */

    public function hookDisplayHeader()

    {

        $this->context->controller->addJS($this->_path . 'js/ybctab.js');

        $this->context->controller->addCSS($this->_path . 'css/skins.css', 'all');

        $this->context->controller->addCSS($this->_path . 'css/font-awesome.css', 'all');

        $this->context->controller->addCSS($this->_path . 'css/owl/owl.carousel.css', 'all');

        $this->context->controller->addCSS($this->_path . 'css/owl/owl.theme.css', 'all');

        $this->context->controller->addCSS($this->_path . 'css/elegant-font.css', 'all');

        $this->context->controller->addCSS($this->_path . 'css/owl/owl.transitions.css', 'all');

        $this->context->controller->addJS($this->_path . 'js/owl.carousel.js');

        if (Configuration::get('YBC_TC_SHOW_SETTING')) {

            //Auto update skin / layout

            if (Tools::getValue('YBC_TC_SKIN') && $this->validateOption($this->skins, Tools::getValue('YBC_TC_SKIN')))

                $this->updateThemeConfigDemo('YBC_TC_SKIN', Tools::getValue('YBC_TC_SKIN'));

            if (Tools::getValue('YBC_TC_LAYOUT') && $this->validateOption($this->layouts, Tools::getValue('YBC_TC_LAYOUT')))

                $this->updateThemeConfigDemo('YBC_TC_LAYOUT', Tools::getValue('YBC_TC_LAYOUT'));

            if (Tools::getValue('YBC_TC_SKIN') || Tools::getValue('YBC_TC_LAYOUT'))

                Tools::redirect($this->context->link->getPageLink('index', true));

            $this->context->controller->addCSS($this->_path . 'css/themeconfig.css', 'all');

        }

        $this->context->smarty->assign(

            array(

                'YBC_TC_CLASSES' => $this->getBodyClasses(),

                'YBC_TC_MOBLE_ENABLED' => Configuration::get('YBC_TC_MOBLE_ENABLED') ? true : false

            ));

    }

    public function getBodyClasses()

    {

        if (Configuration::get('YBC_TC_SHOW_SETTING'))

            $fields = $this->getThemeConfigDemo();

        else

            $fields = $this->_getThemeConfig();

        $bodyClass = '';

        if ($fields)

            foreach ($fields as $field => $val) {

                if ($field == 'YBC_TC_LAYOUT')

                    $bodyClass .= ' ybc-layout-' . ($val ? Tools::strtolower($val) : 'default');

                elseif ($field == 'YBC_TC_SKIN')

                    $bodyClass .= ' ybc-skin-' . ($val ? Tools::strtolower($val) : 'default');

                elseif ($field == 'YBC_TC_FONTSIZE')

                    $bodyClass .= ' ybc-fontsize-' . ($val ? Tools::strtolower($val) : 'default');

                elseif ($field == 'YBC_TC_GENERAL_FONT')

                    $bodyClass .= ' ybc-gf-' . ($val ? Tools::strtolower($val) : 'default');

                elseif ($field == 'YBC_TC_HEADING_FONT')

                    $bodyClass .= ' ybc-hf-' . ($val ? Tools::strtolower($val) : 'default');

                elseif ($field == 'YBC_TC_CUSTOM_FONT')

                    $bodyClass .= ' ybc-cf-' . ($val ? Tools::strtolower($val) : 'default');

                elseif ($field == 'YBC_TC_BG_IMG')

                    $bodyClass .= ' ybc-bg-img-' . ($val ? Tools::strtolower($val) : 'default');

            }

        return $bodyClass;

    }

    public function hookDisplayFooter()

    {

        if (Configuration::get('YBC_TC_SHOW_SETTING')) {

            $this->smarty->assign(array(

                    'configs' => $this->getThemeConfigDemo(),

                    'fonts' => $this->fonts,

                    'fontSizes' => $this->fontSizes,

                    'skins' => $this->skins,

                    'layouts' => $this->layouts,

                    'bgs' => $this->bgs,

                    'moduleDirl' => $this->context->shop->getBaseURL(true) . 'modules/' . $this->name . '/'

                )

            );

            return $this->display(__FILE__, 'panel.tpl');

        }

        return;

    }

    public function getMenuScript()

    {

        $modules = $this->modules;

        if ($modules) {

            foreach ($modules as &$module) {

                $module['link'] = $this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $module['id'] . '&module_name=' . $module['id'];

                $module['installed'] = Module::isInstalled($module['id']) ? true : false;

            }

        }

        $this->smarty->assign(

            array(

                'modules' => $modules,

                'active_module' => Tools::getValue('configure'),

                'log_link' => $this->_path . 'img/logo-16.png'

            )

        );

        return $this->display(__FILE__, 'modulelinks.tpl');

    }

    public function hookDisplayBackOfficeFooter()

    {

        return $this->getMenuScript();

    }

    public function hookYbcCopyright()

    {

        return '<div class="ybc-copyright">' . Configuration::get('YBC_TC_COPYRIGHT_TEXT', (int)$this->context->language->id) . '</div>';

    }

    public function hookDisplayBackOfficeHeader()

    {

        $this->context->controller->addCSS($this->_path . 'css/admin.css');

    }

    public function hookYbcBlockSocial()

    {

        if (Module::isInstalled('blocksocial') && Module::isEnabled('blocksocial')) {

            $this->smarty->assign(array(

                'facebook_url' => Configuration::get('BLOCKSOCIAL_FACEBOOK'),

                'twitter_url' => Configuration::get('BLOCKSOCIAL_TWITTER'),

                'rss_url' => Configuration::get('BLOCKSOCIAL_RSS'),

                'youtube_url' => Configuration::get('BLOCKSOCIAL_YOUTUBE'),

                'google_plus_url' => Configuration::get('BLOCKSOCIAL_GOOGLE_PLUS'),

                'pinterest_url' => Configuration::get('BLOCKSOCIAL_PINTEREST'),

                'vimeo_url' => Configuration::get('BLOCKSOCIAL_VIMEO'),

                'instagram_url' => Configuration::get('BLOCKSOCIAL_INSTAGRAM'),

            ));

            return $this->display(__FILE__, 'blocksocial.tpl');

        }

    }

    public function hookDisplayYbcProductReview($params)

    {

        if (Module::isInstalled('productcomments') && Module::isEnabled('productcomments')) {

            $id_product = (int)$params['product']['id_product'];

            require_once(dirname(__FILE__) . '/../productcomments/ProductComment.php');

            $average = ProductComment::getAverageGrade($id_product);

            $this->smarty->assign(array(

                'averageTotal' => round($average['grade']),

                'ratings' => ProductComment::getRatings($id_product),

                'nbComments' => (int)ProductComment::getCommentNumber($id_product)

            ));

            return $this->display(__FILE__, 'productcomments_reviews.tpl');

        }

        return;

    }

}