<?php
require_once("header.php");

if (!isset($_SESSION['moderator'])) {
	header("Location: index.php");
}
$korisnikId = $_SESSION['id'];

echo "<h2>Moderatorove stranice</h2>";

echo "<p><a class='veza' href='adrese.php'>Adrese za uređivanje</a></p>";
echo "<p><a class='veza' href='moderator_statisticki_pregled.php'>Moderator statistički pregled</a></p>";

echo "<h3>Zahtjevi za rezervacije po županijama -> potrebna potvrda:</h3>";

$sql = "SELECT * FROM `rezervacija` r, `adresa` a, `zupanija` z 
				WHERE r.`adresa_polaska_id` = a.`adresa_id`
				AND a.`zupanija_id` = z.`zupanija_id` 
				AND z.`moderator_id` = $korisnikId
				AND r.`status` = 0 ";
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
			<th>Korisnik</th>
			<th>Komentar</th>
			<th>Potvrđivanje</th>
			<th>Odbijanje</th>
		</tr>";

		while(list(
			$r_rezervacija_id, $r_korisnik_id, $r_vozilo_id, $r_adresa_polaska_id, $r_adresa_odredista_id, $r_dv_polaska, $r_dv_dolaska, $r_komentar, $r_status,
			$a_adresa_id, $a_zupanija_id, $a_grad, $a_ulica,
			$z_zupanija_id, $z_moderator_id, $z_naziv, $z_broj_vozila
		) = mysqli_fetch_array($r, MYSQLI_BOTH)) {

			echo "<tr>
				<td><b>$a_grad @ $a_ulica</b></td>
				<td>".procitaj_datum_iz_baze($r_dv_polaska)."</td>";

			$r_odrediste = sql("SELECT a.grad, a.ulica 
			FROM adresa a, rezervacija r 
			WHERE r.adresa_polaska_id='$r_adresa_polaska_id' 
			AND r.adresa_odredista_id='$r_adresa_odredista_id'");
			list($grad_odredista, $ulica_odredista) = mysqli_fetch_array($r_odrediste, MYSQLI_BOTH);

			$r_korisnik = sql("SELECT korisnicko_ime 
			FROM korisnik 
			WHERE korisnik_id='$r_korisnik_id'");
			list($korisnik_korisnicko_ime) = mysqli_fetch_array($r_korisnik, MYSQLI_BOTH);

			$r_vozilo = sql("SELECT oznaka 
			FROM vozilo 
			WHERE vozilo_id='$r_vozilo_id'");
			list($naziv_vozila) = mysqli_fetch_array($r_vozilo, MYSQLI_BOTH);

			echo "
			<td><b>$grad_odredista @ $ulica_odredista</b></td>
			<td>".procitaj_datum_iz_baze($r_dv_dolaska)."</td>
			<td>$naziv_vozila</td>
			<td>".prevedi_status($r_status)."</td>
			<td><b>$korisnik_korisnicko_ime</b></td>
			<td>$r_komentar</td>
			";

			echo "
			<td><a class='veza' href='potvrdi_rezervaciju.php?potvrdiRezervacijaId=$r_rezervacija_id'>Potvrdi</a></td>
			<td><a class='veza' href='moderator.php?odbijRezervacijaId=$r_rezervacija_id'>Odbij</a></td>
			";

			echo "</tr>";
		}
		echo "</table>";

	if (isset($_GET['odbijRezervacijaId'])) {
		$odbijRezervacijaId = $_GET['odbijRezervacijaId'];

		$sql = "UPDATE rezervacija SET `status` = '2' WHERE rezervacija_id='".$odbijRezervacijaId."'";
    sql($sql);
    header("Location: moderator.php");
	}

} else {
	echo "<h4>Nema rezervacija za adrese iz županija ovog moderatora!<h4>";
}

require_once("footer.php")
?>