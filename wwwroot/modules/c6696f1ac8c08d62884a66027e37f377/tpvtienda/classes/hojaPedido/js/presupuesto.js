$(document).ready(function() {
	$("#crearPedidoPresupuesto").click(function(){
		pago(1);
	});
	$('#mostrarPresupuesto').click(function(){
        if($("#currencyPOS").val() != undefined)
            var currPOS = $("#currencyPOS").val();
        else
            var currPOS = id_currency;
		var nameTransporte = $("#carriersButton .nameCarrier").html();
		var precioTransporte = $("#precioTransporte").val();
		var impuestosTransporte = $("#impuestosTransporte").val();
		var note = $('.messageOrder').val();
		window.location = "../modules/tpvtienda/classes/presupuesto/presupuesto.php?id_cart="+id_cart+"&id_employee="+id_employee+"&id_lang="+id_lang+
		"&id_shop="+id_shop+"&id_currency="+currPOS+"&note="+note+"&id_carrier="+id_carrier+"&nameTransporte="+nameTransporte+"&precioTransporte="+
		precioTransporte+"&impuestosTransporte="+impuestosTransporte;
	});
});