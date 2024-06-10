<?php

require_once __DIR__ . '/vendor/autoload.php';
require 'controller/function.php';
if (isset($_GET['id'])) {
  $idTransac = $_GET['id'];



  $result = query(
    "SELECT 
    detail_transaction.id AS detail_id,
    detail_transaction.id_transaction AS detail_id_transaction,
    detail_transaction.id_product AS detail_id_product,
    detail_transaction.qty AS detail_qty,
    detail_transaction.price AS detail_price,
    products.name AS product_name
    FROM detail_transaction
    JOIN products ON detail_transaction.id_product = products.id 
    WHERE id_transaction = '$idTransac'
    "
  );

  $userId = $_SESSION['id'];

  $user = query("SELECT username FROM users WHERE id = '$userId'")[0];

  $transaction = query("SELECT * FROM transactions WHERE id_transaction = '$idTransac'")[0];
}




$html = '<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>INVOICE</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="asset/style.css">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body style="background-color: #ede0d4;">

  <section>
    <div class="container">
      <div class="row" style="margin-bottom: 100px;">
      <div class="col-6 w-100">
        <div class="text-end">
        <h4 style="font-size: 34px; font-weight: bold;">INVOICE</h4>
          <h6>INVOICE NO. ' . $transaction['id_transaction'] . '</h6>
          <p>' . date("d F Y", strtotime($transaction['transaction_date'])) . '</p>
        </div>
      </div>
        <div class="col-6 d-flex align-items-center">
          <h6 class="m-0">Payment for : <br> <span style="font-weight: normal;">' . $user['username'] . '</span> </h6>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <table class="table">
            <thead>
              <tr style="border-top: 2px solid black; border-bottom: 2px solid black;">
                <th scope="col">Item</th>
                <th scope="col" class="text-center">Quantity</th>
                <th scope="col" class="text-center">Price</th>
              </tr>
            </thead>
            <tbody>';
$totalPrice = 0;
foreach ($result as $item) {
  $html .= '<tr style="border-bottom: 1px solid black;">
                  <td>' . $item['product_name'] . '</td>
                  <td class="text-center">' . $item['detail_qty'] . '</td>
                  <td class="text-center">' . $item['detail_price'] . '</td>';
  $totalPrice += str_replace(".", "", $item['detail_price']);
}
$html .= '<tr>
                <td></td>
                <td></td>
                <td class="text-center" style="border-bottom: 2px solid black;">Total Price : RP.' . number_format($totalPrice, 0, ',', '.') . '</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="row" style="margin-top: 60px;">
        <div class="col-12">
          <h2 style="font-size: 24px; font-weight: 600;">Thank you for your Business!</h2>
        </div>
      </div>
    </div>
  </section>

  <script src="../js/dashboard.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>';


$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output('INVOICE.pdf', \Mpdf\Output\Destination::INLINE);
