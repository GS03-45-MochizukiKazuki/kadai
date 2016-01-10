 <!DOCTYPE html>
 <html lang="ja">
 <head>
 	<meta charset="UTF-8">
 	<title>insert</title>
 </head>
 <body>
 	
 <?php

header("Content-Type: text/html; charset=UTF-8");

//データベースに接続
$dsn = 'mysql:dbname=an;host=localhost';
$user = 'root';
$password = '';
$dbh = new PDO($dsn, $user, $password);
$dbh->query('SET NAMES utf8');

//check.phpから受け取り
$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$age = $_POST["age"];
$message = $_POST["message"];

print$name ;
print" 様<br/>";
print"<br/>";
print"ご連絡ありがとうございました<br/>";
print"<br/>";
print$email;
print"にメールをお送りしておりますのでご確認ください。";

//確認メールの送信
$mail_sub = 'メッセージを受け付けました';//メールタイトル

$mail_body = 
$name."様

ご連絡いただき有難うございます。

メッセージは確かに受け取りましたので、

ご回答まで少しお時間頂けますようお願いいたします。


=========================
望月 一樹
Mochizuki Kazuki
k.mochizuki.0409@gmail.com
TEL:090-4621-7764
=========================";

$mail_body2 = 
$name."様から連絡がありました

email：".$email."

電話番号：".$phone."

メッセージ：".$message;


$my_email = 'popup.mk49@gmail.com';
$mail_body = html_entity_decode($mail_body, ENT_QUOTES, "UTF-8");
$mail_head = 'From:k.mochizuki.0409@gmail.com';
mb_language('Japanese');
mb_internal_encoding("UTF-8");
mb_send_mail($email, $mail_sub, $mail_body, $mail_head);
mb_send_mail($my_email, $mail_sub, $mail_body2, $mail_head);


//SQL文
$sql = "INSERT INTO an_table (id, name, email, phone, age, message, indate )VALUES(NULL, :a1, :a2, :a3, :a4, :a5, sysdate())";
$stmt = $dbh->prepare($sql);//命令を出す準備
//sqlインジェクション回避
$stmt->bindValue(':a1', $name); 
$stmt->bindValue(':a2', $email);
$stmt->bindValue(':a3', $phone);
$stmt->bindValue(':a4', $age);
$stmt->bindValue(':a5', $message);
$status = $stmt->execute();//命令

//データ登録処理後
if($status==false){
  //Errorの場合$status=falseとなり、エラー表示
  echo "SQLエラー";
  exit;
}else{
  //index.phpへリダイレクト
  // header("Location: index.php");
  exit;
}

$dbh = null;//切断



?>

 </body>
 </html>