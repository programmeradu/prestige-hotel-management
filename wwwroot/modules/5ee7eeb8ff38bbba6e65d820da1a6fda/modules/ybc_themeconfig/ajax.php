<?php
/**
 * Copyright YourBestCode.com
 * Email: support@yourbestcode.com
 * First created: 21/12/2015
 * Last updated: NOT YET
*/
include_once('../../config/config.inc.php');
include_once('../../init.php');
include_once('ybc_themeconfig.php');
$newConfigVal = trim(Tools::getValue('newConfigVal'));
$configName = trim(Tools::getValue('configName'));
$tc = new Ybc_themeconfig();
$json = array();
/**
 * Reset 
 */
if(Tools::getValue('tcreset'))
{
    $tc->resetConfigDemo();
    $json['success'] = true;
    die(Tools::jsonEncode($json));
}

$config = $tc->getThemeConfigDemo();
if(is_array($config) && isset($config[$configName]))
    $oldConfigVal = $config[$configName];
else
    $oldConfigVal = '';

switch($configName)
{
    case 'YBC_TC_LAYOUT':
        if(!$tc->validateOption($tc->layouts, $newConfigVal))
            $json['error'] = $tc->l('Layout is invalid');
        else
        {
            $json['oldClass'] = 'ybc-layout-'.Tools::strtolower($oldConfigVal);
            $json['newClass'] = 'ybc-layout-'.Tools::strtolower($newConfigVal);
            $json['success'] =  true;
            $json['reload'] = true;
        }
        break;
    case 'YBC_TC_SKIN':
        if(!$tc->validateOption($tc->skins, $newConfigVal))
            $json['error'] = $tc->l('Skin is invalid');
        else
        {
            $json['oldClass'] = 'ybc-skin-'.Tools::strtolower($oldConfigVal);
            $json['newClass'] = 'ybc-skin-'.Tools::strtolower($newConfigVal);
            $json['success'] =  true;
        }
        break;
    case 'YBC_TC_FONTSIZE':
        if(!$tc->validateOption($tc->fontSizes, $newConfigVal))
            $json['error'] = $tc->l('Font size is invalid');
        else
        {
            $json['oldClass'] = 'ybc-fontsize-'.Tools::strtolower($oldConfigVal);
            $json['newClass'] = 'ybc-fontsize-'.Tools::strtolower($newConfigVal);
            $json['success'] =  true;
        }
        break;
    case 'YBC_TC_LAYOUT':
        if(!$tc->validateOption($tc->layouts, $newConfigVal))
            $json['error'] = $tc->l('Layout is invalid');
        else
        {
            $json['oldClass'] = 'ybc-layout-'.Tools::strtolower($oldConfigVal);
            $json['newClass'] = 'ybc-layout-'.Tools::strtolower($newConfigVal);
            $json['success'] =  true;
        }
        break;
    case 'YBC_TC_GENERAL_FONT':
        if(!$tc->validateOption($tc->fonts, $newConfigVal))
            $json['error'] = $tc->l('General font is invalid');
        else
        {
            $json['oldClass'] = 'ybc-gf-'.Tools::strtolower($oldConfigVal);
            $json['newClass'] = 'ybc-gf-'.Tools::strtolower($newConfigVal);
            $json['success'] =  true;
        }
        break;
    case 'YBC_TC_HEADING_FONT':
        if(!$tc->validateOption($tc->fonts, $newConfigVal))
            $json['error'] = $tc->l('Heading font is invalid');
        else
        {
            $json['oldClass'] = 'ybc-hf-'.Tools::strtolower($oldConfigVal);
            $json['newClass'] = 'ybc-hf-'.Tools::strtolower($newConfigVal);
            $json['success'] =  true;
        }
        break;
    case 'YBC_TC_CUSTOM_FONT':
        if(!$tc->validateOption($tc->fonts, $newConfigVal))
            $json['error'] = $tc->l('Custom font is invalid');
        else
        {
            $json['oldClass'] = 'ybc-cf-'.Tools::strtolower($oldConfigVal);
            $json['newClass'] = 'ybc-cf-'.Tools::strtolower($newConfigVal);
            $json['success'] =  true;
        }
        break;
    case 'YBC_TC_BG_IMG':
        if(!in_array($newConfigVal,$tc->bgs))
            $json['error'] = $tc->l('Background is invalid');
        elseif(Tools::strtolower($tc->getThemeConfig('YBC_TC_LAYOUT')) != 'boxed')
            $json['error'] = $tc->l('Background image is only available for BOXED layout');
        else
        {
            $json['oldClass'] = 'ybc-bg-img-'.Tools::strtolower($oldConfigVal);
            $json['newClass'] = 'ybc-bg-img-'.Tools::strtolower($newConfigVal);
            $json['success'] =  true;
        }
        break;
    default:
        $json['error'] = $tc->l('Configuration is invalid');
        break;
}
if(isset($json['success']) && $json['success'])
    $tc->updateThemeConfigDemo($configName, $newConfigVal);
die(Tools::jsonEncode($json));