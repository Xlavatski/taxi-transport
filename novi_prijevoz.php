<?php
require_once("header.php");

if (!isset($_SESSION['prijavljen'])) {
	header("Location: index.php");
}

echo "<h2>Novi prijevoz od - do</h2>";

$sql = "SELECT zupanija_id, naziv FROM zupanija";
$r = sql($sql);

if (mysqli_num_rows($r) > 0) {
	echo "
	<p>
		<form action='' method='GET'>
				<label>Županija polaska:</label>
				<br>
				<select name='zupanijaId'>";
					while(list($zupanija_id, $naziv) = mysqli_fetch_array($r, MYSQLI_BOTH)) {
						echo "<option value='$zupanija_id'>$naziv</option>";
					}
				echo "</select>
				<br>
				<input type='submit' name='odabirAdresa' value='Odabir adresa'>
		</form>
	</p>";

} else {
	echo "<h3>Nema županija u bazi pa ne možete ostvariti prijevoz!<h3>";
}

if (isset($_GET['odabirAdresa'])) {
	$zupanija_polaska = $_GET['zupanijaId'];

	$sql_zupanija_naziv = "SELECT naziv FROM zupanija WHERE zupanija_id='$zupanija_polaska'";
	$r_zaupanija_naziv = sql($sql_zupanija_naziv);
	list($zupanija_naziv) = mysqli_fetch_array($r_zaupanija_naziv, MYSQLI_BOTH);

	echo "<p>
		<h3>
			Odabir adrese polaska za: $zupanija_naziv
		</h3>
	</p>";

	$sql_adrese_polaska = "SELECT * FROM adresa WHERE zupanija_id='$zupanija_polaska'";
	$r_adrese_polaska = sql($sql_adrese_polaska);

	$sql_adrese = "SELECT * FROM adresa";
	$r_adrese = sql($sql_adrese);

	echo "
	<p>
		<form action='' method='POST'>
			<label>Adresa polaska:</label>
			<br>
			<select name='adresaPolaskaId'>";
				while(list($adresa_id_polaska, $zupanija_id_polaska, $grad_polaska, $ulica_polaska)= mysqli_fetch_array($r_adrese_polaska, MYSQLI_BOTH)) {
					echo "<option value='$adresa_id_polaska'>$grad_polaska @ $ulica_polaska</option>";
				}
			echo "</select>
			<br>

			<label>Datum i vrijeme polaska:</label>
			<br>
			<input type='text' name='datumIVrijemePolaska' required placeholder='dd.mm.gggg hh:mm:ss'>
			<br>

			<label>Adresa odredišta:</label>
			<br>
			<select name='adresaOdredistaId'>";
				while(list($adresa_id, $zupanija_id, $grad, $ulica)= mysqli_fetch_array($r_adrese, MYSQLI_BOTH)) {
					echo "<option value='$adresa_id'>$grad @ $ulica</option>";
				}
			echo "</select>
			<br>
			<input type='submit' name='novaRezervacija' value='Nova rezervacija'>
		</form>
	</p>";

	if (isset($_POST['novaRezervacija'])) {
		$adresaPolaskaId = $_POST['adresaPolaskaId'];
		$adresaOdredistaId = $_POST['adresaOdredistaId'];
		$datumIVrijemePolaska = spremi_datum_u_bazu($_POST['datumIVrijemePolaska']);

		$sql_taksi = "SELECT r.`rezervacija_id`, v.`vozilo_id`, v.`oznaka`, r.`datum_vrijeme_polaska`, r.`datum_vrijeme_dolaska`
			FROM `vozilo` v, `rezervacija` r
			WHERE v.`vozilo_id`
			NOT IN (
				SELECT v.`vozilo_id` FROM `rezervacija` r, `vozilo` v 
				WHERE (r.`datum_vrijeme_polaska` BETWEEN '$datumIVrijemePolaska' AND DATE_ADD('$datumIVrijemePolaska', INTERVAL 1 HOUR) 
					OR r.`datum_vrijeme_dolaska` BETWEEN '$datumIVrijemePolaska' AND DATE_ADD('$datumIVrijemePolaska', INTERVAL 1 HOUR))
				AND r.`vozilo_id` = v.`vozilo_id` AND v.`zupanija_id` = '$zupanija_polaska' AND r.`status` =  1 )
			AND v.`zupanija_id` = '$zupanija_polaska'";

		$r_taksiji = sql($sql_taksi);

		$taksi_niz = array();
		while(list($rezervacija_id, $v_id, $v_oznaka, $dv_polaska, $dv_dolaska) = mysqli_fetch_array($r_taksiji, MYSQLI_BOTH)) {
			array_push($taksi_niz, $v_id);
		}

		$brSlobodnihVozila = count($taksi_niz);
		if ($brSlobodnihVozila >= 1) {
			$slobodniTaksi = $taksi_niz[0];
			$korisnikId = $_SESSION['id'];

			$sql_nova_rezervacija = "INSERT INTO rezervacija (korisnik_id, vozilo_id, adresa_polaska_id, adresa_odredista_id, datum_vrijeme_polaska, datum_vrijeme_dolaska, komentar, status)
				VALUES ('".$korisnikId."', '".$slobodniTaksi."', '".$adresaPolaskaId."', '".$adresaOdredistaId."', '".$datumIVrijemePolaska."', '0000-00-00 00:00:00', '', '0')";
			sql($sql_nova_rezervacija);
			
			echo "<h3>Rezervacija je zatražena. Pričekajte odobrenje moderatora.</h3>";
		} else {
			echo "<h3 class='error'>Nema slobodnih vozila!</h3>";
		}

	}

}

require_once("footer.php")
?>