<?php
	session_start();
	include("baza.php");
	connect();
?>

<html>
	<head>
		<meta charset="utf-8" />
		<meta name="autor" content="Dino Glavas"/>
		<meta name="datum" content="21.1.2019."/>
		<title>Projektni zadatak: Taxi prijevoz</title>
		<link rel="stylesheet" type="text/css" href="css.css" />
		<link href="https://fonts.googleapis.com/css?family=Sarabun:400,700" rel="stylesheet">
	</head>
	
	<body>
		
		<div id="header_okvir">
			<section class="content">
				<h1>Projektni zadatak: Taxi prijevoz</h1>
				<a href="index.php">Početna</a> | 
				<?php
				if (isset($_SESSION['prijavljen'])) {
					echo '<a href="login.php?logout">Logout</a>';
				} else {
					echo '<a href="login.php">Login</a>';
				}
				?>
				|
				<a href="o_autoru.php">Autor</a>
				<?php
				if (isset($_SESSION['moderator'])) {
					echo ' | <a href="moderator.php">Moderatorove stranice</a>';
				}
				if (isset($_SESSION['admin'])) {
					echo ' | <a href="admin.php">Administratorove stranice</a>';
				}
				?>
			</section>
		</div>

		<div id="body_okvir">
			<section class="content">
			<?php
			if (isset($_SESSION['prijavljen'])) {
				echo 'Aktivni korisnik: <strong>' . $_SESSION['kor_ime'] . '</strong>, tip: <strong>' . tip_korisnika($_SESSION['tip']) . '</strong>';
			} else {
				echo 'Niste prijavljeni';
			}
			?>
