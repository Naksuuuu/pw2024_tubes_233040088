<?php

$user = getUserInfo();

?>


<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">Donuts.Co</a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span><i class='bx bx-menu'></i></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="<?= $home; ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= $catalog; ?>">Catalog</a>
        </li>
        <li class="nav-item">
          <a class="nav-link cart-btn " href="../components/chekout.php"><i class='bx bx-cart'></i></a>
        </li>
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="../asset/img/profile_img/<?= $user['image_profile']; ?>" class="rounded-circle">
          </a>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" href="<?= $profile; ?>">Profile</a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item" href="<?= $logOut; ?>">Log-out</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>