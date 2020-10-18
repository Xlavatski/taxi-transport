<?php
require_once("header.php");

if (!isset($_SESSION['moderator'])) {
	header("Location: index.php");
}
$korisnikId = $_SESSION['id'];

if (isset($_GET['potvrdiRezervacijaId'])) {
	$potvrdiRezervacijaId = $_GET['potvrdiRezervacijaId'];
	echo "<h2>Potvrdi zahtjev:</h2>";

	$sql = "SELECT * FROM rezervacija WHERE rezervacija_id=$potvrdiRezervacijaId";
	$r = sql($sql);
	list($r_rezervacija_id, $r_korisnik_id, $r_vozilo_id, $r_adresa_polaska_id, $r_adresa_odredista_id, $r_dv_polaska, $r_dv_dolaska, $r_komentar, $r_status) = mysqli_fetch_array($r, MYSQLI_BOTH);

	echo "
	<h4>Ako vrijeme trajanja vožnje ostavite prazno, zahtjev će automatski biti odbijen</h4>

	<form action='' method='POST'>
		<label>Trajanje vožnje u minutama:</label>
		<br>
		<input type='number' min='1' name='trajanje_voznje_u_min'>
		<br>
		<input type='submit' name='potvrdi' value='Potvrdi'>
	</form>";

	if (isset($_POST['potvrdi'])) {
		$moze_se_dodijeliti_vozilo = false;
		$trajanje_voznje_u_min = $_POST['trajanje_voznje_u_min'];

		if ($trajanje_voznje_u_min == "") {
			
			$sql = "UPDATE rezervacija SET `status` = '2' WHERE rezervacija_id='".$potvrdiRezervacijaId."'";
			sql($sql);
			header("Location: moderator.php");
		} else {
			
			$sql_dodjeli_vozilo = 
			"SELECT v.oznaka, v.vozilo_id FROM `vozilo` v 
			 WHERE v.`vozilo_id` 
			 	NOT IN (SELECT v.`vozilo_id` FROM `rezervacija` r, `vozilo` v 
								WHERE (r.`datum_vrijeme_polaska` BETWEEN '$r_dv_polaska' AND DATE_ADD('$r_dv_polaska', INTERVAL '".$trajanje_voznje_u_min."' MINUTE) 
								OR r.`datum_vrijeme_dolaska` BETWEEN '$r_dv_polaska' AND DATE_ADD('$r_dv_polaska', INTERVAL '".$trajanje_voznje_u_min."' MINUTE))
				AND r.`vozilo_id` = v.`vozilo_id` AND r.`status` =  1)";
			$r_dodjeli_vozilo = sql($sql_dodjeli_vozilo);

			while(list($oznaka_vozila, $id_dodjeljenog_vozila) = mysqli_fetch_array($r_dodjeli_vozilo, MYSQLI_BOTH)) {
				if ($id_dodjeljenog_vozila != $r_vozilo_id) { $moze_se_dodijeliti_vozilo = true; }
			}

			if ($moze_se_dodijeliti_vozilo) {
				$sql = "UPDATE rezervacija 
								SET `datum_vrijeme_dolaska` = DATE_ADD(`datum_vrijeme_polaska`, INTERVAL '".$trajanje_voznje_u_min."' MINUTE), `status` = '1' 
								WHERE rezervacija_id='".$r_rezervacija_id."'";
                sql($sql);
                header("Location: moderator.php");
			} else {
				echo "<h4 class='error'>Nema slobodnog vozila za traženo vrijeme rezervacije.</h4>";
			}

		}

	}

} else {
	header("Location: moderator.php");
}

require_once("footer.php")
?>