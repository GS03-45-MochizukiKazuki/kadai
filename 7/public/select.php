<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>select</title>
</head>
<body>
	
<?php

header("Content-Type: text/html; charset=UTF-8");

//データベースに接続
$dsn = 'mysql:dbname=an;host=localhost';
$user = 'root';
$password = '';
$dbh = new PDO($dsn, $user, $password);

$stmt = $dbh->query('SET NAMES utf8');
$stmt = $dbh->prepare("SELECT * FROM an_table");
$flag = $stmt->execute();

$view="";
if($flag==false){
  $view = "SQLエラー";
}else{
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<p>'.$result['name'].' , '.$result['email'].'</p>';
  }
  echo $view;
}

$dbh = null;//切断


?>



 </body>
 </html>


