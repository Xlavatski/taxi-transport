<?php
require_once("header.php");

if (!isset($_SESSION['admin'])) {
	header("Location: index.php");
}

if (isset($_GET['korisnikIdUredi'])) {
	$korisnikIdUredi = $_GET['korisnikIdUredi'];
	$kor_ime = $_GET['kor_ime'];
	$sql = "SELECT * FROM korisnik WHERE korisnik_id = $korisnikIdUredi";
	$r = sql($sql);
	list($korisnik_id, $tip_id, $korisnicko_ime, $lozinka, $ime, $prezime, $email, $slika) = mysqli_fetch_array($r, MYSQLI_BOTH);

	echo "<h2>Uredite podatke korisnika: <strong>$kor_ime</strong></h2>";

	echo "
	<form action='' method='POST'>
		<label>Korisničko ime:</label>
		<br>
		<input disabled type='text' name='uredi_korisnicko_ime' value='$korisnicko_ime'>
		<br>
		<label>Lozinka:</label>
		<br>
		<input disabled type='text' name='uredi_lozinku' value='$lozinka'>
		<br>
		<label>Ime:</label>
		<br>
		<input type='text' name='uredi_ime' value='$ime'>
		<br>
		<label>Prezime:</label>
		<br>
		<input type='text' name='uredi_prezime' value='$prezime'>
		<br>
		<label>Email:</label>
		<br>
		<input type='text' name='uredi_email' value='$email'>
		<br>
		<label>Slika:</label>
		<br>
		<input type='text' name='uredi_sliku' value='$slika'>
		<br>
		<label>Tip:</label>
		<br>
		<select name='uredi_tip'>";

		$sql_tip_korisnika = "SELECT * FROM tip_korisnika";
		$r_tip_korisnika = sql($sql_tip_korisnika);

		while (list($tip_korisnika, $naziv) = mysqli_fetch_array($r_tip_korisnika, MYSQLI_BOTH)) {
			if ($tip_korisnika == $tip_id) {
				echo "<option selected value='$tip_korisnika'>". tip_korisnika($tip_korisnika) ."</option>";
			} else {
				echo "<option value='$tip_korisnika'>". tip_korisnika($tip_korisnika) ."</option>";
			}
		}

		echo "</select>
		<br>
		<input type='submit' name='uredi' value='Uredi'>
	</form>";

	if (isset($_POST['uredi']) && isset($_POST['uredi_tip']) && $_POST['uredi_tip'] != "") {
		$uredi_ime = $_POST['uredi_ime'];
		$uredi_prezime = $_POST['uredi_prezime'];
		$uredi_email = $_POST['uredi_email'];
		$uredi_sliku = $_POST['uredi_sliku'];
		$uredi_tip = $_POST['uredi_tip'];

		$sql = "UPDATE korisnik SET 
						tip_id='".$uredi_tip."',
						ime='".$uredi_ime."',
						prezime='".$uredi_prezime."',
						email='".$uredi_email."',
						slika='".$uredi_sliku."' 
						WHERE korisnik_id='".$korisnikIdUredi."'";
		sql($sql);

		echo "<h3>Korisnik je uređen -> <a class='veza' href='korisnici.php'>Povratak na korisnike</a></h3>";
	}

} else if (isset($_GET['novi'])) {
	echo "<h2>Novi korisnik</h2>";

	echo "<p>Obavezna polja: *</p>";

	echo "
	<form action='' method='POST'>
		<label>Korisničko ime*:</label>
		<br>
		<input type='text' name='korisnicko_ime' required>
		<br>
		<label>Lozinka*:</label>
		<br>
		<input type='text' name='lozinka' required>
		<br>
		<label>Ime:</label>
		<br>
		<input type='text' name='ime'>
		<br>
		<label>Prezime:</label>
		<br>
		<input type='text' name='prezime'>
		<br>
		<label>Email:</label>
		<br>
		<input type='text' name='email'>
		<br>
		<label>Slika:</label>
		<br>
		<input type='text' name='slika'>
		<br>
		<label>Tip*:</label>
		<br>
		<select name='tip'>";

		$sql_tip_korisnika = "SELECT * FROM tip_korisnika";
		$r_tip_korisnika = sql($sql_tip_korisnika);

		while (list($tip_korisnika, $naziv) = mysqli_fetch_array($r_tip_korisnika, MYSQLI_BOTH)) {
			echo "<option value='$tip_korisnika'>". tip_korisnika($tip_korisnika) ."</option>";
		}
		echo "</select>
		<br>
		<input type='submit' name='novi' value='Unesi'>
	</form>";

	if (isset($_POST['novi']) && isset($_POST['tip']) && $_POST['tip'] != "") {
		$_novo_korisnicko_ime = $_POST['korisnicko_ime'];
		$_nova_lozinka = $_POST['lozinka'];
		$ime = $_POST['ime'];
		$prezime = $_POST['prezime'];
		$email = $_POST['email'];
		$slika = $_POST['slika'];
		$tip = $_POST['tip'];

		$sql = "INSERT INTO korisnik (tip_id, korisnicko_ime, lozinka, ime, prezime, email, slika)
            VALUES ('".$tip."', '".$_novo_korisnicko_ime."', '".$_nova_lozinka."', '".$ime."', '".$prezime."', '".$email."', '".$slika."')";
    sql($sql);

		echo "<h3>Korisnik je dodan -> <a class='veza' href='korisnici.php'>Povratak na korisnike</a></h3>";
	}

} else {
	header("Location: index.php");
}

require_once("footer.php")
?>