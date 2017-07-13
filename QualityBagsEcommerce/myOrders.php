<?php
require_once('business_layer\users\usersController.php');

if(!isset($_SESSION['username'])){
  header("Location: index.php?content_page=login"); /* Redirect browser to login*/
  exit();
}
?>

<div class="container">
  <?php
  $userID = $_SESSION['userid'];
  echo Users::displayMyOrders($userID);
   ?>
</div>
