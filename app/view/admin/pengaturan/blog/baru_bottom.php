var media_target_div = 'dgaleri_items';
var media_single = 0;
var media_name = 'image[]';
var media_caption = 0;
var media_id = '';
var folder_id = '';
var galeri_item_count = 0;
var id_spec = 0;

$(".select2").select2();

function convertToSlug(Text) {
  	return Text.toLowerCase()
             .replace(/ /g, '-')
             .replace(/[^\w-]+/g, '');
}


//submit form
$("#ftambah").on("submit",function(e){
	e.preventDefault();
	NProgress.start();
	$('.btn-submit').prop('disabled',true);
	$('.icon-submit').addClass('fa-circle-o-notch fa-spin');

	var fd = new FormData($(this)[0]);
  var i = 1;
  for(i = 1;i <= 5; i++){
    var gambar = getImageData('igambar'+i+'prev');
    if(gambar){
      fd.append('gambar'+i, gambar.blob, 'gambar.'+gambar.extension);
    }
  }
	fd.append('text', editor["#itext"].getData())


	var url = '<?= base_url("api_admin/pengaturan/blog/baru/")?>';

	$.ajax({
		type: $(this).attr('method'),
		url: url,
		data: fd,
		processData: false,
		contentType: false,
		success: function(respon){
			if(respon.status==200){
				gritter('<h4>Sukses</h4><p>Data berhasil ditambahkan</p>','success');
				setTimeout(function(){
					window.location = '<?=base_url_admin('pengaturan/blog/')?>';
				},500);
			}else{
				gritter('<h4>Gagal</h4><p>'+respon.message+'</p>','warning');
				$('.icon-submit').removeClass('fa-circle-o-notch fa-spin');
				$('.btn-submit').prop('disabled',false);
				NProgress.done();
			}
		},
		error:function(){
			setTimeout(function(){
				gritter('<h4>Error</h4><p>Tidak dapat menambah data, silahkan coba beberapa saat lagi</p>','danger');
			}, 666);

			$('.icon-submit').removeClass('fa-circle-o-notch fa-spin');
			$('.btn-submit').prop('disabled',false);
			NProgress.done();
			return false;
		}
	});
});

$("#inegara").on("change",function(e){
	e.preventDefault();
	$("#iprovinsi").trigger("change");
});

$("#iprovinsi").select2({
	ajax: {
		method: 'post',
		url: '<?=$this->config->semevar->api_address."/provinsi/get/"?>',
		dataType: 'json',
    delay: 250,
		data: function (params) {
      var query = {
        keyword: params.term,
        negara: $("#inegara").val()
      }
      return query;
    },
    processResults: function (dt) {
      return {
        results:  $.map(dt.result, function (itm) {
          return {
            text: itm.text,
            id: itm.text
          }
        })
      };
    },
    cache: true
	}
});

$("#ikabkota").select2({
	ajax: {
		method: 'post',
		url: '<?=$this->config->semevar->api_address."/kabkota/get/"?>',
		dataType: 'json',
    delay: 250,
		data: function (params) {
      var query = {
        keyword: params.term,
        provinsi: $("#iprovinsi").val()
      }
      return query;
    },
    processResults: function (dt) {
      return {
        results:  $.map(dt.result, function (itm) {
          return {
            text: itm.text,
            id: itm.text
          }
        })
      };
    },
    cache: true
	}
});

$("#ikecamatan").select2({
	ajax: {
		method: 'post',
		url: '<?=$this->config->semevar->api_address."/kecamatan/get/"?>',
		dataType: 'json',
    delay: 250,
		data: function (params) {
      var query = {
        keyword: params.term,
        kabkota: $("#ikabkota").val()
      }
      return query;
    },
    processResults: function (dt) {
      return {
        results:  $.map(dt.result, function (itm) {
          return {
            text: itm.text,
            id: itm.text
          }
        })
      };
    },
    cache: true
	}
});


$("#ikelurahan").select2({
	ajax: {
		method: 'post',
		url: '<?=$this->config->semevar->api_address."/kelurahan/get/"?>',
		dataType: 'json',
    delay: 250,
		data: function (params) {
      var query = {
        keyword: params.term,
        kecamatan: $("#ikecamatan").val()
      }
      return query;
    },
    processResults: function (dt) {
      return {
        results:  $.map(dt.result, function (itm) {
          return {
            text: itm.text,
            id: itm.text
          }
        })
      };
    },
    cache: true
	}
});

$(document).off('change', '[name="judul"]')
$(document).on('change', '[name="judul"]', function(e){
	e.preventDefault();
	var type = $(this).attr('id').replace('judul','');
	var slug = convertToSlug($(this).val());
	$("#"+type+"slug").val(slug);
})

$(document).off('change', 'input[type="file"]');
$(document).on('change', 'input[type="file"]', function(e){
	e.preventDefault();
  setCompressedImage(e)
	var id = $(this).attr('id');
	readURLImage(this, 'img-'+id);
});

initEditor('#itext');