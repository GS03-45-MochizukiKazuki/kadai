<?php
//1.POSTでParamを取得
$id = $_GET['id'];

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
$update = $pdo->prepare("DELETE FROM gs_an_table WHERE id=:id");
$update->bindValue(':id', $id);
$status = $update->execute();


//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合
  $error = $update->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．detail.phpへリダイレクト
  header("Location: select.php");
  exit;

}



?>
