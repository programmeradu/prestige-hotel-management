var imprimirPrimeraVez = 0;
var signaturePad = '';
var padNoInicializado = 0;
var token = document.location.href.split("token=");
token = token[1].split("#");
token = token[0].split("&");
token = token[0];
function firmarPDF(destino,id_order,id_order_invoice,tipoDocumento){
    if(destino == 'or'){
        $(".m-signature-pad").show();
        $("#tipo_documento").val(tipoDocumento);
        $("#id_order_invoice_documento").val(id_order_invoice);
        if (padNoInicializado == 0){
            initializePad();
        }else
            $('.button.clear').trigger("click");
        anadirMascara();
        $('.m-signature-pad').show();
    }else{
        var msg = {message: {origen: 'or',id_order: id_order, id_order_invoice: id_order_invoice, tipo: tipoDocumento},type : 'firma'};
        sendMessageToPeer(destino,JSON.stringify(msg));
    }
    $( "#popupDocumento_"+id_order_invoice+"_"+tipoDocumento+"-screen").trigger("click");
}
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
        $.post(token_actionsFirma,{action:"anadirFirma", ajax:"1", id_order: $(".id_order").val(),
            img:signaturePad.toDataURL().substring(22, signaturePad.toDataURL().length),id_order_invoice:$("#id_order_invoice_documento").val(),
            tipo:$("#tipo_documento").val()},function(data) {
            if(data == 1){
                actualizarDocumentosFirmados();
            }
        });
        $(".m-signature-pad").hide();
    }
}
function borraFirma(id_signed){
    $.post(token_actionsFirma,{action:"borrarFirma", ajax:"1", id_signed: id_signed},function(data) {
        if(data == 1){
            actualizarDocumentosFirmados();
        }
    });
}
function actualizarDocumentosFirmados(){
    $(".documentSigned").remove();
    $("#documents_table thead tr").append('<th class=" documentSigned"></th>');

    $.map( $('#documents_table tbody tr'), function( elemento ) {
        if(!$(elemento).children('td').hasClass('list-empty')){
            var displayElemento = $(elemento).css('display');
            if(displayElemento != 'none'){
                var id_order_invoice = $(elemento).attr("id");
                if(id_order_invoice != undefined){
                    var tipo = id_order_invoice.split("_")[0];

                    if(tipo == 'invoice')
                        id_order_invoice = id_order_invoice.replace("invoice_", "");
                    else
                        id_order_invoice = id_order_invoice.replace("delivery_", "");
                    $(elemento).append('<td class="documentSigned"><div data-arrow="b" data-theme="a" id="popupDocumento_'+id_order_invoice+'_'+tipo+'" data-arrow="true" data-history="false">'+
                        '<a class="ui-shadow ui-btn ui-corner-all ui-mini" onclick="firmarPDF(\'or\','+id_order+','+id_order_invoice+',\''+tipo+'\')">'+ tipoFirma["textoAqui"]+'</a>'+
                        '<a class="ui-shadow ui-btn ui-corner-all ui-mini" onclick="firmarPDF(\'pa\','+id_order+','+id_order_invoice+',\''+tipo+'\')">'+ tipoFirma["textoPantalla"]+'</a>'+
                        '</div>'+'<a id="popupAbrirDocumento_'+id_order_invoice+'_'+tipo+'" class="documentosAfirmar btn btn-default">'+tipoFirma[tipo]+'</a></td>');
                    $( "#popupDocumento_"+id_order_invoice+'_'+tipo ).popup();
                }
            }
        }
    });


   $.post(token_actionsFirma,{action:"getFirmados", ajax:"1", id_order:id_order,id_shop:id_shop,
        id_employee: id_employee,id_lang:$("#id_lang").val(),id_currency: $("#id_currency").val()},function(data) {
        $.each(data, function(index, result) {
            if(result != null){
                $("#"+result.type+"_"+result.id_order_invoice+" .documentSigned").html("");

                $("#"+result.type+"_"+result.id_order_invoice+" .documentSigned").append('<a class="btn btn-default" onclick="borraFirma('+result.id_signed+
                        ')">'+borrarFirma+'</a><a href="'+baseUri+'modules/tpvtienda/documents/'+result.type+'/'+result.document_name+
                        '" data-selenium-id="view_invoice" class="btn btn-default _blank" target="_blank"><i class="icon-file"></i></a>');
            }
        });
    });
}




function chequearPDFs(){
    $.map( $("#orderProducts tbody tr.customized a[href*='pdf-']"), function( elemento ) {
        var href = $(elemento).attr('href').replace("displayImage.php?img=pdf-", baseUri+"modules/tpvtienda/displayPDF.php?adminDir="+adminDir+"&file=");
         $(elemento).attr('href',href);
    });
}


if(firma == 1){
    $(document).on("mobileinit", function() {
        $.mobile.activePageClass = "documentSigned";
        $.mobile.autoInitializePage = false;
    });
}

if(cambiarFechaPedido == 1){
    $(document).on("mobileinit", function() {
        $.mobile.activePageClass = "fechaPedido";
        $.mobile.autoInitializePage = false;
    });
}


$(document).ready(function(){
    $(".nuevaAgencia").on('change', function() {
        if(this.value != "")
            $("input[name=nuevaCantidad]").show();
        else
            $("input[name=nuevaCantidad]").hide();
    });
    if(pantalla == 1 && firma == 1){
        main();
    }
});
$(document).on("mobileinit", function() {
    if(firma == 1){
        actualizarDocumentosFirmados();
        $.mobile.document.on( "click", ".documentosAfirmar", function( evt ) {
            var id = $( this).attr("id");
            var tipo = id.split("_")[2];
            var idReplace = id.split("_")[1];
               $( "#popupDocumento_"+idReplace+"_"+tipo ).popup( "open", { x: $(this).offset().left + ($(this).outerWidth()/2),y: $("#"+id).offset().top, changeHash : false } );
            $( "#popupDocumento_"+idReplace+"_"+tipo+"-popup").addClass("popupDocumento");
            $( "#popupDocumento_"+idReplace+"_"+tipo+"-screen").addClass("popupDocumentoScreen");
            evt.preventDefault();
        });
    }
    if(cambiarFechaPedido == 1){
        $.getJSON("../modules/tpvtienda/classes/actions/actionsPedido.php",{token:token, action:'getFechaPedido',id_order:id_order,id_shop:id_shop,
            id_employee: id_employee,id_lang:$("#id_lang").val(),id_currency: $("#id_currency").val()},function(data) {
            if(data != null){
                $.each(data, function(index, result) {
                    if(result != null){
                        $('#popupCambioFechaPedido input[type=text]').val(result.date);
                    }
                });
            }
        });

    }
    chequearPDFs();
});



