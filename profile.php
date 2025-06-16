<?php
$page_title = "سيارتى";
require_once("init.php");

$stmt = $pdo->prepare("SELECT * FROM `users` WHERE `id` = ?");
$stmt->execute([$_SESSION["user_id"]]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM `cars` WHERE `user_id` = ?");
$stmt->execute([$_SESSION["user_id"]]);
$total_car = $stmt->rowCount();

$stmt = $pdo->prepare("SELECT * FROM `cars` WHERE `user_id` = ? AND `status` = '2'");
$stmt->execute([$_SESSION["user_id"]]);
$founded_car = $stmt->rowCount();

?>

<section class="profile">
  <div class="container">
    <div class="user-information ">
      <div class="image flex">
        <i class="icon fa fa-user"></i>
      </div>
      <div class="user-info">
        <p class="username"><?php echo htmlspecialchars($user["username"]) ?></p>
        <p class="full-name"><?php echo htmlspecialchars($user["first_name"]) . " " . htmlspecialchars($user["last_name"]) ?></p>
        <div class="car">
          <p class="search-car">Total Car: <?php echo htmlspecialchars($total_car) ?></p>
          <p class="founded-car">Founded Car: <?php echo htmlspecialchars($founded_car) ?> </p>
        </div>
        <!-- <div class="flex">
          <p>Last Day For Block</p>
          <p><?php //echo htmlspecialchars($user["create_date"]) ?></p>
        </div> -->
      </div>
    </div>
  </div>
</section>

<?php require_once("inc/footer.php"); ?>