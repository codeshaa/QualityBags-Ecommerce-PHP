<?php
// Include MySQL class
require_once('/../../data_layer/data.inc.php');

  function sha256_encrypt($data){
    $ciphered = hash("sha256", $data);
    return $ciphered;
  }

class Users {


  public static function displayRegisterForm() {

    $output[] = '<form action="index.php?content_page=register" method="POST" role="form" class="form-horizontal"><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="lastName" class="control-label">Last Name:</label><input type="text" class="form-control" id="lastName" name="lastName" placeholder="Your last name" required></div></div><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="middleName" class="control-label">Middle Name:</label><input type="text" class="form-control" id="middleName" name="middleName" placeholder="Middle name if you have any" ></div></div><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="firstName" class="control-label">First Name:</label><input type="text" class="form-control" id="firstName" name="firstName" placeholder="Your first name" required></div></div><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="email" class="control-label">Email: (This will be your username)</label><input type="email" class="form-control" id="email" name="email" placeholder="Your email address" required></div></div><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="address" class="control-label">Address:</label><input type="text" class="form-control" id="address" name="address" placeholder="Your address" required></div></div><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="homePhone" class="control-label">Home Phone:</label><input type="tel" class="form-control" id="homePhone" name="homePhone" placeholder="Home phone number" ></div></div><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="mobilePhone" class="control-label">Mobile Phone:</label><input type="tel" class="form-control" id="mobilePhone" name="mobilePhone" placeholder="Mobile phone number" required></div></div><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="password" class="control-label">Password:</label><input type="password" class="form-control" id="password" name="password" placeholder="password" maxlength="8" required></div></div>';

  	echo join('',$output);
  }


  public static function displayLoginForm() {

    $output[] = '<form action="index.php?content_page=login" method="POST" role="form" class="form-horizontal"><div class="row">';

    $output[] = '<div class="form-group col-xs-4"><label for="userName" class="control-label">Username (same as your email):</label><input type="text" class="form-control" id="userName" name="userName" placeholder="username" required></div></div><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="password" class="control-label">Password:</label><input type="password" class="form-control" id="password" name="password" placeholder="password" required></div></div>';

  	echo join('',$output);
  }

  public static function displayMyOrders($userID) {
      global $db;

    	$sql = 'SELECT * FROM orders WHERE user_id='.$userID;
    	$result = $db->query($sql);

      $output[] = '<div class="container"><table class="table table-striped">';
      $output[] = '<thead><tr><th>Order ID</th><th>User Name</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Address</th><th>Mobile Phone</th><th>Order Date</th><th>Total</th><th>GST</th><th>Status</th></tr></thead>';
      $output[] = '<tbody>';

      while ($row = $result->fetch()) {
        $sqlUser = 'SELECT user_id, username FROM users WHERE user_id='.$userID;
      	$resultUser = $db->query($sqlUser);
        $rowUser = $resultUser->fetch();
        extract($rowUser);
        $output[] = '<tr>';
        $output[] = '<td>'.$row['order_id'].'</td>';
        $output[] = '<td>'.$username.'</td>';
        $output[] = '<td>'.$row['order_first_name'].'</td>';
        $output[] = '<td>'.$row['order_middle_name'].'</td>';
        $output[] = '<td>'.$row['order_last_name'].'</td>';
        $output[] = '<td>'.$row['order_address'].'</td>';
        $output[] = '<td>'.$row['order_mobile_phone'].'</td>';
        $output[] = '<td>'.$row['order_date'].'</td>';
        $output[] = '<td>'.$row['total'].'</td>';
        $output[] = '<td>'.$row['gst'].'</td>';
        $output[] = '<td>'.$row['order_status'].'</td>';
        $output[] = '</tr>';

    }
    $output[] = '<tbody></table></div>';
    echo join('',$output);
  }


  public static function displayUsers() {
      global $db;

      $sql = 'SELECT * FROM users WHERE status = 2 OR status = 3';
      $result = $db->query($sql);

      $output[] = '<div class="container"><table class="table table-striped">';
      $output[] = '<thead><tr><th>User ID</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Email</th><th>Address</th><th>Mobile Phone</th><th>Home Phone</th><th>Username</th><th>Status</th></tr></thead>';
      $output[] = '<tbody>';

      while ($row = $result->fetch()) {
        $stat = $row['status'];
        $status = '';
        switch ($stat) {
          case '1':
            $status = 'Pending Verification';
            break;
          case '2':
            $status = 'Enabled';
            break;
          case '3':
            $status = 'Disabled';
            break;
          case '4':
            $status = 'Admin';
            break;

          default:
            $status = 'Invalid';
            break;
        }
        $output[] = '<tr>';
        $output[] = '<td>'.$row['user_id'].'</td>';
        $output[] = '<td>'.$row['first_name'].'</td>';
        $output[] = '<td>'.$row['middle_name'].'</td>';
        $output[] = '<td>'.$row['last_name'].'</td>';
        $output[] = '<td>'.$row['email'].'</td>';
        $output[] = '<td>'.$row['address'].'</td>';
        $output[] = '<td>'.$row['mobile_phone'].'</td>';
        $output[] = '<td>'.$row['home_phone'].'</td>';
        $output[] = '<td>'.$row['username'].'</td>';
        $output[] = '<td>'.$status.'</td>';
        if($stat == 3){
          $output[] = '<td><a href="business_layer/users/enableDisable.php?id='.$row['user_id'].'" class="btn btn-success">Enable</a></td>';
        }
        elseif($stat == 2) {
          $output[] = '<td><a href="business_layer/users/enableDisable.php?id='.$row['user_id'].'" class="btn btn-danger">Disable</a></td>';
        }
        $output[] = '</tr>';

    }
    $output[] = '<tbody></table></div>';
    echo join('',$output);
  }
}
?>
