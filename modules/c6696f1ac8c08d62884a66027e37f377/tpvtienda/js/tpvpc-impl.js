var wSocketMngmtService;
var wSocketPinpad;
var urlWSPinpad = "ws://localhost:9100";
var urlWSMngmtService = "ws://localhost:10205";
var urlHttpPinpad = "http://localhost:10305";
var pinpadServiceVersion = "";
var clientPinPadId;
var eventCalls = new Map();
var responseCalls = new Map();
var isLogEnabled = "0";
var xhr = new XMLHttpRequest();

var respuestaDatafono = [];
var datafonoInicializado = 0;

class TpvpcImplantado {

    initFnDll(args, onResponse)
    {
        WebSocketMsgmtDisConnect();
        WebSocketMsgmtConnect(function () {
            RegisterResponse("fnDllIniTpvpcLatente", onResponse, function() {
                execWSPinPadFunc("fnDllIniTpvpcLatente", args);
            });
        });
    }

    execFnDll(name, args, onResponse)
    {
        RegisterResponse(name, onResponse, function() {
            execWSPinPadFunc(name, args);
        });
    }

    subscribeEvent(name, onResponse) {
        RegisterEvent(name, onResponse);
    }

    EnableLog()
    {
        isLogEnabled = "1";
    }

    DisableLog()
    {
        isLogEnabled = "0";
    }

    HttpExecFnDll(name, args, pinpadId, onResponse) {
        onResponse(execHTTPPinPadFunc(name, args, pinpadId));
    }
}

function RegisterResponse(responseName, responseCall, onSuccess) {
    if (responseName != null && responseName != '') {
        let time = Date.now();
        responseCalls.set(responseName, { responseCall, time });
        setTimeout(() => {
            let fn = responseCalls.get(responseName);
            if (fn != null) {
                responseCalls.delete(responseName);
                log("[WS] Delete responsecallback " + responseName + " (" + responseCalls.size + ")");
            }
        }, "120000")
    }
    if (onSuccess) onSuccess();
}

function RegisterEvent(eventName, eventCall) {
    if (eventName != null && eventName != '') {
        let time = Date.now();
        eventCalls.set(eventName, { eventCall, time });
    }
}

function WebSocketMsgmtDisConnect() {
    if (WebSocketDisConnect()) {
        log('[MWS] closing to management service... ');
        if (wSocketMngmtService) wSocketMngmtService.close();
    }
}

function WebSocketMsgmtConnect(onConnected) {
    log('[MWS] Connecting to management service... ' + urlWSMngmtService);
    if (wSocketMngmtService && wSocketMngmtService.readyState == 1)
        log('[MWS] Already connected...');
    else {
        wSocketMngmtService = new WebSocket(urlWSMngmtService);
        wSocketMngmtService.onopen = function (event) {
            log('[MWS] onopen - Connected!');
            clientPinPadId = Date.now();
            _WebSocketSend(wSocketMngmtService, {
                ClientId: clientPinPadId.toString(),
                Command: "Init",
                Args: [isLogEnabled]
            });
        };
        wSocketMngmtService.onmessage = function (event) {
            log('[MWS] onmessage - ' + event.data);
            handleEventMngmtMessage(JSON.parse(event.data), onConnected);
        }
        wSocketMngmtService.onerror = function(event) {
            log("[MWS] onerror - " + event.data);
        };
        wSocketMngmtService.onclose = function(event) {
            log("[MWS] onclose - " + event.code + ' ' + event.reason);
        }
    }
}

function handleEventMngmtMessage(data, onConnected) {
    if (data.Command == 'managementService_Connected') {
        urlWSPinpad = "ws://" + data.DataResponse.PinPadAddress;
        urlHttpPinpad = "http://" + data.DataResponse.PinPadAddress;
        log("[MWS] version - " + data.DataResponse.Version);
        pinpadServiceVersion = data.DataResponse.Version;
        WebSocketConnect(onConnected);
    } else if (data.Body && data.Body.Command == 'IMPL_PAYMENT') {
        RegisterResponse("fnDllOperPinPad", (response) => {
            data.Body.ResponseCode = response.Response;
            data.Body.Response = response.Result;
            log("ENVIAR " + response);
            _WebSocketSend(wSocketMngmtService, data);
        }, () => {
            execWSPinPadFunc("fnDllOperPinPad", [data.Body.Amount, data.Body.Invoice, data.Body.Type]);
        });

    }

}

function WebSocketDisConnect() {
    log('[WS] Closing pinpad connection... ' + wSocketPinpad);
    if (wSocketPinpad) wSocketPinpad.close();
    return true;
}

function WebSocketConnect(onConnected) {
    log('[WS] Connecting to pinpad... ' + urlWSPinpad);
    if (wSocketPinpad && wSocketPinpad.readyState == 1)
        log('[WS] Pinpad already connected...');
    else
        wSocketPinpad = new WebSocket(urlWSPinpad);
    wSocketPinpad.onopen = function (event) {
        log('[WS] onopen - Pinpad connected!');
        if (onConnected) onConnected();
    };
    wSocketPinpad.onmessage = function (event) {
        log('[WS] onmessage - ' + event.data);
        handleMessage(event.data);
    }
    wSocketPinpad.onerror = function(event) {
        log("[WS] onerror - " + event.data);
    };
    wSocketPinpad.onclose = function(event) {
        log("[WS] onclose - " + event.code + ' ' + event.reason);
    }
}

function WebSocketClose() {
    log("[WS] close");
    wSocketPinpad.close();
}
function _WebSocketSend(wsocket, data) {
    var dataJson = JSON.stringify(data);
    log("[WS] send - " + dataJson);
    if (wsocket)
        wsocket.send(dataJson);
    else
        log("[WS] socket null");

}

function WebSocketPinPadSend(data) {
    _WebSocketSend(wSocketPinpad, data);
}

function WebHttpSend(data) {
    log("[HTTP] sending to " + urlHttpPinpad);
    xhr.open("POST", urlHttpPinpad, false);
    xhr.setRequestHeader("Content-Type", "application/json");
    var stringData = JSON.stringify(data);
    log("[HTTP] send " + stringData);
    xhr.send(stringData);
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            log("[HTTP] receive - " + data.Type + data.Command + " " + xhr.responseText);
            var json = JSON.parse(xhr.responseText);
            return json;
        } else {
            log("[HTTP] error - " + "state " + xhr.readyState + " status " + xhr.status);
            var json = JSON.parse(xhr.responseText);
        }
    }
}

function WebHttpSendAsync(data, onSuccess) {
    xhr.open("POST", urlHttpPinpad, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    var stringData = JSON.stringify(data);
    log("[HTTP] sendAsync " + stringData);
    xhr.onload = function (e) {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                log("[HTTP] receive - " + data.Type + data.Command + " " + xhr.responseText);
                var json = JSON.parse(xhr.responseText);
                if (onSuccess) onSuccess(json.Response);
            } else {
                log("[HTTP] error - " + "state " + xhr.readyState + " status " + xhr.status);
            }
        }
    };
    xhr.onerror = function (e) {
        log("[HTTP] error - " + "state " + xhr.readyState + " status " + xhr.status);
    };
    xhr.ontimeout = function (e) {
        log("[HTTP] timeout - " + xhr.timeout + " " + data.Type + data.Command);
    };
    xhr.send(stringData);
}

function handleMessage(data) {

    let json = JSON.parse(data);
    if (json.Type == "event") {
        handleEventMessage(json);
    } else if (json.Type == "response") {
        handleResponseMessage(json);
    } else {
        log('[WS] Message not handled - ' + data);
    }
}


function handleResponseMessage(data) {
    let event = responseCalls.get(data.Command);
    if (event != null) {
        event.responseCall({
            "Response": data.Response,
            "Result": data.Result
        });
    } else {
        log('[WS] ResponseCallback not registered - ' + data);
    }
    log('Tam before ' + responseCalls.size);
    responseCalls.delete(data.Command);
    log('Tam ' + responseCalls.size);
}

function handleEventMessage(data) {
    let event = eventCalls.get(data.Command);
    if (event != null) {
        event.eventCall({
            "Response": data.Response,
            "Result": data.Result
        });
    } else {
        log('[WS] Event not registered - ' + data);
    }
}

function log(str) {
    if (isLogEnabled == "1")
        console.log(str);
}

function execWSPinPadFunc(name, values) {
    WebSocketPinPadSend({
        Type: "func",
        Command: name,
        Args: values
    });
}

function execHTTPPinPadFunc(name, values, pinpadId) {
    return WebHttpSend({
        PinpadId: pinpadId,
        Type: "func",
        Command: name,
        Args: values
    });
}

var maxLifespan = 2 * 60 * 1000 + 30 * 1000
// check once per second
// Acts like a garbage collector
setInterval(function checkItems() {
    for (let [key, value] of responseCalls) {
        if (Date.now() - maxLifespan > value.time) {
            log("Deleting response made at: " + value.time);
            responseCalls.delete(key);
        }
    }
}, 3 * 60 * 1000)

function removeHtmlTags(text) {
    return text.replace(/<[^>]*>/g, '');
}
let tpvpcImpl = new TpvpcImplantado();
// window.tpvpcImpl = tpvpcImpl;
tpvpcImpl.EnableLog();
//tpvpcImpl.initFnDll(["0341209096","1","5bbbf67600e6ddf4f56c","COM9:,19200,N,8,1","8.1"], function(ret){
datafono_datos = JSON.parse(datafono_datos);

function inicializarDatafono(){
    if(datafono_datos && datafono_datos['datafono_activo'] == 1 && datafono_datos['datafono_codigo'] != "" && datafono_datos['datafono_clave'] != ""){
        tpvpcImpl.initFnDll([datafono_datos['datafono_codigo'],datafono_datos['datafono_terminal'],datafono_datos['datafono_clave'],
                         "COM"+datafono_datos['datafono_puerto']+":,19200,N,"+datafono_datos['datafono_bit']+",1",datafono_datos['datafono_version']], function(ret){
        if(ret.Response == "-11") console.log("No se especificaron valores del datafono.");
        if(ret.Response == "-12") console.log("Error interno del sistema.");
        if(ret.Response == "-13") console.log("Error al realizar el descubrimiento del PinPad. Se superó el TimeOut máximo de espera.");
        if(ret.Response == "-14") console.log("No se pudo iniciar la interfaz gráfica del TPVPC Latente.");
        if(ret.Response == "-16") console.log("No se pudo conectar con el servididor de Redsys.");
        if(ret.Response == "-18") console.log("Datos de conexión no válidos pero hubo conexión con el pinpad")
        if(ret.Response == "-19") console.log("No se pudo conectar el pinpad no esta configurado correctamente.");
        if(ret.Response == "-20") console.log("No se pudo conectar el puerto indicado no es correcto.");
        if(ret.Response == "-21") console.log("No se pudo conectar la versión indicada no es correcto.");
        log("Init [" + ret.Response + "] = " + ret.Result);
        if(ret.Response == 0)
            datafonoInicializado = 1;
            tpvpcImpl.subscribeEvent('pinpadImplantadoEvent_4', function (ret) {
                console.log("Lectura de tarjeta correcta");
                $("#popupPagoTarjeta h4").html("Lectura de tarjeta correcta");
            });
        });
    }
}
function devolucionPago(importe,respuestaDatafono){
    var cXMLResp = "";//rellenar con formato XML correcto
    $("#popupPagoTarjeta h4").removeClass("alert-success");
    $("#popupPagoTarjeta h4").removeClass("alert-danger");
    $("#popupPagoTarjeta p").hide();
   // devolucionPago("10.00",JSON.parse('{"nombre":"POS TPV Prestashop","codigo":"341209096","terminal":"1","literales":"","tarjeta":"************7779","identificadorRTS":"075002250421201649513082","tipo":"Venta","numeroAut":"943631","pedido":"1253","fecha":"2025-04-21 20:16:49","importe":"10.00 €","ReciboSoloCliente":"TRUE"}'))
    tpvpcImpl.execFnDll('fnDllOperComContable', [respuestaDatafono['pedido'],respuestaDatafono['identificadorRTS'],importe,"","DEVOLUCION"],
        function(ret){
            console.log("fnDllOperComContable [" + ret.Response + "] = " +ret.Result);
            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(ret.Result, "text/xml");
            if(typeof xmlDoc.getElementsByTagName("estado")[0] != "undefined")
                var estadoDatafono = removeHtmlTags(xmlDoc.getElementsByTagName("estado")[0].textContent);
            if(typeof xmlDoc.getElementsByTagName("resultado")[0] != "undefined")
                var resultadoDatafono = removeHtmlTags(xmlDoc.getElementsByTagName("resultado")[0].textContent);
            if(estadoDatafono == "F" && resultadoDatafono == "Autorizada"){
                $("#popupPagoTarjeta h4").addClass("alert-success");
                $("#popupPagoTarjeta h4").html("DEVOLUCIÓN ACEPTADA");
            }else{
                $("#popupPagoTarjeta h4").addClass("alert-danger");
                $("#popupPagoTarjeta h4").html("operación con errores");
            }
                $("#popupPagoTarjeta").popup("open");
            setTimeout(function() {$("#popupPagoTarjeta").popup("close");$("#popupPagoTarjeta p").show();}, 3000);
        }
    );
}
function envioPago(importe){
    respuestaDatafono = "";
    tpvpcImpl.execFnDll('fnDllOperPinPad', [importe,"","PAGO"],
        function(ret){
           //  console.log("fnDllOperPinPad [" + ret.Response + "] = " +ret.Result);

            if(ret.Response == 0){ // ha respondido
                $("#popupPagoTarjeta h4").removeClass("alert-success");
                $("#popupPagoTarjeta h4").removeClass("alert-danger");
                const parser = new DOMParser();
                const xmlDoc = parser.parseFromString(ret.Result, "text/xml");
                if(typeof xmlDoc.getElementsByTagName("estado")[0] != "undefined"){
                    var estadoDatafono = removeHtmlTags(xmlDoc.getElementsByTagName("estado")[0].textContent);
                }
                if(typeof xmlDoc.getElementsByTagName("resultado")[0] != "undefined"){
                    var resultadoDatafono = removeHtmlTags(xmlDoc.getElementsByTagName("resultado")[0].textContent);
                }
                if(typeof xmlDoc.getElementsByTagName("codigoRespuesta")[0] != "undefined"){
                    var codigoRespuesta = removeHtmlTags(xmlDoc.getElementsByTagName("codigoRespuesta")[0].textContent);
                }else if(typeof xmlDoc.getElementsByTagName("codigo")[0] != "undefined"){
                    var codigoRespuesta = removeHtmlTags(xmlDoc.getElementsByTagName("codigo")[0].textContent);
                }
                if(codigoRespuesta == "TPV-PC_EMV0002" || codigoRespuesta == "TPV-PC_EMV0005"){
                    $("#popupPagoTarjeta h4").addClass("alert-danger");
                    $("#popupPagoTarjeta h4").html("PAGO Cancelado");
                    $("#popupPagoTarjeta h4").show();
                    setTimeout(function() {$("#popupPagoTarjeta").popup("close")}, 3000);
                }else if(codigoRespuesta == "TPV-PC0084"){
                    $("#popupPagoTarjeta h4").addClass("alert-danger");
                    $("#popupPagoTarjeta h4").html("Error de lectura de la banda");
                    $("#popupPagoTarjeta h4").show();
                    setTimeout(function() {$("#popupPagoTarjeta").popup("close")}, 3000);
                }else if(codigoRespuesta == "TPV-PC_EMV0001" || codigoRespuesta == "TPV-PC0118"){
                    $("#popupPagoTarjeta h4").addClass("alert-danger");
                    $("#popupPagoTarjeta h4").html(removeHtmlTags(xmlDoc.getElementsByTagName("mensaje")[0].textContent));
                    $("#popupPagoTarjeta h4").show();
                    setTimeout(function() {$("#popupPagoTarjeta").popup("close")}, 3000);
                }else if(codigoRespuesta == "106" || codigoRespuesta == "117"){
                    $("#popupPagoTarjeta h4").addClass("alert-danger");
                    $("#popupPagoTarjeta h4").html("Operación denegada.117 Pin incorrecto");
                    $("#popupPagoTarjeta h4").show();
                    setTimeout(function() {$("#popupPagoTarjeta").popup("close")}, 3000);
                }else if(codigoRespuesta == "101"){
                    $("#popupPagoTarjeta h4").addClass("alert-danger");
                    $("#popupPagoTarjeta h4").html("Operación denegada.101 Tarjeta caducada");
                    $("#popupPagoTarjeta h4").show();
                    setTimeout(function() {$("#popupPagoTarjeta").popup("close")}, 3000);
                }else if(estadoDatafono == "F" && resultadoDatafono == "Autorizada"){
                    $("#popupPagoTarjeta h4").addClass("alert-success");
                    $("#popupPagoTarjeta h4").html("PAGO ACEPTADO, procesando pedido....");
                    $("#popupPagoTarjeta h4").show();
                    respuestaDatafono = [];
                    var literalesDatafotono = xmlDoc.getElementsByTagName("Literales");
                    if(typeof literalesDatafotono[0] != "undefined")
                        literalesDatafotono = literalesDatafotono[0].textContent;
                    else
                        literalesDatafotono = "";
                    var ReciboSoloCliente = xmlDoc.getElementsByTagName("ReciboSoloCliente");
                    if(typeof ReciboSoloCliente[0] != "undefined")
                        ReciboSoloCliente = ReciboSoloCliente[0].textContent;
                    else
                        ReciboSoloCliente = "";
                    var codigoDatafotono = removeHtmlTags(xmlDoc.getElementsByTagName("comercio")[0].textContent);
                    var terminalDatafono = removeHtmlTags(xmlDoc.getElementsByTagName("terminal")[0].textContent);
                    var tarjetaClienteRecibo = removeHtmlTags(xmlDoc.getElementsByTagName("tarjetaClienteRecibo")[0].textContent);
                    var identificadorRTS = removeHtmlTags(xmlDoc.getElementsByTagName("identificadorRTS")[0].textContent);
                    var pedidoDatafono = removeHtmlTags(xmlDoc.getElementsByTagName("pedido")[0].textContent);
                    var fechaDatafono = removeHtmlTags(xmlDoc.getElementsByTagName("fechaOperacion")[0].textContent);
                    var importeDatafono = removeHtmlTags(xmlDoc.getElementsByTagName("importe")[0].textContent);
                    if(removeHtmlTags(xmlDoc.getElementsByTagName("moneda")[0].textContent) == 978)
                        importeDatafono+= " €";
                    var elementos = xmlDoc.getElementsByTagName("autenticadoPorPin");
                    if(typeof elementos[0] != "undefined"){
                        var autenticadoPorPinDatafono = removeHtmlTags(elementos[0].textContent);
                        if (autenticadoPorPinDatafono.includes('CONTACTLESS')) {
                            respuestaDatafono["CL"] = "true";
                        }
                    }
                    var operContactLess = xmlDoc.getElementsByTagName("operContactLess");
                    if(typeof operContactLess[0] != "undefined"){
                        operContactLess = operContactLess[0].textContent;
                        if (operContactLess == "TRUE") {
                            respuestaDatafono["CL"] = "true";
                        }
                    }
                    respuestaDatafono["nombre"] = nombre_comercio;
                    respuestaDatafono["codigo"] = codigoDatafotono;
                    respuestaDatafono["terminal"] = terminalDatafono;
                    respuestaDatafono["literales"] = literalesDatafotono;
                    respuestaDatafono["tarjeta"] = tarjetaClienteRecibo;
                    respuestaDatafono["identificadorRTS"] = identificadorRTS;
                    respuestaDatafono["tipo"] = 'Venta';
                    respuestaDatafono["numeroAut"] = codigoRespuesta;
                    respuestaDatafono["pedido"] = pedidoDatafono;
                    respuestaDatafono["fecha"] = fechaDatafono.replace(".0", "");
                    respuestaDatafono["importe"] = importeDatafono;
                    respuestaDatafono["ReciboSoloCliente"] = ReciboSoloCliente;

                    if(typeof xmlDoc.getElementsByTagName("etiquetaApp")[0] != "undefined")
                        respuestaDatafono["etiquetaApp"] = removeHtmlTags(xmlDoc.getElementsByTagName("etiquetaApp")[0].textContent);
                    if(typeof xmlDoc.getElementsByTagName("idapp")[0] != "undefined")
                        respuestaDatafono["idapp"] = removeHtmlTags(xmlDoc.getElementsByTagName("idapp")[0].textContent);
                    if(typeof xmlDoc.getElementsByTagName("conttrans")[0] != "undefined")
                        respuestaDatafono["conttrans"] = removeHtmlTags(xmlDoc.getElementsByTagName("conttrans")[0].textContent);
                    if(typeof xmlDoc.getElementsByTagName("codrespauto")[0] != "undefined")
                        respuestaDatafono["codrespauto"] = removeHtmlTags(xmlDoc.getElementsByTagName("codrespauto")[0].textContent);
                    if(typeof xmlDoc.getElementsByTagName("resverificacion")[0] != "undefined")
                        respuestaDatafono["resverificacion"] = removeHtmlTags(xmlDoc.getElementsByTagName("resverificacion")[0].textContent);
                    if(typeof autenticadoPorPinDatafono != "undefined" && autenticadoPorPinDatafono != "")
                        respuestaDatafono["autenticadoPorPin"] = autenticadoPorPinDatafono;
                    pago();

                }else{
                    $("#popupPagoTarjeta h4").addClass("alert-danger");
                    $("#popupPagoTarjeta h4").html("Operación denegada. Estado: "+estadoDatafono);
                    $("#popupPagoTarjeta h4").show();
                }
            }else{
                 console.log("NO HAY COMUNICACIÓN");
            }
        }
    );
}
 inicializarDatafono();
// export {TpvpcImplantado};
