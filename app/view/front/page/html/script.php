/* function chat refresh */
$('.chat-talk').hide();

/* Demo chat functionality (in sidebar) */
var chatUi = function() {
    var chatUsers       = $('.chat-users');
    var chatTalk        = $('.chat-talk');
    var chatMessages    = $('.chat-talk-messages');
    var chatInput       = $('#sidebar-chat-message');
    var chatMsg         = '';

    // Initialize scrolling on chat talk list
    chatMessages.slimScroll({ height: 210, color: '#fff', size: '3px', position: 'left', touchScrollStep: 100 });

    // If a chat user is clicked show the chat talk
    $('a', chatUsers).click(function(){
        to_user_id = $(this).attr('data-to-id');
        to_user_nama = $(this).attr('data-to-nama');

        //set active for loop
        chat_active = 1;
        update_chat();

        $("#icto_user_id").val(to_user_id);
        $("#icto_user_nama").val(to_user_nama);

        $("#to_user_nama").html(to_user_nama);

        var fd = {};
        fd.to_user_id = to_user_id;
        fd.last_pesan_id = 0;

        $.post('<?=base_url('api_admin/chat/get/'); ?>',fd).done(function(dt){
          if(dt.status == 200){
            var h = '';

            $.each(dt.data,function(key,val){
              if(iterator%7==1){
                h += '<li class="text-center"><small>'+val.cdate+'</small></li>';
              }
              if(val.from_user_id == from_user_id){
                h += '<li class="chat-talk-msg chat-talk-msg-highlight themed-border animation-slideLeft">'+val.pesan+'</li>';
              }else{
                h += '<li class="chat-talk-msg animation-slideRight">'+val.pesan+'</li>';
              }
              last_pesan_id = val.id;
              iterator++;
            });
            $("#chat_conversation_list").html(h);
          }else{
            $("#global_message_danger_text").html('Tidak dapat mengambil chat list');
            $("#global_message_danger").show();
          }
          chatUsers.slideUp();
          chatTalk.slideDown();
          chatMessages.slimScroll({ scrollTo: chatMessages[0].scrollHeight + 'px' });
          chatInput.focus();

        });


        return false;
    });

    // If chat talk close button is clicked show the chat user list
    $('#chat-talk-close-btn').click(function(){
        chatTalk.slideUp();
        chatUsers.slideDown();
        chat_active = 0;
        $("#chat_conversation_list").html('');
        return false;
    });

    // When the chat message form is submitted
    $('#sidebar-chat-form').submit(function(e){
        //formdata
        e.preventDefault();
        var fd = new FormData($(this)[0]);
        var url = '<?=base_url('api_admin/chat/send/') ?>';

        // Get text from message input
        chatMsg = chatInput.val();

        // If the user typed a message
        if (chatMsg) {
          // Add it to the message list

          $.ajax({
            type: 'POST',
            url: url,
            data: fd,
            processData: false,
            contentType: false,
            success: function(respon){
              if(respon.status == 200){
                //chatMessages.append('<li class="chat-talk-msg chat-talk-msg-highlight themed-border animation-slideLeft">' + $('<div />').text(chatMsg).html() + '</li>');

                // Scroll the message list to the bottom
                //chatMessages.slimScroll({ scrollTo: chatMessages[0].scrollHeight + 'px' });
              }else{
                $("#global_message_danger_text").html('Pesan tidak terkirim');
                $("#global_message_danger").show();
              }
              // Reset the message input
              chatInput.val('');
              update_chat();
            },
            error:function(){
              $("#global_message_danger_text").html('Pesan tidak terkirim');
              $("#global_message_danger").show();
            }
          });
        }

        // Don't submit the message form
        e.preventDefault();
    });
};
$.get("<?=base_url('api_admin/chat/'); ?>").done(function(dt){
  if(dt.status == 200){
    var user = dt.data.user;
    from_user_id = user.id;
    from_user_nama = user.nama;
    var h ='';
    var cnt = 0;
    $.each(dt.data.users,function(key,val){
      if(val.id == from_user_id) return true;
      if(val.is_online){
        h += '<li><a href="javascript:void(0)" class="chat-user-online" title="'+val.nama+'" data-from-id="'+from_user_id+'" data-from-nama="'+from_user_nama+'" data-to-id="'+val.id+'" data-to-nama="'+val.nama+'"><span></span><img src="<?=$this->cdn_url('skin/admin/')?>img/placeholders/avatars/avatar12.jpg" alt="'+val.nama+'" class="img-circle"></a></li>';
      }else{
        h += '<li><a href="javascript:void(0)" class="chat-user-busy" title="'+val.nama+'" data-from-id="'+from_user_id+'" data-from-nama="'+from_user_nama+'" data-to-id="'+val.id+'" data-to-nama="'+val.nama+'"><span></span><img src="<?=$this->cdn_url('skin/admin/')?>img/placeholders/avatars/avatar12.jpg" alt="'+val.nama+'" class="img-circle"></a></li>';
      }
      cnt++;
    });
    $("#chat-online-count").html(cnt);
    $("#chat_user_list").html(h);
    chatUi();
  }else{

  }
}).fail(function(){
  $("#global_message_danger_text").html('Chat system currently unavailable...');
  $("#global_message_danger").show();
});

function update_chat(){

  if(chat_active == 1 || chat_active == "1"){
    var chatUsers       = $('.chat-users');
    var chatTalk        = $('.chat-talk');
    var chatMessages    = $('.chat-talk-messages');
    var chatInput       = $('#sidebar-chat-message');
    var chatMsg         = '';

    //console.log('update_chat: executed');
    var fd = {};
    fd.to_user_id = to_user_id;
    fd.last_pesan_id = last_pesan_id;
    if(to_user_id.length>0){
      $.post('<?=base_url('api_admin/chat/get/'); ?>',fd).done(function(dt){
        if(dt.status == 200){
          var h = '';
          $.each(dt.data,function(key,val){
            if(iterator%7==1){
              h += '<li class="text-center"><small>'+val.cdate+'</small></li>';
            }
            if(val.from_user_id == from_user_id){
              h += '<li class="chat-talk-msg chat-talk-msg-highlight themed-border animation-slideLeft">'+val.pesan+'</li>';
            }else{
              h += '<li class="chat-talk-msg animation-slideRight">'+val.pesan+'</li>';
            }
            last_pesan_id = val.id;
            iterator++;
          });
          if(last_pesan_id == "0" || last_pesan_id == 0){
            $("#chat_conversation_list").html(h);
          }else{
            $("#chat_conversation_list").append(h);
          }
        }else{
          //$("#global_message_danger_text").html('Tidak dapat mengambil chat list');
          //$("#global_message_danger").show();
        }
        chatUsers.slideUp();
        chatTalk.slideDown();
        chatMessages.slimScroll({ scrollTo: chatMessages[0].scrollHeight + 'px' });
        chatInput.focus();
      });
    }
  }else{
    //console.log('update_chat: not activated');
  }

  setTimeout(function(){
    update_chat();
  },9666);
}
update_chat();

$('#fmenu_cari').on('submit',function(e){
  e.preventDefault();
  var keyword = $('#top-search').val().toUpperCase();
  var txtValue = "";
  if(typeof keyword === 'string' && keyword.length>0){
    $.each($('.sidebar-nav'),function(k,a){
      $(a).hide();
      if($(a).has('ul')){
        $.each($(a).find('li'),function(k1,a1){
          $(a1).hide();
        });
      }
    });
    $.each($('.sidebar-nav'),function(k,a){
      if($(a).has('ul')){
        $.each($(a).find('li'),function(k1,a1){
          txtValue = a1.innerText || a1.textContent;
          var idx = txtValue.toUpperCase().indexOf(keyword);
          if (idx > -1) {
            console.log('.sidebar-nav: '+k+' ul: '+k1+' txtValue: '+txtValue+' -- IDX: '+idx);

            $(a).show();
            setTimeout(function(){
              $(a).find('a').removeClass('open');
              $(a).find('a').addClass('open');
              $(a1).parent().show();
              $(a1).show('slow');
            },333);

          }
        });
      }else{
        txtValue = a.innerText || a.textContent;
        var idx = txtValue.toUpperCase().indexOf(keyword);
        if (idx > -1) {
          console.log('.sidebar-nav: '+k+' txtValue: '+txtValue+' -- IDX: '+idx);
          $(a).show('slow');
        }
      }
    });
  }

})
