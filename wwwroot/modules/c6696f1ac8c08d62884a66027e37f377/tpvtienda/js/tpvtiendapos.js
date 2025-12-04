//variables del buscador
var inicioProductos = 0;
var cantidadProductos = 9999;
var cantidadClientes = 200;
//variables del entorno
var ultimaBusqueda = 'categoriaId';
var resizeTimer;
//0 normal, capta el teclado para los codebars
//1 botonera. capta los numeros para la botonera
//2 Otro tipo de campo. en este estado no afecta a cantidadCodebar
var modo = 0;
var signaturePad = '';
var padNoInicializado = 0;


var valorActual = "";
var mySwiper = "";
var paginadorDevoluciones = 0;
var paginadorAparcados = 0;
var keys = {};
var teclas = '';
var teclaPulsada = '';
var listaDevoluciones = new Array();
var tax = $('#tax').val();
var anchuraTicket = 300;
var listadoPagos = new Array();

function initializePad(){
	
	var wrapper = document.getElementById("signature-pad"),
    clearButton = wrapper.querySelector("[data-action=clear]"),
    saveButton = wrapper.querySelector("[data-action=save]"),
    canvas = wrapper.querySelector("canvas"),signaturePad;

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
	clearButton.addEventListener("click", function (event) {
	    signaturePad.clear();
	});
		
	saveButton.addEventListener("click", function (event) {
		salvarFirma(signaturePad);
		$('.maskTPVTienda').trigger("click");
	});
	padNoInicializado = 1;
}
function salvarFirma(signaturePad){
	if (signaturePad.isEmpty()) {
	    alert("Please provide signature first.");
	} else {
		$.post("../modules/tpvtienda/classes/actions/actionsPedido.php",{action:"anadirFirma", id_order: $("#id_order_documento").val(), 
			img:signaturePad.toDataURL().substring(22, signaturePad.toDataURL().length),id_order_invoice:$("#id_order_invoice_documento").val(),
			tipo:$("#tipo_documento").val()},function(data) {
			if(data == 1){
				actualizarDocumentosFirmados();
	    	}
	    });
		$(".m-signature-pad").hide();
	}
}
function renovarCarrito(){
	$.getJSON(baseUri+"modules/tpvtienda/classes/actions/actions.php",{action: 'renovarCarrito',id_employee: id_employee,id_currency: $('#id_currency').val(),id_shop: $('#id_shop').val()},function(data) {
		if(data != null){
			$("#id_cart").val(data[0].id_cart);
			//updateCompra(); no hace falta hacer otra llamada a actualizar la compra, en lugar de eso llamo a totales y borro la lista con jquery
			$('#compra').hide();
			$('#compraVacia').show();
			//pongo a 0 contadores
			$('#totalButton span').html(formatCurrency(0, currencyFormat, currencySign, currencyBlank));
			$('#ivaButton span').html(formatCurrency(0, currencyFormat, currencySign, currencyBlank));
			$('.descuentosButton span').html(formatCurrency(0, currencyFormat, currencySign, currencyBlank));
			$('#aDevolverButton').html(formatCurrency(0, currencyFormat, currencySign, currencyBlank));
			$('#pagadoButton').html(formatCurrency(0, currencyFormat, currencySign, currencyBlank));
			$("#closeRemoveCustomer").trigger("click");
		}
	});
}
function getCategoriaId(id){
	ultimaBusqueda = 'categoriaId';
	if(id == ''){
		inicioProductos = 0;
		id=$('#categorias').val();
	}
	var listaProd = $("input[name=listaProd]:checked").val();
	 $.getJSON(token_actions,{ action: 'categoriaId', id_cat: id, id_shop: $('#id_shop').val(),id_lang: $('#id_lang').val(),inicio:inicioProductos,cantidad:cantidadProductos},function(data) {
		if(data != null){
			var index = 0;
			$.each(data, function(index, result) {
				if(typeof result.p ==='object' && result.p !=null){
					if(listaProd == 'grid'){
						var newSlide = $("<div class='contProducto' id='item_"+index+"'><a id='fscreen_"+index+"'class='fullscreenProduct' title='"+result.p.name+"' href='"+result.p.big+"'></a>" +
								"<div class='producto' onclick='addCart("+result.p.id+",0,1);'  >"+((mostrarPrecios == 1) ? "<span class='precio'>"+result.p.p+"</span>" : "" )+"<span class='name'>"+result.p.name+"</span><img src='"+result.p.img+"'/></div></div>");
						$("#contProductos").append(newSlide);
					}else{
						var newSlide = $("<tr class='contProducto' id='item_"+index+"'>" +
								"<td><a id='fscreen_"+index+"'class='fullscreenProduct' title='"+result.p.name+"' href='"+result.p.big+"'><img src='"+result.p.img+"'/></a></td>" +
								"<td onclick='addCart("+result.p.id+",0,1);'>"+result.p.name+"</td>"+
								"<td class='refList' onclick='addCart("+result.p.id+",0,1);'>"+result.p.ref+"</td>"+
								"<td class='stockList' onclick='addCart("+result.p.id+",0,1);'>"+result.p.stock+"</td>"+
								"<td class='precioList'>"+result.p.p+"</td>" +
								"</tr>");
						$("#contProductos2 tbody").append(newSlide);
					}
					index++;
				}
	        });
			inicioProductos += cantidadProductos;
		}else{
			if(inicioProductos ==0){
				$('#advertencia #nohayresultados').slideDown('fast');
				$('#advertencia #nohayresultados').delay(3000).slideUp('fast');
			}
        }
	});
}
function deleteProduct(id_cart,id_product,id_product_attribute){
	$.getJSON(baseUri+"modules/tpvtienda/classes/actions/actions.php",{action:'deleteProduct',id_address_delivery:$('#id_address_delivery').val(),id_cart: id_cart, id_shop:$('#id_shop').val(),
		id_lang: $('#id_lang').val(),id_product:id_product,id_product_attribute:id_product_attribute,id_currency: $("#id_currency").val()
		},function(data) {
		if(data != null){
			$.each(data, function(index, result) {
				if(result.error != null){
					mostrarError(result.error);
				}
				if(result.ok == 1){
					$('tr#linea_'+id_product+'_'+id_product_attribute).fadeOut("slow");
					doPlay();
				}
				if(result.ok == 2){
					$('#compra').hide();
					$('#compraVacia').show();
				}
				updateCompra();
			});
		}
	});
}
function getDiscountsInCart(){
	$.getJSON(baseUri+"modules/tpvtienda/classes/actions/actions.php",{action:'getDiscountsInCart',borrarDescuento:borrarDescuento,id_currency: $('#id_currency').val(),id_shop: $('#id_shop').val(),id_lang: $('#id_lang').val(),id_customer: $('#id_customer').val(), id_cart: $('#id_cart').val()},function(data) {
		if(data != ''){
			$.each(data, function(index, result) {
				if(result.error != null){
					mostrarError(result.error);
				}else{			
					if(result.html != ''){
						$('.descAplicados').slideDown();
						$('#descuentosAplicados').html(result.html);
					}else{
						$('.descAplicados').slideUp();
					}
				}
			});
		}
	});
}
function aparcar(){
	$.getJSON(baseUri+"modules/tpvtienda/classes/actions/actionsAparcados.php",{action: 'apacarCarrito',id_cart:$('#id_cart').val(),
		id_lang: $('#id_lang').val(),id_shop: $('#id_shop').val(),id_employee: id_employee},function(data) {
			$.each(data, function(index, result) {
				if(result.error != null)
					mostrarError(result.error);
				if(result.id_cart != null){
					totales();
					renovarCarrito();
					$("#messageOrder").val('');
					$("#idCarrito").html(result.id_cart);
					$('#advertencia,#advertencia #confAparcado').slideDown('fast');
				}
			});
	});
}
function borrarProductos(){
	$('#compra').hide();
	$('#compraVacia').show();
	$.getJSON(baseUri+"modules/tpvtienda/classes/actions/actions.php",{action: 'deleteProducts',id_cart:$('#id_cart').val(),id_lang: $('#id_lang').val(),id_shop: $('#id_shop').val(),id_employee: id_employee},function(data) {
		if(data == 1){
			totales();
			renovarCarrito();
			updateCarriers();
			$("#messageOrder").val('');
		}else{
			$.each(data, function(index, result) {
				if(result.error != null)
					mostrarError(result.error);
			});
		}
	});
}
function addCart(id_product,attribute,cantidadProd) {
	if(cantidadProd == null)
		cantidadProd = 1;
	$.getJSON(baseUri+"modules/tpvtienda/classes/actions/actions.php",{action:'addCart',id_cart: $('#id_cart').val(),id_shop: $('#id_shop').val(), id_lang: $('#id_lang').val(), id_product:id_product,
		attribute:attribute,cantidad:cantidadProd},function(data) {
		$.each(data, function(index, result) {
			if(result.error != null)
				mostrarError(result.error);
			if(result.ok == 'ok'){
				doPlay();
			    $( "#item_"+id_product+"_"+attribute).effect( "transfer", { to: "#contCompra", className: "ui-effects-transfer" }, 500, updateCompra() );
			}
		});
	});
	$("#order_query").val("");
	$("#order_query").focus();
}
function totales(){
	$('#totalButton span').fadeOut( "fast" );
	$('#ivaButton span').fadeOut( "fast" );
	$('.descuentosButton span').fadeOut( "fast" );
	$('#envioButton span').fadeOut( "fast" );
	$.getJSON(baseUri+"modules/tpvtienda/classes/actions/actions.php",{action:'totales', id_customer:$('#id_customer').val(), id_currency: $("#id_currency").val(), 
		id_shop: $('#id_shop').val(),id_lang: $('#id_lang').val(), tax:tax,id_carrier: $('#id_carrier').val(),id_cart:$('#id_cart').val()},function(data) {
		$.each(data, function(index, result) {
			if(result.error != null){
				mostrarError(result.error);
			}else{
				if(result.total != null){
					$('#totalButton span').html(result.total);
					$('#totalButton span').fadeIn( "fast" );
				}
				if(result.descuentos != null){
					$('.descuentosButton span').html(result.descuentos);
					$('.descuentosButton span').fadeIn( "fast" );
				}
				if(result.totalIva != null){
					$('#ivaButton span').html(result.totalIva);
					$('#ivaButton span').fadeIn( "fast" );
				}
			}
		});
	});
}
function updateCompra(hideLastItem){
	$.getJSON(baseUri+"modules/tpvtienda/classes/actions/actionsPos.php",{action:'updateCompra',id_lang:$('#id_lang').val(), id_currency: $("#id_currency").val(),
		id_customer:$('#id_customer').val(), tax:tax,id_address_delivery:$('#id_address_delivery').val(), id_cart: $('#id_cart').val(), id_shop: $('#id_shop').val()},function(data) {
		if(data != null){
			$.each(data, function(index, result) {
				if(result.error != null){
					mostrarError(result.error);
				}else{		
					if(result.html != ''){
						$('#compra tbody').html(result.html);
						if(hideLastItem != true)
							$('#compra tbody tr:last-child').fadeIn(1000);
						$('#compraVacia').hide();
						$('#compra').show();
					}else{
						$('#compra').hide();
						$('#compraVacia').show();
					}
				}
			});
			$('#compra').trigger('create');
			totales();
			$(".customization .dropzone").dropzone({ 
		  		init: function () {
		  			this.on("dragenter", function(event) {
		  			   	$(this).children('.dragging').show();
		  			});
		  			this.on("addedfile", function(event) {
		  			   	$(this).children('.dragging').hide();
		  			});
		  			this.on("removedfile", function(file) {
		  				 $(this).removeAllFiles(true);
		  			});
		  		},
		  		thumbnailWidth:80,
		  		maxFiles:1,
		  		thumbnailHeight:80,
		  		dictRemoveFile:borrar,
		  		addRemoveLinks:true,
		  		url: "../modules/tpvtienda/classes/actions/actionsCustomization.php",
		  	});
		}
	});
}
function changeQty(idCapaOrigen){
	var aux = idCapaOrigen.replace("cantidadProducto_", "");
	var product = aux.split("_");
	var quantity = $('#'+idCapaOrigen).html();
	$.getJSON(baseUri+"modules/tpvtienda/classes/actions/actions.php",{action:'changeQty',cantidadProductoAntigua:product[2], quantity:quantity,id_cart: $('#id_cart').val(),id_lang: $('#id_lang').val(),
		id_shop: $('#id_shop').val(), id_product:product[0], id_product_attribute:product[1]},function(data) {
		if(data != ''){
			if(data==1){
				$('#compra').show();
				$('#compraVacia').hide();
				updateCompra();
			}else{
				$.each(data, function(index, result) {
					if(typeof result.error ==='object' && result.error !=null){
						$('#'+result.error.motivo+' strong').html(result.error.name);
						updateCompra();
						$('#'+result.error.motivo).show();
						$('#'+result.error.motivo).delay(4000).slideUp('fast');
					}
				});
			}
		}
	});
}
function changeCombination(id_product,id_product_attribute_viejo, id_product_attribute,quantity){
	$.getJSON(baseUri+"modules/tpvtienda/classes/actions/actions.php",{action:'changeCombination', id_shop: $('#id_shop').val(), id_product_attribute_viejo:id_product_attribute_viejo,
		quantity:quantity,id_cart: $('#id_cart').val(), id_lang: $('#id_lang').val(), id_product:id_product, id_product_attribute:id_product_attribute},function(data) {
		if(data != ''){
			if(data==1){
				$('#compra').show();
				$('#compraVacia').hide();
				updateCompra();
			}else{
				$.each(data, function(index, result) {
					if(typeof result.error ==='object' && result.error !=null){
						$('#'+result.error.motivo+' strong').html(result.error.name);
						updateCompra();
						$('#'+result.error.motivo).show();
						$('#'+result.error.motivo).delay(4000).slideUp('fast');
					}
				});
			}
		}
	});
}


function buscoPLU(query){
	id_prod = parseInt(query.substring(1, 6));
	peso = parseFloat(query.substring(6, 8)+'.'+query.substring(8, 11));
	$.getJSON(baseUri+"modules/tpvtienda/classes/actions/actions.php",{action: 'search', tipoBusqueda:'plu', q: id_prod, inicio:0,cantidad:1,id_lang: $('#id_lang').val(), id_shop: $('#id_shop').val(),
		inactivos: $('#inactivos').attr('checked')},function(data) {
		if(data != null) {
			$.each(data, function(index, result) {
				if(result.error != null){
					mostrarError(result.error);
				}else{
					if(result.id != null){
						cambioPrecioPeso(result.id,result.attr,peso)
						//meto la primera coincidencia en la lista de la compra
						addCart(result.id,result.attr,1);
		  		    }
				}
		    });	
	     }else{
				$('#advertencia #nohayresultados').slideDown('fast');
				$('#advertencia #nohayresultados').delay(3000).slideUp('fast');
         }
  	});
}
function buscoCodebar(query,cantidad){
	$.getJSON(baseUri+"modules/tpvtienda/classes/actions/actions.php",{action: 'search', tipoBusqueda:'normal', q: query, inicio:0,cantidad:cantidad,id_lang: $('#id_lang').val(), id_shop: $('#id_shop').val(),
		inactivos: $('#inactivos').attr('checked')},function(data) {
		if(data != null) {
			$.each(data, function(index, result) {
				if(result.error != null){
					mostrarError(result.error);
				}else{
					if(result.id != null){
						//meto la primera coincidencia en la lista de la compra
						addCart(result.id,result.attr,cantidad);
		  		    }
				}
		    });	
	     }else{
				$('#advertencia #nohayresultados').slideDown('fast');
				$('#advertencia #nohayresultados').delay(3000).slideUp('fast');
         }
  	});
}

function search(nuevaBusqueda){
	var query = $('#order_query').val();
	if(query != ''){
  		delay(function(){
  			ultimaBusqueda = 'search';
  			if(nuevaBusqueda == 1){
  				inicioProductos = 0;
  				mySwiper.removeAllSlides();
  			}
			$.getJSON(baseUri+"modules/tpvtienda/classes/actions/actions.php",{action: 'search', q: query,  tipoBusqueda:'normal', inicio:inicioProductos, cantidad:cantidadProductos,inactivos: $('#inactivos').attr('checked'),
				id_lang: $('#id_lang').val(), id_shop: $('#id_shop').val()},function(data) {
				if(data != null) {
					$.each(data, function(index, result) {
						if(result.error != null){
							mostrarError(result.error);
						}else{
							if(result.id != null){
								var newSlide = $("<div class='contProducto'><a id='fscreen_"+result.id+"' class='fullscreenProduct' title='"+result.name+"' href='"+result.big+"'></a>" +
										"<div class='producto' onclick='addCart("+result.id+","+result.attr+",1)' id='item_"+result.id+"'>"+"<span class='precio'>"+
										result.p+"</span>"+"<span class='name'>"+result.name+"</span><img src='"+result.img+"'/></div></div>");
								$("#contProductos").append(newSlide);
				  		    }
						}
				    });	
					if(mySwiper.slides.length != 0){
						inicioProductos += cantidadProductos;
					}
		          }else{
		        	  if(inicioProductos ==0){
		        		  $('#advertencia #nohayresultados').slideDown('fast');
		        		  $('#advertencia #nohayresultados').delay(3000).slideUp('fast');
		        	  }
		          }
		  	});
	  		},400 );
  	}else{
  		getCategoriaId('');
	}
}
	

function actualizarCustomizaciones(id_address_delivery){
   $.getJSON(baseUri+"modules/tpvtienda/classes/actions/actionsCustomization.php",{action:'actualizarCustomization',id_lang: $('#id_lang').val(),id_customer:$("#id_customer").val(),
	   id_currency: $('#id_currency').val(), id_shop: $('#id_shop').val(), id_address_delivery:id_address_delivery,
	   id_cart: $('#id_cart').val()},function(data) {
   });
}
function mostrarError(error){
	if(typeof errores[error] != 'undefined'){
		$('#advertencia .notificationGood').html(errores[error]);
	}else{
		$('#advertencia .notificationGood').html(error);
	}
	$('#advertencia .notificationGood').slideDown('fast');
	$('#advertencia .notificationGood').delay(3000).slideUp('fast');
}
function printKeys() {
    if(teclas.length > 12){
    	if(!$("#order_query").is(":focus")){
    		if(teclas.length == 13 && upc_como_plu == 1 && teclas[0] == 1){
    			buscoPLU(teclas.replace(/\r|\t|\n/, ""));
    		}else{
	    		var cantidadCodebar = $('#cantidadCodebar').html();
	    		buscoCodebar(teclas.replace(/\r|\t|\n/, ""),cantidadCodebar);
		    	$('#cantidadCodebar').html(1);
		    	$('#cantidadCodebar').removeClass('alterado');	
    		}
    	}
    }else{
    	if(!$("#order_query").is(":focus")){
    		var cantidadCodebar = teclas;
	    	if($.isNumeric(cantidadCodebar) && cantidadCodebar != ''){
	    		$( "#cantidadCodebar" ).effect( "bounce", {}, 500,  function(event){
    																$('#cantidadCodebar').html(cantidadCodebar);
    																$('#cantidadCodebar').addClass('alterado');
    															});
	    	}
    	}
    } 
    teclas = '';
}
function anadirMascara(){
	$('#TPVTienda').append('<div class="maskTPVTienda"></div>');
	$('.maskTPVTienda').show();
	$('.maskTPVTienda').on("click", function(event){
		modo=0;
		$('.maskTPVTienda').remove();
		$("#subTPVTienda").removeClass("open");
		$(".panel_lateral").delay(4500).removeClass('open');
	});
}

function atajosTeclado(tecla){
	//console.log(e.keyCode);
	if(tecla == 117){ // F6
		borrarProductos();
		$("#order_query").focus();
    }
	if(tecla == 118){ // F7
		$("#pagadoButton").trigger("click");
    }
	if(tecla == 113){ // F2
		$("#order_query").focus();
    }
	if(tecla == 27){ // ESC
		borrarProductos();
    }
	if(tecla == 121){ //F10
		aparcar();//confirma compra
    }
}
function cargaMasProductos(){
	if(ultimaBusqueda == 'categoriaId')
		getCategoriaId($("#categorias").val());
	if(ultimaBusqueda == 'search')
		search(0);
}
$(window).load(function() {
    //quitarCabeceras(1);
   /* mySwiper = new Swiper('#productos',{ 
		mode:'horizontal', 
		slidesPerView: 'auto',
		 height: 500,
		KeyboardControl:true,
		freeMode: true,
		onSlideTouch:function(swipe) {
			cargaMasProductos();
		},
		onSlideClick:function(swipe) {
			var tipo = mySwiper.getSlide(swipe.clickedSlideIndex).getData("type");
			if(tipo == 'p'){
				var id = mySwiper.getSlide(swipe.clickedSlideIndex).getData("id");
				var attr = mySwiper.getSlide(swipe.clickedSlideIndex).getData("attr");
				addCart(id,attr,1);
			}
			if(tipo == 'f'){
				var done = false;
				$('.fullscreenProduct').fancybox({
					afterLoad: function () {
				    	if ((this.index == this.group.length - 1) && done == false) {
				    		done=true;
				    		var id = mySwiper.getSlide(swipe.clickedSlideIndex-1).getData("id");
							var attr = mySwiper.getSlide(swipe.clickedSlideIndex-1).getData("attr");
				    		var group = this.group;
				    		$.getJSON(baseUri+"modules/tpvtienda/classes/actions/actions.php",{action:'getImagenesGaleria',id_lang:$("#id_lang").val(),id_product:id,attribute:attr},function(data) {
				    			if(data != null) {
				    			   $.each(data, function(index, result) {
				    				   group.push({ href: result.img, type: "image", title: result.name, isDom: false });
				    			   });
				    			}
				    		});
				        } // if
				    	$(".fancybox-outer").append('<div class="addCartButton"><a onclick="addCart('+id+','+
				    			attr+');$.fancybox.close()" class="ui-shadow ui-btn-icon-left ui-icon-plus ui-btn ui-corner-all"><span>'+anadirPedido+'</span></a></div>');
				    },
				 });
			}
		}
    });
    
	$('#view_scroll_left').on('click', function(e){
		e.defaultPrevented;
		mySwiper.swipePrev();
		cargaMasProductos();
	});
	$('#view_scroll_right').on('click', function(e){
		e.defaultPrevented;
		mySwiper.swipeNext();
		cargaMasProductos();
	});
	*/
	getCategoriaId('');
	
});

$(document).ready(function() {
	$("a").not('.ui-mobile-viewport a').each(function(){
        $(this).attr("rel","external");
	});
	$.ajaxSetup({ cache: false });
    updateCompra();
    $.mobile.document.on( "click", ".ponerBotonera", function( evt ) {
    	valorActual = "";
    	var id = $(this).attr("id");
   		ejeY = $("#"+id).offset().top + $("#"+id).outerHeight();
        $( "#popup"+id ).popup("open", {x: $(this).offset().left + ($(this).outerWidth()/2),y: ejeY, changeHash : false});
        $( "#popup"+id ).bind({ 
            popupafterclose: function(event){
            	modo=0;
        		var id = $( this).attr("id");
				var idCapaOrigen =  id.replace("popup", "");
			    if($('#'+idCapaOrigen).hasClass('qty')){
					changeQty(idCapaOrigen);
				}
				$('[id^=popupcantidadProducto]').remove();
				event.defaultPrevented;
			}
        });
        evt.defaultPrevented;
    });
    $(document).keydown(function (e) {
    	if(modo != 2){
    		var tecla = e.keyCode;
	    	if(modo == 0){
	    		if(tecla == 37 || tecla == 39){
		    		if(tecla == 37)// tecla izquierda
		        		mySwiper.swipePrev();
		        	if(tecla == 39)// tecla derecha
		        		mySwiper.swipeNext();
	    		}else{
	    			teclas +=  String.fromCharCode(tecla);
	    			delay(function(){printKeys()},50 );
	    		}
	    	}else{
	    		atajosTeclado(tecla);
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
	    	    e.defaultPrevented;
	    	}
    	}
    });
    $.mobile.document.on( "click", ".key", function( evt ) {
    	var id = $(this).parent().parent().attr("id");
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
    		$('#'+id).html(valorNuevo);
    	}
    	evt.defaultPrevented;
    });
	var timerMenu;
	
	$('.fullscreenProduct').fancybox({
		afterLoad: function (current) {
			var attrId = $(this.element).parents('.contProducto').attr("id");
			var id = attrId.replace("item_", "");
			var identificador = id.split("_");

	    		var group = this.group;
	    		$.getJSON(baseUri+"/modules/tpvtienda/classes/actions/actions.php",{action:'getImagenesGaleria',id_lang:$("#id_lang").val(),id_product:identificador[0],attribute:identificador[1]},function(data) {
	    			if(data != null) {
	    			   $.each(data, function(index, result) {
	    				   group.push({ href: result.img, type: "image", title: result.name, isDom: false });
	    			   });
	    			}
	    		});
	    	$(".fancybox-outer").append('<div class="addCartButton"><a onclick="addCart('+identificador[0]+','+
	    			identificador[1]+');$.fancybox.close()" class="ui-shadow ui-btn-icon-left ui-icon-plus ui-btn ui-corner-all"><span>'+anadirPedido+'</span></a></div>');
	    },
	 });
    $(document).on("keydown", function(e){
    	//SHORTCUTS
    	teclaPulsada = e.keyCode;
    	atajosTeclado(teclaPulsada);
	});
	$('#order_query').keyup(function(e) {
		if(e.keyCode == 38 || e.keyCode == 40 || e.keyCode == 13 || e.keyCode == 27) return;
		search(1);
  	});
	$('#order_query').keydown(function(e) {
	 	switch(e.keyCode) {
	    	case 38: // Up
	    		break;
	    	case 40: // Down
	    		break;
	    	case 13: // Enter
	    		e.defaultPrevented;
		       	buscoCodebar($(this).val(),$('#cantidadCodebar').html());
		       	$('#cantidadCodebar').html(1);
		       	$('#cantidadCodebar').removeClass('alterado');
		       	break;
	    	case 27: // Escape
	    		e.defaultPrevented;
	    		$("#order_query").val('');
	    		inicioProductos=0;
				mySwiper.removeAllSlides();
	    		getCategoriaId('');
	    		break;
		}
	});	 
	$("#order_query").on("mouseover", function(event){
	  	$("#entradaCodigo .close").show();
	});
	$("#order_query").on("mouseout", function(event){
		$("#entradaCodigo .close").hide();
	});
	$("#entradaCodigo .close").on("mouseover", function(event){
		$(this).show();
		$(this).css('color','black');
	});
	$("#entradaCodigo .close").on("mouseout", function(event){
		$(this).css('color','#ddd');
	});
	$("input[name=listaProd]").on("click", function(event){
		var listaProd = $("input[name=listaProd]:checked").val();
		if(listaProd == 'list'){
			$("#contProductos").hide();
			$("#contProductos2").show();
		}else{
			$("#contProductos").show();
			$("#contProductos2").hide();
		}
		$("#contProductos").html("");
		$("#contProductos2 tbody").html("");
		getCategoriaId('');
	});
	$("#entradaCodigo .close").on("click", function(event){
		$("#order_query").val('');
		getCategoriaId('');
	});

	$("#my-awesome-dropzone").dropzone({ 
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
		url: "../modules/tpvtienda/classes/actions/actionsAnadirProducto.php",
	    success: function(file, data) {
	    	$("#my-awesome-dropzone").addClass("dropzone");
	    	var data = $.parseJSON(data);
	    	 if(data != 0){
					$(data).each(function (key, item){
						if(item.filename != ""){
							var fotos = $("#anadirProductoForm input[name=fotos]").val();
							if(fotos == "")
								$("#anadirProductoForm input[name=fotos]").val(item.filename);
							else
								$("#anadirProductoForm input[name=fotos]").val($("#anadirProductoForm input[name=fotos]").val()+","+item.filename);
						}
					});
			  }
	    }
	});
	$('.custField').on("blur", function(e) {
		var id = $(this).attr("id");
		var aux = id.replace("cust_", "");
		var value = $(this).val();
		var customization = aux.split("_");
		var quantity = $('#linea_'+customization[1]+'_'+customization[2]+' .qty').html();
		$.getJSON("../modules/tpvtienda/classes/actions/actionsCustomization.php",{action:'guardarCustomization',id_lang: $('#id_lang').val(),id_customer:$("#id_customer").val(),
		   index:customization[0], id_currency: $('#id_currency').val(), id_shop: $('#id_shop').val(), value: value,id_product:customization[1],id_address_delivery: $('#id_address_delivery').val(),
		   id_product_attribute:customization[2],quantity:quantity, id_cart: $('#id_cart').val()},function(data) {
		   if(data != null) {
			   efectoGuardado('#'+id);
		   }
		});
	});
	$("#categorias").on("change", function(event){
		inicioProductos=0;
		$("#contProductos").html("");
		$("#contProductos2 tbody").html("");
		getCategoriaId($('#categorias').val());
	});
	
   $('#advertencia .close-fancybox').on('click', function(e) {
	   $(this).parent().parent().slideUp('fast');
   });

   
});
