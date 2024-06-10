<!-- edit  -->
<?php foreach ($users as $user) : ?>
  <div class="modal fade" id="edit-user-modal-<?= $user['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">EDIT ROLE USER</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h3><?= $user['username']; ?></h3>
          <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
            <ul class="list-unstyled">
              <li>
                <label for="role" class="label-control">Select Acces Role</label>
                <select name="role">
                  <option value="<?= $user['access_role']; ?>" selected><?= $user['access_role']; ?></option>
                  <option value="admin">admin</option>
                </select>
                <input type="hidden" name="id" value="<?= $user['id']; ?>">
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

<!-- delete -->
<?php foreach ($admins as $admin) : ?>
  <div class="modal fade" id="delete-admin-modal-<?= $admin['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">DELETE ADMIN</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h3 class="mb-3"><?= $admin['username']; ?></h3>
          <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
            <ul class="list-unstyled">
              <li>
                <input type="hidden" name="id" value="<?= $admin['id']; ?>">
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