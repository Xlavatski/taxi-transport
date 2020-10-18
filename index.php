<?php
require_once("header.php");

if (isset($_SESSION['prijavljen'])) {
	echo "<p>
					<a class='veza' href='novi_prijevoz.php'>Novi prijevoz od - do</a>
				</p>
				<p>
					<a class='veza' href='povratne_informacije.php'>Ostavite povratne informacije za potvrđene rezervacije</a>
				</p>
				";
}

echo "<h2>Početna</h2>";

$sql = "SELECT zupanija_id, naziv FROM zupanija";
$r = sql($sql);

if (mysqli_num_rows($r) > 0) {
	echo "
	<table class='tablica'>
		<tr>
			<th>Popis županija</th>
		</tr>";

		while(list($zupanija_id, $naziv) = mysqli_fetch_array($r, MYSQLI_BOTH)) {
			echo "<tr>
				<td><a class='veza' href='index.php?zupanijaId=$zupanija_id'>$naziv</a></td>
			</tr>";
		}
	echo "</table>";

	if (isset($_GET['zupanijaId'])) {
		$id = $_GET['zupanijaId'];

		$sql = "SELECT r.`rezervacija_id`, r.`korisnik_id`, r.`vozilo_id`, r.`adresa_polaska_id`, r.`adresa_odredista_id`, r.`datum_vrijeme_polaska`, r.`datum_vrijeme_dolaska`, r.`komentar`, r.`status`, a.`adresa_id`, a.`ulica` , a.`grad`
		FROM `rezervacija` r, `adresa` a
		WHERE a.`zupanija_id`='$id'
		AND r.`adresa_polaska_id`=a.`adresa_id`
		ORDER BY r.`datum_vrijeme_polaska` DESC";

		if (!isset($_SESSION['prijavljen'])) {
			$sql .= " LIMIT 3";
		}

		$r = sql($sql);

		if (mysqli_num_rows($r) > 0) {
			echo "
			<table class='tablica'>
				<tr>
					<th>Adresa polazišta</th>
					<th>Vrijeme polaska</th>";
					if (isset($_SESSION['prijavljen'])) {
						echo "<th>Adresa odredišta</th>
						<th>Vrijeme dolaska</th>
						<th>Vozilo</th>
						<th>Status</th>
						<th>Korisnik</th>
						<th>Komentar</th>";
					}
				echo "</tr>";

				while(list($rezervacija_id, $korisnik_id, $vozilo_id, $adresa_polaska_id, $adresa_odredista_id, $dv_polaska, $dv_dolaska, $komentar, $status, $adresa_id, $ulica, $grad) = mysqli_fetch_array($r, MYSQLI_BOTH)) {
					echo "<tr>
						<td><b>$grad @ $ulica</b></td>
						<td>".procitaj_datum_iz_baze($dv_polaska)."</td>";
					if (isset($_SESSION['prijavljen'])) {

						$r_odrediste = sql("SELECT a.grad, a.ulica 
						FROM adresa a, rezervacija r 
						WHERE r.adresa_polaska_id='$adresa_polaska_id' 
						AND r.adresa_odredista_id='$adresa_odredista_id'");
            list($grad_odredista, $ulica_odredista) = mysqli_fetch_array($r_odrediste, MYSQLI_BOTH);

						$r_korisnik = sql("SELECT korisnicko_ime 
						FROM korisnik 
						WHERE korisnik_id='$korisnik_id'");
						list($korisnik_korisnicko_ime) = mysqli_fetch_array($r_korisnik, MYSQLI_BOTH);

						$r_vozilo = sql("SELECT oznaka 
						FROM vozilo 
						WHERE vozilo_id='$vozilo_id'");
            list($naziv_vozila) = mysqli_fetch_array($r_vozilo, MYSQLI_BOTH);

						echo "
						<td><b>$grad_odredista @ $ulica_odredista</b></td>
						<td>".procitaj_datum_iz_baze($dv_dolaska)."</td>
						<td>$naziv_vozila</td>
						<td>".prevedi_status($status)."</td>
						<td><b>$korisnik_korisnicko_ime</b></td>
						<td>$komentar</td>
						";
					}
					echo "</tr>";
				}
				echo "</table>";

		} else {
			echo "<h3>Nema prijevoza za adrese iz ove županije!<h3>";
		}
	}

} else {
	echo "<h3>Nema županija u bazi!<h3>";
}

require_once("footer.php")
?>