'use strict';
$(function () {
  // スクロールバー
  var scrollFlg = true;
  $("#scrollbar").on('scroll', function () {
    if (scrollFlg === true) {
      scrollFlg = false;
      $('.scroll-table').scrollLeft($(this).scrollLeft());
    } else {
      scrollFlg = true;
    }
  });
  $(".scroll-table").on('scroll', function () {
    if (scrollFlg === true) {
      scrollFlg = false;
      $("#scrollbar").scrollLeft($(this).scrollLeft());
    } else {
      scrollFlg = true;
    }
  });

  // お問い合わせクリック
  $('.contact-archive-table tbody tr').on('click', function() {
    var contact_id = $(this).find('.contact-id').text();
    window.location.href = '/contact/archive/detail?id='+contact_id;
  });
});