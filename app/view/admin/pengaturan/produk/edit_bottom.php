var media_target_div = 'dgaleri_items';
var media_single = 0;
var media_name = 'image[]';
var media_caption = 0;
var media_id = '';
var folder_id = '';
var galeri_item_count = 0;

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
initCompressingImage('iegambar');

//fill data
var data_fill = <?=json_encode($bpm)?>;
$.each(data_fill,function(k,v){
	if(k == 'gambar'){
    $('#img-iegambar').attr('src', '<?=base_url()?>'+v);
  }else{
    $("#ie"+k).val(v);
  }
});

//submit form
$("#fedit").on("submit",function(e){
	e.preventDefault();
	NProgress.start();
	$('.btn-submit').prop('disabled',true);
	$('.icon-submit').addClass('fa-circle-o-notch fa-spin');

	var fd = new FormData($(this)[0]);
	var url = '<?=base_url("api_admin/pengaturan/produk/edit/".$bpm->id)?>';

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
					window.location = '<?=base_url_admin('pengaturan/produk/')?>';
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

$("#ienegara").on("change",function(e){
	e.preventDefault();
	$("#ieprovinsi").trigger("change");
});

$("#ieprovinsi").select2({
	ajax: {
		method: 'post',
		url: '<?=$this->config->semevar->api_address."provinsi/get/"?>',
		dataType: 'json',
    delay: 250,
		data: function (params) {
      var query = {
        keyword: params.term,
        negara: $("#ienegara").val()
      }
      return query;
    },
    processResults: function (dt) {
      return {
        results:  $.map(dt.result, function (itm) {
          return {
            text: itm.text,
            id: itm.text
          }
        })
      };
    },
    cache: true
	}
});

$("#iekabkota").select2({
	ajax: {
		method: 'post',
		url: '<?=$this->config->semevar->api_address."kabkota/get/"?>',
		dataType: 'json',
    delay: 250,
		data: function (params) {
      var query = {
        keyword: params.term,
        provinsi: $("#ieprovinsi").val()
      }
      return query;
    },
    processResults: function (dt) {
      return {
        results:  $.map(dt.result, function (itm) {
          return {
            text: itm.text,
            id: itm.text
          }
        })
      };
    },
    cache: true
	}
});

$("#iekecamatan").select2({
	ajax: {
		method: 'post',
		url: '<?=$this->config->semevar->api_address."kecamatan/get/"?>',
		dataType: 'json',
    delay: 250,
		data: function (params) {
      var query = {
        keyword: params.term,
        kabkota: $("#iekabkota").val()
      }
      return query;
    },
    processResults: function (dt) {
      return {
        results:  $.map(dt.result, function (itm) {
          return {
            text: itm.text,
            id: itm.text
          }
        })
      };
    },
    cache: true
	}
});


$("#iekelurahan").select2({
	ajax: {
		method: 'post',
		url: '<?=$this->config->semevar->api_address."kelurahan/get/"?>',
		dataType: 'json',
    delay: 250,
		data: function (params) {
      var query = {
        keyword: params.term,
        kecamatan: $("#iekecamatan").val()
      }
      return query;
    },
    processResults: function (dt) {
      return {
        results:  $.map(dt.result, function (itm) {
          return {
            text: itm.text,
            id: itm.text
          }
        })
      };
    },
    cache: true
	}
});



<?php if(isset($bpm->id)){
  foreach($bpm as $k => $v){ ?>
    <?php if(isset($v) && strlen($v)){?>
    $("[name='<?=$k?>']").val('<?=$v?>');
    <?php if($k == 'a_jabatan_id' || $k == 'a_unit_id' || $k == 'a_ruangan_id'){ ?>
      $("[name='<?=$k?>']").val('<?=$v?>').select2();
    <?php } ?>
    <?php } ?>
  <?php }
} ?>

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

function addSpesifikasi(id){
  if(!window['spec_'+id]) window['spec_'+id] = 0;
  var s = `<div id="ps_${id}" class="row">
            <div class="col-md-4">
                <div class="input-group mb-3">
                    <input type="text" id="ispec_${id}" name="spec[]" class="form-control" placeholder="Ex: Warna">
                    <input type="hidden" id="icount_spec_${id}" name="count_spec[]" value="${id}" class="form-control" placeholder="Ex: Warna">
                    <button class="btn btn-danger btn-remove-spec" type="button" data-count="${id}"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-primary btn-add-spec-detail" type="button" data-count="${id}"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="col-md-8">
                <div id="psd_${id}">
                    <div id="sd_${id}_${window['spec_'+id]}" class="input-group mb-3">
                        <input type="text" id="ispec_${id}_${window['spec_'+id]}" name="spec_detail_${id}[]" class="form-control" placeholder="Ex: Merah">
                        <button class="btn btn-danger btn-remove-spec-detail" type="button" data-count="${id}" data-count-detail="${window['spec_'+id]}"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
            </div>
            <hr>
        </div>`;
  $('#panel_spesifikasi').append(s);
  window['spec_'+id]++;
  id_spec++;
}

function addSpesifikasiDetail(id){
  var s = `<div id="sd_${id}_${window['spec_'+id]}" class="input-group mb-3">
                <input type="text" id="ispec_${id}_${window['spec_'+id]}" name="spec_detail_${id}[]" class="form-control" placeholder="Ex: Merah">
                <button class="btn btn-danger btn-remove-spec-detail" type="button" data-count="${id}" data-count-detail="${window['spec_'+id]}"><i class="fa fa-minus"></i></button>
            </div>`;
  $('#psd_'+id).append(s);
  window['spec_'+id]++;
}

function removeSpesifikasi(id){
  $('#ps_'+id).slideUp();
  setTimeout(function(){
    $('#ps_'+id).remove();
  },700)
}

function removeSpesifikasiDetail(id, id_detail){
  $('#sd_'+id+'_'+id_detail).slideUp();
  setTimeout(function(){
    $('#sd_'+id+'_'+id_detail).remove();
  },700)
}

$("#btn_add_spec").on('click', function(e){
  e.preventDefault();
  addSpesifikasi(id_spec);
})

$(document).off('click', '.btn-remove-spec');
$(document).on('click', '.btn-remove-spec', function(e){
	e.preventDefault();
	var id = $(this).attr('data-count');
	removeSpesifikasi(id);
});

$(document).off('click', '.btn-add-spec-detail');
$(document).on('click', '.btn-add-spec-detail', function(e){
	e.preventDefault();
	var id = $(this).attr('data-count');
	addSpesifikasiDetail(id);
});

$(document).off('click', '.btn-remove-spec-detail');
$(document).on('click', '.btn-remove-spec-detail', function(e){
	e.preventDefault();
	var id = $(this).attr('data-count');
	var id_detail = $(this).attr('data-count-detail');
	removeSpesifikasiDetail(id, id_detail);
});

function generateCombinations(arrays, i = 0) {
  if (!arrays[i]) {
    return [];
  }
  if (i == arrays.length - 1) {
    return arrays[i];
  }
  const tmp = generateCombinations(arrays, i + 1);
  const result = [];
  for (let j = 0; j < arrays[i].length; j++) {
    for (let k = 0; k < tmp.length; k++) {
      result.push(Array.isArray(tmp[k]) ? [arrays[i][j], ...tmp[k]] : [arrays[i][j], tmp[k]]);
    }
  }
  return result;
}

function settingPrice(){
  NProgress.start();
  $("#panel_price").slideUp();
  var data = $('#ftambah').serializeArray();
  var specs = [];
  if(data){
    console.log(data,'data');
    var spec = [];
    var count_spec = -1;
    var value = '';
    $.each(data, function(k, v){
      if(v.name.includes('spec')){
        if(v.name == 'spec[]'){
          spec.push(v.value);
          count_spec++;
        } 
        if(v.name.includes('spec_detail')){
          if(!specs[count_spec]) specs[count_spec] = [];
          if(v.name.includes('qty')){
            if(v.name == 'spec_detail_from_qty[]'){
              value = ''
              value += v.value;
            }else if(v.name == 'spec_detail_to_qty[]'){
              value += v.value;
              specs[count_spec].push(value);
            }else{
              value += ` ${v.value} `;
            }
          }else{
            specs[count_spec].push(v.value);
          }
        }
      }
    });
    <!-- console.log(specs,'specs'); -->
    const res = generateCombinations(specs);
    <!-- console.log(res, 'res'); -->
    if(res.length > 1){
      var table = '<table class="table">';
      var input_spec = '';
      table += '<tr>'
      $.each(spec, function(ks, vs){
        table += `<th>${vs}</th>`
      })
      table += `<th>Harga</th>`
      table += '</tr>'
      $.each(res, function(kres, vres){
        <!-- const vspec = vres.map(str => str.replace(/"/g, '\\"')); -->
        input_spec += `<input type="hidden" name="value_spec[]" value="${vres.join(' --- ')}" class="form-control">`;
        table += `<tr>`
        if(vres){
          $.each(vres, function(kd, vd){
            table += `<td>${vd}</td>`;
          })
        }
        table += `<td style="width:20%"><input type="number" name="price_spec[]" class="form-control"></td>`
        table += `</tr>`
      })
      table += '</table>'

      $("#panel_spec").html(input_spec);
      $("#panel_price").html(table).slideDown();
    }else{
			gritter('<h4>Gagal</h4><p>Spesifikasi belum diinput</p>','warning');
    }
  }
  NProgress.done();
}

$('#btn_price_setting').on('click', function(e){
  e.preventDefault();
  var c = confirm('Apakah anda yaking? Setting harga sebelumnya akan direset')
  if(c){
    settingPrice();
  }
})

$(document).off('change', '[name="spec_detail_operator_qty[]"]');
$(document).on('change', '[name="spec_detail_operator_qty[]"]', function(e){
	e.preventDefault();
	var id = $(this).attr('data-count');
	var id_detail = $(this).attr('data-count-detail');
  var value = $(this).find('option:selected').val();
  if(value == '-'){
    $('#ispec_from_'+id+'_'+id_detail).prop('readonly', false);
  }else{
    $('#ispec_from_'+id+'_'+id_detail).prop('readonly', true);
  }
});

function addSpesifikasiQtyDetail(id){
  if(!window['spec_'+id]) window['spec_'+id] = 1;
  var s = `<div id="sd_${id}_${window['spec_'+id]}" class="input-group mb-3">
                <input type="number" id="ispec_from_${id}_${window['spec_'+id]}" name="spec_detail_from_${id}[]" class="form-control" data-count="${id}" data-count-detail="${window['spec_'+id]}" readonly placeholder="">
                <select name="spec_detail_operator_${id}[]" class="bg-dark text-white form-select input-group-text" id="ispec_detail_operator_${id}_${window['spec_'+id]}" data-count="${id}" data-count-detail="${window['spec_'+id]}">
                    <option value="<">
                        < </option>
                    <option value="-"> - </option>
                    <option value=">"> > </option>
                </select>
                <input type="number" id="ispec_to_${id}_${window['spec_'+id]}" name="spec_detail_to_${id}[]" class="form-control pe-1" data-count="${id}" data-count-detail="${window['spec_'+id]}" placeholder="">
                <button class="btn btn-danger btn-remove-spec-detail" type="button" data-count="${id}" data-count-detail="${window['spec_'+id]}"><i class="fa fa-minus"></i></button>
            </div>`;
  $('#psd_'+id).append(s);
  window['spec_'+id]++;
}

$(document).off('click', '.btn-add-spec-qty-detail');
$(document).on('click', '.btn-add-spec-qty-detail', function(e){
	e.preventDefault();
	var id = $(this).attr('data-count');
	addSpesifikasiQtyDetail(id);
});