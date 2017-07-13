
<?php
if(isset($_SESSION['username'])){
    header('Location: index.php?content_page=Home'); /* Redirect browser */
    exit();
}
require_once('business_layer\users\usersController.php');
require("ErrorFunctions.php");
$error_handler = set_error_handler("userErrorHandler");
?>

<div class="container">

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 if(isset($_POST["userName"]) && isset($_POST["password"])){

    $userName = test_input($_POST["userName"]);
    $password = test_input($_POST["password"]);
    $password = sha256_encrypt($password);

    $sql = 'SELECT user_id, first_name, username, password, status FROM users WHERE username ="'.$userName.'" AND password ="'.$password.'"';
    $result = $db->query($sql);
    $rows = $result->size();
    if($rows == 1){
      while ($row = $result->fetch()) {
        $status = $row['status'];
        switch ($status) {
          case '1':
              echo '<h4 style="padding:10px;"> You are not verified your email yet. Please check your inbox.</h4>';
            break;

          case '2':
              $_SESSION['username'] = $row['first_name'];
              $_SESSION['userid'] = $row['user_id'];
              if(isset($_SERVER["HTTP_REFERER"])){
                header('Location: '.$_SERVER["HTTP_REFERER"]); /* Redirect browser */
                exit();
              }
              else {
                header('Location: index.php?content_page=Home'); /* Redirect browser */
                exit();
              }
            break;

          case '3':
              echo '<h4 style="padding:10px;">Your account has been disabled. Please contact admin</h4>';
            break;

          case '4':
              $_SESSION['username'] = "Admin";
              $_SESSION['userid'] = $row['user_id'];
              if(isset($_SERVER["HTTP_REFERER"])){
                header('Location: '.$_SERVER["HTTP_REFERER"]); /* Redirect browser */
                exit();
              }
              else {
                header('Location: index.php?content_page=Home'); /* Redirect browser */
                exit();
              }
            break;

          default:
              echo '<h4 style="padding:10px;">Login failed unexpectedly. Please try again</h4>';
            break;
        }
      }
    }
    else {
      echo '<h4 style="padding:10px;">Login failed. Please check username and password.</h4>';
    }
  }
  else {
    trigger_error("Login Error", E_USER_ERROR);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<div class="panel panel-success">
<div class="panel-heading"><h2 align="center" style="padding:10px;"> Login </h2></div>
  <div class="panel-body">
    <div class="container">
      <?php
      echo Users::displayLoginForm();
      ?>
      <button type="submit" class="btn btn-success">Login</button>
      <a href="index.php?content_page=register" class="btn btn-default">Register</a>
      </form>
    </div>
  </div>
</div>
</div>
