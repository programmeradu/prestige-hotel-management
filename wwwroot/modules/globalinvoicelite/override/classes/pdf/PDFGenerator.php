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

class PDFGenerator extends PDFGeneratorCore
{
	/**
	 * Write a PDF page
	 */
	public function writePage()
	{						
		$this->SetHeaderMargin(Configuration::get('FSPA_margintop'));
		$this->SetFooterMargin(Configuration::get('FSPA_marginfooter'));
		$this->setMargins(10, Configuration::get('FSPA_marginfooterheader'), 10);
		$this->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
		$this->AddPage();
		$this->writeHTML($this->content, true, false, true, false, '');
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
}