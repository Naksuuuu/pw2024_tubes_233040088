<?php


require '../controller/function.php';


if (!isset($_SESSION["login"])) {
  header('location: ../lib/login.php');
  exit;
}

if ($_SESSION["role"] === 'user') {
  header('location: index.php');
  exit;
}

$user = getUserInfo();




$products = query(
  'SELECT products.id, products.image_data AS product_image, products.name AS product_name , products.price AS product_price, category.category_name AS category_name,category.id AS category_id
      FROM products
      JOIN category ON products.id_category = category.id
      ORDER BY products.name DESC
      '
);

$category = query('SELECT * FROM category');


if (isset($_POST['add'])) {
  if (add($_POST) > 0) {
    echo '
    <script>alert("Data Berhasil Di tambahkan");</script>
    ';
  } else {
    echo "gagal";
  }
}


if (isset($_POST["edit"])) {
  if (change($_POST) > 0) {
    echo '
    <script>
    alert("Data Berhasil di ubah");
    document.location.href = "../views/dashboard.php";
    </script>
    ';
  } else {
    echo "
    <script>
    alert('Data gagal di ubah');
    </script>
    ";
  }
}


if (isset($_POST["delete"])) {
  if (delete($_POST) > 0) {
    echo '
    <script>
    alert("Data Berhasil dihapus");
    document.location.href = "../views/dashboard.php";
    </script>
    ';
  } else {
    echo "
    <script>
    alert('Data gagal di ubah');
    </script>
    ";
  }
}

if (isset($_POST["search"])) {
  $products = searchProduct($_POST["keyword"]);
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
  <?php require '../template/modal-products.php'; ?>


  <!-- sidebar -->
  <?php
  $home = "#";
  $pageCategory = "../components/category.php";
  $pageUser = "../components/user.php";
  include '../template/sidebar.php'
  ?>



  <section id="list-product">
    <div class="menus-info" id="icon-sidebar">
      <i class='bx bx-list-ul'></i>
    </div>
    <div class="container">
      <h1>List Products</h1>
      <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#add-product-modal">
        Add new product
      </button>
      <div class="search-bar">
        <form action="" method="post">
          <ul class="list-unstyled d-flex  align-items-center w-100">
            <li>
              <label for="search">
                <i class='bx bx-search'></i>
              </label>
            </li>
            <li class="w-100 mx-2">
              <input type="text" name="keyword" id="search" placeholder="Search Product" autocomplete="off" class="w-100 h-100 px-2">
            </li>
            <li>
              <button type="submit" name="search" class="badge bg-primary border-0 h-100">Search</button>
            </li>

          </ul>
        </form>
      </div>

      <div class="row text-center tables-scroll">
        <div class="col-md-12">
          <table class="table border">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">image</th>
                <th scope="col">Name</th>
                <th scope="col">Category</th>
                <th scope="col">Price</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; ?>
              <?php foreach ($products as $product) : ?>
                <tr>
                  <td scope="row"><?= $i; ?></td>
                  <td><img src="../asset/img/product_img/<?= $product["product_image"]; ?>" alt="" style="width: 50px; height: 50px;"></td>
                  <td><?= $product["product_name"]; ?></td>
                  <td><?= $product["category_name"]; ?></td>
                  <td><?= number_format($product["product_price"], 0, ',', '.'); ?></td>
                  <td>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit-product-modal-<?= $product['id']; ?>">
                      <i class='bx bxs-edit-alt' style="color: white;"></i>
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-product-modal-<?= $product['id']; ?>">
                      <i class='bx bxs-trash'></i>
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

  </section>











  <script src="../js/dashboard.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>