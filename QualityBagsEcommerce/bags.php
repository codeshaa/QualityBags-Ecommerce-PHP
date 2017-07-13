
<?php
require_once('business_layer\bagsController.php');
?>

<div class="container">

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = test_input($_POST["bagName"]);
  $description = test_input($_POST["description"]);
  $price = test_input($_POST["price"]);
  $category = $_POST["category"];
  $supplier = $_POST["supplier"];
  $target_image_dir = "images/products/";

  if (!empty($_FILES["imageFile"]["name"])){
    $target_image_file = $target_image_dir . basename($_FILES["imageFile"]["name"]);
  }
  else {
    $target_image_file = "images/products/default.jpg";
  }

  $data_exist = 0;

  $sql = 'SELECT * FROM bags ORDER BY bag_id';
  $result = $db->query($sql);
  while ($row = $result->fetch()) {
    if ($name == $row['bag_name']){
      $data_exist = 1;
    }
  }
    if ($data_exist){
      echo '<h4><This bag already exists. Please try again.</h4>';
    }
    else{
      $uploadStatus = 1;
      imageUpload();
        if ($uploadStatus == 1){
          $sql = "INSERT INTO bags (bag_name, bag_description, bag_price, bag_image_link, category_id, supplier_id) VALUES ('$name', '$description', '$price', '$target_image_file', '$category', '$supplier')";
          $result = $db->query($sql);
          if($result){
            echo '<h4>A new bag item has been added.</h4>';
          }
          else {
            echo '<h4>Database: Failed to create new bag item</h4>';
          }
        }
    }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!-- Trigger the modal with a button -->
<?php
if (isset($_SESSION['username'])){
  if($_SESSION['username'] == 'Admin'){
  echo '<div style="padding:10px">';
  echo '<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#bagModal">Create a Bag</button>';
  echo '</div>';
  }
}
?>

<!-- Modal -->
 <div class="modal fade" id="bagModal" role="dialog">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Create new bag</h4>
       </div>
       <div class="modal-body">
         <div class="container">
           <?php echo Bag::displayCreateBagForm(); ?>
       </div>
       </div>
       <div class="modal-footer">
         <button type="submit" class="btn btn-success">Create</button>
         <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
         </form>
       </div>
     </div>
   </div>
 </div>
</div>

<?php
echo Bag::displayBags();
?>

<?php

function imageUpload() {

  if (!empty($_FILES["imageFile"]["name"])){
    global $uploadStatus, $target_image_dir, $target_image_file;

    $imageFileType = pathinfo($target_image_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or not
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["imageFile"]["tmp_name"]);
        if($check !== false) {
            $uploadStatus = 1;
        } else {
            echo "<h4>Please upload an image file.</h4>";
            $uploadStatus = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_image_file)) {
        echo "<h4>Oops! This file already exists.</h4>";
        $uploadStatus = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "<h4>Only JPG, JPEG, PNG & GIF files are allowed</h4>";
        $uploadStatus = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadStatus == 0) {
        echo "<h4>Your file was not uploaded. Try again</h4>";
    // if no errors, try uploading file
    } else {
        if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $target_image_file)) {
            echo "<h4>The Image ". basename( $_FILES["imageFile"]["name"]). " has been uploaded.</h4>";
        } else {
            echo "<h4>Sorry, there was an error uploading your file. Please retry</h4>";
        }
    }
  }

}

?>
