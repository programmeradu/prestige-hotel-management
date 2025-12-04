{**
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
 *}

{if $position_tab == 1}
    {if !empty($infor)}
        {if $infor[0]['type'] == 0 }
        <h3 class="page-product-heading">VIDEO</h3> 
        <div class="video_product">
            <section class="page-product-box">
                <div class="rte video_product">
                    {$infor[0]['text_url'] nofilter}{*Escape is unnecessary*}
                </div>
            </section>
        </div>
            
        {/if}
        
        {if $infor[0]['type'] == 1 }
        <h3 class="page-product-heading">VIDEO</h3> 
        <div class="video_product">
            <section class="page-product-box">
                <div class="rte" style="position: relative; cursor: pointer;" onclick="playtap()">
                    <video style=" height: auto; cursor: pointer;" controls id="myVideotab" >
                    <source src="{$url|escape:'htmlall':'UTF-8'}">
                    </video>
                </div>
            </section>
        </div>
        {/if}
    {/if}
{/if}