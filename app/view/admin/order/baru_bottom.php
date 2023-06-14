var media_target_div = 'dgaleri_items';
var media_single = 0;
var media_name = 'image[]';
var media_caption = 0;
var media_id = '';
var folder_id = '';
var galeri_item_count = 0;
var id_produk = 0;

$(".select2").select2();

function convertToSlug(Text) {
  	return Text.toLowerCase()
             .replace(/ /g, '-')
             .replace(/[^\w-]+/g, '');
}

function priceFormat(selector){
  $("#"+selector).priceFormat({
    prefix: '',
    centsSeparator: ',',
    thousandsSeparator:'.',
    decimalSeparator:',',
    centsLimit: 0
  })
}

//submit form
$("#ftambah").on("submit",function(e){
	e.preventDefault();
	NProgress.start();
	$('.btn-submit').prop('disabled',true);
	$('.icon-submit').addClass('fa-circle-o-notch fa-spin');

	var fd = new FormData($(this)[0]);

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
});

$("#inegara").on("change",function(e){
	e.preventDefault();
	$("#iprovinsi").trigger("change");
});

function initCariPembeli(){
  
    $("#ib_user_id_cari").select2({
      ajax: {
        method: 'post',
        url: '<?=base_url("api_admin/akun/user/cari")?>',
        dataType: 'json',
        delay: 250,
        data: function (params) {
          var query = {
            keyword: params.term
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

    $("#ib_user_id_cari").on('change', function(e){
      var b_user_id = $(this).find('option:selected').val();
      var b_user_nama = $(this).find('option:selected').text();
      $("#ib_user_nama").val(b_user_nama)
      $("#ib_user_id").val(b_user_id)
    })

}


priceFormat('itotal_harga')

var option_produk = "";
<?php if(isset($bpm)){ ?>
  <?php foreach($bpm as $k => $v){ ?>
    option_produk += '<option value="<?=$v->id?>"><?=$v->nama?></option>'
  <?php } ?>
<?php } ?>

function addProduk(id, value="", value_detail=""){
  if(!window['produk_'+id]) window['produk_'+id] = 0;
  var s = `<div id="ps_${id}" class="row">
            <div class="col-md-3 mb-3">
                <label for="ib_produk_id_${id}">Nama</label>
                <select name="b_produk_id[]" id="ib_produk_id_${id}" data-count="${id}" class="form-control select2">
                    ${option_produk}
                </select>
            </div>
            <div class="col-md-1 mb-3">
                <label for="iqty_${id}" data-count="${id}">Qty</label>
                <input type="number" name="qty[]" id="iqty_${id}" data-count="${id}" class="form-control">
            </div>
            <div class="col-md-3 mb-3">
                <label for="ib_produk_id_harga_${id}" data-count="${id}">Spesifikasi</label>
                <select name="b_produk_id_harga[]" id="ib_produk_id_harga_${id}" data-count="${id}" class="form-control select2">
                   <option>-- pilih nama & qty terlebih dahulu --</option>
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <label for="iharga_${id}" data-count="${id}">Harga</label>
                <input type="text" name="harga[]" id="iharga_${id}" data-count="${id}" class="form-control">
            </div>
            <div class="col-md-2 mb-3">
                <label for="istatus_${id}" data-count="${id}">Status</label>
                <select name="status[]" id="istatus_${id}" data-count="${id}" class="form-control">
                   <option value="pending">pending</option>
                   <option value="progress">progress</option>
                   <option value="done">done</option>
                </select>
            </div>
            <div class="col-md-1 mb-3">
                <label for="" class="text-white">Aksi</label>
                <button class="btn btn-danger btn-remove-produk pull-right" type="button" data-count="${id}" data-count-detail="${window['produk_'+id]}"><i class="fa fa-minus"></i></button>
            </div>
        </div>`;
  $('#panel_produk').append(s);
  $(".select2").select2();

  initCariPembeli()
  priceFormat('iharga_'+id)
  window['produk_'+id]++;
  id_produk++;
}


function removeProduk(id){
  $('#ps_'+id).slideUp();
  setTimeout(function(){
    $('#ps_'+id).remove();
    setTotal()
  },700)
}


function setSpesifikasi(id){
  var value = $("#ib_produk_id_"+id).find('option:selected').val();
  var qty = $("#iqty_"+id).val();
  if(value && qty){
    $.get(`<?=base_url("api_admin/pengaturan/produk/get_spesifikasi/")?>${value}/${qty}`).done(function(dt){
      if(dt.data.spesifikasi){
        var option = ""
        $.each(dt.data.spesifikasi, function(k,v){
          option += `<option value="${v.id}" data-harga="${v.harga}">${v.option}</option>`
        })
        $("#ib_produk_id_harga_"+id).html(option).trigger('change').trigger('keyup');
      }
    })
  }
}

function setTotal(){
  var total = 0;
  $("[name='harga[]']").map(function(){
    var harga = $(this).val()
    if(harga) total += parseInt(harga.replaceAll('.',''))
    console.log(harga)
  })
  $("#itotal_harga").val(total).trigger('keyup')
}

$("#btn_add_produk").on('click', function(e){
  e.preventDefault();
  addProduk(id_produk);
})

$(document).off('click', '.btn-remove-produk');
$(document).on('click', '.btn-remove-produk', function(e){
	e.preventDefault();
	var id = $(this).attr('data-count');
	removeProduk(id);
});

$(document).off('change', '[name="b_produk_id[]"]');
$(document).on('change', '[name="b_produk_id[]"]', function(e){
	e.preventDefault();
	var id = $(this).attr('data-count');
  setSpesifikasi(id)
});

$(document).off('input', '[name="qty[]"]');
$(document).on('input', '[name="qty[]"]', function(e){
	e.preventDefault();
	var id = $(this).attr('data-count');
  setSpesifikasi(id)
});

$(document).off('change', '[name="b_produk_id_harga[]"]');
$(document).on('change', '[name="b_produk_id_harga[]"]', function(e){
	e.preventDefault();
	var id = $(this).attr('data-count');
  var qty = $("#iqty_"+id).val()
	var harga = $(this).find("option:selected").attr('data-harga');
	var value = $(this).find("option:selected").val();
  $("#iharga_"+id).val(parseInt(harga)*qty).trigger('keyup');
  setTotal()
});

$(document).off('click', '.btn-remove-produk-detail');
$(document).on('click', '.btn-remove-produk-detail', function(e){
	e.preventDefault();
	var id = $(this).attr('data-count');
	var id_detail = $(this).attr('data-count-detail');
	removeProdukDetail(id, id_detail);
});


$(document).off('click', '.btn-add-produk-qty-detail');
$(document).on('click', '.btn-add-produk-qty-detail', function(e){
	e.preventDefault();
	var id = $(this).attr('data-count');
	addProdukQtyDetail(id);
});

$(document).off('input', '.input-produk');
$(document).on('input', '.input-produk', function(e){
	e.preventDefault();
  var id = $(this).attr('data-count');
  var id_detail = $(this).attr('data-count-detail');
  setTimeout(function(){
    
    if(id == 'qty'){
      var dari = $("#iproduk_detail_from_"+id+"_"+id_detail).val();
      var opr = $("#iproduk_detail_operator_"+id+"_"+id_detail).val();
      var ke = $("#iproduk_detail_to_"+id+"_"+id_detail).val();
      $("#icheck_produk_detail_"+id+'_'+id_detail).val(`${dari} ${opr} ${ke}`);
      console.log(`${dari} ${opr} ${ke}`, 'check produk')
    }else{
      var value = $("#iproduk_"+id+"_"+id_detail).val();
      $("#icheck_produk_detail_"+id+'_'+id_detail).val(`${value}`);
      console.log("#iproduk_"+id+"_"+id_detail, value,'check produk')
    }
  },555)
});

$(document).off('input', '.produk-price-filter');
$(document).on('input', '.produk-price-filter', function(e){
	e.preventDefault();
  var id = $(this).attr('data-count');
  if($(this).is(':checked')){
    $("#price_produk_"+id).addClass('price_checked')
  }else{
    $("#price_produk_"+id).removeClass('price_checked')
  }
});

$(document).off('input', '.check-produk-filter');
$(document).on('input', '.check-produk-filter', function(e){
	e.preventDefault();
  var id = $(this).attr('data-count');
  var values = $(this).val();
  var checked = $(this).is(':checked');
  $("[data-value*='"+values+"']").prop('checked', checked).trigger('input');
});

initCariPembeli()


$('.datepicker').datepicker({format: 'yyyy-mm-dd'})

addProduk(id_produk);