var login_try = 0;
$(function(){ Login.init(); });

function gritter(pesan,judul="info"){
	$.bootstrapGrowl(pesan, {
		type: judul,
		delay: 2500,
		allow_dismiss: true
	});
}

$("#form-register").on("submit",function(evt){
	evt.preventDefault();
	var url = '<?=base_url('register/api/'); ?>';
	if($('#register-terms').prop("checked") == false){
		$("#register-terms").focus();
		gritter("<h4>Info</h4><p>Anda belum menyetujui syarat dan ketentuan kami</p>", 'info');
		return false;
	}
	if($("#register-password").val().length < 6){
		$("#register-password").focus();
		gritter("<h4>Info</h4><p>Password minimal 6 digit</p>",'info');
		return false;
	}
	var fd = new FormData($(this)[0]);

	$().btnSubmit();
	$.ajax({
		type: $(this).attr('method'),
		url: url,
		data: fd,
		processData: false,
		contentType: false,
		success: function(dt){
			if(dt.status == 200){
				gritter("<h4>Pendaftaran Berhasil</h4><p>Silakan tunggu sedang membuka dashboard...</p>",'success');
        setTimeout(function(){
          window.location = '<?=$this->current_base_url('login')?>';
        }, 3456);
			}else{
        gritter("<h4>Gagal</h4><p>"+dt.message+"</p>", 'danger');
				$().btnSubmit('finished');
			}
		},
		error:function(){
			$("#iusername").prop("disabled", false);
			$("#ipassword").prop("disabled", false);
			$().btnSubmit('finished');
      gritter("<h4>Error</h4><p>Tidak dapat melakukan pendaftaran saat ini. Coba lagi nanti.</p>", 'danger');
			return false;
		}
	});

});

$("#ialamat_select").select2({
  placeholder: "Pilih / Cari, cth: Bandung",
	ajax: {
		method: 'post',
		url: '<?=base_url("api_admin/pengaturan/destination/cari")?>',
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
