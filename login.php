<?php
$page_title = "find My Car | login";
session_start();

require_once("inc/head.php");
require_once("connection.php");

$error = [];

if (isset($_SESSION["user"])) {
  header('location: /home.php');
  exit;
} else {
  if (isset($_POST["login"]) && !empty($_POST)) {
    $username =  trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
    $password =  trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS));
    
    $statment = $pdo->prepare("SELECT * FROM users WHERE username = ?;");
    $statment->execute([$username]);
    $row = $statment->fetch(PDO::FETCH_ASSOC); 

    if (!empty($row)) {
      $hashedPassword = $row["password"];
      if ($row["username"] == $username) {
        if (password_verify($password, $hashedPassword)) {
          if ($row["status"] == 2) {
            $error = ["massege"=>"Your Acount has been blocked plese contact with your admin"];
          } else {
            $_SESSION["username"] = $row["username"];
            $_SESSION["user_id"]  = $row["id"];
            $_SESSION["user_level"]  = $row["level"];
            $_SESSION["user"] = "user";
            header("location: /home.php");
            exit;
          }
        } else {
          $error = ["massege"=>"Invaled username or password"];
        }
      } else {
        $error = ["massege"=>"Invaled username or password"];
      }
    } else {
      $error = ["massege"=>"Invaled username or password"];
    }
  }
}

?>
<nav class="navbar navbar-login navbar-expand-lg"  id="header">
  <div class="container">
    <a class="flex navbar-brand" href="login.php">
      <div class="image">
        <!-- <img class="fulwid" src="images/logo.jpg" alt="logo"> -->
      </div>  
      <h2>
        My Car
     </h2>
    </a>
  </div>
</nav>
<section class="login-page flex">
  <div class="container">
    <div class="login">
      <h1>Login</h1>
      <?php if (!empty($error)) :?>
      <div class="error-massege">
        <p><?php echo $error["massege"] ?></p>
        <hr>
      </div>
      <?php endif ?>
      <form action="login.php" method="POST">
        <input type="text" placeholder="username" name="username" required>
        <input type="password" placeholder="password" name="password" required>
        <hr>
        <button type="submit" name="login">Submet</button>
      </form>
    </div>
  </div>
</section>

<?php require_once("inc/footer.php"); ?>
