<!DOCTYPE html>
<html lang="ar">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	  <link rel="stylesheet" href="style/bootstrap.min.css" />
    <link rel="stylesheet" href="style/all.min.css">
    <link rel="stylesheet" href="style/main-style.css" />
    <?php
    if (isset($_SESSION["user_level"])) :
      if ($_SESSION["user_level"] == 0) :?>
      <link rel="stylesheet" href="style/admin-style.css" />
      <?php endif; ?>
    <?php endif; ?>
    <title><?php echo $page_title; ?></title>
  </head>
  <body>