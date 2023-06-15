var drTable = {};
var ieid = '';

App.datatables();

var editor = [];

function convertToSlug(Text) {
  	return Text.toLowerCase()
             .replace(/ /g, '-')
             .replace(/[^\w-]+/g, '');
}

function initEditor(selector){
	ClassicEditor
        .create( document.querySelector( selector ), {
			toolbar: {
                    items: [
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        'alignment', '|',
                        'link', 'blockQuote', 'insertTable', 'codeBlock', '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        'textPartLanguage', '|'
                    ],
                    shouldNotGroupWhenFull: true
                },
		} )
		.then( newEditor => {
			editor[selector] = newEditor;
		} )
        .catch( error => {
            console.error( error );
        } );
}


if(jQuery('#drTable').length>0){
	drTable = jQuery('#drTable')
	.on('preXhr.dt', function ( e, settings, data ){
		$().btnSubmit();
	}).DataTable({
			"order"					: [[ 0, "desc" ]],
			"responsive"	  : true,
			"bProcessing"		: true,
			"bServerSide"		: true,
			"sAjaxSource"		: "<?=base_url("api_admin/pengaturan/blog/")?>",
			"fnServerParams": function ( aoData ) {
				aoData.push(
					{ "name": "a_company_id", "value": $("#fl_a_company_id").val() },
					{ "name": "is_active", "value": $("#fl_is_active").val() }
				);
			},
			"fnServerData"	: function (sSource, aoData, fnCallback, oSettings) {
				oSettings.jqXHR = $.ajax({
					dataType 	: 'json',
					method 		: 'POST',
					url 		: sSource,
					data 		: aoData
				}).done(function (response, status, headers, config) {
					$('#drTable > tbody').off('click', 'tr');
					$('#drTable > tbody').on('click', 'tr', function (e) {
						e.preventDefault();
						var id = $(this).find("td").html();
						ieid = id;
						$.get('<?=base_url("api_admin/pengaturan/blog/detail/")?>'+ieid).done(function(dt){
							if(dt.data){
								$.each(dt.data, function(k,v){
									if(k == "gambar"){
										console.log(k);
										$("#img-iegambar").attr('src', '<?=base_url()?>'+v);
									}else if(k == "text"){
										editor["#ietext"].setData(v)
									}else{
										$("#ie"+k).val(v);
									}
								})
							}
						})
						$("#adetail").attr("href","<?=base_url_admin("pengaturan/blog/detail/")?>"+ieid);
						//$("#aedit").attr("href","<?=base_url_admin("pengaturan/blog/edit/")?>"+ieid);
						$("#amodule").attr("href","<?=base_url_admin("pengaturan/blog/module/")?>"+ieid);
						$("#areseller").attr("href","<?=base_url_admin("blog/reseller/baru/")?>"+ieid);
						$("#modal_option").modal("show");
						
					});

					$().btnSubmit('finished');

					fnCallback(response);
				}).fail(function (response, status, headers, config) {
					gritter("<?=DATATABLES_AJAX_FAILED_MSG?>", '<?=DATATABLES_AJAX_FAILED_CLASS?>');
					$().btnSubmit('finished');
				});
			},
	});
	$('.dataTables_filter input').attr('placeholder', 'Cari nama, telp');
	$("#fl_button").on("click",function(e){
		e.preventDefault();
		drTable.ajax.reload();
	});
}


//submit form
$("#ftambah").on("submit",function(e){
	e.preventDefault();
	NProgress.start();
	$('.btn-submit').prop('disabled',true);
	$('.icon-submit').addClass('fa-circle-o-notch fa-spin');

	var fd = new FormData($(this)[0]);
	var url = '<?= base_url("api_admin/pengaturan/blog/baru/")?>';
	var gambar = getImageData('igambarprev');
	if(gambar){
		fd.append('gambar', gambar.blob, 'gambar.'+gambar.extension);
	}
	fd.append('text', editor["#itext"].getData())
	$.ajax({
		type: $(this).attr('method'),
		url: url,
		data: fd,
		processData: false,
		contentType: false,
		success: function(respon){
			if(respon.status==200){
				gritter('<h4>Sukses</h4><p>Data berhasil ditambahkan</p>','success');
					$("#modal_option").modal('hide');
				$("#modal_tambah").modal('hide');
				drTable.ajax.reload()
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

// edit form 
$("#fedit").on("submit",function(e){
	e.preventDefault();
	NProgress.start();
	$('.btn-submit').prop('disabled',true);
	$('.icon-submit').addClass('fa-circle-o-notch fa-spin');

	var fd = new FormData($(this)[0]);
	var url = '<?=base_url("api_admin/pengaturan/blog/edit/")?>';
	var gambar = getImageData('iegambarprev');
	if(gambar){
		fd.append('gambar', gambar.blob, 'gambar.'+gambar.extension);
	}
	fd.append('text', editor["#ietext"].getData())

	$.ajax({
		type: $(this).attr('method'),
		url: url,
		data: fd,
		processData: false,
		contentType: false,
		success: function(respon){
			if(respon.status==200){
				gritter('<h4>Sukses</h4><p>Data berhasil diubah</p>','success');
				$("#modal_option").modal('hide');
				$("#modal_edit").modal('hide');
				drTable.ajax.reload()
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

//hapus
$("#bhapus").on("click",function(e){
	e.preventDefault();
	if(ieid){
		var c = confirm('Apakah kamu yakin?');
		if(c){
			NProgress.start();
			$('.btn-submit').prop('disabled',true);
			$('.icon-submit').addClass('fa-circle-o-notch fa-spin');
			var url = '<?=base_url('api_admin/pengaturan/blog/hapus/')?>'+ieid;
			$.get(url).done(function(response){
				NProgress.done();
				if(response.status==200){
					gritter('<h4>Sukses</h4><p>Data berhasil dihapus</p>','success');
					$('.icon-submit').removeClass('fa-circle-o-notch fa-spin');
					$('.btn-submit').prop('disabled',false);
					NProgress.done();

					drTable.ajax.reload();
					$("#modal_option").modal("hide");
					$("#modal_edit").modal("hide");
				}else{
					gritter('<h4>Gagal</h4><p>'+response.message+'</p>','danger');

					$('.icon-submit').removeClass('fa-circle-o-notch fa-spin');
					$('.btn-submit').prop('disabled',false);
					NProgress.done();
				}
			}).fail(function() {
				gritter('<h4>Error</h4><p>Tidak dapat menghapus data, Cobalah beberapa saat lagi</p>','danger');
				$('.icon-submit').removeClass('fa-circle-o-notch fa-spin');
				$('.btn-submit').prop('disabled',false);
				NProgress.done();
			});
		}
	}
});

//get induk perusahaan
$("#fl_a_company_id_parent").select2({
	ajax: {
		method: 'post',
		url: '<?=base_url("api_admin/pengaturan/blog/get_parent/")?>',
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

$("#btn_close_modal").on("click",function(e){
	e.preventDefault();
	$("#modal_option").modal("hide");
});

$("#fl_do").on("click",function(e){
		e.preventDefault();
		drTable.ajax.reload();
	});

	
$("#atambah").on("click",function(e){
		e.preventDefault();
		$("#modal_tambah").modal("show");
	});

// edit modal
$("#aedit").on("click",function(e){
	e.preventDefault();
	$("#modal_option").modal("hide");
	$("#modal_edit").modal("show");
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

initEditor('#itext')
initEditor('#ietext')