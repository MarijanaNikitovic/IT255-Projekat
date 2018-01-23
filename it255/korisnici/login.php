<?php
header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Token, token, TOKEN');

	require 'funkcije.php';

	if(isset($_POST['korisnicko_ime']) && isset($_POST['lozinka'])){
	$korisnicko_ime = $_POST['korisnicko_ime'];
	$lozinka = $_POST['lozinka'];
	echo login($korisnicko_ime, $lozinka);
	}
?>