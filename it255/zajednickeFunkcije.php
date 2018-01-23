<?php

require_once 'konfiguracija.php';

function tokenToId($token)
{
    $token = str_replace('"', "", $token);
    global $conn;
    $query = 'SELECT korisnik_id FROM korisnik WHERE token = ?';
    $result = $conn->prepare($query);
    $result->bind_param('s', $token);
    $korisnik_id = array();
    if ($result->execute()) {
        $result = $result->get_result();
        while ($row = $result->fetch_assoc()) {
            $korisnik_id = $row['korisnik_id'];
        }
        return $korisnik_id;
    }
}

function tokenToUsn($token)
{
    $token = str_replace('"', "", $token);
    global $conn;
    $query = 'SELECT korisnicko_ime FROM korisnik WHERE token = ?';
    $result = $conn->prepare($query);
    $result->bind_param('s', $token);
    $korisnik_id = array();
    if ($result->execute()) {
        $result = $result->get_result();
        while ($row = $result->fetch_assoc()) {
            $korisnik_id = $row['korisnik_id'];
        }
        return $korisnik_id;
    }
}

function tokenToPorudzbina($token)
{
    $token = str_replace('"', "", $token);
    $korisnik_id = tokenToId($token);
    global $conn;
    $query = 'SELECT porudzbina.porudzbina_id
      FROM porudzbina
      WHERE porudzbina.korisnik_id = ?';
    $result = $conn->prepare($query);
    $result->bind_param('i', $korisnik_id);
    $id = array();
    if ($result->execute()) {
        $result = $result->get_result();
        while ($row = $result->fetch_assoc()) {
            $korisnik_id = $row['korisnik_id'];
        }
        return $korisnik_id;
    }
}
function checkIfLoggedIn($token)
{
    $token = str_replace('"', "", $token);
    global $conn;
    $query = 'SELECT EXISTS (SELECT * FROM korisnik WHERE token = ?)';
    $statement = $conn->prepare($query);
    $statement->bind_param('s', $token);
    $statement->execute();
    $result = $statement->get_result()->fetch_row()[0];
    if ($result == 1) {
        return true;
    } else {
        return false;
    }
}
function checkIfPorudzbinaExists($token)
{
    $token = str_replace('"', "", $token);
    $korisnik_id = tokenToId($token);
    global $conn;
    $query = 'SELECT EXISTS (SELECT * FROM porudzbina WHERE flag = 1 AND korisnik_id = ?)';
    $statement = $conn->prepare($query);
    $statement->bind_param('i', $korisnik_id);
    $statement->execute();
    $result = $statement->get_result()->fetch_row()[0];
    if ($result == 1) {
        return true;
    } else {
        return false;
    }
}
function createPorudzbina($token) {
    $token = str_replace('"', "", $token);
    $korisnik_id = tokenToId($token);
    global $conn;
    $message = array();
    $query = 'INSERT INTO porudzbina (korisnik_id, flag) VALUES (?, ?)';
    $statement = $conn->prepare($query);
    $flag = 1;
    $statement->bind_param("ii", $korisnik_id, $flag);
    if ($statement->execute()) {
        $message['success'];
    } else {
        $message['error'];
    }
    return json_encode($message);
}
?>