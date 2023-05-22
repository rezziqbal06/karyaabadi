function checkPwd() {
  $("#spassword").hide();
  $("#srepassword").hide();
  var str = $("#ipassword").val();
  if (str.length < 6) {
    $("#spassword").slideDown();
    $("#spassword").html("Minimal panjang 6 karakter");
    return("too_short");
  } else if (str.length > 31) {
    $("#spassword").slideDown();
    $("#spassword").html("Password terlalu panjang!");
    return("too_long");
  } else if (str.search(/[a-zA-Z]/) == -1) {
    $("#spassword").slideDown();
    $("#spassword").html("No letter, please add some letters");
    return("no_letter");
  } else if (str.search(/[^a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\_\+\.\,\;\:]/) != -1) {
    $("#spassword").slideDown();
    $("#spassword").html("Bad characters supplied, please change!");
    return("bad_char");
  }
  return("ok");
}
function gritter(judul,isi){
  $.growl({ title: judul, message: isi });
}
$("#ipassword").on("blur",function(e){
  e.preventDefault();
  checkPwd();
});
$("#irepassword").on("blur",function(e){
  e.preventDefault();
  $("#srepassword").hide();
  var p1 = $("#ipassword").val();
  var p2 = $("#irepassword").val();
  if(p1 != p2){
    $("#srepassword").html("Password confirmation does not match with supplied password");
    $("#srepassword").slideDown();
    //$("#irepassword").focus();
  }
});
$("#fpassword").on("submit",function(e){
  $("#spassword").hide();
  $("#srepassword").hide();
  $("#irepassword").focus();
  setTimeout(function(){
    var p1 = $("#ipassword").val();
    var p2 = $("#irepassword").val();
    if(checkPwd() != 'ok'){
      return false;
    }
    if(p1 != p2){
      console.log("password doesnt match");
      $("#srepassword").html("Konfirmasi Password tidak cocok dengan password yang dimasukan");
      $("#srepassword").slideDown();
      //$("#irepassword").focus();
      return false;
    }else{
      console.log("password matched!");
      return false;
    }
  },333);

});
//gritter("Test",'Wololoooo');
