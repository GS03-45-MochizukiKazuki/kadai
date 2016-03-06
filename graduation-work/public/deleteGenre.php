<?php
include("assets/func.php");

$did = $_GET['delid'];

//DB接続
$pdo = db();

//DB文字コードを指定(固定)
$stmt = $pdo->query('SET NAMES utf8');
if (!$stmt) {
  $error = $pdo->errorInfo();
  exit($error[2]);
}

//UPDATE me_an_table SET ....; で更新
$stmt = $pdo->prepare("DELETE FROM me_an_table WHERE id=:did");
$stmt->bindValue(':did', $did);
$status = $stmt->execute();

//データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  header("Location: app.php");
  exit;

}



?>
