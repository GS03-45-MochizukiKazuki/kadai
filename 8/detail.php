<?php

//1.GETでidを取得
if(isset($_GET['id'])){
  $id = $_GET['id'];
}

//2.DB接続など
try {
  $pdo = new PDO('mysql:dbname=gs_db;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

$stmt = $pdo->query('SET NAMES utf8');
if (!$stmt) {
  $error = $pdo->errorInfo();
  exit("charError:".$error[2]);
}

//3.SELECT * FROM gs_an_table WHERE id=***; を取得
$stmt = $pdo->prepare("SELECT * FROM gs_an_table WHERE id = ".$id);
$status = $stmt->execute();


//4.select.phpと同じようにデータを取得（以下はイチ例）
while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
  $name   = htmlspecialchars($result["name"], ENT_QUOTES, 'UTF-8');
  $email  = htmlspecialchars($result["email"], ENT_QUOTES, 'UTF-8');
  $naiyou = htmlspecialchars($result["naiyou"], ENT_QUOTES, 'UTF-8');
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>POSTデータ登録</title>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>
    div{
      padding: 10px;font-size:16px;
    }
    i{
      cursor: pointer;
    }
    input, textArea{
    }
  </style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>回答を編集する</legend>
      <input type="hidden" name="id" value="<?php echo $id ?>">
      <div class="form" data-form="1">
        <label data-form="1">名前：<input type="text" name="name" readonly="readonly" value="<?php echo $name ?>"></label>
        <i class="fa fa-pencil-square-o"></i>
      </div>
      <div class="form" data-form="2">
        <label data-form="2">Email：<input type="text" name="email" readonly="readonly" value="<?php echo $email ?>"></label>
        <i class="fa fa-pencil-square-o"></i>
      </div>
      <div class="form" data-form="3">
        <label data-form="3"><textArea name="naiyou" rows="4" cols="40" readonly="readonly" placeholder="<?php echo $naiyou ?>"><?php echo $naiyou ?></textArea></label>
        <i class="fa fa-pencil-square-o"></i>
      </div>
      <input type="submit" value="編集">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->

<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
  // var forms = $(".form").data("form");




$('.fa-pencil-square-o').on('click', function(){
  var id = $(this).parent().data('form');
  var label = $('label').filter('[data-form='+ id + ']');
  label.find('input, textArea').css('background-color', '#FDDED1');
  label.find('input, textArea').removeAttr('readonly');
});





</script>


</body>
</html>






