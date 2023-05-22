
var myChart;
function showLoading(){
	$(".panel-loading").show();
	$(".panel-empty").hide();
	$(".panel-list").hide();
	$(".panel-statistik").hide();
	$(".panel-filter").hide();
	$("#filter").hide();
	$(".panel-pagination").empty();
	$(".panel-pagination").hide();
}
function hideLoading(){
	$(".panel-loading").hide();
	$(".panel-empty").hide();
	$(".panel-list").hide();
	$(".panel-filter").hide();
	$("#filter").hide();
	$(".panel-pagination").empty();
	$(".panel-pagination").hide();
}
function scrollToTop(){
	window.scrollTo({
		top:250,
		behavior: 'smooth'
	});
}
function download(file, filename) {
    if (window.navigator.msSaveOrOpenBlob) {// IE10+
        window.navigator.msSaveOrOpenBlob(file, filename);
        return;
    }
    let a = document.createElement("a");
    let url = URL.createObjectURL(file);

    a.href = url;
    a.download = filename;
    word.appendChild(a);
    a.click();

    setTimeout(function() {
        word.removeChild(a);
        window.URL.revokeObjectURL(url);
        window.close()
    }, 500);
}

// =========================================================
// initial chart 
// =========================================================
	let jenis_penilaian = "";
	$("#card-hygiene-chart").hide();
	$("#card-apd-chart").hide();
	$("#card-monev-chart").hide();
	const chartCtx = document.querySelector("#asesmenChart");
	const hygieneCtx = document.querySelector("#hygieneChart");
	const apdCtx = document.querySelector("#apdChart");
	const monevCtx = document.querySelector("#monevChart");

	let today = new Date();
	let ruangan_categories = <?= json_encode($arm) ?>;

	let categories = [];
	let ruangan_cats = []
	let hygiene_series = [];
	$.each(ruangan_categories, function(v,k){
		hygiene_series.push(0);
		ruangan_cats.push(k.nama)
	});
	for (let i = 6; i >= 0; i--) {
		let date = new Date(today);
		date.setDate(date.getDate() - i);
		categories.push(date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
	}

	let optionsAO = {
		series: [
		{
			name: 'Audit Hand Hygiene',
			data: [0,0,0,0,0,0,0]
		},
		{
			name: 'Monitoring Kegiatan Harian Pencegahan Pengendalian Infeksi (PPI)',
			data: [0,0,0,0,0,0,0]
		},
		{
			name: 'Audit Kepatuhan APD',
			data: [0,0,0,0,0,0,0]
		},
		],
		chart: {
		height: 350,
		type: 'area',
		fontFamily: 'Lexend Deca, sans-serif',
		},
		dataLabels: {
		enabled: false
		},
		stroke: {
		curve: 'smooth'
		},
		xaxis: {
		type: 'string',
		categories: categories,
		},
		tooltip: {
			x: {
				format: undefined,
			},
		},
	};


	let optionsHygiene = {
		series: [
			{
				name: jenis_penilaian,
				data: hygiene_series
			},
		],
		chart: {
			height: 350,
			type: 'area',
			fontFamily: 'Lexend Deca, sans-serif',
			zoom : {
				enabled : true,
				type: 'x'
			},
			options: {
				chart: {
					overflow: 'scroll'
				}
			}
		},
		dataLabels: {
			enabled: false
		},
		stroke: {
			curve: 'smooth'
		},
		xaxis: {
			type: 'string',
			categories: ruangan_cats,
			labels: {
				rotate: -45,
          		rotateAlways: true,
				hideOverlappingLabels: true
			}
		},
		tooltip: {
			x: {
				format: undefined,
			},
		},
		responsive: [{
			breakpoint: 768, // define breakpoint for mobile devices
			options: {
				chart: {
					width: 700,
					height: 300 // set a fixed height for mobile devices
				}
			}
		}]
	};

  	let chartAO = new ApexCharts(chartCtx, optionsAO);
	let chartHygiene = new ApexCharts(hygieneCtx, optionsHygiene);
	let chartApd = new ApexCharts(apdCtx, optionsHygiene);
	let chartMonev = new ApexCharts(monevCtx, optionsHygiene);

	$(document).on('ready',() => {
		validateFilter();
		chartAO.render();		
		chartHygiene.render();
		chartApd.render();
		chartMonev.render();
		var jp = <?=$jp ?? 2?>;
		if(jp) $("#jenis_penilaian").val(jp);
		setTimeout(function(){
			var fd = new FormData($("#ffilter")[0]);
			initData(fd);
		},300);
	})


function grafik_asesmen(){
	$.get('<?= base_url("api_front/asesmen/chart_asesmen") ?>', {
		'asesor_id' : $('#asesor').val()
	}).done((res) => {
		let today = new Date();
		let categories = [];

		for (let i = 6; i >= 0; i--) {
			let date = new Date(today);
			date.setDate(date.getDate() - i);
			categories.push(date.toLocaleDateString('en-US', { day: 'numeric' }));
		}


		let hh_series = [];
		let apd_series = [];
		let monev_series = [];

		let hh = res.data.hh;
		let apd = res.data.apd;
		let monev = res.data.monev;

		categories.forEach(category => {
        let count_hh = 0;
        let count_apd = 0;
        let count_monev = 0;
        hh.forEach(item => {
          if (item.day === category) {
            count_hh = item.nilai;
          }
        });
        apd.forEach(item => {
          if (item.day === category) {
            count_apd = item.nilai;
          }
        });
        monev.forEach(item => {
          if (item.day === category) {
            count_monev = item.nilai;
          }
        });
        hh_series.push(count_hh);
        apd_series.push(count_apd);
        monev_series.push(count_monev);
      });


		setTimeout(() => {
        chartAO.updateSeries([
          {
            name: 'Audit Hand Hygiene',
            data: hh_series
          },
          {
            name: 'Monitoring Kegiatan Harian Pencegahan Pengendalian Infeksi (PPI)',
            data: apd_series
          },
          {
            name: 'Audit Kepatuhan APD',
            data: monev_series
          }
        ])
      }, 100)

	}).fail((xhr) => {
	});
}

function grafik_hygiene(name, respon){
	let today = new Date();
	let series = [];

	$.each(ruangan_categories, function(v,k){
		let nilai = 0;
		$.each(respon, function(v1,k1){
			if(k.id == k1.a_ruangan_id){
				nilai = parseInt(k1.nilai);
			}
		});
		series.push(nilai);
	});

	setTimeout(() => {
		chartHygiene.updateSeries([
			{
				name: '',
				data: series
			}
		])
	}, 100)
}

function grafik_apd(name, respon){
	let today = new Date();
	let series = [];

	$.each(ruangan_categories, function(v,k){
		let nilai = 0;
		$.each(respon, function(v1,k1){
			if(k.id == k1.a_ruangan_id){
				nilai = parseInt(k1.nilai);
			}
		});
		series.push(nilai);
	});

	setTimeout(() => {
		chartApd.updateSeries([
			{
				name: '',
				data: series
			}
		])
	}, 100)
}

function grafik_monev(name, respon){
	let today = new Date();
	let series = [];

	$.each(ruangan_categories, function(v,k){
		let nilai = 0;
		$.each(respon, function(v1,k1){
			if(k.id == k1.a_ruangan_id){
				nilai = parseInt(k1.nilai);
			}
		});
		series.push(nilai);
	});

	setTimeout(() => {
		chartMonev.updateSeries([
			{
				name: '',
				data: series
			}
		])
	}, 100)
}


// ===============================================================
// end initial chart 
// ===============================================================

function initData(fd=[]){
	if(fd){
		fd.append('a_jpenilaian_id', $('#jenis_penilaian').find('option:selected').val());
	}
	showLoading();
	var url = '<?=base_url("api_front/asesmen/list")?>';
	$.ajax({
		url: url,
		data: fd,
		processData: false,
		contentType: false,
		type: 'POST',
		success: function(respon){
			hideLoading();
			if(respon.status==200){
				var slug = respon.data.ajm.slug;
				var name = respon.data.ajm.nama;
				var type_form = respon.data.ajm.type_form;
				var permission = respon.data.permission;
				if(respon.data.list && respon.data.list.length > 0){
					var s = '';
					
					$.each(respon.data.list, function(k,v){
						var is_show = 'd-none'
						if(v.nilai) is_show = '';
						s += `
						<div class="col-md-4 mb-3">
							<a class="" data-id="${v.id}" href="<?=base_url('asesmen/')?>${v.slug}/${v.id}">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-6">
												<span class="" style="font-size: smaller;">${v.type_form != 2 ? v.ruangan : ''}</span>
											</div>
											<div class="col-6">
												<span class="pill pill-warning ${is_show} float-end">${v.nilai} poin</span>
											</div>
										</div>
										<p class=""><b>${v.type_form == 2 ? v.ruangan : v.nama}</b></p>
										<figcaption class="blockquote-footer">
											${v.type_form != 2 ? v.profesi : ''}
										</figcaption>
										<div class="row">
											<div class="col-8">
												<span class="text-grey" style="font-size: smaller;">${v.cdate}</span>
											</div>
											<div class="col-4">
												<span class="float-end" style="font-size: smaller;">${v.durasi}</span>
											</div>
										</div>
										<div class="d-flex justify-content-end">
											<a href="#" onclick="confirm('apakah anda yakin?') ? window.location.replace('<?=base_url('api_front/asesmen/hardDelete')?>/${v.id}') : '' " class="btn btn-danger"><i class="fas fa-trash"></i></a>
										</div>
									</div>
								</div>
							</a>
						</div>`;
					});
					if(respon.data.pagination){
						$(".panel-pagination").html(respon.data.pagination);
						$(".panel-pagination").show();
					} 
					$(".panel-list").html('');
					$(".panel-list").html(s);
					
					$(".panel-filter").show();
					$("#filter").show();
					$(".panel-list").show();
					$(".panel-list").addClass("row");
					$(".panel-empty").hide();

					
				}else{
					console.log('kosong');
					$(".panel-empty").show();
				}
				if(permission.chart){
					if(type_form == 1){
						$("#card-apd-chart").hide();
						$("#card-monev-chart").hide();
						$("#card-hygiene-chart").show();
						grafik_hygiene(name, respon.data.data);
					} else if(type_form == 3){
						$("#card-monev-chart").hide();
						$("#card-hygiene-chart").hide();
						$("#card-apd-chart").show();
						grafik_apd(name, respon.data.data);
					} else if (type_form == 2){
						$("#card-hygiene-chart").hide();
						$("#card-apd-chart").hide();
						$("#card-monev-chart").show();
						grafik_monev(name, respon.data.data);
					}
					$(".panel-statistik").show();
					$(".panel-filter").show();

				}else{
					$(".panel-empty").show();
				}
				if(permission.export){
					$("#btn_print").show();
				}else{
					$("#btn_print").hide();
				}

				if(!permission.read && !permission.chart){
					$(".panel-empty").show();
				}else{
				}
			}else{
				gritter('<h4>Gagal</h4><p>'+respon.message+'</p>','warning');
				NProgress.done();
			}
		},
		error:function(){
			hideLoading();
			setTimeout(function(){
				gritter('<h4>Error</h4><p>Tidak dapat menambah data, silahkan coba beberapa saat lagi</p>','danger');
			}, 666);

			$('.icon-submit').removeClass('fa-circle-o-notch fa-spin');
			$('.btn-submit').prop('disabled',false);
			NProgress.done();
			return false;
		}
	});
};
$('.select2').select2();


$('#ffilter').on('submit', function(e){
	e.preventDefault();
	if(myChart){
		myChart.destroy();
	}
	var fd = new FormData($(this)[0]);
	initData(fd);
	$("#modal_filter").modal('hide');
});

$('#ffilter_modal').on('submit', function(e){
	e.preventDefault();
	$('#ffilter').trigger('submit');
});


$("#asesor").on('change', function(e){
	grafik_asesmen();
});

function validateFilter(){
	var jp = $("#jenis_penilaian").find('option:selected').val();
	if(jp == 4){
		$(".panel_b_user_id").hide();
		$(".panel_tgl").hide();
		$(".panel_bulan").show();
	}else{
		$(".panel_b_user_id").show();profesi == 'IPCN'
		$(".panel_tgl").show();
		$(".panel_bulan").hide();
	}

	var profesi = '<?=$sess->user->profesi ?? ''?>';
	if(profesi == 'IPCN' || profesi == 'IPCD' || profesi == 'Komite Mutu'){
		$(".panel_b_user_id_penilai").show();
	}else{
		$(".panel_b_user_id_penilai").hide();
	}
}

$('#btn_filter').on('click', function(e){
	e.preventDefault();
	validateFilter();
	$("#modal_filter").modal('show');
});

$("#jenis_penilaian").on('change', function(e){
	e.preventDefault();
	validateFilter();	
	var fd = new FormData($("#ffilter")[0]);
	if(myChart){
		myChart.destroy();
	}
	initData(fd);
});

function printHH(respon){
	var s = '<h4 class="text-center mb-n1">FORMULIR AUDIT HAND HYGIENE RSU BINA SEHAT</h4><br>';
	s += '<table style="width: 100%;">'
	s += '<tbody>'
	var n = 0;
	$.each(respon.data.list, function(k,v){
		if(k == 0){
			s += '<tr>';
		}
		if(n == 3){
			s += '</tr><tr>';
			n = 0;
		}
		s += `<td>
				<table class="my_table">
					<tbody>
						<tr>
							<td>Profesi</td>
							<td colspan="2">${v.profesi}</td>
						</tr>
						<tr>
							<td>Nama</td>
							<td colspan="2">${v.nama}</td>
						</tr>
						<tr>
							<td>Unit</td>
							<td colspan="2">${v.ruangan}</td>
						</tr>
						<tr>
							<td>Tanggal</td>
							<td colspan="2">${v.cdate}</td>
						</tr>
						<tr>
							<td>Lama Audit</td>
							<td colspan="2">${v.durasi}</td>
						</tr>
					</tbody>
					<tbody>
						<tr style="background-color: #08686738;">
							<td>Opp</td>
							<td>Indikasi</td>
							<td>Action</td>
						</tr>`
						$.each(v.value, function(kvalue, vvalue){
							var isPageBreak = kvalue == 4 ? '' : '';
							s += `<tr class="${isPageBreak}">
								<td>${kvalue+1}</td>
								<td>`
								$.each(respon.data.aim, function(kaim,vaim){
									if(vaim.type == 'indikator'){
										var ischecked = vvalue.indikator == vaim.id ? 'checked' : '';
										s += `<div class="form-check">
												<input class="form-check-input" type="checkbox" ${ischecked}>
												<label class="form-check-label" >
													${vaim.nama}
												</label>
											</div>`
										<!-- s += `<label><input type="checkbox" ${ischecked}> ${vaim.nama}</label>` -->
									}
								})
							s += `</td>`
							s += `<td>`
								$.each(respon.data.aim, function(kaim,vaim){
									if(vaim.type == 'aksi'){
										var ischecked = vvalue.aksi == vaim.id ? 'checked' : '';
										s += `<div class="form-check">
												<input class="form-check-input" type="checkbox" ${ischecked}>
												<label class="form-check-label" >
													${vaim.nama}
												</label>
											</div>`
										<!-- s += `<label><input type="checkbox" ${ischecked}> ${vaim.nama}</label>` -->
									}
								})
							s += `</td>
							</tr>`
						})
						
					s += `</tbody>
				</table>
			</td>`;
		if(k == respon.data.list.length - 1){
			s += '</tr>';
		}
		n++;
	});
	s += '</tbody>'
	s += '</table>'

	$.post('<?=base_url('api_front/asesmen/printing')?>', {content: s}).done(function(dt){
		if(dt.status == 200) window.open('<?=base_url('cetak/hh/')?>', 'blank');
	})

	<!-- $("#panel_print").html(s); -->
	
}

function printMonev(respon){
	$.post('<?=base_url('api_front/asesmen/printing_xls')?>', {content: respon}).done(function(dt){
		if(dt.status == 200) window.open('<?=base_url('cetak/monev/')?>', 'blank');
	})
}

function printApd(respon){
	$.post('<?=base_url('api_front/asesmen/printing_xls')?>', {content: respon}).done(function(dt){
		if(dt.status == 200) window.open('<?=base_url('cetak/apd/')?>', 'blank');
	})
}


$("#btn_print").on('click', function(e){
	e.preventDefault();
	var fd = $("#ffilter").serialize();var fd = new FormData($("#ffilter")[0]);
	if(fd){
		fd.append('a_jpenilaian_id', $('#jenis_penilaian').find('option:selected').val());
	}
	
	var name = $('#jenis_penilaian').find('option:selected').text();
	var type_form = $('#jenis_penilaian').find('option:selected').attr('data-type-form');
	var url = '';
	if(type_form == 1){
		var fd = $("#ffilter").serialize();
		if(fd){
			fd += '&a_jpenilaian_id='+$('#jenis_penilaian').find('option:selected').val();
		}
		url = '<?=base_url('cetak/hh/?')?>'+fd;
		window.open(url, 'blank');
	}else if(type_form == 3){
		url = '<?=base_url('cetak/apd/')?>'
	}else{
		url = '<?=base_url('cetak/monev/')?>'
	}

	if(type_form != 1){
		NProgress.start();
		$.ajax({
			url: url,
			data: fd,
			processData: false,
			contentType: false,
			type: 'POST',
			success: function(respon){
				NProgress.done();
				if(respon.status==200){
					var link = document.createElement('a');
					link.href = respon.data.url;
					link.click();
				}else{
					gritter('<h4>Gagal</h4><p>'+respon.message+'</p>','warning');
				}
				$('.icon-submit').removeClass('fa-circle-o-notch fa-spin');
				$('.btn-submit').prop('disabled',false);
				NProgress.done();
			},
			error:function(){
				NProgress.done();
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
	
})

$("#btn_print_modal").on('click', function(e){
	e.preventDefault();
	$("#btn_print").trigger('click');
})

function goToPage(page){
	if(page){
		var fd = new FormData($("#ffilter")[0]);
		fd.append('page',page);
		if(myChart){
			myChart.destroy();
		}
		initData(fd);
	}
}

$(document).off('change',"[id^='im_']");
$(document).on('change',"[id^='im_']", function(e){
	e.preventDefault();
	var tag = e.target.tagName;
	var value = $(this).val();
	if(!value){
		value = $(this).find('option:selected').val()
	}
	var id = $(this).attr('id');
	id = id.replace('im_','i');
	if(tag == 'SELECT'){
		$("#"+id).val(value).select2();

	}else{
		$("#"+id).val(value);

	}
})
