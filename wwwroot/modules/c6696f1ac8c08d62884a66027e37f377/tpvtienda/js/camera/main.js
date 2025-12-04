
/*
*  Copyright (c) 2015 The WebRTC project authors. All Rights Reserved.
*
*  Use of this source code is governed by a BSD-style license
*  that can be found in the LICENSE file in the root of the source
*  tree.
*/

'use strict';
 var videoSelect = "";
  var selectors = "";
var videoElement = "";
  var canvas = "";
function gotDevices(deviceInfos) {
  // Handles being called several times to update labels. Preserve values.
  var values = selectors.map(function(select) {
    return select.value;
  });
  selectors.forEach(function(select) {
    while (select.firstChild) {
      select.removeChild(select.firstChild);
    }
  });
  for (var i = 0; i !== deviceInfos.length; ++i) {
    var deviceInfo = deviceInfos[i];
    var option = document.createElement('option');
    option.value = deviceInfo.deviceId;
    if (deviceInfo.kind === 'videoinput') {
      option.text = deviceInfo.label || 'camera ' + ($('#'+$.mobile.activePage.attr('id')+ ' select.videoSource').length + 1);
      $('#'+$.mobile.activePage.attr('id')+ ' select.videoSource').append(option);
    }
  }
  $('#'+$.mobile.activePage.attr('id')+ ' select.videoSource').prop('selectedIndex',0).selectmenu('refresh');
  selectors.forEach(function(select, selectorIndex) {
    if (Array.prototype.slice.call(select.childNodes).some(function(n) {
      return n.value === values[selectorIndex];
    })) {
      select.value = values[selectorIndex];
    }
  });
}


// Attach audio output device to video element using device/sink ID.
function attachSinkId(element, sinkId) {
  if (typeof element.sinkId !== 'undefined') {
    element.setSinkId(sinkId)
    .then(function() {
      console.log('Success, audio output device attached: ' + sinkId);
    })
    .catch(function(error) {
      var errorMessage = error;
      if (error.name === 'SecurityError') {
        errorMessage = 'You need to use HTTPS for selecting audio output ' +
            'device: ' + error;
      }
      console.error(errorMessage);
      // Jump back to first output device in the list as it's the default.
    });
  } else {
    console.warn('Browser does not support output device selection.');
  }
}


function gotStream(stream) {
  window.stream = stream; // make stream available to console
  videoElement.srcObject = stream;
  // Refresh button list in case labels have become available
  return navigator.mediaDevices.enumerateDevices();
}

function start() {
  if (window.stream) {
    window.stream.getTracks().forEach(function(track) {
      track.stop();
    });
  }
//  var audioSource = audioInputSelect.value;
  var videoSource = videoSelect.value;
  var constraints = {
//	    audio: {deviceId: audioSource ? {exact: audioSource} : undefined},
	audio: false,
    video: {deviceId: videoSource ? {exact: videoSource} : undefined}
  };
  navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
}


function handleError(error) {
  console.log('navigator.getUserMedia error: ', error);
}

function initCamera(){
    videoSelect = document.querySelector('#'+$.mobile.activePage.attr('id')+ ' select.videoSource');
    selectors = [videoSelect];
    if (!navigator.mediaDevices || !navigator.mediaDevices.enumerateDevices) {
      console.log("enumerateDevices() not supported.");
      return;
    }
    navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);
    videoElement = document.querySelector('#'+$.mobile.activePage.attr('id')+ ' video');

    canvas = window.canvas = document.querySelector('#'+$.mobile.activePage.attr('id')+ ' canvas');
	$('#'+$.mobile.activePage.attr('id')+ ' .snapshot').live("click", function(event){
          canvas.className = "mostrarCanvas";
		  canvas.getContext('2d').drawImage(videoElement, 0, 0, canvas.width, canvas.height);
		  $('#'+$.mobile.activePage.attr('id')+ ' .footerSnapshot').show();
		  $('#'+$.mobile.activePage.attr('id')+ ' .saveImage').css({"display":'block'});
		  $('#'+$.mobile.activePage.attr('id')+ ' .snapshot').hide();
		  $('#'+$.mobile.activePage.attr('id')+ ' canvas').show();
		  $('#'+$.mobile.activePage.attr('id')+ ' canvas').css({"display":'inherit'});
		  $('#'+$.mobile.activePage.attr('id')+ ' .switchCamera').hide();
	});

	$('#'+$.mobile.activePage.attr('id')+ ' .saveImage').live("click", function(event){
		$('#'+$.mobile.activePage.attr('id')+ ' .containerCamera').hide();
		  $('#'+$.mobile.activePage.attr('id')+ ' .footerSnapshot').hide();
		  $('#'+$.mobile.activePage.attr('id')+ ' .switchCamera').hide();
		  $('#'+$.mobile.activePage.attr('id')+ ' .saveImage').hide();
		  /* ... your canvas manipulations ... */
		  if (canvas.toBlob) {
		      canvas.toBlob(
		          function (blob) {
		              // Do something with the blob object,
		              // e.g. creating a multipart form for file uploads:
//		              var formData = new FormData();
//		              formData.append('file', blob, "fotoPrueba.jpg");
		               var parts = [blob, new ArrayBuffer()];
		               var file = new File(parts, "test.jpg", {
		                   lastModified: new Date(0), // optional - default = now
		                   type: "image/jpeg"
		               });
			            Dropzone.forElement('#'+$.mobile.activePage.attr('id')+ ' .subidaImagenesProducto').addFile(file);
//		              addBlob(blob,anadirArchivoDropZone);
		              /* ... */
		          },
		          'image/jpeg'
		      );
		  }
	});
	$('#'+$.mobile.activePage.attr('id')+ ' .switchCamera').live("click", function(event){
   		var indiceCamaras = $('#'+$.mobile.activePage.attr('id')+ ' select.videoSource').prop('selectedIndex');
   		if(indiceCamaras == 0)
   			$('#'+$.mobile.activePage.attr('id')+ ' select.videoSource').prop('selectedIndex',1).selectmenu('refresh');
   		else
   			$('#'+$.mobile.activePage.attr('id')+ ' select.videoSource').prop('selectedIndex',0).selectmenu('refresh');
   		start();
   	});
   	$('#'+$.mobile.activePage.attr('id')+ ' .abrirCamara').live("click", function(event){
		$('#'+$.mobile.activePage.attr('id')+ ' .containerCamera').show();
		$('#'+$.mobile.activePage.attr('id')+ ' .footerSnapshot').show();
		if($('#'+$.mobile.activePage.attr('id')+ ' select.videoSource').find('option').length > 1)
			$('#'+$.mobile.activePage.attr('id')+ ' .switchCamera').css({"display":'inherit'});
		else
			$('#'+$.mobile.activePage.attr('id')+ ' .switchCamera').hide();
		var alturaVentana = $(window).height();
	   // 	$('#'+$.mobile.activePage.attr('id')+ ' .video').css({"height":alturaVentana+'px'});
		$('#'+$.mobile.activePage.attr('id')+ ' canvas').css({"height":alturaVentana+'px'});
		var ratio = videoElement.videoWidth / videoElement.videoHeight;
		$('#'+$.mobile.activePage.attr('id')+ ' canvas').css({"width":(alturaVentana * ratio)+'px'});
		$('#'+$.mobile.activePage.attr('id')+ ' .snapshot').show();
		$('#'+$.mobile.activePage.attr('id')+ ' canvas').hide();
	});
    start();
}