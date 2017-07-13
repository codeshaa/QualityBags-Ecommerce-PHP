<?php
// Include MySQL class
require_once('/../data_layer/data.inc.php');

class Bag {

  public static function displayBags() {
  	global $db;

  	$sql = 'SELECT * FROM bags ORDER BY bag_id';
  	$result = $db->query($sql);
    //Count the record number
	  $counter = $result->size();

    $PageSize = 5;
    $PageCount = $counter/$PageSize + 1;

    // Display page number
    $output[] = '<div class="container-fluid"><ul class="pagination pagination-lg">';
    for ( $i=1; $i <= $PageCount; $i++)
    	{
    	   $output[] = '<li><a href="index.php?content_page=bags&pg='.$i.'">'.$i.'</a></li>';
    	}
    $output[] = '</ul></div></br>';


    $output[] = '<div class="container"><div class="table-responsive"><table class="table">';
    $output[] = '<thead><tr><th>Image</th><th>Name</th><th>Description</th><th>Price</th></tr></thead>';
    $output[] = '<tbody>';

       // Test if this is the first page
    	if (isset($_GET['pg']))
    	{
    	  // set the parameters for the rest pages
    	  $start= ($_GET['pg'] - 1) * $PageSize + 1;
    	  $end = $_GET['pg'] * $PageSize;
    	  if( $end > $counter )
    		   $end = $counter;
    	}
      else
    	{
    	  //set the parameters for the first page
    	  $start = 1;
    	  $end = $PageSize;
    	  if( $end > $counter )
    		$end = $counter;
    	} //end if IsSet("$_GET['pg']")

    	$j = $start - 1;
      // /* seek to row no. $j */
      $result -> seek($j);


      //Display the page
  	for( $i = $start; $i <= $end; $i++)
  	{
 	    $row = $result -> fetch();
      $output[] = '<tr>';
  		$output[] = '<td><img class="img-responsive" height="200" width="150" src='.$row['bag_image_link'].'></td><td>'.$row['bag_name'].'</td><td>'.$row['bag_description'].'</td><td>NZ$ '.$row['bag_price'].'</td>';
      $output[] = '<td><a href="index.php?content_page=bagdetails&id='.$row['bag_id'].'" class="btn btn-success">Details</a></td>';
      if (isset($_SESSION['username'])){
        if($_SESSION['username'] != 'Admin'){
          $output[] = '<td><a href="index.php?content_page=cart&action=add&id='.$row['bag_id'].'" class="btn btn-info">Add to Cart</a></td>';
        }
      }
      else {
        $output[] = '<td><a href="index.php?content_page=cart&action=add&id='.$row['bag_id'].'" class="btn btn-info">Add to Cart</a></td>';
      }
      $output[] = '</tr>';

    }
  	$output[] = '</tbody></table></div></div>';
  	echo join('',$output);
  }


  public static function displayCreateBagForm() {
    global $db;

    $output[] = '<form action="index.php?content_page=bags" method="POST" enctype="multipart/form-data" role="form" class="form-horizontal"><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="bagName" class="control-label">Bag Name:</label><input type="text" class="form-control" id="bagName" name="bagName" placeholder="new bag name" required></div></div><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="description" class="control-label">Description:</label><input type="text" class="form-control" id="description" name="description" placeholder="bag description" required></div></div><div class="row">';
    $output[] = '<div class="form-group col-xs-4"><label for="price" class="control-label">Price NZ$:</label><input type="number" min="1" step="0.01" class="form-control" id="price" name="price" placeholder="Price in NZ$" required></div></div><div class="row">';

    // creating category selection list
    $output[] = '<div class="form-group col-xs-4"><label for="category" class="control-label">Select Category: &nbsp;</label><select id="category" name="category">';
    $sqlCategory = 'SELECT category_id, category_name FROM categories ORDER BY category_id';
  	$resultCategory = $db->query($sqlCategory);
    while ($row = $resultCategory->fetch()) {
      $output[] ='<option value="'.$row['category_id'].'">'.$row['category_name'].'</option>';
  	}
    $output[] = '</select></div></div><div class="row">';

    // creating supplier selection list
    $output[] = '<div class="form-group col-xs-4"><label for="supplier" class="control-label">Select Supplier: &nbsp;</label><select id="supplier" name="supplier">';
    $sqlSupplier = 'SELECT supplier_id, supplier_name FROM suppliers ORDER BY supplier_id';
  	$resultSupplier = $db->query($sqlSupplier);
    while ($row = $resultSupplier->fetch()) {
      $output[] ='<option value="'.$row['supplier_id'].'">'.$row['supplier_name'].'</option>';
  	}
    $output[] = '</select></div></div><div class="row">';

    // image file upload
    $output[] = '<div class="form-group col-xs-4"><label for="imageFile" class="control-label">Upload a Bag Image:</label><input type="file" accept=".png, .jpg, .jpeg, .gif" class="form-control" id="imageFile" name="imageFile" ></div></div>';

  	echo join('',$output);
  }


}
?>
