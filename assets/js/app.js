$(function(){

    $('.parent-container').magnificPopup({
      delegate: 'a', 
      type: 'image',
      gallery: { //ギャラリー表示にする
        enabled:true
      }
      });



      $('.popup-modal').magnificPopup({
        type: 'inline',
        preloader: false
      });
      //閉じるリンクの設定
      $(document).on('click', '.popup-modal-dismiss', function (e) { 
        e.preventDefault();
        $.magnificPopup.close();
      });


    //いいね!ボタン
      $(document).on('click', '.js-like', function() {
        var feed_id = $(this).siblings('.feed-id').text();
        var user_id = $('#signin-user').text();
        var like_btn = $(this);
        var like_count = $(this).siblings('.like_count').text();
        console.log(feed_id);
        console.log(user_id);
          $.ajax({
            //送信先、送信するデータ
            url:'like.php',
            type:'POST',
            datatype:'json',
            data: {
              'feed_id':feed_id,
              'user_id':user_id,
            }
          })
          .done(function(data) {
            if (data == 'true') {
              like_count++;
              like_btn.siblings('.like_count').text(like_count);
              like_btn.removeClass('js-like');
              like_btn.addClass('js-unlike');
              like_btn.children('span').text('いいねを取り消す');

            }
          })
          .fail(function(err) {
            //失敗時の処理
            console.log('error');
          })
      });


      //いいね取り消す!ボタン
      $(document).on('click', '.js-unlike', function() {
        var feed_id = $(this).siblings('.feed-id').text();
        var user_id = $('#signin-user').text();
        var like_btn = $(this);
        var like_count = $(this).siblings('.like_count').text();
        $.ajax({
            // 送信先、送信するデータなど
            url: 'like.php',
            type: 'POST',
            datatype: 'json',
            data: {
                'feed_id': feed_id,
                'user_id': user_id,
                'is_unlike': true,
            }
        })
        .done(function(data) {
            if (data == 'true') {
                like_count--;
                like_btn.siblings('.like_count').text(like_count);
                like_btn.removeClass('js-unlike');
                like_btn.addClass('js-like');
                like_btn.children('span').text('いいね!');

            }
        })
        .fail(function(err) {
            console.log('error');
        })
    });


});


// プレビュー画像を任意の場所に挿入
$(function() {
    // jQuery Upload Thumbs 
    $('#img_name').uploadThumbs({
        position : '#preview1',   // any: arbitrarily jquery selector
    });
});


