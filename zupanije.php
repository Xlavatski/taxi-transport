<?php
require_once("header.php");

if (!isset($_SESSION['admin'])) {
	header("Location: index.php");
}

echo "<h2>Županije</h2>";
echo "<a class='veza' href='zupanija.php?nova'>Nova županija</a>";

$sql = "SELECT * FROM zupanija";
$r = sql($sql);

if (mysqli_num_rows($r) > 0) {
	echo "
	<table class='tablica'>
		<tr>
			<th>Naziv</th>
			<th>Moderator</th>	
			<th>Broj vozila</th>
			<th>Uredi</th>
		</tr>";

		while (list($zupanija_id, $moderator_id, $naziv, $broj_vozila) =
								mysqli_fetch_array($r, MYSQLI_BOTH)) {
			echo "<tr>
				<td>$naziv</td>";

				$sql_moder = "SELECT korisnicko_ime FROM korisnik WHERE korisnik_id = $moderator_id";
				$r_moder = sql($sql_moder);
				list($moderator_korisnicko_ime) = mysqli_fetch_array($r_moder, MYSQLI_BOTH);

				echo "<td>$moderator_korisnicko_ime</td>
				<td>$broj_vozila</td>
				<td><a class='veza' href='zupanija.php?zupanijaIdUredi=$zupanija_id&naziv=$naziv'>Uredi</a></td>
			</tr>";
		}

		echo "</table>";
} else {
	echo "<h3>Nema županija u bazi!<h3>";
}

require_once("footer.php")
?>