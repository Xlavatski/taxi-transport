<?php 
$baza = 'iwa_2017_kz_projekt';
$korisnik = 'iwa_2017';
$lozinka = 'foi2017';
$server = 'localhost';
$connection = mysqli_connect($server, $korisnik, $lozinka, $baza);

function connect() {
	global $baza;
	global $korisnik;
	global $lozinka;
	global $server;
	global $connection;
    
	$connection = mysqli_connect($server, $korisnik, $lozinka, $baza);
	if (mysqli_connect_errno()) {
		error(mysqli_connect_error());
		die();
	}
	
	mysqli_set_charset($connection, "utf8");
	if (!mysqli_set_charset($connection, "utf8"))	{
		error(mysqli_error($connection));
		die();
	}
}

function disconnect() {
	global $connection;
	mysqli_close($connection);
}

function sql($sql) {
	global $connection;
	$r = mysqli_query($connection, $sql);
	if (! $r)
		error(mysqli_error($connection));
	return $r;
}

function error($error) {
	echo "ERROR: " . $error;
}

function spremi_datum_u_bazu($d) {
	$datum = explode(" ", $d);
	$datum_kalendar = explode(".", $datum[0]);
	return $datum_kalendar[2]."-".$datum_kalendar[1]."-".$datum_kalendar[0]." ".$datum[1];
}

function procitaj_datum_iz_baze($d) {
	$datum = explode(" ", $d);
	$datum_kalendar = explode("-", $datum[0]);
	return $datum_kalendar[2].".".$datum_kalendar[1].".".$datum_kalendar[0]." ".$datum[1];
}

function prevedi_status($broj_statusa) {
	switch ($broj_statusa) {
		case 0:
		return "Nepotvrđen";
		case 1:
		return "Potvrđen";
		case 2:
		return "Odbijen";
		default:
		return "Nepoznat";
	}
}

function tip_korisnika($tip) {
	switch ($tip) {
		case 0:
		return "administrator";
		case 1:
		return "voditelj";
		case 2:
		return "korisnik";
		default:
		return "nepoznat";
	}
}
?>