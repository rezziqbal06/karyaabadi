var drTable = {};
var ieid = '';
var sSearch = '';
var iSortCol_0 = 0;
var sSortDir_0 = 'asc';
var iDisplayStart = 0;
var iDisplayLength = 10;

App.datatables();

if(jQuery('#drTable').length>0){
  drTable = jQuery('#drTable')
  .on('preXhr.dt', function ( e, settings, data ){
    $().btnSubmit();
  }).DataTable({
    "order" : [[ 0, "desc" ]],
    "responsive" : true,
    "bProcessing" : true,
    "bServerSide" : true,
    "sAjaxSource" : "<?= base_url("api_front/akun/user/") ?>",
    "fnServerParams": function ( aoData ) {
      aoData.push(
        { "name": "is_active", "value": $("#fl_is_active").val() },
        { "name": "utype", "value": $("#fl_utype").val() }
      );
    },
    "fnServerData" : function (sSource, aoData, fnCallback, oSettings) {
      oSettings.jqXHR = $.ajax({
        dataType : 'json',
        method : 'POST',
        url : sSource,
        data : aoData
      }).done(function (response, status, headers, config) {
        $.each(aoData, function(k,v){
          switch(v.name){
            case 'sSearch':
            sSearch = v.value;
            break;
            case 'iSortCol_0':
            iSortCol_0 = v.value;
            break;
            case 'sSortDir_0':
            sSortDir_0 = v.value;
            break;
            case 'iDisplayStart':
            iDisplayStart = v.value;
            break;
            case 'iDisplayLength':
            iDisplayLength = v.value;
            break;
          }
        })

        $('#drTable > tbody').off('click', 'tr');
        $('#drTable > tbody').on('click', 'tr', function (e) {
          e.preventDefault();
          var id = $(this).find("td").html();
          ieid = id;
          $("#adetail").attr("href", "<?= base_url_front("akun/user/detail/") ?>"+ieid);
          $("#aedit").attr("href", "<?= base_url_front("akun/user/edit/") ?>"+ieid);
          $("#modal_option").modal("show");
        });

        $().btnSubmit('finished');

        fnCallback(response);
      }).fail(function (response, status, headers, config) {
        gritter("<?=DATATABLES_AJAX_FAILED_MSG?>", '<?=DATATABLES_AJAX_FAILED_CLASS?>');
        $().btnSubmit('finished');
      });
    },
  });
  $('.dataTables_filter input').attr('placeholder', 'Cari kode, nama, telp');
  $("#fl_button").on("click",function(e){
    e.preventDefault();
    drTable.ajax.reload();
  });
}


//hapus
$("#bhapus").on("click",function(e){
  e.preventDefault();
  if(ieid){
    var c = confirm('<?=AJAX_DELETE_CONFIRM_MSG?>');
    if(c){
      $().btnSubmit();
      var url = '<?= base_url('api_front/akun/user/hapus/') ?>'+ieid;
      $.get(url).done(function(response){
        if(response.status==200){
          gritter('<?=AJAX_DELETE_SUCCESS_MSG?>', '<?=AJAX_DELETE_SUCCESS_CLASS?>');
          $().btnSubmit('finished');

          drTable.ajax.reload();
          $("#modal_option").modal("hide");
          $("#modal_edit").modal("hide");
        }else{
          gritter('<h4>Gagal</h4><p>'+response.message+'</p>', '<?=AJAX_DELETE_FAILED_CLASS?>');
          $().btnSubmit('finished');
        }
      }).fail(function() {
        gritter('<?=AJAX_DELETE_ERROR_MSG?>', '<?=AJAX_DELETE_ERROR_CLASS?>');
        $().btnSubmit('finished');
      });
    }
  }
});

//get induk perusahaan
$("#fl_a_company_id_parent").select2({
  ajax: {
    method: 'post',
    url: '<?= base_url("api_front/akun/user/get_parent/") ?>',
    dataType: 'json',
    delay: 250,
    data: function (params) {
      var query = {
        keyword: params.term,
      }
      return query;
    },
    processResults: function (dt) {
      return {
        results: $.map(dt, function (itm) {
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

$("#fl_do").on("click",function(e){
  e.preventDefault();
  drTable.ajax.reload();
});


$("#download_xls").on('click', function(e){
  e.preventDefault();
  $("#fdxls").html('');
  $("<input>").attr({type: 'hidden', id: 'fdxls_sdate', name: 'sdate', value: $("#fl_sdate").val()}).appendTo('#fdxls');
  $("<input>").attr({type: 'hidden', id: 'fdxls_edate', name: 'edate', value: $("#fl_edate").val()}).appendTo('#fdxls');
  $("<input>").attr({type: 'hidden', id: 'fdxls_sSearch', name: 'sSearch', value: sSearch}).appendTo('#fdxls');
  $("<input>").attr({type: 'hidden', id: 'fdxls_iSortCol_0', name: 'iSortCol_0', value: iSortCol_0}).appendTo('#fdxls');
  $("<input>").attr({type: 'hidden', id: 'fdxls_sSortDir_0', name: 'sSortDir_0', value: sSortDir_0}).appendTo('#fdxls');
  $("<input>").attr({type: 'hidden', id: 'fdxls_iDisplayStart', name: 'iDisplayStart', value: iDisplayStart}).appendTo('#fdxls');
  $("<input>").attr({type: 'hidden', id: 'fdxls_iDisplayLength', name: 'iDisplayLength', value: iDisplayLength}).appendTo('#fdxls');
  $("#fdxls").attr('action', '<?= base_url("akun/user/download_xls") ?>');
  $('#fdxls').trigger('submit');
})
