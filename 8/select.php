<?php
//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

//2. DB文字コードを指定（固定）
$stmt = $pdo->query('SET NAMES utf8');
if (!$stmt) {
  $error = $pdo->errorInfo();
  exit("charError:".$error[2]);//エラー出力
}

//３．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_an_table");
$status = $stmt->execute();

//データ表示
$view="";
if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<p><a href="detail.php?id='.$result["id"].'">'.$result["name"].'</a><a href="delete.php?id='.$result["id"].'"><i class="fa fa-trash-o"></i></a></p>';
    // $view .= $result["name"]."[".$result["indate"]."]<br>";
  }

}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>フリーアンケート表示</title>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>
div{padding: 10px;font-size:16px;}
i{
  cursor: pointer;
  margin-left: 10px;
}
</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録</a>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?php echo $view ?></div>
  </div>
</div>
<!-- Main[End] -->

<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script>

  $('.fa-trash-o').on('click', function(){
    alert("データベースから消去します")

});
</script>

</body>
</html>
