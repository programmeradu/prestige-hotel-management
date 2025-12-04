<?php
/*
 * 2016 Pos Tpv Prestashop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to a Private Software License
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to customize this module
 * please contact with us.
 *
 *  @author Alejandro Lozano AELE <soporte@pos-tpv.com>
 *  @copyright  2016 Pos Tpv Prestashop
 *  @license private
 */

class tpvtienda extends PaymentModule
{
    private $_html;

    public function __construct(){
        $this->name = 'tpvtienda';
        $this->tab = 'administration';
        $this->version = '6.0';
        $this->bootstrap = true;
        $this->author = 'Alejandro Lozano';
        parent::__construct();
        $this->currencies = true;
        $this->context = Context::getContext();
        $this->currencies_mode = 'checkbox';
        $this->context->currency = new Currency(Configuration::get('PS_CURRENCY_DEFAULT'));
        $this->currency = new Currency($this->context->currency->id);
        $this->moneda = $this->currency->sign;
        $this->displayName = $this->l('TPV Tienda');
        $this->description = $this->l('TPV tienda fisica');
        if(!sizeof(Currency::checkPaymentCurrencies($this->id)))
            $this->warning = $this->l('No currency set for this module');
        $versionIoncube = $this->GetIonCubeLoaderVersion();
        if($versionIoncube){
            include_once(_PS_MODULE_DIR_.'/tpvtienda/classes/POSPrestashop.php');
            include_once(_PS_MODULE_DIR_.'/tpvtienda/classes/PluginsPOS.php');
            include_once(_PS_MODULE_DIR_.'/tpvtienda/classes/presupuesto/Quotation.php');
        }
        $this->confirmUninstall = $this->l('Esta seguro de que quiere desinstalar el modulo de TPV / POS prestashop?');
    }
    public function install(){
        $versionIoncube = $this->GetIonCubeLoaderVersion();
        if(!$versionIoncube){
            if($this->context->language->iso_code == 'es')
                $enlaceRequisitos = 'https://www.pos-tpv.com/es/content/14-requisitos-tpv-prestashop';
            else{
                if($this->context->language->iso_code == 'fr')
                    $enlaceRequisitos = 'https://www.pos-tpv.com/fr/content/14-besoins-point-de-vente-caisse-prestashop';
                else
                    $enlaceRequisitos = 'https://www.pos-tpv.com/en/content/14-requeriments-point-of-sale-pos-prestashop';
            }
           $this->_errors[] = $this->l('Este módulo requiere Ioncube instalado en su servidor. Si tiene su propio servidor podrá instalarlo usted mismo, en caso contrario consulte con su empresa de alojamiento para que lo instalen.').' <a href="'.$enlaceRequisitos.'" target="_blank">Mas info</a>';
           return false;
        }elseif (!parent::install()) {
            $this->_errors[] = $this->l('Instalación Prestashop fallida');
            return false;
        }elseif (!InstallPOS::createTab()){
            $this->_errors[] = $this->l('Creación de pestañas fallida');
            return false;
        }elseif (!Configuration::updateValue('TPVTIENDA_CB',1) OR !InstallPOS::chequearTabCodeBars() OR !InstallPOS::createCaja() OR !InstallPOS::createCajas() OR
            !InstallPOS::chequearTabCaja() OR !InstallPOS::chequearBilletes() OR !InstallPOS::tabla_codebars() OR
            !InstallPOS::tabla_codebars_predefinidas() OR !CambioPrecio::createCambioPrecio() OR !InstallPOS::modificarBDOrderPayment() OR
            !InstallPOS::chequearTabStock() OR !InstallPOS::chequearTabStatistics() OR !InstallPOS::chequearTabPantalla() OR
            !Configuration::updateGlobalValue('TPVTIENDA_CAMBIO_PRECIO',1) OR
            !Configuration::updateValue('TPVTIENDA_IVA',1) OR
            !Configuration::updateValue('TPVTIENDA_TICKET_DIREC',1) OR
            !Configuration::updateValue('TPVTIENDA_TICKET_TEXT', '') OR
            !Configuration::updateValue('TPVTIENDA_FACT_CRE',0) OR
            !Configuration::updateValue('TPVTIENDA_TICKET_MOSTRAR',1) OR
            !Configuration::updateValue('TPVTIENDA_TICKET_AUTOPRINT',1) OR
            !Configuration::updateValue('TPVTIENDA_TICKET_PUNTOS',1) OR
            !configuration::updateValue('TPVTIENDA_TICKET_LOGO','default') OR
            !configuration::updateValue('TPVTIENDA_TICKET_NUM',1) OR
            !configuration::updateValue('TPVTIENDA_PARTIAL_USE',1) OR
            !configuration::updateValue('TPVTIENDA_ABONO_DEV',1) OR
            !configuration::updateValue('TPVTIENDA_DEV_LOYALTY',1) OR
            !configuration::updateValue('TPVTIENDA_ABONO_MET',1) OR
            !configuration::updateValue('WSM_PARTIDOS',1) OR
            !Configuration::updateValue('TPVTIENDA_PROFORMA', '000000')){
            $this->_errors[] = $this->l('Instalación TPV fallida');
            return false;
        }elseif (!$this->registerHook('displayBackOfficeHeader') OR
                 !$this->registerHook('actionObjectDeleteAfter') OR
                 !$this->registerHook('actionObjectOrderSlipAddAfter') OR
                 !$this->registerHook('displayAdminOrder') OR
                 !$this->registerHook('actionProductUpdate') OR
                 !$this->registerHook('actionCarrierUpdate') OR
                 !$this->registerHook('actionOrderStatusPostUpdate') OR
                 !$this->registerHook('displayAdminProductsExtra') OR
                 !$this->registerHook('addWebserviceResources') OR
                 !$this->registerHook('actionAdminGroupsControllerSaveAfter') OR
                 !$this->registerHook('actionObjectAddAfter') OR
                 !$this->registerHook('displayPDFInvoice')){
            $this->_errors[] = $this->l('Error activando hooks');
            return false;
        }elseif (!InstallPOS::createGroup() OR !InstallPOS::createCarrier() OR !InstallPOS::darAccesoAtodos() OR !InstallPOS::createOrderState() OR
             !InstallPOS::tabla_aparcados() OR !Devolucion::createDevoluciones() OR
            !Ticket::createTicket() OR !Quotation::createQuotation() OR !Quotation::createQuotationState() ){
            $this->_errors[] = $this->l('Instalación parte final');
            return false;
        }
          return true;
    }

    public function uninstall(){
        if(!parent::uninstall() OR !$this->uninstallModuleTab() OR !InstallPOS::deleteCarrier())
            return false;
            return true;
    }
    public function uninstallModuleTab(){
        $context = Context::getContext();
        $sql = 'DELETE FROM `'._DB_PREFIX_.'tab` WHERE module="tpvtienda"';
        if(Db::getInstance()->Execute($sql))
            return true;
        else
            return false;
    }
    public function hookDisplayAdminOrder($params){
        $admintpvtienda = new AdminTPVTiendaController();
        return $admintpvtienda->adminOrderHook($params);
    }
    public function hookDisplayPDFInvoice($params) {
        $params['object'] = PluginsPOS::getHook('hookPOSPDFinvoice',array('params' => $params));
    }
    public function hookActionObjectAddAfter($params) {
        if(get_class($params['object']) == 'OrderInvoice'){
            return PluginsPOS::getHook('hookPOSActionSetInvoice',array('params' => $params));
        }
    }
    public function hookActionObjectDeleteAfter($params){
        if(get_class($params['object']) == 'Order'){
            POSPrestashop::BorrarPedido($params['object']->id);
        }
    }
    public function hookAddWebserviceResources($params) {
        return [
            'devolucion' => [ //Nom du paramètre $webserviceParameters['objectsNodeName'] de la classe Objet
                'description' => 'Devoluciones hechas en el TPV',
                'class' => 'Devolucion'
            ],
        ];
    }
    public function hookActionOrderStatusPostUpdate($params){
        $cancelStatus = Configuration::getGlobalValue('PS_OS_CANCELED');
        $id_order_status_mixto = Configuration::getGlobalValue('TPVTIENDA_OS_ID_PM');
        include_once(_PS_MODULE_DIR_.'/tpvtienda/classes/Movimientos.php');
        if($params['newOrderStatus']->id == $cancelStatus){
            Movimientos::DevolucionEnCaja($params);
            POSPrestashop::devolverProductoASM($params['id_order']);
            POSPrestashop::decrementarStockSiPresupuestoCancelado($params['id_order'],$params['newOrderStatus']->id);
        }else{
            POSPrestashop::decrementarStockSiPresupuesto($params['id_order'],$params['newOrderStatus']->id);
            if(isset($params['oldOrderStatus'])){
                POSPrestashop::cambioFormaPago($params['id_order'],$params['newOrderStatus']->id,$params['oldOrderStatus']->id);
                POSPrestashop::actualizoFechaFacturaPresupuesto($params['id_order'],$params['newOrderStatus']->id,$params['oldOrderStatus']->id);
            }
        }
    }
    function GetIonCubeLoaderVersion()
    {
        $ioncubeVersion = '';
        if (function_exists('ioncube_loader_version')) {
            $ioncubeVersion = ioncube_loader_version();
            return $ioncubeVersion;
        }
        return false;
    }
    public function hookActionCarrierUpdate($params){
        $id_carrier = Configuration::getGlobalValue('TPVTIENDA_CARRIER');
        $id_group = Configuration::getGlobalValue('TPVTIENDA_ID_GROUP');
        if($params['id_carrier'] == $id_carrier){
            Configuration::updateGlobalValue('TPVTIENDA_CARRIER',$params['carrier']->id);
            // Las siguientes lineas las incluye para asegurarme que el transportista POS se activa en todos los almacenes
            if(Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')){
                $warehouses = Warehouse::getWarehouses(true);
                foreach($warehouses as $warehouse){
                    $wareObject = new Warehouse($warehouse['id_warehouse']);
                    $carriers_ware = $wareObject->getCarriers(true);
                    if(!in_array($params['carrier']->id_reference,$carriers_ware))
                        $carriers_ware[] = $params['carrier']->id_reference;
                    $wareObject->setCarriers($arrayCarriers);
                }
            }

        }
    }
    public function hookActionAdminGroupsControllerSaveAfter($params){
        $id_group = Configuration::getGlobalValue('TPVTIENDA_ID_GROUP');
        $id_carrier = Configuration::getGlobalValue('TPVTIENDA_CARRIER');
        Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'carrier_group WHERE id_carrier = '.(int)($id_carrier).'  AND id_group <> '.$id_group);
    }
    // COPIADO DEL MODULO DE PAYPAL CON FEE
 //   public function hookDisplayPDFInvoice($params) {
//        $order = new order($params['object']->id_order);
//        if ($order->module == $this->name) {
//            $this->context->smarty->assign(array(
//                'fee' => Tools::displayPrice(Tools::convertPrice(PaypalOrderx::getFeeDB($order->id), new Currency($order->id_currency)), new Currency($order->id_currency)),
//            ));
//            return $this->display(__FILE__, 'views/templates/hook/pdf.tpl');
//        }
//    }
    public function hookDisplayBackOfficeHeader()
    {
        $js_custom = Configuration::getGlobalValue('TPVTIENDA_JS');
        if (method_exists($this->context->controller, 'addCSS')) {
            $this->context->controller->addCSS(__PS_BASE_URI__.'modules/tpvtienda/css/general.css');
        }
        return '<script type="text/javascript">'.$js_custom.'</script><meta name="apple-mobile-web-app-capable" content="yes">
        <link rel="apple-touch-icon" href="../modules/tpvtienda/img/pos-icon.png"/>';
    }
    public function hookDisplayOrderDetail($params)
    {
        $order = $params['order'];
        $html = DocumentSigned::hookOrderDetail($params);
        if(isset($order) && isset($order->payment_fee) && $order->payment_fee!=0 && $order->module == 'tpvtienda')
        {
            $html .= '<br />
            <div class="table_block">
            <table class="std">
                <thead>
                    <tr>
                        <th><img src="'.$this->_path.'logo.gif"/> '.$this->l('Recargo').'</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>'.$this->l('Recargo aplicado:').':&nbsp;<span style="color:red">'.Tools::displayPrice($order->payment_fee). '</span></td>
                    <tr>
                </tbody>
            </table>
            </div>';
        }
        return $html;
    }
    public function hookActionObjectOrderSlipAddAfter($params){
        PluginsPOS::hook('hookPOSActionSetCreditSlip',array('orderSlip' => $params['object']));
    }
    public function hookDisplayAdminProductsExtra($params)
    {
        $versionIoncube = $this->GetIonCubeLoaderVersion();
        if(!$versionIoncube)
            return null;
        if(Configuration::get('TPVTIENDA_CAMBIO_PRECIO') == 0)
            return $this->display(__FILE__, 'views/templates/admin/error.tpl');
        if ($this->context->shop->getContext() != Shop::CONTEXT_GROUP) {
            if(version_compare(_PS_VERSION_, "1.7.0.0",'<')){
                $id_product = Tools::getValue('id_product');
            }else{
                $id_product = $params['id_product'];
            }
            $product = new Product($id_product);

            if (!empty($id_product) && $id_product != 0 && $id_product != "") {
                $shops = Shop::getShops();
                $countries = Country::getCountries($this->context->language->id);
                $groups = Group::getGroups($this->context->language->id);
                $currencies = Currency::getCurrencies();
                $attributes = $product->getAttributesGroups((int)$this->context->language->id);
                $combinations = array();
                $sql = 'SELECT COUNT(*) as contador FROM '._DB_PREFIX_.'posp_cambio_precio WHERE oldPrice <> "" AND id_cart = 0 AND id_product = '.$id_product;
                $prec_spec_tpv = Db::getInstance()->ExecuteS($sql);
                if(isset($prec_spec_tpv) && $prec_spec_tpv[0]['contador'] >= 1)
                    $prec_spec_tpv = 1;
                else
                    $prec_spec_tpv = 0;
                $sql = 'SELECT newPrice,minimal_quantity FROM '._DB_PREFIX_.'posp_cambio_precio WHERE id_cart = 0 AND id_product = '.$id_product.' AND id_product_attribute = 0';
                $result = Db::getInstance()->ExecuteS($sql);
                $minimalQty = "";
                if(isset($result[0]['minimal_quantity']))
                    $minimalQty = $result[0]['minimal_quantity'];
                if($minimalQty == 0)
                    $minimalQty = "";
                if(empty($attributes) && isset($result[0]['newPrice']))
                    $priceTEtpvtienda = $result[0]['newPrice'];
                else
                    $priceTEtpvtienda = $product->price;

                foreach ($attributes as $attribute) {
                    $combinations[$attribute['id_product_attribute']]['id_product_attribute'] = $attribute['id_product_attribute'];
                    if (!isset($combinations[$attribute['id_product_attribute']]['attributes'])) {
                        $combinations[$attribute['id_product_attribute']]['attributes'] = '';
                    }
                    $sql = 'SELECT newPrice FROM '._DB_PREFIX_.'posp_cambio_precio WHERE id_cart = 0 AND id_product = '.$id_product.' AND id_product_attribute = '.$attribute['id_product_attribute'];
                    $priceTPV = Db::getInstance()->ExecuteS($sql);
                    $priceTPV = (isset($priceTPV[0]['newPrice']) ? $priceTPV[0]['newPrice'] : null);
                    if($priceTPV == null)
                        $priceTPV = 0;
                    else
                        $priceTPV = $priceTPV - $priceTEtpvtienda;
                    $combinations[$attribute['id_product_attribute']]['attributes'] .= $attribute['attribute_name'].' - ';
                    $combinations[$attribute['id_product_attribute']]['priceTPV'] = number_format($priceTPV, 6,'.','');
                }
                foreach ($combinations as &$combination) {
                    $combination['attributes'] = rtrim($combination['attributes'], ' - ');
                }
                $this->context->smarty->assign(array(
                    'shops' => $shops,
                    'admin_one_shop' => count($this->context->employee->getAssociatedShops()) == 1,
                    'currencies' => $currencies,
                    'countries' => $countries,
                    'groups' => $groups,
                    'no_tax' => Tax::excludeTaxeOption() || !$product->getTaxesRate(),
                    'prec_spec_tpv' => $prec_spec_tpv,
                    'combinations' => $combinations,
                    'minimal_quantity_tpv' => $minimalQty,
                    'priceTEtpvtienda' => $priceTEtpvtienda,
                    'multi_shop' => Shop::isFeatureActive(),
                    'link' => new Link(),
                    'hookPOSAdminProductExtra' => PluginsPOS::getHook('hookPOSAdminProductExtra',array('product' => $product,'context'=>$this->context)),
                    'pack' => new Pack()
                ));
                //specific prices TPV
                $id_group_tpv = Configuration::get('TPVTIENDA_ID_GROUP');
               // $sql = 'SELECT * FROM '._DB_PREFIX_.'specific_price WHERE id_product='.$product->id.' AND id_shop='.$this->context->shop->id.' AND id_group='.$id_group_tpv;
//
//                $specificTPV = Db::getInstance()->ExecuteS($sql);
//                if(!empty($specificTPV)){
//                    if($specificTPV[0]['reduction_type'] =='amount')
//                        $reduction = $specificTPV[0]['reduction'];
//                    else
//                        $reduction = $specificTPV[0]['reduction'] * 100;
//                    $sp_reduction_tpv = number_format($reduction, (int)_PS_PRICE_COMPUTE_PRECISION_,'.','');
//                    $sp_reduction_type_tpv = $specificTPV[0]['reduction_type'];
//                    $sp_reduction_tax_tpv = $specificTPV[0]['reduction_tax'];
//                }else{
//                    $sp_reduction_tpv = "";
//                    $sp_reduction_type_tpv = "";
//                    $sp_reduction_tax_tpv = "";
//                }
//                $this->context->smarty->assign(array(
//                    'sp_reduction_tpv' => $sp_reduction_tpv,
//                    'sp_reduction_type_tpv' => $sp_reduction_type_tpv,
//                    'sp_reduction_tax_tpv' => $sp_reduction_tax_tpv
//                ));

                $address = new Address();
                $address->id_country = (int)$this->context->country->id;
                $tax_rules_groups = TaxRulesGroup::getTaxRulesGroups(true);
                $tax_rates = array(
                    0 => array(
                        'id_tax_rules_group' => 0,
                        'rates' => array(0),
                        'computation_method' => 0
                    )
                );

                foreach ($tax_rules_groups as $tax_rules_group) {
                    $id_tax_rules_group = (int)$tax_rules_group['id_tax_rules_group'];
                    $tax_calculator = TaxManagerFactory::getManager($address, $id_tax_rules_group)->getTaxCalculator();
                    $tax_rates[$id_tax_rules_group] = array(
                        'id_tax_rules_group' => $id_tax_rules_group,
                        'rates' => array(),
                        'computation_method' => (int)$tax_calculator->computation_method
                    );

                    if (isset($tax_calculator->taxes) && count($tax_calculator->taxes)) {
                        foreach ($tax_calculator->taxes as $tax) {
                            $tax_rates[$id_tax_rules_group]['rates'][] = (float)$tax->rate;
                        }
                    } else {
                        $tax_rates[$id_tax_rules_group]['rates'][] = 0;
                    }
                }
                // prices part
                $this->context->smarty->assign(array(
                    'link' => $this->context->link,
                    'currency' => $currency = $this->context->currency,
                    'tax_rules_groups' => $tax_rules_groups,
                    'taxesRatesByGroup' => $tax_rates,
                    'attributes' => $combinations,
                    'tax_exclude_taxe_option' => Tax::excludeTaxeOption()
                ));

                $product->price = Tools::convertPrice($product->price, $this->context->currency, true, $this->context);
                if ($product->unit_price_ratio != 0)
                    $this->context->smarty->assign('unit_price', Tools::ps_round($product->price / $product->unit_price_ratio, 6));
                else
                    $this->context->smarty->assign('unit_price', 0);
                    $this->context->smarty->assign('ps_tax', Configuration::get('PS_TAX'));
                    $this->context->smarty->assign('country_display_tax_label', $this->context->country->display_tax_label);
                    $this->context->smarty->assign(array(
                        'currency', $this->context->currency,
                        'product' => $product,
                        'version' => substr(_PS_VERSION_,0,3)
                    ));
                return $this->display(__FILE__, 'views/templates/admin/tpvtienda.tpl');
            } else {
                return $this->displayWarning($this->l('Debes guardar el producto antes de añadir un precio para el TPV'));
            }
        }else {
            return $this->displayWarning($this->l('No disponible en para grupos de tiendas'));
        }
    }
    public function hookActionProductUpdate($params)
    {
        CambioPrecio::hookActionProductUpdate($this->context,$params);
        PluginsPOS::hook('hookPOSPostAdminProductExtra',$params);
    }
    public function hookOrderDetailDisplayed($param){
        $order = $param['order'];
        if(isset($order) && $order->payment_fee!=0 && $order->module == 'tpvtienda')
        {
            $html = '<br />
            <ul>
                <li><img alt="'.$this->l('Connexion').'" src="'.$this->_path.'logo.gif"/> '.$this->l('Recargo').'</li>
                <li>'.$this->l('Recargo aplicado:').':&nbsp;<span style="color:red">'.Tools::displayPrice($order->payment_fee). '</span></li>
            </ul>';
            return $html;
        }
    }
    public function hookPaymentOptions($params)
    {
        $params['context'] = $this->context;
        return PluginsPOS::getHook('hookPOSPaymentOptions',array('params' => $params));
    }
//    public function hookDisplayPaymentReturn($params)
//    {
//
//        $bankwireOwner = $this->owner;
//        if (!$bankwireOwner) {
//            $bankwireOwner = '___________';
//        }
//
//        $bankwireDetails = Tools::nl2br($this->details);
//        if (!$bankwireDetails) {
//            $bankwireDetails = '___________';
//        }
//
//        $bankwireAddress = Tools::nl2br($this->address);
//        if (!$bankwireAddress) {
//            $bankwireAddress = '___________';
//        }
//
//        $totalToPaid = $params['order']->getOrdersTotalPaid() - $params['order']->getTotalPaid();
//        $this->smarty->assign([
//            'shop_name' => $this->context->shop->name,
//            'total' => $this->context->getCurrentLocale()->formatPrice(
//                $totalToPaid,
//                (new Currency($params['order']->id_currency))->iso_code
//            ),
//            'bankwireDetails' => $bankwireDetails,
//            'bankwireAddress' => $bankwireAddress,
//            'bankwireOwner' => $bankwireOwner,
//            'status' => 'ok',
//            'reference' => $params['order']->reference,
//            'contact_url' => $this->context->link->getPageLink('contact', true),
//        ]);
//
//        return $this->fetch('module:ps_wirepayment/views/templates/hook/payment_return.tpl');
//    }
    private function initForm()
    {
        $helper = new HelperForm();
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->languages = $this->context->controller->_languages;
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        $helper->default_form_language = $this->context->controller->default_form_language;
        $helper->allow_employee_form_lang = $this->context->controller->allow_employee_form_lang;
        $helper->toolbar_scroll = true;

        return $helper;
    }
    function getOrderStateInvoice($estadoContado){
        $os = new OrderState($estadoContado);
        return $os->invoice;
    }
    function getContent(){
        if(!$this->isRegisteredInHook('displayBackOfficeHeader'))
            $this->registerHook('displayBackOfficeHeader');
        if($this->isRegisteredInHook('actionObjectDeleteAfter') != 1)
            $this->registerHook('actionObjectDeleteAfter');
        if($this->isRegisteredInHook('displayAdminOrder') != 1)
            $this->registerHook('displayAdminOrder');
        if($this->isRegisteredInHook('actionCarrierUpdate') != 1)
            $this->registerHook('actionCarrierUpdate');
        if($this->isRegisteredInHook('displayOrderDetail') != 1)
            $this->registerHook('displayOrderDetail');
        if($this->isRegisteredInHook('paymentOptions') != 1)
            $this->registerHook('paymentOptions');
        $versionIoncube = $this->GetIonCubeLoaderVersion();
        if($versionIoncube){
            include_once(_PS_MODULE_DIR_.'/tpvtienda/classes/CambioPrecio.php');
            include_once(_PS_MODULE_DIR_.'/tpvtienda/classes/Movimientos.php');
            include_once(_PS_MODULE_DIR_.'/tpvtienda/classes/Devolucion.php');
            include_once(_PS_MODULE_DIR_.'/tpvtienda/ioncubeVersion.php');
            if(version_compare(_PS_VERSION_, "1.7.3.0",'<'))
                include_once(_PS_MODULE_DIR_.'tpvtienda/classes/cart/16/TPVCart.php');
            else if(version_compare(_PS_VERSION_, "1.7.3.0",'>') && version_compare(_PS_VERSION_, "1.7.7.2",'<'))
                include_once(_PS_MODULE_DIR_.'tpvtienda/classes/cart/17/TPVCart.php');
            else if(version_compare(_PS_VERSION_, "1.7.7.2",'>') )
                include_once(_PS_MODULE_DIR_.'tpvtienda/classes/cart/1775/TPVCart.php');
            else
                include_once(_PS_MODULE_DIR_.'tpvtienda/classes/cart/1770/TPVCart.php');
            include_once(_PS_MODULE_DIR_.'/tpvtienda/classes/InstallPOS.php');
            include_once(_PS_MODULE_DIR_.'/tpvtienda/controllers/admin/AdminTPVTiendaController.php');
            include_once(_PS_MODULE_DIR_.'/tpvtienda/controllers/admin/AdminActionsTpvTiendaController.php');
            include_once(_PS_MODULE_DIR_.'/tpvtienda/controllers/admin/AdminActionsRestockController.php');
            include_once(_PS_MODULE_DIR_.'/tpvtienda/controllers/admin/AdminScreenController.php');
//            echo ioncubeVersion::getVersion();
            $posPrestashop = new POSPrestashop($this->context);
            return $posPrestashop->getContent();
        }else{
            return Tools::displayError($this->l("Error: Ioncube esta desinstalado en su servidor, consulte con su hosting para volver a instalarlo"));
        }
    }

}?>