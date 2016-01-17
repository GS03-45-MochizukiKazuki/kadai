<?php
//1.POSTでParamを取得
// $id = $_GET['id'];

$id     = htmlspecialchars($_POST["id"], ENT_QUOTES, 'UTF-8');
$name   = htmlspecialchars($_POST["name"], ENT_QUOTES, 'UTF-8');
$email  = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
$naiyou = htmlspecialchars($_POST["naiyou"], ENT_QUOTES, 'UTF-8');

//2. DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}

//2. DB文字コードを指定(固定)
$update = $pdo->query('SET NAMES utf8');
if (!$update) {
  $error = $pdo->errorInfo();
  exit($error[2]);
}

//3.UPDATE gs_an_table SET ....; で更新
$update = $pdo->prepare("UPDATE gs_an_table SET name=:a1, email=:a2, naiyou=:a3 WHERE id=:id");
$update->bindValue(':a1', $name);
$update->bindValue(':a2', $email);
$update->bindValue(':a3', $naiyou);
$update->bindValue(':id', $id);
$status = $update->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合
  $error = $update->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．detail.phpへリダイレクト
  // header("Location: select.php");
  header("Location: detail.php?id=".$id);
  exit;

}



?>
