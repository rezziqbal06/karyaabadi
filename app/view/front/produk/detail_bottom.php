NProgress.start();

setTimeout(function(){
	NProgress.done();
},500)

$(document).off('click', '.btn-kategori');
$(document).on('click', '.btn-kategori', function(e){
	e.preventDefault();
	var kategori_id = $(this).attr('data-id');
	$(".btn-kategori").removeClass("text-bold text-primary");
	$(this).addClass("text-bold text-primary");
	$.get('<?=base_url("api_front/produk/?a_kategori_id=")?>'+kategori_id).done(function(dt){
		if(dt.status == 200){
			var s = ""
			$.each(dt.data, function(k,v){
			s += `	<div class="col-6 col-md-2 p-3 kartu-produk" data-kategori-id="${v.a_kategori_id}">
					<a href="<?= base_url("produk/") ?>${v.slug}" class="btn-kategori" data-id="${v.id}" data-kategori-id="${v.a_kategori_id}" alt="${v.nama}">
						<div class="kartu-gambar-produk">
							<img src="<?= base_url("") ?>${v.gambar}" alt="${v.nama}" aria-describedby="${v.nama}" class="img-fluid">
						</div>
						<p class="text-center mt-3"><b>${v.nama}</b></p>
					</a>
				</div>`
			})
			$("#panel_produk").slideUp();
			setTimeout(function(){
				$("#panel_produk").html(s).slideDown();
			},333)
		}else{

		}
	})
});

$('#banner').slick({
    autoplay: true,
    autoplaySpeed: 2000,
    fade: true,
    cssEase: 'linear',
	dots: true, // Enable dots (indicator bullets)
	appendDots: '.carousel-indicators ul', // Append dots to the specified element
    customPaging : function(slider, i) {
      // Custom function to create the dot indicators
      return '<button class="dot"></button>';
    }
  });

  
$('#kustomer').slick({
    autoplay: true,
    autoplaySpeed: 2000,
    fade: false,
    cssEase: 'linear',
	slidesToShow: 4,
  slidesToScroll: 4,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 5,
        slidesToScroll: 1,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
  });



  $("#tambah").on('click', function(e){
    e.preventDefault();
    var qty = $("[name='qty']").val()
    qty = parseInt(qty) + 1
    $("[name='qty']").val(qty)
  })

  $("#kurang").on('click', function(e){
    e.preventDefault();
    var qty = $("[name='qty']").val()
    qty = parseInt(qty) - 1
    if(qty == 0){
      return false
    }
    $("[name='qty']").val(qty)
  })

  
$("#fhitung").on("submit",function(e){
	e.preventDefault();
  NProgress.start();
	var fd = new FormData($(this)[0]);

	var url = '<?= base_url("api_front/produk/hitung_harga/")?>';

	$.ajax({
		type: $(this).attr('method'),
		url: url,
		data: fd,
		processData: false,
		contentType: false,
		success: function(respon){
      NProgress.done();
			if(respon.status==200){
          if(respon.data){
            $("#harga_peritem").text("Rp. "+respon.data.harga)
            $("#harga_total").text("Rp. "+respon.data.total)
            $("#pesan").prop('disabled', false)
          }
			}else{
				gritter('<h4>Gagal</h4><p>'+respon.message+'</p>','warning');
			}
		},
		error:function(){
      NProgress.done();
			setTimeout(function(){
				gritter('<h4>Error</h4><p>Tidak dapat menambah data, silahkan coba beberapa saat lagi</p>','danger');
			}, 666);
			return false;
		}
	});
});

$(document).off('click', '.image-selected');
$(document).on('click', '.image-selected', function(e){
	e.preventDefault();
	var count = $(this).attr('data-count');
	$(".gambar-item").removeClass('selected');
	$("#gambar-item-"+count).addClass('selected');
  var src = $("#gambar-item-"+count).attr('src')
  $("#display-gambar").attr('src',src)
});

function pesanProduk(){
  var url = '<?=base_url("produk/").$produk->slug?>';
  var specs = '';
  var qty = $("[name='qty']").val();
  $("[name='specs[]']").map(function(){
    specs += `- ${$(this).val()}\n`
  })
  var harga_peritem = $("#harga_peritem").text()
  var harga_total = $("#harga_total").text()

  var nama = $("#inama").val();
  var alamat = $("#ialamat").val();

  var text = '';
  text = `Pesan <?=$produk->nama?>, dengan spesifikasi:\n${specs}\nqty: ${qty} pcs\nharga: ${harga_peritem}\ntotal: ${harga_total}`;
  text += `\n\nnama: ${nama}`
  text += `\nalamat: ${alamat}`
  console.log(text);
  text = encodeURIComponent(text);
  var waLink = 'https://wa.me/<?= $this->config->semevar->site_wa ?>'+"/?text="+text;
  window.open(waLink);
}

$("#pesan").on('click', function(e){
  e.preventDefault();
  $("#modal_pesan").modal('show');
})

$("#fpesan").on('submit', function(e){
  e.preventDefault();
  pesanProduk()
})

