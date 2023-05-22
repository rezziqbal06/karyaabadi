
$("#flupa").on('submit',function(e){
	e.preventDefault();
	NProgress.start();
	$(".btn-submit").prop("disabled",true);
	var url = '<?=base_url("api_front/lupa/")?>?apikey=kl17ie';
	var fd = $(this).serialize();
	$.post(url,fd).done(function(dt){
		if(dt.status == 200){
				showToast('success',"<h4>Berhasil</h4>","<p>Bila email telah terdaftar, anda akan menerima email berisi link untuk reset password.</p>");
				setTimeout(function(){
					NProgress.done();
				},1500)
		}else{
			NProgress.done();
			$(".btn-submit").prop("disabled",false);
			$(".btn-submit").removeProp("disabled");
				showToast("warning","Gagal","<p>"+dt.message+"</p>");
		}
	}).fail(function(){
		NProgress.done();
		$(".btn-submit").prop("disabled",false);
		$(".btn-submit").removeProp("disabled");
		showToast('danger',"Error","<p>Coba beberapa saat lagi</p>");
	})
})
