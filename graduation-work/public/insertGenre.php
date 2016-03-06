<?php
include('assets/func.php');

//入力チェック
if(
  !isset($_POST["genre"]) || $_POST["genre"]==""
){
  exit('ParamError');
}

//POSTデータ取得
$genre   = $_POST["genre"];

//**************************************************
// 以下DB（一覧情報取得）
//**************************************************
//1. 接続します
$pdo = db();

//2．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO me_genre_table(genre_id, genre)VALUES(null, :a1)");
$stmt->bindValue(':a1', $genre);
$status = $stmt->execute();

//3．SQL実行エラーチェック
dbExecError($status,$stmt);

//4．データ登録処理後
//フォームの再送信を防げる
header("Location: app.php");
exit;

?>
