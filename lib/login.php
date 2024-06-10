<?php
require '../controller/function.php';


// sign-up
if (isset($_POST["signup"])) {
  $signUpResult = signUp($_POST);
  if ($signUpResult === 1) {
    header('location: login.php');
    exit;
  }
  $errorSignUp = $signUpResult;
}

// login /sign in

if (isset($_POST["signin"])) {
  if (signIn($_POST) === false) {
    $errorSignIn = true;
  }
}

?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="../asset/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
  </style>
</head>

<body>

  <section id="login-page">
    <!-- sign in -->
    <div class="login box sign-in">
      <div class="container d-flex justify-content-center align-items-center flex-column">
        <div class="head-text mb-4">
          <h1>SIGN IN!</h1>
        </div>
        <form action="" method="post">
          <ul class="list-unstyled d-flex gap-4 flex-column">
            <li>
              <input type="text" name="username" placeholder="Username" autocomplete="off">
            </li>
            <li>
              <input type="password" name="password" placeholder="password">
            </li>
            <li>
              <button type="submit" name="signin">login</button>
            </li>
          </ul>
        </form>
        <div class="footer-text">
          <?php if (isset($errorSignIn)) : ?>
            <p style="color: red; font-style: italic;">Username / Password salah</p>
          <?php endif; ?>
          <p class="to-sign-up">don't have an account?</p>
        </div>
      </div>
    </div>


    <!-- sign up -->
    <div class="login box sign-up">
      <div class="container d-flex justify-content-center align-items-center flex-column">
        <div class="head-text mb-4">
          <h1>SIGN UP!</h1>
        </div>
        <form action="" method="post">
          <ul class="list-unstyled d-flex gap-4 flex-column">
            <li>
              <input type="text" name="username" placeholder="Username" autocomplete="off" required>
            </li>
            <li>
              <input type="password" name="password" placeholder="password" required>
            </li>
            <li>
              <input type="password" name="password-confirm" placeholder="confirm password" required>
            </li>
            <li>
              <button type="submit" name="signup">Sign-up</button>
            </li>
          </ul>
        </form>
        <div class="footer-text">
          <?php if (isset($errorSignUp)) : ?>
            <p style="color: red; font-style: italic;"><?= $errorSignUp; ?></p>
            <script>
              document.addEventListener('DOMContentLoaded', () => {
                slideToSignUp();
              })
            </script>
          <?php endif; ?>
          <p class="to-sign-in">already have an account?</p>
        </div>
      </div>
    </div>
  </section>





  <script>
    const boxSignUP = document.querySelector('.sign-up');
    const boxSignIn = document.querySelector('.sign-in');

    function slideToSignUp() {
      boxSignUP.classList.add('active');
      boxSignIn.classList.add('inactive');
    }

    window.addEventListener('click', (e) => {
      if (e.target.classList.contains('to-sign-up')) {
        boxSignUP.classList.add('active');
        boxSignIn.classList.add('inactive');
      }

      if (e.target.classList.contains('to-sign-in')) {
        boxSignIn.classList.remove('inactive');
        boxSignUP.classList.remove('active');
      }
    });
  </script>

  <script src="js/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>