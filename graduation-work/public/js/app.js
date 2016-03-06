// 'use strict';

(function(){

/* ======================================
 * ジャンル
 * ====================================== */

// 色
var $genre_color = $('.genre__color');
var aryColor = ["#FF7B7E","#FFCB7B","#E1FF77","#80FFAE","#7FFFFF","#7FACFF","#9775FF","#E372FF"];

$genre_color.each(function(i, val){
	$(this).css('background-color', aryColor[i%8]);
});

// 最初をactive
var $genreItem_first = $('.genre__item').eq(0);
$genreItem_first.find('h2').addClass('is-active');





})();
