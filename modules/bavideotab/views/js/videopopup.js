/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

var clicks = 0;
var clicks1 = 0;
function popupvideo() {
    $(".momo").css('display', 'block');
    $(".popup").css('display', 'block');
    $("#icon-play").css("cssText", "display: block;");
    $("#icon-pause").css("cssText", "display: none;");
    var stopvideo = document.getElementById("demo");
        stopvideo.play();
        stopvideo.pause();
}
function cancelpopup(type) {
    $(".momo").css('display', 'none');
    $(".popup").css('display', 'none');
    if (type == 0) {
        var videoURL = $('.rte div iframe').prop('src');
        videoURL = videoURL.replace("&autoplay=1", "");
        $('.rte div iframe').prop('src','');
        $('.rte div iframe').prop('src',videoURL);
    } else{
        var stopvideo = document.getElementById("myVideo");
            stopvideo.pause();
            clicks = 0;
    }
}
function clicka() {
    clicks += 1; 
    return clicks;
};
function clicka1() {
    clicks1 += 1; 
    return clicks1;
};
function play(){
    var r = clicka();
    console.log(r);
    if (r%2==0) {
        var stopvideo = document.getElementById("myVideo");
        stopvideo.pause();
        $("#icon-pause").css("cssText", "display: block;");

    } else {
        var stopvideo = document.getElementById("myVideo");
        stopvideo.play();
        $("#icon-pause").css("cssText", "display: none;");
        $("#icon-play").css("cssText", "display: block;");
        setTimeout(function ()
        {
            $("#icon-play").fadeOut('slow');
        }, 100);
    }
}

function playtap(){
     var r = clicka1();
    if (r%2==0) {
        var stopvideo = document.getElementById("myVideotab");
        stopvideo.pause();
        $("#icon-pause1").css("display", "block");

    } else {
        var stopvideo = document.getElementById("myVideotab");
        stopvideo.play();
        $("#icon-pause1").css("display", "none");
        $("#icon-play1").css("display", "block");
        
    }
    setTimeout(function ()
        {
            $("#icon-play1").fadeOut('slow');
        }, 100);
}
    
