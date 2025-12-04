<?php
/**
* MTN Mobile Money Payment API Handler
*
* @author    Copilot
* @copyright Copyright (c) 2025
* @license   https://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class MtnMomoApi
{
    private $primaryKey;
    private $secondaryKey;
    private $apiUser;
    private $apiKey;
    private $baseUrl;
    private $callbackUrl;
    private $accessToken;
    private $tokenExpiry;
    
    public function __construct()
    {
        $this->primaryKey = Configuration::get('MTNMOMO_PRIMARY_KEY');
        $this->secondaryKey = Configuration::get('MTNMOMO_SECONDARY_KEY');
        $this->apiUser = Configuration::get('MTNMOMO_API_USER');
        $this->apiKey = Configuration::get('MTNMOMO_API_KEY');
        $this->callbackUrl = Configuration::get('MTNMOMO_CALLBACK_URL');
        
        // Set the base URL based on live mode
        $isLiveMode = (bool)Configuration::get('MTNMOMO_LIVE_MODE');
        $this->baseUrl = $isLiveMode 
            ? 'https://momodeveloper.mtn.com'
            : 'https://sandbox.momodeveloper.mtn.com';
    }
    
    /**
     * Get OAuth2 access token
     * 
     * @return string|bool Access token or false on failure
     */
    public function getAccessToken()
    {
        // If we already have a valid access token, return it
        if (!empty($this->accessToken) && $this->tokenExpiry > time()) {
            return $this->accessToken;
        }
        
        // Generate a token ID if not provided
        if (empty($this->apiUser)) {
            $this->apiUser = $this->generateUuid();
        }
        
        // Generate API key if not provided
        if (empty($this->apiKey)) {
            $this->apiKey = Tools::passwdGen(24);
        }
        
        $url = $this->baseUrl . '/collection/token/';
        $auth = base64_encode($this->apiUser . ':' . $this->apiKey);
        
        $headers = [
            'Authorization: Basic ' . $auth,
            'Ocp-Apim-Subscription-Key: ' . $this->primaryKey
        ];
        
        $response = $this->sendRequest($url, 'POST', $headers);
        
        if ($response && isset($response['access_token'])) {
            $this->accessToken = $response['access_token'];
            // Set expiry time (default is 3600 seconds)
            $this->tokenExpiry = time() + (isset($response['expires_in']) ? (int)$response['expires_in'] : 3600);
            return $this->accessToken;
        }
        
        return false;
    }
    
    /**
     * Claims consent from user via bc-authorize endpoint
     * 
     * @param string $accessToken OAuth2 access token
     * @param string $callbackUrl Optional callback URL
     * @return array Authorization result
     */
    public function bcAuthorize($accessToken = null, $callbackUrl = null)
    {
        if (!$accessToken) {
            $accessToken = $this->getAccessToken();
            if (!$accessToken) {
                return ['success' => false, 'message' => 'Failed to obtain access token'];
            }
        }
        
        $url = $this->baseUrl . '/collection/v1_0/bc-authorize';
        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'X-Target-Environment: ' . ($this->isLiveMode() ? 'mtnlive' : 'sandbox'),
            'Ocp-Apim-Subscription-Key: ' . $this->primaryKey,
            'Content-Type: application/json'
        ];
        
        // Add callback URL if provided
        if ($callbackUrl) {
            $headers[] = 'X-Callback-Url: ' . $callbackUrl;
        } elseif ($this->callbackUrl) {
            $headers[] = 'X-Callback-Url: ' . $this->callbackUrl;
        }
        
        $response = $this->sendRequest($url, 'POST', $headers);
        
        if ($response && isset($response['auth_req_id'])) {
            return [
                'success' => true,
                'auth_req_id' => $response['auth_req_id'],
                'interval' => isset($response['interval']) ? $response['interval'] : 5,
                'expires_in' => isset($response['expires_in']) ? $response['expires_in'] : 3600
            ];
        }
        
        return [
            'success' => false,
            'message' => isset($response['message']) ? $response['message'] : 'Unknown error'
        ];
    }
    
    /**
     * Request to pay via MTN MoMo
     * 
     * @param float $amount Amount to pay
     * @param string $phoneNumber Customer's phone number
     * @param string $externalId Order reference
     * @param int $orderId Order ID
     * @return array Payment request result
     */
    public function requestToPay($amount, $phoneNumber, $externalId, $orderId)
    {
        // Get access token
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return ['success' => false, 'message' => 'Failed to obtain access token'];
        }
        
        // Generate unique reference ID
        $referenceId = $this->generateUuid();
        
        $url = $this->baseUrl . '/collection/v1_0/requesttopay';
        
        $data = [
            'amount' => (string)$amount,
            'currency' => 'GHS',
            'externalId' => (string)$externalId,
            'payer' => [
                'partyIdType' => 'MSISDN',
                'partyId' => $phoneNumber
            ],
            'payerMessage' => 'Payment for order #' . $orderId,
            'payeeNote' => 'Order Payment'
        ];
        
        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'X-Reference-Id: ' . $referenceId,
            'X-Target-Environment: ' . ($this->isLiveMode() ? 'mtnlive' : 'sandbox'),
            'Ocp-Apim-Subscription-Key: ' . $this->primaryKey,
            'Content-Type: application/json'
        ];
        
        // Add callback URL if available
        if ($this->callbackUrl) {
            $headers[] = 'X-Callback-Url: ' . $this->callbackUrl;
        }
        
        $response = $this->sendRequest($url, 'POST', $headers, $data);
        
        // Request to pay API returns 202 Accepted with empty body if successful
        if ($this->lastHttpCode == 202) {
            return [
                'success' => true,
                'referenceId' => $referenceId
            ];
        }
        
        return [
            'success' => false,
            'message' => isset($response['message']) ? $response['message'] : 'Unknown error',
            'referenceId' => $referenceId
        ];
    }
    
    /**
     * Check payment status
     * 
     * @param string $referenceId Transaction reference ID
     * @return array Payment status result
     */
    public function checkPaymentStatus($referenceId)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return ['success' => false, 'message' => 'Failed to obtain access token'];
        }
        
        $url = $this->baseUrl . '/collection/v1_0/requesttopay/' . $referenceId;
        
        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'X-Target-Environment: ' . ($this->isLiveMode() ? 'mtnlive' : 'sandbox'),
            'Ocp-Apim-Subscription-Key: ' . $this->primaryKey
        ];
        
        $response = $this->sendRequest($url, 'GET', $headers);
        
        if ($response && isset($response['status'])) {
            return [
                'success' => true,
                'status' => $response['status'],
                'payer' => isset($response['payer']) ? $response['payer'] : null,
                'amount' => isset($response['amount']) ? $response['amount'] : null,
                'currency' => isset($response['currency']) ? $response['currency'] : null
            ];
        }
        
        return [
            'success' => false,
            'message' => isset($response['message']) ? $response['message'] : 'Failed to check payment status'
        ];
    }
    
    /**
     * Send HTTP request
     * 
     * @param string $url URL to send request to
     * @param string $method HTTP method (GET, POST, etc.)
     * @param array $headers HTTP headers
     * @param array|null $data Request body data
     * @return array|bool Response data or false on failure
     */
    private $lastHttpCode;
    
    private function sendRequest($url, $method = 'GET', $headers = [], $data = null)
    {
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        if ($data !== null && in_array($method, ['POST', 'PUT', 'PATCH'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $response = curl_exec($ch);
        $this->lastHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        // Log API interactions in debug mode
        if (_PS_MODE_DEV_) {
            $this->logApiInteraction($url, $method, $headers, $data, $response, $this->lastHttpCode);
        }
        
        // Parse JSON response
        $decoded = json_decode($response, true);
        
        // Return parsed response or empty array if not valid JSON
        return !empty($decoded) ? $decoded : [];
    }
    
    /**
     * Log API interactions for debugging
     */
    private function logApiInteraction($url, $method, $headers, $data, $response, $httpCode)
    {
        $log_file = _PS_MODULE_DIR_.'mtnmomo/logs/api_'.date('Ymd').'.log';
        $log_dir = dirname($log_file);
        
        if (!file_exists($log_dir)) {
            mkdir($log_dir, 0755, true);
        }
        
        $log_entry = date('[Y-m-d H:i:s]') . PHP_EOL;
        $log_entry .= "URL: $url" . PHP_EOL;
        $log_entry .= "Method: $method" . PHP_EOL;
        $log_entry .= "Headers: " . json_encode($headers) . PHP_EOL;
        
        if ($data !== null) {
            // Mask sensitive data
            $masked_data = $data;
            if (isset($masked_data['apiKey'])) {
                $masked_data['apiKey'] = '******';
            }
            $log_entry .= "Request: " . json_encode($masked_data) . PHP_EOL;
        }
        
        $log_entry .= "HTTP Code: $httpCode" . PHP_EOL;
        $log_entry .= "Response: $response" . PHP_EOL;
        $log_entry .= "--------------------------------" . PHP_EOL;
        
        file_put_contents($log_file, $log_entry, FILE_APPEND);
    }
    
    /**
     * Generate UUID v4
     * 
     * @return string UUID
     */
    private function generateUuid()
    {
        // Generate 16 bytes (128 bits) of random data
        $data = random_bytes(16);
        
        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        
        // Output the 36 character UUID
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
    
    /**
     * Check if live mode is enabled
     * 
     * @return bool
     */
    private function isLiveMode()
    {
        return (bool)Configuration::get('MTNMOMO_LIVE_MODE');
    }
}
