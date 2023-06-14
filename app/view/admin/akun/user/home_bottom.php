var drTable = {};
var ieid = '';

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
			"sAjaxSource"		: "<?=base_url("api_admin/akun/user/")?>",
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
						$.get('<?=base_url("api_admin/akun/user/detail/")?>'+ieid).done(function(dt){
							if(dt.data){
								if(dt.data.utype){
									if(dt.data.utype == 'agen'){
										$("#areseller").hide();
									}
								}
							}
						})
						$("#adetail").attr("href","<?=base_url_admin("akun/user/detail/")?>"+ieid);
						$("#aedit").attr("href","<?=base_url_admin("akun/user/edit/")?>"+ieid);
						$("#amodule").attr("href","<?=base_url_admin("akun/user/module/")?>"+ieid);
						$("#areseller").attr("href","<?=base_url_admin("partner/reseller/baru/")?>"+ieid);
						$("#ieid-user").val(ieid);
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
			var url = '<?=base_url('api_admin/akun/user/hapus/')?>'+ieid;
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
		url: '<?=base_url("api_admin/akun/user/get_parent/")?>',
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

$("#fl_do").on("click",function(e){
		e.preventDefault();
		drTable.ajax.reload();
	});

	
$("#atambah").on("click",function(e){
		e.preventDefault();
		window.location = '<?=base_url_admin("akun/user/baru/")?>'
	});
	
$("#aresetpass").on("click",function(e){
	e.preventDefault();
	$("#modal_option").modal("hide");
	$("#modal_edit_password").modal("show");
});

// change password
$("#fchange-password").on("submit",function(e){
	e.preventDefault();
	NProgress.start();
	$('.btn-submit').prop('disabled',true);
	$('.icon-submit').addClass('fa-circle-o-notch fa-spin');

	var fd = new FormData($(this)[0]);
	var url = '<?=base_url("api_front/akun/user/changePass/")?>';
	fd.append('is_reset', true);

  let newPass = $("#new-pass").val();
  let confirmNewPass = $("#confirm-new-pass").val();

  if(newPass != confirmNewPass){
    gritter('<h4>Gagal</h4><p>Password tidak cocok</p>','danger');
  }else{
    $.ajax({
      type: $(this).attr('method'),
      url: url,
      data: fd,
      processData: false,
      contentType: false,
      success: function(respon){
        if(respon.status==200){
          gritter('<h4>Sukses</h4><p>Password berhasil direset</p>','success');
          setTimeout(function(){
			$("#modal_edit_password").modal("hide");
			NProgress.done();

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
          gritter('<h4>Error</h4><p>Tidak dapat mengubah data sekarang, silahkan coba lagi nanti</p>','danger');
        }, 666);
  
        $('.icon-submit').removeClass('fa-circle-o-notch fa-spin');
        $('.btn-submit').prop('disabled',false);
        NProgress.done();
        return false;
      }
    });

  }

});

$("#breset").on('click', function(e){
	e.preventDefault();
	$("#new-pass").val(123456);
	$("#confirm-new-pass").val(123456);
});