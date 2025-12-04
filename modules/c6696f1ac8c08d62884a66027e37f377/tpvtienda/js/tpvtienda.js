// variables del buscador
var inicioProductos = 0;
var inicioPagos = 0;
var cantidadProductos = 48;
var cantidadAcredito = 10;
var cantidadPagos = 10;
// variables del entorno
var ultimaBusqueda = 'limpieza';
var resizeTimer;
var imprimirPrimeraVez = 0;
// 0 normal, capta el teclado para los codebars
// 1 botonera. capta los numeros para la botonera
//2 Otro tipo de campo.
//3 Selecciona empleado.
var modo = 0;
var xhrCountCat = 0;
var done = false;
var signaturePad = '';
var selectHtml = "";

var confirmPayment = false;
var valorActual = "";
var mySwiper = "";
var paginadorDevoluciones = 0;
var paginadorDevolucionesProds = 0;
var paginadorAparcados = 0;
var keys = {};
var teclas = '';
var teclaPscrollulsada = '';
var anadirProdDropZone = '';
var listadoPagos = new Array();
var tablaCombinaciones = "";
var error = 0;
var cajaEnUso = 0;
var xhrCount = 0;
var thresholdCrossed = false;
var catActual = categoria_inicio_productos;
var contCombs = 0;
var seHizoDevolucion = false;
var id_prod_full = "";
var attr_prod_full = ""
var name_prod_full = "";
var nameTransporte = "";
var id_order_global = 0;
var pagoInicial = 0;
var flagEnter = 0;
var fechaFin = "";
var estadoActual = "";
var formaPagoInicial = "";
var borraProductos = "";
var tablaPedidos = "";
var id_cart_pedido = "";
var token = document.location.href.split("token=");
var flagCambioEmpleadoAlFinalizarPedido = 0;
var vengo_de ="";
var primeraVez = 0;
var totalDevolucionesConIva = 0;
var totalDevolucionesSinIva = 0;
token = token[1].split("#");
token = token[0].split("&");
token = token[0];
var arrayPedidos = [];
var devolverEnTxt2 = "";
//este semaforo lo uso para que cuando se hace un pedido no lo marque como pedido nuevo ya que lo acabamos de crear
var semaforoAvisadorPedidos = 0;
var carritosTable = "";
//fix raro, daba error con el efectoGuardado de  f.curCSS is not a function
jQuery.curCSS = function(element, prop, val) {
    return jQuery(element).css(prop, val);
};
function pago(quotation){
    $(".loaderTicket").show();
    $("#checkoutButton").addClass("tpv-disabled");
    estadoActual = $("#formaPago").val();
    if(typeof estadoMixto != 'undefined' && estadoActual == estadoMixto){
        var pagado = 0;
        $.each($('input.cantidadPagoMixto'), function(index, result) {
            var cantidadPagoMixto = parseFloat($(this).val());
            if(cantidadPagoMixto >0)
                pagado += cantidadPagoMixto;
        });
    }else if(typeof estadoFactPer != 'undefined' && estadoActual == estadoFactPer){
         var pagado = $('#'+$.mobile.activePage.attr('id')+' #popupPagoAcredito .pagado').html();
    }else{
         var pagado = $('#'+$.mobile.activePage.attr('id')+' #popupPagoEfectivo .pagado').html();
    }
    var arrayVarsPOST = [];
    arrayVarsCheckoutPlugins.forEach(function(index,value){
        arrayVarsPOST[$(index).attr("id")] = $(index).val();
    });
    $.getJSON(token_actions,{action:'checkout', id_cart: id_cart, metodoPago:$('#formaPago').val(), ajax : "1",
        id_carrier: id_carrier, id_employee: id_employee, pagado: pagado, pagoEnPedido: pagoEnPedido, tax: tax, id_currency: $("#currencyPOS").val(),
        id_shop: id_shop, messageOrder: $("#messageOrder").val(), fechaFinFact: fechaFin, fechaCompromiso: $(".fechaCompromiso").val(), cuota: $('#cuota').val(),interes: $('#interes').val(),
        pagoInicial: pagoInicial, formaPagoInicial: formaPagoInicial, id_customer:id_customer, id_lang:id_lang,respuestaDatafono:multiDimensionArray2JSON(respuestaDatafono),
        listadoPagos: listadoPagos, cajaEnUso:cajaEnUso, salidaDineroTxt:salidaDineroTxt, budget: quotation, nameTransporte :$("#carriersButton .nameCarrier").html(),
        precioTransporte: $("#precioTransporte").val(), impuestosTransporte: $("#impuestosTransporte").val(), arrayVarsPOST: multiDimensionArray2JSON(arrayVarsPOST),
        borraProductos: borraProductos, borrarDescuento:borrarDescuento}).done(function( data ) {
            renovarCarrito();
            $("#popupPagoTarjeta").popup("close");
            if(typeof estadoFactPer == 'undefined' || estadoActual != estadoFactPer)  // si no es acredito muestor el ticekt normal
                error = verTicket(data);
            else
                verTicketPayment(data);
            if(error == 0){
                if(quotation == null){
                    if(mostrarFancybox !== "0" || autoprint_ticket != 0){
                        imprimirPrimeraVez = 1;
                        if(typeof estadoFactPer == 'undefined' || estadoActual != estadoFactPer)
                            mostrarTicket("normal");
                        else
                            mostrarTicket("pago");
                    }else{
                        imprimirPrimeraVez = 0;
                    }
                }else{
                    $("#popupPresupuesto").popup("close");
                }
                $('#filter').val('');
                hookJS('afterCheckout',[estadoActual]);
                $('#precioTransporte').val(parseFloat(0).toFixed(priceDisplayPrecision));
                $("#nameTransporte").val(nameTransporte);
                nameTransporte = nameTransporte_defecto;
                $(".nameCarrierPOS").html(nameTransporte);
                $("#carriersButton .nameCarrier").html(nameTransporte);
                $("#carriersButton span:not(.nameCarrier)").html(parseFloat(0).toFixed(priceDisplayPrecision));
                $(".carrier_defecto").trigger("click");
                listadoPagos = new Array();
                actualizarCaja(cajaEnUso);
                $(".contClientePedidoDevs .ui-input-text").show(); //para las devoluciones
                $('.botonVolverClientes').trigger("click");
                $('#descuentosAplicados').html('');
                borraProductos = "";
                confirmPayment = false;
                $('.messageOrder').val('');
                $("#contNotaButton .fa-check-circle").hide();
                dev_pass_neg_flag = 0;
                $("select[name=customer_id_address_delivery]").html('');
                $("select[name=customer_id_address_invoice]").html('');
                $(".pagado").html(0);
                $('input[name=pagoInicial]').val(0);
                if(datos_tarjeta){
                    if(estadoActual == estadoTarjeta){
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .titularTarjeta').val('');
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .numeroTarjeta').val('');
                        $("#"+$.mobile.activePage.attr('id')+' .tCredito').show();
                        if(tarjeta_obligatoria == 1){
                            $("#"+$.mobile.activePage.attr('id')).append('<div class="maskTPVTienda maskTarjetaOblig"></div>');
                            $("#"+$.mobile.activePage.attr('id')+' .maskTarjetaOblig').show();
                            $("#"+$.mobile.activePage.attr('id')+' .maskTarjetaOblig').on("click touchstart", function(event){
                                if($("#"+$.mobile.activePage.attr('id')+' .titularTarjeta').val() != "" && $("#"+$.mobile.activePage.attr('id')+' .numeroTarjeta').val() != ""){
                                    $("#"+$.mobile.activePage.attr('id')+' .maskTarjetaOblig').hide();
                                    $("#"+$.mobile.activePage.attr('id')+' .tCredito').hide();
                                    modo=0;
                                }else{
                                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').html(rellenaCamposTxt);
                                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').slideDown('fast');
                                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').delay(2000).slideUp('fast');
                                }
                            });
                        }
                    }
                }else{
                    $("#"+$.mobile.activePage.attr('id')+' .tCredito').hide();
                }
            }else{
                $.getJSON("../modules/tpvtienda/classes/actions/actions.php",{token:token, action:'dejarComoEstaba',id_cart:id_cart,
             //        carrier_default_especifico: carrier_default_especifico, carrier_default:carrier_default,
                    id_employee: id_employee,tax: tax, id_currency: $("#currencyPOS").val(), id_shop: id_shop}
                ,function(data) {});
                $("#checkoutButton").removeClass("tpv-disabled");
            }
            if(nota_oblig != 1){
                $("#checkoutButton").removeClass("tpv-disabled");
                $("#checkoutButton").tooltip('disable');
            }else{
                $("#checkoutButton").prop('title',nota_oblig_texto);
                $("#checkoutButton").tooltip('enable');
            }
            if(!$("#popupElegirAbono-popup").hasClass("ui-popup-active") && cambioEmpleadoObligatorioAlFinalizar == 1){
                flagCambioEmpleadoAlFinalizarPedido = 1;
                $.mobile.changePage("#popupEmpleados");
            }else{
                flagCambioEmpleadoAlFinalizarPedido = 0;
            }
            $(".loaderTicket").hide();
    });
}
function contadorCaracteres(campo){
    const maxLength = $(campo).attr('maxlength');
    const currentLength = $(campo).val().length;
    $(campo).parent().find(".counterCampo").html("("+currentLength+" / "+maxLength+")");
}
function initializePad(){
    var wrapper = document.getElementById("signature-pad"),
    canvas = wrapper.querySelector("canvas");

    // Adjust canvas coordinate space taking into account pixel ratio,
    // to make it look crisp on mobile devices.
    // This also causes canvas to be cleared.

    function resizeCanvas() {
        var ratio =  window.devicePixelRatio || 1;
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
    }
    window.onresize = resizeCanvas;
    resizeCanvas();
    signaturePad = new SignaturePad(canvas);
}
function salvarFirma(){
    if (signaturePad.isEmpty()) {
        alert("Please provide signature first.");
    } else {
        $("#"+$.mobile.activePage.attr('id')+" .docFirmados .contentFirmados").html('<div class="loaderClientes ui-loading"><div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div></div>');
        $.post(token_actionsFirma,{action:"anadirFirma", ajax:"1", id_order: $("#id_order_documento").val(),
            img:signaturePad.toDataURL().substring(22, signaturePad.toDataURL().length),id_order_invoice:$("#id_order_invoice_documento").val(),
            tipo:$("#tipo_documento").val()},function(data) {
            if(data == 1){
                actualizarDocumentosFirmados();
            }
        });
        $(".m-signature-pad").hide();
    }
    $('.maskTPVTienda').trigger("click");
}
function borrarCategoria(id){
    var valores = $("input[name=categoriasNuevoProducto]").val();
    $("input[name=categoriasNuevoProducto]").val(valores.replace(id+",",""));
}
function firmarPDF(destino,id_order,id_order_invoice,tipoDocumento){
    if(destino == 'tp'){
        $(".m-signature-pad").show();
        $("#tipo_documento").val(tipoDocumento);
        $("#id_order_invoice_documento").val(id_order_invoice);
        $("#id_order_documento").val(id_order);
        initializePad();
        anadirMascara();
        $('.m-signature-pad').show();
    }else{
        var msg = {message: {origen: 'tp',id_order: id_order, id_order_invoice: id_order_invoice, tipo: tipoDocumento},type : 'firma'};
        sendMessageToPeer(destino,JSON.stringify(msg));
    }
    $("#popupDocumento_"+id_order_invoice+"_"+tipoDocumento+"-screen").trigger("click");
}
function renovarCarrito(){
    $.getJSON("../modules/tpvtienda/classes/actions/actions.php",{token:token, action: 'renovarCarrito',id_employee: id_employee,id_currency: $('#currencyPOS').val(),
        id_address_delivery: $('#id_address_delivery_original').val(),id_address_invoice: $('#id_address_invoice_original').val(),id_shop: id_shop},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(result !=null){
                    id_cart = result.id_cart;
                    id_customer = result.id_customer;
                    id_customer_defecto = result.id_customer;
                    // updateCompra(); no hace falta hacer otra llamada a actualizar la
                    // compra, en lugar de eso llamo a totales y borro la lista con
                    // jquery
                    if(existsHookJS('paymentRequiredCheckout')){
                        hookJS('paymentRequiredCheckout') ;
                    }else{
                        $(".formaPago").first().trigger("click");
                    }
                    $('#compra').hide();
                    $('#compraVacia').show();
                    // pongo a 0 contadores
                    $('#precioTransporte').val(parseFloat(0).toFixed(priceDisplayPrecision));
                    $("#nameTransporte").val(nameTransporte);
                    nameTransporte = nameTransporte_defecto;
                    $(".nameCarrierPOS").html(nameTransporte);
                    $("#carriersButton .nameCarrier").html(nameTransporte);
                    $("#carriersButton span:not(.nameCarrier)").html(parseFloat(0).toFixed(priceDisplayPrecision));
                    $('#totalButton span.total').html(formatCurrency(0, currencyFormat, currencySign, currencyBlank));
                    $('#ivaButton span').html(formatCurrency(0, currencyFormat, currencySign, currencyBlank));
                    $('.descuentosButton span').html(formatCurrency(0, currencyFormat, currencySign, currencyBlank));
                    $('.aDevolverButton').html(0);
                    $(".formaPago").removeClass("ui-state-disabled");
                    $('#pagadoButton').html(formatCurrency(0, currencyFormat, currencySign, currencyBlank));
                    removeCustomer();
                    $("#carriersButton .nameCarrier").html(nameTransporte);
                    $("#carriersButton span:not(.nameCarrier)").html(parseFloat(0).toFixed(priceDisplayPrecision));
                    id_carrier = parseInt(result.id_carrier_defecto);
                    id_carrier_defecto = parseInt(result.id_carrier_defecto);
                }
            });
        }
    });
}
function mostrarInfo(id_product, id_product_attribute){
    $("#stockInfo thead tr").html('');
    $("#stockInfo tbody").html('');
    $.getJSON("../modules/tpvtienda/classes/actions/actions.php",{token:token, action: 'getProductInfo',id_product: id_product, id_product_attribute:id_product_attribute,id_shop: id_shop,
        id_currency: $('#currencyPOS').val(),adminDir:adminDir},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(typeof result ==='object' && result !=null){
                    if( index =='warehouses'){
                        $.each(result, function(index, ware) {
                            $("#stockInfo thead tr").append('<th class="center">'+ware.name+'</th>');
                        });
                    }
                    if( index =='shops'){
                        $.each(result, function(index, shop) {
                            $("#stockInfo thead tr").append('<th class="center">'+shop.name+'</th>');
                        });
                    }
                    if( index == 'p'){
                        $("#popupInfoProd h1 a").attr("href", result.link);
                        $("#infoProd_wholesale_price").html(result.wholesale_price);
                        $("#infoProd_desc_corta").html(result.desc_corta);
                        $("#infoProd_desc_larga").html(result.desc_larga);
                        $("#codigoBarras").html('<iframe src="../modules/tpvtienda/codigosBarras.php?productos='+id_product+"_"+id_product_attribute+'_1&filas=1&columnas=1&id_lang='+id_lang+'&id_employee='+
                                id_employee+'&id_currency='+$('#currencyPOS').val()+'&id_shop='+id_shop+'&offset=0" width="100%" height="200"></iframe>');
                        hookJS('infoProduct',[id_product,id_product_attribute]);
                        if(result.asm == 0 && result.stock != null){
                            $("#warningASM").show();
                        }else{
                            $("#warningASM").hide();
                        }
                        if(result.stock != null){
                            $("#stockInfo tbody").append('<tr>');
                            $.each(result.stock, function(index, ware) {
                                $("#stockInfo tbody tr").append('<td class="center">'+ware+'</td>');
                            });
                            $("#stockInfo tbody").append('</tr>');
                        }

                    }
                }
            });
            $("#popupInfoProd").popup("open");
            $("#popupInfoProd").bind({
               popupafterclose: function(event){modo=0;}
            });
        }
    });

}
function comprobarPago(){
    if(existsHookJS('beforeConfirmPayment')){
        confirmPayment = hookJS('beforeConfirmPayment',{'cart':id_cart}) ;
        if(confirmPayment)
            validaconPago();
    }else{
        confirmPayment = true;
        validaconPago();
    }
}
function comprobar_tarjeta(){
    $.getJSON(token_actions,{ ajax : "1",action:'comprobarTarjeta', id_shop: id_shop,
        id_cart: id_cart,id_employee:id_employee},function(data) {
        if(data != null) {
            $.each(data, function(index, result) {
                if(typeof result.numerosTarjeta ==='object' && result.numerosTarjeta !=null){
                    $("#contNumerosTarjeta").html("");
                    $.each(result.numerosTarjeta, function(index, result) {
                        $("#contNumerosTarjeta").append('<p class="center">**** **** **** '+result+'</p>');
                    });
                    $("#popupComprobarTarjeta").popup("open");
                    $("#popupComprobarTarjeta").bind({
                        popupafterclose: function(event){
                            modo=0;}
                    });
                }

            });
        }
    });
}
function validaconPago(){
    if(confirmPayment){
        var transportistaActual = id_carrier;
        var estadoActual = $("#formaPago").val();
        var camposCustRellenos = 0;
        var totalVenta = $("#totalButton span.total").html();
        totalVenta = totalVenta.replace(/ /g, "");
        totalVenta = totalVenta.replace(",",".");
        if($("#checkoutButton").hasClass("tpv-disabled")) return;
        // compruebo si estan rellenos todos los campos requeridos de customizaciÃƒÂ³n
        $.map( $('.reqCustInput input'), function( elemento ) {
            if( $(elemento).val() == "")
                camposCustRellenos = 1;
        });
        $.map( $('.reqCustImage form'), function( elemento ) {
            if( !$(elemento).hasClass("dz-max-files-reached") ){
                camposCustRellenos = 1;
            }
        });
        if(camposCustRellenos == 0){
            // Compruebo si es una factura a crédito
            if(estadoActual != ""){
                if(transportistaActual != ""){
                    if( devs_pass_neg == 0 || (devs_pass_neg == 1 && dev_pass_neg_flag == 1 ) ||  (devs_pass_neg == 1 && totalVenta >= 0)){
                        if(typeof estadoFactPer != 'undefined' && estadoActual == estadoFactPer){
                            $(".formaAcredito").removeAttr('selected').find('option:first').attr('selected', 'selected');
                            $("#popupAcreditoPrimerPago").popup("open");
                            $("#popupAcreditoPrimerPago").bind({
                                popupafterclose: function(event){
                                    modo=0;}
                            });
                            modo="#popupAcreditoPrimerPago";
                            $("select.formaPagoMixto").selectmenu('refresh');
                        }else if(typeof estadoMixto != 'undefined' && estadoActual == estadoMixto){
                            $("#popupPagoMixto .cantidadPagoMixto").val('');
                            $("#popupPagoMixto .restante").removeClass('justo');
                            $("#popupPagoMixto .unaMas").remove();
                            $("#popupPagoMixto .addPaymentMixto:nth-child(1)").removeAttr('selected').find('option:first').attr('selected', 'selected');
                            $("#popupPagoMixto .addPaymentMixto:nth-child(2)").removeAttr('selected').find('option:nth-child(2)').attr('selected', 'selected');
                            $("#popupPagoMixto input[name=total]").val($("#totalButton span.total").html());
                            $("#popupPagoMixto .cantidadPagoMixto").focus();
                            $("#popupPagoMixto").popup("open");
                            modo="#popupPagoMixto";
                            $("#popupPagoMixto").bind({
                                popupafterclose: function(event){modo=0;}
                            });
                            $("#popupPagoMixto select.formaPagoMixto").selectmenu('refresh');
                            $('#popupPagoMixto .restante').html(parseFloat(totalVenta).toFixed(priceDisplayPrecision));
                            calcularRestante();
                        }else if(popup_cambio_efectivo && ((typeof estadoEfectivo != 'undefined' && estadoActual == estadoEfectivo) || (typeof estadoEfectivo2 != 'undefined' && estadoActual == estadoEfectivo2)) && parseFloat(totalVenta) > 0){
                            $('#popupPagoEfectivo .restante').html(parseFloat(totalVenta).toFixed(priceDisplayPrecision));
                            $('#popupPagoEfectivo .pagado').html(0);
                            $('#popupPagoEfectivo .sobra').html(0);
                            $('#popupPagoEfectivo .restante').addClass('justo');
                            $('#popupPagoEfectivo .sobraCont').hide();
                            $('#popupPagoEfectivo .restanteCont').show();
                            $("#popupPagoEfectivo input[name=total]").val(totalVenta);
                            $("#popupPagoEfectivo").popup("open");
                            modo="#popupPagoEfectivo";
                            valorActual = "";
                            $("#popupPagoEfectivo").bind({
                               popupafterclose: function(event){modo=0;}
                            });
                        }else if(typeof estadoTarjeta != 'undefined' && estadoActual == estadoTarjeta && parseFloat(totalVenta) > 0 && datafonoInicializado){
                            envioPago(parseFloat(totalVenta).toFixed(2));
                            $("#popupPagoTarjeta h2").html(parseFloat(totalVenta).toFixed(2));
                            $("#popupPagoTarjeta h4").hide();
                            $("#popupPagoTarjeta h4").html("");
                            $("#popupPagoTarjeta").popup("open");
                            modo="#popupPagoTarjeta";
                            valorActual = "";
                            $("#popupPagoTarjeta").bind({
                               popupafterclose: function(event){modo=0;}
                            });
                        }else if(typeof estadoQuotation != 'undefined' && estadoActual == estadoQuotation){
                            $("#popupPresupuesto").popup( "open");
                        }else{
                            pago();
                        }
                    }else{
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').html(contrasenaDevs);
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').slideDown('fast');
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').delay(2000).slideUp('fast');
                        $("#pass").addClass('open');
                        confirmPayment = false;
                        anadirMascara();
                    }
                }else{
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').html(transportistaVacio);
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').slideDown('fast');
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').delay(2000).slideUp('fast');
                }
            }else{
                $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').html(formaPagoVacia);
                $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').slideDown('fast');
                $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').delay(2000).slideUp('fast');
            }
        }else{
            $("#"+$.mobile.activePage.attr('id')+' .advertencia #customizedFielsReq').slideDown('fast');
            $("#"+$.mobile.activePage.attr('id')+' .advertencia #customizedFielsReq').delay(3000).slideUp('fast');
        }
    }
}
function suscriboFullscreen(idDiv){
    $(idDiv).fancybox({
        prevEffect    : 'none',
        nextEffect    : 'none',
        helpers    : {
            title    : {
                type: 'outside'
            },
            thumbs    : {
                width    : 50,
                height    : 50
            }
        },
        afterLoad: function (param) {
            var id = param.element[0].rel.replace("fscreen_","");
            var prodSplit = id.split("_");
            $(".fancybox-outer").append('<div class="addCartButton"><a onclick="addCart('+prodSplit[0]+','+
                    prodSplit[1]+',1,\''+param.element[0].title+'\',false);$.fancybox.close()" class="ui-shadow ui-btn-icon-left ui-icon-plus ui-btn ui-corner-all"><span>'+anadir+'</span></a></div>');
        },
     });
}
function getSwiperTPV(){
    if(typeof $.mobile.activePage != "undefined" && $.mobile.activePage.attr('id') == 'aCreditoPage') {
        var swiper = mySwiperProductosAcredito;
    }else if(typeof $.mobile.activePage != "undefined" && $.mobile.activePage.attr('id') == 'pedidoSAT') {
        var swiper = mySwiperProductosSatPage;
    }else if(typeof $.mobile.activePage != "undefined" && $.mobile.activePage.attr('id') == 'pedidoPage') {
        var swiper = mySwiperProductosPedidosPage;
    }else{
        var swiper = mySwiper;
    }
    return swiper;
}
function getCategoriaId(id){
    var seqNumberCat = ++xhrCountCat;
    var swiper = getSwiperTPV();
    // $(".loaderProductos").show();
    if(typeof $.mobile.activePage != "undefined")
        var activePage = $.mobile.activePage.attr('id');
    else
        var activePage = 'TPVTienda';
    if(id == ''){
        inicioProductos = 0;
        id=$('#'+activePage+' select.categorias').val();
    }
    var contadorProductos = 0;
    if(ultimaBusqueda != 'categoriaId'){
        //limpio dos veces porque sino al inicio no se porque salian los productos repetidos
        swiper.removeAllSlides();
        swiper.removeAllSlides();
        $(".contProductos").html("");
        $('.contProductos2 tbody').html("");
    }
//    if($("#listaProd").val() == "list"){
//
//    }else{
//        swiper.appendSlide('<div class="loaderProds ui-loading"><div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div></div>');
//    }
    $.getJSON(token_actions,{action: 'categoriaId', id_cat: id, id_shop: id_shop,inicio: inicioProductos, id_lang: id_lang, id_cart: id_cart,
        inactivos: $('#inactivos').prop('checked'), stockcero: $('#stockcero').prop('checked'), ajax : "1",
        id_currency: $("#currencyPOS").val(), cantidad:cantidadProductos, plantilla:plantilla_pos},function(data) {
        if(data != null){
            var index = 0;
            $.each(data, function(index, result) {
                if(typeof result.p ==='object' && result.p !=null){
                    if($("#listaProd").val() == "list"){
                        var newSlide = "<tr class='contProducto' id='item_"+index+"'><td>";
                        if(typeof result.p.i ==='object' && result.p.i !=null){
                            var contadorImagenes = 0
                            $.each(result.p.i, function(index, img) {
                                newSlide += "<a rel='fscreen_"+result.p.id+"_0' class='fullscreenProduct' title='"+result.p.name+"' href='"+img+"'>"+(contadorImagenes++ == 0 ? "<img src='"+result.p.img+"'/>" : "")+"</a>";
                            });
                        }
                        newSlide += "</td>" +
                        "<td onclick='addCart("+result.p.id+",0,1,\""+result.p.name+"\",true);'>"+result.p.name+"</td>"+
                        "<td class='refList' onclick='addCart("+result.p.id+",0,1,\""+result.p.name+"\",true);'>"+result.p.ref+"</td>"+
                        ((mostrarStock == 1) ? "<td class='stockList' onclick='addCart("+result.p.id+",0,1,\""+result.p.name+"\",true);'>"+result.p.s+"</td>" : "")+
                        ((mostrarPrecios == 1) ? "<td class='precioList' onclick='addCart("+result.p.id+",0,1,\""+result.p.name+"\",true);'>"+result.p.p+"</td>" : "") +
                        "</tr>";
                        $('.contProductos2 tbody').append(newSlide);
                    }else{
                      //   $('.loaderProds').remove();
                        htmlProducto = "<div class='swiper-slide producto' id='item_"+result.p.id+"'>"+
                                            ((mostrarPrecios == 1) ? "<span class='precio'>"+result.p.p+"</span>" : "")+
                                            "<span class='name'>"+result.p.name+"</span>"+
                                                "<img src='"+result.p.img+"'/>";
                        if(typeof result.p.i ==='object' && result.p.i !=null){
                            $.each(result.p.i, function(index, img) {
                                htmlProducto += "<a rel='fscreen_"+result.p.id+"_0' class='fullscreenProduct' title='"+result.p.name+"' href='"+img+"'></a>";
                            });
                        }
                        htmlProducto += ((mostrarStock == 1) ? "<span class='stock'>"+stockText+" "+result.p.s+"</span>" : "");
                        htmlProducto += ((result.p.hookPbottomright != null) ? "<span class='hookBottomRightList'>"+result.p.hookPbottomright+"</span>" : "");
                        htmlProducto += "</div>";
                        swiper.appendSlide(htmlProducto);
                    }
                    contadorProductos++;
                }
                if(typeof result.c ==='object' && result.c !=null){
                    if($("#listaProd").val() == "list" ){
                         var newSlide = "<tr class='categoria' id='cate_"+result.c.id+"' onclick='abrirCategoria("+result.c.id+")'>" +
                                "<td><img src='../modules/tpvtienda/img/folder-icon.png'/></td>" +
                                "<td>"+result.c.name+"</td><td></td><td></td><td></td>"+
                                "</tr>";
                        $('.contProductos2 tbody').prepend(newSlide);
                    }else{
                        swiper.prependSlide("<div class='swiper-slide categoria' id='cate_"+result.c.id+"' onclick='abrirCategoria("+result.c.id+")'></span><span class='name'>"+result.c.name+"</span><img src='../modules/tpvtienda/img/folder-icon.png'/></div>");
                    }
                    contadorProductos++;
                }
            });
            //este error ya no hace falta que sea subsanado en la nueva versión del swiper
//            if(plantilla_pos == "full-width")
//                $("#contProductos").css('width', (contadorProductos * 135)+'px');
            suscriboFullscreen('.contProducto .fullscreenProduct');
            suscriboFullscreen('.producto .fullscreenProduct');
            inicioProductos += cantidadProductos;
        }else{
            if(inicioProductos ==0){
                $("#"+activePage+' .advertencia .nohayresultados').slideDown('fast');
                $("#"+activePage+' .advertencia .nohayresultados').delay(3000).slideUp('fast');
             //    $('.loaderProds').remove();
            }
        }
        if(plantilla_pos == "full-width"){
            //nothing
        }else{
         //   var alturaProd =  $("#"+$.mobile.activePage.attr('id')+' .productos').height();
//            var alturaContProd = $("#"+$.mobile.activePage.attr('id')+' .contProductos').height() + alturaProd;
//            if(alturaContProd < alturaProd * 2 && cantidadProductos ==  contadorProductos)
//                alturaContProd = alturaProd * 2;
            // $("#"+$.mobile.activePage.attr('id')+' .contProductos').css({"height":alturaContProd+'px'});
        }
        // $(".loaderProductos").hide();
    });
    ultimaBusqueda = 'categoriaId';
}
function deleteProduct(id_cart,id_product,id_product_attribute,id_warehouse){
    if(typeof id_warehouse !== "undefined" && id_warehouse !== "")
        var identificador = id_product+'_'+id_product_attribute+"_"+id_warehouse;
    else
        var identificador = id_product+'_'+id_product_attribute;
    var cantidadProd = $('[id^=cantidadProducto_'+identificador+"] .amount").html();
    $('tr#linea_'+identificador).remove();
    $('tr.linea_'+identificador).remove();
    doPlay();
    $("#cantidadTotal").html('-');
    $.getJSON(token_actions,{action: 'deleteProduct',ajax:"1",id_cart: id_cart, id_customer:id_customer,id_shop:id_shop,id_warehouse: id_warehouse,id_employee: id_employee,
        id_product:id_product,id_product_attribute:id_product_attribute,id_currency: $("#currencyPOS").val(),quantity:cantidadProd},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(result.error != null){
                    mostrarError(result.error);
                }
                if(result.ok == 1){// no hay mas productos
                    /*
                     * $('tr#linea_'+id_product+'_'+id_product_attribute).fadeOut("slow");
                     * //con esta linea quito las customizaciones tambien
                     * $('tr.linea_'+id_product+'_'+id_product_attribute).fadeOut("slow");
                     */
                    totales();
                    hookJS('deleteProduct') ;

                }
                if(result.ok == 2){// no hay mas productos
                    $('#compra').hide();
                    $('#compraVacia').show();
                    totales();
                }
                if(result.c != null){
                    $("#cantidadTotal").html(result.c);
                }
                pUpdateCompra();
            });
        }
    });
}
function deleteFileCustomizacion(id_customization,index){
    $.getJSON("../modules/tpvtienda/classes/actions/actionsCustomization.php",{token:token, action:'borrarFileCustomizacion',id_customization:id_customization,index: index},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(result.error != null){
                    mostrarError(result.error);
                }
                if(result.ok == 1){
                    doPlay();
                    $('#compra').hide();
                    $('#compraVacia').show();
                    updateCompra();
                }
            });
        }
    });
}
function deleteCustomizacion(campo){
    var id = $(campo).attr("id");
    var aux = id.replace("deletecust_", "");
    var customization = aux.split("_");
    $.getJSON("../modules/tpvtienda/classes/actions/actionsCustomization.php",{token:token, action:'borrarCustomizacion',id_cart: id_cart, id_shop:id_shop,
        id_customization:customization[0],id_product:customization[2],id_product_attribute:customization[3],id_currency: $("#currencyPOS").val()},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(result.error != null){
                    mostrarError(result.error);
                }
                if(result.ok == 1){
                    doPlay();
                    $('#compra').hide();
                    $('#compraVacia').show();
                    updateCompra();
                }
            });
        }
    });
}
function deleteDevolucionOrderDetail(id_order_detail){
    $.getJSON(token_actions,{action:'deleteOrderDetail', ajax:"1",id_shop:id_shop,id_employee: id_employee, id_order_detail: id_order_detail },function(data) {
        if(data == 1)
            updateCompra();
    });
}
function deleteDevolucionRapida(id_product, id_product_attribute){
    $.getJSON(token_actions,{action:'deleteDevolucionRapida',ajax:"1", id_shop:id_shop,id_employee: id_employee, id_cart: id_cart,
        id_product: id_product, id_product_attribute:id_product_attribute },function(data) {
        if(data == 1)
            updateCompra();
    });
}
function anadirPayment(id_order,formaPago,amount,pagado){
    if(pagado == 0)
        pagado = amount;
    if($.mobile.activePage.attr('id') == "aCreditoPage")
        var devuelto = $("#"+$.mobile.activePage.attr('id')+' .popupPagoPayment .aDevolverButton').html();
    if($.mobile.activePage.attr('id') == "pedidoSAT")
        var devuelto = $('#popupPagoSatPagePayment .aDevolverButton').html();
    if($.mobile.activePage.attr('id') == "pedidoPage")
        var devuelto = $("#"+$.mobile.activePage.attr('id')+' .popupPagoPayment .aDevolverButton').html();
    $(".listadoPedidosPage h1").html(pedidosTxT);
    $.getJSON("../modules/tpvtienda/classes/actions/actionsAcredito.php",{token:token, action:'addOrderPayment', formaPago:formaPago, amount:amount, id_order: id_order, id_shop: id_shop,
        pagado:pagado,devuelto:devuelto,id_lang:id_lang, id_currency: $('#currencyPOS').val(),id_employee: id_employee,pagoEnPedido:pagoEnPedido,id_cajas:cajaEnUso},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(result.error != null){
                    error = true;
                    mostrarError(result.error);
                    if($.mobile.activePage.attr('id') == "aCreditoPage")
                        abrirFactCred(id_order);
                    if($.mobile.activePage.attr('id') == "pedidoSAT")
                        abrirPedidoSAT(id_order);
                     if($.mobile.activePage.attr('id') == "pedidoPage")
                        getOrder(id_order);
                }
                if(result.id_order_payment != null){
                     if($.mobile.activePage.attr('id') == "pedidoPage")
                        getOrder(id_order);
                    if($.mobile.activePage.attr('id') == "pedidoSAT")
                        abrirPedidoSAT(id_order);
                    if($.mobile.activePage.attr('id') == "aCreditoPage")
                        actualizarPagoAcredito(id_order);
                    getTicketPayment(id_order,result.id_order_payment,true);
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia #pagoIntroducido').slideDown('fast');
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia #pagoIntroducido').delay(5000).slideUp('fast');
                }
                if(result.pagadoTodo != null){
                    if($.mobile.activePage.attr('id') == "aCreditoPage")
                        abrirFactCred(id_order);
                    if($.mobile.activePage.attr('id') == "pedidoSAT")
                        abrirPedidoSAT(id_order);
                     if($.mobile.activePage.attr('id') == "pedidoPage")
                        getOrder(id_order);
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html(pagadoTodoTxt);
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').slideDown('fast');
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(6000).slideUp('fast');
                }
            });
            if(datos_tarjeta){
                $("#"+$.mobile.activePage.attr('id')+' .advertencia .titularTarjeta').val('');
                $("#"+$.mobile.activePage.attr('id')+' .advertencia .numeroTarjeta').val('');
                $("#"+$.mobile.activePage.attr('id')+' .tCredito').show();
                if(formaPago == estadoTarjeta){
                    if(tarjeta_obligatoria == 1){
                        $("#"+$.mobile.activePage.attr('id')).append('<div class="maskTPVTienda maskTarjetaOblig"></div>');
                        $("#"+$.mobile.activePage.attr('id')+' .maskTarjetaOblig').show();
                        $("#"+$.mobile.activePage.attr('id')+' .maskTarjetaOblig').on("click touchstart", function(event){
                            if($("#"+$.mobile.activePage.attr('id')+' .titularTarjeta').val() != "" && $("#"+$.mobile.activePage.attr('id')+' .numeroTarjeta').val() != ""){
                                $("#"+$.mobile.activePage.attr('id')+' .maskTarjetaOblig').hide();
                                $("#"+$.mobile.activePage.attr('id')+' .tCredito').hide();
                                modo=0;
                            }else{
                                $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').html(rellenaCamposTxt);
                                $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').slideDown('fast');
                                $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').delay(2000).slideUp('fast');
                            }
                        });
                    }
                }
            }else{
                $("#"+$.mobile.activePage.attr('id')+' .tCredito').hide();
            }
        }
        $(".loaderTicket").hide();
    });
}
function deletePayment(id_payment,id_order){
    $.getJSON("../modules/tpvtienda/classes/actions/actionsOrdersAlert.php",{token:token, action:'deleteOrderPayment', id_payment: id_payment, cajaEnUso:cajaEnUso,
        id_employee: id_employee, id_shop: id_shop,id_currency: $('#currencyPOS').val()},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(result.error != null){
                    error = true;
                    mostrarError(result.error);
                }
                if(result.ok != null){
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html(borradoPagoEnPedido);
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').slideDown('fast');
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(6000).slideUp('fast');
                    if($.mobile.activePage.attr('id') == "pedidoPage")
                        getOrder(id_order);
                    if($.mobile.activePage.attr('id') == "pedidoSAT")
                        abrirPedidoSAT(id_order);
                    if($.mobile.activePage.attr('id') == "aCreditoPage")
                        actualizarPagoAcredito(id_order);
                }
            });
        }
    });
}
function crearDescuento(tipoSubmit){
    var codigo = "";
    if(tipoSubmit !='crearImprimirDescuentoDevolucion'){
        var nombre = $("#"+$.mobile.activePage.attr('id')+' .anadirDescuento input[name="nombre"]').val();
        var valor = $("#"+$.mobile.activePage.attr('id')+' .anadirDescuento input[name="valorDescuento"]').val();
        codigo = $("#"+$.mobile.activePage.attr('id')+' .anadirDescuento input[name="code"]').val();
        var tipo = $("#"+$.mobile.activePage.attr('id')+' .anadirDescuento select[name=typeDiscount]').val();
        var uso_parcial = $("#"+$.mobile.activePage.attr('id')+' .anadirDescuento select[name="uso_parcial"]').val();
        var prioridad = $("#"+$.mobile.activePage.attr('id')+' .anadirDescuento input[name="prioridad"]').val();
        var descripcion = $("#"+$.mobile.activePage.attr('id')+' .anadirDescuento input[name="descripcion"]').val();
        var envio_gratis = $("#"+$.mobile.activePage.attr('id')+' .anadirDescuento select[name="envio_gratis"]').val();
        var total_disponible = $("#"+$.mobile.activePage.attr('id')+' .anadirDescuento input[name="total_disponible"]').val();
        var disponible_usuario = $("#"+$.mobile.activePage.attr('id')+' .anadirDescuento input[name="disponible_usuario"]').val();
    }else{
        var chars = "123456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
        for (var i = 1; i <= 8; ++i)
            codigo += chars.charAt(Math.floor(Math.random() * chars.length));
        var nombre = devolucionEnDescuento;
        var valor = $('#devolucionesTipo #amount_devolucion').val();
        var tipoSubmit = 'crearImprimirDescuentoDevolucion';
        var tipo = 'amount';
        var uso_parcial = 'on';
        var prioridad = 1;
        var descripcion = "";
        var envio_gratis = "off";
        var total_disponible = 1;
        var disponible_usuario = 1;
    }
    $(".loaderTicket").show();
    $(".submitAnadirDescuento").addClass("ui-state-disabled");
    if($.mobile.activePage.attr('id') == "TPVTienda")
        var carrito = id_cart;
    if($.mobile.activePage.attr('id') == "pedidoPage" || $.mobile.activePage.attr('id') == "aCreditoPage")
        var carrito = id_cart_pedido;
    $.getJSON(token_actions,{action:'crearDescuento', ajax:"1",adminDir:adminDir,id_currency: $("#currencyPOS").val(), id_shop: id_shop, id_lang:id_lang,
        nombre : nombre, descripcion : descripcion, codigo : codigo, valor : valor, tipo: tipo, uso_parcial: uso_parcial, prioridad: prioridad, envio_gratis: envio_gratis,
        total_disponible: total_disponible, disponible_usuario: disponible_usuario, id_cart: carrito},function(data) {
        if(data != null){
            var id_desc = 0;
            $(".submitAnadirDescuento").delay(2000).removeClass("ui-state-disabled");;
            $.each(data, function(index, result) {
                if(result.error != null){
                    mostrarError(result.error);
                    $(".submitAnadirDescuento").delay(2000).button('enable');
                }
                if(typeof result.desc ==='object' && result.desc != null){
                    if(tipoSubmit == 'crearImprimirDescuentoDevolucion'){
                        getTicketDescuento(result.desc.id);
                        $("#id_descuento_devolucion").val(result.desc.id);
                    }
                    if(tipoSubmit == 'submitCrearImprimirDescuento'){
                        getTicketDescuento(result.desc.id);
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html(descuento+": "+result.desc.id+" "+descuento2+": "+result.desc.code+" "+creado);
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').slideDown('fast');
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(6000).slideUp('fast');
                        $("#"+activePage+' .anadirDescuentoForm').val("");
                    }
                    if(tipoSubmit == 'submitGuardarAnadirDescuento'){
                        addDiscount(result.desc.id);
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html(descuento+": "+result.desc.id+" "+descuento2+": "+result.desc.code+" "+creado);
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').slideDown('fast');
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(6000).slideUp('fast');
                        $("#"+$.mobile.activePage.attr('id')+' .anadirDescuentoForm').val("");
                        $('.maskTPVTienda').trigger("click");
                    }
                }
                //limpio
                $("#"+$.mobile.activePage.attr('id')+" .anadirDescuentoForm input[name=nombre]").val("");
                $("#"+$.mobile.activePage.attr('id')+" .anadirDescuentoForm input[name=descripcion]").val("");
                $("#"+$.mobile.activePage.attr('id')+" .anadirDescuentoForm input[name=valorDescuento]").val("");
                gencodeTPV(8);
                $("#"+$.mobile.activePage.attr('id')+" .anadirDescuentoForm input[name=disponible_usuario]").val(1);
                $("#"+$.mobile.activePage.attr('id')+" .anadirDescuentoForm input[name=total_disponible]").val(1);
                $('#'+$.mobile.activePage.attr('id')+ ' select[name=prioridad]').prop('selectedIndex',0).selectmenu().selectmenu('refresh');
                $('#'+$.mobile.activePage.attr('id')+ ' select[name=typeDiscount]').prop('selectedIndex',0).selectmenu().selectmenu('refresh');
          });
            $(".loaderTicket").hide();
        }
    });
}
function deleteVoucherOrder(id_order,id_order_cart_rule){
    $.getJSON(token_actions,{action:'borrarDescuentoPedido', ajax:"1",adminDir:adminDir,id_currency: $("#currencyPOS").val(), id_lang:id_lang,
        id_shop: id_shop,id_order: id_order, id_order_cart_rule:id_order_cart_rule},function(data) {
        if(data != null){
            if($.mobile.activePage.attr('id') == "pedidoPage")
                getOrder(id_order_global);
            if($.mobile.activePage.attr('id') == "aCreditoPage")
                actualizarPagoAcredito(id_order_global);
        }
    });
}
function anadirProducto(){
    var cantidadProd = $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="cantidad"]').val();
    var contadorCombinaciones = 0;
    var flagCombExistentes = 0;
    var combis = [];
    var arrayVarPlugins = [];
    doPlay();
    while(contadorCombinaciones <= contCombs){
        combis[contadorCombinaciones] = [];
        combis[contadorCombinaciones]['att'] = [];
        $(".comb_"+contadorCombinaciones+" select.attributesToChoose").each(function(index,result){
            var nameAttr = result.name.replace("att_","");
            nameAttr = nameAttr.split("_");
            var opcionElegida = $('select[name='+result.name+']').val();
            if(opcionElegida != ""){
                flagCombExistentes = 1;
                combis[contadorCombinaciones]['att'][nameAttr[0]] = opcionElegida;
            }
        });
        if(combis[contadorCombinaciones]['att'].length > 0) {
               if(contadorCombinaciones > 0){
                combis[contadorCombinaciones]['ref'] = $('.comb_'+contadorCombinaciones+' input[name=reference_comb_'+contadorCombinaciones+']').val();
                combis[contadorCombinaciones]['precio'] = $('.comb_'+contadorCombinaciones+' input[name=impacto_precio_comb_'+contadorCombinaciones+']').val();
                combis[contadorCombinaciones]['cant'] = $('.comb_'+contadorCombinaciones+' input[name=cantidad_comb_'+contadorCombinaciones+']').val();
                combis[contadorCombinaciones]['peso'] = $('.comb_'+contadorCombinaciones+' input[name=impacto_peso_comb_'+contadorCombinaciones+']').val();
                combis[contadorCombinaciones]['iva'] = $('.comb_'+contadorCombinaciones+' input[name=iva_comb_'+contadorCombinaciones+']').val();
            }else{
                combis[contadorCombinaciones]['ref'] = $('.comb_'+contadorCombinaciones+' input[name=reference_comb]').val();
                combis[contadorCombinaciones]['precio'] = $('.comb_'+contadorCombinaciones+' input[name=impacto_precio_comb]').val();
                combis[contadorCombinaciones]['cant'] = $('.comb_'+contadorCombinaciones+' input[name=cantidad_comb]').val();
                combis[contadorCombinaciones]['peso'] = $('.comb_'+contadorCombinaciones+' input[name=impacto_peso_comb]').val();
                combis[contadorCombinaciones]['iva'] = $('.comb_'+contadorCombinaciones+' input[name=iva_comb]').val();
            }
        }else{
             combis.splice(contadorCombinaciones,1);
        }
        contadorCombinaciones++;
    }
    if(flagCombExistentes == 0)   {
        combis = "";
    }

    $('#'+$.mobile.activePage.attr('id')+ ' .pluginsPOSAddProduct .row').each(function(index,result){
        arrayVarPlugins.push({'name' : $(result).find('input[name^=plugin_]').attr('name'),'value': $(result).find('input[name^=plugin_]:checked').val()});
    });
    $.getJSON("../modules/tpvtienda/classes/actions/actionsAnadirProducto.php", { token : token, action : 'anadirProducto', id_shop : id_shop,
        nombre : $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="nombre"]').val(),
        reference : $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="reference"]').val(),
        precio : $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="precioSinIva"]').val(),
        id_tax_rules : $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm select.anadirProducto_id_tax').val(),
        cantidad : cantidadProd,
        url : $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="url"]').val(),
        fotos : $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="fotos"]').val(),
        categorias : $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="categoriasNuevoProducto"]').val(),
        marca:$('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm select[name="selectMarcasNuevoProducto"]').val(),

        visibilidad : $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm select[name="visibility"]').val(),
        ean13 : $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="ean13"]').val(),
        desc_corta : $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm textarea[name="desc_corta"]').val(),
        desc_larga : $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm textarea[name="desc_larga"]').val(),
        combis : multiDimensionArray2JSON(combis),
        id_employee : id_employee,
        stock_avanzado : $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="stock_avanzado"]').prop('checked'),
        variables_plugin : JSON.stringify(arrayVarPlugins),
        tipoStock : $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="stockNuevoProd"]:checked').val()
        },function(data) {
        if(data != null){
            if($.mobile.activePage.attr('id') == "aCreditoPage"){
                $.each(data, function(index, result) {
                    addProductOnOrder(result.id_product,0,1,'');
                });
            }else if($.mobile.activePage.attr('id') == "pedidoSAT"){
                $.each(data, function(index, result) {
                    addProductOnOrder(result.id_product,0,1,'');
                });
            }else if($.mobile.activePage.attr('id') == "pedidoPage"){
                $.each(data, function(index, result) {
                    addProductOnOrder(result.id_product,0,1,'');
                });
            }else{
                $.each(data, function(index, result) {
                    addCart(result.id_product,0,cantidadProd,true);

                    if($('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="borrar_despues"]').prop('checked')){
                        borraProductos += result.id_product+",";
                    }
                });
            }
            $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input:not(:radio,[type=hidden])').val('');
            $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name=fotos]').val('');
            Dropzone.forElement('#'+$.mobile.activePage.attr('id')+ ' .subidaImagenesProducto').removeAllFiles(true);
            $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="cantidad"]').val(1);
            if(forzarStockAvanzado)
                $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="stock_avanzado"]').prop('checked', true).checkboxradio('refresh');
            else
                $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="stock_avanzado"]').prop('checked', false).checkboxradio('refresh');
            if(borrar_producto_por_defecto == 0)
                $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="borrar_despues"]').prop('checked', false).checkboxradio('refresh');
            else
                $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="borrar_despues"]').prop('checked', true).checkboxradio('refresh');

            $('#'+$.mobile.activePage.attr('id')+ ' .categoriasElegidas').html('');
            $('#'+$.mobile.activePage.attr('id')+' input[name=categoriasNuevoProducto]').val("");
            $('#'+$.mobile.activePage.attr('id')+ ' .tabsAnadirProducto select').prop('selectedIndex',0).selectmenu().selectmenu('refresh');
            $('#'+$.mobile.activePage.attr('id')+ ' select.anadirProducto_id_tax').prop('selectedIndex',$('#'+$.mobile.activePage.attr('id')+' .anadirProducto_id_tax option[value="'+id_tax_rule_por_defecto+'"]').index()).selectmenu('refresh');
            $('#'+$.mobile.activePage.attr('id')+ ' .comb_0 input[name=reference_comb]').val("");
            $('#'+$.mobile.activePage.attr('id')+ ' .comb_0 input[name=impacto_precio_comb]').val("");
            $('#'+$.mobile.activePage.attr('id')+ ' .comb_0 input[name=impacto_peso_comb]').val("");
            $('#'+$.mobile.activePage.attr('id')+ ' .comb_0 select').prop('selectedIndex',0).selectmenu().selectmenu('refresh');
            //al introducir un producto vuelvo a mostrar el pedido a crédito

            while (contCombs > 0){
                $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contCombs).remove();
                contCombs--;
            }
        }
    });
}

function deleteDiscount(id_cart,id_cart_rule){
    $.getJSON(token_actions,{action:'deleteDiscount', ajax:"1",adminDir:adminDir,id_currency: $("#currencyPOS").val(), id_lang:id_lang,
        id_cart_rule: id_cart_rule,id_cart: id_cart,id_shop:id_shop},function(data) {
        if(data == 1){
            $('#cart_rule_'+id_cart_rule).fadeOut("slow");
            updateCompra();
        }else{
        }
    });
}
function addDiscount(id){
    if($.mobile.activePage.attr('id') == "TPVTienda")
        var carrito = id_cart;
    if($.mobile.activePage.attr('id') == "pedidoPage" || $.mobile.activePage.attr('id') == "aCreditoPage")
        var carrito = id_cart_pedido;
    $.getJSON(token_actions,{action:'addDiscount', ajax:"1",adminDir:adminDir,id_currency: $("#currencyPOS").val(), id_lang:id_lang,
        descuento: id,id_cart: carrito, tax:tax, id_shop:id_shop},function(data) {
        $.each(data, function(index, result) {
            if(result.error != null){
                mostrarError(result.error);
            }else{
                if(result.ok != null){
                    if($.mobile.activePage.attr('id') == "TPVTienda"){
                        updateCompra();
                        getVouchers();
                    }
                    if($.mobile.activePage.attr('id') == "pedidoPage")
                        getOrder(id_order_global);
                    if($.mobile.activePage.attr('id') == "aCreditoPage")
                        actualizarPagoAcredito(id_order_global);
                }
            }
        });
    });
}
function createDiscountFidelity(){
    $.getJSON("../modules/tpvtienda/classes/actions/actionsFidelity.php",{token:token, action:'createDiscountFidelity',id_cart: id_cart,id_currency: $("#currencyPOS").val(),
        id_shop: id_shop},function(data) {
        if(data != ''){
            $.each(data, function(index, result) {
                if(result.error != null){
                    mostrarError(result.error);
                }else{
                    if(result.id != null){
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html( descuento+" id: "+result.id+" "+creado);
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').slideDown('fast');
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(5000).slideUp('fast');
                        getDiscounts();
                        getLoyalty();
                    }
                }
            });
            updateCompra();
        }
    });
}
function createDiscountFidelityAIOR(){
    $.getJSON("../modules/tpvtienda/classes/actions/actionsFidelityAIOR.php",{token:token, action:'createDiscountFidelity',id_cart: id_cart,
        id_currency: $("#currencyPOS").val(), id_shop: id_shop},function(data) {
        if(data != ''){
            $.each(data, function(index, result) {
                if(result.error != null){
                    mostrarError(result.error);
                }else{
                    if(result.id != null){
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html( descuento+" id: "+result.id+" "+creado);
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').slideDown('fast');
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(5000).slideUp('fast');
                        getDiscounts();
                        getLoyalty();
                    }
                }
            });
            updateCompra();
        }
    });
}
function createDiscountFidelityAL(){
    $.getJSON("../modules/tpvtienda/classes/actions/actionsFidelityAl.php",{token:token, action:'createDiscountFidelity',id_cart: id_cart,
        id_currency: $("#currencyPOS").val(), id_shop: id_shop},function(data) {
        if(data != ''){
            $.each(data, function(index, result) {
                if(result.error != null){
                    mostrarError(result.error);
                }else{
                    if(result.id != null){
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html( descuento+" id: "+result.id+" "+creado);
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').slideDown('fast');
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(5000).slideUp('fast');
                        getDiscounts();
                        getLoyalty();
                    }
                }
            });
            updateCompra();
        }
    });
}
function createDiscountFidelityLEP(){
    $.getJSON("../modules/tpvtienda/classes/actions/actionsFidelityLEP.php",{token:token, action:'createDiscountFidelity',id_cart: id_cart,
        id_currency: $("#currencyPOS").val(), id_shop: id_shop},function(data) {
        if(data != ''){
            $.each(data, function(index, result) {
                if(result.error != null){
                    mostrarError(result.error);
                }else{
                    if(result.id != null){
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html( descuento+" id: "+result.id+" "+creado);
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').slideDown('fast');
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(5000).slideUp('fast');
                        getDiscounts();
                        getLoyalty();
                    }
                }
            });
            updateCompra();
        }
    });
}
function createDiscountFidelityETS(){
    $.getJSON("../modules/tpvtienda/classes/actions/actionsFidelityETS.php",{token:token, action:'createDiscountFidelity',id_cart: id_cart,
        id_currency: $("#currencyPOS").val(), id_shop: id_shop},function(data) {
        if(data != ''){
            $.each(data, function(index, result) {
                if(result.error != null){
                    mostrarError(result.error);
                }else{
                    if(result.id != null){
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html( descuento+" id: "+result.id+" "+creado);
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').slideDown('fast');
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(5000).slideUp('fast');
                        getDiscounts();
                        getLoyalty();
                    }
                }
            });
            updateCompra();
        }
    });
}
function aparcar(){
    $("#popupNombreAparcado").popup( "open");
}
function aparcarCarrito(){
    $.getJSON("../modules/tpvtienda/classes/actions/actionsAparcados.php",{token:token, action: 'aparcarCarrito',id_cart:id_cart,nombre: $('#nombreAparcado').val(),
        id_currency:$("#currencyPOS").val(),id_shop: id_shop, id_employee: id_employee},function(data) {
            $.each(data, function(index, result) {
                if(result.error != null)
                    mostrarError(result.error);
                if(result.id_cart != null){
                    renovarCarrito();
                    $("#messageOrder").val('');
                    $('#nombreAparcado').val('');
                    $("#idCarrito").html(result.id_cart);
                    $("#nombreCarrito").html(result.nombre);
                    $("#"+$.mobile.activePage.attr('id')+" .advertencia, #"+$.mobile.activePage.attr('id')+' .advertencia #confAparcado').slideDown('fast');
                    $("#"+$.mobile.activePage.attr('id')+" .advertencia, #"+$.mobile.activePage.attr('id')+' .advertencia #confAparcado').delay(5000).slideUp('fast');
                    $("#popupNombreAparcado").popup( "close");
                }
            });
    });
}
function borrarProductos(){
    $('#compra').hide();
    $('#compraVacia').show();
    $.getJSON("../modules/tpvtienda/classes/actions/actions.php",{token:token, action: 'deleteProducts',id_cart:id_cart,id_shop: id_shop,
        id_currency:$("#currencyPOS").val(),id_employee: id_employee},function(data) {
        if(data == 1){
            $('#compra > tbody').html('');
            doPlay();
            renovarCarrito();
            nameTransporte = nameTransporte_defecto;
        }else{
            $.each(data, function(index, result) {
                if(result.error != null)
                    mostrarError(result.error);
            });
        }
        $("#titleCliente").hide(); //para las devoluciones
        $(".contClientePedidoDevs .ui-input-text").show(); //para las devoluciones
    });
    if(nota_oblig != 1){
        $("#checkoutButton").removeClass("tpv-disabled");
        $("#checkoutButton").tooltip('disable');
    }
    $('#descuentosAplicados').html('');
    $("#messageOrder").val('');

}
function getDiscountbyCode(code){
    $.getJSON(token_actions,{action:'getDiscounts', ajax:"1",adminDir:adminDir,id_currency: $("#currencyPOS").val(), filter : code, id_cart: id_cart,
        id_shop: id_shop,id_lang:id_lang},function(data) {
        if(data != ''){
            $.each(data, function(index, result) {
                if(typeof result.descuento == 'object')
                    addDiscount(result.descuento.id);
                if(result.error == 'noproducts')
                    buscoCodebar(code);
            });
        }else{
            buscoCodebar(code);
        }
    });
}
function getVouchers(){
    var reduccion = "";
    var html = "";
    if($.mobile.activePage.attr('id') == "TPVTienda")
        var carrito = id_cart;
    if($.mobile.activePage.attr('id') == "pedidoPage" || $.mobile.activePage.attr('id') == "aCreditoPage")
        var carrito = id_cart_pedido;

    // $("#"+$.mobile.activePage.attr('id')+' .descuentoForm').hide();
    $.getJSON(token_actions,{action:'getVouchers', ajax:"1",adminDir:adminDir,id_currency: $("#currencyPOS").val(), id_cart: carrito, id_shop: id_shop, id_lang:id_lang},function(data) {
        if(data != ''){
            $.each(data, function(index, result) {
                if(result.error == 'vacio'){
                    $("#"+$.mobile.activePage.attr('id')+' .descuentosAplicados').hide();
                }else{
                    $("#"+$.mobile.activePage.attr('id')+' .descuentosAplicados').show();
                    $("#"+$.mobile.activePage.attr('id')+' .descuentosAplicados .descuentosAplicadosTable tbody').html("");
                    $.each(result, function(index, voucher) {
                       $("#"+$.mobile.activePage.attr('id')+' .descuentosAplicados .descuentosAplicadosTable tbody').append('<tr><td>'+voucher.code+'</td><td>'+voucher.desc+'</td><td><a id="cart_rule_14" alt="" onclick="deleteDiscount(\''+voucher.id_cart+'\',\''+voucher.id+'\')" class="ui-link"><i class="icon-trash"></i></a></td></tr>');
                    });
                }
            });
        }
    });
}
function getDiscounts(){
    var reduccion = "";
    var html = "";
    if($.mobile.activePage.attr('id') == "TPVTienda")
        var carrito = id_cart;
    if($.mobile.activePage.attr('id') == "pedidoPage" || $.mobile.activePage.attr('id') == "aCreditoPage")
        var carrito = id_cart_pedido;

    // $("#"+$.mobile.activePage.attr('id')+' .descuentoForm').hide();
    $.getJSON(token_actions,{action:'getDiscounts', ajax:"1",adminDir:adminDir,id_currency: $("#currencyPOS").val(),id_lang:id_lang,
        filter : $("#"+$.mobile.activePage.attr('id')+' .codDescuento').val(), id_cart: carrito, id_shop: id_shop},function(data) {
        if(data != ''){
            $.each(data, function(index, result) {
                if(result.error == 'noproducts'){
                    $("#"+$.mobile.activePage.attr('id')+' .descuentosTable').hide();
                    $("#"+$.mobile.activePage.attr('id')+' .noHayProductos').show();
                    $("#"+$.mobile.activePage.attr('id')+' .noHayDescuentos').hide();
                }else{
                    if(result.error != null)
                        mostrarError(result.error);
                    $("#"+$.mobile.activePage.attr('id')+' .descuentosTable').show();
                    $("#"+$.mobile.activePage.attr('id')+' .noHayProductos').hide();
                    $("#"+$.mobile.activePage.attr('id')+' .noHayDescuentos').hide();
                }
                if(typeof result.descuento == 'object'){
                   //  $("#"+$.mobile.activePage.attr('id')+' .descuentoForm').show();
                    if(parseFloat(result.descuento.percent).toFixed(priceDisplayPrecision) != parseFloat(0).toFixed(priceDisplayPrecision))
                        reduccion = result.descuento.percent + "%";
                    else
                        reduccion = result.descuento.amount;
                    html += '<tr id="desc_'+result.descuento.id+'">'+
                              '<td width="13%" onclick="addDiscount('+result.descuento.id+')" class="center">'+result.descuento.name+'</td>'+
                              '<td width="28%" onclick="addDiscount('+result.descuento.id+')" class="center">'+result.descuento.codigo+'</td>'+
                              '<td width="28%" onclick="addDiscount('+result.descuento.id+')" class="center">'+result.descuento.date_from+'</td>'+
                              '<td width="28%" onclick="addDiscount('+result.descuento.id+')" class="center">'+result.descuento.date_to+'</td>'+
                              '<td width="28%" onclick="addDiscount('+result.descuento.id+')" class="center">'+reduccion+'</td>'+
                              '<td><a href="#" onclick="getTicketDescuento('+result.descuento.id+')">Ticket</a></td>'+
                           '</tr>';
                }
            });
        }else{
            $("#"+$.mobile.activePage.attr('id')+' .descuentosTable tbody tr').remove();
            $("#"+$.mobile.activePage.attr('id')+' .noHayProductos').hide();
            $("#"+$.mobile.activePage.attr('id')+' .noHayDescuentos').show();
        }
        $("#"+$.mobile.activePage.attr('id')+' .anadirDescuentos table.descuentosTable tbody').html(html);
    });
}
function addCart(id_product,attribute,cantidadProd,name,focus) {
    if(cantidadProd == null)
        cantidadProd = 1;
    if(id_product == "")
        return;
    // $(".loaderProductos").show();
    $("#checkoutButton").addClass("tpv-disabled");
    $("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones').popup( "close");
    var hayCombinaciones = false;
    var grupos = Array();

    if (typeof tablaCombinaciones == 'object' || (typeof $.fn.DataTable != "undefined" && $.fn.DataTable.isDataTable("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones table.productosComb') )) {
        $("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones table.productosComb').DataTable().destroy();
    }

    $.getJSON(token_actions,{action: 'addCart',ajax:"1",id_cart: id_cart,id_shop: id_shop, id_product:id_product,id_currency: $("#currencyPOS").val(),
        attribute:attribute,cantidad:cantidadProd,id_lang:id_lang, id_employee:id_employee,id_warehouse:$("input[name=almacen_predeterminado]:checked").val() },function(data) {
        $.each(data, function(index, result) {
            if(result.error != null){
                if(result.error == "error029"){
                    mostrarError(result.error);
                    renovarCarrito();
                }else if(result.error == "error009"){  // caso para booking product
                    mostrarError(result.error);
                }else{
                    doNotFound();
                    sinStock(result.error);
                }
            }
            if(result.ok == 'ok'){
                doPlay();
                updateCompra();
                if(obligatorio_cantidad){
                    setTimeout(() => {$("#"+$.mobile.activePage.attr('id')+' tr[id^=linea_'+id_product+'_'+attribute+'] .qty').trigger("click");}, 2000)

                }
                if($(window).width() > 960 && focus){
                    if(redireccionarProductos == 1){
                        $("#entradaCodigo .order_query").val('');
                        $("#entradaCodigo .order_query").focus();
                        $("select.categorias").selectmenu();
                        $("select.categorias").prop('selectedIndex',0).selectmenu('refresh');
                        inicioProductos = 0;
                        var swiper = getSwiperTPV();
                        swiper.removeAllSlides();
                        swiper.removeAllSlides();
                        $(".contProductos").html("");
                        $(".contProductos2 tbody").html("");
                        getCategoriaId(categoria_inicio_productos);
                    }
                }
            }
            if(typeof result.groups === 'object' && result.groups != null){
                hayCombinaciones = true;
                $("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones .productosComb thead tr th.anadido').remove();
                grupos = result.groups;
                $.each(result.groups, function(index, group) {
                    $("<th class='anadido group_"+index+"'>"+group+"</th>").insertBefore("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones .productosComb thead th.camposFijos:first');
                });
            }
            if(typeof result.combinaciones === 'object' && result.combinaciones != null){
                hayCombinaciones = true;
                $("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones h1').html(name);
                $("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones .productosComb tbody').html("");
                $.each(result.combinaciones, function(index, combinacion) {
                    var groupsText = "";
                    $.each(grupos, function(index, group) {
                        if(typeof combinacion.groups[index] != 'undefined')
                            groupsText += '<td>'+combinacion.groups[index]+'</td>';
                        else{
                            groupsText += '<td></td>';
                        }
                    });
                    $("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones .productosComb tbody').append('<tr class="combProd" onclick="addCart('+id_product+','+combinacion.id_product_attribute+',1,\'\',true)">'+groupsText+'<td>'+combinacion.qty+'</td><td>'+combinacion.price+'</td></tr>');
                });
            }

        });
        if(hayCombinaciones){
            var dontSort = [];
            $("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones table.productosComb thead th').each(function () {
                if ($(this).hasClass( 'anadido')) {
                   dontSort.push( {
                      "bSortable": false
                   });
                }else {
                   dontSort.push( null );
                }
            });
            if(orden_combs == ""){
                var indiceOrdenCombs = $("#"+$.mobile.activePage.attr('id')+" .popupCombinaciones table.productosComb thead th").length-2;
            }else{
                var indiceOrdenCombs = $("#"+$.mobile.activePage.attr('id')+" .popupCombinaciones table.productosComb thead th.group_"+orden_combs ).index();
            }
            if(indiceOrdenCombs == -1){
                indiceOrdenCombs = 1;
            }
            var pageLength = 10;
            var heightFondo = $(window).height();
            if(heightFondo > 1200){
                pageLength = 26;
            }else if(heightFondo > 1000){
                pageLength = 22;
            }else if(heightFondo > 900){
                pageLength = 18;
            }else if(heightFondo > 800){
                pageLength = 16;
            }else if(heightFondo > 500){
                pageLength = 13;
            }
            tablaCombinaciones = $("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones table.productosComb').DataTable({
                  initComplete: function () {
                   var api = this.api();
                    var col = 0;
                    api.columns().indexes().flatten().each( function ( i ) {
                        var column = api.column( i );
                        var title = column.header();
                        var pasadas = 0;
                        if(!$(title).hasClass('camposFijos')){

                            var tituloGrupo = "";
                            $.each(grupos, function(index, group) {
                                if(col == pasadas)
                                    tituloGrupo = grupos[index];
                                pasadas++;
                            });
                            var select = $('<select><option value="">'+tituloGrupo+'</option></select>')
                                .appendTo( $(column.header()).empty() )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );
                                    column.search( val ? '^'+val+'$' : '', true, false ).draw();
                                } );
                            column.data().unique().sort().each( function ( d, j ) {
                                   if(d != '')
                                       select.append( '<option value="'+d+'">'+d+'</option>')
                            });
                        }
                         col++ ;
                    } );
                    },
                "sDom": '<"top">rt<"bottom"lp><"clear">',
                order: [[ indiceOrdenCombs, "desc" ]],
                "aoColumns": dontSort,
                "bPaginate":true,
                "pageLength": pageLength,
                "bFilter":true,
                "bDestroy" : true,
                "bLengthChange":false,
            });
            $("#"+$.mobile.activePage.attr('id')+" .popupCombinaciones").popup( "open");
        }
        if(nota_oblig != 1 ||  (nota_oblig == 1 && $("#messageOrder").val() != "")){
            $("#checkoutButton").removeClass("tpv-disabled");
            $("#checkoutButton").tooltip('disable');
        }
        // $(".loaderProductos").hide();
    });
}
function totales(){
    var selected = "";
    var formaPagoElegida = $("#formaPago").val();
    if(id_carrier == id_carrier_defecto){
        var precioTransporte = $('#precioTransporte').val();
    }else{
        var precioTransporte = 0;
    }
    $.getJSON(token_actions,{action: 'totales',ajax:"1",id_employee: id_employee, id_currency: $("#currencyPOS").val(),
        id_shop: id_shop, tax:tax,id_carrier: id_carrier,id_cart:id_cart,formaPago : formaPagoElegida, precioTransporte: precioTransporte,
        impuestosTransporte: $("#impuestosTransporte").val()},function(data) {
        var carrierElegido = id_carrier;
//        $('#id_carrier').html('');
        $.each(data, function(index, result) {
            if(result.error != null){
                mostrarError(result.error);
            }else{
                if(result.total != null){
                    $('#totalButton span.total').html(result.total);
                    pTotal();
                    formasPagoPermitidas();
                }
                if(result.descuentos != null){
                    $('.descuentosButton span').html(result.descuentos);
                    if(result.descuentos != 0){
                        $(".descuentosButton").removeClass("ui-alt-icon");
                    }else{
                        $(".descuentosButton").addClass("ui-alt-icon");
                }
                }
                if(result.totalIva != null){
                    $('#ivaButton span').html(result.totalIva);
                }
                if(result.totalEnvio != null){
                    $('#carriersButton span:not(.nameCarrier)').html(result.totalEnvio);
                    if(parseFloat(result.totalEnvio) != parseFloat(0)){
                        $("#carriersButton").addClass("alterado");
                    }else{
                        $("#carriersButton").removeClass("alterado");
                    }

                }
                if(result.carriers != null){
                    reconstruirCarriers(result.carriers,carrierElegido);
                }
            }
        });
        pTotal();
//        $('#id_carrier').selectmenu('refresh');
//        calculoDeCambio($('#pagadoButton').html());
        var retRenta = $('#retencionRentaButton').html();
        var retIva = $('#retencionIVAButton').html();
        if(retRenta != null)
            calculoDeRetencionRenta($('#retencionRentaButton .amount').html());
        if(retIva != null)
            calculoDeRetencionIVA($('#retencionIVAButton .amount').html());
    });

}
function reconstruirCarriers(carriers,carrierElegido){
    var precioTransporte = $('#precioTransporte').val();
    if(precioTransporte == null)
        precioTransporte = 0;
    if(existsHookJS('updateCarriers')){
        hookJS('updateCarriers',{'carriers':carriers, 'carrierElegido': carrierElegido}) ;
    }else{
        $('#popupcarriers .carrierDiv').remove();
        var taxes_group = $("#"+$.mobile.activePage.attr('id')+' select.anadirProducto_id_tax').html();
        var carrierDiv = "";
        $.each(carriers, function(index, carrier) {
            if(carrier.id_carrier == carrierElegido)
                alterado = 'alterado';
            else
                alterado = '';
            if(carrier.id_carrier == id_carrier_defecto){
                carrierDiv = '<div id="carrier_'+carrier.id_carrier+'"  class="selected '+alterado+' carrierDiv ui-btn  ui-shadow ui-corner-all">'+
                    '<div class="col-sm-10">'+
                        '<input id="nameTransporte" autocomplete="off" data-role="none" class="col-sm-8 nameCarrier ui-shadow ui-corner-all" value="'+(nameTransporte == "" || nameTransporte == nameTransporte_defecto ? carrier.name : nameTransporte)+'">' +
                        '<div id="customPrecio" class="col-sm-4"><input id="precioTransporte" data-role="none" autocomplete="off" class="ui-shadow ui-corner-all" value="'+(precioTransporte == "" || parseInt(precioTransporte) == 0 ? parseFloat(0).toFixed(priceDisplayPrecision): precioTransporte)+'"></div>'+
                        '<select id="impuestosTransporte" data-mini="true" class="twelvecol ui-shadow ui-corner-all">'+taxes_group+'</select>' +
                    '</div>'+
                    '<div class="'+alterado+' ui-btn ui-btn-icon-left ui-shadow ui-corner-all ui-icon-plus col-sm-2" onclick="changeCarrier('+carrier.id_carrier+')">'+

                '</div>';
                if(carrier.selected == "1")
                    $("#carriersButton .nameCarrier").html((nameTransporte == "" || nameTransporte == nameTransporte_defecto ? carrier.name : nameTransporte));

            }else{
                carrierDiv = '<div id="carrier_'+carrier.id_carrier+'"  class="'+alterado+' carrierDiv ui-btn ui-shadow ui-corner-all">'+
                    '<div onclick="changeCarrier('+carrier.id_carrier+')">'+
                        '<div class="nameCarrier twelvecol">'+carrier.name+'</div>'+
                    '</div>'+
                '</div>';
                if(carrier.selected == "1")
                    $("#carriersButton .nameCarrier").html(carrier.name);
            }

            $('#popupcarriers').append(carrierDiv);
            $("#impuestosTransporte").selectmenu();
            $("#impuestosTransporte").selectmenu('refresh');

        });
    }
}
function changeCarrier(nuevo_id_carrier){
    $.getJSON("../modules/tpvtienda/classes/actions/actions.php",{token:token, action:'changeCarriers',id_carrier: nuevo_id_carrier,id_customer:id_customer,
        id_employee: id_employee, id_cart: id_cart, id_shop: id_shop},function(data) {
        if(data == 1){
            $('#popupcarriers').popup("close");
            id_carrier = nuevo_id_carrier;
            var nameCarrier = $('#carrier_'+nuevo_id_carrier+' .nameCarrier').html();
            nameTransporte = $("#nameTransporte").val();
            if(nuevo_id_carrier == id_carrier_defecto){
                var precioTransporte = $('#precioTransporte').val();
                $("#carriersButton span:not(.nameCarrier)").html(parseFloat(precioTransporte).toFixed(priceDisplayPrecision));
                var nameCarrier = $('#carrier_'+nuevo_id_carrier+' .nameCarrier').val();
            }else{
                var nameCarrier = $('#carrier_'+nuevo_id_carrier+' .nameCarrier').html();
            }
            $("#carriersButton .nameCarrier").html(nameCarrier);

            updateCompra();
        }
    });
}

function cambioPrecioPesoPrecio(id_product,id_product_attribute,peso,precio,calcularPrecio) {
    if(typeof calcularPrecio == 'ndefined')
        calcularPrecio = true;
    // $(".loaderProductos").show();
    $.get("../modules/tpvtienda/classes/actions/actionsCambioPrecio.php",{token:token, action:'cambioPrecioPesoPrecio', tax:tax, id_currency: $("#currencyPOS").val(),
        id_shop: id_shop, id_cart:id_cart,peso:peso, precio:precio, id_product:id_product, id_product_attribute:id_product_attribute,calcularPrecio:calcularPrecio
        },function(data) {
        if(data != ''){
            if(data==1){
                $('#compra').show();
                $('#compraVacia').hide();
                var cantidadProd = $('[id^=cantidadProducto_'+id_product+'_'+id_product_attribute+"] .amount").html();
                hookJS('changeWeight',{'id_product':id_product,'id_product_attribute':id_product_attribute,'id_currency' : $("#currencyPOS").val(),'id_cart':id_cart,'cantidad':cantidadProd,'peso': peso});
                updateCompra();
            }else{
                mostrarError(data);
            }
            // $(".loaderProductos").hide();
        }
    });
}
function cambioPrecioPeso(id_product,id_product_attribute,peso,calcularPrecio) {
    if(typeof calcularPrecio == 'ndefined')
        calcularPrecio = true;
    // $(".loaderProductos").show();
    $.get("../modules/tpvtienda/classes/actions/actionsCambioPrecio.php",{token:token, action:'cambioPrecioPeso', tax:tax, id_currency: $("#currencyPOS").val(),
        id_shop: id_shop, id_cart:id_cart,peso:peso, id_product:id_product, id_product_attribute:id_product_attribute,calcularPrecio:calcularPrecio
        },function(data) {
        if(data != ''){
            if(data==1){
                $('#compra').show();
                $('#compraVacia').hide();
                var cantidadProd = $('[id^=cantidadProducto_'+id_product+'_'+id_product_attribute+"] .amount").html();
                hookJS('changeWeight',{'id_product':id_product,'id_product_attribute':id_product_attribute,'id_currency' : $("#currencyPOS").val(),'id_cart':id_cart,'cantidad':cantidadProd,'peso': peso});
                updateCompra();
            }else{
                mostrarError(data);
            }
            // $(".loaderProductos").hide();
        }
    });
}
function cambioPrecio(id_product,id_product_attribute,impuCambioPrecio) {
    var nuevoPrecio = $('[id^=cambioprecio_'+id_product+'_'+id_product_attribute+'] .amount').html();
    var nuevoPeso = $('[id^=cambiopeso_'+id_product+'_'+id_product_attribute+'] .amount').html();
    // $(".loaderProductos").show();
    $.get("../modules/tpvtienda/classes/actions/actionsCambioPrecio.php",{token:token, action:'cambioPrecio', tax:tax, id_currency: $("#currencyPOS").val(), id_shop: id_shop,
        id_cart:id_cart,nuevoPrecio:nuevoPrecio, peso:nuevoPeso,id_product:id_product, id_product_attribute:id_product_attribute, impuCambioPrecio: impuCambioPrecio},function(data) {
        if(data != ''){
            if(data==1){
                $('#compra').show();
                $('#compraVacia').hide();
                updateCompra();
            }else{
                mostrarError(data);
            }
            // $(".loaderProductos").hide();
        }
    });
}
function cambioImpuesto(id_product,id_product_attribute,impuCambioPrecio) {
    var nuevoImpuesto = $('[name^=cambioImpuesto_'+id_product+'_'+id_product_attribute+']').val();
    // $(".loaderProductos").show();
    $.get("../modules/tpvtienda/classes/actions/actionsCambioPrecio.php",{token:token, action:'cambioImpuesto', tax:tax, id_currency: $("#currencyPOS").val(), id_shop: id_shop,
        id_cart:id_cart,nuevoImpuesto:nuevoImpuesto, id_product:id_product, id_product_attribute:id_product_attribute, impuCambioPrecio: impuCambioPrecio},function(data) {
        if(data != ''){
            if(data==1){
                $('#compra').show();
                $('#compraVacia').hide();
                updateCompra();
            }else{
                mostrarError(data);
            }
            // $(".loaderProductos").hide();
        }
    });
}
function cambioPrecioDev(id_product,id_product_attribute) {
    var nuevoPrecio = $('[id^=cambiopreciodev_'+id_product+'_'+id_product_attribute+'] .amount').html();
    // $(".loaderProductos").show();
    $.get(token_actions,{action:'cambioPrecioDev', ajax:"1", tax:tax, id_currency: $("#currencyPOS").val(), id_shop: id_shop,
        id_employee: id_employee, id_cart:id_cart, nuevoPrecio:nuevoPrecio, id_product:id_product, id_product_attribute:id_product_attribute},function(data) {
        if(data != ''){
            if(data==1){
                $('#compra').show();
                $('#compraVacia').hide();
                updateCompra();
            }else{
                mostrarError(data);
            }
            // $(".loaderProductos").hide();
        }
    });
}
function discount(id_product,id_product_attribute,tipo) {
    // $(".loaderProductos").show();
    var descuentoAaplicar = $('[id^=descamount_'+id_product+'_'+id_product_attribute+'] .amount').html();
    if(descuentoAaplicar == 0)
        $('[id^=descamount_'+id_product+'_'+id_product_attribute+'] .amount').removeClass('alterado');
    var cantidadProd = $('[id^=cantidadProducto_'+id_product+'_'+id_product_attribute+'] .amount').html();
    if($.isEmptyObject(cantidadProd))
        var cantidadProd = $('#linea_'+id_product+'_'+id_product_attribute+' .cantidad').html();
    $.getJSON(token_actions,{action:'discount', ajax:"1",adminDir:adminDir, tipo:tipo, id_currency: $("#currencyPOS").val(), id_shop: id_shop,
        id_cart:id_cart,discount:descuentoAaplicar, id_product:id_product,tax:tax,id_product_attribute:id_product_attribute,cantidad:cantidadProd},function(data) {
        $.each(data, function(index, result) {
            if(descuentoAaplicar != 0 || descuentoAaplicar != ""){
                if(result.error != null){
                    mostrarError(result.error);
                }else{
                    $('#compra').show();
                    $('#compraVacia').hide();
                    if(result.total != null){
                        $('div[id^=descamount_'+id_product+'_'+id_product_attribute+']').addClass("alterado");
                        $('#totalProd_'+id_product+'_'+id_product_attribute).html(result.total);
                    }
                }
            }else{
                // si el descuento es 0 tengo que actualizar toda la compra por
                // si hay otro descuento en la linea( un producto puede tener
                // varios descuentos en cola)
                $('#compra').show();
                $('#compraVacia').hide();
                updateCompra();
            }
        });
        pUpdateCompra();
        totales();
        // $(".loaderProductos").hide();
    });
}
function deshabilitarDescuento(id_product,id_product_attribute,tipo,texto){
    $('#desc'+tipo+'_'+id_product+'_'+id_product_attribute).prop('disabled',true);
}
function introducirPrecioUnidad(){
    if(introducirPrecioUnidadAutomaticamente)
        $(".lineaProd .cambiopeso:not(.alterado").trigger("click");
}
function updateCompra(hideLastItem){
    $("#loaderCambio").show();
    $("#cantidadTotal").html('-');
    hookJS('beforeUpdateCompra');

    $.getJSON(token_actions,{action:'updateCompra', ajax:"1",adminDir:adminDir,id_currency: $("#currencyPOS").val(),id_customer:id_customer,
        tax:tax,id_employee: id_employee, id_cart: id_cart, id_lang: id_lang, id_shop: id_shop, plantilla:plantilla_pos},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(result.error != null)
                    mostrarError(result.error);
                if(result.html != null){
                    if(result.html != ''){
                        $('#compra tbody').html(result.html);
                        if(hideLastItem != true)
                            $('#compra tbody tr:last-child').fadeIn(1000);
                        $('#compraVacia').hide();
                        $('#compra').show();
                        introducirPrecioUnidad();
                    }else{
                        $('#compra > tbody').html('');
                        $('#compra').hide();
                        $('#compraVacia').show();
                    }
                }
                if(result.c != null){
                    $("#cantidadTotal").html(result.c);
                }
            });
            $('#compra').trigger('create');
            totales();
            $(".customization .dropzone").not('.dz-clickable').dropzone({
                init: function () {
                    var index = $(this.element).children('input[name=index]').val();
                    var id_customization =$(this.element).children('input[name=id_customization]').val();
                    this.on("dragenter", function(event) {
                         guardarCampoPersonalizado($(this.element));
                        $(this).children('.dragging').show();
                    });
                    this.on("addedfile", function(event) {
                        $(this).children('.dragging').hide();
                    });
                    this.on("removedfile", function(file) {
                        deleteFileCustomizacion(id_customization,index)
                        this.removeAllFiles(true);
                    });
                    $(this.element).on("click", function(event) {
                         guardarCampoPersonalizado(this);
                    });
                },
                thumbnailWidth:80,
                maxFiles:1,
                thumbnailHeight:80,
                dictRemoveFile:borrar,
                addRemoveLinks:true,
                url: "../modules/tpvtienda/classes/actions/actionsCustomization.php?token="+token,
            });
            hookJS('afterUpdateCompra');
            pUpdateCompra();
            suscriboFullscreen('.foto .fullscreenProduct');
        }
    }).always(function() {
        $("#loaderCambio").hide();
    });
}
function formasPagoPermitidas(){
    if(devolucion_forma_pago == 1){
        var total = $("#totalButton .total").html();
        if(total.includes("-")){
            $.getJSON("../modules/tpvtienda/classes/actions/actions.php",{token:token, action:'formasPagoPermitidas',adminDir:adminDir,id_currency: $("#currencyPOS").val(),id_customer:id_customer,
                tax:tax,id_employee: id_employee, id_cart: id_cart, id_lang: id_lang, id_shop: id_shop},function(data) {
                if(data != null){
                    $.each(data, function(index, result) {
                        if(result.error != null)
                            mostrarError(result.error);
                        if(result.formasPagoDisponibles != null && !$.isEmptyObject(result.formasPagoDisponibles)){
                            $(".contFormasPago .formaPago").addClass("ui-state-disabled");
                            $("#formapago_"+result.formasPagoDisponibles).removeClass("ui-state-disabled");
                            $("#formaPago").val(result.formasPagoDisponibles[0]);
                        }
                    });
                }
            });
        }
    }
}
function changeQty(idCapaOrigen){
    var aux = idCapaOrigen.replace("#popupcantidadProducto_", "");
    var product = aux.split("_");
    var quantity = $(idCapaOrigen.replace("popup", "")+" .amount").html();
    // $(".loaderProductos").show();
    $.getJSON(token_actions,{action:'changeQty', ajax:"1",
        quantity:quantity,id_cart: id_cart,id_employee: id_employee,id_customer:id_customer,tax:tax,id_currency: $("#currencyPOS").val(),
        id_shop: id_shop, id_product:product[0], id_product_attribute:product[1],id_warehouse:$("#popupcantidad select.almacenProd").val()},function(data) {
        if(data != ''){
            $.each(data, function(index, result) {
                if(result.error != null){
                    mostrarError(result.error);
                    updateCompra();
                }else{
                    $('#compra').show();
                    $('#compraVacia').hide();
                    $("#totalProd_"+product[0]+"_"+product[1]).html(result.total);
                    updateCompra();
                    doPlay();
                }
                // $(".loaderProductos").hide();
            });
        }
    });
}
function changeQtyCustomizacion(idCapaOrigen){
    var aux = idCapaOrigen.replace("#popupcantidadProductoCustomizacion_", "");
    var product = aux.split("_");
    var quantity = $(idCapaOrigen.replace("popup","")+" .amount").html();
    // $(".loaderProductos").show();
    $.getJSON(token_actions,{action:'changeQty', ajax:"1",
        quantity:quantity,id_cart: id_cart, id_shop: id_shop, id_product:product[0], id_product_attribute:product[1],
        id_customization:product[2]},function(data) {
        if(data != ''){
            $.each(data, function(index, result) {
                if(result.error != null){
                    mostrarError(result.error);
                    updateCompra();
                }else{
                    $('#compra').show();
                    $('#compraVacia').hide();
                    updateCompra();
                    doPlay();
                }
                // $(".loaderProductos").hide();
            });
        }
    });
}

function getLoyalty(){
    $.getJSON("../modules/tpvtienda/classes/actions/actionsFidelity.php",{token:token, action:'getLoyalty', id_currency: $("#currencyPOS").val(),id_cart: id_cart, id_shop: id_shop},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(result.nombreCompleto != null ){
                    $('.descuentoForm span#nombreCompleto').html(result.nombreCompleto);
                }
                if(result.puntos != null ){
                    $('.descuentoForm #puntosLoyalty').html(result.puntos);
                }
                if(result.valor != null ){
                    $('.descuentoForm #valorLoyalty').html(result.valor);
                }
            });
        }
    });
    $.getJSON("../modules/tpvtienda/classes/actions/actionsFidelityAIOR.php",{token:token, action:'getLoyalty', id_currency: $("#currencyPOS").val(),id_cart: id_cart, id_shop: id_shop},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(result.nombreCompleto != null ){
                    $('.descuentoForm span#nombreCompleto').html(result.nombreCompleto);
                }
                if(result.total != null ){
                    $('.descuentoForm #totalLoyaltyAIOR').html(result.total);
                }
                if(result.disponible != null ){
                    $('.descuentoForm #disponibleLoyaltyAIOR').html(result.disponible);
                }
            });
        }
    });
    $.getJSON("../modules/tpvtienda/classes/actions/actionsFidelityAl.php",{token:token, action:'getLoyalty', id_currency: $("#currencyPOS").val(),id_cart: id_cart, id_shop: id_shop},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(result.nombreCompleto != null ){
                    $('.descuentoForm span#nombreCompleto').html(result.nombreCompleto);
                }
                if(result.puntos != null ){
                    $('.descuentoForm #puntosLoyaltyAL').html(result.puntos);
                }
                if(result.valor != null ){
                    $('.descuentoForm #valorLoyaltyAL').html(result.valor);
                }
            });
        }
    });
    $.getJSON("../modules/tpvtienda/classes/actions/actionsFidelityLEP.php",{token:token, action:'getLoyalty', id_currency: $("#currencyPOS").val(),id_cart: id_cart, id_shop: id_shop},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(result.nombreCompleto != null ){
                    $('.descuentoForm span#nombreCompleto').html(result.nombreCompleto);
                }
                if(result.puntos != null ){
                    $('.descuentoForm #puntosLoyaltyLEP').html(result.puntos);
                }
                if(result.valor != null ){
                    $('.descuentoForm #valorLoyaltyLEP').html(result.valor);
                }
            });
        }
    });
    $.getJSON("../modules/tpvtienda/classes/actions/actionsFidelityETS.php",{token:token, action:'getLoyalty', id_currency: $("#currencyPOS").val(),id_cart: id_cart, id_shop: id_shop},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(result.nombreCompleto != null ){
                    $('.descuentoForm span#nombreCompleto').html(result.nombreCompleto);
                }
                if(result.puntos != null ){
                    $('.descuentoForm #puntosLoyaltyETS').html(result.puntos);
                }
                if(result.valor != null ){
                    $('.descuentoForm #valorLoyaltyETS').html(result.valor);
                }
            });
        }
    });
}
function calcularRestante(){
    var acumuladoPagoMixto = 0;
    $.map( $('.cantidadPagoMixto'), function( val ) {
        var valor = $(val).val();
        if(valor != '')
            acumuladoPagoMixto = parseFloat(valor.toString()) + parseFloat(acumuladoPagoMixto);
    });
    var totalVenta = $("#totalButton span.total").html();
    totalVenta = totalVenta.replace(" ", "");
    totalVenta = totalVenta.replace(",", ".");
    var restante = parseFloat(totalVenta)-parseFloat(acumuladoPagoMixto);
    var sobra = 0;
    if(restante < 0){
        sobra = Math.abs(restante);
        restante = 0;
        $("#popupPagoMixto .restanteCont").hide();
        $(".okPagoMixto").removeClass("ui-state-disabled");
        $("#popupPagoMixto .sobra").html(formatCurrency(sobra, currencyFormat, currencySign, currencyBlank));
        $("#popupPagoMixto .sobraCont").show();
    }else if(restante == 0 || restante < 0.001){
        restante = 0;
        $("#popupPagoMixto .restanteCont").show();
        $(".okPagoMixto").removeClass("ui-state-disabled");
        $("#popupPagoMixto .restante").addClass('justo');
        $("#popupPagoMixto .sobraCont").hide();
    }else if(restante > 0){
        $("#popupPagoMixto .restanteCont").show();
        $("#popupPagoMixto .sobraCont").hide();
        $("#popupPagoMixto .restante").removeClass('justo');
        $(".okPagoMixto").removeClass("ui-state-disabled");
        $(".okPagoMixto").addClass("ui-state-disabled");
    }
    $('#popupPagoMixto .restante').html(parseFloat(restante).toFixed(priceDisplayPrecision));
}
function calculoDeCambio(valor){
    var total = $('#totalButton span.total').html();
    var pagado = $('#pagadoButton').html();
    var retRenta = $('#retencionRenta span').html();
    var retIVA = $('#retencionIVA span').html();
    var totalCambio = 0;
    if(retRenta == null) retRenta = 0;
    if(retIVA == null) retIVA = 0;
    if(typeof retRenta == 'undefined')
        retRenta = 0;
    if(typeof retIVA == 'undefined')
        retIVA = 0;

    total = total.replace(/,/g,"");
    total = total.replace(" ","");
    if(valor == 'CE'){
        pagado=pagado.substr(0,pagado.length-1);
        $('#pagadoButton').html(pagado);
    }
    if(pagado != 0)
        totalCambio = parseFloat(total)-parseFloat(pagado)-parseFloat(retRenta)-parseFloat(retIVA);

    if (totalCambio <= 0){
        $('.aDevolverButton').fadeOut( "fast");
        $('.aDevolverButton').html(Math.abs(totalCambio));
        $('.aDevolverButton').fadeIn( "fast");
    }else
        $('.aDevolverButton').html(0);
}
function calculoDeCambioTecla(valor,capa){
    if(valor.toString() == "")
        return;
    var total = $(capa+' input[name=total]').val();
    capa += ' .pagado';
    var retRenta = $('#retencionRenta span').html();
    var retIVA = $('#retencionIVA span').html();
    var valorActual =  $(capa).html();

    if(retRenta == null) retRenta = 0;
    if(retIVA == null) retIVA = 0;
    if(typeof retRenta == 'undefined')
        retRenta = 0;
    if(typeof retIVA == 'undefined')
        retIVA = 0;
    total = total.replace(/,/g,"");
    total = total.replace(" ","");
    total = total.replace(",",".");

    if(valor == 'CE' || valor == '<span class="CEButton">CE</span>'){
        valorActual=valorActual.substr(0,valorActual.length-1);
        if(valorActual == "")
            valorActual = 0;
    }else{
        if(valorActual == "0" || valorActual == "0.00")
            valorActual = "";
        valorActual=valorActual.toString()+valor.toString();
    }
    $(capa).html(valorActual);
    if(valorActual == ".")
        valorActual = "0";
    var restante = parseFloat(total)-parseFloat(valorActual)-parseFloat(retRenta)-parseFloat(retIVA);
    if(restante < 0){
        sobra = Math.abs(restante);
        restante = 0;
        $(".restanteCont").hide();
        $(".okPago").removeClass("ui-state-disabled");
        $(".sobra").html(parseFloat(sobra).toFixed(priceDisplayPrecision));
        $(".sobraCont").show();
    }else if(restante == '' || restante == 0){
        restante = 0;
        $(".restanteCont").show();
        $(".okPago").removeClass("ui-state-disabled");
        $(".restante").addClass('justo');
        $(".sobraCont").hide();
    }else if(restante > 0){
        $(".restanteCont").show();
        $(".sobraCont").hide();
        $(".restante").removeClass('justo');
        $(".okPago").removeClass("ui-state-disabled");
        $(".okPago").addClass("ui-state-disabled");
    }
    $('.restante').html(parseFloat(restante).toFixed(priceDisplayPrecision));
    pCambioEntregado();
}
function calculoDeRetencionRenta(valor){
    var total = $('#totalButton span.total').html().replace(/,/g,"");
    var iva = $('#ivaButton span').html().replace(/,/g,"");
    var base = parseFloat(total)-parseFloat(iva);
    var retencionRenta = base.toFixed(priceDisplayPrecision) * (valor/100);
    $('#retencionRenta span').fadeOut( "fast");
    $('#retencionRenta span').html(retencionRenta.toFixed(priceDisplayPrecision));
    $('#retencionRenta span').fadeIn( "fast");
    calculoDeTotalSinRet();
}
function calculoDeRetencionIVA(valor){
    var iva = $('#ivaButton span').html().replace(/,/g,"");
    var retencionIVA = parseFloat(iva) * parseFloat(valor/100);
    $('#retencionIVA span').fadeOut( "fast");
    $('#retencionIVA span').html(retencionIVA.toFixed(priceDisplayPrecision));
    $('#retencionIVA span').fadeIn( "fast");
    calculoDeTotalSinRet();
}
function calculoDeTotalSinRet(){
    var total = $('#totalButton span.total').html().replace(/,/g,"");
    var htmlRetRenta = $('#retencionRenta span').text();
    if(htmlRetRenta != '' && typeof htmlRetRenta != 'undefined')
        var retencionRenta = htmlRetRenta.replace(/,/g,"");
    var htmlRetIVA = $('#retencionIVA span').text();
    if(typeof htmlRetIVA != 'undefined' && htmlRetIVA != '')
        var retencionIVA = htmlRetIVA.replace(/,/g,"");
    var totalSinRet = parseFloat(total) - (parseFloat(retencionRenta) + parseFloat(retencionIVA));
    $('#totalSinRet span').html(totalSinRet.toFixed(priceDisplayPrecision));
}
function anadirDevolucion(id_order){
    var prodsDevoluciones = listaDevolucionestoString(id_order);
    if(prodsDevoluciones != ""){
        $.getJSON(token_actions,{action: 'anadirDevolucion',ajax:"1",id_employee: id_employee, motivo:$('.motivo').val(), id_cart:id_cart,
            id_shop: id_shop, id_order:id_order, prodsDevoluciones:prodsDevoluciones,defectuoso: $('.defButton').prop('checked')},function(data) {
            $.each(data, function(index, result) {
                if(result.error != null)
                    mostrarError(result.error);
                else{
                    if(result.resultado == 'ok') {
                        updateCompra();
                        if(devs_con_comprobacion_tarjeta == 1)
                            comprobar_tarjeta();
                       // if(pass_dev_enabled == 1){
//                            $(".contDevs").hide();
//                            $(".pass_dev").show();
//                        }
                        $(".maskTPVTienda").trigger("click");
                    }
                }
            });
        });
    }
    var pagosDevoluciones = listaDevolucionesPagostoString();
    pagosDevoluciones = pagosDevoluciones.split(",");
    $.each(pagosDevoluciones, function(index, result){
        var idPago = result.replace("pago_","");
        idPago = idPago.split("_");
        var id_pago = idPago[0];
        var id_order = idPago[1];
        $.getJSON("../modules/tpvtienda/classes/actions/actionsAcredito.php",{token:token, action: 'cancelarPago', id_pago :id_pago,id_shop: id_shop,id_cart:id_cart},function(data) {
            if(data != null) {
                $.each(data, function(index, result) {
                    if(result.q != null){
                        var chars = "123456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
                        var codigo = "";
                        for (var i = 1; i <= 8; ++i)
                            codigo += chars.charAt(Math.floor(Math.random() * chars.length));
                        var nombre = pagoEnPedido + " " + id_order;
                        var valor = result.q;
                        var tipoDesc = 'amount';
                        var uso_parcial = 'on';
                        var prioridad = 1;
                        var descripcion = "";
                        var envio_gratis = "off";
                        var total_disponible = 1;
                        var disponible_usuario = 1;
                        $.getJSON(token_actions,{action:'crearDescuento', ajax:"1",adminDir:adminDir,id_currency: $("#currencyPOS").val(), id_shop: id_shop, id_lang:id_lang,
                            nombre: nombre,  descripcion: descripcion,codigo: codigo,valor: valor, tipo: tipoDesc,uso_parcial: uso_parcial,prioridad: prioridad,
                            envio_gratis: envio_gratis, total_disponible: total_disponible, disponible_usuario: disponible_usuario, id_cart: id_cart},function(data) {
                            if(data != null){
                                var id_desc = 0;
                                $.each(data, function(index, result) {
                                    if(result.error != null){
                                        mostrarError(result.error);
                                    }
                                    if(typeof result.desc ==='object' && result.desc != null){
                                        addDiscount(result.desc.id);
                                    }
                            });
                            }
                        });
                    }
                });
            }
        });
    });
}
function listaDevolucionesPagostoString(){
    var html = '';
    $(".pagoOrder.selected").each(function(index, result) {
        var idPagoPedido = $(this).find("input").attr("id");
        idCapaPagoPedido = idPagoPedido.replace("item_","");
            // cancelarPago(idPagoPedido[0],idPagoPedido[1],'enPedido')

        if(html == '')
            html = "pago_"+idCapaPagoPedido;
        else
            html += ",pago_"+idCapaPagoPedido;
    });
    return html;
}
function modCantidad(id_order_detail){
    if(id_order_detail == null){
        var prodsDevoluciones = listaDevolucionestoString();
        var pagosDevoluciones = listaDevolucionesPagostoString();
    }else{
        var idProd = $("#name_"+id_order_detail+"_product_id_prod").html();
        var priceDev = $("#name_price_"+id_order_detail).data("price");
        var priceDevExcl = $("#name_price_"+id_order_detail).data("price-excl");
        var qty = $("#name_quantity_"+id_order_detail).val();
     //   priceDev = priceDev * qty;
//        priceDevExcl = priceDevExcl * qty;
        var prodsDevoluciones = idProd+"_"+qty+"_"+priceDev+"_"+priceDevExcl;
        var pagosDevoluciones = "";
    }
    var html = '';
    var error=false;
    $('.ticket .columnaUnit').hide();
    $('.ticket .columnaDescuentos').hide();
    $(".loaderTicket").show();
    $(".generarValeDescuento").addClass("ui-state-disabled");
    $('.ticket .datosCliente').hide();
    $.post(token_actions,{action: 'hacerDevolucion', ajax : "1",  pedido:pedido,descuento:descuento,devolucionEnDescuento:devolucionEnDescuento,motivo:$('.motivo').val(),
        id_cajas:cajaEnUso,prodsDevoluciones:prodsDevoluciones,pagosDevoluciones:pagosDevoluciones, id_shop:id_shop, defectuoso: $('.defButton').prop('checked'), id_employee:id_employee, id_currency: $("#currencyPOS").val() },function(data) {
        var classNameTicket = $('#ticket').attr('name');
        data = JSON.parse(data);
        $.each(data, function(index, result) {
            if(result.error != null){
                error = true;
                mostrarError(result.error);
            }else{
                $(".loaderTicket").hide();
               // if(pass_dev_enabled == 1){
//                    $(".contDevs").hide();
//                    $(".pass_dev").show();
//                }
            }
            if(result.titulo != null)
                $('.ticketvaleDescuento .tituloTicket').html(result.titulo);
            if(result.total != null)
                $('.ticketvaleDescuento .totalValeDescuento span').html(result.total);
            if(result.date != null)
                $('.ticketvaleDescuento .dateTicket').html(result.date);
            if(result.date_to != null){
                if(result.date_to != 0){
                    $('.ticketvaleDescuento .dateTicketTo span').html(result.date_to);
                    $('.ticketvaleDescuento .dateTicketTo').show();
                }else{
                    $('.ticketvaleDescuento .dateTicketTo').hide();
                }
            }
            if(result.codigo != null){
                $('.ticketvaleDescuento .codeValeDescuento span').html(result.codigo);
                $(".ticketvaleDescuento .codBarTicket .textoCodebar").html("");
                $(".ticketvaleDescuento .codBarTicket .contCodebar").barcode(result.codigo, "code93", settings);
            }
            if(typeof result.producto ==='object' && result.producto != null){
                html+='<tr>';
                if(typeof result.producto.n != 'undefined' && result.producto.n != ''){
                    html+='<td width="1%" class=" center columnaNumeracionProducto">'+result.producto.n+'</td>';
                }
                html+='<td width="48%">'+result.producto.name;
                if(typeof result.producto.ref != 'undefined' && result.producto.ref != ''){
                    html+='<p class="refticketprod">ref. '+result.producto.ref + '</p>';
                }
                html+='</td><td width="13%" class="center">'+result.producto.q+'</td>';
                if(colUnitariaEnTicket == 1 && result.producto.priceUnit != null){
                    $('.ticket .columnaUnit').show();
                    if(result.producto.priceUnit != '')
                        html+='<td width="13%" class="columnaUnit center columnaProductosTicket">'+result.producto.priceUnit+'</td>';
                    else
                        html+='<td width="13%" class="columnaUnit center columnaProductosTicket"></td>';
                }
                if(colPrecioUnidad == 1 ){
                    if(typeof result.producto.p_unidad != 'undefined'){
                        flagPrecioUnidad = 1;
                        $('.ticket'+tipo+' .columnaPrecioUnidad').show();
                        html+='<td width="13%" class="center columnaPrecioUnidad columnaProductosTicket">'+result.producto.p_unidad+'</td>';
                    }else{
                        html+='<td width="13%" class="center columnaPrecioUnidad columnaProductosTicket"></td>';
                    }
                }
                html+='<td width="28%" class="rightTicket">'+result.producto.price+'</td></tr>';
            }
        });

        if(!error){
            $('.maskTPVTienda').trigger("click");
            actualizarPedidos(paginadorDevoluciones);
            $('.ticketvaleDescuento table.productosTicket tbody').html(html);
            $('.ticketvaleDescuento table.productosTicket').show();
            $.fancybox({
                'type': 'html',
                'content'     :    $(".ContTicketvaleDescuento").html(),
                'autoSize'    : true,
                'autoHeight'  : true,
                'maxWidth'      : anchuraTicket,
                'afterShow'   :  function(){
                    afterShowTickets('valeDescuento');
                }
            });
        }
        $(".generarValeDescuento").removeClass('ui-state-disabled');
    });
}
function buscoBalanzaEan13(query){
    codebar = parseInt(query.substring(2, 6));
    precio = parseFloat(query.substring(6, 8))+'.'+parseFloat(query.substring(8, 10));
    peso = parseFloat(query.substring(10, 14));
    $.getJSON(token_actions,{action:'search', ajax:"1", tipoBusqueda:'normal', q: codebar, inicio:0,cantidad:cantidadProductos,
        id_shop: id_shop,id_cart: id_cart,inactivos: $('#inactivos').prop('checked')},function(data) {
        if(data != null) {
            $.each(data, function(index, result) {
                if(result.error != null){
                    buscoCodebar(query);
                }else{
                    if(result.id != null){
                        cambioPrecioPesoPrecio(result.id,result.attr,peso,precio);
                        // meto la primera coincidencia en la lista de la compra
                        addCart(result.id,result.attr,1,result.name,false);
                      }
                }
            });
         }else{
            $("#"+$.mobile.activePage.attr('id')+' .advertencia .nohayresultados').slideDown('fast');
            $("#"+$.mobile.activePage.attr('id')+' .advertencia .nohayresultados').delay(3000).slideUp('fast');
         }
      });
}
function buscoBalanzaEan13_2(query){
    id_product = parseInt(query.substring(2, 7));
    peso = parseFloat(query.substring(7,12))/1000;
    $.getJSON(token_actions,{action:'search', ajax:"1", tipoBusqueda:'ean13_2', q: id_product, inicio:0,cantidad:cantidadProductos,
        id_shop: id_shop,id_cart: id_cart,inactivos: $('#inactivos').prop('checked'),stockcero: $('#stockcero').prop('checked')},function(data) {
        if(data != null) {
            $.each(data, function(index, result) {
                if(result.error != null){
                    buscoCodebar(query);
                }else{
                    if(result.id != null){
                        cambioPrecioPeso(result.id,result.attr,peso);
                        // meto la primera coincidencia en la lista de la compra
                        addCart(result.id,result.attr,1,result.name,false);
                      }
                }
            });
         }else{
                $("#"+$.mobile.activePage.attr('id')+' .advertencia .nohayresultados').slideDown('fast');
                $("#"+$.mobile.activePage.attr('id')+' .advertencia .nohayresultados').delay(3000).slideUp('fast');
         }
      });
}
function buscoPLU(query){
    $.getJSON(token_actions,{action:'search', ajax:"1", tipoBusqueda:'plu', q: query, inicio:0,cantidad:1,
        id_shop: id_shop,id_cart: id_cart,inactivos: $('#inactivos').prop('checked')},function(data) {
        if(data != null) {
            $.each(data, function(index, result) {
                if(result.error != null){
                    buscoCodebar(query);
                }else{
                    if(result.id != null){
                        // meto la primera coincidencia en la lista de la compra
                        addCart(result.id,result.attr,1,result.name,false);
                      }
                }
            });
         }else{
                $("#"+$.mobile.activePage.attr('id')+' .advertencia .nohayresultados').slideDown('fast');
                $("#"+$.mobile.activePage.attr('id')+' .advertencia .nohayresultados').delay(3000).slideUp('fast');
         }
      });
}
function buscoUPC(query){
    id_prod = parseInt(query.substring(1, 6));
    peso = parseFloat(query.substring(6, 8)+'.'+query.substring(8, 11));
    $.getJSON(token_actions,{action:'search', ajax:"1", tipoBusqueda:'plu', q: id_prod, inicio:0,cantidad:cantidadProductos,
        id_shop: id_shop,id_cart: id_cart,inactivos: $('#inactivos').prop('checked')},function(data) {
        if(data != null) {
            $.each(data, function(index, result) {
                if(result.error != null){
                    buscoCodebar(query);
                }else{
                    if(result.id != null){
                        cambioPrecioPeso(result.id,result.attr,peso)
                        // meto la primera coincidencia en la lista de la compra
                        addCart(result.id,result.attr,1,result.name,false);
                      }
                }
            });
         }else{
                $("#"+$.mobile.activePage.attr('id')+' .advertencia .nohayresultados').slideDown('fast');
                $("#"+$.mobile.activePage.attr('id')+' .advertencia .nohayresultados').delay(3000).slideUp('fast');
         }
      });
}
function buscoCodebar(query,cantidad = 1,displayError = true,callback){
    if(modo == 0){
        if(existsHookJS('searchCodebar')){
            hookJS('searchCodebar',{'query':query}) ;
        }else{
             $.getJSON(token_actions,{action:'search', ajax:"1", tipoBusqueda:'ean13', q: query, inicio:0,cantidad:cantidad, id_shop: id_shop,
                inactivos: $('#inactivos').prop('checked'),stockcero: $('#stockcero').prop('checked'),conAtributos:true},function(data) {
                if(data[0].length != 0) {
                    $.each(data, function(index, result) {
                        if(result.error != null){
                            if(displayError)
                                mostrarError(result.error);
                            else{
                                callback(query);
                            }
                        }else{
                            if(result.id != null){
                                // meto la primera coincidencia en la lista de la compra
                                if($.mobile.activePage.attr('id') == "TPVTienda")
                                    addCart(result.id,result.attr,cantidad,result.name,false);
                                else
                                    addProductOnOrder(result.id,result.attr,cantidad,result.name,false);
                              }
                        }
                    });
                }else{
                    if(displayError){
                        doNotFound();
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .nohayresultados').slideDown('fast');
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .nohayresultados').delay(3000).slideUp('fast');
                    }else{
                        callback(query);
                    }
                }
            });
        }
    }
}
function sinStock(error){
    if(typeof $.mobile.activePage == "undefined")
        var paginaActiva = "";
    else
        var paginaActiva ='#'+$.mobile.activePage.attr('id')+' ';
    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').slideDown('fast');
    if(typeof error['error'] != 'undefined' && error['error'] == 'error015'){
        var html = "";
        $(paginaActiva+' .advertencia .notificationBad .message').html(errores[error['error']]);
        html += '<a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn aladerecha" onclick="devRapida2('+error['id_product']+','+error['id_product_attribute']+')" class="keyDev2">'+devolucionTxt+'</a>'+
                '<a href="'+token_stock+'" target="_blank" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn aladerecha">'+irAstocksTxT+'</a>';
        if(bloquear_ventana_no_encontrado == 1)
            html += '<a href="#" class="alterado ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn" onclick="$(\'.maskTPVTiendaObligatoria\').hide();$(\'.advertencia .notificationBad\').slideUp(\'fast\')">'+cerrarTxT+'</a>';
        $(paginaActiva+'.advertencia .notificationBad .footerAdv').html(html);
    }
    if(bloquear_ventana_no_encontrado != 1){
        $(paginaActiva+' .advertencia .notificationBad').delay(5000).slideUp('fast');
    }else{
        anadirMascaraObligatoria();
    }
}
function abrirConversaciones(){
    $("#"+$.mobile.activePage.attr('id')+' .popupConversaciones').popup('open');
    rellenarConversaciones();
}
function rellenarConversaciones(){
    if($("#currencyPOS").val() != undefined)
        var currPOS = $("#currencyPOS").val();
    else
        var currPOS = id_currency;


    $.getJSON(token_actions,{action:'rellenarConversaciones', ajax : "1",id_order:id_order_global,id_shop:id_shop,emailSend:email_global,nota:$("#messageConv").val(),
        id_employee: id_employee,id_lang:id_lang, id_currency: currPOS},function(data) {
        if(data != null){
            $(".contConvs").html("");
            $.each(data, function(index, result) {
                if(result.error != null){
                    $(".contErroresConvs").show();
                    $(".contErroresConvs").html(result.error);
                    $(".contContConvs").hide();
                }else{
                    $(".contContConvs").show();
                    $(".contErroresConvs").html("");
                    $(".contErroresConvs").hide();
                }
                if(result.contadorConversaciones != null){
                    $("#"+$.mobile.activePage.attr('id')+' .contadorConversaciones').html("("+result.contadorConversaciones+")");
                }
                if(result.messages != null){
                    $.each(result.messages, function(index, message) {
                        if(message.id_employee != "0"){
                            $(".contConvs").append('<div class="mb-2 messages-block-employee"><div class="row no-gutters"><div class="messages-block-content"><p class="mb-0 message employee-message">'+message.message+'</p>'+
                                '<p class="text-muted mb-0 text-right">Yo '+message.date_add+'</p></div></div></div>');
                        }else{
                            $(".contConvs").append('<div class="mb-2 messages-block-customer"><div class="row no-gutters"><div class="messages-block-content"><p class="mb-0 message customer-message">'+message.message+'</p>'+
                                '<p class="text-muted mb-0 text-left">'+message.cfirstname+' '+message.clastname+' '+message.date_add+'</p></div></div></div>');
                        }
                    });
                }
            });
        }
    });
}
function enviarConversacion(){
    if($("#currencyPOS").val() != undefined)
        var currPOS = $("#currencyPOS").val();
    else
        var currPOS = id_currency;
    $.getJSON(token_actions,{action:'enviarConversacion', ajax : "1",id_order:id_order_global,id_shop:id_shop,emailSend:email_global,message:$("#"+$.mobile.activePage.attr('id')+' .messageConv').val(),
        id_employee: id_employee,id_lang:id_lang, id_currency: currPOS},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(result.ok != null){
                    rellenarConversaciones();
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html(mensajeEnviadoTxT);
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').slideDown('fast');
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(6000).slideUp('fast');
                }
                if(result.error != null){
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').html(result.error);
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').slideDown('fast');
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').delay(6000).slideUp('fast');
                }
            });
        }
    });
}
function search(nuevaBusqueda,evento){
    var query = $('#'+$.mobile.activePage.attr('id')+' .order_query').val();
    var seqNumber = ++xhrCount;
    flagEnter = 0;
    // $(".loaderProductos").show();

    if(query != ''){
        ultimaBusqueda = 'search';
        var swiper = getSwiperTPV();
        if(nuevaBusqueda == 1){
            inicioProductos = 0;
            swiper.removeAllSlides();
            $(".contProductos").html("");
            $(".contProductos2 tbody").html("");
        }
        var contadorProductos = 0;
         $.getJSON(token_actions,{action:'search', ajax:"1", q: query, tipoBusqueda:'normal', id_cart: id_cart,
            inicio:inicioProductos, cantidad:cantidadProductos,stockcero: $('#stockcero').prop('checked'),
            inactivos: $('#inactivos').prop('checked'), id_lang:id_lang, id_shop: id_shop,conAtributos:true},function(data) {
            if (seqNumber === xhrCount) {
                if(data != null) {
                    $.each(data, function(index, result) {
                        if(result.error != null){
                            mostrarError(result.error);
                        }else if(result.id != null){
                            if($("#listaProd").val() == "list"){
                             //   if(result.p.attr != 0){
//                                    addCart(result.p.id,result.p.attr,1,true)
//                                }else{
                                    var newSlide = "<tr class='contProducto' id='item_"+index+"'>" +
                                            "<td>";
                                            if(typeof result.i ==='object' && result.i !=null){
                                                var contadorImagenes = 0
                                                $.each(result.i, function(index, img) {
                                                    newSlide += "<a rel='fscreen_"+result.p.id+"_0' class='fullscreenProduct' title='"+result.name+"' href='"+img+"'>"+(contadorImagenes++ == 0 ? "<img src='"+result.img+"'/>" : "")+"</a>";
                                                });
                                            }
                                            newSlide += "</td>" +
                                            "<td onclick='addCart("+result.id+",0,1,\""+result.name+"\",true);'>"+result.name+"</td>"+
                                            "<td class='refList' onclick='addCart("+result.id+",0,1,\""+result.name+"\",true);'>"+result.ref+"</td>"+
                                            "<td class='stockList' onclick='addCart("+result.id+",0,1,\""+result.name+"\",true);'>"+result.s+"</td>"+
                                            "<td class='precioList'>"+result.p+"</td>" +
                                            "</tr>";
                                    $(".contProductos2 tbody").append(newSlide);
                               //  }
                            }else{
                                htmlProducto = "<div class='swiper-slide producto' id='item_"+result.id+"_"+result.attr+"_"+result.numAttr+"' >"+
                                ((mostrarPrecios == 1) ? "<span class='precio'>"+result.p+"</span>" : "")+
                                "<span class='name'>"+result.name+"</span>"+
                                "<img src='"+result.img+"'/>";
                                if(typeof result.i ==='object' && result.i !=null){
                                    $.each(result.i, function(index, img) {
                                        htmlProducto += "<a rel='fscreen_"+result.id+"_0' class='fullscreenProduct' title='"+result.name+"' href='"+img+"'></a>";
                                    });
                                }
                                htmlProducto += ((mostrarStock == 1) ? "<span class='stock'>"+stockText+" "+result.s+"</span>" : "");
                                htmlProducto += ((result.hookPbottomright != null) ? "<span class='hookBottomRightList'>"+result.hookPbottomright+"</span>" : "");
                                htmlProducto += "</div>";
                                swiper.appendSlide(htmlProducto);
                            }
                            contadorProductos++;
                             if(flagEnter == 0 && evento == 'enter'){
                                flagEnter = 1;
                                addCart(result.id,0,1,result.name,true);
                            }
                        }

                        suscriboFullscreen('.cntProducto .fullscreenProduct');
                        suscriboFullscreen('.producto .fullscreenProduct');
                    });
                    //este error ya no hace falta que sea subsanado en la nueva versión del swiper
//                    if(plantilla_pos == "full-width")
//                        $("#contProductos").css('width', (contadorProductos * 135)+'px');

                    if(contadorProductos != 0){
                        inicioProductos += cantidadProductos;
                    }
                }else{
                    if(inicioProductos ==0){
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .nohayresultados').slideDown('fast');
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .nohayresultados').delay(3000).slideUp('fast');
                    }
                }
                // $(".loaderProductos").hide();
            }
        });
    }else{
        getCategoriaId('');
    }
}
function formCambiarFecha() {
    $(".cambiarFechaPedido").hide();
    $(".botonModFecha").show();
    $(".fecha").show();
}
function cambiarFecha(){
    var textoFecha = $("#"+$.mobile.activePage.attr('id')+" .fecha").val();
    $.getJSON("../modules/tpvtienda/classes/actions/actionsPedido.php",{token:token, action:'cambiarFechaPedido',id_order:id_order_global,id_shop:id_shop,
        id_employee: id_employee,id_lang:$("#id_lang").val(),id_currency: $("#id_currency").val(),textoFecha: textoFecha},function(data) {
        if(data == 1){
            $(".cambiarFechaPedido").show();
            $(".botonModFecha").hide();
            $(".fecha").hide();
            getOrder(id_order_global);
        }
    });
}
function actualizarProductos(empiezaEn){
        var list = '';
        var query = $('#codigoPedido').val();
        var nFactura = $('#nFactura').val();
        $("#productosDevoluciones tbody").html("");
        $.getJSON(token_actions,{action: 'searchProductOrder',ajax:"1", empiezaEn :empiezaEn, nFactura: nFactura,
            id_customer:id_customer, refProdDev:$('#refProdDev').val(), clienteProductosDevs:$('#clienteProductosDevs').val(), id_cart: id_cart, q: query, id_shop: id_shop},function(data) {
            if(data != null) {
                list = '';
                paginadorDevolucionesProds = empiezaEn;
                var i=0;
                var errorDevs = 0;
                $.each(data, function(index, result) {
                    if(result.error == 1){
                        errorDevs = 1;
                        $("#soloAlElegirCliente").show();
                        $("#sinProductosDevs").hide();
                        $("#listadoProductos").hide();
                        $("#paginadorDevolucionesProds").hide();
                    }else if(result.error == 2){
                        errorDevs = 1;
                        $("#soloAlElegirCliente").hide();
                        $("#sinProductosDevs").show();
                        $("#listadoProductos").hide();
                        $("#paginadorDevolucionesProds").hide();
                    }else{
                        $("#paginadorDevolucionesProds").show();
                        $("#soloAlElegirCliente").hide();
                        $("#sinProductosDevs").hide();
                        $("#listadoProductos").show();
                        var i=1;
                        var contador = result.q;
                        list +="<tr class='prodOrder order_"+result.id+" "+((i++ % 2 ==0) ? 'odd' : '')+"'>" +
                        "<td id='name_"+result.id+"_product_id_prod'>"+result.idProd+"</td>" +
                        "<td id='name_"+result.id+"_product_id_order_detail'>"+result.name+" <strong>"+result.ref+"</strong>"+"</td>" +

                        "<td>";
                        list +="<select id='name_quantity_"+result.id+"' data-mini=true>";
                        while (contador > 0){
                                list += "<option value='"+contador+"'>"+contador+"</option>";
                                contador--;
                        }
                        list += "</select></td>"+
                                "<td id='name_price_"+result.id+"' data-price='"+result.precio+"' data-price-excl='"+result.precioExcl+"'>"+formatCurrency(parseFloat(result.total), currencyFormat, currencySign, currencyBlank)+"</td>" +
                                "<td>"+
                                    //"<input type='checkbox' id='def_"+result.id+"' class='defButton' title='"+defectuosoExpTxt+"'><span title='"+defectuosoExpTxt+"'>"+defectuosoTxt+"</span>"+
                                        "<a class='anadirPedido ui-shadow ui-btn ui-corner-all' alt=\""+anadirPedido+"\" title=\""+anadirPedido+"\" onclick='anadirDevolucion("+result.id+")'>"+anadirPedido+"</a>"+
                                        "<a class='generarValeDescuento ui-corner-all ui-btn ' alt=\""+genValeDescuento+"\" title=\""+genValeDescuento+"\" onclick='modCantidad("+result.id+")'>"+genValeDescuento+"</a>"+
                                "</td></tr>";
                    }

                });

                $("table#productosDevoluciones tbody").html(list).show('fast');
                $(".prodOrder select").selectmenu();
                $(".prodOrder select").selectmenu('refresh');
                $("#listadoProductos").show('fast');
            }else{
              $("#listadoProductos").hide();
              $("#paginadorDevolucionesProds").hide();
              $("#"+$.mobile.activePage.attr('id')+' .advertencia .nohayresultados').slideDown('fast');
              $("#"+$.mobile.activePage.attr('id')+' .advertencia .nohayresultados').delay(3000).slideUp('fast');
            }
        });
}
function actualizarPedidos(empiezaEn){
    var list = '';
    var query = $('#codigoPedido').val();
    var nFactura = $('#nFactura').val();
    $.getJSON(token_actions,{action: 'searchOrder',ajax:"1", empiezaEn :empiezaEn, nFactura: nFactura, c:10,
        id_customer:id_customer, clienteBusqueda:$('#clientePedidoDevs').val(), id_cart: id_cart, q: query, id_shop: id_shop},function(data) {
        $("table#pedidosDevoluciones tbody").html("");
        if(data != null) {
            $("#pedidosAparcados").show();
            $("#paginadorAparcados").show();
            list = '';
            paginadorDevoluciones = empiezaEn;
            var i=0;
            $.each(data, function(index, result) {
                  list += "<tr id='order_"+result.id+"' class='pedido "+((i % 2 ==0) ? 'odd' : '')+"' onclick=\"abrirPedido('"+result.id+"')\">" +
                              "<td><img id='order_"+result.id+"_down' border='0' src='../modules/tpvtienda/img/down.gif'>" +
                                  "<img id='order_"+result.id+"_up' style='display: none;' border='0' src='../modules/tpvtienda/img/up.gif'></td>" +
                              "<td>"+result.id+"</td>" +
                              "<td>"+result.ref+"</td>" +
                              "<td>"+result.name+"</td>" +
                              "<td>"+result.date+"</td>";
                  list +="</tr>";
                  if(typeof result.productos ==='object'){
                      if(result.available == true){
                        $.each(result.productos, function(index, producto) {
                            var contador = producto.q;
                            list +="<tr style='display:none' class='prodOrder order_"+result.id+" "+((i % 2 ==0) ? 'odd' : '')+"' id='order_"+result.id+"_"+producto.id+"'>" +
                            "<td onclick=\"check('"+result.id+"_"+producto.id+"')\"></td>"+
                            "<td class=\"ui-checkbox\"><input type='checkbox' onclick=\"check2('"+result.id+"_"+producto.id+"')\" id='item_"+result.id+"_"+producto.id+"' ></td>" +
                            "<td colspan='2' onclick=\"check('"+result.id+"_"+producto.id+"')\" id='name_"+result.id+"_product_id_order_detail'>"+producto.name+"</td>" +
                            "<td class='price' data-price='"+producto.precioUnid+"' data-price-excl='"+producto.precioUnidExcl+"'>"+
                                "<select id='quantity_"+result.id+"_"+producto.id+"' data-mini=true>";
                                                while (contador > 0){
                                                        list += "<option value='"+contador+"'>"+contador+"</option>";
                                                        contador--;
                                                }
                            list += "</select><span onclick=\"check('"+result.id+"_"+producto.id+"')\">"+formatCurrency(parseFloat(producto.precio), currencyFormat, currencySign, currencyBlank)+"</span></td>" +
                            "</tr>"
                        });
                      }else{
                          list +="<tr class='accion order_"+result.id+" "+((i % 2 ==0) ? 'odd' : '')+"'><td class='warning alert alert-warning' colspan='5'>"+noDispACuentaTxt+"</td></tr>";
                          if(result.available != false){
                              var j=1;
                            $.each(result.available, function(index, pago) {
                                  list +="<tr style='display:none' class='order_"+pago.id_order+" pagoOrder OCPago_"+pago.id+"_"+pago.id_order+"' "+((i % 2 ==0) ? 'odd' : '')+"'>" +
                                  "<td colspan='2'><input type='checkbox' onclick=\"check3('"+pago.id+"_"+pago.id_order+"')\" id='item_"+pago.id+"_"+pago.id_order+"'' data-price='"+pago.amount+"'></td>"+
                                  "<td onclick=\"check3('"+pago.id+"_"+pago.id_order+"')\"></td>"+
                                "<td onclick=\"check3('"+pago.id+"_"+pago.id_order+"')\">"+pago.payment_method+"</td>" +
                                "<td onclick=\"check3('"+pago.id+"_"+pago.id_order+"')\">"+formatCurrency(parseFloat(pago.amount), currencyFormat, currencySign, currencyBlank)+"</td>" +
                                "</tr>";
                            });
                          }
                      }
                  }else{
                      list +="<tr id='vacio_"+result.id+"' class='vacio'><td colspan='5'>"+vacio+"</td></tr>";
                  }
                i++;
            });
            $("table#pedidosDevoluciones tbody").html(list).show('fast');
            $(".prodOrder select").selectmenu();
            $(".prodOrder select").selectmenu('refresh');
            $("#listadoPedidos").show('fast');
          }else{
              $("#pedidosAparcados").hide();
              $("#paginadorAparcados").hide();
              $("#"+$.mobile.activePage.attr('id')+' .advertencia .nohayresultados').slideDown('fast');
              $("#"+$.mobile.activePage.attr('id')+' .advertencia .nohayresultados').delay(3000).slideUp('fast');
          }
      });
}
function recuperarCarrito(idCarrito){
    recuperarCarritoId(idCarrito);
    $("#aparcados").removeClass("open");
    $(".maskTPVTienda").trigger("click");
}
function getTodosCarts(){
    if (typeof carritosTable != 'object' || (typeof $.fn.DataTable == "undefined" && !$.fn.DataTable.isDataTable( 'table.contTodosCarritos') )) {
      //   $( 'table.contTodosCarritos').DataTable().destroy();
        var pageLength = 5;
        var heightFondo = $(window).height();
        if(heightFondo >= 600)
            pageLength += 5;
        if(heightFondo >= 800)
            pageLength += 5;
        if(heightFondo >= 1000)
            pageLength += 5;
        carritosTable = $('table.contTodosCarritos').DataTable({
              dom: '<"clear">rtip',
            "oLanguage":traducciones,
            "bPaginate":true,
            "pageLength": pageLength,
            "processing": true,
            "PaginationType":"simple_numbers",
            "columnDefs": [ {
                  "targets"  : 'no-sort',
                  "orderable": false,
                }],
            "drawCallback": function ( settings ) {
                $("table.contTodosCarritos tr td").on("click", function(event){
            //         $('#aparcados table.contTodosCarritos tr:not(.header) td').on("click", function(event){
    //        var idCarrito = $(this).parent().children("td").html();
    //        if(event.target.className.indexOf("infoButton") == -1){
    //
    //        }else{
    //            getInfoButton(idCarrito);
    //        }
    //    });
                    $("h1.presutitle").hide();
                    $("h1.carrito").show();
                    var tablaCarts = $(this).parent().attr("id");
                    idCarrito = tablaCarts.replace("cart_", "");
                    $("#contButtonCarrito").html('<button class="ui-btn ui-corner-all ui-shadow" onclick="recuperarCarrito('+idCarrito+')">'+recuperarTxT+'</button>');
                   recuperarCarrito(idCarrito);
                });
            },
             "bServerSide": true,
             "ajax": {
                    "url" : "../modules/tpvtienda/classes/actions/actionsClientes.php?action=getCarritos&id_shop="+id_shop+"&id_lang="+id_lang,
                    "data": {
                        "token" : token
                    }
            },
            //"sAjaxSource": "../modules/tpvtienda/classes/actions/actionsEstadisticas.php?action=stock&id_shop="+id_shop+"&id_lang="+id_lang,
            "bLengthChange":true,
        });
        var contadorCabeceras = 0;
        $('table.contTodosCarritos thead th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" id="filtroCarts_'+contadorCabeceras+'" class="filtroTablaCarts" placeholder="'+title+'" />');
            contadorCabeceras++;
        } );
        var timerScroll;
         $( '.filtroTablaCarts').on( 'keyup change', function (event) {
            clearTimeout(timerScroll);
            event.stopPropagation();
            timerScroll = setTimeout(function() {
                var altura = $(window).height();
                $("#listadoPedidosPage").css({'height':(altura)+'px'});
                carritosTable.ajax.url("../modules/tpvtienda/classes/actions/actionsClientes.php?action=getCarritos&id_cart="+$("#filtroCarts_0").val()+"&nombreCliente="+$("#filtroCarts_1").val()+
                        "&fecha="+$("#filtroCarts_3").val()+"&id_shop="+id_shop+"&id_lang="+id_lang+"&token="+token+"&id_currency="+$('#currencyPOS').val()+
                        "&limit=200").load();
            }, 1500);
        });
    }else{
        $( 'table.contTodosCarritos').DataTable().ajax.reload();
    }

}
function getPresupuestos(){
     if (typeof carritosTable == 'object' || (typeof $.fn.DataTable != "undefined" && $.fn.DataTable.isDataTable( 'table.contPresupuestos') )) {
        $( 'table.contPresupuestos').DataTable().destroy();
    }
    var pageLength = 5;
    var heightFondo = $(window).height();
    if(heightFondo >= 600)
        pageLength += 5;
    if(heightFondo >= 800)
        pageLength += 5;
    if(heightFondo >= 1000)
        pageLength += 5;
    var carritosTable = $('table.contPresupuestos').DataTable({
          dom: '<"clear">rtip',
        "oLanguage":traducciones,
        "bPaginate":true,
        "pageLength": pageLength,
        "processing": true,
        "iDisplayLength":20,
        "PaginationType":"simple_numbers",
        "columnDefs": [{
              "targets"  : 'no-sort',
              "orderable": false,
        }],
        "drawCallback": function ( settings ) {
            $("table.contPresupuestos tr td").on("click", function(event){
                var tablaPresu = $(this).parent().attr("id");
                $("h1.presutitle").show();
                $("h1.carrito").hide();
                id_order_global = $("#"+tablaPresu).children("td:first").html();
                idOrder = tablaPresu.replace("presu_", "");
                $.mobile.changePage('#pedidoPage');
                getOrder(idOrder);
                $("#presupuestos").removeClass('open');
                $('.maskTPVTienda').trigger("click");
                //$("#contButtonCarrito").html('<button class="ui-btn ui-corner-all ui-shadow" onclick="$.mobile.changePage(\'#pedidoPage\');getOrder('+idOrder+');">'+recuperarTxT+'</button>');
//                getInfoButton(idCarrito);
//                getButtonsPDFPresupuesto();

            });
        },
        "bServerSide": true,
         "ajax": {
                "url" : "../modules/tpvtienda/classes/presupuesto/actionsPresupuesto.php?action=getPresupuestos&id_shop="+id_shop+"&id_lang="+id_lang,
                "data": {
                    "token" : token
                }
        },
        //"sAjaxSource": "../modules/tpvtienda/classes/actions/actionsEstadisticas.php?action=stock&id_shop="+id_shop+"&id_lang="+id_lang,
        "bLengthChange":true,
    });
    var contadorCabeceras = 0;
    $('table.contPresupuestos thead th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" id="filtroPresupuestos_'+contadorCabeceras+'" class="nuncaMarcado filtroTablaPresupuestos" placeholder="'+title+'" />');
        contadorCabeceras++;
    } );
}
//function getButtonsPDFPresupuesto(){
//    $.getJSON("../modules/tpvtienda/classes/presupuesto/actionsPresupuesto.php",{token:token, action:'getPresupuesto',id_order:id_order_global,id_shop:id_shop,
//        id_employee: id_employee,id_currency: $("#currencyPOS").val()},function(data) {
//        if(data != null){
//            $.each(data, function(index, result) {
//                if(result != null){
//                    $("#fechaCart span").html(result.documento.date_add);
//
//                    $(".totalPedido").html(result.documento.amount);
//                    var html = '<span>'+result.documento.document_name+' '+result.documento.prefix+""+result.documento.number+'</span>';
//                    $.each(result.documento.link, function(index, lang) {
//                        html += '<button class="btn ui-btn ui-shadow ui-corner-all" id="presupuestoPOS"><img onclick="openQuotation('+lang.id_lang+')" class="pointer" src="'+baseUri+'/img/l/'+lang.id_lang+'.jpg" alt="'+lang.name+'" title="'+lang.name+'"></button>';
//                    });
//                    html += '<textarea id="popupPresupuestoNoteTextarea">'+result.documento.note+'</textarea>';
//                    html += '<a id="guardarNote" onclick="guardarNotaPresu('+result.documento.id_quotation+')" class="btn btn-default"><i class="icon-pencil">'+modificar+'</i></a>';
//                    $("#buttonsPresupuesto").html(html);
//                    $("#popupPresupuesto").popup();
//                    $("#popupPresupuestoNote").popup();
//                }
//            });
//        }
//    });
  //      $.mobile.document.on( "click", ".idiomasPresupuesto", function( evt ) {
//            var id = $( this).attr("id");
//            $( "#popupPresupuesto" ).popup( "open", { x: $(this).offset().left + ($(this).outerWidth()/2),y: $(".idiomasPresupuesto ").offset().top, changeHash : false } );
//            $( "#popupPresupuesto-popup").addClass("popupPresupuesto");
//            $( "#popupPresupuesto-screen").addClass("popupPresupuestoScreen");
//            evt.preventDefault();
//        });
//        $.mobile.document.on( "click", "#popupPresupuestoNoteButton", function( evt ) {
//            var id = $( this).attr("id");
//            $( "#popupPresupuestoNote" ).popup( "open", { x: $(this).offset().left + ($(this).outerWidth()/2),y: $(".notePresupuesto ").offset().top, changeHash : false } );
//            $( "#popupPresupuestoNote-popup").addClass("popupPresupuestoNote");
//            $( "#popupPresupuestoNote-screen").addClass("popupPresupuestoNoteScreen");
//            evt.preventDefault();
//        });
// }
function openQuotation(id_lang){
    window.location = '../modules/tpvtienda/classes/presupuesto/presupuestoOrder.php?id_order='+id_order_global+'&id_employee='+id_employee+'&id_lang='+id_lang;
}

function getAparcados(empiezaEn){
    var list = '';
    var query = $('#busquedaAparcado').val();
    $.getJSON("../modules/tpvtienda/classes/actions/actionsAparcados.php",{token:token, action: 'searchOrder', empiezaEn :empiezaEn, q: query,
        id_shop: id_shop, id_currency:$("#currencyPOS").val()},function(data) {
        if(data != null) {
            $("#pedidosAparcados").show();
            $("#noHayAparcados").hide();
            list = '';
            paginadorAparcados = empiezaEn;
            var i=0;
            $.each(data, function(index, result) {
                  list += "<tr id='order_"+result.id+"' class='pedido'>" +
                            "<td class=\"center\" onclick=\"recuperarAparcado('"+result.id+"')\">"+result.id+"</td>" +
                              "<td class=\"center\" onclick=\"recuperarAparcado('"+result.id+"')\">"+result.nombre+"</td>" +
                              "<td class=\"center\" onclick=\"recuperarAparcado('"+result.id+"')\">"+result.date+"</td>" +
                              "<td class=\"center\" onclick=\"recuperarAparcado('"+result.id+"')\">"+result.total+"</td>"+
                              "<td class='accion' onclick='deleteAparcado("+result.id_aparcado+");'><i class=\"icon-trash\"></i></td>";
                  list +="</tr>";
            });
            $("table#pedidosAparcados tbody").html(list).show('fast');
            $("#pedidosAparcados").show('fast');
        }else{
            $("#pedidosAparcados").hide();
            $("#noHayAparcados").show();
            $("#"+$.mobile.activePage.attr('id')+' .advertencia .nohayresultados').slideDown('fast');
                 $("#"+$.mobile.activePage.attr('id')+' .advertencia .nohayresultados').delay(3000).slideUp('fast');
        }
      });
}
function deleteAparcado(id){
    $.getJSON("../modules/tpvtienda/classes/actions/actionsAparcados.php",{token:token, action: 'deleteAparcado', id_aparcado :id ,
        id_shop: id_shop},function(data) {
            $.each(data, function(index, result) {
                if(result.error != null)
                    mostrarError(result.error);
                if(result.ok != null){
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia #borradoAparcado').slideDown('fast');
                         $("#"+$.mobile.activePage.attr('id')+' .advertencia #borradoAparcado').delay(3000).slideUp('fast');
                       getAparcados(0);
                }
            });
    });
}
function recuperarAparcado(id){
    id_cart = id;
    $.getJSON("../modules/tpvtienda/classes/actions/actionsAparcados.php",{token:token, action: 'recuperarAparcado', id_cart :id , id_shop: id_shop},function(data) {
        $.each(data, function(index, result) {
            if(result.error != null)
                mostrarError(result.error);
                // Comento porque luego ya hace el updateCompra
       //     if(result.id_cart != null){
//                updateCompra();
//            }
            if(result.id_customer != null){
                id_customer = result.id_customer;
                addCustomer(result.id_customer,'#cliente_'+id_customer);
            }
            if(result.nombre != null){
                $('#customerSeleccionado span').html(result.nombre);
                $('#closeRemoveCustomer').show();
                 $.mobile.changePage("#TPVTienda");
            }
        });
    });
}
function abrirPedido(id_order){
    if($('.order_'+id_order).length == 0)
        $('#vacio_'+id_order).slideToggle("fast");
    $('.order_'+id_order).slideToggle("fast");
    $('#order_'+id_order+'_down').slideToggle("fast");
    $('#order_'+id_order+'_up').slideToggle("fast");
}
function getMetodosPago(origen){
    var html ="<select name='metodoPago' class='ui-btn ui-icon-caret-d ui-btn-icon-right ui-corner-all ui-shadow'>";
    $.each(metodosPago,function(index ,value){
        if(value != null){
            if(origen == 'acredito' && typeof estadoFactPer != "undefined" && index == estadoFactPer)
                html += "";
            else
                html += "<option value='"+index+"'>"+value+"</option>";
        }
    });
    //hook para remesas
    html += hookJS('metodosPago') ;
    html +="</select>";
    return html;
}


function getHexColor(colorStr) {
    var a = document.createElement('div');
    a.style.color = colorStr;
    var colors = window.getComputedStyle( document.body.appendChild(a) ).color.match(/\d+/g).map(function(a){ return parseInt(a,10); });
    document.body.removeChild(a);
    return (colors.length >= 3) ? (((1 << 24) + (colors[0] << 16) + (colors[1] << 8) + colors[2]).toString(16).substr(1)) : false;
}
function getContrastYIQ(hexcolor){
    hexcolor = getHexColor(hexcolor);
    var r = parseInt(hexcolor.substr(0,2),16);
    var g = parseInt(hexcolor.substr(2,2),16);
    var b = parseInt(hexcolor.substr(4,2),16);
    var yiq = ((r*299)+(g*587)+(b*114))/1000;
    return (yiq >= 128) ? 'black' : 'white';
}

function cambiarEstado(id_order,nuevoEstado){
    $("#pedidoPage .contentpayments table tbody tr:not(.addPayment)").length;
    if(estadoCancelado != nuevoEstado && vengo_de == "presupuesto" && $("#pedidoPage .contentpayments table tbody tr:not(.addPayment)").length == 0 ){
        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').html(rellenaPagosTxt);
        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').slideDown('fast');
        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').delay(2000).slideUp('fast');
    }else{
        $.getJSON(token_actions,{action:'cambiarEstado', id_order: id_order, id_shop: id_shop,
            nuevoEstado:nuevoEstado,id_employee: id_employee, id_lang:id_lang, ajax : "1",},function(data) {
                if(data != null){
                    $.each(data, function(index, result) {
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia #cambioEstado .idPedido').html(id_order);
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia #cambioEstado .nombrePedido').html(result.name);
                    });
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia #cambioEstado').slideDown('fast');
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia #cambioEstado').delay(5000).slideUp('fast');
                }
                $(".loaderTicket").hide();
                $.mobile.changePage("#pedidoPage");
                getOrder(id_order);
        });
    }
}
function cambiarEmpleado(nuevoEmpleado){
    $.getJSON("../modules/tpvtienda/classes/actions/actions.php",{token:token, action:'cambioEmpleado', id_order: id_order_global, id_shop: id_shop,
        nuevoEmpleado: nuevoEmpleado, id_lang:id_lang},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                $("#"+$.mobile.activePage.attr('id')+' .advertencia #cambiadoEmpleado .nombreEmpleadoNuevo').html(result);
            });
            $("#"+$.mobile.activePage.attr('id')+' .advertencia #cambiadoEmpleado').slideDown('fast');
            $("#"+$.mobile.activePage.attr('id')+' .advertencia #cambiadoEmpleado').delay(5000).slideUp('fast');
        }
        $(".loaderTicket").hide();
    });
}
function guardarNota(){
    if($.mobile.activePage.attr('id') == 'pedidoPage' || $.mobile.activePage.attr('id') == 'aCreditoPage'){
        var textoNota = $("#"+$.mobile.activePage.attr('id')+" .notaPedido").val();
    }
    if($.mobile.activePage.attr('id') == 'pedidoSAT'){
        var textoNota = $("#"+$.mobile.activePage.attr('id')+" .notaPedido").val();
        var textoNotaPrivada = $("#"+$.mobile.activePage.attr('id')+" textarea[name=messageOrderPrivadaSAT]").val();
    }


     $.getJSON("../modules/tpvtienda/classes/actions/actionsPedido.php",{token:token, action:'guardarNota', id_order: id_order_global,
        id_shop: id_shop,note:textoNota,id_lang: id_lang},function(data) {
        $.each(data, function(index, result) {
            if(result.ok == 1){
                showSuccessMessage(update_success_msg);
            }else{
                showErrorMessage("Error");
            }
        });
    });
}


function modProductoOrder(id_order,id_order_detail){
    var name = $("#"+$.mobile.activePage.attr('id')+' .opd_'+id_order_detail+' .nameOpd a').html();
    var ratio = $("#"+$.mobile.activePage.attr('id')+' .opd_'+id_order_detail+' .cantOpd .ratio').val();
    var unityAmount = $("#"+$.mobile.activePage.attr('id')+' .opd_'+id_order_detail+' .cantOpd .unityAmount').html();
    var unity = $("#"+$.mobile.activePage.attr('id')+' .opd_'+id_order_detail+' .cantOpd .unity').html();
    var price = $("#"+$.mobile.activePage.attr('id')+' .opd_'+id_order_detail+' .contPriceOrd').html();
    var desc = $("#"+$.mobile.activePage.attr('id')+' .opd_'+id_order_detail+' .contDescOrd').html();
    var descType = $("#"+$.mobile.activePage.attr('id')+' .opd_'+id_order_detail+' .contDescType').html();
    var cantidad = $("#"+$.mobile.activePage.attr('id')+' .opd_'+id_order_detail+' .cantOpd .unidades').html();
    if(unityAmount != undefined && unityAmount != ""){
        var unityText = '<div class="row">'+
                            '<div class="eightcol">'+
                                '<input type="hidden" class="opd'+id_order_detail+'unityAmount" value="'+unityAmount+'">'+
                                '<input type="hidden" class="opd'+id_order_detail+'ratio" value="'+ratio+'">'+
                                '<input type="hidden" class="opd'+id_order_detail+'priceOrig" value="'+(price/cantidad)+'">'+
                                '<input type="text" onkeyup="changePriceUnity('+id_order_detail+')" class="opd'+id_order_detail+'unity ui-btn ui-btn corner-all ui-shadow" value="'+unityAmount+'"></div>'+
                            '<div class="fourcol last">'+unity+'</div>'+
                        '</div>';
    }else{
        var unityText = '';
    }
    $("#"+$.mobile.activePage.attr('id')+' .opd_'+id_order_detail+' .nameOpd').html('<input type="text" class="opd'+id_order_detail+'name ui-btn ui-btn corner-all ui-shadow" value="'+name+'">');
    $("#"+$.mobile.activePage.attr('id')+' .opd_'+id_order_detail+' .cantOpd').html('<input type="text" class="opd'+id_order_detail+'cant ui-btn ui-btn corner-all ui-shadow" value="'+cantidad+'">'+ unityText);
    $("#"+$.mobile.activePage.attr('id')+' .opd_'+id_order_detail+' .contPriceOrd').html('<input type="text" class="opd'+id_order_detail+'price ui-btn ui-btn corner-all ui-shadow" value="'+price+'">');
    $("#"+$.mobile.activePage.attr('id')+' .opd_'+id_order_detail+' .contDescOrd').html('<input type="text" class="opd'+id_order_detail+'desc ui-btn ui-btn corner-all ui-shadow" value="'+desc+'">');
    $("#"+$.mobile.activePage.attr('id')+' .opd_'+id_order_detail+' .contDescType').html('<select name="descType" class="opd'+id_order_detail+'descType"><option value="perc"'+(descType == '%' ? ' selected' : '')+'>%</option><option value="amount"'+(descType == currencySign ? ' selected' : '')+'>'+currencySign+'</option></select>');
    $("#"+$.mobile.activePage.attr('id')+' .opd_'+id_order_detail+' .descCont').show();
    $("#"+$.mobile.activePage.attr('id')+' .opd_'+id_order_detail+' .editOPD').hide();
    $("#"+$.mobile.activePage.attr('id')+' .opd_'+id_order_detail+' .deleteOPD').hide();
    $("#"+$.mobile.activePage.attr('id')+' .opd_'+id_order_detail+' .guardarOPD').show();
}

function changePriceUnity(id_order_detail){
    var unity = $("#"+$.mobile.activePage.attr('id')+' .opd'+id_order_detail+'unity').val();
    var unityAmount = $("#"+$.mobile.activePage.attr('id')+' .opd'+id_order_detail+'unityAmount').val();
    var ratio = $("#"+$.mobile.activePage.attr('id')+' .opd'+id_order_detail+'ratio').val();
    var price = $("#"+$.mobile.activePage.attr('id')+' .opd'+id_order_detail+'priceOrig').val() / ratio;
    $(".opd"+id_order_detail+'price').val((price * unity) / unityAmount);

}
function deleteProductOrder(id_order,id_order_detail,pagina){
    $(".listadoPedidosPage h1").html(pedidosTxT);
    $.getJSON("../modules/tpvtienda/classes/actions/actionsPedido.php",{token:token, action:'deleteProductOrder', id_order: id_order,id_order_detail:id_order_detail,
        cajaEnUso:cajaEnUso, id_employee: id_employee, id_shop: id_shop},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(result.error != null){
                    error = true;
                    mostrarError(result.error);
                }
                if(result.ok != null){
                    if($.mobile.activePage.attr('id') == "pedidoPage")
                        getOrder(id_order);
                    if($.mobile.activePage.attr('id') == "pedidoSAT")
                        abrirPedidoSAT(id_order);
                    if($.mobile.activePage.attr('id') == "aCreditoPage")
                        actualizarPagoAcredito(id_order);
                }
            });
        }
    });
}
function cambioEnPedido(id_order,id_order_detail){
    var name = $("#"+$.mobile.activePage.attr('id')+' .opd'+id_order_detail+'name').val();
    var cant = $("#"+$.mobile.activePage.attr('id')+' .opd'+id_order_detail+'cant').val();
    var price = $("#"+$.mobile.activePage.attr('id')+' .opd'+id_order_detail+'price').val();
    var desc = $("#"+$.mobile.activePage.attr('id')+' .opd'+id_order_detail+'desc').val();
    var descType = $("#"+$.mobile.activePage.attr('id')+' .opd'+id_order_detail+'descType').val();
    $(".listadoPedidosPage h1").html(pedidosTxT);
    $.post(token_actions,{action:'cambioEnPedido',ajax:"1",name:name,cant:cant,price:price,id_order_detail:id_order_detail,tax:tax,
        id_employee:id_employee,id_shop:id_shop,desc:desc,descType:descType},function(data) {
        data = JSON.parse(data);
        if(data != null){
            $.each(data, function(index, result) {
                if(result.error != null){
                    error = true;
                    mostrarError(result.error);
                    getOrder(id_order);
                }
                if(result.ok != null){
                    if($.mobile.activePage.attr('id') == "pedidoPage")
                        getOrder(id_order);
                    if($.mobile.activePage.attr('id') == "pedidoSAT")
                        abrirPedidoSAT(id_order);
                    if($.mobile.activePage.attr('id') == "aCreditoPage")
                        actualizarPagoAcredito(id_order);
                }
            });
        }
    });
}
function getPagos(scroll){
    var query = $('#busquedaPagos').val();
    var filtroMetodoPago = $('#filtroMetodoPago').val();
    var fecha = $('.fechaPagos').val();
    if(scroll == '')
        scroll = false;
    if(!scroll || typeof scroll == "undefined"){
        inicioPagos = 0;
        $(".pagosForm table tbody").html('');
    }
    if(inicioPagos != "-1"){
        $.getJSON("../modules/tpvtienda/classes/actions/actions.php",{token:token, action:'getPagos', fecha:fecha,filtroMetodoPago:filtroMetodoPago, query: query,
            id_shop: id_shop,c:cantidadPagos, p:inicioPagos},function(data) {
            if(data != null){
                $.each(data, function(index, result) {
                    var i=1;
                    var html = "<tr id='pago_"+result.id_payment+"' class='pedido "+((i++ % 2 ==0) ? 'odd' : '')+"' >" +
                              "<td>" +result.id_order+'</td>'+
                            '<td>'+result.card_holder+'</td>'+
                            '<td>'+result.metodoPago+'</td>'+
                            '<td>'+result.cantidad+'</td>'+
                            '<td>'+result.card_number+'</td>'+
                            '<td>'+result.card_expiration+'</td>'+
                            '<td>'+result.card_brand+'</td>'+
                            '<td>'+result.transaction_id+'</td>'+
                            '<td>'+result.fecha+'</td>'+
                        '</tr>';
                    $('.pagosForm table tbody').append(html);
                });
                if(query != "")
                    inicioPagos = -1;
                if(inicioPagos != "-1")
                    inicioPagos += cantidadPagos;
                if(data.length == cantidadPagos)
                    $("#more_pagos").show();
                else
                    $("#more_pagos").hide();
            }else{
                inicioPagos = -1;
                $("#more_pagos").hide();
                $("#"+$.mobile.activePage.attr('id')+' .advertencia .nohayresultados').slideDown('fast');
                $("#"+$.mobile.activePage.attr('id')+' .advertencia .nohayresultados').delay(3000).slideUp('fast');
             }
        });
    }
}
function check(item){
    var orderLabel = item.split("_");
    orderLabel = orderLabel[0];
    if($('#item_'+item).prop('checked')){
        $('#item_'+item).prop('checked',false);
        $('#order_'+item).removeClass('selected');
    }else{
        $('#item_'+item).prop('checked',true);
        $('#order_'+item).addClass('selected');
    }
    contadorAdevolver();
}
function check2(item){
    var orderLabel = item.split("_");
    orderLabel = orderLabel[0];
    if($('#item_'+item).prop('checked'))
        $('#order_'+item).addClass('selected');
    else
        $('#order_'+item).removeClass('selected');
    contadorAdevolver();
}
function check3(item){
    if($('#item_'+item).prop('checked'))
        $('.OCPago_'+item).addClass('selected');
    else
        $('.OCPago_'+item).removeClass('selected');
    contadorAdevolver();
}
function contadorAdevolver(){
    var contador = 0;
    $('#listadoPedidos tr.prodOrder.selected').each(function(index, result) {
        var id_prod_pedido = $(this).attr("id").replace("order_", "");
        contador += parseInt($("#quantity_"+id_prod_pedido).val());
    });
    $('#listadoPedidos tr.pagoOrder.selected').each(function(index, result) {
        contador++;
    });
    $('#contadorDevs').html(contador);
    if(contador == 0)
        $('#BarraAccionesDevs').slideUp("fast");
    else
        $('#BarraAccionesDevs').slideDown("fast");
}
function listaDevolucionestoString(id_order){
    var html='';
    $(".prodOrder.selected select").each(function(index, result) {
        var idProd = $(this).attr("id");
        var producto = idProd.split("_");
        var priceDev = $("#order_"+producto[1]+"_"+producto[2]+" .price").data("price");
        var priceDevExcl = $("#order_"+producto[1]+"_"+producto[2]+" .price").data("price-excl");
        var qty = $(this).val();
     //   priceDev = priceDev * qty;
//        priceDevExcl = priceDevExcl * qty;
        if(html == '')
            html = producto[2]+"_"+$(this).val()+"_"+priceDev+"_"+priceDevExcl;
        else
            html += ","+producto[2]+"_"+$(this).val()+"_"+priceDev+"_"+priceDevExcl;
    });
    return html;
}

function printTrigger(elementId) {
    var getMyFrame = document.getElementById(elementId);
    getMyFrame.focus();
    getMyFrame.contentWindow.print();
}
function borrarPrecioCambiado(id_product, id_product_attribute){
    $.get("../modules/tpvtienda/classes/actions/actions.php",{token:token, action:'borrarPrecioCambiado', id_product: id_product, id_product_attribute: id_product_attribute,
        id_shop: id_shop, id_cart: id_cart},function(data) {
        if(data == 1)
            updateCompra();
    });
}
function borrarPrecioCambiadoDev(id_product, id_product_attribute){
    $.getJSON(token_actions,{action:'borrarPrecioCambiadoDev', ajax:"1",id_product: id_product, id_product_attribute: id_product_attribute,
        id_shop: id_shop, id_cart: id_cart, id_employee: id_employee},function(data) {
        updateCompra();
    });
}
function printCodebar(id_product,id_product_attribute){
    $('#selectedProducts').val(id_product+'_'+id_product_attribute+'_1');
    $('form#codigosBarrasForm').submit();
}
function eanCheckDigit(barcode){
     var barcodeLengthArr = [8, 12, 13, 14];
    var allowedChars = new RegExp(/\d{8,14}/); // >7 & <15
    // put numbers in array and convert to type Int.
    var barcodeArray = barcode.split('');
    for( var i = 0; i < barcodeArray.length; i++) {
        barcodeArray[i] = parseInt(barcodeArray[i], 10);
    }
    // get the last digit for checking later
    var checkDigit = barcodeArray.slice(-1)[0];
    // we'll need a to compare it to this:
    var remainder = 0;

    // check if input (barcode) is in the array and check against the regex.
    if (($.inArray(barcode.length, barcodeLengthArr) > -1) && (allowedChars.test(barcode))) {

        // Pop the last item from the barcode array, test if the length is
        // odd or even (see note on calculating the check digit) and
        // multiply each item in array based in position:
        var total = 0;
        barcodeArray.pop();
        // odd length after pop
        if (barcodeArray.length % 2 === 1) {
            for (var i = barcodeArray.length - 1; i >= 0; i--) {
                barcodeArray[i] = i % 2 === 0 ? barcodeArray[i] * 3 : barcodeArray[i] * 1;
                total += barcodeArray[i];
            }
        // even length after pop
        } else if (barcodeArray.length % 2 === 0) {

            for (var i = barcodeArray.length - 1; i >= 0; i--) {
                barcodeArray[i] = i % 2 === 0 ? barcodeArray[i] * 1 : barcodeArray[i] * 3;
                total += barcodeArray[i];
            }
        } else {
            return false;
        }
        // calculate the remainder of totalrounded up to nearest multiple of 10:
        remainder = (Math.ceil((total + 1) / 10) * 10) - total;
        if ( remainder === checkDigit ) {
            return true;
        } else {
            return false;
        }

    } else {
        return false;
    }
}
function printKeys() {
    teclas = teclas.replace("J", "");
    teclas = teclas.replace(/\r|\t|\n/, "");
    teclas = teclas.replace("(", "");
    teclas = teclas.replace("%10", "");
    teclas = teclas.replace(/[^0-9a-z]/gi, '');
    if(existsHookJS('printKeys')){
        hookJS('printKeys',{'teclas':teclas}) ;
    }else{
        if(teclas.length >= 5){
            if(!$("#entradaCodigo .order_query").is(":focus")){
               if(teclas.length == 12 && upc_como_plu == 1 && teclas[0] == 1){
                    buscoUPC(teclas);
                }else if(teclas.length == 12){
                    buscoPLU(teclas);
                }else if(teclas.includes("CC")){
                    abrirCajon();
                }else if(teclas.length == 14 && balanza_ean13 == 1 && teclas.substring(0, 2) == '25'){
                    buscoBalanzaEan13(teclas);
                }else if(teclas.length == 35){
                    // EAN128 o GS1-128
                    // Ej: (01)08422915006205(37)001(17)210101(10)1111    los parenteris no se cuentan, son solo indicativos
                    // 01 (indicador de DUN14)
                    // DUN14 (14 dígitos el primero siempre un 0)
                    // 37 (indicador de unidades internas)
                    // UNIDADES (siempre tres dígitos)
                    // 17 (indicador de fecha de caducidad)
                    // FECHA_CADUCIDAD (AAMMDD)
                    // 10 (indicador de lote)
                    // LOTE (cuatro dígitos)
                    buscoCodebar(teclas.substring(3, 16),parseInt(teclas.substring(18, 21)));
                }else if(teclas.length == 13 && balanza_ean13_2 == 1 && (teclas.substring(0, 2) == '25' || teclas.substring(0, 2) == '26')){
                    buscoBalanzaEan13_2(teclas);
                }else if (/[a-zA-Z]/.test(teclas)){
                    getDiscountbyCode(teclas);
                }else if(teclas.length == 8){
                    if(eanCheckDigit(teclas)){
                       buscoCodebar(teclas,1,false,addCustomerCodebar);
                    }
                }else
                    buscoCodebar(teclas);
            }
        }else{
            if(!$("#entradaCodigo .order_query").is(":focus")){
                /*
                 * var cantidadCodebar = teclas; if($.isNumeric(cantidadCodebar) &&
                 * cantidadCodebar != ''){ $("#cantidadCodebar").effect( "bounce",
                 * {}, 500, function(event){
                 * $('#cantidadCodebar').html(cantidadCodebar);
                 * $('#cantidadCodebar').addClass('alterado'); }); }
                 */
            }else{
                atajosTeclado(teclas);
            }
        }
        teclas = '';
    }
}
function addCustomerCodebar(teclas) {
    var clienteId = parseInt(teclas.substring(0, 7));
    addCustomer(clienteId,'#cliente_'+clienteId);
}
function anadirMascaraObligatoria(){
    $('#subTPVTienda').append('<div class="maskTPVTiendaObligatoria"></div>');
    $('.maskTPVTiendaObligatoria').show();
}
function cambiarNombre(id_product,nuevoNombre,viejoNombre){
    if(nuevoNombre != '' && nuevoNombre != viejoNombre){
        $.get("../modules/tpvtienda/classes/actions/actionsCambioNombre.php",{token:token, action:'cambioNombre', id_currency: $("#currencyPOS").val(), id_shop: id_shop,
            id_cart:id_cart,nuevoNombre:nuevoNombre, id_product:id_product},function(data) {
            if(data != ''){
                if(data==1){
                    $('#compra').show();
                    $('#compraVacia').hide();
                    updateCompra();
                }else{
                    mostrarError(data);
                }
            }
        });
    }
}
function borrarCambioNombre(id_cambio_nombre){
    if(id_cambio_nombre != ''){
        $.get("../modules/tpvtienda/classes/actions/actionsCambioNombre.php",{token:token, action:'borrarCambioNombre', id_currency: $("#currencyPOS").val(), id_shop: id_shop,
            id_cart:id_cart,id_cambio_nombre:id_cambio_nombre},function(data) {
            if(data != ''){
                if(data==1){
                    $('#compra').show();
                    $('#compraVacia').hide();
                    updateCompra();
                }else{
                    mostrarError(data);
                }
            }
        });
    }
}

function atajosTeclado(tecla){
    if(tecla == 117){ // F6
        borrarProductos();
    }
    if(tecla == 118){ // F7
        $("#flecha").trigger("click");
    }
    if(tecla == 119){ // F8
        $("#compra [id^=cantidadProducto]").first().trigger("click");
    }
    if(tecla == 120){ // F9
        var indiceFormaPago = $(".formaPago.elegida").index();
        var nFormasPago = $(".formaPago").length;
        indiceFormaPago = indiceFormaPago % nFormasPago;
        $(".formaPago").eq(indiceFormaPago).trigger("click");
//        $("#formaPago option:selected").next().attr('selected', 'selected');
//        var colorAntes = $('#formaPago-button').css('backgroundColor');
//        $('#formaPago-button').animate({background: "#DFF0D8"}, 200 ).delay(300).animate({background: colorAntes}, 200 );
//        $("#formaPago").selectmenu('refresh');
    }
    if(tecla == 113){ // F2
        $('#'+$.mobile.activePage.attr('id')+' .order_query').focus();
    }
    if(tecla == 27){ // ESC
        borrarProductos();
    }
    if(tecla == 121){ // F10
        $("#checkoutButton").trigger("click");
       //  comprobarPago();// confirma compra
    }
    if(tecla == 121){ // F10
        $("#checkoutButton").trigger("click");
       //  comprobarPago();// confirma compra
    }
}
function cargaMasProductos(){
    if(ultimaBusqueda == 'categoriaId'){
        if(plantilla_pos == "full-width"){
            getCategoriaId($('#'+$.mobile.activePage.attr('id')+' select.categorias').val());
        }
        if(plantilla_pos == "fiftyfifty"){
            getCategoriaId(catActual);
        }
    }
    if(ultimaBusqueda == 'search')
        search(0);
}

function avisoCaja(){
    $('.ui-popup').popup('close');
    $("#popupAvisoCaja").popup( "open");
}

function createSwiper(id,cssWidthAndHeight,orientacionSwiper){
    if(cssWidthAndHeight != null)
        cssWidthAndHeight = true;
    if(orientacionSwiper == "")
        orientacionSwiper = 'vertical';
        //si es un dispositivo pequeño los productos pasan a horizontal
    if(id == '#list-products-tpvtienda' && $(window).width() < 945)
        orientacionSwiper = 'horizontal';
    if(orientacionSwiper == "vertical")
        var scrollVar = {el: ".swiper-scrollbar", hide: true};
    else
        var scrollVar = {el: ".swiper-scrollbar", hide: false};
    var swiper = new Swiper(id,{
        direction:orientacionSwiper,
        slidesPerView: 'auto',
        KeyboardControl:true,
        freeMode: true,
        scrollbar: scrollVar,
        cssWidthAndHeight:cssWidthAndHeight,
        queueStartCallbacks: true,
       // centerInsufficientSlides: true,      no funciona no poniendo el slidesPerview con un numero
        threshold: 30,
        onTouchEnd:function(swiper, event) {
            //compruebo si el threshold es mayor de 10, lo hago asi porque no funciona el parametro moveStartThreshold
            if(plantilla_pos != 'fiftyfifty' && Math.abs(mySwiper.touches.startX - mySwiper.touches.currentX) > 200){
//                if(plantilla_pos != 'fiftyfifty')
                cargaMasProductos(mySwiper);
                event.preventDefault;
            }
            event.preventDefault;

           // if(plantilla_pos == 'fiftyfifty' && Math.abs(mySwiper.touches.startY - mySwiper.touches.currentY) > 300){
//                cargaMasProductos(mySwiper);
//                event.preventDefault;
//            }
        },
    });
    return swiper;
}
function anadirProdPedido() {
    $("#"+$.mobile.activePage.attr('id')+" .popupProducto").popup("open");
    ultimaBusqueda = "limpieza";
    getCategoriaId('');
}
function addProductOnOrder(id_product,attribute,cantidadProd,name,focus) {
    if(cantidadProd == null)
        cantidadProd = 1;
    $("#"+$.mobile.activePage.attr('id')+' .popupProducto').popup("close");
    // $(".loaderProductos").show();
    $("#checkoutButton").addClass("tpv-disabled");
    $("#"+$.mobile.activePage.attr('id')+" .popupCombinaciones").popup( "close");
    var hayCombinaciones = false;
    var grupos = [];
    var flagExiste = 0;
    if (typeof tablaCombinaciones == 'object' || (typeof $.fn.DataTable != "undefined" && $.fn.DataTable.isDataTable("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones table.productosComb') )) {
        $("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones table.productosComb').DataTable().destroy();
    }
    $(".listadoPedidosPage h1").html(pedidosTxT);
    $.post(token_actions,{action:'addProductOnOrder', ajax : "1", id_product:id_product, id_order:id_order_global,
        attribute:attribute, cantidad:cantidadProd, id_lang:id_lang, id_currency:$('#currencyPOS').val(),id_shop: id_shop,id_employee:id_employee}).done(function( data ) {
        data = JSON.parse(data);
        $.each(data, function(index, result) {
            if(result.error != null)
                mostrarError(result.error);
            if( result.ok != null){
                if($.mobile.activePage.attr('id') == "aCreditoPage")
                    abrirFactCred(id_order_global);
                if($.mobile.activePage.attr('id') == "pedidoSAT")
                    abrirPedidoSAT(id_order_global);
                 if($.mobile.activePage.attr('id') == "pedidoPage")
                    getOrder(id_order_global);
            }
            if(typeof result.groups === 'object' && result.groups != null){
                hayCombinaciones = true;
                $("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones .productosComb thead tr th.anadido').remove();
                grupos = result.groups;
                $.each(result.groups, function(index, group) {
                    $("<th class='anadido group_"+index+"'>"+group+"</th>").insertBefore("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones .productosComb thead th.camposFijos:first');
                });
            }
            if(typeof result.combinaciones === 'object' && result.combinaciones != null){
                hayCombinaciones = true;
                $("#"+$.mobile.activePage.attr('id')+" .popupCombinaciones h1").html(name);
                $("#"+$.mobile.activePage.attr('id')+" .popupCombinaciones .productosComb tbody").html("");
                $.each(result.combinaciones, function(index, combinacion) {
                    var groupsText = "";
                    $.each(grupos, function(index, group) {
                        if(typeof combinacion.groups[index] != 'undefined')
                            groupsText += '<td>'+combinacion.groups[index]+'</td>';
                        else{
                            groupsText += '<td></td>';
                        }
                    });
                    $("#"+$.mobile.activePage.attr('id') + " .popupCombinaciones .productosComb tbody").append('<tr class="combProd" onclick="addProductOnOrder('+id_product+','+combinacion.id_product_attribute+',1)">'+groupsText+'<td>'+combinacion.qty+'</td><td>'+combinacion.price+'</td></tr>');
                });
            }
        });
        if(hayCombinaciones){
            var dontSort = [];
            $("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones table.productosComb thead th').each(function () {
                if ($(this).hasClass( 'anadido')) {
                    dontSort.push( {
                       "bSortable": false
                    });
                }else {
                    dontSort.push( null );
                }
            });
            tablaCombinaciones = $("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones table.productosComb').DataTable({
                initComplete: function () {
                    var api = this.api();
                    var col = 0;
                    api.columns().indexes().flatten().each( function ( i ) {
                        var column = api.column( i );
                        var title = column.header();
                        var pasadas = 0;
                        if(!$(title).hasClass('camposFijos')){

                            var tituloGrupo = "";
                            $.each(grupos, function(index, group) {
                                if(col == pasadas)
                                    tituloGrupo = grupos[index];
                                pasadas++;
                            });
                            var select = $('<select><option value="">'+tituloGrupo+'</option></select>')
                                .appendTo( $(column.header()).empty() )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );
                                    column.search( val ? '^'+val+'$' : '', true, false ).draw();
                                } );
                            column.data().unique().sort().each( function ( d, j ) {
                                   if(d != '')
                                       select.append( '<option value="'+d+'">'+d+'</option>')
                            });
                        }
                         col++ ;
                    } );
                },
                "sDom": '<"top">rt<"bottom"lp><"clear">',
                "aaSorting": [[ $("#"+$.mobile.activePage.attr('id')+" .popupCombinaciones table.productosComb thead th").length-2, "desc" ]],
                "aoColumns": dontSort,
                "bPaginate":true,
                "pageLength": 10,
                "bFilter":true,
                "bDestroy" : true,
                "bLengthChange":false,
            });
            $("#"+$.mobile.activePage.attr('id')+ " .popupCombinaciones").popup( "open");
        }
        // $(".loaderProductos").hide();
    });
}
function abrirPedidos(filtroEstado){
    $.mobile.changePage("#listadoPedidosPage");
    valorActual = "";
    var altura = $(window).height();

    $("#listadoPedidosPage .table-responsive").css('height',(altura-160)+'px');
    getOrders(filtroEstado);
}
function volverAinicio(){
    $.mobile.changePage("#TPVTienda");
    resizeContCompra();
    modo = 0;
}
function llamadaCambiarEstado(contadorEstados,totalPedidos,pedidos){
    $.getJSON(token_actions,{action:'cambioEstadoMasivo', pedidos: pedidos, id_shop: id_shop, contadorEstados:contadorEstados,
        nuevoEstado:$("#"+$.mobile.activePage.attr('id')+ " select.nuevoEstadoMasivo").val(),id_employee: id_employee, id_lang:id_lang, ajax : "1",},function(data) {
        $.each(data, function(index, result) {
            if(result.error != null){
                mostrarError(result.error);
                return 0;
             }
            if(result.ok != null){
                console.log(contadorEstados+" / "+totalPedidos);
                $("#"+$.mobile.activePage.attr('id')+ " .contadorCambioEstadoMasivo").html(contadorEstados+" / "+totalPedidos);
                contadorEstados = parseInt(contadorEstados)+1;
                if(contadorEstados > totalPedidos)
                    contadorEstados = totalPedidos;
                if(contadorEstados == totalPedidos){
                    getOrders();
                    $("#"+$.mobile.activePage.attr('id')+ " .contadorCambioEstadoMasivo").html(contadorEstados+" / "+totalPedidos);
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html(pedidosCambiadosTxT);
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').slideDown('fast');
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(6000).slideUp('fast');
                    $("#"+$.mobile.activePage.attr('id')+ " .contadorCambioEstadoMasivo").delay(6000).hide();
                    $('.popupCambioEstadoMasivo').popup('close');
                }else{
                    llamadaCambiarEstado(contadorEstados,totalPedidos,pedidos);
                }
            }
        });
    });
}
function cambiarEstadoMasivo(){
    var pedidos = "";
    if($("#"+$.mobile.activePage.attr('id')+ " input[name=pedidos]:checked").length == 0){
        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').html(eligePedidosTxt);
        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').slideDown('fast');
        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').delay(6000).slideUp('fast');
    }else{
        var arrayPedidos = [];
        var contadorEstados = 0;
        var totalPedidos = $("#"+$.mobile.activePage.attr('id')+ " input[name=pedidos]:checked").length;
        $("#"+$.mobile.activePage.attr('id')+ " .contadorCambioEstadoMasivo").html("0 / "+totalPedidos);
        console.log("0 / "+totalPedidos);
        $("#"+$.mobile.activePage.attr('id')+ " .contadorCambioEstadoMasivo").show();
        $("#"+$.mobile.activePage.attr('id')+ " input[name=pedidos]:checked").each(function(){
            if(pedidos == "")
                pedidos += $(this).val();
            else
                pedidos += ","+$(this).val();
        });
        $.getJSON(token_actions,{action:'cambioEstadoMasivo', pedidos: pedidos, id_shop: id_shop, contadorEstados: contadorEstados,
            nuevoEstado:$("#"+$.mobile.activePage.attr('id')+ " select.nuevoEstadoMasivo").val(),id_employee: id_employee, id_lang:id_lang, ajax : "1",},function(data) {
            if(data != null){
                 $.each(data, function(index, result) {
                    if(result.error != null)
                        mostrarError(result.error);
                    if(result.ok == '1'){
                        llamadaCambiarEstado(parseInt(contadorEstados)+1,totalPedidos,pedidos);
                    }
                });
                //$.each(data, function(index, result) {
//                        $("#"+$.mobile.activePage.attr('id')+' .advertencia #cambioEstado .idPedido').html(id_order);
//                        $("#"+$.mobile.activePage.attr('id')+' .advertencia #cambioEstado .nombrePedido').html(result.name);
//                    });
//                    $("#"+$.mobile.activePage.attr('id')+' .advertencia #cambioEstado').slideDown('fast');
//                    $("#"+$.mobile.activePage.attr('id')+' .advertencia #cambioEstado').delay(5000).slideUp('fast');
            }
        });
    }
}
function volverAPedidos(){
    $.mobile.changePage("#listadoPedidosPage");
    valorActual = "";
    var altura = $(window).height();
    $("#listadoPedidosPage .table-responsive").css('height',(altura-160)+'px');
  //   $("#contPedidos tbody").html("");
    if(vengo_de == "presupuesto"){
        $("#contPedidos tbody").html("");
        getOrders(nombreEstadoPresupuesto);
    }else if(vengo_de == "acredito"){
        tablaPedidosAcredito.ajax.reload( null, false );
    }else
        getOrders();
}
function abrirCategoria(id){
    mySwiper.removeAllSlides();
    catActual = id;
    inicioProductos = 0;
    // hago esto para que al clicar una categoria siempre limpie pantalla
    ultimaBusqueda = 'limpieza';
    getCategoriaId(id);
}

function getOrders(filtroEstado){
    $("#contPedidos tbody").html("");
    $(".loading").show();
    $("#pedidosVacios").hide();
    var selected = [];
    $('#listadoPedidosPage').css({"height":(heightFondo-34)+'px'});
    if (typeof tablaPedidos == 'object' || (typeof $.fn.DataTable != "undefined" && $.fn.DataTable.isDataTable('table#contPedidos') )) {
      $('table#contPedidos').DataTable().destroy();
    }
    tablaPedidos = $('table#contPedidos').DataTable({
        dom: 'Tf<"clear">lrti',
        // dom: 'Tf<"clear">rt',
        initComplete: function () {
            var api = this.api();
            api.columns().indexes().flatten().each( function ( i ) {
                var column = api.column( i );
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search( val ? '^'+val+'$' : '', true, false ).draw();
                    } );
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>')
                } );
            } );
        },

        "columnDefs": [
            {"targets": 0,"width": "40px","sortable":false}, // checkboxs
            {"targets": 1,"width": "80px"},                  // ID
            {"targets": 2,"width": "120px"},                 //referencia
            {"targets": 3,"width": "140px", className: "abrirTicket"},        //ticket
            {"targets": 4,"width": "140px", className: "contVerFacturaAcredito" } //factura
        ],
        "language":traducciones,
        "aLengthMenu":[[30,60,120,240,480,960,1920,3840,7680,99999999999],[30,60,120,240,480,960,1920,3840,7680,"All"]],
        "bLengthChange": true,
        "order": [[ 1, "desc" ]],
        serverSide: true,
        processing: true,

        "ajax": $.fn.dataTable.pageLoadMore(
            {
            "url": "../modules/tpvtienda/classes/actions/actionsOrdersAlert.php?action=getOrders&"+(filtroEstado == nombreEstadoPresupuesto ? "estado="+nombreEstadoPresupuesto+"&" : "")+"id_shop="+id_shop+"&id_lang="+id_lang+"&token="+token+"&id_currency="+$('#currencyPOS').val()+"&id_employee="+id_employee,
            "data": {
                "token": token
                }
            }
        ),
        drawCallback: function() {
            // Show or hide "Load more" button based on whether there is more data available
            $('#'+$.mobile.activePage.attr('id')+' #btn-example-load-more-ordersTPV').toggle(this.api().page.hasMore());
        }
    });
    $('#'+$.mobile.activePage.attr('id')+' #btn-example-load-more-ordersTPV').on('click', function(){
            // Load more data
            tablaPedidos.page.loadMore();
        }
    );
        // Setup - add a text input to each footer cell
        var contadorCabeceras = 0
    $('#contPedidos thead th').each( function () {
        var title = $(this).attr("title");
        if(contadorCabeceras != 0)
            $(this).html( '<input type="text" id="filtroPedidos_'+contadorCabeceras+'" class="filtroTablaPedidos" placeholder="'+title+'" />');
        if(contadorCabeceras == 8){
            $('#filtroPedidos_'+contadorCabeceras).datepicker({
                            dateFormat : date_format,
                            changeMonth: true,
                            changeYear: true,
                            beforeShow: function() {
                            },
                            onSelect: function( selectedDate ) {
                                $(this).trigger("keyup");
                               //  lista[id_product][attribute]['d'] = selectedDate;
                            }
                        });
        }
        contadorCabeceras++;
    } );


    // Con esta función evito que al clicar en el input ordene
    $("#contPedidos thead input").click( function (e) {
        if (!e) var e = window.event
        e.cancelBubble = true;
        if (e.stopPropagation) e.stopPropagation();
    });
    // Apply the search
    $( '.filtroTablaPedidos, .buscarProducto').on( 'keyup', function (event) {
        event.stopPropagation();
        var altura = $(window).height();
        $("#listadoPedidosPage").css({'height':(altura)+'px'});
        tablaPedidos.ajax.url("../modules/tpvtienda/classes/actions/actionsOrdersAlert.php?action=getOrders&id_order="+$("#filtroPedidos_1").val()+"&referencia="+$("#filtroPedidos_2").val()+
            "&ticket="+$("#filtroPedidos_3").val()+"&factura="+$("#filtroPedidos_4").val()+"&cliente="+$("#filtroPedidos_5").val()+"&estado="+$("#filtroPedidos_6").val()+
            "&total="+$("#filtroPedidos_7").val()+"&fecha="+$("#filtroPedidos_8").val()+"&producto="+$(".buscarProducto").val()+
            "&id_shop="+id_shop+"&id_lang="+id_lang+"&token="+token+"&id_currency="+$('#currencyPOS').val()+"&id_employee="+id_employee+"&limit=50").load();
    });
    $('.check_all').on("click", function(event){
        event.defaultPrevented;
        $('#'+$.mobile.activePage.attr('id')+' input[name=pedidos]').prop('checked', true);
    });
    $('table#contPedidos tbody').unbind( "click" );
    $('table#contPedidos tbody').on('click', 'tr td:not(:first-child)', function (event) {
        //:not(.abrirTicket,.contVerFacturaAcredito)
        if(event.target.className.indexOf("icon") == -1 && event.target.className.indexOf("getticket") == -1 && event.target.className.indexOf("verFactura") == -1){
//            if(event.target.offsetParent.className.toString().indexOf("producto") > 0){
            var id_order = $(this).parent().find("td:eq(1)").html();
            // $(this).toggleClass('selected');
            $.mobile.changePage("#pedidoPage");
            getOrder(id_order);
        }
    });
    if(filtroEstado == nombreEstadoPresupuesto)
        $(".contEstadoPedido .filtroTablaPedidos").val(nombreEstadoPresupuesto);
    else
        $(".contEstadoPedido .filtroTablaPedidos").val("");
    $("#contPedidos").show();
    $(".loading").hide();

}
//function updateOrders(){
//    $("#contPedidos tbody").html("");
//    $(".loading").show();
//    $("#pedidosVacios").hide();
//    $.getJSON("../modules/tpvtienda/classes/actions/actionsOrdersAlert.php",{action:'getOrders', token:token, id_lang: id_lang,
//        id_shop: id_shop,id_currency: $('#currencyPOS').val(),limit:20},function(data) {
//        if(!$.isEmptyObject(data)){
//            $.each(data, function(index, result) {
//                arrayPedidos.push(result.id_order);
//                inicioPedidos++;
//                $("#contPedidos tbody").append(' <tr><td>'+result.id_order+'</td><td>'+result.customer+'</td><td style="background:'+result.color+'>'+result.osname+'</td><td>'+result.date_add+'</td><td>'+result.total+'</td></tr>');
//            });
//            $("#contPedidos").show();
//        }else{
//            $("#pedidosVacios").show();
//        }
//    });
//    $(".loading").hide();
//}
function cambiarAgencia(){
    $("#"+$.mobile.activePage.attr('id')+" input[name=nuevaCantidad]").show();
    $("#"+$.mobile.activePage.attr('id')+" .envioPedido").hide();
    $("#"+$.mobile.activePage.attr('id')+" .envioCambioAgencia").show();
}
function envioCambioAgencia(){
    $.getJSON("../modules/tpvtienda/classes/actions/actionsOrdersAlert.php",{token:token, action:'cambiarAgencia',nuevaAgencia:$("#"+$.mobile.activePage.attr('id')+" select[name=nuevaAgencia]").val(),
        nuevaCantidad:$("#"+$.mobile.activePage.attr('id')+" input[name=nuevaCantidad]").val(), id_lang: id_lang, id_currency: $('#currencyPOS').val(), id_order : id_order_global, id_shop: id_shop},function(data) {
        if(data != null) {
            if($.mobile.activePage.attr('id') == "pedidoPage")
                getOrder(id_order_global);
            if($.mobile.activePage.attr('id') == "aCreditoPage")
                actualizarPagoAcredito(id_order_global);
        }
    });
 }
function convertirPresupuesto(){
    $.getJSON("../modules/tpvtienda/classes/actions/actionsOrdersAlert.php",{action:'convertirPresupuesto', token:token, id_lang: id_lang,id_employee:id_employee, adminDir:adminDir,
        id_shop: id_shop,id_currency: $('#currencyPOS').val(),id_order:id_order_global},function(data) {
         if(!$.isEmptyObject(data)){
            if(data.error != null){
                mostrarError(result.error);
            }
            if(data.ok == '1'){
                $.mobile.changePage('#aCreditoPage');
                actualizarPagoAcredito(id_order_global);
                //cargo en background los pedidos a crédito de nuevo
                getFacturasCredito();
            }
        }
    });
}
function getOrder(id_order){
    hookJS('getOrder',{'id_order':id_order});
    id_order_global = id_order;
    $("#"+$.mobile.activePage.attr('id')+" input[name=nuevaCantidad]").hide();
    $("#"+$.mobile.activePage.attr('id')+" .envioPedido").show();
    $("#"+$.mobile.activePage.attr('id')+" .envioCambioAgencia").hide();
    $("#"+$.mobile.activePage.attr('id')+" .notaPedido").html("");
    $(".contPresus").html("");
    $('.okGenFactura').hide();
    var htmlPagos = "";
    var metodosPagoHtml = getMetodosPago('acredito');
    $("#"+$.mobile.activePage.attr('id')+" .verFacturaPedido").hide();
    $("#"+$.mobile.activePage.attr('id')+" .verAlbaranPedido").hide();
    var pagadoTodoYFaltaPorCambiar = 0;
    $.getJSON("../modules/tpvtienda/classes/actions/actionsOrdersAlert.php",{action:'getOrder', token:token, id_lang: id_lang,id_employee:id_employee, adminDir:adminDir,
        id_shop: id_shop,id_currency: $('#currencyPOS').val(),id_order:id_order},function(data) {
        if(!$.isEmptyObject(data)){
            if(data.payments != null){
                htmlPagos+="<h4>"+pagosTexto+"</h4><table class='dataTable ui-responsive table'><thead><tr><th>"+pagoID+"</th><th>"+formaPago+"</th><th>"+cantidadTexto+"</th><th>"+fecha+"</th><th></th></tr></thead><tbody>";
                $.each(data.payments, function(index, result) {
                    htmlPagos +="<tr>" +
                            "<td>"+result.id+"</td>" +
                            "<td>"+result.payment_method+"</td>" +
                            "<td>"+result.amount+"</td>" +
                            "<td>"+result.date_add+"</td>" +
                            "<td>"+ (permiso_edicion_pedidos ?
                                (data.order.es_acredito != false ? '<a href="#" onclick="getTicketPayment('+id_order+','+result.id+',true)">Ticket</a>' : "")+
                                '<a href="#" onclick="if(confirm(\'delete?\')){deletePayment('+result.id+','+id_order+')}else{event.stopPropagation(); event.defaultPrevented;}"><i class=\"icon-trash\"></i></a></td>' : '')+
                            '</tr>';
                });
            }
            if(data.order != null){
                $("#"+$.mobile.activePage.attr('id')+" .idPedido").html(data.order.id_order);
                hookJS('getOrder',[data.order.id_order]);
                $("#"+$.mobile.activePage.attr('id')+" .refPedido").html(data.order.reference);
                $("#"+$.mobile.activePage.attr('id')+" .fechaPedido").html(data.order.date_add);
                $("#"+$.mobile.activePage.attr('id')+" .fecha").val(data.order.date_add);
                $("#"+$.mobile.activePage.attr('id')+" .envioPedido").html(data.order.envio);
                $("#"+$.mobile.activePage.attr('id')+" input[name=nuevaCantidad]").val(data.order.envioRaw);
                $("#"+$.mobile.activePage.attr('id')+" .descPedido").html(data.order.desc);
                if(typeof data.order.surchage != "undefined"){
                    $("#"+$.mobile.activePage.attr('id')+" .recargoDetalle").show();
                    $("#"+$.mobile.activePage.attr('id')+" .recargoPedido").html(data.order.surchage);
                }else{
                    $("#"+$.mobile.activePage.attr('id')+" .recargoDetalle").hide();
                }
                $("#"+$.mobile.activePage.attr('id')+" .descPedido").html(data.order.desc);
                if(typeof data.order.tbai != "undefined"){
                    $("#"+$.mobile.activePage.attr('id')+" .ticketBaiContent").html(data.order.tbai);
                }
                if(typeof data.order.vfactu != "undefined"){
                    $("#"+$.mobile.activePage.attr('id')+" .veriFactuContent").html(data.order.vfactu);
                }
                $("#"+$.mobile.activePage.attr('id')+" .totalPedido").html(data.order.total);
                pagadoTodoYFaltaPorCambiar = data.order.pagadoTodoYFaltaPorCambiar;
                $("#"+$.mobile.activePage.attr('id')+" select[name=nuevaAgencia]").prop('selectedIndex',$("#"+$.mobile.activePage.attr('id')+" select[name=nuevaAgencia] option[value="+data.order.id_carrier+"]").index()).selectmenu('refresh');
                if(!$.isEmptyObject(data.order.presu)){
                    var html = '';
                    $.each(data.order.presu.link, function(index, lang) {
                        html += '<a href="#" class="ui-btn ui-shadow ui-corner-all" id="presupuestoPOS" onclick="openQuotation('+lang.id_lang+')" ><i class="icon-file"></i><img class="pointer" width="16" height="10" src="'+baseUri+'img/l/'+lang.id_lang+'.jpg" alt="'+lang.name+'" title="'+lang.name+'">  '+data.order.presu.prefix+""+data.order.presu.number+'</a>';
                    });
                    $("#"+$.mobile.activePage.attr('id')+" .notaPedido").val(data.order.presu.note);
                    $('.contButtonTicket').hide();
                    $(".contPresus").html(html);
                    $(".contConvertirAcredito").html('<a href="#" class="ui-shadow ui-icon-clock ui-btn-icon-left ui-btn ui-corner-all" id="convertirPresupuestoPOS" onclick="convertirPresupuesto()" title="'+convertirAcreditoTxT+'">'+convertirAcreditoTxT+'</a');
                    vengo_de = "presupuesto";
                }else{
                    $('.contButtonTicket').show();
                    $("#"+$.mobile.activePage.attr('id')+" .notaPedido").val(data.order.note);
                    vengo_de = "";
                }
                if(!$.isEmptyObject(data.order.factura)){
                    $("#"+$.mobile.activePage.attr('id')+" .verFacturaPedido").show();
                    $("#"+$.mobile.activePage.attr('id')+" .verFacturaPedido").attr("href", $("#urlBackoffice").val()+"/index.php?controller=AdminPDF&submitAction=generateInvoicePDF&id_order="+data.order.id_order+"&token="+$('#tokenLitePDF').val());
                    $("#"+$.mobile.activePage.attr('id')+" .verFacturaPedido span").html(data.order.factura.number);
                    $('.okGenFactura').hide();
                }else{
                    $("#"+$.mobile.activePage.attr('id')+" .verFacturaPedido").hide();
                    $('.okGenFactura').show();
                }
                if(!$.isEmptyObject(data.order.albaran)){
                    $("#"+$.mobile.activePage.attr('id')+" .verAlbaranPedido").show();
                    $("#"+$.mobile.activePage.attr('id')+" .verAlbaranPedido").attr("href", $("#urlBackoffice").val()+"/index.php?controller=AdminPDF&submitAction=generateDeliverySlipPDF&id_order="+data.order.id_order+"&token="+$('#tokenLitePDF').val());
                    $("#"+$.mobile.activePage.attr('id')+" .verAlbaranPedido span").html(data.order.albaran.number);
                }else{
                    $("#"+$.mobile.activePage.attr('id')+" .verAlbaranPedido").hide();
                }

                id_cart_pedido = data.order.id_cart;
                selectHtml = "";
                $.each(statuses, function(index, state) {
                    selectHtml += '<option style="background:'+state['color']+';color:'+state['font']+'" value="'+state['id']+'"'+(data.order.osname == state['id'] ? ' selected' : '')+'>'+state['name']+'</option>';
                });

                $("#"+$.mobile.activePage.attr('id')+' .vouchersCont').html("");
                $("#"+$.mobile.activePage.attr('id')+' .contEstadosPedido').html("");
                $.each(data.order.estadosPedido, function(index, estado) {
                    $("#"+$.mobile.activePage.attr('id')+" .contEstadosPedido").append("<div><span style=\"background:"+estado.color+";color:"+getContrastYIQ(estado.color)+"\">"+estado.ostate_name+"</span> <span class=\"aligncenter\">"+estado.employee_firstname+" "+estado.employee_lastname+"</span><span class=\"alignright\">"+estado.date_add+"</span></div>");
                });
                $.each(data.order.vouchers, function(index, voucher) {
                    if(voucher['reduction_percent'] != 0)
                        var descValue = voucher['reduction_percent']+'%';
                    if(voucher['reduction_amount'] != 0)
                        var descValue = '- '+voucher['reduction_amount'];
                    $("#"+$.mobile.activePage.attr('id')+' .vouchersCont').append('<a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-icon-right ui-icon-delete" onclick="deleteVoucherOrder('+id_order_global+','+voucher['id_order_cart_rule']+')">'+voucher['name']+'</a>');
                });
                $('#pedidoPage .cambioEstadoCont').html('<select class="status_order_credit" onchange="cambiarEstado('+data.order.id_order+',this.value)">'+selectHtml+'</select>');
                $('#pedidoPage .cambioEstadoCont select').selectmenu();
                $('#pedidoPage .cambioEstadoCont select').selectmenu('refresh');

                //var backgroundElementoSeleccionado =$('#pedidoPage .cambioEstadoCont select :selected').css('background');
//                var colorElementoSeleccionado = $('#pedidoPage .cambioEstadoCont select :selected').css('color');
//                $('#pedidoPage .cambioEstadoCont select').css('background',backgroundElementoSeleccionado);
//                $('#pedidoPage .cambioEstadoCont select').css('color',colorElementoSeleccionado);
                $('#pedidoPage .clienteCont .ui-icon-user').attr("data-customer",data.cliente.id);
                $('#pedidoPage .clienteCont .nombreCliente').html(data.cliente.nombre+"("+data.cliente.email+")");
                $('#pedidoPage .clienteCont .emailCliente').html();
                email_global = data.cliente.email;
                if(data.order.numeroTicket == '--'){
                    $("#pedidoPage .contButtonTicket").html('<button id="botonGenerarTicket" class="btn btn-default button" onclick="generarTicket()"><i class="icon-file"></i>&nbsp;'+generarTicketTxT+'</button>');
                }else{
                    $("#pedidoPage .contButtonTicket").html('<a class="getticket ui-btn ui-corner-all ui-shadow ui-btn-inline" onclick="reTicket(\'actual\','+data.order.id_order+')">'+ticketNormal+'</a>');
                  //   $("#pedidoPage .contButtonTicket").html('<button class="btn btn-default button" onclick="reTicket()"><i class="icon-file"></i>&nbsp;'+verTicketTxt+'</button>';
                }

                $('#pedidoPage .clienteCont .direccionEnvio').html(data.envio.address);
                $('#pedidoPage .clienteCont .direccionFacturacion').html(data.facturacion.address);
            }
            listadoProductosPedido(data.products);
            $("#contPedidos").show();
            htmlPagos +="<tr id='addPayment_"+id_order+"' class='addPayment'"+(pagadoTodoYFaltaPorCambiar ? "style=\"display:none\"" : '')+">" +
                    "<td></td>" +
                    "<td>"+metodosPagoHtml+"</td>" +
                    "<td><input type='text' size='5' pattern='(^\d*\.?\d*[0-9]+\d*$)|(^[0-9]+\d*\.\d*$)' class='amount ui-btn corner-all ui-shadow'></td>" +
                    "<td><a class='ui-input-btn ui-btn' onclick='anadirPaymentPopup("+id_order+")'>"+anadirPago+"</a></td>" +
                    "<td></td></tr>";
            htmlPagos += "</tbody></table>";
            $("#pedidoPage .contentpayments").html(htmlPagos);
        }else{
            $("#pedidosVacios").show();
        }
    });
}

function anadirPaymentPopup(id_order){
    var formaPago = $("#"+$.mobile.activePage.attr('id')+' #addPayment_'+id_order+' select').val();
    var amount = $("#"+$.mobile.activePage.attr('id')+' #addPayment_'+id_order+' .amount').val().replace(",",".");
    if(formaPago == estadoEfectivo){
        $("#"+$.mobile.activePage.attr('id')+' .popupPagoPayment #pagadoPagoAcreditoButton').html(formatCurrency(0, currencyFormat, currencySign, currencyBlank));
        $("#"+$.mobile.activePage.attr('id')+' .popupPagoPayment .aDevolverButton').html(formatCurrency(0, currencyFormat, currencySign, currencyBlank));
        $("#"+$.mobile.activePage.attr('id')+' .popupPagoPayment input[name=primerPago]').val(formatCurrency(0, currencyFormat, currencySign, currencyBlank));
        $("#"+$.mobile.activePage.attr('id')+' .popupPagoPayment input[name=id_order]').val(id_order);
        $("#"+$.mobile.activePage.attr('id')+' .popupPagoPayment input[name=formaPago]').val(formaPago);
        $("#"+$.mobile.activePage.attr('id')+' .popupPagoPayment input[name=amount]').val(amount);
        $("#"+$.mobile.activePage.attr('id')+' .popupPagoPayment input[name=total]').val(amount);
        $("#"+$.mobile.activePage.attr('id')+' .popupPagoPayment .pagado').html(parseFloat(0).toFixed(priceDisplayPrecision));
        $("#"+$.mobile.activePage.attr('id')+' .popupPagoPayment .restante').html(amount);
        $("#"+$.mobile.activePage.attr('id')+' .popupPagoPayment').popup("open");
        $(".sobraCont").hide();
        $(".restanteCont").show();
        $(".restanteCont").removeClass('justo');
        modo=".popupPagoPayment";
        $("#"+$.mobile.activePage.attr('id')+' .popupPagoPayment').bind({
           popupafterclose: function(event){
               modo=0;
            }
        });
    }else if(formaPago == estadoTarjeta){
        if(datos_tarjeta){
            $("#"+$.mobile.activePage.attr('id')+' .advertencia .titularTarjeta').val('');
            $("#"+$.mobile.activePage.attr('id')+' .advertencia .numeroTarjeta').val('');
            $("#"+$.mobile.activePage.attr('id')+' .tCredito').slideDown('fast');
        }
        anadirPayment(id_order,formaPago,amount,amount);
    }else{
        anadirPayment(id_order,formaPago,amount,amount);
    }
}
function listadoProductosPedido(products){
    $("#"+$.mobile.activePage.attr('id')+" .productosPedido tbody").html("");
    if(products != null){
        $.each(products, function(index, result) {
            var lineaProd = '<tr class="opd_'+result.id_order_detail+'">"'+
                                "<td>"+result.img+"</td>"+
                                "<td class='nameOpd'>"+result.name+"</td>"+
                                "<td class='priceOpd'><span class='contPriceOrd'>"+parseFloat(result.product_price_sin_reducciones_wt).toFixed(priceDisplayPrecision)+'</span></td>'+
                                "<td class='descCont'><span class='contDescOrd'>"+result.desc+"</span><span class='contDescType'>"+result.descType+"</span></td>"+
                                "<td class='cantOpd'>"+result.q+
                                (result.precio_unitario != "" ? " x <input type='hidden' class='ratio' value='"+result.unit_price_ratio+"'/><span class='unityAmount'>"+result.precio_unitario+"</span> <span class='unity'>"+result.unity+"</span>" : "<span class='unityAmount'></span> <span class='unity'></span>")+"</td>"+
                                "<td class='totalOpd text-right'>"+result.total_price_tax_incl+"</td>"+
                                "<td class='actionsOpd'>";
            if(cambio_precio == 1 && permiso_edicion_pedidos){
                lineaProd += '<a class="editOPD" href="#" onclick="modProductoOrder('+id_order_global+','+result.id_order_detail+')"><i class=\"icon-edit\"></i></a>'+
                              '<a class="deleteOPD" href="#" onclick="if(confirm(\'delete?\')){deleteProductOrder('+id_order_global+','+result.id_order_detail+',\'pedidos\')}else{event.stopPropagation(); event.defaultPrevented;}"><i class=\"icon-trash\"></i></a>'+
                               '<a class="guardarOPD ui-input-btn ui-btn" onclick="cambioEnPedido('+id_order_global+','+result.id_order_detail+')">'+guardarTxt+'</a>';
            }
            lineaProd += "</td></tr>";
            if(result.booking != null){
                $.each(result.booking, function(index, result) {
                    lineaProd += '<tr class="opd_booking_'+result.id_order_detail+'">"'+
                                "<td></td>"+
                                "<td class='nameOpd'>"+result.name+"</td>"+
                                "<td class='priceOpd'></td>"+
                                "<td class='descCont'></td>"+
                                "<td class='cantOpd'>"+result.qty+"</td>"+
                                "<td class='totalOpd text-right'>"+result.price+"</td>"+
                                '<td class="actionsOpdB"><a class="deleteOPD" href="#" onclick="if(confirm(\'delete?\')){deleteProductOrderBooking('+id_order_global+','+result.id_order_detail+','+result.id+',\'pedidos\')}else{event.stopPropagation(); event.defaultPrevented;}"><i class="icon-trash"></i></a></td></tr>';
                });
            }
            $("#"+$.mobile.activePage.attr('id')+" .productosPedido tbody").append(lineaProd);
        });
    }
}
function devRapida2(id_product, id_product_attribute) {
    $.getJSON(token_actions,{action:'anadirDevolucionRapida',ajax:"1",id_product:id_product,id_product_attribute:id_product_attribute, tax: tax, id_customer :id_customer,
        q:'-1',id_lang:id_lang,id_employee:id_employee,id_cart:id_cart,id_currency: $('#currencyPOS').val(),id_shop: id_shop},function(data) {
        if(data != null) {
           $.each(data, function(index, result) {
                if(result.error != null){
                    mostrarError(result.error);
                }
                if(result.resultado == 'ok'){
                    seHizoDevolucion = true;
                    $("#"+$.mobile.activePage.attr('id')+" .advertencia .notificationBad").slideUp('fast');
                    if(bloquear_ventana_no_encontrado == 1)
                        $("#"+$.mobile.activePage.attr('id')+" .maskTPVTiendaObligatoria").hide();
                    updateCompra();
                }
            });
        }
    });
}
function devRapida(){
    var product = modo.split("_");
    var quantity = $(String(modo).replace("popup", "")+' span').html();
    var id_warehouse = $("select.almacenProd").val();
    //hago esto para que no sale el evento de cambiar la cantidad
    $.getJSON(token_actions,{action:'anadirDevolucionRapida',ajax:"1",id_product:product[1], id_product_attribute:product[2],id_warehouse:id_warehouse,tax:tax,id_customer :id_customer,
        q:quantity,id_lang:id_lang,id_employee:id_employee,id_cart:id_cart,id_currency: $('#currencyPOS').val(),id_shop: id_shop},function(data) {
          if(data != null) {
           $.each(data, function(index, result) {
                if(result.error != null){
                    mostrarError(result.error);
                }
                if(result.resultado == 'ok'){
                    seHizoDevolucion = true;
                    $(".popupcantidad,.popupqtyCustomizacion").popup( "close");
                    updateCompra();
                }
            });
        }
    });
}
function abrirPopupHistorial(){
    $("#"+$.mobile.activePage.attr('id')+" .popupHistorial").popup("open");
}
function abrirDescuentos(){
    $("#"+$.mobile.activePage.attr('id')+" .anadirDescuentos").addClass('open');
    anadirMascara();
    getDiscounts();
    getLoyalty();
    modo = 2;
}
function setFormaPago(formaPago){
    $(".formaPago").removeClass("elegida");
    $("#formapago_"+formaPago).addClass("elegida");
    $("#formaPago").val(formaPago);
    if(albaran == 1 && estadoAlbaran == formaPago){
       tax = 0;
       $(".taxTpv").slideUp();
    }else {
       tax = tax_antes;
       if(tax == 1){
            $(".taxTpv").slideDown();
       }
    }
    updateCompra();
}
function abrirPopupEnviarPorMail(){
    $('#popupEnviarPresu').popup('open');
    $('#popupEnviarPresu .emailSend').val(email_global);
}
function enviarPorMail(){
    if($("#currencyPOS").val() != undefined)
        var currPOS = $("#currencyPOS").val();
    else
        var currPOS = id_currency;
    $.getJSON(token_actions,{action:'sendEmail', ajax : "1",id_order:id_order_global,id_shop:id_shop,emailSend:$('#popupEnviarPresu .emailSend').val(),nota:$("#messagePresu").val(),
        id_employee: id_employee,id_lang:id_lang, id_currency: currPOS,enviarEnlacePago:$('#enlacePago').prop('checked')},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(result.ok != null){
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html(result.ok);
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').slideDown('fast');
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(6000).slideUp('fast');
                }
                if(result.error != null){
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').html(result.error);
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').slideDown('fast');
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationBad').delay(6000).slideUp('fast');
                }
            });
        }
    });
}
function guardarCampoPersonalizado(campo){
    var id = $(campo).attr("id");
    var aux = id.replace("cust_", "");
    var value = $("#"+id).val();
    var customization = aux.split("_");
    var quantity = $('.linea_'+customization[2]+'_'+customization[3]+' .qtyCustomizacion .amount').html();
    $.getJSON("../modules/tpvtienda/classes/actions/actionsCustomization.php",{token:token, action:'guardarCustomization',
       id_customization:customization[0], index:1,id_currency: $('#currencyPOS').val(), id_shop: id_shop, value: value,id_product:customization[2],
       id_product_attribute:customization[3],quantity:quantity, id_cart: id_cart},function(data) {
       if(data != null) {
            $.each(data, function(index, result) {
                if(result.error != null){
                    mostrarError(result.error);
                }
                if(result.resultado == 'ok'){
                    efectoGuardado('#'+id);
                }
                if(result.idCustomization != null){
                    if(typeof aux != "input"){
                        //IMAGEN
                        $(".linea_"+customization[2]+"_"+customization[3]+" #customizacion_").attr("id","customizacion_"+result.idCustomization);
                        $(".linea_"+customization[2]+"_"+customization[3]+" #customizacion_"+result.idCustomization+" form").attr("id","cust_"+result.idCustomization+'_0_'+customization[2]+'_'+customization[3]);
                        $(".linea_"+customization[2]+"_"+customization[3]+" #customizacion_"+result.idCustomization+" form input[name=id_customization]").val(result.idCustomization);
                        $(".linea_"+customization[2]+"_"+customization[3]+" #customizacion_"+result.idCustomization+" .qtyCustomizacion").attr("id","cantidadProductoCustomizacion_"+customization[2]+'_'+customization[3]+"_1_"+result.idCustomization);
                        $(".linea_"+customization[2]+"_"+customization[3]+" #customizacion_"+result.idCustomization+" .accion").attr("id","deletecust_"+result.idCustomization+'_1_'+customization[2]+'_'+customization[3]);
                    }else{
                        //TEXTO
                        $(".linea_"+customization[2]+"_"+customization[3]+" #customizacion_").attr("id","customizacion_"+result.idCustomization);
                        $(".linea_"+customization[2]+"_"+customization[3]+" #customizacion_"+result.idCustomization+" input").attr("id","cust_"+result.idCustomization+'_1_'+customization[2]+'_'+customization[3]);
                        $(".linea_"+customization[2]+"_"+customization[3]+" #customizacion_"+result.idCustomization+" .qtyCustomizacion").attr("id","cantidadProductoCustomizacion_"+customization[2]+'_'+customization[3]+"_1_"+result.idCustomization);
                        $(".linea_"+customization[2]+"_"+customization[3]+" #customizacion_"+result.idCustomization+" .accion").attr("id","deletecust_"+result.idCustomization+'_1_'+customization[2]+'_'+customization[3]);
                        if(!$(".linea_"+customization[2]+"_"+customization[3]+" #customizacion_"+result.idCustomization+" .qtyCustomizacion").hasClass("ponerBotonera"))
                            $(".linea_"+customization[2]+"_"+customization[3]+" #customizacion_"+result.idCustomization+" .qtyCustomizacion").addClass("ponerBotonera")
                    }
                }
            });
       }
    });
}
function accederEmpleado(id){
    var emp = id.replace("empleado_", "");
    var arrayEmp = emp.split("_");
    $('#TPVTienda .employee_seleccionable').removeClass("empActual");
    $('#TPVTienda #'+id).addClass("empActual");
    if(arrayEmp[0] != id_employee){
        id_employee = arrayEmp[0];
        id_customer_defecto = arrayEmp[1];
        id_customer = arrayEmp[1];
        $("#id_address_delivery_original").val(arrayEmp[2]);
        $("#id_address_invoice_original").val(arrayEmp[2]);
        renovarCarrito();
    }
    modo = 0;
    updateCompra();
    if(flagCambioEmpleadoAlFinalizarPedido){  //si vengo de cambiar de empleado, elijo la misma caja que tenía
        usarCaja(cajaEnUso);
    }else{
        if(caja_obligatoria == 1){
            getCajas(1,1);
        }else{
            $.mobile.changePage("#TPVTienda");
        }
    }
}
$(document).on( "click", ".ponerBotonera", function( evt ) {
    valorActual = "";
    var id = $(this).attr("id");
    if(id == undefined){
        id = $(this).attr('class').split(' ')[0];
        ejeY = $("."+id).offset().top + $("."+id).outerHeight();
    }else{
        ejeY = $("#"+id).offset().top + $("#"+id).outerHeight();
    }
    modo="#popup"+id ;
    if($("#"+id).hasClass("cambioprecio")){
        if(pass_cambio_precio_enabled == 1 && vengo_de != "validar"){
            $("#pass").addClass('open');
            anadirMascara();
            modo="validacion_"+modo;
            vengo_de = "cambio_precio";
            $(".pass_dev input[name=pass_dev]").val('');
            $(".pass_dev input[name=pass_dev]").focus();
        }else{
            vengo_de = "cambio_precio";
            $("#impuestosCambioPrecioConImp").attr("checked",true).checkboxradio("refresh");
            $("#impuestosCambioPrecioSinImp").attr("checked",false).checkboxradio("refresh");
            $("#popupcambioprecio").popup("open", {x: $(this).offset().left,y: ejeY-20, changeHash : false});
            $("#popupcambioprecio").bind({
                popupafterclose: function(event){
                    if(event.handled !== true){
                        var aux = modo.replace("#popupcambioprecio_", "");

                        var product = aux.split("_");
                        modo=0;
                        if($("#impuestosCambioPrecioConImp").prop('checked')){
                            var impuCambioPrecio = 1;
                        }else{
                            var impuCambioPrecio = 0;
                        }
                        if(existsHookJS('cambioPrecio')){
                            var nuevoPrecio = $('[id^=cambioprecio_'+product[0]+'_'+product[1]+'] .amount').html();
                            hookJS('cambioPrecio',{'id_product':product[0],'id_product_attribute': product[1],'impuCambioPrecio' : impuCambioPrecio,'nuevoPrecio':nuevoPrecio}) ;
                        }else{
                            cambioPrecio(product[0],product[1],impuCambioPrecio);
                        }
        //                    $('[id^=popupcambioprecio]').remove();
                        event.handled = true;
                        event.defaultPrevented;
                    }
                }
            });
        }
    }
    if($("#"+id).hasClass("openCarriers")){
        $("#popupcarriers").popup("open", {x: $(this).offset().left + ($(this).outerWidth()/2),y: $("#"+id).offset().top, changeHash : false});
        $("#popupcarriers").bind({
            popupafterclose: function(event){
                if(event.handled !== true){
                    modo=0;
                }
                updateCompra();
            }
        });
    }
    if($("#"+id).hasClass("cambiopreciodev")){
        $("#popupcambiopreciodev").popup("open", {x: $(this).offset().left + ($(this).outerWidth()/2),y: ejeY, changeHash : false});
        $("#popupcambiopreciodev").bind({
            popupafterclose: function(event){
                if(event.handled !== true){
                   var aux = modo.replace("#popupcambiopreciodev_", "");
                    modo=0;
                    var product = aux.split("_");
                    cambioPrecioDev(product[0],product[1]);
                    event.handled = true;
                    event.defaultPrevented;
                }
            }
        });
    }
    if($("#"+id).hasClass("qty")){
        $("#popupcantidad").popup("open", {x: $(this).offset().left + ($(this).outerWidth()/2),y: ejeY, changeHash : false});
        $("#popupcantidad").bind({
            popupafterclose: function(event){
                if(event.handled !== true && seHizoDevolucion == false && modo != 0){
                    var idCapaOrigen = modo.replace("#cantidadProducto_", "");
                    if(existsHookJS('changeQty')){
                        hookJS('changeQty',{'idCapaOrigen':idCapaOrigen}) ;
                    }else{
                        changeQty(idCapaOrigen);
                    }
                    event.handled = true;
                    event.defaultPrevented;
                }else{
                    seHizoDevolucion = false;
                }
                modo=0;
            }
        });
    }
    if($("#"+id).hasClass("depends_on_stock")){
        var aux = modo.replace("#popupcantidadProducto_", "");
        var product = aux.split("_");
        $('.almacenProd').attr("id", 'prodWare_'+product[1]+'_'+product[2]);
        $('.almacenProd').parent().parent().show();
        $('select.almacenProd').prop('selectedIndex',$('.almacenProd option[value="'+product[3]+'"]').index()).selectmenu('refresh');
    }
    if($("#"+id).hasClass("qtyCustomizacion")){
        $("#popupqtyCustomizacion").popup("open", {x: $(this).offset().left + ($(this).outerWidth()/2),y: ejeY, changeHash : false});
        $("#popupqtyCustomizacion").bind({
            popupafterclose: function(event){
                if(event.handled !== true){
                    changeQtyCustomizacion(modo);
                    modo=0;
                    event.handled = true;
                    event.defaultPrevented;
                }
            }
        });
    }
    if($("#"+id).hasClass("qtyTimeSlot")){
        $("#popupqtyTimeSlot").popup("open", {x: $(this).offset().left + ($(this).outerWidth()/2),y: ejeY, changeHash : false});
        $("#popupqtyTimeSlot").bind({
            popupafterclose: function(event){
                if(event.handled !== true){
                    changeQtyTimeSlot(modo);
                    modo=0;
                    event.handled = true;
                    event.defaultPrevented;
                }
            }
        });
    }
    if($("#"+id).hasClass("descuento")){
        $("#popupdescuento").popup("open", {x: $(this).offset().left,y: ejeY-20, changeHash : false});
        $("#popupdescuento").bind({
            popupafterclose: function(event){
                if(event.handled !== true){
                    var aux = modo.replace("#popupdescamount_", "");
                    var product = aux.split("_");
                    var tipo = $(modo.replace("popup", "") + ' .subField').html();
                       modo=0;
                    if(tipo == '%')
                        tipo = 'percentage';
                    else
                        tipo = 'amount';
                    discount(product[0],product[1],tipo);
                    event.handled = true;
                    event.defaultPrevented;
                }
            }
        });
    }
    if($("#"+id).hasClass("cambiopeso")){
        $("#popupcambiopeso").popup("open", {x: $(this).offset().left + ($(this).outerWidth()/2),y: ejeY, changeHash : false});
        $('#popupcambiopeso input[name=calcularPrecio]').prop('checked', true).checkboxradio('refresh');
        $("#popupcambiopeso").bind({
            popupafterclose: function(event){
                if(event.handled !== true){
                    var aux = modo.replace("#popupcambiopeso_", "");
                    var product = aux.split("_");
                    var nuevoPeso = $('[id^=cambiopeso_'+product[0]+'_'+product[1]+'] .amount').html();
                   var calcularPrecio = $('#popupcambiopeso input[name=calcularPrecio]').is(':checked');
                    modo=0;
                    cambioPrecioPeso(product[0],product[1],nuevoPeso,(calcularPrecio ? 1 : 0));
                    event.handled = true;
                    event.defaultPrevented;
                }
            }
        });
    }
    if($(this).hasClass('cambioNombre')){
        $("#popupcambioNombre").popup("open", {x: $(this).offset().left + ($(this).outerWidth()/2),y: ejeY, changeHash : false});
        $("#nombre_cambioNombre").val($(this).children().html());
        $("#popupcambioNombre").bind({
            popupafterclose: function(event){
                if(event.handled !== true){
                    var aux =  modo.replace("#popupcambioNombre_", "");
                    var product = aux.split("_");
                    var viejoNombre = $('#orig_'+id).val();
                    var nuevoNombre = $('#nombre_cambioNombre').val();
                    modo=0;
                    cambiarNombre(product[0],nuevoNombre, viejoNombre);
                    $('#nombre_'+id).focus();
                    $('#nombre_'+id).val($('#'+id+' .nombreSinAttr').html()); // truco para hacer el focus al final del texto
                    event.handled = true;
                    event.defaultPrevented;
                }
            }
        });
    }
    if($(this).hasClass('tecnumerico')){
        $("#popuporder_query").popup("open", {x: $(this).offset().left + ($(this).outerWidth()/2),y: ejeY, changeHash : false});
        $("#popuporder_query").bind({
            popupafterclose: function(event){
                if(event.handled !== true){
                    var aux =  modo.replace("#popuporder_query", "");
                    modo=0;
                    search(1);
                    event.handled = true;
                    event.defaultPrevented;
                }
            }
        });
    }
    if($(this).hasClass('retencionRenta')){
        $("#popupretencionRentaButton").popup("open", {x: $(this).offset().left + ($(this).outerWidth()/2),y: ejeY, changeHash : false});
        $("#popupretencionRentaButton").bind({
            popupafterclose: function(event){
                if(event.handled !== true){
                    modo=0;
                    calculoDeRetencionRenta($("#retencionRentaButton .amount").html());
                }
            }
        });
    }
    if($(this).hasClass('retencionIva')){
          $("#popupretencionIVAButton").popup("open", {x: $(this).offset().left + ($(this).outerWidth()/2),y: ejeY, changeHash : false});
           $("#popupretencionIVAButton").bind({
               popupafterclose: function(event){
                   if(event.handled !== true){
                       modo=0;
                       calculoDeRetencionIVA($("#retencionIVAButton .amount").html());
                   }
               }
           });
    }
    evt.defaultPrevented;
});
function borrarCategoriaElegida(idCat){
    if(idCat != ""){
        borrarCategoria(idCat);
        $('#'+$.mobile.activePage.attr('id')+' #cat_'+idCat).remove();
    }
}
function avisadorPedidosJS(){
    if(avisadorPedidos == 1){

        var limit = 5;

        setInterval( function () {
            //pedidosTable.ajax.reload( null, false ); // user paging is not reset on reload
            /*pedidosTable.ajax.reload( function ( json ) {
                var ultimoPedido = json.data[0][0];
                if(ultimoPedido > ultimoPedidoGuardado){
                	doPlay();
                	ultimoPedidoGuardado = ultimoPedido;
                }
            } );*/


                $.getJSON("../modules/tpvtienda/classes/actions/actionsOrdersAlert.php",{action:'getOrdersAlert', id_lang: id_lang, id_shop: id_shop,id_currency: $('#currencyPOS').val(),token:token,limit:limit},function(data) {
                    if(!$.isEmptyObject(data)){
                        if(primeraVez == 0 ){
                            arrayPedidos = [];
                            $(".listadoPedidos").html("");
                        }
                        $.each(data, function(index, order) {
                            if(primeraVez == 0 ){
                                if($('table#contPedidos tr > td:contains('+order.id_order+')').length == 0){
                                    $(".listadoPedidos").append('<div class="pedidoLinea" onclick="$.mobile.changePage(\'#pedidoPage\');getOrder('+order.id_order+')"><span class="refPedido">#'+order.id_order+'</span> <span class="clientePedido">'+order.customer+'</span> <span class="estadoPedido" style="background:'+order.color+'">'+order.osname+'</span><span class="totalPedidoLinea">'+ps_round(order.total_paid, 2)+'</span></div>');
                                    arrayPedidos.push(order.id_order);
                                }
                            }else if($.inArray(order.id_order,arrayPedidos) == -1){
                                // añado
                                arrayPedidos.unshift(order.id_order);
                                if(avisadorPedidosImprimir == 1 && semaforoAvisadorPedidos != order.id_order){
                                    imprimirPrimeraVez = 1;
                                    reTicket('actual',order.id_order);
                                    $("#avisadorPedidosButton").removeAttr('style');
                                }
                                if($('table#contPedidos tr > td:contains('+order.id_order+')').length == 0){
                                    $(".listadoPedidos").prepend('<div class="pedidoLinea" onclick="$.mobile.changePage(\'#pedidoPage\');getOrder('+order.id_order+')"><span class="refPedido">#'+order.id_order+'</span> <span class="clientePedido">'+order.customer+'</span> <span class="estadoPedido" style="background:'+order.color+'">'+order.osname+'</span><span class="totalPedidoLinea">'+ps_round(order.total_paid, 2)+'</span></div>');
                                    $(".listadoPedidos > div:last-child").remove();
                                    if(semaforoAvisadorPedidos != order.id_order){
                                        $("#avisadorPedidosButton").animate({backgroundColor: "#f1b746"}, 200 );
                                        $("#avisadorPedidosButton").animate({backgroundColor: "#000"}, 200 );
                                        $("#avisadorPedidosButton").animate({backgroundColor: "#f1b746"}, 200 );
                                        $("#avisadorPedidosButton").animate({backgroundColor: "#000"}, 200 );
                                        $("#avisadorPedidosButton").animate({backgroundColor: "#f1b746"}, 200 );
                                        $("#popupNuevoPedido").popup("open", {x: $("#avisadorPedidosButton").offset().left + ($("#avisadorPedidosButton").outerWidth()/2),
                                            y: $("#avisadorPedidosButton").offset().top + $("#avisadorPedidosButton").outerHeight(), changeHash : false});
                                        setTimeout(function(){$("#popupNuevoPedido").popup("close")}, 5000);
                                        doPlay();
                                    }else{
                                        semaforoAvisadorPedidos = 0;
                                    }
                                }
                            }
                        });
                        primeraVez = 1;
                    }
                });

        }, 5000 );
        $(document).on( "click", "#avisadorPedidosButton", function( evt ) {
            var ejeY = $("#avisadorPedidosButton").offset().top + $("#avisadorPedidosButton").outerHeight();
            modo="#popupavisadorPedidosButton" ;
            $("#popupAvisadorPedidos").popup("open", {x: $(this).offset().left + ($(this).outerWidth()/2), y: ejeY, changeHash : false});
            $("#popupAvisadorPedidos").bind({
                popupafterclose: function(event){
                    if(event.handled !== true){
                        modo=0;
                        $("#avisadorPedidosButton").removeAttr('style');
                    }
                }
            });
        });
    }
}
function borrarCategoria(categoria,idCat){
    $(categoria).remove();
    var listaActual = $('#'+$.mobile.activePage.attr('id')+' input[name=categoriasNuevoProducto]').val();
    listaActual = listaActual.replace(idCat+",", "");
    $('#'+$.mobile.activePage.attr('id')+' input[name=categoriasNuevoProducto]').val(listaActual);
}
function abrirPopupBusquedaProducto(){
    $('.popupBuscarPorProducto').popup();
    $('.popupBuscarPorProducto').popup('open');
}
function abrirPopupCambioEstadosMasivo(){
    $('.popupCambioEstadoMasivo').popup();
    $('.popupCambioEstadoMasivo').popup('open');
}
function recalcularListaCategorias(){
    var valor = $('#'+$.mobile.activePage.attr('id')+' select[name=selectCategoriasNuevoProducto]').val();
    if(valor != 0){
        $('#'+$.mobile.activePage.attr('id')+' input[name=categoriasNuevoProducto]').val($('#'+$.mobile.activePage.attr('id')+" input[name=categoriasNuevoProducto]").val()+valor+",");
    }
}
$(window).on("resize",function() {
    resizeContCompra();
});
//quito clic secundario
$(document).on("contextmenu",function(e){
    return false;
});
$(document).ready(function() {
//     $('a[data-change-hash="false"]').on('click',function(e) {
//            $.mobile.changePage($(this).attr('href'),{'changeHash':false});
//            e.preventDefault();
//        });
    $("a").not('.ui-mobile-viewport a').each(function(){
        $(this).attr("rel","external");
    });
    var anchura = $(window).width();
    if((anchura < 945 && plantilla_pos == "fiftyfifty") || plantilla_pos == "full-width"){
        var  orientacionSwiper = 'horizontal';
        var cssWidthAndHeight = false;
    }else{
        var orientacionSwiper = 'vertical';
        var cssWidthAndHeight = true;
    }
    mySwiper = createSwiper('#list-products-tpvtienda',cssWidthAndHeight,orientacionSwiper);
    mySwiper.on('touchEnd', function(event) {
        //compruebo si el threshold es mayor de 10, lo hago asi porque no funciona el parametro moveStartThreshold

        if(Math.abs(mySwiper.touches.startX - mySwiper.touches.currentX) > 200){
            cargaMasProductos();
            event.preventDefault;
        }
    });

    mySwiper.on('tap', function(slide,event) {
        if(event.target.className.indexOf("fullscreenProduct") == -1){
            if(event.target.offsetParent.className.toString().indexOf("producto") > 0){
                var id = event.target.offsetParent.id.replace("item_","");
                var prodSplit = id.split("_");
                var name = $("#"+event.target.offsetParent.id).children(".name").html();
                if(typeof prodSplit[1] == "undefined")
                    prodSplit[1] = 0;
                if(prodSplit[0] != ""){
                    if(existsHookJS('addCart')){
                        hookJS('addCart',{'id_product':prodSplit[0],'id_product_attribute': prodSplit[1],'cantidad' : 1,'name':name}) ;
                    }else{
                        if(prodSplit[2] > 1)
                            addCart(prodSplit[0],0,1,name,true);
                        else
                            addCart(prodSplit[0],prodSplit[1],1,name,true);
                    }
                }
                done = false;
            }
            //caso en que no hay foto y clica sobre el fondo
            if(event.target.offsetParent.className.toString().indexOf("swiper-wrapper") > -1){
                var name = $("#"+event.target.id).children(".name").html();
                var id = event.target.id.replace("item_","");
                var prodSplit = id.split("_");
                if(prodSplit[1] == "undefined")
                    prodSplit[1] = 0;
                if(prodSplit[0] != ""){
                    if(existsHookJS('addCart')){
                        hookJS('addCart',{'id_product':prodSplit[0],'id_product_attribute': prodSplit[1],'cantidad' : 1,'name':name}) ;
                    }else{
                        if(prodSplit[2] > 1)
                            addCart(prodSplit[0],0,1,name,true);
                        else
                            addCart(prodSplit[0],prodSplit[1],1,name,true);
                    }
                }
                done = false;
            }

        }
    });
     // init Swiper
    var timerScroll;
    $('#cabecera').on( "scroll",function () {
        clearTimeout(timerScroll);
        timerScroll = setTimeout(function() {
            var scroll = $('#cabecera').scrollTop();
            var cabeceraHeight = $('#cabecera').height();
            var scrollHeight = $('#cabecera').prop("scrollHeight");
            if ( scrollHeight - (cabeceraHeight + scroll) < 100) {
                cargaMasProductos();
            }
        }, 250);
    });
    mySwiperProductosPedidosPage = createSwiper('#list-products-pedidoPage',true,'vertical');
    mySwiperProductosPedidosPage.on('tap', function(slide,event) {
        if(event.target.className.indexOf("fullscreenProduct") == -1){
            if(event.target.offsetParent.className.indexOf("producto") != -1){
                var id = event.target.offsetParent.id.replace("item_","");
             	var prodSplit = id.split("_");
                var name = $("#"+event.target.offsetParent.id).children(".name").html();
                addProductOnOrder(prodSplit[0],prodSplit[1],1,name,true);
                done = false;
            }
            //caso en que no hay foto y clica sobre el fondo
            if(event.target.offsetParent.className.indexOf("swiper-wrapper") != -1){
                var id = event.target.id.replace("item_","");
             	var prodSplit = id.split("_");
                var name = $("#"+id).children(".name").html();
                addProductOnOrder(prodSplit[0],prodSplit[1],1,name,true);
                done = false;
            }
        }
    });
    $("#header_search").attr("data-ajax",false);
    $('#footer').hide();
    $("#checkoutButton").tooltip();
    $.ajaxSetup({ cache: false });
    $("#TPVTienda #tabsDevs").tabs();
    $("#aparcados #tabsCarts").tabs();
    $("#TPVTienda .tabsAnadirProducto").tabs();
    $("#aCreditoPage .tabsAnadirProducto").tabs();
    $("#pedidoPage .tabsAnadirProducto").tabs();
    $( document ).on( "pageinit", "#pedidoPage", function( event ) {
        $("#pedidoPage .panel_lateral input[type=text]").phAnim();
    });
    $( document ).on( "pageinit", "#aCreditoPage", function( event ) {
        $("#aCreditoPage .panel_lateral input[type=text]").phAnim();
    });
    if(existsHookJS('paymentRequired')){
        hookJS('paymentRequired') ;
    }else{
        var idFormaPagoElegida = $(".formaPago.elegida").attr("id");
        if(!$.isEmptyObject(idFormaPagoElegida))
            $("#formaPago").val(idFormaPagoElegida.replace("formapago_",""));
    }


    if(pantalla == 1)
        main();
    if(tax==0) $('.taxTpv').hide();
    if(caja_obligatoria == 1){
         if(cambioEmpleado != 1){
             getCajas(1,1);
         }
    }
    if(cambioEmpleado == 1){
        modo = 3;
        $.mobile.changePage("#popupEmpleados");
        resizeContCompra();
    }else{
         updateCompra();
    }
    if(caja_obligatoria == 0 && cambioEmpleado != 1){
        $.mobile.changePage("#TPVTienda");
    }
    getCategoriaId(categoria_inicio_productos);
//    $('#id_carrier').selectmenu();
    if(nota_oblig == 1){
        $("#checkoutButton").prop('title',nota_oblig_texto);
        $("#checkoutButton").addClass("tpv-disabled");
    }
    if(typeof emp_al != "undefined" && typeof emp_al[id_employee] != "undefined"){
        $("#almacen_predeterminado"+emp_al[id_employee]).prop('checked', true).checkboxradio();
        $("#almacen_predeterminado"+emp_al[id_employee]).prop('checked', true).checkboxradio('refresh');
    }
    $(document).on("keydown",function (e) {
        // 0 normal, capta el teclado para los codebars
        // 1 botonera. capta los numeros para la botonera
        // 2 Otro tipo de campo.
        // 3 elige empleado
        var doPrevent = false;
        var tecla = e.keyCode;
        var teclaPulsada = "";
        var d = e.srcElement || e.target;
        if (tecla === 8) { // evita que vaya hacia atras con el backspace
            if ((d.tagName.toUpperCase() === 'INPUT' &&
                (  d.type.toUpperCase() === 'TEXT' ||
                    d.type.toUpperCase() === 'NUMBER' ||
                    d.type.toUpperCase() === 'PASSWORD' ||
                    d.type.toUpperCase() === 'FILE' ||
                    d.type.toUpperCase() === 'EMAIL' ||
                    d.type.toUpperCase() === 'SEARCH' ||
                    d.type.toUpperCase() === 'DATE')
                ) || d.tagName.toUpperCase() === 'TEXTAREA') {
                doPrevent = d.readOnly || d.disabled;
            }
            else
                doPrevent = true;
            if (doPrevent)
                e.preventDefault();
        }
        if(modo != 2){
            if(modo == 0){
                // filtrado para evitar todas las teclas que no sean numeros o un punto
                var swiper = getSwiperTPV();
                if(e.target.className == 'amount_entrada'){
                    if ((tecla < 48 || tecla > 58 && tecla < 95 || tecla > 105 ) && tecla != 110 && tecla != 8 && tecla != 37 && tecla != 39 && tecla != 46 && tecla != 190){
                        e.preventDefault();
                    }
                }else if(tecla == 37 || tecla == 39){
                    if(tecla == 37)// tecla izquierda
                        swiper.slidePrev();
                    if(tecla == 39)// tecla derecha
                        swiper.slideNext();
                }else if ((d.tagName.toUpperCase() === 'INPUT' &&
                     (
                         d.type.toUpperCase() === 'TEXT' ||
                         d.type.toUpperCase() === 'NUMBER' ||
                         d.type.toUpperCase() === 'PASSWORD' ||
                         d.type.toUpperCase() === 'FILE' ||
                         d.type.toUpperCase() === 'EMAIL' ||
                         d.type.toUpperCase() === 'SEARCH' ||
                         d.type.toUpperCase() === 'DATE')
                     ) || d.tagName.toUpperCase() === 'TEXTAREA'){
                       //nada...
                }else{
                    teclas +=  String.fromCharCode(tecla);
                    delay(function(){printKeys()},400 );
                }
            }else{
                atajosTeclado(tecla);
                flagEnter = 0;
                // TO-DO tecla intro cierra el popup
                if(tecla == 48 ||tecla == 96)
                    teclaPulsada = 0;
                if(tecla == 49 ||tecla == 97)
                    teclaPulsada = 1;
                if(tecla == 50 ||tecla == 98)
                    teclaPulsada = 2;
                if(tecla == 51 ||tecla == 99)
                    teclaPulsada = 3;
                if(tecla == 52 ||tecla == 100)
                    teclaPulsada = 4;
                if(tecla == 53 ||tecla == 101)
                    teclaPulsada = 5;
                if(tecla == 54 ||tecla == 102)
                    teclaPulsada = 6;
                if(tecla == 55 ||tecla == 103)
                    teclaPulsada = 7;
                if(tecla == 56 ||tecla == 104)
                    teclaPulsada = 8;
                if(tecla == 57 ||tecla == 105)
                    teclaPulsada = 9;
                if(tecla == 109)
                    teclaPulsada = '-';
                if(tecla == 107)
                    teclaPulsada = '+';
                if(tecla == 110 ||tecla == 190)
                    teclaPulsada = '.';
                if(tecla == 8 ||tecla == 46)
                    teclaPulsada = 'CE';
                if(tecla == 13 && flagEnter == 0) {// pulso enter
                    flagEnter = 1;
                    teclaPulsada = '';
                    if(modo == '#popupPagoEfectivo')
                        $(".okComprobarPagoEfectivo").trigger("click");
                    else if(modo == '#popupAcreditoPrimerPago')
                        $("#popupAcreditoPrimerPago .okAcredito").trigger("click");
                    else if(modo == '#popupPagoAcredito')
                        $(".okComprobarPagoAcredito").trigger("click");
                    else if(modo == '.popupPagoPayment')
                        $(".okComprobarPagoPayment").trigger("click");
                    else if(modo == '#popupPagoSatPagePayment')
                        $(".okComprobarPagoSat ").trigger("click");
                    else if(modo == '#popupPagoMixto'){
                        if(!$(".okPagoMixto").hasClass("ui-state-disabled"))
                            $(".okPagoMixto").trigger("click");
                    }else if(modo == '#popupNuevaCaja')
                        $("#nuevaCaja").trigger("click");
                    else if(typeof(modo) != "number" && modo.includes('#popupcambioNombre'))
                        $("#popupcambioNombre").popup("close");
                    else if(typeof(modo) != "number" && modo.includes('#popupcantidadProducto'))
                        $("#popupcantidad").popup("close");
                    else if(typeof(modo) != "number" && modo.includes('#popupdescamount'))
                        $("#popupdescuento").popup("close");
                    else if(typeof(modo) != "number" && modo.includes('#popupcambioprecio'))
                        $("#popupcambioprecio").popup("close");
                    else if(typeof(modo) != "number" && modo.includes('#popupcambiopeso'))
                        $("#popupcambiopeso").popup("close");
                    else if(modo == 3){
                        if($('#'+$.mobile.activePage.attr('id')+' .popupEmpPass').css('display') == "block")
                            $(".accederConPass").trigger("click");
                    }else
                        $(modo).popup( "close");
                }else{
                    if(modo == "#popupPagoEfectivo" || modo == "#popupPagoAcredito" || modo == ".popupPagoPayment" || modo == "#popupPagoSatPagePayment"){
                        calculoDeCambioTecla(teclaPulsada,modo);
                    }else if (modo != 3){
                        valorActual = valorActual.toString().replace(/,/g,"");// asi borra todas las comas del número, con "," como
                                                                    // primer parametro solo borrará la primera ocurrencia
                        if(teclaPulsada == 'CE')
                            var valorNuevo = valorActual.substr(0,valorActual.length-1);
                        else if(teclaPulsada == '+'){
                            var valorNuevo = parseInt($(modo.replace("popup","")+" .amount").html()) + 1;
                        }else if(teclaPulsada == '-' && valorActual != 1)
                            var valorNuevo = parseInt($(modo.replace("popup","")+" .amount").html()) - 1;
                        else{
                            if($.isNumeric(teclaPulsada) || teclaPulsada == '.'){
                                var valorNuevo=valorActual.toString()+teclaPulsada.toString();
                            }else{
                                if(teclaPulsada != '')
                                    $(modo.replace("popup","") + ' .subField').html(teclaPulsada);
                                var valorNuevo=valorActual.toString();
                            }
                        }
                        valorActual = valorNuevo;
                        if(modo == "#popuporder_query"){
                            $('#'+$.mobile.activePage.attr('id')+' #entradaCodigo .order_query').val(valorNuevo);
                        }else if(modo.includes('validacion_')){
                            $('#'+$.mobile.activePage.attr('id')+' #pass input[name=pass_dev]').focus();
                        }else{
                            $(modo.replace("popup","")+ ' .amount').html(valorNuevo);
                        }
                    }
                    e.defaultPrevented;
                }
            }
        }
    });
    $.mobile.document.on( "click", ".documentosAfirmar", function( evt ) {
        var id = $( this).attr("id");
        var aux = id.replace("popupAbrirDocumento_", "");
        aux = aux.split("_");
        $("#tipo_documento").val(aux[1]);
        $("#popupDocumento_"+aux[0]+"_"+aux[1]).popup( "open", { x: $(this).offset().left + ($(this).outerWidth()/2),y: $("#"+id).offset().top, changeHash : false } );
        $("#popupDocumento_"+aux[0]+"_"+aux[1]+"-popup").addClass("popupDocumento");
        $("#popupDocumento_"+aux[0]+"_"+aux[1]+"screen").addClass("popupDocumentoScreen");
        evt.defaultPrevented;
    });
    $.mobile.document.on( "click", ".key, .keyTwo", function( evt ) {
        var id = modo;
        var teclaPulsada = $(this).html();
        if(id == "#popupPagoEfectivo" || id == "#popupPagoAcredito" || id == ".popupPagoPayment" || id == "#popupPagoSatPagePayment"|| id == "#popupPagoSat"){
            calculoDeCambioTecla(teclaPulsada,id);
        }else{
            id = id.replace("popup","");
            valorActual = valorActual.replace(/,/g,"");// asi borra todas las comas del nÃƒÂºmero, con "," como primer parametro solo borrarÃƒÂ­a la primera ocurrencia
            if(teclaPulsada == 'CE' || teclaPulsada == '<span class="CEButton">CE</span>')
                var valorNuevo=valorActual.substr(0,valorActual.length-1);
            else{
                if($.isNumeric(teclaPulsada) || teclaPulsada == '.'){
                    var valorNuevo=valorActual.toString()+teclaPulsada.toString();
                }else{
                    $(id + ' .subField').html(teclaPulsada);
                    var valorNuevo=valorActual.toString();
                }
            }
            valorActual = valorNuevo;
            if(id == '#order_query')
                $('#'+$.mobile.activePage.attr('id')+' #entradaCodigo .order_query').val(valorNuevo);
            else
                $(id + " .amount").html(valorNuevo);
        }
        evt.defaultPrevented;
    });
    $.mobile.document.on( "click", ".keyDev", function( evt ) {
        if(pass_dev_enabled == 1){
            $("#pass").addClass('open');
            $(".pass_dev input[name=pass_dev]").val('');
            $(".pass_dev input[name=pass_dev]").focus();
        }else{
            devRapida();
        }
        evt.defaultPrevented;
    });

    // MENU
    //var timerMenu;
    $("#menuButtom").on( 'click', function(){
        //clearTimeout(timerMenu);
        var windowWidth = $(window).width();
        var winH = 704;
        var menuTPV = $('#contMenuTPV').css('display');
        if(menuTPV == 'none')
            $('#contMenuTPV').show();
        else
            $('#contMenuTPV').hide();
    });
    $(".menuPedidosButtom").on( 'click', function(){
        //clearTimeout(timerMenu);
        var windowWidth = $(window).width();
        var winH = 704;
        var menuPedidos = $('#'+$.mobile.activePage.attr('id')+' .contMenuPedidos').css('display');
        console.log(menuPedidos)
        if(menuPedidos == 'none')
            $('#'+$.mobile.activePage.attr('id')+' .contMenuPedidos').show();
        else
            $('#'+$.mobile.activePage.attr('id')+' .contMenuPedidos').hide();
    });
//    $('#menuTPV, .menuPedidos').on('mouseleave', function(){
//        timerMenu = setTimeout(function(){$('#menuTPV,.menuPedidos').fadeOut();}, 500);
//    });
   // $('#menuTPV, .menuPedidos').on('mouseover', function(){
//        clearTimeout(timerMenu);
//        $('#menuTPV,.menuPedidos').show();
//    });
    $('#menuTPV li').on('click', function(){
        $('#contMenuTPV').hide();
    });
    $('.menuPedidos li').on('click', function(){
        $('.contMenuPedidos').hide();
    });
    $(".listaProdIcon").on("click", function(event){
        if( $("#listaProd").val() == "list"){
            $(".contProductos2").hide();
            $(".contProductos").show();
            $(this).addClass("ui-icon-bars");
            $(this).removeClass("ui-icon-grid");
            $("#listaProd").val("grid");
        }else{
            $(".contProductos2").show();
            $(".contProductos").hide();
            $(this).removeClass("ui-icon-bars");
            $(this).addClass("ui-icon-grid");
            $("#listaProd").val("list");
        }
        $(".contProductos").html("");
        $(".contProductos2 tbody").html("");
        getCategoriaId('');
    });
    // NOTA
    $("#notaButton").on('click', function(e){
        $('#popupNota').popup("open");
        $("#messageOrder").focus();
    });
    // ALMACENES
    $("#almacenesButton").on('click', function(e){
       // }else{
//            $("input[name=almacen_predeterminado]").prop('checked', true).checkboxradio('refresh');
//        }
       $('#popupAlmacenes').popup("open");
    });
//    // BUSQUEDA AVANZADA
    $("#abrirBusq").on('click', function(){
        var descAplicados = $('#contBusquedaAvanzada').css('display');
        if(descAplicados == 'none'){
            $('#contBusquedaAvanzada').show();
            $("#abrirBusq").addClass('alterado');
        }else{
            $("#abrirBusq").removeClass('alterado');
            $('#contBusquedaAvanzada').hide();
        }

    });
    $('.pass_dev_button').on('click', function(){
        $.getJSON(token_actions,{action:'passDev',ajax:"1",pass:$('input[name=pass_dev]').val(),id_shop: id_shop},function(data) {
            if(data != null) {
               $.each(data, function(index, result) {
                    if(result.error != null)
                        mostrarError(result.error);
                    if(result.resultado == 'ok'){
                        if(vengo_de == "cambio_precio"){
                            $("#pass").removeClass("open");
                            $('.maskTPVTienda').hide();
                            vengo_de = "validar";
                            var botonCambioPrecio = modo.replace("validacion_","");
                            botonCambioPrecio = botonCambioPrecio.replace("popup","");
                            $(botonCambioPrecio).trigger("click");
                        }else if(devs_pass_neg == 1 && !confirmPayment){
                            confirmPayment = true;
                            $("#pass").removeClass("open");
                            $('.maskTPVTienda').trigger("click");
                            dev_pass_neg_flag = 1;
                            validaconPago();
                        }else{
                            $("#pass").removeClass("open");
                            anadirMascara();
                            actualizarPedidos(0);
                            actualizarProductos(0);
                            $("#devoluciones").addClass("open");
                            if(String(modo).indexOf("popupcantidadProducto") != -1){
                                $("#pass").removeClass("open");
                                devRapida();
                            }
                        }
                    }
                });
            }
        });
    });
    $(window).bind('keydown', function(e) {
        // SHORTCUTS
        teclaPulsada = e.keyCode;
        if(teclaPulsada == 117 || teclaPulsada == 118 || teclaPulsada == 119 || teclaPulsada == 120 || teclaPulsada == 113 || teclaPulsada == 27 || teclaPulsada == 121){ // F10{ // quito F5
            window.onhelp = function () { return false; }
            e.cancelable = true;
            e.stopPropagation();
            e.preventDefault();
            e.returnValue = false;
            atajosTeclado(teclaPulsada);
        }
    });
    $('#busquedaAparcado').on("keyup",function(){
        delay(function(){getAparcados(0);},300 );
    });
    $('.tabs-todosCarts').on("click",function(){
        getTodosCarts();
    });

    $('.order_query').on("keyup",function(e) {
        //he puesto este delay para que si hay una lectura de código con pistola que al final mete un enter,
        //prevalezca la busqueda de producto con el evento de enter, antes que la busqueda de aqui que sería la primera parte sin el enter, por eso un delay tan pequeño
        //al entrar mas tarde la busqueda es ignorada por el seqNumber con el que llega
        delay(function(){
            if(e.keyCode == 37 || e.keyCode == 38 || e.keyCode == 39 || e.keyCode == 40 || e.keyCode == 13 || e.keyCode == 27) return;
            search(1);
        },300 );
      });
    $('.order_query').on("keydown",function(e) {
        var swiper = getSwiperTPV();
         switch(e.keyCode) {
            case 38: // Up
                break;
            case 40: // Down
                break;
            case 13: // Enter
                e.defaultPrevented;
                search(1,'enter');
                $('#'+$.mobile.activePage.attr('id')+' .order_query').val('');
                   break;
            case 27: // Escape
                e.defaultPrevented;
                $('#'+$.mobile.activePage.attr('id')+' .order_query').val('');
                inicioProductos=0;
                swiper.removeAllSlides();
                getCategoriaId('');
                break;
        }
    });
    $(".order_query").on("mouseover", function(event){
          $("#entradaCodigo .close").show();
    });
    $(".order_query").on("mouseout", function(event){
        $("#entradaCodigo .close").hide();
    });
    $("#entradaCodigo .close").on("mouseover", function(event){
        $(this).show();
        $(this).css('color','black');
        $('#contBusquedaAvanzada').hide();
        teclas = "";
    });
    $("#entradaCodigo .close").on("mouseout", function(event){
        $(this).css('color','#777');
    });
    $("#entradaCodigo .close").on("click", function(event){
        $(".order_query").val('');
        ultimaBusqueda = "limpieza";
        getCategoriaId('');
    });
    $("#menuTPV a").on("hover", function(event){
        $(this).children('span').animate({width:'toggle'},350);
    });
    $("#nuevaComb").on("click", function(event){
        contCombs++;
        $('#contNuevaCombinacion').append('<div class="sepComb sepCombAdic"></div><div class="combinacioNuevoProducto comb_'+contCombs+'">'+$('#'+$.mobile.activePage.attr('id')+ ' .comb_0').html()+'</div>');
        $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contCombs+' select').each(function (key, item){
            $(item).parent().remove();
            $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contCombs+' .ui-controlgroup-controls').append($(item).attr('name',$(item).attr('name')+'_'+contCombs));
        });
        $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contCombs+' select').selectmenu();
        $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contCombs+' select').selectmenu('refresh');
        $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contCombs+' input').each(function (key, item){
            $(item).attr('name',$(item).attr('name')+'_'+contCombs);// le añado el contador para que no sea el mismo identidicador
        });
        $("#contNuevaCombinacion").show();
    });

    $("#pedidosButton").on("click", function(event){
        $(".listadoPedidosPage h1").html(pedidosTxT);
        abrirPedidos();
    });
    $("#pagosButton").on("click", function(event){
        $.mobile.changePage("#pagos");
        $('#busquedaPagos').on("keyup",function(e) {
            if(e.keyCode == 38 || e.keyCode == 40 || e.keyCode == 13 || e.keyCode == 27) return;
            var query = $('#busquedaPagos').val();
                 if(query != ''){
                  delay(function(){getPagos()},400 );
              }else{
                  getPagos();
            }
        });
        getPagos();
        $(".fechaPagos").on('keyup', function(e) {
               getPagos();
        });
    });
    $("#more_pagos").on("click", function(event){
        getPagos(true);
    });
    $("#buttonCarts").on("click", function(event){
        mostrarCarritos($('#'+$.mobile.activePage.attr('id')+" .id_customer_popup").val());
    });
    $(".okComprobarPagoPayment").on("click", function(event){
        var aDevolver = $("#"+$.mobile.activePage.attr('id')+' .popupPagoPayment .aDevolverButton').html();
        if(caja_obligatoria == 1 && aDevolver >0 && (dineroEnCaja - aDevolver) < 0)
            avisoCaja();
        else{
            var id_order = $("#"+$.mobile.activePage.attr('id')+' .popupPagoPayment input[name=id_order]').val();
            var formaPago = $("#"+$.mobile.activePage.attr('id')+' .popupPagoPayment input[name=formaPago]').val();
            var amount = $("#"+$.mobile.activePage.attr('id')+' .popupPagoPayment input[name=amount]').val();
            var pagado = $("#"+$.mobile.activePage.attr('id')+' .popupPagoPayment .pagado').html();
            anadirPayment(id_order,formaPago,amount,pagado);
        }
        $("#"+$.mobile.activePage.attr('id')+' .popupPagoPayment .pagado').html(0);
        $("#"+$.mobile.activePage.attr('id')+' .popupPagoPayment').popup( "close" );
    });
    $(".anadirProductoButton").on("click", function(event){
        $("#"+$.mobile.activePage.attr('id')+ " .anadirProducto").addClass('open');
        $("#"+$.mobile.activePage.attr('id')+ " .popupProducto").popup("close");
         anadirMascara();
        $('#'+$.mobile.activePage.attr('id')+' .anadirProductoForm .nombre').on('keyup', function(e) {
            $('#'+$.mobile.activePage.attr('id')+ '.anadirProductoForm .url').val(str2url($('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm .nombre').val(), 'UTF-8'));
        });
        $('#'+$.mobile.activePage.attr('id')+' .precioSinIvaAnadirProd').on("keyup",function(e) {
            var priceTE = parseFloat(this.value.replace(/,/g, '.'));
            var newPrice = addTaxes(priceTE);
            $('#'+$.mobile.activePage.attr('id')+ ' label[for='+$('#'+$.mobile.activePage.attr('id')+ ' .precioAnadirProd').attr("id")+"]").addClass('active focusIn');
            $('#'+$.mobile.activePage.attr('id')+ ' .precioAnadirProd').val((isNaN(newPrice) == true || newPrice < 0) ? '' : ps_round(newPrice, 6).toFixed(6));
        });
        $('#'+$.mobile.activePage.attr('id')+' .precioAnadirProd').on("keyup",function(e) {
          if(e.keyCode != 9){// si escribo un tabulador no entro, asi evito que cambie el precio sin IVA
            var priceTI = parseFloat(this.value.replace(/,/g, '.'));
            var newPrice = removeTaxes(ps_round(priceTI, priceDisplayPrecision));
            $('#'+$.mobile.activePage.attr('id')+ ' label[for='+$('#'+$.mobile.activePage.attr('id')+ ' .precioSinIvaAnadirProd').attr("id")+"]").addClass('active focusIn');
            $('#'+$.mobile.activePage.attr('id')+ ' .precioSinIvaAnadirProd').val((isNaN(newPrice) == true || newPrice < 0) ? '' : ps_round(newPrice, 6).toFixed(6));
          }
        });
        $('#'+$.mobile.activePage.attr('id')+' .anadirProducto_id_tax').on("change", function(event){
            var priceTE = parseFloat($('#'+$.mobile.activePage.attr('id')+' .precioSinIvaAnadirProd').val().replace(/,/g, '.'));
            var newPrice = addTaxes(priceTE);
            $('#'+$.mobile.activePage.attr('id')+' .precioAnadirProd').val((isNaN(newPrice) == true || newPrice < 0) ? '' : ps_round(newPrice, priceDisplayPrecision));
            $('#'+$.mobile.activePage.attr('id')+' .precioSinIvaAnadirProd').val((isNaN(newPrice) == true || newPrice < 0) ? '' : ps_round(newPrice, 6).toFixed(6));
        });
        if(forzarStockAvanzado == 1){
            $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name=stock_avanzado]').prop('checked', true).checkboxradio('refresh');
            $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm .StockAlmacenes input[id^=stockNuevoProd]').prop('checked', true).checkboxradio('refresh');
        }else{
            $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name=stock_avanzado]').prop('checked', false).checkboxradio('refresh');
            $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[id^=StockManual]').prop('checked', true).checkboxradio('refresh');
        }
        //elimina el evento para uqe no se acumulen
        $('#'+$.mobile.activePage.attr('id')+' .selectCategoriasNuevoProducto').off("change");
        $('#'+$.mobile.activePage.attr('id')+' .selectCategoriasNuevoProducto').on("change", function(event){
            recalcularListaCategorias();
            var texto = $('#'+$.mobile.activePage.attr('id')+' .selectCategoriasNuevoProducto option[value='+$(this).val()+']').text();
            var i = 0;
            while(texto.charAt(i) == '-' || texto.charAt(i) == ' ')
                i++;
            texto = texto.substr(i,texto.length);
            $('#'+$.mobile.activePage.attr('id')+' .categoriasElegidas').append('<div data-mini="true" id="cat_'+$(this).val()+'" onclick="borrarCategoria(this,'+$(this).val()+')" class="catEscondida ui-btn ui-icon-delete ui-btn-icon-left ui-shadow ui-corner-all">'+texto+'</div>');
        });
        if(anadirProdDropZone == ""){
            anadirProdDropZone = $('#'+$.mobile.activePage.attr('id')+ ' .subidaImagenesProducto').dropzone({
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
                url: "../modules/tpvtienda/classes/actions/actionsAnadirProducto.php?token="+token,
                success: function(file, data) {
                    $('#'+$.mobile.activePage.attr('id')+ ' .subidaImagenesProducto').addClass("dropzone");
                    var data = $.parseJSON(data);
                    if(data != 0){
                        $(data).each(function (key, item){
                            if(item.filename != ""){
                                var fotos = $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name=fotos]').val();
                                if(fotos == "")
                                    $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name=fotos]').val(item.filename);
                                else
                                    $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name=fotos]').val($('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name=fotos]').val()+","+item.filename);
                            }
                        });
                    }
                }
            });
        }
    });

    $(".botonCrearProducto").on("click", function(event){
        $('#'+$.mobile.activePage.attr('id')+ ' .submitAnadirProducto').trigger('click');
    });
    $("#messageOrder").bind('input propertychange', function() {
        if($("#messageOrder").val() != ""){
            if(nota_oblig == 1){
                $("#checkoutButton").removeClass("tpv-disabled");
                $("#checkoutButton").tooltip('disable');
            }
            $("#contNotaButton .fa-check-circle").show();
        }
        if($("#messageOrder").val() == ""){
            if(nota_oblig == 1 ){
                $("#checkoutButton").addClass("tpv-disabled");
                $("#checkoutButton").prop('title',nota_oblig_texto);
                $("#checkoutButton").tooltip('enable');
            }
            $("#contNotaButton .fa-check-circle").hide();
        }
    });
    $(".categorias").on("change", function(event){
        inicioProductos=0;
        var swiper = getSwiperTPV();
        if(typeof swiper != 'undefined')
            swiper.removeAllSlides() ;
        $('#contBusquedaAvanzada').hide();
        $("#abrirBusq").removeClass('alterado');
        $(".contProductos").html("");
        $('.contProductos2 tbody').html("");
        getCategoriaId($('#'+$.mobile.activePage.attr('id')+' select.categorias').val());
    });

    $('.anadirDescuentoButton').on("click", function(event){
        $(".anadirDescuentos").removeClass('open');
        $(".anadirDescuento").addClass('open');
        gencodeTPV(8);
        $("label[for=code]").addClass('active focusIn');
        $(".anadirDescuentoForm :submit").click(function () { $('#'+$.mobile.activePage.attr('id')+" .actionDescuento").val(this.id); });
        $('.anadirDescuento input').on('click', function(e) {
            $('label.error').hide("slow");
        });
        anadirMascara();
    });
    $('#aparcadosButton').on("click", function(event){
        getAparcados(0);
        $("#aparcados").addClass('open');
       //  vengo_de = "aparcados";
        $("#subTPVTienda").addClass("open");
        anadirMascara();
    });
    $('#presupuestosButton').on("click", function(event){
        vengo_de = "presupuesto";
        $(".listadoPedidosPage h1").html(presupuestosTxT);
        abrirPedidos(nombreEstadoPresupuesto);
    });
    $('.diezAntAparcados').on('click', function(e) {
        getAparcados(paginadorAparcados-10);
    });
    $('.diezSigAparcados').on('click', function(e) {
        getAparcados(paginadorAparcados+10);
    });
    $('.accederConPass').on("click", function(event){
        var id = $(".empSeleccionado").attr("id");
        var emp = id.replace("empleado_", "");
        var arrayEmp = emp.split("_");

        $.getJSON(token_actions,{action:'passEmpleado',ajax:"1",pass:$('#'+$.mobile.activePage.attr('id')+' .passempleado').val(),id_employee:arrayEmp[0],id_shop: id_shop},function(data) {
            if(data != null) {
                $.each(data, function(index, result) {
                    if(result.error != null)
                        mostrarError(result.error);
                    if(result.resultado == 'ok'){
                        accederEmpleado(id);
                    }
                });
                $(".passempleado").val("");
            }
        });
    });
    $('.employee_seleccionable').on("click", function(event){
        $('.employee_seleccionable').removeClass("empSeleccionado");
        $(this).addClass("empSeleccionado");
        if(emp_pass == 1){
            $('#'+$.mobile.activePage.attr('id')+' .popupEmpPass').popup("open");
            $("#passempleado").focus();
        }else{
            accederEmpleado($(this).attr("id"));
        }
    });
    $('#devolverEnCaja').click(function(){
        $.getJSON(token_actions,{ ajax : "1",action:'devolverEnCaja', id_shop: id_shop, id_order: id_order_global, id_employee: id_employee, cajaEnUso: cajaEnUso, formaPagoId:estadoActual,
            id_currency: $('#currencyPOS').val(),totalDevolucionesConIva: totalDevolucionesConIva,totalDevolucionesSinIva: totalDevolucionesSinIva},function(data) {
            if(data != null) {
                actualizarCaja(cajaEnUso);
                $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html(devolverEnTxt2);
                $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').slideDown('fast');
                $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(6000).slideUp('fast');
                $( "#popupElegirAbono").popup( "close");
            }
        });
    });
    $('#devolverEnVale').click(function(){
        $.getJSON(token_actions,{ ajax : "1",action:'devolverEnVale', id_shop: id_shop, id_order: id_order_global, id_employee: id_employee,
        id_currency: $('#currencyPOS').val(),totalDevolucionesConIva: totalDevolucionesConIva,totalDevolucionesSinIva: totalDevolucionesSinIva},function(data) {
            if(data != null) {
                $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html(devolverEnValeTxt);
                $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').slideDown('fast');
                $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(6000).slideUp('fast');
                $( "#popupElegirAbono").popup( "close");
                 $.each(data, function(index, result) {
                    if(result.error != null)
                        mostrarError(result.error);
                    if(result.valesNuevos != null){
                        getTicketDescuento(result.valesNuevos.id);
                    }
                });
            }
        });
    });
    selectHtml = "";
    $.each(statuses, function(index, state) {
        selectHtml += '<option style="background:'+state['color']+';color:'+state['font']+'" value="'+state['id']+'">'+state['name']+'</option>';
    });
    $('.cambioEstadoMasivoCont').html('<select name="nuevoEstadoMasivo" class="nuevoEstadoMasivo">'+selectHtml+'</select>');
    $('.cambioEstadoMasivoCont select').selectmenu();
    $('.cambioEstadoMasivoCont select').selectmenu('refresh');
    $('#devolucionesButton').on("click", function(event){
        $("#BarraAccionesDevs").hide();
        $("#contadorDevs").html(0);
        $('.motivo').val("");
        modo = 'devoluciones';
        delay(function(){$('#'+$.mobile.activePage.attr('id')+' #pass input[name=pass_dev]').val('')},600 );
        if(pass_dev_enabled == 1 && devs_pass_neg == 0){
            $("#pass").addClass("open");
            vengo_de="devoluciones";
        }else{
            $("#devoluciones").addClass('open');
            anadirMascara();
            actualizarPedidos(0);
            actualizarProductos(0);
        }
    });
    $('#codigoPedido, #nFactura').on("keyup",function(e) {
        if(e.keyCode == 38 || e.keyCode == 40 || e.keyCode == 13 || e.keyCode == 27) return;
        delay(function(){actualizarPedidos(0)},400 );
    });
    $('#refProdDev, #clienteProductosDevs').on("keyup",function(e) {
        if(e.keyCode == 38 || e.keyCode == 40 || e.keyCode == 13 || e.keyCode == 27) return;
        delay(function(){actualizarProductos(0)},400 );
    });
    $('#clientePedidoDevs').on('keyup', function(e) {
        delay(function(){actualizarPedidos(0)},400 );
    });
    $('#clienteProductosDevs').on('keyup', function(e) {
        delay(function(){actualizarProductos(0)},400 );
    });
    $('.diezAnt').on('click', function(e) {
        actualizarPedidos(paginadorDevoluciones-10);
    });
    $('.diezSig').on('click', function(e) {
        actualizarPedidos(paginadorDevoluciones+10);
    });
    $('.diezAntProds').on('click', function(e) {
        actualizarProductos(paginadorDevolucionesProds-10);
    });
    $('.diezSigProds').on('click', function(e) {
        actualizarProductos(paginadorDevolucionesProds+10);
    });

    $('.advertencia .fancybox-close').on('click', function(e) {
        $(this).parent().slideUp('fast');
       //  $("#"+$.mobile.activePage.attr('id')+' .advertencia .module_confirmation').slideUp('fast');
    });
    $('#inactivos,#stockcero').on('change', function(e){
        var query = $('#'+$.mobile.activePage.attr('id')+' .order_query').val();
        if(ultimaBusqueda == 'categoriaId'){
            inicioProductos = 0;
            ultimaBusqueda = 'limpieza';
            getCategoriaId(catActual);
        }else
            $('#'+$.mobile.activePage.attr('id')+' .order_query').trigger('keyup');
    });

    $('.direcciones select.id_country').on('change',function(e){
       updateState( $(this).parents(".direcciones").attr("id"));
    });

    $('.titularTarjeta, .numeroTarjeta, .transactionIdTarjeta').on('keyup', function(e) {
        var titular = $("#"+$.mobile.activePage.attr('id')+' .titularTarjeta').val();
        var numero = $("#"+$.mobile.activePage.attr('id')+' .numeroTarjeta').val();
        var transactionIdTarjeta = $("#"+$.mobile.activePage.attr('id')+' .transactionIdTarjeta').val();

        delay(function(){
            $.getJSON("../modules/tpvtienda/classes/actions/actions.php",{token:token, action:'guardarTarjeta', id_order: id_order_global, titular:titular,numero:numero,
                transactionIdTarjeta : transactionIdTarjeta, id_currency: $('#currencyPOS').val(), id_shop: id_shop,id_lang:id_lang},function(data) {
                if(data != null) {
                    $("#"+$.mobile.activePage.attr('id')+' .tCredito .guardado').fadeIn();
                    $("#"+$.mobile.activePage.attr('id')+' .tCredito .guardado').delay(1000).fadeOut();
                }
            });
        },400 );
   });
   $('.numeroCheque, .bancoCheque, .libradorCheque, .nombreCheque, .fechaCheque').on('keyup', function(e) {
       delay(function(){
           $.getJSON("../modules/tpvtienda/classes/actions/actions.php",{token:token, action:'guardarCheque', id_order: id_order_global, numeroCheque:$("#"+$.mobile.activePage.attr('id')+' .numeroCheque').val(),bancoCheque:$("#"+$.mobile.activePage.attr('id')+' .bancoCheque').val(),
               libradorCheque:$("#"+$.mobile.activePage.attr('id')+' .libradorCheque').val(),nombreCheque:$("#"+$.mobile.activePage.attr('id')+' .nombreCheque').val(),fechaCheque:$("#"+$.mobile.activePage.attr('id')+' .fechaCheque').val(),
               id_currency: $('#currencyPOS').val(), id_shop: id_shop},function(data) {
               if(data != null) {
                      $("#"+$.mobile.activePage.attr('id')+' .cheque .guardado').fadeIn();
                    $("#"+$.mobile.activePage.attr('id')+' .cheque .guardado').delay(1000).fadeOut();
               }
           });
       },400 );
   });

   $('.numeroCuenta, .bancoNombre').on('keyup', function(e) {
       var numeroCuenta = $("#"+$.mobile.activePage.attr('id')+' .numeroCuenta').val();
       var bancoNombre = $("#"+$.mobile.activePage.attr('id')+' .bancoNombre').val();
       delay(function(){
           $.getJSON("../modules/tpvtienda/classes/actions/actions.php",{token:token, action:'guardarTBancaria', id_order: id_order_global, numeroCuenta:numeroCuenta,bancoNombre:bancoNombre,
               id_currency: $('#currencyPOS').val(), id_shop: id_shop},function(data) {
               if(data != null) {
                      $("#"+$.mobile.activePage.attr('id')+' .tBancaria .guardado').fadeIn();
                    $("#"+$.mobile.activePage.attr('id')+' .tBancaria .guardado').delay(1000).fadeOut();
               }
           });
       },400 );
   });
   /*
     * $('#diasFact').on('keyup', function(e) { var hoy = new
     * Date($('#hoy').val()); var vencimiento = new Date($('#hoy').val());
     * if(vencimiento == null){ $('.FechaFinFact').val(hoy); }else{
     * vencimiento.setDate(hoy.getDate()+parseInt($('#diasFact').val())); var
     * mes = vencimiento.getMonth()+1; if (mes <= 9) mes = "0"+mes; var dia =
     * vencimiento.getDate(); if (dia <= 9) dia = "0"+dia; fechaFinFact =
     * vencimiento.getFullYear()+'/'+mes+'/'+dia; console.log(fechaFinFact);
     * $('.FechaFinFact').hide(); $('.FechaFinFact').val(fechaFinFact); } });
     */
   $(".anadirPagoMixto").on("click", function(event){
       var options = "";
       $('.addPaymentMixto:first select option').each(function(payment) {
           options += '<option value="'+$(this).val()+'">'+$(this).html()+'</option>';
       });
        $(".pagos").append('<div class="addPaymentMixto row unaMas"><div class="ninecol"><select class="formaPagoMixto">'+options+'</select></div><div class="threecol last"><input type="text" name="value" class="cantidadPagoMixto" onkeyup="calcularRestante()" value=""/></div></div>');
         $('select.formaPagoMixto').selectmenu();
         $('input.cantidadPagoMixto').textinput();
   });
   $("select.formaPagoMixto").on("change", function(){
       $(this).selectmenu('refresh');
   });
   //cuando te avisa que en la caja no hay suficiente dinero
    $("#popupAvisoCaja .okPago").on("click", function(event){
        $("#popupAvisoCaja").popup( "close");
        pago();
        $("#popupPagoEfectivo .pagado").html(0);
        $("#popupPagoEfectivo").popup( "close");
    });
    $(".okPagoMixto").on("click", function(event){
        listadoPagos = new Array();
         $('.addPaymentMixto').each(function(payment) {
            listadoPagos.push({q: $(this).find('.cantidadPagoMixto').val(), m: $(this).find('select.formaPagoMixto').val()});
        });
        $("#popupPagoMixto").popup( "close");
        pago();
    });
    $(".okComprobarPagoEfectivo").on("click", function(event){
        var aDevolver = $(".aDevolverButton").html();
        if(caja_obligatoria == 1 && aDevolver >0 && (dineroEnCaja - aDevolver) < 0)
            avisoCaja();
        else{
            $("#popupPagoEfectivo").popup( "close");
            pago();
        }
    });

    $('.dropzoneImg .dz-remove').on("click", function(event){
        var id_borrar = $(this).attr("id");
        id_borrar = id_borrar.replace("borrarCust_", "");
        $("#cust_"+id_borrar).show();
        $(this).parents('.dropzoneImg').hide();
    });
    $("#currencyPOS").on("change",function(){
        updateCompra();
        getCategoriaId('');
    });
    setTimeout(function() {
         resizeContCompra();
    }, 1500);
    avisadorPedidosJS();
    hookJS('general');
    $(".codDescuento").val("");
});
( function( $ ) {
    function pageIsSelectmenuDialog( page ) {
        var isDialog = false, id = page && page.attr( "id");
        $(".filterable-select").each( function() {
            if ( $( this ).attr( "id") + "-dialog" === id ) {
                isDialog = true;
                return false;
            }
        });
        return isDialog;
    }
    $.mobile.document
        // Upon creation of the select menu, we want to make use of the fact that the ID of the
        // listview it generates starts with the ID of the select menu itself, plus the suffix "-menu".
        // We retrieve the listview and insert a search input before it.
        .on( "selectmenucreate", "#categorias-listbox.filterable-select", function( event ) {
            var input, selectmenu = $( event.target ), list = $("#" + selectmenu.attr( "id") + "-menu"), form = list.jqmData( "filter-form");
            // We store the generated form in a variable attached to the popup so we avoid creating a
            // second form/input field when the listview is destroyed/rebuilt during a refresh.
            if ( !form ) {
                input = $("<input data-type='search'></input>");
                form = $("<form></form>").append( input );
                input.textinput();
                list.before( form ).jqmData( "filter-form", form ) ;
                form.jqmData( "listview", list );
            }
            // Instantiate a filterable widget on the newly created selectmenu widget and indicate that
            // the generated input form element is to be used for the filtering.
            selectmenu
                .filterable({
                    input: input,
                    children: "> optgroup option[value]"
                })
                // Rebuild the custom select menu's list items to reflect the results of the filtering
                // done on the select menu.
                .on( "filterablefilter", function() {
                    selectmenu.selectmenu( "refresh");
                });
        })
        // The custom select list may show up as either a popup or a dialog, depending on how much
        // vertical room there is on the screen. If it shows up as a dialog, then the form containing
        // the filter input field must be transferred to the dialog so that the user can continue to
        // use it for filtering list items.
        .on( "pagecontainerbeforeshow", function( event, data ) {
            var listview, form;
            // We only handle the appearance of a dialog generated by a filterable selectmenu
            if ( !pageIsSelectmenuDialog( data.toPage ) )
                return;
            listview = data.toPage.find( "ul");
            form = listview.jqmData( "filter-form");
            // Attach a reference to the listview as a data item to the dialog, because during the
            // pagecontainerhide handler below the selectmenu widget will already have returned the
            // listview to the popup, so we won't be able to find it inside the dialog with a selector.
            data.toPage.jqmData( "listview", listview );
            // Place the form before the listview in the dialog.
            listview.before( form );
            $("#categorias-dialog form a.ui-icon-delete").trigger("click");
        })
        // After the dialog is closed, the form containing the filter input is returned to the popup.
        .on( "pagecontainerhide", function( event, data ) {
            var listview, form;
            // We only handle the disappearance of a dialog generated by a filterable selectmenu
            if ( !pageIsSelectmenuDialog( data.toPage ) )
                return;
            listview = data.toPage.find( "ul");
            form = listview.jqmData( "filter-form");
            // Put the form back in the popup. It goes ahead of the listview.
            listview.before( form );
        });
    })( jQuery );
$(document).on("pagecreate", "#categorias-dialog", function (e) {
    var form = $("<form><input data-type='search'/></form>"),
        page = $(this);
    $(".ui-content", this)
        .prepend(form);

    form.enhanceWithin().on("keyup", "input", function () {
        var data = $(this).val().toLowerCase();
        $("li", page).addClass("ui-screen-hidden").filter(function (i, v) {
            return $(this).text().toLowerCase().indexOf(data) > -1;
        }).removeClass("ui-screen-hidden");
    });

    $(document).on("pagecontainerhide", function () {
        $("#categorias-menu li").removeClass("ui-screen-hidden");
        $("input", form).val("");
    });

 });