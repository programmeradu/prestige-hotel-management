var tokenConf = document.location.href.split("token=");
tokenConf = tokenConf[1].split("#");
tokenConf = tokenConf[0].split("&");
tokenConf = tokenConf[0];
jQuery.extend({
    isEmpty: function () {
        var count = 0;
        $.each(arguments, function (i, data) {
            if (typeof data !== typeof undefined && data !== null && data !== '' && parseInt(data) !== 0) {
                count++;
            }
            else
                return false
        });
        return (arguments).length == count ? false : true;
    }
});
function nuevaFormaPago(){
     var nuevosmetodosPagos = [];
     $.each($('input.nuevoMetodoPago'), function() {
         var id_lang = $(this).attr('name');
         nuevosmetodosPagos[id_lang] = [];
         nuevosmetodosPagos[id_lang].push($(this).val());
        });
    $.getJSON("../modules/tpvtienda/classes/actions/actionsConf.php",{token:tokenConf, action:'nuevaFormaPago',id_lang:$('#id_lang').val(),nombre: $('#nuevaFormaDePagoNombre').val(), factura:$('#nuevaFormaPagoFactura').val(),
        'nuevometodoPago[]': nuevosmetodosPagos, id_shop: id_shop},function(data) {
        if(data == 1){
            updateFormasPago();
        }
    });
}
function updateFormasPago(){
    $('table#formasPago tbody').html('');
    $.getJSON("../modules/tpvtienda/classes/actions/actionsConf.php",{token:tokenConf, action:'updateFormasPago',id_lang:$('#id_lang').val(), id_currency: id_currency,id_employee: id_employee, id_shop: id_shop},function(data) {
        $i = 0;
        var html = "";
        $.each(data, function(index, result) {

             html += '<tr id="formaPago_'+result.id_order_state+'" class="'+(($i++ % 2 == 0) ? 'alt_row ':'')+(result.activo ? 'enabled' : 'disabled')+'">'+
             					'<td class="center"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><input type="checkbox" class="check" onclick="dameOrden()" name="metodosPago['+result.id_order_state+'][activo]" '+(result.activo ? 'checked' :'')+'/></td>'+
             					'<td>'+result.id_order_state+'</td>'+
             					'<td>'+result.orderStateName+'</td>'+
             					'<td class="translatable">';
             					$.each(result.languages, function(index, lang) {
             						 html += '<div class="idioma_'+result.id_order_state+' lang_'+lang.id_lang+' '+(result.activo == false ? 'hide' : '')+'" style=" float: left;">'+lang.img+
             						 	'<input class="ac_input" size="9" type="text" name="metodosPago['+result.id_order_state+'][fPago]['+lang.id_lang+']" value="'+lang.value+'" autocomplete="off"/></div>';
             					});
             	html += '</td>'+
             				  '<td class="facturaSiNo center">';
             	if(result.botonFactura == 1 || result.botonFactura == 0){
                 	html += '<fieldset data-role="controlgroup" data-mini=true data-type="horizontal">'+
                                    '<input type="checkbox" id="onOff_'+result.id_order_state+'" name="metodosPago['+result.id_order_state+'][factura]" '+(result.botonFactura == 1 ? 'checked': '')+'/>'+
                                '</fieldset>';
             	}else{
             		html += '<input type="hidden" name="metodosPago['+result.id_order_state+'][factura]" value="0"/>';
             	}
             	html += '</td>'+
             		          '<td class="row center fees">'+
                                '<input type="text" placeholder="'+fijoTxT+'('+currencySign+')" name="metodosPago['+result.id_order_state+'][fee][fijo]" value="'+result.fee.fijo+'">'+
                                '<input type="text" placeholder="'+variableTxT+'(%)" name="metodosPago['+result.id_order_state+'][fee][perc]" value="'+result.fee.variable+'">'+
                                '<select data-mini=true name="metodosPago['+result.id_order_state+'][fee][tax]">'+
                                    '<option value="">'+sintasasTxt+'</option>'+result.fee.tasas+
                                '</select>'+
                            '</td>'+
                        '</tr>';
        });
        $('table#formasPago tbody').append(html);
        $("#formasPago .facturaSiNo input[type='checkbox']").flipswitch();
       // $("#formasPago .facturaSiNo input").checkboxradio('refresh');
       //  $("#formasPago .facturaSiNo input[type='radio']").checkboxradio('enable');

        $('table#formasPago tbody' ).sortable({
            stop : function(){
                dameOrden();
            }
        });
            dameOrden();
    });
}
function modificarPreciosCambiados(){
    $.getJSON("../modules/tpvtienda/classes/actions/actionsCambioPrecio.php",{token:tokenConf, action:'modificarPreciosCambiados', id_shop: id_shop,
        id_cat: $('#categorias_cambiar_precio').val(), type: $('#categorias_cambiar_precio_descuento').val(), amount: $('#categorias_cambiar_precio_amount').val(),
        id_lang: $('#id_lang').val()},function(data) {
        if(data != null){
            if(data.error != null){
                mostrarError(data.error);
            }else{
                $.each(data, function(index, result) {
                    if(result.ok == '2'){
                        showSuccessMessage(guardado);
                    }
                    if(typeof result.tam != 'undefined'){
                        showSuccessMessage(generadosTxt+ " "+result.tam+" "+productosTxt);
                    }
                });
            }
        }
    });
}
function generarCodigos(){
    $.getJSON("../modules/tpvtienda/classes/actions/actionsConf.php",{token:tokenConf, action:'generarCodigos', id_shop: id_shop},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(typeof result.pasadas != 'undefined'){
                    showSuccessMessage(generadosTxt+ " "+result.pasadas);
                }
            });
        }
    });
}
function deleteCampoExtra(){
    $('.deleteCampoExtra').on("click", function() {
        if($(this).parent().attr("id") == 'campoExtraSelect')
            $('input[name=campo_extra_cliente_select]').val(0);
        if($(this).parent().attr("id") == 'campoExtra')
            $('input[name=campo_extra_cliente]').val(0);
        if(!$(this).parent().hasClass("campoCustom"))
            $(this).parent().hide();
        else
            $(this).parent().remove();
  	  	$( "input[name=cliente_orden_list]" ).val($("#cliente_orden").sortable("toArray"));
  	  	$( "input[name=direccion_orden_list]" ).val($("#direcciones_orden").sortable("toArray"));
    });
}
function dameOrden(){
    var result = $("#formasPago tbody").sortable('toArray');
    var aux = "";
    var id = "";
    for(var i=0; i<result.length; i++){
        id = result[i].replace("formaPago_","");
        if($("#"+result[i]+' .check').is(':checked')){
            aux += id + '-';
            $("#onOff_"+id).removeClass("hide");
            $("#"+result[i]).removeClass("disabled");
            $(".idioma_"+id).removeClass("hide");
        }else{
            $("#onOff_"+id).addClass("hide");
            $("#"+result[i]).addClass("disabled");
            $(".idioma_"+id).addClass("hide");
        }
    }
    $('#ordenFormasPago').val(aux.substr(0,aux.length-1));
}
function borrarCategoria(id){
    var valores = $("input[name=selectedCategoriasEscondidas]").val();
    $("input[name=selectedCategoriasEscondidas]").val(valores.replace(id+",",""));
}
function mostrarOcultarDescuentosTickets(){
    if($("#tipoDescuentoTicketNinguno").prop('checked')){
        //ninguno
        $(".tipoDescuentoTicketFijo").hide();
        $(".tipoDescuentoTicket").hide();
    }
    if($("#tipoDescuentoTicketFijo").prop('checked')){
        //descuento fijo
        $(".tipoDescuentoTicketFijo").show();
        $(".tipoDescuentoTicket").show();
    }
    if($("#tipoDescuentoTicketVariable").prop('checked')){
        //descuento variable
        $(".tipoDescuentoTicketFijo").hide();
        $(".tipoDescuentoTicket").show();
    }
}
function eligeCampo(tipo){
    if(tipo == 'input'){
//		if($(this).next().val()=='0'){
//			$('.campo_extra_cliente_texto').slideDown('fast');
//		}else
//			$('.campo_extra_cliente_texto').slideUp('fast');

        if($("input[name=campo_extra_cliente]").val() == 0){
            $("input[name=campo_extra_cliente]").val(1);
            $("#campoExtra").show();
        }else{
            $("input[name=campo_extra_cliente]").val(0);
            $("#campoExtra").hide();
        }
    }
    if(tipo == 'select'){
        if($("input[name=campo_extra_cliente_select]").val() == 0){
            $("input[name=campo_extra_cliente_select]").val(1);
            $("#campoExtraSelect").show();
        }else{
            $("input[name=campo_extra_cliente_select]").val(0);
            $("#campoExtraSelect").hide();
        }
    }
    $( "#popupElegirCampo" ).popup('close');
}
function addIdCat(idCat,contenedor){
    $(".catResults").hide();
    if(contenedor == '.contsearchCatCambioPrecio'){
        $("input[name=categorias_cambiar_precio]").val(idCat);
        $(".contCategoriaCambioPrecio").html('<div data-mini="true" id="cat_'+idCat+'" class="ui-mini ui-btnui-btn-icon-left ui-shadow ui-corner-all">'+$(contenedor + " .cat_"+idCat+' .name').text()+'</div>')
    }
    if(contenedor == '.contsearchCat'){
        $("input[name=selectedCategoriasEscondidas]").val($("input[name=selectedCategoriasEscondidas]").val()+idCat+",");
        $(".contCategoriasEscondidas").append('<div data-mini="true" id="cat_'+idCat+'" class="catEscondida ui-mini ui-btn ui-icon-delete ui-btn-icon-left ui-shadow ui-corner-all">'+$(contenedor + " .cat_"+idCat+' .name').text()+'</div>')
    }
}
$(document).ready(function() {
    updateFormasPago();
    reTicketConf();
    $( "#popupElegirCampo" ).popup();
    $("a").not('.ui-mobile-viewport a').each(function(){
        $(this).attr("rel","external");
    });
    $("#header_search").attr("data-ajax",false);
    $('form#imagenLogo').submit(function() {
        $(this).ajaxSubmit({
            target:   '.resultadoSubida',   // target element(s) to be updated with server response
            beforeSubmit:  beforeSubmit(".resultadoSubida"),  // pre-submit callback
            resetForm: true        // reset the form after successful submit
        });  //Ajax Submit form
        // return false to prevent standard browser submit and page navigation
        return false;
    });
    /*$('form#imagenLogoTicket').submit(function() {
        $(this).ajaxSubmit({
            target:   '.imgTicket',   // target element(s) to be updated with server response
            beforeSubmit:  beforeSubmit(".imgTicket"),  // pre-submit callback
            resetForm: true        // reset the form after successful submit
        });  //Ajax Submit form
        // return false to prevent standard browser submit and page navigation
        return false;
    });*/
    $('#submitDeleteImgConf').on("click", function() {
        $.get("../modules/tpvtienda/classes/actions/actionsConf.php",{token:tokenConf, action:'borrarImagenTicket',id_lang:$('#id_lang').val(),
            id_currency: id_currency,id_employee: id_employee, id_shop: id_shop},function(data) {
                $("#cabeceraTicket .logo").remove();
                $("#cabeceraTicket").prepend(data);
        });
    });
    $('#submitUseDefaultLogo').on("click", function() {
        $.get("../modules/tpvtienda/classes/actions/actionsConf.php",{token:tokenConf, action:'defaultTicket',id_lang:$('#id_lang').val(),
            id_currency: id_currency,id_employee: id_employee, id_shop: id_shop},function(data) {
                $("#cabeceraTicket .logo").remove();
                $("#cabeceraTicket").prepend('<div class="logo">'+data+'</h3>');
        });
    });
    $( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );

    $('#formasPago td input:checkbox').on("click", function() {
        if($(this).prop('checked')){
            $(this).parent().parent().removeClass('disabled');
        }else{
            $(this).parent().parent().addClass('disabled');
        }
    });
    $('#transferenciaButton').on("click", function() {
        if($(this).next().val()=='0'){
            $('#datosBancarios').slideDown('fast');
        }else
            $('#datosBancarios').slideUp('fast');
    });
    $('input[name=avisadorPedidos]').on("click", function() {
        if($('input[name=avisadorPedidos]:checked').val()=='1'){
            $('.contAvisadorPedidos').slideDown('fast');
        }else
            $('.contAvisadorPedidos').slideUp('fast');
    });

    $("input[name=elegir_almacen]").on('click', function() {
        if($(this).val() != "0"){
            $(".contContEmpleadosAlmacen").slideDown('fast');
            $(".contEmpleadosAlmacen").slideDown('fast');
        }else{
            $(".contContEmpleadosAlmacen").slideUp('fast');
            $(".contEmpleadosAlmacen").slideUp('fast');
        }
    });
    $("input[name=almacen_predeterminado]").on('click', function() {
        if($(this).val() != "0")
            $(".contEmpleadosAlmacen").slideDown('fast');
        else
            $(".contEmpleadosAlmacen").slideUp('fast');
    });
    $('#codigosdebarrasButton').on("click", function() {
        if($(this).next().val()=='0'){
            $('#codigosDeBarrasCont').slideDown('fast');
        }else
            $('#codigosDeBarrasCont').slideUp('fast');
    });
    $("#cliente_orden li i,#direcciones_orden li i").on("click", function() {
        if($(this).hasClass("fa-eye")){
            $(this).removeClass("fa-eye");
            $(this).addClass("fa-eye-slash");
            $(this).parent().find('input').val(0);
        }else{
            $(this).removeClass("fa-eye-slash");
            $(this).addClass("fa-eye");
            $(this).parent().find('input').val(1);
        }
    });
    $('#anadirCampoExtraCliente').on("click", function() {
        var id = $( this).attr("id");
        var tipo = id.split("_")[2];
    	var idReplace = id.split("_")[1];
   		$( "#popupElegirCampo").popup( "open", {
   			x: $(this).offset().left + ($(this).outerWidth()/2),
   			y: $("#"+id).offset().top,
   			changeHash : false
   		});
    });
    $('#anadirCampoExtraClienteIntegrado').on("click", function() {
        var chars = "123456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
        var codigo = "";
        for (var i = 1; i <= 15; ++i)
                codigo += chars.charAt(Math.floor(Math.random() * chars.length));
        $("#cliente_orden").append('<li class="ui-state-default campoCustom" id="campo'+codigo+'">'+
                                        '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'+
                                        '<input type="text" name="campoLabel[]" class="campoLabel" data-role="none" placeholder="'+textoLabelCampoCustom+'">'+
                                        '<input type="text" name="campoValue[]" class="campoValue" data-role="none" placeholder="'+textoValueCampoCustom+'">'+
                                        '<input type="hidden" name="campoIDRand[]" value="campo'+codigo+'">'+
                                        '<div class="deleteCampoExtra"></div></li>');
        var htmlCustomCliente = "";
        $.each($("#cliente_orden li.campoCustom"),function(index,valor){
            htmlCustomCliente += $(this).children('.campoLabel').val()+'-'+$(this).children('.campoValue').val()+',';
        });
        $('#campo_extra_cliente_custom').html(htmlCustomCliente);
        //actualizo lista de campos en cliente
  	  	$( "input[name=cliente_orden_list]" ).val($("#cliente_orden").sortable("toArray"));
  	  deleteCampoExtra();
    });
    $('#anadirCampoExtraDireccionIntegrado').on("click", function() {
        var chars = "123456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
        var codigo = "";
        for (var i = 1; i <= 15; ++i)
                codigo += chars.charAt(Math.floor(Math.random() * chars.length));
        $("#direcciones_orden").append('<li class="ui-state-default campoCustom" id="campo'+codigo+'">'+
                                        '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'+
                                        '<input type="text" name="campoLabelDireccion[]" class="campoLabel" data-role="none" placeholder="'+textoLabelCampoCustom+'">'+
                                        '<input type="text" name="campoValueDireccion[]" class="campoValue" data-role="none" placeholder="'+textoValueCampoCustom+'">'+
                                        '<input type="hidden" name="campoIDRandDireccion[]" value="campo'+codigo+'">'+
                                        '<div class="deleteCampoExtra"></div></li>');
        var htmlCustomCliente = "";
        $.each($("#direcciones_orden li.campoCustom"),function(index,valor){
            htmlCustomCliente += $(this).children('.campoLabel').val()+'-'+$(this).children('.campoValue').val()+',';
        });
        $('#campo_extra_direccion_custom').html(htmlCustomCliente);
        //actualizo lista de campos en direccion
  	  	$( "input[name=direccion_orden_list]" ).val($("#direcciones_orden").sortable("toArray"));
  	  	deleteCampoExtra();
    });

    $("#imagenLogoTicket").dropzone({
        init: function () {
            this.on("dragenter", function(event) {
               	$('#dragging').show();
            });
            this.on("addedfile", function(event) {
               	$('#dragging').hide();
            });
        },
        thumbnailWidth:80,
        thumbnailHeight:80,
        dictRemoveFile:borrar,
        addRemoveLinks:true,
        url: "../modules/tpvtienda/classes/actions/actionsConf.php?action=uploadImageTicket&token="+tokenConf+"&id_shop="+id_shop,
        success: function(file, data) {
        	$("#imagenLogoTicket").addClass("dropzone");
        	$("#cabeceraTicket .logo").remove();
        	$("#cabeceraTicket").prepend('<div class="logo" style="margin-bottom:10px;text-align: center;">'+data+'</div>');

        }
    });
    $('input[name=mostrarPrecios]').on("change", function() {
        if($(this).next().val()=='0'){
            $('#mostrar_precio_iva').slideDown('fast');
        }else
            $('#mostrar_precio_iva').slideUp('fast');
    });
    $('#translations_id_lang').on("change", function(e) {
        var iso_code = $(e.currentTarget).val();
        $.getJSON("../modules/tpvtienda/classes/actions/actionsConf.php",{token:tokenConf, action:'getTranslations',iso_code:iso_code},function(data) {
            if (Object.keys(data).length > 0) {
                var keysTraducir = Object.keys(data);
                for(i = 0; i < keysTraducir.length; i++){
                    var keysFrase = Object.keys(data[keysTraducir[i]]);
                    for(j = 0; j < keysFrase.length; j++){
                    	var key = keysFrase[j];
                    	var value = data[keysTraducir[i]][key]['lang_selected'];
                    	var $content_inputs = $('.content_translations[data-file="'+keysTraducir[i]+'"]').find('table tr td.input_content_translation');
                        var $input = $content_inputs.find('input[name="'+key+'"][type="text"]').attr('value', value);
                        if ($.isEmpty(value)) {
                            $input.addClass('input-error-translate');
                        } else {
                            if ($input.hasClass('input-error-translate')) {
                               $input.removeClass('input-error-translate');
                            }
                        }
                    }
                }
            } else {
                $('.content_translations').find('table tr td.input_content_translation input[type="text"]').attr('value', '').addClass('input-error-translate');
            }
    	});
    });
    $("#btn-save-translation").on("click", function(e){
        var array_data = {};
        var $elements_key_translations = $('#content_translations div.content_translations');
        $.each($elements_key_translations, function(i, element){
            var file_translation = $(element).attr('data-file');
            array_data[file_translation] = [];
        });

        var $data_elements = $('#content_translations div.content_text-translation table tr');
        $.each($data_elements, function(i, element){
            var file_translation = $(element).find('input[type="hidden"]').val();
            var key_translation = $(element).find('input[type!="hidden"]').attr('name');
            var value_translation = $(element).find('input[type!="hidden"]').val();

            var object = {key_translation: key_translation, value_translation: value_translation};
            array_data[file_translation].push(object);

        });
        var lang = $('select#translations_id_lang').val();
        $.post("../modules/tpvtienda/classes/actions/actionsConf.php",{token:tokenConf, action:'saveTranslations',lang: lang,array_translation: array_data},function(data) {
        	if(data != null){
        		$.each(JSON.parse(data),function(index,result){
        			if(result.ok == 1){
    					$('.notificationGood').fadeIn();
    					$('.notificationGood').delay(1000).fadeOut();
        			}
        		});
        	}
        });

    });
    $('#tarjetaCreditoButton').on("click", function() {
        if($(this).next().val()=='0'){
            $('#datosBancarios').slideDown('fast');
        }else
            $('#datosBancarios').slideUp('fast');
    });
    $("input[name=permiso_caja]").on("change", function() {
        if($(this).val() == 1){
            $(".cajas-emp-list").show();
            $(".cajas-list").hide();
            $(".anadirCaja_emp").show();
            $(".anadirCaja_tienda").hide();
        }else{
            $(".cajas-emp-list").hide();
            $(".cajas-list").show();
            $(".anadirCaja_emp").hide();
            $(".anadirCaja_tienda").show();
        }
    });
    $("select[name=num_ticket]").on("change",function(){
        var valor = $(this).val();
        if(valor == 2){
            $("#numeracionTickets .num_ticket_3").hide();
            $("#numeracionTickets .num_ticket_0").hide();
        }
        if(valor == 3){
            $("#numeracionTickets .num_ticket_3").show();
            $("#numeracionTickets .num_ticket_1").hide();
        }
        if(valor == 1){
            $("#numeracionTickets .num_ticket_3").hide();
            $("#numeracionTickets .num_ticket_1").show();
        }
    });
    $("#tipoDescuentoTicketNinguno").on("change", function(event){
        mostrarOcultarDescuentosTickets();
    });
    $("#tipoDescuentoTicketFijo").on("change", function(event){
        mostrarOcultarDescuentosTickets();
    });
    $("#tipoDescuentoTicketVariable").on("change", function(event){
        mostrarOcultarDescuentosTickets();
    });
    mostrarOcultarDescuentosTickets();
    $(".nombreCaja").on("keyup", function(){
        $("input[name='"+$(this).attr('name')+"']").val($(this).val());
    });

    $(".searchCatCambioPrecio").on("keyup", function(event){
        var idSearchCat = $(this).attr("class");
        $(".contsearchCatCambioPrecio .catResults").html("");
        $(".contsearchCatCambioPrecio .catResults").show();
        searchCat(idSearchCat,'.contsearchCatCambioPrecio');
    });
    $(".searchCat").on("keyup", function(event){
        var idSearchCat = $(this).attr("class");
        $(".catResults").html("");
        $(".catResults").show();
        searchCat(idSearchCat,'.contsearchCat');
    });
    $(".catEscondida").on("click", function(event){
        var idCat = $(this).attr("id");
        var valor = idCat.replace("cat_","");
        if(valor != ""){
            borrarCategoria(valor);
            $(this).remove();
        }
    });
    $(".anadirCaja_tienda").on("click", function(event){
        var sizeCajas = $(".cajas-list input.nombreCaja").size();
        var nameCaja = $(".cajas-list input.nombreCaja").eq(-1).attr("name");
        if(sizeCajas >= 1){ //hay cajas
            $(".cajas-list").prepend('<div class="row cajaTienda">'+$(".cajas-list .cajaTienda:last").html()+'</div>');
            nameCaja = nameCaja.split('[');
            var SigCaja= sizeCajas + parseInt(nameCaja[1].substr(0, nameCaja[1].length-1));
            nameCaja = 'cajas[' + SigCaja + '][' + nameCaja[2];
            $(".cajas-list .cajaTienda:first").find("input[type=text]").attr("name",nameCaja);
            $(".cajas-list .cajaTienda:first input[type=text]").val("");
            $(".cajas-list .cajaTienda:first .ui-select a").remove();
            $(".cajas-list .cajaTienda:first .ui-select select").attr("id",'cajas[' + SigCaja + '][s][]');
            $(".cajas-list .cajaTienda:first .ui-select select").attr("name",'cajas[' + SigCaja + '][s][]');
            $(".cajas-list .cajaTienda:first .ui-select > div").remove();
            $(".cajas-list .cajaTienda:first select").selectmenu();
            $(".cajas-list .cajaTienda:first select").selectmenu('refresh');
            $(".cajas-list .cajaTienda:first .quitarCaja").attr("id",'quitar_' + SigCaja);

        }else{// no hay cajas por tanto inserto la primera
            $(".cajas-list").prepend('<div class="row cajaTienda"><div class="twocol"><input type="text" name="cajas[1][n]" data-role="none" class="nombreCaja" value=""/>'+
                '</div><button id="quitar_1" class="quitarCaja onecol last"><i class="icon-trash"></i></button><div class="ninecol"></div></div>');
        }
        event.preventDefault();
    });
    $(".anadirCaja_emp").on("click", function(event){
        var sizeCajas = $(".cajas-emp-list input.nombreCaja").size();
        var nameCaja = $(".cajas-emp-list input.nombreCaja").attr("name");
        if(sizeCajas >= 1){ //hay cajas
  			$(".cajas-emp-list").prepend('<div class="row cajaTienda">'+$(".cajas-emp-list .cajaTienda:last").html()+'</div>');
    		nameCaja = nameCaja.split('[');
            var SigCaja= sizeCajas + parseInt(nameCaja[1].substr(0, nameCaja[1].length-1));
            nameCaja = 'cajas[' + SigCaja + '][' + nameCaja[2];
            $(".cajas-emp-list .cajaTienda:first").find("input[type=text]").attr("name",nameCaja);
            $(".cajas-emp-list .cajaTienda:first input[type=text]").val("");
            $(".cajas-emp-list .cajaTienda:first .ui-select a").remove();
            $(".cajas-emp-list .cajaTienda:first .ui-select select").attr("id",'cajas[' + SigCaja + '][e][]');
            $(".cajas-emp-list .cajaTienda:first .ui-select select").attr("name",'cajas[' + SigCaja + '][e][]');
            $(".cajas-emp-list .cajaTienda:first .ui-select > div").remove();
            $(".cajas-emp-list .cajaTienda:first select").selectmenu();
            $(".cajas-emp-list .cajaTienda:first select").selectmenu('refresh');
            $(".cajas-emp-list .cajaTienda:first .quitarCaja").attr("id",'quitar_' + SigCaja);
        }else{// no hay cajas por tanto inserto la primera
            $(".cajas-emp-list").prepend('<div class="row cajaTienda"><div class="twocol"><input type="text" name="cajas[1][n]" data-role="none" class="nombreCaja" value=""/>'+
                '</div><button id="quitar_1" class="quitarCaja onecol last"><i class="icon-trash"></i></button><div class="ninecol"></div></div>');
        }
        event.preventDefault();
    });
  $(".quitarCaja").on("click", function(event){
        if($(".cajaTienda").length > 2){
            var idCaja = $(this).data("caja");
            $("#quitar_emp_"+idCaja).parent().parent().remove();
            $("#quitar_tienda_"+idCaja).parent().parent().remove();
        }
        event.preventDefault();
    });
    $("#dateStartDescuento").datepicker({
        dateFormat : 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        beforeShow: function() {
            setTimeout(function(){
                $('.ui-datepicker').css('z-index', 2);
            }, 0);
        },

        onSelect: function( selectedDate ) {
        	var date2 = $("#dateStartDescuento").datepicker('getDate');
            date2.setDate(date2.getDate());
            $("#dateEndDescuento").datepicker('option', 'minDate', date2);
        	//$("#hastaFecha").val(selectedDate);
        }
    });
    $("#dateEndDescuento").datepicker({
        dateFormat : 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        beforeShow: function() {
            setTimeout(function(){
                $('.ui-datepicker').css('z-index', 2);
            }, 0);
        },

        onSelect: function( selectedDate ) {
        	var date2 = $("#dateStartDescuento").datepicker('getDate');
            date2.setDate(date2.getDate());
            $("#dateEndDescuento").datepicker('option', 'minDate', date2);
        	//$("#hastaFecha").val(selectedDate);
        }
    });
    $( "#cliente_orden" ).sortable({
      start: function( event, ui ) {
    	  $( "input[name=cliente_orden_list]" ).val($("#cliente_orden").sortable("toArray"));
      },
      stop: function( event, ui ) {
    	  $( "input[name=cliente_orden_list]" ).val($("#cliente_orden").sortable("toArray"));
      },
      change: function(){
    	  $( "input[name=cliente_orden_list]" ).val($("#cliente_orden").sortable("toArray"));
      }
    });
    $( "#direcciones_orden" ).sortable({
          start: function( event, ui ) {
        	  $( "input[name=direccion_orden_list]" ).val($("#direcciones_orden").sortable("toArray"));
          },
          stop: function( event, ui ) {
        	  $( "input[name=direccion_orden_list]" ).val($("#direcciones_orden").sortable("toArray"));
          },
          change: function(){
        	  $( "input[name=direccion_orden_list]" ).val($("#direcciones_orden").sortable("toArray"));
          }
        });
    $( "input[name=cliente_orden_list]" ).val($("#cliente_orden").sortable("toArray"));
    $( "input[name=direccion_orden_list]" ).val($("#direcciones_orden").sortable("toArray"));
    $( "#cliente_orden" ).disableSelection();
    $( "#direcciones_orden" ).disableSelection();
    deleteCampoExtra();
    init_ticket_live();
    $("#tabs-2 input").click(function(){
            control_errores_ticket_live ();
    });
    if($(".ticketnormal").width() > 100){
        $(".logostickets").css({
            "width" : $(".ticketnormal").width()
        });
    }
         //  <input type="hidden" name="action" value="uploadImageTarjeta">
//                            <input type="hidden" name="id_shop" value="'.$this->context->shop->id.'">
//                            <input type="hidden" name="token" value="'.Tools::getAdminTokenLite('AdminTPVTienda',$this->context).'">
    $("#imagenTarjeta").dropzone({
        init: function () {
    		this.on("dragenter", function(event) {
    		   	$('#dragging').show();
    		});
    		this.on("addedfile", function(event) {
    		   	$('#dragging').hide();
    		});
    	},
    	thumbnailWidth:80,
    	thumbnailHeight:80,
    	dictRemoveFile:borrar,
    	addRemoveLinks:true,
    	url: "../modules/tpvtienda/classes/actions/actionsConf.php?action=uploadImageTarjeta&id_shop="+id_shop+"&token="+tokenConf,
    	   success: function(file, data) {
    	   	$("#imagenTarjeta").addClass("dropzone");
    	   	$("#backgroundTarjeta").html(data+'<a class="dz-remove" href="javascript:undefined;" onclick="borrarImgTarjeta()" data-dz-remove="">'+borrar+'</a>');
    	}
    });
// cambio live de tamaño fuente y familia de fuente
    $("#selecttamaño").change(function(){
        tamañoseleccionado= $("#selecttamaño option:selected").val();
        $(".totalesTicket span, .tax_0 span, .totalIvaTicket span, .fctTicket div, .dateTicket, .ticket, .ticket p, .ticket .fctTicket, .fact_simpl, .ticket strong, .ticket tr td").attr("style", "font-size:" + tamañoseleccionado + "px !important");
    });
    $("#selectfuente").change(function(){
        fuenteseleccionada= $("#selectfuente option:selected").val();
        $(".totalesTicket span, .tax_0 span, .totalIvaTicket span, .fctTicket div, .dateTicket, .ticket, .ticket p, .ticket .fctTicket, .fact_simpl, .ticket strong, .ticket tr td").attr("style", "font-family:" + fuenteseleccionada + " !important");
    });
//	Hover para botones del logo
    $(".capalogoshover").mouseenter(function() {
        $(".logostickets").css({
            "width" : $(".ticketnormal").width()
        });
        $(".logostickets").fadeIn();
    });
    $(".capalogoshover").mouseleave(function() {
        $(".logostickets").fadeOut()
    });

// Actualizar textos input del ticket in live
    $("input#tituloticket").on("keyup", function(){
        $(".tituloTicket").html($(this).val());
    });
    $("#ticket_text").on("keyup" ,function(){
        $(".textoinferiorticket").html($(this).val());
    });

//Descuento próxima compra ficticio
    $(".descuentoproxcompra").on("keyup",function(){
        descuentoproxcompra();
    });

//Descuento  en precio de producto y producto final ficticio
    $("input#precio_con_descuentossi , input#precio_con_descuentosno").click(function(){
        if($("#precio_con_descuentos_boton :radio:checked").val() == 1 ){
            $(".totalTicket span").html(500.00 - 3.24 + " €");
            $("tbody .columnaPrecioProd").html(500.00 - 3.24);
        }else{
            $(".totalTicket span").html("500.00 €");
            $("tbody .columnaPrecioProd").html("500.00");
        }
     });
    $("input#bizumsi , input#bizumno").click(function(){
        if($("input[name=bizum]:radio:checked").val() == 1 ){
            $(".contBizum").show();
        }else{
            $(".contBizum").hide();
        }
     });
//Actualización inlive de string de factura
      $("#numertickets").change(function(){
          opcionseleccionada= $("#numertickets option:selected").val();
            if(opcionseleccionada == 0) {
                $(".fctLabel").html( $("input[name='prefixTickets']").val() + " ");
                $(".fact_simpl span").html("00000380");
                $(".num_ticket_0").show();$(".num_ticket_1").hide();
            }
            if(opcionseleccionada == 1) {
                $(".fact_simpl span").html( $("input[name='num_cont_manual']").val() ).css("margin-left","5px");
                $(".fact_simpl .fctLabel").html( $("input[name='prefixTickets']").val() + " ").css("display","inline-block"); $(".num_ticket_0").show();
                $(".num_ticket_1").show();
            }
            if(opcionseleccionada == 3) {
                $(".fact_simpl span").html( $("input[name='num_cont']").val() ).css("margin-left","5px");
                $(".fact_simpl .fctLabel").html( $("input[name='prefixTickets']").val() + " ").css("display","inline-block");
                $(".num_ticket_0").show();$(".num_ticket_2").show();
            }
            if(opcionseleccionada == 2) {
                $(".fact_simpl span").html( "000370" ).css("margin-left","0px");
            	$(".fact_simpl .fctLabel").html( $("input[name='prefixTickets']").val() + " ").hide();
                $(".num_ticket_0").hide();$(".num_ticket_1").hide();
            }
      });
      $("input[name='prefixTickets']").keyup(function(){
          $(".fact_simpl .fctLabel").html($(this).val());
      });
      $("input[name='num_cont']").keyup(function(){
          $(".fact_simpl span").html($(this).val());
      });
      $("input[name='num_cont_manual']").keyup(function(){
          $(".fact_simpl span").html($(this).val());
      });

//	  control_ticket_live();
    $("input#datos_en_ticketsi, input#datos_en_ticketno").click(function(){ mostrar_ocultar_capas_inlive("#datos_en_ticket", ".datosCliente");});
    $("input#datos_en_ticket_tlfsi , input#datos_en_ticket_tlfno, input#datos_en_ticketsi, input#datos_en_ticketno").click(function(){ mostrar_ocultar_capas_inlive("#datos_en_ticket_tlf", ".datosCliente .contTel"); });
    $("input#datos_en_ticket_emailsi , input#datos_en_ticket_emailno, input#datos_en_ticketsi, input#datos_en_ticketno").click(function(){ mostrar_ocultar_capas_inlive("#datos_en_ticket_email", ".datosCliente .contEmailTicket");});
    $("input#datos_en_ticket_comentariosi , input#datos_en_ticket_comentariono, input#datos_en_ticketsi, input#datos_en_ticketno").click(function(){ mostrar_ocultar_capas_inlive("#datos_en_ticket_comentario", ".datosCliente .contComentarioTicket"); });
    $("input#envio_en_ticketsi , input#envio_en_ticketno, input#datos_en_ticketsi, input#datos_en_ticketno").click(function(){ mostrar_ocultar_capas_inlive("#envio_en_ticket", ".datosCliente .contDireccionEnvioTicket"); });
    $("input#datos_empresa_en_ticketsi , input#datos_empresa_en_ticketno, input#datos_en_ticketsi, input#datos_en_ticketno").click(function(){ mostrar_ocultar_capas_inlive("#datos_empresa_en_ticket", ".datosCliente .contDireccionEmpresa"); });
    $("input#extra_datos_en_ticketsi , input#extra_datos_en_ticketno, input#datos_en_ticketsi, input#datos_en_ticketno").click(function(){ mostrar_ocultar_capas_inlive("#extra_datos_en_ticket", ".datosCliente .contExtraCliente"); });
    $("input#descuentos_en_ticketsi , input#descuentos_en_ticketno").click(function(){ mostrar_ocultar_capas_inlive("#descuentos_en_ticket", ".productosTicket .columnaDescuentos"); });
    $("input#columna_precio_unidadsi , input#columna_precio_unidadno").click(function(){ mostrar_ocultar_capas_inlive("#columna_precio_unidad", ".productosTicket .columnaPrecioUnidad"); });
    $("input#columna_precio_originalsi , input#columna_precio_originalno").click(function(){ mostrar_ocultar_capas_inlive("#columna_precio_original", ".productosTicket .columnaPrecioOriginal"); });
    $("input#columna_unitaria_en_ticketsi , input#columna_unitaria_en_ticketno").click(function(){ mostrar_ocultar_capas_inlive("#columna_unitaria_en_ticket", ".productosTicket .columnaUnit"); });
    $("input#columna_grupo_clientesi , input#columna_grupo_clienteno").click(function(){ mostrar_ocultar_capas_inlive("#columna_grupo_cliente", ".productosTicket .columnaDescuentosGroup"); });
    $("input#le_atendiosi , input#le_atendiono").click(function(){ mostrar_ocultar_capas_inlive("#le_atendio", ".leAtendioTicket"); });
    $("input#ref_pedido_en_ticketsi , input#ref_pedido_en_ticketno").click(function(){ mostrar_ocultar_capas_inlive("#ref_pedido_en_ticket", ".contRefPedido"); });
    $("input#ref_en_ticketsi , input#ref_en_ticketno").click(function(){ mostrar_ocultar_capas_inlive("#ref_en_ticket", ".refticketprod"); });
    $("input#mostrar_forma_pagosi , input#mostrar_forma_pagono").click(function(){ mostrar_ocultar_capas_inlive("#mostrar_forma_pago", ".contFormaPago"); });
    $("input#attr_en_ticketsi , input#attr_en_ticketno").click(function(){ mostrar_ocultar_capas_inlive("#attr_en_ticket", ".columnaNombreArticulo strong"); });
    $("input#direccion_en_ticketsi , input#direccion_en_ticketno").click(function(){ mostrar_ocultar_capas_inlive("#direccion_en_ticket", "#cabeceraTicket .direccionTicket"); });
    $("input#puntos_en_ticketsi , input#puntos_en_ticketno").click(function(){ mostrar_ocultar_capas_inlive("#puntos_en_ticket", ".totalesTicket .puntosContent"); });
    $("input#direccion_websi , input#direccion_webno").click(function(){ mostrar_ocultar_capas_inlive("#direccion_web", ".direccionWeb"); });
    $("input#numeracion_producto_en_ticketsi , input#numeracion_producto_en_ticketno").click(function(){ mostrar_ocultar_capas_inlive("#numeracion_producto_en_ticket", ".columnaNumeracionProducto"); });
    $("input#codBarTicketsi , input#codBarTicketno").click(function(){ mostrar_ocultar_capas_inlive("#codBarTicket", ".codBarTicketRef"); });
    $("input#impuestos_producto_en_ticketsi , input#impuestos_producto_en_ticketno").click(function(){ mostrar_ocultar_capas_inlive("#impuestos_producto_en_ticket", ".impuestoficticio"); });
    $("input#totalDescuentossi , input#totalDescuentosno").click(function(){ mostrar_ocultar_capas_inlive("#totalDescuentos", ".contDescuentos"); });
});

//MODIFICACIONES ALFREDO
$( function() {
    $( "a.sinlink" ).tooltip();
  } );


//FUNCIÓN PARA HACER EL TICKET FIXED SEGÚN EL SCROLL DE LA PÁGINA
window.onscroll = fixedticketscroll; //cuando hacemos scroll llamamos a la función

function fixedticketscroll(){
      //coge el valor del scroll en pixeles
        var sc = window.pageYOffset;

        if(sc > 20){ //si racemes scroll más de 100 pixeles
           //si el header no tiene la clase fixed:
           if(!$('.thumbticket').hasClass('fixed')){
                if( $(".ticketwrapper").width() > 100){
                	$(".thumbticket").css({
                		"width" : $(".ticketwrapper").width()
                	});
                }
                $('.thumbticket').addClass('fixed'); // le ponemos fixed

           }
        }else if($('.thumbticket').hasClass('fixed') || sc < 100){
           $('.thumbticket').removeClass('fixed'); // se lo sacamos
        }

}

//MOSTRAR DINÁMICAMENTE LOS ELEMENTOS DEL TICKET

//PRECOMPONER TICKET AL CARGAR
function init_ticket_live (){
    if( datos_en_ticket_JQuery == 1 ){
        $("#ticket .datosCliente").addClass("mostrarenticket");
        $("#ticket .datosCliente .contDNI").addClass("mostrarenticket");
        $("#ticket .datosCliente .contDireccionTicket").addClass("mostrarenticket");
    }
    if( datos_en_ticket_tlf_JQuery == 1 ){ $("#ticket .datosCliente .contTel").addClass("mostrarenticket");
        if(datos_en_ticket_JQuery == 0){
            $(".alertdatosclientestfno").css("display", "inline-block");
            $("label[for='datos_en_ticket_tlfsi']").addClass("faltaconfig");
            $("label[for='datos_en_ticket_tlfno']").removeClass("faltaconfig");
        }else{
            $(".alertdatosclientestfno").css("display", "none");
            $("label[for='datos_en_ticket_tlfsi']").removeClass("faltaconfig");
        }
    }
    if( totalDescuentos_JQuery == 1 ){
        $("#ticket .contDescuentos").show();
    }else{
        $("#ticket .contDescuentos").hide();
    }
    if( datos_en_ticket_email_JQuery == 1 ){$("#ticket .datosCliente .contEmailTicket").addClass("mostrarenticket");}
    if( datos_en_ticket_comentario_JQuery == 1 ){$("#ticket .datosCliente .contComentarioTicket").addClass("mostrarenticket");}
    if( extra_datos_en_ticket_JQuery == 1 ){ $("#ticket .datosCliente .contExtraCliente").addClass("mostrarenticket");}
    if( tipoDescuento_JQuery == 1 ){
        $("#ticket .codBarTicket").hide();
    }
    if( tipoDescuento_JQuery == 1 ){
        $("#ticket .codBarTicket").show();
        descuentoproxcompra ();
    }
    if( tipoDescuento_JQuery == 2 ){
        $("#ticket .codBarTicket").show();
        descuentoproxcompra ();
    }
    if( envio_en_ticket_JQuery == 1 ){$("#ticket .datosCliente .contDireccionEnvioTicket").addClass("mostrarenticket");}
    if( datos_empresa_en_ticket_JQuery == 1 ){$("#ticket .datosCliente .contDireccionEmpresa").addClass("mostrarenticket");}
//	if( mostrar_ticket_online_JQuery == 1 ){}
//	if( mostrar_ticket_JQuery == 1 ){}
//	if( autoprint_ticket_JQuery == 1 ){}
    if( descuentos_en_ticket_JQuery == 1 )
        $("#ticket .productosTicket .columnaDescuentos").show();
    else
        $("#ticket .productosTicket .columnaDescuentos").hide();

    if( columna_precio_unidad_JQuery == 1 )
        $("#ticket .productosTicket .columnaPrecioUnidad").show();
    else
        $("#ticket .productosTicket .columnaPrecioUnidad").hide();
    if( columna_precio_original_JQuery == 1 )
        $("#ticket .productosTicket .columnaPrecioOriginal").show();
    else
        $("#ticket .productosTicket .columnaPrecioOriginal").hide();
    if( columna_unitaria_en_ticket_JQuery == 1 )
        $("#ticket .productosTicket .columnaUnit").show();
    else
        $("#ticket .productosTicket .columnaUnit").hide();
    if( columna_grupo_cliente_JQuery == 1 )
        $("#ticket .productosTicket .columnaDescuentosGroup").show();
    else
        $("#ticket .productosTicket .columnaDescuentosGroup").hide();
//	if( descuentos_en_ticket_regalo_JQuery == 1 ){}
    if( precio_con_descuentos_JQuery == 1 ){
        $(".totalTicket span").html(500.00 - 3.24 + " €");
        $("tbody .columnaPrecioProd").html(500.00 - 3.24);

    }
    if( le_atendio_JQuery == 1 ){$("#ticket .leAtendioTicket").addClass("mostrarenticket");}
    if( ref_en_ticket_JQuery == 1 ){}
    if( ref_en_ticket_JQuery === "" || ref_en_ticket_JQuery == 1 ){
        $("#ticket .refticketprod").show();
    }else{
        $("#ticket .refticketprod").hide();
    }
    if( mostrar_forma_pago_JQuery === "" || mostrar_forma_pago_JQuery == 1 ){
        $("#ticket .contFormaPago").show();
    }else{
        $("#ticket .contFormaPago").hide();
    }
    if( ref_en_pedido_ticket_JQuery === "" || ref_en_pedido_ticket_JQuery == 1 ){
        $("#ticket .contRefPedido").show();
    }else{
        $("#ticket .contRefPedido").hide();
    }
    if( attr_en_ticket_JQuery === "" || attr_en_ticket_JQuery === 1 ){
        $("#ticket .columnaNombreArticulo strong").show();
    }else{
        $("#ticket .columnaNombreArticulo strong").hide();
    }
    if( direccion_en_ticket_JQuery == 1 ){
        $("#ticket #cabeceraTicket .direccionTicket").show();
    }else{
        $("#ticket #cabeceraTicket .direccionTicket").hide();
    }
    if( puntos_en_ticket_JQuery == 1 ){$("#ticket .totalesTicket .puntosContent").addClass("mostrarenticket");}
    if( direccion_web_JQuery == 1 )
        $("#ticket .direccionWeb").addClass("mostrarenticket");
    else
         $("#ticket .direccionWeb").hide();
    if( impuestos_producto_en_ticket_JQuery == 1 ){$("#ticket .impuestoficticio").addClass("mostrarenticket");}
    if( numeracion_producto_en_ticket_JQuery == 1 ){
        $("#ticket .columnaNumeracionProducto").show();
    }else{
        $("#ticket .columnaNumeracionProducto").hide();
    }
    if( codBarTicket_JQuery == 1 ){$("#ticket .codBarTicketRef").show();}
    switch(num_ticket_JQuery) {
        case 0:
        	$(".fctLabel").html( $("input[name='prefixTickets']").val() + " ");
            $(".fact_simpl span").html("00000380");
        	break;
        case 1:
        	$(".fact_simpl span").html( $("input[name='num_cont']").val() ).css("margin-left","5px");
        	$(".fact_simpl .fctLabel").html( $("input[name='prefixTickets']").val() + " ").css("display","inline-block");
            break;
        case 2:
        	$(".fact_simpl span").html( "000370" ).css("margin-left","0px");
        	$(".fact_simpl .fctLabel").html( $("input[name='prefixTickets']").val() + " ").hide();
        	break;
        case 3:
        	$(".fact_simpl span").html( $("input[name='num_cont']").val() ).css("margin-left","5px");
        	$(".fact_simpl .fctLabel").html( $("input[name='prefixTickets']").val() + " ").css("display","inline-block");
            break;
        default:
    }

//AGREGAMOS AL CARGAR LOS POSIBLES ERRORES DE CONFIGURACIÓN QUE HAYA
    if( (datos_en_ticket_tlf_JQuery || datos_en_ticket_email_JQuery || datos_en_ticket_comentario_JQuery || extra_datos_en_ticket_JQuery || envio_en_ticket_JQuery || datos_empresa_en_ticket_JQuery) == 1 && (datos_en_ticket_JQuery) == 0 ){
        if(datos_en_ticket_tlf_JQuery == 1){
            $(".alertdatosclientestfno").css("display","inline-block");
            $("label[for='datos_en_ticket_tlfsi']").addClass("faltaconfig");
            $("label[for='datos_en_ticket_tlfno']").removeClass("faltaconfig");
        }
        if(datos_en_ticket_email_JQuery == 1){
            $(".alertdatosclientesemail").css("display","inline-block");
            $("label[for='datos_en_ticket_emailsi']").addClass("faltaconfig");
            $("label[for='datos_en_ticket_emailno']").removeClass("faltaconfig");
        }
        if(datos_en_ticket_comentario_JQuery == 1){
            $(".alertdatosclientescomentarios").css("display","inline-block");
            $("label[for='datos_en_ticket_comentariosi']").addClass("faltaconfig");
            $("label[for='datos_en_ticket_comentariono']").removeClass("faltaconfig");
        }
        if(extra_datos_en_ticket_JQuery == 1){
            $(".alertextradatos").css("display","inline-block");
            $("label[for='extra_datos_en_ticketsi']").addClass("faltaconfig");
            $("label[for='extra_datos_en_ticketno']").removeClass("faltaconfig");
        }
        if(envio_en_ticket_JQuery == 1 ){
            $(".alertenvioticket").css("display","inline-block");
            $("label[for='envio_en_ticketsi']").addClass("faltaconfig");
            $("label[for='envio_en_ticketno']").removeClass("faltaconfig");
        }
        if(datos_empresa_en_ticket_JQuery == 1){
            $(".alertdatosempresa").css("display","inline-block");
            $("label[for='datos_empresa_en_ticketsi']").addClass("faltaconfig");
            $("label[for='datos_empresa_en_ticketno']").removeClass("faltaconfig");
        }
    }else{
        if($("input[name='campo_extra_cliente'], input[name='campo_extra_cliente_select']").val() == 0 && extra_datos_en_ticket_JQuery == 1){
            $(".alertextradatos").css("display","inline-block");
            $("label[for='extra_datos_en_ticketsi']").addClass("faltaconfig");
            $("label[for='extra_datos_en_ticketno']").removeClass("faltaconfig");
        }
    }
}

//Descuento próxima compra ficticio
function descuentoproxcompra(){
      if($("#radiodescproxcompra :radio:checked").val() == 0 ){
            $(".ticketpruebaconfig .codBarTicket ").hide("slow");
        }
        if($("#radiodescproxcompra :radio:checked").val() == 1 ){
            var descuentofijo = $("input[name='valorDescuento']").val();
            var eurosoporc = $("select[name='typeDiscount']").val();
            if(eurosoporc == "percentage"){ eurosoporc = "%";}else{eurosoporc = "€"}

            $(".ticketpruebaconfig .textoCodebar ").html("Descuento de " + descuentofijo + eurosoporc +  " para la próxima compra");
            $(".ticketpruebaconfig .codBarTicket ").show("slow");
        }
        if($("#radiodescproxcompra :radio:checked").val() == 2 ){
            var descuentofijo = $("input[name='valorDescuento']").val();
            var eurosoporc = $("select[name='typeDiscount']").val();
            var cantidadminima = $("#minimum_amount").val();
            if(eurosoporc == "percentage"){ eurosoporc = "%";}else{eurosoporc = "€"}

            $(".ticketpruebaconfig .textoCodebar ").html("Descuento de " + descuentofijo + eurosoporc +  " para la próxima compra a partir de " + cantidadminima + "€");
            $(".ticketpruebaconfig .codBarTicket ").show("slow");
        }
}

//MOSTRAR ERORRES DINÁMICAMENTE AL CLICAR EN LOS ON/OFF
function control_errores_ticket_live (){
    if($("input[name='campo_extra_cliente'], input[name='campo_extra_cliente_select']").val() == 1){
        if($("#datos_en_ticket_boton :radio:checked").val() == 1 && $("#extra_datos_en_ticket_boton :radio:checked").val() == 1 ){
            $("label[for='extra_datos_en_ticketsi']").removeClass("faltaconfig");
            $(".alertextradatos").css("display","none");
        }
        if($("#datos_en_ticket_boton :radio:checked").val() == 1 && $("#extra_datos_en_ticket_boton :radio:checked").val() == 0 ){
        }
        if($("#datos_en_ticket_boton :radio:checked").val() == 0 && $("#extra_datos_en_ticket_boton :radio:checked").val() == 1 ){
            $("label[for='extra_datos_en_ticketsi']").addClass("faltaconfig");
            $("label[for='extra_datos_en_ticketno']").removeClass("faltaconfig");
            $(".alertextradatos").css("display","inline-block");
        }
        if($("#datos_en_ticket_boton :radio:checked").val() == 0 && $("#extra_datos_en_ticket_boton :radio:checked").val() == 0 ){
            $("label[for='extra_datos_en_ticketsi']").removeClass("faltaconfig");
            $(".alertextradatos").css("display","none");
        }
    }else{
        if($("#datos_en_ticket_boton :radio:checked").val() == 1 && $("#extra_datos_en_ticket_boton :radio:checked").val() == 1 ){
            $("label[for='extra_datos_en_ticketsi']").addClass("faltaconfig");
            $("label[for='extra_datos_en_ticketno']").removeClass("faltaconfig");
            $(".alertextradatos").css("display","inline-block");
        }
        if($("#datos_en_ticket_boton :radio:checked").val() == 1 && $("#extra_datos_en_ticket_boton :radio:checked").val() == 0 ){
            $("label[for='extra_datos_en_ticketsi']").removeClass("faltaconfig");
            $(".alertextradatos").css("display","none");
        }
        if($("#datos_en_ticket_boton :radio:checked").val() == 0 && $("#extra_datos_en_ticket_boton :radio:checked").val() == 1 ){
            $("label[for='extra_datos_en_ticketsi']").addClass("faltaconfig");
            $("label[for='extra_datos_en_ticketno']").removeClass("faltaconfig");
            $(".alertextradatos").css("display","inline-block");
        }
        if($("#datos_en_ticket_boton :radio:checked").val() == 0 && $("#extra_datos_en_ticket_boton :radio:checked").val() == 0 ){
            $("label[for='extra_datos_en_ticketsi']").removeClass("faltaconfig");
            $(".alertextradatos").css("display","none");
        }
    }

    if($("#datos_en_ticket_boton :radio:checked").val() == 1 ){
        if( $("#datos_en_ticket_tlf_boton :radio:checked").val() == 1 ){
            $(".alertdatosclientestfno").css("display", "none");
            $("label[for='datos_en_ticket_tlfsi").removeClass("faltaconfig");
        }
        if( $("#datos_en_ticket_email_boton :radio:checked").val() == 1 ){
            $(".alertdatosclientesemail").css("display", "none");
            $("label[for='datos_en_ticket_emailsi").removeClass("faltaconfig");
        }
        if( $("#datos_en_ticket_comentario_boton :radio:checked").val() == 1 ){
            $(".alertdatosclientescomentarios").css("display", "none");
            $("label[for='datos_en_ticket_comentariosi").removeClass("faltaconfig");
        }
        if( $("#envio_en_ticket_boton :radio:checked").val() == 1 ){
            $(".alertenvioticket").css("display", "none");
            $("label[for='envio_en_ticketsi").removeClass("faltaconfig");
        }
        if( $("#datos_empresa_en_ticket_boton :radio:checked").val() == 1 ){
            $(".alertdatosempresa").css("display", "none");
            $("label[for='datos_empresa_en_ticketsi").removeClass("faltaconfig");
        }
    }else{
        if( $("#datos_en_ticket_tlf_boton :radio:checked").val() == 1 ){
            $(".alertdatosclientestfno").css("display", "inline-block");
            $("label[for='datos_en_ticket_tlfsi").addClass("faltaconfig");
            $("label[for='datos_en_ticket_tlfno").removeClass("faltaconfig");
        }else{
            $(".alertdatosclientestfno").css("display", "none");
            $("label[for='datos_en_ticket_tlfsi']").removeClass("faltaconfig");
        }
        if( $("#datos_en_ticket_email_boton :radio:checked").val() == 1 ){
            $(".alertdatosclientesemail").css("display", "inline-block");
            $("label[for='datos_en_ticket_emailsi").addClass("faltaconfig");
            $("label[for='datos_en_ticket_emailno").removeClass("faltaconfig");
        }else{
            $(".alertdatosclientesemail").css("display", "none");
            $("label[for='datos_en_ticket_emailsi").removeClass("faltaconfig");
        }
        if( $("#datos_en_ticket_comentario_boton :radio:checked").val() == 1 ){
            $(".alertdatosclientescomentarios").css("display", "inline-block");
            $("label[for='datos_en_ticket_comentariosi").addClass("faltaconfig");
            $("label[for='datos_en_ticket_comentariono").removeClass("faltaconfig");
        }else{
            $(".alertdatosclientescomentarios").css("display", "none");
            $("label[for='datos_en_ticket_comentariosi").removeClass("faltaconfig");
        }
        if( $("#envio_en_ticket_boton :radio:checked").val() == 1 ){
            $(".alertenvioticket").css("display", "inline-block");
            $("label[for='envio_en_ticketsi").addClass("faltaconfig");
            $("label[for='envio_en_ticketno").removeClass("faltaconfig");
        }else{
            $(".alertenvioticket").css("display", "none");
            $("label[for='envio_en_ticketsi").removeClass("faltaconfig");
        }
        if( $("#datos_empresa_en_ticket_boton :radio:checked").val() == 1 ){
            $(".alertdatosempresa").css("display", "inline-block");
            $("label[for='datos_empresa_en_ticketsi").addClass("faltaconfig");
            $("label[for='datos_empresa_en_ticketno").removeClass("faltaconfig");
        }else{
            $(".alertdatosempresa").css("display", "none");
            $("label[for='datos_empresa_en_ticketsi").removeClass("faltaconfig");
        }
    }
}

//MOSTRAR U OCULTAR DINÄMICAMENTE AL CLICAR EN LOS ON/OFF
function mostrar_ocultar_capas_inlive(onoffclick, capa_mostrar_ocultar){
    onoffclickpulsado = onoffclick;
    onoffclickpulsadoboton = onoffclickpulsado+'_boton';
    capa_mostrar_ocultar_pulsada = capa_mostrar_ocultar;
    if(!onoffclickpulsado == "#datos_en_ticket"){
        if($("#datos_en_ticket_boton :radio:checked").val() == 1 ){
            if( $(onoffclickpulsadoboton + " :radio:checked").val() == 1 ){
                $("#ticket " + capa_mostrar_ocultar_pulsada).show("slow");
            }else{
                $("#ticket " + capa_mostrar_ocultar_pulsada).hide("slow").removeClass("mostrarenticket");;
            }
        }else{
            if( $(onoffclickpulsadoboton + " :radio:checked").val() == 1 ){
                $("#ticket " + capa_mostrar_ocultar_pulsada).hide("slow").removeClass("mostrarenticket");;
            }else{
                $("#ticket " + capa_mostrar_ocultar_pulsada).show("slow");
            }
        }
    }else{
        if( $(onoffclickpulsadoboton + " :radio:checked").val() == 1 ){
            $("#ticket " + capa_mostrar_ocultar_pulsada).show("slow");
            $("#ticket " + capa_mostrar_ocultar_pulsada+" .contDni").show("slow");
            $("#ticket " + capa_mostrar_ocultar_pulsada+" .contDireccionTicket").show("slow");
        }else{
            $("#ticket " + capa_mostrar_ocultar_pulsada).hide("slow").removeClass("mostrarenticket");
            $("#ticket " + capa_mostrar_ocultar_pulsada+" .contDni").hide("slow").removeClass("mostrarenticket");
            $("#ticket " + capa_mostrar_ocultar_pulsada+" .contDireccionTicket").hide("slow").removeClass("mostrarenticket");
        }
    }
}
function borrarImgTarjeta(){
   	$.get("../modules/tpvtienda/classes/actions/actionsConf.php",{token:tokenConf, action:'borrarImagenTarjeta',id_lang:$('#id_lang').val(),
        id_currency: $("#id_currency").val(),id_employee: id_employee, imagenBorrada:imagenBorrada,id_shop: $('#id_shop').val()},function(data) {
        $('#backgroundTarjeta').html("");
    });
}
