<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Token, token, TOKEN');

	require 'funkcije.php';

	if(isset($_SERVER['HTTP_TOKEN']) && isset($_POST['sifra'])){
	$token = $_SERVER['HTTP_TOKEN'];
	$sifra = $_POST['sifra'];
	echo obrisiIzKorpe($token, $sifra);
	}
?>