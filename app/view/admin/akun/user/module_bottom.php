var drTable = {};
var ieid = '';


//submit form
$("#ftambah").on("submit",function(e){
	e.preventDefault();
	NProgress.start();
	$('.btn-submit').prop('disabled',true);
	$('.icon-submit').addClass('fa-circle-o-notch fa-spin');

	var fd = new FormData($(this)[0]);
	var url = '<?= base_url("api_admin/pengaturan/jabatan/module_baru/")?>';
	<?php if(isset($bumm) && is_array($bumm) && count($bumm)){ ?>
		url = '<?= base_url("api_admin/pengaturan/jabatan/module_edit/")?>';
	<?php } ?>

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
					window.location = '<?=base_url_admin('akun/user/')?>';
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
				gritter('<h4>Error</h4><p>Tidak dapat menambah data, silahkan coba beberapa saat lagi</p>','warning');
			}, 666);

			$('.icon-submit').removeClass('fa-circle-o-notch fa-spin');
			$('.btn-submit').prop('disabled',false);
			NProgress.done();
			return false;
		}
	});
});
$(document).off('change', '.btn-all');
$(document).on('change', '.btn-all', function(e){
	e.preventDefault();
	var id = $(this).attr('data-id');
	if($(this).is(':checked')){
		$('.btn-module-'+id).prop('checked', true);
	}else{
		$('.btn-module-'+id).prop('checked', false);
	}
});
