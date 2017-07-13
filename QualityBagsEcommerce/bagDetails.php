<?php

if (isset($_GET['id'])){

  $bagID = $_GET['id'];

  $sql = 'SELECT * FROM bags WHERE bag_id='.$bagID;
  $result = $db->query($sql);
  $row = $result->fetch();
  extract($row);
  $sqlCategory = 'SELECT category_name FROM categories WHERE category_id='.$category_id;
  $resultCategory = $db->query($sqlCategory);
  $rowCategory = $resultCategory->fetch();
  extract($rowCategory);
  $sqlSupplier = 'SELECT supplier_name FROM suppliers WHERE supplier_id='.$supplier_id;
  $resultSupplier = $db->query($sqlSupplier);
  $rowSupplier = $resultSupplier->fetch();
  extract($rowSupplier);
  echo '<div class="container-fluid">';
  echo '<h2 align="center">Bag Details</h2></br>';
  echo '<div class="row"><div class="col-sm-3"></div><div class="col-sm-6"><img class="img-responsive" height="auto" width="400" src='.$bag_image_link.'></div></div></br>';
  echo '<div class="row"><div class="col-sm-3">Bag Name:</div><div class="col-sm-6">'.$bag_name.'</div></div>';
  echo '<div class="row"><div class="col-sm-3">Bag Description:</div><div class="col-sm-6">'.$bag_description.'</div></div>';
  echo '<div class="row"><div class="col-sm-3">Bag Price:</div><div class="col-sm-6">NZ$: '.$bag_price.'</div></div>';
  echo '<div class="row"><div class="col-sm-3">Category:</div><div class="col-sm-6">'.$category_name.'</div></div>';
  echo '<div class="row"><div class="col-sm-3">Supplier:</div><div class="col-sm-6">'.$supplier_name.'</div></div>';
  echo '</br>';
  echo '<div class="row"><div class="col-sm-3"><a href="index.php?content_page=Bags"><h4><span class="glyphicon glyphicon-fast-backward"></span> Back to list</h4></a></div>' ;
  if (isset($_SESSION['username'])){
    if($_SESSION['username'] != 'Admin'){
      echo '<div class="col-sm-6"></div>';
      echo '<div class="col-sm-3">';
      echo '<a href="index.php?content_page=cart&action=add&id='.$bag_id.'" class="btn btn-info">Add to Cart</a>';
      echo '</div>';
    }
  }
  else {
    echo '<div class="col-sm-6"></div>';
    echo '<div class="col-sm-3">';
    echo '<a href="index.php?content_page=cart&action=add&id='.$bag_id.'" class="btn btn-info">Add to Cart</a>';
    echo '</div>';
  }
  echo '</div></br></div>';

}
else {
  header("Location: index.php?content_page=bags"); // Redirecting To bag page
  exit();
}

?>
