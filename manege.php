<?php
$page_title = "سيارتى";
require_once("init.php");

$table_colume = [];
$rows_colume  = [];
$title        = "";

if (isset($_POST["delet"]) && !empty($_POST)) {
	$car_id = trim(filter_input(INPUT_POST, 'car_id', FILTER_SANITIZE_SPECIAL_CHARS)); 

  // $stmtment = $pdo->prepare("SELECT * FROM `cars` WHERE `id` = ?;");
  // $stmtment->execute([$car_id]);
  // $row = $stmtment->fetch(); 
  // $old_image = $row["image"];
  // unlink("images/".$old_image);

  $stmt = $pdo->prepare("DELETE FROM `cars` WHERE `cars`.`id` = ?;");
  $stmt->execute([$car_id]);
}
if (isset($_POST["search"]) && !empty($_POST)) {
  $car_id = trim(filter_input(INPUT_POST, 'car_id', FILTER_SANITIZE_SPECIAL_CHARS)); 
  $stmt = $pdo->prepare("UPDATE `cars` SET `status` = ? WHERE `id` = ? ;");
  $stmt->execute([1,$car_id]);
}
if (isset($_POST["active"]) && !empty($_POST)) {
	$car_id = trim(filter_input(INPUT_POST, 'car_id', FILTER_SANITIZE_SPECIAL_CHARS)); 
  $stmt = $pdo->prepare("UPDATE `cars` SET `status` = ? WHERE `id` = ? ;");
  $stmt->execute([2,$car_id]);
}
if (isset($_POST["lock"]) && !empty($_POST)) {
	$car_id = trim(filter_input(INPUT_POST, 'car_id', FILTER_SANITIZE_SPECIAL_CHARS)); 
  $stmt = $pdo->prepare("UPDATE `cars` SET `status` = ? WHERE `id` = ? ;");
  $stmt->execute([3,$car_id]);
}
if (isset($_POST["active_user"]) && !empty($_POST)) {
  $user_id = trim(filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_SPECIAL_CHARS)); 
  $stmt = $pdo->prepare("UPDATE `users` SET `status` = ? WHERE `id` = ? ;");
  $stmt->execute([1,$user_id]);
}
if (isset($_POST["lock_user"]) && !empty($_POST)) {
  $user_id = trim(filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_SPECIAL_CHARS)); 
  $stmt = $pdo->prepare("UPDATE `users` SET `status` = ? WHERE `id` = ? ;");
  $stmt->execute([2,$user_id]);
}
if (isset($_POST["delet_user"]) && !empty($_POST)) {
	$user_id = trim(filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_SPECIAL_CHARS)); 
  $stmt = $pdo->prepare("DELETE FROM `users` WHERE `users`.`id` = ?;");
  $stmt->execute([$user_id]);
}


if (isset($_GET["page"]) && $_GET["page"] == "total_car") {
  $statment = $pdo->prepare("SELECT * FROM cars");
  $statment->execute();
  $rows = $statment->fetchAll(PDO::FETCH_ASSOC); 
  
  $statment = $pdo->prepare("SELECT * FROM users");
  $statment->execute();
  $users = $statment->fetchAll(PDO::FETCH_ASSOC); 
} elseif (isset($_GET["page"]) && $_GET["page"] == "founded_car") {
  $statment = $pdo->prepare("SELECT * FROM cars WHERE `status` = 2");
  $statment->execute();
  $rows = $statment->fetchAll(PDO::FETCH_ASSOC); 

  $statment = $pdo->prepare("SELECT * FROM users");
  $statment->execute();
  $users = $statment->fetchAll(PDO::FETCH_ASSOC); 
} elseif (isset($_GET["page"]) && $_GET["page"] == "block_car") {
  $statment = $pdo->prepare("SELECT * FROM cars WHERE `status` = 3");
  $statment->execute();
  $rows = $statment->fetchAll(PDO::FETCH_ASSOC); 

  $statment = $pdo->prepare("SELECT * FROM users");
  $statment->execute();
  $users = $statment->fetchAll(PDO::FETCH_ASSOC); 
} elseif (isset($_GET["page"]) && $_GET["page"] == "block_user") {
  $statment = $pdo->prepare("SELECT * FROM users WHERE `status` = 2");
  $statment->execute();
  $rows = $statment->fetchAll(PDO::FETCH_ASSOC); 

  $statment = $pdo->prepare("SELECT * FROM users");
  $statment->execute();
  $users = $statment->fetchAll(PDO::FETCH_ASSOC); 
} elseif (isset($_GET["page"]) && $_GET["page"] == "total_user") {
  $statment = $pdo->prepare("SELECT * FROM users");
  $statment->execute();
  $rows = $statment->fetchAll(PDO::FETCH_ASSOC); 

} else {
  header("location: /login.php");
  exit; 
}

if (isset($_GET{"page"})) {
  switch ($_GET["page"]) {
    case 'total_car':
      $title = "Total Car";
      $table_colume = [
        '<td>Id</td>',
        '<td>Bord Number</td>',
        '<td>alt Bord Number</td>',
        '<td>Username</td>',
        '<td>Location</td>',
        '<td>Action</td>'
        // '<td>image</td>'
      ];
      $rows_colume = [
        1 => 'id',
        2 => 'bord_no',
        3 => 'alt_bord_no',
        4 => 'username',
        5 => 'location',
        // 6 => 'image',
        7 => 'status'
      ];
      break;
      case 'founded_car':
        $title = "Founded Car";
        $table_colume = [
          '<td>Id</td>',
          '<td>Bord Number</td>',
          '<td>alt Bord Number</td>',
          '<td>Username</td>',
          '<td>Location</td>',
          '<td>Action</td>'
          // '<td>image</td>'
        ];
        $rows_colume = [
          1 => 'id',
          2 => 'bord_no',
          3 => 'alt_bord_no',
          4 => 'username',
          5 => 'location',
          // 6 => 'image',
          7 => 'status'
        ];
        break;
    case 'block_car':
      $title = "Block Car";
      $table_colume = [
        '<td>Id</td>',
        '<td>Bord Number</td>',
        '<td>alt Bord Number</td>',
        '<td>Username</td>',
        '<td>Location</td>',
        '<td>Action</td>'
        // '<td>image</td>'
      ];
      $rows_colume = [
        1 => 'id',
        2 => 'bord_no',
        3 => 'alt_bord_no',
        4 => 'username',
        5 => 'location',
        // 6 => 'image',
        7 => 'status'
      ];
      break;
    case 'total_user':
      $title = "Total Users";
      $table_colume = [
        '<td>Id</td>',
        '<td>Username</td>',
        '<td>Frist Name</td>',
        '<td>Last Name</td>',
        '<td>Total Cars</td>',
        '<td>Founded Cars</td>',
        '<td>Action</td>'
      ];
      $rows_colume = [
        1 => 'id',
        2 => 'username',
        3 => 'first_name',
        4 => 'last_name',
        5 => 'status'
      ];
      break;
    case 'block_user':
      $title = "Block Users";
      $table_colume = [
        '<td>Id</td>',
        '<td>Username</td>',
        '<td>Frist Name</td>',
        '<td>Last Name</td>',
        '<td>Total Cars</td>',
        '<td>Founded Cars</td>',
        '<td>Action</td>'
      ];
      $rows_colume = [
        1 => 'id',
        2 => 'username',
        3 => 'first_name',
        4 => 'last_name',
        5 => 'status'
      ];
      break;
  }
} else {
  header("location: /login.php");
  exit;
}

?>
<?php if ($_GET["page"] == 'total_user' || $_GET["page"] == 'block_user') : ?>
<section class="section total-car">
  <div class="container">
    <div class="head flex">
      <h4><?php echo $title; ?></h4>
      <div>
        <label for="search">Search</label>
        <input class="search" type="search" name="search" id="search">
      </div>
    </div>
    <table>
      <tr>
        <?php foreach ($table_colume as $colume) : 
          echo $colume;
        endforeach ?>
      </tr>
      <?php foreach ($rows as $row) :?>
        <tr class="user-status">
          <td><?php echo $row[$rows_colume[1]] ?></td>
          <td><?php echo $row[$rows_colume[2]] ?></td>
          <td><?php echo $row[$rows_colume[3]] ?></td>
          <td><?php echo $row[$rows_colume[4]] ?></td>
          <td><?php 
            $statment = $pdo->prepare("SELECT * FROM cars WHERE user_id = ?;");
            $statment->execute([$row[$rows_colume[1]]]);
            $totals_car = $statment->rowCount();
            echo $totals_car;
          ?></td>
          <td><?php 
            $statment = $pdo->prepare("SELECT * FROM cars WHERE user_id = ? AND `status` = 2;");
            $statment->execute([$row[$rows_colume[1]]]);
            $founded_car = $statment->rowCount();
            echo $founded_car;
          ?></td>
          <td>
          <div class="flex">
              <a class="flex action-icon" href="/add_user.php?edit&user_id=<?php echo $row[$rows_colume[1]] ?>"><i class="action-icon fa fa-pen"></i></a>

              <!-- <i class="action-icon fa fa-lock"></i> -->
              <form class="flex" action="<?php echo $_SERVER["REQUEST_URI"] ?>" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $row[$rows_colume[1]] ?>">
                <?php if ($row[$rows_colume[5]] == 1) : ?>
                  <!-- lock -->
                  <button class="flex lock" type="submit" name="lock_user">
                    <svg fill="#fff" class="action-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                      <path d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z"/>
                    </svg>
                  </button>
                <?php elseif ($row[$rows_colume[5]] == 2) : ?>
                  <!-- founded -->
                  <button class="flex active" type="submit" name="active_user">
                    <svg fill="#fff" class="action-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                      <path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"/>
                    </svg>
                  </button>
                <?php endif ?>
                <button class="flex" type="submit" name="delet_user"><i class="action-icon fa fa-shopping-basket"></i></button>
              </form>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</section>
<?php else :?>
<section class="section total-car">
  <div class="container">
    <div class="head flex">
      <h4><?php echo $title; ?></h4>
      <div>
        <label for="search">Search</label>
        <input class="search" type="search" name="search" id="search">
      </div>
    </div>
    <table>
      <tr>
        <?php foreach ($table_colume as $colume) : 
          echo $colume;
        endforeach ?>
      </tr>
      <?php foreach ($rows as $row) :?>
        <tr class="car-status-<?php echo htmlspecialchars($row[$rows_colume[7]]) ?>">
          <td><?php echo htmlspecialchars($row[$rows_colume[1]]) ?></td>
          <td><?php echo htmlspecialchars($row[$rows_colume[2]]) ?></td>
          <td><?php echo htmlspecialchars($row[$rows_colume[3]]) ?></td>
          <td><?php 
            foreach ($users as $user) {
              if ($user["id"] == $row["user_id"]) {
                echo htmlspecialchars($user[$rows_colume[4]]);
                break;
              }
            } ?></td>
          <td><?php echo htmlspecialchars($row[$rows_colume[5]]) ?></td>
          <td>
            <div class="flex">
              <a class="flex action-icon" href="/add_car.php?edit&car_id=<?php echo htmlspecialchars($row[$rows_colume[1]]) ?>"><i class="action-icon fa fa-pen"></i></a>

              <!-- <i class="action-icon fa fa-lock"></i> -->
              <form class="flex" action="<?php echo $_SERVER["REQUEST_URI"] ?>" method="POST">
                <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($row[$rows_colume[1]]) ?>">
                <?php if ($row[$rows_colume[7]] == 1) : ?>
                  <!-- founded -->
                  <button class="flex active" type="submit" name="active">
                    <svg fill="#fff" class="action-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                      <path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"/>
                    </svg>
                  </button>
                  <!-- lock -->
                  <button class="flex lock" type="submit" name="lock">
                    <svg fill="#fff" class="action-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                      <path d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z"/>
                    </svg>
                  </button>
                <?php elseif ($row[$rows_colume[7]] == 2) : ?>
                  <!-- search -->
                  <button class="flex search" type="submit" name="search">
                    <svg fill="#fff" class="action-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                      <path d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"/>
                    </svg>
                  </button>
                  <!-- lock -->
                  <button class="flex lock" type="submit" name="lock">
                    <svg fill="#fff" class="action-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                      <path d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z"/>
                    </svg>
                  </button>
                <?php elseif ($row[$rows_colume[7]] == 3) : ?>
                  <!-- founded -->
                  <button class="flex active" type="submit" name="active">
                    <svg fill="#fff" class="action-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                      <path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"/>
                    </svg>
                  </button>
                  <!-- search -->
                  <button class="flex search" type="submit" name="search">
                    <svg fill="#fff" class="action-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                      <path d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"/>
                    </svg>
                  </button>
                <?php endif ?>
                <button class="flex" type="submit" name="delet"><i class="action-icon fa fa-shopping-basket"></i></button>
              </form>
            </div>
          </td>
          <!-- <td class="image"><img src="images/<?php echo htmlspecialchars($row[$rows_colume[6]]) ?>"/></td> -->
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</section>
<?php endif ?>
<?php require_once("inc/footer.php") ?>
