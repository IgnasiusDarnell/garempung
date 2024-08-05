<?php


date_default_timezone_set("Asia/Jakarta");
error_reporting(0);

// $host = 'sql312.infinityfree.com';
// $user = 'if0_37019602';
// $pass = 'kxGCCVdCcsa';
// $dbname = 'if0_37019602_garempung';

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'garempung';

try {
	$config = new PDO("mysql:host=$host;dbname=$dbname;", $user, $pass);
	//echo 'sukses';	
} catch (PDOException $e) {
	echo 'KONEKSI GAGAL' . $e->getMessage();
}
