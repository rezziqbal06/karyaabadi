$("#forgot_password_form").on('submit',function(e){
	e.preventDefault();
	NProgress.start();
	$(".btn-submit").prop("disabled",true);
	var url = '<?=base_url("api_front/forgot_password/")?>?apikey=kl17ie';
	var fd = $(this).serialize();
	$.post(url,fd).done(function(dt){
		if(dt.status == 200){
				gritter("<h4>Berhasil</h4><p>Bila email telah terdaftar, anda akan menerima email berisi link untuk reset password.</p>", 'success');
        setTimeout(function(){
					NProgress.done();
				},1500)
		}else{
  		gritter("<h4>Gagal</h4><p>"+dt.message+"</p>", 'danger');
      $().btnSubmit('finished');
		}
	}).fail(function(){
		gritter("<h4>Error</h4><p>Tidak dapat reset password sekarang, coba beberapa saat lagi</p>", 'warning');
    $().btnSubmit('finished');
	})
})
