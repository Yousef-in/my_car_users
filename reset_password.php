<?php
$page_title = "سيارتى";
require_once("init.php");

$massege = [];

if (isset($_POST["reset_password"]) && !empty($_POST)) {
  $user_id = $_SESSION["user_id"];
  $old_password 		 		= trim(filter_input(INPUT_POST, 'old_password', FILTER_SANITIZE_SPECIAL_CHARS));
  $new_password 		 		= trim(filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_SPECIAL_CHARS));
  $confarm_password 		= trim(filter_input(INPUT_POST, 'confarm_password', FILTER_SANITIZE_SPECIAL_CHARS));

  $statment = $pdo->prepare("SELECT * FROM `users` WHERE id = ?;");
  $statment->execute([$user_id]);
  $row = $statment->fetch(PDO::FETCH_ASSOC);

  if (password_verify($old_password,$row["password"])) {
    if (!empty($new_password)) {
      if ($new_password === $confarm_password) {
        $hash_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE `users` SET `password` = :hash_password WHERE `id` = :user_id ;");
        $stmt->execute(["hash_password"=>$hash_password, "user_id"=>$user_id]);
        $massege = ["status" => "success", "massege" => "Note: Successfull To Reset Password"];
      } else {
        $massege = ["status" => "error", "massege" => "Note: New Password And Confarm Password Is Not Match"];
      }
    } else {
      $massege = ["status" => "error", "massege" => "Note: New Password Can't Be Epty"];
    }
  } else {
    $massege = ["status" => "error", "massege" => "Note: Old Password Is Not Corect"];
  }

}

?>

<section class="reset-password section">
  <div class="container">
    <div class="box">
      <h2>Reset Password</h2>
      <?php if (!empty($massege)) : ?>
      <div class="massege <?php echo $massege["status"] ?>">
        <p><?php echo $massege["massege"] ?></p>
      </div>
      <?php endif; ?>
      <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST">
        <div>
          <label for="old_password">Old Password</label></br>
          <input type="password" name="old_password" id="old_password" required>
        </div>
        <div>
          <label for="new_password">New Password</label></br>
          <input type="password" name="new_password" id="new_password" >
        </div>
        <div>
          <label for="confarm_password">Confarm New Password</label></br>
          <input type="password" name="confarm_password" id="confarm_password" >
        </div>
        <button class="btn" type="submit" name="reset_password">Reset Password</button>
      </form>
    </div>
  </div>
</section>

<?php require_once("inc/footer.php"); ?>