var media_target_div = 'dgaleri_items';
var media_single = 0;
var media_name = 'image[]';
var media_caption = 0;
var media_id = '';
var folder_id = '';
var galeri_item_count = 0;
var id_produk = 0;


function priceFormat(selector){
  $("#"+selector).priceFormat({
    prefix: '',
    centsSeparator: ',',
    thousandsSeparator:'.',
    decimalSeparator:',',
    centsLimit: 0
  })
}


//fill data
var data_fill = <?=json_encode($com)?>;
$.each(data_fill,function(k,v){
	if(k == 'gambar'){
    $('#img-iegambar1').attr('src', '<?=base_url()?>'+v);
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

	var url = '<?= base_url("api_admin/order/edit/$com->id")?>';

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


priceFormat('ietotal_harga')

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


function initCariPembeli(){
  
  $("#ieb_user_id_cari").select2({
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

  $("#ieb_user_id_cari").on('change', function(e){
    var b_user_id = $(this).find('option:selected').val();
    var b_user_nama = $(this).find('option:selected').text();
    $("#ieb_user_nama").val(b_user_nama)
    $("#ieb_user_id").val(b_user_id)
  })

}

var option_produk = "";
<?php if(isset($bpm)){ ?>
  <?php foreach($bpm as $k => $v){ ?>
    option_produk += '<option value="<?=$v->id?>"><?=$v->nama?></option>'
  <?php } ?>
<?php } ?>

function addProduk(id, b_produk_id="", qty="", b_produk_id_harga="", harga=""){
  if(!window['produk_'+id]) window['produk_'+id] = 0;
  var s = `<div id="ps_${id}" class="row">
            <div class="col-md-4 mb-3">
                <label for="ib_produk_id_${id}">Nama</label>
                <select name="b_produk_id[]" id="ib_produk_id_${id}" data-count="${id}" class="form-control select2">
                    ${option_produk}
                </select>
            </div>
            <div class="col-md-2 mb-3">
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
                <input type="text" name="harga[]" id="iharga_${id}" data-count="${id}" class="form-control text-end">
            </div>
            <div class="col-md-1 mb-3">
                <label for="" class="text-white">Aksi</label>
                <button class="btn btn-danger btn-remove-produk pull-right" type="button" data-count="${id}" data-count-detail="${window['produk_'+id]}"><i class="fa fa-minus"></i></button>
            </div>
        </div>`;
  $('#panel_produk').append(s);
  $(".select2").select2();
  priceFormat('iharga_'+id)

  if(b_produk_id) $("#ib_produk_id_"+id).val(b_produk_id)
  if(qty) $("#iqty_"+id).val(qty)
  if(b_produk_id && qty){
    setSpesifikasi(id)
    setTimeout(function(){
      if(b_produk_id_harga) $("#ib_produk_id_harga_"+id).val(b_produk_id_harga).trigger('change')
    },333)
  }
  initCariPembeli()
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

function setTotal(){
  var total = 0;
  $("[name='harga[]']").map(function(){
    var harga = $(this).val()
    if(harga) total += parseInt(harga.replaceAll('.',''))
    console.log(harga)
  })
  $("#ietotal_harga").val(total).trigger('keyup')
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

initCariPembeli()

$('.datepicker').datepicker({format: 'yyyy-mm-dd'})

setTimeout(function(){
<?php if(isset($copm) && count($copm)){ ?>
  <?php foreach($copm as $kpm => $vpm){ ?>
      addProduk(id_produk, "<?=$vpm->b_produk_id?>", "<?=$vpm->qty?>", "<?=$vpm->b_produk_id_harga?>", "<?=$vpm->sub_harga?>")
  <?php } ?>
<?php } ?>
},333)