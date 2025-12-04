var chart = "";

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [month, day, year].join('/');
}
function getCategoriesDays(){
    var date1 =  new Date(formatDate($('#desdeFecha').val()));
    var date2   =  new Date(formatDate($('#hastaFecha').val()));
    var timeDiff = Math.abs(date2.getTime() - date1.getTime());
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
    var cont = 0;
    var ejeX = [];
    for(cont = 0; cont < diffDays+1 ; cont++){
         ejeX.push(date1.getFullYear() + "/" + (date1.getMonth()+1) + "/" + date1.getDate());
         date1.setDate(date1.getDate() + 1);
    }
    return ejeX;
}

function addData(){
    //primero limpio
    while(chart.series.length > 0)
        chart.series[0].remove(true);
    // etiqueto el eje x
    chart.xAxis[0].update({categories:getCategoriesDays()}, true);
    var factura = $("input[name=factura]:checked").attr("id");
    var id_employee = [];
    $("input[name=empleado]:checked").each(function() {
       	id_employee.push($(this).attr("id").replace("empleado", ""));
    });
    $.getJSON("../modules/tpvtienda/classes/actions/actionsEstadisticas.php",{token:token, action:'totalizacionTiendaDias',
        dia : $('#desdeFecha').val(),diaFin:$('#hastaFecha').val(), id_lang: id_lang,
    	id_shop: id_shop,id_currency: $('#id_currency').val(),id_employee: id_employee,
        ventasOnline:$('#onlineButton').is(':checked'),ventasFisica:$('#fisicaButton').is(':checked'),
    	factura:factura},function(data) {
        	$.each(data, function(index, result) {
         	    if(result.days != null){
         	        var i = 0;
                    var days = [];
         	        $.each(result.days, function(index, day) {
         	            days.push({x: i++, y: day});
                    });
         	    }
                chart.addSeries({
                    name: result.name,
                    data: days
                });
            });
            chart.redraw();
    });


}
chart = Highcharts.chart('grafica', {

    chart: {
    },
    title: {
        text: ""
    },
  //  subtitle: {
//        text: 'Source: Google Analytics'
//    },
   xAxis: {
        title: {
            text: diaTxT
        },
    },
    yAxis: {
        title: {
            text: ventasTxT
        },
        plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
        }]
    },
    legend: {
            labelFormatter: function () {
                return this.name;
            }
        },



    tooltip: {
        shared: true,
        crosshairs: true
    },

    plotOptions: {
        series: {
            cursor: 'pointer',
            point: {
                events: {
                    click: function (e) {

                    }
                }
            },
            marker: {
                lineWidth: 1
            }
        }
    },


});
