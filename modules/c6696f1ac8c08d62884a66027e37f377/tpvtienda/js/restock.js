//variables del buscador
var inicioProductos = 0;
var cantidad = 20;
//0 normal, capta el teclado para los codebars
//1 botonera. capta los numeros para la botonera
var modo = 0;
var done = false;
var teclas = '';
var valorActual = "";
var mySwiper = "";
var lista = new Array();
var resumenStock = "";
var contCombs = 0;
var tablaCombinaciones = "";
var anadirProductoDropZone = '';
var token = document.location.href.split("token=");
token = token[1].split("#");
token = token[0].split("&");
token = token[0];
var tablaTPV = new Array(8);
var stocksTable = "";

function printKeys() {
    teclas = teclas.replace("J", "");
    teclas = teclas.replace(/\r|\t|\n/, "");
    teclas = teclas.replace("(", "");
    teclas = teclas.replace("%10", "");
    teclas = teclas.replace(/[^0-9a-z]/gi, '');

    if(teclas.length > 9){
   	    if(teclas.length == 35){
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
        }else if(!$(".order_query").is(":focus")){
    		buscoCodebar(teclas);
    	}
    }
    teclas = '';
}
function customCabecera(doc){
    var filasTexto = [{text: '\n', bold: true, fontSize: 11, alignment: 'left'}];
    var nombreAlmacen = [];
    var api = $('table.informeStocks').dataTable().api();
    var costeTotal = 0;
    var stockTotal = 0;
    var precioVentaTotal = 0;
    // Remove the formatting to get integer data for summation
    var intVal = function ( i ) {
        i = stripHtml(i);
        return typeof i === 'string' ?
            i.replace(/[\$,]/g, '')*1 :
            typeof i === 'number' ?
                i : 0;
    };
    // Total con IVA
   // pageTotal = api.column( 10, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
//            $( api.column( 10 ).footer() ).html(parseFloat(pageTotal.toFixed(priceDisplayPrecision)));
    // Coste toal
    //pageTotal = api.column( 11, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
//    var costeTotal = pageTotal.toFixed(priceDisplayPrecision);
  //   $( "#costeTotal").html(parseFloat(costeTotal));
    // cantidades por almacen
    var costeTotalAlmacen = 0;
    var contadorHuecos = 0;
    var i = 0;
    var nb_rows = api.rows().nodes().length;
    //saco nombres almacenes
    api.columns().indexes().flatten().each( function ( i ) {
        var column = api.column( i );
        var title = column.header();

        if($(title).hasClass('stock')){
            contadorHuecos++;
            nombreAlmacen.push($(title).children("span").html());
        }
    });
    while(contadorHuecos >= huecosStock && contadorHuecos != 0){
        stock = api.column( 12+i+1, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
        precioVenta = api.column( 12+i, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
        precioVentaTotal += precioVenta;
        stockTotal += stock;
        filasTexto.push({text: cantidadTxT+" "+nombreAlmacen[i]+": "+stock+'\n', bold: true, fontSize: 11, alignment: 'left'});
        contadorHuecos--;
        i++;
    }
    //i = 0;
//    while(i < nb_rows){
//        var num = 99;
//        var rowData = api.rows(i).data()[0];
//        console.log(rowData);
//        console.log(rowData.firstNumber);
//        costeTotal +=  num * rowData.firstNumber;
//        api.rows(i).invalidate().draw();
//        api.data().sum();
//        i++;
//    }
    if(huecosStock > 1){
        // saco total coste por almacen
        contadorHuecos = huecosStock;

        var i = 0; //columnas
        while(contadorHuecos <= huecosStock && contadorHuecos != 0){
            var j = 0; //filas
            costeTotalAlmacen = 0;
            while(j < nb_rows){
                var num = 99;
                var rowData = api.rows(j).data()[0];
                var costeProducto = rowData[10];
                var cantidadAlmacen = stripHtml(rowData[11+i+2]);
                costeTotalAlmacen +=  costeProducto * cantidadAlmacen;
                j++;
            }
            filasTexto.push({text: costeTxT+" "+nombreAlmacen[i]+": "+costeTotalAlmacen.toFixed(priceDisplayPrecision)+'\n', bold: true, fontSize: 11, alignment: 'left'});
            costeTotal += costeTotalAlmacen;
            i++;
            contadorHuecos--;
        }
        //stock = api.column( 11+huecosStock+1, { page: 'current'} ).data().reduce( function (a, b) {return intVal(a) + intVal(b);}, 0 );
//        $( api.column( 11+huecosStock+1 ).footer() ).html(cantidadTxT+": "+stock+'<br>'+costeTxT+": "+(stock * costeTotal));
    }
       filasTexto.push({text: precioVentaTxT+" "+": "+precioVentaTotal+'\n', bold: true, fontSize: 11, alignment: 'left'});
        filasTexto.push({text: cantidadTxT+" "+": "+stockTotal+'\n', bold: true, fontSize: 11, alignment: 'left'});
        filasTexto.push({text: costeTxT+": "+costeTotal.toFixed(priceDisplayPrecision)+'\n', bold: true, fontSize: 11, alignment: 'left'});
   //  cols[1] = {text: 'Right part', alignment: 'right', margin:[0,0,20] };
    doc.defaultStyle.fontSize = 8;
    doc.styles.tableHeader.fontSize = 9;
    doc.pageMargins = [10, 10, 10,10 ];
    doc.content.splice(0, 1,
    {
        text: [{
            text: nombreTienda+'\n',
            bold: true,
            fontSize: 18,
            alignment: 'left'
        },{
            text: direccionTienda+'\n',
            fontSize: 12,
            alignment: 'left'
        },{
            text: fechaHoy,
            fontSize: 12,
            alignment: 'center'
        }],
        margin: [0, 0, 0, 12]
    });
    doc.content.splice(2, 0,
    {
        text: filasTexto,
        margin: [0, 0, 0, 12]
    });
    return doc;
}

function stripHtml(html)
{
    let tmp = document.createElement("DIV");
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || "";
}
function anadirListado(){
    if($("input[name=prds]:checked").length == 0){
        $('.advertencia #notificationBad').slideDown('fast');
        $('.advertencia #notificationBad').delay(6000).slideUp('fast');
    }else{
        $("input[name=prds]:checked").each(function(){
            var producto = $(this).val().replace("prod_","");
    	    producto = producto.split("_");
            console.log(producto);
            addToList(producto[0],producto[1]);
        });
        // Object.assign(document.createElement('a'), { target: '_blank', href: '../modules/orderspreparation/classes/listadoFacturas.php?id_lang='+id_lang+'&productos='+productos+'&id_currency='+id_currency+'&id_employee='+id_employee}).click();
    }
}
function createTableStock(){
    if (typeof stocksTable == 'object' || (typeof $.fn.DataTable != "undefined" && $.fn.DataTable.isDataTable("#"+$.mobile.activePage.attr('id')+' table.informeStocks' ) )) {
        $("#"+$.mobile.activePage.attr('id')+' table.informeStocks' ).DataTable().destroy();
    }
    stocksTable = $('table.informeStocks').DataTable({
        dom: 'T<"clear">lBri',
        //     dom: 'frt',
        buttons:[
            {
                extend: 'copy', footer: true, text: copyTxT, attr: {id: 'allan'},
                exportOptions: {columns: ':visible:not(th:last-child)'},
            },
            {
                extend: 'csv', footer: true,
                exportOptions: {columns: ':visible:not(th:last-child)'},
            },
            {
                extend: 'excel', footer: true,
                exportOptions: {columns: ':visible:not(th:last-child)'},
            },
            {
                extend:'pdf', footer: true,
                exportOptions: {columns: ':visible:not(th:last-child)'},
                customize: function(doc) {customCabecera(doc)}
            },
            {
                extend: 'print', footer: true, text: printTxT,
                exportOptions: {columns: ':visible:not(th:last-child,th:first-child)'},
            },
            {
                extend:'colvis',text:columnsTxt
            }
        ],
        "columnDefs": [ {"width": "35px","targets": 0, "visible":true,"sortable":false},
                        {"width": "40px", "targets": 1, "visible":false},
                        {"width": "80px", "targets": 2},
                        {"width": "80px", "targets": 3, "visible":false},
                        {"width": "200px", "targets": 4},
                        {"width": "95px", "targets": 5},
                        {"width": "100px", "targets": 6, "visible":false}],
        "oLanguage": traducciones,
        'order' : [[1,'desc']],
        serverSide: true,
        processing: true,
        layout: {
            topStart: {
                buttons: ['colvis']
            }
        },
        stateSave: true,
        "bStateSave": true,
        "fnStateSave": function (oSettings, oData) {
            localStorage.setItem( 'DataTables', JSON.stringify(oData) );
        },
        "fnStateLoad": function (oSettings) {
            return JSON.parse( localStorage.getItem('DataTables') );
        },
        "aLengthMenu":[[30,60,120,240,480,960,1920,3840,7680,99999999999],[30,60,120,240,480,960,1920,3840,7680,"All"]],
        "ajax": $.fn.dataTable.pageLoadMore(
            {
            "url": "../modules/tpvtienda/classes/actions/actionsReStock.php?action=stock&id_shop="+id_shop+"&id_lang="+id_lang+"&id_currency="+$('#id_currency').val()+"&group="+$("input[name=groupC]:checked").val(),
            "data": {
                "token": token
                }
            }
        ),
        //"sAjaxSource": "../modules/tpvtienda/classes/actions/actionsEstadisticas.php?action=stock&id_shop="+id_shop+"&id_lang="+id_lang,
        "bLengthChange": true,

        drawCallback: function() {
            // If there is some more data
            //  if($('#btn-example-load-more').is(':visible')){
            //                // Scroll to the "Load more" button
            //                $('html, body').animate({
            //                    scrollTop: $('#btn-example-load-more').offset().top
            //                }, 1000);
            //            }

            // Show or hide "Load more" button based on whether there is more data available
            $('#btn-example-load-more').toggle(this.api().page.hasMore());
        }
    });
    $('#btn-example-load-more').on('click', function(){
        // Load more data
        stocksTable.page.loadMore();
    });
    $("#stock .loading").hide();
    $('table.informeStocks').show();
    filtradoCabeceras();
    stocksTable.on( 'column-visibility.dt', function ( e, settings, column, state ) {
        filtradoCabeceras();
    });
    $("#stock .dt-buttons .anadirSeleccionados").remove();
    $("#stock .dt-buttons").append('<button class="dt-button anadirSeleccionados" onclick="anadirListado()" title="añadir seleccionado">'+anadirseleccionadoTxt+'</button>');
    tablaTPV['stocks'] = stocksTable;
}
function filtradoCabeceras(){
    var contadorCabeceras = 0;
    $('table.informeStocks thead th').each( function () {
        var title = $(this).text();
        if(title != "" && !$(this).hasClass("nofilterable"))
            $(this).html( '<input type="text" id="filtroStock_'+contadorCabeceras+'" class="filtroStock" placeholder="'+title+'" /><span>'+title+'</span>' );
        contadorCabeceras++;
    } );
     // Con esta función evito que al clicar en el input ordene
    $("table.informeStocks thead input").click( function (e) {
        if (!e) var e = window.event
        e.cancelBubble = true;
        if (e.stopPropagation) e.stopPropagation();
    });
     // Apply the search
    $( '.filtroStock, .buscarProducto').on( 'keyup change', function (event) {
        event.stopPropagation();
        delay(function(){
            stocksTable.ajax.url("../modules/tpvtienda/classes/actions/actionsReStock.php?action=stock&id_product="+$(".filtro_id input").val()+"&reference="+$(".filtro_ref input").val()+
                "&ean13="+$(".filtro_ean input").val()+"&name="+$(".filtro_nombre input").val()+"&nombre_attr="+$(".filtro_comb input").val()+"&category="+$(".filtro_categoria input").val()+
                "&fabricante="+$(".filtro_fabricante input").val()+"&proveedor="+$('.filtro_proveedor input').val()+"&ubicacion="+$('.filtro_ubicacion input').val()+"&id_shop="+id_shop+"&id_lang="+id_lang+"&token="+token+"&id_currency="+$('#id_currency').val()+"&id_employee="+id_employee+"&limit=200").load();
        },300 );
    });
}
function anadirProducto(){
    var contadorCombinaciones = 0;
    var combis = [];
    var flagCombExistentes = 0;
    while(contadorCombinaciones <= contCombs){
        combis[contadorCombinaciones] = [];
    	combis[contadorCombinaciones]['att'] = [];
    	$('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contadorCombinaciones+' select.attributesToChoose').each(function(index,result){
    	    var nameAttr = result.name.replace("att_","");
    	    nameAttr = nameAttr.split("_");
            var opcionElegida = $('#'+$.mobile.activePage.attr('id')+ ' select[name='+result.name+']').val();
            if(opcionElegida != ""){
                flagCombExistentes = 1;
    	        combis[contadorCombinaciones]['att'][nameAttr[0]] = opcionElegida;
            }
    	});
        if(combis[contadorCombinaciones]['att'].length > 0) {
           	if(contadorCombinaciones > 0){
        		combis[contadorCombinaciones]['ref'] = $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contadorCombinaciones+' input[name=reference_comb_'+contadorCombinaciones+']').val();
        		combis[contadorCombinaciones]['precio'] = $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contadorCombinaciones+' input[name=impacto_precio_comb_'+contadorCombinaciones+']').val();
        		combis[contadorCombinaciones]['cant'] = $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contadorCombinaciones+' input[name=cantidad_comb_'+contadorCombinaciones+']').val();
        		combis[contadorCombinaciones]['peso'] = $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contadorCombinaciones+' input[name=impacto_peso_comb_'+contadorCombinaciones+']').val();
        		combis[contadorCombinaciones]['ean13'] = $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contadorCombinaciones+' input[name=ean13_comb_'+contadorCombinaciones+']').val();
        		combis[contadorCombinaciones]['iva'] = $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contadorCombinaciones+' input[name=iva_comb_'+contadorCombinaciones+']').val();
        	}else{
        		combis[contadorCombinaciones]['ref'] = $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contadorCombinaciones+' input[name=reference_comb]').val();
        		combis[contadorCombinaciones]['precio'] = $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contadorCombinaciones+' input[name=impacto_precio_comb]').val();
        		combis[contadorCombinaciones]['cant'] = $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contadorCombinaciones+' input[name=cantidad_comb]').val();
        		combis[contadorCombinaciones]['peso'] = $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contadorCombinaciones+' input[name=impacto_peso_comb]').val();
        		combis[contadorCombinaciones]['ean13'] = $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contadorCombinaciones+' input[name=ean13_comb]').val();
        		combis[contadorCombinaciones]['iva'] = $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contadorCombinaciones+' input[name=iva_comb]').val();
        	}
        }else{
             combis.splice(contadorCombinaciones,1);
        }
        contadorCombinaciones++;
    }
    if(flagCombExistentes == 0)   {
        combis = "";
    }
    $.getJSON("../modules/tpvtienda/classes/actions/actionsAnadirProducto.php",	{ token:token, action: 'anadirProducto', id_shop: id_shop,
        nombre:$('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="nombre"]').val(), reference:$('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="reference"]').val(),
        precio:$('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="precioSinIva"]').val(), id_tax_rules:$('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm select.anadirProducto_id_tax').val(),
        cantidad:$('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="cantidad"]').val(), url:$('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="url"]').val(),fotos:$('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="fotos"]').val(),
        categorias:$('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="categoriasNuevoProducto"]').val(),combis:multiDimensionArray2JSON(combis),
        marca:$('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm select[name="selectMarcasNuevoProducto"]').val(),
        visibilidad:$('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm select[name="visibility"]').val(), ean13:$('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="ean13"]').val(),
        precioCompraSinIva: $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="precioCompraSinIva"]').val(),id_currency: $("#id_currency").val(),
        id_supplier: $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm select[name="proveedoresSUP"]').val(),refProveedor: $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="refProveedor"]').val()},function(data) {
          if(data != null){
                $("#buttonBorrarProd").show();
                $.each(data, function(index, result) {
                    addToList(result.id_product,result.id_product_attribute);
                   //  addProduct(result.id_product,result.id_product_attribute,result.cant,result.name,true);
                });
                $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input').val('');
                $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name=fotos]').val('');
                Dropzone.forElement('#'+$.mobile.activePage.attr('id')+' .subidaImagenesProducto').removeAllFiles(true);
                $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm input[name="cantidad"]').val(1);
                $('#'+$.mobile.activePage.attr('id')+ ' .categoriasElegidas').html('');
                $('#'+$.mobile.activePage.attr('id')+ ' .tabsAnadirProducto select').prop('selectedIndex',0).selectmenu('refresh');
                $('#'+$.mobile.activePage.attr('id')+ ' .comb_0 input[name=reference_comb]').val("");
                $('#'+$.mobile.activePage.attr('id')+ ' .comb_0 input[name=impacto_precio_comb]').val("");
                $('#'+$.mobile.activePage.attr('id')+ ' .comb_0 input[name=impacto_peso_comb]').val("");
                $('#'+$.mobile.activePage.attr('id')+ ' .comb_0 input[name=ean13_comb]').val("");
                $('#'+$.mobile.activePage.attr('id')+ ' .comb_0 select').prop('selectedIndex',0).selectmenu('refresh');
                while (contCombs > 0){
                    $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contCombs).remove();
                    $('#'+$.mobile.activePage.attr('id')+ ' .sepCombAdic').remove();
                    contCombs--;
                }
          }
    });
}
function suscriboFullscreen(idDiv){
    $(idDiv).fancybox({
        afterLoad: function (param) {
            var id = param.element[0].id.replace("fscreen_","");
        	if ((this.index == this.group.length - 1) && done == false) {
        		done=true;
                var group = this.group;
        		$.getJSON("../modules/tpvtienda/classes/actions/actions.php",{token:token, action:'getImagenesGaleria',id:id, attribute:0, id_lang:id_lang},function(data) {
        			if(data != null) {
        			   $.each(data, function(index, result) {
        				   group.push({ href: result.img, type: "image", title: result.name, isDom: false });
        			   });
        			}
        		});
            } // if
//	    	$(".fancybox-outer").append('<div class="addCartButton"><a onclick="addCart('+id+','+
//	    			0+',1,\''+param.element[0].title+'\',false);$.fancybox.close()" class="ui-shadow ui-btn-icon-left ui-icon-plus ui-btn ui-corner-all"><span>'+anadirPedido+'</span></a></div>');
        },
    });
}
function getCategoriaId(id){
    ultimaBusqueda = 'categoriaId';
    if(id == '')
        inicioProductos = 0;
    $(".loaderProductos").show();
    $.getJSON(token_actions,{action:'categoriaId',id_cat: id, ajax:"1",id_shop: id_shop, id_lang: id_lang, inicio:inicioProductos,
        cantidad:cantidad,  inactivos: $('#inactivos').prop('checked'),'restock':1},function(data) {
        if(data != null){
            $.each(data, function(index, result) {
                if(typeof result.p ==='object' && result.p !=null){
                    htmlProducto = "<div class='swiper-slide producto' id='item_"+result.p.id+"' ><span class='name'>"+result.p.name+"</span><img src='"+result.p.img+"'/>"+
                                        ((mostrarPrecios == 1) ? "<span class='precio'>"+result.p.p+"</span>" : "");

                    if(typeof result.p.i ==='object' && result.p.i !=null){
                        $.each(result.p.i, function(index, img) {
                            htmlProducto += "<a rel='fscreen_"+result.p.id+"_0' class='fullscreenProduct' title='"+result.p.name+"' href='"+img+"'></a>";
                        });
                    }
                    htmlProducto += ((mostrarStock == 1) ? "<span class='stock'>"+stockText+" "+result.p.s+"</span>" : "");
                    htmlProducto += ((result.p.hookPbottomright != null) ? "<span class='hookBottomRightList'>"+result.p.hookPbottomright+"</span>" : "");
                    htmlProducto += "</div>";
                    mySwiper.appendSlide(htmlProducto);
                }
            });
            suscriboFullscreen('.producto .fullscreenProduct');
            inicioProductos += cantidad;
        }
        $(".loaderProductos").hide();
    });
}
function buscoCodebar(query,cantidad = 1){
     $.getJSON(token_actions,{action:'search', ajax:"1",tipoBusqueda:'ean13', q: query, inicio:0,cantidad:cantidad,id_lang: id_lang, id_shop: id_shop,
        inactivos: $('#inactivos').prop('checked'),conAtributos:true},function(data) {
        if(data != null) {
            $.each(data, function(index, result) {
                if(result.error != null){
                    mostrarError(result.error);
                }else{
                    if(result.id != null){
                        //meto la primera coincidencia en la lista de la compra
                        addToList(result.id,result.attr);
          		    }
                }
            });
         }else{
            $("#"+$.mobile.activePage.attr('id')+' .advertencia #nohayresultados').slideDown('fast');
            $("#"+$.mobile.activePage.attr('id')+' .advertencia #nohayresultados').delay(3000).slideUp('fast');
         }
  	});
}
function botonera(id,clase){
    return '<div data-role="popup" id="popup'+id+'" data-theme="b" class="popup'+clase+' ui-content botonera" data-arrow="t">'+
                '<div class="row">'+
                    '<button class="key key7 i-btn ui-btn ui-shadow ui-corner-all">7</button>'+
                    '<button class="key key8 i-btn ui-btn ui-shadow ui-corner-all">8</button>'+
                    '<button class="key key9 i-btn ui-btn ui-shadow ui-corner-all">9</button>'+
                '</div>'+
                '<div class="row">'+
                    '<button class="key key4 i-btn ui-btn ui-shadow ui-corner-all">4</button>'+
                    '<button class="key key5 i-btn ui-btn ui-shadow ui-corner-all">5</button>'+
                    '<button class="key key6 i-btn ui-btn ui-shadow ui-corner-all">6</button>'+
                '</div>'+
                '<div class="row">'+
                    '<button class="key key1 i-btn ui-btn ui-shadow ui-corner-all">1</button>'+
                    '<button class="key key2 i-btn ui-btn ui-shadow ui-corner-all">2</button>'+
                    '<button class="key key3 i-btn ui-btn ui-shadow ui-corner-all">3</button>'+
                '</div>'+
                '<div class="row">'+
                    '<button class="key keyPunto i-btn ui-btn ui-shadow ui-corner-all">.</button>'+
                    '<button class="key key0 i-btn ui-btn ui-shadow ui-corner-all">0</button>'+
                    '<button class="key keyDelete i-btn ui-btn ui-shadow ui-corner-all"><span class="CEButton">CE</span></button>'+
                '</div>'+
            '</div>';
}
function comprobarReStock(){
    var totalProductos = 0;
    $.map( $('.qty'), function( val ) {
        var valor = $(val).html();
        if(valor != '')
            totalProductos += parseFloat(valor);
    });

    $(".totalProductos span").html(totalProductos);
    $("#popupConfirmacion").popup("open");
}
function traspasar(){
    var totalProductos = 0;
    $.map( $('.qty'), function( val ) {
        var valor = $(val).html();
        if(valor != '')
            totalProductos += parseFloat(valor);
    });

    $(".totalProductos span").html(totalProductos);
    $("#popupTraspasar").popup("open");
}
function traspasarStock(){
    var error = 0;
    $("#imprimirEtiquetas").hide();
    $('#resumenStockTable').DataTable().rows().remove().draw();
    $('#movsStockTable').DataTable().rows().remove().draw();
    $.getJSON("../modules/tpvtienda/classes/actions/actionsReStock.php",{token:token, action:'traspasar',id_shop: id_shop, tipo:$("#tipoReStockage").val(),
        id_lang: id_lang,id_currency: $('#id_currency').val(),id_warehouse_origen:$("#almacenOrigen").val(),shopOrigen:$("select[name=shopOrigen]").val(), shopDestino:$("select[name=shopDestino] option:selected").val(),
        id_employee:id_employee,id_warehouse_destino:$("#almacenDestino").val(),lista:multiDimensionArray2JSON(lista)},function(data) {
            if(data != null){
                $.each(data, function(index, result) {
                    if(result.error != null){
                        error=1;
                        mostrarError(result.error);
                    }
                    if(result.ok != null){
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html('importacion bien');
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').slideDown('fast');
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(5000).slideUp('fast');
                    }
                    if(typeof result.producto ==='object' && result.producto != null){
                        var tablaProd = [result.producto.id,result.producto.nombre,result.producto.ref,
                                            result.producto.wp]
                        if(result.producto.stock != null){
                            $.each(result.producto.stock, function(id_warehouse, stock) {
                                tablaProd.push(stock);
                            });
                        }
                        tablaProd.push(result.producto.stockTotal);
                        tablaProd.push(result.producto.precio);
                        tablaProd.push(result.producto.fecha);
                        $('#resumenStockTable').DataTable().row.add(tablaProd).draw( false );
                    }
                    if(result.cantidadTotal != null)
                        $("#cantidadTotal").html(result.cantidadTotal);
                    if(typeof result.movs ==='object' && result.movs != null){
                        var tablaProdMovs = [result.movs.nombre,result.movs.ref, result.movs.emp];
                        if(result.movs.tipo == 'traspaso')
                            tablaProdMovs.push(traspasoTxT);
                        tablaProdMovs.push(result.movs.origen);
                        tablaProdMovs.push(result.movs.destino);
                        tablaProdMovs.push(result.movs.ctd);
                        tablaProdMovs.push(result.movs.fecha);
                        $('#movsStockTable').DataTable().row.add(tablaProdMovs).draw( false );
                    }
                    if(result.supplyOrder != null){
                        $("#imprimirEtiquetas").show();
                        $("#imprimirEtiquetasSupplyOrder").val(result.supplyOrder);
                    }
                });
                $('.okTraspasar').removeClass("ui-state-disabled");
                $("#popupTraspasar").popup( "close" );
                if(error == 0){
       			    $( "#"+$.mobile.activePage.attr('id')+' #resumenStock' ).popup();
                    $( "#"+$.mobile.activePage.attr('id')+' #resumenStock' ).popup( "open");
                    $("#"+$.mobile.activePage.attr('id')+" #resumenStock").popup("reposition", {positionTo: '#TPVTienda'});
                    borrarProductosStock();
                }
            }
        });
}
function ejecutarReStock(){
    var error = 0;
    var productos = '';
    $("#imprimirEtiquetas").hide();
    $('#resumenStockTable').DataTable().rows().remove().draw();
    $('#movsStockTable').DataTable().rows().remove().draw();

    $.getJSON("../modules/tpvtienda/classes/actions/actionsReStock.php",{token:token, action:'restockar',id_shop: id_shop, tipo:$("#tipoReStockage").val(),
    // $.post(token_actions_stock,{ action:'restockar',id_shop: id_shop, tipo:$("#tipoReStockage").val(),ajax : "1",
        id_lang: id_lang,id_currency: $('#id_currency').val(),generaOrdenSuministros:$("input[name=generaOrdenSuministros]").prop('checked'),tipoInc:$("#tipoInc").val(),
        tipoDec:$("#tipoDec").val(),id_employee:id_employee,id_warehouse:$("#almacen").val(),lista:multiDimensionArray2JSON(lista)},function(data) {
            if(data != null){
                $.each(data, function(index, result) {
                    if(result.error != null){
                        error=1;
                        mostrarError(result.error);
                    }
                    if(result.ok != null){
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').html('importacion bien');
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').slideDown('fast');
                        $("#"+$.mobile.activePage.attr('id')+' .advertencia .notificationGood').delay(5000).slideUp('fast');
                    }
                    if(typeof result.producto ==='object' && result.producto != null){
                        var tablaProd = [result.producto.id,result.producto.nombre,result.producto.ref,
                                            result.producto.wp]
                        if(result.producto.stock != null){
                            $.each(result.producto.stock, function(id_warehouse, stock) {
                                tablaProd.push(stock);
                            });
                        }
                        tablaProd.push(result.producto.stockTotal);
                        tablaProd.push(result.producto.precio);
                        tablaProd.push(result.producto.fecha);
                        $('#resumenStockTable').DataTable().row.add(tablaProd).draw( false );
                    }
                    if(result.cantidadTotal != null)
                       $("#cantidadTotal").html(result.cantidadTotal);
                    if(typeof result.movs ==='object' && result.movs != null){
                        var tablaProdMovs = [result.movs.nombre,result.movs.ref,result.movs.emp];
                        if(result.movs.tipo == 1)
                            tablaProdMovs.push(inventarioTxT);
                        if(result.movs.tipo == 0)
                            tablaProdMovs.push(reestockageTxT);
                        if(result.movs.tipo == 2)
                            tablaProdMovs.push(restarTxT);
                        tablaProdMovs.push("");
                        tablaProdMovs.push(result.movs.destino);
                        tablaProdMovs.push(result.movs.ctd);
                        tablaProdMovs.push(result.movs.fecha);
                        $('#movsStockTable').DataTable().row.add(tablaProdMovs).draw( false );
                    }
                    if(result.supplyOrder != null){
                        $("#imprimirEtiquetas").show();
                        $("#imprimirEtiquetasSupplyOrder").val(result.supplyOrder);
                    }
                });
                if(error == 0){
       				$("#popupConfirmacion").popup( "close" );
                    $('#'+$.mobile.activePage.attr('id')+ ' input[name=generaOrdenSuministros]').prop('checked', false).checkboxradio('refresh');
    			    $("#"+$.mobile.activePage.attr('id')+' #resumenStock' ).popup();
                    $("#"+$.mobile.activePage.attr('id')+' #resumenStock' ).popup( "open");
                    $("#"+$.mobile.activePage.attr('id')+" #resumenStock").popup("reposition", {positionTo: '#TPVTienda'});
              		$('.okConfirmacion').removeClass("ui-state-disabled");
                    $('#tipoInc').prop('selectedIndex',0).selectmenu('refresh');
                    $('#tipoDec').prop('selectedIndex',0).selectmenu('refresh');
                    borrarProductosStock();
                }
            }
        });
}
function detalleStock(id_product,attribute,id_warehouse){
    $(".cont_pedidos_sin_enviar").hide();
    $(".cantidad_reserved").parent().hide();
    $(".cantidad_usable").parent().hide();
    $("#popupDetalleStock h1 span").html($("#stock_"+id_product+'_'+attribute+" td.name").html())
    $.getJSON("../modules/tpvtienda/classes/actions/actionsReStock.php",{token:token, action:'detalleStockProducto',id_shop: id_shop, id_lang: id_lang, id_product:id_product,
        attribute:attribute,t:new Date().getTime(),warehouse:id_warehouse},function(data) {
        $.each(data, function(index, result) {
        if(result.error != null)
        	mostrarError(result.error);
        if(result.physical_quantity != null){
        	$(".cantidad_fisica").html(result.physical_quantity);
        }
        if(result.usable_quantity != null){
            $(".cantidad_usable").parent().show();
        	$(".cantidad_usable").html(result.usable_quantity);
        }
        if(result.reserved_quantity != null){
            $(".cantidad_reserved").parent().show();
        	$(".cantidad_reserved").html(result.reserved_quantity);
        }
        if(result.real_quantity != null){
        	$(".cantidad_real").html(result.real_quantity);
        }
        if(result.pedidos_sin_enviar != null){
        	$(".pedidos_sin_enviar").html(result.pedidos_sin_enviar);
        	$(".cont_pedidos_sin_enviar").show();
        }
        });
    });
    $("#popupDetalleStock").popup("open");
    $("#popupDetalleStock").bind({
        popupafterclose: function(event){modo=0;}
    });
}
function guardarLocation(id_product,id_product_attribute,id_warehouse,ubicacion){
    var location = $("#location_"+id_product+"_"+id_product_attribute+"_"+id_warehouse).val();
    $.getJSON(token_actions_stock,{action:'guardarUbicacion',id_product: id_product,id_product_attribute:id_product_attribute,
         ajax:"1", location:ubicacion,id_warehouse:id_warehouse, id_shop: id_shop},function(data) {
        $.each(data, function(index, result) {
            if(result.ok == 'ok')
                efectoGuardado("#location_"+id_product+"_"+id_product_attribute+"_"+id_warehouse);
        });
    });
}
function cambiaEan(id_product,attribute){
    lista[id_product][attribute]['e'] = $(".ean13_"+id_product+"_"+attribute).val();
}
function addToList(id_product,attribute,name,cantidadProd) {
    if(cantidadProd == null)
        cantidadProd = 1;
    $('#compra').show();
    $('#compraVacia').hide();
    $('.loaderProductos').show();
    if(typeof lista[id_product] == "undefined" ){
        lista[id_product] = new Array();
    }
    var cosa = multiDimensionArray2JSON(lista);
    var hayCombinaciones = false;
    if (typeof $.fn.DataTable != "undefined" && $.fn.DataTable.isDataTable("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones table.productosComb' ) ){
        tablaCombinaciones.destroy();
    }
    $( "#"+$.mobile.activePage.attr('id')+' .popupCombinaciones').popup( "close");
    if($.mobile.activePage.attr('id') == "stock"){
        $.mobile.changePage("#TPVTienda");
    }
    if(typeof lista[id_product][attribute] == "undefined"){
        $.getJSON("../modules/tpvtienda/classes/actions/actionsReStock.php",{token:token, action:'infoProducto',adminDir:adminDir,id_shop:id_shop,id_lang:id_lang,
            id_product:id_product,attribute:attribute,id_employee:id_employee,id_currency:$('#id_currency').val(),t:new Date().getTime()},function(data) {
            if(data != null){
                var groups = new Array();
                $.each(data, function(index, result) {
                    if(result.error != null)
                        mostrarError(result.error);
                    if(result.producto != null){
                        var rand = makeid();
                        var lineaProd = '<tr id="stock_'+id_product+'_'+attribute+'" class="stockProduct"><td class="ID">'+id_product+'</td><td class="foto">'+(result.producto.foto != "" ? '<img src="'+result.producto.foto+'"/>' : '')+
                                '</td><td class="estado"><img src="../img/admin/'+result.producto.estado+'" alt="" /></td>'+
                                '<td class="nombre">'+result.producto.nombre+'</td>'+
                                '<td class="ean13"><input type="text" maxlength="13" class="ean13 ean13_'+id_product+'_'+attribute+'" value="'+result.producto.ean13+'" onkeyup="cambiaEan('+id_product+','+attribute+')" data-mini="true"></td>'+
                                '<td class="disponibilidad"><input type="text" class="dispo_date dispo_'+id_product+'_'+attribute+'" value="'+((result.producto.dispo != null && result.producto.dispo != false) ? result.producto.dispo : '0000-00-00')+'" data-mini="true"></td>'+
                                '<td class="referencia">'+result.producto.ref+'</td>'+
                                '<td class="referenciaP">'+result.producto.refP+'</td>';
                        if(typeof warehouses == 'object'){
                            $.each(result.producto.stock, function(id_warehouse, stock) {
                                lineaProd += '<td class="stock" id="stock_'+id_warehouse+'" "><span onclick="detalleStock('+id_product+','+attribute+','+id_warehouse+')">'+stock.c+'</span>'+(!$.isEmptyObject(stock.loc) ? stock.loc : "<br>"+stock.loc)+'</td>';
                            });
                        }else{
                            $.each(result.producto.stock, function(id_shop, stock) {
                                lineaProd += '<td class="stock" id="stock_'+id_shop+'" onclick="detalleStock('+id_product+','+attribute+')">'+stock.c+(!$.isEmptyObject(stock.loc) ? stock.loc : "<br>"+stock.loc)+'</td>';
                            })
                        }
                        lineaProd += '<td class="cantidad" id="ctd_'+id_product+'_'+attribute+'">'+botonera("cantidadProducto_"+id_product+"_"+attribute+"_"+rand,'cantidadProducto')+
                                    '<div class="ui-btn cantidadProducto ui-corner-all qty ponerBotonera" id="cantidadProducto_'+id_product+'_'+attribute+'_'+rand+'">'+cantidadProd+'</div>'+
                                '</td><td class="precio_mayorista" id="cmb_'+id_product+'_'+attribute+'">'+botonera("cambiopreciomayorista_"+id_product+"_"+attribute+"_"+rand,'cambiopreciomayorista')+
                                    '<div class="ui-btn cambiopreciomayorista ponerBotonera" id="cambiopreciomayorista_'+id_product+'_'+attribute+'_'+rand+'">'+result.producto.precio_mayorista+'</div>'+
                                '</td><td class="precio" id="cmb_'+id_product+'_'+attribute+'">'+botonera("cambioprecio_"+id_product+"_"+attribute+"_"+rand,'cambioprecio')+
                                    '<div class="ui-btn cambioprecio ponerBotonera" id="cambioprecio_'+id_product+'_'+attribute+'_'+rand+'">'+result.producto.precio+'</div>'+
                                '</td><td class="accion"><a onclick="deleteStockProduct('+id_product+','+attribute+')"><img src="../img/admin/delete.gif"/></a></td></tr>';
                        $("#compra tbody").prepend(lineaProd);
                        doPlay();
                        lista[id_product][attribute] = new Array();
                        lista[id_product][attribute]['c'] = cantidadProd;
                        lista[id_product][attribute]['e'] = result.producto.ean13;
                        $('#popupcantidadProducto_'+id_product+'_'+attribute+'_'+rand ).popup();
                        $('#popupcambioprecio_'+id_product+'_'+attribute+'_'+rand ).popup();
                        $('#popupcambiopreciomayorista_'+id_product+'_'+attribute+'_'+rand ).popup();
                        $('.dispo_'+id_product+'_'+attribute).datepicker({
                            dateFormat : 'yy-mm-dd',
                            changeMonth: true,
                            changeYear: true,
                            beforeShow: function() {
                            },
                            onSelect: function( selectedDate ) {
                                lista[id_product][attribute]['d'] = selectedDate;
                            }
                        });
                    }
                    if(typeof result.groups === 'object' && result.groups != null){
                        hayCombinaciones = true;
                        $("#"+$.mobile.activePage.attr('id')+" .popupCombinaciones .productosComb thead tr th.anadido").remove();
                        $("#"+$.mobile.activePage.attr('id')+" .popupCombinaciones .productosComb tfoot tr td.anadido").remove();
                        $.each(result.groups, function(index, group) {
                            $("<th class='anadido group_"+index+"'>"+group+"</th>").insertBefore("#"+$.mobile.activePage.attr('id')+" .popupCombinaciones .productosComb thead th.camposFijos:first");
                            $("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones .productosComb tfoot tr').append("<td class='anadido'></td>");
                        });
                        groups = result.groups;
                    }
                    if(typeof result.combinaciones === 'object' && result.combinaciones != null){
                        hayCombinaciones = true;
                        $( "#"+$.mobile.activePage.attr('id')+' .popupCombinaciones h1' ).html(name);
                        $( "#"+$.mobile.activePage.attr('id')+' .popupCombinaciones .productosComb tbody' ).html("");
                        $('.comb_checkbox,.checkall').prop('checked', false);
                        $.each(result.combinaciones, function(index, combinacion) {
                            var groupsText = "";
                            $.each(groups, function(index, group) {
                                if(typeof combinacion.groups[index] != "undefined")
                                    groupsText += '<td class="combProd" id="combProd_'+id_product+'_'+combinacion.id_product_attribute+'">'+combinacion.groups[index]+'</td>';
                                else
                                    groupsText += '<td class="combProd" id="combProd_'+id_product+'_'+combinacion.id_product_attribute+'"></td>';
                            });

                            $("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones .productosComb tbody' ).append('<tr><td><input type="checkbox" class="comb_checkbox" id="comb_checkbox_'+id_product+'_'+combinacion.id_product_attribute+'"/></td>'+groupsText+'<td class="combProd" id="combProd_'+id_product+'_'+combinacion.id_product_attribute+'">'+combinacion.qty+'</td><td class="combProd" id="combProd_'+id_product+'_'+combinacion.id_product_attribute+'">'+combinacion.price+'</td></tr>');
                        });
                         $("#"+$.mobile.activePage.attr('id') + " .popupCombinaciones .productosComb tbody .combProd").click(function(){
                            var idComb = $(this).attr("id").replace("combProd_","");
                        	var prodSplit = idComb.split("_");
                            addToList(prodSplit[0],prodSplit[1],name,cantidadProd);
                        });
                    }
                });
                if(hayCombinaciones){
                    var dontSort = [];
                    $("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones table.productosComb thead th').each(function () {
                        if ($(this).hasClass( 'anadido' )|| $(this).hasClass( 'camposFijosPrimero' )) {
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
                            api.columns().indexes().flatten().each( function ( i ) {
                                var column = api.column( i );
                                var title = column.header();
                                if(!$(title).hasClass('camposFijos') && !$(title).hasClass('camposFijosPrimero')){
                                    var select = $('<select><option value="">'+$(title).html()+'</option></select>')
                                        .appendTo( $(column.header()).empty() )
                                        .on( 'change', function () {
                                            var val = $.fn.dataTable.util.escapeRegex(
                                                $(this).val()
                                            );

                                            column.search( val ? '^'+val+'$' : '', true, false ).draw();
                                        } );

                                    column.data().unique().sort().each( function ( d, j ) {
                                    	if(d != '')
                                    		select.append( '<option value="'+d+'">'+d+'</option>' )
                                    });
                                }
                            } );
                        },
                        "language":traducciones,
                        "sDom": '<"top">rt<"bottom"lp><"clear">',
                        "aaSorting": [[ $("#"+$.mobile.activePage.attr('id')+' .popupCombinaciones table.productosComb thead th' ).length-2, "desc" ]],
                        "aoColumns": dontSort,
                        "bPaginate":true,
                        "pageLength": 10,
                        "bFilter":true,
                        "bLengthChange":false,
                    });
                    $( "#"+$.mobile.activePage.attr('id')+' .popupCombinaciones' ).popup( "open");
                }
            }
            $('.loaderProductos').hide();
        });
    }else{
        doPlay();
        lista[id_product][attribute]['c'] = parseFloat(lista[id_product][attribute]['c'])+cantidadProd;
        //console.log(lista);
        $('#ctd_'+id_product+'_'+attribute+' .qty').html(lista[id_product][attribute]['c']);
        $('.loaderProductos').hide();
    }
    $(".order_query").val("");
}
function makeid(){
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 5; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}
function borrarProductosStock(){
    lista = new Array();
    $(".stockProduct").remove();
    $('#compra').hide();
    $('#compraVacia').show();
}
function deleteStockProduct(id_product,attribute){
    $('#stock_'+id_product+'_'+attribute).slideUp();
    $('#stock_'+id_product+'_'+attribute).remove();
    delete lista[id_product][attribute];
    var count = 0;
    for(var key in lista[id_product]) if(lista[id_product].hasOwnProperty(key)) count++;
    if(count==0)
        delete lista[id_product];
    count = 0;
    for(var key in lista) if(lista.hasOwnProperty(key)) count++;
    if(count==0){
        $('#compra').hide();
        $('#compraVacia').show();
    }
}
function search(nuevaBusqueda){
    var query = $('.order_query').val();
    if(nuevaBusqueda == 1){
            inicioProductos = 0;
            mySwiper.removeAllSlides();
    }
    if(query != ''){
  		delay(function(){
  			ultimaBusqueda = 'search';
            $.getJSON(token_actions,{action:'search', ajax:"1", tipoBusqueda:'stock',q: query, inicio:inicioProductos, cantidad:cantidad,inactivos: $('#inactivos').prop('checked'),
                id_lang: id_lang, id_shop: id_shop,conAtributos:false},function(data) {
                if(data != null) {
                    var index =0;
                    $.each(data, function(index, result) {
                        if(result.error != null){
                            mostrarError(result.error);
                        }else{
                            if(result.id != null){
                                var newSlide = mySwiper.appendSlide("<div class='swiper-slide producto' id='item_"+result.id+"'><span class='name'>"+result.name+"</span><img src='"+result.img+"'/><a id='fscreen_"+index+"' class='fullscreenProduct' title='"+result.name+"' href='"+result.big+"'></a></div>");
                                suscriboFullscreen('fscreen_'+index);

//								newSlide.setData("id",result.id);
//								newSlide.setData("attr",result.attr);
//								newSlide.setData("name",result.name);
//								newSlide.setData("type",'p');
//								mySwiper.appendSlide(newSlide);
                                index++;
//								var newSlide = mySwiper.createSlide("");
//								newSlide.setData("type",'f');
//								mySwiper.appendSlide(newSlide);
//								index++;
                  		    }
                        }
                    });
                    if(mySwiper.slides.length != 0){
                        $("#contProductos").addClass("conProductos");
                        inicioProductos += cantidad;
                    }
                  }else{
                	  if(inicioProductos ==0){
                		  $("#"+$.mobile.activePage.attr('id')+' .advertencia #nohayresultados').slideDown('fast');
                		  $("#"+$.mobile.activePage.attr('id')+' .advertencia #nohayresultados').delay(3000).slideUp('fast');
                	  }
                  }
          	});
      		},400 );
  	}else{
  		getCategoriaId('');
    }
}
function cargaMasProductos(){
    if(ultimaBusqueda == 'categoriaId')
        getCategoriaId($("#categorias").val());
    if(ultimaBusqueda == 'search')
        search(0);
}
function imprimirEtiquetas(){
    var idSupplyOrder = $('#imprimirEtiquetasSupplyOrder').val();
    if(idSupplyOrder != '')
        window.location = $("#urlBackoffice").val()+"/index.php?controller=AdminCodebar&submitSupplyOrder&idSupplyOrder="+idSupplyOrder+"&token="+$('#tokenLiteAdminCodebar').val();
}
function borrarCategoria(categoria,idCat){
    $(categoria).remove();
    var listaActual = $('#'+$.mobile.activePage.attr('id')+' input[name=categoriasNuevoProducto]').val();
    listaActual = listaActual.replace(idCat+",", "");
    $('#'+$.mobile.activePage.attr('id')+' input[name=categoriasNuevoProducto]').val(listaActual);
}
function recalcularListaCategorias(){
    var valor = $('#'+$.mobile.activePage.attr('id')+' select[name=selectCategoriasNuevoProducto]').val();
    if(valor != 0){
        $('#'+$.mobile.activePage.attr('id')+' input[name=categoriasNuevoProducto]').val($('#'+$.mobile.activePage.attr('id')+" input[name=categoriasNuevoProducto]").val()+valor+",");
    }
}
function borrarComb(ContComb){
    $(ContComb).parent().parent().parent().remove();
}
$(window).load(function() {
    //quitarCabeceras(1);
    mySwiper = new Swiper('#productos',{
        mode:'horizontal',
        slidesPerView: 'auto',
        KeyboardControl:true,
        freeMode: true,
        cssWidthAndHeight:false,
        queueStartCallbacks: true,
        threshold: 30,
    });
    mySwiper.on('touchEnd', function(event) {
        //compruebo si el threshold es mayor de 10, lo hago asi porque no funciona el parametro moveStartThreshold
        if(Math.abs(mySwiper.touches.startX - mySwiper.touches.currentX) > 300){
//			if(plantilla_pos != 'fiftyfifty')
                cargaMasProductos();
                event.preventDefault;
        }
    });
    mySwiper.on('tap', function(slide,event) {
        if(event.target.className.indexOf("fullscreenProduct") == -1){
            if(event.target.offsetParent.className.includes("producto")){
                var id = event.target.offsetParent.id.replace("item_","");
                var attr = 0;
                var name = $("#"+event.target.offsetParent.id).children(".name").html();
                addToList(id,attr,name);
            }else
            //caso en que no hay foto y clica sobre el fondo
            if(event.target.offsetParent.className.includes("swiper-wrapper") != false){
                var id = event.target.id.replace("item_","");
                var attr = 0;
                var name = $("#"+id).children(".name").html();
    			addToList(id,attr,name);
            }
        }
    });
    getCategoriaId('');
});
$(window).resize(function() {
    resizeContCompra();
});
$(document).ready(function() {
    $("a").not('.ui-mobile-viewport a').each(function(){
        $(this).attr("rel","external");
    });
    $.mobile.changePage("#TPVTienda");
    $('#check_all').on("click", function(event){
        event.defaultPrevented;
        if($(this).prop('checked'))
            $("input[name=productos]").prop('checked', true);
        else
            $("input[name=productos]").prop('checked', false);
    });
    $("#stockButton").on("click", function(event){
        $.mobile.changePage("#stock");
        createTableStock();
    });

    $("#categorias").on("change", function(event){
        inicioProductos=0;
        if(typeof mySwiper != 'undefined')
            mySwiper.removeAllSlides() ;
        getCategoriaId($('#categorias').val());
    });

    $(".okConfirmacion").on("click", function(event){
        $(this).addClass("ui-state-disabled");
        ejecutarReStock();
    });
    $(".okTraspasar").on("click", function(event){
        $(this).addClass("ui-state-disabled");
        traspasarStock();
    });
    $(document).on( "click", ".ponerBotonera", function( evt ) {
        valorActual = "";
        var id = $(this).attr("id");
        var ejeY = $("#"+id).offset().top + $("#"+id).outerHeight();
        modo="#popup"+id ;
    	var idCapaOrigen = id.replace("popup", "");
    	if($('#'+idCapaOrigen).hasClass('cambiopreciomayorista')){
            $( "#popupcambiopreciomayorista" ).popup("open", {x: $(this).offset().left + ($(this).outerWidth()/2),y: ejeY, changeHash : false});
            $( "#popupcambiopreciomayorista" ).bind({
                popupafterclose: function(event){
                    if(event.handled !== true){
           		        var aux = modo.replace("#popupcambiopreciomayorista_", "");
                        var product = aux.split("_");
                        modo = 0;
                   		var valorActual = $("[id^=cambiopreciomayorista_"+product[0]+"_"+product[1]+"]").html();
                   		lista[product[0]][product[1]]['wp'] = valorActual;
                        event.handled = true;
                        event.defaultPrevented;
                    }
                }
            });
        }
    	if($('#'+idCapaOrigen).hasClass('cambioprecio')){
            $( "#popupcambioprecio" ).popup("open", {x: $(this).offset().left + ($(this).outerWidth()/2),y: ejeY, changeHash : false});
            $( "#popupcambioprecio" ).bind({
                popupafterclose: function(event){
                    if(event.handled !== true){
                        var aux = modo.replace("#popupcambioprecio_", "");
                        var product = aux.split("_");
                        modo = 0;
                   		var valorActual = $("[id^=cambioprecio_"+product[0]+"_"+product[1]+"]").html();
                   		lista[product[0]][product[1]]['p'] = valorActual;
                        event.handled = true;
                        event.defaultPrevented;
                    }
                }
            });
        }
       	if($('#'+idCapaOrigen).hasClass('cantidadProducto')){
       	    $( "#popupcantidad" ).popup("open", {x: $(this).offset().left + ($(this).outerWidth()/2),y: ejeY, changeHash : false});
            $( "#popupcantidad" ).bind({
                popupafterclose: function(event){
                    if(event.handled !== true){
                        var aux = modo.replace("#popupcantidadProducto_", "");
                        var product = aux.split("_");
                        modo = 0;
                   		var valorActual = $("[id^=cantidadProducto_"+product[0]+"_"+product[1]+"]").html();
               			lista[product[0]][product[1]]['c'] = valorActual;
                        event.handled = true;
                        event.defaultPrevented;
                    }
                }
            });
        }
    });
    $('#inactivos').on('change', function(e){
         search(1);
    });
    $('.order_query').keyup(function(e) {
        if(e.keyCode == 38 || e.keyCode == 40 || e.keyCode == 13 || e.keyCode == 27) return;
        search(1);
  	});
    $("#confTablaStock").on("click", function(event){
            $("#popupConfTablaStock").popup( "open");
    });
    $('.order_query').keydown(function(e) {
     	switch(e.keyCode) {
        	case 38: // Up
        		break;
        	case 40: // Down
        		break;
        	case 13: // Enter
        		e.preventDefault();
               	buscoCodebar($(this).val());
               	break;
        	case 27: // Escape
        		e.preventDefault();
        		$(".order_query").val('');
        		inicioProductos=0;
                mySwiper.removeAllSlides();
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
    });
    $("#entradaCodigo .close").on("mouseout", function(event){
        $(this).css('color','#ddd');
    });
    $("#entradaCodigo .close").on("click", function(event){
        $(".order_query").val('');
        getCategoriaId('');
    });
    $(".anadirProductoButton").live("click", function(event){
        $("#"+$.mobile.activePage.attr('id')+ " .anadirProducto").addClass('open');
        $("#"+$.mobile.activePage.attr('id')+ " .popupProducto").popup("close");
        anadirMascara();
        initCamera();
        $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm #nombre').live('keyup', function(e) {
            $('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm .url').val(str2url($('#'+$.mobile.activePage.attr('id')+ ' .anadirProductoForm #nombre').val(), 'UTF-8'));
        });
        $('#'+$.mobile.activePage.attr('id')+ ' .precioSinIvaAnadirProd').keyup(function(e) {
            var priceTE = parseFloat(this.value.replace(/,/g, '.'));
            var newPrice = addTaxes(priceTE);
           $('#'+$.mobile.activePage.attr('id')+ ' .precioAnadirProd').trigger("focus");
            $('#'+$.mobile.activePage.attr('id')+ ' .precioAnadirProd').val((isNaN(newPrice) == true || newPrice < 0) ? '' : ps_round(newPrice, priceDisplayPrecision));
        });
        $('#'+$.mobile.activePage.attr('id')+ ' .precioAnadirProd').keyup(function(e) {
            if(e.keyCode != 9){// si escribo un tabulador no entro, asi evito que cambie el precio sin IVA
                var priceTI = parseFloat(this.value.replace(/,/g, '.'));
                var newPrice = removeTaxes(ps_round(priceTI, priceDisplayPrecision));
                $('#'+$.mobile.activePage.attr('id')+ ' .precioSinIvaAnadirProd').val((isNaN(newPrice) == true || newPrice < 0) ? '' : ps_round(newPrice, 6).toFixed(6));
            }
        });
        $('#'+$.mobile.activePage.attr('id')+ ' .anadirProducto_id_tax').live("change", function(event){
            var priceTE = parseFloat(this.value.replace(/,/g, '.'));
            var newPrice = addTaxes(priceTE);
            $('#'+$.mobile.activePage.attr('id')+ ' .precioAnadirProd').val((isNaN(newPrice) == true || newPrice < 0) ? '' : ps_round(newPrice, priceDisplayPrecision));
        });
        $('#'+$.mobile.activePage.attr('id')+ ' .nuevaComb').live("click", function(event){
            console.log("clic nueva comb");
            contCombs++;
            $('#'+$.mobile.activePage.attr('id')+ ' .contNuevaCombinacion').append('<div class="combinacioNuevoProducto comb_'+contCombs+'">'+$('#'+$.mobile.activePage.attr('id')+ ' .comb_0').html()+'</div>');
            $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contCombs+' select').each(function (key, item){
                $(item).parent().remove();
                $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contCombs+' .ui-controlgroup-controls').append($(item).attr('name',$(item).attr('name')+'_'+contCombs));
            });
            $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contCombs+' select').selectmenu();
            $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contCombs+' select').selectmenu('refresh');
            $('#'+$.mobile.activePage.attr('id')+ ' .comb_'+contCombs+' input').each(function (key, item){
                $(item).attr('name',$(item).attr('name')+'_'+contCombs);// le añado el contador para que no sea el mismo identidicador
            });
            $('#'+$.mobile.activePage.attr('id')+ ' .contNuevaCombinacion').show();
        });

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
    });
    $( "#TPVTienda .tabsAnadirProducto" ).tabs();
    var settingsDropZone = {
    	init: function () {
    		this.on("dragenter", function(event) {
    	       	$('#'+$.mobile.activePage.attr('id')+ ' .dragging').show();
    		});
    		this.on("addedfile", function(event) {
    	       	$('#'+$.mobile.activePage.attr('id')+ ' .dragging').hide();
    		});
    	},
    	thumbnailWidth:80,
    	thumbnailHeight:80,
    	dictRemoveFile:borrar,
    	addRemoveLinks:true,
    	url: "../modules/tpvtienda/classes/actions/actionsAnadirProducto.php?action=subirImagen&token="+token,
    	success: function(file, data) {
    	   	$('#'+$.mobile.activePage.attr('id')+' .subidaImagenesProducto').addClass("dropzone");
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
    };
    anadirProductoDropZone = $('#'+$.mobile.activePage.attr('id')+' .subidaImagenesProducto').dropzone(settingsDropZone);

    $('.checkall').click(function(){
        if($(this).prop('checked') != true)
            $('.comb_checkbox').prop('checked', false);
        else
            $('.comb_checkbox').prop('checked', true);
    });
    $(".comb_checkbox_enviar").click(function(){
        $("#"+$.mobile.activePage.attr('id')+ " .comb_checkbox").each(function(){
            if( $(this).prop('checked')){
                var idComb = $(this).attr("id").replace("comb_checkbox_","");
    	        var prodSplit = idComb.split("_");
                addToList(prodSplit[0],prodSplit[1],1);
            }
        });
    });
    $(document).keydown(function (e) {
        if(modo == 0){
            teclas +=  String.fromCharCode(e.keyCode);
            delay(function(){printKeys()},400 );
        }else{
            var tecla = e.keyCode;
            //TO-DO tecla intro cierra el popup
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
            if(tecla == 110 ||tecla == 190)
            	teclaPulsada = '.';
            if(tecla == 96 ||tecla == 48)
                teclaPulsada = 0;
            if(tecla == 8 ||tecla == 46)
            	teclaPulsada = 'CE';
            if(tecla == 13 ) // pulso intro
            	teclaPulsada = '';
            var idCapaOrigen =  modo.replace("#popup", "");
            if(idCapaOrigen == "pagadoButton"){
                calculoDeCambioTecla(teclaPulsada);
            }else{
                valorActual = valorActual.replace(/,/g,"");//asi borra todas las comas del número, con "," como primer parametro solo borraría la primera ocurrencia
                if(teclaPulsada == 'CE')
                    var valorNuevo=valorActual.substr(0,valorActual.length-1);
                else{
                    if($.isNumeric(teclaPulsada) || teclaPulsada == '.'){
                        var valorNuevo=valorActual.toString()+teclaPulsada.toString();
                    }else{
                        if(teclaPulsada != '')
                            $('#' + idCapaOrigen).next('.subField').html(teclaPulsada);
                        var valorNuevo=valorActual.toString();
                    }
                }
                valorActual = valorNuevo;
                $('#'+idCapaOrigen).html(valorNuevo);
            }
            if(tecla == 13 ){
            	$( "#popup"+idCapaOrigen).popup( "close" );
            }
            e.preventDefault();
        }
    });
    var buttonCommon = {
            exportOptions: {
                format: {
                    body: function ( data, row, column, node ) {
                        // Strip $ from salary column to make it numeric
                    	if(column === (huecosStock + 8)){
                    		data = data.split( '"');
                    		return data[7];
                    	}
                    	if(column === (huecosStock + 6)){
                    		data = data.split('"');
                    		return data[9]+"%";
                    	}
                    	if(column === (huecosStock + 5)){
                    		data = data.split( '"');
                    		return data[7];
                    	}
                    	return data;
                    }
                }
            }
        };
    resumenStock = $('#resumenStockTable').DataTable({
      	dom: 'Brtp',
        buttons: [
            { extend: 'copy',text: copyTxT, attr: { id: 'allan' } }, 'csv', 'excel', 'pdf',  {extend: 'print', text: printTxT}
        ],
        "language":traducciones,
        "bPaginate":true,
        "pageLength": 4,
    });
    movsStock = $('#movsStockTable').DataTable({
      	dom: 'Brtp',
        buttons: [
            { extend: 'copy',text: copyTxT, attr: { id: 'allan' } }, 'csv', 'excel', 'pdf',  {extend: 'print', text: printTxT}
        ],
        "columnDefs": [
        { "width": "370px", "targets": 0 },
        { "width": "auto", "targets": 1 },
        { "width": "auto", "targets": 2 },
        { "width": "auto", "targets": 3 },
        { "width": "auto", "targets": 4 },
        { "width": "auto", "targets": 5 },
        { "width": "auto", "targets": 6 },
        { "width": "120px", "targets": 7 },
        ],
        "language":traducciones,
        "bPaginate":true,
        "pageLength": 4,
    });
    $.mobile.document.on( "click", ".key", function( evt ) {
        var id = modo;
        id = id.replace("popup","");
        var teclaPulsada = $(this).html();
        if(id == "pagadoButton"){
            calculoDeCambioTecla(teclaPulsada);
        }else{
            valorActual = valorActual.replace(/,/g,"");//asi borra todas las comas del número, con "," como primer parametro solo borraría la primera ocurrencia
            if(teclaPulsada == 'CE' || teclaPulsada == '<span class="CEButton">CE</span>' )
                var valorNuevo=valorActual.substr(0,valorActual.length-1);
            else{
                if($.isNumeric(teclaPulsada) || teclaPulsada == '.'){
                    var valorNuevo=valorActual.toString()+teclaPulsada.toString();
                }else{
                    $('#' + id).next('.subField').html(teclaPulsada);
                    var valorNuevo=valorActual.toString();
                }
            }valorActual = valorNuevo;
            $(id).html(valorNuevo);
        }
        evt.preventDefault();
    });
    rellenarCategorias();
});
( function( $ ) {
    function pageIsSelectmenuDialog( page ) {
        var isDialog = false, id = page && page.attr( "id" );
        $( ".filterable-select" ).each( function() {
            if ( $( this ).attr( "id" ) + "-dialog" === id ) {
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
            var input, selectmenu = $( event.target ), list = $( "#" + selectmenu.attr( "id" ) + "-menu" ), form = list.jqmData( "filter-form" );
            // We store the generated form in a variable attached to the popup so we avoid creating a
            // second form/input field when the listview is destroyed/rebuilt during a refresh.
            if ( !form ) {
                input = $( "<input data-type='search'></input>" );
                form = $( "<form></form>" ).append( input );
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
                    selectmenu.selectmenu( "refresh" );
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
            listview = data.toPage.find( "ul" );
            form = listview.jqmData( "filter-form" );
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
            listview = data.toPage.find( "ul" );
            form = listview.jqmData( "filter-form" );
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
    $(".groupC").on("click", function(event){
        createTableStock();
    });
    $(document).on("pagecontainerhide", function () {
        $("#categorias-menu li").removeClass("ui-screen-hidden");
        $("input", form).val("");
    });
});