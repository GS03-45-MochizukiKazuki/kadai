<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>check_name</title>
</head>
<style>
body {
	color: #ffffff;
	font-family:Monospace;
	text-align:center;
	font-weight: bold;

	background-color: #000000;
	margin: 0px;
	overflow: hidden;

	font: 30px sans-serif;
	width: 100%;
	height: 100%;

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
	margin-top: 12%;
	display: none;
	font-size: 1.5rem;
}
.ans:nth-child(1){
	display: block;
}

#contentArea {
  -webkit-border-radius: 10px;
  -moz-border-radius: 10px;
  border-radius: 10px;
  margin: 20px;
  background: #2b3135;
}

#inputArea {
  padding: 20px;
  width: 600px;
  margin: 0px auto;
}

input[type="text"]{
  background-color: #000;
  height: 40px;
  width: 60%;
  padding: 10px;
  font-weight: bold;
  font-size: 26px;
  -webkit-border-radius: 7px;
  -moz-border-radius: 7px;
  border-radius: 7px;
  color: #999;
}

input[type="range"]::-webkit-slider-thumb {

  background-color: #666;
  opacity: 0.5;
  width: 10px;
  height: 26px;
}

#textCv {
   display: none;
}

#inputText{
	opacity: 0;
}


</style>
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
		echo "<p class='ans'>".$array[$i]."</p>";
	}
}
flock($fp, LOCK_UN);                      //ロック解除
fclose($fp);                              //ファイルを閉じる


?>


<a href="check_age.php"><button class="nextBtn">＞</button></a>



<div id="contentArea">

<!-- 文字入力 -->
<div id="inputArea">
	<input type="text" value="" id="inputText" placeholder="ここにテキストを入力">
<input type="range" max="40" id="rangeViberation">
	<select name="selectColor" id="selectColor">
		<option value="#FF0000" selected="selected">赤</option>
		<option value="#F1FF00">黄</option>
		<option value="#FF06D7">桃</option>
		<option value="#00FF00">緑</option>
		<option value="#7A00FF">紫</option>
	</select>
</div>

<!-- 文字出力 -->
<div id="viewArea">
	<canvas id="textCv"></canvas>
</div>

</div>



<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/jquery-1.11.3.min.js"></script>


<script>
	var ans = document.getElementsByClassName("ans")[0].innerHTML;
	var ans = ans.split(":")[1];
	console.log(ans);


$(function(){

	var cv = document.getElementById('textCv'),
		ctx = cv.getContext('2d'),
		paddingWindow = 10*2,
        inputAreaHeight = 100,
		W = cv.width = window.innerWidth,
		H = cv.height = window.innerHeight,
	//canvas作成
		imgCv = document.createElement('canvas'),
		imgCtx = imgCv.getContext('2d'),
		imgText = new Image(),
		fontSize = 60,
		randomPos,
		start = true;

	//DOMが全てロードされてDOMにアクセスできる準備が出来た段階で実行させたい処理を関数で指定します。
	$(document).ready(function(){
		init();
	});

	function init(){
		watchForm();
		//色をプルダウンで選択時
		$('#selectColor').on('change', drawText);//selectColorが変更された時drawText
		//アニメーション用canvas
		setImageCanvas();

		imgText.onload = function(){
            if(start) {
                animation();
                // この後はanimation()を実行しない
                start = false;
            }
        };
	}

	drawText();
	function drawText(){
		var inputText = ans;//テキストのvalue値
		var colorText = $('#selectColor').val();//色選択のvalue値

		ctx.clearRect(0,0,W,H);//四角をくりぬく

		ctx.textBaseline = 'middle';
		ctx.textAlign = 'center';
		ctx.shadowColor = colorText;
		ctx.shadowBlur = 20;
		ctx.font = 'bold 80px "Audiowide"';
		ctx.fillStyle = '#fff';
		ctx.fillText(inputText, W/2 - 30, H/2 -200, W);//ここでcanvasに文字を描いている！

		changeImg();
	}

	function watchForm(){
		var timerID;

		$('#inputText').on("focus", function(){//フォーカスを合わせる
			timerID = setInterval(drawText, 60);
		});

		$('#inputText').on('blur', function(){//フォーカスを外す
			clearInterval(timerID);
		});
	}


	// ========================
	// 画像変換
	// ========================

	function setImageCanvas(){
		imgCv.setAttribute('width', W);//属性 width と 値 W を追加
		imgCv.setAttribute('height', H-300);

		$('#viewArea').append(imgCv);
	}

	//canvasに書いたテキストをimgに変換
	function changeImg(){
		var imgPngUrl = cv.toDataURL();//toDataURL() canvasデータを画像にする 参考http://www.pori2.net/html5/Canvas/150.html

		imgText.src = imgPngUrl;
	}


	// ========================
	// アニメーション
	// ========================

	//アニメーションの初期設定
	function initAnimation(){
		imgCtx.clearRect(0,0,W,H);
		effectViberation();
	}

	//このループで動かしている
	function effectViberation(){
		var range = $('#rangeViberation').val();

		for (var i = 0; i < H; i+=1) {
			randomPos = Math.floor(Math.random()*range);
			imgCtx.drawImage(imgText,0,i,W,1,randomPos,i,W,1);//context . drawImage(image, sx, sy, sw, sh, dx, dy, dw, dh)
		}
	}

	//アニメーションさせるためのループ
	function animation(){
		function animationLoop(){
			initAnimation();
			requestAnimationFrame(animationLoop);
		}
		animationLoop();
	}

	//requestAnimationFrameメソッド設定 使い方http://liginc.co.jp/web/js/130758
	window.requestAnimationFrame = (function(){//描画する処理の準備が整っている場合のみコールバックを実行する
		return window.requestAnimationFrame||
		window.mozRequestAnimationFrame||
		window.webkitRequestAnimationFrame||
		function(callback){
			window.setTimeout(callback, 1000/60);
		};
	})();


});


</script>


</body>
</html>
