'use strict';
$(function () {
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
});