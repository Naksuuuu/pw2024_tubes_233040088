<?php


require '../controller/function.php';


if (!isset($_SESSION["login"])) {
  header('location: ../lib/login.php');
  exit;
}

if ($_SESSION["role"] === 'user') {
  header('location: ../views/index.php');
  exit;
}

$adminId = $_SESSION['id'];

$users = query(
  "SELECT username, id, access_role FROM users WHERE access_role = 'user'  
      "
);

$admins = query(
  "SELECT username, id FROM users WHERE access_role = 'admin'
  ORDER BY 
  CASE 
    WHEN id = '$adminId' THEN 0 
    ELSE 1 
  END, 
  id"
);


if (isset($_POST['edit'])) {
  if (editUser($_POST) > 0) {
    header('location: ?');
  }
}

if (isset($_POST['delete'])) {
  if (delUser($_POST) > 0) {
    header('location: ../lib/login.php');
  }
}

if (isset($_POST['search'])) {
  $users = searchUser($_POST['keyword']);
}


?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="../asset/styleadmin.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <?php include '../template/modal-user.php'; ?>



  <!-- sidebar -->
  <?php
  $home = '../views/dashboard.php';
  $pageCategory = 'category.php';
  $pageUser = '#';
  include '../template/sidebar.php'
  ?>

  <section id="user">
    <div class="menus-info" id="icon-sidebar">
      <i class='bx bx-list-ul'></i>
    </div>
    <div class="container">
      <h1>User</h1>

      <div class="search-bar">
        <form action="" method="post">
          <ul class="list-unstyled d-flex  align-items-center w-100">
            <li>
              <label for="search">
                <i class='bx bx-search'></i>
              </label>
            </li>
            <li class="w-100 mx-2">
              <input type="text" name="keyword" id="search" placeholder="Search User" autocomplete="off" class="w-100 h-100 px-2">
            </li>
            <li>
              <button type="submit" name="search" class="badge bg-primary border-0 h-100">Search</button>
            </li>

          </ul>
        </form>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="row text-center tables-scroll">
            <div class="col-md-12">
              <h4>User</h4>
              <table class="table border">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1; ?>
                  <?php foreach ($users as $user) : ?>
                    <tr>
                      <td scope="row"><?= $i; ?></td>
                      <td>
                        <?= $user["username"]; ?>
                      </td>
                      <td>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit-user-modal-<?= $user['id']; ?>">
                          <i class='bx bxs-edit-alt'></i>
                        </button>
                      </td>
                    </tr>
                    <?php $i++; ?>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row text-center tables-scroll">
            <div class="col-md-12">
              <h4>Admin</h4>
              <table class="table border">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1; ?>
                  <?php foreach ($admins as $admin) : ?>
                    <?php if ($admin['id'] == $_SESSION['id']) : ?>
                      <tr>
                        <td scope="row"><?= $i; ?></td>
                        <td><?= $admin["username"]; ?> (me)</td>
                        <td>
                          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-admin-modal-<?= $admin['id']; ?>">
                            <i class='bx bxs-trash'></i>
                          </button>
                        </td>
                      </tr>
                    <?php elseif ($admin['id'] != $_SESSION['id']) : ?>
                      <tr>
                        <td scope="row"><?= $i; ?></td>
                        <td><?= $admin["username"]; ?></td>
                        <td>
                          -
                        </td>
                      </tr>
                    <?php endif; ?>
                    <?php $i++; ?>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>


      </div>
    </div>

  </section>



  <script src="../js/dashboard.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>