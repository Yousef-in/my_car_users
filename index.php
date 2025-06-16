<?php
session_start();
if (isset($_SESSION["user"])) {
  header('location: /home.php');
  exit;
} else {
  header("location: /login.php");
  exit;
}
?>