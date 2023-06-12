/*
 *  Document   : gambar-alite.js
 *  Author     : drosanda - rezziqbal
 *  Description: JS Plugins for compressing image
 *
 *  Bismillah,
 *  berikut plugin JS untuk compress image
 */

var ufsmax = 10;
var frmax = 100;
var wmax = 720;
var hmax = 560;
var extension = 'jpg';
var extensionFile = "jpg";

/* Fungsi untuk compress gambar */

(function($) {
    $.fn.checkFileType = function(options) {
        var defaults = {
            allowedExtensions: [],
            success: function() {},
            error: function() {}
        };
        options = $.extend(defaults, options);

        return this.each(function() {

            $(this).on('change', function() {
                var value = $(this).val(),
                file = value.toLowerCase(),
                extension = file.substring(file.lastIndexOf('.') + 1);
                extensionFile = extension;
                if ($.inArray(extension, options.allowedExtensions) == -1) {
                    options.error();
                    $(this).focus();
                } else {
                    options.success();
                }

            });

        });
    };

})(jQuery);

//simpan gambar di <img/>
function readURLImage(input,target) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
        $('#'+target).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

// for file upload, convert base64 value of Image.src to file fake path
function DataURIToBlob(dataURI) {
    const splitDataURI = dataURI.split(',')
    const byteString = splitDataURI[0].indexOf('base64') >= 0 ? atob(splitDataURI[1]) : decodeURI(splitDataURI[1])
    const mimeString = splitDataURI[0].split(':')[1].split(';')[0]

    const ia = new Uint8Array(byteString.length)
    for (let i = 0; i < byteString.length; i++)
        ia[i] = byteString.charCodeAt(i)

    return new Blob([ia], { type: mimeString })
}

function initCompressingImage(selector, type="single"){
    if(!$("#panel_temp_image").length){
        console.log('create panel_temp_image');
        $('body').append('<div id="panel_temp_image"></div>');
    }
    var fileReader = new FileReader();
    var selector_imgprev = (type == "single") ? selector+'prev' : selector+'prev'+prev_count;
    var selector_imgprevori = (type == "single") ? selector+'prevori' : selector+'prevori'+prev_count;

    if(type == "single"){
        $("#panel_temp_image").append('<img id="'+selector_imgprev+'" src="" style="display: none;" /><img id="'+selector_imgprevori+'" src="" style="display: none;" />')
    }else{
        $("#panel_temp_image").append('<img id="'+selector_imgprev+'" src="" style="display: none;" /><img id="'+selector_imgprevori+'" src="" style="display: none;" />')
    }
    // console.log(selector_imgprev + ' ' + selector_imgprevori);
    // console.log($("#panel_temp_image"));
    // attach fileReader onload
    fileReader.onload = function (event) {
    var image = new Image();
    // console.log('image.src',image.src);
    image.onload=function(){
        document.getElementById(selector_imgprevori).src=image.src;
        var canvas=document.createElement("canvas");
        var context=canvas.getContext("2d");
            // console.log('image.width: '+image.width);
            // console.log('image.height: '+image.height);
            // var sx = 1;
            // if(image.width >= wmax && image.height >= hmax){
            //     if(image.width >= image.height){
            //         sx = wmax / image.width;
            //         sx = Math.round((sx + Number.EPSILON) * 100) / 100;
            //     }else{
            //         sx = hmax / image.height;
            //         sx = Math.round((sx + Number.EPSILON) * 100) / 100;
            //     }
            // }else if(image.width >= wmax && image.height < hmax){
            //     sx = wmax / image.width;
            //     sx = Math.round((sx + Number.EPSILON) * 100) / 100;
            // }else if(image.width < wmax && image.height >= hmax){
            //     sx = hmax / image.height;
            //     sx = Math.round((sx + Number.EPSILON) * 100) / 100;
            // }
            // canvas.width = image.width*sx;
            // canvas.height = image.height*sx;
            canvas.width = image.width;
            canvas.height = image.height;
            

            // console.log('canvas.width: '+canvas.width);
            // console.log('canvas.height: '+canvas.height);
        // context.drawImage(image, 0, 0, image.width, image.height, 0, 0, canvas.width, canvas.height);
        context.drawImage(image, 0, 0, image.width, image.height);
        // document.getElementById(selector_imgprev).src = canvas.toDataURL();
        var compressionQuality = 0.5;
        document.getElementById(selector_imgprev).src = canvas.toDataURL('image/jpeg', compressionQuality);
    }
    image.src=event.target.result;
        // console.log('final image.width: '+image.width);
        // console.log('final image.height: '+image.height);
    };


    // attach ifile listener
    $(function() {
        $('#'+selector).checkFileType({
            allowedExtensions: ['jpg', 'jpeg', 'ico', 'png', 'bmp'],
            success: function() {
                // alert('Allowed extension icon!');
                // console.log('Max file size: '+ufsmax+'MB');
                var flsz = $('#'+selector)[0].files[0].size;
                console.log("original size: "+flsz)
                if(flsz > 100000) flsz = flsz/1920/1080;
                flsz = flsz.toFixed(2);
                console.log("compressed size: "+flsz)
                if(flsz > ufsmax){
                    // console.log('File too big, maximum is '+ufsmax+'MB');
                    $('#'+selector).val('');
                    alert('File too big, maximum is '+ufsmax+'MB')
                    return false;
                }else if (flsz <= 0){
                    // console.log('unselected file');
                    alert('Pilih file terlebih dahulu')
                    $('#'+selector).val('');
                    return false;
                }else{
                    fileReader.readAsDataURL($('#'+selector)[0].files[0]);
                }
            },
            error: function() {
                // console.log('Invalid file icon, please change your icon!');
                alert('Invalid file, please change your file')
            }
        });
    });

}


function getImageData(selector_prev){
    var imgprev = $("#"+selector_prev).attr("src");
    
    if(imgprev){
        var blob =  DataURIToBlob($("#"+selector_prev).attr("src"))
        var extension = blob.type.split('/').pop();
        return {'blob':blob, 'extension':extension};
    }
    return 0;
}
