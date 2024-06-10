<?php
require '../controller/function.php';

if (!isset($_SESSION["login"])) {
  header('location: ../lib/login.php');
}

$id = $_GET['id'];


$products = query(
  "SELECT products.id, products.name AS product_name , products.price AS product_price, products.image_data AS product_image , category.category_name AS category_name
      FROM products
      JOIN category ON products.id_category = category.id
      WHERE products.id = '$id' 
      "
)[0];

$category = $products['category_name'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DETAIL DONUTS.CO!</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="../asset/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body id="detail">

  <!-- navbar -->

  <?php
  $home = "../views/index.php";
  $catalog = "../views/index.php#catalog";
  $logOut = "../lib/logout.php";
  $profile = "profile.php";

  include '../template/navbar.php';
  ?>

  <section class="pb-0">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="../asset/img/product_img/<?= $products['product_image']; ?>" alt="" class="img-fluid">
        </div>
        <div class="col-md-6 d-flex flex-column justify-content-center">
          <div>
            <h1><?= $products['product_name']; ?></h1>
            <p><?= $products['product_price']; ?></p>
            <p><?= $products['category_name']; ?></p>
          </div>
          <div>
            <form action="../components/chekout.php" method="post">
              <input type="hidden" name="id-product" value="<?= $products['id']; ?>">
              <button name="add-to-cart" class="btn btn-primary d-flex align-items-center gap-1">add to cart <i class='bx bx-cart'></i></button>
            </form>
          </div>
        </div>
        <div class="col-12 text-center">
          <h1>
            Similiar Products
          </h1>
        </div>
      </div>
    </div>
  </section>

  <section class="pt-1">
    <div class="container-fluid">

      <?php
      $products = query(
        "SELECT products.id, products.name AS product_name , products.price AS product_price, products.image_data AS product_image , category.category_name AS category_name
            FROM products
            JOIN category ON products.id_category = category.id
            WHERE category.category_name = '$category' AND products.id != '$id'
            ORDER BY products.name DESC
            "
      );

      include '../template/card.php'; ?>
    </div>
  </section>

  <?php
  include '../template/footer.php';
  ?>





  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const pageLink = document.querySelector('.page-link');

      pageLink.innerHTML = '';
    })
  </script>
  <script src="../js/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>