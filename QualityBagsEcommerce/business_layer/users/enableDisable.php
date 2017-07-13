<?php
require_once('/../../data_layer/data.inc.php');

  if(isset($_GET['id'])){
    global $db;

    $id = $_GET['id'];

    $sql = 'SELECT * FROM users WHERE user_id='.$id;
    $result = $db->query($sql);
    $row = $result->fetch();
    extract($row);
    if($status == '2'){

      $sql = 'UPDATE users SET status = 3 WHERE user_id='.$id;
      $result = $db->query($sql);
      header("Location: ../../index.php?content_page=users"); /* Redirect browser to login*/
      exit();

    }
    elseif ($status == '3') {
      $sql = 'UPDATE users SET status = 2 WHERE user_id='.$id;
      $result = $db->query($sql);
      header("Location: ../../index.php?content_page=users"); /* Redirect browser to login*/
      exit();
    }
    else {
      header("Location: ../../index.php?content_page=users"); /* Redirect browser to login*/
      exit();
    }
  }
  else {
    header("Location: ../../index.php?content_page=users"); /* Redirect browser to login*/
    exit();
  }

?>
