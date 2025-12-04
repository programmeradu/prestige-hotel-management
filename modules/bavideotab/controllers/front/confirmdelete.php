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
class BaVideoTabConfirmDeleteModuleFrontController extends ModuleFrontController
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
		$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $id_product = (int) Tools::getValue('id');
        $id_lang = (int) Tools::getValue('id_lang');
        $id_shop = ($this->context->shop->id);
        $sql = 'SELECT text_url FROM ' . _DB_PREFIX_ . "url_video WHERE id_product='" . $id_product . "'";
        $sql .= "AND id_lang='" . $id_lang . "' AND id_store='" . $id_shop . "' AND type = 1 ";
        $text_url = $db->getValue($sql);
        if (empty($text_url)) {
            exit('0');
        }
        $url_dele = _PS_ROOT_DIR_ . '/media/' . $id_shop . '/' . $id_product . '/' . $id_lang . '/';
        $file = $url_dele . $text_url;
        @unlink($file);
        $sql1 = 'DELETE FROM ' . _DB_PREFIX_ . "url_video WHERE  id_product='" . $id_product . "'";
        $sql1 .= ' AND id_lang=' . $id_lang . ' AND id_store=' . $id_shop . ' AND type = 1';
        $db->query($sql1);
        echo '1';
    }
}
