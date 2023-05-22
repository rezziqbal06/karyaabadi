var growlPesan = '<h4>Error</h4><p>Tidak dapat diproses, silakan coba beberapa saat lagi!</p>';
var growlType = 'danger';
var drTable = {};
var ieid = '';

App.datatables();

function gritter(pesan,jenis="info"){
	$.bootstrapGrowl(pesan, {
		type: jenis,
		delay: 3456,
		allow_dismiss: true
	});
}


function prettyingJSON() {
	$('.json-value').map(function(){
		var badJson = $(this).val();
		if(badJson) {
			var parseJson = JSON.parse(badJson);
			$(this).val(JSON.stringify(parseJson, undefined, 16));
		}
	})
}


function loading($type='show'){
	if($type == 'hide'){
		NProgress.done();
		$('.btn-submit').prop('disabled',false);
		$('.icon-submit').removeClass('fa-circle-o-notch');
		$('.icon-submit').removeClass('fa-spin');
	}else{
		NProgress.start();
		$('.btn-submit').prop('disabled',true);
		$('.icon-submit').addClass('fa-circle-o-notch');
		$('.icon-submit').addClass('fa-spin');
	}
}

if(jQuery('#drTable').length>0){
	drTable = jQuery('#drTable')
	.on('preXhr.dt', function ( e, settings, data ){
		<!-- $().btnSubmit(); -->
	}).DataTable({
			"order"					: [[ 0, "desc" ]],
			"responsive"	  : true,
			"bProcessing"		: true,
			"bServerSide"		: true,
			"sAjaxSource"		: "<?=base_url("api_admin/pengaturan/apidoc/")?>",
			"fnServerParams": function ( aoData ) {
				aoData.push(
					{ "name": "a_company_id_parent", "value": $("#fl_a_company_id_parent").val() },
					{ "name": "badan_hukum", "value": $("#fl_badan_hukum").val() },
					{ "name": "is_vendor", "value": $("#fl_is_vendor").val() },
					{ "name": "is_active", "value": $("#fl_is_active").val() },
					{ "name": "utype", "value": $("#fl_utype").val() }
				);
			},
			"fnServerData"	: function (sSource, aoData, fnCallback, oSettings) {
				oSettings.jqXHR = $.ajax({
					dataType 	: 'json',
					method 		: 'POST',
					url 		: sSource,
					data 		: aoData
				}).done(function (response, status, headers, config) {
					console.log(response);

					$('#drTable > tbody').off('click', 'tr');
					$('#drTable > tbody').on('click', 'tr', function (e) {
						e.preventDefault();
						var id = $(this).find("td").html();
						ieid = id;
						$("#modal_option").modal("show");
					});

					<!-- $().btnSubmit('finished'); -->

					fnCallback(response);
				}).fail(function (response, status, headers, config) {
					gritter("<h4>Error</h4><p>Tidak dapat mengambil data sekarang, silahkan coba lagi nanti</p>",'warning');
					<!-- $().btnSubmit('finished'); -->
				});
			},
	});
	$('.dataTables_filter input').attr('placeholder', 'Cari kode, nama, telp');
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
			var url = '<?=base_url('api_admin/pengaturan/apidoc/hapus/')?>'+ieid;
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

$("#atambah").on('click', function(e){
	e.preventDefault();
	$("#modal_tambah").modal('show');
});


$("#aedit").on('click', function(e){
	e.preventDefault();
	loading('show')
	$.ajax({
		url: '<?=base_url("api_admin/pengaturan/apidoc/detail/")?>' +ieid,
		dataType: "JSON",
		type: "GET",
		success: (res) => {
			loading('hide')

			if(res.status == 200){
				if(res.data){
					var data = res.data;
					$.each(data, function(k,v){
						$("#ie"+k).val(v);
					})
					prettyingJSON();
					$("#modal_edit").modal('show');
				}

			}else{
				gritter(res.message, 'warning');
			}
			
		},error: () => {
			loading('hide')
			gritter('Gagal, coba beberapa saat lagi','danger');
		}
	});
});


$("#ftambah").on('submit', function(e){
	e.preventDefault();
	var formData = new FormData($(this)[0]);
	loading('show')
	$.ajax({
		url: '<?=base_url("api_admin/pengaturan/apidoc/tambah")?>',
		dataType: "JSON",
		type: "POST",
		data: formData,
		processData: false,
		contentType: false,
		success: (res) => {
			loading('hide')

			if(res.status == 200){
				$("#modal_option").modal('hide');
				$("#modal_tambah").modal('hide');
				$("#ftambah").trigger('reset');
				drTable.draw();

				gritter(res.message, 'success');

			}else{
				gritter(res.message, 'warning');
			}
			
		},error: () => {
			loading('hide')
			gritter('Gagal, coba beberapa saat lagi','danger');
		}
	});
});


$("#fedit").on('submit', function(e){
	e.preventDefault();
	var formData = new FormData($(this)[0]);
	loading('show')
	$.ajax({
		url: '<?=base_url("api_admin/pengaturan/apidoc/edit/")?>' +ieid,
		dataType: "JSON",
		type: "POST",
		data: formData,
		processData: false,
		contentType: false,
		success: (res) => {
			loading('hide')

			if(res.status == 200){
				$("#modal_option").modal('hide');
				$("#modal_edit").modal('hide');
				$("#fedit").trigger('reset');
				drTable.draw();

				gritter(res.message, 'success');

			}else{
				gritter(res.message, 'warning');
			}
			
		},error: () => {
			loading('hide')
			gritter('Gagal, coba beberapa saat lagi','danger');
		}
	});
});


$(document).off('click','.btn_prettying');
$(document).on('click','.btn_prettying', function(e){
	e.preventDefault();
	prettyingJSON();
})