<?php

/**

 * Copyright YourBestCode.com

 * Email: support@yourbestcode.com

 * First created: 21/12/2015

 * Last updated: NOT YET

*/



if (!defined('_PS_VERSION_'))

	exit;

    

Class Ybc_HtmlProduct extends Module

{

    public function __construct()

	{

		$this->name = 'ybc_htmlproduct';

		$this->tab = 'front_office_features';

		$this->version = '1.0.1';

		$this->author = 'YBC-Themes';

		$this->need_instance = 0;

		$this->secure_key = Tools::encrypt($this->name);

		$this->bootstrap = true;



		parent::__construct();



		$this->displayName = $this->l('YBC product HTML block');

		$this->description = $this->l('Add a HTML block to product page');

		$this->ps_versions_compliancy = array('min' => '1.6.0.0', 'max' => _PS_VERSION_);

        

    }

    /**

	 * @see Module::install()

	 */

	public function install()

	{

        return parent::install() 

        && $this->registerHook('displayHeader')

        && $this->registerHook('displayYbcProductHtml');

    }    

    /**

	 * @see Module::uninstall()

	 */

	public function uninstall()

	{

	    $this->_resetData();

        return parent::uninstall();

    }

    public function getContent()

    {

        $this->processPost();

        $this->_html .= $this->renderConfigForm();

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
    private function _resetData()

    {

        $default = $this->getHTML('default');

        $languages = Language::getLanguages(false);

        if($languages)

        {

            foreach($languages as $lang)

            {

                if($default)

                    $this->saveHTML($lang['iso_code'], $default);

                else

                    $this->saveHTML($lang['iso_code'], '');

            }

        }

    }

    public function processPost()

    {

        $languages = Language::getLanguages(false);

        $defaultLang = $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

        $errors = array();

        if(Tools::isSubmit('saveHTML'))

        {

            if($languages)

            {

                foreach($languages as $lang)

                {

                    $html = trim(Tools::getValue('YBC_PRODUCT_HTML_BLOCK_'.$lang['id_lang'])) ? trim(Tools::getValue('YBC_PRODUCT_HTML_BLOCK_'.$lang['id_lang'])) : trim(Tools::getValue('YBC_PRODUCT_HTML_BLOCK_'.Configuration::get('PS_LANG_DEFAULT')));

                    if(!$this->saveHTML($lang['iso_code'], $html))

                        $errors[] = $this->l('Can not save HTML with language '.$lang['name']);

                }

            }            

            if($errors)

                $this->_html .= $this->displayError(implode('<br />', $errors)); 

            else

                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);

        

        }

    }

    public function renderConfigForm()

    {

        $fields_form = array(

			'form' => array(

				'legend' => array(

					'title' => $this->l('Product HTML block'),

					'icon' => 'icon-AdminAdmin'

				),

				'input' => array(

                    array(

						'type' => 'textarea',

						'label' => $this->l('Block content'),

						'name' => 'YBC_PRODUCT_HTML_BLOCK' ,

                        'lang' => true,  

                        'autoload_rte' => true                          

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

		$helper->submit_action = 'saveHTML';

		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;

		$helper->token = Tools::getAdminTokenLite('AdminModules');

		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

		$languages = Language::getLanguages(false);

        /**

         * Get field values 

         */

        

        $fields = array();

        if(Tools::isSubmit('saveHTML'))

        {

            foreach($languages as $lang)

            {

                $fields['YBC_PRODUCT_HTML_BLOCK'][$lang['id_lang']] = Tools::getValue('YBC_PRODUCT_HTML_BLOCK_'.$lang['id_lang'],'');   

            }                        

        }

        else

        {

            foreach($languages as $lang)

            {

                $fields['YBC_PRODUCT_HTML_BLOCK'][$lang['id_lang']] = $this->getHTML($lang['iso_code']) ? $this->getHTML($lang['iso_code']) : $this->getHTML($language->iso_code);   

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

			'id_language' => $this->context->language->id

        );

        $helper->override_folder = '/';

        $languages = Language::getLanguages(false);

        $this->_html .= $helper->generateForm(array($fields_form));			

    }

    

    /**

     * functions 

     */

     public function getHTML($iso)

     {

        $fileData = dirname(__FILE__).'/data/'.$iso.'.cache';

        if(file_exists($fileData) && is_readable($fileData))

            return file_get_contents($fileData);

        return '';

     }

     public function saveHTML($iso, $data)

     {

        $fileData = dirname(__FILE__).'/data/'.$iso.'.cache';

        return @file_put_contents($fileData, $data);

     }

     

     /**

      * Hooks 

      */

    public function hookDisplayRightColumnProduct()

	{

	   $language = new Language((int)($this->context->language->id ? $this->context->language->id : Configuration::get('PS_LANG_DEFAULT')));

	   $html = $this->getHTML($language->iso_code);

       if(!$html)

       {

            $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

            $html = $this->getHTML($language->iso_code);

       }

       if($html)

            return '<div class="pb-right-column col-xs-12 col-sm-4 col-md-2"><div class="ybc-product-html">'.$html.'</div></div>';

        

	   return;

    }

    public function hookDisplayYbcProductHtml()

    {

        return $this->hookDisplayRightColumnProduct();

    }

    public function hookDisplayLeftColumnProduct()

	{

		return $this->hookDisplayRightColumnProduct();

	}

    public function hookDisplayHeader()

    {

        $this->context->controller->addCSS($this->_path.'css/ybchtmlproduct.css','all');

    }

}