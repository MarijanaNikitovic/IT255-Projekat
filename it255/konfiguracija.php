<?php

$db_host = 'localhost';
$db_korisnik = 'root';
$db_lozinka = '';
$db_ime = 'it255baza';

$conn = new mysqli($db_host, $db_korisnik, $db_lozinka, $db_ime);

if ($conn->connect_error) {
    die('Connection error: ' . $conn->connect_error);
}

$conn->set_charset('utf8');

?>