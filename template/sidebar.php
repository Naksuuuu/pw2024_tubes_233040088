<?php

$user = getUserInfo();

?>

<nav id="sidebar">
  <div class="container d-flex justify-content-between align-items-center h-100 flex-column">
    <div class="menus">
      <ul class="list-unstyled text-white ">
        <li class="mb-5">
          <div class="menus-img w-100 rounded-circle overflow-hidden">
            <img src="../asset/img/profile_img/<?= $user['image_profile']; ?>" alt="" class="img-fluid">
          </div>
          <div class="text-center mt-2">
            <h4><?= $user['username'] ?></h4>
          </div>
        </li>
        <li class="page-link">
          <a href="<?= $home; ?>" class="text-decoration-none">
            <h6 class="link-sidebar">Product</h6>
          </a>
        </li>
        <li class="page-link">
          <a href="<?= $pageCategory; ?>" class="text-decoration-none">
            <h6 class="link-sidebar">Category</h6>
          </a>
        </li>
        <li class="page-link">
          <a href="<?= $pageUser; ?>" class="text-decoration-none">
            <h6 class="link-sidebar">Roles</h6>
          </a>
        </li>
      </ul>
    </div>
    <div class="menus-logout">
      <ul class="list-unstyled text-white">
        <li>
          <a href="../components/profile.php" class="text-decoration-none">
            <h6 class="link-sidebar">Profile</h6>
          </a>
        </li>
        <li>
          <a href="../lib/logout.php" class="text-decoration-none">
            <h6 class="link-sidebar">Log-out</h6>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>