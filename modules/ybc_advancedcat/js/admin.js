$(document).ready(function(){
    if($('.ybc_fancy').length > 0)
    {
        $('.ybc_fancy').fancybox();
    }
    $('#product_autocomplete_input').autocomplete(ybc_advancedcat_ajax_url,{
		minChars: 1,
		autoFill: true,
		max:20,
		matchContains: true,
		mustMatch:true,
		scroll:false,
		cacheLength:0,
		formatItem: function(item) {
			return item[1]+' - '+item[0];
		}
	}).result(ybcAddAccessory);
    $('#product_autocomplete_input').setOptions({
		extraParams: {
			excludeIds : ybcGetAccessoriesIds()
		}
	});
    //Sortable 
    if($('.ybc_advancedcats_backend').length > 0)
    {
        $( ".ybc_advancedcats_backend" ).sortable({
          update: function(e,ui){
            if (this === ui.item.parent()[0]){
                $.ajax({
                    url : ybc_advancedcats_short_url,
                    type: 'POST',
                    data: getAdvancedCatsOrders(),
                    dataType : 'json',
                    success: function()
                    {
                        
                    },
                    error: function(){
                        
                    }                    
                });
            }
          }
        }).disableSelection();
    }
});

function getAdvancedCatsOrders()
{
    var orderStr = 'reorder=yes';
    if($('.ybc_advancedcats_backend .ybc_ac_item').length > 0)
    {        
        var ik = 0;
        $('.ybc_advancedcats_backend .ybc_ac_item').each(function(){
            ik++;
            orderStr += '&sortcat['+$(this).attr('rel')+']='+ik;
        });
    }
    return orderStr;
}

function ybcGetAccessoriesIds()
{
    if ($('#inputAccessories').val() === undefined)
			return '';
		return $('#inputAccessories').val().replace(/\-/g,',');
}
var ybcAddAccessory = function(event, data, formatted)
{
	if (data == null)
		return false;
	var productId = data[1];
	var productName = data[0];

	var $divAccessories = $('#divAccessories');
	var $inputAccessories = $('#inputAccessories');
	var $nameAccessories = $('#nameAccessories');

	/* delete product from select + add product line to the div, input_name, input_ids elements */
	$divAccessories.html($divAccessories.html() + '<div class="form-control-static"><button type="button" onclick="ybcDelAccessory('+productId+');" class="btn btn-default" name="' + productId + '"><i class="icon-remove text-danger"></i></button>&nbsp;'+ productName +'</div>');
	$nameAccessories.val($nameAccessories.val() + productName + '¤');
	$inputAccessories.val($inputAccessories.val() + productId + '-');
	$('#product_autocomplete_input').val('');
	$('#product_autocomplete_input').setOptions({
		extraParams: {excludeIds : ybcGetAccessoriesIds()}
	});
};

function ybcDelAccessory(id)
{
	var div = getE('divAccessories');
	var input = getE('inputAccessories');
	var name = getE('nameAccessories');

	// Cut hidden fields in array
	var inputCut = input.value.split('-');
	var nameCut = name.value.split('¤');

	if (inputCut.length != nameCut.length)
		return jAlert('Bad size');

	// Reset all hidden fields
	input.value = '';
	name.value = '';
	div.innerHTML = '';
	for (i in inputCut)
	{
		// If empty, error, next
		if (!inputCut[i] || !nameCut[i])
			continue ;

		// Add to hidden fields no selected products OR add to select field selected product
		if (inputCut[i] != id)
		{
			input.value += inputCut[i] + '-';
			name.value += nameCut[i] + '¤';
			div.innerHTML += '<div class="form-control-static"><button type="button"  onclick="ybcDelAccessory('+inputCut[i]+');"  class="btn btn-default" name="' + inputCut[i] +'"><i class="icon-remove text-danger"></i></button>&nbsp;' + nameCut[i] + '</div>';
		}
		else
			$('#selectAccessories').append('<option selected="selected" value="' + inputCut[i] + '-' + nameCut[i] + '">' + inputCut[i] + ' - ' + nameCut[i] + '</option>');
	}

	$('#product_autocomplete_input').setOptions({
		extraParams: {excludeIds : ybcGetAccessoriesIds()}
	});
};