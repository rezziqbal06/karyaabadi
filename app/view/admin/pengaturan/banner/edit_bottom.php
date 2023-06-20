var media_target_div = 'dgaleri_items';
var media_single = 0;
var media_name = 'image[]';
var media_caption = 0;
var media_id = '';
var folder_id = '';
var galeri_item_count = 0;
var id_spec = 0;

function gritter(pesan,jenis="info"){
	$.bootstrapGrowl(pesan, {
		type: jenis,
		delay: 3500,
		allow_dismiss: true
	});
}

$(".select2").select2();
function convertToSlug(Text) {
  	return Text.toLowerCase()
             .replace(/ /g, '-')
             .replace(/[^\w-]+/g, '');
}

initEditor('#iedeskripsi')

//fill data
setTimeout(function(){

  var data_fill = <?=json_encode($abm)?>;
  $.each(data_fill,function(k,v){
    if(k == 'gambar'){
      $('#img-iegambar').attr('src', '<?=base_url()?>'+v);
    }else if(k == "deskripsi"){
      editor["#iedeskripsi"].setData(v)
    }else{
      $("#ie"+k).val(v);
    }
  });
},500)


//submit form
$("#fedit").on("submit",function(e){
	e.preventDefault();
	NProgress.start();
	$('.btn-submit').prop('disabled',true);
	$('.icon-submit').addClass('fa-circle-o-notch fa-spin');

	var fd = new FormData($(this)[0]);
  var i = 1;
  for(i = 1;i <= 5; i++){
    var gambar = getImageData('iegambar'+i+'prev');
    if(gambar){
      fd.append('gambar'+i, gambar.blob, 'gambar.'+gambar.extension);
    }
  }
	var url = '<?=base_url("api_admin/pengaturan/banner/edit/".$abm->id)?>';

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
					window.location = '<?=base_url_admin('pengaturan/banner/')?>';
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

$(document).off('change', '[name="nama"]')
$(document).on('change', '[name="nama"]', function(e){
	e.preventDefault();
	var type = $(this).attr('id').replace('nama','');
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

$('.select2').select2();
