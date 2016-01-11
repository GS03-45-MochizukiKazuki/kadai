 <!DOCTYPE html>
 <html lang="ja">
 <head>
 	<meta charset="UTF-8">
 	<title>コンタクトフォーム</title>
 </head>
 <body>
 <style type="text/css">
	label{
		width: 100px;
		height: 30px;
		display: inline-block;
	}
	.form__message label{
		vertical-align: top;
	}
 </style>


 <form method="post" action="check.php">
    <div class="form__name form">
        <label for="name">お名前</label>
        <input type="text" placeholder="your name" id="name" name="name">
    </div>
    <div class="form__email form">
        <label for="email">Email</label>
        <input type="email" placeholder="mail address" id="email" name="email">
    </div>
    <div class="form__phone form">
        <label for="phone">電話番号</label>
        <input type="tel" placeholder="phone number" id="phone" name="phone">
    </div>
    <div class="form__age form">
        <label for="age">年齢</label>
		<select id="age" name="age">
			<option value="">選択してください</opton>
			<?php 
			for ($i = 6; $i <= 100; $i++) {
				echo '<option value="'.$i.'">'.$i.'歳'.'</option>';
			}
			?>
		</select>
    </div>
	<div class="form__hobby form">
		<label for="hobby[]">趣味</label>
		<?php
		$types = array('読書', 'スポーツ', '料理', '旅行', '映画鑑賞', '絵画鑑賞');
		foreach ($types as $type){
			echo '<input type="checkbox" name="hobby[]" value="'.$type.'">'.$type;
		}
		?>
	</div>
    <div class="form__message form">
        <label for="message">メッセージ</label>
        <textarea rows="5" placeholder="message" id="message" name="message"></textarea>
    </div>

    <button type="submit">確認</button>
</form>    
 	
 </body>
 </html>