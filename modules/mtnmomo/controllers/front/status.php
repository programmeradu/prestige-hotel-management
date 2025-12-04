<?php
/**
* MTN Mobile Money Payment Module for QloApps - Payment Status Check Controller
*
* @author    Copilot
* @copyright Copyright (c) 2025
* @license   https://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
*/

class MtnMomoStatusModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        $this->ajax = true;
        parent::initContent();
    }
    
    public function postProcess()
    {
        // Check if this is an AJAX request
        if (!$this->isXmlHttpRequest()) {
            die(json_encode([
                'success' => false,
                'message' => 'Invalid request'
            ]));
        }
        
        $reference_id = Tools::getValue('ref');
        
        if (!$reference_id) {
            die(json_encode([
                'success' => false,
                'message' => 'Missing reference ID'
            ]));
        }
        
        // Get transaction details from database
        $transaction = $this->getTransactionByReference($reference_id);
        
        if (!$transaction) {
            die(json_encode([
                'success' => false,
                'message' => 'Transaction not found'
            ]));
        }
        
        // If transaction status is still PENDING, check with MTN MoMo API
        if ($transaction['status'] == 'PENDING') {
            $momo_api = new MtnMomoApi();
            $status_result = $momo_api->checkPaymentStatus($reference_id);
            
            if ($status_result['success']) {
                // Update transaction status in database
                $this->updateTransactionStatus($reference_id, $status_result['status']);
                
                // If payment was successful, update order status
                if ($status_result['status'] == 'SUCCESSFUL') {
                    $order = new Order($transaction['id_order']);
                    $order_history = new OrderHistory();
                    $order_history->id_order = (int)$order->id;
                    $order_history->changeIdOrderState(Configuration::get('PS_OS_PAYMENT'), $order->id);
                    $order_history->addWithemail(true);
                }
                
                // Return updated status
                die(json_encode([
                    'success' => true,
                    'status' => $status_result['status'],
                    'message' => $this->getStatusMessage($status_result['status'])
                ]));
            } else {
                die(json_encode([
                    'success' => false,
                    'message' => $status_result['message']
                ]));
            }
        } else {
            // Return current status from database
            die(json_encode([
                'success' => true,
                'status' => $transaction['status'],
                'message' => $this->getStatusMessage($transaction['status'])
            ]));
        }
    }
    
    private function getTransactionByReference($reference_id)
    {
        return Db::getInstance()->getRow(
            'SELECT * FROM `'._DB_PREFIX_.'mtnmomo_transaction` 
             WHERE `reference_id` = "'.pSQL($reference_id).'"'
        );
    }
    
    private function updateTransactionStatus($reference_id, $status)
    {
        Db::getInstance()->update(
            'mtnmomo_transaction',
            array(
                'status' => pSQL($status),
                'date_upd' => date('Y-m-d H:i:s')
            ),
            '`reference_id` = "'.pSQL($reference_id).'"'
        );
    }
    
    private function getStatusMessage($status)
    {
        switch ($status) {
            case 'PENDING':
                return $this->module->l('Your payment is being processed. Please wait...');
            case 'SUCCESSFUL':
                return $this->module->l('Payment successful! Your order has been confirmed.');
            case 'FAILED':
                return $this->module->l('Payment failed. Please try again or use a different payment method.');
            case 'TIMEOUT':
                return $this->module->l('The payment request has timed out. Please try again.');
            case 'REJECTED':
                return $this->module->l('Your payment was rejected. Please try again or contact support.');
            default:
                return $this->module->l('Unknown payment status.');
        }
    }
    
    private function isXmlHttpRequest()
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }
}
