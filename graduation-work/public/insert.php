<?php
include('assets/func.php');

// ジャンルIDで紐付ける
//入力チェック
if(
  // !isset($_POST["genre"]) || $_POST["genre"]=="" ||
  !isset($_POST["scene"]) || $_POST["scene"]=="" ||
  !isset($_POST["action"]) || $_POST["action"]==""
){
  exit('ParamError');
}

//POSTデータ取得
// $genre   = $_POST["genre"];
$scene   = $_POST["scene"];
$action  = $_POST["action"];

//**************************************************
// 以下DB（一覧情報取得）
//**************************************************
//1. 接続します
$pdo = db();

//2．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO me_an_table(scene, action,
indate )VALUES(:a1, :a2, sysdate())");
// $stmt->bindValue(':a1', $genre);
$stmt->bindValue(':a1', $scene);
$stmt->bindValue(':a2', $action);
// $stmt->bindValue(':a4', $evaluation);
$status = $stmt->execute();

//3．SQL実行エラーチェック
dbExecError($status,$stmt);

//4．データ登録処理後
//フォームの再送信を防げる
header("Location: app.php");
exit;

?>
