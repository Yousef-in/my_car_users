<?php
if ($_SERVER["REQUEST_URI"] === "connection.php"){
  header("location: index.html");
  exit;
}
$username = "root";
$password = "";
$host     = "127.0.0.1";
$dbname   = "find_my_car"; 
$port     = "3306";
$dsn = "mysql:host=".$host.";port=".$port.";dbname=".$dbname.";charset=utf8";

try{
  $pdo = new PDO($dsn, $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){ 
  echo "There is some problem in connection: ". $e->getMessage();
}
