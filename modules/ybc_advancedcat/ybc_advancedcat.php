<?php

/**
 * Copyright YBC-Themes
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
 */

include_once(_PS_MODULE_DIR_ . 'ybc_advancedcat/classes/ybc_advancedcat_category_class.php');

if (!defined('_PS_VERSION_'))

    exit;


class Ybc_advancedcat extends Module

{

    public static $deepLevel = 0;

    private $errorMessage;

    private $baseAdminPath;

    private $_html;

    private $_hooks = array(

        'displayHeader',

        'displayTop',

        'displayBackOfficeHeader'

    );

    private $categoryFields = array(

        array(

            'name' => 'id_category',

            'primary_key' => true

        ),

        array(

            'name' => 'title',

            'multi_lang' => true

        ),

        array(

            'name' => 'description',

            'multi_lang' => true

        ),

        array(

            'name' => 'icon'

        ),

        array(

            'name' => 'banner'

        ),

        array(

            'name' => 'submenu_position'

        ),

        array(

            'name' => 'show_title',

            'default' => 1

        ),

        array(

            'name' => 'show_description',

            'default' => 1

        ),

        array(

            'name' => 'show_banner',

            'default' => 1

        ),

        array(

            'name' => 'include_subcategories',

            'default' => 1

        ),

        array(

            'name' => 'sort_order'

        ),

        array(

            'name' => 'banner_position'

        ),

        array(

            'name' => 'products'

        ),

        array(

            'name' => 'category'

        ),

        array(

            'name' => 'enabled',

            'default' => 1

        ),

    );

    public function __construct()

    {

        $this->name = 'ybc_advancedcat';

        $this->tab = 'front_office_features';

        $this->version = '1.0.1';

        $this->author = 'YBC-Themes';

        $this->need_instance = 0;

        $this->secure_key = Tools::encrypt($this->name);

        $this->bootstrap = true;


        parent::__construct();


        $this->displayName = $this->l('YBC Advanced Categories Block');

        $this->description = $this->l('Display categories block with icons and banners');

        $this->ps_versions_compliancy = array('min' => '1.6.0.0', 'max' => _PS_VERSION_);

        if (isset($this->context->controller->controller_type) && $this->context->controller->controller_type == 'admin')

            $this->baseAdminPath = $this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;


    }

    /**
     * @see Module::install()
     */

    public function install()

    {

        $res = parent::install();

        foreach ($this->_hooks as $hook) {

            $res &= $this->registerHook($hook);

        }

        $this->_installDb();

        return $res;

    }

    public function _installDb()

    {

        $tbls = array(

            "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "ybc_advancedcat_category` (

              `id_category` int(10) unsigned NOT NULL AUTO_INCREMENT,

              `enabled` tinyint(1) NOT NULL DEFAULT '1',

              `image` varchar(1000) DEFAULT NULL,

              `icon` varchar(2000) DEFAULT NULL,

              `category` int(11) DEFAULT '0',

              `products` varchar(1000) DEFAULT NULL,

              `sort_order` int(11) NOT NULL DEFAULT '1',

              `banner` varchar(1000) DEFAULT NULL,

              `banner_position` varchar(1000) NOT NULL DEFAULT 'BOTTOM',

              `submenu_position` varchar(1000) NOT NULL DEFAULT 'TOP',

              `show_title` tinyint(1) NOT NULL DEFAULT '1',

              `show_description` tinyint(1) NOT NULL DEFAULT '1',

              `show_banner` tinyint(1) NOT NULL DEFAULT '1',

              `include_subcategories` tinyint(1) NOT NULL DEFAULT '1',

              PRIMARY KEY (`id_category`)

            )",

            "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "ybc_advancedcat_category_lang` (

              `id_category` int(11) NOT NULL,

              `id_lang` int(11) NOT NULL,

              `title` varchar(2000) CHARACTER SET utf8 DEFAULT NULL,

              `description` text CHARACTER SET utf8

            )

            "

        );

        foreach ($tbls as $tbl)

            Db::getInstance()->execute($tbl);

        return true;

    }

    /**
     * @see Module::uninstall()
     */

    public function uninstall()

    {

        return parent::uninstall() && $this->_uninstallDb();

    }

    private function _uninstallDb()

    {

        $tbls = array('category', 'category_lang');

        foreach ($tbls as $tbl) {

            Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'ybc_advancedcat_' . $tbl . '`');

        }

        $dirs = array('category');

        foreach ($dirs as $dir) {

            $files = glob(dirname(__FILE__) . '/images/' . $dir . '/*');

            foreach ($files as $file) {

                if (is_file($file))

                    @unlink($file);

            }

        }

        return true;

    }

    public function getContent()

    {

        if (Tools::isSubmit('reorder')) {

            $this->_updateOrders();

            die(json_encode(array('updated' => 'true')));

        }

        $control = trim(Tools::getValue('control'));

        if (!$control)

            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name . '&control=main');

        if ($control == 'main')

            $this->context->controller->addJqueryUI('ui.sortable');

        //Process advancedcat

        $this->_html .= '<script type="text/javascript"> var ybc_advancedcats_short_url =  \'' . $this->baseAdminPath . '\'; var ybc_advancedcat_ajax_url = \'' . $this->_path . 'ajax.php\';</script>';

        $this->_html .= '<script type="text/javascript" src="' . $this->_path . 'js/admin.js"></script>';


        if ($control == 'advancedcat') {

            $this->_postAdvancedcat();

        }

        //Display errors if any

        if ($this->errorMessage)

            $this->_html .= $this->errorMessage;

        if ($control == 'advancedcat') {

            $this->renderAdvancedcatForm();

        } else {

            $this->renderMainForm();

        }

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

    public function _updateOrders()

    {

        $orders = Tools::getValue('sortcat');

        if ($orders && is_array($orders)) {

            foreach ($orders as $cat => $order) {

                $sql = "UPDATE " . _DB_PREFIX_ . "ybc_advancedcat_category SET sort_order = $order WHERE id_category=" . $cat;

                Db::getInstance()->execute($sql);

            }

        }

    }

    public function renderMainForm()

    {

        $advancedCats = $this->getAdvancedCats();

        $this->_html .= '<div class="panel">

                            <div class="panel-heading"><span class="advancedcat_title"> <i class="icon-AdminAdmin"></i>' . $this->l('Categories list') . '</span>

                                <span class="add_new_advancedcat"><a class="label-tooltip" data-toggle="tooltip" data-original-title="' . $this->l('Add new category') . '" href="' . $this->baseAdminPath . '&control=advancedcat" title=""><i class="process-icon-new "></i></a></span>

                            </div>';

        $this->_html .= '   <div class="form-wrapper">';

        $this->_html .= $this->displayAdvancedCats($advancedCats);

        $this->_html .= '   </div>

                        </div>';

    }

    public function displayAdvancedCats($advancedCats)

    {

        $this->smarty->assign(

            array(

                'advancedCats' => $advancedCats,

                'link' => $this->context->link

            )

        );

        return $this->display(__FILE__, 'catslist_backend.tpl');

    }

    public function renderAdvancedcatForm()

    {

        if (Tools::isSubmit('id_category')) {

            $category = new Ybc_advancedcat_category_class((int)Tools::getValue('id_category'));

        } else

            $category = false;

        $fields_form = array(

            'form' => array(

                'legend' => array(

                    'title' => (int)Tools::getValue('id_category') ? $this->l('Edit category') : $this->l('Add new category'),

                    'icon' => 'icon-AdminAdmin'

                ),

                'input' => array(

                    array(

                        'type' => 'text',

                        'label' => $this->l('Title'),

                        'name' => 'title',

                        'lang' => true,

                        'required' => true

                    ),

                    array(

                        'type' => 'textarea',

                        'label' => $this->l('Description'),

                        'name' => 'description',

                        'lang' => true,

                        'autoload_rte' => true

                    ),

                    array(

                        'type' => 'text',

                        'label' => $this->l('Awesome icon'),

                        'name' => 'icon',

                        'desc' => $this->l('Eg: fa-home, fa-phone...')

                    ),

                    array(

                        'type' => 'categories',

                        'label' => $this->l('Category'),

                        'name' => 'id_parent',

                        'tree' => array(

                            'id' => 'categories-tree',

                            'selected_categories' => (int)Tools::getValue('id_parent') ? array((int)Tools::getValue('id_parent')) : ($category ? array((int)$category->category) : array()),

                            'disabled_categories' => null,

                            'use_checkbox' => false,

                            'use_search' => true,

                            'root_category' => 2

                        ),

                        'required' => true,

                        'desc' => $this->l('Note: "Home" is not usable (Because there is no routings for it)')

                    ),

                    array(

                        'type' => 'switch',

                        'label' => $this->l('Include subcategories'),

                        'name' => 'include_subcategories',

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

                    ),

                    array(

                        'label' => $this->l('Submenu position'),

                        'type' => 'select',

                        'options' => array(

                            'query' => array(

                                array(

                                    'id_option' => 'TOP',

                                    'name' => $this->l('Top')

                                ),

                                array(

                                    'id_option' => 'LEFT',

                                    'name' => $this->l('Left')

                                ),

                            ),

                            'id' => 'id_option',

                            'name' => 'name'

                        ),

                        'default' => 'default',

                        'name' => 'submenu_position'

                    ),

                    array(

                        'type' => 'products_search',

                        'label' => $this->l('Featured product(s)'),

                        'name' => 'products',

                        'selected_products' => $this->getSelectedProducts()

                    ),

                    array(

                        'type' => 'file',

                        'label' => $this->l('Icon (Standard dimension: 25px x 25px)'),

                        'name' => 'image',

                        'display_img' => $category && $category->image ? $this->_path . 'images/category/' . $category->image : '',

                        'img_del_link' => $category && $category->image ? $this->baseAdminPath . '&delimage=yes&image=image&control=advancedcat&id_category=' . $category->id_category : '',

                    ),

                    array(

                        'type' => 'file',

                        'label' => $this->l('Banner'),

                        'name' => 'banner',

                        'display_img' => $category && $category->banner ? $this->_path . 'images/category/' . $category->banner : '',

                        'img_del_link' => $category && $category->banner ? $this->baseAdminPath . '&delimage=yes&image=banner&control=advancedcat&id_category=' . $category->id_category : '',

                    ),

                    array(

                        'label' => $this->l('Banner position'),

                        'type' => 'select',

                        'options' => array(

                            'query' => array(

                                array(

                                    'id_option' => 'BOTTOM',

                                    'name' => $this->l('After categories list')

                                ),

                                array(

                                    'id_option' => 'TOP',

                                    'name' => $this->l('Before categories list')

                                ),

                                array(

                                    'id_option' => 'LEFT',

                                    'name' => $this->l('On the left of categories list')

                                ),

                                array(

                                    'id_option' => 'RIGHT',

                                    'name' => $this->l('On the right of categories list')

                                ),

                            ),

                            'id' => 'id_option',

                            'name' => 'name'

                        ),

                        'default' => 'default',

                        'name' => 'banner_position'

                    ),

                    array(

                        'type' => 'switch',

                        'label' => $this->l('Show title'),

                        'name' => 'show_title',

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

                    ),

                    array(

                        'type' => 'switch',

                        'label' => $this->l('Show description'),

                        'name' => 'show_description',

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

                    ),

                    array(

                        'type' => 'switch',

                        'label' => $this->l('Show banner'),

                        'name' => 'show_banner',

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

                    ),

                    array(

                        'type' => 'switch',

                        'label' => $this->l('Enabled'),

                        'name' => 'enabled',

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

                    ),

                    array(

                        'type' => 'hidden',

                        'name' => 'control'

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

        $helper->submit_action = 'saveAdvancedcat';

        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;

        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

        $helper->tpl_vars = array(

            'base_url' => $this->context->shop->getBaseURL(),

            'language' => array(

                'id_lang' => $language->id,

                'iso_code' => $language->iso_code

            ),

            'PS_ALLOW_ACCENTED_CHARS_URL', (int)Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL'),

            'fields_value' => $this->getFieldsValues($this->categoryFields, 'id_category', 'Ybc_advancedcat_category_class', 'saveAdvancedcat'),

            'languages' => $this->context->controller->getLanguages(),

            'id_language' => $this->context->language->id,

            'image_baseurl' => $this->_path . 'images/',

            'link' => $this->context->link,

            'cancel_url' => $this->baseAdminPath . '&control=main',

            'add_url' => $this->baseAdminPath . '&control=advancedcat'

        );


        if (Tools::isSubmit('id_category') && $this->itemExists('category', 'id_category', (int)Tools::getValue('id_category'))) {

            $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_category');

            $advancedcat = new Ybc_advancedcat_category_class((int)Tools::getValue('id_category'));

            if ($advancedcat->image) {

                $helper->tpl_vars['display_img'] = $this->_path . 'images/advancedcat/' . $advancedcat->image;

                $helper->tpl_vars['img_del_link'] = $this->baseAdminPath . '&id_category=' . Tools::getValue('id_category') . '&deladvancedcatimage=true&control=advancedcat';

            }

        }

        $helper->override_folder = '/';

        $languages = Language::getLanguages(false);

        $this->_html .= $helper->generateForm(array($fields_form));

    }

    private function _postAdvancedcat()

    {

        $errors = array();

        $id_category = (int)Tools::getValue('id_category');

        if ($id_category && !$this->itemExists('category', 'id_category', $id_category))

            Tools::redirectAdmin($this->baseAdminPath);

        /**
         * Change status
         */

        if (Tools::isSubmit('change_enabled')) {

            $status = (int)Tools::getValue('change_enabled') ? 1 : 0;

            $id_category = (int)Tools::getValue('id_category');

            if ($id_category) {

                $this->changeStatus('category', 'enabled', $id_category, $status);

                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true) . '&conf=4&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name . '&control=main');

            }

        }

        /**
         * Delete image
         */

        if ($id_category && $this->itemExists('category', 'id_category', $id_category) && Tools::isSubmit('delimage')) {

            $field = trim(Tools::getValue('image'));

            if (in_array($field, array('image', 'banner'))) {

                $advancedcat = new Ybc_advancedcat_category_class($id_category);

                if ($advancedcat->$field) {

                    $imgUrl = dirname(__FILE__) . '/images/category/' . $advancedcat->$field;

                    if (file_exists($imgUrl)) {

                        @unlink($imgUrl);

                        $advancedcat->$field = '';

                        $advancedcat->update();

                        Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true) . '&conf=4&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name . '&id_category=' . Tools::getValue('id_category') . '&control=advancedcat');

                    } else

                        $errors[] = $this->l('Image does not exist');

                } else

                    $errors[] = $this->l('Image does not exist');

            } else

                $errors[] = $this->l('Image field is invalid');

        }

        /**
         * Delete advancedcat
         */

        if (Tools::isSubmit('del')) {

            $id_category = (int)Tools::getValue('id_category');

            if (!$this->itemExists('category', 'id_category', $id_category))

                $errors[] = $this->l('Item does not exist');

            elseif ($this->_deleteAdvancedcat($id_category)) {

                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true) . '&conf=4&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name . '&control=main');

            } else

                $errors[] = $this->l('Could not delete the item. Please try again');

        }

        /**
         * Save advancedcat
         */

        if (Tools::isSubmit('saveAdvancedcat')) {

            if ($id_category && $this->itemExists('category', 'id_category', $id_category)) {

                $advancedcat = new Ybc_advancedcat_category_class($id_category);

            } else {

                $advancedcat = new Ybc_advancedcat_category_class();

                $advancedcat->sort_order = 1;

            }

            $advancedcat->banner_position = in_array(Tools::getValue('banner_position'), array('BOTTOM', 'TOP', 'LEFT', 'RIGHT')) ? Tools::strtoupper(Tools::getValue('banner_position')) : 'BOTTOM';

            $advancedcat->submenu_position = in_array(Tools::getValue('submenu_position'), array('TOP', 'LEFT')) ? Tools::strtoupper(Tools::getValue('submenu_position')) : 'TOP';

            $advancedcat->enabled = trim(Tools::getValue('enabled', 1)) ? 1 : 0;

            $advancedcat->show_title = trim(Tools::getValue('show_title', 1)) ? 1 : 0;

            $advancedcat->show_description = trim(Tools::getValue('show_description', 1)) ? 1 : 0;

            $advancedcat->show_banner = trim(Tools::getValue('show_banner', 1)) ? 1 : 0;

            $advancedcat->include_subcategories = trim(Tools::getValue('include_subcategories', 1)) ? 1 : 0;

            $advancedcat->products = trim(trim(Tools::getValue('inputAccessories', '')), '-');

            $advancedcat->category = Tools::getValue('id_parent') ? (int)Tools::getValue('id_parent') : 0;

            if (!$advancedcat->category)

                $errors[] = $this->l('You need to choose a category');

            elseif ($advancedcat->category <= 2)

                $errors[] = $this->l('"Home" category is not usable. Please choose another category');

            $advancedcat->icon = trim(Tools::getValue('icon'));

            if ($advancedcat->icon != '' && !preg_match('/^fa-(.)+$/', $advancedcat->icon))

                $errors[] = $this->l('Awesome icon is not vaild');

            $languages = Language::getLanguages(false);

            foreach ($languages as $language) {

                $advancedcat->title[$language['id_lang']] = trim(Tools::getValue('title_' . $language['id_lang'])) != '' ? trim(Tools::getValue('title_' . $language['id_lang'])) : trim(Tools::getValue('title_' . Configuration::get('PS_LANG_DEFAULT')));

                if ($advancedcat->title[$language['id_lang']] && !Validate::isCleanHtml($advancedcat->title[$language['id_lang']]))

                    $errors[] = $this->l('Title in ' . $language['name'] . ' is not valid');

                $advancedcat->description[$language['id_lang']] = trim(Tools::getValue('description_' . $language['id_lang'])) != '' ? trim(Tools::getValue('description_' . $language['id_lang'])) : trim(Tools::getValue('description_' . Configuration::get('PS_LANG_DEFAULT')));

                if ($advancedcat->description[$language['id_lang']] && !Validate::isCleanHtml($advancedcat->description[$language['id_lang']]))

                    $errors[] = $this->l('Description in ' . $language['name'] . ' is not valid');

            }

            if (isset($advancedcat->title[(int)Configuration::get('PS_LANG_DEFAULT')]) && empty($advancedcat->title[(int)Configuration::get('PS_LANG_DEFAULT')]))

                $errors[] = $this->l('Title is required for default language');


            if ($advancedcat->products && !preg_match('/^[0-9]+(-[0-9]+)*$/', $advancedcat->products))

                $errors[] = $this->l('Featured products field is not valid');


            //Upload images

            $oldImage = false;

            $newImage = false;

            $oldBanner = false;

            $newBanner = false;


            if (!$errors) {

                $imageUpload = $this->uploadImage('image', 'category');

                $bannerUpload = $this->uploadImage('banner', 'category');


                if ($imageUpload['image']) {

                    $newImage = $imageUpload['image'];

                    if (!empty($advancedcat->image))

                        $oldImage = dirname(__FILE__) . '/images/category/' . $advancedcat->image;

                    $advancedcat->image = $imageUpload['fileName'];

                }

                if ($imageUpload['errors'])

                    $errors = array_merge($errors, $imageUpload['errors']);


                if ($bannerUpload['image']) {

                    $newBanner = $bannerUpload['image'];

                    if (!empty($advancedcat->banner))

                        $oldBanner = dirname(__FILE__) . '/images/category/' . $advancedcat->banner;

                    $advancedcat->banner = $bannerUpload['fileName'];

                }

                if ($bannerUpload['errors'])

                    $errors = array_merge($errors, $bannerUpload['errors']);


            }


            /**
             * Save
             */

            if (!$errors) {

                if (!Tools::getValue('id_category')) {

                    if (!$advancedcat->add()) {

                        $errors[] = $this->displayError($this->l('The item could not be added.'));

                        if ($newImage && file_exists($newImage))

                            @unlink($newImage);

                        if ($newBanner && file_exists($newBanner))

                            @unlink($newBanner);

                    }

                } elseif (!$advancedcat->update()) {

                    if ($newImage && file_exists($newImage))

                        @unlink($newImage);

                    if ($newBanner && file_exists($newBanner))

                        @unlink($newBanner);

                    $errors[] = $this->displayError($this->l('The item could not be updated.'));

                } else {

                    if ($oldImage && file_exists($oldImage))

                        @unlink($oldImage);

                    if ($oldBanner && file_exists($oldBanner))

                        @unlink($oldBanner);


                }

            }

        }

        if (count($errors)) {

            if ($newImage && file_exists($newImage))

                @unlink($newImage);

            if ($newBanner && file_exists($newBanner))

                @unlink($newBanner);


            $this->errorMessage = $this->displayError(implode('<br />', $errors));

        } elseif (Tools::isSubmit('saveAdvancedcat') && Tools::isSubmit('id_category'))

            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true) . '&conf=4&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name . '&id_category=' . Tools::getValue('id_category') . '&control=advancedcat');

        elseif (Tools::isSubmit('saveAdvancedcat')) {

            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true) . '&conf=3&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name . '&id_category=' . $this->getMaxId('category', 'id_category') . '&control=advancedcat');

        }

    }

    public function uploadImage($field, $directory)

    {

        $result = array(

            'image' => false,

            'fileName' => false,

            'errors' => false

        );

        $errors = array();

        if (isset($_FILES[$field]['tmp_name']) && isset($_FILES[$field]['name']) && $_FILES[$field]['name']) {
            $fileName = str_replace(' ', '_', trim(Tools::strtolower($_FILES[$field]['name'])));
            $baseImgDirectory = dirname(__FILE__) . '/images/' . $directory;
            if (!file_exists($baseImgDirectory)) {
                @mkdir($baseImgDirectory,0777,true);
            }
            if (file_exists(dirname(__FILE__) . '/images/' . $directory . '/' . $fileName)) {

                $fileName = sha1(microtime()) . '_' . $fileName;

            }

            if (file_exists(dirname(__FILE__) . '/images/' . $directory . '/' . $fileName)) {

                $errors[] = '"' . $field . '" - ' . $this->l('Image file name already exists. Try to rename the file name then reupload it');

            } else {

                $type = Tools::strtolower(Tools::substr(strrchr($_FILES[$field]['name'], '.'), 1));

                $imagesize = @getimagesize($_FILES[$field]['tmp_name']);

                if (isset($_FILES[$field]) &&

                    !empty($_FILES[$field]['tmp_name']) &&

                    !empty($imagesize) &&

                    in_array($type, array('jpg', 'gif', 'jpeg', 'png'))

                ) {

                    $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');

                    if ($error = ImageManager::validateUpload($_FILES[$field]))

                        $errors[] = $error;

                    elseif (!$temp_name || !move_uploaded_file($_FILES[$field]['tmp_name'], $temp_name))

                        $errors[] = $this->l('Can not upload the file');

                    elseif (!ImageManager::resize($temp_name, dirname(__FILE__) . '/images/' . $directory . '/' . $fileName, null, null, $type))
                    {
                        $errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
                    }



                    $result['image'] = dirname(__FILE__) . '/images/' . $directory . '/' . $fileName;

                    $result['fileName'] = $fileName;

                    if (isset($temp_name))

                        @unlink($temp_name);

                } else

                    $errors[] = '"' . $field . '" ' . $this->l(' is not valid');

            }

        }

        if ($errors)

            $result['errors'] = $errors;

        return $result;

    }

    public function itemExists($tbl, $primaryKey, $id)

    {

        $req = 'SELECT `' . $primaryKey . '`

				FROM `' . _DB_PREFIX_ . 'ybc_advancedcat_' . $tbl . '` tbl

				WHERE tbl.`' . $primaryKey . '` = ' . (int)$id;

        $row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);

        return ($row);

    }

    public function getMaxId($tbl, $primaryKey)

    {

        $req = 'SELECT max(`' . $primaryKey . '`) as maxid

				FROM `' . _DB_PREFIX_ . 'ybc_advancedcat_' . $tbl . '` tbl';

        $row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);

        return isset($row['maxid']) ? (int)$row['maxid'] : 0;

    }

    public function getFieldsValues($formFields, $primaryKey, $objClass, $saveBtnName)

    {

        $fields = array();

        $id_lang_default = Configuration::get('PS_LANG_DEFAULT');

        if (Tools::isSubmit($primaryKey)) {

            $obj = new $objClass((int)Tools::getValue($primaryKey));

            $fields[$primaryKey] = (int)Tools::getValue($primaryKey, $obj->$primaryKey);

        } else {

            $obj = new $objClass();

        }

        foreach ($formFields as $field) {

            if (!isset($field['primary_key']) && !isset($field['multi_lang']) && !isset($field['connection'])) {
                $attr = $field['name'];
                $fields[$field['name']] = trim(Tools::getValue($field['name'], $obj->$attr));
            }

        }

        $languages = Language::getLanguages(false);

        /**
         *  Default
         */

        if (!Tools::isSubmit($saveBtnName) && !Tools::isSubmit($primaryKey)) {

            foreach ($formFields as $field) {

                if (isset($field['default']) && !isset($field['multi_lang'])) {

                    if (isset($field['default_submit']))

                        $fields[$field['name']] = (int)Tools::getValue($field['name']) ? (int)Tools::getValue($field['name']) : $field['default'];

                    else

                        $fields[$field['name']] = $field['default'];

                }

            }

        }

        /**
         * Multiple language
         */

        foreach ($languages as $lang) {

            foreach ($formFields as $field) {

                $attrName = $field['name'];
                if (!Tools::isSubmit($saveBtnName) && !Tools::isSubmit($primaryKey)) {

                    if (isset($field['multi_lang'])) {

                        if (isset($field['default']))

                            $fields[$field['name']][$lang['id_lang']] = $field['default'];

                        else

                            $fields[$field['name']][$lang['id_lang']] = '';

                    }

                } elseif (Tools::isSubmit($saveBtnName)) {

                    if (isset($field['multi_lang']))

                        $fields[$field['name']][$lang['id_lang']] = Tools::getValue($field['name'] . '_' . (int)$lang['id_lang']);


                } else {

                    if (isset($field['multi_lang'])) {

                        $field_langs = $obj->$attrName;

                        $fields[$field['name']][$lang['id_lang']] = $field_langs[$lang['id_lang']];

                    }

                }

            }

        }

        $fields['control'] = trim(Tools::getValue('control')) ? trim(Tools::getValue('control')) : '';

        return $fields;

    }

    private function _deleteAdvancedcat($id_category)

    {

        if ($this->itemExists('category', 'id_category', $id_category)) {

            $advancedcat = new Ybc_advancedcat_category_class($id_category);

            if ($advancedcat->image && file_exists(dirname(__FILE__) . '/images/category/' . $advancedcat->image)) {

                @unlink(dirname(__FILE__) . '/images/category/' . $advancedcat->image);

            }

            if ($advancedcat->banner && file_exists(dirname(__FILE__) . '/images/category/' . $advancedcat->banner)) {

                @unlink(dirname(__FILE__) . '/images/category/' . $advancedcat->banner);

            }

            return $advancedcat->delete();

        }

        return false;

    }

    public function changeStatus($tbl, $field, $id, $status)

    {

        $req = "UPDATE " . _DB_PREFIX_ . "ybc_advancedcat_$tbl SET `enabled`=$status WHERE id_$tbl=$id";

        return Db::getInstance()->execute($req);

    }

    public function getSelectedProducts()

    {

        $products = array();

        if (Tools::isSubmit('inputAccessories') && trim(trim(Tools::getValue('inputAccessories')), ',')) {

            $products = explode('-', trim(trim(Tools::getValue('inputAccessories')), '-'));

        } else {

            $id_category = (int)Tools::getValue('id_category');

            if ($this->itemExists('category', 'id_category', $id_category)) {

                $category = new Ybc_advancedcat_category_class($id_category);

                if ($category->products)

                    $products = explode('-', $category->products);

            }

        }


        if ($products) {

            foreach ($products as $key => &$product) {

                $product = (int)$product;

            }

            $sql = 'SELECT p.`id_product`, pl.`name`,p.`reference`

				FROM `' . _DB_PREFIX_ . 'product` p

                ' . Shop::addSqlAssociation('product', 'p') . '

				LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (p.`id_product` = pl.`id_product` ' . Shop::addSqlRestrictionOnLang('pl') . ')

				WHERE pl.`id_lang` = ' . (int)$this->context->language->id . ' AND p.`id_product` IN (' . implode(',', $products) . ')';

            $product_list = Db::getInstance()->executeS($sql);

            return $product_list;

        }

        return false;

    }

    public function getAdvancedCats($enabled = false)

    {

        $sql = "SELECT c.*, cl.title, cl.description

                FROM  " . _DB_PREFIX_ . "ybc_advancedcat_category c              

                LEFT JOIN " . _DB_PREFIX_ . "ybc_advancedcat_category_lang cl on c.id_category = cl.id_category AND cl.id_lang = " . (int)$this->context->language->id . "

                WHERE 1 " . ($enabled ? " AND c.enabled = 1 " : "") . "

                ORDER BY c.sort_order ASC, cl.title ASC";

        $categories = Db::getInstance()->executeS($sql);

        if ($categories) {

            foreach ($categories as &$cat) {

                if ($cat['category'])

                    $cat['category'] = $this->getCagetoryInfo($cat['category'], $enabled);

                if ($cat['products'])

                    $cat['products'] = $this->getProductsList($cat['products']);

                if ($cat['image'])

                    $cat['image'] = $this->_path . 'images/category/' . $cat['image'];

                if ($cat['banner'])

                    $cat['banner'] = $this->_path . 'images/category/' . $cat['banner'];

                if (isset($this->context->controller->controller_type) && $this->context->controller->controller_type == 'admin') {

                    $cat['edit_link'] = $this->baseAdminPath . '&control=advancedcat&id_category=' . $cat['id_category'];

                    $cat['delete_link'] = $this->baseAdminPath . '&control=advancedcat&id_category=' . $cat['id_category'] . '&del=yes';

                    $cat['enabled_link'] = $this->baseAdminPath . '&control=advancedcat&id_category=' . $cat['id_category'] . '&change_enabled=' . ($cat['enabled'] ? '0' : '1');

                } else {

                    $cat['edit_link'] = '';

                    $cat['delete_link'] = '';

                    $cat['enabled_link'] = '';

                }

                $cat['bannerClass'] = 'banner-advancedcat';

            }

        }

        return $categories;

    }

    public static function getSubCatList($trees, $active = false)

    {

        $html = '';

        if ($trees) {

            self::$deepLevel++;

            if (self::$deepLevel > 1 && self::checkSubExist($trees))

                $html .= '<ul class="deep-level-' . self::$deepLevel . '">';

            foreach ($trees as $tree) {

                $cat = new Category((int)$tree['id_category'], (int)Context::getContext()->language->id);

                if (!$active || $active && $cat->active) {

                    if (self::$deepLevel > 1)

                        $html .= '<li class="ybc-ac-item"><a href="' . $cat->getLink() . '">' . $cat->name . '</a>';

                    if (isset($tree['children']) && $tree['children']) {

                        if (self::checkSubExist($tree['children']) && self::$deepLevel > 1)

                            $html .= '<i class="has-subcats"></i><span class="ybc-ac-oc-btn closed">+/-</span>';

                        $html .= self::getSubCatList($tree['children'], $active);

                    }

                    if (self::$deepLevel > 1)

                        $html .= '</li>';

                }

            }

            if (self::$deepLevel > 1 && self::checkSubExist($trees))

                $html .= '</ul>';

            self::$deepLevel--;

        }

        return $html;

    }

    public static function checkSubExist($trees)

    {

        if ($trees)

            foreach ($trees as $tree) {

                $cat = new Category((int)$tree['id_category'], (int)Context::getContext()->language->id);

                if ($cat->active)

                    return true;

            }

        return false;

    }

    public function getCagetoryInfo($id_category, $active = false)

    {

        $info = array();

        if ($id_category >= 2) {

            $sql = "SELECT c.id_category

                    FROM " . _DB_PREFIX_ . "category c 

                    WHERE c.id_category = " . $id_category;

            if (Db::getInstance()->getRow($sql)) {

                $cat = new Category($id_category, (int)$this->context->language->id);

                $info = array(

                    'name' => $cat->name,

                    'url' => $cat->getLink()

                );

                $treeHelper = new HelperTreeCategories('categories-blocksearch-model', null, $id_category, (int)Context::getContext()->language->id);

                $categoriesTree = $treeHelper->getData();

                if ($categoriesTree)

                    $info['subcatHtml'] = self::getSubCatList($categoriesTree, $active);

                else

                    $info['subcatHtml'] = '';

            }

        }

        return $info;

    }

    public function getIdsArgsFromIdsStr($ids_string)

    {

        $ids = array();

        if ($ids_string) {

            $elements = explode('-', $ids_string);

            if ($elements) {

                foreach ($elements as $id)

                    if (!in_array((int)$id, $ids))

                        $ids[] = $id;

            }

        }

        return $ids;

    }

    public function getProductsList($ids_string, $id_lang = null, $order_by = null, $order_way = null, $active = true, $random = false, $random_number_products = 1, Context $context = null)

    {

        if (is_null($id_lang))

            $id_lang = (int)$this->context->language->id;

        $ids = $this->getIdsArgsFromIdsStr($ids_string);

        if (!$ids)

            return array();

        if (!$context)

            $context = Context::getContext();

        $front = true;

        if (!in_array($context->controller->controller_type, array('front', 'modulefront')))

            $front = false;


        if (empty($order_by))

            $order_by = 'position';

        else

            /* Fix for all modules which are now using lowercase values for 'orderBy' parameter */

            $order_by = strtolower($order_by);


        if (empty($order_way))

            $order_way = 'ASC';


        $order_by_prefix = false;

        if ($order_by == 'id_product' || $order_by == 'date_add' || $order_by == 'date_upd')

            $order_by_prefix = 'p';

        elseif ($order_by == 'name')

            $order_by_prefix = 'pl';

        elseif ($order_by == 'manufacturer' || $order_by == 'manufacturer_name') {

            $order_by_prefix = 'm';

            $order_by = 'name';

        } elseif ($order_by == 'position')

            $order_by_prefix = 'cp';


        if ($order_by == 'price')

            $order_by = 'orderprice';


        if (!Validate::isBool($active) || !Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way))

            die (Tools::displayError());


        $id_supplier = (int)Tools::getValue('id_supplier');


        $sql = 'SELECT p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity' . (Combination::isFeatureActive() ? ', MAX(product_attribute_shop.id_product_attribute) id_product_attribute, MAX(product_attribute_shop.minimal_quantity) AS product_attribute_minimal_quantity' : '') . ', pl.`description`, pl.`description_short`, pl.`available_now`,

					pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, MAX(image_shop.`id_image`) id_image,

					MAX(il.`legend`) as legend, m.`name` AS manufacturer_name, cl.`name` AS category_default,

					DATEDIFF(product_shop.`date_add`, DATE_SUB(NOW(),

					INTERVAL ' . (Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20) . '

						DAY)) > 0 AS new, product_shop.price AS orderprice

				FROM `' . _DB_PREFIX_ . 'category_product` cp

				LEFT JOIN `' . _DB_PREFIX_ . 'product` p

					ON p.`id_product` = cp.`id_product`

				' . Shop::addSqlAssociation('product', 'p') .

            (Combination::isFeatureActive() ? 'LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute` pa

				ON (p.`id_product` = pa.`id_product`)

				' . Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1') . '

				' . Product::sqlStock('p', 'product_attribute_shop', false, $context->shop) : Product::sqlStock('p', 'product', false, Context::getContext()->shop)) . '

				LEFT JOIN `' . _DB_PREFIX_ . 'category_lang` cl

					ON (product_shop.`id_category_default` = cl.`id_category`

					AND cl.`id_lang` = ' . (int)$id_lang . Shop::addSqlRestrictionOnLang('cl') . ')

				LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl

					ON (p.`id_product` = pl.`id_product`

					AND pl.`id_lang` = ' . (int)$id_lang . Shop::addSqlRestrictionOnLang('pl') . ')

				LEFT JOIN `' . _DB_PREFIX_ . 'image` i

					ON (i.`id_product` = p.`id_product`)' .

            Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1') . '

				LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il

					ON (image_shop.`id_image` = il.`id_image`

					AND il.`id_lang` = ' . (int)$id_lang . ')

				LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m

					ON m.`id_manufacturer` = p.`id_manufacturer`

				WHERE product_shop.`id_shop` = ' . (int)$context->shop->id . '

					AND cp.`id_product` IN (' . implode(',', $ids) . ') '

            . ($active ? ' AND product_shop.`active` = 1' : '')

            . ($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '')

            . ($id_supplier ? ' AND p.id_supplier = ' . (int)$id_supplier : '')

            . ' GROUP BY product_shop.id_product';


        if ($random === true)

            $sql .= ' ORDER BY RAND() LIMIT ' . (int)$random_number_products;

        else

            $sql .= ' ORDER BY ' . (!empty($order_by_prefix) ? $order_by_prefix . '.' : '') . '`' . bqSQL($order_by) . '` ' . pSQL($order_way);


        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        if ($order_by == 'orderprice')

            Tools::orderbyPrice($result, $order_way);


        if (!$result)

            return array();


        /* Modify SQL result */

        return Product::getProductsProperties($id_lang, $result);

    }

    public function hookDisplayBackOfficeHeader()

    {

        $this->context->controller->addCSS((__PS_BASE_URI__) . 'modules/' . $this->name . '/css/admin.css', 'all');

    }

    public function hookDisplayHeader()

    {

        $this->context->controller->addCSS((__PS_BASE_URI__) . 'modules/' . $this->name . '/css/advancedcat.css', 'all');

        $this->context->controller->addJS((__PS_BASE_URI__) . 'modules/' . $this->name . '/js/advancedcat.js');

    }

    public function hookDisplayHome()

    {

        $cats = $this->getAdvancedCats(true);


        $this->smarty->assign(

            array(

                'advancedCats' => $cats,

                'link' => $this->context->link,

                'product_list_tpl' => dirname(__FILE__) . '/views/templates/hook/product_list.tpl'

            )

        );

        return $this->display(__FILE__, 'advancedcats.tpl');

    }

    public function hookDisplayTop()

    {

        return $this->hookDisplayHome();

    }

    public function hookDisplayLeftColumn()

    {

        return $this->hookDisplayHome();

    }

    public function hookDisplayRightColumn()

    {

        return $this->hookDisplayHome();

    }

}