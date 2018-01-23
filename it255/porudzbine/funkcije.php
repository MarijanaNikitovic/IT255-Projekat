<?php

require_once '../zajednickeFunkcije.php';

function getPorudzbine($token){
    $korisnik_id = tokenToId($token);
    global $conn;
    $query = 'SELECT porudzbina.porudzbina_id, porudzbina.sifra, proizvod.naziv,proizvod.opis, proizvod.cena,  proizvod.slika
	FROM porudzbina, proizvod
	WHERE porudzbina.sifra = proizvod.sifra AND porudzbina.flag = 1 AND porudzbina.korisnik_id = ?
	GROUP BY porudzbina.porudzbina_id';
    $porudzbine = array();
    if ($statement = $conn->prepare($query)) {
        $statement->bind_param('i', $korisnik_id);
        $statement->execute();
        $result = $statement->get_result();
        while ($row = $result->fetch_assoc()) {
            $porudzbina = array();
            $porudzbina['porudzbina_id'] = $row['porudzbina_id'];
            $porudzbina['sifra'] = $row['sifra'];
            $porudzbina['naziv'] = $row['naziv'];
            $porudzbina['opis'] = $row['opis'];
            $porudzbina['cena'] = $row['cena'];
            $porudzbina['slika'] = $row['slika'];
            array_push($porudzbine, $porudzbina);
        }
    }
    $message['porudzbina'] = $porudzbina;
    return json_encode($porudzbine);
}
function dodajUKorpu($token, $sifra){
	$porudzbina_id = tokenToPorudzbina($token);
	$korisnik_id = tokenToId($token);
	global $conn;
	$message = array();
	$query = 'INSERT INTO porudzbina (porudzbina_id, korisnik_id, sifra, flag) VALUES (?, ?, ?, ?)';
	$statement = $conn->prepare($query);
	$flag = 1;
	$statement->bind_param("iiii", $porudzbina_id, $korisnik_id, $sifra, $flag);
	if($statement->execute()){
		$message['success'];
	} else {
		$message['error'];
	}
	return json_encode($message);
}
function obrisiIzKorpe($token, $sifra) {
	$korisnik_id = tokenToId($token);
	print($korisnik_id);
	global $conn;
	$message = array();
	$query = 'DELETE FROM porudzbina WHERE korisnik_id=? AND sifra=?';
	$statement = $conn->prepare($query);
	$statement->bind_param("ii", $korisnik_id, $sifra);
	$statement->execute();
	if($statement->execute()){
		$message['success'];
	} else {
		$message['error'];
	}
	return json_encode($message);
}
function checkout($token){
	$token = str_replace('"', "", $token);
	$korisnik_id = tokenToId($token);
	global $conn;
	$message = array();
	$query = 'UPDATE porudzbina SET flag = 2 WHERE porudzbina.flag = 1 AND porudzbina.korisnik_id =?';
	$statement = $conn->prepare($query);
	$statement->bind_param("i", $korisnik_id);
	if($statement->execute()){
		$message['success'];
	} else {
		$message['error'];
	}
	if(!checkIfPorudzbinaExists($token)){
		createPorudzbina($token);
	}
	return json_encode($message);
}

?>