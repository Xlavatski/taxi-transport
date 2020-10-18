<?php
require_once("header.php");

if (!isset($_SESSION['admin'])) {
	header("Location: index.php");
}

echo "<h2>Administratorove stranice</h2>";
echo "<p><a class='veza' href='korisnici.php'>Korisnici</a></p>";
echo "<p><a class='veza' href='zupanije.php'>Županije</a></p>";

require_once("footer.php")
?>