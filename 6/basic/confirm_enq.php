<html>
<head>
<meta charset="utf-8">
<title></title>
</head>
<body>


<?php

$name = $_POST["name"];
$age = $_POST["age"];
$email = $_POST["email"];
$sex = $_POST["sex"];
$syumi = $_POST["syumi"];
$free = $_POST["free"];
$select_syumi = "";

$sexAry = array(1 => "男", 2 => "女");
$syumiAry = array(1 => "スポーツ", 2 => "映画鑑賞", 3 => "読書", 4 => "料理");

if (is_array($syumi)) {
	foreach ($syumi as $value) {
		// var_dump($value);
		$select_syumi .= $syumiAry[$value]."、";
	}
	$syumi_list = rtrim($select_syumi, "、");
}

$answer = '名前 : '.$name.PHP_EOL
		.'年齢 : '.$age.PHP_EOL
		.'e-mail : '.$email.PHP_EOL
		.'性別 : '.$sexAry[$sex].PHP_EOL
		.'趣味 : '.$syumi_list.PHP_EOL
		.'その他 : '.$free;
// echo $answer;

$file = fopen("data/data.csv","w");	// ファイル読み込み a 追加
flock($file, LOCK_EX);			// ファイルロック
fputs($file, $answer . PHP_EOL); // 書き込み PHP_EOL 改行
flock($file, LOCK_UN);			// ファイルロック解除
fclose($file);


$fp = fopen("data/data.csv", "r");		//ファイルを開く
flock($fp, LOCK_SH);					//ファイルロック
while ($array = fgetcsv( $fp )) {		//ファイルを読み込む
	$num = count($array);				//行数カウント
	for($i=0;$i<$num;$i++){
		echo "<p>".$array[$i]."</p>";
		// echo "<br>";
	}
}
flock($fp, LOCK_UN);                      //ロック解除
fclose($fp);                              //ファイルを閉じる


?>



</body>
</html>
