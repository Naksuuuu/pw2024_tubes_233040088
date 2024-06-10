<?php
require '../controller/function.php';
date_default_timezone_set('Asia/Jakarta');

if (!isset($_SESSION["login"])) {
  header('location: ../lib/login.php');
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['id-product'])) {
    $product_id = $_POST['id-product'];
    $tes = addToCart($product_id);
    header('Location: ../views/index.php#catalog');
    exit();
  }
}

$rawData = getCart();
$jsonRawData = htmlspecialchars(json_encode($rawData), ENT_QUOTES, 'UTF-8');

if (isset($_POST['submit-trans'])) {
  if (cartToDb($_POST) > 0) {
    $userId = $_SESSION['id'];
    $cookieName = 'cart_' . $userId;
    setcookie($cookieName, '', time() - (86400 * 30), "/");

    header('location: ../views/index.php');
    exit;
  }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove-product'])) {
  $product_id = $_POST['remove-product'];
  removeFromCart($product_id);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Check out!</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="../asset/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>

  <!-- navbar -->

  <?php
  $home = "../views/index.php";
  $catalog = "../views/index.php?#catalog";
  $logOut = "../lib/logout.php";
  $profile = "profile.php";

  include '../template/navbar.php';
  ?>

  <section id="shopping-cart">
    <div class="container ">
      <h1>Shopping cart items</h1>

      <div class="row mt-5">
        <?php if ($rawData == []) : ?>
          <h1>Cart is Empty!</h1>
        <?php else : ?>
          <div class="col-12 ">
            <div class="table-responsive">
              <table class="table border border-black ">
                <thead class="th-tables">
                  <tr class="text-center">
                    <th scope="col">Product</th>
                    <th scope="col">Category</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody id="result">
                  <?php foreach ($rawData as $product) : ?>
                    <tr class="text-center border border-black">
                      <td>
                        <div class="d-flex align-items-center justify-content-center gap-3">
                          <img src="../asset/img/product_img/<?= $product['product_image']; ?>" alt="" style="width: 125px; height: 125px;">
                          <p><?= $product['product_name']; ?></p>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center h-100">
                          <div class="w-100">
                            <p><?= $product['category_name']; ?></p>

                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center h-100">
                          <div class="w-100">
                            <p><?= $product['quantity']; ?></p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center h-100">
                          <div class="w-100">
                            <p><?= $product['product_price']; ?></p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center h-100">
                          <div class="w-100">
                            <form action="" method="post">
                              <input type="hidden" name="remove-product" value="<?= $product['id']; ?>">
                              <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php endif; ?>
      </div>
      <?php if ($rawData != []) : ?>
        <div class="row">
          <div class="col-12 text-center">
            <form action="" method="post">
              <input type="hidden" name="id-user" value="<?= $_SESSION['id']; ?>">
              <input type="hidden" name="date" value="<?= date('Y-m-d H:i:s'); ?>">
              <input type="hidden" name="products" value="<?= $jsonRawData; ?>">
              <button type="submit" name="submit-trans" class="btn btn-primary">BUY NOW!</button>
            </form>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </section>








  <script>
    // Perbarui halaman setelah menghapus item
  </script>
  <script src="../js/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>