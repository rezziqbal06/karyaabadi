$(document).off('click', '.btn-asesmen')
$(document).on('click', '.btn-asesmen', function(e){
  e.preventDefault();
  var url = $(this).attr('href');
  // if(!url.includes('audit-hand-hygiene')){
  //  gritter('Masih dalam pengembangan', 'warning');
  //  return;
  // }

  
  window.location.href = url;
})