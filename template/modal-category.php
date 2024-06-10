<!-- modal category -->
<!-- add -->
<div class="modal fade" id="add-category-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ADD CATEGORY</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
          <ul class="list-unstyled">
            <li>
              <label for="name" class="label-control">Name Category</label>
              <input type="text" name="name" id="name" class="form-control" required>
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

<!-- delete -->
<?php foreach ($categories as $category) : ?>
  <div class="modal fade" id="delete-category-modal-<?= $category['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">DELETE CATEGORY</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
            <ul class="list-unstyled">
              <li>
                <label for="name" class="label-control">Name Category</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= $category['category_name']; ?>" disabled>
                <input type="hidden" name="id" value="<?= $category['id']; ?>">
              </li>
              <li class="mt-2">
                <button type="submit" class="btn btn-danger" name="delete">Delete</button>
              </li>
            </ul>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<!-- edit -->
<?php foreach ($categories as $category) : ?>
  <div class="modal fade" id="edit-category-modal-<?= $category['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">EDIT CATEGORY</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
            <ul class="list-unstyled">
              <li>
                <label for="name" class="label-control">Name Category</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= $category['category_name']; ?>" required>
                <input type="hidden" name="id" value="<?= $category['id']; ?>">
              </li>
              <li class="mt-2">
                <button type="submit" class="btn btn-primary" name="edit">Save</button>
              </li>
            </ul>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<!-- end modal category -->