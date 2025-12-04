{*
* 2007-2016 PrestaShop
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<script type="text/javascript">
    var product_url = '{$link->getAdminLink('AdminProducts', true)|addslashes}';
    var priceDisplayPrecision = {$smarty.const._PS_PRICE_DISPLAY_PRECISION_|intval};
    if(typeof noTax == 'undefined')
        var noTax = false;
    function calcPriceTEtpvtienda()
    {
        var priceTItpvtienda = parseFloat(document.getElementById('priceTItpvtienda').value.replace(/,/g, '.'));
        var newPrice = removeTaxes2(ps_round(priceTItpvtienda , priceDisplayPrecision));
        document.getElementById('priceTEtpvtienda').value = (isNaN(newPrice) == true || newPrice < 0) ? '' : ps_round(newPrice, 6).toFixed(6);
        document.getElementById('finalPricetpvtienda').innerHTML = (isNaN(newPrice) == true || newPrice < 0) ? '' : ps_round(priceTItpvtienda, priceDisplayPrecision).toFixed(priceDisplayPrecision);
        document.getElementById('finalPriceWithoutTaxtpvtienda').innerHTML = (isNaN(newPrice) == true || newPrice < 0) ? '' : (ps_round(newPrice, 6)).toFixed(6);
        calcReduction();
    }
    function removeTaxes2(price)
{
    var taxes = getTaxes2();
    var price_without_taxes = price;
    if (typeof taxes.computation_method == "undefined" || taxes.computation_method == 0) {
        for (i in taxes.rates) {
            price_without_taxes /= (1 + taxes.rates[i] / 100);
            break;
        }
    }
    else if (taxes.computation_method == 1) {
        var rate = 0;
        for (i in taxes.rates) {
             rate += taxes.rates[i];
        }
        price_without_taxes /= (1 + rate / 100);
    }
    else if (taxes.computation_method == 2) {
        for (i in taxes.rates) {
            price_without_taxes /= (1 + taxes.rates[i] / 100);
        }
    }

    return price_without_taxes;
}
    function getTaxes2()
    {
        if (noTax)
            taxesArray[taxId];
        var selectedTax = document.getElementById('id_tax_rules_group_tpvtienda');
        var taxId = selectedTax.options[selectedTax.selectedIndex].value;
        if(typeof taxesArray != "undefined")
            return taxesArray[taxId];
    }
    function addTaxes2(price)
    {
        var taxes = getTaxes2();
        var price_with_taxes = price;
        if (typeof taxes.computation_method != "undefined" && taxes.computation_method == 0) {
            for (i in taxes.rates) {
                price_with_taxes *= (1 + taxes.rates[i] / 100);
                break;
            }
        }
        else if (typeof taxes.computation_method != "undefined" && taxes.computation_method == 1) {
            var rate = 0;
            for (i in taxes.rates) {
                 rate += taxes.rates[i];
            }
            price_with_taxes *= (1 + rate / 100);
        }
        else if (typeof taxes.computation_method != "undefined" && taxes.computation_method == 2 || typeof taxes.computation_method == "undefined") {
            for (i in taxes.rates) {
                price_with_taxes *= (1 + taxes.rates[i] / 100);
            }
        }

        return price_with_taxes;
    }
    function calcPriceTItpvtienda()
    {

        var priceTE = parseFloat(document.getElementById('priceTEtpvtienda').value.replace(/,/g, '.'));
        var newPrice = addTaxes2(priceTE);

        document.getElementById('priceTItpvtienda').value = (isNaN(newPrice) == true || newPrice < 0) ? '' :
            ps_round(newPrice, priceDisplayPrecision);
        document.getElementById('finalPricetpvtienda').innerHTML = (isNaN(newPrice) == true || newPrice < 0) ? '' :
            ps_round(newPrice, priceDisplayPrecision).toFixed(priceDisplayPrecision);
        document.getElementById('finalPriceWithoutTaxtpvtienda').innerHTML = (isNaN(priceTE) == true || priceTE < 0) ? '' :
            (ps_round(priceTE, 6)).toFixed(6);

        if (isNaN(parseFloat($('#priceTItpvtienda').val())))
        {
            $('#priceTItpvtienda').val('');
            $('#finalPricetpvtienda').val('');
        }
        else
        {
            $('#priceTItpvtienda').val((parseFloat($('#priceTItpvtienda').val())).toFixed(priceDisplayPrecision));
            $('#finalPricetpvtienda').html(parseFloat($('#priceTItpvtienda').val()).toFixed(priceDisplayPrecision));
        }
    }
    function calcPriceCombNoTax(id_attribute){
        var inc = $("#input_price_comb_no_tax_"+id_attribute).val();
        var base = $("#priceTEtpvtienda").val();
         if(inc != ""){
         	$("#price_final_comb_no_tax_"+id_attribute).html((parseFloat(base) + parseFloat(inc)).toFixed(6));
         	$("#input_price_comb_tax_"+id_attribute).val(addTaxes2(inc).toFixed(priceDisplayPrecision));
         	$("#price_final_comb_tax_"+id_attribute).html(addTaxes2(parseFloat(base) + parseFloat(inc)).toFixed(priceDisplayPrecision));
        }else{
            $("#price_final_comb_no_tax_"+id_attribute).html('');
         	$("#input_price_comb_tax_"+id_attribute).val('');
         	$("#price_final_comb_tax_"+id_attribute).html('');
        }
    }
    function calcPriceCombTax(id_attribute){
        var inc = $("#input_price_comb_tax_"+id_attribute).val();
        var base = $("#priceTItpvtienda").val();
        if(inc != ""){
            $("#price_final_comb_tax_"+id_attribute).html((parseFloat(base) + parseFloat(inc)).toFixed(2));
          	$("#input_price_comb_no_tax_"+id_attribute).val(removeTaxes2(inc).toFixed(6));
            $("#price_final_comb_no_tax_"+id_attribute).html(removeTaxes2(parseFloat(base) + parseFloat(inc)).toFixed(6));
        }else{
            $("#price_final_comb_tax_"+id_attribute).html('');
          	$("#input_price_comb_no_tax_"+id_attribute).val('');
            $("#price_final_comb_no_tax_"+id_attribute).html('');
        }

    }
    function calcPricesTIattr(){
        var base = $("#priceTItpvtienda").val();
        $('.input_price_attr').each(function( index ) {
            var id_attr = $(this).attr('id');
            var priceIncWT = addTaxes2($("#"+id_attr).val());
            if(priceIncWT != ""){
                id_attr = id_attr.replace("input_price_comb_no_tax_", "");
                var priceWT = addTaxes2($(this).val());
                $("#input_price_comb_tax_"+id_attr).val(parseFloat(priceWT).toFixed(priceDisplayPrecision));
                $("#price_final_comb_tax_"+id_attr).html((parseFloat(priceIncWT) + parseFloat(base)).toFixed(priceDisplayPrecision));
            }else{
                $("#input_price_comb_tax_"+id_attr).val('');
                $("#price_final_comb_tax_"+id_attr).html('');
            }
        });
    }
    function calcPricesTEattr(){
        var base = $("#priceTEtpvtienda").val();
        $('.input_price_attr').each(function( index ) {
            var id_attr = $(this).attr('id');
            id_attr = id_attr.replace("input_price_comb_no_tax_", "");
            var inc = $(this).val();
            if(inc != "")
                $("#price_final_comb_no_tax_"+id_attr).html((parseFloat(inc) + parseFloat(base)).toFixed(6));
            else
                $("#price_final_comb_no_tax_"+id_attr).html('');
        });
    }
    function togglePreciosTPV(mostrarOcultar){
        if(mostrarOcultar == 1){
            if(atributos == 1){
                $("#contPreciosTPV .preciosAtributos input").prop( "disabled", false );
            }else{
                $("#contPreciosTPV input").prop( "disabled", false );
                $("#contPreciosTPV select").prop( "disabled", false );
            }
             $("#contPreciosTPV .form-group").fadeTo( "fast" , 1, function() {});
        }else{
                $("#contPreciosTPV input").prop( "disabled", true );
                $("#contPreciosTPV select").prop( "disabled", true );
             $("#contPreciosTPV .form-group").fadeTo( "fast" , 0.5, function() {});
        }
    }
    var atributos = {if !empty($attributes)}1{else}0{/if};
    var prec_spec_tpv = "{$prec_spec_tpv}";
    $(document).ready(function () {
        calcPriceTItpvtienda();
        calcPricesTIattr();
        calcPricesTEattr();
        if(prec_spec_tpv == 0)
            togglePreciosTPV(0)
    });
</script>
{capture assign=priceDisplayPrecisionFormat}{'%.'|cat:$smarty.const._PS_PRICE_DISPLAY_PRECISION_|cat:'f'}{/capture}
<div id="product-prices-tpv" class="{if $version == '1.6'}panel {/if}product-tab">
        <div class="col-md-12 form-group row">
            <div class="col-md-12 form-group preciosBase row" >
    			<div class="input-group">
    		        <h3 class="control-label form-control-label col-lg-3" for="min-quantity">{l s='Cantidad mínima en el TPV' mod='tpvtienda'}</h3>
                    <div class="col-lg-4" >
        				<input id="minimal_quantity_tpv" name="minimal_quantity_tpv" type="text" value="{$minimal_quantity_tpv}" class="form-control" maxlength="27" />
                        {l s='Vacio para mismo comportamiento que en la tienda' mod='tpvtienda'}
                    </div>
    			</div>
        	</div>
        </div>
        <div class="col-md-12 form-group preciosBase row">
        	 <div class="input-group">
        	    <h3 class="control-label form-control-label col-lg-3">{l s='Precio del producto en el TPV' mod='tpvtienda'}</h3>
                <div class="col-lg-4">
                    <div class="col-md-12">
                        <span class="switch prestashop-switch">
                            <input type="radio" name="prec_spec_tpv"  id="prec_spec_tpv_on" value="1"  {if ($prec_spec_tpv == 1)}checked="checked"{/if} onclick="togglePreciosTPV(1)">
                            <label for="prec_spec_tpv_on">{l s='Si' mod='tpvtienda'}</label>
                            <input type="radio" name="prec_spec_tpv"  id="prec_spec_tpv_off" value="0" {if ($prec_spec_tpv != 1)}checked="checked"{/if} onclick="togglePreciosTPV(0)">
                            <label for="prec_spec_tpv_off">{l s='No' mod='tpvtienda'}</label>
                     	</span>
                    </div>
                    {l s='¿Quiere un precio diferente para los productos en tienda física?' mod='tpvtienda'}
                </div>
            </div>
        </div>
        <div id="contPreciosTPV">
        	<div class="col-md-12 form-group preciosBase row">
        	    <div class="input-group">
            		<label class="control-label col-lg-5 text-right" >
            			<span class="label-tooltip" data-toggle="tooltip" title="{l s='El precio sin impuestos es el precio por el cual se quiere vender a sus clientes. Debería ser mayor que el precio de mayorista: la diferencia entre estos dos precios es el margen de beneficio.' mod='tpvtienda'}">
            			    {if !$country_display_tax_label || $tax_exclude_taxe_option}{l s='Precio con impuestos' mod='tpvtienda'}{else}{l s='Precio sin impuestos' mod='tpvtienda'}{/if}
                        </span>
            		</label>
            		<div class="col-lg-2">
            		    <div class="input-group money-type">
            				<input size="11" maxlength="27" id="priceTEtpvtienda" class="form-control" name="priceTEtpvtienda" type="text" value="{{toolsConvertPrice price=$priceTEtpvtienda}|string_format:'%.6f'}" onchange="noComma('priceTE'); " onkeyup="$('#priceTypetpvtienda').val('TE'); if (isArrowKey(event)) return; calcPriceTItpvtienda();" {if !empty($attributes)}disabled{/if}/>
                            <div class="input-group-append">
                                <span class="input-group-text"> {$currency->sign}</span>
                            </div>
                        </div>
            		</div>
            	</div>
        	</div>
        	<div class="col-md-12 preciosBase row" style="display:none">
            	<div class="input-group">
            	    <label class="control-label col-lg-5 text-right" for="id_tax_rules_group_tpvtienda">
            			{l s='Regla de impuestos' mod='tpvtienda'}:
            		</label>
            		<div class="col-lg-2">
            			<script type="text/javascript">
            				taxesArray = new Array();
            					{foreach $taxesRatesByGroup as $tax_by_group}
            				taxesArray[{$tax_by_group.id_tax_rules_group}] = {$tax_by_group|json_encode};
            				{/foreach}
            			</script>
            			<div class="row">
            				<div class="col-lg-8">
            					<select onchange="javascript:calcPrice(); unitPriceWithTax('unit');" name="id_tax_rules_group_tpvtienda" id="id_tax_rules_group_tpvtienda" {if $tax_exclude_taxe_option}disabled="disabled"{/if} >
            						<option value="0">{l s='Sin impuestos' mod='tpvtienda'}</option>
            					{foreach from=$tax_rules_groups item=tax_rules_group}
            						<option value="{$tax_rules_group.id_tax_rules_group}" {if $product->getIdTaxRulesGroup() == $tax_rules_group.id_tax_rules_group}selected="selected"{/if} >
            					{$tax_rules_group['name']|htmlentitiesUTF8}
            						</option>
            					{/foreach}
            					</select>
            				</div>
            			</div>
            		</div>
                </div>

        	</div>
        	{if $tax_exclude_taxe_option}
        	<div class="col-md-12 form-group preciosBase" style="display:none">
        		<div class="col-lg-9 col-lg-offset-3">
        			<div class="alert">
        				{l s='Los impuestos estan desactivados:' mod='tpvtienda'}
        				<a href="{$link->getAdminLink('AdminTaxes')|escape:'html':'UTF-8'}">{l s='Clic aqui para abrir la página de impuestos' mod='tpvtienda'}</a>
        				<input type="hidden" value="{$product->getIdTaxRulesGroup()}" name="id_tax_rules_group_tpvtienda" />
        			</div>
        		</div>
        	</div>
        	{/if}
        	<div class="col-md-12 form-group preciosBase row" {if !$country_display_tax_label || $tax_exclude_taxe_option}style="display:none;"{/if} >
        		<label class="control-label col-lg-5 text-right" for="priceTI">{l s='Precio con impuestos' mod='tpvtienda'}</label>
        		<div class="col-lg-2">
        			<div class="input-group money-type">
        				<input id="priceTypetpvtienda" name="priceTypetpvtienda" type="hidden" value="TE" />
        				<input id="priceTItpvtienda" name="priceTItpvtienda" type="text" class="form-control" value="" onchange="noComma('priceTItpvtienda');" maxlength="27" onkeyup="$('#priceTypetpvtienda').val('TI');if (isArrowKey(event)) return;  calcPriceTEtpvtienda();" {if !empty($attributes)}disabled{/if}/>
                        <div class="input-group-append">
                            <span class="input-group-text"> {$currency->sign}</span>
                        </div>
        			</div>
        		</div>
        	</div>
        	<div class="col-md-12 form-group">
        		<div class="col-lg-9 col-lg-offset-2">
        			<div class="alert alert-warning">
        				<strong>{l s='Precio de venta final en el TPV' mod='tpvtienda'}</strong>
        				<span id="finalPricetpvtienda" >0.00</span>
        					{$currency->sign}
        					<span{if !$ps_tax} style="display:none;"{/if}> ({l s='impuestos incluidos' mod='tpvtienda'})</span>
        				</span>
        				<span{if !$ps_tax} style="display:none;"{/if} >
        				{if $country_display_tax_label}
        					/
        				{/if}
                        </span>
        				<span id="finalPriceWithoutTaxtpvtienda"></span>
        					{$currency->sign}
        					{if $country_display_tax_label}({l s='sin impuestos' mod='tpvtienda'}){/if}
        				</span>
        			</div>
        		</div>
        	</div>
        	{if !empty($attributes)}
        	<div class="col-md-12 form-group">
            	        <label class="control-label col-lg-2" for=>
        			{l s='Combinaciones' mod='tpvtienda'}
        		</label>
        		<div class="col-lg-8">
        				<table class="table preciosAtributos">
        					<thead>
        						<tr>
        							<th><span class="title_box"></span></th>
        							<th><span class="title_box">{l s='Incremento precio sin IVA'  mod='tpvtienda'}</span></th>
        							<th><span class="title_box">{l s='Precio sin IVA'  mod='tpvtienda'}</span></th>
        							<th><span class="title_box">{l s='Incremento precio con IVA'  mod='tpvtienda'}</span></th>
        							<th><span class="title_box">{l s='Precio con IVA'  mod='tpvtienda'}</span></th>
        						</tr>
        					</thead>
        					{foreach from=$attributes item=attribute}
        						<tr{if isset($attribute['default_on']) && $attribute['default_on']} class="highlighted"{/if}>
        							<td>{$attribute['attributes']}</td>
        							<td class="price_comb_no_tax">
        								<input type="text" id="input_price_comb_no_tax_{$attribute['id_product_attribute']}" name="price_comb_no_tax[{$attribute['id_product_attribute']}]" class="input_price_attr fixed-width-sm" value="{$attribute['priceTPV']}" onkeyup="$('#input_price_comb_no_tax_{$attribute['id_product_attribute']}').val(this.value.replace(/,/g, '.'));calcPriceCombNoTax({$attribute['id_product_attribute']})"/>
        							</td>
        							<td>
        								<span id="price_final_comb_no_tax_{$attribute['id_product_attribute']}"></span>
        							</td>
        							<td class="price_comb_tax" >
        								<input type="text" id="input_price_comb_tax_{$attribute['id_product_attribute']}" class="price_comb_tax_{$attribute['id_product_attribute']} fixed-width-sm" class="fixed-width-sm" value="" onkeyup="$('#input_price_comb_tax_{$attribute['id_product_attribute']}').val(this.value.replace(/,/g, '.'));calcPriceCombTax({$attribute['id_product_attribute']})"/>
        							</td>
        							<td>
        								<span id="price_final_comb_tax_{$attribute['id_product_attribute']}"></span>
        							</td>
        						</tr>
        					{/foreach}
        			</table>
        		</div>
        	</div>
        	{/if}
        </div>
    {if $version == '1.6'}
        <div class="panel-footer">
            <a href="{$link->getAdminLink('AdminProducts')|escape:'html':'UTF-8'}{if isset($smarty.request.page) && $smarty.request.page > 1}&amp;submitFilterproduct={$smarty.request.page|intval}{/if}" class="btn btn-default"><i class="process-icon-cancel"></i> {l s='Cancelar' mod='tpvtienda'}</a>
            <button type="submit" name="submitAddproduct" class="btn btn-default pull-right"><i class="process-icon-loading"></i> {l s='Guardar' mod='tpvtienda'}</button>
            <button type="submit" name="submitAddproductAndStay" class="btn btn-default pull-right"><i class="process-icon-loading"></i> {l s='Guardar y permanecer' mod='tpvtienda'}</button>
        </div>
    {/if}
</div>
{$hookPOSAdminProductExtra}
{*
<div id="specific-prices-tpv" class="{if $version == '1.6'}panel {/if}product-tab">
    <h3>{l s='Descuento en el TPV' mod='tpvtienda'}</h3>
    <div class="alert alert-info" {if !$country_display_tax_label || $tax_exclude_taxe_option}style="display:none;"{/if}>
        {l s='NOTA: Estos descuentos se aplicarán a los clientes/empleados que esten en el grupo TPV Tienda' mod='tpvtienda'}
    </div>
    <div class="form-group">
        <div class="row">
            <label class="control-label col-lg-2" for="sp_reduction">{l s='Aplicar un descuento de' mod='tpvtienda'}</label>
            <div class="col-lg-1">
                <input type="text" name="sp_reduction_tpv" style="width:100%" id="sp_reduction_tpv" value="{$sp_reduction_tpv|intval}"/>
                </div>
            <div class="col-lg-1">
                <select name="sp_reduction_type_tpv" id="sp_reduction_type_tpv">
                    <option value="amount" {if $sp_reduction_type_tpv == 'amount'}selected="selected"{/if}>{$currency->name|escape:'html':'UTF-8'}</option>
                    <option value="percentage" {if $sp_reduction_type_tpv == 'percentage'}selected="selected"{/if}>{l s='%'}</option>
                </select>
            </div>
            <div class="col-lg-2">
                <select name="sp_reduction_tax_tpv" id="sp_reduction_tax_tpv">
                    <option value="0" {if $sp_reduction_tax_tpv == 0}selected="selected"{/if}>{l s='Sin impuestos' mod='tpvtienda'}</option>
                    <option value="1" {if $sp_reduction_tax_tpv == 1}selected="selected"{/if}>{l s='con impuestos' mod='tpvtienda'}</option>
                </select>
            </div>
        </div>
    </div>
    {if $version == '1.6'}
        <div class="panel-footer">
            <a href="{$link->getAdminLink('AdminProducts')|escape:'html':'UTF-8'}{if isset($smarty.request.page) && $smarty.request.page > 1}&amp;submitFilterproduct={$smarty.request.page|intval}{/if}" class="btn btn-default"><i class="process-icon-cancel"></i> {l s='Cancelar' mod='tpvtienda'}</a>
            <button type="submit" name="submitAddproduct" class="btn btn-default pull-right"><i class="process-icon-loading"></i> {l s='Guardar' mod='tpvtienda'}</button>
            <button type="submit" name="submitAddproductAndStay" class="btn btn-default pull-right"><i class="process-icon-loading"></i> {l s='Guardar y permanecer' mod='tpvtienda'}</button>
        </div>
    {/if}
</div>
*}

