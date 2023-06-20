var drTable = {};
var ieid = '';

App.datatables();


function convertToSlug(Text) {
  	return Text.toLowerCase()
             .replace(/ /g, '-')
             .replace(/[^\w-]+/g, '');
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
					
						$("#adetail").attr("href","<?=base_url_admin("pengaturan/blog/detail/")?>"+ieid);
						$("#aedit").attr("href","<?=base_url_admin("pengaturan/blog/edit/")?>"+ieid);
						
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
		window.location.href = '<?=base_url_admin("pengaturan/blog/baru")?>'
	});

// edit modal

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
