<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>##META_TITLE##</title>
		<meta name="description" content="##META_DESCRIPTION##" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href='http://fonts.googleapis.com/css?family=Jura:400,300,500,600' rel='stylesheet' type='text/css'>
		<link href="images/favicon.ico" type="image/x-icon" rel="icon">
		<link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/structure.css">
		<link rel="stylesheet" href="css/shadowbox.css">
		<script src="scripts/jquery-1.8.3.min.js"></script>
		<script src="scripts/shadowbox.js"></script>
		<script src="scripts/routines.js"></script>
		<script src="scripts/veriform.js"></script>
	</head>
	<body>
		<div id="site">
			<div id="bando"></div>
			<header>
				<nav id="top">
					<a href="contact.php" title="">contact</a>
					<a href="mentions.php" title="">mentions légales</a>
				</nav>
				<a id="logo" href="/" title="<?php echo ""; ?>"><img src="<?php echo "images/##LOGO##"; ?>" alt="##SITENAME##" width="235" height="121" /></a>
				<p id="baseline">##BASELINE##</p>
				<nav id="main">
					<a href="entreprise.php" title="">Entreprise</a>
					<a href="particulier.php" title="">Particulier</a>
					<a href="installateur.php" title="">Installateur</a>
				</nav>
			</header>
			<div id="wrapper">
				<aside id="left">
					<?php if( is_file('left_##PAGENAME##.php') )
						    include 'left_##PAGENAME##.php';
					?>

					<a id="callback" href="/callback.php" >
						<span class="call-us">On vous rappelle !</span>
						<span class="em">Laissez-nous vos coordonnées, nous vous rappelerons dans de plus brefs délais</span>
					</a>
					<a id="the-who" href="/qui-sommes-nous.php" >Qui sommes-nous ?</a>
				</aside>
				<div id="center">
					##CONTENT##
				</div>
			</div>
			<footer>
				<span>##FOOTER##</span>
			</footer>
		</div>
	</body>
</html>