<?php
require_once("header.php");

if (!isset($_SESSION['admin'])) {
	header("Location: index.php");
}

if (isset($_GET['zupanijaIdUredi'])) {
	$zupanijaIdUredi = $_GET['zupanijaIdUredi'];
	$naziv = $_GET['naziv'];
	$sql = "SELECT * FROM zupanija WHERE zupanija_id = $zupanijaIdUredi";
	$r = sql($sql);
	list($zupanija_id, $moderator_id, $naziv, $broj_vozila) = mysqli_fetch_array($r, MYSQLI_BOTH);

	$zadnje_vozilo_oznaka = "";
	$sql_vozila = "SELECT oznaka FROM vozilo WHERE zupanija_id=$zupanija_id";
	$r_vozila = sql($sql_vozila);
	while (list($oznaka) = mysqli_fetch_array($r_vozila, MYSQLI_BOTH)) {
		$zadnje_vozilo_oznaka = $oznaka;
	}
	$vozilo_oznaka = substr($zadnje_vozilo_oznaka, 0, -2);

	echo "<h2>Uredite podatke o županiji: <strong>$naziv</strong></h2>";

	echo "
	<form action='' method='POST'>
		<label>Naziv:</label>
		<br>
		<input type='text' name='uredi_naziv' value='$naziv'>
		<br>
		<label>Broj vozila:</label>
		<br>
		<input type='number' name='uredi_broj_vozila' value='$broj_vozila' min='0'>
		<br>
		<label>Naziv vozila:</label>
		<br>
		<input type='text' name='uredi_naziv_vozila' value='$vozilo_oznaka'>
		<br>
		<label>Moderator:</label>
		<br>
		<select name='uredi_moderatora'>";

		$sql_moderatori = "SELECT korisnicko_ime, korisnik_id FROM korisnik WHERE tip_id='1' OR tip_id='0'";
		$r_moderatori = sql($sql_moderatori);

		while (list($moderator_ime, $moderator_kor_id) = mysqli_fetch_array($r_moderatori, MYSQLI_BOTH)) {
			if ($moderator_kor_id == $moderator_id) {
				echo "<option selected value='$moderator_kor_id'>$moderator_ime</option>";
			} else {
				echo "<option value='$moderator_kor_id'>$moderator_ime</option>";
			}
		}

		echo "</select>
		<br>
		<input type='submit' name='uredi' value='Uredi'>
	</form>";

	if (isset($_POST['uredi']) && isset($_POST['uredi_moderatora']) && $_POST['uredi_moderatora'] != "") {
		$uredi_naziv = $_POST['uredi_naziv'];
		$uredi_broj_vozila = $_POST['uredi_broj_vozila'];
		$uredi_naziv_vozila = $_POST['uredi_naziv_vozila'];
		$uredi_moderatora = $_POST['uredi_moderatora'];

		$sql = "UPDATE zupanija SET
						moderator_id='".$uredi_moderatora."',
						naziv='".$uredi_naziv."',
						broj_vozila='".$uredi_broj_vozila."'
						WHERE zupanija_id='$zupanijaIdUredi'";
		sql($sql);

		$vozilo_broj = 1;
		$niz_ideva_vozila_za_zupaniju = array();
		$sql_vozila_zupanije = "SELECT * FROM vozilo WHERE zupanija_id=$zupanijaIdUredi";
		$r_vozila_zupanije = sql($sql_vozila_zupanije);

		while (list($vozilo_id, $vozilo_zupanija_id, $vozilo_oznaka2) = mysqli_fetch_array($r_vozila_zupanije, MYSQLI_BOTH)) {
			$niz_ideva_vozila_za_zupaniju[$vozilo_id] = $vozilo_broj;
			$vozilo_broj++;
		}

		foreach ($niz_ideva_vozila_za_zupaniju as $id => $broj) {
			$sql = "UPDATE vozilo SET 
							oznaka='$uredi_naziv_vozila-$broj'
							WHERE zupanija_id='$zupanijaIdUredi'
							AND vozilo_id='$id'";
			sql($sql);
		}

		echo "<h3>Županija je uređena -> <a class='veza' href='zupanije.php'>Povratak na županije</a></h3>";
	}

} else if (isset($_GET['nova'])) {
	echo "<h2>Nova županija</h2>";

	echo "<p>Obavezna polja: *</p>";

	echo "
	<form action='' method='POST'>
		<label>Ime županije*:</label>
		<br>
		<input type='text' name='naziv_zupanije' required>
		<br>
		<label>Naziv vozila*:</label>
		<br>
		<input type='text' name='naziv_vozila' required>
		<br>
		<label>Broj vozila*:</label>
		<br>
		<input type='number' name='broj_vozila' min='0' required>
		<br>
		<label>Moderator*:</label>
		<br>
		<select name='moderator'>";

		$sql_moderatori = "SELECT korisnicko_ime, korisnik_id FROM korisnik WHERE tip_id='1' OR tip_id='0'";
		$r_moderatori = sql($sql_moderatori);

		while (list($moderator_ime, $moderator_kor_id) = mysqli_fetch_array($r_moderatori, MYSQLI_BOTH)) {
			echo "<option value='$moderator_kor_id'>$moderator_ime</option>";
		}
		echo "</select>
		<br>
		<input type='submit' name='nova' value='Unesi'>
	</form>";

	if (isset($_POST['nova']) && isset($_POST['moderator']) && $_POST['moderator'] != "") {
		$naziv_zupanije = $_POST['naziv_zupanije'];
		$naziv_vozila = $_POST['naziv_vozila'];
		$broj_vozila_u_zupaniji = $_POST['broj_vozila'];
		$moderator = $_POST['moderator'];

		$sql = "INSERT INTO zupanija (moderator_id, naziv, broj_vozila) VALUES
						('".$moderator."', '".$naziv_zupanije."', '".$broj_vozila_u_zupaniji."')";
		sql($sql);
		
		$id_zadnje_zupanije = "";
		$sql_id_zadnje_zupanije = "SELECT zupanija_id FROM zupanija";
		$r_id_zadnje_zupanije = sql($sql_id_zadnje_zupanije);
		while (list($id_zup) = mysqli_fetch_array($r_id_zadnje_zupanije, MYSQLI_BOTH)) {
			$id_zadnje_zupanije = $id_zup;
		}

		for ($i = 1; $i <= $broj_vozila_u_zupaniji; $i++) {
			$novo_vozilo = $naziv_vozila."-".$i;
			$sql_novo_vozilo = "INSERT INTO vozilo (zupanija_id, oznaka) VALUES ('".$id_zadnje_zupanije."', '".$novo_vozilo."')";
			sql($sql_novo_vozilo);
		}

		echo "<h3>Županija je dodana -> <a class='veza' href='zupanije.php'>Povratak na županije</a></h3>";
	}

} else {
	header("Location: index.php");
}

require_once("footer.php")
?>