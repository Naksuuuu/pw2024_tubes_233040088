<?php
require '../controller/function.php';

if (!isset($_SESSION["login"])) {
  header('location: ../lib/login.php');
}

$rawData = pagedata('SELECT products.id, products.name AS product_name , products.price AS product_price, products.image_data AS product_image , category.category_name AS category_name
FROM products
JOIN category ON products.id_category = category.id
ORDER BY products.name DESC
');
$products = $rawData['query'];

if (isset($_POST["search"])) {
  $rawData = search($_POST["keyword"]);
  $_SESSION['keyword'] = $_POST['keyword'];
}

if (isset($_SESSION['keyword'])) {
  $rawData = search($_SESSION['keyword']);
  $products = $rawData['query'];
}

$activePage = $rawData['activePage'];
$amountPage = $rawData['amountPage'];





?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DONUTS.CO!</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="../asset/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <!-- navbar -->
  <?php
  $home = "#";
  $catalog = "#catalog";
  $logOut = "../lib/logout.php";
  $profile = "../components/profile.php";
  include_once '../template/navbar.php';
  ?>


  <!-- home/hero -->
  <section id="home">
    <div class="container-fluid">
      <div class="row text-center align-items-center justify-content-center">
        <div class="col-md-5 col-12 home-text">
          <h1><span>
              NUTS.CO
            </span> <br> Savoring Sweet Moments, One Bite at a Time.
          </h1>
        </div>
        <div class="col-md-4 col-8 ">
          <div class="home-img">
            <img src="../asset/img/hero-img.png" alt="">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- catalog  -->
  <section id="catalog">
    <div class="container-fluid">
      <div class="row justify-content-center mb-5">
        <div class="col-sm-6 text-center search-bar">
          <form action="" method="post" style="height: 100%;">
            <ul class="list-unstyled d-flex  align-items-center w-100 mb-0">
              <li>
                <label for="search" class="label label-control">
                  <i class='bx bx-search mt-1' style="font-size: 24px;"></i>
                </label>
              </li>
              <li class="w-100 mx-2">
                <input type="text" name="keyword" id="keyword" placeholder="Search Product" autocomplete="off" class="form form-control" value="<?= isset($_SESSION['keyword']) ? $_SESSION['keyword'] : ''; ?>">
              </li>
              <li>
                <button type="submit" name="search" class="btn btn-primary">Search</button>
              </li>
            </ul>
          </form>
        </div>
      </div>

      <?php include '../template/card.php'; ?>

    </div>
  </section>






  <!-- footer -->
  <?php
  include '../template/footer.php';
  ?>


  <script src="../js/ajax/livesearch/product.js"></script>
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>