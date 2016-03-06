 // 'use strict';

$(function() {

/* ======================================
 * テキスト編集
 * ====================================== */

// tr > td > input
$(document).ready(function(){
	$('.editable-td').click(edit_toggle());
});

function edit_toggle(){
	var flag = false;
	return function(){
		if (flag) return;
		var $input = $("<input>").attr("type","text").val($(this).text()); // <input type="text" value="sample"></input>
        $input.addClass('is-editing');
        console.log($(this).attr('class'));
        var $old_val = $(this).text();
        console.log($old_val);
        var $tr = $("<tr class='js-added_tr'><td></td></tr>");
        var $tr_colspan = $("<td colspan=\"2\"></td>");

        var $selected_id = $(this).parent().find('input[name="delid"]').val();
        console.log($selected_id);

        if ($(this).hasClass('editable-td1')) {
            $input.attr('name', 'scene');
        }else if($(this).hasClass('editable-td2')){
            $input.attr('name', 'action');
        }
        var $form = $("<form action='update.php' method='post'></form>");
        var $submit = $("<input type='submit' name='update' class='todo__submit-btn' value='保存'/>");
        var $cancel = $("<input type='button' name='cancel' class='todo__cancel-btn' value='キャンセル'/>");
        var $id_hidden = $("<input type='hidden' name='id' value='"+$selected_id+"'/>");
        // $form.append($input);
        // tr > form > submit, cancel
        $('table').wrap($form);
        $tr.append($tr_colspan);
        $tr_colspan.append($submit);
        $tr_colspan.append($cancel);
        $tr_colspan.append($id_hidden);
        // $tr.append($form);
        // $(this).parent().parent().wrap($form); // tbodyを囲う
        $(this).html($input); // tdの中にinput
        $(this).parent().after($tr); // trの後ろに新たなtr
        // $(this).form("<form action='update.php' method='post' style='margin:0; padding:0;'/>");

    	// $("input", this).focus().blur(function(){
     //        $(this).after($(this).val()).remove(); // valだけ要素の後ろに追加して要素自体は消える
            
     //        // $('.tbody').find('form[action="update.php"]').remove();

     //        $('.js-added_tr').remove();
     //        flag = false;
     //        // console.log($(this).val()); // 変更後の値を保存ボタンの値にセットしてあげる
    	// });

        // キャンセルボタン
        $('.todo__cancel-btn').on('click', function(){
            // $(this).after($(this).val()).remove(); 
            // var value = $input.val();
            // var value = $(this).parent().find('input[type=text]').val();
            $('.js-added_tr').prev().find('.editable-td input').after($old_val); // formの後ろ 値を戻す
            $('.js-added_tr').prev().find('.editable-td input').remove();
            // $(this).parent().parent().remove(); // tr削除
            $('.js-added_tr').remove();

            flag = false;
        });


		flag = true;
	};
}








/* ======================================
 * テーブルハイライト
 * ====================================== */
// セルをマウスオーバー
$(".editable-td").hover(function(){
    // 横
    // 親要素（tr要素）にtargetクラスを追加
    $(this).parent().find(".editable-td").addClass("js-highlight");
   

    // 縦
    // 親要素から見て、自分が何番目の子要素なのか調べる
    // var myIndex = $(this).index() + 1;
                
    // // 各行の「myIndex番目の子要素」にjs-highlightクラスを追加する
    // $("td:nth-child("+ myIndex +")").addClass("js-highlight");

}, function(){
    // マウスアウト時にjs-highlightクラスを削除
    $(".js-highlight").removeClass("js-highlight");
});




});

