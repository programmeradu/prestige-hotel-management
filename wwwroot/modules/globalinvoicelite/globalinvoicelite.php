<?php
/**
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2015 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class globalinvoicelite extends Module
{
    
    public $imp;
    public $ship;
    public $wrap;
    
    public function __construct()
    {
        $this->name          = 'globalinvoicelite';
        $this->tab           = 'billing_invoicing';
        $this->version       = '1.0.1';
        $this->author        = 'PrestaMarketing™';
        $this->need_instance = 0;
        
        parent::__construct();
        
        $this->bootstrap   = true;
        $this->displayName = $this->l('Invoice Customization for PrestaShop');
        $this->description = $this->l('Customize your invoices with extra data and your own colors. Developed by PrestaMarketing™');
        
    }
    
    public function install()
    {
        $this->createVariables();
        
        return (parent::install() && $this->registerHook('backOfficeHeader'));
    }
    
    public function uninstall()
    {
        $this->destroyVariables();
        $this->deleteDirectory(_PS_THEME_DIR_.'pdf');
        return (parent::uninstall());
    }
    
    public function hookBackOfficeHeader($params)
    {
        $this->context->controller->addCSS(($this->_path) . 'views/css/' . $this->name . '.css', 'all');
    }
    
    public function getContent()
    {        
        $output = '';
        if(Tools::isSubmit('activationCode')) {
            if(Configuration::get('PMKT_licence_GLBINVLT') == '') {
                require_once(_PS_MODULE_DIR_.'globalinvoicelite/inc/nusoap/lib/nusoap.php');
                $wsdl='http://prestamarketing.com/modules/PMKT_API/PMKT_API/active.php?wsdl';
                $client = new nusoap_client($wsdl,'wsdl');
                $param = array(
                    'key' => Tools::getValue('activationCode'),
                    'host' => $_SERVER['SERVER_NAME'], 
                    'ip' => $_SERVER['REMOTE_ADDR']
                );
                $response = $client->call('activeKey',$param);
                if ($response != '') {
                    Configuration::updateValue('PMKT_licence_GLBINVLT',$response);
                    Configuration::updateValue('PMKT_key_GLBINVLT',Tools::getValue('activationCode'));
                    $pdfDir = _PS_THEME_DIR_ . 'pdf';
                    if (!is_dir($pdfDir)) {
                        mkdir($pdfDir, 0777);
                    }
                    
                    $this->escribirArchivos('/modules/' . $this->name . 
                        '/views/templates/front/', _PS_THEME_DIR_ . 'pdf/', 'tpl');
                } else {
                    $output .= $this->displayError($this->l('Incorrect license number 
                        if the problem persists please 
                        contact soporte@prestamarketing.com'));
                }
            }
        }

        Configuration::updateValue('PMKT_licence_GLBINVLT', 1);
        
        if(Configuration::get('PMKT_licence_GLBINVLT') == '') {
            $output .= $this->formActivacion();
            return $output;
        }            

        if(strtoupper($this->context->language->iso_code) == 'ES') {
            $iso_code = '-ES';
        } else {
            $iso_code = '';
        }            
        $output = '';
        $output .= '<link rel="stylesheet" href="' . _PS_ROOT_DIR_ . '/modules/'.
            $this->name.'/css/globalinvoicelite.css" type="text/css">';
        $output = '<script type="text/javascript">          

            function savePanelHeader()
            {
                var output = "";
                $("#ul-panel-short-header").children("li").each(function () { 
                    output = output + $(this).attr("id") + ",";
                });
                $("#panel_header").val(output);
                $("#form_panel_header").submit();
            }
            </script>';
        
        if (((bool) Tools::isSubmit('submit_facturacion_total_factura')) == true) {
            $output .= $this->displayConfirmation($this->l('Invoice information saved!!'));
            $output .= '<script type="text/javascript">var tabpress = 1;</script>';
        } elseif (Tools::isSubmit('panel_header')) {
            $output .= $this->displayConfirmation($this->l('Panel Header saved!!'));
             $output .= '<script type="text/javascript">var tabpress = 2;</script>';
        }

        $output .= '<div id="content-fact-total" class="panel">';        
        $output .= '<ul class="nav nav-tabs" role="tablist">';
        $output .= '<li role="presentation" class="tab-page active"><a href="#panel-fields" aria-controls="panel-fields" class="panel-fields" role="tab" data-toggle="tab">'.
            $this->l('Invoice Info') . '</a></li>'; 
        $output .= '<li role="presentation" class="tab-page"><a href="#panel-header" aria-controls="panel-header" class="panel-header2" role="tab" data-toggle="tab">'.
            $this->l('Invoice Header') . '</a></li>';
        $output .= '</ul>';        
        $output .= '<div class="tab-content panel row">';
        $output .= '<div role="tabpanel" id="panel-informe" class="tab-pane">';
		$output .= '<div class="col-md-8 form-content">';
        if (Tools::getIsset('FSPA_nombre')) {
            
            $langs = language::getLanguages();
            
            $text_in_footer = array();
            foreach ($langs as $kl => $vl) {
                $text_in_footer[$vl['id_lang']] = Tools::getValue('FSPA_texto_en_footer_'.$vl['id_lang']);
            }
           
            Configuration::updateValue('FSPA_razonSocial', Tools::getValue('FSPA_razonSocial'));
            Configuration::updateValue('FSPA_nombre', Tools::getValue('FSPA_nombre'));
            Configuration::updateValue('FSPA_cif', Tools::getValue('FSPA_cif'));
            Configuration::updateValue('FSPA_domicilio', Tools::getValue('FSPA_domicilio'));
            Configuration::updateValue('FSPA_localidad', Tools::getValue('FSPA_localidad'));
            Configuration::updateValue('FSPA_Provincia', Tools::getValue('FSPA_Provincia'));
            Configuration::updateValue('FSPA_Pais', Tools::getValue('FSPA_Pais'));
            Configuration::updateValue('FSPA_telefono', Tools::getValue('FSPA_telefono'));
            Configuration::updateValue('FSPA_fax', Tools::getValue('FSPA_fax'));
            Configuration::updateValue('FSPA_mail', Tools::getValue('FSPA_mail'));
            Configuration::updateValue('FSPA_otro', Tools::getValue('FSPA_otro'));
            Configuration::updateValue('FSPA_color', Tools::getValue('FSPA_color'));
            Configuration::UpdateValue('FSPA_textColor', Tools::getValue('FSPA_textColor'));
            Configuration::UpdateValue('FSPA_titleColor', Tools::getValue('FSPA_titleColor'));
            Configuration::updateValue('FSPA_details', Tools::getValue('FSPA_details'));
            Configuration::updateValue('FSPA_showCarrier', Tools::getValue('FSPA_showCarrier'));
            Configuration::updateValue('FSPA_taxBlock', Tools::getValue('FSPA_taxBlock'));
            Configuration::updateValue('FSPA_images', Tools::getValue('FSPA_images'));
            Configuration::updateValue('FSPA_imagesAlbaran', Tools::getValue('FSPA_imagesAlbaran'));
            Configuration::updateValue('FSPA_imagesSlip', Tools::getValue('FSPA_imagesSlip'));
            Configuration::updateValue('FSPA_showdeliveryaddress', Tools::getValue('FSPA_showdeliveryaddress'));
            Configuration::updateValue('FSPA_texto_en_footer',$text_in_footer,true);
        } elseif (Tools::getIsset('panel_header')) {
           
            $panel = Tools::getValue('panel_header');
            $panel = Tools::substr($panel, 0, -1);
            Configuration::updateValue('FSPA_panelHeader', $panel);
            Configuration::updateValue('FSPA_margintop', (int)Tools::getValue('FSPA_margintop'));
            Configuration::updateValue('FSPA_marginfooter', (int)Tools::getValue('FSPA_marginfooter'));
            Configuration::updateValue('FSPA_marginfooterheader', (int)Tools::getValue('FSPA_marginfooterheader'));
        }
        
        
        $output .= '</div> <!-- .form-content -->';
        $output .= '<div class="col-md-4 panel help-panel panel-info">';
		$output .= '<div class="panel-heading">';
        $output .= '<i class="icon-info"></i> '.$this->l('Help').'';
        $output .= '</div>';
        $output .= '<div class="panel-content">';
        $output .= '<p>'. $this->l('Help for sales reports').'</p>';
        $output .= '<img src="../modules/'.$this->name.'/views/img/help-reports'.$iso_code.'.jpg" class="img-responsive">';
        $output .= '</div>';
        $output .= '</div> <!-- .help-panel panel-info -->';
        $output .= '</div> <!-- #panel-informe -->';        
        $output .= '<div role="tabpanel" id="panel-fields" class="tab-pane active">';
        $output .= '<div class="col-md-8 form-content">';
        $output .= $this->renderForm(true);
        $output .= '<div class="panel panel-info">';
        $output .= '<div class="panel-heading">';
        $output .= '<i class="icon-info"></i> '.$this->l('Extra tip').'';
        $output .= '</div>';
        $output .= '<p>'. $this->l('If you need to modify invoice`s footer data, you can do it in `Preferences / Stores´.').' <a href="index.php?controller=AdminStores#store_fieldset_contact" >'. $this->l('Go to `Stores´ and modify footer data').' <i class="icon-share"></i></a>';
        $output .= '</div>';        
        $output .= '</div> <!-- .form-content -->';
        $output .= '<div class="col-md-4 panel help-panel panel-info">';
		$output .= '<div class="panel-heading">';
        $output .= '<i class="icon-info"></i> '.$this->l('Help').'';
        $output .= '</div>';
        $output .= '<div class="panel-content">';
        $output .= '<p>'. $this->l('Help for invoice data and color customization').'</p>';
        $output .= '<img src="../modules/'.$this->name.'/views/img/help-customize'.$iso_code.'.jpg" class="img-responsive">';
        $output .= '<p>'. $this->l('Here you have an example file:').' <a href="../modules/'.$this->name.'/views/examples/invoice'.$iso_code.'.pdf" target="_blank" >'. $this->l('Download example invoice').'</a>.</p>';         
        $output .= '</div>';
        $output .= '</div> <!-- .help-panel -->';
        $output .= '</div> <!-- #panel-fileds -->';
        $output .= '<div role="tabpanel" id="panel-header" class="tab-pane">';
        $output .= '<div class="col-md-8 form-content">';
        $output .= '<div class="panel" style="float:left">';
        $output .= '<div class="panel-heading">';
        $output .= '<i class="icon-cogs"></i> '.$this->l('Customize your invoice`s header').'';
        $output .= '</div>';
        $output .= '<p>' . $this->l('You can sort header\'s elements. Drag the blocks below to get your preferred custom order:') . '</p>';
        $output .= '<ul id="ul-panel-short-header">';
        $paneles = explode(',', Configuration::get('FSPA_panelHeader'));
        foreach ($paneles as $key => $panel) {
            $output .= '<li id="' . $panel . '" class="col-md-4 well well-lg">';
            switch ($panel) {
                case 'header_block_1':
                    $output .= $this->l('Company Data');
                    $output .= '<img src="../modules/'.$this->name.'/views/img/custom-store-data.png" class="img-responsive">';
                    break;
                case 'header_block_2':
                    $output .= $this->l('Logo');
                    $output .= '<img src="../modules/'.$this->name.'/views/img/custom-logo.png" class="img-responsive">';
                    break;
                case 'header_block_3':
                    $output .= $this->l('Invoice Data');
                    $output .= '<img src="../modules/'.$this->name.'/views/img/custom-invoice-data.png" class="img-responsive">';
                    break;
            }
            $output .= '</li>';
        }
        $output .= '</ul>';
        
        $output .= '<form action="' . $_SERVER['REQUEST_URI'] . '"
            method="post" id="form_panel_header" name="form_panel_header" class="defaultForm form-horizontal">';
             
		$output .= '<div class="form-wrapper">';
		$output .= '<hr>'; 
        $output .='<div class="form-group col-md-6">
	        	<label class="control-label">'.$this->l('Header top margin').'</label>
	        	<div class="input-group col-md-6">
	            	<input type="text" name="FSPA_margintop" id="FSPA_margintop" value="'.Configuration::get('FSPA_margintop').'" />
	            	<span class="input-group-addon">pt</span>
	            </div>
            </div> <!-- .form-group -->
            <div class="form-group col-md-6">
	            <label class="control-label">'.$this->l('Header height').'</label>
	            <div class="input-group col-md-6">
	            	<input type="text" name="FSPA_marginfooterheader" id="FSPA_marginfooterheader" value="'.Configuration::get('FSPA_marginfooterheader').'" />
	            	<span class="input-group-addon">pt</span>
	            </div>
            </div> <!-- .form-group -->
            <div class="form-group col-md-12 clearfix">
            <label class="control-label">'.$this->l('Footer height').'</label>
            <div class="input-group col-md-3">
            	<input type="text" name="FSPA_marginfooter" id="FSPA_marginfooter" value="'.Configuration::get('FSPA_marginfooter').'" /> 
            	<span class="input-group-addon">pt</span> 
            </div>                     
            <input type="hidden" name="panel_header" id="panel_header" value="" />
            </div> <!-- .form-group -->
            <div class="clearfix"></div>
            </div> <!-- .form-wrapper -->
            
            <div class="panel-footer">';
        $output .= '<button onclick="savePanelHeader()" class="btn btn-default pull-right"><i class="process-icon-save"></i>'.$this->l('Save').'</button>';
        $output .= '</div> <!-- .panel-footer -->';        
        $output .= '</form>';
        $output .= '<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>';
        $output .= '<script type="text/javascript">
                         $(document).ready(function(){
                            $("#ul-panel-short-header").sortable();
                         });                    
                    </script>';
        $output .= '</div> <!-- .panel -->';        
        $output .= '</div> <!-- .form-content -->';
        $output .= '<div class="col-md-4 panel help-panel panel-info">';
		$output .= '<div class="panel-heading">';
        $output .= '<i class="icon-info"></i> '.$this->l('Help').'';
        $output .= '</div>';
        $output .= '<div class="panel-content">';        
        $output .= '<p>'. $this->l('Help for header customization').'</p>';
        $output .= '<img src="../modules/'.$this->name.'/views/img/help-header'.$iso_code.'.jpg" class="img-responsive">';
        $output .= '<p>'. $this->l('Here you have an example file:').' <a href="../modules/'.$this->name.'/views/examples/invoice'.$iso_code.'.pdf" target="_blank" >'. $this->l('Download example invoice').'</a>.</p>';
        $output .= '</div>';
        $output .= '</div> <!-- .help-panel panel-info -->';
        $output .= '</div> <!-- #panel-header -->';
        $output .= '</div> <!-- .tab-content -->';
        $output .= '</div> <!-- #content-fact-total -->'; 
        $output .= '<script>$( document ).ready(function() {
                console.log(tabpress);
                if (tabpress == 1)
                    $(".panel-fields" ).trigger( "click" );
                else if (tabpress == 2)
                    $(".panel-header2" ).trigger( "click" );
                else if (tabpress == 3)
                    $(".panel-informe" ).trigger( "click" );

            });</script>';
        return $output;
        
    }
    
    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm($fact = true)
    {
        $helper = new HelperForm();
        
        $helper->show_toolbar             = false;
        $helper->table                    = $this->table;
        $helper->module                   = $this;
        $helper->default_form_language    = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        
        $helper->identifier = $this->identifier;
        if (!$fact) {
            $helper->submit_action = 'submit_facturacion_total';
        } else {
            $helper->submit_action = 'submit_facturacion_total_factura';
        }

        $helper->currentIndex = $this->context->link
            ->getAdminLink('AdminModules', false).'&configure='
            .$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token        = Tools::getAdminTokenLite('AdminModules');
        
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues($fact),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );
        
        if (!$fact) {
            return $helper->generateForm(array(
                $this->getConfigForm()
            ));
        } else {
            return $helper->generateForm(array(
                $this->getFormFact()
            ));
        }
    }
       
    
    /**
     * Create the structure of your form.
     */
    protected function getFormFact()
    {
        
        $ver = _PS_VERSION_;
        $ver = explode('.', $ver);
        if ($ver[1] < 6) {
            $name_input = 'radio';
        } else {
            $name_input = 'switch';
        }
        
        return array(            
            	'form' => array(
                	'legend' => array(
                    'title' => $this->l('Configure your invoice data and customize invoice`s colors'),
                    'icon' => 'icon-cogs'
                ),                
                'input' => array(
                    array(
                        'autoload_rte' => true,
                        'type' => 'text',
                        'name' => 'FSPA_nombre',
                        'label' => $this->l('Store name'),
                        'col' => 6
                    ),
                    array(
                        'autoload_rte' => true,
                        'type' => 'text',
                        'name' => 'FSPA_razonSocial',
                        'label' => $this->l('Company name'),
                        'col' => 6
                    ),
                    array(
                        'autoload_rte' => true,
                        'type' => 'text',
                        'name' => 'FSPA_cif',
                        'label' => $this->l('Tax number'),
                        'col' => 4
                    ),
                    array(
                        'autoload_rte' => true,
                        'type' => 'text',
                        'name' => 'FSPA_domicilio',
                        'label' => $this->l('Address'),
                        'col' => 6
                    ),
                    array(
                        'autoload_rte' => true,
                        'type' => 'text',
                        'name' => 'FSPA_localidad',
                        'label' => $this->l('City'),
                        'col' => 6
                    ),
                    array(
                        'autoload_rte' => true,
                        'type' => 'text',
                        'name' => 'FSPA_Provincia',
                        'label' => $this->l('State'),
                        'col' => 6
                    ),
                    array(
                        'autoload_rte' => true,
                        'type' => 'text',
                        'name' => 'FSPA_Pais',
                        'label' => $this->l('Country'),
                        'col' => 6
                    ),
                    array(
                        'autoload_rte' => true,
                        'type' => 'text',
                        'name' => 'FSPA_telefono',
                        'label' => $this->l('Phone'),
                        'col' => 4,                        
                    ),
                    array(
                        'autoload_rte' => true,
                        'type' => 'text',
                        'name' => 'FSPA_fax',
                        'label' => $this->l('Fax'),
                        'col' => 4,                        
                    ),
                    array(
                        'autoload_rte' => true,
                        'type' => 'text',
                        'name' => 'FSPA_mail',
                        'label' => $this->l('E-mail'),
                        'col' => 6
                    ),
                    array(
                        'autoload_rte' => true,
                        'type' => 'text',
                        'name' => 'FSPA_otro',
                        'label' => $this->l('Extra data'),
                        'desc' => $this->l('Use this if you need to add any extra information in the company data shown at the invoice`s header.'),
                        'col' => 6
                    ),
                    array(
                        'autoload_rte' => true,
                        'type' => 'textarea',
                        'lang' => true,
                        'name' => 'FSPA_texto_en_footer',
                        'label' => $this->l('Footer`s text'),
                        'desc' => $this->l('This text will replace the default text PrestaShop generates at invoice`s footer. See the tip below for more info.'),
                        'col' => 8
                    ),
                    array(
                        'type' => $name_input,
                        'label' => $this->l('Show product details in invoice'),
                        'name' => 'FSPA_details',
                        'required' => false,
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => $name_input,
                        'label' => $this->l('Show tax breakdown block'),
                        'name' => 'FSPA_taxBlock',
                        'required' => false,
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => $name_input,
                        'label' => $this->l('Show product images in Invoice'),
                        'name' => 'FSPA_images',
                        'required' => false,
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => $name_input,
                        'label' => $this->l('Show product images in Credit Slip'),
                        'name' => 'FSPA_imagesSlip',
                        'required' => false,
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => $name_input,
                        'label' => $this->l('Show product images in Delivery Slip'),
                        'name' => 'FSPA_imagesAlbaran',
                        'required' => false,
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => $name_input,
                        'label' => $this->l('Show carrier in Invoice'),
                        'name' => 'FSPA_showCarrier',
                        'required' => false,
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                     array(
                        'type' => $name_input,
                        'label' => $this->l('Show delivery address'),
                        'name' => 'FSPA_showdeliveryaddress',
                        'required' => false,
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'autoload_rte' => true,
                        'type' => 'color',
                        'name' => 'FSPA_color',
                        'label' => $this->l('Panels background color')
                    ),
					array(
                        'autoload_rte' => true,
                        'type' => 'color',
                        'name' => 'FSPA_textColor',
                        'label' => $this->l('Panels text color')
                    ),
                    array(
                        'autoload_rte' => true,
                        'type' => 'color',
                        'name' => 'FSPA_titleColor',
                        'label' => $this->l('Invoice title color')
                    )
                    
                ),
                'submit' => array(
                    'title' => $this->l('Save')
                )
            )
        );
    }
    
    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues($fact = true)
    {
        if (!$fact) {
            return array(
                'date_in' => date('Y-m-01'),
                'date_out' => date('Y-m-30'),
                'ftotal_desglose_pagos' => 1,
                'ftotal_desglose_paises' => 1,
                'ftotal_desglose_impuestos' => 0,
                'ftotal_desglose_zonas' => 1
            );
        } else {

            $langs = $this->context->controller->getLanguages();
            $a2 = array();
            foreach ($langs as $value) {
                $a2[$value['id_lang']] = Configuration::get('FSPA_texto_en_footer',$value['id_lang']);
            }

            $a1 = array(
                'FSPA_nombre' => Configuration::get('FSPA_nombre'),
                'FSPA_razonSocial' => Configuration::get('FSPA_razonSocial'),
                'FSPA_cif' => Configuration::get('FSPA_cif'),
                'FSPA_domicilio' => Configuration::get('FSPA_domicilio'),
                'FSPA_localidad' => Configuration::get('FSPA_localidad'),
                'FSPA_Provincia' => Configuration::get('FSPA_Provincia'),
                'FSPA_Pais' => Configuration::get('FSPA_Pais'),
                'FSPA_telefono' => Configuration::get('FSPA_telefono'),
                'FSPA_fax' => Configuration::get('FSPA_fax'),
                'FSPA_mail' => Configuration::get('FSPA_mail'),
                'FSPA_otro' => Configuration::get('FSPA_otro'),
                'FSPA_details' => Configuration::get('FSPA_details'),
                'FSPA_showCarrier' => Configuration::get('FSPA_showCarrier'),
                'FSPA_color' => Configuration::get('FSPA_color'),
                'FSPA_titleColor' => Configuration::get('FSPA_titleColor'),
                'FSPA_textColor' => Configuration::get('FSPA_textColor'),
                'FSPA_taxBlock' => Configuration::get('FSPA_taxBlock'),
                'FSPA_images' => Configuration::get('FSPA_images'),
                'FSPA_imagesAlbaran' => Configuration::get('FSPA_imagesAlbaran'),
                'FSPA_imagesSlip' => Configuration::get('FSPA_imagesSlip'),
                'FSPA_showdeliveryaddress' => Configuration::get('FSPA_showdeliveryaddress'),
                'FSPA_texto_en_footer' => $a2,             
            );
           
            return $a1;
        }
    }    
    
    private function escribirArchivos($origen, $destino, $extension)
    {
        $path = _PS_ROOT_DIR_ . $origen;
        $dir  = dir($path);
        while (($file = $dir->read()) !== false) {
            if (is_file($path . '/' . $file) && preg_match('/^(.+)\.' . $extension . '$/i', $file)) {
                $texto   = '';
                $fichero = fopen($path . '/' . $file, 'r');
                while ($trozo = fgets($fichero, 1024)) {
                    $texto .= $trozo;
                }
                if ($file != 'HTMLTemplateInvoice.php') {
                    $xmlFile   = $destino . $file;
                    $xmlHandle = fopen($xmlFile, 'w');
                    fwrite($xmlHandle, $texto);
                    fclose($xmlHandle);
                }
            }
        }
        $dir->close();
    }    
    
    private function createVariables()
    {
        $content_multilang = array();
        
        $langs = $this->context->controller->getLanguages();
        
        foreach ($langs as $value) {
            $content_multilang[$value['id_lang']] = '';
        }
        
        Configuration::updateValue('FSPA_razonSocial', '');
        Configuration::updateValue('FSPA_nombre', '');
        Configuration::updateValue('FSPA_cif', '');
        Configuration::updateValue('FSPA_domicilio', '');
        Configuration::updateValue('FSPA_localidad', '');
        Configuration::updateValue('FSPA_Provincia', '');
        Configuration::updateValue('FSPA_Pais', '');
        Configuration::updateValue('FSPA_telefono', '');
        Configuration::updateValue('FSPA_fax', '');
        Configuration::updateValue('FSPA_mail', '');
        Configuration::updateValue('FSPA_otro', '');
        Configuration::updateValue('FSPA_color', '#000000');
        Configuration::UpdateValue('FSPA_textColor', '#ffffff');
        Configuration::UpdateValue('FSPA_titleColor', '#000000');
        Configuration::updateValue('FSPA_details', 0);
        Configuration::updateValue('FSPA_showCarrier', 0);
        Configuration::updateValue('FSPA_panelHeader', 'header_block_1,header_block_2,header_block_3');
        Configuration::updateValue('FSPA_taxBlock', 1);
        Configuration::updateValue('FSPA_images', 0);
        Configuration::updateValue('FSPA_imagesSlip', 0);
        Configuration::updateValue('FSPA_imagesAlbaran', 0);
        Configuration::updateValue('FSPA_marginfooterheader', 50);
        Configuration::updateValue('FSPA_margintop', 5);
        Configuration::updateValue('FSPA_marginfooter', 18);
        Configuration::updateValue('FSPA_showdeliveryaddress', 1);
        Configuration::updateValue('FSPA_texto_en_footer',$content_multilang);
        Configuration::updateValue('PMKT_licence_GLBINVLT','');
        Configuration::updateValue('PMKT_key_GLBINVLT','');
    }
    
    private function destroyVariables()
    {
        Configuration::deleteByName('FSPA_razonSocial');
        Configuration::deleteByName('FSPA_nombre');
        Configuration::deleteByName('FSPA_cif');
        Configuration::deleteByName('FSPA_domicilio');
        Configuration::deleteByName('FSPA_localidad');
        Configuration::deleteByName('FSPA_Provincia');
        Configuration::deleteByName('FSPA_telefono');
        Configuration::deleteByName('FSPA_Pais');
        Configuration::deleteByName('FSPA_fax');
        Configuration::deleteByName('FSPA_mail');
        Configuration::deleteByName('FSPA_otro');
        Configuration::deleteByName('FSPA_color');
        Configuration::deleteByName('FSPA_textColor');
        Configuration::deleteByName('FSPA_titleColor');
        Configuration::deleteByName('FSPA_details');
        Configuration::deleteByName('FSPA_showCarrier');
        Configuration::deleteByName('FSPA_multilang');
        Configuration::deleteByName('FSPA_panelHeader');
        Configuration::deleteByName('FSPA_taxBlock');
        Configuration::deleteByName('FSPA_images');
        Configuration::deleteByName('FSPA_imagesSlip');
        Configuration::deleteByName('FSPA_imagesAlbaran');
        Configuration::deleteByName('FSPA_margintop');
        Configuration::deleteByName('FSPA_marginfooter');
        Configuration::deleteByName('FSPA_marginfooterheader');
        Configuration::deleteByName('FSPA_showdeliveryaddress');
        Configuration::deleteByName('FSPA_texto_en_footer');
        Configuration::deleteByName('PMKT_licence_GLBINVLT');
        Configuration::deleteByName('PMKT_key_GLBINVLT');
    }

    public function formActivacion()
    {   
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
        
        $fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('Module activation'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Code'),
                    'name' => 'activationCode',
                    'desc' => $this->l('leave this field empty in localhost'),
                    'size' => 40,
                    'required' => true
                ),
                
            ),
            'submit' => array(
                'title' => $this->l('Send'),
                'class' => 'button'
            )
        );
         
        $helper = new HelperForm();
         
        // Module, token and currentIndex
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
         
        // Language
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;
         
        // Title and toolbar
        $helper->title = $this->displayName;
        $helper->show_toolbar = true;        // false -> remove toolbar
        $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
        $helper->submit_action = 'submit'.$this->name;
        $helper->toolbar_btn = array(
            'save' =>
            array(
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
                '&token='.Tools::getAdminTokenLite('AdminModules'),
            ),
            'back' => array(
                'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            )
        );       
        return $helper->generateForm($fields_form);
    }

    public static function getInvoiceBySlipOrder($id_order) 
    {
        $o = new Order($id_order);
        $i = $o->getInvoicesCollection();
        $x = @$i[0];
        if (is_object($x)) {
            $ht = new HTMLTemplateInvoice($x, Context::getContext()->smarty);
            return $ht->title;
        } else {
            return '';
        }
    }

    public function disable($force_all = false) 
    {
        $this->deleteDirectory(_PS_THEME_DIR_.'pdf');
        return parent::disable($force_all);
    }

    public function deleteDirectory($dir) {
        if(!$dh = @opendir($dir)) return;
        while (false !== ($current = readdir($dh))) {
            if($current != '.' && $current != '..') {
                if (!@unlink($dir.'/'.$current)) 
                    $this->deleteDirectory($dir.'/'.$current);
            }       
        }
        closedir($dh);
        @rmdir($dir);
    }

    public function enable($force_all = false) 
    {
        if (Configuration::get('PMKT_licence_GLBINVLT') != '') {
            $pdfDir = _PS_THEME_DIR_ . 'pdf';
            if (!is_dir($pdfDir)) {
                mkdir($pdfDir, 0777);
            }    
            $this->escribirArchivos('/modules/'.$this->name.'/views/templates/front/', _PS_THEME_DIR_ . 'pdf/', 'tpl');
        }
        parent::enable($force_all);
    }
}
