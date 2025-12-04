<?php
/**
* MTN Mobile Money Payment Module for QloApps - Waiting Page Controller
*
* @author    Copilot
* @copyright Copyright (c) 2025
* @license   https://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
*/

class MtnMomoWaitingModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        
        $order_id = (int)Tools::getValue('order_id');
        $reference_id = Tools::getValue('ref');
        
        if (!$order_id || !$reference_id) {
            Tools::redirect('index.php');
        }
        
        $order = new Order($order_id);
        
        // Check order exists and belongs to current customer
        if (!Validate::isLoadedObject($order) || $order->id_customer != $this->context->customer->id) {
            Tools::redirect('index.php');
        }
        
        // Get transaction details from database
        $transaction = $this->getTransactionDetails($order_id, $reference_id);
        
        if (!$transaction) {
            Tools::redirect('index.php?controller=history');
        }
        
        $this->context->smarty->assign([
            'order_id' => $order_id,
            'reference_id' => $reference_id,
            'order_reference' => $order->reference,
            'status_url' => $this->context->link->getModuleLink('mtnmomo', 'status', array('ref' => $reference_id), true),
            'confirmation_url' => $this->context->link->getPageLink('order-confirmation', null, null, array(
                'id_cart' => $order->id_cart,
                'id_module' => $this->module->id,
                'key' => $this->context->customer->secure_key
            ))
        ]);
        
        $this->setTemplate('module:mtnmomo/views/templates/front/payment_waiting.tpl');
    }
    
    private function getTransactionDetails($order_id, $reference_id)
    {
        return Db::getInstance()->getRow(
            'SELECT * FROM `'._DB_PREFIX_.'mtnmomo_transaction` 
             WHERE `id_order` = '.(int)$order_id.' 
             AND `reference_id` = "'.pSQL($reference_id).'"'
        );
    }
}
