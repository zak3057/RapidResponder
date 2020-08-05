'use strict';
$(function () {
  // フォームエラー時にフォームまで移動
  if($('.form-error').length) {
    var pos = $('.form-error').offset().top;
    scrollTo(0, pos-30);
  }
});