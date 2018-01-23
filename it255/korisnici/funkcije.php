<?php
	require_once'../zajednickeFunkcije.php';
	
function login($korisnicko_ime, $lozinka) {
		global $conn;
		$message = array();
		$lozinka = trim($lozinka);
		$hashPwd = md5($lozinka);
		if(checkLogin($korisnicko_ime, $hashPwd)) {
			$token = sha1(uniqid());
			$query = 'UPDATE korisnik SET token = ? WHERE korisnicko_ime = ?';
			$result = $conn->prepare($query);
			$result->bind_param('ss', $token, $korisnicko_ime);
			$result->execute();
			$message['token'] = $token;
			
			if(!checkIfPorudzbinaExists($token)){
				createPorudzbina($token);		
			}
			
			} else {
				$message = 'Pogresno korisnicko ime i/ili sifra';
				header('HTTP/1.1 404 Unauthorized');
		}
		return json_encode($message);
}

function checkLogin($korisnicko_ime, $lozinka){
	global $conn;
	$query = 'SELECT EXISTS(SELECT * FROM korisnik WHERE korisnicko_ime=? AND lozinka=?)';
	$statement = $conn->prepare($query);
	$statement->bind_param("ss", $korisnicko_ime, $lozinka);
	$statement->execute();
	$result = $statement->get_result()->fetch_row()[0];
	if($result == 1){
		return true;
	} else {
		return false;
	}
}

function checkIfuserExists($korisnicko_ime){
	global $conn;
	$query = 'SELECT EXISTS(SELECT * FROM korisnik WHERE korisnicko_ime=?)';
	$statement = $conn->prepare($query);
	$statement->bind_param("s", $korisnicko_ime);
	$statement->execute();
	$result = $statement->get_result()->fetch_row()[0];
	if ($result == 1){
		return true;
	} else {
		return false;
	}
}
function register($korisnicko_ime, $lozinka, $email, $adresa){
	global $conn;
	$message = array();
	$errors = '';
	if (checkIfuserExists($korisnicko_ime)){
		$errors .= 'Korisnik postoji u bazi.';
	}
	if (strlen($lozinka) < 6){
		$errors .= 'Sifra mora imati najmanje 6 karaktera.';
	}
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$errors .= 'Email adresa nije ispravna';
	}
	if ($errors ==''){
		$query = 'INSERT INTO korisnik (korisnicko_ime, lozinka, email, adresa, role_id) VALUES (?, ?, ?, ?, ?)';
		$statement = $conn->prepare($query);
		$lozinka = trim($lozinka);
		$hashPwd = md5($lozinka);
		$role_id = 1;
		$statement->bind_param('ssssi', $korisnicko_ime, $hashPwd, $email, $adresa, $role_id);
		if ($statement->execute()){
				$token = sha1(uniqid());
				$queryTwo = 'UPDATE korisnik SET token=? WHERE korisnicko_ime=?';
				$result = $conn->prepare($queryTwo);
				$result->bind_param('ss', $token, $korisnicko_ime);
				$result->execute();
				$message['token'] = $token;
		} else {
			$message['error'] = 'Problem sa konekcijom.';
			header('HTTP/1.1 400 Bad Request');
		}
	} else {
		header('HTTP/1.1 400 Bad Request');
		$message['error'] = json_encode($errors);
	}
	return json_encode($message);
}
function getUser($token){
	$token = str_replace('"', "", $token);
    global $conn;
    $query = 'SELECT korisnik_id, korisnicko_ime, lozinka, adresa, email, role_id,
      role AS role_name
      FROM korisnik
      WHERE korisnik.token = ?';
    $korisnik = array();
    $statement = $conn->prepare($query);
    $statement->bind_param('i', $token);
    if ($statement->execute()) {
        $result = $statement->get_result();
        while ($row = $result->fetch_assoc()) {
            $korisnik['korisnik_id'] = $row['korisnik_id'];
            $korisnik['korisnicko_ime'] = $row['korisnicko_ime'];
            $korisnik['lozinka'] = $row['lozinka'];
            $korisnik['adresa'] = $row['adresa'];
            $korisnik['email'] = $row['email'];
            $korisnik['role_id'] = $row['role_id'];
            $korisnik['role_name'] = $row['role_name'];
        }
    }
    return json_encode($korisnik);
}

?>