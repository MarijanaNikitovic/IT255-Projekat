<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Token, token, TOKEN');
	
	require 'funkcije.php';
	
	if (isset($_POST['korisnicko_ime']) && isset($_POST['lozinka']) && isset($_POST['email']) && isset($_POST['adresa'])){
		$korisnicko_ime = $_POST['korisnicko_ime'];
		$lozinka = $_POST['lozinka'];
		$email = $_POST['email'];
		$adresa = $_POST['adresa'];
		echo register($korisnicko_ime, $lozinka, $email, $adresa);
	}

?>