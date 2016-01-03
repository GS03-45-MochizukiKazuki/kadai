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
	display: none;
	position: relative;
	z-index: 9999;
	font-size: 1.5rem;
	width: 80%;
	margin: 10% auto 0;
}
.ans:nth-child(6){
	display: block;
	opacity: 0;
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

.modal{
	position: fixed;
	width: 100%;
	height: 100%;
	left: 0;
	top: 0;
	background-color: rgba(0,0,0,0.5);
	z-index: 999;
}

.textSplitLoad {
	display: none;
}
.split {
	visibility: hidden;
	width: 70%;
	margin: 0 auto;
}
#container {
	padding: 100px 0 70px 0;
	width: 100%;
	font-size: 120%;
	text-align: center;
	position: relative;
	z-index: 9999;
}

.active{
	opacity: 1;
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



<a href="confirm_enq.php"><button class="nextBtn">＞</button></a>

<div class="modal"></div>

<div id="container">
</div><!--/#container-->

<script src="js/jquery-1.11.3.min.js"></script>	

<script src="js/three.js"></script>

<script src="javascript/renderers/Projector.js"></script>
<script src="javascript/renderers/CanvasRenderer.js"></script>

<script src="javascript/libs/stats.min.js"></script>
<script src="javascript/libs/tween.min.js"></script>

<script>

	// document.getElementsByClassName("ans")[5].className = "split";
	var ans = document.getElementsByClassName("ans")[5];
	var ans_html = ans.innerHTML;
	var ans_substr = ans_html.substr(0,20);
	var ans_split = ans_html.split(":")[1];

	console.log("ans:"+ans_split);

	$("#container").append("<p class='split'>"+ ans_split +"</p>")

	document.getElementsByClassName("ans")[5].innerHTML = ans_substr + "・・・";

	$(".ans:nth-child(6)").css("opacity", "1");



	var container, stats;
	var camera, scene, renderer, particle;
	var mouseX = 0, mouseY = 0;

	var windowHalfX = window.innerWidth / 2;
	var windowHalfY = window.innerHeight / 2;

	init();
	animate();

	function init() {

		container = document.createElement( 'div' );
		document.body.appendChild( container );

		camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 1, 5000 );
		var cameraDis = Math.floor(Math.random()*100)+500;

		camera.position.z = cameraDis;

		scene = new THREE.Scene();

		var material = new THREE.SpriteMaterial( {
			map: new THREE.CanvasTexture( generateSprite() ),
			blending: THREE.AdditiveBlending
		} );

		for ( var i = 0; i < 1000; i++ ) {

			particle = new THREE.Sprite( material );

			initParticle( particle, i * 10 );

			scene.add( particle );
		}

		renderer = new THREE.CanvasRenderer();
		renderer.setClearColor( 0x000040 );
		renderer.setPixelRatio( window.devicePixelRatio );
		renderer.setSize( window.innerWidth, window.innerHeight );
		container.appendChild( renderer.domElement );

		stats = new Stats();
		stats.domElement.style.position = 'absolute';
		stats.domElement.style.top = '0px';
		container.appendChild( stats.domElement );

		document.addEventListener( 'mousemove', onDocumentMouseMove, false );
		document.addEventListener( 'touchstart', onDocumentTouchStart, false );
		document.addEventListener( 'touchmove', onDocumentTouchMove, false );

		window.addEventListener( 'resize', onWindowResize, false );

	}

	function onWindowResize() {

		windowHalfX = window.innerWidth / 2;
		windowHalfY = window.innerHeight / 2;

		camera.aspect = window.innerWidth / window.innerHeight;
		camera.updateProjectionMatrix();

		renderer.setSize( window.innerWidth, window.innerHeight );

	}

	function generateSprite() {

		var canvas = document.createElement( 'canvas' );
		canvas.width = 16;
		canvas.height = 16;

		var context = canvas.getContext( '2d' );
		var gradient = context.createRadialGradient( canvas.width / 2, canvas.height / 2, 0, canvas.width / 2, canvas.height / 2, canvas.width / 2 );
		// particleの色
		gradient.addColorStop( 0, 'rgba(255,255,255,1)' );
		gradient.addColorStop( 0.2, 'rgba(0,255,255,1)' );
		gradient.addColorStop( 0.4, 'rgba(0,0,64,1)' );
		gradient.addColorStop( 1, 'rgba(0,0,0,1)' );

		context.fillStyle = gradient;
		context.fillRect( 0, 0, canvas.width, canvas.height );

		return canvas;

	}

	function initParticle( particle, delay ) {

		var particle = this instanceof THREE.Sprite ? this : particle;
		var delay = delay !== undefined ? delay : 0;

		particle.position.set( 0, 0, 0 );
		particle.scale.x = particle.scale.y = Math.random() * 50 + 10;

		new TWEEN.Tween( particle )
			.delay( delay)
			.to( {}, 5000 ) //消える時間
			.onComplete( initParticle )
			.start();

		new TWEEN.Tween( particle.position )
			.delay( delay )
			.to( { x: Math.random() * 3000 - 1500, y: Math.random() * 3000 - 1500, z: Math.random() * 4000 - 2000 }, 10000 ) // x,y,z duration
			.start();

		new TWEEN.Tween( particle.scale )
			.delay( delay )
			.to( { x: 0.01, y: 0.01 }, 10000 )
			.start();

	}

	//

	function onDocumentMouseMove( event ) {

		mouseX = event.clientX - windowHalfX;
		mouseY = event.clientY - windowHalfY;
	}

	function onDocumentTouchStart( event ) {

		if ( event.touches.length == 1 ) {

			event.preventDefault();

			mouseX = event.touches[ 0 ].pageX - windowHalfX;
			mouseY = event.touches[ 0 ].pageY - windowHalfY;

		}

	}

	function onDocumentTouchMove( event ) {

		if ( event.touches.length == 1 ) {

			event.preventDefault();

			mouseX = event.touches[ 0 ].pageX - windowHalfX;
			mouseY = event.touches[ 0 ].pageY - windowHalfY;

		}

	}


	function animate() {

		requestAnimationFrame( animate );

		render();
		stats.update();

	}

	function render() {

		TWEEN.update();

		camera.position.x += ( mouseX - camera.position.x ) * 0.05;
		camera.position.y += ( - mouseY - camera.position.y ) * 0.05;
		camera.lookAt( scene.position );

		renderer.render( scene, camera );
		
	}

</script>


<script>
$(function(){
	var setElm = $('.split'),
	delaySpeed = 100,
	fadeSpeed = 0;

	setText = setElm.html();

	setElm.css({visibility:'visible'}).children().addBack().contents().each(function(){
		var elmThis = $(this);
		if (this.nodeType == 3) {
			var $this = $(this);
			$this.replaceWith($this.text().replace(/(\S)/g, '<span class="textSplitLoad">$&</span>'));
		}
	});
	$(window).load(function(){
		splitLength = $('.textSplitLoad').length;
		setElm.find('.textSplitLoad').each(function(i){
			splitThis = $(this);
			splitTxt = splitThis.text();
			splitThis.delay(i*(delaySpeed)).css({display:'inline-block',opacity:'0'}).animate({opacity:'1'},fadeSpeed);
		});
		setTimeout(function(){
				setElm.html(setText);
		},splitLength*delaySpeed+fadeSpeed);
	});
});
</script>


</body>
</html>
