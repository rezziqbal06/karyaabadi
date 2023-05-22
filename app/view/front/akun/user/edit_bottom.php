var media_target_div = 'dgaleri_items';
var media_single = 0;
var media_name = 'image[]';
var media_caption = 0;
var media_id = '';
var folder_id = '';
var galeri_item_count = 0;

function gritter(pesan,jenis="info"){
	$.bootstrapGrowl(pesan, {
		type: jenis,
		delay: 3500,
		allow_dismiss: true
	});
}

$(".select2").select2();

//fill data
var data_fill = <?=json_encode($bum)?>;
$.each(data_fill,function(k,v){
	$("#ie"+k).val(v);
});

//submit form
$("#fedit").on("submit",function(e){
	e.preventDefault();
	NProgress.start();
	$('.btn-submit').prop('disabled',true);
	$('.icon-submit').addClass('fa-circle-o-notch fa-spin');

	var fd = new FormData($(this)[0]);
	var url = '<?=base_url("api_front/akun/user/edit/".$bum->id)?>';

	$.ajax({
		type: $(this).attr('method'),
		url: url,
		data: fd,
		processData: false,
		contentType: false,
		success: function(respon){
			if(respon.status==200){
				gritter('<h4>Sukses</h4><p>Data berhasil diubah</p>','success');
				setTimeout(function(){
					window.location = '<?=base_url_front('akun/user/')?>';
				},500);
			}else{
				gritter('<h4>Gagal</h4><p>'+respon.message+'</p>','danger');

				$('.icon-submit').removeClass('fa-circle-o-notch fa-spin');
				$('.btn-submit').prop('disabled',false);
				NProgress.done();
			}
		},
		error:function(){
			setTimeout(function(){
				gritter('<h4>Error</h4><p>Tidak dapat mengubah data sekarang, silahkan coba lagi nanti</p>','warning');
			}, 666);

			$('.icon-submit').removeClass('fa-circle-o-notch fa-spin');
			$('.btn-submit').prop('disabled',false);
			NProgress.done();
			return false;
		}
	});

});

$("#ienegara").on("change",function(e){
	e.preventDefault();
	$("#ieprovinsi").trigger("change");
});

$("#ieprovinsi").select2({
	ajax: {
		method: 'post',
		url: '<?=base_url("api_front/alamat/provinsi/get/")?>',
		dataType: 'json',
    delay: 250,
		data: function (params) {
      var query = {
        keyword: params.term,
        negara: $("#ienegara").val()
      }
      return query;
    },
    processResults: function (dt) {
      return {
        results:  $.map(dt, function (itm) {
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

$("#iekabkota").select2({
	ajax: {
		method: 'post',
		url: '<?=base_url("api_front/alamat/kabkota/get/")?>',
		dataType: 'json',
    delay: 250,
		data: function (params) {
      var query = {
        keyword: params.term,
        provinsi: $("#ieprovinsi").val()
      }
      return query;
    },
    processResults: function (dt) {
      return {
        results:  $.map(dt, function (itm) {
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

$("#iekecamatan").select2({
	ajax: {
		method: 'post',
		url: '<?=base_url("api_front/alamat/kecamatan/get/")?>',
		dataType: 'json',
    delay: 250,
		data: function (params) {
      var query = {
        keyword: params.term,
        kabkota: $("#iekabkota").val()
      }
      return query;
    },
    processResults: function (dt) {
      return {
        results:  $.map(dt, function (itm) {
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


$("#iekelurahan").select2({
	ajax: {
		method: 'post',
		url: '<?=base_url("api_front/alamat/kelurahan/get/")?>',
		dataType: 'json',
    delay: 250,
		data: function (params) {
      var query = {
        keyword: params.term,
        kecamatan: $("#iekecamatan").val()
      }
      return query;
    },
    processResults: function (dt) {
      return {
        results:  $.map(dt, function (itm) {
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

$("#ieutype").on("change",function(e){
	e.preventDefault();
	$("#iea_company_id").val("NULL").trigger('change');
})
$("#iea_company_id").select2({
	ajax: {
		method: 'post',
		url: '<?=base_url("api_front/akun/user/get/")?>',
		dataType: 'json',
    delay: 250,
		data: function (params) {
      var query = {
        keyword: params.term,
      }
      return query;
    },
    processResults: function (dt) {
      return {
        results:  $.map(dt, function (itm) {
          return {
            text: itm.text,
            id: itm.id
          }
        })
      };
    },
    cache: true
	}
});


$("#ialamat_select").select2({
	ajax: {
		method: 'post',
		url: '<?=base_url("api_front/pengaturan/destination/cari")?>',
		dataType: 'json',
	delay: 250,
		data: function (params) {
	var query = {
		keyword: params.term,
	}
	return query;
	},
	processResults: function (dt) {
	return {
		results:  $.map(dt, function (itm) {
		return {
			text: itm.text,
			id: itm.id
		}
		})
	};
	},
	cache: true
	}
});


$("#ialamat_select").on('change', function(e){
	var value = $(this).find('option:selected').val();
	var text = $(this).find('option:selected').text();
	var alamat = text.split(' - ');
	$("[name='kode_destination']").val(value);
	$("[name='provinsi']").val(alamat[0]);
	$("[name='kabkota']").val(alamat[1]);
	$("[name='kecamatan']").val(alamat[2]);
	$("[name='kelurahan']").val(alamat[3]);
	$("[name='kodepos']").val(alamat[4]);
  var kabkota = alamat[1];
  $.get('<?=base_url("api_front/pengaturan/origin/get_by_kota/")?>'+kabkota).done(function(dt){
    if(dt.status == 200){
      if(dt.data){
        $("[name='kode_origin']").val(dt.data.code);
      }
    }
  })
})


<?php if(isset($bum->id)){
  foreach($bum as $k => $v){ ?>
    <?php if(isset($v) && strlen($v)){?>
    $("[name='<?=$k?>']").val('<?=$v?>');
    <?php } ?>
  <?php }
} ?>

<?php if(isset($buam->id)){
  foreach($buam as $k => $v){ ?>
    <?php if(isset($v) && strlen($v) && $k != 'nama'){?>
     $("[name='<?=$k?>']").val('<?=$v?>');
    <?php } ?>
  <?php }
} ?>

var s = '<option value="<?=$bum->id?>"><?=$bum->fnama." - ".$bum->email?></option>';

if(s) $("#ib_user_id_owner").html(s);