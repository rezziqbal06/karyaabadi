var ieid = '';
var growlPesan = '<h4>Error</h4><p>Tidak dapat diproses, silakan coba beberapa saat lagi!</p>';
var growlType = 'danger';
var drTable = {};

function gritter(gpesan,gtype="info"){
	$.bootstrapGrowl(gpesan, {
		type: gtype,
		delay: 2500,
		allow_dismiss: true
	});
}

initCompressingImage("iprofil_gambar");

function detail(){
	$.get('<?=base_url("api_admin/akun/pengguna/detail/").$sess->admin->id?>').done(function(dt){
    if(dt.status == 200){
      if(dt.data){
        var data = dt.data;
        $("#iprofil_nama").val(data.nama)
        $("#iprofil_username").val(data.username)
        $("#iprofil_email").val(data.email)
        $("#img-iprofil_gambar").attr('src', '<?=base_url()?>'+data.foto)
        $("#modal_profil").modal('show');

      }
    }
  })
}

$("#fprofil").on("submit",function(e){
	e.preventDefault();
	NProgress.start();
	$('.btn-submit').prop('disabled',true);
	$('.icon-submit').addClass('fa-circle-o-notch fa-spin');

	var fd = new FormData($(this)[0]);
	var url = '<?= base_url("api_admin/akun/pengguna/edit/")?>';
	var gambar = getImageData('iprofil_gambarprev');
  fd.append('id', <?=$sess->admin->id?>)
	if(gambar){
		fd.append('gambar', gambar.blob, 'gambar.'+gambar.extension);
	}
	$.ajax({
		type: $(this).attr('method'),
		url: url,
		data: fd,
		processData: false,
		contentType: false,
		success: function(respon){
			if(respon.status==200){
				gritter('<h4>Sukses</h4><p>Data berhasil diupdate</p>','success');
				window.location.href = "<?=base_url_admin()?>"
			}else{
				gritter('<h4>Gagal</h4><p>'+respon.message+'</p>','warning');
				$('.icon-submit').removeClass('fa-circle-o-notch fa-spin');
				$('.btn-submit').prop('disabled',false);
				NProgress.done();
			}
		},
		error:function(){
			setTimeout(function(){
				gritter('<h4>Error</h4><p>Tidak dapat mengupdate data, silahkan coba beberapa saat lagi</p>','danger');
			}, 666);

			$('.icon-submit').removeClass('fa-circle-o-notch fa-spin');
			$('.btn-submit').prop('disabled',false);
			NProgress.done();
			return false;
		}
	});
});

detail();

$(document).off('change', 'input[type="file"]');
$(document).on('change', 'input[type="file"]', function(e){
	e.preventDefault();
	var id = $(this).attr('id');
	readURLImage(this, 'img-'+id);
});