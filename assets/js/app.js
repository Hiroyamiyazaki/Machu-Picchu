    $(function () {
      $('.popup-modal').magnificPopup({
        type: 'inline',
        preloader: false
      });
      //閉じるリンクの設定
      $(document).on('click', '.popup-modal-dismiss', function (e) { 
        e.preventDefault();
        $.magnificPopup.close();
      });
});