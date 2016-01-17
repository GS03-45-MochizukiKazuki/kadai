<?php
//入力チェック
if(
  !isset($_POST["name"]) || $_POST["name"]=="" || //nameをとれているか、nameがnullじゃないか
  !isset($_POST["email"]) || $_POST["email"]=="" ||
  !isset($_POST["naiyou"]) || $_POST["naiyou"]==""
){
  exit('ParamError');
}

//1. POSTデータ取得
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
$stmt = $pdo->query('SET NAMES utf8');
if (!$stmt) {
  $error = $pdo->errorInfo();
  exit($error[2]);
}

//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_an_table(id, name, email, naiyou,
indate )VALUES(NULL, :a1, :a2, :a3, sysdate())");
$stmt->bindValue(':a1', $name);
$stmt->bindValue(':a2', $email);
$stmt->bindValue(':a3', $naiyou);
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: index.php");
  exit;
}
?>
