<?php
require_once('business_layer\users\usersController.php');

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
  echo Users::displayUsers();
   ?>
</div>
