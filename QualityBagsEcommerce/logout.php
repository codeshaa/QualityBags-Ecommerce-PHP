<?php

if (isset($_SESSION['username'])){
  unset($_SESSION['username']); // Destroying username session variable
  unset($_SESSION['userid']);  // Destroying userid session varioble
}
header("Location: index.php?content_page=Home"); // Redirecting To Home Page
exit();
?>
