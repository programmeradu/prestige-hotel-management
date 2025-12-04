var anchuraTicket = 300;
var emailSend="";
var settings = {
   output:"css",
   bgColor: "#FFFFFF",
   color: "#000000",
   fontSize: 15,
   barWidth: 2,
   barHeight: 50,
//		   moduleSize: $("#moduleSize").val(),
   posX: 0,
   posY: 0,
   addQuietZone: 0
}

// el segundo parametro hacer que no se muestre el fancybox para el caso de la configuración del módulo que no hay fancbox, con rellenar los datos es suficiente.
function verTicket(data,conf){
    var html = '';
    var htmlRegalo = '';
    var htmlTaxes = '';
    var htmlVales = '';
    var hayDocumentos = 0;
    var classNameTicket = $('.ticket').attr('name');
    var nombre = '';
    var id_order = '';
    var error = 0;
    var contadorTaxes = 0;
    var flagDescuentos = 0;
    var flagDescuentosGroup = 0;
    var flagPrecioUnidad = 0;
    var flagPrecioUnitario = 0;
    var flagPrecioOriginal = 0;
    var id_order_state = 0;
    var nProductos = 0;
    var tipo = 'normal';
    emailSend = '';

    $('.ticket .contFormaPago').hide();
    $('.ticket .fact_simpl').hide();
    $('.ticket .contRefPedido').hide();
    $('.ticket .fechaFin').hide();
    $('.ticket .fechaFinTicket').hide();
    $('.ticket .fechaCompromisoTicket').hide();
    $('.ticket .facturaCreditoTicket').hide();
    $('.ticket .transferenciaTicket').hide();
    $('.ticket .datosCliente').hide();
    $('.ticket .datosCliente .contTel').hide();
    $('.ticket .datosCliente .contExtraCliente').hide();
    $('.ticket .datosCliente .contComentarioTicket').hide();
    $('.ticket .datosCliente .contEmailCliente').hide();
    $('.ticket .datosCliente .contDireccionEnvioTicket').hide();
    $('.ticket .datosCliente .contDireccionEmpresa').hide();
    $('.ticket .columnaDescuentos').hide();
    $('.ticket .columnaUnit').hide();
    $('.ticket .columnaPrecioUnidad').hide();
    $('.ticket .columnaPrecioOriginal').hide();
    $('.ticket .columnaDescuentosGroup').hide();
   //	$('.ticket .columnaProductosTicket').hide();
    $('.ticket table.totalesTicket .envio').hide();
    $('.ticket table.totalesTicket .totalIVA').hide();
    $('.ticket table.totalesTicket [class^=tax_]').hide();
    $('.ticket table.totalesTicket .porcentajeIva').hide();
    $('.ticket table.totalesTicket .totalIvaTicket').hide();
    $('.ticket table.totalesTicket .taxes').remove();
    $('.ticket table.totalesTicket .vale').hide();
    $('.ticket table.totalesAcreditoTicket').hide();
    $('.verFactura').hide();
    $('.advertencia .tCredito').hide();
    $('.advertencia #cheque').hide();
    $('.advertencia #tBancaria').hide();
    $('.advertencia #devolucionesTipo').hide();
    $('.advertencia .documentosAfirmar').remove();
    $('.ticket .tituloTicket').show();
    $('.ticket .tituloTicket2').hide();
    $('.ticket .messageOrderTicket').hide();
    $('.ticket .messageOrderContent').html("");
    $(".codBarTicket").hide();   
    $(".codBarTicketRef").hide();
    $(".codBarTicketPago").hide();
    $('.ticket .logo').show();
    $(".textoParteInferior").show();
    if(generaTicket == 1)
        $('.okGenNumTicket').show();
    else
        $('.okGenNumTicket').hide();
    $('.okGenFactura').show();
    $('.verAlbaran').hide();
    $('.ticket .leAtendioTicket').hide();
    $('.ticket .totalIvaTicket').show();
    $('.ticket .direccionWeb').show();
    $('.ticket .eet').hide();
    $('.noHayFactura').hide();
    $('.ticket .devolucionOrigen').hide();
    $('.facturaCheck').hide();
    $('.ticket .puntosContent').hide();
    $('.ticket .contDescuentos').hide();
    $('.ticket .contDescuentosVales').hide();
    $('.ticket .contSurchage').hide();
    $('.ticket .contDescuentosGroup').hide();
    $('.ticket table.totalesTicket .contPagadoTicket').hide();
    $('.ticket table.totalesTicket .contTicketDevuelto').hide();
    $('.checkoutButton').addClass("ui-state-disabled");
    $(".docFirmados").hide();
    $('.ticket .pagosRealizados').hide();
    $('.ticket .contPagosTicket').hide();
    $('.ticket .contPagosTicket table tbody').html("");
    $('.ticket .respuestaDatafono').hide();
    if(data != null){
        $.each(data, function(index, result) {
            if(typeof result.current === 'number'){
                id_order = result.current;
                 //actualizo los pedidos en el avisador para que no no avise de pedido nuevo en la misma ventana que acabo de generarlo
            //    if(avisadorPedidos == 1 && typeof arrayPedidos != "undefined" && $.inArray(id_order,arrayPedidos) == -1){
//                    arrayPedidos.shift();
//                    arrayPedidos.push(id_order);
//                    semaforoAvisadorPedidos = 0;
//                }
                semaforoAvisadorPedidos = id_order;
                id_order_global = result.current;
                $('.id_order').val(id_order);
               //	$('.advertencia #confPedido #verPedido').show();
                $('.verPedido').show();
                $('.verPedido').attr("href", $("#urlBackoffice").val()+"/index.php?controller=AdminOrders&id_order="+id_order+"&vieworder&token="+$('#tokenLiteOrders').val());
                $('.verFactura').attr("href", $("#urlBackoffice").val()+"/index.php?controller=AdminPDF&submitAction=generateInvoicePDF&id_order="+id_order+"&token="+$('#tokenLitePDF').val());
            }
            if(result.error != null){
                error=1;
                mostrarError(result.error);
            }
            if(typeof result.nombre === 'string'){
                nombre = result.nombre;
            }
            if(typeof result.respuestaDatafono ==='object' && result.respuestaDatafono != null){
                devolucionPago(result.respuestaDatafono.importe,JSON.parse(result.respuestaDatafono.respuesta));
            }
            if(typeof result.eligeAbono ==='object' && result.eligeAbono != null){
                $("#popupElegirAbono").popup( "open");
                $("#popupElegirAbono").bind({
                    popupafterclose: function(event){
                        flagCambioEmpleadoAlFinalizarPedido = 1;
                        $.mobile.changePage("#popupEmpleados");}
                });
                $.each(result.eligeAbono, function(index, pago) {
                    if(index == 'totalDevolucionesConIva')
                        totalDevolucionesConIva = pago;
                    if(index == 'totalDevolucionesSinIva')
                        totalDevolucionesSinIva = pago;
                    if(index == 'order' && pago != null)
                        id_order_global = pago.id;
                });
            }
            if(typeof result.email === 'string'){
                emailSend = result.email;
                $('.emailSend').val(emailSend);
            }
            if(typeof result.documentos ==='object' && result.documentos != null){
                hayDocumentos = 1;
                if(typeof result.documentos.delivery ==='object'){
                    $('.verAlbaran').show();
                    $('.verAlbaran').attr("href", $("#urlBackoffice").val()+"/index.php?controller=AdminPDF&submitAction=generateDeliverySlipPDF&id_order="+id_order+"&token="+$('#tokenLitePDF').val());
                }
            }
            if(result.fPago == 'tcredito'){
                $("#"+$.mobile.activePage.attr('id')+' .advertencia .tCredito').show();
            }
            if(result.descTPV != null){
                $(".ticketnormal .codBarTicket").show();
                $(".ticketnormal .codBarTicket .textoCodebar").html(result.descTPV.textoCodebar);
                $(".ticketnormal .codBarTicket .contCodebar").barcode(result.descTPV.codebar, "code93", settings);
               // $(".codBarTicket .caducaCodebar").html(result.descTPV.caduca);
            }
            if(result.eet != null){
                $('.ticket .eet').html(result.eet);
                $('.ticket .eet').show();
            }
            if(result.fPago == 'cheque'){
                $('.advertencia #cheque').show();
                $('.advertencia #cheque #fechaCheque').datepicker({
                    dateFormat : 'yy/mm/dd',
                    changeMonth: true,
                    changeYear: true,
                });
                if(heightFondo > 500)
                    $('.advertencia #cheque #numeroCheque').focus();
            }
            if(result.fPago == 'tBancaria'){
                $('.advertencia #tBancaria').show();
            }
            if(result.formaPago != null && mostrar_forma_pago !== 0){
                $('.ticket .formaPagoTicket span').html(result.formaPago);
                $('span.formaPagoWarning').html(result.formaPago);
              //   $('.ticket .tituloTicket2').html(result.formaPago);
                $("#devolverEnCaja span").html(result.formaPago);
                devolverEnTxt2 = devolverEnTxt+result.formaPago;
                $('.ticket .contFormaPago').show();
                if(result.fechaFin != null){
                    $('.ticket .fechaFin span').html(result.formaPago);
                    $('.ticket .contFormaPago').show();
                }
            }
            if(result.qrPago != null){
                $(".codBarTicketPago").show();
                var settings2 = settings;
                settings2['fontSize'] = 0;
                if(pantalla == 1)
                    pQR(result.qrPago);
                $(".codBarTicketPago .contCodebar").barcode(result.qrPago, "datamatrix", settings2);
            }
            if(result.tbai != null){
                $(".codBarTicketQR").show();
                $(".codBarTicketQR .contCodebar").html('<a href="'+result.tbai.urlConsulta+'" target="_blank"><img src="'+result.tbai.filename+'" width="100"></a>');
                $(".codBarTicketQR .textoCodebar").html(result.tbai.code);
                enviarComunicacionHacienda(id_order,1);
            }
            if(result.vfactu != null){
                $(".codBarTicketQR").show();
                $(".codBarTicketQR .contCodebar").html('<a href="'+result.tbai.urlConsulta+'" target="_blank"><img src="'+result.vfactu.filename+'" width="100"></a>');
                $(".codBarTicketQR .textoCodebar").html(result.vfactu.code);
                enviarComunicacionHacienda(id_order,1);
            }
            if(result.orderState != null)
                id_order_state = result.orderState;
            if(result.date != null){
                $('.ticket .dateTicket').html(result.date);
            }
            if(result.fechaFin != null){
                $('.ticket table.totalesAcreditoTicket').show();
                $('.ticket .fechaFinTicket span').html(result.fechaFin);
                $('.ticket .fechaFinTicket').show();
            }
            if(result.fechaCompromiso != null){
                $('.ticket table.totalesAcreditoTicket').show();
                $('.ticket .fechaCompromisoTicket span').html(result.fechaCompromiso);
                $('.ticket .fechaCompromisoTicket').show();
            }
        	if(result.totalPagadoTicket != null){
                $('.ticket .facturaCreditoTicket .totalPagadoTicket').html(result.totalPagadoTicket);
                $('.ticket .facturaCreditoTicket').show();
                tipo = 'pago';
            }
            if(result.datosBancarios != null){
                $('.ticket'+tipo+' .transferenciaTicket .datosBancariosTicket').html(result.datosBancarios);
                $('.ticket'+tipo+' .transferenciaTicket').show();
            }
            if(typeof result.pagos ==='object' && result.pagos != null){
                $('.ticket table.totalesAcreditoTicket').show();
                $('.ticket .pagosRealizados').css('display','table-row');
                $('.ticket .contPagosTicket').show();
                $.each(result.pagos, function(index, pago) {
                    var fechaPago = pago.date_add.substr(0,10);
                    $('.contPagosTicket table tbody').append('<tr><td>'+fechaPago+'</td><td>'+pago.payment_method+'</td><td class="rightTicket">'+formatCurrency(parseFloat(pago.amount), currencyFormat, currencySign, currencyBlank)+'</td>');
                });
            }

            if(typeof result.totales === 'object' && result.totales != null){
                if(result.totales.respuestaDatafono != null){
                    $('.ticket .respuestaDatafono').html(result.totales.respuestaDatafono);
                    $('.ticket .respuestaDatafono').show();
                }
                if(typeof result.totales.cambio === 'object' && result.totales.cambio != null){
                    $('.ticket table.totalesTicket .pagadoTicket span').html(result.totales.cambio.pagado);
                    $('.ticket table.totalesTicket .contPagadoTicket').show();
                    $('.ticket table.totalesTicket .pagadoTicket span').show();
                    $('.ticket table.totalesTicket .devueltoTicket span').html(result.totales.cambio.devuelto);
                    $('.ticket table.totalesTicket .contTicketDevuelto').show();
                    $('.ticket table.totalesTicket .devueltoTicket span').show();
                }
                $('.ticket table.totalesTicket .totalTicket span').html(result.totales.total);
           //     if(result.totales.totalRaw < 0){
//                    $('.advertencia #devolucionesTipo').show();
//                    $("#devolucionesTipo #ya_creada_devolucion").val('0');
//                    $("#devolucionesTipo .crearVale").hide();
//                    $("#devolucionesTipo .verVale").show();
//                    $('.advertencia #devolucionesTipo #amount_devolucion').val(Math.abs(result.totales.totalRaw));
//                }

                $('.ticket table.totalesTicket .baseTicket span').html(result.totales.base);
                if(result.totales.ref != null){
                    $('.ticket .refPedido').html(result.totales.ref);
                    $('.ticket .contRefPedido').show();
                }
                if(codBarTicket == 1 && result.totales.ref != null){
                    $(".codBarTicketRef .contCodebar").barcode(result.totales.ref, "code93", settings);
                    $(".codBarTicketRef").show();
                }
                if(result.totales.envio != null){
                    $('.ticket .envioTicket span').html(result.totales.envio);
                    $('.ticket .envio').show();
                }
                if(result.totales.descuentos != null && result.totales.descuentos != ""){
                    $('.ticket .contDescuentos span').html(result.totales.descuentos);
                    $('.ticket .contDescuentos').show();
                }
                if(result.totales.descuentosGroup != null){
                    $('.ticket .contDescuentosGroup span.nombreCustomerGroup').html(result.totales.customerGroup);
                    $('.ticket .contDescuentosGroup .descuentosGroupTicket span').html(result.totales.descuentosGroup);
                    $('.ticket .contDescuentosGroup').show();
                }
                if(result.totales.surchage != null){
                    $('.ticket .contSurchage span').html(result.totales.surchage);
                    $('.ticket .contSurchage').show();
                }
                if(result.totales.tax != null && tax == 1){
                    $.each(result.totales.tax ,function (key, item){
                        if(contadorTaxes >= 0){
                            $('.ticket table.totalesTicket .tax_0').show();
                            htmlTaxes = $('.ticket table.totalesTicket .tax_0').html();
                            if(contadorTaxes >= 1)
                                $('.ticket table.totalesTicket .tax_'+(contadorTaxes-1)).after('<tr class="taxes tax_'+contadorTaxes+'">'+htmlTaxes+'</tr>');
                            $('.ticket table.totalesTicket .tax_'+contadorTaxes+' .porcentajeIva span:not(.nombreImpuestoTicket)').html(item.rate+"%");
                            $('.ticket table.totalesTicket .tax_'+contadorTaxes+' .nombreImpuestoTicket').html(item.name);
                            $('.ticket table.totalesTicket .tax_'+contadorTaxes+' .totalIvaTicket span').html(item.amount);
                        }
                        contadorTaxes++;
                    });
                }
                if(result.totales.totalIva != null){
                    $('.ticket table.totalesTicket .porcentajeIva').show();
                    $('.ticket table.totalesTicket .totalIVA .totalIvaTicket span').html(result.totales.totalIva);
                }
            }

            if(typeof result.cartRules ==='object' && result.cartRules != null){
                $('.ticket .contDescuentosVales').show();
                $('.ticket .contDescuentosVales span').html("");
                $(result.cartRules ).each(function (key, item){
                    $('.ticket .contDescuentosVales span').append("<b>"+item.code+"</b> "+item.value+"<br>");
                });
            }
            if(result.valesNuevos != null){
                $('.advertencia #devolucionesTipo').show();
                $("#devolucionesTipo #ya_creada_devolucion").val('1');
                $("#devolucionesTipo #id_descuento_devolucion").val(result.valesNuevos.id);
                $("#devolucionesTipo .crearVale").hide();
                $("#devolucionesTipo .verVale").show();
                $('.ticket table.totalesTicket .vale').show();
                $('.ticket table.totalesTicket .vale .amountTicket span').html(result.valesNuevos.code+" ("+result.valesNuevos.value+")");
            }
            if(result.customer != null){
                datosClienteTicket(result);
            }
            if(result.emp != null){
                $('.ticket .leAtendioTicket span').html(result.emp);
                $('.ticket .leAtendioTicket').show();
            }
            if(result.messageOrder != null){
                $('.ticket .messageOrderTicket').show();
                $('.ticket .messageOrderContent').html(result.messageOrder);
            }
            if(mostrar_puntos == 1 && result.puntos != null){
                $('.ticket .puntosContent').show();
                $('.ticket .puntoFid').html(result.puntos);
            }
            if(result.valor != null){
                $('.ticket .puntosContent').show();
                $('.ticket .dineroFid').html("("+result.valor+")");
            }
            if(result.nFact != null){
                $('.okGenFactura').hide();
                $('.verFactura').show();
            }
            if(result.faltaPorPagar != null){
                $('.ticket table.totalesAcreditoTicket').show();
                $(".faltaTicket span").html(result.faltaPorPagar);
            }
            if(result.textoExtra != null){
                $('.ticket .textoParteInferiorExtra').html(result.textoExtra);
            }
            if(result.nTicket != null){
                if(num_ticket == 1 || num_ticket == 2){
                    $('.ticket .fact_simpl span').html(result.nTicket);
                    $('.ticket .fact_simpl').show();
                }
                if(num_ticket == 0){
                    $('.ticket .fact_simpl span').html(result.nTicket);
                    $('.ticket .fact_simpl').show();
                }
                if(num_ticket == 3){
                    $('.ticket .fact_simpl span').html(result.nTicket);
                    $('.ticket .fact_simpl').show();
                }
            }
            if(result.nuevaDevolucion != null){
                $('.ticket .devolucionOrigen').show();
                $('.ticket .devolucionOrigen').html(result.nuevaDevolucion);
                $('.verPedido').hide();
                $('.okGenFactura').hide();
                $('.okGenFactura').hide();
            }
            if(index == 'products' && typeof result == 'object' && result != null){
                $.each(result, function(index, producto) {
                    html+='<tr>';
                    htmlRegalo+='<tr class="lineaRegalo">';
                    if(typeof producto.n != 'undefined' || conf){
                        html+='<td width="1%" class=" center columnaNumeracionProducto">'+producto.n+'</td>';
                        htmlRegalo+='<td width="1%" class=" center columnaNumeracionProducto">'+producto.n+'</td>';
                    }
                    html+='<td width="48%" class="columnaProductosTicket columnaNombreArticulo">'+producto.name;
                    htmlRegalo+='<td width="48%" class="columnaProductosTicket columnaNombreArticulo">'+producto.name;
                    if(typeof producto.ref != 'undefined' && producto.ref != '' || conf){
                        html+='<p class="refticketprod">ref. '+producto.ref + '</p>';
                        htmlRegalo+='<span>ref. ' + producto.ref + '</span>';
                    }
                    html+='</td><td width="13%" class="center columnaProductosTicket">'+producto.q+'</td>';
                    htmlRegalo+='</td><td width="13%" class="center columnaProductosTicket">'+producto.q+'</td><td class="borrarLinea borrarLinea_'+nProductos+'" onclick="borrarLinea('+nProductos+')"><i class="icon-trash"></i></td>';
                    if(colUnitariaEnTicket == 1){
                        if(producto.priceUnit != null || producto.priceUnit != '' || conf){
                            flagPrecioUnitario = 1;
                            html+='<td width="13%" class="columnaUnit center columnaProductosTicket">'+producto.priceUnit+'</td>';
                        }else
                            html+='<td width="13%" class="columnaUnit center columnaProductosTicket"></td>';
                    }
                    if(colPrecioUnidad == 1 || conf){
                        if(typeof producto.p_unidad != 'undefined'){
                            flagPrecioUnidad = 1;
                            $('.ticket'+tipo+' .columnaPrecioUnidad').show();
                            html+='<td width="13%" class="center columnaPrecioUnidad columnaProductosTicket">'+producto.p_unidad+'</td>';
                        }else{
                            html+='<td width="13%" class="center columnaPrecioUnidad columnaProductosTicket"></td>';
                        }
                    }
                    if(colPrecioOriginal == 1 || conf){
                        if(typeof producto.p_orig != 'undefined'){
                            flagPrecioOriginal = 1;
                            $('.ticket'+tipo+' .columnaPrecioOriginal').show();
                            html+='<td width="13%" class="center columnaPrecioOriginal columnaProductosTicket">'+producto.p_orig+'</td>';
                        }else{
                            html+='<td width="13%" class="center columnaPrecioOriginal columnaProductosTicket"></td>';
                        }
                    }
                    if(typeof producto.desc != 'undefined'|| conf){
                        flagDescuentos = 1;
                        $('.ticket'+tipo+' .columnaDescuentos').show();
                        if(descEnTicket == 1)
                            html+='<td width="13%" class="center columnaDescuentos columnaProductosTicket">'+producto.desc+'</td>';
                        if(descEnTicketRegalo == 1){
                            $('.ticketregalo .columnaDescuentos').show();
                            htmlRegalo+='<td width="28%" class="center columnaDescuentos columnaProductosTicket">'+producto.desc+'</td>';
                        }
                        htmlRegalo+='</tr>';
                    }else if(descEnTicket == 1){
                        html+='<td width="13%" class="center columnaDescuentos columnaProductosTicket"></td>';
                    }

                    if(typeof producto.descGroup != 'undefined' || conf){
                        flagDescuentosGroup = 1;
                        $('.ticket'+tipo+' .columnaDescuentosGroup').show();
                        html+='<td width="13%" class="center columnaDescuentosGroup columnaProductosTicket">'+producto.descGroup+'</td>';
                    }else{
                        html+='<td width="13%" class="center columnaDescuentosGroup columnaProductosTicket"></td>';
                    }
                    html+='<td width="28%" class="rightTicket columnaProductosTicket columnaPrecioProd">'+producto.price+'</td></tr>';
                    if(typeof producto.cust != 'undefined'){
                        html+=producto.cust.text;
                    }
                    nProductos++;
                });
            }
            if(typeof result.descuentosListado ==='object' && result.descuentosListado != null){
                $(result.descuentosListado ).each(function (key, item){
                    html+='<tr><td width="48%" class="center columnaProductosTicket">'+item.name+" "+item.code;
                    html+='</td><td width="13%" class="center columnaProductosTicket">-'+item.q+'</td><td width="28%" class="center columnaProductosTicket columnaPrecioProd">-'+item.price+'</td></tr>';
                });
            }
        });

    }else{
        error = 1;
    }
    $('.ticket table.productosTicket tbody').html(html);
    $('.ticketregalo table.productosTicket tbody').html(htmlRegalo);
    if(hayDocumentos == 1){
        actualizarDocumentosFirmados();
    }
    if(albaran == 1 && estadoAlbaran == id_order_state){
        $('.ticket .tituloTicket').hide();
       // $('.ticket .tituloTicket2').html();
//        $('.ticket .tituloTicket2').show();
        $('.ticket .logo').hide();
        $('.ticket .leAtendioTicket').hide();
        $('.ticket .totalIvaTicket').hide();
        $('.ticket .direccionWeb').hide();
    }
    if(flagDescuentos == 0)
        $('.columnaDescuentos').hide();
    if(flagDescuentosGroup == 0)
        $('.columnaDescuentosGroup').hide();
    if(flagPrecioUnidad == 0)
        $('.columnaPrecioUnidad').hide();
    if(flagPrecioUnitario == 1)
        $('.columnaUnit').show();
   else
        $('.columnaUnit').hide();
    if(flagPrecioOriginal == 0)
        $('.columnaPrecioOriginal').hide();
   if(tax==1 && contadorTaxes > 1){
        $('.ticket table.totalesTicket .porcentajeIva').show();
        if(contadorTaxes > 1){
            $('.ticket table.totalesTicket .totalIvaTicket').show();
            $('.ticket table.totalesTicket .totalIVA').show();
        }
    }else if(tax==1 && contadorTaxes == 1){
        $('.ticket table.totalesTicket .tax_0').show();
        $('.ticket table.totalesTicket .totalIVA').hide();
    //al clicar en el botón de ticket normal, lo muestra
    }
    return error;
}
function datosClienteTicket(result){
    if(dirEnTicketCliente){
        $('.ticket .datosCliente').show();
        $('.ticket .datosCliente .nombreCliente').html(result.customer.name);
        $('.ticket .datosCliente .direccionCliente').html(result.customer.address);
        $('.ticket .datosCliente .dniCliente').html(result.customer.dni);
        if(result.customer.phone != null){
             $('.ticket .datosCliente .contTel').show();
             $('.ticket .datosCliente .phoneCliente').html(result.customer.phone);
        }
        if(result.customer.addressEnvio != null){
            $('.ticket .datosCliente .contDireccionEnvioTicket').show();
            $(".ticket .datosCliente .direccionEnvioCliente").html(result.customer.addressEnvio);
        }
        if(result.customer.nombreEmpresa != null){
            if(result.customer.nombreEmpresa != "" && result.customer.nIVAEmpresa != ""){
                $('.ticket .datosCliente .contDireccionEmpresa').show();
                $(".ticket .datosCliente .direccionNombreEmpresa").html(result.customer.nombreEmpresa);
                $(".ticket .datosCliente .direccionNumeroIVAEmpresa").html(result.customer.nIVAEmpresa);
            }
        }
        if(result.customer.comentario != null){
            $('.ticket .datosCliente .contComentarioTicket').show();
            $(".ticket .datosCliente .comentarioCliente").html(result.customer.comentario);
        }
        if(result.customer.extra_field != null){
            $('.ticket .datosCliente .contExtraCliente').show();
            $(".ticket .datosCliente .extraCliente").html(result.customer.extra_field);
        }
        if(result.customer.email != null){
            $('.ticket .datosCliente .contEmailTicket').show();
            $(".ticket .datosCliente .EmailCliente").html(result.customer.email);
        }
    }else{
        $('.ticket .datosCliente').hide();
    }
}
function borrarLinea(idLinea){
    $('.borrarLinea_'+idLinea).parent().slideUp();
}
function verTicketPayment(data){
    $.each(data, function(index, result) {
        if(typeof result.current === 'number'){
            id_order = result.current;
            semaforoAvisadorPedidos = id_order;
            id_order_global = result.current;
            $('.id_order').val(id_order);
            getTicketPayment(id_order,"", false);
        }
    });
}
function getTicketPayment(id_order,id_order_payment,imprimirTicket){
    var html = '';
    var htmlTaxes = '';
    var htmlRegalo = '';
    var nProductos = 0;
    var contadorTaxes = 0;
    var flagDescuentos = 0;
    var tipo = "pago";
    $('.ticket .fact_simpl').hide();
    $('.ticket .facturaCreditoTicket').show();
    $(".loaderTicket").show();
    $('.ticketpago .columnaDescuentos').hide();
    $('.ticketpago .columnaUnit').hide();
    $('.ticket .datosCliente').hide();
    $('.ticket .datosCliente .contTel').hide();
    $('.ticket .datosCliente .contExtraCliente').hide();
    $('.ticket .datosCliente .contComentarioTicket').hide();
    $('.ticket .datosCliente .contEmailCliente').hide();
    $('.ticket .datosCliente .contDireccionEnvioTicket').hide();
    $('.ticket .datosCliente .contDireccionEmpresa').hide();
    $('.ticket .contFormaPago').hide();
    $('.ticket table.totalesTicket .envio').hide();
    $('.ticket table.totalesTicket .totalIVA').hide();
    $('.ticket table.totalesTicket [class^=tax_]').hide();
    $('.ticket table.totalesTicket .porcentajeIva').hide();
    $('.ticket table.totalesTicket .totalIvaTicket').hide();
    $('.ticket .contDescuentosVales').hide();
    $('.ticket .totalIvaTicket').show();
    $(".textoParteInferior").show();
    $('.ticket .messageOrderContent').html("");
    $('.ticket table.totalesTicket .taxes').remove();
    $('.ticket table.totalesTicket .vale').hide();
    $('.ticket .contDescuentos').hide();
    $(".codBarTicketRef").hide();
    $('.ticket .contDescuentosGroup').hide();
    $('.ticket .pagosRealizados').hide();
    $('.ticket .contPagosTicket').hide();
    $('.ticket .contPagosTicket table tbody').html("");
    if($("#currencyPOS").val() != undefined)
        var currPOS = $("#currencyPOS").val();
    else
        var currPOS = id_currency;
    $.getJSON(PosBaseAdminDir+"../modules/tpvtienda/classes/actions/actionsOrdersAlert.php",{token:token_admin_orders, action:'getOrderPayment', id_shop: id_shop,fecha:fecha,id_order: id_order,
        id_order_payment:id_order_payment,id_currency: currPOS,id_lang:id_lang,id_employee: id_employee},function(data) {
            if(data != null){
                $.each(data, function(index, result) {
                    if(result.ref != null)
                        $(".refPedido").html(result.ref);
                    if(result.cantidad != null)
                        $(".pagadoTicket span").html(result.cantidad);
                    if(result.pagado != null)
                        $(".pagadoTicket span").html(result.pagado);
                    if(result.faltaPorPagar != null)
                        $(".faltaTicket span").html(result.faltaPorPagar);
                    if(result.totalPagadoTicket != null)
                        $(".totalPagadoTicket ").html(result.totalPagadoTicket);
                    if(result.devuelto != null)
                        $(".devueltoTicket span").html(result.devuelto);
                    if(result.fecha != null)
                        $(".ticket .dateTicket").html(result.fecha);
                    if(result.total != null)
                        $(".totalTicket span").html(result.total);
                    if(result.customer != null)
                        datosClienteTicket(result);
                    if(result.formaPago != null && mostrar_forma_pago !== 0){
                        $('.ticket .formaPagoTicket span').html(result.formaPago);
                        $('span.formaPagoWarning').html(result.formaPago);
                      //   $('.ticket .tituloTicket2').html(result.formaPago);
                        $('.ticket .contFormaPago').show();
                        if(result.fechaFin != null){
                            $('.ticket #fechaFin span').html(result.formaPago);
                            $('.ticket .contFormaPago').show();
                        }
                    }
                    if(typeof result.pagos ==='object' && result.pagos != null){
                        $('.ticket .pagosRealizados').css('display','table-row');
                        $('.ticket .contPagosTicket').show();
                        $.each(result.pagos, function(index, pago) {
                            var fechaPago = pago.date_add.substr(0,10);
                            $('.contPagosTicket table tbody').append('<tr><td>'+fechaPago+'</td><td>'+pago.payment_method+'</td><td class="rightTicket">'+formatCurrency(parseFloat(pago.amount), currencyFormat, currencySign, currencyBlank)+'</td>');
                        });
                    }
                    if(index == 'products' && typeof result == 'object' && result != null){
                        $.each(result, function(index, producto) {
                            html+='<tr>';
                            htmlRegalo+='<tr class="lineaRegalo">';
                            if(typeof producto.n != 'undefined' && producto.n != ''){
                                html+='<td width="1%">'+producto.n+'</td>';
                                htmlRegalo+='<td width="1%">'+producto.n+'</td>';
                            }
                            html+='<td width="48%">'+producto.name;
                            htmlRegalo+='<td width="48%">'+producto.name;
                            if(typeof producto.ref != 'undefined' && producto.ref != ''){
                                html+='<br>ref. '+producto.ref;
                                htmlRegalo+='<br>ref. '+producto.ref;
                            }
                            html+='</td><td width="13%" class="center">'+producto.q+'</td>';
                            htmlRegalo+='</td><td width="13%" class="center">'+producto.q+'</td><td class="borrarLinea borrarLinea_'+nProductos+'" onclick="borrarLinea('+nProductos+')"><i class="icon-trash"></i></td>';
                            if(colUnitariaEnTicket == 1 && producto.priceUnit != null){
                                $('.ticket .columnaUnit').show();
                                if(producto.priceUnit != '')
                                    html+='<td width="13%" class="columnaUnit center">'+producto.priceUnit+'</td>';
                                else
                                    html+='<td width="13%" class="columnaUnit center"></td>';
                            }
                            if(colPrecioUnidad == 1){
                                if(typeof producto.p_unidad != 'undefined'){
                                    flagPrecioUnidad = 1;
                                    $('.ticket'+tipo+' .columnaPrecioUnidad').show();
                                    html+='<td width="13%" class="center columnaPrecioUnidad">'+producto.p_unidad+'</td>';
                                }else{
                                    html+='<td width="13%" class="center columnaPrecioUnidad"></td>';
                                }
                            }
                            if(colPrecioOriginal == 1){
                                if(typeof producto.p_orig != 'undefined'){
                                    flagPrecioOriginal = 1;
                                    $('.ticket'+tipo+' .columnaPrecioOriginal').show();
                                    html+='<td width="13%" class="center columnaPrecioOriginal">'+producto.p_orig+'</td>';
                                }else{
                                    html+='<td width="13%" class="center columnaPrecioOriginal"></td>';
                                }
                            }
                            if(typeof producto.desc != 'undefined'){
                                flagDescuentos = 1;
                                $('.ticket'+tipo+' .columnaDescuentos').show();
                                if(descEnTicket == 1)
                                    html+='<td width="13%" class="center columnaDescuentos">'+producto.desc+'</td>';
                                if(descEnTicketRegalo == 1){
                                    $('.ticketregalo .columnaDescuentos').show();
                                    htmlRegalo+='<td width="28%" class="center columnaDescuentos">'+producto.desc+'</td>';
                                }
                                htmlRegalo+='</tr>';
                            }else if(descEnTicket == 1){
                                html+='<td width="13%" class="center columnaDescuentos"></td>';
                            }
                            if(typeof producto.descGroup != 'undefined'){
                                flagDescuentosGroup = 1;
                                $('.ticket'+tipo+' .columnaDescuentosGroup').show();
                                html+='<td width="13%" class="center columnaDescuentosGroup columnaProductosTicket">'+producto.descGroup+'</td>';
                            }else{
                                html+='<td width="13%" class="center columnaDescuentosGroup columnaProductosTicket"></td>';
                            }
                            html+='<td width="28%" class="rightTicket columnaProductosTicket columnaPrecioProd">'+producto.price+'</td></tr>';
                            if(typeof producto.cust != 'undefined'){
                                html+=producto.cust.text;
                            }
                            nProductos++;
                        });
                    }
                    if(result.messageOrder != null){
                        $('.ticket .messageOrderTicket').show();
                        $('.ticket .messageOrderContent').html(result.messageOrder);
                    }
                    if(typeof result.totales === 'object' && result.totales != null){
                        $('.ticket table.totalesTicket .totalTicket span').html(result.totales.total);
                        if(result.totales.totalIva != null){
                            $('.ticket table.totalesTicket .porcentajeIva').show();
                            $('.ticket table.totalesTicket .totalIVA .totalIvaTicket span').html(result.totales.totalIva);
                        }
                        $('.ticket table.totalesTicket .baseTicket span').html(result.totales.base);
                        $('.ticket .refPedido').html(result.totales.ref);
                        if(codBarTicket == 1){
                            $(".codBarTicketRef .contCodebar").barcode(result.totales.ref, "code93", settings);
                            $(".codBarTicketRef").show();
                        }
                        if(result.totales.envio != null){
                            $('.ticket .envioTicket span').html(result.totales.envio);
                            $('.ticket .envio').show();
                        }
                        if(result.totales.descuentos != null && result.totales.descuentos != ""){
                            $('.ticket .contDescuentos span').html(result.totales.descuentos);
                            $('.ticket .contDescuentos').show();
                        }
                        if(result.totales.descuentosGroup != null){
                            $('.ticket .contDescuentosGroup .descuentosGroupTicket').html(result.totales.descuentosGroup);
                            $('.ticket .contDescuentosGroup span').html(result.totales.customerGroup);
                            $('.ticket .contDescuentosGroup').show();
                        }

                        if(result.totales.tax != null && tax == 1){
                            $.each(result.totales.tax ,function (key, item){
                                if(contadorTaxes >= 0){
                                    $('.ticket table.totalesTicket .tax_0').show();
                                    htmlTaxes = $('.ticket table.totalesTicket .tax_0').html();
                                    if(contadorTaxes >= 1)
                                        $('.ticket table.totalesTicket .tax_'+(contadorTaxes-1)).after('<tr class="taxes tax_'+contadorTaxes+'">'+htmlTaxes+'</tr>');
                                    $('.ticket table.totalesTicket .tax_'+contadorTaxes+' .porcentajeIva span:not(.nombreImpuestoTicket)').html(item.rate+"%");
                                    $('.ticket table.totalesTicket .tax_'+contadorTaxes+' .totalIvaTicket span').html(item.amount);
                                }
                                contadorTaxes++;
                            });
                        }
                    }
                });

                $('.ticketpago table.productosTicket tbody').html(html);
                if(imprimirTicket){
                    $.fancybox({
                        'type': 'html',
                        'content' : 	$(".ContTicketpago").html(),
                        'autoSize'    : true,
                        'autoHeight'  : true,
                        'maxWidth'		: anchuraTicket,
                        'afterShow':  function(){
                            afterShowTickets('pago');
                            $(".loaderTicket").hide();
                            if(flagDescuentos == 0)
                                $('.ticketpago .columnaDescuentos').hide();
                            if(autoprint_ticket != null && autoprint_ticket == 1)
                                $('.fancybox-outer .ticketPrint').trigger("click");
                        },
                        'afterClose':  function(){
    //						$( "#popupAcredito").popup( "open");
    //						getFacturasCredito();
                        }
                    });
                }
            }
    });
}
function reTicket(sigPrevActual,id_order){
    if(sigPrevActual == null)
        sigPrevActual = 'actual';
    if(id_order == null)
        id_order = $('.id_order').val();
    $(".loaderTicket").show();
    if($("#currencyPOS").val() != undefined)
        var currPOS = $("#currencyPOS").val();
    else
        var currPOS = id_currency;

    $.getJSON(PosBaseAdminDir+"../modules/tpvtienda/classes/actions/actionsConf.php",{token:token_admin_orders, action:'reticket',id_order:id_order,id_shop:id_shop,sigPrevActual: sigPrevActual,
        id_employee: id_employee,id_currency:currPOS,id_lang:$("#id_lang").val()},function(data) {

        mostrarTicket('normal');
        error = verTicket(data);
        //con esto evito que aunque este el autoprint se lance
        $.each(data, function(index, result) {
            if(result.error != null)
                mostrarError(result.error);
            if(typeof result.current != 'undefined'){
                if(sigPrevActual == 'sigOrder')
                    $('.id_order').val(result.current);
                if(sigPrevActual == 'prevOrder')
                    $('.id_order').val(result.current);
            }
        });
        $(".loaderTicket").hide();
    });
}
function verDevolucionTicket(id_order){
    $(".loaderTicket").show();
    if($("#currencyPOS").val() != undefined)
        var currPOS = $("#currencyPOS").val();
    else
        var currPOS = id_currency;
    $.getJSON(PosBaseAdminDir+"../modules/tpvtienda/classes/actions/actionsConf.php",{token:token_admin_orders, action:'reticketDevolucion',id_order:id_order,id_shop:id_shop,
        id_employee: id_employee,id_lang:$("#id_lang").val(),id_currency: currPOS},function(data) {
        error = verTicket(data);
        mostrarTicket('normal');
        $.each(data, function(index, result) {
            if(result.error != null)
                mostrarError(result.error);
        });
        $(".loaderTicket").hide();
    });
}

function generarTicket(){
    if($("#currencyPOS").val() != undefined)
        var currPOS = $("#currencyPOS").val();
    else
        var currPOS = id_currency;
    $.getJSON(PosBaseAdminDir+"../modules/tpvtienda/classes/actions/actionsPedido.php",{token:token_admin_orders, action:'generaTicket',id_order:id_order_global,id_shop:id_shop,
        id_employee: id_employee,id_lang:$("#id_lang").val(),id_cart:$("#id_cart").val(),id_currency: currPOS},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(typeof result.number != 'undefined'){
                    if(typeof $.mobile != "undefined" && $.mobile.activePage.attr('id') == "pedidoPage"){
                        $("#pedidoPage .contButtonTicket").html('<a class="getticket ui-btn ui-corner-all ui-shadow ui-btn-inline" onclick="reTicket(\'actual\','+id_order_global+')">'+result.number+'</a>');
                        $('#botonGenerarTicket').hide();
                    }else{
                        $('#ticketPedidos .nTicket span').html(result.number);
                        $('.fctTicket h4 span').html(result.number);
                        $('#botonGenerarTicket').hide();
                    }
                }
            });
        }
    });
}
//function reTicketConf(){
//	var jsonArray = JSON.parse('[{"tax":{"rate":"21","amount":"86,77 \u20ac"}},{"totales":{"total":"500,00 \u20ac","totalIva":"86,77 \u20ac","base":"413,22 \u20ac","ref":"DXWHMLCLS"}},'+
//			'{"nTicket":"0000590"},{"puntos":104},{"valor":"20,80 \u20ac"},'+
//			'{"producto":{"name":"Sofa","q":"1","priceUnit":"500,00","price":"500,00","p_orig":"600,00","ref":"RFX1005"}},{"formaPago":"Cash"},'+
//			'{"orderState":113},{"date":"2 Oct, 15 18:30:21"},{"nombre":"POS Store"},{"current":2425}]');
//	verTicket(jsonArray,false);
//	$(".loaderTicket").hide();
//}
function reTicketConf(){
    colPrecioOriginal=1;
    var jsonArray = JSON.parse('{"0":{"totales":{"total":"-90,00\u00a0\u20ac","totalIva":"0,00\u00a0\u20ac","totalRaw":"-90.00","base":"0,00\u00a0\u20ac","tax":[],"descuentos":"100,00\u00a0\u20ac","descuentosRaw":100,"ref":"REHMPKYVS"}},'+
    '"1":{"cartRules":[{"id":486,"code":"devolucion","value":"100,00\u00a0\u20ac","rawValue":"100.000000","rawValueExcl":"82.644628"}]},'+
    '"2":{"nTicket":2110},'+
    '"3":{"formaPago":"Efectivo"},'+
    '"4":{"nFact":903},'+
    '"5":{"orderState":20},'+
    '"6":{"emp":"Alex Lozano"},'+
    '"7":{"date":"11 Mar, 25 14:52:15"},'+
    '"8":{"nombre":"POS Store"},'+
    '"9":{"current":2110},'+
    '"10":{"puntos":45},'+
    '"11":{"valor":"9,00\u00a0\u20ac"},'+
    '"products":[{"name":"Sofa <strong>'+grandeText+'</strong><span class=impuestoficticio>(21%)</span>","q":1,"price":"500,00\u00a0\u20ac","priceRaw":"3.600000","id_order_detail":2551,"id":35,"attr":0,"desc":"3,24","descGroup":"0","p_unidad":"2€/Kg","n":1,"priceUnit":"3,60","p_orig":"3,60\u00a0\u20ac","ref":"RFX1005"}]}');
    verTicket(jsonArray,true);
    $(".loaderTicket").hide();
}
function mostrarTicket(tipo){
    $.fancybox({
        'type': 'html',
        'content' : 	$(".ContTicket"+tipo).html(),
        'autoSize'    : true,
        'autoHeight'  : true,
        'maxWidth'		: anchuraTicket,
        'afterClose'	: function(){
            modo=0;
            $(".docFirmados").hide();
            if(tipo == 'normal')
                pNuevaVenta();
            if(tarjeta_obligatoria == 0)
                $(".tCredito").hide();
            $("#devolucionesTipo").hide();
//			if(cambioEmpleado == 1 && tipo != 'pago'){
//				$.mobile.changePage("#popupEmpleados");
//		    }
           },
        'afterShow':  function(){
            afterShowTickets(tipo);
            if(tipo != 'pago'){
                $(".fancybox-outer").append('<div class="prevTicket"></div>	<div class="sigTicket"></div>');
                $(".fancybox-inner").addClass('ventanaOpcionesTab');
            }
            if(imprimirPrimeraVez == 1 && autoprint_ticket != null && autoprint_ticket == 1){
                $(".fancybox-outer .ticket"+tipo).printThis({
                    debug: true,              // show the iframe for debugging
                    importCSS: true,           // import page CSS
                    printContainer: true,      // grab outer container as well as the contents of the selector
                    removeInline: false        // remove all inline styles from print elements
                });
                imprimirPrimeraVez = 0;
            }
            if(mostrarFancybox == "0" && imprimirPrimeraVez == 1)
                $.fancybox.close();
        }
    });
}

function generaTicket(){
    $(".ticketPrintNormal").trigger("click");
    $.getJSON("../modules/tpvtienda/classes/actions/actionsPedido.php",{token:token_admin_orders, action:'generaTicket',id_order:id_order_global},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(typeof result.number != 'undefined'){
                    $('.fact_simpl span').html(result.number);
                    $('.fact_simpl').show();

                    efectoGuardado('.ticket .fact_simpl');
                    $('.okGenNumTicket').hide();
                }
            });
        }
    });
}
function genFactura(){
    if($("#currencyPOS").val() != undefined)
        var currPOS = $("#currencyPOS").val();
    else
        var currPOS = id_currency;
    $.getJSON(PosBaseAdminDir+"../modules/tpvtienda/classes/actions/actionsPedido.php",{token:token_admin_orders,id_currency: currPOS, action:'generaFactura',id_order:id_order_global},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(typeof result.invoices != 'undefined'){
                    if($.mobile.activePage.attr('id') != "pedidoPage"){
                        $('.verFactura').show();
                        efectoGuardado('.verFactura');
                        $('.okGenFactura').hide();
                        $('.noHayFactura').hide();
                        $('.facturaCheck').show();
                        $('.ventanaOpcionesTab .noHayFactura').hide();
                    }else{
                        $('.verFacturaPedido span').html(result.invoices[0].number);
                        $(".verFacturaPedido").show();
                        $(".verFacturaPedido").attr("href", $("#urlBackoffice").val()+"/index.php?controller=AdminPDF&submitAction=generateInvoicePDF&id_order="+id_order_global+"&token="+$('#tokenLitePDF').val());
                        $('.okGenFactura').hide();
                    }
                }
            });
        }
    });
}
function afterShowTickets(tab){
    $(".lineaRegalo").show();
  //  if(typeof cloudprint != "undefined"){
//        var gadget = new cloudprint.Gadget();
//        gadget.setPrintButton(document.getElementById("printGoogleCloud")); // div id to contain the button
//        $(".fancybox-outer").append('<div id="printGoogleCloud" class="ticketPrintGoogleCloud printWrapper"><div class="print" title="'+ticketCloudPrint+'"></div></div>');
//    }
    if(!$("body").hasClass("adminorders"))
        $(".fancybox-outer").append('<div class="ticketOpenCashdrawer printWrapper"><div class="print" onclick="abrirCajon()" title="'+ticketOpenCashdrawer+'"><i class="fas fa-cash-register"></i></div></div>');
    $(".fancybox-outer").append('<div class="ticketPrint printWrapper"><div class="print" title="'+imprimir+'"></div></div>');
    if(tab != 'caja' && tab != 'estadisticas' && tab != 'valeDescuento'){
        $(".fancybox-outer").append('<div class="ticketPrintGuardar printWrapperDer '+((tab == 'pdfTab')? "seleccionado" : "")+'"><div class="print" title="'+guardarTicket+'"></div></div>');
        $(".fancybox-outer").append('<div class="ticketPrintNormal printWrapperDer '+((tab == 'normal')? "seleccionado" : "")+'" title="'+ticketNormal+'" onclick="mostrarTicket(\'normal\')"><div class="print"></div></div>');
        $(".fancybox-outer").append('<div class="ticketPrintRegalo printWrapperDer '+((tab == 'regalo')? "seleccionado" : "")+'" title="'+ticketRegalo+'"><div class="print"></div></div>');
        $(".fancybox-outer").append('<div class="ticketOpciones printWrapperDer '+((tab == 'opciones')? "seleccionado" : "")+'" title="'+opcionesTab+'"><div class="print"></div></div>');
        $(".guardarticket").on("click", function(event){
            ticketToPDF(1);
            // $.getJSON(token_actions,{action:'printGuardar', ajax : "1",id_order:id_order_global, id_employee:id_employee, id_lang:id_lang,
//                id_shop:id_shop},function(data) {
//                    window.open(baseUri+"modules/tpvtienda/classes/actions/ticket.pdf");
//                    $(".loadingTicket").hide();
//                    $('#formTicket').submit();
//            });
        });
    }
    $(".loaderTicket").hide();
    $(".fancybox-outer .ticketPrint").on("click", function(event){
        if(tab == 'verValeDescuento')
            tab = 'valeDescuento';
        $('.fancybox-outer .ticket'+tab).printThis({
            debug: true,              // show the iframe for debugging
            importCSS: true,           // import page CSS
            printContainer: true,      // grab outer container as well as the contents of the selector
            removeInline: false        // remove all inline styles from print elements
        });

    });
    $(".ticketPrintRegalo").fancybox({
        'type': 'html',
        'content' 	  :	$('.ContTicketregalo').html(),
        'autoSize'    : true,
        'autoHeight'  : true,
        'maxWidth'		: anchuraTicket,
        'afterClose'	: function(){
            modo=0;
        },
        'afterShow':  function(){
        	afterShowTickets('regalo');
        }
    });
    $(".ticketOpciones").fancybox({
        'type'        : 'html',
        'content' 	  : $("#ContOpcionesTab").html(),
        'autoSize'    : true,
        'autoHeight'  : true,
        'maxWidth'	  : 347,
        'afterClose'	: function(){
            modo=0;
           },
        'afterShow':  function(){
            afterShowTickets('opciones');
            $(".fancybox-inner").addClass('ventanaOpcionesTab');
            $('.opcionesTab .id_order').val(id_order_global);
            $('.emailSend').val(emailSend);
            $('.ventanaOpcionesTab form').submit(function() {
                $(this).ajaxSubmit({
                    target:  '.ventanaOpcionesTab .opcionesTab .resultadoEnviarEmail',   // target element(s) to be updated with server response
                    beforeSubmit:  function(){
                        var email = $('.ventanaOpcionesTab .emailSend').val();
                        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                        var valido = regex.test(email);
                        if(valido) {
                            return true;
                        }else {
                            $('.ventanaOpcionesTab .resultadoEnviarEmail').html('<div class="module_error alert alert-danger error">'+emailNoValido+'</div>');
                            return false;
                        }
                    },  // pre-submit callback
                    resetForm: false        // reset the form after successful submit
                });  //Ajax Submit form
                // return false to prevent standard browser submit and page navigation
                return false;
            });
        }
    });
    //$(".ticketPrintGoogleCloud").on("click", function(event){
//        $.post("../modules/tpvtienda/classes/actions/actionsTicket.php",{action:'printGoogleCloud', id_order:id_order_global, id_employee:id_employee, id_lang:id_lang,
//            id_shop:id_shop, token:token},function(data) {
//                gadget.setPrintDocument("url", "TPV", baseUri+"modules/tpvtienda/classes/actions/ticket.pdf");
//                gadget.openPrintDialog();
//        });
//    });
}
function getTicketDescuento(id_descuento,notabs){
    var html = '';
    var error = false;
    if(typeof notabs != 'undefined')
        notabs = true;
    $(".loaderTicket").show();
    $(".codBarTicket").hide();
    $(".codBarTicketRef").hide();
    $(".textoCodebar").hide();
    $(".textoParteInferior").hide();
    $(".codBarTicketQR").hide();
    $('.ticket .datosCliente').hide();
    if($("#currencyPOS").val() != undefined)
        var currPOS = $("#currencyPOS").val();
    else
        var currPOS = id_currency;
    $.getJSON(token_actions,{action:'getDiscount', ajax:"1",id_shop: id_shop,fecha:fecha,id_descuento: id_descuento,
        id_currency: currPOS,id_employee: id_employee},function(data) {
            if(data != null){
                $.each(data, function(index, result) {
                    if(result.error != null){
                        error = true;
                        mostrarError(result.error);
                    }
                    if(result.total != null)
                        $('.ticketvaleDescuento .totalValeDescuento span').html(result.total);
                    if(result.date != null)
                        $('.ticketvaleDescuento .dateTicket').html(result.date);
                    if(result.date_to != null){
                        if(result.date_to == 0 || result.date_to_raw == '9999-12-31 23:59:59')
                            $('.ticketvaleDescuento .dateTicketTo').hide();
                        else{
                            $('.ticketvaleDescuento .dateTicketTo').show();
                            $('.ticketvaleDescuento .dateTicketTo span').html(result.date_to);
                        }
                    }
                    if(result.codigo != null){
                        $('.ticketvaleDescuento .codeValeDescuento span').html(result.codigo);
                        $(".codBarTicket .contCodebar").barcode(result.codigo, "code93", settings);
                        $(".codBarTicket").show();

                    }
                });
                if(!error){
                    // $('.maskTPVTienda').trigger("click");
                    $('.ticketvaleDescuento table.productosTicket').hide();
                    $.fancybox({
                        'type'        : 'html',
                        'content'     : $(".ContTicketvaleDescuento").html(),
                        'autoSize'    : true,
                        'autoHeight'  : true,
                        'maxWidth'    : anchuraTicket,
                        'afterShow':  function(){
                            if(notabs)
                                afterShowTickets('valeDescuento');
                            else
                                afterShowTickets('verValeDescuento');
                        }
                    });
                }
            }
        });
}
$(document).ready(function() {
    $(".sigTicket").on("click",function(){
         reTicket('sigOrder');
    });
    $(".prevTicket").on("click",function(){
         reTicket('prevOrder');
    });
    $(".tipoDevVale").on("click", function(){
        var codigo = "";
        var ya_creada = $("#devolucionesTipo #ya_creada_devolucion").val();
        if(ya_creada == 0){
            crearDescuento('crearImprimirDescuentoDevolucion');
            $("#devolucionesTipo #ya_creada_devolucion").val('1');
        }else{
            var id_desc = $("#devolucionesTipo #id_descuento_devolucion").val();
            getTicketDescuento(id_desc);
        }
    });
});