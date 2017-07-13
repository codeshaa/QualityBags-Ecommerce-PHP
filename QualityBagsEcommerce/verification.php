<?php
require_once('/data_layer/data.inc.php');
global $db;

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){

    // Verify data
    $email = mysql_escape_string($_GET['email']); // Set email variable
    $hash = mysql_escape_string($_GET['hash']); // Set hash variable

    $sql = 'SELECT email, hash FROM users WHERE email="'.$email.'" AND hash="'.$hash.'"';
    $result = $db->query($sql);
    $rows = $result->size();

    if($rows == 1){
        // hash matched. activating account
        $sql = 'UPDATE users SET status = 2 WHERE email="'.$email.'" AND hash="'.$hash.'"';
        $result = $db->query($sql);
        if($result){
          echo '<h3>Email verification successful. Please <a href="index.php?content_page=login">login</a></h3>';
        }
        else {
          echo '<h3> Oops! Verification failed. DB Update error. Please retry.</h3>';
        }
    }else{
        // no match or invalid hash
        echo '<h3> Verification failed. Please retry.</h3>';
    }

}
else{
    // Invalid params
    echo '<h3>Verification failed. Please follow the link provided in your email.</h3>';
}
?>
