<?php
$page_title = "سيارتى";
require_once("init.php");

$stmt = $pdo->prepare("SELECT * FROM `users` WHERE `status` = ?;");
$stmt->execute([2]);
$block_users =  $stmt->rowCount();

$stmt = $pdo->prepare("SELECT * FROM `cars`;");
$stmt->execute();
$total_cars =  $stmt->rowCount();

$stmt = $pdo->prepare("SELECT * FROM `cars` WHERE user_id = ?;");
$stmt->execute([$_SESSION["user_id"]]);
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM `users`;");
$stmt->execute();
$total_user =  $stmt->rowCount() - 1;

if ($total_cars > 0) {
  $stmt = $pdo->prepare("SELECT * FROM `cars` WHERE `status` = 2");
  $stmt->execute();
  $founded_car =  $stmt->rowCount();

  $stmt = $pdo->prepare("SELECT * FROM `cars` WHERE `status` = 3;");
  $stmt->execute();
  $block_car =  $stmt->rowCount();
} else {
  $founded_car = 0;
  $block_car   = 0;
}

if (isset($_POST["delet"]) && !empty($_POST)) {
	$car_id = trim(filter_input(INPUT_POST, 'car_id', FILTER_SANITIZE_SPECIAL_CHARS)); 

  $stmtment = $pdo->prepare("SELECT * FROM `cars` WHERE `id` = ?;");
  $stmtment->execute([$car_id]);
  $row = $stmtment->fetch(); 

  // $old_image = $row["image"];
  // unlink("images/".$old_image);

  $stmt = $pdo->prepare("DELETE FROM `cars` WHERE `cars`.`id` = ?;");
  $stmt->execute([$car_id]);
  header("location: /home.php");
  exit;
}

$founded = false;
?>
<?php if ($_SESSION["user_level"] == 0) :?>
<div class="dashboard">
  <div class="container">
    <div class="boxes">
      <a href="/manege.php?page=total_car" class="box total-car">
        <h5>Total Car</h5>
        <p><i class="icon fa fa-car-alt"></i><?php echo htmlspecialchars($total_cars); ?></p>
      </a>
      <a href="/manege.php?page=total_user" class="box total-user">
        <h5>Total Users</h5>
        <p><i class="icon fa fa-user"></i><?php echo htmlspecialchars($total_user); ?></p>
      </a>
      <a href="/manege.php?page=founded_car" class="box founded-car">
        <h5>Founded Car</h5>
        <p><i class="icon fa fa-car-side"></i><?php echo htmlspecialchars($founded_car); ?></p>
      </a>
      <a href="/manege.php?page=block_car" class="box block-car">
        <h5>Blocked Car</h5>
        <p><i class="icon fa fa-car-alt"></i><?php echo htmlspecialchars($block_car); ?></p>
      </a>
      <a href="/manege.php?page=block_user" class="box block-user">
        <h5>Blocked users</h5>
        <p><i class="icon fa fa-user-alt-slash"></i><?php echo htmlspecialchars($block_users); ?></p>
      </a>
    </div>
  </div>
</div>
<?php endif; ?>
<section class="section manege">
  <div class="container">
    <div class="head flex-between">
      <h2>Manege:</h2>
      <div class="add">
        <?php if ($_SESSION["user_level"] == 0) :?>
          <a class="add-user" href="/add_user.php"><i class="icon fa fa-user-plus"></i></a>
        <?php endif; ?>
        <a class="flex" href="/add_car.php">+ Add Car</a>
      </div>
    </div>
    <?php if (empty($cars)) : ?>
    <div class="no-car">
      <p>you are not find any car</p>
    </div>
    <?php else: ?>
      <div class="cars-box">
        <?php foreach ($cars as $car) :
          if ($car["status"] == 2) {$founded = true;} else {$founded = false;}?>
        <div class="car col-md-4 col-sm-12 <?php if ($founded) {echo "found";}  ?>">
          <div class="found-cover">
            <p>Founded</p>
          </div>
          <div class="date">
            <p>Date: <?php echo htmlspecialchars($car["date"]) ?></p>
          </div>
          <!-- <div class="image-box ">
            <img src="images/<?php //echo $car["image"] ?>" alt="">
          </div> -->
          <a href="car.php?info&id=<?php echo htmlspecialchars($car["id"]) ?>">
            <div class="car-info">
              <div>
                <div class="location">
                  <img src="images/map-marker-alt.svg" alt="">
                </div>
                <div class="info">
                  <p><b>Bord No:</b> <?php echo htmlspecialchars($car["bord_no"]) ?></p>
                  <p><b>Alt Bord No:</b><br> <?php echo htmlspecialchars($car["alt_bord_no"]) ?></p>
                </div>
              </div>
              <p><?php echo htmlspecialchars($car["location"]) ?></p>
            </div>
          </a>
          <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
            <button class="delet" type="submit" name="delet">Delet</button>
            <button class="edit"><a href="/add_car.php?edit&car_id=<?php echo htmlspecialchars($car["id"]) ?>">Edit</a></button>
            <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($car["id"]) ?>">
          </form>
        </div>
      <?php endforeach ?>
    </div>
    <?php endif ?>
  </div>
</section>

<?php require_once("inc/footer.php"); ?>