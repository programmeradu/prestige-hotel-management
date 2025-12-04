<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */
class BaVideoTabEditVideoModuleFrontController extends ModuleFrontController
{
    /**
     * @see FrontController::postProcess()
     */
    public function run()
    {
		$cookie = new Cookie('psAdmin');
        $id_employee = $cookie->id_employee;
		if (empty($id_employee)) {
            echo $this->module->l('You do not have permission to access it.');
			exit;
        }
        $url = Tools::getShopProtocol() . Tools::getServerName() . __PS_BASE_URI__;
        $id_product = (int) Tools::getValue('id');
        $this->context->smarty->assign('url', $url);
        $this->context->smarty->assign('id_product', $id_product);
        $a = _PS_MODULE_DIR_ . '/bavideotab/views/templates/admin/videotab.tpl';
        $tb_p = $this->context->smarty->fetch($a);
        echo $tb_p;
    }
}
