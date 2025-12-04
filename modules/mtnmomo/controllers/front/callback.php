<?php
/**
* MTN Mobile Money Payment Module for QloApps - Callback Handler
*
* @author    Copilot
* @copyright Copyright (c) 2025
* @license   https://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
*/

class MtnMomoCallbackModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        // Check if this is a proper callback from MTN
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!$data || !isset($data['referenceId'])) {
            header('HTTP/1.1 400 Bad Request');
            die('Invalid request');
        }
        
        // Log the callback (for debugging)
        $this->logCallback($data);
        
        $reference_id = $data['referenceId'];
        $status = isset($data['status']) ? $data['status'] : 'UNKNOWN';
        
        // Get transaction from database
        $transaction = $this->getTransactionByReference($reference_id);
        
        if (!$transaction) {
            header('HTTP/1.1 404 Not Found');
            die('Transaction not found');
        }
        
        // Update transaction status in database
        $this->updateTransactionStatus($reference_id, $status);
        
        // If payment was successful, update order status
        if ($status == 'SUCCESSFUL' || $status == 'COMPLETED') {
            $order = new Order($transaction['id_order']);
            $order_history = new OrderHistory();
            $order_history->id_order = (int)$order->id;
            $order_history->changeIdOrderState(Configuration::get('PS_OS_PAYMENT'), $order->id);
            $order_history->addWithemail(true);
        } elseif ($status == 'FAILED' || $status == 'REJECTED') {
            $order = new Order($transaction['id_order']);
            $order_history = new OrderHistory();
            $order_history->id_order = (int)$order->id;
            $order_history->changeIdOrderState(Configuration::get('PS_OS_ERROR'), $order->id);
            $order_history->addWithemail(true);
        }
        
        // Return success response
        header('HTTP/1.1 200 OK');
        die(json_encode(['status' => 'success']));
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
    
    private function logCallback($data)
    {
        $log_file = _PS_MODULE_DIR_.'mtnmomo/logs/callback_'.date('Ymd').'.log';
        $log_dir = dirname($log_file);
        
        if (!file_exists($log_dir)) {
            mkdir($log_dir, 0755, true);
        }
        
        file_put_contents(
            $log_file,
            date('[Y-m-d H:i:s] ').json_encode($data).PHP_EOL,
            FILE_APPEND
        );
    }
}
