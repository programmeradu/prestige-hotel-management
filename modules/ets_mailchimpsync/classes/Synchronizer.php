<?php
/**
 * Copyright ETS Software Technology Co., Ltd
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future.
 *
 * @author ETS Software Technology Co., Ltd
 * @copyright  ETS Software Technology Co., Ltd
 * @license    Valid for 1 website (or project) for each purchase of license
*/
if (!defined('_PS_VERSION_')) { exit; }
require_once dirname(__FILE__) . '/User.php';

abstract class Galahad_MailChimp_Synchronizer
{
	protected $_mailChimp;
	protected $_mailChimpOptions = array(
		'doubleOptIn' => false,
		'replaceInterests' => true,
		'sendGoodby' => false,
		'sendNotify' => false,
	);
	protected $_batchSize = 500;
	protected $_batchLog = array();
	protected $_batchErrors = array();
	protected $_updateUsers = array();

	public function __construct($mcApiKey, $batchSize = 500)
	{
		if (!class_exists('MCAPI')) {
			throw new Galahad_MailChimp_Synchronizer_Exception('The MailChimp MCAPI class is required to use Galahad_MailChimp_Synchronizer.');
		}

		$this->_mailChimp = new MCAPI($mcApiKey);
		$this->setBatchSize($batchSize);
	}

	public function sync($listId, $unsubscribe = false)
	{
		$this->processMailChimpUsers($listId);
		$this->processLocalUsers($listId);
		if ($unsubscribe)
		{
			//$this->mailchimpUnsubscribers($listId);
			$this->prestashopunsubscribers($listId);
		}
		return true;
	}

	public function setBatchSize($batchSize)
	{
		$batchSize = (int) $batchSize;
		if ($batchSize < 1) {
			throw new Galahad_MailChimp_Synchronizer_Exception('Invalid batch size!');
		}

		$this->_batchSize = $batchSize;
	}

	public function setMailChimpOptions($options = array())
	{
		$this->_mailChimpOptions = array_merge($this->_mailChimpOptions, $options);
	}

	public function getBatchLog()
	{
		return $this->_batchLog;
	}

	public function getBatchErrorLog()
	{
		if (!count($this->_batchErrors)) {
			return false;
		}

		return $this->_batchErrors;
	}

	abstract protected function getUsers($batchNumber, $listId = null);

	abstract protected function userExists($email, $listId = null);

	protected function processMailChimpUsers($listId)
	{
		$unsubscribers = array();
		$start = 0;

		do {
			$batch = $this->_mailChimp->listMembers($listId, 'subscribed', null, $start, $this->_batchSize);
			$start++;
            if($batch)
    			foreach ($batch as $row) {
    				if (!$this->userExists($row['email'], $listId))
    					$unsubscribers[] = $row['email'];
    			}
		} while (count($batch) == $this->_batchSize);

		unset($batch);
		unset($unsubscribers);
	}

	protected function mailchimpUnsubscribers($listId)
	{
		$start = 0;
		do
		{
			$batch = $this->_mailChimp->listMembers($listId, 'unsubscribed', null, $start, $this->_batchSize);
			$start++;
			foreach ($batch as $row)
				$this->unsubscribeFromPrestashop($row['email']);
		} while (count($batch) == $this->_batchSize);

		unset($batch);
	}

	protected function unsubscribeFromPrestashop($email)
	{
		if(Db::getInstance()->update(_DB_PREFIX_.'customer', array('newsletter' => 0),  'email LIKE \''.pSQL($email).'\''))
			return true;
		if(Db::getInstance()->delete(_DB_PREFIX_.'newsletter', 'email = \''.pSQL($email).'\'', 1))
			return true;
		else
			echo Db::getInstance()->getMsgError();
		return true;
	}

	protected function prestashopunsubscribers($listId)
	{
		$emails = array();
		$unsubscribers = Db::getInstance()->executeS('SELECT email FROM `'._DB_PREFIX_.'customer` WHERE newsletter = 0');
		foreach ($unsubscribers as $unsubscriber)
			$emails[] = $unsubscriber['email'];
		if (is_array($emails) && !empty($emails))
			$this->_mailChimp->listBatchUnsubscribe($listId, $emails, true, false, false);
		unset($emails);
		return true;
	}

	protected function processLocalUsers($listId)
	{
		$batch = 0;

		while($users = $this->getUsers($batch++, $listId))
		{
			$batchResult = $this->_mailChimp->listBatchSubscribe($listId, $users, $this->_mailChimpOptions['doubleOptIn'], true, true);
			if ($this->_mailChimp->errorCode)
			{
                if(class_exists('Galahad_MailChimp_Synchronizer_Exception'))
				    throw new Galahad_MailChimp_Synchronizer_Exception('Error with batch subscribe: ' . $this->_mailChimp->errorMessage);
			}
			else
			{
				$this->_batchLog[] = "Subscribe Batch {$batch}: {$batchResult['success_count']} Succeeded";
				$this->_batchLog[] = "Subscribe Batch {$batch}: {$batchResult['error_count']} Failed";
				if ($batchResult['error_count'])
					$this->_batchErrors["Subscribe Batch {$batch}"] = $batchResult['errors'];
			}
		}
	}
}