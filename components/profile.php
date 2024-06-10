<?php
require '../controller/function.php';
date_default_timezone_set('Asia/Jakarta');

if (!isset($_SESSION["login"])) {
  header('location: ../lib/login.php');
}



$userId = $_SESSION['id'];
$user = getUserInfo();
$role = $user['access_role'];
$hisTransac = query("SELECT * FROM transactions WHERE id_user = '$userId' ORDER BY transaction_date DESC");



if (isset($_POST['editPassword'])) {
  $result = editPassword($_POST);
  if ($result === 'password wrong') {
    $errorOldPassword = true;
  }
  if ($result === "password doesn't match") {
    $errorNewPassword = true;
  }
  if ($result === 1) {
    echo '<script>alert("Password has change");</script>';
  }
}

if (isset($_POST['add-photo-profile'])) {
  if (uploadProfile($_FILES) > 0) {
    header('location: ?');
  }
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
  <?php if ($role == 'admin') : ?>
    <link rel="stylesheet" href="../asset/styleadmin.css">
  <?php endif; ?>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>

  <!-- navbar -->

  <?php if ($role == 'user') {
    $home = "../views/index.php";
    $catalog = "../views/index.php?#catalog";
    $logOut = "../lib/logout.php";
    $profile = "#";

    include '../template/navbar.php';
  } else {
    $home = '../views/dashboard.php';
    $pageCategory = '#';
    $pageUser = 'user.php';
    include '../template/sidebar.php';
  }
  ?>

  <section>
    <?php if ($role == 'admin') : ?>
      <div class="menus-info" id="icon-sidebar">
        <i class='bx bx-list-ul'></i>
      </div>
    <?php endif; ?>
    <div class="container">
      <div class="row">
        <?php if ($role == 'user') : ?>
          <div class="col-md-6 d-flex justify-content-center align-items-center">
          <?php else : ?>
            <div class="col-md-12 d-flex justify-content-center align-items-center">
            <?php endif; ?>
            <div class="card card-profile">
              <div class="card-img">
                <img id="photoPreview" src="../asset/img/profile_img/<?= $user['image_profile']; ?>" class="card-img-top rounded-circle" alt="...">
                <div class="rounded-circle" style=" position: absolute; top: 80%; right: 10%; overflow: hidden;">
                  <button class="btn btn-warning" type="button" id="edit-image-profile"><i class='bx bxs-edit-alt' style=" color: white;"></i></button>
                  <form id="uploadForm" style="display: none;" action="" method="post" enctype="multipart/form-data">
                    <input type="file" name="image" id="fileInput" style="display: none;" name="file">
                    <button type="submit" name="add-photo-profile" class="btn btn-primary" id="submitBtn"> <i class='bx bx-check' style=" color: white;"></i></button>
                  </form>
                </div>
              </div>
              <div class=" card-body">
                <div class="mb-4">
                  <p class="mb-0">Hello!</p>
                  <h2>
                    <?= $user['username']; ?>
                  </h2>
                </div>
                <form action="" method="post">
                  <ul class="list-unstyled d-flex flex-column gap-4">
                    <li class="edit-form d-none">
                      <label for="password">Old Password :</label>
                      <input type="password" name="password" class="form form-control">
                    </li>
                    <li class="edit-form d-none">
                      <label for="new-password">New Password :</label>
                      <input type="password" name="new-password" class="form form-control">
                    </li>
                    <li class="edit-form d-none">
                      <label for="confirm-password">Confirm Password :</label>
                      <input type="password" name="confirm-password" class="form form-control">
                    </li>
                    <li>
                      <button type="button" class="btn btn-warning btn-edit-pw">Edit</button>
                      <button type="button" class="btn btn-danger d-none">Cancel</button>
                      <button name="editPassword" class="btn btn-primary btn-save-pw d-none">save</button>
                    </li>
                  </ul>
                </form>
                <?php if (isset($errorOldPassword)) : ?>
                  <p style="color: red; font-style: italic;">Password wrong</p>
                <?php endif; ?>
                <?php if (isset($errorNewPassword)) : ?>
                  <p style="color: red; font-style: italic;">Password doesn't match</p>
                <?php endif; ?>
              </div>
            </div>
            </div>
            <?php if ($role == 'user') : ?>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-12">
                    <div class="card">
                      <div class="p-5">
                        <h1>Your purchase records</h1>
                      </div>
                      <div class=" card-body">
                        <?php if ($hisTransac == []) : ?>
                          <p>BUY SOME DONUTS!</p>
                        <?php else : ?>
                          <div class="tables-responsive">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th scope="col">Date</th>
                                  <th scope="col">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach ($hisTransac as $transac) : ?>
                                  <tr>
                                    <td class="">
                                      <div class="d-flex align-items-center" style="height: 40px;">
                                        <p class="mb-0">
                                          <?= date("d F Y", strtotime($transac['transaction_date'])); ?>
                                        </p>
                                      </div>
                                    </td>
                                    <td>
                                      <a href="../pdf.php?id=<?= $transac['id_transaction']; ?>" target="_blank" class="btn btn-primary">Print</a>
                                    </td>
                                  </tr>
                                <?php endforeach; ?>
                              </tbody>
                            </table>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>

                  </div>
                  <div class="col-12"></div>
                </div>
              </div>
            <?php endif; ?>
          </div>
      </div>
  </section>

  <?php if ($role == 'admin') : ?>
    <script src="../js/dashboard.js"></script>
  <?php endif; ?>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const inputEdit = document.querySelectorAll('.edit-form');
      const btnSave = document.querySelector('.btn-save-pw');
      const btnEdit = document.querySelector('.btn-edit-pw');
      const btnCancel = document.querySelector('.btn-danger');
      btnEdit.addEventListener('click', () => {
        btnSave.classList.toggle('d-none');
        btnCancel.classList.toggle('d-none');
        btnEdit.classList.toggle('d-none');
        inputEdit.forEach((input) => {
          input.classList.toggle('d-none');
        })
      })
      btnCancel.addEventListener('click', () => {
        window.location.href = '';
      })


      const btnImageEdit = document.getElementById('edit-image-profile');
      const inputImg = document.getElementById('fileInput');
      const formImg = document.getElementById('uploadForm');
      const sumbitImg = document.getElementById('submitBtn');
      const oldPhoto = document.getElementById('oldPhoto');
      btnImageEdit.addEventListener('click', () => {
        inputImg.click();
      })

      inputImg.addEventListener('change', () => {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
          const photoPreview = document.getElementById('photoPreview');
          photoPreview.setAttribute('src', `${e.target.result}`);
        };

        reader.readAsDataURL(file);

        formImg.style.display = 'block';
        btnImageEdit.style.display = 'none';
        submitImg.style.display = 'inline-block';
      })




    })
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>