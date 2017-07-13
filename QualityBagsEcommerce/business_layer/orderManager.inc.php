<?php
// Include MySQL class
require_once('/../data_layer/data.inc.php');

class Order {

  public static function displayPurchaseOrder($orderID) {
  	global $db;

  	$sql = 'SELECT * FROM orders WHERE order_id='.$orderID;
  	$result = $db->query($sql);
    $row = $result->fetch();
    extract($row);
      $output[] = '<div class="row"><div class="col-md-4">First Name: </div><div class="col-md-4"><strong>'.$order_first_name.'</strong></div></div>';
      $output[] = '<div class="row"><div class="col-md-4">Last Name: </div><div class="col-md-4"><strong>'.$order_last_name.'</strong></div></div>';
      $output[] = '<div class="row"><div class="col-md-4">Address: </div><div class="col-md-4"><strong>'.$order_address.'</strong></div></div>';
      $output[] = '<div class="row"><div class="col-md-4">Mobile Phone: </div><div class="col-md-4"><strong>'.$order_mobile_phone.'</strong></div></div>';
      $output[] = '<div class="row"><div class="col-md-4">Home Phone: </div><div class="col-md-4"><strong>'.$order_home_phone.'</strong></div></div>';
      $output[] = '<div class="row"><div class="col-md-4">Total: </div><div class="col-md-4"><strong>'.$total.'</strong></div></div>';
      $output[] = '<div class="row"><div class="col-md-4">GST: </div><div class="col-md-4"><strong>'.$gst.'</strong></div></div>';
      $output[] = '<div class="row"><div class="col-md-4">Order Status: </div><div class="col-md-4"><strong>'.$order_status.'</strong></div></div></br></br>';

      $output[] = '<div class="container"><table class="table">';
      $output[] = '<thead><tr><th>Image</th><th>Bag Name</th><th>Description</th><th>Quantity</th><th>Subtotal</th></tr></thead>';
      $output[] = '<tbody>';

      $sql = 'SELECT * FROM order_items WHERE order_id='.$orderID;
    	$result = $db->query($sql);
      while ($row = $result->fetch()) {
        $sqlBag = 'SELECT * FROM bags WHERE bag_id='.$row['bag_id'];
      	$resultBag = $db->query($sqlBag);
        $rowBag = $resultBag->fetch();
        extract($rowBag);
        $output[] = '<tr>';
        $output[] = '<td><img class="img-responsive" height="200" width="150" src='.$bag_image_link.'></td>';
        $output[] = '<td>'.$bag_name.'</td>';
        $output[] = '<td>'.$bag_description.'</td>';
        $output[] = '<td>'.$row['quantity'].'</td>';
        $output[] = '<td>'.$row['subtotal'].'</td>';
        $output[] = '</tr>';

      }

    $output[] = '<tbody></table></div>';
  	echo join('',$output);
  }


  public static function displayOrders() {
    global $db;

  	$sql = 'SELECT * FROM orders ORDER BY order_id';
  	$result = $db->query($sql);

    $output[] = '<div class="container"><table class="table table-striped">';
    $output[] = '<thead><tr><th>Order ID</th><th>User Name</th><th>First Name</th><th>Last Name</th><th>Address</th><th>Mobile Phone</th><th>Order Date</th><th>Total</th><th>GST</th><th>Status</th></tr></thead>';
    $output[] = '<tbody>';

  	while ($row = $result->fetch()) {
      $sqlUser = 'SELECT user_id, username FROM users WHERE user_id='.$row['user_id'];
    	$resultUser = $db->query($sqlUser);
      $rowUser = $resultUser->fetch();
      extract($rowUser);
      $output[] = '<tr>';
      $output[] = '<td>'.$row['order_id'].'</td>';
      $output[] = '<td>'.$username.'</td>';
      $output[] = '<td>'.$row['order_first_name'].'</td>';
      $output[] = '<td>'.$row['order_last_name'].'</td>';
      $output[] = '<td>'.$row['order_address'].'</td>';
      $output[] = '<td>'.$row['order_mobile_phone'].'</td>';
      $output[] = '<td>'.$row['order_date'].'</td>';
      $output[] = '<td>'.$row['total'].'</td>';
      $output[] = '<td>'.$row['gst'].'</td>';
      $output[] = '<td>'.$row['order_status'].'</td>';
      $output[] = '<td><button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#orderModal'.$row['order_id'].'">Update Status</button></td>';
      $output[] = '</tr>';

      $output[] = '<div class="modal fade" id="orderModal'.$row['order_id'].'" role="dialog">';
      $output[] = '<div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header">';
      $output[] = '<button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Update Status</h4></div>';
      $output[] = '<div class="modal-body"><div class="container">';

      $output[] = '<form action="index.php?content_page=orders" method="POST" role="form" class="form-horizontal">';
      $output[] = '<input type="hidden" name="orderID" value='.$row['order_id'].'>';
      $output[] = '<div class="row"><div class="form-group col-xs-4"><label for="userName" class="control-label">Username:</label></div><div class="form-group col-xs-4"><p class="form-control-static">'.$username.'</p></div></div>';
      $output[] = '<div class="row"><div class="form-group col-xs-4"><label for="firstName" class="control-label">First Name:</label></div><div class="form-group col-xs-8"><p class="form-control-static">'.$row['order_first_name'].'</p></div></div>';
      $output[] = '<div class="row"><div class="form-group col-xs-4"><label for="lastName" class="control-label">Last Name:</label></div><div class="form-group col-xs-8"><p class="form-control-static">'.$row['order_last_name'].'</p></div></div>';
      $output[] = '<div class="row"><div class="form-group col-xs-4"><label for="address" class="control-label">Address:</label></div><div class="form-group col-xs-8"><p class="form-control-static">'.$row['order_address'].'</p></div></div>';
      $output[] = '<div class="row"><div class="form-group col-xs-4"><label for="mobilePhone" class="control-label">Mobile Phone:</label></div><div class="form-group col-xs-8"><p class="form-control-static">'.$row['order_mobile_phone'].'</p></div></div>';
      $output[] = '<div class="row"><div class="form-group col-xs-4"><label for="date" class="control-label">Order Date:</label></div><div class="form-group col-xs-8"><p class="form-control-static">'.$row['order_date'].'</p></div></div>';
      $output[] = '<div class="row"><div class="form-group col-xs-4"><label for="total" class="control-label">Total:</label></div><div class="form-group col-xs-8"><p class="form-control-static">'.$row['total'].'</p></div></div>';
      $output[] = '<div class="row"><div class="form-group col-xs-4"><label for="gst" class="control-label">GST:</label></div><div class="form-group col-xs-8"><p class="form-control-static">'.$row['gst'].'</p></div></div>';
      $output[] = '<div class="row"><div class="form-group col-xs-4"><label for="status" class="control-label">Status:</label></div><div class="form-group col-xs-8"><select name="status" id="status"><option value="Pending">Pending</option><option value="Shipped">Shipped</option></select></div></div>';

      $output[] = '</div></div>';
      $output[] = '<div class="modal-footer"><button type="submit" class="btn btn-success">Update</button>';
      $output[] = '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
      $output[] = '</form>';
      $output[] = '</div></div></div></div>';

  	}
  	$output[] = '<tbody></table></div>';
  	echo join('',$output);

  }
}
