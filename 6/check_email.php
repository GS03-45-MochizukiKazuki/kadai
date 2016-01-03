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

#info {
	position: absolute;
	top: 10px;
	width: 100%;
	text-align: center;
	z-index: 100;
	display:block;
}
#info a, .button { color: #f00; font-weight: bold; text-decoration: underline; cursor: pointer }


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
.ans:nth-child(3){
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




<a href="check_sex.php"><button class="nextBtn">＞</button></a>


<div id="info">
<span class="button" id="color">change color</span>,
	<span class="button" id="font">change font</span>,
	<span class="button" id="weight">change weight</span>,
	<span class="button" id="bevel">change bevel</span>,
	<span class="button" id="postprocessing">change postprocessing</span>,
	<a id="permalink" href="#">permalink</a>
</div>


<script src="js/three.js"></script>
<script src="js/jquery-2.1.4.min.js"></script>
<script src="javascript/utils/GeometryUtils.js"></script>

<script src="javascript/shaders/ConvolutionShader.js"></script>
<script src="javascript/shaders/CopyShader.js"></script>
<script src="javascript/shaders/FilmShader.js"></script>
<script src="javascript/shaders/FXAAShader.js"></script>

<script src="javascript/postprocessing/EffectComposer.js"></script>
<script src="javascript/postprocessing/RenderPass.js"></script>
<script src="javascript/postprocessing/ShaderPass.js"></script>
<script src="javascript/postprocessing/MaskPass.js"></script>
<script src="javascript/postprocessing/BloomPass.js"></script>
<script src="javascript/postprocessing/FilmPass.js"></script>

<script src="javascript/Detector.js"></script>
<script src="javascript/libs/stats.min.js"></script>

<script src="javascript/geometries/TextGeometry.js"></script>
<script src="javascript/utils/FontUtils.js"></script>

<script src="fonts/gentilis_bold.typeface.js"></script>
<script src="fonts/gentilis_regular.typeface.js"></script>
<script src="fonts/optimer_bold.typeface.js"></script>
<script src="fonts/optimer_regular.typeface.js"></script>
<script src="fonts/helvetiker_bold.typeface.js"></script>
<script src="fonts/helvetiker_regular.typeface.js"></script>
<script src="fonts/droid/droid_sans_regular.typeface.js"></script>
<script src="fonts/droid/droid_sans_bold.typeface.js"></script>
<script src="fonts/droid/droid_serif_regular.typeface.js"></script>
<script src="fonts/droid/droid_serif_bold.typeface.js"></script>

<!-- replace built-in triangulation with PnlTri.js -->
<script src="javascript/libs/pnltri.min.js"></script>
<script>
	THREE.Shape.Utils.triangulateShape = ( function () {
		var pnlTriangulator = new PNLTRI.Triangulator();
		return function triangulateShape( contour, holes ) {
			// console.log("new Triangulation: PnlTri.js " + PNLTRI.REVISION );
			return pnlTriangulator.triangulate_polygon( [ contour ].concat(holes) );
		};
	} )();
</script>


<script>

if ( ! Detector.webgl ) Detector.addGetWebGLMessage();

var container, stats, permalink, hex, color;

var camera, cameraTarget, scene, renderer;

var composer;
var effectFXAA;

var group, textMesh1, textMesh2, textGeo, material;

var firstLetter = true;

var ans = document.getElementsByClassName("ans")[2].innerHTML;
var ans = ans.split(":")[1];

console.log("ans:"+ans);

var text = ans,

	height = 20,
	size = 30,
	hover = 20,

	curveSegments = 4,

	bevelThickness = 2,
	bevelSize = 1.5,
	bevelSegments = 3,
	bevelEnabled = true,

	font = "optimer", // helvetiker, optimer, gentilis, droid sans, droid serif
	weight = "bold", // normal bold
	style = "normal"; // normal italic

var mirror = true;

var fontMap = {

	"helvetiker": 0,
	"optimer": 1,
	"gentilis": 2,
	"droid sans": 3,
	"droid serif": 4

};

var weightMap = {

	"normal": 0,
	"bold": 1

};

var reverseFontMap = {};
var reverseWeightMap = {};

for ( var i in fontMap ) reverseFontMap[ fontMap[i] ] = i;
for ( var i in weightMap ) reverseWeightMap[ weightMap[i] ] = i;

var targetRotation = 0;
var targetRotationOnMouseDown = 0;

var mouseX = 0;
var mouseXOnMouseDown = 0;

var windowHalfX = window.innerWidth / 2;
var windowHalfY = window.innerHeight / 2;

var postprocessing = { enabled : false };
var glow = 0.9;

init();
animate();

function capitalize( txt ) {

	return txt.substring( 0, 1 ).toUpperCase() + txt.substring( 1 );

}

function decimalToHex( d ) {

	var hex = Number( d ).toString( 16 );
	hex = "000000".substr( 0, 6 - hex.length ) + hex;
	return hex.toUpperCase();

}

function init() {

	container = document.createElement( 'div' );
	document.body.appendChild( container );

	permalink = document.getElementById( "permalink" );

	// CAMERA

	camera = new THREE.PerspectiveCamera( 30, window.innerWidth / window.innerHeight, 1, 1500 );
	camera.position.set( 0, 400, 700 );

	cameraTarget = new THREE.Vector3( 0, 150, 0 );

	// SCENE

	scene = new THREE.Scene();
	scene.fog = new THREE.Fog( 0x000000, 250, 1400 );

	// LIGHTS

	var dirLight = new THREE.DirectionalLight( 0xffffff, 0.125 );
	dirLight.position.set( 0, 0, 1 ).normalize();
	scene.add( dirLight );

	var pointLight = new THREE.PointLight( 0xffffff, 1.5 );
	pointLight.position.set( 0, 100, 90 );
	scene.add( pointLight );

	//text = capitalize( font ) + " " + capitalize( weight );
	//text = "abcdefghijklmnopqrstuvwxyz0123456789";
	//text = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

	// Get text from hash

	var hash = document.location.hash.substr( 1 );

	if ( hash.length !== 0 ) {

		var colorhash  = hash.substring( 0, 6 );
		var fonthash   = hash.substring( 6, 7 );
		var weighthash = hash.substring( 7, 8 );
		var pphash 	   = hash.substring( 8, 9 );
		var bevelhash  = hash.substring( 9, 10 );
		var texthash   = hash.substring( 10 );

		hex = colorhash;
		pointLight.color.setHex( parseInt( colorhash, 16 ) );

		font = reverseFontMap[ parseInt( fonthash ) ];
		weight = reverseWeightMap[ parseInt( weighthash ) ];

		postprocessing.enabled = parseInt( pphash );
		bevelEnabled = parseInt( bevelhash );

		text = decodeURI( texthash );

		updatePermalink();

	} else {

		pointLight.color.setHSL( Math.random(), 1, 0.5 );
		hex = decimalToHex( pointLight.color.getHex() );

	}

	material = new THREE.MeshFaceMaterial( [
		new THREE.MeshPhongMaterial( { color: 0xffffff, shading: THREE.FlatShading } ), // front
		new THREE.MeshPhongMaterial( { color: 0xffffff, shading: THREE.SmoothShading } ) // side
	] );

	group = new THREE.Group();
	group.position.y = 100;

	scene.add( group );

	createText();

	var plane = new THREE.Mesh(
		new THREE.PlaneBufferGeometry( 10000, 10000 ),
		new THREE.MeshBasicMaterial( { color: 0xffffff, opacity: 0.5, transparent: true } )
	);
	plane.position.y = 100;
	plane.rotation.x = - Math.PI / 2;
	scene.add( plane );

	// RENDERER

	renderer = new THREE.WebGLRenderer( { antialias: true } );
	renderer.setClearColor( scene.fog.color );
	renderer.setPixelRatio( window.devicePixelRatio );
	renderer.setSize( window.innerWidth, window.innerHeight );
	container.appendChild( renderer.domElement );

	// STATS

	stats = new Stats();
	stats.domElement.style.position = 'absolute';
	stats.domElement.style.top = '0px';
	//container.appendChild( stats.domElement );

	// EVENTS

	document.addEventListener( 'mousedown', onDocumentMouseDown, false );
	document.addEventListener( 'touchstart', onDocumentTouchStart, false );
	document.addEventListener( 'touchmove', onDocumentTouchMove, false );
	document.addEventListener( 'keypress', onDocumentKeyPress, false );
	document.addEventListener( 'keydown', onDocumentKeyDown, false );

	document.getElementById( "color" ).addEventListener( 'click', function() {

		pointLight.color.setHSL( Math.random(), 1, 0.5 );
		hex = decimalToHex( pointLight.color.getHex() );

		updatePermalink();

	}, false );

	document.getElementById( "font" ).addEventListener( 'click', function() {

		if ( font == "helvetiker" ) {

			font = "optimer";

		} else if ( font == "optimer" ) {

			font = "gentilis";

		} else if ( font == "gentilis" ) {

			font = "droid sans";

		} else if ( font == "droid sans" ) {

			font = "droid serif";

		} else {

			font = "helvetiker";

		}

		refreshText();

	}, false );

	document.getElementById( "weight" ).addEventListener( 'click', function() {

		if ( weight == "bold" ) {

			weight = "normal";

		} else {

			weight = "bold";

		}

		refreshText();

	}, false );

	document.getElementById( "bevel" ).addEventListener( 'click', function() {

		bevelEnabled = !bevelEnabled;

		refreshText();

	}, false );

	document.getElementById( "postprocessing" ).addEventListener( 'click', function() {

		postprocessing.enabled = !postprocessing.enabled;
		updatePermalink();

	}, false );


	// POSTPROCESSING

	renderer.autoClear = false;

	var renderModel = new THREE.RenderPass( scene, camera );
	var effectBloom = new THREE.BloomPass( 0.25 );
	var effectFilm = new THREE.FilmPass( 0.5, 0.125, 2048, false );

	effectFXAA = new THREE.ShaderPass( THREE.FXAAShader );

	var width = window.innerWidth || 2;
	var height = window.innerHeight || 2;

	effectFXAA.uniforms[ 'resolution' ].value.set( 1 / width, 1 / height );

	effectFilm.renderToScreen = true;

	composer = new THREE.EffectComposer( renderer );

	composer.addPass( renderModel );
	composer.addPass( effectFXAA );
	composer.addPass( effectBloom );
	composer.addPass( effectFilm );

	//

	window.addEventListener( 'resize', onWindowResize, false );

}

function onWindowResize() {

	windowHalfX = window.innerWidth / 2;
	windowHalfY = window.innerHeight / 2;

	camera.aspect = window.innerWidth / window.innerHeight;
	camera.updateProjectionMatrix();

	renderer.setSize( window.innerWidth, window.innerHeight );

	composer.reset();

	effectFXAA.uniforms[ 'resolution' ].value.set( 1 / window.innerWidth, 1 / window.innerHeight );

}

//

function boolToNum( b ) {

	return b ? 1 : 0;

}

function updatePermalink() {

	var link = hex + fontMap[ font ] + weightMap[ weight ] + boolToNum( postprocessing.enabled ) + boolToNum( bevelEnabled ) + "#" + encodeURI( text );

	permalink.href = "#" + link;
	window.location.hash = link;

}

function onDocumentKeyDown( event ) {

	if ( firstLetter ) {

		firstLetter = false;
		text = "";

	}

	var keyCode = event.keyCode;

	// backspace

	if ( keyCode == 8 ) {

		event.preventDefault();

		text = text.substring( 0, text.length - 1 );
		refreshText();

		return false;

	}

}

function onDocumentKeyPress( event ) {

	var keyCode = event.which;

	// backspace

	if ( keyCode == 8 ) {

		event.preventDefault();

	} else {

		var ch = String.fromCharCode( keyCode );
		text += ch;

		refreshText();

	}

}

function createText() {

	textGeo = new THREE.TextGeometry( text, {

		size: size,
		height: height,
		curveSegments: curveSegments,

		font: font,
		weight: weight,
		style: style,

		bevelThickness: bevelThickness,
		bevelSize: bevelSize,
		bevelEnabled: bevelEnabled,

		material: 0,
		extrudeMaterial: 1

	});

	textGeo.computeBoundingBox();
	textGeo.computeVertexNormals();

	// "fix" side normals by removing z-component of normals for side faces
	// (this doesn't work well for beveled geometry as then we lose nice curvature around z-axis)

	if ( ! bevelEnabled ) {

		var triangleAreaHeuristics = 0.1 * ( height * size );

		for ( var i = 0; i < textGeo.faces.length; i ++ ) {

			var face = textGeo.faces[ i ];

			if ( face.materialIndex == 1 ) {

				for ( var j = 0; j < face.vertexNormals.length; j ++ ) {

					face.vertexNormals[ j ].z = 0;
					face.vertexNormals[ j ].normalize();

				}

				var va = textGeo.vertices[ face.a ];
				var vb = textGeo.vertices[ face.b ];
				var vc = textGeo.vertices[ face.c ];

				var s = THREE.GeometryUtils.triangleArea( va, vb, vc );

				if ( s > triangleAreaHeuristics ) {

					for ( var j = 0; j < face.vertexNormals.length; j ++ ) {

						face.vertexNormals[ j ].copy( face.normal );

					}

				}

			}

		}

	}

	var centerOffset = -0.5 * ( textGeo.boundingBox.max.x - textGeo.boundingBox.min.x );

	textMesh1 = new THREE.Mesh( textGeo, material );

	textMesh1.position.x = centerOffset;
	textMesh1.position.y = hover;
	textMesh1.position.z = 0;

	textMesh1.rotation.x = 0;
	textMesh1.rotation.y = Math.PI * 2;

	group.add( textMesh1 );

	if ( mirror ) {

		textMesh2 = new THREE.Mesh( textGeo, material );

		textMesh2.position.x = centerOffset;
		textMesh2.position.y = -hover;
		textMesh2.position.z = height;

		textMesh2.rotation.x = Math.PI;
		textMesh2.rotation.y = Math.PI * 2;

		group.add( textMesh2 );

	}

}

function refreshText() {

	updatePermalink();

	group.remove( textMesh1 );
	if ( mirror ) group.remove( textMesh2 );

	if ( !text ) return;

	createText();

}

function onDocumentMouseDown( event ) {

	event.preventDefault();

	document.addEventListener( 'mousemove', onDocumentMouseMove, false );
	document.addEventListener( 'mouseup', onDocumentMouseUp, false );
	document.addEventListener( 'mouseout', onDocumentMouseOut, false );

	mouseXOnMouseDown = event.clientX - windowHalfX;
	targetRotationOnMouseDown = targetRotation;

}

function onDocumentMouseMove( event ) {

	mouseX = event.clientX - windowHalfX;

	targetRotation = targetRotationOnMouseDown + ( mouseX - mouseXOnMouseDown ) * 0.02;

}

function onDocumentMouseUp( event ) {

	document.removeEventListener( 'mousemove', onDocumentMouseMove, false );
	document.removeEventListener( 'mouseup', onDocumentMouseUp, false );
	document.removeEventListener( 'mouseout', onDocumentMouseOut, false );

}

function onDocumentMouseOut( event ) {

	document.removeEventListener( 'mousemove', onDocumentMouseMove, false );
	document.removeEventListener( 'mouseup', onDocumentMouseUp, false );
	document.removeEventListener( 'mouseout', onDocumentMouseOut, false );

}

function onDocumentTouchStart( event ) {

	if ( event.touches.length == 1 ) {

		event.preventDefault();

		mouseXOnMouseDown = event.touches[ 0 ].pageX - windowHalfX;
		targetRotationOnMouseDown = targetRotation;

	}

}

function onDocumentTouchMove( event ) {

	if ( event.touches.length == 1 ) {

		event.preventDefault();

		mouseX = event.touches[ 0 ].pageX - windowHalfX;
		targetRotation = targetRotationOnMouseDown + ( mouseX - mouseXOnMouseDown ) * 0.05;

	}

}

//

function animate() {

	requestAnimationFrame( animate );

	render();
	stats.update();

}

function render() {

	group.rotation.y += ( targetRotation - group.rotation.y ) * 0.05;

	camera.lookAt( cameraTarget );

	renderer.clear();

	if ( postprocessing.enabled ) {

		composer.render( 0.05 );

	} else {

		renderer.render( scene, camera );

	}

}

</script>


</body>
</html>
