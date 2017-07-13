<?php

if (isset($_GET['id'])){

  $supplierID = $_GET['id'];

  $sql = 'SELECT * FROM suppliers WHERE supplier_id='.$supplierID;
  $result = $db->query($sql);
  $row = $result->fetch();
  extract($row);
  echo '<div class="container-fluid">';
  echo '<h2 align="center">Supplier Details</h2></br>';
  echo '<div class="row"><div class="col-sm-3">Supplier Name:</div><div class="col-sm-6">'.$supplier_name.'</div></div>';
  echo '<div class="row"><div class="col-sm-3">Supplier Email:</div><div class="col-sm-6">'.$supplier_email.'</div></div>';
  echo '<div class="row"><div class="col-sm-3">Supplier Address:</div><div class="col-sm-6">'.$supplier_address.'</div></div>';
  echo '<div class="row"><div class="col-sm-3">Supplier Mobile Phone:</div><div class="col-sm-6">'.$supplier_phone_mobile.'</div></div>';
  echo '<div class="row"><div class="col-sm-3">Supplier Work Phone:</div><div class="col-sm-6">'.$supplier_phone_work.'</div></div>';
  echo '<div class="row"><div class="col-sm-3">Supplier Home Phone:</div><div class="col-sm-6">'.$supplier_phone_home.'</div></div>';
  echo '</br>';
  echo '<div class="row"><div class="col-sm-3"><a href="index.php?content_page=suppliers"><h4><span class="	glyphicon glyphicon-fast-backward"></span> Back to list</h4></a></div></div></br>' ;
  echo '</div>';

}
else {
  header("Location: index.php?content_page=suppliers"); // Redirecting To bag page
  exit();
}

?>
