<?php 
header("Content-Type: text/html; charaset=UTF-8"); // 文字化け対策

session_start(); 

include("assets/func.php");

$title = "Mental Energy | APP"; 

include("assets/html/meta.php");

?>
<style type="text/css">
	td{
		width: 100px;
		height: auto;
	}
	.is-editing{
		width: 100%;
		height: 100%;
	}
</style>

<?php
$db = db();

//追加ボタン＝保存ボタン
// if(isset($_POST["insert"])){
// 	$genre = $_POST["genre"];
// 	$scene = $_POST["scene"];
// 	$action = $_POST["action"];
// 	$qry ="INSERT INTO me_an_table(genre, scene, action, indate) VALUES(:a1, :a2, :a3, sysdate())";
// 	$stmt = $db->prepare($qry);
// 	$stmt->bindValue(":a1", $genre);
// 	$stmt->bindValue(":a2", $scene);
// 	$stmt->bindValue(":a3", $action);
// 	$stmt->execute();
// }
//削除ボタン
// if(isset($_POST["delete"])){
// 	$did = $_POST["delid"];
// 	$qry ="DELETE FROM me_an_table WHERE id = :did";
// 	$stmt = $db->prepare($qry);
// 	$stmt->bindValue(":did", $did);
// 	$stmt->execute();
// }

$qry = "SELECT * FROM me_an_table";
$data = $db->query($qry);

?>

<h2>ルール登録</h2>

<!-- <form action="http://mo49.tokyo/mental_energy/app/" method="post"> -->
<form action="insert.php" method="post">
ジャンル：<input type="text" name="genre"/><br/>
シーン：<input type="text" name="scene"/><br/>
アクション：<input type="text" name="action"/><br/>
<!-- 評価：<input type="text" name="evaluation"/><br/> -->
<input type="submit" name="insert" value="追加"/>
</form>

<hr/>

<h2>マイルール</h2>

<!-- delete -->
<form action="delete.php" method="get">

	<table border="2">
	<tr bgcolor="#aaa">
	<th>削除</th>
	<th>ジャンル</th>
	<th>シーン</th>
	<th>アクション</th>
	<th>評価</th>
	</tr>

	<?php
	while($value = $data->fetch()){
		$id = $value["id"];
		$evaluation = $value["evaluation"];
		$genre = $value["genre"];
		$scene = $value["scene"];
		$action = $value["action"];
		// 削除ボタンのvalueに行と同じID番号を振る
		print "<tr class=\"editable-tr\">
					<td><input type=\"radio\" name=\"delid\" value=\"{$id}\"/></td>
			        <td>{$genre}</td><td class=\"editable-td\">{$scene}</td><td class=\"editable-td\">{$action}</td><td>{$evaluation}</td>
		    	</tr>\n";
	}
	$db = null;
	?>

	</table>

	<input type="submit" name="delete" value="削除"/>
</form>


<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="js/TextEdit.js"></script>


</body>
</html>