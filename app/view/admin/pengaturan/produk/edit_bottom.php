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


//fill data
var data_fill = <?=json_encode($bpm)?>;
$.each(data_fill,function(k,v){
	if(k == 'gambar'){
    $('#img-iegambar1').attr('src', '<?=base_url()?>'+v);
  }else{
    $("#ie"+k).val(v);
  }
});

var data_fill_gambar = <?=json_encode($bpgm)?>;
if(data_fill_gambar){
  $.each(data_fill_gambar, function(k,v){
    $('#img-iegambar'+v.ke).attr('src', '<?=base_url()?>'+v.gambar);
    if(v.is_cover == 1){
      $("[name='is_cover'][value='"+v.ke+"']").prop('checked', true)
    } 
  })
}

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

function addSpesifikasi(id, value="", value_detail=""){
  if(!window['spec_'+id]) window['spec_'+id] = 0;
  var s = `<div id="ps_${id}" class="row">
            <div class="col-md-4">
                <div class="input-group mb-3">
                    <input type="text" id="ispec_${id}" name="spec[]" class="form-control" value="${value}" placeholder="Ex: Warna">
                    <input type="hidden" id="icount_spec_${id}" name="count_spec[]" value="${id}" class="form-control" placeholder="Ex: Warna">
                    <button class="btn btn-danger btn-remove-spec" type="button" data-count="${id}"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-primary btn-add-spec-detail" type="button" data-count="${id}"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="col-md-8">
                <div id="psd_${id}">
                    <div id="sd_${id}_${window['spec_'+id]}" class="input-group mb-3">
                        <input type="text" id="ispec_${id}_${window['spec_'+id]}" name="spec_detail_${id}[]" class="form-control input-spec" value="${value_detail}" data-count="${id}" data-count-detail="${window['spec_'+id]}" placeholder="Ex: Merah">
                        <button class="btn btn-danger btn-remove-spec-detail" type="button" data-count="${id}" data-count-detail="${window['spec_'+id]}"><i class="fa fa-minus"></i></button>
                        <div class="input-group-text bg-light">
                          <input type="checkbox" id="icheck_spec_detail_${id}_${window['spec_'+id]}" data-count="${id}" data-count-detail="${window['spec_'+id]}" value="${value_detail}" class="check-spec-filter">
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>`;
  $('#panel_spesifikasi').append(s);
  window['spec_'+id]++;
  id_spec++;
}

function addSpesifikasiDetail(id, value=""){
  var s = `<div id="sd_${id}_${window['spec_'+id]}" class="input-group mb-3">
                <input type="text" id="ispec_${id}_${window['spec_'+id]}" name="spec_detail_${id}[]" class="form-control input-spec" value="${value}" data-count="${id}" data-count-detail="${window['spec_'+id]}" placeholder="Ex: Merah">
                <button class="btn btn-danger btn-remove-spec-detail" type="button" data-count="${id}" data-count-detail="${window['spec_'+id]}"><i class="fa fa-minus"></i></button>
                <div class="input-group-text bg-light">
                  <input type="checkbox" id="icheck_spec_detail_${id}_${window['spec_'+id]}" data-count="${id}" data-count-detail="${window['spec_'+id]}" value="${value}" class="check-spec-filter">
                </div>
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
  var data = $('#fedit').serializeArray();
  var specs = [];
  if(data){
    <!-- console.log(data,'data'); -->
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
      var table = '<table class="table table-bordered table-striped">';
      var input_spec = '';
      table += '<tr>'
      $.each(spec, function(ks, vs){
        table += `<th>${vs}</th>`
      })
      table += `<th><input type="number" name="" id="input_price_filter" class="form-control" placeholder="Harga"></th>`
      table += `<th class="text-center align-middle"><input type="checkbox" name="" id="check_price_filter" class=""></th>`
      table += '</tr>'
      $.each(res, function(kres, vres){
        <!-- const vspec = vres.map(str => str.replace(/"/g, '\\"')); -->
        input_spec += `<input type="hidden" name="value_spec[]" value="${vres.join(' --- ')}" class="form-control">`;
        table += `<tr>`
        var values = '';
        if(vres){
          $.each(vres, function(kd, vd){
            table += `<td>${vd}</td>`;
            values += `${vd} | `;
          })
        }
        table += `<td style="width:20%"><input type="number" name="price_spec[]" id="price_spec_${kres}" data-value="${values}" data-count="${kres}" class="form-control"></td>`
        table += `<td style="width:5%" class="text-center align-middle"><input type="checkbox" name="" id="check_spec_${kres}" data-value="${values}" data-count="${kres}" class="spec-price-filter"></td>`
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

  $("#input_price_filter").on('input', function(e){
    e.preventDefault();
    var values = $(this).val();
    if(values){
      $('.price_checked').val(values);
    }
  })

  $("#check_price_filter").on('change', function(e){
    e.preventDefault();
    var checked = $(this).is(':checked');
    $('.spec-price-filter').prop('checked', checked).trigger('input')
  })
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
    $('#ispec_detail_from_'+id+'_'+id_detail).prop('readonly', false);
  }else{
    $('#ispec_detail_from_'+id+'_'+id_detail).val('').prop('readonly', true);
  }
});

function addSpesifikasiQtyDetail(id, dari="", opr="", ke=""){
  if(!window['spec_'+id]) window['spec_'+id] = 1;
  var s = `<div id="sd_${id}_${window['spec_'+id]}" class="input-group mb-3">
                <input type="number" id="ispec_detail_from_${id}_${window['spec_'+id]}" name="spec_detail_from_${id}[]" class="form-control input-spec" data-count="${id}" data-count-detail="${window['spec_'+id]}" readonly placeholder="">
                <select name="spec_detail_operator_${id}[]" class="bg-dark text-white form-select input-group-text input-spec" id="ispec_detail_operator_${id}_${window['spec_'+id]}" data-count="${id}" data-count-detail="${window['spec_'+id]}">
                    <option value="<">
                        < </option>
                    <option value="-"> - </option>
                    <option value=">"> > </option>
                </select>
                <input type="number" id="ispec_detail_to_${id}_${window['spec_'+id]}" name="spec_detail_to_${id}[]" class="form-control pe-1 input-spec" data-count="${id}" data-count-detail="${window['spec_'+id]}" placeholder="">
                <button class="btn btn-danger btn-remove-spec-detail" type="button" data-count="${id}" data-count-detail="${window['spec_'+id]}"><i class="fa fa-minus"></i></button>
                <div class="input-group-text bg-light">
                  <input type="checkbox" id="icheck_spec_detail_${id}_${window['spec_'+id]}" data-count="${id}" data-count-detail="${window['spec_'+id]}" value="" class="check-spec-filter">
                </div>
            </div>`;
  $('#psd_'+id).append(s);
  $("#ispec_detail_from_"+id+"_"+window['spec_'+id]).val(dari);
  $("#ispec_detail_operator_"+id+"_"+window['spec_'+id]).val(opr);
  $("#ispec_detail_to_"+id+"_"+window['spec_'+id]).val(ke);
  $("#icheck_spec_detail_"+id+"_"+window['spec_'+id]).val(dari+' '+opr+' '+ke);
  if(opr == '-') $("#ispec_detail_from_"+id+"_"+window['spec_'+id]).prop('readonly', false);
  window['spec_'+id]++;
}

$(document).off('click', '.btn-add-spec-qty-detail');
$(document).on('click', '.btn-add-spec-qty-detail', function(e){
	e.preventDefault();
	var id = $(this).attr('data-count');
	addSpesifikasiQtyDetail(id);
});

<?php if(isset($bpm->spesifikasi) && count($bpm->spesifikasi)){ ?>
  <?php foreach($bpm->spesifikasi as $k => $v){ ?>
    var ibpm = id_spec;
    <?php foreach($v as $k2 => $v2){ ?>
        <?php if($k2 == 0){ ?>
          addSpesifikasi(id_spec, '<?=$k?>', '<?=$v2?>');
        <?php }else{ ?>
          addSpesifikasiDetail(ibpm, '<?=$v2?>');
        <?php } ?>
    <?php } ?>
  <?php } ?>
<?php } ?>

<?php if(isset($bpm->qty) && count($bpm->qty)){ ?>
  <?php foreach($bpm->qty as $kq => $vq){ ?>
    <?php if($kq == 0){ ?>
      $("#ispec_detail_from_qty_0").val('<?=$vq['dari_qty']?>');
      $("#ispec_detail_operator_qty_0").val('<?=$vq['opr']?>');
      $("#ispec_detail_to_qty_0").val('<?=$vq['ke_qty']?>');
      $("#icheck_spec_detail_qty_0").val('<?=$vq['dari_qty']?>'+' '+'<?=$vq['opr']?>'+' '+'<?=$vq['ke_qty']?>');
      <?php if($vq['opr'] == '-') : ?> $("#ispec_detail_from_qty_0").prop('readonly', false); <?php endif ?>
    <?php }else{ ?>
      addSpesifikasiQtyDetail('qty', '<?=$vq['dari_qty']?>', '<?=$vq['opr']?>', '<?=$vq['ke_qty']?>');
    <?php } ?>
  <?php } ?>

  setTimeout(function(){
    settingPrice();
  },333)
<?php } ?>

setTimeout(function(){
<?php if(isset($bphm) && count($bphm)){ ?>
  <?php foreach($bphm as $khm => $vhm){ ?>
      var harga = '<?=$vhm->harga?>'.replaceAll('.00','')
      $("#price_spec_<?=$khm?>").val(harga)
  <?php } ?>
<?php } ?>
},333)

$(document).off('input', '.input-spec');
$(document).on('input', '.input-spec', function(e){
	e.preventDefault();
  var id = $(this).attr('data-count');
  var id_detail = $(this).attr('data-count-detail');
  setTimeout(function(){
    
    if(id == 'qty'){
      var dari = $("#ispec_detail_from_"+id+"_"+id_detail).val();
      var opr = $("#ispec_detail_operator_"+id+"_"+id_detail).val();
      var ke = $("#ispec_detail_to_"+id+"_"+id_detail).val();
      $("#icheck_spec_detail_"+id+'_'+id_detail).val(`${dari} ${opr} ${ke}`);
      console.log(`${dari} ${opr} ${ke}`, 'check spec')
    }else{
      var value = $("#ispec_"+id+"_"+id_detail).val();
      $("#icheck_spec_detail_"+id+'_'+id_detail).val(`${value}`);
      console.log("#ispec_"+id+"_"+id_detail, value,'check spec')
    }
  },555)
});

$(document).off('input', '.spec-price-filter');
$(document).on('input', '.spec-price-filter', function(e){
	e.preventDefault();
  var id = $(this).attr('data-count');
  if($(this).is(':checked')){
    $("#price_spec_"+id).addClass('price_checked')
  }else{
    $("#price_spec_"+id).removeClass('price_checked')
  }
});

$(document).off('input', '.check-spec-filter');
$(document).on('input', '.check-spec-filter', function(e){
	e.preventDefault();
  var id = $(this).attr('data-count');
  var values = $(this).val();
  var checked = $(this).is(':checked');
  $("[data-value*='"+values+"']").prop('checked', checked).trigger('input');
});