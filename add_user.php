<?php
$page_title = "سيارتى";
require_once("init.php");

$massege = [];
$mode = '';

if (isset($_POST["add"]) && !empty($_POST)) {
  $username 		= trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
  $first_name		= trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS));
  $last_name 		= trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS));
  $password 		= trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS));
  $active_user	= trim(filter_input(INPUT_POST, 'active_user'));
  if ($active_user == "on") {
    $status = 1;
  } elseif ($active_user == "off") {
    $status = 2;
  }

  $statment = $pdo->prepare("SELECT * FROM `users` WHERE username = ?");
  $statment->execute([$username]);
  $row = $statment->fetchAll(PDO::FETCH_ASSOC);
  
  if (empty($row)) {
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
		$now = new DateTime();
		$create_date = $now->format('Y-m-d H:i:s');

    $stmt = $pdo->prepare("INSERT INTO `users` (`username`, `first_name`, `last_name`, `password`, `status`, `level`, `create_date`) VALUES (?, ?, ?, ?, ?, ?, ?);");
    $stmt->execute([$username, $first_name, $last_name, $hash_password, $status, 1, $create_date]);

    $massege = ["status" => "success", "massege" => "Note: Add User successfull"];
  }else {
    $massege = ["status" => "error", "massege" => "Note: Username alredy exist"];
  }
} elseif (isset($_GET["edit"]) && isset($_GET["user_id"])) {
	$mode = "edit";
	$user_id = trim(filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_SPECIAL_CHARS));
	$stmtment = $pdo->prepare("SELECT * FROM `users` WHERE `id` = ?;");
  $stmtment->execute([$user_id]);
  $user = $stmtment->fetch(PDO::FETCH_ASSOC); 
} elseif (isset($_POST["update"]) && !empty($_POST)) {
	$mode = "update";
	$user_id			= trim(filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_SPECIAL_CHARS));
  $username 		= trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
  $old_username = trim(filter_input(INPUT_POST, 'old_username', FILTER_SANITIZE_SPECIAL_CHARS));
  $first_name		= trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS));
  $last_name 		= trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS));
  $password 		= trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS));
	
	$matsh = false; 

	if ($username == $old_username) {
		$matsh = true;
	}

	function update() {
		global $pdo;
		global $first_name;
		global $last_name;
		global $user_id;
		global $passowrd;
		global $massege;
		
		$stmt = $pdo->prepare("UPDATE `users` SET first_name = ? WHERE `id` = ? ;");
		$stmt->execute([$first_name,$user_id]);
		$stmt = $pdo->prepare("UPDATE `users` SET last_name = ? WHERE `id` = ? ;");
		$stmt->execute([$last_name,$user_id]);
		if (!empty($password)) {
			$hash_password = password_hash($password, PASSWORD_DEFAULT);
			$stmt = $pdo->prepare("UPDATE `users` SET passowrd = ? WHERE `id` = ? ;");
			$stmt->execute([$passowrd,$user_id]);
		}
		$massege = ["status" => "success", "massege" => "Note: Successfull To Update"];
	}

	if (!empty($username)) {
		if (!$matsh) {
			$stmt = $pdo->prepare("SELECT * FROM `users` WHERE `username` = ?");
			$stmt->execute([$username]);
			$res = $stmt->fetch(PDO::FETCH_ASSOC);
			if (empty($res)) {
				$stmt = $pdo->prepare("UPDATE `users` SET username = ? WHERE `id` = ? ;");
				$stmt->execute([$username,$user_id]);
				update();
			} else {
				$massege = ["status" => "error", "massege" => "Note: Username Alredy excited"];
			};
		} else {
			update();
		}
	} else {
		$massege = ["status" => "error", "massege" => "Note: Username Can't Be Empty"];
	}

	$stmt = $pdo->prepare("SELECT * FROM `users` WHERE `id` = ?");
  $stmt->execute([$user_id]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC); 
}
?>
<?php if ($mode == "edit" || $mode == "update") : ?>
	<section class="add-car section">
  <div class="container">
	  <div class="add-form">
			<h2>Edit Users</h2>
			<?php if (!empty($massege)) : ?>
				<div class="massege <?php echo htmlspecialchars($massege["status"]) ?>">
					<p><?php echo htmlspecialchars($massege["massege"]) ?></p>
				</div>
			<?php endif ?>
			<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="user_id" id="user_id" value="<?php echo htmlspecialchars($user['id']) ?>">
				<div>
					<label for="username">Username</label><br>
					<input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']) ?>" required>
					<input type="hidden" name="old_username" id="old_username" value="<?php echo htmlspecialchars($user['username']) ?>">
				</div>
				<div>
					<label for="first_name">First Name</label><br>
					<input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($user['first_name']) ?>" required>
				</div>
				<div>
					<label for="last_name">Last Name</label><br>
					<input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($user['last_name']) ?>" required>
				</div>
				<div>
					<label for="password">Password</label><br>
					<input type="password" name="password" id="password">
					<input type="hidden" name="old_password" id="password" value="<?php echo htmlspecialchars($user['password']) ?>">
			  </div>
				<button class="btn" type="submit" name="update">Update</button>
			</form>
		</div>
	</div>
</section>
<?php else : ?>
<section class="add-car section">
  <div class="container">
	  <div class="add-form">
			<h2>Add Users</h2>
			<?php if (!empty($massege)) : ?>
				<div class="massege <?php echo htmlspecialchars($massege["status"]) ?>">
					<p><?php echo htmlspecialchars($massege["massege"]) ?></p>
				</div>
			<?php endif ?>
			<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
				<div>
					<label for="username">Username</label><br>
					<input type="text" name="username" id="username" required>
				</div>
				<div>
					<label for="first_name">First Name</label><br>
					<input type="text" name="first_name" id="first_name" required>
				</div>
				<div>
					<label for="last_name">Last Name</label><br>
					<input type="text" name="last_name" id="last_name" required>
				</div>
				<div>
					<label for="password">Password</label><br>
					<input type="password" name="password" id="password" required>
			  </div>
        <div class="active-user">
          <input type="checkbox" name="active_user" id="active-user" checked>
          <label for="active-user">Active User</label>
        </div>
				<button class="btn" type="submit" name="add">Add</button>
			</form>
		</div>
	</div>
</section>
<?php endif; ?>

<?php require_once("inc/footer.php") ?>