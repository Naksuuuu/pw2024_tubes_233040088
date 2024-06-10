<div class="row" id="products-card">
  <div class="col-12 mb-3 text-center page-link">
    <?php if ($activePage > 1) : ?>
      <a href="?halaman=<?= $activePage - 1; ?>#catalog">&laquo;</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $amountPage; $i++) : ?>
      <?php if ($i == $activePage) : ?>
        <a href="?halaman=<?= $i; ?>#catalog" class="no-scroll-link" style="font-weight: bold;"><?= $i; ?></a>
      <?php else : ?>
        <a href="?halaman=<?= $i; ?>#catalog" class="no-scroll-link" style="text-decoration: none;"><?= $i; ?></a>
      <?php endif; ?>
    <?php endfor ?>
    <?php if ($activePage < $amountPage) : ?>
      <a href="?halaman=<?= $activePage + 1; ?>#catalog">&raquo;</a>
    <?php endif; ?>
  </div>
  <?php foreach ($products as $product) : ?>
    <div class="col-lg-3 col-md-4 col-sm-6 col-12 card-catalog p-0">
      <div class="card">
        <div class="card-img">
          <img src="../asset/img/product_img/<?= $product["product_image"]; ?>" class="card-img-top" alt="...">
        </div>
        <div class="card-body text-center">
          <h5 class="card-title"><?= $product["product_name"]; ?></h5>
          <p class="card-text"><?= number_format($product["product_price"], 0, ',', '.'); ?></p>
          <div class="card-btn d-flex align-items-center justify-content-center gap-2">
            <a href="../components/detail.php?id= <?= $product['id']; ?>" class="btn btn-primary">See Detail</a>
            <form action="../components/chekout.php" method="post">
              <input type="hidden" name="id-product" value="<?= $product['id']; ?>">
              <button name="add-to-cart" class="btn btn-warning "><i class='bx bx-cart'></i></button>
            </form>
          </div>
        </div>
      </div>
    </div>

  <?php endforeach; ?>

</div>