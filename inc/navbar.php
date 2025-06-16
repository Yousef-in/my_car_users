<nav class="navbar navbar-expand-lg"  id="header">
  <div class="container">
    <a class="flex navbar-brand" href="/">
      <div class="image">
        <!-- <img class="fulwid" src="images/logo.jpg" alt="logo"> -->
      </div>  
      <h2>
        My Car
      </h2>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <a class="nav-link" href="home.php">Manege</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="reset_password.php">Reset Password</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile.php?id=<?php echo $_SESSION["user_id"] ?>">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>