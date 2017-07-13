<?php
// Include MySQL class
require_once('/../data_layer/data.inc.php');

class Supplier {

  public static function displaySuppliers() {
  	global $db;

  	$sql = 'SELECT supplier_id, supplier_name FROM suppliers ORDER BY supplier_id';
  	$result = $db->query($sql);

    $output[] = '<div class="container"><table class="table table-striped">';
    $output[] = '<thead><tr><th>Name</th></tr></thead>';
    $output[] = '<tbody>';

  	while ($row = $result->fetch()) {
      $output[] = '<tr>';
  		$output[] = '<td>'.$row['supplier_name'].'</td>';

      if (isset($_SESSION['username'])){
        if($_SESSION['username'] == 'Admin'){
          $output[] = '<td><a class="btn btn-info" href="index.php?content_page=supplierDetails&id='.$row['supplier_id'].'">Details</a></td>';
        }
      }
      
      $output[] = '</tr>';
  	}
  	$output[] = '</tbody></table></div>';
  	echo join('',$output);
  }

  public static function displayCreateSupplierForm() {

    $output[] = '<div class="container"><form action="index.php?content_page=suppliers" method="POST" role="form" class="form-horizontal"><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="supplierName" class="control-label">Supplier Name:</label><input type="text" class="form-control" id="supplierName" name="supplierName" placeholder="new supplier name" required></div></div><div class="row">';
    $output[] = '<div class="form-group  col-xs-4"><label for="email" class="control-label">Email:</label><input type="email" class="form-control" id="email" name="email" placeholder="supplier email" required></div></div><div class="row">';
    $output[] = '<div class="form-group  col-xs-4"><label for="address" class="control-label">Address:</label><input type="text" class="form-control" id="address" name="address" placeholder="supplier address" required></div></div><div class="row">';
    $output[] = '<div class="form-group  col-xs-4"><label for="mobilePhone" class="control-label">Mobile Phone:</label><input type="tel" class="form-control" id="mobilePhone" name="mobilePhone" placeholder="supplier mobile number"></div></div><div class="row">';
    $output[] = '<div class="form-group  col-xs-4"><label for="workPhone" class="control-label">Office Phone:</label><input type="tel" class="form-control" id="workPhone" name="workPhone" placeholder="supplier office phone number"></div></div><div class="row">';
    $output[] = '<div class="form-group  col-xs-4"><label for="homePhone" class="control-label">Home Phone:</label><input type="tel" class="form-control" id="homePhone" name="homePhone" placeholder="supplier home phone number"></div></div>';

  	echo join('',$output);
  }


}
?>
