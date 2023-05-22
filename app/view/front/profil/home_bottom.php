$("#btn-edit-profile").on("click",function(e){
		e.preventDefault();
		$("#modal_option").modal("show");
});

$("#btn-logout").on("click",function(e){
		e.preventDefault();
    $("#modal_logout").modal("show");
});

$("#btn_close_modal_logout").on("click",function(e){
		e.preventDefault();
		$("#modal_logout").modal("hide");
});

$("#btn_close_modal").on("click",function(e){
		e.preventDefault();
		$("#modal_option").modal("hide");
});

$("#editprofil").on("click",function(e){
		e.preventDefault();
		$("#modal_option").modal("hide");
		$("#modal_edit_profil").modal("show");
});

if (window.matchMedia('(max-width:600px)').matches) {
        $("#edit-button").removeClass("col-md-6");
        $("#edit-button").removeClass("text-end");
        $("#edit-button").addClass("text-center");
        $("#edit-button").addClass("mt-4");
        $("#edit-button").addClass("col-md-12");
        $("#edit-button").addClass("flex-fill");
        $(".info-asesmen").addClass("m-2");
      }else{
        $("#edit-button").addClass("col-md-6");
        $("#edit-button").removeClass("col-md-12");
        $("#edit-button").removeClass("flex-fill");
        $(".info-asesmen").removeClass("m-2");
    }

$(".select2").select2();

$("#changepass").on("click",function(e){
		e.preventDefault();
		$("#modal_option").modal("hide");
		$("#modal_edit_password").modal("show");
});

const chartCtx = $("#asesmenChart");

const data = {
  labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
  datasets: [{
    label: 'Looping tension',
    data: [65, 59, 80, 81, 26, 55, 40],
    fill: false,
    borderColor: 'rgb(75, 192, 192)',
  }]
};

const config = {
  type: 'line',
  data: data,
  options: {
    animations: {
      tension: {
        duration: 1000,
        easing: 'linear',
        from: 1,
        to: 0,
        loop: true
      }
    },
    scales: {
      y: { // defining min and max so hiding the dataset does not change scale range
        min: 0,
        max: 100
      }
    }
  }
};

new Chart(chartCtx, config);


// edit profil
$("#fedit-profil").on("submit",function(e){
	e.preventDefault();
	NProgress.start();
	$('.btn-submit').prop('disabled',true);
	$('.icon-submit').addClass('fa-circle-o-notch fa-spin');

	var fd = new FormData($(this)[0]);
	var url = '<?=base_url("api_front/akun/user/editProfil/")?>';

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
					window.location = '<?=base_url('profil/')?>';
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

// change password
$("#fchange-password").on("submit",function(e){
	e.preventDefault();
	NProgress.start();
	$('.btn-submit').prop('disabled',true);
	$('.icon-submit').addClass('fa-circle-o-notch fa-spin');

	var fd = new FormData($(this)[0]);
	var url = '<?=base_url("api_front/akun/user/changePass/")?>';

  let newPass = $("#new-pass").val();
  let confirmNewPass = $("#confirm-new-pass").val();

  if(newPass != confirmNewPass){
    gritter('<h4>Gagal</h4><p>Password tidak cocok</p>','danger');
  }else{
    $.ajax({
      type: $(this).attr('method'),
      url: url,
      data: fd,
      processData: false,
      contentType: false,
      success: function(respon){
        if(respon.status==200){
          gritter('<h4>Sukses</h4><p>Password berhasil diubah</p>','success');
          setTimeout(function(){
            window.location = '<?=base_url('profil/')?>';
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

  }

});