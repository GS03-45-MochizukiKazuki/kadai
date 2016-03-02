<?php 
header("Content-Type: text/html; charaset=UTF-8"); // 文字化け対策

session_start(); 

include("../src/assets/func.php");

$title = "Mental Energy | APP"; 
$cssHref = "app.css";

include("../src/assets/html/meta.php");

include("../src/assets/html/header.php");

?>




<?php
$db = db();

$qry = "SELECT * FROM me_an_table";
$data = $db->query($qry);

?>

<h2>ルール登録</h2>

<!-- insert -->
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
			        <td>{$genre}</td><td class=\"editable-td editable-td1\">{$scene}</td><td class=\"editable-td editable-td2\">{$action}</td><td>{$evaluation}</td>
		    	</tr>\n";
	}
	$db = null;
	?>

	</table>

	<input type="submit" name="delete" value="削除"/>
</form>




<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="js/textEdit.js"></script>

<?php 
include("../src/assets/html/footer.php");
?>