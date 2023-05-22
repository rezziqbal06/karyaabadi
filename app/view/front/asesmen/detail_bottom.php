function changeChoice(selector, custom_aksi = ''){
	$("#"+selector).removeClass("border border-success border-danger");
	let aksi = $("#aksi-"+selector).val();
	console.log(selector, custom_aksi);
	if(custom_aksi){
		if(custom_aksi == 'y'){
			$("#aksi-"+selector).val('y');
			$("#"+selector).addClass("border border-success");
		}else{
			$("#aksi-"+selector).val('n');
			$("#"+selector).addClass("border border-danger");
		}
	}else{
		if(!aksi || aksi == 'n'){
			$("#aksi-"+selector).val('y');
			$("#"+selector).addClass("border border-success");
		}else{
			$("#aksi-"+selector).val('n');
			$("#"+selector).addClass("border border-danger");
		}
	}
}

function saveLocal(){
	var key = '<?=$ajm->id.'-'.$sess->user->id?>';
	var data = $("#ftambah").serializeArray();
	setTimeout(function(){
		localStorage.setItem(key, JSON.stringify(data));
		console.log('simpan local', key, data);
	},333)
}

function removeLocalData(){
<?php if(!isset($cam)) : ?>
	var key = '<?=$ajm->id.'-'.$sess->user->id?>';
	localStorage.removeItem(key);
<?php endif ?>
}

function initLocalData(){
<?php if(!isset($cam)) : ?>
	var key = '<?=$ajm->id.'-'.$sess->user->id?>';
	let data = localStorage.getItem(key);
	var nomor = -1;
	if(data){
		data = JSON.parse(data);
		console.log(data, 'data local')
		$.each(data, function(k,v){
			if(v.value){
				if(v.name.includes('[]')){
					var name = v.name.replaceAll('[]','');
					if(v.name.includes('b_user_id_penilais')){
						nomor++;
					}
					console.log("#i"+name+'_'+nomor, v.value)
					$("#i"+name+'_'+nomor).val(v.value);
					if(name.includes('indikator')) $("#i"+name+'_select_'+nomor).val(v.value).select2();

				}else{
					var tag = $("#"+v.name).prop('tagName');
					console.log(tag,v.name);
					if(tag == 'SELECT'){
						$("#"+v.name).val(v.value).select2();
					}else{
						$("#"+v.name).val(v.value);
					}
					var tag = $("#i"+v.name).prop('tagName');
					if(tag == 'SELECT'){
						$("#i"+v.name).val(v.value).select2();
					}else{
						$("#i"+v.name).val(v.value);
					}

					if(<?= $type_form ?> == 1){ //Hand hygiene
						if(v.name.includes('a_aksi_id')){
							if(v.value) $("#i"+v.name+"_"+v.value).prop('checked', true);
						}
					}else if(<?= $type_form ?> == 2){ //MM
						if(v.name.includes('aksi')){
							var selector = v.name.replaceAll('aksi[','');
							selector = selector.replaceAll(']','');
							changeChoice(selector, v.value);
						}
					}else if(<?= $type_form ?> == 3){ //APD
						if(v.name.includes('a_indikator_aksi')){
							$("[name='"+v.name+"']").prop('checked', true);
						}
					}
				


				}
			}
		})
	} 
	
<?php endif ?>
	NProgress.done();
}

$("#btn_back").on('click', function(e){
    e.preventDefault();
    var c = confirm('Apakah anda yakin?');
    if(c){
		removeLocalData();
        history.back()
    }
})

//submit form
$("#ftambah").on("submit",function(e){
	e.preventDefault();
	var c = confirm('Apakah anda yakin?');
	// var c = confirm('Apakah anda yakin? Penilaian yang tersimpan tidak bisa diedit kembali.');
	if(!c){
		return;
		return false;
	}
	if(!$("#cdate").val()){
		gritter('<p>Tanggal belum terisi</p>','warning');
		return false;
	}
	<?php if($type_form != 2) : ?>
	if(!$("#iuser").val()){
		gritter('<p>Nama belum terisi</p>','warning');
		return false;
	}
	<?php endif; ?>
	NProgress.start();
	$('.btn-submit').prop('disabled',true);
	$('.icon-submit').addClass('fa-circle-o-notch fa-spin');

	var fd = new FormData($(this)[0]);
	var url = '<?= isset($id) ? base_url("api_front/asesmen/edit/$id") : base_url("api_front/asesmen/baru")?>';
	var isEmpty = false; 
	$.each($("input[id*='aksi']:not([id='aksi-empty'])"), function(key,value){
		var vals = $(value).val();
		var data_id = $(value).attr('data-id');
		var id = $(value).attr('id');
		console.log(vals,"value");
		console.log(value,"val");
		if(!vals){
			gritter('<p>Beberapa belum terisi</p>','warning');
			$('.icon-submit').removeClass('fa-circle-o-notch fa-spin');
			$('.btn-submit').prop('disabled',false);
			NProgress.done();
			isEmpty = true;
			return false;
		}
	})
	
	if(!isEmpty){
		$.ajax({
			url: url,
			data: fd,
			processData: false,
			contentType: false,
			type: $(this).attr('method'),
			success: function(respon){
				if(respon.status==200){
					removeLocalData();
					gritter('<h4>Sukses</h4><p>Data berhasil ditambahkan</p>','success');
					setTimeout(function(){
						window.location = '<?=base_url('asesmen/')?>';
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
					gritter('<h4>Error</h4><p>Tidak dapat menambah data, silahkan coba beberapa saat lagi</p>','danger');
				}, 666);
	
				$('.icon-submit').removeClass('fa-circle-o-notch fa-spin');
				$('.btn-submit').prop('disabled',false);
				NProgress.done();
				return false;
			}
		});
	}
});

$("#btn_cari_user").on('click', function(e){
    e.preventDefault();
    $("#modal_cari_user").modal('show');
});

function cariUser(){
	$("#cari_user").select2({
		ajax: {
			method: 'post',
			url: '<?=base_url("api_front/user/cari/")?>',
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
}

var form_hygiene = '';
$(document).on('ready',() => {
	if(<?= $type_form ?> == 1){
		form_hygiene = $(".parent").html();
	}else if(<?= $type_form ?> == 3){
		form_hygiene = $(".parent").html();
	}
	$(".select2").select2();
	cariUser();
	
	if(<?= $type_form ?> == 2){
		NProgress.start();
		setTimeout(function(){
			initLocalData();
		},1500)
	}else{
		NProgress.start();
		initLocalData();
	}
})


$("#pilih_user").on('click', function(e){
    e.preventDefault();
    var id = $('#cari_user').find('option:selected').val();
	var cdate = $('#cdate').val();
    $.get('<?=base_url('api_front/user/detail/')?>' + id + '/' + '?jenis_penilaian=<?=$ajm->slug?>&cdate='+cdate).done(function(dt){
        if(dt.data){
            $("#ib_user_id").val(id);
            $("#iuser").val(dt.data.fnama);
			console.log(dt.data);
            $("#ia_jabatan_id").val(dt.data.a_jabatan_id).select2();
            $("#ia_ruangan_id").val(dt.data.a_unit_id).select2();
            $("#modal_cari_user").modal('hide');
			$('.progress').slideUp();
            <?php if($ajm->type_form == 1) : ?>
				console.log('ini hand higene');
                if(dt.data.jumlah_penilaian){
					var message = '';
					if(dt.data.jumlah_penilaian >= 10){
						$('.progress-bar').addClass('bg-warning');
						message = 'penilaian sudah maksimal di bulan ini (10 kali)';
					}else{
						message = dt.data.jumlah_penilaian;
					}
                    $('.progress-bar').css('width', dt.data.progress_penilaian+'%').attr('aria-valuenow', dt.data.progress_penilaian).text(message); 
                    $('.progress').slideDown();
                }
				if(dt.data.histori_penilaian && dt.data.histori_penilaian.length > 0){
					var penilaian = dt.data.histori_penilaian;
					console.log(penilaian, 'penilaian');
					if(penilaian && penilaian.length >= 10){
						var pesan = `Penilaian untuk ${dt.data.fnama} sudah selesai dikerjakan/sudah 10kali kesempatan. Silakan untuk kembali`;
						var a = alert(pesan);
						$(".btn-submit").hide();				
					}
					$.each(penilaian, function(k,v){
						$("#panel-item-asesmen-"+k).empty();
					})
				}else{
					$(".parent").html(form_hygiene);
				}
            <?php endif; ?>

			<?php if($ajm->type_form == 3) :?>
				console.log('dt', dt);
				if(dt.data.jumlah_penilaian){
					var message = '';
					if(dt.data.jumlah_penilaian >= 10){
						$('.progress-bar').addClass('bg-warning');
						message = 'penilaian sudah maksimal di bulan ini (10 kali)';
					}else{
						message = dt.data.jumlah_penilaian;
					}
                    $('.progress-bar').css('width', dt.data.progress_penilaian+'%').attr('aria-valuenow', dt.data.progress_penilaian).text(message); 
                    $('.progress').slideDown();
                }
				if(dt.data.histori_penilaian && dt.data.histori_penilaian.length > 0){
					var penilaian = dt.data.histori_penilaian;
					console.log(penilaian, 'penilaian');
					if(penilaian && penilaian.length >= 10){
						var pesan = `Penilaian untuk ${dt.data.fnama} sudah selesai dikerjakan/sudah 10kali kesempatan. Silakan untuk kembali`;
						var a = alert(pesan);
						history.back();
						$(".btn-submit").hide();				
					}
					$.each(penilaian, function(k,v){
						$("#panel-item-asesmen-"+k).empty();
					})
				}else{
					$(".parent").html(form_hygiene);
				}
			<?php endif; ?>
			$('.select2').select2();
			cariUser();
			saveLocal();
        } 
    })
})


$(document).off('click', '.choice');
$(document).on('click', '.choice', function(e){
	e.preventDefault();
	let selector = $(this).attr("data-id");
	changeChoice(selector);
	saveLocal();
});

$(document).off('dblclick', '.choice');
$(document).on('dblclick', '.choice', function(e){
	e.preventDefault();
	let selector = $(this).attr("data-id");
	changeChoice(selector, 'n');
	saveLocal();
});

$(document).on('click',"#filter-empty",function(e){
	e.preventDefault();
	let iempty = $("#aksi-empty").val();
	if(!iempty || iempty == 'false'){
		$("#aksi-empty").val('true');
		$(this).addClass("bg-primary");
		$("#filter-empty h6").addClass("text-white");
		$("#filter-empty h6").text("Reset Filter");
		var isEmpty = false; 
		$.each($(".choice "), function(key,value){
			var vals = $(value).val();
			var data_id = $(value).attr('data-id');
			var id = $(value).attr('id');
			var value = $("#aksi-"+data_id).val();
			console.log(value);
			if(value || value == 'y'){
				$("#aksi-"+data_id).parent().hide();
			}
		})
	}else{
		$(this).removeClass("bg-primary");
		$("#filter-empty h6").removeClass("text-white");
		$("#filter-empty h6").text("Tampilkan yang belum diisi");
		$("#aksi-empty").val('false');
		$.each($(".choice "), function(key,value){
			var vals = $(value).val();
			var data_id = $(value).attr('data-id');
			var id = $(value).attr('id');
			var value = $("#aksi-"+data_id).val();
			console.log(value);
			if(value || value == 'y'){
				$("#aksi-"+data_id).parent().show();
			}
		})
	}
});


function initDataByRuanganId(r_id=0, val_edit = []){
	var url = '<?= base_url("api_front/asesmen/indicatorLists/".$slug."/") ?>'+r_id;
	$.ajax({
		url: url,
		data: [],
		processData: false,
		contentType: false,
		type: 'POST',
		success: function(respon){
			if(respon.status==200){
				if(respon.data.aim && Object.keys(respon.data.aim).length > 0){
					if(val_edit.length < 0){
						let s = '';
						let r = '';
						$("#panel-judul").removeClass("col-md-12");
						$("#panel-judul").addClass("col-md-6");
						$("#panel-filter").addClass("col-md-6");
						$("#panel-filter").html(`<div class="card col-md-5 p-3 text-center transition" id="filter-empty">
							<input type="hidden" id="aksi-empty">
							<h6>Tampilkan yang belum diisi</h6>
						</div>`);
						$.each(respon.data.aim, function(k,v){
							$.each(v, function(k1,v1){
								r += `
								<div class="col-md-6">
								<div class="card p-3 m-1 choice transition" data-id="${v1.id}" id="${v1.id}">
									<input type="hidden" id="aksi-${v1.id}" name="aksi[${v1.id}]">
									<h6>${v1.nama}</h6>
								</div>	
								</div>
								`;
							});
							s += `<div class="card p-2 my-3">
								<div class="card-header">
									<h4>${k}</h4>
									<hr>
								</div>
								<div class="card-body">
									<div class="row">
										${r}
									</div>
								</div>
							</div>`;
							r = '';
						});
						$("#panel-form-2").html('');
						$("#panel-form-2").html(s);
					}else{
						let s = '';
						let r = '';
						$("#panel-judul").removeClass("col-md-12");
						$("#panel-judul").addClass("col-md-6");
						$("#panel-filter").addClass("col-md-6");
						$("#panel-filter").html(`<div class="card col-md-5 p-3 text-center transition" id="filter-empty">
							<input type="hidden" id="aksi-empty">
							<h6>Tampilkan yang belum diisi</h6>
						</div>`);
						$.each(respon.data.aim, function(k,v){
							
							$.each(v, function(k1,v1){
								r += `
								<div class="col-md-6">
								<div class="card p-3 m-1 choice transition" data-id="${v1.id}" id="${v1.id}">
									<input type="hidden" id="aksi-${v1.id}" name="aksi[${v1.id}]">
									<h6>${v1.nama}</h6>
								</div>	
								</div>
								`;
							});
							s += `<div class="card p-2 my-3">
								<div class="card-header">
									<h4>${k}</h4>
									<hr>
								</div>
								<div class="card-body">
									<div class="row">
										${r}
									</div>
								</div>
							</div>`;
							r = '';
						});
						$("#panel-form-2").html('');
						$("#panel-form-2").html(s);
						console.log(val_edit);
						$.each(val_edit, function(k,v){
							$("#"+v.indikator).removeClass("border border-success border-danger");
							$("#aksi-"+v.indikator).val(v.aksi);
							if(v.aksi == 'n'){
								$("#"+v.indikator).addClass("border border-danger");
							}else{
								$("#"+v.indikator).addClass("border border-success");
							}
						});

					}
					
				}else{
					$("#panel-form-2").html('');
				}
				if(respon.data.list && respon.data.list.length > 0){
					let labelSets = [];
					let nilaiSets = [];
					$.each(respon.data.datasets, function(k,v){
						labelSets.push(v.nama);
						nilaiSets.push(v.percent);
					});
					initChart(labelSets,nilaiSets);
					var s = '';
					
				}else{
					$(".panel-empty").show();
				}
			}else{
				gritter('<h4>Gagal</h4><p>'+respon.message+'</p>','danger');
				NProgress.done();
			}
		},
		error:function(){
			hideLoading();
			setTimeout(function(){
				gritter('<h4>Error</h4><p>Tidak dapat memuat data, silahkan coba beberapa saat lagi</p>','warning');
			}, 666);

			$('.icon-submit').removeClass('fa-circle-o-notch fa-spin');
			$('.btn-submit').prop('disabled',false);
			NProgress.done();
			return false;
		}
	});
}

$('#cdate').datepicker({format: 'yyyy-mm-dd'})


<?php if(($permission->create && !isset($value)) || ($permission->edit && isset($value))){ ?>
	console.log("buttonnya ada")
	$(".btn-submit").show();
	<?php }else{ ?>
		$(".btn-submit").show();
		$(".btn-submit").prop("disabled",true);
	console.log("buttonnya hilang brow")
		$(".btn-submit").text("Anda tidak punya wewenang untuk edit asesmen ini");
<?php } ?>
if(<?= $type_form ?> == 1){
	var val_edit = <?= isset($value) ? json_encode($value) : json_encode([]) ?>;
	if(val_edit.length > 0){
		$('.progress-bar').removeClass('bg-warning');
		var items = val_edit.length;
		var progress = Math.round(items/10*100);
		if(val_edit.length >= 10){
			$(".btn-submit").hide();
			$('.progress-bar').addClass('bg-warning');
			items = 'penilaian sudah maksimal di bulan ini (10 kali)';
		}else{
			items = items+'';
		}
		$('.progress').slideUp();
		if(items){
			$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress).text(items); 
			$('.progress').slideDown();
			console.log('slide down', items)
		}
	}

	
}else if(<?= $type_form ?> == 2){
	$("#ia_ruangan_id").on('change', function(e){
		e.preventDefault();
		let ruangan_id = this.value;
		initDataByRuanganId(ruangan_id);
		let selector = $(this).attr("data-id");
		$("#"+selector).removeClass("border border-success border-danger");
	});
	var val_edit = <?= isset($value) ? json_encode($value) : json_encode([]) ?>;
	console.log(val_edit.length);
	if(val_edit.length < 1){
		setTimeout(function(){
			var fd = $("#ia_ruangan_id").val();
			initDataByRuanganId(fd);
		},300);
	}else{
		setTimeout(function(){
			var fd = $("#ia_ruangan_id").val();
			initDataByRuanganId(fd,val_edit);
		},300);
	}
} else if(<?= $type_form ?> == 3){
	console.log(<?= $type_form ?>);
	var val_edit = <?= isset($value) ? json_encode($value) : json_encode([]) ?>;
	if(val_edit.length > 0){
		console.log(val_edit);
		$.each(val_edit, function(k,v){
			$.each(v.aksi,function(k1,v1){
				console.log(v1);
				$("#checkbox_"+v1+"_"+v.indikator).prop('checked', true);
			})
		});
		
		$('.progress-bar').removeClass('bg-warning');
		var items = val_edit.length;
		var progress = Math.round(items/10*100);
		if(val_edit.length >= 10){
			$(".btn-submit").hide();
			$('.progress-bar').addClass('bg-warning');
			items = 'penilaian sudah maksimal di bulan ini (10 kali)';
		}else{
			items = items;
		}
		$('.progress').slideUp();
		if(items){
			$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress).text(items); 
			$('.progress').slideDown();
			console.log('slide down', items)
		}
	}
}

function tambahForm(now){

}



$(document).off('change', '.indikator-select');
$(document).on('change', '.indikator-select', function(e){
	e.preventDefault();
	let count = $(this).attr("data-count");
	let value = $(this).find('option:selected').val();
	$("#ia_indikator_id_"+count).val(value);
});

<?php if(!isset($cam)) : ?>
//Offline mode
$(document).off('change', 'select');
$(document).on('change', 'select', function(e){
	e.preventDefault();
	saveLocal();
});
$(document).off('input', 'input');
$(document).on('input', 'input', function(e){
	e.preventDefault();
	saveLocal();
});
<?php endif ?>