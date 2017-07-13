<?php
require_once('business_layer\orderManager.inc.php');

if (isset($_SESSION['username'])){
  if($_SESSION['username'] != 'Admin'){
    header("Location: index.php?content_page=Home"); /* Redirect browser */
    exit();
  }
}
else {
  header("Location: index.php?content_page=Home"); /* Redirect browser */
  exit();
}
?>

<div class="container">
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

 if(isset($_POST["orderID"])){
    $orderID = test_input($_POST["orderID"]);
    $status = test_input($_POST["status"]);

    $sql = 'UPDATE orders SET order_status = "'.$status.'" WHERE order_id='.$orderID ;
    $result = $db->query($sql);
    if($result){
      echo '<h4>Order Status has been updated for Order ID: '.$orderID.'</h4></br>';
    }
    else {
      echo '<h4>Oops! Database failure. Unable to update order status for Order ID: '.$orderID.'</h4></br>';
    }
   }
   else {
     echo '<h4>Invalid order update. Please try again.</h4></br>';
   }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>



  <?php
  echo Order::displayOrders();
   ?>

</div>
