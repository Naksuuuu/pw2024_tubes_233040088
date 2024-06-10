<?php
session_start();

// koneksi
function conn()
{
  $conn = mysqli_connect('localhost', 'root', '', 'pw2024_tubes_233040088');

  return $conn;
}


function query($query)
{
  $conn = conn();


  $result = mysqli_query($conn, $query);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

// user info

function getUserInfo()
{

  $userId = $_SESSION['id'];

  $query = "SELECT * FROM users WHERE id = $userId";

  $result = query($query);

  return $result[0];
}


// admin page
// product

function searchProduct($keyword)
{
  $query = "SELECT products.id, 
                   products.image_data AS product_image, 
                   products.name AS product_name, 
                   products.price AS product_price, 
                   category.category_name AS category_name,
                   category.id AS category_id
            FROM products
            JOIN category ON products.id_category = category.id
            WHERE products.name LIKE '%$keyword%' OR category.category_name LIKE '%$keyword%'
            ORDER BY 
              CASE 
                  WHEN products.name LIKE '$keyword%' THEN 0 
                  WHEN category.category_name LIKE '$keyword%' THEN 0
                  ELSE 1 
              END,
              products.name ASC
  ";

  return query($query);
}


// category
function addCategory($data)
{
  $conn = conn();

  $name = htmlspecialchars($data['name']);

  $query = "INSERT INTO category
        VALUES 
        (null, '$name')";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}


function delCategory($data)
{
  $conn = conn();

  $id = $data['id'];

  $query = "DELETE FROM category WHERE id = '$id'";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}


function editCategory($data)
{
  $conn = conn();

  $id = $_POST['id'];
  $name = htmlspecialchars($data['name']);

  $query = "UPDATE category 
            SET category_name = '$name'
            WHERE id = '$id'";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

function searchCategory($data)
{
  $query = "SELECT * FROM category WHERE category_name LIKE '%$data%'";

  return query($query);
}

// user

function editUser($data)
{
  $conn = conn();
  $role = $data['role'];
  $id = $data['id'];

  $query = "UPDATE users 
            SET access_role = '$role'
            WHERE id = '$id'";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

function delUser($data)
{
  $conn = conn();
  $id = $data['id'];

  $query = "DELETE FROM users WHERE id = '$id'";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

function searchUser($data)
{
  $query = "SELECT username, id, access_role FROM users WHERE access_role = 'user' AND username LIKE '%$data%'";

  return query($query);
}









// tambah data

function add($data)
{
  $conn = conn();

  $name = htmlspecialchars($data['name']);
  $price = htmlspecialchars($data['price']);
  $category = htmlspecialchars($data['category']);
  // format price
  $price = str_replace('.', '', $price);

  $image = upload();
  if (!$image) {
    return false;
  }

  $query = "INSERT INTO products
        VALUES 
        ('0', '$name', '$price', '$category', '$image')
  ";


  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}



// upload
function upload()
{
  $nameFile = $_FILES['image']['name'];
  $sizeFile = $_FILES['image']['size'];
  $error = $_FILES['image']['error'];
  $tmpName = $_FILES['image']['tmp_name'];


  if ($error === 4) {
    echo "<script>
            alert('Upload Foto terlebih dahulu');
          </script>";
    return false;
  }


  $validImageExtension = ["jpg", "jpeg", "png"];
  $imageExtension = explode('.', $nameFile);
  $imageExtension = strtolower(end($imageExtension));

  if (!in_array($imageExtension, $validImageExtension)) {
    echo "<script>
            alert('Yang anda upload bukan gambar');
          </script>";
    return false;
  }

  if ($sizeFile > 2000000) {
    echo "<script>
            alert('Ukuran gambar terlalu besar');
          </script>";
    return false;
  }



  $newFileName = uniqid();
  $newFileName .= "." . $imageExtension;


  move_uploaded_file($tmpName, '../asset/img/product_img/' . $newFileName);

  return $newFileName;
}


// ubah data
function change($data)
{

  $conn = conn();

  $id = $data["id"];
  $name = htmlspecialchars($data["name"]);
  $price = htmlspecialchars($data["price"]);
  $category = htmlspecialchars($data["category"]);
  $oldimage = $data["oldimage"];

  $price = str_replace('.', '', $price);

  if ($_FILES['image']['error'] === 4) {
    $image = $oldimage;
  } else {
    $image = upload();
    if ($image == false) {
      return mysqli_affected_rows($conn);
    }
  }



  // qury update data
  $query = "UPDATE products
            JOIN category ON products.id_category = category.id
            SET 
                products.name = '$name',
                products.price = '$price',
                products.id_category = '$category',
                products.image_data = '$image'
        WHERE products.id = '$id'
";
  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}


// delet data

function delete($data)
{

  $conn = conn();

  $id = $data["id"];

  $query = "DELETE FROM products WHERE id = '$id'";

  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

// pagination / limit data
function pageData($query)
{
  $dataPerPage = 4;
  $amountData = count(query($query));

  $amountPage = ceil($amountData / $dataPerPage);

  $activePage = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;

  $startData = ($dataPerPage * $activePage) - $dataPerPage;

  $result = query("$query LIMIT $startData, $dataPerPage");

  $allData = [
    'dataPerPage' => $dataPerPage,
    'amountData' => $amountData,
    'amountPage' => $amountPage,
    'activePage' => $activePage,
    'startData' => $startData,
    'query' => $result
  ];

  return $allData;
}





// cari data 

function search($data)
{

  $query = "SELECT 
                products.id, 
                products.image_data AS product_image,
                products.name AS product_name,
                products.price AS product_price, 
                category.category_name AS category_name
            FROM products
            JOIN category ON products.id_category = category.id
            WHERE products.name LIKE '%$data%' OR category.category_name LIKE '%$data%'
            ORDER BY 
              CASE 
                  WHEN products.name LIKE '$data%' THEN 0 
                  WHEN category.category_name LIKE '$data%' THEN 0
                  ELSE 1 
              END,
              products.name ASC
  ";

  return pageData($query);
}


// registrasi / sign up

function signUp($data)
{

  $conn = conn();

  $username = strtolower(stripslashes($data["username"]));
  $password = mysqli_real_escape_string($conn, $data["password"]);
  $password2 = mysqli_real_escape_string($conn, $data["password-confirm"]);
  $photoProfile = 'Default_pfp.png';
  $roles = 'user';


  $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");




  if (mysqli_fetch_assoc($result)) {
    return "Username already exists";
  }

  if ($password !== $password2) {
    return "Passwords do not match";
  }


  $password = password_hash($password, PASSWORD_DEFAULT);



  mysqli_query($conn, "INSERT INTO users VALUES('0', '$username', '$password','$roles','$photoProfile')");

  return mysqli_affected_rows($conn);
}


// login / sign in 

function signIn($data)
{

  $conn = conn();

  $username = $data["username"];
  $password = $data["password"];

  $result =  mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

  // cek username
  if (mysqli_num_rows($result) == 1) {
    // cek password 
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row["password"])) {
      $_SESSION["login"] = true;
      $_SESSION["id"] = $row['id'];
      $_SESSION["role"] = $row["access_role"];
      if ($row["access_role"] === 'admin') {
        header("location: ../views/dashboard.php");
        exit;
      }

      header("location: ../views/index.php");
      exit;
    }
  }

  return false;
}

// cart sistem

function addToCart($productId)
{
  $userId = $_SESSION['id'];
  $cookieName = 'cart_' . $userId;


  if (isset($_COOKIE[$cookieName])) {
    $cart = json_decode($_COOKIE[$cookieName], true);
  } else {
    $cart = [];
  }


  if (array_key_exists($productId, $cart)) {
    $cart[$productId] += 1;
  } else {
    $cart[$productId] = 1;
  }


  setcookie($cookieName, json_encode($cart), time() + (86400 * 30), "/");
}

function removeFromCart($productId)
{

  $userId = $_SESSION['id'];
  $cookieName = 'cart_' . $userId;
  $cart = isset($_COOKIE[$cookieName]) ? json_decode($_COOKIE[$cookieName], true) : [];

  unset($cart[$productId]);

  setcookie($cookieName, json_encode($cart), time() + (86400 * 30), "/");

  header('location: ../components/chekout.php');
}

function getCart()
{
  $userId = $_SESSION['id'];
  $cookieName = 'cart_' . $userId;
  if (!isset($_COOKIE[$cookieName])) {
    return [];
  }

  $cart = json_decode($_COOKIE[$cookieName], true);
  $items = [];

  foreach ($cart as $id => $qty) {
    $item = query("SELECT products.id, 
                          products.name AS product_name, 
                          products.price AS product_price, 
                          products.image_data AS product_image,
                          category.category_name AS category_name
                   FROM products
                   JOIN category ON products.id_category = category.id
                   WHERE products.id = $id
                   ORDER BY products.name DESC");


    if ($item) {
      $item[0] += ["quantity" => "$qty"];
      $price = floatval(str_replace('.', '', $item[0]['product_price']));
      $item[0]['product_price'] = number_format($price * $qty, 0, ',', '.');
      $items[] = $item[0];
    }
  }

  return $items;
}


function cartToDb($data)
{
  $idUser = $data['id-user'];
  $date = $data['date'];

  $conn = conn();
  $query = "INSERT INTO transactions
            VALUES (null,'$idUser','$date')
  ";

  mysqli_query($conn, $query);

  $idTransactions = mysqli_insert_id($conn);



  $products = json_decode($data['products'], true);
  foreach ($products as $product) {
    $idProduct = $product['id'];
    $qty = $product['quantity'];
    $price = $product['product_price'];
    $query = "INSERT INTO detail_transaction
    VALUES (null,'$idTransactions', '$idProduct','$qty', '$price')
    ";

    mysqli_query($conn, $query);
  }

  return mysqli_affected_rows($conn);
}

// profile page


function editPassword($data)
{
  $conn = conn();
  $userId = $_SESSION['id'];
  $oldPassword = $data["password"];
  $newPassword = mysqli_real_escape_string($conn, $data["new-password"]);
  $confirmPassword = mysqli_real_escape_string($conn, $data['confirm-password']);

  $result =  mysqli_query($conn, "SELECT * FROM users WHERE id = '$userId'");

  $row = mysqli_fetch_assoc($result);
  if (password_verify($oldPassword, $row["password"])) {
    if ($newPassword === $confirmPassword) {
      $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
      $query = "UPDATE users SET password = '$newPassword' WHERE id = '$userId'";
      $result = mysqli_query($conn, $query);
      return mysqli_affected_rows($conn);
    } else {
      return "password doesn't match";
    }
  }


  return 'password wrong';
}

function uploadProfile($imageData)
{
  $nameFile = $imageData['image']['name'];
  $sizeFile = $imageData['image']['size'];
  $error = $imageData['image']['error'];
  $tmpName = $imageData['image']['tmp_name'];


  if ($error === 4) {
    echo "<script>
            alert('Upload photos first');
          </script>";
    return false;
  }


  $validImageExtension = ["jpg", "jpeg", "png"];
  $imageExtension = explode('.', $nameFile);
  $imageExtension = strtolower(end($imageExtension));

  if (!in_array($imageExtension, $validImageExtension)) {
    echo "<script>
            alert('What you uploaded is not an image');
          </script>";
    return false;
  }

  if ($sizeFile > 2000000) {
    echo "<script>
            alert('Image size is too large');
          </script>";
    return false;
  }



  $newFileName = uniqid();
  $newFileName .= "." . $imageExtension;


  move_uploaded_file($tmpName, '../asset/img/profile_img/' . $newFileName);


  $conn = conn();
  $id = $_SESSION['id'];
  $query = "UPDATE users 
            SET image_profile = '$newFileName'
            WHERE id = '$id'";
  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}
