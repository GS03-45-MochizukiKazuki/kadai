 <!DOCTYPE html>
 <html lang="ja">
 <head>
 	<meta charset="UTF-8">
 	<title>check</title>
 </head>
 <body>

 <?php

header("Content-Type: text/html; charset=UTF-8");

//htmlのnameから情報を受け取っている
$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$age = $_POST["age"];
$message = $_POST["message"];


if($name == ""){
	print"※お名前を入力してください<br/><br/>";
}else{
	print"初めまして ";
	print $name;
	print" 様";
	print"<br/><br/>";
}

if($email == ""){
	print"※メールアドレスを入力してください<br/><br/>";
}else{
	print"メールアドレス：";
	print $email;
	print"<br/><br/>";
}

if($phone == ""){
	print"※電話番号を入力してください<br/><br/>";
}else{
	print"電話番号：";
	print $phone;
	print"<br/><br/>";
}

if($age == ""){
	print"※年齢を入力してください<br/><br/>";
}else{
	print"年齢：";
	print $age;
	print"<br/><br/>";
}

if($message == ""){
	print"※メッセージを入力してください<br/><br/>";
}else{
	print"メッセージ『";
	print $message;
	print"』<br/>";
}


//空っぽの時にOKボタンを表示しない
if($name == "" || $email == "" || $age == "" || $message == "" || $phone == ""){
	print'<form method="post" action="insert.php">';
	print'<input type="button" onclick="history.back()" value="戻る">';
	print'</form>';
} else {
	print'<form method="post" action="insert.php">';

	//insert.phpにデータを送り出す
	print'<input name="name" type="hidden" value="'.$name.'">';
	print'<input name="email" type="hidden" value="'.$email.'">';
	print'<input name="phone" type="hidden" value="'.$phone.'">';
	print'<input name="age" type="hidden" value="'.$age.'">';
	print'<input name="message" type="hidden" value="'.$message.'">';

	print'<input type="button" onclick="history.back()" value="戻る">';
	print'<input type="submit" value="送信">';
	print'</form>';
}

?>
 	
 </body>
 </html>