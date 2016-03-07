<?php
$description = "ライフハックサービス「メンタルエナジー」！決断を減らす、迷わない人生へ。";
$keyword = "メンタルエナジー,mentalenergy,ライフハック";
$siteTitle = "MentalEnergy";
$creator = "@mo4_9";
$ogp = "http://mental-energy.com/images/ogp.png";
$url = "http://mental-energy.com/";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title><?= htmlenc($title) ?></title>
	<meta name="description" content= <?= $description ?> />
	<meta name="keywords" content= <?= $keyword ?> />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

	<!-- twitter -->
	<meta name="twitter:card" content="summary">
	<meta name="twitter:title" content= <?= $siteTitle ?> />
	<meta name="twitter:description" content= <?= $description ?> />
	<meta name="twitter:image" content= <?= $ogp ?> />
	<meta name="twitter:site" content= <?= $creator ?> />
	<meta name="twitter:creator" content= <?= $creator ?> />

	<!-- facebbok -->
	<meta property="fb:app_id" content="id" />
	<meta property="og:type" content="website">
	<meta property="og:title" content= <?= $siteTitle ?> />
	<meta property="og:image" content= <?= $ogp ?> />
	<meta property="og:url" content= <?= $url ?> />
	<meta property="og:site_name" content= <?= $siteTitle ?> />
	<meta property="og:description" content= <?= $description ?> />
	<meta property="og:locale" content="ja_JP">

	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<link rel="shortcut icon" href="img/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.18.1/build/cssreset/cssreset-min.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/<?= $css_href ?>">
	<script src="js/lib/jquery-2.2.1.min.js"></script>
	<!-- <script src="http://code.jquery.com/jquery-2.2.0.min.js"></script> -->

</head>
<body>
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : 'id',
      xfbml      : true,
      version    : 'v2.5'
    });
  };
  function shareFB(){
    FB.ui({
        method: 'share',
        href: 'http://mental-energy.com/',
      });
  }
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/ja_JP/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>




