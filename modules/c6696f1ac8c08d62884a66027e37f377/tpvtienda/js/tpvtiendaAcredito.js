var tablaPedidosAcredito = "";

function getFacturasCredito(scroll){
    var seqNumber = ++xhrCount;
    $("#tablaPedidosAcredito tbody").html("");
    var query = $('#aCredito #tablaPedidosAcredito_filter input[type=search]').val();
    var heightFondo = $(window).height();
    var selected = [];
    if (typeof tablaPedidosAcredito == 'object' || (typeof $.fn.DataTable != "undefined" && $.fn.DataTable.isDataTable('table#tablaPedidosAcredito' ) )) {
        $('table#tablaPedidosAcredito' ).DataTable().destroy();
    }
    tablaPedidosAcredito = $('#tablaPedidosAcredito').DataTable({
        dom: 'Tf<"clear">lrti',
        "language":traducciones,
       // "columnDefs": [{ "visible": false, "targets": 1 },
//                            { "visible": false, "targets": 2 },
//                            { "visible": false, "targets": 3 },
//                            { "visible": true, "targets": 4 },
//                            { "visible": true, "targets": 5 },
//                            {"width": "230px","targets": 6},
//                            {"width": "150px","targets": 7},
//                            {"width": "150px","targets": 8},
//                            {"width": "80px","targets": 9}],
        "order": [[ 0, 'desc' ]],
        "columnDefs": [
            {"targets": 0,"sortable":false},
            {"targets": 9,"sortable":false}
        ],
        "drawCallback": function ( settings ) {
            $('#'+$.mobile.activePage.attr('id')+' #btn-example-load-more-ordersAcreditoTPV').toggle(this.api().page.hasMore());
        },
        "aLengthMenu":[[30,60,120,240,480,960,1920,3840,7680,99999999999],[30,60,120,240,480,960,1920,3840,7680,"All"]],
        "order": [[ 0, "desc" ]],
        serverSide: true,
        processing: true,
        "ajax": "../modules/tpvtienda/classes/actions/actionsAcredito.php?action=getFacturasCredito&id_shop="+id_shop+"&id_lang="+id_lang+"&id_currency="+$('#currencyPOS').val()+"&token="+token,
    });
        var contadorCabeceras = 0
    $('#tablaPedidosAcredito thead th').each( function () {
        var title = $(this).attr("title");
        if(contadorCabeceras != 0 && contadorCabeceras < 9)
            $(this).html( '<input type="text" id="filtroAcredito_'+contadorCabeceras+'" class="filtroTablaAcredido" placeholder="'+title+'" />');
        if(contadorCabeceras == 4 || contadorCabeceras == 5){
            $('#filtroAcredito_'+contadorCabeceras).datepicker({
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
    $("#tablaPedidosAcredito thead input").click( function (e) {
        if (!e) var e = window.event
        e.cancelBubble = true;
        if (e.stopPropagation) e.stopPropagation();
    });
    $( '.filtroTablaAcredido, .buscarProducto').on( 'keyup', function (event) {
        event.stopPropagation();
        var altura = $(window).height();
        $("#listadoPedidosPage").css({'height':(altura)+'px'});
        tablaPedidosAcredito.ajax.url("../modules/tpvtienda/classes/actions/actionsAcredito.php?action=getFacturasCredito&id_order="+$("#filtroAcredito_1").val()+"&referencia="+$("#filtroAcredito_2").val()+
            "&cliente="+$("#filtroAcredito_3").val()+"&fecha_ini="+$("#filtroAcredito_4").val()+"&fecha_fin="+$("#filtroAcredito_5").val()+"&estado="+$("#filtroAcredito_6").val()+
            "&falta_pagar="+$("#filtroAcredito_7").val()+"&total="+$("#filtroAcredito_8").val()+"&producto="+$(".buscarProducto").val()+
            "&id_shop="+id_shop+"&id_lang="+id_lang+"&token="+token+"&id_currency="+$('#currencyPOS').val()+"&id_employee="+id_employee+"&limit=50").load();
    });
    $('#tablaPedidosAcredito tbody').unbind( "click" );
    $("#tablaPedidosAcredito tbody").on('click', 'tr td:not(:first-child,:last-child)', function(event){
        var tablaPedidosAcredito = $(this).parent().attr("id");
        var idAcredito = tablaPedidosAcredito.replace("pad_", "");
       abrirFactCred(idAcredito);
    });

}
function openOrdenResumen(){
    window.location = '../modules/tpvtienda/classes/hojaPedido/imprimirHojaPedido.php?id_order='+id_order_global+'&id_employee='+id_employee+'&id_lang='+id_lang;
}
function openSupplyorders(){
    localStorage.setItem('id_order_global', id_order_global);
    window.location = urlSupplyorderspro;
}

function abrirFactCred(id_order){
    // comprimo todo
    $.mobile.changePage('#aCreditoPage');
    actualizarPagoAcredito(id_order);
  //  $('#'+$.mobile.activePage.attr('id')+' .anadirProductoButtonAcredito').on("click", function(event){
//        $('#'+$.mobile.activePage.attr('id')+' .anadirProductoButton').trigger("click");
//    });

}
function getTicketAcredito(id){
    $(".loaderTicket").show();
    mostrarTicket('normal');
    $.getJSON("../modules/tpvtienda/classes/actions/actionsConf.php",{token:token, action:'reticket',id_order:id,id_shop:id_shop,
        id_employee: id_employee,id_lang:id_lang,id_currency: $("#currencyPOS").val()},function(data) {
        error = verTicket(data);
        $.each(data, function(index, result) {
            if(result.error != null)
                mostrarError(result.error);
        });
        $(".loaderTicket").hide();
    });
}

function cambiarPagado(id){
    $.getJSON("../modules/tpvtienda/classes/actions/actionsAcredito.php",{token:token, action:'cambiarFacturaCredito',id_order:id, id_shop: id_shop},function(data) {
        if(data == 1){
            getFacturasCredito();
        }
    });
}
function guardarFechaFin(id){
    var valorFechaFin = $('#fin_'+id+' input').val();
    $.getJSON("../modules/tpvtienda/classes/actions/actionsAcredito.php",{token:token, action:'modificarFechaCredito',id_order:id, fecha:valorFechaFin, id_shop: id_shop},function(data) {
        if(data == 1){
            $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html(actualizado);
            $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').slideDown('fast');
            $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(1000).slideUp('fast');
            $('#fin_'+id+'').html(valorFechaFin);
            $('#fin_'+id).parent().children('a').show();
        }
    });
}
function editFacturaCredito(id){
    var valorFechaFin = $('#fin_'+id).html();
    $('#fin_'+id).parent().children('a').hide();
    $('#fin_'+id).html('<input tyle="text" class="ui-btn corner-all ui-shadow" size="9" value="'+valorFechaFin+'"><span onclick="guardarFechaFin('+id+')" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn">'+guardarTxt+'</span>');
}
function deleteFacturaCredito(id){
    $.getJSON("../modules/tpvtienda/classes/actions/actionsAcredito.php",{token:token, action:'deleteFechaCredito',id_order:id, id_shop: id_shop},function(data) {
        if(data == 1){
            getFacturasCredito();
        }
    });
}
function actualizarPagoAcredito(id_order){
    var currentDate = new Date();
    var day = currentDate.getDate();
    var month = currentDate.getMonth() + 1;
    var year = currentDate.getFullYear();
    var html = "";
    var orderInfo = "";
    var pagadoTodoYFaltaPorCambiar = 0;
    if(month<10) month = "0"+month;
    var metodosPagoHtml = getMetodosPago('acredito');
    $(".detallesPedidoAcredito h1 span").html("");
    $(".detallesPedidoAcredito .faltaPorPagar span").html("");
    $(".detallesPedidoAcredito .total span").html("");
    $(".detallesPedidoAcredito .fecha span").html("");
    $(".detallesPedidoAcredito .notaPedido").val("");
    $(".detallesPedidoAcredito .contentpayments").html("");
    $("#"+$.mobile.activePage.attr('id')+" input[name=nuevaCantidad]").hide();
    $("#"+$.mobile.activePage.attr('id')+" .envioPedido").show();
    $("#"+$.mobile.activePage.attr('id')+" .envioCambioAgencia").hide();
    id_order_global = id_order;
    $.getJSON("../modules/tpvtienda/classes/actions/actionsAcredito.php",{token:token, action:'getOrderPayments', adminDir: adminDir,id_order: id_order, id_currency: $("#currencyPOS").val(),
        id_shop: id_shop,id_lang: id_lang,id_employee:id_employee},function(data) {
        $.each(data, function(index, result) {
            if(result.payments != null){
                html+="<h2>"+pagosTexto+"</h2><table class='dataTable ui-responsive table'><thead><tr><th>"+pagoID+"</th><th>"+formaPago+"</th><th>"+cantidadTexto+"</th><th>"+fecha+"</th><th></th></tr></thead><tbody>";
                $.each(result.payments, function(index, result) {
                    html +="<tr>" +
                            "<td>"+result.id+"</td>" +
                            "<td>"+result.payment_method+"</td>" +
                            "<td>"+result.amount+"</td>" +
                            "<td>"+result.date_add+"</td>" +
                            "<td>"+
                                '<a href="#" onclick="getTicketPayment('+id_order+','+result.id+',true)">Ticket</a>'+
                                '<a href="#" onclick="if(confirm(\'delete?\')){deletePayment('+result.id+','+id_order+')}else{event.stopPropagation(); event.defaultPrevented;}"><i class=\"icon-trash\"></i></a></td>'+
                            '</tr>';
                });
            }
            if(result.order != null){
                vengo_de = "acredito";
                $(".detallesPedidoAcredito h2 span").html(result.order.id_order);
                id_order_global = result.order.id_order;
                id_cart_pedido = result.order.id_cart;
                $(".detallesPedidoAcredito .faltaPorPagar span").html(result.order.faltaPorPagar);
                $(".detallesPedidoAcredito .total span").html(result.order.total);
                $(".detallesPedidoAcredito .fecha span").html(result.order.fecha_ini);
                $(".detallesPedidoAcredito .fecha_fin span").html(result.order.fecha_fin);
                $(".detallesPedidoAcredito .cuotasOrderCredit span").html(result.order.cuota);
                $(".detallesPedidoAcredito .interesOrderCredit span").html(result.order.interes);
                $(".detallesPedidoAcredito .totalInteresOrderCredit span").html(result.order.totalInteres);
                $(".detallesPedidoAcredito .envioPedido").html(result.order.envio);
                $(".detallesPedidoAcredito select[name=nuevaAgencia]").prop('selectedIndex',$(".detallesPedidoAcredito select[name=nuevaAgencia] option[value="+result.order.id_carrier+"]").index()).selectmenu('refresh');
                $(".detallesPedidoAcredito .descPedido").html(result.order.desc);
                $(".detallesPedidoAcredito .notaPedido").val(result.order.note);
                $(".detallesPedidoAcredito .totalPedido").html(result.order.total);
                $(".detallesPedidoAcredito input[name=nuevaCantidad]").val(result.order.envioRaw);
                $(".detallesPedidoAcredito .contButtonTicket").html('<a class="getticket ui-btn ui-corner-all ui-shadow ui-btn-inline" onclick="reTicket(\'actual\','+result.order.id_order+')">'+ticketNormal+'</a>');
                if(result.order.factura != null && result.order.factura == 1){
                    $(".detallesPedidoAcredito .verFacturaAcredito").show();
                    $(".detallesPedidoAcredito .verFacturaAcredito").attr("href", $("#urlBackoffice").val()+"/index.php?controller=AdminPDF&submitAction=generateInvoicePDF&id_order="+result.order.id_order+"&token="+$('#tokenLitePDF').val());
                }else{
                    $(".detallesPedidoAcredito .verFacturaAcredito").hide();
                }
                var selectHtml = "";
                $.each(statuses, function(index, state) {
                       selectHtml += '<option style="background:'+state['color']+';color:'+state['font']+'"value="'+state['id']+'"'+(result.order.current_state == state['id'] ? ' selected' : '')+'>'+state['name']+'</option>';
                });
                $("#"+$.mobile.activePage.attr('id')+' .vouchersCont').html("");
                $.each(result.order.vouchers, function(index, voucher) {
                    if(voucher['reduction_percent'] != 0)
                        var descValue = voucher['reduction_percent']+'%';
                    if(voucher['reduction_amount'] != 0)
                        var descValue = '- '+voucher['reduction_amount'];
                    $("#"+$.mobile.activePage.attr('id')+' .vouchersCont').append('<a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-icon-right ui-icon-delete" onclick="deleteVoucherOrder('+id_order_global+','+voucher['id']+')">'+voucher['name'][id_lang]+'</a>');
                });
                pagadoTodoYFaltaPorCambiar = result.order.pagadoTodoYFaltaPorCambiar;
                if(result.order.pagadoTodoYFaltaPorCambiar == 1){
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationWarn').html(pagadoTodoTxt);
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationWarn').slideDown('fast');
                    $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationWarn').delay(6000).slideUp('fast');
                    $(".detallesPedidoAcredito .estadoPedidoDetalle").addClass("alert-warning");
                }else{
                    $(".detallesPedidoAcredito .estadoPedidoDetalle").removeClass("alert-warning");
                }
                $("#"+$.mobile.activePage.attr('id')+ ' .contSelect').html('<select class="status_order_credit" data-native-menu="true" onchange="cambiarEstado('+result.order.id_order+',this.value)">'+selectHtml+'</select>');
                $("#"+$.mobile.activePage.attr('id')+ ' .contSelect select').selectmenu();
                $("#"+$.mobile.activePage.attr('id')+ ' .contSelect select').selectmenu('refresh');
                $('#'+$.mobile.activePage.attr('id')+ ' select[name=empleadoAcredito]').prop('selectedIndex',$('#'+$.mobile.activePage.attr('id')+' select[name=empleadoAcredito] option[value="'+result.order.id_employee+'"]').index()).selectmenu('refresh');
                $('#'+$.mobile.activePage.attr('id')+ ' .nombreCliente').html(result.order.cliente.nombre);
                $('#'+$.mobile.activePage.attr('id')+ ' .direccionFacturacion').html('<p>'+result.order.facturacion.telefono+'</p>'+
                                                                                        '<p>'+result.order.facturacion.address+'</p>'+
                                                                                        '<p>'+result.order.facturacion.cp+' '+result.order.facturacion.city+'</p>');
            }
            if(index == "products"){
                $(".detallesPedidoAcredito .contentproducts").html("");
                $(".detallesPedidoAcredito .contentproducts").html("<h2>"+productosTexto+'</h2><button onclick="anadirProdPedido()" class="ui-btn ui-shadow ui-corner-all ui-btn-icon-notext ui-icon-plus anadirProdPedido"></button>');
                listadoProductosPedido(result);
                //$.each(result.products, function(index, result) {
//                    htmlProds += "<tr class=\"opd_"+result.id_order_detail+"\">";
//                        htmlProds += "<td>"+result.img+"</td>";
//                        htmlProds += "<td class='nameOpd'>"+result.product_name+"</td>";
//                        htmlProds += "<td class='priceOpd'><span class='contPriceOrd'>"+parseFloat(result.product_price_sin_reducciones_wt).toFixed(priceDisplayPrecision)+'</span></td>';
//                        htmlProds += "<td class='descCont'><span class='contDescOrd'>"+result.desc+"</span><span class='contDescType'>"+result.descType+"</span></td>";
//                        htmlProds += "<td class='cantOpd'><span class='unidades'>"+result.product_quantity+"</span>"+
//                                                                (result.precio_unitario != "" ? " x <input type='hidden' class='ratio' value='"+result.unit_price_ratio+"'/><span class='unityAmount'>"+result.precio_unitario+"</span> <span class='unity'>"+result.unity+"</span>" : "<span class='unityAmount'></span> <span class='unity'></span>")+"</td>";
//                        htmlProds += "<td class='totalOpd'>"+result.total_price_tax_incl+"</td>";
//                        htmlProds += "<td class='actionsOpd'>";
//                            htmlProds += '<a class="editOPD" href="#" onclick="modProductoOrder('+id_order+','+result.id_order_detail+')"><i class=\"icon-edit\"></i></a>';
//                            htmlProds += '<a class="deleteOPD" href="#" onclick="if(confirm(\'delete?\')){deleteProductOrder('+id_order+','+result.id_order_detail+',\'aCredito\')}else{event.stopPropagation(); event.defaultPrevented;}"><i class=\"icon-trash\"></i></a>';
//                            htmlProds += '<a class="guardarOPD ui-input-btn ui-btn" onclick="cambioEnPedido('+id_order+','+result.id_order_detail+',\'aCredito\')">'+guardarTxt+'</a>';
//                        htmlProds +="</td>";
//                    htmlProds +='</tr>';
//                });
            }
        });
        html +="<tr id='addPayment_"+id_order+"' class='addPayment'"+(pagadoTodoYFaltaPorCambiar ? "style=\"display:none\"" : '')+">" +
                    "<td></td>" +
                    "<td>"+metodosPagoHtml+"</td>" +
                    "<td><input type='text' size='5' pattern='(^\d*\.?\d*[0-9]+\d*$)|(^[0-9]+\d*\.\d*$)' class='amount ui-btn corner-all ui-shadow'></td>" +
                    "<td><a class='ui-input-btn ui-btn' onclick='anadirPaymentPopup("+id_order+")'>"+anadirPago+"</a></td>" +
                    "<td></td></tr>";
        html += "</tbody></table>";
        $(".detallesPedidoAcredito .contentpayments").html(html);
    });
    actualizarCaja(cajaEnUso);
}


$(document).ready(function() {
    $("#fact_cred").on("click", function(event){
        $.mobile.changePage("#aCredito");
        valorActual = "";
        var altura = $(window).height();

//        $("#aCredito .table-responsive").css('height',(altura)+'px');
        getFacturasCredito();
    });
    mySwiperProductosAcredito = createSwiper('#list-products-aCredito',true,'vertical');
    mySwiperProductosAcredito.on('tap', function(slide,event) {
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
    $(".okAcredito").on("click", function(event){
        listadoPagos = new Array();
        formaPagoInicial = $('#popupAcreditoPrimerPago select.formaPagoInicial').val();
        pagoInicial = $('#popupAcreditoPrimerPago input[name=pagoInicial]').val();
        pagoInicial = pagoInicial.replace(",",".");
        fechaFin = $("#popupAcreditoPrimerPago .fechaFinFact").val();
        $("#popupAcreditoPrimerPago").popup( "close" );
        if(typeof estadoEfectivo != 'undefined' && formaPagoInicial == estadoEfectivo){
            $('#popupPagoEfectivo #pagadoPagoAcreditoButton').html(parseFloat(0).toFixed(priceDisplayPrecision));
            $('#popupPagoEfectivo .aDevolverButton').html(0);
            $("#popupPagoEfectivo input[name=primerPago]").val(1);
            $("#popupPagoEfectivo input[name=id_order]").val('');
            $("#popupPagoEfectivo input[name=formaPago]").val(formaPagoInicial);
            $("#popupPagoEfectivo input[name=amount]").val(pagoInicial);
            $("#popupPagoEfectivo input[name=total]").val(pagoInicial);
            $("#popupPagoEfectivo .pagado").html(0);
            $("#popupPagoEfectivo .restante").html(parseFloat(pagoInicial).toFixed(priceDisplayPrecision));
            $("#popupPagoEfectivo .sobraCont").hide();
            $(".restanteCont").show();
            $('#popupAcredito').popup("close");
            $("#popupPagoEfectivo").popup("open");
            modo="#popupPagoEfectivo";
            $("#popupPagoEfectivo").bind({
               popupafterclose: function(event){modo=0;}
            });
        }else{
            pago();
        }
    });
    $(".okComprobarPagoAcredito").on("click", function(event){
        var aDevolver = $('#'+$.mobile.activePage.attr('id')+' .aDevolverButton').html();
        if(caja_obligatoria == 1 && aDevolver >0 && (dineroEnCaja - aDevolver) < 0)
            avisoCaja();
        else{
            pago();
            $("#popupPagoAcredito .pagado").html(0);
            $("#popupPagoAcredito").popup( "close" );
        }
    });
});