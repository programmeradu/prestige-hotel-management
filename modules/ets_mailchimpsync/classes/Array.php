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
require_once dirname(__FILE__) . '/Synchronizer.php';
require_once dirname(__FILE__) . '/User.php';

class Galahad_MailChimp_Synchronizer_Array extends Galahad_MailChimp_Synchronizer
{
	protected $_users;
	protected $_batched = false;
	protected $_keys = null;

	public function __construct($mcApiKey, Array $users)
	{	   
		$this->_users = $users;
		unset($users);

		foreach ($this->_users as $i => $user) {
			$this->_keys[$user['EMAIL']] = $i;
		}

		parent::__construct($mcApiKey);
	}

	protected function userExists($email, $listId = null)
	{
	   unset($listId);
		return isset($this->_keys[$email]);
	}

	protected function getUsers($batchNumber, $listId = null)
	{
		if (!$this->_batched) {
			$this->_users = array_chunk($this->_users, $this->_batchSize);
			$this->_batched = true;
		}

		if (!isset($this->_users[$batchNumber])) {
			return array();
		}
        unset($listId);
		return $this->_users[$batchNumber];
	}
}