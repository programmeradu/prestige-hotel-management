<?php

/**

 * Copyright YBC-Themes

 * Email: support@yourbestcode.com

 * First created: 21/12/2015

 * Last updated: NOT YET

*/

include_once(_PS_MODULE_DIR_.'ybc_featuredcat/classes/ybc_featuredcat_category_class.php');

if (!defined('_PS_VERSION_'))

	exit;

   

class Ybc_featuredcat extends Module

{

    private $errorMessage;

    private $baseAdminPath;

    private $_html;

    private $_hooks = array(

        'displayHeader',

        'displayHome',

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

            'name' => 'link'

        ),         

        array(

            'name' => 'banner1'

        ), 

        array(

            'name' => 'banner2'

        ), 

        array(

            'name' => 'banner3'

        ),  

        array(

            'name' => 'banner1_link'

        ), 

        array(

            'name' => 'banner2_link'

        ),

        array(

            'name' => 'banner3_link'

        ),       

        array(

            'name' => 'image'

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

            'name' => 'enabled',

            'default' => 1

        ),        

    );

    public function __construct()

	{

		$this->name = 'ybc_featuredcat';

		$this->tab = 'front_office_features';

		$this->version = '1.0.1';

		$this->author = 'YBC-Themes';

		$this->need_instance = 0;

		$this->secure_key = Tools::encrypt($this->name);

		$this->bootstrap = true;



		parent::__construct();



		$this->displayName = $this->l('YBC Featured Categories');

		$this->description = $this->l('Display featured categories with products slider on your home page');

		$this->ps_versions_compliancy = array('min' => '1.6.0.0', 'max' => _PS_VERSION_); 

        if(isset($this->context->controller->controller_type) && $this->context->controller->controller_type =='admin')

            $this->baseAdminPath = $this->context->link->getAdminLink('AdminModules').'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;        

        

    }

    /**

	 * @see Module::install()

	 */

    public function install()

	{

	    $res = parent::install();        

        foreach($this->_hooks as $hook)

        {

            $res &= $this->registerHook($hook);

        }

        $this->_installDb();

        return  $res;

    }

    public function _installDb()

    {

        $tbls = array(

            "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_featuredcat_category` (

              `id_category` int(10) unsigned NOT NULL AUTO_INCREMENT,

              `enabled` tinyint(1) NOT NULL DEFAULT '1',

              `image` varchar(1000) DEFAULT NULL,

              `link` varchar(2000) DEFAULT NULL,

              `categories` varchar(1000) DEFAULT NULL,

              `products` varchar(1000) DEFAULT NULL,

              `sort_order` int(11) NOT NULL DEFAULT '1',

              `banner1` varchar(1000) DEFAULT NULL,

              `banner2` varchar(1000) DEFAULT NULL,

              `banner3` varchar(1000) DEFAULT NULL,

              `banner1_link` varchar(2000) DEFAULT NULL,

              `banner2_link` varchar(2000) DEFAULT NULL,

              `banner3_link` varchar(2000) DEFAULT NULL,

              `banner_position` varchar(1000) NOT NULL DEFAULT 'BOTTOM',

              PRIMARY KEY (`id_category`)

            )",

            "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."ybc_featuredcat_category_lang` (

              `id_category` int(11) NOT NULL,

              `id_lang` int(11) NOT NULL,

              `title` varchar(2000) CHARACTER SET utf8 DEFAULT NULL

            )

            "

        );

        foreach($tbls as $tbl)

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

        foreach($tbls as $tbl)

        {

            Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'ybc_featuredcat_'.$tbl.'`');

        }        

        $dirs = array('category');

        foreach($dirs as $dir)

        {

            $files = glob(dirname(__FILE__).'/images/'.$dir.'/*'); 

            foreach($files as $file){ 

              if(is_file($file))

                @unlink($file); 

            }

        }      

        return true;

    }

    public function getContent()

	{

	   if(Tools::isSubmit('reorder'))

       {

            $this->_updateOrders();

            die(json_encode(array('updated' => 'true')));

       }

	   $control = trim(Tools::getValue('control'));

       if(!$control)

            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&control=main');

       if($control == 'main')

            $this->context->controller->addJqueryUI('ui.sortable');

       //Process featuredcat

       $this->_html .= '<script type="text/javascript"> var ybc_featuredcats_short_url =  \''.$this->baseAdminPath.'\'; var ybc_featuredcat_ajax_url = \''.$this->_path.'ajax.php\';</script>';

       $this->_html .= '<script type="text/javascript" src="'.$this->_path.'js/admin.js"></script>';

         

       if($control=='featuredcat')

       {

            $this->_postFeaturedcat();   

       }       

       //Display errors if any

       if($this->errorMessage)

            $this->_html .= $this->errorMessage;  

       if($control=='featuredcat')

       {

            $this->renderFeaturedcatForm();

       }

       else

       {

            $this->renderMainForm();

       }

       return $this->_html.$this->displayIframe();

    }
    public function displayIframe()
    {
        switch($this->context->language->iso_code) {
          case 'en':
            $url = 'https://cdn.prestahero.com/prestahero-product-feed?utm_source=feed_'.$this->name.'&utm_medium=iframe';
            break;
          case 'it':
            $url = 'https://cdn.prestahero.com/it/prestahero-product-feed?utm_source=feed_'.$this->name.'&utm_medium=iframe';
            break;
          case 'fr':
            $url = 'https://cdn.prestahero.com/fr/prestahero-product-feed?utm_source=feed_'.$this->name.'&utm_medium=iframe';
            break;
          case 'es':
            $url = 'https://cdn.prestahero.com/es/prestahero-product-feed?utm_source=feed_'.$this->name.'&utm_medium=iframe';
            break;
          default:
            $url = 'https://cdn.prestahero.com/prestahero-product-feed?utm_source=feed_'.$this->name.'&utm_medium=iframe';
        }
        $this->smarty->assign(
            array(
                'url_iframe' => $url
            )
        );
        return $this->display(__FILE__,'iframe.tpl');
    }
    public function _updateOrders()

    {

        $orders = Tools::getValue('sortcat');

        if($orders && is_array($orders))

        {

            foreach($orders as $cat => $order)

            {

                $sql = "UPDATE "._DB_PREFIX_."ybc_featuredcat_category SET sort_order = $order WHERE id_category=".$cat;

                Db::getInstance()->execute($sql);

            }

        }

    }

    public function renderMainForm()

    { 

        $featuredCats = $this->getFeaturedCats();

        $this->_html .= '<div class="panel">

                            <div class="panel-heading"><span class="featuredcat_title"> <i class="icon-AdminAdmin"></i>'.$this->l('Featured categories').'</span>

                                <span class="add_new_featuredcat"><a class="label-tooltip" data-toggle="tooltip" data-original-title="'.$this->l('Add new featured category block').'" href="'.$this->baseAdminPath.'&control=featuredcat" title=""><i class="process-icon-new "></i></a></span>

                            </div>';

        $this->_html .= '   <div class="form-wrapper">';

        $this->_html .= $this->displayFeaturedCats($featuredCats);

        $this->_html .= '   </div>

                        </div>';

    }

    public function displayFeaturedCats($featuredCats)

    {

        $this->smarty->assign(

            array(

                'featuredCats' => $featuredCats,

                'link' => $this->context->link

            )

        );

        return $this->display(__FILE__, 'catslist_backend.tpl');

    }

    public function renderFeaturedcatForm()

    {

            if(Tools::isSubmit('id_category'))

            {

                $category = new Ybc_featuredcat_category_class((int)Tools::getValue('id_category'));

            }

            else

                $category = false;

            $fields_form = array(

    			'form' => array(

    				'legend' => array(

    					'title' => (int)Tools::getValue('id_category') ? $this->l('Edit featured category') : $this->l('Add new featured category'),

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

    						'type' => 'text',

    						'label' => $this->l('Custom link'),

    						'name' => 'link',

                            'desc' => $this->l('Eg: http://yourwebsite.com')

                        ),                        

                        array(

    						'type'  => 'categories',

        					'label' => $this->l('Categories'),

        					'name'  => 'categories',                        

        					'tree'  => array(

        						'id'      => 'categories-tree',

        						'selected_categories' => $this->getSelectedCategories(),

        						'disabled_categories' => null,

                                'use_checkbox' => true,

                                'use_search' => true,

                                'root_category' => 2

        					),    

                            'desc' => $this->l('Note: "Home" category will be excluded from categories list on frontend (Because there is no routings for it)')                         					              

    					), 

                        array(

    						'type' => 'products_search',

    						'label' => $this->l('Featured product(s)'),

    						'name' => 'products',

                            'selected_products' => $this->getSelectedProducts()                               						              

    					),                    

                        array(

    						'type' => 'file',

    						'label' => $this->l('Image'),

    						'name' => 'image',

                            'display_img' => $category && $category->image ? $this->_path.'images/category/'.$category->image : '',					

			                'img_del_link' => $category && $category->image ? $this->baseAdminPath.'&delimage=yes&image=image&control=featuredcat&id_category='.$category->id_category : '',

                        ),

                        array(

    						'type' => 'file',

    						'label' => $this->l('Banner 1'),

    						'name' => 'banner1',

                            'display_img' => $category && $category->banner1 ? $this->_path.'images/category/'.$category->banner1 : '',					

			                'img_del_link' => $category && $category->banner1 ? $this->baseAdminPath.'&delimage=yes&image=banner1&control=featuredcat&id_category='.$category->id_category : '',					

    					),

                        array(

    						'type' => 'text',

    						'label' => $this->l('Banner 1 link'),

    						'name' => 'banner1_link',

                            'desc' => $this->l('Eg: http://yourwebsite.com')

                        ),

                        array(

    						'type' => 'file',

    						'label' => $this->l('Banner 2'),

    						'name' => 'banner2',

                            'display_img' => $category && $category->banner2 ? $this->_path.'images/category/'.$category->banner2 : '',					

			                'img_del_link' => $category && $category->banner2 ? $this->baseAdminPath.'&delimage=yes&image=banner2&control=featuredcat&id_category='.$category->id_category : '',					

    					),

                        array(

    						'type' => 'text',

    						'label' => $this->l('Banner 2 link'),

    						'name' => 'banner2_link',

                            'desc' => $this->l('Eg: http://yourwebsite.com')

                        ),

                        array(

    						'type' => 'file',

    						'label' => $this->l('Banner3'),

    						'name' => 'banner3',

                            'display_img' => $category && $category->banner3 ? $this->_path.'images/category/'.$category->banner3 : '',					

			                'img_del_link' => $category && $category->banner3 ? $this->baseAdminPath.'&delimage=yes&image=banner3&control=featuredcat&id_category='.$category->id_category : '',					

    					),

                        array(

    						'type' => 'text',

    						'label' => $this->l('Banner 3 link'),

    						'name' => 'banner3_link',

                            'desc' => $this->l('Eg: http://yourwebsite.com')

                        ),

                        'banner_position' => array(

                            'label' => $this->l('Banner position'),

                            'type' => 'select',                                              

            				'options' => array(

                    			 'query' => array( 

                                        array(

                                            'id_option' => 'BOTTOM', 

                                            'name' => $this->l('After categories block')

                                        ),

                                        array(

                                            'id_option' => 'TOP', 

                                            'name' => $this->l('Before categories block')

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

    		$helper->submit_action = 'saveFeaturedcat';

    		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;

    		$helper->token = Tools::getAdminTokenLite('AdminModules');

    		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

            $helper->tpl_vars = array(

    			'base_url' => $this->context->shop->getBaseURL(),

    			'language' => array(

    				'id_lang' => $language->id,

    				'iso_code' => $language->iso_code

    			),

                'PS_ALLOW_ACCENTED_CHARS_URL', (int)Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL'),

    			'fields_value' => $this->getFieldsValues($this->categoryFields,'id_category','Ybc_featuredcat_category_class','saveFeaturedcat'),

    			'languages' => $this->context->controller->getLanguages(),

    			'id_language' => $this->context->language->id,

    			'image_baseurl' => $this->_path.'images/',

                'link' => $this->context->link,

                'cancel_url' => $this->baseAdminPath.'&control=main',

                'add_url' => $this->baseAdminPath.'&control=featuredcat'

    		);

            

            if(Tools::isSubmit('id_category') && $this->itemExists('category','id_category',(int)Tools::getValue('id_category')))

            {                

                $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_category');

                $featuredcat = new Ybc_featuredcat_category_class((int)Tools::getValue('id_category'));

                if($featuredcat->image)

                {             

                    $helper->tpl_vars['display_img'] = $this->_path.'images/featuredcat/'.$featuredcat->image;

                    $helper->tpl_vars['img_del_link'] = $this->baseAdminPath.'&id_category='.Tools::getValue('id_category').'&delfeaturedcatimage=true&control=featuredcat';                

                }

            }            

    		$helper->override_folder = '/';    

    		$languages = Language::getLanguages(false);            

            $this->_html .= $helper->generateForm(array($fields_form));	

    }

    private function _postFeaturedcat()

    {

        $errors = array();

        $id_category = (int)Tools::getValue('id_category');

        if($id_category && !$this->itemExists('category','id_category',$id_category))

            Tools::redirectAdmin($this->baseAdminPath);

        /**

         * Change status 

         */

         if(Tools::isSubmit('change_enabled'))

         {

            $status = (int)Tools::getValue('change_enabled') ?  1 : 0;

            $id_category = (int)Tools::getValue('id_category');            

            if($id_category)

            {

                $this->changeStatus('category','enabled',$id_category,$status);

                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&control=main');

            }

         }

        /**

         * Delete image 

         */         

         if($id_category && $this->itemExists('category','id_category',$id_category) && Tools::isSubmit('delimage'))

         {

            $field = trim(Tools::getValue('image'));

            if(in_array($field, array('image','banner1','banner2','banner3')))

            {

                $featuredcat = new Ybc_featuredcat_category_class($id_category);

                if($featuredcat->$field)

                {

                    $imgUrl = dirname(__FILE__).'/images/category/'.$featuredcat->$field; 

                    if(file_exists($imgUrl))

                    {

                        @unlink($imgUrl);

                        $featuredcat->$field = '';

                        $featuredcat->update();

                        Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_category='.Tools::getValue('id_category').'&control=featuredcat');

                    }

                    else

                        $errors[] = $this->l('Image does not exist'); 

                }

                else

                    $errors[] = $this->l('Image does not exist'); 

            }

            else

               $errors[] = $this->l('Image field is invalid');

        }

        /**

         * Delete featuredcat 

         */ 

         if(Tools::isSubmit('del'))

         {

            $id_category = (int)Tools::getValue('id_category');

            if(!$this->itemExists('category','id_category',$id_category))

                $errors[] = $this->l('Item does not exist');

            elseif($this->_deleteFeaturedcat($id_category))

            {                

                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&control=main');

            }                

            else

                $errors[] = $this->l('Could not delete the item. Please try again');    

         }                  

        /**

         * Save featuredcat 

         */

        if(Tools::isSubmit('saveFeaturedcat'))

        {            

            if($id_category && $this->itemExists('category','id_category',$id_category))

            {

                $featuredcat = new Ybc_featuredcat_category_class($id_category);

            }

            else

            {

                $featuredcat = new Ybc_featuredcat_category_class();

                $featuredcat->sort_order = 1;                                   

            }

            $featuredcat->banner_position = in_array(Tools::getValue('banner_position'), array('BOTTOM','TOP')) ? Tools::strtoupper(Tools::getValue('banner_position')) : 'BOTTOM';                

            $featuredcat->enabled = trim(Tools::getValue('enabled',1)) ? 1 : 0;

            $featuredcat->products = trim(trim(Tools::getValue('inputAccessories','')),'-');

            $featuredcat->categories = Tools::getValue('categories') && is_array(Tools::getValue('categories')) ? implode('-',Tools::getValue('categories')) : '';

            $featuredcat->link = trim(Tools::getValue('link'));

            if($featuredcat->link!='' && !preg_match('/^http(.)+$/', $featuredcat->link) && $featuredcat->link!='#')

                $errors[] = $this->l('Custom link is not vaild');

            $languages = Language::getLanguages(false);

            foreach ($languages as $language)

			{			

		        $featuredcat->title[$language['id_lang']] = trim(Tools::getValue('title_'.$language['id_lang'])) != '' ? trim(Tools::getValue('title_'.$language['id_lang'])) :  trim(Tools::getValue('title_'.Configuration::get('PS_LANG_DEFAULT')));

                if($featuredcat->title[$language['id_lang']] && !Validate::isCleanHtml($featuredcat->title[$language['id_lang']]))

                    $errors[] = $this->l('Title in '.$language['name'].' is not valid');                

            }

            if(isset($featuredcat->title[(int)Configuration::get('PS_LANG_DEFAULT')]) && empty($featuredcat->title[(int)Configuration::get('PS_LANG_DEFAULT')]))

                $errors[] = $this->l('Title is required for default language');

            if($featuredcat->products && !preg_match('/^[0-9]+([\-0-9])*$/', $featuredcat->products))

                $errors[] = $this->l('Featured products is not valid'); 

            

            $featuredcat->banner1_link = trim(Tools::getValue('banner1_link'));

            if($featuredcat->banner1_link!='' && !preg_match('/^http(.)+$/', $featuredcat->banner1_link) && $featuredcat->banner1_link!='#')

                $errors[] = $this->l('Banner 1 link is not vaild');

            

            $featuredcat->banner2_link = trim(Tools::getValue('banner2_link'));

            if($featuredcat->banner2_link!='' && !preg_match('/^http(.)+$/', $featuredcat->banner2_link) && $featuredcat->banner2_link!='#')

                $errors[] = $this->l('Banner 2 link is not vaild');

            

            $featuredcat->banner3_link = trim(Tools::getValue('banner3_link'));

            if($featuredcat->banner3_link!='' && !preg_match('/^http(.)+$/', $featuredcat->banner3_link) && $featuredcat->banner3_link!='#')

                $errors[] = $this->l('Banner 3 link is not vaild');

            

            //Upload images

            $oldImage = false;

            $newImage = false;

            $oldBanner1 = false;

            $newBanner1 = false;

            $oldBanner2 = false;

            $newBanner2 = false;

            $oldBanner3 = false;

            $newBanner3 = false;

            

            if(!$errors)

            {

                $imageUpload = $this->uploadImage('image','category');		

                $banner1Upload = $this->uploadImage('banner1','category');

                $banner2Upload = $this->uploadImage('banner2','category');

                $banner3Upload = $this->uploadImage('banner3','category');    

               

                if($imageUpload['image'])

                {

                    $newImage = $imageUpload['image'];

                    if(!empty($featuredcat->image))

                        $oldImage = dirname(__FILE__).'/images/category/'.$featuredcat->image;                    

                    $featuredcat->image = $imageUpload['fileName'];                

                }                

                if($imageUpload['errors'])

                    $errors = array_merge($errors, $imageUpload['errors']);

                

                if($banner1Upload['image'])

                {

                    $newBanner1 = $banner1Upload['image'];

                    if(!empty($featuredcat->banner1))

                        $oldBanner1 = dirname(__FILE__).'/images/category/'.$featuredcat->banner1;                    

                    $featuredcat->banner1 = $banner1Upload['fileName'];                

                }                

                if($banner1Upload['errors'])

                    $errors = array_merge($errors, $banner1Upload['errors']);

                

                if($banner2Upload['image'])

                {

                    $newBanner2 = $banner2Upload['image'];

                    if(!empty($featuredcat->banner2))

                        $oldBanner2 = dirname(__FILE__).'/images/category/'.$featuredcat->banner2;                    

                    $featuredcat->banner2 = $banner2Upload['fileName'];                

                }                

                if($banner2Upload['errors'])

                    $errors = array_merge($errors, $banner2Upload['errors']);

                    

                if($banner3Upload['image'])

                {

                    $newBanner3 = $banner3Upload['image'];

                    if(!empty($featuredcat->banner3))

                        $oldBanner3 = dirname(__FILE__).'/images/category/'.$featuredcat->banner3;                    

                    $featuredcat->banner3 = $banner3Upload['fileName'];                

                }                

                if($banner3Upload['errors'])

                    $errors = array_merge($errors, $banner3Upload['errors']);

            }

            

            /**

             * Save 

             */

            if(!$errors)

            {

                if (!Tools::getValue('id_category'))

    			{

    				if (!$featuredcat->add())

                    {

                        $errors[] = $this->displayError($this->l('The item could not be added.'));

                        if($newImage && file_exists($newImage))

                            @unlink($newImage); 

                        if($newBanner1 && file_exists($newBanner1))

                            @unlink($newBanner1); 

                        if($newBanner2 && file_exists($newBanner2))

                            @unlink($newBanner2); 

                        if($newBanner3 && file_exists($newBanner3))

                            @unlink($newBanner3);                                              

                    }                	                    

    			}				

    			elseif (!$featuredcat->update())

                {

                    if($newImage && file_exists($newImage))

                        @unlink($newImage);

                    if($newBanner1 && file_exists($newBanner1))

                        @unlink($newBanner1); 

                    if($newBanner2 && file_exists($newBanner2))

                        @unlink($newBanner2); 

                    if($newBanner3 && file_exists($newBanner3))

                        @unlink($newBanner3);                     

                    $errors[] = $this->displayError($this->l('The item could not be updated.'));

                }

                else

                {

                    if($oldImage && file_exists($oldImage))

                        @unlink($oldImage);  

                    if($oldBanner1 && file_exists($oldBanner1))

                        @unlink($oldBanner1);  

                    if($oldBanner2 && file_exists($oldBanner2))

                        @unlink($oldBanner2);  

                    if($oldBanner3 && file_exists($oldBanner3))

                        @unlink($oldBanner3);                    

                }    					                

            }

         }

         if (count($errors))

         {

            if($newImage && file_exists($newImage))

                @unlink($newImage);  

            if($newBanner1 && file_exists($newBanner1))

                @unlink($newBanner1);  

            if($newBanner2 && file_exists($newBanner2))

                @unlink($newBanner2);  

            if($newBanner3 && file_exists($newBanner3))

                @unlink($newBanner3);            

            $this->errorMessage = $this->displayError(implode('<br />', $errors));  

         }

         elseif (Tools::isSubmit('saveFeaturedcat') && Tools::isSubmit('id_category'))

			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_category='.Tools::getValue('id_category').'&control=featuredcat');

		 elseif (Tools::isSubmit('saveFeaturedcat'))

         {

            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=3&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'&id_category='.$this->getMaxId('category','id_category').'&control=featuredcat');

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

        if(isset($_FILES[$field]['tmp_name']) && isset($_FILES[$field]['name']) && $_FILES[$field]['name'])

        {   $fileName = str_replace(' ','_',trim(Tools::strtolower($_FILES[$field]['name'])));

            if(file_exists(dirname(__FILE__).'/images/'.$directory.'/'.$fileName))

            {

                $fileName = sha1(microtime()).'_'.$fileName;

            }            

            if(file_exists(dirname(__FILE__).'/images/'.$directory.'/'.$fileName))

            {

                $errors[] = '"'.$field.'" - '.$this->l('Image file name already exists. Try to rename the file name then reupload it');

            }

            else

            {

                $type = Tools::strtolower(Tools::substr(strrchr($_FILES[$field]['name'], '.'), 1));

    			$imagesize = @getimagesize($_FILES[$field]['tmp_name']);

    			if (isset($_FILES[$field]) &&				

    				!empty($_FILES[$field]['tmp_name']) &&

    				!empty($imagesize) &&

    				in_array($type, array('jpg', 'gif', 'jpeg', 'png'))

    			)

    			{

    				$temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');    				

    				if ($error = ImageManager::validateUpload($_FILES[$field]))

    					$errors[] = $error;

    				elseif (!$temp_name || !move_uploaded_file($_FILES[$field]['tmp_name'], $temp_name))

    					$errors[] = $this->l('Can not upload the file');

    				elseif(!ImageManager::resize($temp_name, dirname(__FILE__).'/images/'.$directory.'/'.$fileName, null, null, $type))

    					$errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));

    				$result['image'] = dirname(__FILE__).'/images/'.$directory.'/'.$fileName;

                    $result['fileName'] = $fileName;                      

                    if(isset($temp_name))

    					@unlink($temp_name);		

    			}

                else

                    $errors[] = '"'.$field.'" '.$this->l(' is not valid');

            }

        }

        if($errors)

            $result['errors'] = $errors;

        return $result;	

    }

    public function itemExists($tbl, $primaryKey, $id)

	{

		$req = 'SELECT `'.$primaryKey.'`

				FROM `'._DB_PREFIX_.'ybc_featuredcat_'.$tbl.'` tbl

				WHERE tbl.`'.$primaryKey.'` = '.(int)$id;

		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);        

		return ($row);

	}

    public function getMaxId($tbl, $primaryKey)

    {

        $req = 'SELECT max(`'.$primaryKey.'`) as maxid

				FROM `'._DB_PREFIX_.'ybc_featuredcat_'.$tbl.'` tbl';				

		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);

        return isset($row['maxid']) ? (int)$row['maxid'] : 0;

    }

    public function getFieldsValues($formFields, $primaryKey, $objClass, $saveBtnName)

	{

		$fields = array();

        $id_lang_default = Configuration::get('PS_LANG_DEFAULT');

		if (Tools::isSubmit($primaryKey))

		{

			$obj = new $objClass((int)Tools::getValue($primaryKey));

			$fields[$primaryKey] = (int)Tools::getValue($primaryKey, $obj->$primaryKey);            

		}

		else

        {

            $obj = new $objClass();

        }        

        foreach($formFields as $field)

        {

            if(!isset($field['primary_key']) && !isset($field['multi_lang']) && !isset($field['connection']))

                $fields[$field['name']] = trim(Tools::getValue($field['name'], $obj->$field['name']));            

        }        

        $languages = Language::getLanguages(false);        

        /**

         *  Default

         */        

        if(!Tools::isSubmit($saveBtnName) && !Tools::isSubmit($primaryKey))

        {

            foreach($formFields as $field)

            {

                if(isset($field['default']) && !isset($field['multi_lang']))

                {

                    if(isset($field['default_submit']))

                        $fields[$field['name']] = (int)Tools::getValue($field['name']) ? (int)Tools::getValue($field['name']) : $field['default'];

                    else

                        $fields[$field['name']] = $field['default'];

                }

            }

        }        

        /**

         * Multiple language 

         */

		foreach ($languages as $lang)

		{

		    foreach($formFields as $field)

            {

                if(!Tools::isSubmit($saveBtnName) && !Tools::isSubmit($primaryKey))

                {

                    if(isset($field['multi_lang']))

                    {

                        if(isset($field['default']))

                            $fields[$field['name']][$lang['id_lang']] = $field['default'];

                        else

                            $fields[$field['name']][$lang['id_lang']] = '';

                    }

                }

                elseif(Tools::isSubmit($saveBtnName))

                {

                    if(isset($field['multi_lang']))

                        $fields[$field['name']][$lang['id_lang']] = Tools::getValue($field['name'].'_'.(int)$lang['id_lang']);  

                    

                }

                else{                    

                    if(isset($field['multi_lang']))

                    {

                        $field_langs = $obj->$field['name'];                        

                        $fields[$field['name']][$lang['id_lang']] = $field_langs[$lang['id_lang']];

                    }                        

                }                

            }

		}

        $fields['control'] = trim(Tools::getValue('control')) ? trim(Tools::getValue('control')) : '';        

        return $fields;

	}

    private function _deleteFeaturedcat($id_category)

    {

        if($this->itemExists('category','id_category',$id_category))

        {

            $featuredcat = new Ybc_featuredcat_category_class($id_category);

            if($featuredcat->image && file_exists(dirname(__FILE__).'/images/category/'.$featuredcat->image))

            {

                @unlink(dirname(__FILE__).'/images/category/'.$featuredcat->image);

            } 

            if($featuredcat->banner1 && file_exists(dirname(__FILE__).'/images/category/'.$featuredcat->banner1))

            {

                @unlink(dirname(__FILE__).'/images/category/'.$featuredcat->banner1);

            } 

            if($featuredcat->banner2 && file_exists(dirname(__FILE__).'/images/category/'.$featuredcat->banner2))

            {

                @unlink(dirname(__FILE__).'/images/category/'.$featuredcat->banner2);

            } 

            if($featuredcat->banner3 && file_exists(dirname(__FILE__).'/images/category/'.$featuredcat->banner3))

            {

                @unlink(dirname(__FILE__).'/images/category/'.$featuredcat->banner3);

            }            

            return $featuredcat->delete();

        }

        return false;        

    }

    public function changeStatus($tbl, $field, $id , $status)

    {

        $req = "UPDATE "._DB_PREFIX_."ybc_featuredcat_$tbl SET `enabled`=$status WHERE id_$tbl=$id";

        return Db::getInstance()->execute($req);

    }

    public function getSelectedCategories()

    {

        if(Tools::isSubmit('categories') && is_array(Tools::getValue('categories')))

            return Tools::getValue('categories');

        $id_category = (int)Tools::getValue('id_category');

        if($id_category && $this->itemExists('category','id_category',$id_category))

        {            

            $category = new Ybc_featuredcat_category_class($id_category);

            if($category->categories)

                return explode('-', $category->categories);

        }

        return array();

    }

    public function getSelectedProducts()

    {

        $products = array();

        if(Tools::isSubmit('inputAccessories') && trim(trim(Tools::getValue('inputAccessories')),','))

        {

            $products = explode('-', trim(trim(Tools::getValue('inputAccessories')),'-'));

        }

        else

        {

            $id_category = (int)Tools::getValue('id_category');

            if($this->itemExists('category','id_category',$id_category))

            {

                $category = new Ybc_featuredcat_category_class($id_category);

                if($category->products)

                    $products = explode('-', $category->products);

            }            

        }

        

        if($products)

        {

            foreach($products as $key => &$product)

            {

                $product = (int)$product;

            }

            $sql = 'SELECT p.`id_product`, pl.`name`,p.`reference`

				FROM `'._DB_PREFIX_.'product` p

                '.Shop::addSqlAssociation('product', 'p').'

				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` '.Shop::addSqlRestrictionOnLang('pl').')

				WHERE pl.`id_lang` = '.(int)$this->context->language->id.' AND p.`id_product` IN ('.implode(',',$products).')';

            $product_list = Db::getInstance()->executeS($sql);            

            return $product_list;          

        }        

        return false;

    }

    public function getFeaturedCats($enabled = false)

    {

        $sql = "SELECT c.*, cl.title 

                FROM  "._DB_PREFIX_."ybc_featuredcat_category c              

                LEFT JOIN "._DB_PREFIX_."ybc_featuredcat_category_lang cl on c.id_category = cl.id_category AND cl.id_lang = ".(int)$this->context->language->id."

                WHERE 1 ".($enabled ? " AND c.enabled = 1 " : "")."

                ORDER BY c.sort_order ASC, cl.title ASC"; 

        $categories = Db::getInstance()->executeS($sql);

        if($categories)

        {

            foreach($categories as &$cat)

            {

                if($cat['categories'])

                    $cat['categories'] = $this->getCagetoriesList($cat['categories']);

                if($cat['products'])

                    $cat['products'] = $this->getProductsList($cat['products']);                

                if($cat['image'])

                    $cat['image'] = $this->_path.'images/category/'.$cat['image'];

                if($cat['banner1'])

                    $cat['banner1'] = $this->_path.'images/category/'.$cat['banner1'];

                if($cat['banner2'])

                    $cat['banner2'] = $this->_path.'images/category/'.$cat['banner2'];

                if($cat['banner3'])

                    $cat['banner3'] = $this->_path.'images/category/'.$cat['banner3'];

                if(isset($this->context->controller->controller_type) && $this->context->controller->controller_type =='admin')

                {

                    $cat['edit_link'] = $this->baseAdminPath.'&control=featuredcat&id_category='.$cat['id_category'];

                    $cat['delete_link'] = $this->baseAdminPath.'&control=featuredcat&id_category='.$cat['id_category'].'&del=yes';

                    $cat['enabled_link'] = $this->baseAdminPath.'&control=featuredcat&id_category='.$cat['id_category'].'&change_enabled='.($cat['enabled'] ? '0' : '1');

                }

                else

                {

                    $cat['edit_link'] = '';

                    $cat['delete_link'] = '';

                    $cat['enabled_link'] = '';

                }

                $cat['bannerClass'] = 'banner-'.$this->_countBanner($cat);

            }

        }

        return $categories;

    }

    public function getCagetoriesList($ids_string)

    {

        $ids = $this->getIdsArgsFromIdsStr($ids_string);

        $links = array();

        if($ids)

        {

            $sql = "SELECT c.id_category

                    FROM "._DB_PREFIX_."category c 

                    LEFT JOIN "._DB_PREFIX_."category_lang cl ON c.id_category = cl.id_category AND cl.id_lang = ".(int)$this->context->language->id." 

                    WHERE c.id_category IN (".implode(',', $ids).")

                    ORDER BY cl.name ASC";

            $cats = Db::getInstance()->executeS($sql);

            if($cats)

            {

                foreach($cats as $cat)

                {

                    if((int)$cat['id_category'] > 2)

                    {

                        $cat = new Category((int)$cat['id_category'], (int)$this->context->language->id);  

                        $links[] = array(

                            'name' => $cat->name,

                            'url' => $cat->getLink()

                        );   

                    }                    

                }

            }             

        }

        return $links;     

    }

    public function getIdsArgsFromIdsStr($ids_string)

    {

        $ids = array();

        if($ids_string)

        {

            $elements = explode('-', $ids_string);

            if($elements)

            {

                foreach($elements as $id)

                    if(!in_array((int)$id, $ids))

                        $ids[] = $id;

            }

        }

        return $ids;

    }

    public function getProductsList($ids_string, $id_lang = null, $order_by = null, $order_way = null, $active = true, $random = false, $random_number_products = 1, Context $context = null)

	{

	   if(is_null($id_lang))

            $id_lang = (int)$this->context->language->id;

	    $ids = $this->getIdsArgsFromIdsStr($ids_string);

        if(!$ids)

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

		elseif ($order_by == 'manufacturer' || $order_by == 'manufacturer_name')

		{

			$order_by_prefix = 'm';

			$order_by = 'name';

		}

		elseif ($order_by == 'position')

			$order_by_prefix = 'cp';



		if ($order_by == 'price')

			$order_by = 'orderprice';



		if (!Validate::isBool($active) || !Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way))

			die (Tools::displayError());



		$id_supplier = (int)Tools::getValue('id_supplier');





		$sql = 'SELECT p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity'.(Combination::isFeatureActive() ? ', MAX(product_attribute_shop.id_product_attribute) id_product_attribute, MAX(product_attribute_shop.minimal_quantity) AS product_attribute_minimal_quantity' : '').', pl.`description`, pl.`description_short`, pl.`available_now`,

					pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, MAX(image_shop.`id_image`) id_image,

					MAX(il.`legend`) as legend, m.`name` AS manufacturer_name, cl.`name` AS category_default,

					DATEDIFF(product_shop.`date_add`, DATE_SUB(NOW(),

					INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).'

						DAY)) > 0 AS new, product_shop.price AS orderprice

				FROM `'._DB_PREFIX_.'category_product` cp

				LEFT JOIN `'._DB_PREFIX_.'product` p

					ON p.`id_product` = cp.`id_product`

				'.Shop::addSqlAssociation('product', 'p').

				(Combination::isFeatureActive() ? 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa

				ON (p.`id_product` = pa.`id_product`)

				'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').'

				'.Product::sqlStock('p', 'product_attribute_shop', false, $context->shop) :  Product::sqlStock('p', 'product', false, Context::getContext()->shop)).'

				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl

					ON (product_shop.`id_category_default` = cl.`id_category`

					AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').')

				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl

					ON (p.`id_product` = pl.`id_product`

					AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').')

				LEFT JOIN `'._DB_PREFIX_.'image` i

					ON (i.`id_product` = p.`id_product`)'.

				Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'

				LEFT JOIN `'._DB_PREFIX_.'image_lang` il

					ON (image_shop.`id_image` = il.`id_image`

					AND il.`id_lang` = '.(int)$id_lang.')

				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m

					ON m.`id_manufacturer` = p.`id_manufacturer`

				WHERE product_shop.`id_shop` = '.(int)$context->shop->id.'

					AND cp.`id_product` IN ('.implode(',', $ids).') '

					.($active ? ' AND product_shop.`active` = 1' : '')

					.($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '')

					.($id_supplier ? ' AND p.id_supplier = '.(int)$id_supplier : '')

					.' GROUP BY product_shop.id_product';



		if ($random === true)

			$sql .= ' ORDER BY RAND() LIMIT '.(int)$random_number_products;

		else

			$sql .= ' ORDER BY '.(!empty($order_by_prefix) ? $order_by_prefix.'.' : '').'`'.bqSQL($order_by).'` '.pSQL($order_way);



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

        $this->context->controller->addCSS((__PS_BASE_URI__).'modules/'.$this->name.'/css/admin.css', 'all');        

    }

    public function hookDisplayHeader()

    { 

        $this->context->controller->addCSS((__PS_BASE_URI__).'modules/'.$this->name.'/css/featuredcat.css', 'all');        

    }

    public function hookDisplayHome()

    {

        $cats = $this->getFeaturedCats(true);

        $this->smarty->assign(

            array(

                'featuredCats' => $cats,

                'link' => $this->context->link,

                'product_list_tpl' => dirname(__FILE__).'/views/templates/hook/product_list.tpl'              

            )

        );

        return $this->display(__FILE__, 'featuredcats.tpl');

    }

    private function _countBanner($cat)

    {

        $ik = 0;

        if(isset($cat['banner1']) && $cat['banner1'])

            $ik++;

        if(isset($cat['banner2']) && $cat['banner2'])

            $ik++;

        if(isset($cat['banner3']) && $cat['banner3'])

            $ik++;

        return $ik;

    }

}