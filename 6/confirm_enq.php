<html>
<head>
<meta charset="utf-8">
<title>check_name</title>
</head>
<style>
body {
	color: #ffffff;
	font-family:Monospace;
	font-size:13px;
	text-align:left;
	font-weight: bold;

	background-color: #000000;
	margin: 0px;
	overflow: scroll;
}


.nextBtn{
	cursor: pointer;;
	position: fixed;
	z-index: 9999;
	top: 10%;
	right: 5%;
	padding: 15px 10px;
	border: 1px solid #fff;
	background-color: transparent;
	color: #fff;
}
a{
	text-decoration: none;
	color: #fff;
	display: block;
}

.nextBtn:hover{
	background-color: rgba(255,255,255,.2);
}
.ans{
	display: block;
	position: relative;
	z-index: 9999;
	font-size: 1rem;
	width: 80%;
	margin: 3% auto 0;
}

.submit_btn{
	width: 200px;
	height: 200px;
	border-radius: 50%;
	border: 1px solid #fff;
	position: relative;
	margin: 0 auto;
	margin-top: 30px;
	cursor: pointer;
}
.submit_btn:hover{
	border: 1px dashed #fff;
	background-color: rgba(255,255,255,.1);
}
.submit_btn p{
	margin: 0;
	padding: 0;
	position:absolute;
	top:50%;
	left:50%;
	-moz-transform:translate(-50%, -50%);
	-webkit-transform:translate(-50%, -50%);
	-o-transform:translate(-50%, -50%);
	-ms-transform:translate(-50%, -50%);
	transform:translate(-50%, -50%);
	font-size: 2.5rem;
}


</style>
<body>


<?php


$fp = fopen("data/data.csv", "r");		//ファイルを開く
flock($fp, LOCK_SH);					//ファイルロック
while ($array = fgetcsv( $fp )) {		//ファイルを読み込む
	$num = count($array);				//行数カウント
	for($i=0;$i<$num;$i++){
		echo "<p class='ans'>".$array[$i]."</p>";
		// echo "<br>";
	}
}
flock($fp, LOCK_UN);                      //ロック解除
fclose($fp);                              //ファイルを閉じる


?>



<div class="submit_btn"><p>送信</p></div>



<script src="js/jquery-1.11.3.min.js"></script>	

<script src="javascript/libs/tween.min.js"></script>



</body>
</html>
