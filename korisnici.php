<?php
require_once("header.php");

if (!isset($_SESSION['admin'])) {
	header("Location: index.php");
}

echo "<h2>Korisnici</h2>";
echo "<a class='veza' href='korisnik.php?novi'>Novi korisnik</a>";

$sql = "SELECT * FROM korisnik";
$r = sql($sql);

if (mysqli_num_rows($r) > 0) {
	echo "
	<table class='tablica'>
		<tr>
			<th></th>
			<th>Korisnik</th>	
			<th>Ime</th>
			<th>Prezime</th>
			<th>Email</th>
			<th>Lozinka</th>
			<th>Tip</th>
			<th>Uredi</th>
		</tr>";

		while (list($korisnik_id, $tip_id, $korisnicko_ime, $lozinka, $ime, $prezime, $email, $slika) =
								mysqli_fetch_array($r, MYSQLI_BOTH)) {
			echo "<tr>
				<td><img src='$slika' class='korisnik_img'></td>
				<td>$korisnicko_ime</td>
				<td>$ime</td>
				<td>$prezime</td>
				<td>$email</td>
				<td>$lozinka</td>
				<td>". tip_korisnika($tip_id) ."</td>
				<td><a class='veza' href='korisnik.php?korisnikIdUredi=$korisnik_id&kor_ime=$korisnicko_ime'>Uredi</a></td>
			</tr>";
		}

		echo "</table>";
} else {
	echo "<h3>Nema korisnika u bazi!<h3>";
}

require_once("footer.php")
?>