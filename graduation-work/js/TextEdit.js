 // 'use strict';

$(function() {

	/* ======================================
	 * テキスト編集
	 * ====================================== */
	$(document).ready(function(){
		$('.editable-td').click(edit_toggle());
	});

	function edit_toggle(){
		var flag = false;
		return function(){
			if (flag) return;
			var $input = $("<input>").attr("type","text").val($(this).text()); // <input type="text" value="sample"></input>
			$input.addClass('is-editing')
	    	$(this).html($input); // tdの中にinput

	    	$("input", this).focus().blur(function(){
	            $(this).after($(this).val()).remove(); 
	            flag = false;
	            console.log($(this).val()); // 変更後の値を保存ボタンの値にセットしてあげる
	    	});
			flag = true;
		}
	}


	/* ======================================
	 * テーブルハイライト
	 * ====================================== */
    $("tr").each(function () {
		$(this).children().not('th').each(function (i) { // th以外＝td
			i = i+1;
			$(this).addClass("item" + i);
		});
    });

    $.fn.color = function() {
      return this.each(function() {
        $(this).css('background-color', '#eee');
      });
    };

    $("tr").mouseout(function() {
        $(this).children().css('background-color', '');
    });
 
    //列の背景色変更
    $("td").each(function() {
		var selector = '.'+ $(this).attr('class');
		$(this).hover(function(){
				$(selector).color();
				$(this).siblings().color();
				//選択中のtdの背景色変更
				$(this).css('background-color', '#ccc');
			},function(){
				$(selector).css('background-color', '');
				$(this).parent().css('background-color', '');
		});
    });


});

