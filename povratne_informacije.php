<?php
require_once("header.php");

if (!isset($_SESSION['prijavljen'])) {
	header("Location: index.php");
}

echo "<h2>Povratne informacije za potvrđene rezervacije</h2>";

$korisnikId = $_SESSION['id'];

$sql = "SELECT * FROM rezervacija 
	WHERE `status`='1' AND `korisnik_id`='$korisnikId'";
$r = sql($sql);

if (mysqli_num_rows($r) > 0) {
	echo "
	<table class='tablica'>
		<tr>
			<th>Adresa polazišta</th>
			<th>Vrijeme polaska</th>
			<th>Adresa odredišta</th>
			<th>Vrijeme dolaska</th>
			<th>Vozilo</th>
			<th>Status</th>
			<th>Komentar</th>
			<th>Povratna informacija</th>
		</tr>";

		while(list($rezervacija_id, $korisnik_id, $vozilo_id, $adresa_polaska_id, $adresa_odredista_id, $datum_vrijeme_polaska, $datum_vrijeme_dolaska, $komentar, $status) = mysqli_fetch_array($r, MYSQLI_BOTH)) {

			$r_polazak = sql("SELECT grad, ulica FROM adresa WHERE adresa_id='$adresa_polaska_id'");
			list($grad_polaska, $ulica_polaska) = mysqli_fetch_array($r_polazak, MYSQLI_BOTH);

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

				echo "<tr>
				<td><b>$grad_polaska @ $ulica_polaska</b></td>

				<td>".procitaj_datum_iz_baze($datum_vrijeme_polaska)."</td>

				<td><b>$grad_odredista @ $ulica_odredista</b></td>

				<td>".procitaj_datum_iz_baze($datum_vrijeme_dolaska)."</td>

				<td>$naziv_vozila</td>

				<td>".prevedi_status($status)."</td>

				<td>$komentar</td>
				
				<td><a class='veza' href='povratne_informacije.php?info&komentar=$rezervacija_id'>Dodaj ili ažuriraj odgovor</a></td>
			
			</tr>";
		}
		echo "</table>";

		if (isset($_GET['info'])) {
			$rezervacijaIdKomentar = $_GET['komentar'];

			echo "<p><h3>Dodavanje - ažuriranje povratnih informacija</h3></p>";

			$sql_povratna_inf = "SELECT * FROM rezervacija WHERE rezervacija_id='$rezervacijaIdKomentar'";
			$r_povratna_inf = sql($sql_povratna_inf);
			list($rezervacija_id_inf, $korisnik_id_inf, $vozilo_id_inf, $adresa_polaska_id_inf, $adresa_odredista_id_inf, $datum_vrijeme_polaska_inf, $datum_vrijeme_dolaska_inf, $komentar_inf, $status_inf) = mysqli_fetch_array($r_povratna_inf, MYSQLI_BOTH);

			echo "<p>
			<form action='' method='POST'>
				<label>Povratna informacija:</label>
				<br>
				<textarea name='komentar_update'>$komentar_inf</textarea>
				<br>
				<input type='submit' name='update' value='Dodaj - ažuriraj'>
			</form>
			</p>";

			if (isset($_POST['update'])) {
				$update = $_POST['komentar_update'];

				sql("UPDATE rezervacija SET komentar = '".$update."' WHERE rezervacija_id='".$rezervacijaIdKomentar."'");
				
				echo "<h3>Povratna informacija je dodana - ažurirana.</h3>";
				echo "<script>window.location.replace('povratne_informacije.php')</script>";
			}
		}

} else {
	echo "<h3>Nema potvrđenih rezervacija za vas pa ne možete komentirati.<h3>";
}

require_once("footer.php")
?>