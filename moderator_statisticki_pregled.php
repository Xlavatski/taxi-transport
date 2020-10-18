<?php
require_once("header.php");

if (!isset($_SESSION['moderator'])) {
	header("Location: index.php");
}
$korisnikId = $_SESSION['id'];

echo "<h4>Odaberite:</h4>
<p><a class='veza' href='moderator_statisticki_pregled.php?odradeni_prijevozi'>Ukupan broj odrađenih prijevoza po vozilu za određeni vremenski interval po županijama moderatora</a></p>
<p><a class='veza' href='moderator_statisticki_pregled.php?top_lista'>Top lista adresa sa najviše rezervacija u županijama moderatora</a></p>
";

if (isset($_GET['odradeni_prijevozi'])) {
	echo "<h2>Ukupan broj odrađenih prijevoza po vozilu za određeni vremenski interval po županijama moderatora</h2>";

	$sql = "";

	echo "
	<form action='' method='POST'>
		<label>Datum i vrijeme početka:</label>
		<br>
		<input type='text' name='dv_pocetka' placeholder='dd.mm.gggg hh:mm:ss' required>
		<br>
		<label>Datum i vrijeme kraja:</label>
		<br>
		<input type='text' name='dv_kraja' placeholder='dd.mm.gggg hh:mm:ss' required>
		<br>
		<input type='submit' name='filter' value='Filtriraj'>
	</form>";

	if (isset($_POST['filter'])) {
		$dv_pocetka = $_POST['dv_pocetka'];
		$dv_kraja = $_POST['dv_kraja'];

		$pocetak = spremi_datum_u_bazu($dv_pocetka);
		$kraj = spremi_datum_u_bazu($dv_kraja);

		$sql = "SELECT z.`naziv`, v.`oznaka`, COUNT(*) AS `svi_pronadeni_prijevozi` 
		FROM `rezervacija` r, `vozilo` v, `zupanija` z 
		WHERE r.`vozilo_id` = v.`vozilo_id`
		AND r.`datum_vrijeme_dolaska` BETWEEN '$pocetak' AND '$kraj' AND r.`status` = 1
		AND v.`zupanija_id` = z.`zupanija_id` 
		AND z.`moderator_id` = 2
		GROUP BY v.`oznaka`";
	} else {
		$sql = "SELECT z.`naziv`, v.`oznaka`, COUNT(*) AS `svi_pronadeni_prijevozi` 
		FROM `rezervacija` r, `vozilo` v, `zupanija` z 
		WHERE r.`vozilo_id` = v.`vozilo_id`
		AND r.`status` = 1 
		AND v.`zupanija_id` = z.`zupanija_id` 
		AND z.`moderator_id` = 2
		AND r.`datum_vrijeme_dolaska` 
		GROUP BY v.`oznaka`";
	}
	$r = sql($sql);

	if (mysqli_num_rows($r) > 0) {
		echo "<table class='tablica'>
		<tr>
			<th>Županija</th>
			<th>Vozilo</th>
			<th>Broj prijevoza</th>
		</tr>";

		while(list($naziv_zupanije, $naziv_vozila, $broj_prijevoza) = mysqli_fetch_array($r, MYSQLI_BOTH)) {
			echo "
			<tr>
				<td>$naziv_zupanije</td>
				<td>$naziv_vozila</td>
				<td>$broj_prijevoza</td>
			</tr>";
		}
		echo "</table>";
	} else {
		echo "<h4>Nema prijevoza za ovaj vremenski interval za ovog moderatora.<h4>";
	}

} else if (isset($_GET['top_lista'])) {
	echo "<h2>Top lista adresa sa najviše rezervacija u županijama moderatora</h2>";

	$sql = "SELECT a.`grad`, a.`ulica`, COUNT(*) AS `broj_rezervacija` 
					FROM `rezervacija` r, `adresa` a, `zupanija` z 
					WHERE r.`adresa_polaska_id` = a.`adresa_id`
					AND a.`zupanija_id` = z.`zupanija_id` 
					AND z.`moderator_id` = '$korisnikId'
					AND r.`status` = 1
					GROUP BY a.adresa_id
					ORDER BY `broj_rezervacija` DESC";
	$r = sql($sql);

	echo "
	<table class='tablica'>
			<tr>
					<th>Adresa</th>
					<th>Broj rezervacija</th>
			</tr>";
	while(list($ulica, $grad, $broj) = mysqli_fetch_array($r, MYSQLI_BOTH)) {
			echo "
			<tr>
					<td>$grad @ $ulica</td>
					<td>$broj</td>
			</tr>";
	}
	echo "</table>";
}

require_once("footer.php")
?>