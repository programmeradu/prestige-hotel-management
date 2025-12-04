<?php
/**
 * Copyright YBC-Themes
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/

if (!defined('_PS_VERSION_'))
	exit;
class Ybc_featuredcat_category_class extends ObjectModel
{
    public $id_category;
    public $title;
    public $enabled;    
	public $image;
    public $banner1;
    public $banner2;
    public $banner3;
    public $banner1_link;
    public $banner2_link;
    public $banner3_link;
    public $sort_order;   
    public $banner_position;
    public $products;
    public $categories;
    public $link;
    public static $definition = array(
		'table' => 'ybc_featuredcat_category',
		'primary' => 'id_category',
		'multilang' => true,
		'fields' => array(
			'enabled' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'sort_order' => array('type' => self::TYPE_INT),
            'image' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 1000),
            'link' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 2000),
            'banner1_link' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 2000),
            'banner2_link' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 2000),
            'banner3_link' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 2000),
            'banner1' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 1000),
            'banner2' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 1000),
            'banner3' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 1000),
            'products' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 1000),
            'categories' =>	array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 1000),
            'banner_position' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 500),
            // Lang fields
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 1000),
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