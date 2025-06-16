<?php
$page_title = "سيارتى";
require_once("init.php");

$massege = [];
$mode = "add";

if (isset($_POST["add"]) && !empty($_POST)) {
	$bord_no 		 		= trim(filter_input(INPUT_POST, 'bord_no', FILTER_SANITIZE_SPECIAL_CHARS));
	$alt_bord_no 		= strtoupper(trim(filter_input(INPUT_POST, 'alt_bord_no', FILTER_SANITIZE_SPECIAL_CHARS)));
	$location		 		= trim(filter_input(INPUT_POST, 'location', FILTER_SANITIZE_SPECIAL_CHARS));
	$user_id 		 		= trim($_SESSION["user_id"]);

	// $image_name 		= $_FILES["image"]["name"];
	// $ext 						= pathinfo($image_name, PATHINFO_EXTENSION);
	// $new_image_name = sha1($image_name. mt_rand()) . "." . $ext;
	// move_uploaded_file($_FILES['image']['tmp_name'], './images/'.$new_image_name);

	function add() {
		global $bord_no;
		global $alt_bord_no;
		global $pdo;
		global $user_id;
		// global $new_image_name;
		global $massege;
		global $location;
		
		$statment = $pdo->prepare("SELECT * FROM `cars`");
		$statment->execute();
		$row = $statment->fetchAll(PDO::FETCH_ASSOC);

		$is_alt_bord_no_exists = false;
		$is_bord_no_exists		 = false;
		
		if (!empty($row)) {
			$statment = $pdo->prepare("SELECT * FROM `cars` WHERE bord_no = ?");
			$statment->execute([$bord_no]);
			$row_count = $statment->rowCount();
			if ($row_count != 0) {
				$is_bord_no_exists = true;
			}
			$statment = $pdo->prepare("SELECT * FROM `cars` WHERE alt_bord_no = ?");
			$statment->execute([$alt_bord_no]);
			$row_count = $statment->rowCount();
			if ($row_count != 0) {
				$is_alt_bord_no_exists = true;
			}
		}
		
		if (!$is_bord_no_exists && !$is_alt_bord_no_exists) {
			$now = new DateTime();
			$date = $now->format('Y-m-d H:i:s');

			$stmt = $pdo->prepare("INSERT INTO `cars` (`bord_no`, `alt_bord_no`, `user_id`, `location`, `date`) VALUES (?, ?, ?, ?, ?);");
      $stmt->execute([$bord_no, $alt_bord_no, $user_id, $location, $date]);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

			$massege = ["status" => "success", "massege" => "Note: add new car information is successfull"];
		} else {
			$massege = ["status" => "error", "massege" => "Note: bord no or alt bord no alredey exest"];	
		}
	}

	if (!empty($bord_no)) {
		add();
	} elseif (!empty($alt_bord_no)) {
		add();
	} else {
		$massege = ["status" => "error", "massege" => "Note: bord no and alt bord no can't let both empty"];
	}

} elseif (isset($_GET["edit"]) && isset($_GET["car_id"])) {
	$mode = "edit";
	$car_id = trim(filter_input(INPUT_GET, 'car_id', FILTER_SANITIZE_SPECIAL_CHARS));
	$stmtment = $pdo->prepare("SELECT * FROM `cars` WHERE `id` = ?;");
  $stmtment->execute([$car_id]);
  $row = $stmtment->fetch(PDO::FETCH_ASSOC); 

} elseif (isset($_POST["update"]) && !empty($_POST)) {
	$mode 							= "update";
	$car_id 		 				= trim(filter_input(INPUT_POST, 'car_id', FILTER_SANITIZE_SPECIAL_CHARS));
	$bord_no 		 				= trim(filter_input(INPUT_POST, 'bord_no', FILTER_SANITIZE_SPECIAL_CHARS));
	$alt_bord_no 				= strtoupper(trim(filter_input(INPUT_POST, 'alt_bord_no', FILTER_SANITIZE_SPECIAL_CHARS)));
	$old_bord_no 		 		= trim(filter_input(INPUT_POST, 'old_bord_no', FILTER_SANITIZE_SPECIAL_CHARS));
	$old_alt_bord_no 		= trim(filter_input(INPUT_POST, 'old_alt_bord_no', FILTER_SANITIZE_SPECIAL_CHARS));
	$location		 				= trim(filter_input(INPUT_POST, 'location', FILTER_SANITIZE_SPECIAL_CHARS));
	$user_id 		 				= trim($_SESSION["user_id"]);

  // if ($_FILES["image"]["error"] !== 4) {
  //   $old_image = $row["image"];
  //   unlink("./images/".$old_image);
  //   $image_name = $_FILES["image"]["name"];
  //   $ext = pathinfo($image_name, PATHINFO_EXTENSION);
  //   $new_image_name = sha1($image_name. mt_rand()) . ".".$ext;
  //   move_uploaded_file($_FILES['image']['tmp_name'], './images/'.$new_image_name);
  // } else {
  //   $new_image_name = $row["image"];
  // }

	$statment = $pdo->prepare("SELECT * FROM `cars`");
	$statment->execute();
	$allrow = $statment->fetchAll(PDO::FETCH_ASSOC);

	$is_alt_bord_no_exists = false;
	$is_bord_no_exists		 = false;
	
	if ($bord_no !== $old_bord_no) {
		$statment = $pdo->prepare("SELECT * FROM `cars` WHERE bord_no = ?");
		$statment->execute([$bord_no]);
		$row_count = $statment->rowCount();

		if ($row_count != 0) {
			$is_bord_no_exists = true;
		} 
	}
	if ($alt_bord_no !== $old_alt_bord_no) {
		$statment = $pdo->prepare("SELECT * FROM `cars` WHERE alt_bord_no = ?");
		$statment->execute([$alt_bord_no]);
		$row_count = $statment->rowCount();

		if ($row_count != 0) {
			$is_alt_bord_no_exists = true;
		}
	}

	function update() {
		global $pdo;
		global $car_id;
		global $bord_no;
		global $location;
		global $alt_bord_no;
		global $massege;
		// global $new_image_name;

		$stmt = $pdo->prepare("UPDATE `cars` SET bord_no = :bord_no WHERE `id` = :id ;");
		$stmt->execute(["bord_no"=>$bord_no, "id"=>$car_id]);
		$stmt = $pdo->prepare("UPDATE `cars` SET alt_bord_no = :alt_bord_no WHERE `id` = :id ;");
		$stmt->execute(["alt_bord_no"=>$alt_bord_no, "id"=>$car_id]);
		$stmt = $pdo->prepare("UPDATE `cars` SET location = :location WHERE `id` = :id ;");
		$stmt->execute(["location"=>$location, "id"=>$car_id]);
		// $stmt = $pdo->prepare("UPDATE `cars` SET `image` = :new_image_name WHERE `id` = :id ;");
		// $stmt->execute(["new_image_name"=>$new_image_name, "id"=>$car_id]);

		$massege = ["status" => "success", "massege" => "Note: successfull to update car information"];
	}
	
	if (!empty($bord_no)) {
		if ($is_alt_bord_no_exists || $is_bord_no_exists) {
			$massege = ["status" => "error", "massege" => "Note: bord no or alt bord no alrydy exist"];
		} else {
			update();
		}
	} elseif (!empty($alt_bord_no)) {
		if ($is_alt_bord_no_exists || $is_bord_no_exists) {
			$massege = ["status" => "error", "massege" => "Note: bord no or alt bord no alrydy exist"];
		} else {			
			update();
		}
	} else {
		$massege = ["status" => "error", "massege" => "Note: bord no and alt bord no can't let both empty"];
	}
	
	$stmt = $pdo->prepare("SELECT * FROM `cars` WHERE `id` = ?");
	$stmt->execute([$car_id]);
	$row = $stmt->fetch(PDO::FETCH_ASSOC); 
}
?>

<?php if ($mode == "edit" || $mode == "update") : ?>
<section class="add-car section">
  <div class="container">
	  <div class="add-form">
			<h2>Edit Car</h2>
			<?php if (!empty($massege)) : ?>
				<div class="massege <?php echo htmlspecialchars($massege["status"]) ?>">
					<p><?php echo htmlspecialchars($massege["massege"]) ?></p>
				</div>
			<?php endif ?>
			<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="car_id" value="<?php echo htmlspecialchars($row["id"]) ?>">
				<div>
					<label for="">Bord No</label><br>
					<input type="hidden" name="old_bord_no" value="<?php echo htmlspecialchars($row["bord_no"]) ?>" required>
					<input type="text" name="bord_no" value="<?php echo htmlspecialchars($row["bord_no"]) ?>" required>
				</div>
				<div>
					<label for="">alt Bord No</label><br>
					<input type="hidden" name="old_alt_bord_no" value="<?php echo htmlspecialchars($row["alt_bord_no"]) ?>" required>
					<input type="text" name="alt_bord_no" value="<?php echo htmlspecialchars($row["alt_bord_no"]) ?>" required>
				</div>
				<!-- <div>
					<div class="old-image">
						<p>Old image</p>
						<img src="images/<?php //echo $row["image"] ?>" alt="">
					</div>
					<label for="">New image</label><br>
					<input type="file" name="image">
				</div> -->
				<div>
					<label for="">Location</label><br>
					<input type="text" name="location" value="<?php echo htmlspecialchars($row["location"]) ?>" required>
			  </div>
				<button class="btn" type="submit" name="update">Update</button>
			</form>
		</div>
	</div>
</section>
<?php else: ?>
<section class="add-car section">
  <div class="container">
	  <div class="add-form">
			<h2>Add Car</h2>
			<?php if (!empty($massege)) : ?>
				<div class="massege <?php echo htmlspecialchars($massege["status"]) ?>">
					<p><?php echo htmlspecialchars($massege["massege"]) ?></p>
				</div>
			<?php endif ?>
			<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
				<div>
					<label for="">Bord No</label><br>
					<input type="text" name="bord_no" required>
				</div>
				<div>
					<label for="">alt Bord No</label><br>
					<input type="text" name="alt_bord_no" required>
				</div>
				<!-- <div>
					<label for="">image</label><br>
					<input type="file" name="image" required>
				</div> -->
				<div>
					<label for="">Location</label><br>
					<input type="text" name="location" required>
			  </div>
				<button class="btn" type="submit" name="add">Add</button>
			</form>
		</div>
	</div>
</section>
<?php endif ?>

<?php require_once("inc/footer.php"); ?>