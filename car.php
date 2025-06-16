<?php
$page_title = "سيارتى";
require_once("init.php");

if (isset($_GET["info"]) && !empty($_GET)) {
  $car_id = trim(filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT));
  $is_have = false;

  $stmt = $pdo->prepare("SELECT * FROM `cars` WHERE `user_id` = ?");
  $stmt->execute([$_SESSION["user_id"]]);
  $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach ($cars as $car) { 
    $is_have = array_search($car_id, $car);
    if ($is_have) {
      break;
    }
  }

  if ($is_have) {
    $stmt = $pdo->prepare("SELECT * FROM `cars` WHERE `id` = ?");
    $stmt->execute([$car_id]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);
  } else {
    header("location: /index.php");
    exit;
  }
}

?>

<section class="car-information section">
  <div class="container">
    <h2>Car information</h2>
    <div class="info">
      <h4>Bord Number:-</h4>
      <p><?php echo htmlspecialchars($car["bord_no"]) ?></p>
      <h4>Alt Bord Number:-</h4>
      <p><?php echo htmlspecialchars($car["alt_bord_no"]) ?></p>
      <h4>Location:-</h4>
      <p><?php echo htmlspecialchars($car["location"]) ?></p>
      <h4>Date And Time Of Upload:-</h4>
      <p><?php echo htmlspecialchars($car["date"]) ?></p>
      <!-- <h4>image:-</h4>
      <div class="image">
        <img src="images/<?php //echo $car["image"] ?>" alt="car image">
      </div> -->
    </div>
  </div>
</section>

<?php require_once("inc/footer.php") ?>