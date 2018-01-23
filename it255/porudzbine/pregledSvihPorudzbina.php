<?php
	if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
		die();
	}
function getUsers() {
	$connection = mysqli_connect("localhost", "root", "", "it255baza") or die("Error ". mysqli_error($connection));
	$query = 'SELECT porudzbina.porudzbina_id, korisnik.korisnicko_ime, proizvod.sifra, proizvod.naziv, proizvod.opis FROM porudzbina, korisnik, proizvod
	WHERE porudzbina.korisnik_id=korisnik.korisnik_id AND porudzbina.sifra=proizvod.sifra
    AND flag = 2
	ORDER BY korisnik.korisnicko_ime';
	$result = mysqli_query($connection, $query) or die("Error".mysqli_error($connection));
	
	$niz = array();
	while($row = mysqli_fetch_assoc($result)){
		$niz[] = $row;
	}
	return json_encode($niz);
}
?>