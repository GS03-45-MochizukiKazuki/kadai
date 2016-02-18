<?php
include('./include/func.php'); //外部ファイル読み込み（関数群）

//入力チェック
if(
  !isset($_POST["genre"]) || $_POST["genre"]=="" ||
  !isset($_POST["scene"]) || $_POST["scene"]=="" ||
  !isset($_POST["action"]) || $_POST["action"]=="" ||
  !isset($_POST["star"]) || $_POST["star"]==""
){
  exit('ParamError');
}

//POSTデータ取得
$genre   = $_POST["genre"];
$scene  = $_POST["scene"];
$action  = $_POST["action"];
$star = $_POST["star"];

//**************************************************
// 以下DB（一覧情報取得）
//**************************************************
//1. 接続します
$pdo = db(); // new PDO(...を関数として読み込み (include/func.php)

//2．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO mental_energy_table(id, genre, scene, action, star,
indate )VALUES(NULL, :a1, :a2, :a3, :a4, sysdate())");
$stmt->bindValue(':a1', $genre);
$stmt->bindValue(':a2', $scene);
$stmt->bindValue(':a3', $action);
$stmt->bindValue(':a4', $star);
$status = $stmt->execute();

//3．SQL実行エラーチェック
dbExecError($status,$stmt);

//4．データ登録処理後
header("Location: index.php");
exit;
?>
