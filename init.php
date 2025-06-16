<?php 

session_start();
header_remove('X-Powered-By');
require_once("inc/head.php");
require_once("inc/navbar.php");
require_once("connection.php");

if (!isset($_SESSION["user"])) {
  header('location: /login.php');
  exit;
}

