// variables del entorno
var cantidadClientes = 100;
var inicioClientes = 0;

function getClientes(inicio){
    resizeContClientesLista();
    if(inicio == 1){
        inicioClientes = 0;
        $('#'+$.mobile.activePage.attr('id')+' .clientes .loaderClientes').show();
        $('#'+$.mobile.activePage.attr('id')+' .clientesLista').slideUp("slow");
        $('#'+$.mobile.activePage.attr('id')+' .clientesMensaje').hide();
    }
    $('#'+$.mobile.activePage.attr('id')+' .contClientesLista').html("");
    var error = 0;
    $.getJSON("../modules/tpvtienda/classes/actions/actionsClientes.php",{token:token, action:'getClientes',init:inicio,inicioclientes:inicioClientes,
        id_currency: $("#currencyPOS").val(),cantidad: cantidadClientes,filter: $('#'+$.mobile.activePage.attr('id')+' .filterCliente').val(),id_employee: id_employee,id_shop: id_shop},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(result.error != null){
                    error = 1;
                    $('#'+$.mobile.activePage.attr('id')+' .clientesMensaje').html('<div class="error ui-shadow-icon ui-btn ui-shadow ui-corner-all">'+errores[result.error]+'</div>');
                }else{
                    if(typeof result.customer.email != 'undefined')
                        var campoAdicional = result.customer.email;
                    if(typeof result.customer.phone != 'undefined')
                        var campoAdicional = result.customer.phone;
                    $('#'+$.mobile.activePage.attr('id')+' .contClientesLista').append("<div class='cliente' id='cliente_"+result.customer.id+"' >"+
                            "<div class='contCliente' onclick='elegirCliente("+result.customer.id+")'>"+
                            "<span class='nombre'>"+result.customer.name+(result.customer.company != "" ? ", "+result.customer.company : "")+"</span>"+
                            "<span class='campoAdicCliente'>"+campoAdicional+"</span></div>"+
                            "<div id='buttonAddress_"+result.customer.id+"'class='buttonAddress' onclick='abrirCliente("+result.customer.id+");' title='"+result.customer.name+"'>"+
                                "<a href='#' class='ui-btn ui-shadow ui-corner-all ui-icon-edit ui-btn-icon-notext ui-btn-inline'></a>"+
                            "</div></div>");
                }
            });
            $('#'+$.mobile.activePage.attr('id')+' .clientes .loaderClientes').hide();
            if(error == 0){
                if(inicio == 1)
                   $('#'+$.mobile.activePage.attr('id')+' .clientesLista').slideDown();
                inicioClientes += cantidadClientes;
            }else{
                $('#'+$.mobile.activePage.attr('id')+' .clientesLista').hide();
                $('#'+$.mobile.activePage.attr('id')+' .clientesMensaje').show();
            }


        }
    });
}
function resizeContClientesLista(){
    var altura = $(window).height();
    var alturaBarraBusqueda = $('#'+$.mobile.activePage.attr('id')+' .clientes .wrapperClientes .filterCliente').outerHeight();
    var alturaBottonAnadirCliente = $('#'+$.mobile.activePage.attr('id')+' .clientes .anadirClienteButton').outerHeight();
    var alturah1 = $('#'+$.mobile.activePage.attr('id')+' .clientes h1.old').outerHeight();
    var paddingContenedor = 42;
    var altura2 = altura-(alturah1+alturaBottonAnadirCliente+alturaBarraBusqueda+paddingContenedor);

    $('#'+$.mobile.activePage.attr('id')+' .clientesLista').css({"height":altura2+'px'});
    var alturatitulo = $('#'+$.mobile.activePage.attr('id')+' .clientes h1').outerHeight();
    var alturaBottonVolver = 36;
    var alturaPestana = 35;
    var altura = altura-(alturatitulo+alturaBottonVolver+alturaPestana);

    $('#'+$.mobile.activePage.attr('id')+' #tabs-1').css({"height":altura+'px'});
    $('#'+$.mobile.activePage.attr('id')+' #tabs-2').css({"height":altura+'px'});
    $('#'+$.mobile.activePage.attr('id')+' #tabs-3').css({"height":altura+'px'});

}

function abrirCliente(id_customer){
    var html = "";
    var selected = "";
    var direccionesContador = 0;
    // limpio valores
    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress .addressMore').remove();
    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-0 input').val('');
    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-0 textarea').html('');
    $('#'+$.mobile.activePage.attr('id')+' .clientesInfo .address_delivery').html('');
    // trozo para limpiar los estilos
    limpiarEstilosNavBar("navBarAddress");
    $('#'+$.mobile.activePage.attr('id')+' #navBarAddress').navbar('destroy');
    $('#'+$.mobile.activePage.attr('id')+' .tabsCliente').navbar();
    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-0 select').val($('#'+$.mobile.activePage.attr('id')+' .tabsAddress-0 select option:first').val());
    $('#'+$.mobile.activePage.attr('id')+' .masDeUna').remove();
    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-0 select').selectmenu();
    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-0 select').selectmenu('refresh');
    $('#'+$.mobile.activePage.attr('id')+' .tabsCliente input[type=checkbox]').checkboxradio();
    $('#'+$.mobile.activePage.attr('id')+' .tabsCliente [data-role="listview"]').listview();
    $('#'+$.mobile.activePage.attr('id')+' .tabsCliente input[type=checkbox]').prop('checked', false).checkboxradio('refresh');
    // busqueda de direcciones
    $('#'+$.mobile.activePage.attr('id')+' .clientesInfo select[name=customer_id_address_delivery],.clientesInfo select[name=customer_id_address_invoice], .clientesInfo input').html("");
    if($("#currencyPOS").val() != undefined)
        var currPOS = $("#currencyPOS").val();
    else
        var currPOS = id_currency;
    $.getJSON("../modules/tpvtienda/classes/actions/actionsClientes.php",{token:token, action:'getClienteInfo', id_customer: id_customer, id_currency: currPOS,
        id_shop: id_shop, id_lang:id_lang},function(data) {
            var posIdAddressDelivery = 0;
            var posIdAddressInvoice = 0;
            $.each(data, function(index, result) {
                if(result.error != null)
                    mostrarError(result.error);
                if(result.cartAddress != null){
                    posIdAddressDelivery = result.cartAddress.d;
                    posIdAddressInvoice = result.cartAddress.i;
                }
                if(result.customer != null){
                    $('#'+$.mobile.activePage.attr('id')+' .clientesInfo .clientes input.id_customer_popup').val(result.customer.id);
                    $('#'+$.mobile.activePage.attr('id')+' .clientesInfo .clientes input[name=firstname]').val(result.customer.nombre);
                    $('#'+$.mobile.activePage.attr('id')+' .clientesInfo .clientes input[name=firstname]').parent().children("label").addClass('active focusIn');
                    $('#'+$.mobile.activePage.attr('id')+' .clientesInfo .clientes input[name=lastname]').val(result.customer.apellido);
                    $('#'+$.mobile.activePage.attr('id')+' .clientesInfo .clientes input[name=lastname]').parent().children("label").addClass('active focusIn');
                    $('#'+$.mobile.activePage.attr('id')+' .clientesInfo .clientes input[name=email]').val(result.customer.email);
                    $('#'+$.mobile.activePage.attr('id')+' .clientesInfo .clientes input[name=email]').parent().children("label").addClass('active focusIn');
                    $('#'+$.mobile.activePage.attr('id')+' .clientesInfo .clientes input[name=birthday]').addClass('active focusIn');
                    $('#'+$.mobile.activePage.attr('id')+' .clientesInfo .clientes input[name=birthday]').val(result.customer.birthday);
                    $('#'+$.mobile.activePage.attr('id')+' .clientesInfo .clientes textarea[name=note]').val(result.customer.note);
                    $('#'+$.mobile.activePage.attr('id')+' .clientesInfo .clientes input[name=active]').val(result.customer.active);
                    $('#'+$.mobile.activePage.attr('id')+' .clientesInfo #botonAddCustomer').html('<div class="alterado ui-icon-user ui-btn-icon-left ui-shadow ui-btn ui-corner-all" onclick="addCustomerConDireccion('+id_customer+',\'#tabs-1\')">'+anadirAlPedido+'</div>');
                    if(result.customer.groups != null){
                        $(result.customer.groups ).each(function (key, item){
                            $('#'+$.mobile.activePage.attr('id')+' #groupC-'+item).prop('checked', true).checkboxradio('refresh');
                        });
                    }
          //          $(".clientesInfo .clientes input[name=birthday]").datepicker({
//                        dateFormat : 'yy-mm-dd',
//                        changeMonth: true,
//                        changeYear: true,
//                        yearRange: "-120:+0",
//                        maxDate: "+1m",
//                        beforeShow: function() {
//                            setTimeout(function(){
//                                $('.ui-datepicker').css('z-index', 2);
//                            }, 0);
//                        },
//
//                        onSelect: function( selectedDate ) {
//                            $.getJSON("../modules/tpvtienda/classes/actions/actions.php",{token:token, action:'guardarInfoCliente',name:"birthday", value:selectedDate,
//                               id_customer:$('#'+$.mobile.activePage.attr('id')+' .id_customer_popup').val(), id_currency: $('#id_currency').val(), id_shop: id_shop},function(data) {
//                                if(data != null) {
//                                    efectoGuardado('#customer_birthday');
//                                }
//                            });
//                        }
//                    });
                    if(result.customer.group_default != null){
                        $('#'+$.mobile.activePage.attr('id')+' .clientesInfo select[name=id_default_group] option').removeAttr('selected');
                        $('#'+$.mobile.activePage.attr('id')+' .clientesInfo select[name=id_default_group] option[value='+result.customer.group_default+']').attr('selected','selected');
                        $('#'+$.mobile.activePage.attr('id')+' .clientesInfo select[name=id_default_group]').selectmenu().selectmenu('refresh');
                    }
                    if(result.customer.newsletter == 1)
                        $('#'+$.mobile.activePage.attr('id')+' .clientesInfo input[name=newsletter]').prop('checked', true).checkboxradio('refresh');
                    if(result.customer.extra_field != null)
                        $('#'+$.mobile.activePage.attr('id')+' .clientesInfo .clientes input[name=extra_field]').val(result.customer.extra_field);
                    if(result.customer.extra_field_select != null){
                        $('#'+$.mobile.activePage.attr('id')+' .clientesInfo .clientes select[name=extra_field_select] option').removeAttr('selected');
                        $('#'+$.mobile.activePage.attr('id')+' .clientesInfo .clientes select[name=extra_field_select] option[value='+result.customer.extra_field_select+']').attr('selected','selected');
                        $('#'+$.mobile.activePage.attr('id')+' .clientesInfo .clientes select[name=extra_field_select]').selectmenu().selectmenu('refresh');
                    }
                    if(result.customer.id_gender == 1 || result.customer.id_gender == 0)
                        $('#'+$.mobile.activePage.attr('id')+' .clientesInfo input[name=id_gender]').prop('checked', false).checkboxradio('refresh');
                        $('#'+$.mobile.activePage.attr('id')+' .clientesInfo #id_gender_'+result.customer.id_gender).prop('checked', true).checkboxradio('refresh');
                    if(result.customer.optin == 1)
                        $('#'+$.mobile.activePage.attr('id')+' .clientesInfo input[name=optin]').prop('checked', true).checkboxradio('refresh');
                    if(result.customer.surchage!= null){
                        if(result.customer.surchage == false)
                            var surchageCliente = 0;
                        else
                            var surchageCliente = 1;
                        $('#'+$.mobile.activePage.attr('id')+' .clientesInfo #surchage_'+surchageCliente).prop('checked', true).checkboxradio('refresh');
                    }
                }
                if(result.direccion != null){
                    $('#'+$.mobile.activePage.attr('id')+' #errorNoDireccion').hide();
                    direccionesContador++;
                    if(direccionesContador > 1){
                        $('#'+$.mobile.activePage.attr('id')+' .tabsAddress select.indicesDirecciones').append('<option value="tabsAddress-'+direccionesContador+'" data-direccion="'+result.direccion.id+'" class="masDeUna">'+result.direccion.alias+'</option>');
                        $('#'+$.mobile.activePage.attr('id')+' .tabsAddress').append('<div style="display:none" class="tabsAddress-'+direccionesContador+' direcciones addressMore ui-body-d"></div>');
                        $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador).html($('#'+$.mobile.activePage.attr('id')+' .tabsAddress-0 .contenedor').html());
                    }else{
                        $('#'+$.mobile.activePage.attr('id')+' .tabsAddress select.indicesDirecciones').append('<option value="tabsAddress-'+direccionesContador+'" data-direccion="'+result.direccion.id+'" class="masDeUna">'+result.direccion.alias+'</option>');
                        var contenidoDireccion = '<div style="display:none" class="tabsAddress-'+direccionesContador+' direcciones addressMore ui-body-d">';
                        contenidoDireccion += $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-0').html();
                        contenidoDireccion += "</div>";
                        $('#'+$.mobile.activePage.attr('id')+' .tabsAddress').append(contenidoDireccion);
                    }
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' input.id_address').val(result.direccion.id);
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' input[name=alias]').val(result.direccion.alias);
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' input[name=firstname]').val(result.direccion.nombre);
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' input[name=lastname]').val(result.direccion.apellido);
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' input[name=address1]').val(result.direccion.address1);
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' input[name=address2]').val(result.direccion.address2);
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' input[name=dni]').val(result.direccion.dni);
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' input[name=phone]').val(result.direccion.telefono);
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' input[name=phone_mobile]').val(result.direccion.movil);
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' .contCountry').html('');
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' .contCountry').append('<select id="id_country_'+direccionesContador+'" class="id_country" name="id_country_'+direccionesContador+'"></select>');
                    $.each(countries,function(index,value){
                        if (value["id"] == result.direccion.pais)
                            selected = " selected";
                        else
                            selected = "";
                        $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' select[name=id_country_'+direccionesContador+']').append('<option value="'+value["id"]+'"'+selected+'>'+value["name"]+'</option>');
                    });
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+" select[name=id_country_"+direccionesContador+"]").selectmenu();
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+" select[name=id_country_"+direccionesContador+"]").selectmenu('refresh');
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' .contStates .selectStates').html('');
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' .contStates .selectStates').append('<select id="id_state_'+direccionesContador+'" name="id_state" onchange="guardarDireccionCliente(this)"></select>');
                    updateState("tabsAddress-"+direccionesContador,result.direccion.id_state);
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' input[name=postcode]').val(result.direccion.cp);
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' input[name=city]').val(result.direccion.ciudad);
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' input[name=other]').val(result.direccion.other);
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' input[name=company]').val(result.direccion.company);
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' input[name=vat_number]').val(result.direccion.vat_number);
                    if(result.direccion.active == 1)
                        $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' input[name=active]').prop('checked',true);
                    else
                        $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' input[name=active]').prop('checked',false);
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' .botonGuardarDireccion').remove();
                    $('#'+$.mobile.activePage.attr('id')+' .tabsAddress-'+direccionesContador+' input').parent().children("label").addClass('active focusIn');
                   //  $('#'+$.mobile.activePage.attr('id')+' .clientesInfo select[name=customer_id_address_delivery]').append('<option value="'+result.direccion.id+'">'+result.direccion.alias+'</option>');
                    $('#'+$.mobile.activePage.attr('id')+' .clientesInfo select[name=customer_id_address_invoice]').append('<option value="'+result.direccion.id+'">'+result.direccion.alias+'</option>');
                    if(!$.isEmptyObject(result.direccion.movil) && !$.isEmptyObject(result.direccion.telefono)){
                        var telefonoDire = result.direccion.movil+' / '+result.direccion.telefono+'<br>';
                    }else if(!$.isEmptyObject(result.direccion.movil) && $.isEmptyObject(result.direccion.telefono)){
                        var telefonoDire = result.direccion.movil+'<br>';
                    }else if($.isEmptyObject(result.direccion.movil) && !$.isEmptyObject(result.direccion.telefono)){
                        var telefonoDire = result.direccion.telefono+'<br>';
                    }else
                        var telefonoDire = "";
                    $('#'+$.mobile.activePage.attr('id')+' .clientesInfo .address_delivery').append('<article  class="address_item col-lg-6 '+
                                                                                                        ((posIdAddressDelivery == result.direccion.id) || (posIdAddressDelivery == null && direccionesContador == 1) ? 'elegida' : '')+'">'+
                                                                                                        '<header id="address_delivery_'+result.direccion.id+'" class="address-header" onclick="elegirDireccion(this)">'+
                                                                                                            '<div class="address-title">'+
                                                                                                                '<span class="address-alias">'+result.direccion.alias+'</span>'+
                                                                                                            '</div>'+
                                                                                                            '<hr>'+
                                                                                                            '<div class="address">'+
                                                                                                                result.direccion.nombre+' '+result.direccion.apellido+'<br>'+
                                                                                                                result.direccion.dni+'<br>'+
                                                                                                                result.direccion.address1+'<br>'+
                                                                                                                result.direccion.cp+' '+result.direccion.ciudad+'<br>'+
                                                                                                                result.direccion.state+','+result.direccion.pais+'<br>'+
                                                                                                                telefonoDire+
                                                                                                                '<i class="material-icons" '+
                                                                                                                    ((posIdAddressDelivery == result.direccion.id) || (posIdAddressDelivery == null && direccionesContador == 1) ? '' : 'style="display:none"')+
                                                                                                                    '>check_circle_outline</i>'+
                                                                                                            '</div>'+
                                                                                                        '</header>'+
                                                                                                        '<div class="ui-shadow ui-btn ui-corner-all" onclick="modificarDireccion('+result.direccion.id+')">'+modificar+'</div>'+
                                                                                                    '</article>');
                }
            });
            // esto lo hago por si al abrir cliente el carrito ya tenia una direción del mismo cliente ya asignada, para que no seleccione la primera direción, si no la que corresponde
            if(posIdAddressDelivery ==0 && posIdAddressInvoice == 0){
               //  $('#'+$.mobile.activePage.attr('id')+' .clientesInfo select[name=customer_id_address_delivery] option:first').attr('selected','selected');
                $('#'+$.mobile.activePage.attr('id')+' .clientesInfo select[name=customer_id_address_invoice] option:first').attr('selected','selected');
            }else{
              //   $('#'+$.mobile.activePage.attr('id')+' .clientesInfo select[name=customer_id_address_delivery] option[value='+posIdAddressDelivery+']').attr('selected','selected');
                $('#'+$.mobile.activePage.attr('id')+' .clientesInfo select[name=customer_id_address_invoice] option[value='+posIdAddressInvoice+']').attr('selected','selected');
            }
          //   $('#'+$.mobile.activePage.attr('id')+' .clientesInfo select[name=customer_id_address_delivery]').selectmenu().selectmenu('refresh');
            $('#'+$.mobile.activePage.attr('id')+' .clientesInfo select[name=customer_id_address_invoice]').selectmenu().selectmenu('refresh');
            $('#'+$.mobile.activePage.attr('id')+' .clientes h1.new').html($('#cliente_'+id_customer+' .nombre').html());
            $('#'+$.mobile.activePage.attr('id')+' .clientes h1.old').hide();
            $('#'+$.mobile.activePage.attr('id')+' .anadirClienteButton').hide();
            $('#'+$.mobile.activePage.attr('id')+' .clientes h1.new').show();
    //		if(direccionesContador > 0)
    //			$('.indicesDirecciones:first a').trigger("click");
            updateState("tabsAddress-0");
            var instanciaTabs = $('#'+$.mobile.activePage.attr('id')+' .tabsAddress').tabs();
            if(instanciaTabs != undefined)
                $('#'+$.mobile.activePage.attr('id')+' .tabsAddress').tabs("refresh");
            else
                $('#'+$.mobile.activePage.attr('id')+' .tabsAddress').tabs();

            $('#'+$.mobile.activePage.attr('id')+' #tabsCliente ul li:first-child a').trigger("click");
            $('#'+$.mobile.activePage.attr('id')+' .clientesInfo').show( "slide" , { direction: "right" }, 500);
            $('#'+$.mobile.activePage.attr('id')+' .wrapperClientes').hide( "slide" , { direction: "left" }, 500);
    });
}
function elegirDireccion(direccion){
    var id_address = $(direccion).attr("id").replace("address_delivery_","");
    $('#'+$.mobile.activePage.attr('id')+' .address_delivery .address_item .address i').hide();
    $('#'+$.mobile.activePage.attr('id')+' .address_delivery #address_delivery_'+id_address+' .address i').show();
    $('#'+$.mobile.activePage.attr('id')+' .address_delivery .address_item header').removeClass("elegida");
    $('#'+$.mobile.activePage.attr('id')+' .address_delivery #address_delivery_'+id_address).parent().addClass("elegida");
    if($("#currencyPOS").val() != undefined)
        var currPOS = $("#currencyPOS").val();
    else
        var currPOS = id_currency;
    $.getJSON("../modules/tpvtienda/classes/actions/actions.php",{token:token, action:'updateAddress',id_cart:id_cart,id_currency:currPOS,
        id_address_delivery:id_address,id_shop: id_shop},function(data) {
        if(data != null) {
            $.each(data, function(index, result) {
            	if(result.error != null){
            		mostrarError(result.error);
            	}else{
            		updateCompra();
            	}
            });
        }
    });
}
function limpiarEstilosNavBar(selector){
    $("#"+selector).find("*").andSelf().each(function(){
        $(this).removeClass(function(i, cn){
            var matches = cn.match (/ui-[\w\-]+/g) || [];
            return (matches.join (' '));
        });
        if ($(this).attr("class") == "") {
            $(this).removeAttr("class");
        }
    });
}
function addCustomerConDireccion(id_cust, selector){
    var id_address_invoice = $('#'+$.mobile.activePage.attr('id')+" select[name=customer_id_address_invoice]").val() ;
    var id_address_delivery = $('#'+$.mobile.activePage.attr('id')+" .elegida header").attr("id").replace("address_delivery_","");
    addCustomer(id_cust,selector,id_address_delivery,id_address_invoice);
}

function addCustomer(id_cust,selector,id_address_delivery,id_address_invoice,abrirDespues){
    if($("#currencyPOS").val() != undefined)
        var currPOS = $("#currencyPOS").val();
    else
        var currPOS = id_currency;

    if($.mobile.activePage.attr('id') == "pedidoPage")
        var id_carrito = id_cart_pedido;
    else
        var id_carrito = id_cart;
    $.getJSON("../modules/tpvtienda/classes/actions/actionsClientes.php",{token:token, action:'addCustomer', id_cart:id_carrito,id_customer:id_cust,id_currency: currPOS,
        id_shop: id_shop,id_address_invoice:id_address_invoice, id_address_delivery:id_address_delivery},function(data) {
        if(data != null) {
            $.each(data, function(index, result) {
                if(result.error != null){
                    mostrarError(result.error);
                }
                if(result.infoCustomer != null){
                    $('#id_customer').val(id_cust);
                    id_customer = id_cust;
                    // vuelvo a cargar esto porque no coge las variables de
                    // fuera del getJSON
                	$('#customerSeleccionado span').html(result.infoCustomer.nombreCompleto);

                    if(abrirDespues)
                        abrirCliente(id_cust);
                    modo=0;
                    if($.mobile.activePage.attr('id') == "pedidoPage"){
                        getOrder(id_order_global);
                    }else{
                        // si no es empleado solo puedo buscar devoluciones de el mismo
                        if(result.infoCustomer.emp == 1) {
                            $("#titleCliente").show();
                            $(".contClientePedidoDevs .ui-input-text").hide();
                        }else{
                            $("#titleCliente").hide();
                            $(".contClientePedidoDevs .ui-input-text").show();
                        }
                    	$('.maskTPVTienda').trigger("click");
                    	$("#subTPVTienda").removeClass("open");
                    	$(".clientes").removeClass("open");
                    	$('#closeRemoveCustomer').show();
                    	$("#customerSeleccionado").addClass("alterado");
                    	hookJS('updateCustomer');
                    	updateCompra();
                    }
                }
            });
        }
    });
}
function cambioCliente(id_customer,id_address_delivery_cambio_cliente,id_address_invoice_cambio_cliente){
    if($("#currencyPOS").val() != undefined)
        var currPOS = $("#currencyPOS").val();
    else
        var currPOS = id_currency;
    $.getJSON("../modules/tpvtienda/classes/actions/actionsClientes.php",{token:token, action:'addCustomerAdminOrder', id_employee:id_employee,id_customer:id_customer,id_currency: currPOS,
        id_shop: id_shop,id_address_invoice:id_address_invoice_cambio_cliente, id_address_delivery:id_address_delivery_cambio_cliente,id_order:id_order_global},function(data) {
        if(data != null) {
            $.each(data, function(index, result) {
                if(result.error != null){
                    mostrarError(result.error);
                }
                if(result.ok != null){
                	hookJS('updateCustomer');
                    if($.mobile.activePage.attr('id') == "pedidoPage")
                        getOrder(id_order_global);
                    if($.mobile.activePage.attr('id') == "aCreditoPage")
                        actualizarPagoAcredito(id_order_global);
                    if($.mobile.activePage.attr('id') == "pedidoSAT")
                        abrirPedidoSat(id_order_global);
                    $('.maskTPVTienda').trigger("click");
                }
            });
        }
    });
}
function addAddress(){
    var telefono = $('#'+$.mobile.activePage.attr('id')+" .tabsAddress-0 input[name=phone]").val();
    if(telefono == '')
        telefono = '000000000';
    var postcode = $('#'+$.mobile.activePage.attr('id')+" .tabsAddress-0 input[name=postcode]").val();
    if(postcode == '')
        postcode = '00000';
    if($("#currencyPOS").val() != undefined)
        var currPOS = $("#currencyPOS").val();
    else
        var currPOS = id_currency;
    $.getJSON("../modules/tpvtienda/classes/actions/actionsClientes.php",{token:token, action:'guardarDireccionCompletaCliente',id_currency: currPOS, id_shop: id_shop,
       id_customer: $('#'+$.mobile.activePage.attr('id')+" .id_customer_popup").val(), alias:$('#'+$.mobile.activePage.attr('id')+" .tabsAddress-0 input[name=alias]").val(), firstname:$('#'+$.mobile.activePage.attr('id')+" .tabsAddress-0 input[name=firstname]").val(), lastname:$('#'+$.mobile.activePage.attr('id')+" .tabsAddress-0 input[name=lastname]").val(),
       address1:$('#'+$.mobile.activePage.attr('id')+" .tabsAddress-0 input[name=address1]").val(), address2:$('#'+$.mobile.activePage.attr('id')+" .tabsAddress-0 input[name=address2]").val(), dni:$('#'+$.mobile.activePage.attr('id')+" .tabsAddress-0 input[name=dni]").val(),
       phone_mobile:$('#'+$.mobile.activePage.attr('id')+" .tabsAddress-0 input[name=phone_mobile]").val(),phone:telefono, postcode:postcode, desconocido:desconocido,
       city:$('#'+$.mobile.activePage.attr('id')+" .tabsAddress-0 input[name=city]").val(), country:$('#'+$.mobile.activePage.attr('id')+" .tabsAddress-0 select[name=id_country]").val(), state:$('#'+$.mobile.activePage.attr('id')+" .tabsAddress-0 select[name=id_state]").val(),
       other:$('#'+$.mobile.activePage.attr('id')+" .tabsAddress-0 input[name=other]").val(), company:$('#'+$.mobile.activePage.attr('id')+" .tabsAddress-0 input[name=company]").val(), vat_number:$('#'+$.mobile.activePage.attr('id')+" .tabsAddress-0 input[name=vat_number]").val()},function(data) {
       if(data != null) {
           $.each(data, function(index, result) {
                if(result.error != null){
                    mostrarError(result.error);
                }
                if(result.ok == 'ok'){
                    $('.notificationGood').html(guardado);
                    $('.notificationGood').fadeIn();
                    $('.notificationGood').delay(1000).fadeOut();
                    abrirCliente($('#'+$.mobile.activePage.attr('id')+" .id_customer_popup").val());
                }
            });
       }
    });
}
function updateState(selector,value){
    $('#'+$.mobile.activePage.attr('id')+' .'+selector + ' select[name=id_state]').html('');
    var id_country = $('#'+$.mobile.activePage.attr('id')+' .'+selector+' select.id_country').val();
    selected = "";
    $('#'+$.mobile.activePage.attr('id')+' .'+selector + ' select[name=id_state]').selectmenu();
    $.getJSON("../modules/tpvtienda/classes/actions/actionsClientes.php",{token:token, action: 'getStates','country':id_country,id_shop: id_shop},function(data) {
        if(data.length !== 0){
            $('#'+$.mobile.activePage.attr('id')+' .'+selector+ " .contIdState").fadeIn('slow');
            $(data).each(function (key, item){
                if (value == item.state.id || (typeof value == "undefined" && item.state.defecto == "porDefecto"))
                    selected = " selected";
                else
                    selected = "";
                $('#'+$.mobile.activePage.attr('id')+' .'+selector + ' select[name=id_state]').append('<option value="'+item.state.id+'"'+selected+'>'+item.state.name+'</option>').selectmenu('refresh');
            });
            $('#'+$.mobile.activePage.attr('id')+' .'+selector + ' select[name=id_state]').selectmenu('refresh');

        }
        else{
            $('#'+$.mobile.activePage.attr('id')+' .'+selector+ " .contIdState").fadeOut('fast');
        }
    });
}
function anadirCliente(){
    var groups = [];
    $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name=groupAC]:checked').each(function() {
    	groups.push($(this).attr("class").replace("groupAC-", ""));
    });
    var opc_fields = [];
    $('#'+$.mobile.activePage.attr('id')+' input[name^=opc_]').each(function() {
    	opc_fields.push([$(this).attr("name").replace("opc_", ""),$(this).val()]);
    });
    $('#'+$.mobile.activePage.attr('id')+' .submitAnadirCliente').button('disable');
    if($.mobile.activePage.attr('id') == "pedidoPage")
        var id_carrito = id_cart_pedido;
    else
        var id_carrito = id_cart;
    $.getJSON(token_actions,{action:'anadirCliente', ajax : "1",id_shop: id_shop, id_lang:id_lang,
        nombre : $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name="nombre"]').val(),
        apellidos : $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name="apellidos"]').val(),
        direccion : $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name="address1"]').val(),
        direccion2 : $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name="address2"]').val(),
        telefono : $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name="phone"]').val(),
        telefono_movil : $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name="phone_mobile"]').val(),
        company : $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name="company"]').val(),
        vat_number : $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name="vat_number"]').val(),
        codigo_postal : $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name="postcode"]').val(),
        birthday : $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name="birthday"]').val(),
        id_gender : $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name="id_gender"]:checked').val(),
        email: $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name="email"]').val(),
        password: $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name="password"]').val(),
        dni: $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name="dni"]').val(),
        otro : $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm textarea[name="other"]').val(),
        pais : $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm select[name="id_country"]').val(),
        ciudad : $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name="city"]').val(),
        estado : $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm select[name="id_state"]').val(),
        newsletter : $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name="newsletter3"]').is(':checked'),
        optin : $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name="optin3"]').is(':checked'),
        id_cart: id_carrito,
        id_default_group:$('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm select[name="id_default_group"]').val(),
        groups:groups,
        direccion_predeterminada:direccion_predeterminada,
        desconocido:desconocido,
        opc_fields:opc_fields,
        extra_field:$('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name="extra_field"]').val(),
        extra_field_select:$('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm select[name="extra_field_select"]').val()},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(result.error != null){
                    mostrarError(result.error);
                    $('#'+$.mobile.activePage.attr('id')+' .submitAnadirCliente').delay(2000).button('enable');
                }
                if(result.customer != null){
                    $('#'+$.mobile.activePage.attr('id')+' #id_customer').val(result.customer.id);
                    id_customer = result.customer.id;
                    $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[type=checkbox]').attr("checked",false).checkboxradio("refresh");
                    $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[type=checkbox].groupAC-'+grupoClientes).attr("checked",true).checkboxradio("refresh");
                    $('#'+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').slideDown('fast');
                    $('#'+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(5000).slideUp('fast');
                    $('#'+$.mobile.activePage.attr('id')+' .maskTPVTienda').trigger("click");
                    hookJS('updateCustomer');
                    if($.mobile.activePage.attr('id') == "pedidoPage"){
                        //estoy dentro de un pedido
                        cambioCliente(result.customer.id,$('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name=nombre]').val(),result.customer.id_address_delivery,result.customer.id_address_invoice);
                    }else{
                        $('#'+$.mobile.activePage.attr('id')+' #customerSeleccionado span').html(result.customer.nombre);
                        $('#'+$.mobile.activePage.attr('id')+' #closeRemoveCustomer').show();
                    }
                    $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input').val('');
                    $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm textarea').val('');
                    $('#'+$.mobile.activePage.attr('id')+' .submitAnadirCliente').delay(2000).button('enable');
                }
            });
        }
    });
}
function recuperarCarritoId(idCarrito){
    id_cart = idCarrito;
    $.getJSON("../modules/tpvtienda/classes/actions/actionsClientes.php",{token:token, action: 'recuperarCarrito', id_cart :idCarrito , id_shop: id_shop},function(data) {
        $.each(data, function(index, result) {
            if(result.error != null)
                mostrarError(result.error);
            if(result.id_cart != null){
                updateCompra();
            }
            if(result.id_customer != null){
                $('#id_customer').val(result.id_customer);
                addCustomer(result.id_customer,'#cliente_'+id_customer);
                abrirCliente(result.id_customer);
            }
            if(result.nombre != null){
                $('#customerSeleccionado span').html(result.nombre);
                $('#closeRemoveCustomer').show();
         		$.mobile.changePage("#TPVTienda");
            }
            if(result.id_carrier != null){
                changeCarrier(result.id_carrier);
            }
        });
    });
}
function mostrarCarritos(id_customer){
    if (typeof carritosTable == 'object' || (typeof $.fn.DataTable != "undefined" && $.fn.DataTable.isDataTable( 'table.contCarritos' ) )) {
        $( 'table.contCarritos' ).DataTable().destroy();
    }
    var carritosTable = $('table.contCarritos').DataTable({
      	dom: '<"clear">rtip',
        "oLanguage":traducciones,
        "bPaginate":true,
        "pageLength": 30,
        "processing": true,
        "iDisplayLength":20,
        "PaginationType":"simple_numbers",
        "columnDefs": [ {
              "targets"  : 'no-sort',
              "orderable": false,
            }],
        "drawCallback": function ( settings ) {
            $("table.contCarritos tr td").on("click", function(event){
              //  $("h1.presutitle").hide();
//                $("h1.carrito").show();
                var tablaCarts = $(this).parent().attr("id");
                idCarrito = tablaCarts.replace("cart_", "");
              //   $("#contButtonCarrito").html('<button class="ui-btn ui-corner-all ui-shadow" onclick="recuperarCarrito('+idCarrito+')">'+recuperarTxT+'</button>');
               recuperarCarritoId(idCarrito);
            });
        },
        "bServerSide": true,
        "ajax": {
                "url" : "../modules/tpvtienda/classes/actions/actionsClientes.php?action=getCarritos&id_customer="+id_customer+"&id_shop="+id_shop+"&id_lang="+id_lang,
                "data": {
                	"token" : token
                }
        },
        //"sAjaxSource": "../modules/tpvtienda/classes/actions/actionsEstadisticas.php?action=stock&id_shop="+id_shop+"&id_lang="+id_lang,
        "bLengthChange":true,
    });

   // $('.clientes table.contCarritos tr:not(.header) td').on("click", function(event){
//        var idCarrito = $(this).parent().children("td").html();
//        if(event.target.className.indexOf("infoButton") == -1){
//            recuperarCarritoId(idCarrito);
//        }else{
//            getInfoButton(idCarrito);
//        }
//    });

}
function mostrarTarjeta(id_customer){
    $("#tarjetaClienteCont").html('');
    $("#tarjetaClienteCont").html('<iframe id="iframeTarjetaCliente" src="../modules/tpvtienda/classes/tarjetas/tarjetas.php?id_lang='+id_lang+'&id_shop='+id_shop+'&id_customer='+id_customer+'" width="100%" height="200"></iframe>');
    $("#popupTarjetaCliente").popup("open");
    $("#popupTarjetaCliente").bind({
       popupafterclose: function(event){modo=0;}
    });

}
function elegirCliente(id_customer){
    if($.mobile.activePage.attr('id') == "TPVTienda"){
        addCustomer(id_customer,'#cliente_'+id_customer);
    }else{
        cambioCliente(id_customer);
    }
}
function anadirClienteButton(){
    $('#'+$.mobile.activePage.attr('id')+' .clientes').removeClass('open');
    $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm').addClass('open');
    $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm .submitAnadirCliente').button();
    $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm select').selectmenu();
    $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm select').selectmenu('refresh');
    $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[type=checkbox]').checkboxradio();
    $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input[name=birthday]').addClass('active focusIn');
    $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm input').on('click', function(e) {
    	$('label.error').hide("slow");
    });
    anadirMascara();
    //$("#fechaCumple").datepicker({
//            dateFormat : 'yy-mm-dd',
//            changeMonth: true,
//            changeYear: true,
//            yearRange: "-120:+0",
//            maxDate: "+1m",
//            beforeShow: function() {
//                setTimeout(function(){
//                    $('.ui-datepicker').css('z-index', 2);
//                }, 0);
//            },
//
//            onSelect: function( selectedDate ) {
//            }
//        });
  	updateState('anadirClienteForm');
    $('#'+$.mobile.activePage.attr('id')+' .anadirClienteForm select.id_country').on('change click',function(e){
   		updateState('anadirClienteForm');
    });
}
function filterCliente(){
    $("#subTPVTienda").addClass("open");
    delay(function(){
        getClientes(1);
    },400 );
}
function guardarInfoCliente(input){
    var name = $(input).attr("name");
    var value = $(input).val();
    delay(function(){
        if($("#currencyPOS").val() != undefined)
            var currPOS = $("#currencyPOS").val();
        else
            var currPOS = id_currency;
        $.getJSON("../modules/tpvtienda/classes/actions/actionsClientes.php",{token:token, action:'guardarInfoCliente',name:name, value:value,
       	   id_customer:$('#'+$.mobile.activePage.attr('id')+' .id_customer_popup').val(), id_currency: currPOS, id_shop: id_shop},function(data) {
            if(data != null) {
               efectoGuardado(input);
            }
        });
    },400 );
}
function guardarInfoClienteCheckbox(checkbox){
    var id = $(checkbox).attr("id");
    var name = $(checkbox).attr("name");
  	var value = $(checkbox).is(":checked");
   	delay(function(){
   	    if($("#currencyPOS").val() != undefined)
            var currPOS = $("#currencyPOS").val();
        else
            var currPOS = id_currency;
        $.getJSON("../modules/tpvtienda/classes/actions/actionsClientes.php",{token:token, action:'guardarInfoCliente',name:name, value:value,
       	   id_customer:$('#'+$.mobile.activePage.attr('id')+' .id_customer_popup').val(),id_currency: currPOS, id_shop: id_shop},function(data) {
            if(data != null) {
               efectoGuardado(id);
               if(name == 'surchage')
                    updateCompra();
            }
        });
    },400 );
}
function guardarInfoClienteRadio(radio){
    var id = $(radio).attr("id");
    var name = $(radio).attr("name");
  	var value = $(radio).val();
   	delay(function(){
   	    if($("#currencyPOS").val() != undefined)
            var currPOS = $("#currencyPOS").val();
        else
            var currPOS = id_currency;
        $.getJSON("../modules/tpvtienda/classes/actions/actionsClientes.php",{token:token, action:'guardarInfoCliente',name:name, value:value,
       	   id_customer:$('#'+$.mobile.activePage.attr('id')+' .id_customer_popup').val(),id_currency: currPOS, id_shop: id_shop},function(data) {
            if(data != null) {
               efectoGuardado(radio);
            }
        });
    },400 );
}
function guardarDireccionCliente(input){
   	var className = $(input).attr("class");
    if(typeof id == "undefined")
        id = '#anadirDireccionForm .' + $(input).attr("class");
   	var name = $(input).attr("name");
   	var value = $(input).val();
   	var id_address = $(input).parents(".addressMore").find(".id_address").val();
    if($("#currencyPOS").val() != undefined)
        var currPOS = $("#currencyPOS").val();
    else
        var currPOS = id_currency;
    $.getJSON("../modules/tpvtienda/classes/actions/actionsClientes.php",{token:token, action:'guardarDireccionCliente',name:name, value:value,id_address:id_address,
        id_currency: currPOS, id_shop: id_shop},function(data) {
        if(data != null) {
            efectoGuardado('.addressMore .'+className);
        }
    });
}
function modificarDireccion(id_direccion){
    $('#'+$.mobile.activePage.attr('id')+' ul li[aria-controls=tabs-2] a').trigger("click");
    $(".direcciones").hide();
   //  $('#'+$.mobile.activePage.attr('id')+' .'+nombreCapa).show();
    var nombrePestana = $('#'+$.mobile.activePage.attr('id')+ ' select.indicesDirecciones option[data-direccion='+id_direccion+']').val();
    console.log(id_direccion);
    console.log(nombrePestana);
                $('#'+$.mobile.activePage.attr('id')+' .'+nombrePestana).show();
//    $('#'+$.mobile.activePage.attr('id')+' .indicesDirecciones').trigger("click");
//
//        var nombreCapa = $(this).val();

}
function removeCustomer(){
    $('#id_customer').val(id_customer_defecto);
    id_customer = id_customer_defecto;
    $('#customerSeleccionado span').html('-- '+id_customer_defecto_nombre+' --');
    $(this).parent().removeClass('alterado');
    hookJS('updateCustomer');
    $(".botonVolverClientes").trigger("click");
    $("#titleCliente").hide(); //para las devoluciones
    $(".contClientePedidoDevs .ui-input-text").show(); //para las devoluciones
    event.stopPropagation();// evita que se abran los clientes de nuevo al
                            // estar contenido en una capa con ese
                            // comportamiento al hacer click
}
$(document).ready(function() {
    $(".tabsCliente").tabs();

     // CAMBIO EMPLEADO
    $("#cambioEmpleado").on('click', function(e){
        var windowWidth = $(window).width();
        var winH = 704;
        $('#contCambioEmpleado').show();
        anadirMascara();
        e.defaultPrevented;
    });
    $('#customerSeleccionado, #cambiarCliente').on("click", function(event){
        $('#'+$.mobile.activePage.attr('id')+' .cambiarCliente').addClass('open');
        modo = "clientes";
        $('#'+$.mobile.activePage.attr('id')+' #subTPVTienda').addClass("open");
        anadirMascara();
        getClientes(1);
        $('#'+$.mobile.activePage.attr('id')+' .filterCliente').val("");
        if(heightFondo > 600)
            $('#'+$.mobile.activePage.attr('id')+' .filterCliente').focus();
    });
    $('.clienteCont .ui-icon-user,.clienteCont .address_item').on("click", function(event){
        $('#'+$.mobile.activePage.attr('id')+' .cambiarCliente').addClass('open');
        modo = "clientes";
        anadirMascara();
        abrirCliente($('.clienteCont .ui-icon-user').attr('data-customer'));
    });
    $("select[name=customer_id_address_delivery]").on("click change", function(event){
        var id_customer = $(this).parents("#tabs-1").children(".id_customer_popup").val();
        var id_customer_fijo = $("#id_customer").val();
        updateCompra();
        if(id_customer == id_customer_fijo){
            if($("#currencyPOS").val() != undefined)
                var currPOS = $("#currencyPOS").val();
            else
                var currPOS = id_currency;
            $.getJSON("../modules/tpvtienda/classes/actions/actions.php",{token:token, action:'updateAddress',id_cart:id_cart,id_currency:currPOS,
                id_address_delivery:$(this).val(),id_shop: id_shop},function(data) {
    			if(data != null) {
    				$.each(data, function(index, result) {
    					if(result.error != null){
    						mostrarError(result.error);
    					}else{
    						// todo bien
    					}
    				});
    			}
    		});
        }

    });
    $("select[name=customer_id_address_invoice]").on("change", function(event){
        var id_customer = $(this).parents("#tabs-1").children('#'+$.mobile.activePage.attr('id')+' .id_customer_popup').val();
        var id_customer_fijo = $("#id_customer").val();
        if(id_customer == id_customer_fijo){
            if($("#currencyPOS").val() != undefined)
                var currPOS = $("#currencyPOS").val();
            else
                var currPOS = id_currency;
            $.getJSON("../modules/tpvtienda/classes/actions/actions.php",{token:token, action:'updateAddress',id_cart:id_cart,id_currency: currPOS,
                id_address_invoice:$(this).val(),id_shop: id_shop},function(data) {
                    if(data != null) {
        				$.each(data, function(index, result) {
        					if(result.error != null){
        						mostrarError(result.error);
                            }else{
                                // todo bien
                            }
        				});
                    }
    		});
        }
    });

    $("select.indicesDirecciones").on("change", function(event){
        var nombreCapa = $(this).val();
        $(".direcciones").hide();
        $('#'+$.mobile.activePage.attr('id')+' .'+nombreCapa).show();
    });
   /* $('.clientes .contClientes input[type=text], .clientes .contClientes input[type=date], .clientes .contClientes textarea, .clientes .contClientes select').on("keyup blur", function(e) {
        var id = $(this).attr("id");
        var name = $(this).attr("name");
        var value = $(this).val();
        // if(name != 'birthday'){
            delay(function(){
                if($("#currencyPOS").val() != undefined)
                    var currPOS = $("#currencyPOS").val();
                else
                    var currPOS = id_currency;
                $.getJSON("../modules/tpvtienda/classes/actions/actionsClientes.php",{token:token, action:'guardarInfoCliente',name:name, value:value,
               	   id_customer:$('#'+$.mobile.activePage.attr('id')+' .id_customer_popup").val(), id_currency: currPOS, id_shop: id_shop},function(data) {
                    if(data != null) {
                       efectoGuardado('#'+id);
                    }
                });
            },400 );
        // }
    });  */
   /* $('.clientes .contClientes input:checkbox').on("change", function(e) {
        var id = $(this).attr("id");
        var name = $(this).attr("name");
      	var value = $(this).is(":checked");
       	delay(function(){
       	    if($("#currencyPOS").val() != undefined)
                var currPOS = $("#currencyPOS").val();
            else
                var currPOS = id_currency;
            $.getJSON("../modules/tpvtienda/classes/actions/actionsClientes.php",{token:token, action:'guardarInfoCliente',name:name, value:value,
           	   id_customer:$('#'+$.mobile.activePage.attr('id')+' .id_customer_popup").val(),id_currency: currPOS, id_shop: id_shop},function(data) {
                if(data != null) {
                   efectoGuardado('#'+id);
                   if(name == 'surchage')
                        updateCompra();
                }
            });
        },400 );
    });*/
    /*$('.clientes .contClientes input:radio').on("change", function(e) {
        var id = $(this).attr("id");
        var name = $(this).attr("name");
      	var value = $(this).val();
       	delay(function(){
       	    if($("#currencyPOS").val() != undefined)
                var currPOS = $("#currencyPOS").val();
            else
                var currPOS = id_currency;
            $.getJSON("../modules/tpvtienda/classes/actions/actionsClientes.php",{token:token, action:'guardarInfoCliente',name:name, value:value,
           	   id_customer:$('#'+$.mobile.activePage.attr('id')+' .id_customer_popup").val(),id_currency: currPOS, id_shop: id_shop},function(data) {
                if(data != null) {
                   efectoGuardado('#'+id);
                }
            });
        },400 );
    });  */
   /* $('.addressMore input[type=text], .addressMore textarea, .addressMore select').on("keyup onchange blur", function(e) {
       	var className = $(this).attr("class");
        if(typeof id == "undefined")
            id = '#anadirDireccionForm .' + $(this).attr("class");
       	var name = $(this).attr("name");
       	var value = $(this).val();
       	var id_address = $(this).parents(".addressMore").find(".id_address").val();
       	delay(function(){
       	    if($("#currencyPOS").val() != undefined)
                var currPOS = $("#currencyPOS").val();
            else
                var currPOS = id_currency;
            $.getJSON("../modules/tpvtienda/classes/actions/actionsClientes.php",{token:token, action:'guardarDireccionCliente',name:name, value:value,id_address:id_address,
                id_currency: currPOS, id_shop: id_shop},function(data) {
                if(data != null) {
                    efectoGuardado('.addressMore .'+className);
                }
            });
        },400 );
    }); */

    $('#verTarjeta').on('click', function(e) {
        var id_customer = $('#'+$.mobile.activePage.attr('id')+' .id_customer_popup').val();
        mostrarTarjeta(id_customer);
    });
    $('.botonVolverClientes').on('click', function(e) {
        $('.clientes h1.old').show();
        $('.clientes h1.new').hide();
        $('.anadirClienteButton').show();
        $(".clientesInfo").hide( "slide" , { direction: "right" }, 500);
        $(".wrapperClientes").show( "slide" , { direction: "left" }, 500);
    });
});