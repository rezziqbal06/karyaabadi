var drTable = {};
var ieid = '';
var nIndikator;

function addIndikator(type='tambah'){
	nIndikator = $("#panel_indikator_"+type).children().length;
	var row = $("#row_indikator_"+type+"_0").get(0).outerHTML;
	row = row.replaceAll('_0', `_${nIndikator}`);
	row = row.replaceAll('none', '');
	$("#panel_indikator_"+type).append(row);
}

function convertToSlug(Text) {
  	return Text.toLowerCase()
             .replace(/ /g, '-')
             .replace(/[^\w-]+/g, '');
}

initCompressingImage('igambar');
initCompressingImage('iegambar');


App.datatables();


if(jQuery('#drTable').length>0){
	drTable = jQuery('#drTable')
	.on('preXhr.dt', function ( e, settings, data ){
		$().btnSubmit();
	}).DataTable({
			"order"					: [[ 0, "desc" ]],
			"responsive"	  : true,
			"bProcessing"		: true,
			"bServerSide"		: true,
			"sAjaxSource"		: "<?=base_url("api_admin/order/")?>",
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
						$.get('<?=base_url("api_admin/order/detail/")?>'+ieid).done(function(dt){
							if(dt.data.produk){
								var s = '';
								$.each(dt.data.produk, function(k,v){
									s += `<tr>
										<td>${(k+1)}</td>
										<td>${v.produk}</td>
										<td>${v.spesifikasi}</td>
										<td>${v.qty}</td>
										<td>${v.tgl_pesan}</td>
										<td>${v.status}</td>
										<td>${v.tgl_selesai}</td>
										<td class="text-end">${v.sub_harga}</td>
									</tr>`
								})
								s += `<tr class="table-warning">
									<td colspan="7">Total</td>
									<td class="text-end">${dt.data.detail.total_harga}</td>
								</tr>`
								$("#table_produk").html(s);
								

							}
						})
						
						$("#aedit").attr("href","<?=base_url_admin("order/edit/")?>"+ieid);
						$("#areseller").attr("href","<?=base_url_admin("partner/reseller/baru/")?>"+ieid);
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
	var gambar = getImageData('igambarprev');
	if(gambar){
		fd.append('gambar', gambar.blob, 'gambar.'+gambar.extension);
	}
	var url = '<?= base_url("api_admin/order/baru/")?>';

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
					window.location = '<?=base_url_admin('order/')?>';
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

// edit form 
$("#fedit").on("submit",function(e){
	e.preventDefault();
	NProgress.start();
	$('.btn-submit').prop('disabled',true);
	$('.icon-submit').addClass('fa-circle-o-notch fa-spin');

	var fd = new FormData($(this)[0]);
	var url = '<?=base_url("api_admin/order/edit/")?>';
	var gambar = getImageData('iegambarprev');
	console.log(gambar, 'gambar')
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
				gritter('<h4>Sukses</h4><p>Data berhasil diubah</p>','success');
				setTimeout(function(){
					window.location = '<?=base_url_admin('order/')?>';
				},500);
			}else{
				gritter('<h4>Gagal</h4><p>'+respon.message+'</p>','danger');

				$('.icon-submit').removeClass('fa-circle-o-notch fa-spin');
				$('.btn-submit').prop('disabled',false);
			}
			NProgress.done();
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
			var url = '<?=base_url('api_admin/order/hapus/')?>'+ieid;
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
		url: '<?=base_url("api_admin/order/get_parent/")?>',
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
		window.location = '<?=base_url_admin('order/baru/')?>'
	});

// edit modal
$("#aedit").on("click",function(e){
	e.preventDefault();
	window.location = '<?=base_url_admin('order/edit/')?>' + ieid
});

$(document).off('click', '.btn-tambah-indikator')
$(document).on('click', '.btn-tambah-indikator', function(e){
	e.preventDefault();
	var type = $(this).attr('data-type');
	addIndikator(type)
})
$(document).off('click', '.btn-remove-row')
$(document).on('click', '.btn-remove-row', function(e){
	e.preventDefault();
	$(this).closest('tr').remove();
})
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
	var id = $(this).attr('id');
	readURLImage(this, 'img-'+id);
});

$('.select2').select2();

$("#adetail").on('click', function(e){
	e.preventDefault();
	$("#modal_option").modal('hide');
	$("#modal_produk").modal('show');
})

function setStatus(status, tgl_selesai, id){
	var fd = new FormData();

	fd.append('tgl_selesai', tgl_selesai)
	fd.append('status', status)
	fd.append('id', id)
	$.ajax({
		type: 'POST',
		url: '<?=base_url("api_admin/order/set_status")?>',
		data: fd,
		processData: false,
		contentType: false,
		success: function(respon){
			if(respon.status==200){
				drTable.ajax.reload();
			}else{
				gritter('<h4>Gagal</h4><p>'+respon.message+'</p>','danger');
			}
			
			NProgress.done();
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
}

$(document).off('change', '.rd-status')
$(document).on('change', '.rd-status', function(e){
	e.preventDefault();
	NProgress.start();
	var status = $(this).val()
	var k = $(this).attr('data-k')
	var id = $(this).attr('data-id')
	if(status == 'done' || status == 'cancel'){
		$("#tgl_selesai"+k).show()
	}else{
		$("#tgl_selesai"+k).hide()
	}
	var tgl_selesai = $("#tgl_selesai"+k).val()

	setStatus(status, tgl_selesai, id)
})

$(document).off('change', '.tgl_selesai')
$(document).on('change', '.tgl_selesai', function(e){
	e.preventDefault();
	NProgress.start();
	var k = $(this).attr('data-k')
	var id = $(this).attr('data-id')
	var status = $('input[name="status'+k+'"]:checked').val();
	var tgl_selesai = $("#tgl_selesai"+k).val()

	setStatus(status, tgl_selesai, id)
})