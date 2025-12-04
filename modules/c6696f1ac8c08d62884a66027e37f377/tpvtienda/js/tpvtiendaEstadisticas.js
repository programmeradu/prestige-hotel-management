
//var ventasInicializado = 0;
var tablaTPV = new Array(8);
var anchuraTicket = 400;
var total_devs = 0;
var total_devs_tax_incl = 0;
var total_devs_tax_excl = 0;
var total_devs_taxes = 0;
var xhrCount = 0;
var totalTotalizacionFisica = 0;
var totalTotalizacionFisicaSinIva = 0;
var totalTotalizacionOnline = 0;
var totalTotalizacionOnlineSinIva = 0;
var totalTotalizacionProductosFisica = 0;
var totalTotalizacionProductosFisicaSinIva = 0;
var totalTotalizacionProductosOnline = 0;
var totalTotalizacionProductosOnlineSinIva = 0;
var filtro_categorias = "";
var filtro_proveedor = "";
var filtro_categorias_online = "";
var filtro_proveedor_online = "";
var id_employee = "allEmp";
var nTotalPedidos = 0;

var total_devs_tax_incl_rapidas = 0;
var total_devs_tax_excl_rapidas = 0;
var total_devs_tax_incl_no_rapidas = 0;
var total_devs_tax_excl_no_rapidas = 0;
var token = document.location.href.split("token=");
//contador para esperar a que responda el servidor antes de obtener el totan(con iva)
var contadorTotales = 0;
token = token[1].split("#");
token = token[0].split("&");
token = token[0];
var currencyActual = $('#id_currency').val();

function recalcularInventario(){
    if(asm ==0){
        $("#costeInventario span").html('<div class="ui-loading"><div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div></div>');
    }else{
        $("div[id^=costeInventario_]").html('<div class="ui-loading"><div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon-loading"></span><h1>loading</h1></div></div>');

    }
    $.getJSON("../modules/tpvtienda/classes/actions/actionsEstadisticas.php", {token: token, action: 'costeInventario', id_lang: id_lang, id_shop: id_shop, id_currency: $('#id_currency').val()}, function(data) {
        $.each(data, function(index, result){
            if(asm ==0){
                if(typeof result.costeInventario.coste != 'undefined') {
                    $("#costeInventario span").html(result.costeInventario.coste);
                    $("#costeInventarioPVP span").html(result.costeInventario.pvp);
                }
            }else{
                if(typeof result.costeInventarioASM != 'undefined') {
                    $.each(result.costeInventarioASM, function(index, result){
                        $("#costeInventario_"+index+" span").html(formatCurrency(parseFloat(result.coste), currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
                        $("#costeInventarioPVP_"+index+" span").html(formatCurrency(parseFloat(result.pvp), currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
                    });
                }
            }
        });
    });
}
function getInformes() {
    $('table.tablaPaises').DataTable({
        dom: 'Tf<"clear">lBrtip',
        buttons:['copyHtml5','excelHtml5','csvHtml5','pdfHtml5',
            {
                extend: 'print',
                customize: function (win) {
                    $(win.document.body).css('font-size', '10pt');
                    $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                }
            }
        ],
        "columnDefs": [
            {"targets": 0},
            {"targets": 1,"width": "120px"},
            {"targets": 2,"width": "120px"},
        ],
        "order": [[ 2, "desc" ]],
        "oLanguage": traducciones,
        fixedHeader: true,
        "info": false, // Will show "1 to n of n entries" Text at bottom
        "lengthChange": false, // Will Disabled Record number per page
        "bPaginate": true,
    });
    $("#tablaPaises .loading").hide();
    $('table.tablaClientes').DataTable({
        dom: 'Tf<"clear">lBrtip',
        buttons:['copyHtml5','excelHtml5','csvHtml5','pdfHtml5',
            {
                extend: 'print',
                customize: function (win) {
                    $(win.document.body).css('font-size', '10pt');
                    $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                }
            }
        ],
        "columnDefs": [
            {"targets": 0},
            {"targets": 1},
            {"targets": 2,"width": "120px"},
            {"targets": 3,"width": "120px"},
        ],
        "order": [[ 3, "desc" ]],
        "oLanguage": traducciones,
        fixedHeader: true,
        "info": false, // Will show "1 to n of n entries" Text at bottom
        "lengthChange": false, // Will Disabled Record number per page
        "bPaginate": true,
    });
    $("#tablaClientes .loading").hide();
    $('table.informeStocks').show();
}
function getTotalizacion() {
    $("#botonResumenO").trigger("click");
    $("#botonResumenF").trigger("click");
    var factura = $("input[name=factura]:checked").attr("id");
    var estadosResumen = '';
    var estadosProductos = '';
    var estadosOnlineResumen = '';
    var estadosOnlineProductos = '';
    var listadoPaises = '';
    var listadoClientes = '';
    totalTotalizacionFisica = 0;
    totalTotalizacionFisicaSinIva = 0;
    var seqNumber = ++xhrCount;
    var coloreo = '';
    var facturadoHoy = '';
    contadorTotales = 0;
    nTotalPedidos = 0;
    totalTotalizacionOnline = 0;
    $("#imagenesProductos").html("");
    $('input.id_employee').val(id_employee);
    // $("#ventas .loading").show();
    // $('#totalizacion').hide();
    $('#devTable').hide();
    $('#taxTable').hide();
    $('#totalizacion #totalClientes span').html('');
    $('#totalizacion #totalPedidos span').html('');
    $('#totalizacion #totalTotalizacion span').html("");
    $('#totalizacion #totalTotalizacionSinIva span').html("");
    $("#taxTable tbody").html("");
    $('#totalizacion #totalBeneficios span').html(formatCurrency(0, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
    $('#totalizacion #totalBeneficiosSinIVA span').html(formatCurrency(0, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
    var prodGroupedFisica = 'off';
    var prodGroupedOnline = 'off';
    if($('#prodGroupedOnline').attr('checked') == 'checked')
        prodGroupedOnline = 'on';
    if($('#prodGroupedFisica').attr('checked') == 'checked')
        prodGroupedFisica = 'on';
    $.getJSON("../modules/tpvtienda/classes/actions/actionsEstadisticas.php",
        {token: token, action: 'nClientes', dia: $('#desdeFecha').val(), diaFin: $('#hastaFecha').val(), id_shop: id_shop,
        factura: factura}, function(data) {
            $('#totalizacion #totalClientes span').html(data[0].nClientes);
            var porcentajeRecurrente = data[1].nClientesRecurrentes*100 / data[0].nClientes;
            $('#totalizacion #totalClientesRecurrentes span').html(parseFloat(porcentajeRecurrente.toFixed(priceDisplayPrecision)) );
            $('#totalizacion #totalClientesRecurrentes span').append("% " );
        }
    );
    $.getJSON("../modules/tpvtienda/classes/actions/actionsEstadisticas.php",
        {token: token, action: 'costes', dia: $('#desdeFecha').val(), diaFin: $('#hastaFecha').val(), id_lang: id_lang,
        id_shop: id_shop, id_currency: $('#id_currency').val(), id_employee: id_employee, ventasOnline: $('#onlineButton').is(':checked'), ventasFisica: $('#fisicaButton').is(':checked'),
        factura: factura}, function(data) {
            if (seqNumber === xhrCount) {
                var totalCostesSinIva = 0;
                var totalCostes = 0;
                $.each(data, function(index, result){
                    if(typeof result.costes != 'undefined') {
                        totalCostes += parseFloat(result.costes);
                    }
                     if(typeof result.costesSinIva != 'undefined') {
                        totalCostesSinIva += parseFloat(result.costesSinIva);
                    }
                });
                $('#totalizacion #totalCostes span').html(formatCurrency(totalCostes, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
                $('#totalizacion #totalCostesSinIva span').html(formatCurrency(totalCostesSinIva, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
            }
        }
    );

    $.getJSON("../modules/tpvtienda/classes/actions/actionsEstadisticas.php",
        {token: token, action: 'descuentos', dia: $('#desdeFecha').val(), diaFin: $('#hastaFecha').val(), id_lang: id_lang,
        id_shop: id_shop, id_currency: $('#id_currency').val(), id_employee: id_employee, ventasOnline: $('#onlineButton').is(':checked'), ventasFisica: $('#fisicaButton').is(':checked'),
        factura: factura}, function(data) {
            if (seqNumber === xhrCount) {
                var total_discs_tax_excl = 0;
                var total_discs = 0;
                var contadorDiscs = 0;
                $("#discTable tbody").html("");
                $.each(data, function(index, result)
                    {
                        if(typeof result.descuentos != 'undefined') {
                            $.each(result.descuentos, function(index, disc)
                                {
                                    contadorDiscs++;
                                    $("#discTable tbody").append("<tr><td>"+disc.id_order+"</td><td>"+disc.code+"</td><td>"+index+"</td><td>"+formatCurrency(disc.amount_tax_excl, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank'])+"</td><td>"+formatCurrency(disc.amount, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank'])+"</td></tr>");
                                    total_discs_tax_excl += disc.amount_tax_excl;
                                    total_discs += disc.amount;
                                }
                            );
                            $("#discTable").show();
                        }
                    }
                );
                if(contadorDiscs > 0) {
                    $("#discTable").show();
                    $('#totalizacion #total_discs').html(formatCurrency(total_discs, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
                    $('#totalizacion #total_discs_tax_excl').html(formatCurrency(total_discs_tax_excl, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
                }else {
                    $("#discTable").hide();
                }
            }
        }
    );

    $.getJSON("../modules/tpvtienda/classes/actions/actionsEstadisticas.php",
        {token: token, action: 'beneficios', dia: $('#desdeFecha').val(), diaFin: $('#hastaFecha').val(), id_lang: id_lang,
        id_shop: id_shop, id_currency: $('#id_currency').val(), id_employee: id_employee, ventasOnline: $('#onlineButton').is(':checked'), ventasFisica: $('#fisicaButton').is(':checked'),
        factura: factura}, function(data) {
            if (seqNumber === xhrCount) {
                $.each(data, function(index, result)
                    {
                        if(typeof result.beneficios != 'undefined') {
                            $('#totalizacion #totalBeneficiosSinIva span').html(formatCurrency(parseFloat(result.beneficios.sinIVA), currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
                            $('#totalizacion #totalBeneficios span').html(formatCurrency(parseFloat(result.beneficios.conIVA), currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
                        }
                    }
                );
            }
        }
    );
    $.getJSON("../modules/tpvtienda/classes/actions/actionsEstadisticas.php",
        {token: token, action: 'taxesDetalles', dia: $('#desdeFecha').val(), diaFin: $('#hastaFecha').val(), id_lang: id_lang,
        id_shop: id_shop, id_currency: $('#id_currency').val(), id_employee: id_employee, ventasOnline: $('#onlineButton').is(':checked'), ventasFisica: $('#fisicaButton').is(':checked'),
        factura: factura}, function(data) {
            if (seqNumber === xhrCount) {
                $.each(data, function(index, result)
                    {
                        if(typeof result.taxes != 'undefined' && result.taxes != "") {
                            $.each(result.taxes, function(index, tax)
                                {
                                    $("#totaTT-1 tbody").append("<tr class='detalleTax'>"+
                                        "<td>"+parseFloat(index).toFixed(2)+" %</td>"+
                                        "<td>"+formatCurrency(tax.total_paid_tax_excl, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank'])+"</td>"+
                                        "<td>"+formatCurrency(tax.total_amount, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank'])+"</td>+" +
                                        "<td>"+formatCurrency((tax.total_paid_tax_excl+tax.total_amount), currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank'])+"</td>"+
                                        "</tr>");
                                }
                            );
                            $("#taxTable").show();
                        }
                    }
                );
            }
        }
    );
    $.getJSON("../modules/tpvtienda/classes/actions/actionsEstadisticas.php",
        {token: token, action: 'taxes', dia: $('#desdeFecha').val(), diaFin: $('#hastaFecha').val(), id_lang: id_lang,
        id_shop: id_shop, id_currency: $('#id_currency').val(), id_employee: id_employee, ventasOnline: $('#onlineButton').is(':checked'), ventasFisica: $('#fisicaButton').is(':checked'),
        factura: factura}, function(data) {
            if (seqNumber === xhrCount) {
                var totalTax = 0;
                var totalPreciosSinIva = 0;
                var totalTotalizacionIvas = 0;
                $.each(data, function(index, result)
                    {
                        if(typeof result.taxes != 'undefined' && result.taxes != "") {
                            $.each(result.taxes, function(index, tax)
                                {
                                    $("#totaTT-1 tbody").append("<tr>"+
                                        "<td>"+textoTaxes[index]+"</td>"+
                                        "<td>"+formatCurrency(tax.total_paid_tax_excl, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank'])+"</td>"+
                                        "<td>"+formatCurrency(tax.total_amount, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank'])+"</td>+" +
                                        "<td>"+formatCurrency((tax.total_paid_tax_excl+tax.total_amount), currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank'])+"</td>"+
                                        "</tr>");
                                    if(index == 'orders' || index == 'carriers') {//pedidos y gastos de envio
                                        totalTotalizacionIvas += tax.total_paid_tax_excl+tax.total_amount;
                                        totalPreciosSinIva += tax.total_paid_tax_excl;
                                        totalTax += tax.total_amount;
                                    }
                                    if(index == 'devs') {//devoluciones
                                        totalTotalizacionIvas -= tax.total_paid_tax_excl+tax.total_amount;
                                        totalPreciosSinIva -= tax.total_paid_tax_excl;
                                        totalTax -= tax.total_amount;
                                    }
                                }
                            );
                            $("#taxTable").show();
                        }
                    }
                );
                $('#totalizacion #totalTotalizacionIvas').html(formatCurrency(totalTotalizacionIvas, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
                $('#totalizacion #totalPreciosSinIva').html(formatCurrency(totalPreciosSinIva, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
                $('#totalizacion #totalTax').html(formatCurrency(totalTax, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
            }
        }
    );
    $('#contenedorOnline .loading').show();
    $('#totalizacion #tabsTotaOnline').hide();
    $.getJSON("../modules/tpvtienda/classes/actions/actionsEstadisticas.php",
        {token: token, action: 'totalizacionOnline', dia: $('#desdeFecha').val(), diaFin: $('#hastaFecha').val(), id_lang: id_lang,
        id_shop: id_shop, id_currency: $('#id_currency').val(), id_employee: id_employee, ventasOnline: $('#onlineButton').is(':checked'), ventasFisica: $('#fisicaButton').is(':checked'),
        factura: factura, prodGrouped: prodGroupedOnline}, function(data) {
            if (seqNumber === xhrCount) {
                var i = 0;
                var cantidadesOnline = 0;
                $.each(data, function(index, result)
                    {
                        if(typeof result.online ==='object' && result.online !=null) {
                            if(typeof result.online.resumen != 'undefined') {
                                (i++%2==0)? coloreo = 'class="alt_row"': coloreo = '';
                                (result.online.resumen.factura == 0)? factura = no: factura = si;
                                estadosOnlineResumen += '<tr '+coloreo+'>';
                                estadosOnlineResumen += '<td>'+result.online.resumen.name+'</td>';
                                estadosOnlineResumen += '<td><strong>'+result.online.resumen.contador+'</strong></td>';
                                estadosOnlineResumen += '<td><strong>'+result.online.resumen.amount+'</strong></td>';
                                totalTotalizacionOnline += parseFloat(result.online.resumen.amountRaw);
                                cantidadesOnline += result.online.resumen.contador;
                                if(result.online.resumen.amountRawSinIva != null) {
                                    totalTotalizacionFisicaSinIva += parseFloat(result.online.resumen.amountRawSinIva);
                                }
                            }
                        }
                        if(typeof result.date != 'undefined') {
                            $('#ventas .date').html(result.date);
                        }
                    }
                );
                contadorTotales++;
                $('#totaO-1').hide();
                if(estadosOnlineResumen != '') {
                    $('#totalizacion .sinResultadosOnline').hide();
                    $('#totalizacion #totalTotalizacionOnline').show();
                    $('#totalizacion #tabsTotaOnline').show();
                    $('#contenedorOnline .loading').hide();
                    $('#totalizacion #totaO-1 .estadosOnline tbody').html(estadosOnlineResumen);
                    $('#totalizacion #totalTotalizacionOnline').html(formatCurrency(totalTotalizacionOnline, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
                    $('#totalizacion #totaO-1 .totalcantidad').html(cantidadesOnline);
                    nTotalPedidos += cantidadesOnline;
                     $('#totaO-1').show();
                }else {
                    $('#contenedorOnline .loading').hide();
                    $('#totalizacion .sinResultadosOnline').show();
                    $('#totalizacion #totalTotalizacionOnline').hide();
                    $('#totalizacion #tabsTotaOnline').hide();
                }
            }
        }
    );
    $('#contenedorFisica .loading').show();
    $('#totalizacion #tabsTotaFisica').hide();
    $.getJSON("../modules/tpvtienda/classes/actions/actionsEstadisticas.php",
        {token: token, action: 'totalizacionFisica', dia: $('#desdeFecha').val(), diaFin: $('#hastaFecha').val(), id_lang: id_lang,
        id_shop: id_shop, id_currency: $('#id_currency').val(), id_employee: id_employee, ventasOnline: $('#onlineButton').is(':checked'), ventasFisica: $('#fisicaButton').is(':checked'),
        factura: factura, prodGrouped: prodGroupedFisica}, function(data) {
            if (seqNumber === xhrCount) {
                var i = 0;
                var cantidadesFisica = 0;
                $.each(data, function(index, result)
                    {
                        if(typeof result.fisica ==='object' && result.fisica !=null) {
                            if(typeof result.fisica.resumen != 'undefined') {
                                (i++%2==0)? coloreo = 'class="alt_row"': coloreo = '';
                                (result.fisica.resumen.fHoy == 1)? facturadoHoy = facturadoElPedido: facturadoHoy = '';
                                estadosResumen += '<tr '+coloreo+'><td>'+facturadoHoy+result.fisica.resumen.name+'</td>';
                                estadosResumen += '<td>'+result.fisica.resumen.contador+'</td>';
                                estadosResumen += '<td><strong>'+result.fisica.resumen.amount+'</strong></td></tr>';
                                cantidadesFisica += result.fisica.resumen.contador;
                                if(result.fisica.resumen.amountRaw != null) {
                                    totalTotalizacionFisica += parseFloat(result.fisica.resumen.amountRaw);
                                }
                                if(result.fisica.resumen.amountRawSinIva != null) {
                                    totalTotalizacionFisicaSinIva += parseFloat(result.fisica.resumen.amountRawSinIva);
                                }
                            }
                        }
                        if(typeof result.date != 'undefined') {
                            $('#ventas .date').html(result.date);
                        }
                    }
                );
                contadorTotales++;
                $('#contenedorFisica #totaF-1').hide();
                if(estadosResumen != '') {
                    $('#totalizacion .sinResultadosFisica').hide();
                    $('#totalizacion #totalTotalizacionFisica').show();
                    $('#totalizacion #tabsTotaFisica').show();
                    $('#contenedorFisica .loading').hide();
                    $('#totalizacion #totaF-1 .estados tbody').html(estadosResumen);
                    $('#totalizacion #totalTotalizacionFisica').html(formatCurrency(totalTotalizacionFisica, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
                    $('#totalizacion #totaF-1 .totalcantidad').html(cantidadesFisica);
                    nTotalPedidos += cantidadesFisica;
                    $('#contenedorFisica #totaF-1').show();
                }else {
                    $('#contenedorFisica .loading').hide();
                    $('#totalizacion .sinResultadosFisica').show();
                    $('#totalizacion #totalTotalizacionFisica').hide();
                    $('#totalizacion #tabsTotaFisica').hide();
                }
            }
        }
    );

    $.getJSON("../modules/tpvtienda/classes/actions/actionsEstadisticas.php",
        {token: token, action: 'devoluciones', dia: $('#desdeFecha').val(), diaFin: $('#hastaFecha').val(), id_lang: id_lang,
        id_shop: id_shop, id_currency: $('#id_currency').val(), id_employee: id_employee, ventasOnline: $('#onlineButton').is(':checked'), ventasFisica: $('#fisicaButton').is(':checked'),
        factura: factura}, function(data) {
        if (seqNumber === xhrCount) {
            total_devs = 0;
            total_devs_tax_incl = 0;
            total_devs_tax_excl = 0;
            total_devs_coste = 0;
            total_devs_taxes = 0;
            $('table.devsTable').DataTable().rows().remove().draw();
            $.each(data, function(index, result){
                if(typeof result.devoluciones != 'undefined' && result.devoluciones != null) {
                    $.each(result.devoluciones, function(index, dev){
                        var amountDev = 1;
                        var id_order = '-';
                        if(dev.amount !== null && $.isNumeric(dev.amount))
                            amountDev = dev.amount;
                        if(dev.id_order != 0)
                            id_order = dev.id_order_orig;
                        $('table.devsTable').DataTable().row.add(
                            [id_order, dev.id_order_dest, dev.id_product,dev.name, dev.description, dev.payment, dev.shop_name, dev.caja, amountDev,
                            formatCurrency(Math.abs(parseFloat(dev.wholesale_price)), currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']),
                            formatCurrency(Math.abs(parseFloat(dev.unit_price_tax_excl * amountDev)), currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']),
                            Math.round(((dev.unit_price_tax_incl/dev.unit_price_tax_excl)-1) * 100)+"%",
                            formatCurrency(Math.abs(parseFloat((dev.unit_price_tax_incl-dev.unit_price_tax_excl) * amountDev)), currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']),
                            formatCurrency(Math.abs(parseFloat(dev.unit_price_tax_incl * amountDev)), currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank'])]
                        ).draw(false);
                        total_devs_taxes += Math.abs((dev.unit_price_tax_incl - dev.unit_price_tax_excl) * amountDev);
                        total_devs_coste += Math.abs(dev.wholesale_price * amountDev);
                        total_devs_tax_incl += Math.abs(dev.unit_price_tax_incl * amountDev);
                        total_devs_tax_excl += Math.abs(dev.unit_price_tax_excl * amountDev);
                        //sumo solo las devoluciones rápidas  para restarlo al total
                        if(id_order == "-") {
                            total_devs_tax_incl_rapidas += Math.abs(dev.unit_price_tax_incl * amountDev);
                            total_devs_tax_excl_rapidas += Math.abs(dev.unit_price_tax_excl * amountDev);
                        }else{
                            total_devs_tax_incl_no_rapidas += Math.abs(dev.unit_price_tax_incl * amountDev);
                            total_devs_tax_excl_no_rapidas += Math.abs(dev.unit_price_tax_excl * amountDev);
                        }

                        //esto es el numero de devoluciones que se han hecho
                        total_devs += Math.abs(parseFloat(amountDev));
                    });
                    suscriboFullscreen('.fullscreenProduct');

                    if(total_devs > 0)
                        $("#devTable").show();
                    $('#coste_dev').html(formatCurrency(total_devs_coste, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
                    $('#total_devs_tax_incl').html(formatCurrency(total_devs_tax_incl, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
                    $('#subtotales_dev').html(formatCurrency(total_devs_tax_excl, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
                    $('#impuestostotales_dev').html(formatCurrency(total_devs_taxes, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
                    $('#total_devs').html(total_devs);
                }
            });
            contadorTotales++;
        }
    });
    $('table.tablaClientes').DataTable().rows().remove().draw();
    $('table.tablaPaises').DataTable().rows().remove().draw();
    $.getJSON("../modules/tpvtienda/classes/actions/actionsEstadisticas.php",{token: token, action: 'totalPaisesClientes', dia: $('#desdeFecha').val(), diaFin: $('#hastaFecha').val(),
        id_lang: id_lang, id_shop: id_shop, id_currency: $('#id_currency').val(), id_employee: id_employee, ventasOnline: $('#onlineButton').is(':checked'),
        ventasFisica: $('#fisicaButton').is(':checked'), factura: factura, prodGrouped: prodGroupedFisica}, function(data) {
            if (seqNumber === xhrCount) {
                var i = 0;
                if(typeof data.date != 'undefined'){
                    $('#ventas .date').html(data.date);
                }
                if(typeof data.countries != 'undefined'){
                    $.each(data.countries, function(index, result){
                        $('table.tablaPaises').DataTable().row.add([result.n,result.amountSinIva,result.amount]).draw(false);;
                    });
                }
                if(typeof data.customers != 'undefined'){
                    $.each(data.customers, function(index, result){
                        $('table.tablaClientes').DataTable().row.add([result.n,result.email, result.amountSinIva,result.amount]).draw(false);;
                    });
                }
            }
        }
    );
        //  totalTotalizacionFisica = totalTotalizacionProductosFisica;
    //    totalTotalizacionFisicaSinIva = totalTotalizacionProductosFisicaSinIva;
    //    totalTotalizacionOnline = totalTotalizacionProductosOnline;
    //    totalTotalizacionOnlineSinIva = totalTotalizacionProductosOnlineSinIva;

    var refreshId = setInterval(function(){
        if(contadorTotales == 3) {
            var totalTotalizacion = parseFloat(totalTotalizacionFisica.toFixed(priceDisplayPrecision)) + parseFloat(totalTotalizacionOnline.toFixed(priceDisplayPrecision));
            var totalTotalizacionSinIva = parseFloat(totalTotalizacionFisicaSinIva.toFixed(priceDisplayPrecision)) + parseFloat(totalTotalizacionOnlineSinIva.toFixed(priceDisplayPrecision));

            if(isNaN(totalTotalizacion))
                totalTotalizacion = 0;
            if(isNaN(totalTotalizacionSinIva))
                totalTotalizacionSinIva = 0;
            if(totalTotalizacionSinIva > 0){
                var totalPedidoMedio = totalTotalizacion / nTotalPedidos;
                var totalPedidoMedioSinIva = totalTotalizacionSinIva / nTotalPedidos;;
            }else{
                var totalPedidoMedio = 0;
                var totalPedidoMedioSinIva = 0;
            }

            $("#totalPedidos span").html(nTotalPedidos);
            $('#totalizacion #totalTotalizacion span').html(formatCurrency(totalTotalizacion, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
            $('#totalizacion #pedidoMedio span').html(formatCurrency(totalPedidoMedio, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
            $('#totalizacion #pedidoMedioSinIva span').html(formatCurrency(totalPedidoMedioSinIva, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
            $('#totalizacion #totalTotalizacionSinIva span').html(formatCurrency(totalTotalizacionSinIva, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
            clearInterval(refreshId);
        }
    }, 500);
    //$("#ventas .loading").hide();
    // $('#totalizacion').show();
}

function suscriboFullscreen(idDiv) {
    $(idDiv).fancybox(
        {
        prevEffect: 'none',
        nextEffect: 'none',
        helpers: {
            title: {
                type: 'outside'
                },
            thumbs: {
                width: 50,
                height: 50
                }
            }
        }
    );
}
function exportar(id) {
    if(id != '') {
        $("#exportarMarcas").hide();
        $("#exportarCaracteristicas").hide();
        if(id == 'exportar')
            $("#exportarNormal").submit();
        else if(id == 'exportarAbonos')
            $("#exportarAbonos").submit();
        else if(id == 'exportarPedidosYonline')
            $("#exportarPedidosYonline").submit();
        else if(id == 'exportarListadoClientes')
            $("#exportarListadoClientes").submit();
        else if(id == 'exportarProductos')
            $("#exportarProductos").submit();
        else if(id == 'exportarDetalleProductos')
            $("#popupDetalleProductos").popup("open");
        else if(id == 'exportarDias')
            $("#exportarDias").submit();
        else if(id == 'exportarFormasPago')
            $("#exportarFormasPago").submit();
        else if(id == 'exportarMarcas')
            $("#exportarMarcas").submit();
        else if(id == 'exportarCaracteristicas')
            $("#exportarCaracteristicas").submit();
        else if(id == 'exportarCSVOnline')
            $("#exportarCSVOnline").submit();
        else if(id == 'exportarCSVFisica')
            $("#exportarCSVFisica").submit();
        else if(id == 'exportarCSVSerialNumbers')
            $("#exportarCSVSerialNumbers").submit();
        else{
            $("#"+id).submit();
         }
        //$("#selectorExportador option:first").attr('selected', 'selected');
    }

}

function imprimirTotalizacion() {
    //wtotalizacionw.print();
    var desde = $("#desdeFecha").val();
    var hasta = $("#hastaFecha").val();
    if(hasta == desde)
        var fechaTitulo = desde;
    else
        var fechaTitulo = desde+" - "+hasta;
    $(".contenidoestadisticas").html("<h2 style='text-align:center'>"+fechaTitulo+"</h2>");
    $(".contenidoestadisticas").append($(".infoTienda").clone()).html();
    $(".contenidoestadisticas .infoTienda").show();
    if($("#tabsTotaFisica").css('display') == 'block') {
        $(".contenidoestadisticas").append($("#contenedorFisica h4").clone()).html();
        if($("#totaF-1").css('display') == 'block'){
            $(".contenidoestadisticas").append($("#contenedorFisica #totaF-1 table").clone()).html();
        }
        if($("#totaF-2").css('display') == 'block'){
            $(".contenidoestadisticas").append($("#contenedorFisica #totaF-2 table").clone()).html();
        }
        if($("#totaF-3").css('display') == 'block'){
            $(".contenidoestadisticas").append($("#contenedorFisica #totaF-3 table").clone()).html();
        }
        $(".contenidoestadisticas").append('<br>').html();

        //comento esto porque los productos hay que pinchar para que aparezcan
        //$(".contenidoestadisticas").append('<h4 class="contProductosTicket">'+$("#contenedorFisica a[href=#totaF-3]").html()+'</h4>');
        // $(".contenidoestadisticas").append($("#contenedorFisica #totaF-3 table").clone()).html();
    }
    if($("#tabsTotaOnline").css('display') == 'block') {
        $(".contenidoestadisticas").append($("#contenedorOnline h4").clone()).html();
        if($("#totaO-1").css('display') == 'block'){
            $(".contenidoestadisticas").append($("#contenedorOnline #totaO-1 table").clone()).html();
        }
        if($("#totaO-2").css('display') == 'block'){
            $(".contenidoestadisticas").append($("#contenedorOnline #totaO-2 table").clone()).html();
        }
        if($("#totaO-3").css('display') == 'block'){
            $(".contenidoestadisticas").append($("#contenedorOnline #totaO-3 table").clone()).html();
        }
        $(".contenidoestadisticas").append('<br>').html();

        //comento esto porque los productos hay que pinchar para que aparezcan
        //  $(".contenidoestadisticas").append('<h4 class="contProductosTicket">'+$("#contenedorOnline a[href=#totaO-3]").html()+'</h4>');
        //   $(".contenidoestadisticas").append($("#contenedorOnline #totaO-3 table").clone()).html();
    }

    $(".contenidoestadisticas").append('<br>').html();
    $(".contenidoestadisticas").append($("#devTable h4").clone()).html();
    $(".contenidoestadisticas").append($("#devTable table").clone()).html();
    $(".contenidoestadisticas").append($("#discTable").html());
        $(".contenidoestadisticas").append($("#taxTable h4").clone()).html();

    if($("#tabsTotaTaxes #totaTT-1").css('display') == 'block')
        $(".contenidoestadisticas").append($("#totaTT-1").html());
    if($("#tabsTotaTaxes #totaTT-2").css('display') == 'block')
        $(".contenidoestadisticas").append($("#totaTT-2").html());
    $(".contenidoestadisticas").append("<h4>"+$("#totalTotalizacion").html()+"</h4>");
    $(".contenidoestadisticas").append("<h4>"+$("#totalTotalizacionSinIva").html()+"</h4>");
    $(".contenidoestadisticas").append("<h4>"+$("#totalBeneficios").html()+"</h4>");
    $(".contenidoestadisticas").append("<h4>"+$("#totalCostes").html()+"</h4>");
    $(".contenidoestadisticas").append("<h4>"+$("#totalClientes").html()+"</h4>");
    $(".contenidoestadisticas").append("<h4>"+$("#totalPedidos").html()+"</h4>");
    $(".contenidoestadisticas .noPrint").hide();
    $.fancybox(
        {
        'type': 'html',
        'content': $("#ContTicketestadisticas").html(),
        'autoSize': true,
        'autoHeight': true,
        'maxWidth': anchuraTicket,
        'afterClose': function() {
                modo = 0;
                $(".contenidoestadisticas").html("");
            },
        'afterShow': function() {
                afterShowTickets('estadisticas');
                if(autoprint_ticket != null && autoprint_ticket == 1)
                    $(".ticketPrint").trigger("click");
            }
        }
    );
}

function filtrar(value, tabla, columna) {
    tablaTPV[tabla].column(columna).search(value).draw();
}
function deleteProdCSV(id_prod) {
    $("#prodcsv_"+id_prod).remove();
    var idsCollector = $("#idsCollector").val().replace(id_prod+";", "");
    $("#idsCollector").val(idsCollector);
}
function addIdProd(id_prod) {
    $("#idsCollector").val($("#idsCollector").val()+id_prod+";");
    $("#contNamesProdsCSV").append('<div id="prodcsv_'+id_prod+'" class="ui-input-btn ui-btn ui-icon-delete ui-btn-icon-left" onclick="deleteProdCSV('+id_prod+')">'+$("#item_"+id_prod+" .name").html()+"</div>");
    $("#contProdsCSV").hide();
    $('#'+$.mobile.activePage.attr('id')+' #searchProd').val("");
}
function crearFiltrosFooterProducto(api,tabla){
    api.columns().every(function (){
        var column = this;
        if($(column.footer()).hasClass("filtradoCategoria")) {
            $("#"+(tabla == "online" ? 'totaO-3' : 'totaF-3')+" select[name=filtro_categorias]").html("");
            if(tabla == "online")
                var filtro = filtro_categorias_online;
            else
                var filtro = filtro_categorias;

            column.data().unique().sort().each(function (d, j){
                if(d != null)
                    $("#"+(tabla == "online" ? 'totaO-3' : 'totaF-3')+" select[name=filtro_categorias]").append('<option value="'+d+'"'+(filtro == d ? ' selected' : '')+'>'+d+'</option>')
            });
             $("#"+(tabla == "online" ? 'totaO-3' : 'totaF-3')+" select[name=filtro_categorias]").on('change', function (){
                var val = $(this).val();
                val = $.fn.dataTable.util.escapeRegex(val);
                if(tabla == "online")
                    filtro_categorias_online = val;
                else
                    filtro_categorias = val;
                column.search(val? '^'+val+'$': '', true, false).draw();
            });
        }
        if($(column.footer()).hasClass("filtradoProveedor")) {
            $("#"+(tabla == "online" ? 'totaO-3' : 'totaF-3')+" select[name=filtro_proveedor]").html("");

            if(tabla == "online")
                var filtro = filtro_proveedor_online;
            else
                var filtro = filtro_proveedor;
            column.data().unique().sort().each(function (d, j){
                if(d != null)
                    $("#"+(tabla == "online" ? 'totaO-3' : 'totaF-3')+" select[name=filtro_proveedor]").append('<option value="'+d+'"'+(filtro == d ? ' selected' : '')+'>'+d+'</option>');
            });
            $("#"+(tabla == "online" ? 'totaO-3' : 'totaF-3')+" select[name=filtro_proveedor]").on('change', function (){
                var val = $(this).val();
                val = $.fn.dataTable.util.escapeRegex(val);
                if(tabla == "online")
                    filtro_proveedor_online = val;
                else
                    filtro_proveedor = val;
                filtro_proveedor_online = $(this).val();
                column.search(val? '^'+val+'$': '', true, false).draw();
            });
        }
    });
}
function search() {
    var query = $('#'+$.mobile.activePage.attr('id')+' #searchProd').val();
    var seqNumber = ++xhrCount;
    if(query != '') {
        $("#contProdsCSV").html("");
        $("#contProdsCSV").show();
        $("#loaderProductos").show();
        $.getJSON("../modules/tpvtienda/classes/actions/actions.php",
            {token: token, action: 'search', q: query, tipoBusqueda: 'normal', inicio: 0, cantidad: 10,
            inactivos: '', id_lang: id_lang, id_shop: $('#id_shop').val(), conAtributos: false}, function(data) {
                if (seqNumber === xhrCount) {
                    if(data != null) {
                        $.each(data, function(index, result)
                            {
                                if(result.error != null) {
                                    mostrarError(result.error);
                                }else {
                                    if(result.id != null) {
                                        $("#idCollectorProds").append(result.id+",");
                                        $("#contProdsCSV").append("<div class='lineaProducto' onclick='addIdProd("+result.id+")' id='item_"+result.id+"'>"+
                                            "<span class='name'>"+result.name+"</span>"+
                                            "</div>");
                                    }
                                }
                            }
                        );
                        //este error ya no hace falta que sea subsanado en la nueva versión del swiper
                        //     if(plantilla_pos == "full-width")
                        //      $("#contProductos").css('width', (contadorProductos * 135)+'px');
                    }else {
                        $("#contProdsCSV").hide();
                    }
                }
            }
        );
    }else {
        getCategoriaId('');
    }
}
(function($)
    {
        $(document).on('pagecontainerbeforeshow', function()
            {
                var activePage = $.mobile.pageContainer.pagecontainer("getActivePage");
            }
        );
    }
)(jQuery);

$(document).ready(function()
    {
        $("a").not('.ui-mobile-viewport a').each(function(){
            $(this).attr("rel", "external");
        });
        $("#header_search").attr("data-ajax", false);
        getInformes();
        getTotalizacion();
        addData();
        $('#marcasExportar').change(function (){
                var vals = $('#marcasExportar').val();
                $("input[name=marcasExportar]").val(vals.join(','));
        });
        $('#caracteristicasExportar').change(function ()
            {
                var vals = $('#caracteristicasExportar').val();
                $("input[name=caracteristicasExportar]").val(vals.join(','));
            }
        );
        $("#searchProd").on("keyup", function(event){
            search();
        });
        $("#generarInformeProductos").on("click", function(event)
            {
                $("#exportarDetalleProductos").submit();
            }
        );
        $("#desdeFecha").datepicker(
            {
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            beforeShow: function() {
                setTimeout(function()
                    {
                        $('.ui-datepicker').css('z-index', 2);
                    }, 0
                );
            },

            onSelect: function(selectedDate) {
                    var date2 = $("#desdeFecha").datepicker('getDate');
                    date2.setDate(date2.getDate());
                    $("#hastaFecha").datepicker('option', 'minDate', date2);
                    $('input.fechaTotalizacion').val(selectedDate);
                    getTotalizacion();
                    addData();
                    //$("#hastaFecha").val(selectedDate);
                }
            }
        );

        $("#hastaFecha").datepicker(
            {
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            beforeShow: function() {
                    setTimeout(function()
                        {
                            $('.ui-datepicker').css('z-index', 2);
                        }, 0
                    );

                },
            onSelect: function(selectedDate) {
                    $('input.fechaTotalizacionFin').val(selectedDate);
                    getTotalizacion();
                    addData();
                }
            }
        );

        $('.cajaTotalizacion').on("keyup blur", function(e)
            {
                guardarCaja($(this).val());
            }
        );

        $('#id_currency').on("change", function(e)
            {
                getTotalizacion();
            }
        );

        $('#prodGroupedFisica, #prodGroupedOnline').on("change", function(e)
            {
                getTotalizacion();
                if($('#prodGroupedFisica').attr('checked') == 'checked')
                    prodGroupedFisica = 'on';
                else
                    prodGroupedFisica = 'off';
                if($('#prodGroupedOnline').attr('checked') == 'checked')
                    prodGroupedOnline = 'on';
                else
                    prodGroupedOnline = 'off';
            }
        );


        $(".confTablaProductos").on("click", function(event){
            $("#popupConfTablaProductos").popup( "open");
        });
        $('.camposProd').on( 'click', function (e) {
            e.preventDefault();
            // Get the column API object
            var column = $('table.totaF-3' ).DataTable().column( $(this).val() );
            // Toggle the visibility
            column.visible( ! column.visible() );
            // Get the column API object
            var column = $('table.totaO-3' ).DataTable().column( $(this).val() );
            // Toggle the visibility
            column.visible( ! column.visible() );
        } );
        $("#botonPedidosOnline").on("click", function(event)
            {
                var factura = $("input[name=factura]:checked").attr("id");
                var currencyActual = $('#id_currency').val();
                $('#totaO-2 .loading').show();
                $('#totaO-2').hide();
                var estadosOnlineDetallado = '';
                $.getJSON("../modules/tpvtienda/classes/actions/actionsEstadisticas.php",
                    {token: token, action: 'totalizacionOnlineDetallado', dia: $('#desdeFecha').val(), diaFin: $('#hastaFecha').val(), id_lang: id_lang,
                    id_shop: id_shop, id_currency: $('#id_currency').val(), id_employee: id_employee, ventasOnline: $('#onlineButton').is(':checked'), ventasFisica: $('#fisicaButton').is(':checked'),
                    factura: factura}, function(data) {
                        var i = 0;
                        $.each(data, function(index, result)
                            {
                                if(typeof result.online ==='object' && result.online !=null) {
                                    if(typeof result.online.detallado != 'undefined') {
                                        (i++%2==0)? coloreo = 'class="alt_row"': coloreo = '';
                                        (result.online.detallado.factura == 0)? factura = no: factura = si;
                                        estadosOnlineDetallado += '<tr '+coloreo+'>';
                                        estadosOnlineDetallado += '<td>'+result.online.detallado.id_order+'</td>';
                                        estadosOnlineDetallado += '<td>'+result.online.detallado.cliente+'</td>';
                                        estadosOnlineDetallado += '<td>'+result.online.detallado.date_add+'</td>';
                                        estadosOnlineDetallado += '<td>'+result.online.detallado.name+'</td>';
                                        estadosOnlineDetallado += '<td>'+result.online.detallado.total+'</td>';
                                        estadosOnlineDetallado += '<td><strong>'+factura+'</strong></td></tr>';
                                    }
                                }
                            }
                        );
                        $('#totalizacion #totaO-2 .estadosOnline tbody').html(estadosOnlineDetallado);
                        $('#totaO-2 .loading').hide();
                        $('#totaO-2').show();
                    }
                );
            }
        );
        $("#botonPagosOnline").on("click", function(event){
            var factura = $("input[name=factura]:checked").attr("id");
            var currencyActual = $('#id_currency').val();
            $('#totaO-4 .loading').show();
            $('#totaO-4 ').hide();
            var estadosOnlinePagos = '';
            $.getJSON("../modules/tpvtienda/classes/actions/actionsEstadisticas.php",
                {token: token, action: 'totalizacionOnlinePagos', dia: $('#desdeFecha').val(), diaFin: $('#hastaFecha').val(), id_lang: id_lang,
                id_shop: id_shop, id_currency: $('#id_currency').val(), id_employee: id_employee, ventasOnline: $('#onlineButton').is(':checked'), ventasFisica: $('#fisicaButton').is(':checked'),
                factura: factura}, function(data) {
                    var i = 0;
                    $.each(data, function(index, result)
                        {
                            if(typeof result.online ==='object' && result.online !=null) {
                                if(typeof result.online.pagos != 'undefined') {
                                    (i++%2==0)? coloreo = 'class="alt_row"': coloreo = '';
                                    estadosOnlinePagos += '<tr '+coloreo+'>';
                                    estadosOnlinePagos += '<td>'+result.online.pagos.id_order+'</td>';
                                    estadosOnlinePagos += '<td >'+result.online.pagos.name+'</td>';
                                    estadosOnlinePagos += '<td><strong>'+result.online.pagos.amount+'</strong></td></tr>';
                                }
                            }
                        }
                    );
                    $('#totalizacion #totaO-4 .estadosOnline tbody').html(estadosOnlinePagos);
                    $('#totaO-4 .loading').hide();
                    $('#totaO-4 table').show();
                }
            );
        });
        $("#botonProductosOnline").on("click", function(event){
            var factura = $("input[name=factura]:checked").attr("id");
            var currencyActual = $('#id_currency').val();
            totalTotalizacionProductosOnline = 0;
            totalTotalizacionProductosOnlineSinIva = 0;
            var prodGroupedOnline = 'off';
            if($('#prodGroupedOnline').attr('checked') == 'checked')
                prodGroupedOnline = 'on';
            $('#totaO-3 .loading').show();
            $('#totaO-3 .dataTables_wrapper').hide();
            $.getJSON("../modules/tpvtienda/classes/actions/actionsEstadisticas.php",
                {token: token, action: 'totalizacionOnlineProductos', dia: $('#desdeFecha').val(), diaFin: $('#hastaFecha').val(), id_lang: id_lang,
                id_shop: id_shop, id_currency: $('#id_currency').val(), id_employee: id_employee, ventasOnline: $('#onlineButton').is(':checked'), ventasFisica: $('#fisicaButton').is(':checked'),
                factura: factura, prodGrouped: prodGroupedOnline}, function(data) {
                    var i = 0;
                    $('table.totaO-3').DataTable().rows().remove().draw();
                    $.each(data, function(index, result)
                        {
                            if(typeof result.online ==='object' && result.online !=null) {
                                if(typeof result.online.productos != 'undefined') {
                                    estadosOnlineProductos = 1;
                                    if(result.online.productos.img != "")
                                        var imgOnline = '<a rel="imgProdsOnline" class="fullscreenProduct" href="'+result.online.productos.img+'"><img width="30" height="30" src="'+result.online.productos.img+'"/></a>';
                                    else
                                        var imgOnline = "";
                                    $('table.totaO-3').DataTable().row.add(
                                        [result.online.productos.id,result.online.productos.id_order, imgOnline, result.online.productos.name, result.online.productos.ref, result.online.productos.product_supplier_reference, result.online.productos.supplier, result.online.productos.cat, result.online.productos.stock, result.online.productos.quantity,
                                            result.online.productos.mayorista, result.online.productos.amountUnit, result.online.productos.amountSinIva, result.online.productos.amount]
                                    ).draw(false);
                                    totalTotalizacionProductosOnline += parseFloat(result.online.productos.amount);
                                    totalTotalizacionProductosOnlineSinIva += parseFloat(result.online.productos.amountSinIva);
                                    if(result.online.productos.i !=null) {
                                        $("#imagenesProductos").append("<a rel='fscreen_"+result.online.productos.i.id+"_0' class='fullscreenProduct' title='"+result.online.productos.i.name+"' href='"+result.online.productos.i.img+"'></a>");
                                    }
                                }
                            }
                        }
                    );
                    $('#totaO-3 .loading').hide();
                    $('#totaO-3 .dataTables_wrapper').show();
                    $('#totalizacion #totalTotalizacionProductosOnline').html(formatCurrency(totalTotalizacionProductosOnline, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
                }
            );
        });
        $("#botonPedidosFisica").on("click", function(event)
            {
                var factura = $("input[name=factura]:checked").attr("id");
                var currencyActual = $('#id_currency').val();
                var estadosDetallado = '';
                $('#totaF-2 .loading').show();
                $('#totaF-2').hide();
                $.getJSON("../modules/tpvtienda/classes/actions/actionsEstadisticas.php",
                    {token: token, action: 'totalizacionFisicaDetallado', dia: $('#desdeFecha').val(), diaFin: $('#hastaFecha').val(), id_lang: id_lang,
                    id_shop: id_shop, id_currency: $('#id_currency').val(), id_employee: id_employee, ventasOnline: $('#onlineButton').is(':checked'), ventasFisica: $('#fisicaButton').is(':checked'),
                    factura: factura}, function(data) {
                        var i = 0;
                        $.each(data, function(index, result)
                            {
                                if(typeof result.fisica ==='object' && result.fisica !=null) {
                                    if(typeof result.fisica.detallado != 'undefined') {
                                        (i++%2==0)? coloreo = 'class="alt_row"': coloreo = '';
                                        (result.fisica.detallado.fHoy == 1)? facturadoHoy = facturadoElPedido: facturadoHoy = '';
                                        estadosDetallado += '<tr '+coloreo+'><td class="center">'+result.fisica.detallado.id_order+'</td>';
                                        estadosDetallado += '<td>'+result.fisica.detallado.cliente+'</td>';
                                        estadosDetallado += '<td>'+facturadoHoy+result.fisica.detallado.date_add+'</td>';
                                        estadosDetallado += '<td>'+facturadoHoy+result.fisica.detallado.name+'</td>';
                                        estadosDetallado += '<td><strong>'+result.fisica.detallado.amount+'</strong></td></tr>';
                                    }
                                }
                            }
                        );
                        $('#totalizacion #totaF-2 .estados tbody').html(estadosDetallado);
                        $('#totaF-2 .loading').hide();
                        $('#totaF-2').show();
                    }
                );
            }
        );
        $("#botonPagosFisica").on("click", function(event)
            {
                var factura = $("input[name=factura]:checked").attr("id");
                var currencyActual = $('#id_currency').val();
                $('#totaF-4 .loading').show();
                $('#totaF-4 table').hide();
                var estadosPagos = '';
                $.getJSON("../modules/tpvtienda/classes/actions/actionsEstadisticas.php",
                    {token: token, action: 'totalizacionFisicaPagos', dia: $('#desdeFecha').val(), diaFin: $('#hastaFecha').val(), id_lang: id_lang,
                    id_shop: id_shop, id_currency: $('#id_currency').val(), id_employee: id_employee, ventasOnline: $('#onlineButton').is(':checked'), ventasFisica: $('#fisicaButton').is(':checked'),
                    factura: factura}, function(data) {
                        var i = 0;
                        $.each(data, function(index, result){
                                if(typeof result.fisica ==='object' && result.fisica !=null) {
                                        if(typeof result.fisica.pagos != 'undefined') {
                                                (i++%2==0)? coloreo = 'class="alt_row"': coloreo = '';
                                                estadosPagos += '<tr '+coloreo+'>';
                                                estadosPagos += '<td>'+result.fisica.pagos.id_order+'</td>';
                                                estadosPagos += '<td >'+result.fisica.pagos.name+'</td>';
                                                estadosPagos += '<td><strong>'+result.fisica.pagos.amount+'</strong></td></tr>';
                                        }
                                }
                                if(typeof result.date != 'undefined')
                                    $('#ventas .date').html(result.date);
                        });
                        $('#totalizacion #totaF-4 .estados tbody').html(estadosPagos);
                        $('#totaF-4 .loading').hide();
                        $('#totaF-4 table').show();
                    }
                );
            }
        );
        $("#botonProductosFisica").on("click", function(event){
            var factura = $("input[name=factura]:checked").attr("id");
            var currencyActual = $('#id_currency').val();
            totalTotalizacionProductosFisica = 0;
            totalTotalizacionProductosFisicaSinIva = 0;
            var prodGroupedFisica = 'off';
            if($('#prodGroupedFisica').attr('checked') == 'checked')
                prodGroupedFisica = 'on';
            $('#totaF-3 .loading').show();
            $('#totaF-3 .dataTables_wrapper').hide();
            $.getJSON("../modules/tpvtienda/classes/actions/actionsEstadisticas.php", {token: token, action: 'totalizacionFisicaProductos', dia: $('#desdeFecha').val(), diaFin: $('#hastaFecha').val(), id_lang: id_lang,
                id_shop: id_shop, id_currency: $('#id_currency').val(), id_employee: id_employee, ventasOnline: $('#onlineButton').is(':checked'), ventasFisica: $('#fisicaButton').is(':checked'),
                factura: factura, prodGrouped: prodGroupedFisica}, function(data) {
                var i = 0;
                $('table.totaF-3').DataTable().rows().remove().draw();
                $.each(data, function(index, result)
                    {
                        if(typeof result.fisica ==='object' && result.fisica !=null) {
                            if(typeof result.fisica.productos != 'undefined') {
                                estadosProductos = 1;
                                if(result.fisica.productos.img != "")
                                        var imgFisica = '<a rel="imgProdsFisica" class="fullscreenProduct" href="'+result.fisica.productos.img+'"><img width="30" height="30" src="'+result.fisica.productos.img+'"/></a>';
                                else
                                        var imgFisica = "";
                                $('.totaF-3').DataTable().row.add(
                                    [result.fisica.productos.id, result.fisica.productos.id_order, imgFisica, result.fisica.productos.name, result.fisica.productos.ref, result.fisica.productos.product_supplier_reference, result.fisica.productos.supplier, result.fisica.productos.cat, result.fisica.productos.stock, result.fisica.productos.quantity,
                                        result.fisica.productos.mayorista, result.fisica.productos.amountUnit, result.fisica.productos.amountSinIva, result.fisica.productos.amount]
                                ).draw(false);
                                totalTotalizacionProductosFisica += parseFloat(result.fisica.productos.amount);
                                totalTotalizacionProductosFisicaSinIva += parseFloat(result.fisica.productos.amountSinIva);
                                if(result.fisica.productos.i !=null) {
                                    $("#imagenesProductos").append("<a rel='fscreen_"+result.fisica.productos.i.id+"_0' class='fullscreenProduct' title='"+result.fisica.productos.i.name+"' href='"+result.fisica.productos.i.img+"'></a>");
                                }
                            }
                        }
                    }
                );
                $('#totaF-3 .loading').hide();
                $('#totaF-3 .dataTables_wrapper').show();
                $('#totalizacion #totalTotalizacionProductosFisica').html(formatCurrency(totalTotalizacionProductosFisica, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
            });
        });
        $("#botonTaxesPagos").on("click", function(event){
            var factura = $("input[name=factura]:checked").attr("id");
            var prodGroupedFisica = 'off';
            var currencyActual = $('#id_currency').val();
            if($('#prodGroupedFisica').attr('checked') == 'checked')
                prodGroupedFisica = 'on';
            $.getJSON("../modules/tpvtienda/classes/actions/actionsEstadisticas.php", {token: token, action: 'taxesPaymentMethod', dia: $('#desdeFecha').val(), diaFin: $('#hastaFecha').val(), id_lang: id_lang,
                id_shop: id_shop, id_currency: $('#id_currency').val(), id_employee: id_employee, ventasOnline: $('#onlineButton').is(':checked'), ventasFisica: $('#fisicaButton').is(':checked'),
                factura: factura, prodGrouped: prodGroupedFisica}, function(data) {
                var i = 0;
                $('#totaTT-2 table tbody').html("");  var totalTax = 0;
                var totalPreciosSinIva = 0;
                var totalTotalizacionIvas = 0;
                $.each(data, function(index, result)
                    {
                        if(typeof result.taxes != 'undefined' && result.taxes != "") {
                            $.each(result.taxes, function(index, tax)
                                {
                                    $("#totaTT-2 tbody").append("<tr class='detalleTax'>"+
                                        "<td>"+index+"</td>"+
                                        "<td>"+formatCurrency(tax.total_paid_tax_excl, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank'])+"</td>"+
                                        "<td>"+formatCurrency(tax.total_amount, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank'])+"</td>+" +
                                        "<td>"+formatCurrency((tax.total_paid_tax_excl+tax.total_amount), currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank'])+"</td>"+
                                        "</tr>");
                                        totalTotalizacionIvas += tax.total_paid_tax_excl+tax.total_amount;
                                        totalPreciosSinIva += tax.total_paid_tax_excl;
                                        totalTax += tax.total_amount;
                                }
                            );
                            $("#taxTable").show();
                        }
                    }
                );
                $('#totalizacion #totalPaymentsTotalizacionIvas').html(formatCurrency(totalTotalizacionIvas, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
                $('#totalizacion #totalPaymentsPreciosSinIva').html(formatCurrency(totalPreciosSinIva, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
                $('#totalizacion #totalPaymentsTax').html(formatCurrency(totalTax, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
            });
        });
        $("#ventas .filtrarEmpleado").on("click", function(event) {
            id_employee=[];
            if($(this).attr("id") != "allEmp") {
                $("#allEmp").prop('checked', false).checkboxradio('refresh');
                if($("input[name=empleado]:checked").length >= 1) {
                    $("input[name=empleado]:checked").each(function(){
                        id_employee.push($(this).attr("id").replace("empleado", ""));
                    });
                }else{
                    $("#allEmp").prop('checked', true).checkboxradio('refresh');
                    id_employee = "allEmp";
                }
            }else {
                $("input[name=empleado]:checked").each(function(){
                    $(this).prop('checked', false).checkboxradio('refresh');
                });
                $(this).prop('checked', true).checkboxradio('refresh');
                id_employee = "allEmp";
            }

            $("input[name=id_employee]").val(id_employee);
            getTotalizacion();
            if(id_employee != 'allEmp') {
                $("#ventas .employeeFiltered span").html($("#ventas label[for="+$("input[name=empleado]:checked").attr("id")+"]").html());
                $("#ventas .employeeFiltered").show();
            }else
                $("#ventas .employeeFiltered").hide();
        });
        $("#ventas .filtrarPerfil").on("click", function(event){
            var id_perfil = $("input[name=perfil]:checked").attr("id").replace("perfil", "");
            getTotalizacion();
            $(".filtrarEmpleado").prop('checked', false).checkboxradio('refresh');
            if(id_perfil != 'allProf') {
                $("#ventas .profileFiltered span").html($("#ventas label[for="+$("input[name=perfil]:checked").attr("id")+"]").html());
                $(".profile_"+id_perfil).prop('checked', true).checkboxradio('refresh');
                $("#ventas .profileFiltered").show();
            }else {
                $("#allEmp").prop('checked', true).checkboxradio('refresh');
                $("#ventas .profileFiltered").hide();
            }
        });
        $("#ventas .filtrarFactura").on("click", function(event){
            var factura = $("input[name=factura]:checked").attr("id");
            $('input.factura').val(factura);
            getTotalizacion();
        });

        $("#onlineButton").on("click", function(event){
            if($(this).is(':checked'))
                $("#contenedorOnline").show();
            else
                $("#contenedorOnline").hide();
            getTotalizacion();
        });

        $("#fisicaButton").on("click", function(event){
            if($(this).is(':checked'))
                $("#contenedorFisica").show();
            else
                $("#contenedorFisica").hide();
            getTotalizacion();
        });

        $('table.totaO-3').DataTable({
            dom: 'Tf<"clear">lBrtip',
            buttons:[
                {
                    extend: 'copy', footer: true, text: copyTxT, attr: {id: 'allan'},
                    exportOptions: {columns: ':visible'},
                    footer:false
                },
                {
                    extend: 'csv', footer: true,
                    exportOptions: {columns: ':visible'},
                    footer:false
                },
                {
                    extend: 'excel', footer: true,
                    exportOptions: {columns: ':visible'},
                    footer:false
                },
                {
                    extend:'pdf', footer: true,
                    exportOptions: {columns: ':visible'},
                    footer:false
                },
                {
                    extend: 'print',
                    exportOptions: {columns: ':visible'},
                    footer:false,
                    customize: function (win) {
                        $(win.document.body)
                        .css('font-size', '10pt');
                        //                          .prepend('<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />');
                        $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                    }
                },
                {
                    extend:'colvis',text:columnsTxt
                }
            ],
            layout: {
                topStart: {
                    buttons: ['colvis']
                }
            },
            stateSave: true,
            "oLanguage": traducciones,
            "info": false, // Will show "1 to n of n entries" Text at bottom
            "lengthChange": false, // Will Disabled Record number per page
            "bPaginate": false,
            "columnDefs": [
                { targets: [1,5, 6], visible: false},
                { targets: '_all', visible: true }
            ] ,
            "drawCallback": function (settings) {
                crearFiltrosFooterProducto(this.api(),"online");
                var totalMayo = 0;
                var totalCantidades = 0;
                var currencyActual = $('#id_currency').val();
                var cantidades = this.api().column(9, { page: 'current'}).data();
                var precMayos = this.api().column(10, { page: 'current'}).data();
                cantidades.each(function (d, j){
                    totalMayo += d * precMayos[j];
                    totalCantidades += parseInt(d);
                });
                $("table.totaO-3 .totalcantidad").html(totalCantidades);
                $("table.totaO-3 .totalmayorista").html(formatCurrency(totalMayo, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
            }
        });
        $('table.totaO-3').on( 'column-visibility.dt', function ( e, settings, column, state ) {
            crearFiltrosFooterProducto($('table.totaO-3').dataTable().api(),"online");
        } );

        $('table.totaF-3').DataTable({
            dom: 'Tf<"clear">lBrtip',
            buttons:[
                {
                    extend: 'copy', footer: true, text: copyTxT, attr: {id: 'allan'},
                    exportOptions: {columns: ':visible'},
                    footer:false
                },
                {
                    extend: 'csv', footer: true,
                    exportOptions: {columns: ':visible'},
                    footer:false
                },
                {
                    extend: 'excel', footer: true,
                    exportOptions: {columns: ':visible'},
                    footer:false
                },
                {
                    extend:'pdf', footer: true,
                    exportOptions: {columns: ':visible'},
                    footer:false
                },
                {
                    extend: 'print',
                    exportOptions: {columns: ':visible'},
                    footer:false,
                    customize: function (win) {
                            $(win.document.body)
                            .css('font-size', '10pt');
                            //                          .prepend('<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />');
                            $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                    }
                },
                {
                    extend:'colvis',text:columnsTxt
                }
            ],
            layout: {
                topStart: {
                    buttons: ['colvis']
                }
            },
            stateSave: true,
            "columnDefs": [
                { targets: [1,5, 6], visible: false},
                { targets: '_all', visible: true }
            ] ,
            "oLanguage": traducciones,
            fixedHeader: true,
            "info": false, // Will show "1 to n of n entries" Text at bottom
            "lengthChange": false, // Will Disabled Record number per page
            "bPaginate": false,
            "drawCallback": function (settings) {
                var precioMayorista = 0;
                var totalCantidades = 0;
                crearFiltrosFooterProducto(this.api(),'fisica');
                var totalMayo = 0;
                var currencyActual = $('#id_currency').val();
                var cantidades = this.api().column(9, { page: 'current'}).data();
                var precMayos = this.api().column(10, { page: 'current'}).data();
                cantidades.each(function (d, j){
                    totalMayo += d * precMayos[j];
                    totalCantidades += parseInt(d);
                });
                $("table.totaF-3 .totalcantidad").html(totalCantidades);
                $("table.totaF-3 .totalmayorista").html(formatCurrency(totalMayo, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
            }
        });
        $('table.totaF-3').on( 'column-visibility.dt', function ( e, settings, column, state ) {
            crearFiltrosFooterProducto($('table.totaF-3').dataTable().api(),'fisica');
        } );
        $('table.devsTable').DataTable(
            {
            dom: 'Tf<"clear">lBrtip',
            buttons:[
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                {
                extend: 'print',
                customize: function (win) {
                        $(win.document.body)
                        .css('font-size', '10pt');
                        //                          .prepend('<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />');
                        $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                    }
                }
            ],
            "oLanguage": traducciones,
            fixedHeader: true,
            "info": false, // Will show "1 to n of n entries" Text at bottom
            "lengthChange": false, // Will Disabled Record number per page
            "bPaginate": false,
            "drawCallback": function (settings) {
                var totalMayo = 0;
                var currencyActual = $('#id_currency').val();
                var cantidades = this.api().column(8, { page: 'current'}).data();
                var precMayos = this.api().column(9, { page: 'current'}).data();
                cantidades.each(function (d, j){
                    totalMayo += d * precMayos[j];
                });
                $("table.devsTable .totalmayorista").html(formatCurrency(totalMayo, currencies[currencyActual]['format'], currencies[currencyActual]['sign'], currencies[currencyActual]['blank']));
            }
                //  "pageLength": 30,
                //  "iDisplayLength":10,
                //  "aLengthMenu": [[30, 60, 100,200, 500, 1000, 99999999999], [30, 60, 100, 200, 500, 1000, "All"]],
                //  "sPaginationType":"full_numbers",
                //  "bLengthChange":true,
        });
    }
);
$( function() {
        $( "a.sinlink" ).tooltip();
    } );
