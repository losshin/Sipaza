<?php
$server = 'localhost';
$user = 'root';
$password = '';
$db_name = 'sipaza_db';

try {
    $mySqliCon = mysqli_connect($server, $user, $password, $db_name);
    $pdo = new PDO("mysql:$server=$server;dbname=$db_name", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
?>
