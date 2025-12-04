var dineroEnCaja = 0;
var anchuraTicket = 400;
var inicioCajas = 0;
var cantidadCajas = 5;
var token = document.location.href.split("token=");
token = token[1].split("#");
token = token[0].split("&");
token = token[0];
var totalMenosEfectivo = 0;
var totalConEfectivo = 0;
var efectivo = 0;

function getCajas(rest,busquedaLimpia){
    $(".cajasVacias").hide();
    // si esta a 1 restricci�n es para que solo busque las que perteneces a la tienda actual, si es 0 busca en todas las creadas
    var restriccion = 1;
    if($("body").hasClass("admintpvcaja"))
        id_emp = $("input[name=empleado]:checked").attr("id").replace("empleado", "");
    else if(id_employee != "")
        id_emp = id_employee;
    else
        id_emp = 'allEmp';
    if(typeof rest == 'undefined')
        restriccion = 1;
    else if(rest == 0)
        restriccion = 0;
    else if(rest == 2)
        restriccion = 2;
    if(!scroll || typeof scroll == "undefined" || typeof busquedaLimpia == 'undefined' || busquedaLimpia == 1){
        inicioCajas = 0;
        cantidadCajas = 5;
        $(".contCajas").html("");
    }
    var tipo = $("input[name=tipoCajas]:checked").attr("id");
    if(typeof tipo == "undefined")
        tipo = 'abiertasCajas';
    $("input[name=tipoCaja]").val(tipo);
    if($("#cajas #filtrarFechasCajas").is(':checked'))
        var filtrarFechas = 1;
    else
        var filtrarFechas = 0;
    $("input[name=filtrarFechas]").val(filtrarFechas);
    var	desde = $('#desdeFechaCajas').val();
    var	hasta = $('#hastaFechaCajas').val();
    if(filtrarFechas){
        $("input[name=fecha]").val(desde);
        $("input[name=fechaFin]").val(hasta);
    }
    if(origenCaja == 'TPV'){
        inicioCajas = 0;
        cantidadCajas = 999999;
    }

    if(inicioCajas != "-1"){
        $.getJSON("../modules/tpvtienda/classes/actions/actionsCaja.php",{token:token, action:'getCajas', tipo:tipo, dia:desde, diaFin:hasta, id_lang: id_lang,c: cantidadCajas,p:inicioCajas,
            id_shop: id_shop,id_currency: $('#currencyPOS').val(),id_employee: id_emp,restriccion: restriccion, filtrarFechas:filtrarFechas},function(data) {
            if(!$.isEmptyObject(data)){
                if(origenCaja == 'TPV'){
                    var flagCajasDispo=0;
                    var contadorCajasAbiertas=0;
                    $.each(data, function(index, result) {
                        if(result.cajasDisponibles != null)
                            flagCajasDispo = 1;
                        else
                            contadorCajasAbiertas++;
                    });
                    if(contadorCajasAbiertas == 1 && flagCajasDispo == 0){  // o sea una caja abierta y ninguna disponible, lo mando a usar caja
                        usarCaja(data[0].id_cajas);
                    }else{
                        cajaResumen(data);
                        $.mobile.changePage("#popupCajas");
                        resizeContCompra();
                    }

                }
               if(origenCaja == 'historialCajas')
                    cajaDetallada(data);
                $(".button_usar_caja").show();
                $(".button_usar_caja").addClass('ui-state-disabled');
                if(inicioCajas != "-1")
                    inicioCajas += cantidadCajas+1;
            }else{
                if(origenCaja == 'TPV'){
                    inicioCajas = -1;
                    $(".button_usar_caja").hide();
                    $(".button_usar_caja").addClass('ui-state-disabled');
                    $(".contCajas").html("");
                    $(".cajasVacias").show();
                    $.mobile.changePage("#popupCajas");
                    resizeContCompra();
                }
            }
        });
    }
    $(".loading").hide();
}

function getCajasParaTransferir(){
    $("#popupCajaCerrada .loading").show();
    $.getJSON("../modules/tpvtienda/classes/actions/actionsCaja.php",{token:token, action:'getCajasParaTransferir', id_lang: id_lang,cajaEnUso:cajaEnUso,
        id_shop: id_shop,id_currency: $('#currencyPOS').val(), id_employee:id_employee},function(data) {
        $("#popupCajaCerrada .contCajas").html("");
        if(!$.isEmptyObject(data)){
            $.each(data, function(index, result) {
                var html = '<button class="ui-btn ui-icon-action ui-btn-icon-left" onclick="transferirCaja(\''+result+'\')" title="'+transferirCajaTxt+'"><span>'+result+'</span></button>';
                $("#popupCajaCerrada .contCajas").append(html);
            });
        }else{
          //  console.log("else");
//            getCajas(1,0);
//			$.mobile.changePage("#popupCajas");
            $("#popupCajaCerrada .cajasVacias").show();
        }
        $("#popupCajaCerrada").popup();
        $("#popupCajaCerrada").popup("open");
    });
    $("#popupCajaCerrada .loading").hide();
}

function entradaSalidaDinero(tipo,id_cajas){
    if(tipo == 'entrada')
        var opuesto = 'salida';
    else
        var opuesto = 'entrada';

    var display = $("#"+tipo+"_caja_"+id_cajas).css('display');

    if(display == 'none'){
        $("#"+tipo+"_caja_"+id_cajas).show();
        $("#"+opuesto+"_caja_"+id_cajas).hide();
    }else{
        $("#"+tipo+"_caja_"+id_cajas).hide();
        $("#"+opuesto+"_caja_"+id_cajas).show();

    }

}

function getCaja(){
    $.getJSON("../modules/tpvtienda/classes/actions/actionsCaja.php",{token:token, action:'getCaja', id_cajas:cajaEnUso,id_lang:id_lang},function(data) {
        if(!$.isEmptyObject(data)){
            $('#popupCaja #contCaja').html("");
            cajaDetallada(data,'#popupCaja', '#contCaja');
        }else{
            getCajas(1,0);
            $.mobile.changePage("#popupCajas");
            $(".cajasVacias").show();
        }
    });
}

function anadirDinero(id_cajas){
    var tipo = $("select[name=selectorEntradaSalida]").val();
    if(tipo == 'entrada'){
        var nameTxt = entradaDineroTxt;
    }else{
        var nameTxt = salidaDineroTxt;
    }
    $.getJSON("../modules/tpvtienda/classes/actions/actionsCaja.php",{token:token, action:'entradaSalidaDinero', tipo:tipo,id_employee:id_employee,id_cajas:id_cajas,
        cantidad:$("#entradaSalida_caja_"+id_cajas+' input[name=amount_entrada]').val(),description:$("#entradaSalida_caja_"+id_cajas+' input[name=description_entrada]').val(),
        name:nameTxt,id_currency:$('#currencyPOS').val(),id_lang:id_lang},function(data) {
        if(data == 1){
            showSuccessMessage(actualizado);
            getCaja();
            actualizarCaja(cajaEnUso);
        }else{
            mostrarError(data);
        }
    });
}
function calculaDescuadre(){
    var y = parseFloat($("#dineroRealEnCaja").val());
    if (!isNaN(y)){
        var totalContReal = parseFloat(y) + parseFloat(totalMenosEfectivo);
        $('.totalConteoCierre').html(formatCurrency(parseFloat(totalContReal), currencyFormat, currencySign, currencyBlank));
        $("#descuadre").show();
        $("#descuadre span").html(formatCurrency(parseFloat(totalContReal - totalConEfectivo), currencyFormat, currencySign, currencyBlank));
        if(totalContReal != totalConEfectivo){
            //descueadre
            $("#descuadre").removeClass('cuadrada');
        }else{
            $("#descuadre").addClass('cuadrada');

        }
    }
}
function cajaDetallada(data,selector, selectorCaja){
    if(typeof selector == 'undefined')
        var selectorCajas = ".contCajas";
    else
        selectorCajas = selector + " " +selectorCaja;
    $.each(data, function(index, result) {
        if(typeof result.id_cajas != 'undefined') {
            var ventas = parseFloat(result.ventas);
            var totalMovimientos = parseFloat(result.totalMovimientos);
    		var al_comienzo = parseFloat(result.al_comienzo);
    		if(result.al_fin != null)
    			var al_fin = parseFloat(result.al_fin);
    		else
    			var al_fin = null;

    		var EnCaja = al_comienzo + totalMovimientos;
    		var html = "";

    		if(typeof selectorCaja == 'undefined' || selectorCaja == '.contCajas'){
    			html += '<div id="cajas_'+result.id_cajas+'_contenedor" class="cajas row estado_'+result.estado+'">';
    		}else{
    			html += '<div id="cajas_'+result.id_cajas+'_contenedor" class="cajasDetalladas row">';
    		}
    		html += '<div class="resumeCaja threecol"></div><div class="ninecol last"><table id="cajas_'+result.id_cajas+'" class="table">'+
    						'<thead><tr>'+
                                    '<th>ID</th>'+
                                    '<th>'+forma_de_pago+'</th>'+
                                    '<th>'+concepto+'</th>'+
                                    '<th>'+descripcion+'</th>'+
                                    '<th>'+cantidad+'</th>'+
                                    '<th>'+empleado+'</th>'+
                                    '<th class="fecha">'+fecha+'</th>'+
                                    '</tr>'+
                            '</thead>';
    		html +='<tbody></tbody></table></div>';
    		html += '</div>';
    		$(selectorCajas).append(html);

    		var agrupacionMovimientos = [];
    		var alturaCont = $("#TPVTienda").height();
    		if(alturaCont < 600)
    			var pageLength = 5;
    		else if(alturaCont < 940)
    			var pageLength = 10;
    		else
    			var pageLength = 17;
            if ((typeof $.fn.DataTable != "undefined" && $.fn.DataTable.isDataTable('#cajas_'+result.id_cajas) )) {
                $('#cajas_'+result.id_cajas).DataTable().destroy();
            }
           	 $('#cajas_'+result.id_cajas).DataTable({
    		  	dom: 'Tf<"clear">Brtip',
    		  	buttons: [
    		              { extend: 'copy',text: copyTxT, attr: { id: 'allan' } }, 'csv', 'excel', 'pdf',  {extend: 'print', text: printTxT,
    		                  customize: function ( win ) {
    		                     $(win.document.body)
    		                         .css( 'font-size', '10pt' )
    		                         .css( 'font-weight', 'normal' );
    		                     $(win.document.body).find( 'table' ).addClass( 'compact' ).css( 'font-size', 'inherit' );
    		                  }
    		              }
    		    ],
    			"language":traducciones,
                 order: [[0, 'desc']],
    			"pageLength": pageLength,
    			"ajax": {
    				"url" : "../modules/tpvtienda/classes/actions/actionsCaja.php?action=getMovimientosByCaja&token="+token+"&id_shop="+id_shop+"&id_lang="+id_lang+"&id_cajas="+result.id_cajas,
    				"type": 'POST',
    	            "data": {
    	            	"token" : token
    	            }
    			},
    //			"ajax":"../modules/tpvtienda/classes/actions/actionsCaja.php?action=getMovimientosByCaja&id_cajas="+result.id_cajas,
    			"drawCallback": function( settings ) {
                    $('#cajas_'+result.id_cajas+'_wrapper .agrupacionMovimientos').remove();
                    $('#cajas_'+result.id_cajas+'_wrapper h2.totalesCaja').remove();
    		        $('#cajas_'+result.id_cajas+'_wrapper').append('<h2 class="totalesCaja">'+totalesTxt+'</h2><div class="agrupacionMovimientos"></div>');
    		 		var datos = this.fnGetData();
    		 		if(datos.length > 0){

                        $.each(this.fnGetData(),function(index,value){
                            if(value[1] != "" && value[1] != "null" && value[1] != null){
        			 			var nameFormated = value[1].replace(/ /g, "_");
        			 			var typeMov = (value[7] != null ? value[7].replace(/ /g, "_") : '');
        			 			nameFormated = nameFormated.replace(":","").replace(".","").replace("/","").replace("(","").replace(")","");
        			 			var $myDiv = $('#cajas_'+result.id_cajas+'_wrapper .mov_'+typeMov);
        				 		if ( $myDiv.length){
        				 			var amountCaja = parseFloat($('#cajas_'+result.id_cajas+'_wrapper .mov_'+typeMov+" span.amount").html())+parseFloat(value[4]);
        							var ctdCaja = parseFloat(parseFloat($('#cajas_'+result.id_cajas+'_wrapper .mov_'+typeMov+" span.ctd").html())+1);
        				 		   	$('#cajas_'+result.id_cajas+'_wrapper .mov_'+typeMov+" span.amount").html(amountCaja);
        				 		   	$('#cajas_'+result.id_cajas+'_wrapper .mov_'+typeMov+" span.ctd").html(ctdCaja);
        				 		}else
        				 		   	$('#cajas_'+result.id_cajas+'_wrapper .agrupacionMovimientos').append('<p class="mov_'+typeMov+
                                    ' center">(<span class="ctd">1</span>x) '+(metodosPago[value[7]] != undefined ? metodosPago[value[7]] : value[1])+': <span class="amount">'+value[4]+'</span></p>');
                            }
    		 			});
                    	$('#cajas_'+result.id_cajas+'_wrapper .agrupacionMovimientos p').each(function(index,value){
    						var classMov = value.className.split(" ");
    						var amountMov = $('#cajas_'+result.id_cajas+'_wrapper .agrupacionMovimientos p.'+classMov[0]+' .amount').html();
    						$('#cajas_'+result.id_cajas+'_wrapper .agrupacionMovimientos p.'+classMov[0]+' .amount').html(parseFloat(amountMov).toFixed(priceDisplayPrecision));
    					});
    		 		}
    		 	}
    		});

            if(selectorCaja != '#popupCaja' && origenCaja != 'historialCajas'){
                $('#cajas_'+result.id_cajas+'_wrapper h2.tituloAnadirMovCaja').remove();
                $('#cajas_'+result.id_cajas+'_wrapper').append('<h2 class="tituloAnadirMovCaja">'+anadirMovTxt+'</h2><div class="row anadirMovCaja"></div>');
            	$('.anadirMovCaja').html('<div id="entradaSalida_caja_'+result.id_cajas+'" class="entradaSalida">'+
        		'<div class="col-sm-3"><select name="selectorEntradaSalida"><option value="salida">'+salidaDineroTxt+'</option><option value="entrada">'+entradaDineroTxt+'</option></select></div>'+
        		'<div class="col-sm-4"><input type="text" name="description_entrada" placeholder="'+descripcion+'"></div>'+
        		'<div class="col-sm-2"><input type="text" name="amount_entrada" class="amount_entrada" placeholder="'+cantidad+'" value="">'+
        		    '<input type="hidden" value="'+nombre_employee+'"></div>'+
        		'<div class="col-sm-3"><a href="#" class="button_anadir_movimiento ui-btn ui-icon-plus ui-btn-icon-left" onclick="anadirDinero(\''+result.id_cajas+'\')" class="ui-btn ui-icon-delete ui-btn-icon-left">'+guardarTxt+'</a></div></div>');
        	}
            var nombreCaja = result.nombre.replace(/'/g, "\\'");
    		$('#cajas_'+result.id_cajas+'_contenedor .resumeCaja').html(
    			'<h2><span>'+result.nombre+'</span></h2>'+
    			'<div class="contResumenCaja"><p class="restoDatos">'+empleado+': <span>'+result.employee+'</span></p>'+
    			'<p class="restoDatos">'+alInicioTxt+': <span>'+formatCurrency(al_comienzo, currencyFormat, currencySign, currencyBlank)+'</span></p>'+
    			(al_fin != null ? '<p class="restoDatos">'+alFinTxt+': <span>'+formatCurrency(al_fin, currencyFormat, currencySign, currencyBlank)+'</span></p>' : '')+
    			(al_fin != null && result.date_closed != "" && al_fin != EnCaja ? '<div class="descuadre"><p class="restoDatos">'+descuadreTxt+': <span>'+formatCurrency(al_fin - EnCaja, currencyFormat, currencySign, currencyBlank)+'</span></p></div>' : '')+
    			'<p class="restoDatos statusVentas">'+ventasTxt+': <span class="totalVentas">'+formatCurrency(ventas, currencyFormat, currencySign, currencyBlank)+'</span></p>'+
    			'<p class="status"><span class="title">'+totalTxt+': </span><span class="encaja">'+formatCurrency(EnCaja, currencyFormat, currencySign, currencyBlank)+'</span></p>'+
    			'<p class="restoDatos" id="comentarioCaja">'+comentario+': <span>'+result.comment+'</span></p>'+
    			'<p class="restoDatos">'+cajaAbiertaTxt+': <span>'+result.date_add+'</span></p></div>'+
    			'<p class="restoDatos cajaCerrada">'+cajaCerradaTxt+': <span>'+(result.date_closed != "" ? result.date_closed: "")+'</span></p>' +
                '<div class="contBotonesCaja"><p><button onclick="abrirCajon()" class="button_abrir_cajon ui-btn ui-shadow ui-corner-all ui-btn-no-icon"><i class="fas fa-cash-register"></i>'+abrirCajonTxt+'</button></p><div class="apertura_cajon" style="display:none"></div>'+
    			(result.estado == 0 && selectorCaja == '#contCaja' ? '<p><button class="button_transferir_caja ui-btn ui-icon-action ui-btn-icon-left" onclick="abrirTransferirCaja('+result.id_cajas+',\''+nombreCaja+'\')" class="ui-btn ui-icon-delete ui-btn-icon-left">'+transferirCajaTxt+'</button></p>'+
    				'<p><a href="#" class="button_cerrar_caja ui-btn ui-icon-delete ui-btn-icon-left" onclick="abrirCerrarCaja('+result.id_cajas+',\''+nombreCaja+'\')" class="ui-btn ui-btn-b ui-icon-delete ui-btn-icon-left">'+cerrarCajaTxt+'</a></p>' : ''))+
    		$('#cajas_'+result.id_cajas+'_wrapper .dt-buttons').append('<a class="noPrint dt-button" onclick="imprimirResumenPagos('+result.id_cajas+')" href="#cajas_'+result.id_cajas+'_wrapper">'+imprimirResumenTxt+'</a>');
        }
    });

}

function actualizarCaja(cajaEnUso){
    $.getJSON("../modules/tpvtienda/classes/actions/actionsCaja.php",{token:token, action:'getCaja', id_cajas:cajaEnUso,id_lang:id_lang},function(data) {
        if(!$.isEmptyObject(data)){
            $.each(data, function(index, result) {
                var totalMovimientos = parseFloat(result.totalMovimientos);
                var al_comienzo = parseFloat(result.al_comienzo);
                var EnCaja = al_comienzo+totalMovimientos;
                $('#cajaButton span').html(formatCurrency(EnCaja, currencyFormat, currencySign, currencyBlank));
            });
        }
    });
}

function usarCaja(id_cajas){
    cajaEnUso = id_cajas;
    //$('.notificationGood').html(textoCaja+" <strong>"+nombre+"</strong> "+seleccionada);
    dineroEnCaja = $(".caja_"+id_cajas+" input[name=conteo]").val();
    $('#cajaButton span').html(dineroEnCaja);
    $('#cajaButton').attr("href",'#popupCaja');
    $('#cajaButton').removeClass('getCajas');
    $('#cajaButton').addClass('getCaja');
    flagCambioEmpleadoAlFinalizarPedido = 0;
    $.mobile.changePage("#TPVTienda");
    totales();
}

function abrirCerrarCaja(id_cajas,nombre){
    $("#id_caja_popup").val(id_cajas);
    $("#nombre_caja_popup").val(nombre);
    //chequeo las formas de pago que afectan a la caja
    $(".dineroReal").val('0.00');
    $(".totalConteoCierre").val('0.00');
    $(".contDineroResto").html("");
    $(".contDineroEnTarjeta").hide();
    $("#descuadre").hide();
    totalMenosEfectivo = 0;
    totalConEfectivo = 0;
    $.getJSON("../modules/tpvtienda/classes/actions/actionsCaja.php",{token:token, action:'getResumenPagos',id_cajas:id_cajas,id_lang:id_lang,id_shop: id_shop},function(data) {
        if(!$.isEmptyObject(data)){
            deberiaHaberEnCaja = 0;
            $.each(data, function(index, result) {
                //if(typeof metodosPagoCaja[index] != "undefined" || index == 'traspaso' ||index == 'salida' || index == 'entrada')
//                    deberiaHaberEnCaja += parseFloat(result.valor);
                if(index == estadoEfectivo){
                    $(".contDineroEnCaja label").html(result.name);
                    totalConEfectivo += parseFloat(result.valor);
                    deberiaHaberEnCaja += parseFloat(result.valor);
                }else if(index == estadoTarjeta){
                    totalMenosEfectivo += parseFloat(result.valor);
                    totalConEfectivo += parseFloat(result.valor);
                  //   deberiaHaberEnCaja += parseFloat(result.valor);
                    $(".contDineroEnTarjeta").show();
                    $(".contDineroEnTarjeta label").html(result.name);
                    $("#deberiaHaberTarjeta").html(formatCurrency(parseFloat(result.valor), currencyFormat, currencySign, currencyBlank));
                }else{
                    if((result.f != null && result.f == 1) || index == 'traspaso' ||index == 'salida' || index == 'entrada')  //fondo
                        deberiaHaberEnCaja += parseFloat(result.valor);
                    else
                        totalMenosEfectivo += parseFloat(result.valor);
                    totalConEfectivo += parseFloat(result.valor);
                    $(".contDineroResto").append('<div class="contDineroOtro row">'+
                                                    '<label>'+result.name+'</label>'+
                                                	'<span class="deberiaHaberOtro">'+formatCurrency(parseFloat(result.valor), currencyFormat, currencySign, currencyBlank)+'</span>'+
                                                '</div>');
                }
            });
            $("#deberiaHaberEnCaja").html(formatCurrency(parseFloat(deberiaHaberEnCaja), currencyFormat, currencySign, currencyBlank));
            $("#popupCerrarCaja").popup("reposition", {positionTo: 'window'});
        }
    });
    $("#deberiaHaber").html($(".resumeCaja .encaja").html());
    $("#popupCerrarCaja").popup();
    $("#popupCerrarCaja").popup( "open");
    resizeContCompra();
}
function cerrarCaja(id_cajas,nombre){
    if(typeof id_cajas == "undefined")
        id_cajas = $("#id_caja_popup").val();
    if(typeof nombre != null){
        nombre = $("#nombre_caja_popup").val();
        $.getJSON("../modules/tpvtienda/classes/actions/actionsCaja.php",{token:token, action:'cerrarCaja', id_cajas:id_cajas, notaEnCaja:$("#notaEnCajaCerrarCaja").val(),
            id_shop: id_shop, id_lang:id_lang, al_fin:totalMenosEfectivo+parseFloat($("#dineroRealEnCaja").val())},function(data) {
                if(!$.isEmptyObject(data)){
                    $.each(data, function(index, result) {
                        if(result.date_closed != null)
                            $('p.cajaCerrada span').html(result.date_closed);
                        if(result.ok == 1){
                            $("#popupCerrarCaja").popup( "open");
                            $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html(textoCaja+" <strong>"+nombre+"</strong> "+textoCajaCerrada);
                            $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').fadeIn();
                            $("#comentarioCaja span").html($("#notaEnCajaCerrarCaja").val());
                            $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(2000).fadeOut();
                            $('#cajaButton').attr("href",'#popupCajas');
                            $('.notaEnCaja').val('');
                            $('#cajaButton').removeClass('getCaja');
                            $('#cajaButton').addClass('getCajas');
                            $('#cajaButton span').html(formatCurrency(0, currencyFormat, currencySign, currencyBlank));
                            imprimirResumenPagos(id_cajas);
                            if(caja_obligatoria == 1){
                                getCajas(1,1);
                            }else
                                $.mobile.changePage("#TPVTienda");
                        }
                    });
                    cajaEnUso = '';
                }
        });
    }
}



function abrirTransferirCaja(id_cajas,nombre){
    if(id_cajas !=null){
        $.getJSON("../modules/tpvtienda/classes/actions/actionsCaja.php",{token:token, action:'infoTransferenciaCaja',id_cajas:id_cajas,id_shop: id_shop},function(data) {
            if(!$.isEmptyObject(data)){
                var fondoCajaValue = 0;
                $.each(data, function(index, result) {
                    //if(typeof result.sobrante != "undefined"){
//                        $("#popupCajaCerrada #dineroAtransferir span").html(formatCurrency(result.sobrante, currencyFormat, currencySign, currencyBlank));
//                    }
                    if(typeof result.fondo != "undefined"){
                        fondoCajaValue = result.fondo;
                    }

                    if(result.ok == 1){
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html(textoCaja+" <strong>"+nombre+"</strong> "+textoCajaBorrada);
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').fadeIn();
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(2000).fadeOut();
                        $('#cajaButton').attr("href",'#popupCajas');
                        $('#cajaButton').removeClass('getCaja');
                        $('#cajaButton').addClass('getCajas');
                        $('#cajaButton span').html(formatCurrency(0, currencyFormat, currencySign, currencyBlank));
                        //limpio y relleno con el fondo de caja
                        $("#traspasosDeCaja").html('<div class="row"><form><span>'+fondoCajaTxt+": "+fondoCajaValue+'</span>'+
                                                        '<select id="trans_fondo" class="pagosAtransferir" data-role="flipswitch" data-theme="b" data-track-theme="b" data-mini="true">'+
                                                		'<option value="no">'+no+'</option>'+
                                                		'<option value="yes" selected>'+si+'</option>'+
                                                		'</select></div></form>');
                        $.each($(".agrupacionMovimientos p"),function(index,value){
                            var nombreMov = $(this).attr("class");
                            nombreMov = nombreMov.replace("mov_","");
                            nombreMov = nombreMov.split(" ");
                            nombreMov = nombreMov[0];
                            var textoMovs = $(this).text().split("(");
                            textoMovs = textoMovs[1];
                            textoMovs = textoMovs.split(")");
                            var nombrePago = textoMovs[1].split(":");
                            nombrePago = nombrePago[0];
                            var amountPago = nombrePago[1];
                            var onOff = '<select id="trans_'+nombreMov+'" class="pagosAtransferir" data-role="flipswitch" data-theme="b" data-track-theme="b" data-mini="true">'+
                                    		'<option value="no">'+no+'</option>'+
                                    		'<option value="yes" selected>'+si+'</option>'+
                                		'</select>';
                            $("#traspasosDeCaja").append('<div class="row"><form><span>'+textoMovs[1]+" </span>"+onOff+'</form></div>');
                        });
                        $('.pagosAtransferir').flipswitch();
                        $('.pagosAtransferir').flipswitch("refresh");
                       	getCajasParaTransferir();
                    }
                });
            }
        });
    }
}
function transferirCajaNueva(){
    var valoresATraspasar = [];
    $.each($(".pagosAtransferir"),function(index, value){
        var conceptoActivoOno = $(this).val();
        var nombreConceptoFormatted = $(this).attr("id").replace("trans_","");
        if(conceptoActivoOno == "yes")
            valoresATraspasar.push(nombreConceptoFormatted);
    });
    $.getJSON("../modules/tpvtienda/classes/actions/actionsCaja.php",{token:token, action:'transferirNuevaCaja', id_cajas:cajaEnUso,
        name:transferenciaTxt, id_shop: id_shop, id_lang: id_lang, valoresAtraspasar: multiDimensionArray2JSON(valoresATraspasar), id_employee: id_employee,
        notaEnCaja:$("#notaEnCajaTransferencia").val()},function(data) {
        if(!$.isEmptyObject(data)){
            $.each(data, function(index, result) {
                if(result.ok == 1){
                    getCajas(1,1);
             		$.mobile.changePage("#TPVTienda");
                	updateCompra();
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html(transferidoCajaTxt+" <strong>"+$(".resumeCaja h2 span").html()+"</strong>");
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').fadeIn();
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(2000).fadeOut();
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia #popupCajaCerrada').popup("close");
                }
            });
        }
    });
}
function transferirCaja(nombre){
    var valoresATraspasar = [];
    $.each($(".pagosAtransferir"),function(index, value){
        var conceptoActivoOno = $(this).val();
        var nombreConceptoFormatted = $(this).attr("id").replace("trans_","");
        if(conceptoActivoOno == "yes")
            valoresATraspasar.push(nombreConceptoFormatted)
    });
    $.getJSON("../modules/tpvtienda/classes/actions/actionsCaja.php",{token:token, action:'transferirCaja',id_cajas:cajaEnUso,
        name:transferenciaTxt,nombreCaja:nombre,id_shop: id_shop,id_lang: id_lang,valoresAtraspasar: multiDimensionArray2JSON(valoresATraspasar),id_employee: id_employee,
        notaEnCaja:$("#notaEnCajaTransferencia").val()},function(data) {
        if(!$.isEmptyObject(data)){
            $.each(data, function(index, result) {
                if(result.ok == 1){
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html(transferidoCajaTxt+" <strong>"+nombre+"</strong>");
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').fadeIn();
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(2000).fadeOut();
                    $("#popupCajaCerrada").popup("close");
                    if(caja_obligatoria == 1){
                        getCajas(1,1);
                    }else{
                 		$.mobile.changePage("#TPVTienda");
                    	updateCompra();
                    }
                }
            });
        }
    });
}

function nuevaCaja(tipo){
    $.getJSON("../modules/tpvtienda/classes/actions/actionsCaja.php",{token:token, action:'getCajasDisponibles',
        id_shop:id_shop,id_lang: id_lang,id_currency:$('#currencyPOS').val(),id_employee: id_employee},function(data) {
        if(data.length > 0){
            $("#abrirCaja select[name=caja]").html("");
            $.each(data, function(index, result) {
                $("#abrirCaja select[name=caja]").append('<option value="'+result+'">'+result+'</option>');
            });
            $("#abrirCaja select[name=caja]").selectmenu();
            $("#abrirCaja select[name=caja]").selectmenu('refresh');
            modo = '#popupNuevaCaja';
            $.mobile.changePage("#popupNuevaCaja");
        }else{
            mostrarError('error017');
            //no quedan cajas disponibles
        }
    });
}

function estado(estado){
    return listaEstados[estado]
}

function guardarCaja(){
    var nombre = $("#abrirCaja select[name=caja]").val();
    $.getJSON("../modules/tpvtienda/classes/actions/actionsCaja.php",{token:token, action:'guardarCajas', al_comienzo: $("#abrirCaja .contadorCaja").val(),
        id_shop:  id_shop,nombre: nombre,id_currency: $('#currencyPOS').val(),id_lang:id_lang, id_employee: id_employee},function(data) {
        if(!$.isEmptyObject(data)){
            $.each(data, function(index, result) {
                if(result.ok == 1){// no hay mas productos
                    $("#abrirCaja input").val("");
                    $("#abrirCaja .contadorCaja").val("");
                    $("#abrirCaja textarea").val("");
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html(textoCajaGuardada+" <strong>"+nombre+"</strong> "+textoCajaGuardada);
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').fadeIn();
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(2000).fadeOut();
                    modo = 0;
                    getCajas(1,1);
                }
            });
        }
    });
}

function cajaResumen(data){
    var lengthCajas = data.length;
    var i = 0;
    $.each(data, function(index, result) {
        if(result.cajasDisponibles == null){
    		var totalMovimientos = parseFloat(result.totalMovimientos);
    		var al_comienzo = parseFloat(result.al_comienzo);
    		var EnCaja = al_comienzo+totalMovimientos;
    		var secuenciaCierre = "";
    		i++;

    		var html = '<div id="caja_'+result.id_cajas+'" onclick="usarCaja('+result.id_cajas+')" class="cajas caja_'+result.id_cajas+' estado_'+result.estado+' ">'+
    			'<h4 class="text-center"><div class="fas fa-cash-register"></div> <span>'+result.nombre+'</span></h4>';
    			if(result.estado == 0 ){
    				if(typeof caja_obligatoria == "undefined" || caja_obligatoria == 1)
    					secuenciaCierre = "popupCajas";
    				else
    					secuenciaCierre = "TPVTienda";
    			}
                if(typeof ocultarDineroCaja == "undefined" || !ocultarDineroCaja){
                    html +='<p class="center status status_'+result.estado+'">'+actualTxt+': '+formatCurrency(EnCaja, currencyFormat, currencySign, currencyBlank)+', '+
                    alInicioTxt+': '+formatCurrency(al_comienzo, currencyFormat, currencySign, currencyBlank)+','+
                    totalMovimientosTxt+': '+formatCurrency(totalMovimientos, currencyFormat, currencySign, currencyBlank)+'</p>'+
        			'<input type="hidden" name="conteo" value="'+formatCurrency(EnCaja, currencyFormat, currencySign, currencyBlank)+'">';
                }
    		html +='</div>';
    		$("#popupCajas .contCajas").append(html);
        }
    });
}
function abrirCajon(){
    $(".apertura_cajon").printThis({
        importCSS: false,           // import page CSS
    });
}
function imprimirResumenPagos(id_caja){
    var desde = $("#desdeFechaCajas").val();
    var hasta = $("#hastaFechaCajas").val();
    if(hasta == desde)
        var fechaTitulo = desde;
    else
        var fechaTitulo = desde+" - "+hasta;
    $(".contenidocaja").html('<h2 class="center">'+$("#cajas_"+id_caja+"_contenedor h2 span").clone().html()+'</h2>');
    $(".contenidocaja").append('<h2 class="center">'+$("#cajas_"+id_caja+"_contenedor p.status").clone().html()+'</h2>');

    $("#cajas_"+id_caja+"_contenedor .resumeCaja p.restoDatos").each(function(){
        $(".contenidocaja").append('<p>'+$(this).html()+'</p>');
    });
    $(".contenidocaja").append('<p>'+$("#descuadre").html()+'</p>');
    var totalAgrupaMovs = $("#cajas_"+id_caja+"_wrapper .totalesCaja").clone().html();
    if(totalAgrupaMovs != undefined){
        $(".contenidocaja").append('<h2 class="center">'+$("#cajas_"+id_caja+"_wrapper .totalesCaja").clone().html()+'</h2>');
        $(".contenidocaja").append('<div class="agrupacionMovimientos">'+$("#cajas_"+id_caja+"_wrapper .agrupacionMovimientos").clone().html()+'</div>');
    }
    $.fancybox({
        'type': 'html',
        'content' : 	$("#ContTicketcaja").html(),
        'autoSize'    : true,
        'autoHeight'  : true,
        'maxWidth'		: anchuraTicket,
        'afterClose'	: function(){
            modo=0;
        },
        'afterShow':  function(){
            afterShowTickets('caja');
        }
    });
}
function elegirCaja(event){
   //  $("#listadoCajas .cajas").on("click", function(event){
        if(($(event.srcElement).is("input") && $(event.srcElement).val() != 'on' ) ||
           !$(event.srcElement).is("input") && $(event.srcElement).children('input').val() != 'on' ){
            $(event.srcElement).removeClass("alterado");
            var nameCaja = $(event.srcElement).attr("id");
            if(typeof nameCaja != "undefined"){
                idCaja = nameCaja.replace("caja_", "");
                usarCaja(idCaja);
            }else{
                mostrarError('error017');
            }
        }else{
            $(event.srcElement).addClass("alterado");
            if($(event.srcElement).is("input")){
                $(event.srcElement).val('') ;
                $(event.srcElement).prop('checked',true) ;
            }else{
                $(event.srcElement).children('input[type=radio]').val('') ;
                $(event.srcElement).children('input[type=radio]').prop('checked',true) ;
            }
        }
        selected_value = $("input[type=radio]:checked").val();
        if(typeof selected_value != "undefined"){
            $(".button_usar_caja").removeClass('ui-state-disabled');
        }else{
            $(".button_usar_caja").addClass('ui-state-disabled');
        }
    // });
    }

$(document).ready(function() {
//	$('a[data-change-hash="false"]').on('click',function(e) {
//        $.mobile.changePage($(this).attr('href'),{'changeHash':false});
//        e.preventDefault();
//    });

    $("a").not('.ui-mobile-viewport a').each(function(){
        $(this).attr("rel","external");
    });
    $("#header_search").attr("data-ajax",false);
    $("#desdeFechaCajas").datepicker({
        dateFormat : 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        beforeShow: function() {
            setTimeout(function(){
                $('.ui-datepicker').css('z-index', 2);
            }, 0);
        },

        onSelect: function( selectedDate ) {
        	getCajas(2,1);
        	var date2 = $("#desdeFechaCajas").datepicker('getDate');
            date2.setDate(date2.getDate());
            $("#hastaFechaCajas").datepicker('option', 'minDate', date2);
        	$('input.fechaCajas').val(selectedDate);
        }
    });

    $("#hastaFechaCajas").datepicker({
        dateFormat : 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        beforeShow: function() {
            setTimeout(function(){
                $('.ui-datepicker').css('z-index', 2);
            }, 0);
        },
        onSelect: function( selectedDate ) {
        	getCajas(2,1);
        	$('input.fechaCajasFin').val(selectedDate);
        }
    });
    $('.getCaja').on("click", function(event){
       getCaja();
    });

    $('.getCajas').on("click", function(event){
        if(cajaEnUso != 0)
            getCaja();
        else
            getCajas();
    });

    $(".button_get_cajas").on("click", function(event){
    	getCajas();
    });

    $("#cajas input[name=tipoCajas]").on("click", function(event){
        getCajas(0,1);

    });


    $("#cajas #filtrarFechasCajas").on("click", function(event){
        if(!$(this).is(':checked')){
            $("#desdeFechaCajas").textinput('disable');
            $("#hastaFechaCajas").textinput('disable');
            $("#desdeFechaCajas").addClass('ui-state-disabled');
            $("#hastaFechaCajas").addClass('ui-state-disabled');
        }else{
            $("#desdeFechaCajas").textinput('enable');
            $("#hastaFechaCajas").textinput('enable');
            $("#desdeFechaCajas").removeClass('ui-state-disabled');
            $("#hastaFechaCajas").removeClass('ui-state-disabled');
        }
        inicioCajas = 0;
        getCajas(0,1);
    });

    $("#cajas .filtrarEmpleado").on("click", function(event){
        getCajas(2,1);
    });

    $("#ventas .filtrarEmpleado").on("click", function(event){
        var id_employee = $("input[name=empleado]:checked").attr("id").replace("empleado", "");
        getTotalizacion();
        if(id_employee != 'allEmp'){
            $("#ventas .employeeFiltered span").html($("#ventas label[for="+$("input[name=empleado]:checked").attr("id")+"]").html());
            $("#ventas .employeeFiltered").show();
        }else
            $("#ventas .employeeFiltered").hide();
    });
    $("#desdeFechaCajas").textinput().textinput('disable');
    $("#hastaFechaCajas").textinput().textinput('disable');
    $("#desdeFechaCajas").addClass('ui-state-disabled');
    $("#hastaFechaCajas").addClass('ui-state-disabled');
    $(".dineroReal").on("click",function(event){
        $(this).val("");
    });
    $(".dineroReal").on("keyup",function(event){
        var amount = $(this).val().replace(",", ".");
        var totalContReal = parseFloat(amount) + parseFloat(totalMenosEfectivo);
        $('.totalConteoCierre').html(formatCurrency(parseFloat(totalContReal), currencyFormat, currencySign, currencyBlank));
        $("#descuadre").show();
        $("#descuadre span").html(formatCurrency(parseFloat(totalContReal-totalConEfectivo), currencyFormat, currencySign, currencyBlank));
        if(totalContReal != totalConEfectivo){
            //descueadre
            $("#descuadre").removeClass('cuadrada');
        }else{
            $("#descuadre").addClass('cuadrada');

        }
    });
    $(".billeteomoneda").on("keyup",function(event){
        var valor = 0;
        $(".billeteomoneda").each(function(){
            var valInput = $(this).val();
            if(valInput !== "")
                valor += valInput * $(this).prev('button').text();
        });
        $("#abrirCaja .contadorCaja").val(parseFloat(valor).toFixed(priceDisplayPrecision));
        efectoGuardado("#abrirCaja .contadorCaja");
    });

    $(".billeteomoneda2").on("keyup",function(event){
        var valor = 0;
        $(".billeteomoneda2").each(function(){
            var valInput = $(this).val();
            if(valInput !== "")
                valor += valInput * $(this).prev('button').text();
        });
        $("#dineroRealEnCaja").val(parseFloat(valor).toFixed(priceDisplayPrecision));
        calculaDescuadre();
        efectoGuardado("#dineroRealEnCaja");
    });

    $(window).on( "scroll",function() {
        if($("body").hasClass("admintpvcaja") && $(window).scrollTop() + $(window).height() > $(document).height()-500) {
            delay(function(){getCajas(2,0)},400 );
       }
    });

    $(".button_contar_billetes").on("click", function(event){
        $('#contBilletesCerrarCaja').slideToggle('fast');
        setTimeout(function(){
             $("#popupCerrarCaja").popup("reposition", {positionTo: 'window'});
        }, 100);
    });
    $("#cajaButton").on("click", function(event){
        if(cajaEnUso !== ''){
            $.mobile.changePage("#popupCaja");
            setTimeout(function(){
                 resizeContCompra();
            }, 1000);
        }else{
            getCajas(1,0);
            $.mobile.changePage("#popupCajas");
        }
    });
  	$("#nuevaCaja").on("click", function(event){
        guardarCaja();
    });
});