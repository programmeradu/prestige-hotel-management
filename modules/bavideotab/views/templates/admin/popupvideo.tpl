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


{if $position_popup == 1}
    {if !empty($infor)}
    <div class="videopopup" style="padding : 15px 0px;"> 
            <button class="btn btn-primary" type="button" onclick="popupvideo()" style="width: auto;background: #fff;border-radius: 5px; height: 40px;border-color: #a3c9da;color:#565252; font-weight: 800;">
            <img src="{$url1|escape:'htmlall':'UTF-8'}modules/bavideotab/views/img/iconvideo.png" alt="" style="margin-top:-4px;">
            {l s='LIVE VIDEO' mod='bavideotab'}
         </button> 
    </div>
    <div class="popup" onclick="cancelpopup({$infor[0]['type']|escape:'htmlall':'UTF-8'})">
    </div>
    <div class="momo" onclick="play()">
            {if $infor[0]['type'] == 0 }
            <div class="video_popup" style="">
                    <div class="rte" style="position: relative;width: 100%; padding: 0px;">
                         <div>
                             {$infor[0]['text_url'] nofilter}{*Escape is unnecessary*}
                         </div>
                       
                    </div>
            </div>
            {/if}
            
            {if $infor[0]['type'] == 1 }
            <div class="video_productpopup">
                <div class="rte" style="">
                    <video style=" height: auto;width: 100%" controls id="myVideo">
                    <source src="{$url|escape:'htmlall':'UTF-8'}">
                    </video>
                    <video style="display: none;" controls id="demo">
                    <source src="{$url|escape:'htmlall':'UTF-8'}">
                    </video>
                </div>
            </div>
            {/if}
    </div>
    {/if}
{/if}