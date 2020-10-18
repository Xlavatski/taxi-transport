<?php
require_once("header.php");

if (isset($_SESSION['prijavljen'])) {
    header('Location: index.php');
}

echo "<h2>Login</h2>";

echo "
<form action='' method='POST'>
	<label>Korisničko ime:</label>
	<br>
	<input type='text' name='login_korisnicko_ime' required>
	<br>
	<label>Lozinka:</label>
	<br>
	<input type='password' name='login_lozinka' required>
	<br>
	<input type='submit' value='Login'>
</form>";

if (isset($_GET['logout'])) {
	disconnect();
	session_destroy();
}

if (isset($_POST['login_korisnicko_ime']) && isset($_POST['login_lozinka'])) {
    $login_korisnicko_ime = $_POST['login_korisnicko_ime'];
    $login_lozinka = $_POST['login_lozinka'];

    $sql = "SELECT * FROM korisnik 
						WHERE korisnicko_ime = '".$login_korisnicko_ime."' 
						AND lozinka = '".$login_lozinka."'";
    $r = sql($sql);

    if(mysqli_num_rows($r) === 1) {
		list($korisnik_id, $tip_id, $korisnicko_ime, $lozinka, $ime, $prezime, $email, $slika) = mysqli_fetch_array($r, MYSQLI_BOTH);

		$_SESSION['prijavljen'] = true;
		$_SESSION['id'] = $korisnik_id;
		$_SESSION['tip'] = $tip_id;
		$_SESSION['kor_ime'] = $korisnicko_ime;
		$_SESSION['ime'] = $ime;
		$_SESSION['prezime'] = $prezime;
		$_SESSION['email'] = $email;
		$_SESSION['slika'] = $slika;

		if ($tip_id == 1) {
			$_SESSION['moderator'] = true;
		}
		
		if ($tip_id == 0) {
			$_SESSION['moderator'] = true;
			$_SESSION['admin'] = true;
		}
		
		if ($_SESSION['tip'] == 1) {
			header('Location: moderator.php');
		} else {
			header('Location: index.php');
		}

	} else {
		echo '<h3 class="error">Podaci su neispravni!</h3>';
	}
}

require_once("footer.php")
?>