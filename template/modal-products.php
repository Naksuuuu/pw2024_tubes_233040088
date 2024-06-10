<!-- add -->

<div class="modal fade" id="add-product-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ADD PRODUCT</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
          <ul class="list-unstyled">
            <li class="d-flex justify-content-center w-100">
              <div style="width: 200px; height: 200px">
                <img src="../asset/img/question.png" id="addPhotoPreview" class="w-100 h-100" alt="">
              </div>
            </li>
            <li>
              <label for="image" class="label-control">Image</label>
              <input type="file" name="image" id="addImage" class="form-control" required>
            </li>
            <li>
              <label for="name" class="label-control">Name</label>
              <input type="text" name="name" id="name" class="form-control" required>
            </li>
            <li>
              <label for="category" class="label-control">Category</label>
              <select name="category" id="category" class="form-control" required>
                <option value="" disabled selected>Select Category</option>
                <?php foreach ($category as $subCate) : ?>
                  <option value="<?= $subCate['id']; ?>"><?= $subCate['category_name']; ?></option>
                <?php endforeach; ?>
              </select>
            </li>
            <li>
              <label for="price" class="label-control">Price</label>
              <input type="text" name="price" id="price" class="form-control" required>
            </li>
            <li class="mt-2">
              <button type="submit" class="btn btn-primary" name="add">Add</button>
            </li>
          </ul>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- edit -->
<?php foreach ($products as $product) : ?>
  <div class="modal fade" id="edit-product-modal-<?= $product['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">EDIT PRODUCT</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $product['id']; ?>">
            <input type="hidden" name="oldimage" value="<?= $product['product_image']; ?>">
            <div class="card-img">
              <img src="../asset/img/product_img/<?= $product['product_image'] ?>" class="card-img-top p-5 editPhotoPreview" alt="...">
            </div>
            <div class="card-body">
              <ul class="list-unstyled">
                <li>
                  <input type="file" name="image" class="form-control input-img">
                </li>
                <li>
                  <label for="name" class="label-control">Name :</label>
                  <input type="text" id="name" name="name" value="<?= $product["product_name"] ?>" class="form-control">
                </li>
                <li>
                  <label for="category" class="label-control">Category</label>
                  <select name="category" id="category" class="form-control">
                    <option value="<?= $product['category_id']; ?>"><?= $product['category_name']; ?></option>
                    <?php foreach ($category as $subCate) : ?>
                      <?php if ($product['category_name'] !==  $subCate['category_name']) : ?>
                        <option value="<?= $subCate['id']; ?>"><?= $subCate['category_name']; ?></option>';
                      <?php endif ?>
                    <?php endforeach; ?>
                  </select>
                </li>
                <li>
                  <label for="price" class="label-control">Price :</label>
                  <input type="text" id="price" name="price" value="<?= number_format($product["product_price"], 0, ',', '.'); ?>" class="form-control">
                </li>
                <li class="mt-2">
                  <button type="submit" class="btn btn-primary" name="edit">Save</button>
                </li>
              </ul>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<!-- delete -->
<?php foreach ($products as $product) : ?>
  <div class="modal fade" id="delete-product-modal-<?= $product['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">DELETE PRODUCT</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $product['id']; ?>">
            <input type="hidden" name="oldimage" value="<?= $product['product_image']; ?>">
            <div class="card-img">
              <img src="../asset/img/product_img/<?= $product['product_image'] ?>" class="card-img-top p-5" alt="...">
            </div>
            <div class="card-body">
              <ul class="list-unstyled">
                <li>
                  <label for="name" class="label-control">Name :</label>
                  <input type="text" id="name" name="name" value="<?= $product["product_name"] ?>" class="form-control" disabled>
                </li>
                <li>
                  <label for="category" class="label-control">Category</label>
                  <select name="category" id="category" class="form-control" disabled>
                    <option value="<?= $product['category_id']; ?>"><?= $product['category_name']; ?></option>
                    <?php foreach ($category as $subCate) : ?>
                      <?php if ($product['category_name'] !==  $subCate['category_name']) : ?>
                        <option value="<?= $subCate['id']; ?>"><?= $subCate['category_name']; ?></option>';
                      <?php endif ?>
                    <?php endforeach; ?>
                  </select>
                </li>
                <li>
                  <label for="price" class="label-control">Price :</label>
                  <input type="text" id="price" name="price" value="<?= number_format($product["product_price"], 0, ',', '.'); ?>" class="form-control" disabled>
                </li>
                <li class="mt-2">
                  <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                </li>
              </ul>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>