<?php

require_once '../zajednickeFunkcije.php';

function getProizvodi(){
    global $conn;
    $message = array();
    $query = 'SELECT  proizvod.sifra, proizvod.naziv, proizvod.opis,proizvod.cena, proizvod.slika
    FROM proizvod
    GROUP BY proizvod.sifra';
    $proizvodi = array();
    $statement = $conn->prepare($query);
    if ($statement->execute()) {
        $result = $statement->get_result();
        while ($row = $result->fetch_assoc()) {
            $proizvod = array();
            $proizvod['sifra'] = $row['sifra'];
            $proizvod['naziv'] = $row['naziv'];
            $proizvod['opis'] = $row['opis'];
			$proizvod['cena'] = $row['cena'];
			$proizvod['slika'] = $row['slika'];
            array_push($proizvodi, $proizvod);
        }
    }
    $message['proizvodi'] = $proizvodi;
    return json_encode($message);
}

?>