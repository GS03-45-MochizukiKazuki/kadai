// 'use strict';

// (function(){

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




// })();
