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


canvas{
	position:absolute;
	top:50%;
	left:50%;
	-moz-transform:translate(-50%, -50%);
	-webkit-transform:translate(-50%, -50%);
	-o-transform:translate(-50%, -50%);
	-ms-transform:translate(-50%, -50%);
	transform:translate(-50%, -50%);
	z-index: -9999;
}

.nextBtn:hover{
	background-color: rgba(255,255,255,.2);
}
.ans{
	margin-top: 10%;
	display: none;
	font-size: 1.5rem;
}
.ans:nth-child(2){
	display: block;
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




<a href="check_email.php"><button class="nextBtn">＞</button></a>

<script src="js/three.js"></script>

<script src="javascript/renderers/Projector.js"></script>
<script src="javascript/renderers/CanvasRenderer.js"></script>

<script src="javascript/libs/stats.min.js"></script>

<script>

	var container, stats;
	var camera, scene, renderer, group, particle;
	var mouseX = 0, mouseY = 0;

	var windowHalfX = window.innerWidth / 2;
	var windowHalfY = window.innerHeight / 2;

	var ans = document.getElementsByClassName("ans")[1].innerHTML;
	var ans = ans.split(":")[1];

	console.log("ans:"+ans);

	init();
	animate();

	function init() {

		container = document.createElement( 'div' );
		document.body.appendChild( container );

		camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 1, 3000 );
		camera.position.z = 1000;

		scene = new THREE.Scene();

		var PI2 = Math.PI * 2;
		var program = function ( context ) {

			context.beginPath();
			context.arc( 0, 0, 0.5, 0, PI2, true );
			context.fill();

		};

		group = new THREE.Group();
		scene.add( group );

		for ( var i = 0; i < ans; i++ ) {

			var material = new THREE.SpriteCanvasMaterial( {
				color: Math.random() * 0x808008 + 0x808080,
				program: program
			} );

			particle = new THREE.Sprite( material );
			particle.position.x = Math.random() * 2000 - 1000;
			particle.position.y = Math.random() * 2000 - 1000;
			particle.position.z = Math.random() * 2000 - 1000;
			particle.scale.x = particle.scale.y = Math.random() * 150 + 50;
			group.add( particle );
		}

		renderer = new THREE.CanvasRenderer();
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

		//

		window.addEventListener( 'resize', onWindowResize, false );

	}

	function onWindowResize() {

		windowHalfX = window.innerWidth / 2;
		windowHalfY = window.innerHeight / 2;

		camera.aspect = window.innerWidth / window.innerHeight;
		camera.updateProjectionMatrix();

		renderer.setSize( window.innerWidth, window.innerHeight );

	}

	//

	function onDocumentMouseMove( event ) {

		mouseX = event.clientX - windowHalfX;
		mouseY = event.clientY - windowHalfY;
	}

	function onDocumentTouchStart( event ) {

		if ( event.touches.length === 1 ) {

			event.preventDefault();

			mouseX = event.touches[ 0 ].pageX - windowHalfX;
			mouseY = event.touches[ 0 ].pageY - windowHalfY;

		}

	}

	function onDocumentTouchMove( event ) {

		if ( event.touches.length === 1 ) {

			event.preventDefault();

			mouseX = event.touches[ 0 ].pageX - windowHalfX;
			mouseY = event.touches[ 0 ].pageY - windowHalfY;

		}

	}

	//

	function animate() {

		requestAnimationFrame( animate );

		render();
		stats.update();

	}

	function render() {

		camera.position.x += ( mouseX - camera.position.x ) * 0.05;
		camera.position.y += ( - mouseY - camera.position.y ) * 0.05;
		camera.lookAt( scene.position );

		group.rotation.x += 0.01;
		group.rotation.y += 0.02;

		renderer.render( scene, camera );

	}

</script>


</body>
</html>
