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
.ans:nth-child(4){
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

<header class="EaselJS"></header>

<div>
	<canvas id="testCanvas" width="960" height="600"
			style="background:black"></canvas>
</div>



<a href="check_syumi.php"><button class="nextBtn">＞</button></a>

<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/examples.js"></script>
<script src="js/easeljs-NEXT.combined.js"></script>

<script id="editable">
	var canvas;
	var stage;

	var imgSeq = new Image();        // The image for the sparkle animation
	var sprite;                        // The animated sparkle template to clone
	var fpsLabel;

	function init() {
		// create a new stage and point it at our canvas:
		canvas = document.getElementById("testCanvas");
		stage = new createjs.Stage(canvas);
		// attach mouse handlers directly to the source canvas.
		// better than calling from canvas tag for cross browser compatibility:
		stage.addEventListener("stagemousemove", moveCanvas);
		stage.addEventListener("stagemousedown", clickCanvas);

		// define simple sprite sheet data specifying the image(s) to use, the size of the frames,
		// and the registration point of the frame
		// it will auto-calculate the number of frames from the image dimensions and loop them
		var ans = document.getElementsByClassName("ans")[3].innerHTML;
		var ans = ans.split(":")[1];
		console.log(ans);
		if (ans.indexOf("男") > 0) {
			var img_src = "img/otoko.png";
		}else{
			var img_src = "img/onna.png";
		};

		var data = {
			images: [ img_src ],
			frames: {width: 21, height: 21, regX: 20, regY: 20}
		};

		// set up an animation instance, which we will clone
		sprite = new createjs.Sprite(new createjs.SpriteSheet(data));

		// add a text object to output the current FPS:
		fpsLabel = new createjs.Text("-- fps", "bold 14px Arial", "#FFF");
		stage.addChild(fpsLabel);
		fpsLabel.x = 20;
		fpsLabel.y = 20;

		// start the tick and point it at the window so we can do some work before updating the stage:
		createjs.Ticker.timingMode = createjs.Ticker.RAF;
		createjs.Ticker.addEventListener("tick", tick);
	}

	function tick(event) {
		// loop through all of the active sparkles on stage:
		var l = stage.getNumChildren();
		var m = event.delta / 16;
		for (var i = l - 1; i > 0; i--) {
			var sparkle = stage.getChildAt(i);

			// apply gravity and friction
			sparkle.vY += 0.8 * m;
			sparkle.vX *= 0.99;

			// update position, scale, and alpha:
			sparkle.x += sparkle.vX * m;
			sparkle.y += sparkle.vY * m;
			sparkle.scaleX = sparkle.scaleY = sparkle.scaleX + sparkle.vS * m;
			sparkle.alpha += sparkle.vA * m;

			//remove sparkles that are off screen or not invisble
			if (sparkle.alpha <= 0 || sparkle.y > canvas.height) {
				stage.removeChildAt(i);
			}
		}

		fpsLabel.text = Math.round(createjs.Ticker.getMeasuredFPS()) + " fps";

		// draw the updates to stage
		stage.update(event);
	}

	//sparkle explosion
	function clickCanvas(evt) {
		addSparkles(Math.random() * 200 + 100 | 0, stage.mouseX, stage.mouseY, 1);
	}

	//sparkle trail
	function moveCanvas(evt) {
		addSparkles(Math.random() * 6 + 3 | 0, stage.mouseX, stage.mouseY, 0.5);
	}

	function addSparkles(count, x, y, speed) {
		//create the specified number of sparkles
		for (var i = 0; i < count; i++) {
			// clone the original sparkle, so we don't need to set shared properties:
			var sparkle = sprite.clone();

			// set display properties:
			sparkle.x = x;
			sparkle.y = y;
			//sparkle.rotation = Math.random()*360;
			sparkle.alpha = Math.random() * 0.5 + 0.5;
			sparkle.scaleX = sparkle.scaleY = Math.random() + 0.3;

			// set up velocities:
			var a = Math.PI * 2 * Math.random();
			var v = (Math.random() - 0.5) * 30 * speed;
			sparkle.vX = Math.cos(a) * v;
			sparkle.vY = Math.sin(a) * v;
			sparkle.vS = (Math.random() - 0.5) * 0.2; // scale
			sparkle.vA = -Math.random() * 0.05 - 0.01; // alpha

			// start the animation on a random frame:
			sparkle.gotoAndPlay(Math.random() * sparkle.spriteSheet.getNumFrames());

			// add to the display list:
			stage.addChild(sparkle);
		}
	}

</script>

</body>
</html>
