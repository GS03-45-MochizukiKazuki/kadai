<?php 
include("assets/func.php");

$title = "Mental Energy | TOP"; 
$cssHref = "top.css";

include("assets/html/meta.php");

?>

<header class="header">
	<div class="header__logo"></div>
	<nav class="header__nav">
		<ul class="header__list">
			<li class="header__item header__item1">
				<a class="header__link" href="app.php">app</a>
			</li>
			<li class="header__item header__item2">
				<a class="header__link" href="#about">about</a>
			</li>
			<li class="header__item header__item3">
				<a class="header__link" href="login.php">login</a>
			</li>
		</ul>
	</nav>
</header>

<main>
	<div class="register"></div>
</main>




<?php 
include("assets/html/footer.php");
?>