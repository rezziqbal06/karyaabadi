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