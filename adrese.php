<?php
require_once("header.php");

if (!isset($_SESSION['moderator'])) {
	header("Location: index.php");
}

echo "<h2>Moderatorove adrese</h2>";
echo "<a class='veza' href='adresa.php?nova'>Nova adresa</a>";

$korisnikId = $_SESSION['id'];

$sql = "SELECT * FROM zupanija z, adresa a
				WHERE z.moderator_id = $korisnikId
				AND z.zupanija_id = a.zupanija_id
				ORDER BY z.naziv ASC";
$r = sql($sql);

if (mysqli_num_rows($r) > 0) {
	echo "
	<table class='tablica'>
		<tr>
			<th>Adresa</th>	
			<th>Županija</th>
			<th>Broj vozila</th>
			<th>Uredi</th>
		</tr>";

		while (list($zup_zupanija_id, $zup_moderator_id, $zup_naziv, $zup_broj_vozila, 
								$adr_adresa_id, $adr_zupanija_id, $adr_grad, $adr_ulica) =
								mysqli_fetch_array($r, MYSQLI_BOTH)) {
			echo "<tr>
				<td>$adr_grad @ $adr_ulica</td>
				<td>$zup_naziv</td>
				<td>$zup_broj_vozila</td>
				<td><a class='veza' href='adresa.php?adresaId=$adr_adresa_id&zupanijaId=$zup_zupanija_id&grad=$adr_grad&ulica=$adr_ulica'>Uredi</a></td>
			</tr>";
		}

		echo "</table>";
} else {
	echo "<h3>Nema adresa za ovog moderatora!<h3>";
}

require_once("footer.php")
?>