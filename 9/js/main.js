$(document).ready(function(){
	function scroll_in(){
	$(".scroll").fadeIn();
	}
	function scroll_hidden(){
	$(".scroll").fadeOut();
	clearTimeout(time_id);
	}
	function scroll_display(){
	time_id=setTimeout(function(){
	scroll_in()
	},
	1000
	);
	}

	scroll_display();
	$(window).scroll(function(){
	scroll_hidden();
	scroll_display();
	});
});


/*
=================
BGM
=================
*/

var audio = document.getElementById("bgm_audio");
var bgm_btn = document.getElementById("bgm");
var bgm_on = document.getElementById("bgm_on");
var bgm_off = document.getElementById("bgm_off");

bgm_btn.addEventListener("click", function(){
  if(audio.paused){
    audio.play();
    audio.volume = 1.0;
    audio.loop = true;
    bgm_on.className = 'open';
  }else{
    audio.pause();
    bgm_on.className = 'close';
  }
}, false);

$(function(){
	audio.loop = true;
});



/*
=================
scroll
=================
*/
$('.slowDownAnim').css('visibility','hidden');
$(window).scroll(function(){
 var windowHeight = $(window).height(),
     topWindow = $(window).scrollTop();
 $('.slowDownAnim').each(function(){
  var targetPosition = $(this).offset().top;
  if(topWindow > targetPosition - windowHeight + 100){
   $(this).addClass("fadeInDown");
  }
 });
});


$('.fadeInAnim').css('visibility','hidden');
$(window).scroll(function(){
 var windowHeight = $(window).height(),
     topWindow = $(window).scrollTop();
 $('.fadeInAnim').each(function(){
  var targetPosition = $(this).offset().top;
  if(topWindow > targetPosition - windowHeight + 100){
   $(this).addClass("fadeIn");
  }
 });
});





/*
=================
top page
=================
*/
$(function(){
	$('a[href^=#]').click(function(){
		var speed = 1000;
		var href= $(this).attr("href");
		var target = $(href == "#" || href == "" ? 'html' : href);
		var position = target.offset().top;
		$("html, body").animate({scrollTop:position}, speed, "swing");
		return false;
	});
});



/*
=================
scroll menu
=================
*/
$(function() {
    var topMenu = $('#menu');
    topMenu.hide();
    //スクロールが200に達したらボタン表示
    $(window).scroll(function () {
        if ($(this).scrollTop() > 200) {
            topMenu.fadeIn(500);
        } else {
            topMenu.fadeOut(500);
        }
    });
});



