<?php
require_once('business_layer/shopping.inc.php');
require_once('business_layer/orderManager.inc.php');
require("ErrorFunctions.php");
$error_handler = set_error_handler("userErrorHandler");

if(!isset($_SESSION['username'])){
  header("Location: index.php?content_page=login"); /* Redirect browser */
  exit();
}
if(empty($_SESSION['cart'])){
  header("Location: index.php?content_page=bags"); /* Redirect browser */
  exit();
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 if(isset($_POST["address"]) && isset($_POST["firstName"])){
   global $db;

    $lastName = test_input($_POST["lastName"]);
    $middleName = test_input($_POST["middleName"]);
    $firstName = test_input($_POST["firstName"]);
    $address = test_input($_POST["address"]);
    $mobilePhone = test_input($_POST["mobilePhone"]);
    $homePhone = test_input($_POST["homePhone"]);
    $status = 'Pending';
    $date = date("Y-m-d");
    $user_id = $_SESSION['userid'];
    $cart = $_SESSION['cart'];

    if ($cart) {
  		$items = explode(',',$cart);
  		$contents = array();
  		$total = 0;
  		foreach ($items as $item) {
  			$contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
  		}
  		foreach ($contents as $id=>$qty) {
  			$sql = 'SELECT * FROM bags WHERE bag_id = '.$id;
  			$result = $db->query($sql);
  			$row = $result->fetch();
  			extract($row);
  			$subtotal = $bag_price * $qty;
        $subtotal = number_format($subtotal, 2);
  			$total += $bag_price * $qty;
  		}
      $total = number_format($total, 2);
      $gst = ($total/100) * 15;
      $gst = number_format($gst, 2);

      $sql = "INSERT INTO orders (order_last_name, order_middle_name, order_first_name, order_address, order_home_phone, order_mobile_phone, order_status, order_date, total, gst, user_id) VALUES ('$lastName', '$middleName', '$firstName', '$address', $homePhone, $mobilePhone, '$status', $date, $total, $gst, $user_id)";
      $result = $db->query($sql);
      if($result){
        $orderID = $result -> insertID();
        $purchased = 0;
        foreach ($contents as $id=>$qty) {
    			$sql = 'SELECT * FROM bags WHERE bag_id = '.$id;
    			$result = $db->query($sql);
    			$row = $result->fetch();
    			extract($row);
    			$subtotal = $bag_price * $qty;
          $subtotal = number_format($subtotal, 2);

          $sql = "INSERT INTO order_items (bag_id, quantity, subtotal, order_id) VALUES ('$id', '$qty', '$subtotal', '$orderID')";
          $result = $db->query($sql);
          if($result){
            $purchased = 1;
          }
    		}
        if ($purchased) {
          unset($_SESSION['cart']);
          $cart = NULL;
          echo '<h2>Thank you. Your order has been placed with below details</h2></br></br>';
          echo '<div class="panel panel-success"><div class="panel-heading"><h2 align="center" style="padding:10px;"> Order Details </h2></div>';
          echo '<div class="panel-body"><div class="container">';
          echo Order::displayPurchaseOrder($orderID);
          echo '</div></div></div>';
        }

      }
      else {
        echo '<h4>Oops! Unable to update Orders. Please retry</h4>';
      }

  	}
    else {
  		echo '<h4>Your shopping cart is empty.</h4>';
  	}
  }
  else {
    trigger_error("Purchase Error: Address and First name not provided", E_USER_ERROR);
  }
}
else {

  $output[] = '<div class="panel panel-success"><div class="panel-heading"><h2 align="center" style="padding:10px;"> Purchase Form </h2></div>';
  $output[] = '<div class="panel-body"><div class="container">';
  echo Shopping::showCart();

  $output[] = '</br></br>';
  $output[] = '<form action="index.php?content_page=purchased" method="POST" role="form" class="form-horizontal"><div class="row">';
  $output[] = '<div class="form-group col-xs-4"><label for="lastName" class="control-label">Last Name:</label><input type="text" class="form-control" id="lastName" name="lastName" placeholder="Your last name" required></div></div><div class="row">';
  $output[] = '<div class="form-group col-xs-4"><label for="middleName" class="control-label">Middle Name:</label><input type="text" class="form-control" id="middleName" name="middleName" placeholder="Middle name if you have any" ></div></div><div class="row">';
  $output[] = '<div class="form-group col-xs-4"><label for="firstName" class="control-label">First Name:</label><input type="text" class="form-control" id="firstName" name="firstName" placeholder="Your first name" required></div></div><div class="row">';
  $output[] = '<div class="form-group col-xs-4"><label for="address" class="control-label">Order Address:</label><input type="text" class="form-control" id="address" name="address" placeholder="Your address" required></div></div><div class="row">';
  $output[] = '<div class="form-group col-xs-4"><label for="homePhone" class="control-label">Home Phone:</label><input type="tel" class="form-control" id="homePhone" name="homePhone" placeholder="Home phone number" ></div></div><div class="row">';
  $output[] = '<div class="form-group col-xs-4"><label for="mobilePhone" class="control-label">Mobile Phone:</label><input type="tel" class="form-control" id="mobilePhone" name="mobilePhone" placeholder="Mobile phone number" required></div></div><div class="row">';
  $output[] = '<button type="submit" class="btn btn-success">Purchase Now</button>';
  $output[] = '</form></div></div></div>';

  echo join('',$output);

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
