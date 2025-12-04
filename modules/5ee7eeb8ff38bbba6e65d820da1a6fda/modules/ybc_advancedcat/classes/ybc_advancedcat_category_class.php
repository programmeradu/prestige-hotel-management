<?php
/**
 * Copyright YBC-Themes
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/

if (!defined('_PS_VERSION_'))
	exit;
class Ybc_advancedcat_category_class extends ObjectModel
{
    public $id_category;
    public $title;
    public $description;
    public $enabled;    
	public $image;
    public $banner;
    public $icon;
    public $show_title;
    public $show_description;
    public $show_banner;
    public $include_subcategories;
    public $sort_order;   
    public $banner_position;
    public $submenu_position;
    public $products;
    public $category;
    public static $definition = array(
		'table' => 'ybc_advancedcat_category',
		'primary' => 'id_category',
		'multilang' => true,
		'fields' => array(
			'enabled' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'show_title' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'show_description' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'show_banner' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'include_subcategories' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'sort_order' => array('type' => self::TYPE_INT),
            'image' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 1000),
            'icon' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 200),
            'banner' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 1000),
            'products' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 1000),
            'category' =>	 array('type' => self::TYPE_INT),
            'banner_position' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 500),
            'submenu_position' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 500),
            // Lang fields
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 1000),
            'description' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 900000)
        )
	);
    public	function __construct($id_item = null, $id_lang = null, $id_shop = null, Context $context = null)
	{
		parent::__construct($id_item, $id_lang, $id_shop);
        $languages = Language::getLanguages(false);
        $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
        foreach($languages as $lang)
        {
            foreach(self::$definition['fields'] as $field => $params)
            {   
                $temp = $this->$field; 
                if(isset($params['lang']) && $params['lang'] && !isset($temp[$lang['id_lang']]))
                {                      
                    $temp[$lang['id_lang']] = '';                        
                }
                $this->$field = $temp;
            }
        }
	}
}