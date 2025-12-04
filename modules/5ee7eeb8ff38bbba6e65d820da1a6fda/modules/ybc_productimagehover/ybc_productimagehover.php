<?php
/**
 * Copyright YBC-Themes
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/
if (!defined('_PS_VERSION_'))
	exit;
/**
 * Includes 
 */   
class Ybc_productimagehover extends Module
{    
    private $_hooks = array('productImageHover','displayHeader');
    public function __construct()
	{
		$this->name = 'ybc_productimagehover';
		$this->tab = 'front_office_features';
		$this->version = '1.0.1';
		$this->author = 'YBC-Themes';
		$this->need_instance = 0;
		$this->secure_key = Tools::encrypt($this->name);
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('YBC product image hover');
		$this->description = $this->l('Display second image when hover over product image');
		$this->ps_versions_compliancy = array('min' => '1.6.0.0', 'max' => _PS_VERSION_);
        
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
        return  $res;
    }
    /**
	 * @see Module::uninstall()
	 */
	public function uninstall()
	{
        return parent::uninstall();
    }
    public function hookDisplayHeader()
    { 
        $this->context->controller->addCSS($this->_path.'css/productimagehover.css', 'all');        
    }
    public function hookProductImageHover($params)
    { 
        if(isset($params['id_product']))
        {
            $product_id=$params['id_product'];
            $sql= "SELECT id_image 
                   FROM  `"._DB_PREFIX_."image` 
                   WHERE  `id_product` =  $product_id AND (cover = 0 OR cover is null) ORDER BY  `position` ASC";
                   
            $image = Db::getInstance()->getRow($sql);
            
            if(!$image)
            {
                $sql= "SELECT id_image 
                       FROM  `"._DB_PREFIX_."image` 
                       WHERE  `id_product` =  $product_id AND cover =  1 ORDER BY  `position` ASC";
                $image = Db::getInstance()->getRow($sql);               
            }
            if($image){
                $product = new Product($product_id,false,$this->context->language->id,$this->context->shop->id);
                
                $this->smarty->assign(array(
                    'product_name' => $product->name,
                    'img_url' => $this->context->link->getImageLink($product->link_rewrite, (int)$image['id_image'], 'home_default')
                ));               
            }
            else
                return;        
        }
        return $this->display(__FILE__, 'image.tpl');
    }
}