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
      $('.js-like').on('click', function() {
          $.ajax({
            //送信先、送信するデータ
          })
          .done(function(data) {
            //成功時の処理
          })
          .fail(function(err) {
            //失敗時の処理
          })
      });

});

