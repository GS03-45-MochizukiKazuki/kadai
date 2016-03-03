<?php
include('assets/func.php');

//入力チェック
// if(
//   !isset($_POST["scene"]) || $_POST["scene"]=="" ||
//   !isset($_POST["action"]) || $_POST["action"]==""
// ){
//   exit('ParamError');
// }

//POSTデータ取得
$id      = $_POST["id"];
$scene   = $_POST["scene"];
// $action  = $_POST["action"];


// db接続
$pdo = db();

//2. DB文字コードを指定(固定)
$update = $pdo->query('SET NAMES utf8');
if (!$update) {
  $error = $pdo->errorInfo();
  exit($error[2]);
}

//3.UPDATE gs_an_table SET ....; で更新
$update = $pdo->prepare("UPDATE me_an_table SET scene=:a1 WHERE id=:id");
$update->bindValue(':a1', $scene);
// $update->bindValue(':a2', $action);
$update->bindValue(':id', $id);
$status = $update->execute();

//3．SQL実行エラーチェック
dbExecError($status,$update);

//4．データ登録処理後
//フォームの再送信を防げる
header("Location: app.php");
exit;



?>
