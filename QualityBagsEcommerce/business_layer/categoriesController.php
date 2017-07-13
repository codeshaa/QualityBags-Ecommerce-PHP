<?php
// Include MySQL class
require_once('/../data_layer/data.inc.php');

class Category {

  public static function displayCategories() {
  	global $db;

  	$sql = 'SELECT * FROM categories ORDER BY category_id';
  	$result = $db->query($sql);

    $output[] = '<div class="container"><table class="table table-striped">';
    $output[] = '<thead><tr><th>Category</th><th>Description</th></tr></thead>';
    $output[] = '<tbody>';

  	while ($row = $result->fetch()) {
      $output[] = '<tr>';
  		$output[] = '<td>'.$row['category_name'].'</td><td>'.$row['description'].'</td>';
      $output[] = '<td><a href="index.php?content_page=categoryDetails&id='.$row['category_id'].'" class="btn btn-warning">Details</a></td>';
      $output[] = '</tr>';
  	}
  	$output[] = '<tbody></table></div>';
  	echo join('',$output);
  }


  public static function displayCreateCategoryForm() {

    $output[] = '<form action="index.php?content_page=categories" method="POST" role="form" class="form-horizontal"><div class="row">';
    $output[] = '<div class="form-group col-sm-4"><label for="categoryName" class="control-label">Category Name:</label><input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="new category name" required></div></div><div class="row">';
    $output[] = '<div class="form-group col-sm-4"><label for="description" class="control-label">Description:</label><input type="text" class="form-control" id="description" name="description" placeholder="category description" required></div></div>';
    // $output[] = '</form>';

  	echo join('',$output);
  }


}
?>
