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
	text-align:center;
	font-weight: bold;

	background-color: #000000;
	margin: 0px;
	overflow: hidden;
}

#content {
	width: 640px;
	margin: 0 auto;
}

.gridBox {
	float: left;
	background-repeat: no-repeat;
	background-position: 0 0px;
	background-color: #222;
	background-size: 320px 300px;
	border: 0px solid #666;
	width: 320px;
	height: 100px;
	position: relative;
}
.gridBox p{
	font-size: 1.2rem;
	opacity: .8;
	position:absolute;
	top: 30%;
	left:50%;
	-moz-transform:translate(-50%, -50%);
	-webkit-transform:translate(-50%, -50%);
	-o-transform:translate(-50%, -50%);
	-ms-transform:translate(-50%, -50%);
	transform:translate(-50%, -50%);
	text-shadow: 1px 1px 3px #000;
}

.gridBox:hover {
	background-position: 0 -100px;
	background-color: #322;
	cursor: pointer;
}

.gridBox.active, .gridbox.active:hover {
	background-position: 0 -200px;
	cursor: auto;
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
	margin-top: 10%;
	display: none;
	position: relative;
	z-index: 9999;
	font-size: 1.5rem;
}
.ans:nth-child(5){
	display: block;
}
canvas{
	position:absolute;
	top:50%;
	left:50%;
	-moz-transform:translate(-50%, -50%);
	-webkit-transform:translate(-50%, -50%);
	-o-transform:translate(-50%, -50%);
	-ms-transform:translate(-50%, -50%);
	transform:translate(-50%, -50%);
	z-index: 100;
}

#content div{
	display: none;
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



<body onload="init();">


<a href="check_free.php"><button class="nextBtn">＞</button></a>


<!-- We'll use the ID of the div to determine which audio file to play.
These id's match the ones passed into the audioList array. -->
<div id="content">
	<div id="1" onclick="playSound(this)" class="gridBox ans1"><p>スポーツ</p></div>
	<div id="2" onclick="playSound(this)" class="gridBox ans2"><p>映画鑑賞</p></div>
	<div id="3" onclick="playSound(this)" class="gridBox ans3"><p>読書</p></div>
	<div id="4" onclick="playSound(this)" class="gridBox ans4"><p>料理</p></div>
</div>


<script src="js/jquery-1.11.3.min.js"></script>	
<script type="text/javascript" src="js/soundjs-NEXT.combined.js"></script>
<!-- <script src="js/jquery-2.1.4.min.js"></script> -->
<script src="js/examples_sound.js"></script>

<script>
	var ans = document.getElementsByClassName("ans")[4].innerHTML;
	var ans = ans.split(":")[1];
	var ans = ans.split("、");
	// console.log(ans);
	
	for(var i in ans){
		if (ans[i].indexOf("スポーツ") >= 0) {
			$(".ans1").css("display", "block");
		};
		if (ans[i].indexOf("映画鑑賞") >= 0) {
			$(".ans2").css("display", "block");
		};
		if (ans[i].indexOf("読書") >= 0) {
			$(".ans3").css("display", "block");
		};
		if (ans[i].indexOf("料理") >= 0) {
			$(".ans4").css("display", "block");
		};
		console.log(ans);

	}
	

</script>

<script id="editable">
	var preload;

	function init() {
		if (!createjs.Sound.initializeDefaultPlugins()) {
			document.getElementById("error").style.display = "block";
			document.getElementById("content").style.display = "none";
			return;
		}

		//examples.showDistractor("content");
		var assetsPath = "audio/";
		var sounds = [
			{src: "basketball_buzzer.mp3", id: 1},
			{src: "movie_buzzer.mp3", id: 2},
			{src: "magazine.mp3", id: 3},
			{src: "cutting_onion.mp3", id: 4} //OJR would prefer a new sound rather than a copy
		];

		createjs.Sound.alternateExtensions = ["mp3"];	// add other extensions to try loading if the src file extension is not supported
		createjs.Sound.addEventListener("fileload", createjs.proxy(soundLoaded, this)); // add an event listener for when load is completed
		createjs.Sound.registerSounds(sounds, assetsPath);
	}

	function soundLoaded(event) {
		//examples.hideDistractor();
		var div = document.getElementById(event.id);
		div.style.backgroundImage = "url('img/audioButtonSheet.png')";
	}

	function stop() {
		if (preload != null) {
			preload.close();
		}
		createjs.Sound.stop();
	}

	function playSound(target) {
		//Play the sound: play (src, interrupt, delay, offset, loop, volume, pan)
		var instance = createjs.Sound.play(target.id);
		if (instance == null || instance.playState == createjs.Sound.PLAY_FAILED) {
			return;
		}
		target.className = "gridBox active";
		instance.addEventListener("complete", function (instance) {
			target.className = "gridBox";
		});
	}
</script>

</body>
</html>
