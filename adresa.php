<?php
require_once("header.php");

if (!isset($_SESSION['moderator'])) {
	header("Location: index.php");
}

$korisnikId = $_SESSION['id'];

$sql = "SELECT * FROM zupanija WHERE moderator_id=$korisnikId";
$r = sql($sql);

if (isset($_GET['adresaId'])) {
	echo "<h2>Uredi adresu:</h2>";
	$adresaId = $_GET['adresaId'];
	$adresaGrad = $_GET['grad'];
	$adresaUlica = $_GET['ulica'];
	$adresaZupanijaId = $_GET['zupanijaId'];

	echo "
	<form action='' method='POST'>";

	echo "<label>Županija:</label>
	<br>
	<select name='uredi_zupaniju'>";

	while (list($zupanija_id, $moderator_id, $naziv, $broj_vozila) = mysqli_fetch_array($r, MYSQLI_BOTH)) {
		if ($adresaZupanijaId == $zupanija_id) {
			echo "<option selected value='$zupanija_id'>$naziv</option>";	
		} else {
			echo "<option value='$zupanija_id'>$naziv</option>";
		}
	}

	echo "
		</select>
		<br>
		<label>Grad:</label>
		<br>
		<input type='text' name='uredi_grad' value='$adresaGrad' required>
		<br>
		<label>Ulica:</label>
		<br>
		<input type='text' name='uredi_ulicu' value='$adresaUlica' required>
		<br>
		<input type='submit' name='uredi' value='Uredi'>
	</form>";

	if (isset($_POST['uredi'])) {
		$urediZupaniju = $_POST['uredi_zupaniju'];
		$urediUlicu = $_POST['uredi_ulicu'];
		$urediGrad = $_POST['uredi_grad'];

		$sql_uredi = "UPDATE adresa SET `zupanija_id` = '$urediZupaniju', `grad` = '$urediGrad', `ulica` = '$urediUlicu'
						WHERE adresa_id='".$adresaId."'";
		sql($sql_uredi);
		header("Location: adrese.php");
	}

} else if (isset($_GET['nova'])) {
	echo "<h2>Nova adresa:</h2>";

	echo "
	<form action='' method='POST'>

	<label>Županija:</label>
	<br>
	<select name='dodaj_zupaniju'>";

	while (list($zupanija_id, $moderator_id, $naziv, $broj_vozila) = mysqli_fetch_array($r, MYSQLI_BOTH)) {
			echo "<option value='$zupanija_id'>$naziv</option>";
	}

	echo "
		</select>
		<br>
		<label>Grad:</label>
		<br>
		<input type='text' name='dodaj_grad' required>
		<br>
		<label>Ulica:</label>
		<br>
		<input type='text' name='dodaj_ulicu' required>
		<br>
		<input type='submit' name='dodaj' value='Dodaj'>
	</form>";

	if (isset($_POST['dodaj'])) {
		$dodajZupaniju = $_POST['dodaj_zupaniju'];
		$dodajUlicu = $_POST['dodaj_ulicu'];
		$dodajGrad = $_POST['dodaj_grad'];

		$sql_nova = "INSERT INTO  adresa (`zupanija_id`, `grad`, `ulica`) VALUES ('".$dodajZupaniju."', '".$dodajGrad."', '".$dodajUlicu."')";
		sql($sql_nova);
		header("Location: adrese.php");
	}

} else {
	header("Location: index.php");
}

require_once("footer.php")
?>