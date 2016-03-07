<?php 
header("Content-Type: text/html; charaset=UTF-8"); // 文字化け対策

session_start(); 

include("assets/func.php");

$title = "Mental Energy | APP"; 
$css_href = "app.css";

include("assets/html/meta.php");

include("assets/html/header.php");

?>




<?php
// メインテーブル
$db = db();
$db->query("set names utf8"); // 文字化け対策
$qry = "SELECT * FROM me_an_table";
$data = $db->query($qry);

// ジャンルテーブル
$qry_genre = "SELECT * FROM me_genre_table";
$data_genre = $db->query($qry_genre);


?>


<div class="header-bg"></div>

<div class="wrapper">


<section class="content-left">
<section class="content-left__wrapper cf">

	<!-- .rule -->
	<section class="rule">
		<ul class="rule__list">
			<li class="rule__item rule__item1"><i class="fa fa-inbox fa-fw fa-2x"></i><h2 class="is-active">定期ルール</h2></li>
			<li class="rule__item rule__item2"><i class="fa fa-calendar fa-fw fa-2x"></i><h2>不定期ルール</h2></li>
		</ul>
	</section>
	
	
	<!-- .genre -->
	<section class="genre">
	
		<!-- .genre delete -->
		<form action="deleteGenre.php" method="post">
			<!-- .genre select -->
			<h2 class="genre__ttl">ジャンル</h2>
			<ul class="genre__list">
				<?php 
				while($value = $data_genre->fetch()){
					$id = $value["genre_id"];
					$genre = $value["genre"];
					print "<li class=\"genre__item\">
								<span class=\"genre__color\"></span><h2 class=\"genre__txt\">{$genre}</h2><i class=\"genre__delete fa fa-minus-square-o \"></i>
							</li>";
				}
				$db = null;
				?>
			</ul>
			<input type="submit" name="deleteGenre" value="削除"/>
		</form>
	
		<!-- .genre insert -->
		<form class="genre__form" action="insertGenre.php" method="post">
			<input class="genre__txt" type="text" name="genre" placeholder="genre"/><br/>
			<input class="genre__submit" type="submit" name="insertGenre" value="追加"/>
			<input class="genre__cancel" type='button' name='cancel' class='cancel-btn' value='キャンセル'/>
		</form>
	
	</section>

</section>	
</section><!-- .content-left -->





<section class="content-right">
<section class="content-right__wrapper cf">

	<h2 class="is-active">ジャンル名</h2>

	<!-- delete -->
	<form action="delete.php" method="get">

		<table class="todo__table">
			<tr class="todo__tr">
				<th class="todo__th"></th>
				<!-- <th>ジャンル</th> -->
				<th class="todo__th">シーン</th>
				<th class="todo__th">アクション</th>
			</tr>

			<?php
			while($value = $data->fetch()){
				$id = $value["id"];
				$genre = $value["genre_id"];
				$scene = $value["scene"];
				$action = $value["action"];
				// 削除ボタンのvalueに行と同じID番号を振る
				print "<tr class=\"editable-tr\">
							<td><input type=\"radio\" name=\"delid\" value=\"{$id}\"/></td>
					        <td class=\"editable-td editable-td1\">{$scene}</td><td class=\"editable-td editable-td2\">{$action}</td>
				    	</tr>\n";
			}
			$db = null;
			?>

		</table><!-- .todo__table -->

		<!-- これをdisplay:none;にしてradiobuttonにcheckがあったら自動的にクリックさせる -->
		<input type="submit" name="delete" value="削除"/>
	</form>


	<!-- insert -->
	<form action="insert.php" method="post">
		<!-- ジャンル：<input type="text" name="genre"/><br/> -->
		<input type="text" name="scene" placeholder="scene" /><br/>
		<input type="text" name="action" placeholder="action"/><br/>
		<input type="submit" name="insert" value="追加"/>
	</form>

</section>
</section><!-- .content-right -->


</div><!-- .wrapper -->



<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="js/textEdit.js"></script>
<script src="js/app.js"></script>

<?php 
include("assets/html/footer.php");
?>




