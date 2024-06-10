<?php

require '../../../controller/function.php';




if (isset($_GET["keyword"])) {
  $rawData = search($_GET["keyword"]);
  $_SESSION['keyword'] = $_GET['keyword'];
}

if (isset($_SESSION['keyword'])) {
  $rawData = search($_SESSION['keyword']);
  $products = $rawData['query'];
}

$activePage = $rawData['activePage'];
$amountPage = $rawData['amountPage'];




?>





<div class="col-12 mb-3 text-center page-link">
  <?php if ($activePage > 1) : ?>
    <a href="?halaman=<?= $activePage - 1; ?>#catalog">&laquo;</a>
  <?php endif; ?>
  <?php for ($i = 1; $i <= $amountPage; $i++) : ?>
    <?php if ($i == $activePage) : ?>
      <a href="index.php?halaman=<?= $i; ?>#catalog" class="no-scroll-link" style="font-weight: bold;"><?= $i; ?></a>
    <?php else : ?>
      <a href="index.php?halaman=<?= $i; ?>#catalog" class="no-scroll-link" style="text-decoration: none;"><?= $i; ?></a>
    <?php endif; ?>
  <?php endfor ?>
  <?php if ($activePage < $amountPage) : ?>
    <a href="?halaman=<?= $activePage + 1; ?>#catalog">&raquo;</a>
  <?php endif; ?>
</div>
<?php if ($products == null) : ?>
  <h1>Product not founds</h1>
<?php else : ?>
  <?php foreach ($products as $product) : ?>
    <div class="col-lg-3 col-md-4 col-sm-6 col-12 card-catalog p-0">
      <div class="card">
        <div class="card-img">
          <img src="../asset/img/product_img/<?= $product["product_image"]; ?>" class="card-img-top" alt="...">
        </div>
        <div class="card-body text-center">
          <h5 class="card-title"><?= $product["product_name"]; ?></h5>
          <p class="card-text"><?= $product["product_price"]; ?></p>
          <div class="card-btn d-flex align-items-center gap-2">
            <a href="../components/detail.php?id= <?= $product['id']; ?>" class="btn btn-primary">See Detail</a>
            <form action="" method="post">
              <input type="hidden" name="id" value="<?= $product['id']; ?>">
              <button name="add-to-cart" class="btn btn-warning"><i class='bx bx-cart'></i></button>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>